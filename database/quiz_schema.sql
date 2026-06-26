-- ELEVATES Quiz — full schema (run once on live DB)
-- Import via phpMyAdmin or: mysql -u USER -p DATABASE < database/quiz_schema.sql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `quiz_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sort_order` int NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `instructions` text,
  `duration_minutes` int NOT NULL DEFAULT 90,
  `total_questions` int NOT NULL DEFAULT 200,
  `persona_code` varchar(10) DEFAULT NULL,
  `meta_json` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(500) NOT NULL,
  `option_b` varchar(500) NOT NULL,
  `option_c` varchar(500) DEFAULT NULL,
  `option_d` varchar(500) DEFAULT NULL,
  `correct_option` enum('a','b','c','d','e') NOT NULL DEFAULT 'a',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `item_code` varchar(10) DEFAULT NULL,
  `question_type` varchar(10) NOT NULL DEFAULT 'K',
  `option_e` varchar(500) DEFAULT NULL,
  `pillar` varchar(20) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `scoring_meta` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `quiz_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT 'AI Based Assessment',
  `instructions` text,
  `duration_minutes` int NOT NULL DEFAULT 50,
  `total_questions` int NOT NULL DEFAULT 40,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `quiz_result_bands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `min_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `max_percent` decimal(5,2) NOT NULL DEFAULT 100.00,
  `title` varchar(255) NOT NULL,
  `result_text` text NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `quiz_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `attempt_token` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `question_ids` json NOT NULL,
  `answers` json DEFAULT NULL,
  `started_at` datetime NOT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `time_taken_seconds` int DEFAULT NULL,
  `total_questions` int NOT NULL,
  `correct_count` int DEFAULT NULL,
  `score_percent` decimal(5,2) DEFAULT NULL,
  `result_band_id` int DEFAULT NULL,
  `result_title` varchar(255) DEFAULT NULL,
  `result_text` text,
  `status` enum('in_progress','submitted','expired') NOT NULL DEFAULT 'in_progress',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_attempt_token` (`attempt_token`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
