DROP TABLE IF EXISTS `#PREFIX#session`;
-- # Schnipp --
DROP TABLE IF EXISTS `#PREFIX#_session`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_session` (
  `ID` smallint(5) NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `logindate` datetime NOT NULL,
  PRIMARY KEY (`sessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- # Schnipp --
ALTER TABLE `#PREFIX#person`
  DROP `logindate`,
  DROP `sessionID`,
  DROP `IP`,
  DROP `cookie`,
  DROP `visibility`;
-- # Schnipp --
ALTER TABLE `#PREFIX#kategorien` CHANGE `status` `status` VARCHAR( 15 ) NOT NULL DEFAULT '0'