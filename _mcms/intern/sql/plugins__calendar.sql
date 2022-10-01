DROP TABLE IF EXISTS `#PREFIX#plugins__calendar`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__calendar` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `PAGE_ID` mediumint(11) NOT NULL DEFAULT '0',
  `anfang` varchar(22) DEFAULT NULL,
  `ende` varchar(22) DEFAULT NULL,
  `Name` varchar(65) NOT NULL DEFAULT '',
  `Strasse` varchar(65) NOT NULL DEFAULT '',
  `PLZ` varchar(65) NOT NULL DEFAULT '',
  `Ort` varchar(65) NOT NULL DEFAULT '',
  `Telefon` varchar(65) NOT NULL DEFAULT '',
  `Email` varchar(65) NOT NULL DEFAULT '',
  `betreff` varchar(65) NOT NULL,
  `mitteilung` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;