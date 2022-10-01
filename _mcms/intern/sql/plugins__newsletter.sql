DROP TABLE IF EXISTS `#PREFIX#plugins__newsletter`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__newsletter` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(65) NOT NULL DEFAULT '',
  `Email` varchar(150) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `phrase` varchar(65) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;