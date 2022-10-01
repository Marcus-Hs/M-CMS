DROP TABLE IF EXISTS `#PREFIX#_cache`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_cache` (
  `PAGE_ID` mediumint(11) NOT NULL,
  `LANG_ID` mediumint(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `content` blob NOT NULL,
  UNIQUE KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;