CREATE DATABASE IF NOT EXISTS `bug_app`;

use bug_app;

CREATE TABLE `reports` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `report_type` varchar(50) NOT NULL,
    `message` text NOT NULL,
    `link` varchar(255) DEFAULT NULL,
    `email` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE DATABASE IF NOT EXISTS `bug_app_testing`;

use bug_app_testing;

CREATE TABLE `reports` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `report_type` varchar(50) NOT NULL,
    `message` text NOT NULL,
    `link` varchar(255) DEFAULT NULL,
    `email` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = latin1;