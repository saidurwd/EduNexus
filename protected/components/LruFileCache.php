<?php
/**
 * LruFileCache implements a file-based cache with LRU eviction, TTL, atomic writes, and locking.
 *
 * @author Saidur Rahman
 */
class LruFileCache extends CCache
{
	/**
	 * @var string the directory where cache files are stored. Defaults to null, meaning
	 * using 'protected/runtime/cache/lru/' relative to the application base path.
	 * If you want to use a different directory, set this property accordingly.
	 */
	public $cacheDir;
	/**
	 * @var integer maximum number of files allowed in the cache directory.
	 * Defaults to 1000, meaning no more than 1000 cache files will be kept.
	 * When the number exceeds this, the oldest files (based on file mtime) will be removed.
	 */
	public $maxFiles = 1000;
	/**
	 * @var integer maximum total size (in bytes) of all cache files.
	 * Defaults to 10MB (10 * 1024 * 1024). When the total size exceeds this,
	 * the oldest files will be removed until the total size is under the limit.
	 */
	public $maxSize = 10485760; // 10MB

	/**
	 * Initializes the component.
	 * This method sets the cache directory if not set and ensures it exists.
	 */
	public function init()
	{
		parent::init();
		if ($this->cacheDir === null) {
			$this->cacheDir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'lru';
		}
		// Ensure the directory exists
		if (!is_dir($this->cacheDir)) {
			mkdir($this->cacheDir, 0775, true);
		}
	}

	/**
	 * Generates the cache file path for a given key.
	 * @param string $key the cache key (already unique and possibly hashed by parent)
	 * @return string the cache file path
	 */
	protected function getCacheFile($key)
	{
		return $this->cacheDir . DIRECTORY_SEPARATOR . $key . '.cache';
	}

	/**
	 * Generates the lock file path for a given key.
	 * @param string $key the cache key
	 * @return string the lock file path
	 */
	protected function getLockFile($key)
	{
		return $this->cacheDir . DIRECTORY_SEPARATOR . $key . '.lock';
	}

	/**
	 * Acquires a lock on the given lock file.
	 * @param string $lockFile the lock file path
	 * @return resource the file pointer locked, or false on failure
	 */
	protected function acquireLock($lockFile)
	{
		$fp = fopen($lockFile, 'c');
		if ($fp === false) {
			return false;
		}
		if (flock($fp, LOCK_EX) === false) {
			fclose($fp);
			return false;
		}
		return $fp;
	}

	/**
	 * Releases the lock on the given file pointer.
	 * @param resource $fp the file pointer returned by acquireLock
	 */
	protected function releaseLock($fp)
	{
		if ($fp !== false) {
			flock($fp, LOCK_UN);
			fclose($fp);
		}
	}

	/**
	 * Removes the lock file.
	 * @param string $lockFile the lock file path
	 */
	protected function removeLockFile($lockFile)
	{
		@unlink($lockFile);
	}

	/**
	 * Checks if a cache entry has expired.
	 * @param integer $expireTimestamp the expiration timestamp (0 means never expire)
	 * @param integer $fileMtime the file's modification time (when the cache was written)
	 * @return boolean true if expired, false otherwise
	 */
	protected function isExpired($expireTimestamp, $fileMtime)
	{
		if ($expireTimestamp === 0) {
			return false; // never expire
		}
		return time() >= $expireTimestamp;
	}

	/**
	 * Updates the LRU timestamp of a file by touching it.
	 * @param string $filePath the cache file path
	 * @return boolean true on success, false on failure
	 */
	protected function updateLRU($filePath)
	{
		return touch($filePath);
	}

