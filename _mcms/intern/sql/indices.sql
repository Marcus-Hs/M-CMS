ALTER TABLE `#PREFIX#_languages` ADD INDEX ( `position` );
-- # Schnipp --
ALTER TABLE `#PREFIX#_translate` ADD INDEX ( `position` );
-- # Schnipp --
ALTER TABLE `#PREFIX#_translate` ADD INDEX ( `publish` );
-- # Schnipp --
ALTER TABLE `#PREFIX#_translate` ADD INDEX ( `finish` );
-- # Schnipp --
ALTER TABLE `#PREFIX#abschnitte` ADD INDEX ( `position` );
-- # Schnipp --
ALTER TABLE `#PREFIX#dateien` ADD INDEX ( `position` );
-- # Schnipp --
ALTER TABLE `#PREFIX#seiten` ADD INDEX ( `insdate` );
-- # Schnipp --
ALTER TABLE `#PREFIX#seiten_attr` ADD INDEX (`status`);
-- # Schnipp --
ALTER TABLE `#PREFIX#seiten_attr` ADD INDEX (`rgt`);
-- # Schnipp --
ALTER TABLE `#PREFIX#seiten_attr` ADD INDEX (`lft`);
-- # Schnipp --
ALTER TABLE `#PREFIX#seiten_attr` ADD INDEX `parent_ID` (`parent_ID`);
-- # Schnipp --
ALTER TABLE `#PREFIX#vorlagen` ADD INDEX ( `position` );
-- # Schnipp --
ALTER TABLE `#PREFIX#vorlagen` ADD INDEX ( `Titel` );
-- # Schnipp --