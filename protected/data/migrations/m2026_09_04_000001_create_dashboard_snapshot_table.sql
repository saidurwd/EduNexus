-- Migration: Create dashboard_snapshot table
-- Created: 2026-09-04
-- Description: Pre-aggregated daily metrics for dashboard performance

CREATE TABLE {{dashboard_snapshot}} (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    institution INTEGER NOT NULL,
    metric_type VARCHAR(50) NOT NULL,
    metric_key VARCHAR(100) NOT NULL,
    metric_value DECIMAL(18,2),
    recorded_date DATE NOT NULL,
    academic_year INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_institution_date (institution, recorded_date),
    INDEX idx_metric (metric_type, metric_key),
    INDEX idx_academic_year (academic_year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
