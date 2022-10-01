-- IMPORT AS NEW--

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("18", "Forum Eintrag", "", "§FORUM:neu§
<!-- SUB=formular -->§BACKLINK§#ANTWORT#
<form class=\"forum\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">
  <input type=\"hidden\" name=\"k\" value=\"#K_ID#\">  
  <input type=\"hidden\" name=\"parent\" value=\"#PARENTID#\">  
  <input type=\"hidden\" name=\"thread\" value=\"#THREADID#\"> 
  <p><label for=\"name\">%NAME%:<input id=\"name\" name=\"forum[Name]\" value=\"#NAME#\" size=\"35\" maxlength=\"255\" /></label>
    <label for=\"email\">%EMAIL%:<input type=\"eamil\" id=\"email\" name=\"forum[Email]\" value=\"#EMAIL#\" size=\"35\" maxlength=\"64\" /></label>
    <input type=\"checkbox\" class=\"checkbox\" style=\"float:none;\" name=\"forum[publish]\" value=\"1\" #CHECK_PUBLISH# /> <small>%VEROEFFENTLICHEN%</small></p>
  <p><label for=\"titel\">%TITEL%:<input type=\"text\" id=\"titel\" name=\"forum[titel]\" value=\"#TITEL#\" size=\"35\" maxlength=\"125\" /></label>
    <label for=\"textarea\">%NACHRICHT%:</label>
    <textarea rows=\"6\" style=\"width:435px;\" cols=\"20\" id=\"textarea\" name=\"forum[nachricht]\">#NACHRICHT#</textarea></p>
  <div id=\"bbcode\">
    §SMILIES§<br />
    <a href=\"javascript:\" onclick=\"fett();return false;\"   id=\"fett\" style=\"font-weight:bolder;\">%FETT%</a>
    <a href=\"javascript:\" onclick=\"uline();return false;\"  id=\"uline\">%UNTERSTRICHEN%</a>
    <a href=\"javascript:\" onclick=\"italic();return false;\" id=\"italic\" style=\"font-style:italic;\">%SCHRAEG%</a>
    <a href=\"javascript:\" onclick=\"vorschau('textarea');return false;\" id=\"preview\">%VORSCHAU%</a>
  </div>
  <p><input type=\"checkbox\" class=\"checkbox\" name=\"forum[mailme]\" value=\"1\" checked=\"checked\" /> %BENACHRICHTIGUNG%<br /><br />
    <input type=\"checkbox\" class=\"checkbox\" name=\"forum[bedingungen]\" value=\"1\" #CHECK_NB# /> <a onClick=\"popup(%NUTZBEDINGUNGEN_SELECT:seiten%);return false;\" href=\"#LINKTO:%NUTZBEDINGUNGEN_SELECT:seiten%#\" title=\"\">%NUTZUNGSBEDINGUNGEN%</a>§PFLICHTFELD§<br /><br />
    <input type=\"submit\" class=\"button\" name=\"submit[forum]\" value=\"%EINTRAGEN%\" /></p>
  <p>%INFO_TEXT%</p>
  <p>%PFLICHTFELDER_TEXT%</p>
</form> <!-- /SUB -->

<!-- SUB=kat_frame --><table class=\"eintraege\"><tr><th>%TITEL%</th><th>%BEITRAEGE%</th><th>%LETZTERBEITRAG%</th><th>%DATUM%</th></tr>$ROWS$</table><!-- /SUB -->
<!-- SUB=kat_row --><tr>
  <td><a href=\"§LINKTO:*PAGE_ID*§\">*TITEL*</a></td>
  <td class=\"tar\">*COUNTER*</td>
  <td><a href=\"§LINKTONOSID:*PAGE_ID*§/*THREADID*§SID§#id*ID*\">*BEITRAG*</a></td><td>*DATUM*</td>
</tr> <!-- /SUB -->
 
<!-- SUB=thread_frame --><table class=\"forum\"><tr><th>%BEITRAG%</th><th>%VON%</th><th>%DATUM%</th><th>%LETZTERBEITRAG%</th><th>%ANTWORTEN%</th></tr>$ROWS$</table><!-- /SUB -->
<!-- SUB=thread_row --><tr>
  <td><a href=\"$LINK$\">*TITLE*</a></td><td>*NAME*</td><td>*DATE*</td><td>*LAST*</td><td class=\"tar\">*COUNT*</td>
</tr><!-- /SUB --> 

<!-- SUB=uhr --> %UHR%<!-- /SUB -->

<!-- SUB=eintrag -->%EINTRAG_FCK:HEIGHT=250px%<!-- /SUB -->
<!-- SUB=antworten --><p><a href=\"#LINKTO:#PAGE_ID###AMP#thread=#THREADID##AMP#parent=#ID#\">%ANTWORTEN%</a></p><!-- /SUB -->
<!-- SUB=forumeintrag -->%FORUMEINTRAG_SELECT:seiten%<!-- /SUB -->
<!-- SUB=keinekategorie -->%KEINEKATEGORIE_TEXT%<!-- /SUB --> 
<!-- SUB=backlink --><p><a class=\"backlink\"  href=\"#BACKLINK#\">§VORIGES§</a></p><!-- /SUB -->
<!-- SUB=nichtgefunden -->%NICHTGEFUNDEN_TEXT%<!-- /SUB -->
<!-- SUB=antwortauf -->%ANTWORTAUF%<!-- /SUB -->
<!-- SUB=neuereintrag -->%NEUEREINTRAG%<!-- /SUB -->
<!-- SUB=keineeintraege -->%KEINEEINTRAEGE_TEXT%<!-- /SUB -->
<!-- SUB=keineeintraegedetail -->(%KEINEEINTRAEGEDETAIL%)<!-- /SUB -->
<!-- SUB=nochkeintragdetail -->(%NOCHKEINEEINTRAEGE%)<!-- /SUB -->
<!-- SUB=fehlernutzungsbedingungen -->%FEHLERNUTZUNGSBEDINGUNGEN%<!-- /SUB -->
<!-- SUB=fehlertextformatierungen -->%FEHLERTEXTFORMATIERUNGEN%<!-- /SUB -->
<!-- SUB=fehlersonst -->%FEHLERSONST%<!-- /SUB -->
<!-- SUB=emaileintrag -->%EMAILEINTRAG_TEXT%<!-- /SUB -->
<!-- SUB=freischaltung -->%FREISCHALTUNG%<!-- /SUB -->
<!-- SUB=eintragexistiert -->%EINTRAGEXISTIERT% <!-- /SUB -->
<!-- SUB=eintraggeloescht -->%EINTRAGGELOESCHT%<!-- /SUB -->
<!-- SUB=eintragnichtgefunden -->%EINTRAGNICHTGEFUNDEN%<!-- /SUB -->
<!-- SUB=eintragbeantwortet -->%EINTRAGBEANTWORTET%<!-- /SUB -->
<!-- SUB=bestaetigt -->%BESTAETIGT%<!-- /SUB -->
<!-- SUB=eineantwort -->%EINEANTWORT%<!-- /SUB -->
<!-- SUB=emailantwort -->%EMAILANTWORT_TEXT%<!-- /SUB -->
<!-- SUB=freigeschaltet -->%FREIGESCHALTET%<!-- /SUB -->
<!-- SUB=schonfreigeschaltet -->%SCHONFREIGESCHALTET%<!-- /SUB -->
<!-- SUB=nonotify -->%KEINEBENACHRICHTIGUNG%<!-- /SUB --> ", "", "th {text-align:left;padding-right:.5em}
td {padding-top:.3em}", "gbook.js;jquery/simplemodal.js", "gbook.css", "1", "0", "1", "1", "1", "0", "0", "0", "0", "0", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --


-- # DUMP=seiten_attr:78 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "81", "2", "10", "PO_ASC", "1", "0", "36", "41");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=seiten:78 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "Eintrag ins Forum", "Eintrag ins Forum", "Eintrag_ins_Forum", "Eintrag ins Forum", "E", "", "Eintrag ins Forum", "2010-11-19 00:00:00", "2013-05-15 08:51:56", "0"),
("PAGE_NEW", "2", "0", "M-CMS: Das suchmaschinenoptimierte Redaktionssystem, leicht zu be", "Bien Venu", "Startseite", "Startseite", "", "Bien Venu", "Bien Venu", "0000-00-00 00:00:00", "2008-05-02 08:08:47", "0"),
("PAGE_NEW", "3", "10", "M-CMS: Das suchmaschinenoptimierte Redaktionssystem, leicht zu be", "Individuelle Redaktionssysteme und Datenbankanwendungen aus Bremen", "StartseiteStartseite", "Startseite", "", "&lt;h4&gt;&lt;br /&gt;

&amp;nbsp;&lt;/h4&gt;", "", "0000-00-00 00:00:00", "2009-09-22 09:22:13", "0");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=abschnitte:78 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "PAGE_NEW", "1", "a%3A46%3A%7Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A16%3A%22Veroeffentlichen%22%3Bs%3A23%3A%22E-Mail+Ver%C3%B6ffentlichen%22%3Bs%3A5%3A%22Titel%22%3Bs%3A5%3A%22Titel%22%3Bs%3A9%3A%22Nachricht%22%3Bs%3A7%3A%22Eintrag%22%3Bs%3A4%3A%22Fett%22%3Bs%3A4%3A%22Fett%22%3Bs%3A13%3A%22Unterstrichen%22%3Bs%3A13%3A%22Unterstrichen%22%3Bs%3A7%3A%22Schraeg%22%3Bs%3A7%3A%22Schr%C3%A4g%22%3Bs%3A8%3A%22Vorschau%22%3Bs%3A8%3A%22Vorschau%22%3Bs%3A16%3A%22Benachrichtigung%22%3Bs%3A30%3A%22Benachrichtigung+bei+Antworten%22%3Bs%3A22%3A%22Nutzbedingungen_select%22%3Bs%3A2%3A%2245%22%3Bs%3A19%3A%22Nutzungsbedingungen%22%3Bs%3A33%3A%22Ich+kenne+die+Nutzungsbedingungen%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A9%3A%22Info_text%22%3Bs%3A74%3A%22Nach+dem+Absenden+erhalten+Sie+eine+E-Mail%2C+um+den+Beitrag+freizuschalten.%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A42%3A%22%2A+Diese+Felder+bitte+unbedingt+ausf%C3%BCllen.%22%3Bs%3A9%3A%22Beitraege%22%3Bs%3A9%3A%22Beitr%C3%A4ge%22%3Bs%3A14%3A%22Letzterbeitrag%22%3Bs%3A15%3A%22Letzter+Beitrag%22%3Bs%3A5%3A%22Datum%22%3Bs%3A5%3A%22Datum%22%3Bs%3A7%3A%22Beitrag%22%3Bs%3A7%3A%22Beitrag%22%3Bs%3A3%3A%22Von%22%3Bs%3A3%3A%22von%22%3Bs%3A9%3A%22Antworten%22%3Bs%3A9%3A%22Antworten%22%3Bs%3A3%3A%22Uhr%22%3Bs%3A3%3A%22Uhr%22%3Bs%3A11%3A%22Eintrag_fck%22%3Bs%3A129%3A%22%3Ch5+id%3D%22id%23ID%23%22%3E%3Cspan+class%3D%22small%22%3E%3Cspan+class%3D%22flr%22%3E%23NAME%23+%5B%23ZEIT%23%5D%3C%2Fspan%3E%3C%2Fspan%3E%23TITEL%23%3C%2Fh5%3E%0D%0A%3Cdiv+class%3D%22eintrag%22%3E%23MSG%23%3C%2Fdiv%3E%22%3Bs%3A19%3A%22Forumeintrag_select%22%3Bs%3A2%3A%2278%22%3Bs%3A19%3A%22Keinekategorie_text%22%3Bs%3A90%3A%22Sie+haben+leider+keine+Kategorie+ausgew%C3%A4hlt+in+die+Sie+Ihren+Eintrag+einstellen+m%C3%B6chten.%22%3Bs%3A18%3A%22Nichtgefunden_text%22%3Bs%3A185%3A%22Die+Nachricht%2C+auf+die+Sie+antworten+m%C3%B6chten%2C+konnte+nicht+gefunden+werden.+%28Vielleicht+ist+sie+bereits+gel%C3%B6scht+worden+und+die+alte+Seite+befand+sich+noch+in+Ihrem+Zwischenspeicher%29.%22%3Bs%3A10%3A%22Antwortauf%22%3Bs%3A11%3A%22Antwort+auf%22%3Bs%3A12%3A%22Neuereintrag%22%3Bs%3A13%3A%22Neuer+Eintrag%22%3Bs%3A19%3A%22Keineeintraege_text%22%3Bs%3A56%3A%22Leider+gibt+es+noch+keine+Beitrag+zu+diesem+Thema.+%5Bsad%5D%22%3Bs%3A20%3A%22Keineeintraegedetail%22%3Bs%3A24%3A%22Keine+Eintr%C3%A4ge+gefunden%22%3Bs%3A18%3A%22Nochkeineeintraege%22%3Bs%3A30%3A%22Noch+keine+Eintr%C3%A4ge+vorhanden%22%3Bs%3A25%3A%22Fehlernutzungsbedingungen%22%3Bs%3A107%3A%22Wenn+Sie+unsere+Nutzungsbedingunen+nicht+akzepieren%2C+k%C3%B6nnen+wir+den+Eintrag+leider+nicht+ver%C3%B6ffentlichen.%22%3Bs%3A24%3A%22Fehlertextformatierungen%22%3Bs%3A41%3A%22Bitte+pr%C3%BCfen+Sie+die+Textformatierungen.%22%3Bs%3A11%3A%22Fehlersonst%22%3Bs%3A77%3A%22Ihr+Eintrag+konnte+auf+Grund+eines+Datenbankfehlers+nicht+gespeichert+werden.%22%3Bs%3A17%3A%22Emaileintrag_text%22%3Bs%3A420%3A%22Danke+f%C3%BCr+Ihren+Eintrag+im+Forum%2C+%23NAME%23.%0D%0A%0D%0AIhre+Nachricht%3A%0D%0A%23TITEL%23%0D%0A%0D%0A%23TEXT%23%0D%0A%0D%0A---%0D%0AHier+k%C3%B6nnen+Sie+Ihren+Eintrag+ansehen%2C+sobald+er+freigeschaltet+wurde%3A%0D%0A%23THREAD%23%0D%0A%0D%0A---%0D%0ADer+Beitrag+wird+mit+folgendem+Link+freigeschaltet%3A%0D%0A%23VERIFY%23%0D%0A%0D%0A---%0D%0ASolange+keine+Antworten+auf+Ihre+Nachricht+eingegangen+sind%2C+k%C3%B6nnen+Sie+Ihren+Eintrag+mit+folgendem+Link+wieder+l%C3%B6schen+%28Vorsicht%2C+es+erfolgt+keine+Nachfrage%29%3A%0D%0A%23REMOVE%23%22%3Bs%3A13%3A%22Freischaltung%22%3Bs%3A75%3A%22Der+Beitrag+wird+Freigeschaltet%2C+wenn+Sie+die+erhaltene+E-Mail+best%C3%A4tigen.%22%3Bs%3A16%3A%22Eintragexistiert%22%3Bs%3A33%3A%22Dieser+Eintrag+existiert+bereits.%22%3Bs%3A16%3A%22Eintraggeloescht%22%3Bs%3A33%3A%22Ihr+Eintrag+ist+gel%C3%B6scht+worden.%22%3Bs%3A20%3A%22Eintragnichtgefunden%22%3Bs%3A100%3A%22Ihr+Eintrag+konnte+in+der+Datenbank+nicht+gefunden+werden%2C+vielleicht+ist+er+schon+gel%C3%B6scht+worden.%22%3Bs%3A18%3A%22Eintragbeantwortet%22%3Bs%3A92%3A%22Auf+Ihren+Eintrag+ist+schon+geantwortet+worden%2C+er+kann+leider+nicht+mehr+gel%EF%BF%BDscht+werden.%22%3Bs%3A10%3A%22Bestaetigt%22%3Bs%3A20%3A%22Best%C3%A4tigter+Eintrag%22%3Bs%3A11%3A%22Eineantwort%22%3Bs%3A12%3A%22Eine+Antwort%22%3Bs%3A17%3A%22Emailantwort_text%22%3Bs%3A203%3A%22Auf+Den+Eintrag+%22%23TITEL%23%22+ist+geantwortet+worden.%0D%0A%0D%0AHier+k%C3%B6nnen+Sie+die+Eintr%C3%A4ge+ansehen%3A%0D%0A%23THREAD%23%0D%0A%0D%0A---%0D%0AWenn+Sie+keine+Benachrichtigungen+mehr+w%C3%BCnschen%2Cbenutzen+Sie+bitte+folgenden+Link%0D%0A%23NOMAIL%23%22%3Bs%3A14%3A%22Freigeschaltet%22%3Bs%3A37%3A%22Der+Beitrag+ist+jetzt+freigeschaltet.%22%3Bs%3A19%3A%22Schonfreigeschaltet%22%3Bs%3A81%3A%22Ihr+Beitrag+konnte+leider+nicht+gefunden+werden%2C+oder+ist+bereits+freigeschaltet.%22%3Bs%3A21%3A%22Keinebenachrichtigung%22%3Bs%3A97%3A%22Sie+erhalten%2C+bei+neuen+Eintr%C3%A4gen+in+diesem+Diskussionsstrang%2C+keine+Benachrichtigungungen+mehr.%22%3B%7D", "NAME,EMAIL,TITEL,NACHRICHT", "1", "1", "Name", "2010-11-19", "0000-00-00"),
("0", "PAGE_NEW", "3", "a%3A41%3A%7Bs%3A7%3A%22Zurueck%22%3Bs%3A4%3A%22back%22%3Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A16%3A%22Veroeffentlichen%22%3Bs%3A14%3A%22publish+e-mail%22%3Bs%3A5%3A%22Titel%22%3Bs%3A5%3A%22Title%22%3Bs%3A9%3A%22Nachricht%22%3Bs%3A5%3A%22Entry%22%3Bs%3A4%3A%22Fett%22%3Bs%3A4%3A%22Bold%22%3Bs%3A13%3A%22Unterstrichen%22%3Bs%3A9%3A%22Underline%22%3Bs%3A7%3A%22Schraeg%22%3Bs%3A6%3A%22Italic%22%3Bs%3A11%3A%22Bildauswahl%22%3Bs%3A10%3A%22Add+images%22%3Bs%3A13%3A%22Weiterebilder%22%3Bs%3A11%3A%22more+images%22%3Bs%3A8%3A%22Bildzahl%22%3Bs%3A16%3A%227+imags+maximum.%22%3Bs%3A16%3A%22Benachrichtigung%22%3Bs%3A25%3A%22Send+e-mail+when+answered%22%3Bs%3A19%3A%22Nutzungsbedingungen%22%3Bs%3A24%3A%22I%27ve+read+the+disclaimer%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A6%3A%22Submit%22%3Bs%3A13%3A%22Zuruecksetzen%22%3Bs%3A5%3A%22Reset%22%3Bs%3A9%3A%22Info_text%22%3Bs%3A74%3A%22Nach+dem+Absenden+erhalten+Sie+eine+E-Mail%2C+um+den+Beitrag+freizuschalten.%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A43%3A%22%2A+Diese+Felder+bitte+unbedingt+ausf%EF%BF%BDllen.%22%3Bs%3A9%3A%22Antworten%22%3Bs%3A9%3A%22Antworten%22%3Bs%3A15%3A%22Kontaktformular%22%3Bs%3A17%3A%22Kontakt+aufnehmen%22%3Bs%3A19%3A%22Keinekategorie_text%22%3Bs%3A92%3A%22Sie+haben+leider+keine+Kategorie+ausgew%EF%BF%BDhlt+in+die+Sie+Ihren+Eintrag+einstellen+m%EF%BF%BDchten.%22%3Bs%3A18%3A%22Nichtgefunden_text%22%3Bs%3A187%3A%22Die+Nachricht%2C+auf+die+Sie+antworten+m%EF%BF%BDchten%2C+konnte+nicht+gefunden+werden.+%28Vielleicht+ist+sie+bereits+gel%EF%BF%BDscht+worden+und+die+alte+Seite+befand+sich+noch+in+Ihrem+Zwischenspeicher%29.%22%3Bs%3A10%3A%22Antwortauf%22%3Bs%3A11%3A%22Antwort+auf%22%3Bs%3A12%3A%22Neuereintrag%22%3Bs%3A13%3A%22Neuer+Eintrag%22%3Bs%3A19%3A%22Keineeintraege_text%22%3Bs%3A30%3A%22Leider+keine+Eintr%EF%BF%BDge.+%5Bsad%5D%22%3Bs%3A20%3A%22Keineeintraegedetail%22%3Bs%3A25%3A%22Keine+Eintr%EF%BF%BDge+gefunden%22%3Bs%3A18%3A%22Nochkeineeintraege%22%3Bs%3A31%3A%22Noch+keine+Eintr%EF%BF%BDge+vorhanden%22%3Bs%3A25%3A%22Fehlernutzungsbedingungen%22%3Bs%3A109%3A%22Wenn+Sie+unsere+Nutzungsbedingunen+nicht+akzepieren%2C+k%EF%BF%BDnnen+wir+den+Eintrag+leider+nicht+ver%EF%BF%BDffentlichen.%22%3Bs%3A24%3A%22Fehlertextformatierungen%22%3Bs%3A42%3A%22Bitte+pr%EF%BF%BDfen+Sie+die+Textformatierungen.%22%3Bs%3A11%3A%22Fehlersonst%22%3Bs%3A77%3A%22Ihr+Eintrag+konnte+auf+Grund+eines+Datenbankfehlers+nicht+gespeichert+werden.%22%3Bs%3A17%3A%22Emaileintrag_text%22%3Bs%3A424%3A%22Danke+f%EF%BF%BDr+Ihren+Eintrag+im+Forum%2C+%23NAME%23.%0D%0A%0D%0AIhre+Nachricht%3A%0D%0A%23TITEL%23%0D%0A%0D%0A%23TEXT%23%0D%0A%0D%0A---%0D%0AHier+k%EF%BF%BDnnen+Sie+Ihren+Eintrag+ansehen%2C+sobald+er+freigeschaltet+wurde%3A%0D%0A%23THREAD%23%0D%0A%0D%0A---%0D%0ADer+Beitrag+wird+mit+folgendem+Link+freigeschaltet%3A%0D%0A%23VERIFY%23%0D%0A%0D%0A---%0D%0ASolange+keine+Antworten+auf+Ihre+Nachricht+eingegangen+sind%2C+k%EF%BF%BDnnen+Sie+Ihren+Eintrag+mit+folgendem+Link+wieder+l%EF%BF%BDschen+%28Vorsicht%2C+es+erfolgt+keine+Nachfrage%29%3A%0D%0A%23REMOVE%23%22%3Bs%3A13%3A%22Freischaltung%22%3Bs%3A76%3A%22Der+Beitrag+wird+Freigeschaltet%2C+wenn+Sie+die+erhaltene+E-mail+best%EF%BF%BDtigen.%22%3Bs%3A16%3A%22Eintragexistiert%22%3Bs%3A33%3A%22Dieser+Eintrag+existiert+bereits.%22%3Bs%3A16%3A%22Eintraggeloescht%22%3Bs%3A34%3A%22Ihr+Eintrag+ist+gel%EF%BF%BDscht+worden.%22%3Bs%3A20%3A%22Eintragnichtgefunden%22%3Bs%3A101%3A%22Ihr+Eintrag+konnte+in+der+Datenbank+nicht+gefunden+werden%2C+vielleicht+ist+er+schon+gel%EF%BF%BDscht+worden.%22%3Bs%3A18%3A%22Eintragbeantwortet%22%3Bs%3A92%3A%22Auf+Ihren+Eintrag+ist+schon+geantwortet+worden%2C+er+kann+leider+nicht+mehr+gel%EF%BF%BDscht+werden.%22%3Bs%3A10%3A%22Bestaetigt%22%3Bs%3A21%3A%22Best%EF%BF%BDtigter+Eintrag%22%3Bs%3A11%3A%22Eineantwort%22%3Bs%3A12%3A%22Eine+Antwort%22%3Bs%3A17%3A%22Emailantwort_text%22%3Bs%3A106%3A%22Auf+Ihren+Eintrag+%22%23TITEL%23%22+ist+geantwortet+worden.%0D%0A%0D%0AHier+k%EF%BF%BDnnen+Sie+die+Eintr%EF%BF%BDge+ansehen%3A%0D%0A%23THREAD%23%22%3Bs%3A14%3A%22Freigeschaltet%22%3Bs%3A37%3A%22Der+Beitrag+ist+jetzt+freigeschaltet.%22%3Bs%3A19%3A%22Schonfreigeschaltet%22%3Bs%3A81%3A%22Ihr+Beitrag+konnte+leider+nicht+gefunden+werden%2C+oder+ist+bereits+freigeschaltet.%22%3B%7D", "NAME,EMAIL,TITEL,NACHRICHT", "1", "1", "back", "2010-11-19", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --
