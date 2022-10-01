-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("21", "Forum Übersicht", "", "§FORUM§", "", "", "", "", "1", "0", "1", "1", "1", "200", "200", "500", "500", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:81 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("2", "TPL_NEW", "87", "2", "8", "", "1", "0", "33", "48");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:81 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "Forum", "Forum", "Forum", "Forum", "", "&lt;p&gt;Zum Austausch von Gedanken und Ideen.&lt;br /&gt;

&lt;/p&gt;", "Ein Platz zum Austausch von Gedanken und Ideen.", "0000-00-00 00:00:00", "2010-04-19 16:42:39", "0");
-- # /DUMP # --

-- # Schnipp --