	/**
	 * Enforces the cache limits (maxFiles and maxSize) by removing the oldest files.
	 * This method is called after adding a new cache file.
	 */
	protected function enforceLimits()
	{
		$files = array();
		$dir = @opendir($this->cacheDir);
		if ($dir === false) {
			return;
		}
		while (($file = readdir($dir)) !== false) {
			if ($file === '.' || $file === '..') {
				continue;
			}
			// We only consider .cache files for LRU eviction
			if (substr($file, -6) !== '.cache') {
				continue;
			}
			$filePath = $this->cacheDir . DIRECTORY_SEPARATOR . $file;
			$mtime = filemtime($filePath);
			$size = filesize($filePath);
			$files[] = array(
				'file' => $filePath,
				'mtime' => $mtime,
				'size' => $size,
			);
		}
		closedir($dir);

		// Sort by mtime ascending (oldest first)
		usort($files, function($a, $b) {
			return $a['mtime'] - $b['mtime'];
		});

		// Remove files until we are under the limits
		$totalSize = 0;
		$count = count($files);
		$removeFiles = array();
		$removeCount = 0;

		// First, check if we need to remove based on count
		if ($count > $this->maxFiles) {
			$removeCount = $count - $this->maxFiles;
			for ($i = 0; $i < $removeCount; $i++) {
				$removeFiles[] = $files[$i]['file'];
			}
		}

		// Now, check total size after removing the excess count files
		// We'll compute the size of the remaining files
		$remainingFiles = array_slice($files, $removeCount);
		$totalSize = 0;
		foreach ($remainingFiles as $fileInfo) {
			$totalSize += $fileInfo['size'];
		}

		// If total size still exceeds maxSize, remove more oldest files
		if ($totalSize > $this->maxSize) {
			// We need to remove files until total size <= maxSize
			// We'll iterate over the remainingFiles (which are sorted by mtime ascending)
			// and remove from the beginning (oldest) until we are under the limit.
			foreach ($remainingFiles as $fileInfo) {
				if ($totalSize <= $this->maxSize) {
					break;
				}
				$removeFiles[] = $fileInfo['file'];
				$totalSize -= $fileInfo['size'];
			}
		}

		// Actually remove the files
		foreach ($removeFiles as $filePath) {
			@unlink($filePath);
			// Also remove any associated lock file (should not exist, but just in case)
			$lockFile = $filePath . '.lock';
			@unlink($lockFile);
		}
	}

	/**
	 * Retrieves a value from cache with a specified key.
	 * This method is called by parent::get() after generating the unique key.
	 * @param string $key a unique key identifying the cached value
	 * @return string|boolean the value stored in cache, false if the value is not in the cache or expired.
	 */
	protected function getValue($key)
	{
		$cacheFile = $this->getCacheFile($key);
		if (!is_file($cacheFile)) {
			return false;
		}

		// Acquire lock for reading (we want to prevent concurrent write during read)
		$lockFile = $this->getLockFile($key);
		$fp = $this->acquireLock($lockFile);
		if ($fp === false) {
			// If we cannot acquire lock, we might still try to read, but to be safe we return false.
			// Alternatively, we could skip locking for reads? But we need to prevent reading while writing.
			// We'll return false on lock failure.
			return false;
		}

		$content = @file_get_contents($cacheFile);
		$this->releaseLock($fp);

		if ($content === false) {
			return false;
		}

		$data = @unserialize($content);
		if (!is_array($data) || !isset($data['e'], $data['d'])) {
			// Corrupted cache file, delete it
			@unlink($cacheFile);
			return false;
		}

		$expireTimestamp = $data['e'];
		$cachedData = $data['d'];

		if ($this->isExpired($expireTimestamp, filemtime($cacheFile))) {
			// Expired, delete it
			@unlink($cacheFile);
			return false;
		}

		// Update LRU timestamp
		$this->updateLRU($cacheFile);

		// Remove lock file after successful read
		$this->removeLockFile($lockFile);

		return $cachedData;
	}

