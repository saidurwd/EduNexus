CREATE TABLE `os_hikvision_devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_name` varchar(100) NOT NULL,
  `device_serial` varchar(100) DEFAULT NULL,
  `device_model` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password_encrypted` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_event_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_device_serial` (`device_serial`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci