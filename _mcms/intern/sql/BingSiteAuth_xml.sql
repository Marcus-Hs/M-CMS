-- IMPORT AS NEW--

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("13", "BingSiteAuth.xml", "Auth for Bing", "<!-- SUB=main_tpl --><?xml version=\"1.0\"?>
<users>
  <user>%BINGAUTH%</user>
</users><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->", "", "", "", "", "1", "0", "0", "1", "1", "0", "250", "250", "500", "500", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --


-- # DUMP=seiten_attr:48 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("1", "TPL_NEW", "0", "2", "99", "", "1", "0", "95", "96");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=seiten:48 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "BingSiteAuth.xml", "", "BingSiteAuth.xml", "BingSiteAuth.xml", "", "", "", "2013-11-14 16:15:14", "2013-11-14 16:15:14", "1");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=abschnitte:48 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("1", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A8%3A%22Bingauth%22%3Bs%3A32%3A%22602063BD9369FBE0AAFDA26A72EFDE19%22%3B%7D", "", "99", "1", "602063BD9369FBE0AAFDA26A72EFDE19", "2013-11-14", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --