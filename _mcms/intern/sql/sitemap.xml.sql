-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`styles`,`JS`,`CSS`,`anzahl`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("26", "sitemap.xml", "Sitemap für Google", "<!-- SUB=main_tpl --><?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
         xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
         xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
§SITEMAPURLS§
</urlset>
<!-- /SUB -->
<!-- SUB=sitemapurls --><url>
    <loc>#PATH#</loc>
    <lastmod>#LASTMOD#</lastmod>
    <changefreq>%CANGEFREQ%</changefreq>
    <priority>%PRORITY%</priority>
</url><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->
", "", "", "", "1", "1", "1", "0", "0", "0", "0", "0", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:103 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "0", "2", "10", "PO_ASC", "1", "0", "70", "71");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:103 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "sitemap.xml", "", "sitemap.xml", "sitemap.xml", "", "", "0000-00-00 00:00:00", "2010-08-06 16:20:30", "1");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=abschnitte:103 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("1", "PAGE_NEW", "1", "a%3A2%3A%7Bs%3A9%3A%22Cangefreq%22%3Bs%3A6%3A%22weekly%22%3Bs%3A7%3A%22Prority%22%3Bs%3A3%3A%220.5%22%3B%7D", "", "99", "1", "weekly", "2010-08-06", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --

