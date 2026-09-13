CREATE TABLE `os_dashboard_snapshot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institution` int(11) NOT NULL,
  `metric_type` varchar(50) NOT NULL,
  `metric_key` varchar(100) NOT NULL,
  `metric_value` decimal(18,2) DEFAULT NULL,
  `recorded_date` date NOT NULL,
  `academic_year` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_institution_date` (`institution`,`recorded_date`),
  KEY `idx_metric` (`metric_type`,`metric_key`),
  KEY `idx_academic_year` (`academic_year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci