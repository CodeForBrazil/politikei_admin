ALTER TABLE `users` ADD COLUMN `facebook_id` VARCHAR(255);
ALTER TABLE `users` CHANGE `dateupdate` `updated_at` DATETIME NULL;
ALTER TABLE `users` CHANGE `dateadd` `created_at` DATETIME NULL;
ALTER TABLE `users` CHANGE COLUMN `avatar` `avatar_id` INT(11) NULL DEFAULT NULL COMMENT 'media.id' ;
