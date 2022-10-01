-- IMPORT AS NEW--

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`,`cache`,`stats`) VALUES
("9", "Newsletter-Email", "", "<!-- %ATTACHMENT_DATEI% -->", "", "", "", "", "1", "0", "1", "1", "0", "0", "0", "0", "fit", "fit", "0", "1");
-- # /DUMP # --

-- # Schnipp --


-- # DUMP=seiten_attr:137 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`order_by`,`person_ID`,`position`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "1", "PO_ASC", "10", "15", "1", "0", "2", "3");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=seiten:137 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "Noch ein Newsletter", "Noch ein Newsletter", "Noch_ein_Newsletter", "Noch ein Newsletter", "", "&lt;p&gt;Hallo liebe Leute,&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Viele Gr&amp;uuml;&amp;szlig;e&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;", "", "0000-00-00 00:00:00", "2010-09-09 09:39:11", "0");
-- # /DUMP # --
