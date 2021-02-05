ALTER TABLE `#__extensions` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__menu` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__modules` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__tags` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__update_sites` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__user_notes` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__workflows` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__workflow_stages` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__workflow_transitions` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__banners` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__banner_clients` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__contact_details` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__content` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__finder_filters` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__newsfeeds` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__categories` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__fields` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__fields_groups` MODIFY `checked_out` INT(10) UNSIGNED;
ALTER TABLE `#__ucm_content` MODIFY `core_checked_out_user_id` INT(10) UNSIGNED;

UPDATE `#__extensions` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__menu` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__modules` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__tags` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__update_sites` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__user_notes` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__workflows` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__workflow_stages` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__workflow_transitions` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__banners` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__banner_clients` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__contact_details` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__content` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__finder_filters` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__newsfeeds` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__categories` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__fields` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__fields_groups` SET `checked_out` = null WHERE `checked_out` = 0;
UPDATE `#__ucm_content` SET `core_checked_out_user_id` = null WHERE `core_checked_out_user_id` = 0;
