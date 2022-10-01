DROP TABLE IF EXISTS `#PREFIX#plugins__categorize`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__categorize` (
  `CAT_PAGE_ID` mediumint(7) NOT NULL,
  `PAGE_ID` mediumint(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;