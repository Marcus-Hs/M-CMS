DROP TABLE IF EXISTS `#PREFIX#plugins__xsite_items`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__xsite_items` (
  `ITEM_ID` smallint(7) NOT NULL AUTO_INCREMENT,
  `SITE_ID` smallint(5) NOT NULL,
  `category` varchar(65) NOT NULL,
  `PAGE_ID` smallint(5) NOT NULL,
  `PART_ID` smallint(5) NOT NULL,
  `contents` text NOT NULL,
  `publish` date NOT NULL,
  `finish` date NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `lastmod` date NOT NULL,
  PRIMARY KEY (`ITEM_ID`),
  UNIQUE KEY `SITE_ID` (`SITE_ID`,`PAGE_ID`,`PART_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
-- # Schnipp --
DROP TABLE IF EXISTS `#PREFIX#plugins__xsite_sites`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__xsite_sites` (
  `SITE_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `domain` varchar(65) NOT NULL,
  `PAGE_IDs` varchar(65) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`SITE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;