-- IMPORT AS NEW--

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`,`cache`,`stats`) VALUES
("10", "Newsletter", "", "§NEWSLETTER§
<form action=\"\" method=\"post\">
    <p><label for=\"newsletter\" style=\"margin:3px .5em 0 0;\">%NAME%:
        <input name=\"newsletter[name]\" id=\"name\"   value=\"#NAME#\" /></label><label for=\"newsletter\" style=\"margin:3px .5em 0 0;\">%EMAIL%:
       <input name=\"newsletter[email]\" id=\"email\" value=\"#EMAIL#\" /></label>
        <br />
        <input type=\"submit\" class=\"submit\" name=\"submit[newsletter][ein]\" title=\"%ABONNIEREN%\" value=\"%EINTRAGEN%\" />
        <input type=\"submit\" class=\"submit\" name=\"submit[newsletter][aus]\" title=\"%ABBESTELLEN%\" value=\"%AUSTRAGEN%\" /> 
      <br /><br />
      §PFLICHTFELD§ %PFLICHTFELDER% </p> 
</form>


 <!-- SUB=html --><html><head>
<style type=\"text/css\">
  body {font-family: Verdana, sans-serif;}
</style>
</head><body>
#TEXT#
<div class=\"footer\" style=\"clear:both;\">%ABBINDER_FCK%</div>
</body></html><!-- /SUB -->

<!-- SUB=plain -->
#TEXT#

---
%ABBINDER_FCK%<!-- /SUB -->

<!-- SUB=nl_betreff -->%BETREFF%<!-- /SUB -->
<!-- SUB=nl_body -->%BESTAETIGUNGSMAIL_FCK%<!-- /SUB -->
<!-- SUB=bestaetigung -->%BESTAETIGUNG%<!-- /SUB -->
<!-- SUB=danke -->%DANKE%<!-- /SUB -->
<!-- SUB=schonvorhanden -->%SCHONVORHANDEN%<!-- /SUB -->
<!-- SUB=geloescht -->%GELOESCHT%<!-- /SUB -->
<!-- SUB=nichtgefunden -->%NICHTGEFUNDEN%<!-- /SUB -->", "", "", "", "", "1", "0", "0", "1", "0", "0", "0", "0", "fit", "fit", "1", "1");
-- # /DUMP # --

-- # Schnipp --


-- # DUMP=seiten_attr:138 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`order_by`,`person_ID`,`position`,`visibility`,`status`,`lft`,`rgt`) VALUES
("2", "TPL_NEW", "0", "PO_ASC", "10", "12", "1", "0", "45", "46");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=seiten:138 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "10", "Newsletter", "Newsletter", "Newsletter", "Newsletter", "", "<p>§BRIDGE§</p>
<h4>Newsletter bestellen / abbestellen:</h4>
<p>Möchten Sie auf dem laufenden bleiben und über aktuelle Entwicklungen mit einem HTML-Newsletter informiert werden, dann tragen Sie Ihr E-mail-Adresse hier ein.</p>", "Möchten Sie auf dem laufenden bleiben und über aktuelle Entwicklungen mit einem HTML-Newsletter informiert werden, dann tragen Sie Ihr E-mail-Adresse hier ein.", "2010-11-16 00:00:00", "2013-08-21 08:40:18", "0");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=abschnitte:138 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "PAGE_NEW", "1", "a%3A15%3A%7Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A10%3A%22Abonnieren%22%3Bs%3A10%3A%22Abonnieren%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A9%3A%22Eintragen%22%3Bs%3A11%3A%22Abbestellen%22%3Bs%3A11%3A%22Abbestellen%22%3Bs%3A9%3A%22Austragen%22%3Bs%3A9%3A%22Austragen%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A12%3A%22Abbinder_fck%22%3Bs%3A328%3A%22%3Cp%3E---%3Cbr+%2F%3E%0D%0A%3Cstrong%3E%A7FIRMA%A7%3C%2Fstrong%3E%3Cbr+%2F%3E%0D%0A%3Cbr+%2F%3E%0D%0A%A7WWW2%A7%2C+%A7EMAIL2%A7%3Cbr+%2F%3E%0D%0ATel.%3A+%A7TELEFON%A7%3C%2Fp%3E%0D%0A%3Cp%3ESie+erhalten+den+Newsletter%2C+weil+Ihre+E-Mail-Adresse+f%FCr+den+Bezug+eingetragen+wurde.%3Cbr+%2F%3E%0D%0AFalls+Sie+ihn+abbestellen+m%F6chten%2C+tragen+Sie+Ihre+E-Mail-Adresse+bitte+hier+aus%3A%3Cbr+%2F%3E%0D%0A%3Ca+href%3D%22%23LINKTO%3A138%23%22%3E%23LINKTO%3A138%23%3C%2Fa%3E%3C%2Fp%3E%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A18%3A%22Ihre+Registrierung%22%3Bs%3A21%3A%22Bestaetigungsmail_fck%22%3Bs%3A679%3A%22%3Cp%3EHallo%2C%3Cbr+%2F%3E%0D%0A%3Cbr+%2F%3E%0D%0Aich+freue+mich%2C+dass+Sie+unseren+Newsletter+beziehen+m%F6chten.%3C%2Fp%3E%0D%0A%3Cp%3EUm+sicher+zu+gehen%2C+dass+Ihre+E-Mail-Adresse+von+Ihnen+selbst+eingetragen+wurde%2C+klicken+Sie+bitte+auf+folgenden+Link+oder+kopieren+ihn+in+Ihren+Browser.+Mit+dem+Klick+erkl%E4ren+Sie+sich+einverstanden%2C+dass+wir+ihre+E-Mail+nutzen+um+Ihnen+Aktuelle+Informationen+rund+um+%A7FIRMA%A7+zukommen+zu+lassen%2C+wir+geben+Ihre+Daten+nicht+an+dritte+weiter%3A%3A%3Cbr+%2F%3E%0D%0A%3Ca+href%3D%22%23LINKTO%3Apage_id%23%2F%26bestaetigung%3D%23PHRASE%23%22%3E%23LINKTO%3Apage_id%23%2F%26amp%3Bbestaetigung%3D%23PHRASE%23%3C%2Fa%3E%3C%2Fp%3E%0D%0A%3Cp%3EWenn+Sie+den+Newsletter+nicht+erhalten+m%F6chten%2C+brauchen+Sie+nichts+zu+tun.+Ihre+E-Mail-Adresse+wird+dann+in+K%FCrze+gel%F6scht.%3C%2Fp%3E%22%3Bs%3A12%3A%22Bestaetigung%22%3Bs%3A83%3A%22Sie+erhalten+in+K%FCrze+eine+E-Mail.+Bitte+klicken+Sie+dort+auf+den+angegebenen+Link.%22%3Bs%3A5%3A%22Danke%22%3Bs%3A42%3A%22Danke%2C+Ihre+Best%E4tigung+wurde+registriert.%22%3Bs%3A14%3A%22Schonvorhanden%22%3Bs%3A59%3A%22Sie+sind+f%FCr+den+Bezug+des+Newsletters+bereits+eingetragen.%22%3Bs%3A9%3A%22Geloescht%22%3Bs%3A35%3A%22Ihre+E-Mail-Adresse+wurde+gel%F6scht.%22%3Bs%3A13%3A%22Nichtgefunden%22%3Bs%3A56%3A%22Ihre+E-Mail-Adresse+konnte+leider+nicht+gefunden+werden.%22%3B%7D", "EMAIL", "99", "1", "E-Mail", "2010-08-13", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --
