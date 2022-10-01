DROP TABLE IF EXISTS `#PREFIX#_cache`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_cache` (
  `PAGE_ID` mediumint(11) NOT NULL,
  `LANG_ID` mediumint(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `content` blob NOT NULL,
  PRIMARY KEY  (`LANG_ID`,`path`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --


DROP TABLE IF EXISTS `#PREFIX#_inuse`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_inuse` (
  `person_ID` mediumint(5) NOT NULL,
  `attr` varchar(15) NOT NULL,
  `attr_ID` mediumint(5) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  KEY `person_ID` (`person_ID`,`attr`,`attr_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --


DROP TABLE IF EXISTS `#PREFIX#_languages`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_languages` (
  `LANG_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `short` char(3) NOT NULL DEFAULT '',
  `domain` varchar(65) NOT NULL DEFAULT '',
  `lang_intl` varchar(255) NOT NULL DEFAULT '',
  `lang_local` varchar(255) NOT NULL DEFAULT '',
  `codepage` varchar(255) NOT NULL DEFAULT '',
  `direction` char(3) NOT NULL DEFAULT '',
  `position` smallint(3) NOT NULL DEFAULT '99',
  `visibility` smallint(1) DEFAULT '1',
  `UID` mediumint(5) NOT NULL,
  PRIMARY KEY  (`LANG_ID`),
  KEY `short` (`short`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=_languages # --
INSERT INTO `#PREFIX#_languages` (`LANG_ID`,`short`,`domain`,`lang_intl`,`lang_local`,`codepage`,`direction`,`position`,`visibility`,`UID`) VALUES
("1", "de", "", "german", "deutsch", "windows-1252", "ltr", "1", "1", "10"),
("3", "en", "", "english", "english", "windows-1252", "ltr", "2", "1", "10");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#_session`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_session` (
  `ID` smallint(5) NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `logindate` datetime NOT NULL,
  PRIMARY KEY  (`sessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=_session # --
INSERT INTO `#PREFIX#_session` (`ID`,`sessionID`,`IP`,`logindate`) VALUES ("#SUID#", "#PHPSESSID#", "#REMOTE_ADDR#", "2013-03-25 11:24:16");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#_translate`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_translate` (
  `LANG_ID` mediumint(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`LANG_ID`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=_translate # --
INSERT INTO `#PREFIX#_translate` (`LANG_ID`,`name`,`value`) VALUES
("1", "%ABC_ABSTEIGEND%", "A-Z absteigend"),
("1", "%ABC_AUFSTEIGEND%", "A-Z aufsteigend"),
("1", "%ABKUERZUNG%", "Abk�rzung"),
("1", "%ABMELDEN%", "Aus der Verwaltung Abmelden"),
("1", "%ABSCHNITT%", "Abschnitt"),
("1", "%ABSCHNITTE%", "Abschnitte"),
("1", "%ABSCHNITTIMPORT%", "Abschnittimport"),
("1", "%ABSCHNITT_ABSTEIGEND%", "Abschnitt absteigend"),
("1", "%ABSCHNITT_AUFSTEIGEND%", "Abschnitt aufsteigend"),
("1", "%ABSCHNITT_GELOESCHT%", "Der Abschnitt wurde entfernt"),
("1", "%ABSCHNITT_VERSCHOBEN%", "Abschnitt verschoben"),
("1", "%ABSENDERADRESSE_UNGUELTIG%", "Absenderadresse ung�ltig"),
("1", "%ACTIVE%", "Active"),
("1", "%ADRESSEN%", "Adressen"),
("1", "%ADRESSEN_AUSGEWAEHLT%", "Adressen ausgew�hlt"),
("1", "%ADRESSEN_GEAENDERT%", "Adressen ge�ndert"),
("1", "%ADRESSEN_GELOESCHT%", "Adressen gel�scht"),
("1", "%ADRESSEN_HINZUGEFUEGT%", "Adressen hinzugef�gt"),
("1", "%AENDERUNGEN_SIND_EINGETRAGEN%", "�nderungen sind eingetragen"),
("1", "%ALLE%", "Alle"),
("1", "%ALLES%", "Alles"),
("1", "%ALLE_AENDERN%", "Alle �ndern"),
("1", "%ALLE_AUSWAEHLEN%", "Alle ausw�hlen"),
("1", "%ALLE_SEITEN%", "Alle Seiten"),
("1", "%ALLE_SEITEN_DER_ERSTEN_EBENE%", "Alle Seiten der ersten Ebene anzeigen"),
("1", "%ALLE_SEITEN_DIESER_EBENE%", "Alle Seiten dieser Ebene anzeigen"),
("1", "%ALLE_SEITEN_DIESER_KATEGORIE%", "Alle Seiten dieser Kategorie anzeigen"),
("1", "%ALLE_SEITEN_WIE_IN_LETZTER_UEBERSICHT%", "Alle Seiten wie in letzter �bericht anzeigen"),
("1", "%ALLE_SPRACHEN_ZEIGEN%", "Alle Sprachen zeigen"),
("1", "%ALLE_THREADS%", "Alle Threads"),
("1", "%ALLE_WAEHLEN%", "Alle w�hlen"),
("1", "%ANGABEN_GESPEICHERT%", "Die Angaben sind gespeichert worden."),
("1", "%ANGABEN_UNVOLLSTAENDIG%", "Angaben unvollst�ndig"),
("1", "%ANHANG%", "Anhang"),
("1", "%ANLEGEN%", "Anlegen"),
("1", "%ANSEHEN_BEARBEITEN%", "Ansehen / Bearbeiten"),
("1", "%ANSPRECHPARTNER%", "Ansprechpartner"),
("1", "%ANZAHL%", "Anzahl"),
("1", "%ANZEIGEN%", "Anzeigen"),
("1", "%APRIL%", "April"),
("1", "%AUFRAEUMEN%", "Aufr�umen"),
("1", "%AUGUST%", "August"),
("1", "%AUSBLENDEN%", "Ausblenden"),
("1", "%AUSFUEHREN%", "Ausf�hren"),
("1", "%AUSGABEOPTIONEN%", "Ausgabeoptionen"),
("1", "%AUSWAHL%", "Auswahl"),
("1", "%AUSWAHL_LOESCHEN%", "Auswahl l�schen"),
("1", "%AUSWAHL_NICHT_MOEGLICH%", "Auswahl nicht m�glich"),
("1", "%AUTOMATISCH_UEBERSETZEN%", "Automatisch �bersetzen"),
("1", "%AUTOR%", "Autor"),
("1", "%BEARBEITEN%", "Bearbeiten"),
("1", "%BENUTZER%", "Benutzer"),
("1", "%BENUTZERVERWALTUNG%", "Benutzerverwaltung"),
("1", "%BERECHTIGUNGEN%", "Berechtigungen"),
("1", "%BESCHREIBUNG%", "Beschreibung"),
("1", "%BESITZER%", "Besitzer"),
("1", "%BESONDERE_SEITEN%", "Besondere Seiten"),
("1", "%BETREFF%", "Betreff"),
("1", "%BETREFFANHANG%", "Betreffanhang"),
("1", "%BETRIFFT_ALLE_SPRACHEN%", "Betrifft alle Sprachen"),
("1", "%BILD%", "Bild"),
("1", "%BILDER%", "Bilder"),
("1", "%BILDLOESCHEN%", "Bild l�schen"),
("1", "%BILD_NUR_TEILWEISE%", "Beim Hochladen ist etwas schief gegangen:"),
("1", "%BILD_ZU_GROSS%", "Das Bild ist leider zu Gro�:"),
("1", "%BITTE_AUSWAEHLEN%", "Bitte ausw�hlen"),
("1", "%BLOECKE%", "Bl�cke"),
("1", "%BODYCLASS%", "BodyClass"),
("1", "%BODYID%", "BodyId"),
("1", "%BREITE%", "Breite"),
("1", "%CACHE%", "Cache"),
("1", "%COVER%", "Cover"),
("1", "%DATA_NICHT_AKZEPTIERT%", "Data nicht akzeptiert"),
("1", "%DATEIENDUNG_NICHT_ERLAUBT%", "Dateiendung nicht erlaubt"),
("1", "%DATEIMANAGER%", "Dateimanager"),
("1", "%DATEINAME%", "Dateiname"),
("1", "%DATEI_DURCH_DIESE_ERSETZEN%", "Vorhandene Datei durch diese ersetzen."),
("1", "%DATEI_EXISTIERT_BEREITS%", "Datei existiert bereits"),
("1", "%DATEI_GELOESCHT%", "Datei gel�scht"),
("1", "%DATEI_GESPEICHERT%", "Datei gespeichert"),
("1", "%DATEI_NICHT_GESPEICHERT%", "Datei nicht gespeichert"),
("1", "%DATEI_NICHT_HOCHLADEN%", "Datei doch nicht hochladen."),
("1", "%DATEI_OEFFNEN_FEHLER%", "Datei �ffnen Fehler"),
("1", "%DATEI_SEHR_GROSS%", "Die Datei sehr gro� (#SIZE#). Das Hochladen k�nnte einige Zeit in Anspruch nehmen. "),
("1", "%DATEI_UNGUELTIG%", "Datei ung�ltig"),
("1", "%DATEI_ZUGRIFF_FEHLER%", "Datei Zugriff Fehler"),
("1", "%DATEI_ZU_GROSS%", "Die Datei ist zu gro� (#SIZE#). Mehr als #ALLOWED# insgesamt werden vom Server nicht unterst�tzt."),
("1", "%DATEN%", "Daten"),
("1", "%DATENBANK_AUFRAEUMEN%", "Datenbank aufr�umen"),
("1", "%DATENBANK_OPTIMIEREN%", "Datenbank optimieren"),
("1", "%DATENBANK_RUNTERLADEN%", "Datenbank runterladen"),
("1", "%DATEN_WURDEN_GELOESCHT%", "Die Daten wurden gel�scht"),
("1", "%DATEN_WURDEN_GESPEICHERT%", "Ihre Daten wurden gespeichert."),
("1", "%DATUM%", "Datum"),
("1", "%DATUM_ABSTEIGEND%", "Datum absteigend"),
("1", "%DATUM_AUFSTEIGEND%", "Datum aufsteigend"),
("1", "%DATUM_PRUEFEN%", "Datum pr�fen"),
("1", "%DEZEMBER%", "Dezember"),
("1", "%DIENSTAG%", "Dienstag"),
("1", "%DIESE_SEITE_GIBT_ES_NICHT%", "Diese Seite gibt es leider nicht (mehr)."),
("1", "%DISKUSSIONSSTRANG_GESCHLOSSEN%", "Diskussionsstrang geschlossen"),
("1", "%DOMAIN_NICHT_ERREICHBAR%", "Die Domain ist nicht erreichbar"),
("1", "%DONNERSTAG%", "Donnerstag"),
("1", "%DOWNLOAD%", "Download"),
("1", "%DUMP%", "Dump"),
("1", "%EIGENE%", "Nur Eigene"),
("1", "%EINE_ZEILE_NACH_OBEN%", "Eine Zeile nach oben"),
("1", "%EINE_ZEILE_NACH_UNTEN%", "Eine Zeile nach unten"),
("1", "%EINFUEGEN%", "Einf�gen"),
("1", "%EINTRAEGE_BEARBEITET%", "Eintr�ge wurden bearbeitet"),
("1", "%EINTRAEGE_FINDEN%", "Eintr�ge finden"),
("1", "%EINTRAGEN%", "Eintragen"),
("1", "%EINTRAG_AENDERN%", "Eintrag �ndern"),
("1", "%EINTRAG_BEARBEITEN%", "Eintrag bearbeiten"),
("1", "%EINTRAG_KOMMENTIEREN%", "Eintrag kommentieren"),
("1", "%EMAIL%", "E-Mail"),
("1", "%EMAILFUNKTION_NICHT_AUSFUEHRBAR%", "Emailfunktion nicht ausf�hrbar"),
("1", "%EMAILS_ALS_LISTE%", "E-Mails als Liste"),
("1", "%EMAILS_AN_DIESE_EMPFAENGER%", "E-Mails an diese Empf�nger"),
("1", "%EMAILS_SIND_VERSANDT_WORDEN%", "E-Mails sind versandt worden"),
("1", "%EMAIL_ZEIGEN%", "E-Mail zeigen"),
("1", "%EMPFAENGER%", "Empf�nger"),
("1", "%EMPFAENGER_UNGUELTIG%", "Empf�nger ung�ltig"),
("1", "%ENDE_ABSTEIGEND%", "Ende absteigend"),
("1", "%ENDE_AUFSTEIGEND%", "Ende aufsteigend"),
("1", "%ENTFERNEN%", "Entfernen"),
("1", "%ERLAUBTE_DATEIENDUNGEN%", "Bitte laden Sie nur Dateien mit folgenden Dateiendungen hoch"),
("1", "%ERSCHEINT_IM_MENUE%", "Erscheint im Men�"),
("1", "%ERSTELLEN%", "Erstellen"),
("1", "%ERSTELLT_AM%", "Erstellt am"),
("1", "%EXPORT%", "Export"),
("1", "%FAX%", "Fax"),
("1", "%FCKEDITOR%", "FCKeditor"),
("1", "%FEBRUAR%", "Februar"),
("1", "%FEHLER%", "Fehler"),
("1", "%FENSTERTITEL%", "Fenstertitel, Popup im Menu, Betreff bei E-mails"),
("1", "%FENSTER_SCHLIESSEN%", "Fenster schlie�en"),
("1", "%FIRMA%", "Firma"),
("1", "%FIX%", "Fix"),
("1", "%FIXIERTE_SEITE%", "Fixierte Seite"),
("1", "%FLAGGE%", "Flagge"),
("1", "%FOLGE%", "Folge"),
("1", "%FOLGEJAHR%", "Folgejahr"),
("1", "%FOLGEMONAT%", "Folgemonat"),
("1", "%FOLGESEITE%", "Folgeseite"),
("1", "%FOLLOW%", "Follow"),
("1", "%FONTFORMATS%", "Font-Formate"),
("1", "%FORUM%", "Forum"),
("1", "%FORUMEINTRAG%", "Forumeintrag"),
("1", "%FORUMVORLAGE%", "Forumvorlage"),
("1", "%FREISCHALTEN%", "Freischalten"),
("1", "%FREITAG%", "Freitag"),
("1", "%FUER_MAIL_AUSWAEHLEN%", "F�r E-Mail ausw�hlen"),
("1", "%GAESTEBUCH%", "G�stebuch"),
("1", "%GAESTEBUCHSEITE%", "G�stebuchseite"),
("1", "%GAESTEBUCH_BEARBEITEN%", "G�stebuch bearbeiten"),
("1", "%GALERIEN%", "Galerien"),
("1", "%GANZ_SICHER%", "Sind Sie da ganz Sicher?"),
("1", "%GELOESCHT%", "Gel�scht"),
("1", "%GROESSENVORGABEN%", "Gr��envorgaben"),
("1", "%HEUTE%", "Heute"),
("1", "%HINTERGRUENDE%", "Hintergr�nde"),
("1", "%HINTERGRUND%", "Hintergrund"),
("1", "%HINTERGRUND2%", "Hintergrund2"),
("1", "%HOCHGELADEN%", "Hochgeladen"),
("1", "%HOCHGELADEN_FEHLGESCHLAGEN%", "Etwas ist beim Hochladen schief gegangen."),
("1", "%HOCHLADEN%", "Hochladen"),
("1", "%HOEHE%", "H�he"),
("1", "%HTTPSDOMAIN%", "Httpsdomain"),
("1", "%IMMER_ZEIGEN%", "Immer zeigen"),
("1", "%IMPORT%", "Import"),
("1", "%IMPORTIEREN%", "Importieren"),
("1", "%IMPRESSUM%", "Impressum"),
("1", "%INFO_STICHWORTE%", "Wichtige Stichworte sollten �fter vorkommen, sie werden hier gr��er angezeigt"),
("1", "%IN_BEARBEITUNG%", "In Bearbeitung"),
("1", "%IN_NEUEM_FENSTER_OEFFNEN%", "In neuem Fenster �ffnen"),
("1", "%IN_TEXT_EINFUEGEN%", "Dieses Bild in den Text einf�gen."),
("1", "%JANUAR%", "Januar"),
("1", "%JULI%", "Juli"),
("1", "%JUNI%", "Juni"),
("1", "%KALENDERSEITEN%", "Kalenderseiten"),
("1", "%KALENDERVORLAGE%", "Kalendervorlage"),
("1", "%KATEGAL%", "Unterseiten unabh�ngig von Kategorie im Men� anzeigen"),
("1", "%KATEGORIE%", "Kategorie"),
("1", "%KATEGORIEN%", "Kategorien"),
("1", "%KATEGORIEN_BEARBEITEN%", "Kategorien bearbeiten"),
("1", "%KATEGORIE_BEARBEITEN%", "Kategorie bearbeiten"),
("1", "%KATEGORIE_IST_ANGELEGT%", "Kategorie ist angelegt"),
("1", "%KATEGORIE_OHNE_TITEL%", "Ohne Titel kann die Kategorie nicht gespeichert werden."),
("1", "%KEINE%", "Keine"),
("1", "%KEINE_ABONNENTEN_GEWAEHLT%", "Keine Abonennten gew�hlt"),
("1", "%KEINE_AUTHENTIFIZIERUNG%", "Keine Authentifizierung"),
("1", "%KEINE_EINTRAEGE%", "Noch keine Eintr�ge im Forum"),
("1", "%KEINE_EINTRAEGE_GEFUNDEN%", "Keine Eintr�ge gefunden"),
("1", "%KEINE_EMAIL_ANGEGEBEN%", "Keine E-Mail angegeben"),
("1", "%KEINE_HTML_UNTERSEITEN%", "Keine HTML-Unterseiten"),
("1", "%KEINE_NACHRICHT%", "Keine Nachricht"),
("1", "%KEINE_NUM_UNTERSEITEN%", "Keine numerischen Unterseiten"),
("1", "%KEINE_VERBINDUNG_HOST%", "Keine Verbindung zum Mail-Host"),
("1", "%KEIN_EMPFAENGER_GEWAEHLT%", "Kein Empf�nger gew�hlt"),
("1", "%KLICK_TOGGLE%", "Anklicken zum ein-/ausblenden"),
("1", "%KOMMAGETRENNT%", "Durch Komma getrennt"),
("1", "%KOMMENTAR%", "Kommentar"),
("1", "%KOMPRIMIERUNG%", "Komprimierung"),
("1", "%KONFIGURATIONSOPTIONEN%", "weitere Konfigurationsoptionen (Vorlage, Kategorie, Unterseite)"),
("1", "%KONTAKT%", "Kontakt"),
("1", "%KONTAKTE_SPEICHERN%", "Kontakte speichern"),
("1", "%KONTAKTSEITE%", "Kontaktseite"),
("1", "%KOPIE%", "Kopie"),
("1", "%KOPIEREN%", "Kopieren"),
("1", "%KOPIE_VON%", "Kopie von"),
("1", "%LAND%", "Land"),
("1", "%LETZTE_GESPEICHERTE_VERSION%", "Letzte gespeicherte Version der Seite"),
("1", "%LINK_EINFUEGEN%", "Als Link einf�gen"),
("1", "%LOESCHEN%", "L�schen"),
("1", "%LOESCHEN_FEHLGESCHLAGEN%", "L�schen fehlgeschlagen"),
("1", "%LOESCHEN_ODER_ABBRECHEN%", "L�schen oder abbrechen (OK oder Cancel)"),
("1", "%LOGIN%", "Login"),
("1", "%LOGINSEITE%", "Loginseite"),
("1", "%LOGOUT%", "Logout"),
("1", "%LOGOUTSEITE%", "Logoutseite"),
("1", "%LOGOUT_IM_MENUE%", "Logout im Men� oben"),
("1", "%MAERZ%", "M�rz"),
("1", "%MAI%", "Mai"),
("1", "%MAIL%", "E-Mail"),
("1", "%MAILER_NICHT_UNTERSTUETZT%", "Mailer wird nicht unterst�tzt"),
("1", "%MARKIERUNGEN_ENTFERNEN%", "Markierungen entfernen"),
("1", "%MARKIERUNGEN_VON_BEGRIFFEN_ENTFERNEN%", "Markierungen von Begriffen entfernen."),
("1", "%MAXZEICHEN%", "Mehr als #MAXLENGTH# Zeichen sind nicht erlaubt."),
("1", "%MEHR%", "Mehr"),
("1", "%MELDUNGEN%", "Meldungen"),
("1", "%MENU%", "Men�"),
("1", "%MENUEBILD%", "Men�bild"),
("1", "%MENUEBILD2%", "Men�bild (hover)"),
("1", "%MENUEBILDER%", "Men�bilder"),
("1", "%MENUEEINTRAG%", "Men�eintrag"),
("1", "%MINDESTENS_SECHS_ZEICHEN%", "Das Passwort sollte Mindestens sechs Zeichen lang sein. Es darf Zahlen und Sonderzeichen enthalten."),
("1", "%MITTWOCH%", "Mittwoch"),
("1", "%MOBIL%", "Mobil"),
("1", "%MONTAG%", "Montag"),
("1", "%MYSQL%", "Mysql"),
("1", "%NACHBARSEITEN%", "Nachbarseiten"),
("1", "%NACHRICHT%", "Nachricht"),
("1", "%NACHRICHT_ANZEIGEN%", "Nachricht anzeigen"),
("1", "%NAME%", "Name"),
("1", "%NEU%", "Neu"),
("1", "%NEUER_ORDNER%", "Neuer Ordner"),
("1", "%NEUES_PASSWORT%", "Neues Passwort"),
("1", "%NEUE_ABSCHNITTE%", "Neue Abschnitte"),
("1", "%NEUE_DATEI%", "Neue Datei"),
("1", "%NEUE_KATEGORIE%", "Neue Kategorie"),
("1", "%NEUE_PERSON_ANLEGEN%", "Neue Person anlegen"),
("1", "%NEUE_SEITE%", "Neue Seite"),
("1", "%NEUE_SEITE_ANLEGEN%", "Neue Seite anlegen"),
("1", "%NEUE_SEITE_MIT_DIESEN_INHALTEN%", "Neue Seite mit diesen Inhalten"),
("1", "%NEUE_SEITE_NACH_DIESEM_VORBILD%", "Neue Seite nach diesem Vorbild"),
("1", "%NEUE_SPRACHE%", "Neue Sprache"),
("1", "%NEU_ANLEGEN%", "Neu anlegen"),
("1", "%NEU_LADEN%", "Neu laden"),
("1", "%NEWSLETTER%", "Newsletter"),
("1", "%NEWSLETTERVORLAGE%", "Newslettervorlage"),
("1", "%NEWSLETTERVORSCHAU%", "Newslettervorschau"),
("1", "%NEWSLETTER_%", "Newsletter "),
("1", "%NEWSLETTER_EINZELN_SENDEN%", "Newsletter einzeln senden"),
("1", "%NEWSLETTER_VERSANDT%", "Es wurden E-Mails versandt"),
("1", "%NEWSLETTER_VORSCHAU%", "Es w�ren E-Mails versandt worden"),
("1", "%NICHT_GELOESCHT%", "Diese Vorlage kann nicht entfernt werden."),
("1", "%NLEMAILVORLAGE%", "Newsletter E-Mail"),
("1", "%NOVEMBER%", "November"),
("1", "%NR%", "Nr"),
("1", "%NUR_AN_DIESE_EMPFAENGER%", "Nur an diese Empf�nger"),
("1", "%NUR_TEXT_EINFUEGEN%", "Nur Text einf�gen"),
("1", "%ODER_KATEGORIEN_LOESCHEN%", "Oder Kategorien l�schen"),
("1", "%ODER_VORLAGEN_LOESCHEN%", "oder Vorlagen l�schen"),
("1", "%OEFFNEN%", "�ffnen"),
("1", "%OHNE%", "ohne"),
("1", "%OKTOBER%", "Oktober"),
("1", "%OPTIMIEREN%", "Optimieren"),
("1", "%ORDNER_ANGELEGT%", "Ordner angelegt"),
("1", "%ORDNER_GELOESCHT%", "Ordner gel�scht"),
("1", "%ORDNER_LOESCHEN_FEHLGESCHLAGEN%", "Ordner l�schen fehlgeschlagen"),
("1", "%ORT%", "Ort"),
("1", "%OVER%", "Over"),
("1", "%PAGE%", "Page"),
("1", "%PASSWORT%", "Passwort"),
("1", "%PASSWORTGESPEICHERT%", "Das neue Passwort ist gespeichert worden."),
("1", "%PASSWORTGLEICHEIT%", "Bitte pr�fen Sie, ob Sie beide Male das gleiche Passwort angegeben haben. "),
("1", "%PASSWORTVERGESSENSEITE%", "Passwortvergessenseite"),
("1", "%PASSWORTZEICHENFEHLER%", "Ihr Passwort enh�lt ung�ltige Zeichen oder ist zu kurz (Leerschritte und Sonderzeichen sind nicht erlaubt und es sollte mindestes 6 Zeichen enthalten)."),
("1", "%PASSWORT_AENDERN%", "Passwort �ndern"),
("1", "%PASSWORT_ZUSCHICKEN%", "Passwort zuschicken"),
("1", "%PERSOENLICHE_DATEN%", "Pers�nliche Daten"),
("1", "%PERSOENLICHE_DATEN_BEARBEITEN%", "Pers�nliche Daten bearbeiten"),
("1", "%PERSON%", "Person"),
("1", "%PERSONEN%", "Personen"),
("1", "%PERSONEN_ONLINE%", "Folgende Personen sind zur Zeit online (oder haben sich nicht abgemeldet)"),
("1", "%PFADE_ABSOLUT_SETZEN%", "Pfade absolut setzen"),
("1", "%PFAD_ZUM_JAVASCRIPT%", "Pfad zum Javascript"),
("1", "%PFAD_ZU_BILDERN%", "Pfad zu Bildern"),
("1", "%PFAD_ZU_DEN_STYLESHEETS%", "Pfad zu den Stylesheets"),
("1", "%PFAD_ZU_DEN_VORLAGEN%", "Pfad zu den Vorlagen"),
("1", "%PFLICHTFELD%", "Pflichtfeld"),
("1", "%PLUGINS%", "Plugins"),
("1", "%POS%", "Pos."),
("1", "%POSITION%", "Position"),
("1", "%POS_ABSTEIGEND%", "Pos. absteigend"),
("1", "%POS_AUFSTEIGEND%", "Pos. aufsteigend"),
("1", "%PREFIX%", "Prefix"),
("1", "%PREVIEW%", "Vorschau"),
("1", "%PROFILING%", "PHP Profiling"),
("1", "%PRO_SEITE%", "Pro Seite"),
("1", "%RECHTE%", "Rechte"),
("1", "%REDUZIERTE_HOEHE%", "Reduzierte H�he"),
("1", "%RUNTERGELADEN%", "Runtergeladen"),
("1", "%RUNTERLADEN%", "Runterladen"),
("1", "%SAMSTAG%", "Samstag"),
("1", "%SCHADE%", "Schade"),
("1", "%SCHLIESSEN%", "Schlie�en"),
("1", "%SCHREIBFEHLER%", "Schreibfehler"),
("1", "%SCHREIBWEISE%", "Schreibweise"),
("1", "%SEITE%", "Seite"),
("1", "%SEITEN%", "Seiten"),
("1", "%SEITENBESCHREIBUNG%", "Erscheint auf �bersichtsseiten und bei Google, (description)"),
("1", "%SEITENBESUCHE_ZAEHLEN%", "Seitenbesuche z�hlen (Statsitik)"),
("1", "%SEITENDETAILS%", "Seitendetails"),
("1", "%SEITENUEBERSCHRIFT%", "�berschrift auf der Seite"),
("1", "%SEITENVORLAGE%", "Seitenvorlage"),
("1", "%SEITENZAEHLER%", "Seitenz�hler"),
("1", "%SEITEN_ANLEGEN%", "Seiten anlegen"),
("1", "%SEITEN_ANZEIGEN%", "Seiten anzeigen"),
("1", "%SEITEN_BEARBEITEN%", "Seiten bearbeiten"),
("1", "%SEITEN_DIESER_AUSWAHL%", "Seiten dieser Auswahl anzeigen"),
("1", "%SEITEN_DIESER_KATEGORIE%", "Seiten dieser Kategorie"),
("1", "%SEITEN_ZAEHLEN%", "Seiten z�hlen"),
("1", "%SEITEN_ZWISCHENSPEICHERN%", "Seiten zwischenspeichern (Cache)"),
("1", "%SEITE_ALS_EIGENE_UNTERSEITE%", "Eine Seite kann nicht ihre eigene Unterseite sein."),
("1", "%SEITE_ANZEIGEN%", "Seite anzeigen"),
("1", "%SEITE_BEARBEITEN%", "Seite bearbeiten"),
("1", "%SEITE_ERSTELLT_AM%", "Seite erstellt am"),
("1", "%SEITE_FREIGEBEN%", "Seite freigeben"),
("1", "%SEITE_GELOESCHT%", "Seite gel�scht"),
("1", "%SEITE_OHNE_TITEL%", "Ohne Titel kann die Seite nicht gespeichert werden."),
("1", "%SENDEN%", "Senden"),
("1", "%SEPTEMBER%", "September"),
("1", "%SERVER_DURCHSUCHEn%", "Server durchsuchen"),
("1", "%SERVER_FEHLER%", "Server Fehler"),
("1", "%SIZE%", "Gr��e"),
("1", "%SMTP_FEHLER%", "SMTP-Fehler"),
("1", "%SOFORT_VEROEFFENTLICHEN%", "Sofort ver�ffentlichen"),
("1", "%SONDERSEITEN%", "Sonderseiten"),
("1", "%SONDERVORLAGEN%", "Sondervorlagen"),
("1", "%SONNTAG%", "Sonntag"),
("1", "%SONSTIGES%", "Sonstiges"),
("1", "%SORTIERUNG_DER_ABSCHNITTE%", "Sortierung der Abschnitte"),
("1", "%SPEICHERN_NICHT_ERLAUBT%", "Ihnen fehlen die Rechte, �nderungen zu speichern. Bitte wenden Sie ggfl. sich an den Administrator."),
("1", "%SPEICHERVERBOT%", "Speicherverbot"),
("1", "%SPRACHE%", "Sprache"),
("1", "%SPRACHEN%", "Sprachen"),
("1", "%SPRACHEN_BEARBEITEN%", "Sprachen bearbeiten"),
("1", "%SPRACHEN_LOESCHEN%", "Sprachen l�schen"),
("1", "%SPRACHE_BEARBEITEN%", "Sprache bearbeiten"),
("1", "%SPRACHE_EXPORTIEREN%", "Sprache exportieren"),
("1", "%SPRACHE_GELOESCHT%", "Sprache gel�scht"),
("1", "%SPRACHE_LOESCHEN%", "Diese Sprache und alle zugeh�rigen Einrtr�ge L�schen."),
("1", "%STARTSEITE%", "Startseite"),
("1", "%STATISTIK%", "Statistik"),
("1", "%STATISTIKDOMAIN%", "Statistik-Domain"),
("1", "%STATISTIKID%", "Statistik ID"),
("1", "%STATS%", "Stats"),
("1", "%STATUS%", "Status"),
("1", "%STATUSAENDERUNGSEITE%", "Status�nderung"),
("1", "%STATUSSEITE%", "Statusseite"),
("1", "%STRASSE%", "Strasse"),
("1", "%SUCHE%", "Suche"),
("1", "%SUCHEN%", "Suchen"),
("1", "%SYSTEM%", "System / Editor"),
("1", "%SYSTEMFEHLER%", "Systemfehler"),
("1", "%TABELLE%", "Tabelle"),
("1", "%TABELLEN_AUFGERAEUMT%", "Tabellen aufger�umt"),
("1", "%TABELLEN_OPTIMIERT%", "Tabellen optimiert"),
("1", "%TABELLE_EXPORTIERT%", "Die Tabelle wurde exportiert"),
("1", "%TABELLE_IMPORTIERT%", "Tabelle importiert"),
("1", "%TASTENKUERZEL%", "Tastenk�rzel"),
("1", "%TASTENKUERZEL_FESTLEGEN%", "F�r Tastaturbedienung"),
("1", "%TEL%", "Tel"),
("1", "%TELEFON%", "Telefon"),
("1", "%TERMINE%", "Termine"),
("1", "%TERMINE_GELOESCHT%", "Termine gel�scht"),
("1", "%TERMINE_GESPEICHERT%", "Termine gespeichert"),
("1", "%TEXTFELD%", "Textfeld"),
("1", "%TEXTFELD_ANZEIGEN%", "Textfeld anzeigen"),
("1", "%TITEL%", "Titel"),
("1", "%TOOLBAR%", "Toolbar"),
("1", "%TOOLTIP_BERECHTIGUNGEN%", "Festlegen, welche Seiten und Kategorien bearbeitet werden d�rfen"),
("1", "%TOOLTIP_EINTRAGEN%", "�nderungen speichern"),
("1", "%TOOLTIP_PLUGINSRECHTE%", "Rechte f�r Plugins festlegen"),
("1", "%TOOLTIP_RECHTE%", "Rechte f�r Seiten festlegen"),
("1", "%TOOLTIP_STICHWORTE%", "Titel, Beschreibung, �berschrift und Text werden ausgewertet"),
("1", "%UEBERSCHREIBEN%", "�berschreiben"),
("1", "%UEBERSCHRIFT%", "�berschrift"),
("1", "%UEBERSETZEN%", "�bersetzen"),
("1", "%UEBERSETZUNG_BEARBEITEN%", "�bersetzung bearbeiten"),
("1", "%UMBENENNEN%", "Umbenennen"),
("1", "%UNBEDINGT_AUSWAEHLEN%", "Unbedingt ausw�hlen"),
("1", "%UNBEKANNTE_KODIERUNG%", "Unbekannte Kodierung"),
("1", "%UND%", "und"),
("1", "%UNGUELTIGE_ADRESSE%", "Ung�ltige Adresse"),
("1", "%UNIDENTIFIZIERTER_FEHLER%", "Unidentifizierter Fehler"),
("1", "%UNTERSEITEN%", "Unterseiten"),
("1", "%UNTERSEITEN_ANZEIGEN%", "Unterseiten anzeigen"),
("1", "%UNTERSEITE_VON%", "Unterseite von"),
("1", "%UPLOAD%", "Neue Datei:"),
("1", "%UPLOAD_ZU_GROSS%", "Die Summe der Hochzuladenden Dateien ist zu gro� (#SIZE#). Mehr als #ALLOWED# insgesamt werden vom Server nicht unterst�tzt."),
("1", "%URL%", "Url"),
("1", "%Uhr%", "Uhr"),
("1", "%VARIABLE_NICHT_GESETZT%", "Variable nicht gesetzt"),
("1", "%VEROEFFENTLICHEN%", "Ver�ffentlichen"),
("1", "%VERSCHIEBEN%", "Verschieben"),
("1", "%VERSTECKEN%", "Verstecken"),
("1", "%VERWALTUNG%", "Verwaltung"),
("1", "%VERWALTUNGSSEITEN%", "Verwaltungsseiten"),
("1", "%VERWALTUNGSSPRACHE%", "Verwaltungssprache"),
("1", "%VIDEO%", "Video"),
("1", "%VON_LINKS_NACH_RECHTS%", "Von links nach rechts"),
("1", "%VON_RECHTS_NACH_LINKS%", "Von rechts nach links"),
("1", "%VORGABEN%", "Vorgaben"),
("1", "%VORGABEN_BEARBEITEN%", "Vorgaben bearbeiten"),
("1", "%VORGAENGERSEITE%", "Vorg�ngerseite"),
("1", "%VORIGE%", "Vorige"),
("1", "%VORJAHR%", "Vorjahr"),
("1", "%VORLAGE%", "Vorlage"),
("1", "%VORLAGEN%", "Vorlagen"),
("1", "%VORLAGEN_BEARBEITEN%", "Vorlagen bearbeiten"),
("1", "%VORLAGE_BEARBEITEN%", "Vorlage bearbeiten"),
("1", "%VORLAGE_EXPORTIEREN%", "Vorlage exportieren"),
("1", "%VORLAGE_GELOESCHT%", "Vorlage gel�scht"),
("1", "%VORLAGE_IMPORTIERT%", "Vorlage importiert"),
("1", "%VORLAGE_NICHT_GEFUNDEN%", "Vorlage nicht gefunden"),
("1", "%VORLAGE_OHNE_TITEL%", "Ohne Titel kann die Vorlage nicht gespeichert werden."),
("1", "%VORMONAT%", "Vormonat"),
("1", "%VORSCHAU%", "Vorschau"),
("1", "%WEITERBLAETTERN%", "Weiterbl�ttern"),
("1", "%WEITERE_ANGABEN%", "Weitere Angaben"),
("1", "%WEITERE_DATEIEN%", "Weitere SQL-Dateien"),
("1", "%WEITERE_DATEN%", "Weitere Daten"),
("1", "%WIEDERHOLUNG%", "Wiederholung"),
("1", "%WIRD_BEARBEITET_VON%", "Wird bearbeitet von"),
("1", "%WORD_BEREINIGEN%", "Word bereinigen"),
("1", "%WWW%", "www"),
("1", "%ZEIGEN%", "Zeigen"),
("1", "%ZEIT%", "Zeit"),
("1", "%ZUGEHOERIGE_SEITEN%", "Zugeh�rige Seiten"),
("1", "%ZUGEHOERIGE_UNTERSEITEN%", "Zugeh�rige Unterseiten"),
("1", "%ZUGEORDNETE_SEITEN%", "zugeordnete Seiten"),
("1", "%ZUGRIFF%", "Zugriff"),
("1", "%ZURUECK%", "Zur�ck"),
("1", "%ZURUECKBLAETTERN%", "Zur�ckbl�ttern"),
("1", "%ZU_VIELE_UPLOADS%", "Zu viele  Dateien (#UPCOUNT#). Mehr als #MFU# werden von Server nicht unterst�tzt."),
("3", "%ABBINDERSEITE%", "Footer"),
("3", "%ABC_ABSTEIGEND%", "A-Z descending"),
("3", "%ABC_AUFSTEIGEND%", "A-Z ascending"),
("3", "%ABKUERZUNG%", "Abbreviation"),
("3", "%ABMELDEN%", "Logout of administration"),
("3", "%ABSCHNITT%", "Section"),
("3", "%ABSCHNITTE%", "Sections"),
("3", "%ABSCHNITTIMPORT%", "Section import"),
("3", "%ABSCHNITT_ABSTEIGEND%", "Section descending"),
("3", "%ABSCHNITT_AUFSTEIGEND%", "Section ascending"),
("3", "%ABSCHNITT_GELOESCHT%", "Section deleted"),
("3", "%ABSCHNITT_VERSCHOBEN%", "Section moved "),
("3", "%ABSENDERADRESSE_UNGUELTIG%", "Sender address invalid"),
("3", "%ACTIVE%", "Active"),
("3", "%ADDCOLOR%", "Addcolor"),
("3", "%ADRESSEN%", "Addresses"),
("3", "%ADRESSEN_AUSGEWAEHLT%", "Address (es) selected"),
("3", "%ADRESSEN_GEAENDERT%", "Address changed"),
("3", "%ADRESSEN_GELOESCHT%", "The addresses have been deleted."),
("3", "%ADRESSEN_HINZUGEFUEGT%", "Addresses added"),
("3", "%AENDERUNGEN_SIND_EINGETRAGEN%", "Changes are saved"),
("3", "%ALLE%", "All"),
("3", "%ALLES%", "Everything "),
("3", "%ALLE_AENDERN%", "Change all"),
("3", "%ALLE_AUSWAEHLEN%", "Select All"),
("3", "%ALLE_SEITEN%", "All pages"),
("3", "%ALLE_SEITEN_DER_ERSTEN_EBENE%", "All pages of the first level"),
("3", "%ALLE_SEITEN_DIESER_EBENE%", "All pages of this level"),
("3", "%ALLE_SEITEN_DIESER_KATEGORIE%", "All pages of this groups"),
("3", "%ALLE_SEITEN_WIE_IN_LETZTER_UEBERSICHT%", "All pages like in last overview"),
("3", "%ALLE_SPRACHEN_ZEIGEN%", "Show all languages"),
("3", "%ALLE_THREADS%", "All threads"),
("3", "%ALLE_WAEHLEN%", "Select All"),
("3", "%ANGABEN_GESPEICHERT%", "The data have been stored."),
("3", "%ANGABEN_UNVOLLSTAENDIG%", "The data are not complete."),
("3", "%ANHANG%", "Attachment"),
("3", "%ANLEGEN%", "Create"),
("3", "%ANSEHEN_BEARBEITEN%", "Edit / view"),
("3", "%ANSPRECHPARTNER%", "Contact"),
("3", "%ANZAHL%", "Number"),
("3", "%ANZEIGEN%", "Visible"),
("3", "%APRIL%", "April"),
("3", "%AUFRAEUMEN%", "Clean up"),
("3", "%AUGUST%", "August"),
("3", "%AUSBLENDEN%", "Hide"),
("3", "%AUSFUEHREN%", "Execute"),
("3", "%AUSGABEOPTIONEN%", "Output options"),
("3", "%AUSWAHL%", "Selection"),
("3", "%AUSWAHL_LOESCHEN%", "Delete selection"),
("3", "%AUSWAHL_NICHT_MOEGLICH%", "Selection not possible"),
("3", "%AUTOMATISCH_UEBERSETZEN%", "Automatic translation"),
("3", "%AUTOR%", "Autor"),
("3", "%BEARBEITEN%", "Edit"),
("3", "%BENUTZER%", "User"),
("3", "%BENUTZERVERWALTUNG%", "User management"),
("3", "%BERECHTIGUNGEN%", "Permissions"),
("3", "%BESCHREIBUNG%", "Description"),
("3", "%BESITZER%", "Owner"),
("3", "%BESONDERE_SEITEN%", "Special pages"),
("3", "%BESTAETIGT%", "Confirmed"),
("3", "%BETREFF%", "Subject"),
("3", "%BETREFFANHANG%", "Subject suffix"),
("3", "%BETRIFFT_ALLE_SPRACHEN%", "Affects all languages"),
("3", "%BILD%", "Images"),
("3", "%BILDBESCHREIBUNG_ERSETZEN%", "Replace image description"),
("3", "%BILDER%", "Images"),
("3", "%BILDERGROESSE%", "Image Size"),
("3", "%BILDLOESCHEN%", "Delete image"),
("3", "%BILD_NUR_TEILWEISE%", "The image could only be partially uploaded, please try again."),
("3", "%BILD_ZU_GROSS%", "The picture is too large."),
("3", "%BITTE_AUSWAEHLEN%", "Please choose"),
("3", "%BLOECKE%", "Blocks"),
("3", "%BODYCLASS%", "BodyClass"),
("3", "%BODYID%", "BodyId"),
("3", "%BREITE%", "Width"),
("3", "%BREITEHOEHE%", "Image height"),
("3", "%CACHE%", "Cache"),
("3", "%COVER%", "Cover"),
("3", "%DATA_NICHT_AKZEPTIERT%", "Data not accepted"),
("3", "%DATEIENDUNG_NICHT_ERLAUBT%", "File extension not allowed"),
("3", "%DATEIMANAGER%", "File manager"),
("3", "%DATEINAME%", "File Name"),
("3", "%DATEI_DURCH_DIESE_ERSETZEN%", "Replace file with this one. "),
("3", "%DATEI_EXISTIERT_BEREITS%", "File already exists"),
("3", "%DATEI_GELOESCHT%", "File removed"),
("3", "%DATEI_GESPEICHERT%", "File stored"),
("3", "%DATEI_NICHT_GESPEICHERT%", "File not saved"),
("3", "%DATEI_NICHT_HOCHLADEN%", "Don't upload file."),
("3", "%DATEI_OEFFNEN_FEHLER%", "Error opening file"),
("3", "%DATEI_SEHR_GROSS%", "The file is very large (#SIZE#). Uploading may take some time."),
("3", "%DATEI_UNGUELTIG%", "File not valid"),
("3", "%DATEI_ZUGRIFF_FEHLER%", "File access error"),
("3", "%DATEI_ZU_GROSS%", "One of the attached files is too big!"),
("3", "%DATEN%", "Data"),
("3", "%DATENBANK_AUFRAEUMEN%", "Clean database (remove duplicates)"),
("3", "%DATENBANK_OPTIMIEREN%", "Database optimized"),
("3", "%DATENBANK_RUNTERLADEN%", "Download database"),
("3", "%DATEN_WURDEN_GELOESCHT%", "The data was deleted"),
("3", "%DATEN_WURDEN_GESPEICHERT%", "Your data was saved."),
("3", "%DATUM%", "Date"),
("3", "%DATUMSFORMAT%", "Date format"),
("3", "%DATUM_ABSTEIGEND%", "Date descending"),
("3", "%DATUM_AUFSTEIGEND%", "Date ascending"),
("3", "%DATUM_PRUEFEN%", "Check date"),
("3", "%DEZEMBER%", "December"),
("3", "%DIENSTAG%", "Tuesday"),
("3", "%DIESE_SEITE_GIBT_ES_NICHT%", "Page not found."),
("3", "%DISKUSSIONSSTRANG_GESCHLOSSEN%", "Thread closed"),
("3", "%DOMAIN_NICHT_ERREICHBAR%", "Domain not available"),
("3", "%DONNERSTAG%", "Thursday"),
("3", "%DOWNLOAD%", "Download"),
("3", "%DUMP%", "Dump"),
("3", "%EIGENE%", "Only own"),
("3", "%EINE_ZEILE_NACH_OBEN%", "One line up"),
("3", "%EINE_ZEILE_NACH_UNTEN%", "One line down"),
("3", "%EINFUEGEN%", "Paste"),
("3", "%EINTRAEGE%", "Entries"),
("3", "%EINTRAEGE_BEARBEITET%", "Entries processed"),
("3", "%EINTRAEGE_FINDEN%", "Find entries"),
("3", "%EINTRAGEN%", "Save"),
("3", "%EINTRAG_AENDERN%", "Edit entry"),
("3", "%EINTRAG_BEARBEITEN%", "Edit Entry"),
("3", "%EINTRAG_KOMMENTIEREN%", "Comment entry"),
("3", "%EMAIL%", "E-mail"),
("3", "%EMAILFUNKTION_NICHT_AUSFUEHRBAR%", "Email function not defined"),
("3", "%EMAILS_ALS_LISTE%", "Show e-mails as list"),
("3", "%EMAILS_AN_DIESE_EMPFAENGER%", "Send emails to these recipients"),
("3", "%EMAILS_SIND_VERSANDT_WORDEN%", "E-mails have been send."),
("3", "%EMAIL_ZEIGEN%", "Show email"),
("3", "%EMPFAENGER%", "Recipients"),
("3", "%EMPFAENGER_UNGUELTIG%", "Invalid recipient"),
("3", "%ENDE_ABSTEIGEND%", "End descending"),
("3", "%ENDE_AUFSTEIGEND%", "End ascending"),
("3", "%ENTFERNEN%", "Remove "),
("3", "%ERLAUBTE_DATEIENDUNGEN%", "Please only upload files with the following file extensions"),
("3", "%ERSCHEINT_IM_MENUE%", "Appears in the menu"),
("3", "%ERSTELLEN%", "Create"),
("3", "%ERSTELLT_AM%", "Creation date"),
("3", "%EXPORT%", "Export"),
("3", "%EXPORTIEREN%", "Export"),
("3", "%EXTRA%", "Extra"),
("3", "%FARBE%", "Color"),
("3", "%FARBIDS_FEHLEN%", "Color ids missing"),
("3", "%FAX%", "Fax"),
("3", "%FCKEDITOR%", "FCKeditor"),
("3", "%FEBRUAR%", "February"),
("3", "%FEHLER%", "An error occured"),
("3", "%FENSTERTITEL%", "Window Title"),
("3", "%FENSTER_SCHLIESSEN%", "Close window"),
("3", "%FIRMA%", "Company Name"),
("3", "%FIX%", "Fix"),
("3", "%FIXIERTE_SEITE%", "Fixed side"),
("3", "%FLAGGE%", "Flag"),
("3", "%FOLGE%", "Next"),
("3", "%FOLGEJAHR%", "Following year"),
("3", "%FOLGEMONAT%", "Next month"),
("3", "%FOLGESEITE%", "Next page"),
("3", "%FOLLOW%", "Follow "),
("3", "%FONTFORMATS%", "Font size"),
("3", "%FORUM%", "Forum"),
("3", "%FORUMEINTRAG%", "Forum posts"),
("3", "%FORUMVORLAGE%", "Forum template"),
("3", "%FREIGABESEITE%", "Account active page"),
("3", "%FREISCHALTEN%", "Unlock"),
("3", "%FREITAG%", "Friday"),
("3", "%FUER_EXPORT_AUSWAEHLEN%", "Choose  for export"),
("3", "%FUER_MAIL_AUSWAEHLEN%", "Select e-mail"),
("3", "%GAESTEBUCH%", "Guestbook"),
("3", "%GAESTEBUCHSEITE%", "Guestbook page"),
("3", "%GAESTEBUCH_BEARBEITEN%", "Edit guestbook "),
("3", "%GALERIEN%", "Galleries"),
("3", "%GANZ_SICHER%", "Are you sure?"),
("3", "%GELOESCHT%", "Deleted"),
("3", "%GESPERRTSEITE%", "Account locked page"),
("3", "%GROESSENVORGABEN%", "Size presets"),
("3", "%HAUSNUMMER%", "Number"),
("3", "%HEUTE%", "Today"),
("3", "%HINTERGRUENDE%", "Backgrounds"),
("3", "%HINTERGRUND%", "Background"),
("3", "%HINTERGRUND2%", "Background"),
("3", "%HOCHGELADEN%", "Uploaded"),
("3", "%HOCHLADEN%", "Upload"),
("3", "%HOCHLADEN_FEHLGESCHLAGEN%", "Upload failed "),
("3", "%HOEHE%", "Height"),
("3", "%HTTPSDOMAIN%", "Httpsdomain"),
("3", "%IMMER_ZEIGEN%", "Show always"),
("3", "%IMPORT%", "Import"),
("3", "%IMPORTIEREN%", "Import"),
("3", "%IMPRESSUM%", "Imprint"),
("3", "%INAKTIV%", "Inactiv"),
("3", "%INFO_STICHWORTE%", "Important keywords should occur more often, they are displayed larger here."),
("3", "%IN_BEARBEITUNG%", "Under construction"),
("3", "%IN_NEUEM_FENSTER_OEFFNEN%", "Open in new Window"),
("3", "%IN_TEXT_EINFUEGEN%", "Insert into text"),
("3", "%JANUAR%", "January"),
("3", "%JULI%", "July"),
("3", "%JUNI%", "June"),
("3", "%KALENDERSEITEN%", "Calendar pages"),
("3", "%KALENDERVORLAGE%", "Calendar Template"),
("3", "%KATEGAL%", "Show sub pages independent of groups"),
("3", "%KATEGORIE%", "Category"),
("3", "%KATEGORIEN%", "Groups"),
("3", "%KATEGORIEN_BEARBEITEN%", "Edit groups"),
("3", "%KATEGORIE_BEARBEITEN%", "Edit group"),
("3", "%KATEGORIE_IST_ANGELEGT%", "New group was created "),
("3", "%KATEGORIE_OHNE_TITEL%", "Without title, the group can not be saved. "),
("3", "%KEINE%", "None"),
("3", "%KEINE_ABONNENTEN_GEWAEHLT%", "No subscribers selected"),
("3", "%KEINE_AUTHENTIFIZIERUNG%", "No authentication"),
("3", "%KEINE_EINTRAEGE%", "No entries found");

-- # Schnipp --
INSERT INTO `#PREFIX#_translate` (`LANG_ID`,`name`,`value`) VALUES
("3", "%KEINE_EINTRAEGE_GEFUNDEN%", "No entries found"),
("3", "%KEINE_EMAIL_ANGEGEBEN%", "No email specified"),
("3", "%KEINE_HTML_UNTERSEITEN%", "No html sub pages"),
("3", "%KEINE_NACHRICHT%", "No message"),
("3", "%KEINE_NUM_UNTERSEITEN%", "No numeric sub pages"),
("3", "%KEINE_VERBINDUNG_HOST%", "No Connection to host"),
("3", "%KEIN_EMPFAENGER_GEWAEHLT%", "No recipients selected"),
("3", "%KLICK_TOGGLE%", "Click to show / hide"),
("3", "%KOMMAGETRENNT%", "Comma-separated"),
("3", "%KOMMENTAR%", "Comment"),
("3", "%KOMPRIMIERUNG%", "Use compression"),
("3", "%KONFIGURATIONSOPTIONEN%", "Configuration options"),
("3", "%KONTAKT%", "Contact"),
("3", "%KONTAKTE_SPEICHERN%", "Store contacts"),
("3", "%KONTAKTSEITE%", "Contact page"),
("3", "%KOPIE%", "Copy"),
("3", "%KOPIEREN%", "Copy"),
("3", "%KOPIE_VON%", "Copy of"),
("3", "%LAND%", "Country"),
("3", "%LETZTE_GESPEICHERTE_VERSION%", "Last saved version"),
("3", "%LINKS_DURCHSUCHEN%", "Search Links"),
("3", "%LINK_EINFUEGEN%", "Paste as link"),
("3", "%LOESCHEN%", "Delete"),
("3", "%LOESCHEN_FEHLGESCHLAGEN%", "Remove failed"),
("3", "%LOESCHEN_ODER_ABBRECHEN%", "Confirm Delete (OK) oder Cancel operation (Cancel)"),
("3", "%LOGIN%", "Username"),
("3", "%LOGINSEITE%", "Login page"),
("3", "%LOGOUT%", "Logout"),
("3", "%LOGOUTSEITE%", "Logout page"),
("3", "%LOGOUT_IM_MENUE%", "Logout in menu"),
("3", "%MAERZ%", "March"),
("3", "%MAI%", "May"),
("3", "%MAIL%", "Email"),
("3", "%MAILER_NICHT_UNTERSTUETZT%", "Mailer not supported"),
("3", "%MARKIERUNGEN_ENTFERNEN%", "Clear highlighting"),
("3", "%MARKIERUNGEN_VON_BEGRIFFEN_ENTFERNEN%", "Clear highlighting"),
("3", "%MAXZEICHEN%", "More than #MAXLENGTH# characters are not allowed."),
("3", "%MEHR%", "More"),
("3", "%MELDUNGEN%", "Messages / Errors"),
("3", "%MENU%", "Menu "),
("3", "%MENUEBILD%", "Menu image"),
("3", "%MENUEBILD2%", "Menu image (hover)"),
("3", "%MENUEBILDER%", "Menu images"),
("3", "%MENUEEINTRAG%", "Menu item"),
("3", "%METADATEN%", "Meta"),
("3", "%MINDESTENS_SECHS_ZEICHEN%", "The password should contain at least six characters."),
("3", "%MITTWOCH%", "Wednesday"),
("3", "%MOBIL%", "Mobile"),
("3", "%MONTAG%", "Monday"),
("3", "%MYSQL%", "MySQL"),
("3", "%NACHBARSEITEN%", "Neighbor pages"),
("3", "%NACHNAME%", "Surname"),
("3", "%NACHRICHT%", "Message"),
("3", "%NACHRICHT_ANZEIGEN%", "Show message"),
("3", "%NAME%", "Name"),
("3", "%NEU%", "New"),
("3", "%NEUER_ORDNER%", "new directory"),
("3", "%NEUES_PASSWORT%", "New password"),
("3", "%NEUE_ABSCHNITTE%", "New sections"),
("3", "%NEUE_DATEI%", "new file"),
("3", "%NEUE_KATEGORIE%", "New group"),
("3", "%NEUE_PERSON_ANLEGEN%", "Create new person"),
("3", "%NEUE_SEITE%", "New page"),
("3", "%NEUE_SEITE_ANLEGEN%", "Create new page"),
("3", "%NEUE_SEITE_MIT_DIESEN_INHALTEN%", "New page with this content"),
("3", "%NEUE_SEITE_NACH_DIESEM_VORBILD%", "New page like this one."),
("3", "%NEUE_SPRACHE%", "New language"),
("3", "%NEU_ANLEGEN%", "Create New"),
("3", "%NEU_LADEN%", "Reload"),
("3", "%NEWSLETTER%", "Newsletter"),
("3", "%NEWSLETTERVORLAGE%", "Newsletter template"),
("3", "%NEWSLETTERVORSCHAU%", "Newsletter preview"),
("3", "%NEWSLETTER_%", "Send newsletter"),
("3", "%NEWSLETTER_EINZELN_SENDEN%", "Send newsletter individually"),
("3", "%NEWSLETTER_VERSANDT%", "Newsletter send"),
("3", "%NEWSLETTER_VORSCHAU%", "Newsletter preview"),
("3", "%NICHT_GELOESCHT%", "Not deleted"),
("3", "%NLEMAILVORLAGE%", "Newsletter e-mail"),
("3", "%NNNNLNNNNN%", "Nnnnlnnnnn"),
("3", "%NOVEMBER%", "November"),
("3", "%NR%", "No."),
("3", "%NUR_AN_DIESE_EMPFAENGER%", "Only selected recipients"),
("3", "%NUR_TEXT_EINFUEGEN%", "Insert only  text"),
("3", "%ODER_KATEGORIEN_LOESCHEN%", "or delete groups - corresponding pages will be removed!"),
("3", "%ODER_VORLAGEN_LOESCHEN%", "or delete templates - all corresponding pages will be removed!"),
("3", "%OEFFNEN%", "Open"),
("3", "%OHNE%", "without"),
("3", "%OKTOBER%", "October"),
("3", "%OPTIMIEREN%", "Optimize"),
("3", "%OPTIONAL%", "Optional"),
("3", "%ORDNER_ANGELEGT%", "Directory created"),
("3", "%ORDNER_GELOESCHT%", "Directory removed"),
("3", "%ORDNER_LOESCHEN_FEHLGESCHLAGEN%", "Removing directory failed"),
("3", "%ORT%", "Place"),
("3", "%OVER%", "Over"),
("3", "%PAGE%", "Page"),
("3", "%PASSWORT%", "Password"),
("3", "%PASSWORTGESPEICHERT%", "The new password has been saved."),
("3", "%PASSWORTGLEICHEIT%", "Please check that you have specified the same password both times."),
("3", "%PASSWORTVERGESSENSEITE%", "Password forgotten page"),
("3", "%PASSWORTZEICHENFEHLER%", "Your password contains invalid characters or is too short (spaces and special characters are not allowed and there should be minimum 6 characters)."),
("3", "%PASSWORT_AENDERN%", "Change Password"),
("3", "%PASSWORT_ZUSCHICKEN%", "Send password"),
("3", "%PERSOENLICHE_DATEN%", "Personal data"),
("3", "%PERSOENLICHE_DATEN_BEARBEITEN%", "Edit personal data"),
("3", "%PERSON%", "User"),
("3", "%PERSONEN%", "People"),
("3", "%PERSONEN_ONLINE%", "Users online"),
("3", "%PFADE_ABSOLUT_SETZEN%", "Use absolute paths"),
("3", "%PFADE_AUSSCHLIESSEN%", "Excluded Paths"),
("3", "%PFAD_ZUM_JAVASCRIPT%", "Path to javascript"),
("3", "%PFAD_ZU_BILDERN%", "Path to images "),
("3", "%PFAD_ZU_DEN_STYLESHEETS%", "Path to StyleSheet"),
("3", "%PFAD_ZU_DEN_VORLAGEN%", "Path to templates"),
("3", "%PFLICHTFELD%", "Required field"),
("3", "%PLUGINS%", "Plugins / modules"),
("3", "%PLZ%", "ZIP"),
("3", "%POS%", "Pos"),
("3", "%POSITION%", "Position"),
("3", "%POS_ABSTEIGEND%", "Pos descending"),
("3", "%POS_AUFSTEIGEND%", "Pos ascending"),
("3", "%PREFIX%", "Prefix"),
("3", "%PREVIEW%", "Preview"),
("3", "%PROFILING%", "PHP Profiling"),
("3", "%PRO_SEITE%", "Per page"),
("3", "%RECHTE%", "Set rights"),
("3", "%REDUZIERTE_HOEHE%", "reduced height"),
("3", "%RUNTERGELADEN%", "Downloaded"),
("3", "%RUNTERLADEN%", "Download"),
("3", "%SAMSTAG%", "Saturday"),
("3", "%SCHADE%", "What a pity"),
("3", "%SCHLIESSEN%", "Close"),
("3", "%SCHREIBFEHLER%", "error writing file"),
("3", "%SCHREIBWEISE%", "Spelling"),
("3", "%SEITE%", "Page"),
("3", "%SEITEN%", "Pages"),
("3", "%SEITENBESCHREIBUNG%", "Description of page content"),
("3", "%SEITENBESUCHE_ZAEHLEN%", "Visits count"),
("3", "%SEITENDETAILS%", "Page details"),
("3", "%SEITENUEBERSCHRIFT%", "Page Headline"),
("3", "%SEITENVORLAGE%", "Page Template"),
("3", "%SEITENZAEHLER%", "Page counter"),
("3", "%SEITEN_ANLEGEN%", "Creating pages"),
("3", "%SEITEN_ANZEIGEN%", "Show pages"),
("3", "%SEITEN_BEARBEITEN%", "Edit Pages"),
("3", "%SEITEN_DIESER_AUSWAHL%", "Pages of this selection"),
("3", "%SEITEN_DIESER_KATEGORIE%", "Pages in this groups"),
("3", "%SEITEN_ZAEHLEN%", "Page count"),
("3", "%SEITEN_ZWISCHENSPEICHERN%", "Cached pages"),
("3", "%SEITE_ALS_EIGENE_UNTERSEITE%", "A page can not be her own bottom."),
("3", "%SEITE_ANZEIGEN%", "Preview"),
("3", "%SEITE_BEARBEITEN%", "Edit page"),
("3", "%SEITE_ERSTELLT_AM%", "Page created on"),
("3", "%SEITE_FREIGEBEN%", "release pages"),
("3", "%SEITE_GELOESCHT%", "Page deleted"),
("3", "%SEITE_OHNE_TITEL%", "The page can not be saved without a title."),
("3", "%SENDEN%", "Send"),
("3", "%SEPTEMBER%", "September"),
("3", "%SERVER_DURCHSUCHEN%", "Search Server"),
("3", "%SERVER_FEHLER%", "Server error"),
("3", "%SIZE%", "Size"),
("3", "%SMTP_FEHLER%", "SMTP error"),
("3", "%SOFORT_VEROEFFENTLICHEN%", "Immediately publish"),
("3", "%SONDERSEITEN%", "Special pages"),
("3", "%SONDERVORLAGEN%", "Special Templates"),
("3", "%SONNTAG%", "Sunday"),
("3", "%SONSTIGES%", "Other"),
("3", "%SORTIERUNG_DER_ABSCHNITTE%", "Sorting of sections"),
("3", "%SPEICHERN_NICHT_ERLAUBT%", "Sorry. You don't have the rights to save changes. "),
("3", "%SPEICHERVERBOT%", "Disable Save"),
("3", "%SPRACHE%", "Language"),
("3", "%SPRACHEN%", "Languages"),
("3", "%SPRACHEN_BEARBEITEN%", "Edit languages"),
("3", "%SPRACHEN_LOESCHEN%", "Delete language"),
("3", "%SPRACHE_BEARBEITEN%", "Edit language"),
("3", "%SPRACHE_EXPORTIEREN%", "Export language"),
("3", "%SPRACHE_GELOESCHT%", "The language has been deleted."),
("3", "%SPRACHE_LOESCHEN%", "Delete this language and all related pages."),
("3", "%STARTSEITE%", "Home"),
("3", "%STATISTIK%", "Statistics"),
("3", "%STATISTIKDOMAIN%", "Domain Statistics"),
("3", "%STATISTIKID%", "Statistik id"),
("3", "%STATS%", "Stats"),
("3", "%STATUS%", "Status"),
("3", "%STATUSAENDERUNGSEITE%", "Change of status"),
("3", "%STATUSSEITE%", "Status Page"),
("3", "%STRASSE%", "Street"),
("3", "%SUCHE%", "Search for"),
("3", "%SUCHEN%", "Search"),
("3", "%SYSTEM%", "System"),
("3", "%SYSTEMFEHLER%", "System error"),
("3", "%TABELLE%", "Table"),
("3", "%TABELLEN_AUFGERAEUMT%", "Tables cleaned"),
("3", "%TABELLEN_OPTIMIERT%", "Tables optimized"),
("3", "%TABELLE_EXPORTIERT%", "Table exported"),
("3", "%TABELLE_IMPORTIERT%", "Table imported"),
("3", "%TASTENKUERZEL%", "Acceskey"),
("3", "%TASTENKUERZEL_FESTLEGEN%", "Set acceskey"),
("3", "%TEL%", "Tel"),
("3", "%TELEFON%", "Telephone"),
("3", "%TERMINE%", "Dates"),
("3", "%TERMINE_GELOESCHT%", "Dates deleted"),
("3", "%TERMINE_GESPEICHERT%", "Events stored"),
("3", "%TEXTFELD%", "Text box"),
("3", "%TEXTFELD_ANZEIGEN%", "Display text box"),
("3", "%TITEL%", "Title"),
("3", "%TOOLBAR%", "Toolbar"),
("3", "%TOOLTIP_BERECHTIGUNGEN%", "Determine which pages and groups can be edited"),
("3", "%TOOLTIP_EINTRAGEN%", "Save changes"),
("3", "%TOOLTIP_PLUGINSRECHTE%", "Set rights for plugins and modules"),
("3", "%TOOLTIP_RECHTE%", "Rights to choose sides"),
("3", "%TOOLTIP_STICHWORTE%", "Title, description, title and text are evaluated"),
("3", "%UEBERSCHREIBEN%", "Overwrite"),
("3", "%UEBERSCHRIFT%", "Headline"),
("3", "%UEBERSETZEN%", "Translate"),
("3", "%UEBERSETZUNG_BEARBEITEN%", "Edit translation"),
("3", "%UMBENENNEN%", "Rename"),
("3", "%UNBEDINGT_AUSWAEHLEN%", "please choose"),
("3", "%UNBEKANNTE_KODIERUNG%", "Unknown encoding"),
("3", "%UND%", "and"),
("3", "%UNGUELTIGE_ADRESSE%", "Invalid address"),
("3", "%UNIDENTIFIZIERTER_FEHLER%", "Unidentified error"),
("3", "%UNTERSEITEN%", "sub-pages"),
("3", "%UNTERSEITEN_ANZEIGEN%", "Browse subpages"),
("3", "%UNTERSEITE_VON%", "Subpage of"),
("3", "%UPLOAD%", "Upload"),
("3", "%UPLOAD_ZU_GROSS%", "The sum of files to upload is too large (#SIZE#). More than #MFS# is not supported by the server."),
("3", "%URL%", "Url"),
("3", "%Uhr%", "h"),
("3", "%VARIABLE_NICHT_GESETZT%", "Variable not set"),
("3", "%VEROEFFENTLICHEN%", "Publish"),
("3", "%VERSCHIEBEN%", "Move"),
("3", "%VERSTECKEN%", "Hide"),
("3", "%VERWALTUNG%", "Administration"),
("3", "%VERWALTUNGSSEITEN%", "Translate back-end"),
("3", "%VERWALTUNGSSPRACHE%", "Admin language"),
("3", "%VIDEO%", "Video"),
("3", "%VON_LINKS_NACH_RECHTS%", "From left to right"),
("3", "%VON_RECHTS_NACH_LINKS%", "From right to left"),
("3", "%VORGABEN%", "Preferences"),
("3", "%VORGABEN_BEARBEITEN%", "Edit preferences"),
("3", "%VORGAENGERSEITE%", "Previous page"),
("3", "%VORIGE%", "Previous"),
("3", "%VORJAHR%", "Previous year"),
("3", "%VORLAGE%", "Template"),
("3", "%VORLAGEN%", "Templates"),
("3", "%VORLAGEN_BEARBEITEN%", "Edit templates"),
("3", "%VORLAGE_BEARBEITEN%", "Edit template"),
("3", "%VORLAGE_EXPORTIEREN%", "Export template"),
("3", "%VORLAGE_GELOESCHT%", "The template has been deleted."),
("3", "%VORLAGE_IMPORTIERT%", "Template imported"),
("3", "%VORLAGE_NICHT_GEFUNDEN%", "Template not found"),
("3", "%VORLAGE_OHNE_TITEL%", "Without title, the template can not be saved."),
("3", "%VORMONAT%", "Previous month"),
("3", "%VORSCHAU%", "Preview"),
("3", "%VORSCHAUSEITEN%", "Preview pages"),
("3", "%WEITERBLAETTERN%", "Go to next page"),
("3", "%WEITERE_ANGABEN%", "More settings"),
("3", "%WEITERE_DATEIEN%", "More SQL-files"),
("3", "%WEITERE_DATEN%", "More information"),
("3", "%WIEDERHOLUNG%", "Repetition"),
("3", "%WIRD_BEARBEITET_VON%", "Someone is working here"),
("3", "%WORD_BEREINIGEN%", "Word Cleanup"),
("3", "%WWW%", "www"),
("3", "%ZEIGEN%", "Show"),
("3", "%ZEIT%", "Time"),
("3", "%ZUGEHOERIGE_SEITEN%", "Related Pages"),
("3", "%ZUGEHOERIGE_UNTERSEITEN%", "Related subpages"),
("3", "%ZUGEORDNETE_SEITEN%", "associated pages"),
("3", "%ZUGRIFF%", "Access"),
("3", "%ZURUECK%", "Back"),
("3", "%ZURUECKBLAETTERN%", "Go to previous page"),
("3", "%ZU_VIELE_UPLOADS%", "Too many uploads (#UPCOUNT#). More than #MFU# are not supported b the server.");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#abschnitte`;
-- # Schnipp --
CREATE TABLE `#PREFIX#abschnitte` (
  `PART_ID` smallint(5) NOT NULL DEFAULT '0',
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `LANG_ID` smallint(5) NOT NULL DEFAULT '0',
  `Content` text NOT NULL,
  `pflicht` text NOT NULL,
  `position` int(3) DEFAULT '99',
  `visibility` int(1) NOT NULL DEFAULT '1',
  `first` varchar(65) NOT NULL DEFAULT '',
  `publish` date DEFAULT NULL,
  `finish` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY  (`PART_ID`,`PAGE_ID`,`LANG_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=abschnitte # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "30", "0", "", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "", "2010-08-02", "0000-00-00"),
("0", "30", "1", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A3%3A%22Ort%22%3Bs%3A3%3A%22Ort%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A6%3A%22Senden%22%3Bs%3A6%3A%22Senden%22%3Bs%3A13%3A%22Fehlermeldung%22%3Bs%3A36%3A%22Bitte+f%FCllen+Sie+folgende+Felder+aus%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A94%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AKontaktdaten%3A%0D%0A%23NAME%23%0D%0A%23STRASSE%23%0D%0A%23ORT%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AE-Mail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "Name", "2010-08-02", "0000-00-00"),
("0", "30", "3", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A6%3A%22Street%22%3Bs%3A3%3A%22Ort%22%3Bs%3A5%3A%22Place%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A9%3A%22Telephone%22%3Bs%3A5%3A%22Email%22%3Bs%3A5%3A%22Email%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A7%3A%22Subject%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A7%3A%22Message%22%3Bs%3A6%3A%22Senden%22%3Bs%3A4%3A%22Send%22%3Bs%3A13%3A%22Fehlermeldung%22%3Bs%3A24%3A%22Please+fill+these+fields%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A77%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AKontaktdaten+von+%23NAME%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AEmail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "Name", "2010-08-02", "0000-00-00"),
("0", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A45%3A%22Danke%2C+Ihre+Nachricht+ist+abgeschickt+worden.%22%3B%7D", "", "10", "1", "Danke, Ihre Nachricht ist abgeschickt worden.", "2010-09-09", "0000-00-00"),
("0", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A37%3A%22Thank+you.+The+Message+has+been+send.%22%3B%7D", "", "10", "1", "Thank you. The Message has been send.", "2010-09-09", "0000-00-00"),
("0", "76", "0", "", "", "99", "1", "", "2010-09-09", "0000-00-00"),
("0", "76", "1", "a%3A14%3A%7Bs%3A7%3A%22Springe%22%3Bs%3A7%3A%22Springe%22%3Bs%3A9%3A%22Zuminhalt%22%3Bs%3A10%3A%22zum+Inhalt%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A8%3A%22zum+Men%FC%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A7%3A%22%A7FIRMA%A7%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A3%3A%22Web%22%3Bs%3A3%3A%22Web%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A8%3A%22Nachoben%22%3Bs%3A1%3A%22%5E%22%3Bs%3A7%3A%22Voriges%22%3Bs%3A1%3A%22%3C%22%3Bs%3A9%3A%22Folgendes%22%3Bs%3A1%3A%22%3E%22%3Bs%3A3%3A%22Und%22%3Bs%3A3%3A%22und%22%3Bs%3A4%3A%22Oder%22%3Bs%3A4%3A%22oder%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A16%3A%22Bitte+ausf%FCllen.%22%3B%7D", "", "99", "1", "Springe", "2010-09-09", "0000-00-00"),
("0", "76", "3", "a%3A14%3A%7Bs%3A9%3A%22Zuminhalt%22%3Bs%3A10%3A%22to+content%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A7%3A%22to+menu%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A26%3A%22Personalied+Indian+Cuisine%22%3Bs%3A11%3A%22Description%22%3Bs%3A35%3A%22Personalied+Indian+Cuisine+Hannover%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A35%3A%22indian%2C+homemade%2C+cooking%2C+hannover%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A6%3A%22Mobile%22%3Bs%3A3%3A%22Web%22%3Bs%3A3%3A%22Web%22%3Bs%3A5%3A%22Email%22%3Bs%3A5%3A%22Email%22%3Bs%3A3%3A%22Und%22%3Bs%3A3%3A%22and%22%3Bs%3A4%3A%22Oder%22%3Bs%3A2%3A%22or%22%3Bs%3A17%3A%22Googleverfication%22%3Bs%3A43%3A%22TmPSiB8pJLZxLYK0anUyi6Bjn2TGmLYEK4bmIZQ6jAk%22%3Bs%3A15%3A%22Bingverfication%22%3Bs%3A32%3A%2246AAFDC8403819202357057854E56EFD%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A1%3A%22%2A%22%3B%7D", "", "99", "1", "to content", "2010-09-09", "0000-00-00"),
("1", "2", "1", "a%3A6%3A%7Bs%3A21%3A%22Passwortvergessen_fck%22%3Bs%3A143%3A%22%3Cp%3EBitte+geben+Sie+die+E-Mail+Adresse+an+mit+der+Sie+sich+bei+%A7DOMAIN%A7+registriert+haben.%3Cbr+%2F%3E%0D%0ADas+neue+Passwort+erhalten+Sie+per+E-Mail.%3C%2Fp%3E%22%3Bs%3A8%3A%22Benutzer%22%3Bs%3A24%3A%22Benutzername+oder+E-Mail%22%3Bs%3A8%3A%22Anfragen%22%3Bs%3A14%3A%22Anfrage+senden%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A34%3A%22Bitte+f%FCllen+Sie+diese+Felder+aus.%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A31%3A%22Ihr+neues+Passwort+f%FCr+%A7DOMAIN%A7%22%3Bs%3A10%3A%22Email_text%22%3Bs%3A54%3A%22Halllo+%23NAME%23%2C%0D%0A%0D%0ADas+neue+Passwort+lautet%3A+%23PASSWORT%23%22%3B%7D", "", "99", "1", "Bitte geben Sie die E-Mail Adresse an mit der Sie sich bei ...", "2013-11-15", "0000-00-00"),
("1", "2", "3", "a%3A5%3A%7Bs%3A21%3A%22Passwortvergessen_fck%22%3Bs%3A143%3A%22%3Cp%3EBitte+geben+Sie+die+E-Mail+Adresse+an+mit+der+Sie+sich+bei+%A7DOMAIN%A7+registriert+haben.%3Cbr+%2F%3E%0D%0ADas+neue+Passwort+erhalten+Sie+per+E-Mail.%3C%2Fp%3E%22%3Bs%3A8%3A%22Benutzer%22%3Bs%3A24%3A%22Benutzername+oder+E-Mail%22%3Bs%3A8%3A%22Anfragen%22%3Bs%3A14%3A%22Anfrage+senden%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A31%3A%22Ihr+neues+Passwort+f%FCr+%A7DOMAIN%A7%22%3Bs%3A10%3A%22Email_text%22%3Bs%3A54%3A%22Halllo+%23NAME%23%2C%0D%0A%0D%0ADas+neue+Passwort+lautet%3A+%23PASSWORT%23%22%3B%7D", "", "99", "1", "Bitte geben Sie die E-Mail Adresse an mit der Sie sich bei ...", "2013-11-15", "0000-00-00"),
("1", "4", "3", "a%3A14%3A%7Bs%3A4%3A%22Agbs%22%3Bs%3A20%3A%22Terms+and+Conditions%22%3Bs%3A12%3A%22Deliverydate%22%3Bs%3A4%3A%22Date%22%3Bs%3A11%3A%22Agbsbekannt%22%3Bs%3A36%3A%22Terms+and+Conditions+were+confirmed.%22%3Bs%3A8%3A%22Agbs_fck%22%3Bs%3A95%3A%22%3Cp%3Eplease+agree+to+our%26nbsp%3B%3Ca+href%3D%22%23LINKTO%3A10%23%22%3Eterms+and+conditions%3C%2Fa%3E+before+ordering.%3C%2Fp%3E%22%3Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A5%3A%22Phone%22%3Bs%3A5%3A%22Phone%22%3Bs%3A9%3A%22Kopie_fck%22%3Bs%3A150%3A%22%3Cp%3EYou+will+recieve+a+copy+of+your+order+for+reference.+Please+also+check+your+spam+folder+if+not+or+get+back+to+us+to+confirm+your+email+address.%3C%2Fp%3E%22%3Bs%3A7%3A%22Message%22%3Bs%3A21%3A%22Comments+and+Requests%22%3Bs%3A4%3A%22Send%22%3Bs%3A12%3A%22send+request%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A29%3A%22Please+fill+out+these+fileds.%22%3Bs%3A7%3A%22Subject%22%3Bs%3A12%3A%22Menu+Request%22%3Bs%3A6%3A%22Thanks%22%3Bs%3A24%3A%22Thanks+for+your+request.%22%3Bs%3A8%3A%22Mail_fck%22%3Bs%3A752%3A%22%3Cp%3EHi+%23NAME%23%2C%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3Ethank+you+for+your+request+at+%A7FIRMA%A7+on+the+%A7DATUM%3Ad.m.Y%A7.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3EYour+Order%3A%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%A7GET_SECTIONS%3APAGE_ID%3D5%3BKEY%3D%23MENU%23%3BFELD%3D%A7%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3EExtras%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%A7GET_SECTIONS%3APAGE_ID%3D7%3BKEY%3D%23EXTRAS%23%3BFELD%3D%A7%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3ENumber+of+Portions%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%A7GET_SECTIONS%3APAGE_ID%3D8%3BKEY%3D%23PORTIONS%23%3BFELD%3D%A7%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3ELevel+of+Spicyness%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%A7GET_SECTIONS%3APAGE_ID%3D9%3BKEY%3D%23SPICYNESS%23%3BFELD%3D%A7%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3EDate+%2F+Pickup%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%23DATE%23+at+6+pm.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3EComment%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%23MESSAGE%23%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%3Cstrong%3EPayment%26%238203%3B%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3ECash+on+pickup.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EWith+love%3Cbr+%2F%3E%0D%0AYour+%A7FIRMA%A7%3C%2Fp%3E%22%3B%7D", "AGBS,NAME,EMAIL,PHONE", "99", "1", "Terms and Conditions", "2018-10-12", "0000-00-00"),
("1", "5", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A48%3A%22Vegetarian+%28Dhal%2C+Vegetable+Curry%2C+Basmati+Rice%29%22%3B%7D", "", "1", "1", "Vegetarian (Dhal, Vegetable Curry, Basmati Rice)", "2018-10-10", "0000-00-00"),
("1", "7", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A6%3A%22Snacks%22%3B%7D", "", "1", "1", "Snacks", "2018-10-10", "0000-00-00"),
("1", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A11%3A%221+%2815.99+%80%29%22%3B%7D", "", "1", "1", "1 (15.99 �)", "2018-10-10", "0000-00-00"),
("1", "9", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A1%3A%221%22%3B%7D", "", "1", "1", "1", "2018-10-10", "0000-00-00"),
("1", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A30%3A%22Bitte+gebe+Sie+Ihren+Namen+an.%22%3B%7D", "", "1", "1", "Bitte gebe Sie Ihren Namen an.", "2010-09-09", "0000-00-00"),
("1", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A20%3A%22Please+enter+a+name.%22%3B%7D", "", "1", "1", "Please enter a name.", "2010-09-09", "0000-00-00"),
("1", "103", "1", "a%3A2%3A%7Bs%3A9%3A%22Cangefreq%22%3Bs%3A6%3A%22weekly%22%3Bs%3A7%3A%22Prority%22%3Bs%3A3%3A%220.5%22%3B%7D", "", "99", "1", "weekly", "2010-08-06", "0000-00-00"),
("1", "103", "3", "a%3A2%3A%7Bs%3A9%3A%22Cangefreq%22%3Bs%3A6%3A%22weekly%22%3Bs%3A7%3A%22Prority%22%3Bs%3A3%3A%220.5%22%3B%7D", "", "99", "1", "weekly", "2010-08-06", "0000-00-00"),
("1", "104", "1", "a%3A2%3A%7Bs%3A15%3A%22Anweisungen_raw%22%3Bs%3A74%3A%22User-agent%3A+%2A%0D%0ADisallow%3A+%2Fimages%2F%0D%0ADisallow%3A+%2Fintern%2F%0D%0ADisallow%3A+script.js%22%3Bs%3A14%3A%22Sitemap_select%22%3Bs%3A3%3A%22103%22%3B%7D", "", "99", "1", "User-agent: *
Disallow: /images/
Disallow: /intern/
Disallow:", "2010-08-06", "0000-00-00"),
("1", "104", "3", "a%3A2%3A%7Bs%3A15%3A%22Anweisungen_raw%22%3Bs%3A74%3A%22User-agent%3A+%2A%0D%0ADisallow%3A+%2Fimages%2F%0D%0ADisallow%3A+%2Fintern%2F%0D%0ADisallow%3A+script.js%22%3Bs%3A14%3A%22Sitemap_select%22%3Bs%3A3%3A%22103%22%3B%7D", "", "99", "1", "User-agent: *
Disallow: /images/
Disallow: ...", "2010-08-06", "0000-00-00"),
("1", "106", "1", "a%3A6%3A%7Bs%3A21%3A%22Passwortvergessen_fck%22%3Bs%3A152%3A%22%3Cp%3EBitte+geben+Sie+die+E-Mail+Adresse+an+mit+der+Sie+sich+bei+%A7DOMAIN%A7+registriert+haben.%26%23160%3B%3Cbr+%2F%3E%0D%0ADas+neue+Passwort+erhalten+Sie+per+E-Mail+zu.%3C%2Fp%3E%22%3Bs%3A8%3A%22Benutzer%22%3Bs%3A23%3A%22Benutzername+oder+Email%22%3Bs%3A8%3A%22Anfragen%22%3Bs%3A14%3A%22Anfrage+senden%22%3Bs%3A13%3A%22Pflichtfelder%22%3Bs%3A34%3A%22Bitte+f%FCllen+Sie+diese+Felder+aus.%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A31%3A%22Ihr+neues+Passwort+f%FCr+%A7DOMAIN%A7%22%3Bs%3A10%3A%22Email_text%22%3Bs%3A54%3A%22Halllo+%23NAME%23%2C%0D%0A%0D%0ADas+neue+Passwort+lautet%3A+%23PASSWORT%23%22%3B%7D", "", "99", "1", "Bitte geben Sie die E-Mail Adresse an mit der Sie sich bei ...", "2010-09-09", "0000-00-00"),
("1", "112", "0", "", "", "99", "1", "", "2011-08-10", "0000-00-00"),
("1", "112", "1", "a%3A3%3A%7Bs%3A12%3A%22Benutzername%22%3Bs%3A8%3A%22Benutzer%22%3Bs%3A8%3A%22Passwort%22%3Bs%3A8%3A%22Passwort%22%3Bs%3A9%3A%22Einloggen%22%3Bs%3A9%3A%22Einloggen%22%3B%7D", "", "99", "1", "Benutzer", "2011-08-10", "0000-00-00"),
("1", "112", "3", "a%3A3%3A%7Bs%3A12%3A%22Benutzername%22%3Bs%3A4%3A%22User%22%3Bs%3A8%3A%22Passwort%22%3Bs%3A8%3A%22Password%22%3Bs%3A9%3A%22Einloggen%22%3Bs%3A6%3A%22Log-in%22%3B%7D", "", "99", "1", "User", "2011-08-10", "0000-00-00"),
("1", "114", "0", "", "", "99", "1", "", "2013-11-14", "0000-00-00"),
("1", "114", "1", "a%3A1%3A%7Bs%3A8%3A%22Bingauth%22%3Bs%3A32%3A%22602063BD9369FBE0AAFDA26A72EFDE19%22%3B%7D", "", "99", "1", "602063BD9369FBE0AAFDA26A72EFDE19", "2013-11-14", "0000-00-00"),
("1", "114", "3", "a%3A1%3A%7Bs%3A8%3A%22Bingauth%22%3Bs%3A32%3A%22602063BD9369FBE0AAFDA26A72EFDE19%22%3B%7D", "", "99", "1", "602063BD9369FBE0AAFDA26A72EFDE19", "2013-11-14", "0000-00-00"),
("2", "5", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A44%3A%22Non-Vegetarian+%28Chicken+Curry%2C+Basmati+Rice%29%22%3B%7D", "", "2", "1", "Non-Vegetarian (Chicken Curry, Basmati Rice)", "2018-10-10", "0000-00-00"),
("2", "7", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A26%3A%22Raitha+%28Yoghurt%2C+Cucumber%29%22%3B%7D", "", "2", "1", "Raitha (Yoghurt, Cucumber)", "2018-10-10", "0000-00-00"),
("2", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A11%3A%222+%2829.99+%80%29%22%3B%7D", "", "2", "1", "2 (29.99 �)", "2018-10-10", "0000-00-00"),
("2", "9", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A1%3A%222%22%3B%7D", "", "2", "1", "2", "2018-10-10", "0000-00-00"),
("2", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A35%3A%22Ihr+Name+enth%E4lt+ung%FCltige+Zeichen.%22%3B%7D", "", "2", "1", "Ihr Name enth�lt ung�ltige Zeichen.", "2010-09-09", "0000-00-00"),
("2", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22Your+name+seems+to+contain+invalid+characters.%22%3B%7D", "", "2", "1", "Your name seems to contain invalid characters.", "2010-09-09", "0000-00-00"),
("2", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A16%3A%22nicht+angemeldet%22%3B%7D", "", "0", "1", "nicht angemeldet", "2011-12-16", "0000-00-00"),
("2", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22other%22%3B%7D", "", "0", "1", "other", "2011-12-16", "0000-00-00"),
("3", "5", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A43%3A%22Home-Sick-Menu+%28Please+specify+in+comments%29%22%3B%7D", "", "3", "1", "Home-Sick-Menu (Please specify in comments)", "2018-10-10", "0000-00-00"),
("3", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A11%3A%223+%2842.99+%80%29%22%3B%7D", "", "3", "1", "3 (42.99 �)", "2018-10-10", "0000-00-00"),
("3", "9", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A1%3A%223%22%3B%7D", "", "3", "1", "3", "2018-10-10", "0000-00-00"),
("3", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22Ihre+Ortsbezeichnung+enth%E4lt+ung%FCltige+Zeichen%22%3B%7D", "", "3", "1", "Ihre Ortsbezeichnung enth�lt ung�ltige Zeichen", "2010-09-09", "0000-00-00"),
("3", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A59%3A%22The+name+of+your+place+seems+to+contain+invalid+characters.%22%3B%7D", "", "3", "1", "The name of your place seems to contain invalid characters.", "2010-09-09", "0000-00-00"),
("3", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A4%3A%22Gast%22%3B%7D", "", "1", "1", "Gast", "2018-10-07", "0000-00-00"),
("3", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22guest%22%3B%7D", "", "1", "1", "guest", "2018-10-07", "0000-00-00"),
("4", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A11%3A%224+%2855.99+%80%29%22%3B%7D", "", "4", "1", "4 (55.99 �)", "2018-10-10", "0000-00-00"),
("4", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A47%3A%22Sie+haben+keine+g%FCltige+Emailadresse+angegeben.%22%3B%7D", "", "4", "1", "Sie haben keine g�ltige Emailadresse angegeben.", "2010-09-09", "0000-00-00"),
("4", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A36%3A%22This+seems+not+to+be+a+email+address%22%3B%7D", "", "4", "1", "This seems not to be a email address", "2010-09-09", "0000-00-00"),
("4", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A6%3A%22Editor%22%3B%7D", "", "88", "1", "Editor", "2018-10-07", "0000-00-00"),
("4", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A6%3A%22Editor%22%3B%7D", "", "88", "1", "Editor", "2018-10-07", "0000-00-00"),
("5", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A11%3A%225+%2869.99+%80%29%22%3B%7D", "", "5", "1", "5 (69.99 �)", "2018-10-10", "0000-00-00"),
("5", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A50%3A%22Sie+haben+keine+g%FCltige+Telefonnummer+angegeben.++%22%3B%7D", "", "5", "1", "Sie haben keine g�ltige Telefonnummer angegeben.", "2010-09-09", "0000-00-00"),
("5", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22This+seems+not+to+be+a+valid+telephone+number.%22%3B%7D", "", "5", "1", "This seems not to be a valid telephone number.", "2010-09-09", "0000-00-00"),
("5", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22Admin%22%3B%7D", "", "99", "1", "Admin", "2018-10-07", "0000-00-00"),
("5", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22Admin%22%3B%7D", "", "99", "1", "Admin", "2018-10-07", "0000-00-00"),
("6", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A11%3A%226+%2885.99+%80%29%22%3B%7D", "", "6", "1", "6 (85.99 �)", "2018-10-10", "0000-00-00"),
("6", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A32%3A%22Bitte+geben+Sie+ein+Betreff+ein.%22%3B%7D", "", "8", "1", "Bitte geben Sie ein Betreff ein.", "2010-09-09", "0000-00-00"),
("6", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A23%3A%22Please+enter+a+subject.%22%3B%7D", "", "8", "1", "Please enter a subject.", "2010-09-09", "0000-00-00"),
("7", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A12%3A%227+%28105.99+%80%29%22%3B%7D", "", "7", "1", "7 (105.99 �)", "2018-10-10", "0000-00-00"),
("7", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A45%3A%22Die+Seite+konnte+leider+nicht+gefunden+werden%22%3B%7D", "", "404", "1", "Die Seite konnte leider nicht gefunden werden", "2010-09-09", "0000-00-00"),
("7", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A27%3A%22The+page+could+not+be+found%22%3B%7D", "", "404", "1", "The page could not be found", "2010-09-09", "0000-00-00"),
("8", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A12%3A%228+%28115.99+%80%29%22%3B%7D", "", "8", "1", "8 (115.99 �)", "2018-10-10", "0000-00-00"),
("8", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A35%3A%22Bitte+geben+Sie+eine+Nachricht+ein.%22%3B%7D", "", "9", "1", "Bitte geben Sie eine Nachricht ein.", "2010-09-09", "0000-00-00"),
("8", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A23%3A%22Please+enter+a+message.%22%3B%7D", "", "9", "1", "Please enter a message.", "2010-09-09", "0000-00-00"),
("9", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A12%3A%229+%28125.99+%80%29%22%3B%7D", "", "9", "1", "9 (125.99 �)", "2018-10-10", "0000-00-00"),
("9", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A37%3A%22Bitte+f%FCllen+Sie+folgende+Felder+aus%3A%22%3B%7D", "", "20", "1", "Bitte f�llen Sie folgende Felder aus:", "2010-09-09", "0000-00-00"),
("9", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A33%3A%22Please+fill+the+following+fields%3A%22%3B%7D", "", "20", "1", "Please fill the following fields:", "2010-09-09", "0000-00-00"),
("10", "8", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A13%3A%2210+%28129.99+%80%29%22%3B%7D", "", "10", "1", "10 (129.99 �)", "2018-10-10", "0000-00-00"),
("10", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A50%3A%22Sie+haben+keine+g%FCltige+Mobilfunknummer+angegeben.%22%3B%7D", "", "6", "1", "Sie haben keine g�ltige Mobilfunknummer angegeben.", "2010-09-09", "0000-00-00"),
("10", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A49%3A%22This+seems+not+to+be+a+valid+mobile+phone+number.%22%3B%7D", "", "6", "1", "This seems not to be a valid mobile phone number.", "2010-09-09", "0000-00-00"),
("19", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A9%3A%22Bis+Bald.%22%3B%7D", "", "100", "1", "Bis Bald.", "2010-09-09", "0000-00-00"),
("19", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A9%3A%22Good+bye.%22%3B%7D", "", "100", "1", "Good bye.", "2010-09-09", "0000-00-00"),
("20", "53", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A47%3A%22Ihre+neuen+Zugangsdaten+sind+verschickt+worden.%22%3B%7D", "", "62", "1", "Ihre neuen Zugangsdaten sind verschickt worden.", "2010-09-09", "0000-00-00"),
("20", "53", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A32%3A%22Your+new+password+has+been+send.%22%3B%7D", "", "62", "1", "Your new password has been send.", "2010-09-09", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#bilder`;
-- # Schnipp --
CREATE TABLE `#PREFIX#bilder` (
  `BILD_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `LANG_ID` smallint(5) NOT NULL DEFAULT '1',
  `PART_ID` varchar(32) NOT NULL DEFAULT '0',
  `Position` smallint(3) NOT NULL DEFAULT '0',
  `Dateiname` varchar(65) NOT NULL DEFAULT '',
  `visibility` int(1) DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`BILD_ID`),
  KEY `PART_ID` (`PART_ID`),
  KEY `PAGE_ID` (`PAGE_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=bilder # --
INSERT INTO `#PREFIX#bilder` (`BILD_ID`,`PAGE_ID`,`LANG_ID`,`PART_ID`,`Position`,`Dateiname`,`visibility`,`views`) VALUES
("1", "76", "1", "hintergrund", "0", "hintergrund_1_feuerspuren_1.jpg", "1", "0"),
("2", "76", "1", "0", "0", "logo_bild_Kunstler_gesucht_Logo.png", "1", "0"),
("3", "1", "1", "hintergrund", "0", "hintergrund_1_04-20.jpg", "1", "0"),
("4", "30", "1", "hintergrund", "0", "hintergrund_1_DSC9689.JPG", "1", "0");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#dateien`;
-- # Schnipp --
CREATE TABLE `#PREFIX#dateien` (
  `DATEI_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `PART_ID` smallint(5) NOT NULL DEFAULT '0',
  `Position` smallint(3) NOT NULL DEFAULT '0',
  `Dateiname` varchar(65) NOT NULL DEFAULT '',
  `visibility` int(1) DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`DATEI_ID`),
  KEY `PAGE_ID` (`PAGE_ID`),
  KEY `PART_ID` (`PART_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --


DROP TABLE IF EXISTS `#PREFIX#kategorien`;
-- # Schnipp --
CREATE TABLE `#PREFIX#kategorien` (
  `KAT_ID` smallint(5) NOT NULL DEFAULT '0',
  `LANG_ID` smallint(5) NOT NULL DEFAULT '0',
  `Titel` varchar(255) NOT NULL DEFAULT '',
  `Beschreibung` varchar(255) NOT NULL DEFAULT '',
  `position` smallint(2) NOT NULL DEFAULT '99',
  `visibility` smallint(1) NOT NULL DEFAULT '1',
  `follow` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(15) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`KAT_ID`,`LANG_ID`),
  KEY `KAT_ID` (`KAT_ID`),
  KEY `LANG_ID` (`LANG_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=kategorien # --
INSERT INTO `#PREFIX#kategorien` (`KAT_ID`,`LANG_ID`,`Titel`,`Beschreibung`,`position`,`visibility`,`follow`,`status`) VALUES
("1", "0", "Start", "", "1", "1", "1", "0"),
("2", "0", "Inhalte", "", "2", "1", "1", "0"),
("3", "0", "sonstige", "Weitere Seiten", "5", "1", "0", "0"),
("4", "0", "CMS", "f�r das CMS", "4", "0", "0", "88,99"),
("5", "0", "Intern", "nur f�r Mitarbeiter", "3", "1", "0", "1,88,99");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#person`;
-- # Schnipp --
CREATE TABLE `#PREFIX#person` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LANG_ID` smallint(5) DEFAULT '1',
  `Firma` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Name` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Strasse` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Ort` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Telefon` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Fax` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Mobil` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Email` varchar(128) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `www` varchar(128) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Login` varchar(65) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `Passwort` varchar(255) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `anmeldung` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` smallint(2) DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `kontakt` tinyint(1) DEFAULT '0',
  `impressum` tinyint(1) DEFAULT '0',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`),
  KEY `Ort` (`Ort`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
-- # Schnipp --

-- # DUMP=person # --
INSERT INTO `#PREFIX#person` (`ID`,`LANG_ID`,`Firma`,`Name`,`Strasse`,`Ort`,`Telefon`,`Fax`,`Mobil`,`Email`,`www`,`Login`,`Passwort`,`anmeldung`,`status`,`verified`,`kontakt`,`impressum`) VALUES
("2", "3", "Agentur f�r Kreative", "Marcus Haas", "Fl�ggestr. 14", "30161 Hannover", "0421 / 3871360", "", "0162 / 95 75 407", "wir@agentur-fuer-kreative.de", "www.agentur-fuer-kreative.de", "Marcus", "298b5d48b7ed8465bbc3d2200d0c4a95b308c448:10000:sha1:ddd122ecb4a9c79f7f4a230bb0d6318dac29ca21", "2007-05-16 07:00:56", "99", "1", "1", "1");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#plugins__addcolor`;
-- # Schnipp --
CREATE TABLE `#PREFIX#plugins__addcolor` (
  `PAGE_ID` mediumint(5) NOT NULL,
  `color_ID` varchar(15) NOT NULL DEFAULT '0',
  `color` varchar(15) NOT NULL,
  PRIMARY KEY  (`PAGE_ID`,`color_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=plugins__addcolor # --
INSERT INTO `#PREFIX#plugins__addcolor` (`PAGE_ID`,`color_ID`,`color`) VALUES
("0", "line", "#b0cb1f"),
("0", "menu", "#e77817"),
("0", "text", "#e77817"),
("1", "line", "#b0cb1f"),
("1", "menu", "#e77817"),
("1", "text", "#f8d5b6"),
("2", "line", "#b0cb1f"),
("2", "menu", "#e77817"),
("2", "text", "#e77817"),
("3", "line", "#1f5ecc"),
("3", "menu", "#fa006c"),
("3", "text", "#d6adbc"),
("4", "line", "#b0cb1f"),
("4", "menu", "#a5f198"),
("4", "text", "#caf2d4"),
("5", "line", "#b0cb1f"),
("5", "menu", "#3a916c"),
("5", "text", "#5ca58b"),
("6", "line", "#b0cb1f"),
("6", "menu", "#75c5f0"),
("6", "text", "#c5d8e0"),
("7", "line", "#b0cb1f"),
("7", "menu", "#e77817"),
("7", "text", "#ff7817"),
("8", "line", "#b0cb1f"),
("8", "menu", "#dd2f59"),
("8", "text", "#dd2f59"),
("9", "line", "#b0cb1f"),
("9", "menu", "#e77817"),
("9", "text", "#e77817"),
("10", "line", "#b0cb1f"),
("10", "menu", "#e77817"),
("10", "text", "#dc85d0"),
("11", "line", "#b0cb1f"),
("11", "menu", "#e77817"),
("11", "text", "#67b3f6"),
("12", "line", "#b0cb1f"),
("12", "menu", "#e77817"),
("12", "text", "#e77817"),
("13", "line", "#b0cb1f"),
("13", "menu", "#e77817"),
("13", "text", "#e77817"),
("30", "line", "#b0cb1f"),
("30", "menu", "#1de764"),
("30", "text", "#a6e6bf"),
("54", "line", "#b0cb1f"),
("54", "menu", "#e58b3c"),
("54", "text", "#f4c193"),
("56", "line", "#b0cb1f"),
("56", "menu", "#e77817"),
("56", "text", "#e77817"),
("76", "line", "#b0cb1f"),
("76", "menu", "#e77817"),
("76", "text", "#e77817"),
("99", "line", "#b0cb1f"),
("99", "menu", "#e77817"),
("99", "text", "#e77817"),
("103", "line", "#b0cb1f"),
("103", "menu", "#e77817"),
("103", "text", "#e77817"),
("104", "line", "#b0cb1f"),
("104", "menu", "#e77817"),
("104", "text", "#e77817"),
("112", "line", "#b0cb1f"),
("112", "menu", "#e77817"),
("112", "text", "#ffff80"),
("114", "line", "#b0cb1f"),
("114", "menu", "#e77817"),
("114", "text", "#e77817");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten` (
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `LANG_ID` smallint(5) NOT NULL DEFAULT '0',
  `editor_ID` int(11) NOT NULL,
  `Titel` varchar(127) DEFAULT NULL,
  `Ueberschrift` varchar(255) NOT NULL DEFAULT '',
  `Kurzname` varchar(127) NOT NULL DEFAULT '',
  `Menu` varchar(127) NOT NULL DEFAULT '',
  `AK` varchar(3) NOT NULL,
  `Text` text NOT NULL,
  `Beschreibung` varchar(255) NOT NULL DEFAULT '',
  `insdate` datetime NOT NULL,
  `lastmod` datetime DEFAULT NULL,
  `fix_kn` int(1) NOT NULL,
  PRIMARY KEY  (`PAGE_ID`,`LANG_ID`),
  KEY `PAGE_ID` (`PAGE_ID`,`LANG_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("1", "1", "2", "home", "Wir bringen K�nster und Kunden zusammen", "home", "home", "", "<p>Wir bringen K�nster und Kunden zusammen</p>
", "Wir bringen K�nster und Kunden zusammen", "2010-11-25 00:00:00", "2019-07-05 11:32:31", "0"),
("1", "3", "2", "home", "Welcome", "home", "home", "", "<p>Hi! I'm Bosi. Welcome to my kitchen! I love to cook and hope to share my expertise, experience and experiments with you.</p>

<p>Whether you want traditional indian cuisine or try some indian-western fusion foods, Bosi's Pic will provide you a wonderful personalized culinary experience. You choose the menu, the number of portions and the level of spiciness.</p>

<p>Taste the food, spread the word!</p>

<p>ENJOY!</p>
", "", "2018-10-07 00:00:00", "2018-11-19 19:36:42", "0"),
("2", "1", "2", "Passwort vergessen", "Passwort vergessen", "Passwort_vergessen", "Passwort vergessen", "", "", "", "2013-11-15 10:51:09", "2013-11-15 10:51:09", "0"),
("2", "3", "2", "forgot password", "", "forgot_password", "forgot password", "", "", "", "2018-10-14 00:00:00", "2018-10-14 20:12:11", "0"),
("4", "3", "2", "Was brauchts Du", "Was brauchts Du", "Was_brauchts_Du", "Was brauchts Du", "", "", "Was brauchts Du? Hier findest du den K�nstler f�r deine Veranstaltung", "2018-10-09 00:00:00", "2019-07-05 11:10:26", "0"),
("5", "3", "10", "Choose your Menu", "", "Menu", "Choose yor Menu", "", "", "", "2018-10-10 00:00:00", "2018-10-22 15:06:29", "1"),
("6", "1", "10", "about us", "about us", "about_us", "about us", "", "", "", "2016-03-01 00:00:00", "2018-10-07 16:02:29", "0"),
("6", "3", "2", "about us", "about us", "about_us", "about us", "", "", "", "2018-10-07 00:00:00", "2018-10-08 23:13:46", "0"),
("7", "3", "10", "Extras", "", "Extras", "Extras", "", "", "", "2018-10-10 00:00:00", "2018-10-10 10:48:29", "0"),
("8", "3", "10", "Number of Portions", "", "Portions", "Number of Portions", "", "", "", "2018-10-10 00:00:00", "2018-10-12 20:16:02", "1"),
("9", "3", "10", "Level of Spicyness", "", "Spicyness", "Level of Spicyness", "", "", "", "2018-10-10 00:00:00", "2018-10-12 20:16:19", "1"),
("10", "3", "10", "Terms and Conditions", "Terms and Conditions", "Terms_and_Conditions", "Terms and Conditions", "", "<p>All menu requests will be processed and responded to within 24 hours.</p>

<p>Your order will be prepared after your request and payment has been received, approved and confirmed. You will receive two confirmation emails: one automatic confirmation of menu request and two confirming your payment and order. Please note your order will be prepared only after payment confirmation.&nbsp;</p>

<p>Dishes may contain nuts. Please notify Bosi's PIC about dietary restrictions. Bosi's PIC is not liable for any complication from the consumption of our products.</p>

<p>Bosi's PIC has the right to deny a menu request without giving reasons.</p>

<p>All food is prepared according to applicable food codes and standards in Germany.</p>

<p>The food can be picked up at 6 or 7 pm on the date of delivery.&nbsp;</p>

<p>Cancellations of all orders have to be issued at least 48 hours before date of delivery. Failing which the payment will not be returned.</p>
", "", "2018-10-22 00:00:00", "2018-10-23 17:25:57", "0"),
("30", "1", "2", "Contact", "Contact", "Contact", "Contact", "", "<p>�NAME�<br />
�STRASSE�<br />
�ORT�</p>

<p>Mobil; �MOBIL�<br />
�EMAIL2�</p>

<p>�WWW2�</p>
", "", "2010-08-02 00:00:00", "2019-07-05 11:38:20", "0"),
("30", "3", "2", "contact", "contact", "contact", "contact", "", "<p>�NAME�<br />
�STRASSE�<br />
�ORT�</p>

<p>Mobil; �MOBIL�<br />
�EMAIL2�</p>

<p>�WWW2�</p>
", "", "2009-06-26 00:00:00", "2018-10-10 10:33:53", "0"),
("53", "1", "2", "Meldungen", "Meldungen", "Meldungen", "Meldungen", "", "", "Fehlermeldungen", "2010-09-09 00:00:00", "2011-08-08 07:59:26", "0"),
("53", "3", "2", "Error messages", "Error messages", "Error_messages", "Error messages", "E", "", "Error messages", "2009-06-26 00:00:00", "2011-09-23 09:45:08", "0"),
("54", "1", "10", "Imprint", "Imprint", "Imprint", "Imprint", "", "<p><strong>Verantwortlich f�r den Inhalt dieser Website:</strong></p>

<p>�NAME�<br />
�STRASSE�<br />
�ORT�<br />
<br />
<span style=\"font-size: 13px;\">Mobil&nbsp;&nbsp;&nbsp; �MOBIL�</span><br />
E-Mail: &nbsp;�EMAIL2�<br />
Internet: �WWW2�</p>

<p>&nbsp;</p>

<p>Grafische Gestaltung: <a href=\"http://www.grafik-ko.de\">Grafik &amp; Ko</a><br />
Web-Design and photos: <a href=\"http://www.webdesign-haas.de\">Marcus Haas</a></p>

<p>&nbsp;</p>

<p>&nbsp;</p>
", "", "2010-09-09 00:00:00", "2018-10-07 16:04:53", "0"),
("54", "3", "2", "imprint", "imprint", "imprint", "imprint", "", "<h2>Verantwortlich f�r den Inhalt dieser Website:</h2>

<p>�NAME�<br />
�STRASSE�<br />
�ORT�<br />
<br />
<span style=\"font-size: 13px;\">Mobil&nbsp;&nbsp;&nbsp; �MOBIL�</span><br />
E-Mail: &nbsp;�EMAIL2�<br />
Internet: �WWW2�</p>

<p>&nbsp;</p>

<p>Grafische Gestaltung: <a href=\"http://www.grafik-ko.de\">Grafik &amp; Ko</a><br />
Web-Design and photos: <a href=\"http://www.webdesign-haas.de\">Marcus Haas</a></p>

<p>&nbsp;</p>

<p>&nbsp;</p>
", "", "2018-10-07 00:00:00", "2018-10-10 10:34:16", "0"),
("56", "1", "0", "Logout", "Logout", "logout", "Logout", "", "", "Logout", "0000-00-00 00:00:00", "2008-04-06 09:30:07", "0"),
("56", "3", "2", "Logout", "Logout", "Logout", "Logout", "", "", "Logout", "2018-10-07 00:00:00", "2018-10-07 18:17:53", "0"),
("76", "1", "2", "alle Seiten", "alle Seiten", "alle_Seiten", "alle Seiten", "a", "", "alle Seiten", "2010-11-26 00:00:00", "2019-07-05 11:28:07", "0"),
("76", "3", "2", "all pages", "all pages", "all_pages", "all pages", "a", "", "alle Seiten", "2009-06-30 00:00:00", "2019-07-05 11:11:39", "0"),
("99", "1", "10", "Personenstatus", "Personenstatus", "Personenstatus", "Personenstatus", "", "", "", "0000-00-00 00:00:00", "2010-05-21 07:14:47", "0"),
("99", "3", "2", "person status", "", "person_status", "person status", "", "", "", "2018-10-07 00:00:00", "2018-10-14 20:11:21", "0"),
("103", "1", "2", "sitemap.xml", "", "sitemap.xml", "sitemap.xml", "", "", "", "0000-00-00 00:00:00", "2010-08-06 16:20:30", "1"),
("103", "3", "2", "sitemap.xml", "", "sitemap.xml", "sitemap.xml", "", "", "", "2018-10-07 00:00:00", "2018-10-07 18:18:57", "0"),
("104", "1", "2", "robots.txt", "", "robots.txt", "robots.txt", "", "", "", "0000-00-00 00:00:00", "2010-11-16 17:28:21", "1"),
("104", "3", "2", "robots.txt", "", "robots.txt", "robots.txt", "", "", "", "2018-10-07 00:00:00", "2018-10-07 18:18:52", "0"),
("112", "1", "2", "Login", "Login", "Login", "Login", "", "", "", "2011-08-10 00:00:00", "2016-03-05 14:16:30", "0"),
("112", "3", "2", "Login", "Login", "Login", "Login", "", "", "Log in here.", "2012-04-04 00:00:00", "2019-04-29 13:06:29", "0"),
("114", "1", "2", "BingSiteAuth.xml", "", "BingSiteAuth.xml", "BingSiteAuth.xml", "", "", "", "2013-11-14 00:00:00", "2016-04-08 17:34:44", "1"),
("114", "3", "2", "BingSiteAuth.xml", "", "BingSiteAuth.xml", "BingSiteAuth.xml", "", "", "", "2018-10-07 00:00:00", "2018-10-07 18:19:03", "0");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten_attr`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten_attr` (
  `PAGE_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `KAT_ID` smallint(5) NOT NULL DEFAULT '1',
  `TPL_ID` smallint(5) NOT NULL DEFAULT '1',
  `parent_ID` smallint(5) NOT NULL DEFAULT '0',
  `person_ID` int(11) NOT NULL DEFAULT '0',
  `position` smallint(3) DEFAULT '99',
  `order_by` varchar(9) NOT NULL,
  `visibility` smallint(1) DEFAULT '1',
  `status` smallint(1) DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  PRIMARY KEY  (`PAGE_ID`,`KAT_ID`,`TPL_ID`),
  KEY `lft` (`lft`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten_attr # --
INSERT INTO `#PREFIX#seiten_attr` (`PAGE_ID`,`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("1", "1", "1", "0", "2", "1", "PO_ASC", "1", "0", "1", "2"),
("2", "3", "81", "112", "2", "99", "", "1", "0", "32", "33"),
("4", "2", "6", "0", "2", "3", "", "1", "0", "5", "16"),
("5", "3", "43", "4", "10", "3", "PO_ASC", "1", "0", "8", "9"),
("6", "2", "1", "0", "10", "4", "", "0", "0", "17", "18"),
("7", "3", "43", "4", "10", "3", "PO_ASC", "1", "0", "10", "11"),
("8", "3", "43", "4", "10", "3", "PO_ASC", "1", "0", "12", "13"),
("9", "3", "43", "4", "10", "3", "PO_ASC", "1", "0", "14", "15"),
("10", "2", "1", "4", "10", "99", "", "1", "0", "6", "7"),
("30", "2", "5", "0", "2", "8", "PO_ASC", "1", "0", "19", "20"),
("53", "4", "43", "76", "2", "6", "PO_ASC", "1", "0", "26", "27"),
("54", "2", "1", "0", "10", "9", "PO_ASC", "1", "0", "21", "22"),
("56", "5", "1", "0", "2", "10", "", "1", "0", "23", "24"),
("76", "4", "49", "0", "2", "11", "PO_ASC", "1", "0", "25", "30"),
("99", "4", "43", "76", "2", "7", "PO_ASC", "1", "0", "28", "29"),
("103", "3", "78", "0", "2", "14", "PO_ASC", "1", "0", "37", "38"),
("104", "3", "79", "0", "2", "13", "PO_ASC", "1", "0", "35", "36"),
("112", "3", "44", "0", "2", "12", "PO_ASC", "1", "0", "31", "34"),
("113", "1", "83", "0", "2", "99", "", "1", "0", "3", "4"),
("114", "3", "83", "0", "2", "99", "", "1", "0", "39", "40");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten_personen`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten_personen` (
  `person_ID` varchar(15) NOT NULL,
  `attr` varchar(15) NOT NULL,
  `attr_ID` varchar(11) NOT NULL,
  PRIMARY KEY  (`person_ID`,`attr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten_personen # --
INSERT INTO `#PREFIX#seiten_personen` (`person_ID`,`attr`,`attr_ID`) VALUES
("2", "1_admin_mysql", "1"),
("2", "1_categories", "1"),
("2", "1_pages", "1"),
("2", "2_statistik", "1"),
("2", "2_templates", "1"),
("2", "3_bgimg", "1"),
("2", "3_languages", "1"),
("2", "3_translate", "1"),
("2", "4_presets", "1"),
("2", "KAT_ID", "alles"),
("2", "PAGE_ID", "alles"),
("2", "TPL_ID", "alles"),
("2", "addcolor", "1"),
("2", "bgimg", "1"),
("2", "bgimg2", "1"),
("2", "kats", "1"),
("2", "lang", "1"),
("2", "move", "1"),
("2", "neu", "1"),
("2", "pages", "1"),
("2", "rem", "1"),
("2", "subp", "1"),
("2", "such", "1"),
("2", "tpl", "1"),
("2", "vis", "1"),
("10", "1_pages", "1"),
("10", "KAT_ID", "alles"),
("10", "PAGE_ID", "eigene"),
("10", "TPL_ID", "alles"),
("10", "bgimg", "1"),
("10", "kats", "1"),
("10", "lang", "1"),
("10", "move", "1"),
("10", "pages", "1"),
("10", "rem", "1"),
("10", "subp", "1"),
("10", "such", "1"),
("10", "tpl", "1"),
("10", "vis", "1");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten_redirects`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten_redirects` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `ex_kurzname` varchar(65) NOT NULL DEFAULT '',
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten_redirects # --
INSERT INTO `#PREFIX#seiten_redirects` (`ID`,`ex_kurzname`,`PAGE_ID`) VALUES
("7", "kleine_Weisheiten2", "11"),
("8", "kleine_Weisheiten2", "11"),
("9", "Startseite", "1"),
("10", "Startseite", "1"),
("11", "Angebot", "3"),
("12", "Angebot", "3"),
("13", "Uber_mich", "6"),
("14", "Uber_mich", "6"),
("19", "Contact", "30"),
("20", "Contact", "30"),
("21", "Imprint", "54"),
("22", "Imprint", "54"),
("23", "Choose_yor_Menu", "5"),
("24", "Choose_yor_Menu", "5"),
("25", "Number_of_Portions", "8"),
("26", "Number_of_Portions", "8"),
("27", "Level_of_Spicyness", "9"),
("28", "Level_of_Spicyness", "9"),
("29", "Personenstatus", "99"),
("30", "Personenstatus", "99"),
("31", "Terms_and_conditions", "10"),
("32", "Terms_and_conditions", "10"),
("33", "your_order", "4"),
("34", "your_order", "4");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#vorgaben`;
-- # Schnipp --
CREATE TABLE `#PREFIX#vorgaben` (
  `name` varchar(65) NOT NULL,
  `value` varchar(65) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=vorgaben # --
INSERT INTO `#PREFIX#vorgaben` (`name`,`value`) VALUES
("abspaths", "0"),
("bildfixed", "width"),
("bildx", "800"),
("bildy", "800"),
("bodyclass", "text"),
("bodyid", "text"),
("checkdate", "0"),
("cleanword", "1"),
("compress", "1"),
("css_path", "templates/css"),
("exclude_paths", ""),
("excludepaths", "0"),
("fontformats", "p;h1;h2;h3"),
("forceplain", "0"),
("forum_seite", ""),
("forum_tpl", ""),
("freigabe_seite", ""),
("galeriebildx", "800"),
("galeriebildy", "800"),
("galeriefixed", "fit"),
("galerievorschaufixed", "width"),
("galerievorschaux", "500"),
("galerievorschauy", "500"),
("gbook_seite", ""),
("gesperrt_seite", ""),
("hintergrund2bildx", ""),
("hintergrund2bildy", ""),
("hintergrund2fixed", "fit"),
("hintergrundbildx", "1400"),
("hintergrundbildy", "1000"),
("hintergrundfixed", "cover"),
("https_domain", "0"),
("img_path", "images/bilder"),
("imgtitlerpl", "0"),
("js_path", "templates/js"),
("kalender_tpl", ""),
("kategal", "1"),
("kontakt_seite", "30"),
("last_change", "05.07.2019 11:39"),
("logout_seite", "112"),
("meldungen_seite", "53"),
("menubildx", ""),
("menubildy", ""),
("menufixed", "fit"),
("menuvorschaux", ""),
("menuvorschauy", ""),
("mysql_backup", "2019-07-05"),
("newsletter_tpl", ""),
("nleach", "1"),
("nlemail_tpl", ""),
("nohtmlsubp", "0"),
("nonumsubp", "0"),
("passwortvergessen_seite", "2"),
("redtexth", "500"),
("seiten_tpl", "49"),
("seitenzaehler", "0"),
("select_subject", "2"),
("select_tbs_1", "basic"),
("select_tbs_2", "mini"),
("showblocks", "1"),
("statistics_domain", "stats.beate-weidewitsch.de"),
("statistics_id", "0"),
("status_seite", "99"),
("statusaenderung_seite", ""),
("template", "<p><br /></p>"),
("texth", "800"),
("tpl_path", "templates/tpl"),
("verwaltung_sprache", "1"),
("videox", "400"),
("videoy", "300"),
("vorschaufixed", "width"),
("vorschaux", "500"),
("vorschauy", "500");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#vorlagen`;
-- # Schnipp --
CREATE TABLE `#PREFIX#vorlagen` (
  `TPL_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `position` smallint(5) NOT NULL DEFAULT '99',
  `Titel` varchar(255) NOT NULL DEFAULT '',
  `Beschreibung` varchar(255) NOT NULL DEFAULT '',
  `Template` text NOT NULL,
  `script` text NOT NULL,
  `styles` text,
  `JS` varchar(128) NOT NULL,
  `CSS` varchar(255) NOT NULL,
  `anzahl` smallint(5) NOT NULL DEFAULT '1',
  `proseite` smallint(5) NOT NULL,
  `showta` tinyint(1) NOT NULL DEFAULT '1',
  `neu` smallint(3) NOT NULL DEFAULT '0',
  `cache` tinyint(1) NOT NULL,
  `stats` tinyint(1) NOT NULL DEFAULT '1',
  `VorschauX` smallint(3) NOT NULL DEFAULT '0',
  `VorschauY` smallint(3) NOT NULL DEFAULT '0',
  `BildX` smallint(3) NOT NULL DEFAULT '0',
  `BildY` smallint(3) NOT NULL DEFAULT '0',
  `vorschaufixed` varchar(12) NOT NULL DEFAULT '',
  `bildfixed` varchar(12) NOT NULL DEFAULT '',
  UNIQUE KEY `TPL_ID` (`TPL_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`TPL_ID`,`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("1", "1", "Text", "Text", "
", "", "", "", "", "1", "0", "1", "0", "1", "1", "0", "0", "0", "0", "fit", "fit"),
("2", "6", "Start", "", "<!-- SUB=seitenvorlage --><h1>#UEBERSCHRIFT#</h1>
$ERROR$
#TEXT#\"<!-- /SUB -->
<!-- SUB=ticker -->�GET_VORLAGE:PAGE_ID=%AKTUELLES_SELECT:seiten%;anz=5;order_by=PUB_DESC;nocache=1�<!-- /SUB -->", "", "#top {
    right: 655px; height:360px;
    width:370px;
	z-index:10;
	background-size: 333px 246px; background-repeat:no-repeat; background-position:20px 85px;
}
.text {display:none;}
#topimg {position:absolute; top:156px; right: 340px;width:355px;height:500px;}
@media (max-width: 1024px) {
	#top {right:auto;left:0;}
}
@media (max-width: 960px) {
	#top {width:38%;background-size: 92% auto;background-position:center 85px;}
	#topimg {width:35%;left:35%;}
}
@media (max-width: 800px) {#top {height:330px;}}
@media (max-width: 720px) {#top {height:300px;}}
@media (max-width: 630px) {#top {height:270px;}}
@media (max-width: 540px) {#top {height:240px;}}
@media (max-width: 520px) {
	#headline ul {width:80% !important;left:10%;right:auto;padding-left:0;}
	#topimg {display:none;}
	#top {left:10%;width:80%;background-size: auto 62%;}
    #headline ul {animation: slidein .5s ease-out;}
}
@keyframes slidein {
  0% {padding-left:100%;}
  100% {padding-left:0;}
}", "", "", "1", "0", "1", "1", "1", "1", "0", "0", "0", "0", "fit", "fit"),
("3", "5", "News", "", "<div class=\"news\">%NACHRICHT_FCK:HEIGHT=200px%</div>
<!-- SUB=suffix -->�SUBNAV�<!-- /SUB -->

<!-- SUB=poptitle -->%TITEL%<!-- /SUB -->
<!-- SUB=popdesc -->%NACHRICHT_FCK:HEIGHT=200px%<!-- /SUB -->", "", ".news {padding-bottom:1em;display:block;clear:both}", "", "", "-1", "0", "0", "1", "0", "0", "500", "500", "800", "800", "fit", "fit"),
("4", "4", "Gallery", "", "<div class=\"block\" style=\"background-image: url(%HINTERGRUND_BILD%);background-color: %FARBE:IGNORE=#000000%\">
  �SHOW:IF=%TITEL%;TPL= <h3>%TITEL%</h3>�
  �SHOW:IF=%BESCHREIBUNG%;TPL=<p class=\"%POS_RADIO:Oben=top;Mitte=middle;Unten=bottom;IGNORE=top%\">%BESCHREIBUNG%</p>�
  �SHOW:IF=%HINTERGRUND_BILD%;TPL=<a class=\"lb\" href=\"��BIGIMG:%HINTERGRUND_BILD%��SHOW:IF=%HINTERGRUND_BILD%;TPL=\" target=\"_blank\">%TITEL%</a>�
</div>
<!-- SUB=saveignore -->#000000;top;middle;bottom<!-- /SUB -->", "if ($('.lb').length>0) {$('.lb').lightBox();}", ".text	 {width:auto;right:205px;width:980px; bottom:0;}
.text>div{background-color:rgba(0,0,0,0) !important;}
.text>h1 {display:none;}
.text>div{top:0px;padding:0;padding-left: 50px; left: -50px;}
.block {
	position:relative; background-repeat:no-repeat;background-size:cover;
	float:left;width:215px;height:215px;margin:0 25px 25px 0;
}
.block h3 {
	position:absolute;left:30px;bottom:15px;right:15px;
}
.block p {
	position:absolute;left:-5px;right:auto;
	background-color: rgba(255,255,255,0.66);
	padding:5px;
	white-space:pre; font-size:1.1em;
}
.block p.top {top:15px;}
.block p.middle {top:100px;}
.block p.bottom {bottom:15px;}
.block a {
	position:absolute;left:0;top:0;width:100%;height:100%;
	text-indent:-1000px;overflow:hidden;
}
@media  (min-width: 1185px) {
	.block:nth-child(4n) {margin-right:0}
}
@media (max-width: 1185px) and (min-width: 925px) {
	.text {width:740px;}
}
@media (max-width: 940px) {
	.text {right:205px;left:0;width:auto;}
}
@media (max-width: 940px) and (min-width: 895px) {
	.block:nth-child(3n) {margin-right:0}
}
@media (max-width: 915px) and (min-width: 600px) {
	.block {margin:0 15px 15px 0;}
}
@media (max-width: 850px) and (min-width: 600px) {
	.block:nth-child(even) {margin-right:0}
}
@media (max-width: 720px) {
	.text {right:30px;}
}
@media (max-width: 600px) {
	.block {width:103px;height:103px;margin:0 9px 9px 0;font-size:.9em}
    .block p {left:-20px;}
    .block p.top {top:15px;}
    .block p.middle {top:45px;}
    .block p.bottom {bottom:15px;}
	.block h3 {left:15px;}
}", "jquery/jquery.js
jquery/lightbox-0.5.min.js", "jquery/lightbox.css", "-1", "0", "0", "1", "1", "1", "220", "220", "800", "600", "cover", "fit"),
("5", "7", "Contact Form", "", "<!-- SUB=seitenvorlage --><article class=\"text\">
  <h1>#UEBERSCHRIFT#</h1>
  <div>
    $ERROR$
    #TEXT#
	�CONTACT�
  </div>
</article>
<div id=\"topimg\" �BGIMG:hintergrund2� /><!-- /SUB -->
<!-- SUB=googlemap --><div class=\"googlemap\">
<iframe width=\"100%\" height=\"300px\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"http://maps.google.de/maps?&q=�STRASSE�,+�ORT�&iwloc=0&fb=1&hl=�LANG�&hnear=&output=embed\"></iframe>
</div><!-- /SUB -->
<!-- SUB=mailform --><br /><br />
<form action=\"\" method=\"post\" style=\"clear:both\">
  �PHPSESSID�
  <p><label for=\"name\">%NAME%:     <input name=\"kontakt[name]\"    id=\"name\"    value=\"#NAME#\" /></label>
    <label for=\"strasse\">%STRASSE%:<input name=\"kontakt[strasse]\" id=\"strasse\" value=\"#STRASSE#\" /></label>
    <label for=\"ort\">%ORT%:        <input name=\"kontakt[ort]\"     id=\"ort\"     value=\"#ORT#\" /></label>
    <label for=\"telefon\">%TELEFON%:<input name=\"kontakt[telefon]\" id=\"telefon\" value=\"#TELEFON#\" /></label>    
    <label for=\"email\">%EMAIL%:    <input name=\"kontakt[email]\"   id=\"email\"   value=\"#EMAIL#\" /></label>
    <label for=\"betreff\">%BETREFF%:<input name=\"kontakt[betreff]\" id=\"betreff\" value=\"#BETREFF#\" /></label>
  </p>
  <p style=\"clear:both\"><label for=\"mitteilung\">%MITTEILUNG%:</label>
    <textarea style=\"float:left;width:23em\" name=\"kontakt[mitteilung]\" cols=\"36\" rows=\"6\" id=\"mitteilung\">#MITTEILUNG#</textarea><br /></p>
  <p style=\"clear:both;\"><input name=\"send\" type=\"submit\" value=\"%SENDEN%\" /></p>
  �PFLICHTFELDER�
</form>
<!-- /SUB -->
<!-- SUB=fehler -->%FEHLERMELDUNG%<!-- /SUB -->
<!-- SUB=emailbody -->%MAIL_TEXT%<!-- /SUB -->
<!-- SUB=bodyhtml --><html><head>
<div style=\"font-family:arial,sans-serif;\">
#MSG#
</div><!-- /SUB -->


<!-- SUB=bodyplain -->
#MSG#
<!-- /SUB -->
", "", ".text {width:705px; bottom:0;}
.fl {float:left;width:30%}
.fl:last-child {margin-left:5%;width:65%}

@media (max-width: 1062px) {
	.text {right:auto;left:0;}
}
@media (max-width: 920px) {
	.text {right:215px;width:auto;}
}
@media (max-width: 920px) {
	.text {right:215px;width:auto;}
	.fl {float:none;width:100%}
	.fl:last-child {margin-left:0;width:100%}
	.text p{float:left;width:50%;}
}
@media (max-width: 720px) {
	.text {right:35px;}
}", "", "", "1", "1", "1", "1", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("6", "2", "Order Form", "", "�CONTACT:form=order;tpl=mailform�

<!-- SUB=error_agbs -->%AGBS%<!--#AGBS#--><!-- /SUB -->
<!-- SUB=required_extra -->agbs<!-- /SUB -->
<!-- SUB=mailform --><form action=\"\" method=\"post\">
�PHPSESSID�
<section class=\"form\">
  �BRIDGE:tpl=selections;tpl_id=43�
  <p><label for=\"date\">%DELIVERYDATE%: <input name=\"order[date]\" id=\"date\" value=\"#DATE#\" type=\"date\" /></label></p>
  <p><label for=\"infos\"><input type=\"checkbox\" id=\"infos\" name=\"order[agbs]\" value=\"%AGBSBEKANNT%\" required=\"required\" />#STRIPP#%AGBS_FCK%#STRIPP#</label><br /></p>
  <p><label for=\"name\">%NAME%:  <input name=\"order[name]\"  id=\"name\"  value=\"#NAME#\" /></label>
    <label for=\"email\">%EMAIL%: <input name=\"order[email]\" id=\"email\" value=\"#EMAIL#\" type=\"email\" /></label>
    <label for=\"phone\">%PHONE%: <input name=\"order[phone]\" id=\"email\" value=\"#PHONE#\" type=\"phone\" /></label>
  </p>
  <p>%KOPIE_FCK% <input name=\"copy\" id=\"copy\" type=\"hidden\" checked=\"checked\" value=\"1\" /></p>
</section>
<p style=\"clear:both\"><label for=\"message\">%MESSAGE%:</label>
    <textarea style=\"float:left;width:23em\" name=\"order[message]\" cols=\"36\" rows=\"6\" id=\"message\">#MESSAGE#</textarea><br />
</p>
<p style=\"clear:both;margin-top:2em\"><input class=\"submit\" name=\"send\" type=\"submit\" id=\"send\" value=\"%SEND%\" /></p>
<p>�PFLICHTFELD� %PFLICHTFELDER_TEXT%</p>
</form><!-- /SUB -->


<!-- SUB=selections -->
  <p><b>$TITEL$</b>�SELECT_SECTIONS:PAGE_ID=$PAGE_ID$;KEY=order;FELD=$KN$;TYPE=radio�</p><!-- /SUB -->

<!-- SUB=subject -->%SUBJECT%<!-- /SUB -->
<!-- SUB=response -->%THANKS%<!-- /SUB -->
<!-- SUB=emailbody --><html><head><style type=\"text/css\">body {font-family:arial,sans-serif;}</style></head><body>
%MAIL_FCK:HEIGHT=400%
</body></html><!-- /SUB -->", "", "label {
	width: auto;
}
label input, label textarea, label select {
    position: relative;
	left:0;
    margin-right: .5em;
    max-width:100%;
}", "", "", "1", "1", "1", "1", "1", "1", "500", "500", "800", "800", "fit", "fit"),
("43", "11", "Data", "", "%FELD%", "", "", "", "", "-1", "0", "0", "1", "0", "0", "0", "0", "0", "0", "fit", "fit"),
("44", "8", "Login", "Login", "<form action=\"/login.php\" method=\"post\">
  <p><label for=\"login\">%BENUTZERNAME%: <input value=\"#BENUTZERNAME#\"   name=\"login\"  /></label>
    <label for=\"passwort\">%PASSWORT%:   <input value=\"\" type=\"password\" name=\"password\" /></label>
     <br /><input type=\"submit\" value=\"%EINLOGGEN%\" /></p>
</form>", "", "", "", "", "1", "0", "1", "0", "1", "0", "0", "0", "0", "0", "1", "0"),
("49", "10", "All Pages", "", "<!-- SUB=headline --><div id=\"headline\">
<a id=\"top\" href=\"#LINKTO:home#\" style=\"background-image:url(%LOGO_BILD%);\">�FIRMA�</a>
<p id=\"access\">%SPRINGE% <a href=\"#inhalt\">%ZUMINHALT%</a> �ODER� <a href=\"#menu\">%ZUMMENUE%</a>.</p>
�SPRACHAUSWAHL�
<ul tabindex=\"0\">
  �MENU:START�
  �MENU:INHALTE�
</ul>
</div><!-- /SUB -->
<!-- SUB=titleprefix -->%TITELPREFIX%<!-- /SUB -->
<!-- SUB=descriptionprefix -->%DESCRIPTION%<!-- /SUB -->
<!-- SUB=keywordsprefix -->%KEYWORDS%<!-- /SUB -->

<!-- SUB=seitenvorlage --><article class=\"text\">
  <h1>#UEBERSCHRIFT#</h1>
  <div>
    $ERROR$
    #TEXT#
    #ABSCHNITT#
  </div>
</article>
<div id=\"topimg\" �BGIMG:hintergrund2� /><!-- /SUB -->

<!-- SUB=footer --><div id=\"footer\">
<div id=\"address\" class=\"vcard\">
  <p><span  class=\"org\">�FIRMA�</span><br />
    <span  class=\"fn n\">�NAME�</span><br />
    <span class=\"adr\">
      <span  class=\"street-address\">�STRASSE�</span><br />
      <span class=\"locality\">�ORT�</span>
    </span><br /><br />
    %TEL% <span  class=\"tel\">�TELEFON�</span><br />
    %MOBIL%: <span  class=\"tel\">�MOBIL�</span><br />
    %WEB%: <span  class=\"url\">�WWW�</span><br />
    %EMAIL%: <a href=\"mailto:�EMAIL�\" class=\"email\">�EMAIL�</a></p>
</div>
</div>
<!-- /SUB -->

<!-- SUB=bridge -->#STRIPP#<div class=\"bridge\"><h4><a href=\"#LINKTO:$PAGE_ID$#\" title=\"$UEBERSCHRIFT$\">$TITEL$</a></h4>$BESCHREIBUNG$</div>#STRIPP#<!-- /SUB -->

<!-- SUB=top -->%NACHOBEN%<!-- /SUB -->
<!-- SUB=zurueck -->%VORIGES%<!-- /SUB -->
<!-- SUB=voriges -->%VORIGES%<!-- /SUB -->
<!-- SUB=vor -->%FOLGENDES%<!-- /SUB -->
<!-- SUB=und -->%UND%<!-- /SUB -->
<!-- SUB=oder -->%ODER%<!-- /SUB -->

<!-- SUB=meta|google --><meta name=\"google-site-verification\" content=\"%GOOGLEVERFICATION%\" /><!-- /SUB -->
<!-- SUB=meta|bing --><meta name=\"msvalidate.01\" content=\"%BINGVERFICATION%\" /><!-- /SUB -->

<!-- SUB=pflichtfelder --><p class=\"requiredinfo\">%PFLICHTFELDER%</p><!-- /SUB -->
<!-- SUB=bgimg -->style=\"background-image:url($IMG$)\"<!-- /SUB -->

<!-- SUB=menublock --><ul>$ENTRIES$</ul><!-- /SUB -->
<!-- SUB=menuentry -->    <li id=\"id_$PAGE_ID$\" class=\"�ACTIVE:$PAGE_ID$�\"><a href=\"/$PATH$�SID�\" accesskey=\"$AK$\" title=\"$BESCHREIBUNG$\">$MENU$</a></li><!-- /SUB -->
<!-- SUB=menu_css -->#headline ul li#id_#P_ID# {
	background-color:rgba(#COLOR#,0.8);
	transition:all .3s;
}
#headline ul li#id_#P_ID#:hover,#headline ul li#id_#P_ID#.active  {
	background-color:rgba(#COLOR#,1);
}<!-- /SUB -->", "", ".text {background-color:�ADDCOLOR:color_ID=text;opacity=.9� !important}
.text h1 {border-color:�ADDCOLOR:color_ID=menu� !important}
�MENU_CSS�", "", "styles.css
https://fonts.googleapis.com/css?family=Work+Sans:bold,bolditalic,thin,light", "1", "0", "0", "0", "1", "0", "500", "500", "0", "0", "fit", "fit"),
("57", "3", "Panorama", "", "<div class=\"block\" style=\"background-image: url(%HINTERGRUND_BILD%);background-color: %FARBE:IGNORE=#000000%\">
  �SHOW:IF=%WWW%;TPL=<a href=\"http://%WWW%\">�
  �SHOW:IF=%BESCHREIBUNG_TEXT%;TPL=<p class=\"%POS_RADIO:Oben=top;Mitte=middle;Unten=bottom;IGNORE=top%\">%BESCHREIBUNG_TEXT%</p>�
  �SHOW:IF=%TITEL_TEXT%;TPL=<h3>%TITEL_TEXT%</h3>�
  �SHOW:IF=%WWW%;TPL=</a>�
</div>", "", ".text	 {width:auto;right:205px;width:980px; bottom:0;}
.text>div{background-color:rgba(0,0,0,0) !important;}
.text>h1 {display:none;}
.text>div{top:0px;padding:0;padding-left: 50px; left: -50px;}
.block {
	position:relative; background-repeat:no-repeat;background-size:cover;
	float:left;width:215px;height:215px;margin:0 25px 25px 0;
}
.block h3 {
	position:absolute;left:30px;bottom:15px;right:15px;
	white-space:pre-wrap;
}
.block p {
	position:absolute;left:-5px;right:auto;
	background-color: rgba(255,255,255,0.66);
	padding:5px;
	white-space:pre-wrap; font-size:1.1em;
}
.block p.top {top:15px;}
.block p.middle {top:100px;}
.block p.bottom {bottom:15px;}
.block a {
	position:absolute;left:0;top:0;width:100%;height:100%;
}
.block a:hover p,.block a:hover h3 {text-decoration:underline}

@media  (min-width: 1186px) {
	.block:nth-child(4n) {margin-right:0}
}
@media (max-width: 1185px) and (min-width: 925px) {
	.text {width:740px;}
}
@media (max-width: 940px) {
	.text {right:205px;left:0;width:auto;}
}
@media (max-width: 940px) and (min-width: 895px) {
	.block:nth-child(3n) {margin-right:0}
}
@media (max-width: 915px) and (min-width: 600px) {
	.block {margin:0 15px 15px 0;}
}
@media (max-width: 850px) and (min-width: 600px) {
	.block:nth-child(even) {margin-right:0}
}
@media (max-width: 720px) {
	.text {right:30px;}
}
@media (max-width: 600px) {
	.block {width:103px;height:103px;margin:0 9px 9px 0;font-size:.9em}
    .block p {left:-20px;}
    .block p.top {top:15px;}
    .block p.middle {top:45px;}
    .block p.bottom {bottom:15px;}
	.block h3 {left:15px;}
}", "", "", "16", "0", "0", "4", "1", "1", "220", "220", "800", "600", "cover", "fit"),
("78", "12", "sitemap.xml", "Sitemap for Google", "<!-- SUB=main_tpl --><?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
         xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
         xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
�SITEMAPURLS�
</urlset>
<!-- /SUB -->
<!-- SUB=sitemapurls --><url>
    <loc>#PATH#</loc>
    <lastmod>#LASTMOD#</lastmod>
    <changefreq>%CANGEFREQ%</changefreq>
    <priority>%PRORITY%</priority>
</url><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->
", "", "", "", "", "1", "0", "0", "1", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("79", "13", "robots.txt", "For search engines", "<!-- SUB=main_tpl -->%ANWEISUNGEN_RAW%
Sitemap: #LINKTO:%SITEMAP_SELECT:seiten%;absolute#
<!-- /SUB -->
<!-- SUB=Content-type -->text/plain<!-- /SUB -->
", "", "", "", "", "1", "0", "0", "1", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("81", "9", "Forgort Password", "", "�PASSWORTVERGESSEN�
%PASSWORTVERGESSEN_FCK%
<form action=\"\" method=\"post\">
    <p><label for=\"zugang\">%BENUTZER%:    <input id=\"zugang\" type=\"input\" name=\"zugang\" value=\"#ZUGANG#\" /></label></p>
    <p><input class=\"button\" type=\"submit\" name=\"submit[zugang]\" value=\"%ANFRAGEN%\" /></p>
</form>
�PFLICHTFELDER�

<!-- SUB=betreff -->%BETREFF%<!-- /SUB -->
<!-- SUB=emailbody -->%EMAIL_TEXT%<!-- /SUB -->
", "", "", "", "", "1", "0", "0", "1", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("83", "14", "BingSiteAuth.xml", "Auth for Bing", "<!-- SUB=main_tpl --><?xml version=\"1.0\"?>
<users>
  <user>%BINGAUTH%</user>
</users><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->", "", "", "", "", "1", "0", "0", "1", "1", "0", "250", "250", "500", "500", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --