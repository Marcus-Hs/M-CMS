DROP TABLE IF EXISTS `#PREFIX#plugins__forum`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__forum` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentID` int(11) NOT NULL DEFAULT '0',
  `threadID` int(11) NOT NULL DEFAULT '0',
  `PAGE_ID` int(11) NOT NULL DEFAULT '3',
  `ebene` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg` text NOT NULL,
  `titel` varchar(255) NOT NULL DEFAULT '',
  `publish` int(1) NOT NULL DEFAULT '0',
  `mailme` int(1) NOT NULL DEFAULT '0',
  `phrase` varchar(65) NOT NULL DEFAULT '',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `IP` varchar(16) NOT NULL DEFAULT '',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;