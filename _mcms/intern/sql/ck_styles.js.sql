-- IMPORT AS NEW--

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("27", "ck_styles.js", "", "<!-- SUB=main_tpl -->/**
 * Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// This file contains style definitions that can be used by CKEditor plugins.
//
// The most common use for it is the \"stylescombo\" plugin, which shows a combo
// in the editor toolbar, containing all styles. Other plugins instead, like
// the div plugin, use a subset of the styles on their feature.
//
// If you don't have plugins that depend on this file, you can simply ignore it.
// Otherwise it is strongly recommended to customize this file to match your
// website requirements and design properly.

CKEDITOR.stylesSet.add( '%STYLESET%', [

  /* Inline Styles */
%INLINESTYLES_RAW%,


  /* Object Styles */
%OBJECTSTYLES_RAW%,

]);<!-- /SUB -->
<!-- SUB=Content-type -->text/javascript<!-- /SUB -->", "", "", "", "", "1", "0", "0", "1", "1", "0", "0", "0", "0", "0", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --


-- # DUMP=seiten_attr:110 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("3", "TPL_NEW", "0", "2", "9", "PO_ASC", "1", "0", "75", "76");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=seiten:110 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "CK Styles", "", "ck_styles", "styles.js", "", "<h3><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
&nbsp;</h3>
", "", "2011-01-14 00:00:00", "2013-12-17 15:34:51", "1"),
("PAGE_NEW", "3", "2", "myfckstyles.xml", "", "myfckstyles.xml", "myfckstyles.xml", "m", "<h3><br />
&#160;</h3>", "", "2012-08-06 00:00:00", "2012-08-06 15:15:20", "0");
-- # /DUMP # --

-- # Schnipp --
-- # DUMP=abschnitte:110 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("1", "PAGE_NEW", "1", "a%3A3%3A%7Bs%3A8%3A%22Styleset%22%3Bs%3A6%3A%22styles%22%3Bs%3A16%3A%22Inlinestyles_raw%22%3Bs%3A285%3A%22%7B+name%3A+%27Gro%C3%9F%27%2C%09element%3A+%27span%27%2C+attributes%3A+%7B+%27class%27%3A+%27gross%27+%7D+%7D%2C%0D%0A%7B+name%3A+%27Klein%27%2C%09element%3A+%27span%27%2C+attributes%3A+%7B+%27class%27%3A+%27klein%27+%7D+%7D%2C%0D%0A%7B+name%3A+%27Links%27%2C%09element%3A+%27div%27%2C++++attributes%3A+%7B+%27class%27%3A+%27left%27+%7D+%7D%2C%0D%0A%7B+name%3A+%27Rechts%27%2C%09element%3A+%27div%27%2C++++attributes%3A+%7B+%27class%27%3A+%27right%27+%7D+%7D%22%3Bs%3A16%3A%22Objectstyles_raw%22%3Bs%3A149%3A%22%7B+name%3A+%27Bild+links%27%2C+++element%3A+%27img%27%2C+attributes%3A+%7B+%27class%27%3A+%27left%27+%7D+%7D%2C%0D%0A%7B+name%3A+%27Bild+rechts%27%2C+element%3A+%27img%27%2C+attributes%3A+%7B+%27class%27%3A+%27right%27+%7D+%7D%22%3B%7D", "", "99", "1", "styles", "2011-01-14", "0000-00-00"),
("1", "PAGE_NEW", "3", "a%3A2%3A%7Bs%3A16%3A%22Inlinestyles_raw%22%3Bs%3A580%3A%22%3CStyle+name%3D%5C%22Without+Stil%5C%22+element%3D%5C%22p%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Big%5C%22+element%3D%5C%22span%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22big%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Small%5C%22+element%3D%5C%22span%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22small%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Right%5C%22+element%3D%5C%22div%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22rechts%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Center%5C%22+element%3D%5C%22div%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22center%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Left%5C%22+element%3D%5C%22div%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22links%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%22%3Bs%3A16%3A%22Objectstyles_raw%22%3Bs%3A623%3A%22%3CStyle+name%3D%5C%22Image+left%5C%22+element%3D%5C%22img%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22left%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Image+right%5C%22+element%3D%5C%22img%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22right%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Image+far+right%5C%22+element%3D%5C%22img%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22farright%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Image+centered%5C%22+element%3D%5C%22img%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22center%5C%22+%2F%3E%0D%0A%09%3CAttribute+name%3D%5C%22align%5C%22+value%3D%5C%22center%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%0D%0A%3CStyle+name%3D%5C%22Image+within+text%5C%22+element%3D%5C%22img%5C%22%3E%0D%0A%09%3CAttribute+name%3D%5C%22class%5C%22+value%3D%5C%22none%5C%22+%2F%3E%0D%0A%09%3CAttribute+name%3D%5C%22align%5C%22+value%3D%5C%22middle%5C%22+%2F%3E%0D%0A%3C%2FStyle%3E%22%3B%7D", "", "99", "1", "1", "2011-01-14", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --