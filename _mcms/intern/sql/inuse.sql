DROP TABLE IF EXISTS `#PREFIX#_inuse`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_inuse` (
  `person_ID` mediumint(5) NOT NULL,
  `attr` varchar(15) NOT NULL,
  `attr_ID` mediumint(5) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  KEY `person_ID` (`person_ID`,`attr`,`attr_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;