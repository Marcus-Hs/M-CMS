-- IMPORT AS NEW--
-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`neu`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`,`cache`,`stats`) VALUES
("8", "alle Seiten", "", "<!-- SUB=headline --><div id=\"headline\">
<a id=\"top\" href=\"#LINKTO:1#\" ><span>§FIRMA§</span></a>
<p id=\"access\">%SPRINGE% <a href=\"#inhalt\">%ZUMINHALT%</a> §ODER§ <a href=\"#menu\">%ZUMMENUE%</a>.</p>
<div id=\"address\" class=\"vcard\">
  <p><span  class=\"org\">§FIRMA§</span><br />
    <span  class=\"fn n\">§NAME§</span><br />
    <span class=\"adr\">
      <span  class=\"street-address\">§STRASSE§</span><br />
      <span class=\"locality\">§ORT§</span>
    </span><br /><br />
    %TEL% <span  class=\"tel\">§TELEFON§</span><br />
    %MOBIL%: <span  class=\"tel\">§MOBIL§</span><br />
    %WEB%: <span  class=\"url\">§WWW§</span><br />
    %EMAIL%: <a style=\"float:none\" href=\"mailto:§EMAIL§\" class=\"email\">§EMAIL§</a></p>
</div>
</div><!-- /SUB -->
<!-- SUB=titleprefix -->%TITELPREFIX%<!-- /SUB --> 
<!-- SUB=descriptionprefix -->%DESCRIPTION%<!-- /SUB -->
<!-- SUB=keywordsprefix -->%KEYWORDS%<!-- /SUB -->

<!-- SUB=seitenvorlage --><h3>#UEBERSCHRIFT#</h3>
$ERROR$
§BILDER§
#TEXT#
#ABSCHNITT#<!-- /SUB -->

<!-- SUB=footer --><div id=\"footer\">§BREADCRUMBS§</div><!-- /SUB -->

<!-- SUB=bgimg -->style=\"background-image:url(#BGIMG#)\"<!-- /SUB -->
<!-- SUB=bridge --><div class=\"bridge\"><h4><a href=\"#LINKTO:$PAGE_ID$#\" title=\"$UEBERSCHRIFT$\">$TITEL$</a></h4><p>$BESCHREIBUNG$</p></div><!-- /SUB -->
<!-- SUB=list --><li><a href=\"#LINKTO:$PAGE_ID$#\" title=\"$UEBERSCHRIFT$\">$TITEL$</a></li><!-- /SUB -->

<!-- SUB=googlemap --><div class=\"googlemap\">
<iframe width=\"%KARTENBREITE%\" height=\"%KARTENHOEHE%\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"http://maps.google.de/maps?f=q&source=s_q&hl=en&geocode=&q=#DATA#&output=embed&iwloc=\"></iframe>
<br /><small><a href=\"http://maps.google.de/maps?f=q&source=s_q&hl=en&geocode=&q=#DATA#\" class=\"flr\" target=\"_blank\">%GROSSEKARTE%</a></small>
<br /></div><!-- /SUB -->

<!-- SUB=voriges -->%VORIGES%<!-- /SUB -->
<!-- SUB=folgendes -->%FOLGENDES%<!-- /SUB -->
<!-- SUB=und -->%UND%<!-- /SUB -->
<!-- SUB=oder -->%ODER%<!-- /SUB -->

<!-- SUB=pflichtfeld --><span class=\"error\">%PFLICHT%</span><!-- /SUB -->
<!-- SUB=bgimg -->style=\"background-image:url(/#BGIMG#)\"<!-- /SUB -->

<!-- SUB=menublock --><ul class=\"menu\" id=\"$ID$\">$ENTRIES$</ul><!-- /SUB -->
<!-- SUB=menuentry -->    <li class=\"§ACTIVE:$PAGE_ID$§\"><a href=\"/$PATH$§SID§\" accesskey=\"$AK$\" title=\"$BESCHREIBUNG$\">$MENU$</a>§SUBMENU:$PAGE_ID$§</li><!-- /SUB -->
<!-- SUB=languageblock --><ul class=\"sprachen\">$ENTRIES$</ul><!-- /SUB -->
<!-- SUB=languageentry -->      <li><a href=\"#LINK#§SID§\" id=\"$SHORT$\" class=\"$DIRECTION$\">$LANG_LOCAL$</a></li><!-- /SUB -->
", "", "", "", "", "1", "0", "0", "0", "0", "0", "0", "fit", "fit", "0", "0");
-- # /DUMP # --

-- # Schnipp --

-- # DUMP=seiten_attr:76 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`order_by`,`person_ID`,`position`,`visibility`,`status`,`lft`,`rgt`) VALUES
("4", "TPL_NEW", "0", "PO_ASC", "10", "11", "1", "0", "36", "37");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:76 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "10", "alle Seiten", "alle Seiten", "alle_Seiten", "alle Seiten", "", "&lt;p&gt;Hier stehen Daten, die alle Seiten betreffen, aber die Seite selbst wir nicht angezeigt.&amp;nbsp;&lt;/p&gt;", "alle Seiten", "2010-09-28 00:00:00", "2011-04-19 07:34:37", "0");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=abschnitte:76 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "PAGE_NEW", "1", "a%3A19%3A%7Bs%3A7%3A%22Springe%22%3Bs%3A7%3A%22Springe%22%3Bs%3A9%3A%22Zuminhalt%22%3Bs%3A10%3A%22zum+Inhalt%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A8%3A%22zum+Men%FC%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A3%3A%22Web%22%3Bs%3A3%3A%22Web%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A12%3A%22Balken_farbe%22%3Bs%3A7%3A%22%23ececec%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A7%3A%22%A7FIRMA%A7%22%3Bs%3A11%3A%22Description%22%3Bs%3A7%3A%22%A7FIRMA%A7%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A7%3A%22%A7FIRMA%A7%22%3Bs%3A12%3A%22Kartenbreite%22%3Bs%3A3%3A%22350%22%3Bs%3A11%3A%22Kartenhoehe%22%3Bs%3A3%3A%22300%22%3Bs%3A11%3A%22Grossekarte%22%3Bs%3A11%3A%22Gro%DFe+karte%22%3Bs%3A7%3A%22Voriges%22%3Bs%3A1%3A%22%3C%22%3Bs%3A9%3A%22Folgendes%22%3Bs%3A1%3A%22%3E%22%3Bs%3A3%3A%22Und%22%3Bs%3A5%3A%22+und+%22%3Bs%3A4%3A%22Oder%22%3Bs%3A6%3A%22+oder+%22%3Bs%3A7%3A%22Pflicht%22%3Bs%3A2%3A%22+%2A%22%3B%7D", "", "99", "1", "Springe", "2010-09-10", "0000-00-00"),
("0", "PAGE_NEW", "3", "a%3A15%3A%7Bs%3A8%3A%22Headline%22%3Bs%3A5%3A%22m-cms%22%3Bs%3A9%3A%22Zuminhalt%22%3Bs%3A10%3A%22to+content%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A7%3A%22to+menu%22%3Bs%3A11%3A%22Slogan_text%22%3Bs%3A82%3A%22Individualized+Content%0D%0AManagment+Systems+and%0D%0ADatabase+Applications+%0D%0Afrom+Bremen%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A6%3A%22Mobile%22%3Bs%3A3%3A%22Web%22%3Bs%3A3%3A%22Web%22%3Bs%3A5%3A%22Email%22%3Bs%3A5%3A%22Email%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A34%3A%22M-CMS+by+Webdesign+Haas%2C+Bremen+-+%22%3Bs%3A11%3A%22Description%22%3Bs%3A7%3A%22M-CMS%3A+%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A24%3A%22M-CMS%2C+Webdesign%2C+Bremen%22%3Bs%3A3%3A%22Und%22%3Bs%3A5%3A%22+and+%22%3Bs%3A4%3A%22Oder%22%3Bs%3A4%3A%22+or+%22%3Bs%3A12%3A%22Pflicht_text%22%3Bs%3A25%3A%22%5Bcolor%3D%23aa0033%5D+%2A%5B%2Fcolor%5D%22%3Bs%3A10%3A%22Footer_raw%22%3Bs%3A434%3A%22%3Cp%3E%0D%0A++++%3Ca+href%3D%5C%22http%3A%2F%2Fjigsaw.w3.org%2Fcss-validator%2Fcheck%2Freferer%5C%22%3E%0D%0A++++++++%3Cimg+style%3D%5C%22border%3A0%3Bwidth%3A88px%3Bheight%3A31px%5C%22%0D%0A++++++++++++src%3D%5C%22http%3A%2F%2Fjigsaw.w3.org%2Fcss-validator%2Fimages%2Fvcss%5C%22%0D%0A++++++++++++alt%3D%5C%22Valid+CSS%21%5C%22+%2F%3E%3C%2Fa%3E%0D%0A++++%3Ca+href%3D%5C%22http%3A%2F%2Fvalidator.w3.org%2Fcheck%3Furi%3Dreferer%5C%22%3E%3Cimg%0D%0A++++++++src%3D%5C%22http%3A%2F%2Fwww.w3.org%2FIcons%2Fvalid-xhtml10%5C%22%0D%0A++++++++alt%3D%5C%22Valid+XHTML+1.0+Strict%5C%22+height%3D%5C%2231%5C%22+width%3D%5C%2288%5C%22+%2F%3E%3C%2Fa%3E%0D%0A++%3C%2Fp%3E%22%3B%7D", "", "99", "1", "m-cms", "2010-09-10", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --

