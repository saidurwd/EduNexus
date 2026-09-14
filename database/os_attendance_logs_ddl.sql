CREATE TABLE `os_attendance_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_no` varchar(100) NOT NULL,
  `device_id` int(10) unsigned DEFAULT NULL,
  `attendance_time` datetime NOT NULL,
  `attendance_type` varchar(30) DEFAULT NULL,
  `verify_mode` varchar(50) DEFAULT NULL,
  `source` varchar(30) NOT NULL DEFAULT 'HIKVISION',
  `hikvision_event_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_hikvision_event` (`hikvision_event_id`),
  KEY `idx_employee_time` (`employee_no`,`attendance_time`),
  KEY `idx_device_time` (`device_id`,`attendance_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci