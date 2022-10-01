-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`neu`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`,`cache`,`stats`) VALUES
("12", "GB-Eintrag", "", "§GAESTEBUCH§
<!-- SUB=gbform --><div id=\"formular\">
§PHPSESSID§
<form action=\"\" method=\"post\">
    <p><label for=\"name\">%NAME%:<input style=\"margin-bottom:2px;\" type=\"text\" name=\"gb[name]\" id=\"name\" value=\"#NAME#\" size=\"25\" maxlength=\"25\" /></label>
      <input type=\"checkbox\" checked=\"checked\" name=\"zeigen\" id=\"zeigen\" /><span class=\"small\"> %EMAILZEIGEN% </span> <br />
        <label for=\"email\">%EMAIL%:<input type=\"text\" name=\"gb[email]\" id=\"email\" onblur=\"gb_verify();return false;\" value=\"#EMAIL#\" size=\"25\" maxlength=\"120\" /></label>
        <label for=\"url\">%HOMEPAGE%:<input style=\"margin-bottom:2px;\" type=\"text\" name=\"gb[url]\" id=\"url\" value=\"#HOMEPAGE#\" size=\"25\" maxlength=\"120\" /></label>
    </p>
    <p>
        <label for=\"gb_eintrag\">%EINTRAG%:</label>
        <textarea id=\"gb_eintrag\" name=\"gb[eintrag]\" style=\"width:450px;\" rows=\"6\">#EINTRAG#</textarea></p>
    <div id=\"bbcode\">
        §SMILIES§<br />
        <a href=\"javascript:\" onclick=\"fett();return false;\" class=\"edit\" id=\"fett\" style=\"font-weight:bolder;\">%FETT%</a>
        <a href=\"javascript:\" onclick=\"uline();return false;\" class=\"edit\" id=\"uline\">%UNTERSTRICHEN%</a>
        <a href=\"javascript:\" onclick=\"italic();return false;\" class=\"edit\" id=\"italic\" style=\"font-style:italic;\">%SCHRAEG%</a>
        <a href=\"javascript:\" onclick=\"vorschau();return false;\" class=\"edit\" id=\"preview\" style=\"float:right;\">%VORSCHAU%</a>
    </div>
    
    <span id=\"gb_verify\">§GBV§</span>
    <p><input style=\"margin-left:5px;\" type=\"submit\" name=\"gb_submit\" value=\"%EINTRAGEN%\" /></p>
    <p>* %PFLICHTFELDER%</p>
</form>
</div><!-- /SUB -->

<!-- SUB=geloescht -->%EINTRAGGELOESCHT%: <!-- /SUB -->
<!-- SUB=fehler -->%FEHLERMELDUNG%: <!-- /SUB -->
<!-- SUB=keineurls -->%KEINEURLS%<!-- /SUB -->
<!-- SUB=javascript -->%JAVASCRIPT%<!-- /SUB -->
<!-- SUB=existiertschon -->%EXISTIERTSCHON%<!-- /SUB -->
<!-- SUB=danke -->%DANKE%<!-- /SUB -->
<!-- SUB=eintragsmail -->Nachricht: #NAME# (mailto: #EMAIL#, HP: #URL#) hat geschrieben:
 
#EINTRAG#

---
Eintrag ansehen:
§LINKTO:PAGE_ID=%GAESTEBUCH_SELECT:seiten%;SET=absolute§

---
Eintrag löschen:
§LINKTO:PAGE_ID=%GAESTEBUCH_SELECT:seiten%;SET=absolute§&datum=#TIMESTAMP#&gb_remove=1<!-- /SUB --> ", "", "", "gbook.js", "gbook.css", "1", "1", "0", "0", "0", "0", "fit", "fit", "1", "0");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:143 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`order_by`,`person_ID`,`position`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "142", "PO_ASC", "2", "18", "1", "0", "17", "18");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:143 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "10", "Dein Eintrag ins Gästebuch", "Dein Eintrag ins Gästebuch", "Dein_Eintrag_ins_Gaestebuch", "Dein Eintrag ins Gästebuch", "D", "&lt;p&gt;&lt;a href=&quot;#LINKTO:142#&quot;&gt;Zur&amp;uuml;ck zum G&amp;auml;stebuch&lt;/a&gt;&lt;/p&gt;
&lt;p&gt;&lt;span class=&quot;small&quot;&gt;Wer seine Email-Adresse hier nicht ver&amp;ouml;ffentlichen m&amp;ouml;chte, sollte im Formular das H&amp;auml;kchen neben der Email-Adresse entfernen.&amp;nbsp;&lt;/span&gt;&lt;/p&gt;", "", "2009-07-17 00:00:00", "2011-05-05 07:41:48", "0");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=abschnitte:143 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "PAGE_NEW", "1", "a%3A18%3A%7Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A11%3A%22Emailzeigen%22%3Bs%3A15%3A%22E-Mail+anzeigen%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A8%3A%22Homepage%22%3Bs%3A8%3A%22Homepage%22%3Bs%3A7%3A%22Eintrag%22%3Bs%3A7%3A%22Eintrag%22%3Bs%3A4%3A%22Fett%22%3Bs%3A4%3A%22Fett%22%3Bs%3A13%3A%22Unterstrichen%22%3Bs%3A13%3A%22Unterstrichen%22%3Bs%3A7%3A%22Schraeg%22%3Bs%3A6%3A%22Schr%E4g%22%3Bs%3A8%3A%22Vorschau%22%3Bs%3A8%3A%22Vorschau%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A29%3A%22Diese+Felder+bitte+ausf%FCllen.%22%3Bs%3A16%3A%22Eintraggeloescht%22%3Bs%3A27%3A%22Der+Eintrag+wurde+gel%F6scht.%22%3Bs%3A13%3A%22Fehlermeldung%22%3Bs%3A31%3A%22Bitte+f%FClle+folgende+Felder+aus%22%3Bs%3A9%3A%22Keineurls%22%3Bs%3A25%3A%22Bitte+keine+URLs+im+Text%21%22%3Bs%3A10%3A%22Javascript%22%3Bs%3A85%3A%22Bitte+Javascript+aktivieren+%28aus+Gr%FCnden+des+Spamschutzes+geht+es+leider+nicht+ohne%29.%22%3Bs%3A14%3A%22Existiertschon%22%3Bs%3A31%3A%22Dieser+Eintrag+existiert+schon.%22%3Bs%3A5%3A%22Danke%22%3Bs%3A31%3A%22Vielen+Dank+f%FCr+Deinen+Eintrag.%22%3Bs%3A17%3A%22Gaestebuch_select%22%3Bs%3A3%3A%22142%22%3B%7D", "NAME,EMAIL,EINTRAG", "99", "1", "Name", "2011-05-05", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --
