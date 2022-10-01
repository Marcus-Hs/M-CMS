DROP TABLE IF EXISTS `#PREFIX#plugins__addcolor`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__addcolor` (
  `PAGE_ID` mediumint(5) NOT NULL,
  `color_ID` varchar(15) NOT NULL DEFAULT '0',
  `color` varchar(15) NOT NULL,
  PRIMARY KEY (`PAGE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --