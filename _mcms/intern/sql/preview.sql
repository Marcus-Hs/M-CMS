DROP TABLE IF EXISTS `#PREFIX#___preview`;
CREATE TABLE `#PREFIX#___preview` (
  `PAGE_ID` smallint(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` blob NOT NULL,
  PRIMARY KEY (`PAGE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;