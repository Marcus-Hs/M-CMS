DROP TABLE IF EXISTS `#PREFIX#plugins__gbook`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__gbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(30) NOT NULL DEFAULT '',
  `mail` varchar(120) NOT NULL DEFAULT '',
  `url` varchar(120) NOT NULL DEFAULT '',
  `textfeld` text NOT NULL,
  `mailstatus` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
