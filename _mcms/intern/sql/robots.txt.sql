-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`styles`,`JS`,`CSS`,`anzahl`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("27", "robots.txt", "Anweisungen für Suchrobooter", "<!-- SUB=main_tpl -->%ANWEISUNGEN_RAW%
Sitemap: #LINKTO:%SITEMAP_SELECT:seiten%;absolute#
<!-- /SUB -->
<!-- SUB=Content-type -->text/plain<!-- /SUB -->
", "", "", "", "1", "1", "1", "0", "0", "0", "0", "0", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:104 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "0", "2", "9", "PO_ASC", "1", "0", "68", "69");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:104 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "robots.txt", "", "robots.txt", "robots.txt", "", "", "0000-00-00 00:00:00", "2010-11-16 17:28:21", "1");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=abschnitte:104 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("1", "PAGE_NEW", "1", "a%3A2%3A%7Bs%3A15%3A%22Anweisungen_raw%22%3Bs%3A74%3A%22User-agent%3A+%2A%0D%0ADisallow%3A+%2Fimages%2F%0D%0ADisallow%3A+%2Fintern%2F%0D%0ADisallow%3A+script.js%22%3Bs%3A14%3A%22Sitemap_select%22%3Bs%3A3%3A%22103%22%3B%7D", "", "99", "1", "User-agent: *
Disallow: /images/
Disallow: /intern/
Disallow:", "2010-08-06", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --

