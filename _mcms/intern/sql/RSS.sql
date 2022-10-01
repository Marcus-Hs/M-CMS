-- IMPORT AS NEW--

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`,`cache`,`stats`) VALUES
("11", "RSS", "", "<!-- SUB=main_tpl --><?xml version=\"1.0\" encoding=\"§CODEPAGE§\"?>
<?xml-stylesheet type=\"text/css\" href=\"§ABLINKNOSID:rss.css§\" ?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">
  <channel>
    <title>§TITLE§</title>
    <description>§DESCRIPTION§</description>
    <language>§LANG§</language>
    <copyright>Copyright §YEAR§ §FIRMA§, §WWW§</copyright>
    <link>§ABLINKNOSID:home§</link> 
    <atom:link href=\"§ABLINKNOSID:page_id§\" rel=\"self\" type=\"application/rss+xml\" /> 
    §BRIDGE:TPL_ID=68;template=texts;limit=5;date=2013-01;nochache=1;visibility=0§
  </channel>
</rss><!-- /SUB -->
 
<!-- SUB=texts --><item>
    <title><![CDATA[
$TITEL$, $BESCHREIBUNG$
     ]]> </title>
    <description><![CDATA[  
§FETCHIMAGE:PAGE_ID=$PAGE_ID$;limit=1;avisi=1;set=absolute§ 
$TEXT$
]]></description>
    <link>§ABLINKNOSID:$PAGE_ID$§</link>
    <pubDate>$INSDATE$</pubDate> 
    <guid>§ABLINKNOSID:$PAGE_ID$§</guid>
    <category><![CDATA[
§FIRMA§ - $TITEL$ 
]]></category> 
  </item><!-- /SUB -->

<!-- SUB=Content-type -->text/xml<!-- /SUB -->
<!-- SUB=img --><img align=\"right\" hspace=\"10\" src=\"$SRC$\" alt=\"\"><!-- /SUB -->", "", "", "", "", "0", "0", "0", "0", "250", "250", "500", "500", "fit", "fit", "0", "0");
-- # /DUMP # --

-- # Schnipp --


-- # DUMP=seiten_attr:2 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`order_by`,`person_ID`,`position`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "1", "", "2", "99", "1", "0", "4", "5");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=seiten:2 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "RSS", "", "RSS", "RSS", "", "", "", "2013-08-20 00:00:00", "2013-08-20 17:16:09", "0");
-- # /DUMP # --

-- # Schnipp --