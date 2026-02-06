ALTER TABLE `legal_agencies_login` ADD `status` ENUM('A','D') NOT NULL DEFAULT 'A' AFTER `updated_by`;