	/**
	 * Stores a value identified by a key into cache.
	 * This method is called by parent::set() after generating the unique key and serializing the value with dependency.
	 * @param string $key the key identifying the value to be cached
	 * @param string $value the value to be cached (already serialized by parent if needed)
	 * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
	 * @return boolean true if the value is successfully stored into cache, false otherwise
	 */
	protected function setValue($key, $value, $expire)
	{
		// Calculate expiration timestamp
		$expireTimestamp = ($expire > 0) ? time() + $expire : 0;

		// Prepare data to store
		$data = serialize(array(
			'e' => $expireTimestamp,
			'd' => $value,
		));

		$cacheFile = $this->getCacheFile($key);
		$lockFile = $this->getLockFile($key);

		// Acquire lock for writing
		$fp = $this->acquireLock($lockFile);
		if ($fp === false) {
			return false;
		}

		// Write to a temporary file first (atomic write)
		$tempFile = $cacheFile . '.tmp' . mt_rand();
		if (@file_put_contents($tempFile, $data, LOCK_EX) === false) {
			$this->releaseLock($fp);
			$this->removeLockFile($lockFile);
			@unlink($tempFile);
			return false;
		}

		// Release lock before renaming? Actually we should hold the lock until the rename is done to prevent
		// another process from reading the file while we are renaming? But rename is atomic.
		// We'll hold the lock.
		if (@rename($tempFile, $cacheFile) === false) {
			$this->releaseLock($fp);
			$this->removeLockFile($lockFile);
			@unlink($tempFile);
			return false;
		}

		// Now we can release the lock and remove the lock file
		$this->releaseLock($fp);
		$this->removeLockFile($lockFile);

		// Update LRU timestamp (the file's mtime is now set to the time of the rename)
		// We'll touch it again to ensure it's recent (though rename should have updated mtime)
		$this->updateLRU($cacheFile);

		// Enforce limits
		$this->enforceLimits();

		return true;
	}

	/**
	 * Stores a value identified by a key into cache if the cache does not contain this key.
	 * This method is called by parent::add() after generating the unique key and serializing the value with dependency.
	 * @param string $key the key identifying the value to be cached
	 * @param string $value the value to be cached (already serialized by parent if needed)
	 * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
	 * @return boolean true if the value is successfully stored into cache, false otherwise
	 */
	protected function addValue($key, $value, $expire)
	{
		// Check if the key already exists (and is not expired)
		if ($this->getValue($key) !== false) {
			return false;
		}
		return $this->setValue($key, $value, $expire);
	}

	/**
	 * Deletes a value with the specified key from cache
	 * This method is called by parent::delete() after generating the unique key.
	 * @param string $key the key of the value to be deleted
	 * @return boolean if no error happens during deletion
	 */
	protected function deleteValue($key)
	{
		$cacheFile = $this->getCacheFile($key);
		$lockFile = $this->getLockFile($key);

		// Acquire lock to prevent race condition with get/set
		$fp = $this->acquireLock($lockFile);
		if ($fp === false) {
			// If we cannot get lock, we still try to delete, but it might be risky.
			// We'll proceed without lock? Better to return false.
			return false;
		}

		$result = @unlink($cacheFile);
		$this->releaseLock($fp);
		$this->removeLockFile($lockFile);

		return $result;
	}

	/**
	 * Deletes all values from cache.
	 * This method is called by parent::flush().
	 * @return boolean whether the flush operation was successful.
	 */
	protected function flushValues()
	{
		$dir = @opendir($this->cacheDir);
		if ($dir === false) {
			return false;
		}
		$success = true;
		while (($file = readdir($dir)) !== false) {
			if ($file === '.' || $file === '..') {
				continue;
			}
			$filePath = $this->cacheDir . DIRECTORY_SEPARATOR . $file;
			// We only delete .cache and .lock files
			if (substr($file, -6) === '.cache' || substr($file, -5) === '.lock') {
				if (@unlink($filePath) === false) {
					$success = false;
				}
			}
		}
		closedir($dir);
		return $success;
	}
}