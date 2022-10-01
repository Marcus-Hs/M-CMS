-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("20", "Forum", "", "§FORUM:threads§", "", "", "", "", "1", "0", "1", "1", "1", "200", "200", "500", "500", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:82 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("2", "TPL_NEW", "81", "2", "13", "", "1", "0", "40", "41");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten:82 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "0", "Ideen", "Ideen", "Ideen", "Ideen", "", "", "", "0000-00-00 00:00:00", "2009-07-01 14:31:24", "0");
-- # /DUMP # --

-- # Schnipp --