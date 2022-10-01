-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`neu`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`,`cache`,`stats`) VALUES
("11", "Gästebuch", "", "§BRIDGE§
§GAESTEBUCH§
<!-- SUB=eintraege --><h5>%EINTRAG% %NR%: #NUMMER#</h5>
<div class=\"eintrag\">
<div class=\"name\">
<span style=\"font-size:11px;float:right;\">#TIME#</span>
<p>#NAME#<br />#URL#</p>
</div>
<div class=\"eintragstext\">#TEXT#</div>
</div><!-- /SUB -->
<!-- SUB=geloescht -->%EINTRAGGELOESCHT%: <!-- /SUB -->", "", "", "", "", "1", "1", "0", "0", "0", "0", "fit", "fit", "1", "1");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:142 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`order_by`,`person_ID`,`position`,`visibility`,`status`,`lft`,`rgt`) VALUES
("6", "TPL_NEW", "0", "PO_ASC", "2", "8", "1", "0", "16", "19");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:142 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "Gästebuch", "Gästebuch", "Gaestebuch", "Gästebuch", "G", "&lt;p&gt;Hier ist Platz f&amp;uuml;r Lob, Kritik und liebe Gr&amp;uuml;&amp;szlig;e...&lt;/p&gt;", "Hier ist Platz für Lob, Kritik und liebe Grüße...", "2009-10-22 00:00:00", "2011-05-05 07:30:05", "0");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=abschnitte:142 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "PAGE_NEW", "1", "a%3A5%3A%7Bs%3A7%3A%22Eintrag%22%3Bs%3A7%3A%22Eintrag%22%3Bs%3A2%3A%22Nr%22%3Bs%3A3%3A%22Nr.%22%3Bs%3A8%3A%22Proseite%22%3Bs%3A2%3A%2210%22%3Bs%3A6%3A%22Seiten%22%3Bs%3A6%3A%22Seiten%22%3Bs%3A16%3A%22Eintraggeloescht%22%3Bs%3A32%3A%22Der+Eintrag+ist+gel%F6scht+worden.%22%3B%7D", "", "99", "1", "Eintrag", "2011-05-05", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --