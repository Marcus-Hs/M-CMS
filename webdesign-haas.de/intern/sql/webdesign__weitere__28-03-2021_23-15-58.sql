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
  `UID` smallint(5) NOT NULL,
  `short` char(2) NOT NULL DEFAULT '',
  `domain` varchar(65) NOT NULL DEFAULT '',
  `lang_intl` varchar(255) NOT NULL DEFAULT '',
  `lang_local` varchar(255) NOT NULL DEFAULT '',
  `codepage` varchar(255) NOT NULL DEFAULT '',
  `direction` char(3) NOT NULL DEFAULT '',
  `position` smallint(3) NOT NULL DEFAULT '99',
  `visibility` smallint(1) DEFAULT '1',
  PRIMARY KEY  (`LANG_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=_languages # --
INSERT INTO `#PREFIX#_languages` (`LANG_ID`,`UID`,`short`,`domain`,`lang_intl`,`lang_local`,`codepage`,`direction`,`position`,`visibility`) VALUES
("1", "2", "de", "www.webdesign-haas.de", "german", "deutsch", "utf-8", "ltr", "1", "1"),
("2", "2", "ar", "arabic.webdesign-haas.com", "arabic", "عرب", "utf-8", "rtl", "3", "1"),
("3", "2", "en", "www.webdesign-haas.com", "english", "english", "utf-8", "ltr", "2", "1"),
("4", "2", "hi", "hindi.webdesign-haas.com", "hindi", "हिंदी", "utf-8", "ltr", "4", "1"),
("5", "1", "zh", "chinese.webdesign-haas.com", "simplified Chinese", "普通话", "utf-8", "ltr", "5", "1");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#_preview`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_preview` (
  `PAGE_ID` smallint(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` blob NOT NULL,
  PRIMARY KEY (`PAGE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --


DROP TABLE IF EXISTS `#PREFIX#_session`;
-- # Schnipp --
CREATE TABLE `#PREFIX#_session` (
  `ID` smallint(5) NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `logindate` datetime NOT NULL,
  PRIMARY KEY  (`sessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
("1", "%ABKUERZUNG%", "Abkürzung"),
("1", "%ABMELDEN%", "Aus der Verwaltung Abmelden"),
("1", "%ABSCHNITT%", "Abschnitt"),
("1", "%ABSCHNITTE%", "Abschnitte"),
("1", "%ABSCHNITTIMPORT%", "Abschnittimport"),
("1", "%ABSCHNITT_ABSTEIGEND%", "Abschnitt absteigend"),
("1", "%ABSCHNITT_AUFSTEIGEND%", "Abschnitt aufsteigend"),
("1", "%ABSCHNITT_GELOESCHT%", "Der Abschnitt wurde entfernt"),
("1", "%ABSENDERADRESSE_UNGUELTIG%", "Absenderadresse ungültig"),
("1", "%ACTIVE%", "Active"),
("1", "%ADRESSEN%", "Adressen"),
("1", "%ADRESSEN_AUSGEWAEHLT%", "Adressen ausgewählt"),
("1", "%ADRESSEN_GEAENDERT%", "Adressen geändert"),
("1", "%ADRESSEN_GELOESCHT%", "Adressen gelöscht"),
("1", "%ADRESSEN_HINZUGEFUEGT%", "Adressen hinzugefügt"),
("1", "%AENDERUNGEN_NICHT_GESPEICHERT%", "Änderungen konnten nicht gespeichert werden."),
("1", "%AENDERUNGEN_SIND_EINGETRAGEN%", "Änderungen sind eingetragen"),
("1", "%ALLES%", "Alles"),
("1", "%ALLE_AENDERN%", "Alle ändern"),
("1", "%ALLE_AUSWAEHLEN%", "Alle auswählen"),
("1", "%ALLE_SEITEN%", "Alle Seiten"),
("1", "%ALLE_SEITEN_DER_ERSTEN_EBENE%", "Alle Seiten der ersten Ebene anzeigen"),
("1", "%ALLE_SEITEN_DIESER_EBENE%", "Alle Seiten dieser Ebene anzeigen"),
("1", "%ALLE_SEITEN_DIESER_KATEGORIE%", "Alle Seiten dieser Kategorie anzeigen"),
("1", "%ALLE_SEITEN_WIE_IN_LETZTER_UEBERSICHT%", "Alle Seiten wie in letzter Übersicht"),
("1", "%ALLE_SPRACHEN_ZEIGEN%", "Alle Sprachen zeigen"),
("1", "%ALLE_THREADS%", "Alle Threads"),
("1", "%ALLE_WAEHLEN%", "Alle wählen"),
("1", "%ANGABEN_GESPEICHERT%", "Die Angaben sind gespeichert worden."),
("1", "%ANGABEN_UNVOLLSTAENDIG%", "Angaben unvollständig"),
("1", "%ANHANG%", "Anhang"),
("1", "%ANLEGEN%", "Anlegen"),
("1", "%ANSPRECHPARTNER%", "Ansprechpartner"),
("1", "%ANZAHL%", "Anzahl"),
("1", "%ANZEIGEN%", "Anzeigen"),
("1", "%APRIL%", "April"),
("1", "%AUGUST%", "August"),
("1", "%AUSBLENDEN%", "Ausblenden"),
("1", "%AUSFUEHREN%", "Ausführen"),
("1", "%AUSGABEOPTIONEN%", "Ausgabeoptionen"),
("1", "%AUSWAHL%", "Auswahl"),
("1", "%AUSWAHL_LOESCHEN%", "Auswahl löschen"),
("1", "%AUSWAHL_NICHT_MOEGLICH%", "Auswahl nicht möglich"),
("1", "%AUTOMATISCH_UEBERSETZEN%", "Automatisch übersetzen"),
("1", "%AUTOR%", "Autor"),
("1", "%BEARBEITEN%", "Bearbeiten"),
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
("1", "%BILDLOESCHEN%", "Bild löschen"),
("1", "%BILD_NUR_TEILWEISE%", "Beim Hochladen ist etwas schief gegangen:"),
("1", "%BILD_ZU_GROSS%", "Das Bild ist leider zu Groß:"),
("1", "%BITTE_AUSWAEHLEN%", "Bitte auswaehlen"),
("1", "%BLOECKE%", "Blöcke"),
("1", "%BODYCLASS%", "BodyClass"),
("1", "%BODYID%", "BodyId"),
("1", "%BREITE%", "Breite"),
("1", "%CACHE%", "Cache"),
("1", "%COVER%", "Cover"),
("1", "%DATA_NICHT_AKZEPTIERT%", "Data nicht akzeptiert"),
("1", "%DATEIENDUNG_NICHT_ERLAUBT%", "Dateiendung nicht erlaubt"),
("1", "%DATEIMANAGER%", "Dateimanager"),
("1", "%DATEINAME%", "Dateiname"),
("1", "%DATEI_DURCH_DIESE_ERSETZEN%", "Vorhandene Datei durch diese ersetzen. Eintragen um Änderungen zu Übernehmen."),
("1", "%DATEI_EXISTIERT_BEREITS%", "Datei existiert bereits"),
("1", "%DATEI_GELOESCHT%", "Datei gelöscht"),
("1", "%DATEI_NICHT_HOCHLADEN%", "Datei doch nicht hochladen."),
("1", "%DATEI_OEFFNEN_FEHLER%", "Datei-öffnen Fehler"),
("1", "%DATEI_SEHR_GROSS%", "Die Datei sehr groß(#SIZE#). Das Hochladen könnte einige Zeit in Anspruch nehmen. "),
("1", "%DATEI_ZUGRIFF_FEHLER%", "Dateizugriff Fehler"),
("1", "%DATEI_ZU_GROSS%", "Die Datei ist zu groß(#SIZE#). Mehr als #ALLOWED# insgesamt werden vom Server nicht unterstützt."),
("1", "%DATEN%", "Daten"),
("1", "%DATEN_WURDEN_GELOESCHT%", "Die Daten wurden gelöscht"),
("1", "%DATEN_WURDEN_GESPEICHERT%", "Ihre Daten wurden gespeichert."),
("1", "%DATUM%", "Datum"),
("1", "%DATUM_ABSTEIGEND%", "Datum absteigend"),
("1", "%DATUM_AUFSTEIGEND%", "Datum aufsteigend"),
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
("1", "%EINFUEGEN%", "Einfügen"),
("1", "%EINLOGGEN%", "Einloggen"),
("1", "%EINTRAEGE_BEARBEITET%", "Einträge wurden bearbeitet"),
("1", "%EINTRAEGE_FINDEN%", "Einträge finden"),
("1", "%EINTRAGEN%", "Eintragen"),
("1", "%EINTRAG_AENDERN%", "Eintrag ändern"),
("1", "%EINTRAG_BEARBEITEN%", "Eintrag bearbeiten"),
("1", "%EINTRAG_KOMMENTIEREN%", "Eintrag kommentieren"),
("1", "%EMAIL%", "E-Mail"),
("1", "%EMAILFUNKTION_NICHT_AUSFUEHRBAR%", "Emailfunktion nicht ausführbar"),
("1", "%EMAILS_ALS_LISTE%", "E-mails als Liste"),
("1", "%EMAILS_AN_DIESE_EMPFAENGER%", "E-mails an diese Empfänger"),
("1", "%EMAILS_SIND_VERSANDT_WORDEN%", "E-mails sind versandt worden"),
("1", "%EMAIL_ZEIGEN%", "E-mail zeigen"),
("1", "%EMPFAENGER%", "Empfänger"),
("1", "%EMPFAENGER_UNGUELTIG%", "Empfänger ungueltig"),
("1", "%ENDE_ABSTEIGEND%", "Ende absteigend"),
("1", "%ENDE_AUFSTEIGEND%", "Ende aufsteigend"),
("1", "%ENTFERNEN%", "Entfernen"),
("1", "%ERLAUBTE_DATEIENDUNGEN%", "Bitte laden Sie nur Dateien mit folgenden Dateiendungen hoch"),
("1", "%ERSCHEINT_IM_MENUE%", "Erscheint im Menü"),
("1", "%ERSTELLEN%", "Erstellen"),
("1", "%ERSTSTELLT_AM%", "Erststellt am"),
("1", "%EXPORT%", "Export"),
("1", "%FAX%", "Fax"),
("1", "%FCKEDITOR%", "FCKeditor"),
("1", "%FEBRUAR%", "Februar"),
("1", "%FEHLER%", "Fehler"),
("1", "%FENSTERTITEL%", "Fenstertitel, Popup im Menu, Betreff bei E-mails"),
("1", "%FENSTER_SCHLIESSEN%", "Fenster schließen"),
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
("1", "%FUER_MAIL_AUSWAEHLEN%", "Für E-Mail auswählen"),
("1", "%GAESTEBUCH%", "Gästebuch"),
("1", "%GAESTEBUCHSEITE%", "Gästebuchseite"),
("1", "%GAESTEBUCH_BEARBEITEN%", "Gästebuch bearbeiten"),
("1", "%GALERIEN%", "Galerien"),
("1", "%GANZ_SICHER%", "Sind Sie da ganz Sicher?"),
("1", "%GELOESCHT%", "Gelöscht"),
("1", "%GROESSENVORGABEN%", "Größenvorgaben"),
("1", "%HEUTE%", "Heute"),
("1", "%HINTERGRUENDE%", "Hintergründe"),
("1", "%HINTERGRUND%", "Hintergrund"),
("1", "%HINTERGRUND2%", "Hintergrund2"),
("1", "%HOCHGELADEN%", "Hochgeladen"),
("1", "%HOCHGELADEN_FEHLGESCHLAGEN%", "Etwas ist beim Hochladen schief gegangen."),
("1", "%HOCHLADEN%", "Hochladen"),
("1", "%HOCHLADEN_FEHLGESCHLAGEN%", "Hochladen fehlgeschlagen"),
("1", "%HOEHE%", "Höhe"),
("1", "%IMPORT%", "Import"),
("1", "%IMPORTIEREN%", "Importieren"),
("1", "%IMPRESSUM%", "Impressum"),
("1", "%INFO_STICHWORTE%", "Wichtige Stichworte sollten öfter vorkommen, sie werden hier größer angezeigt"),
("1", "%IN_BEARBEITUNG%", "In Bearbeitung"),
("1", "%IN_NEUEM_FENSTER_OEFFNEN%", "In neuem Fenster öffnen"),
("1", "%IN_TEXT_EINFUEGEN%", "Dieses Bild in den Text einfügen."),
("1", "%JANUAR%", "Januar"),
("1", "%JULI%", "Juli"),
("1", "%JUNI%", "Juni"),
("1", "%KALENDERVORLAGE%", "Kalendervorlage"),
("1", "%KATEGAL%", "Unterseiten unabhängig von Kategorie im Menüanzeigen"),
("1", "%KATEGORIE%", "Kategorie"),
("1", "%KATEGORIEN%", "Kategorien"),
("1", "%KATEGORIEN_BEARBEITEN%", "Kategorien bearbeiten"),
("1", "%KATEGORIE_BEARBEITEN%", "Kategorie bearbeiten"),
("1", "%KATEGORIE_IST_ANGELEGT%", "Kategorie ist angelegt"),
("1", "%KATEGORIE_OHNE_TITEL%", "Ohne Titel kann die Kategorie nicht gespeichert werden."),
("1", "%KEINE_ABONNENTEN_GEWAEHLT%", "Keine Abonnenten gewählt"),
("1", "%KEINE_AUTHENTIFIZIERUNG%", "Keine Authentifizierung"),
("1", "%KEINE_EINTRAEGE%", "Keine eintraege"),
("1", "%KEINE_EINTRAEGE_GEFUNDEN%", "Keine Einträge gefunden"),
("1", "%KEINE_EMAIL_ANGEGEBEN%", "Keine Email angegeben"),
("1", "%KEINE_HTML_UNTERSEITEN%", "Keine HTML-Unterseiten"),
("1", "%KEINE_NACHRICHT%", "Keine Nachricht"),
("1", "%KEINE_NUM_UNTERSEITEN%", "Keine numerischen Unterseiten"),
("1", "%KEINE_VERBINDUNG_HOST%", "Keine Verbindung zu Host"),
("1", "%KEIN_EMPFAENGER_GEWAEHLT%", "Kein Empfänger gewählt"),
("1", "%KLICK_TOGGLE%", "Anklicken zum ein-/ausblenden"),
("1", "%KOMMAGETRENNT%", "Durch Komma getrennt"),
("1", "%KOMMENTAR%", "Kommentar"),
("1", "%KOMPRIMIERUNG%", "Komprimierung"),
("1", "%KONFIGURATIONSOPTIONEN%", "weitere Konfigurationsoptionen (Vorlage, Kategorie, Unterseite)"),
("1", "%KONTAKT%", "Kontakt"),
("1", "%KONTAKTSEITE%", "Kontaktseite"),
("1", "%KOPIEREN%", "Kopieren"),
("1", "%KOPIE_VON%", "Kopie von"),
("1", "%KURSANMELDUNG%", "Kursanmeldung"),
("1", "%LETZTE_GESPEICHERTE_VERSION%", "Letzte gespeicherte Version der Seite"),
("1", "%LINK_EINFUEGEN%", "Als Link einfügen"),
("1", "%LOESCHEN%", "Löschen"),
("1", "%LOESCHEN_FEHLGESCHLAGEN%", "Löschen fehlgeschlagen"),
("1", "%LOESCHEN_ODER_ABBRECHEN%", "Löschen oder abbrechen (OK oder Cancel)"),
("1", "%LOGIN%", "Login"),
("1", "%LOGOUT%", "Logout"),
("1", "%LOGOUT_IM_MENUE%", "Logout im Menü oben"),
("1", "%MAERZ%", "März"),
("1", "%MAI%", "Mai"),
("1", "%MAIL%", "E-Mail"),
("1", "%MAILER_NICHT_UNTERSTUETZT%", "Mailer nicht unterstützt"),
("1", "%MARKIERUNGEN_ENTFERNEN%", "Markierungen entfernen"),
("1", "%MARKIERUNGEN_VON_BEGRIFFEN_ENTFERNEN%", "Markierungen von Begriffen entfernen."),
("1", "%MAXZEICHEN%", "Mehr als #MAXLENGTH# Zeichen sind nicht erlaubt."),
("1", "%MELDUNGEN%", "Meldungen"),
("1", "%MENU%", "Menü"),
("1", "%MENUEBILD%", "Menübild"),
("1", "%MENUEBILD2%", "Menübild (hover)"),
("1", "%MENUEBILDER%", "Menübilder"),
("1", "%MENUEEINTRAG%", "Menüeintrag"),
("1", "%MINDESTENS_SECHS_ZEICHEN%", "Das Passwort sollte Mindestens sechs Zeichen lang sein. Es darf Zahlen und Sonderzeichen enthalten."),
("1", "%MITTWOCH%", "Mittwoch"),
("1", "%MOBIL%", "Mobil"),
("1", "%MONTAG%", "Montag"),
("1", "%MYSQL%", "Mysql"),
("1", "%NACHBARSEITEN%", "Nachbarseiten"),
("1", "%NACHRICHT%", "Nachricht"),
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
("1", "%NEWSLETTER_ABSCHICKEN%", "Newsletter abschicken"),
("1", "%NEWSLETTER_EINZELN_SENDEN%", "Newsletter einzeln senden"),
("1", "%NEWSLETTER_VERSANDT%", "Es wurden E-Mails versandt"),
("1", "%NEWSLETTER_VORSCHAU%", "Es wären E-Mails versandt worden"),
("1", "%NICHT_GELOESCHT%", "Diese Vorlage kann nicht entfernt werden."),
("1", "%NLEMAILVORLAGE%", "Newsletter E-Mail"),
("1", "%NOVEMBER%", "November"),
("1", "%NR%", "Nr"),
("1", "%NUR_AN_DIESE_EMPFAENGER%", "Nur an diese Empfänger"),
("1", "%NUR_TEXT_EINFUEGEN%", "Nur Text einfügen"),
("1", "%ODER_KATEGORIEN_LOESCHEN%", "Oder Kategorien löschen"),
("1", "%ODER_VORLAGEN_LOESCHEN%", "oder Vorlagen löschen"),
("1", "%OEFFNEN%", "Öffnen"),
("1", "%OHNE%", "ohne"),
("1", "%OKTOBER%", "Oktober"),
("1", "%OPTIMIEREN%", "Optimieren"),
("1", "%ORDNER_ANGELEGT%", "Ordner angelegt"),
("1", "%ORDNER_GELOESCHT%", "Ordner gelöscht"),
("1", "%ORDNER_LOESCHEN_FEHLGESCHLAGEN%", "Ordner löschen fehlgeschlagen"),
("1", "%ORT%", "Ort"),
("1", "%OVER%", "Over"),
("1", "%PAGE%", "Page"),
("1", "%PASSWORT%", "Passwort"),
("1", "%PASSWORTGESPEICHERT%", "Das neue Passwort ist gespeichert worden."),
("1", "%PASSWORTGLEICHEIT%", "Bitte prüfen Sie, ob Sie beide Male das gleiche Passwort angegeben haben. "),
("1", "%PASSWORTZEICHENFEHLER%", "Ihr Passwort enhält ungültige Zeichen oder ist zu kurz (Leerschritte und Sonderzeichen sind nicht erlaubt und es sollte mindestes 6 Zeichen enthalten)."),
("1", "%PASSWORT_AENDERN%", "Passwort ändern"),
("1", "%PERSOENLICHE_DATEN%", "Persönliche Daten"),
("1", "%PERSOENLICHE_DATEN_BEARBEITEN%", "Persönliche Daten bearbeiten"),
("1", "%PERSON%", "Person"),
("1", "%PERSONEN%", "Personen"),
("1", "%PERSONEN_ONLINE%", "Folgende Personen sind zur Zeit online (oder haben sich nicht abgemeldet)"),
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
("1", "%PREVIEW%", "Vorschau"),
("1", "%PROFILING%", "PHP Profiling"),
("1", "%PRO_SEITE%", "Pro Seite"),
("1", "%RECHTE%", "Rechte"),
("1", "%REDUZIERTE_HOEHE%", "Reduzierte Höhe"),
("1", "%SAMSTAG%", "Samstag"),
("1", "%SCHLIESSEN%", "Schließen"),
("1", "%SCHREIBFEHLER%", "Schreibfehler"),
("1", "%SCHREIBWEISE%", "Schreibweise"),
("1", "%SEITE%", "Seite"),
("1", "%SEITEN%", "Seiten"),
("1", "%SEITENBESCHREIBUNG%", "Erscheint auf Übersichtsseiten und bei Google, (description)"),
("1", "%SEITENBESUCHE_ZAEHLEN%", "Seitenbesuche zählen (Statsitik)"),
("1", "%SEITENDETAILS%", "Seitendetails"),
("1", "%SEITENUEBERSCHRIFT%", "Überschrift auf der Seite"),
("1", "%SEITENVORLAGE%", "Seitenvorlage"),
("1", "%SEITEN_ANLEGEN%", "Seiten anlegen"),
("1", "%SEITEN_ANZEIGEN%", "Seiten anzeigen"),
("1", "%SEITEN_BEARBEITEN%", "Seiten bearbeiten"),
("1", "%SEITEN_DIESER_AUSWAHL%", "Seiten dieser Auswahl anzeigen"),
("1", "%SEITEN_DIESER_KATEGORIE%", "Seiten dieser Kategorie"),
("1", "%SEITEN_ZWISCHENSPEICHERN%", "Seiten zwischenspeichern (Cache)"),
("1", "%SEITE_ALS_EIGENE_UNTERSEITE%", "Eine Seite kann nicht ihre eigene Unterseite sein."),
("1", "%SEITE_ANZEIGEN%", "Seite anzeigen"),
("1", "%SEITE_BEARBEITEN%", "Seite bearbeiten"),
("1", "%SEITE_ERSTELLT_AM%", "Seite erstellt am"),
("1", "%SEITE_FREIGEBEN%", "Seite freigeben"),
("1", "%SEITE_GELOESCHT%", "Seite gelöscht"),
("1", "%SEITE_OHNE_TITEL%", "Ohne Titel kann die Seite nicht gespeichert werden."),
("1", "%SENDEN%", "Senden"),
("1", "%SEPTEMBER%", "September"),
("1", "%SERVER_FEHLER%", "Server-Fehler"),
("1", "%SIZE%", "Größe"),
("1", "%SMTP_FEHLER%", "SMTP-Fehler"),
("1", "%SONDERSEITEN%", "Sonderseiten"),
("1", "%SONDERVORLAGEN%", "Sondervorlagen"),
("1", "%SONNTAG%", "Sonntag"),
("1", "%SONSTIGES%", "Sonstiges"),
("1", "%SORTIERUNG_DER_ABSCHNITTE%", "Sortierung der Abschnitte"),
("1", "%SPEICHERN_NICHT_ERLAUBT%", "Ihnen fehlen die Rechte, Änderungen zu speichern. Bitte wenden Sie ggfl. sich an den Administrator."),
("1", "%SPEICHERVERBOT%", "Speicherverbot"),
("1", "%SPRACHE%", "Sprache"),
("1", "%SPRACHEN%", "Sprachen"),
("1", "%SPRACHEN_BEARBEITEN%", "Sprachen bearbeiten"),
("1", "%SPRACHEN_LOESCHEN%", "Sprachen löschen"),
("1", "%SPRACHE_BEARBEITEN%", "Sprache bearbeiten"),
("1", "%SPRACHE_EXPORTIEREN%", "Sprache exportieren"),
("1", "%SPRACHE_GELOESCHT%", "Sprache gelöscht"),
("1", "%SPRACHE_LOESCHEN%", "Diese Sprache und alle zugehörigen Einrträge Löschen."),
("1", "%STARTSEITE%", "Startseite"),
("1", "%STATISTIK%", "Statistik"),
("1", "%STATISTIKDOMAIN%", "Statistik-Domain"),
("1", "%STATISTIKID%", "Statistik ID"),
("1", "%STATS%", "Stats"),
("1", "%STATUS%", "Status"),
("1", "%STATUSAENDERUNGSEITE%", "Statusänderung"),
("1", "%STATUSSEITE%", "Statusseite"),
("1", "%STRASSE%", "Strasse"),
("1", "%SUCHE%", "Suche"),
("1", "%SUCHEN%", "Suchen"),
("1", "%SYSTEM%", "System / Editor"),
("1", "%SYSTEMFEHLER%", "Systemfehler"),
("1", "%TABELLE%", "Tabelle"),
("1", "%TABELLEN_OPTIMIERT%", "Tabellen optimiert"),
("1", "%TABELLE_EXPORTIERT%", "Die Tabelle wurde exportiert"),
("1", "%TABELLE_IMPORTIERT%", "Tabelle importiert"),
("1", "%TASTENKUERZEL%", "Tastenkürzel"),
("1", "%TASTENKUERZEL_FESTLEGEN%", "Für Tastaturbedienung"),
("1", "%TEL%", "Tel"),
("1", "%TELEFON%", "Telefon"),
("1", "%TERMINE%", "Termine"),
("1", "%TERMINE_GELOESCHT%", "Termine gelöscht"),
("1", "%TERMINE_GESPEICHERT%", "Termine gespeichert"),
("1", "%TEXTFELD%", "Textfeld"),
("1", "%TEXTFELD_ANZEIGEN%", "Textfeld anzeigen"),
("1", "%TITEL%", "Titel"),
("1", "%TOOLBAR%", "Toolbar"),
("1", "%TOOLTIP_BERECHTIGUNGEN%", "Festlegen, welche Seiten und Kategorien bearbeitet werden dürfen"),
("1", "%TOOLTIP_EINTRAGEN%", "Änderungen speichern"),
("1", "%TOOLTIP_PLUGINSRECHTE%", "Rechte für Plugins festlegen"),
("1", "%TOOLTIP_RECHTE%", "Rechte für Seiten festlegen"),
("1", "%TOOLTIP_STICHWORTE%", "Titel, Beschreibung, Überschrift und Text werden ausgewertet"),
("1", "%UEBERSCHREIBEN%", "Überschreiben"),
("1", "%UEBERSCHRIFT%", "Überschrift"),
("1", "%UEBERSETZEN%", "Übersetzen"),
("1", "%UEBERSETZUNG_BEARBEITEN%", "Übersetzung bearbeiten"),
("1", "%UMBENENNEN%", "Umbenennen"),
("1", "%UNBEDINGT_AUSWAEHLEN%", "Unbedingt auswählen"),
("1", "%UNBEKANNTE_KODIERUNG%", "Unbekannte Kodierung"),
("1", "%UND%", "und"),
("1", "%UNGUELTIGE_ADRESSE%", "Ungültige Adresse"),
("1", "%UNIDENTIFIZIERTER_FEHLER%", "Unidentifizierter Fehler"),
("1", "%UNTERSEITEN%", "Unterseiten"),
("1", "%UNTERSEITEN_ANZEIGEN%", "Unterseiten anzeigen"),
("1", "%UNTERSEITE_VON%", "Unterseite von"),
("1", "%UPLOAD%", "Neue Datei:"),
("1", "%UPLOAD_ZU_GROSS%", "Die Summe der Hochzuladenden Dateien ist zu groß (#SIZE#). Mehr als #MFS# insgesamt werden vom Server nicht unterstützt. Bitte Änderungen Eintragen und fortsetzen."),
("1", "%URL%", "Url"),
("1", "%Uhr%", "Uhr"),
("1", "%VARIABLE_NICHT_GESETZT%", "Variable nicht gesetzt"),
("1", "%VEROEFFENTLICHEN%", "Veröffentlichen"),
("1", "%VERSCHIEBEN%", "Verschieben"),
("1", "%VERSTECKEN%", "Verstecken"),
("1", "%VERWALTUNGSSEITEN%", "Verwaltungsseiten"),
("1", "%VERWALTUNGSSPRACHE%", "Verwaltungssprache"),
("1", "%VIDEO%", "Video"),
("1", "%VON_LINKS_NACH_RECHTS%", "Von links nach rechts"),
("1", "%VON_RECHTS_NACH_LINKS%", "Von rechts nach links"),
("1", "%VORGABEN%", "Vorgaben"),
("1", "%VORGABEN_BEARBEITEN%", "Vorgaben bearbeiten"),
("1", "%VORGAENGERSEITE%", "Vorgängerseite"),
("1", "%VORIGE%", "Vorige"),
("1", "%VORJAHR%", "Vorjahr"),
("1", "%VORLAGE%", "Vorlage"),
("1", "%VORLAGEN%", "Vorlagen"),
("1", "%VORLAGEN_BEARBEITEN%", "Vorlagen bearbeiten"),
("1", "%VORLAGE_BEARBEITEN%", "Vorlage bearbeiten"),
("1", "%VORLAGE_EXPORTIEREN%", "Vorlage exportieren"),
("1", "%VORLAGE_GELOESCHT%", "Vorlage gelöscht"),
("1", "%VORLAGE_IMPORTIERT%", "Vorlage importiert"),
("1", "%VORLAGE_NICHT_GEFUNDEN%", "Vorlage nicht gefunden"),
("1", "%VORLAGE_OHNE_TITEL%", "Ohne Titel kann die Vorlage nicht gespeichert werden."),
("1", "%VORMONAT%", "Vormonat"),
("1", "%VORSCHAU%", "Vorschau"),
("1", "%WEITERBLAETTERN%", "Weiterblättern"),
("1", "%WEITERE_ANGABEN%", "Weitere Angaben"),
("1", "%WEITERE_DATEIEN%", "Weitere SQL-Dateien"),
("1", "%WEITERE_DATEN%", "Weitere Daten"),
("1", "%WIEDERHOLUNG%", "Wiederholung"),
("1", "%WIRD_BEARBEITET_VON%", "Wird bearbeitet von"),
("1", "%WORD_BEREINIGEN%", "Word bereinigen"),
("1", "%WWW%", "www"),
("1", "%ZEIGEN%", "Zeigen"),
("1", "%ZEIT%", "Zeit"),
("1", "%ZUGEHOERIGE_SEITEN%", "Zugehörige Seiten"),
("1", "%ZUGEHOERIGE_UNTERSEITEN%", "Zugehörige Unterseiten"),
("1", "%ZUGEORDNETE_SEITEN%", "zugeordnete Seiten"),
("1", "%ZUGRIFF%", "Zugriff"),
("1", "%ZURUECK%", "Zurück"),
("1", "%ZURUECKBLAETTERN%", "Zurückblättern"),
("1", "%ZU_VIELE_UPLOADS%", "Zu viele  Dateien (#UPCOUNT#). Mehr als #MFU# werden von Server nicht unterstützt. Bitte Änderungen Eintragen und fortsetzen."),
("3", "%ABC_ABSTEIGEND%", "AZ descending"),
("3", "%ABC_AUFSTEIGEND%", "AZ ascending"),
("3", "%ABKUERZUNG%", "Abbreviation"),
("3", "%ABMELDEN%", "Logout of administration"),
("3", "%ABSCHNITT%", "Section"),
("3", "%ABSCHNITTE%", "Sections"),
("3", "%ABSCHNITT_ABSTEIGEND%", "Section descending"),
("3", "%ABSCHNITT_AUFSTEIGEND%", "Section ascending"),
("3", "%ABSCHNITT_GELOESCHT%", "Section deleted"),
("3", "%ACTIVE%", "Active"),
("3", "%ADRESSEN%", "Addresses"),
("3", "%ADRESSEN_AUSGEWAEHLT%", "Address (es) selected"),
("3", "%ADRESSEN_GEAENDERT%", "Address changed"),
("3", "%ADRESSEN_GELOESCHT%", "The addresses have been deleted."),
("3", "%ADRESSEN_HINZUGEFUEGT%", "Addresses added"),
("3", "%AENDERUNGEN_NICHT_GESPEICHERT%", "The changes could not be saved."),
("3", "%AENDERUNGEN_SIND_EIGETRAGEN%", "The changes have been saved."),
("3", "%ALLES%", "Everything "),
("3", "%ALLE_AENDERN%", "Change all"),
("3", "%ALLE_AUSWAEHLEN%", "Select All"),
("3", "%ALLE_SEITEN%", "All pages"),
("3", "%ALLE_SEITEN_DER_ERSTEN_EBENE%", "All pages of the first level"),
("3", "%ALLE_SEITEN_DIESER_EBENE%", "All pages of this level"),
("3", "%ALLE_SEITEN_DIESER_KATEGORIE%", "All pages of this groups"),
("3", "%ALLE_SEITEN_WIE_IN_LETZTER_UEBERICHT%", "All pages like in last overview."),
("3", "%ALLE_SPRACHEN_ZEIGEN%", "Show all languages"),
("3", "%ALLE_WAEHLEN%", "Select All"),
("3", "%ANGABEN_GESPEICHERT%", "The data have been stored."),
("3", "%ANGABEN_UNVOLLSTAENDIG%", "The data are not complete."),
("3", "%ANHANG%", "Attachment"),
("3", "%ANLEGEN%", "Create"),
("3", "%ANSPRECHPARTNER%", "Contact"),
("3", "%ANZAHL%", "Number"),
("3", "%ANZEIGEN%", "Visible"),
("3", "%AUSBLENDEN%", "Hide"),
("3", "%AUSFUEHREN%", "Execute"),
("3", "%AUSGABEOPTIONEN%", "Output options"),
("3", "%AUSWAHL%", "Selection"),
("3", "%AUSWAHL_LOESCHEN%", "Delete selection"),
("3", "%AUSWAHL_NICHT_MOEGLICH%", "Selection not possible"),
("3", "%AUTOMATISCH_UEBERSETZEN%", "Automatic translation"),
("3", "%AUTOR%", "Autor"),
("3", "%BEARBEITEN%", "Edit"),
("3", "%BENUTZERVERWALTUNG%", "User management"),
("3", "%BERECHTIGUNGEN%", "Permissions"),
("3", "%BESCHREIBUNG%", "Description"),
("3", "%BESITZER%", "Owner"),
("3", "%BESONDERE_SEITEN%", "Special pages"),
("3", "%BETREFF%", "Subject"),
("3", "%BETREFFANHANG%", "Subject suffix"),
("3", "%BETRIFFT_ALLE_SPRACHEN%", "Affects all languages"),
("3", "%BILD%", "Images"),
("3", "%BILDER%", "Images"),
("3", "%BILDER_WERDEN_VERKLEINERT%", "Images will be reduced to size."),
("3", "%BILDLOESCHEN%", "Delete image"),
("3", "%BILD_NUR_TEILWEISE%", "The image could only be partially uploaded, please try again."),
("3", "%BILD_ZU_GROSS%", "The picture is too large."),
("3", "%BITTE_AUSWAEHLEN%", "Please choose"),
("3", "%BLOECKE%", "Blocks"),
("3", "%BODYCLASS%", "BodyClass"),
("3", "%BODYID%", "BodyId"),
("3", "%BREITE%", "Width"),
("3", "%CACHE%", "Cache"),
("3", "%CLEAR_CACHE_SEITEN%", "Always clear cache for these pages"),
("3", "%DATEI%", "File"),
("3", "%DATEIENDUNG_NICHT_ERLAUBT%", "File extension not allowed"),
("3", "%DATEIMANAGER%", "File manager"),
("3", "%DATEINAME%", "File Name"),
("3", "%DATEI_DURCH_DIESE_ERSETZEN%", "Replace file with this one. Please save to apply changes."),
("3", "%DATEI_EXISTIERT_BEREITS%", "File already exists"),
("3", "%DATEI_GELOESCHT%", "File removed"),
("3", "%DATEI_NICHT_HOCHLADEN%", "Don't upload file."),
("3", "%DATEI_SEHR_GROSS%", "The file is very large (#SIZE#). Uploading may take some time."),
("3", "%DATEI_ZU_GROSS%", "One of the attached files is too big!"),
("3", "%DATEN%", "Data"),
("3", "%DATEN_WURDEN_GELOESCHT%", "The data was deleted"),
("3", "%DATEN_WURDEN_GESPEICHERT%", "Your data was saved."),
("3", "%DATUM%", "Date"),
("3", "%DATUM_ABSTEIGEND%", "Date descending"),
("3", "%DATUM_AUFSTEIGEND%", "Date ascending"),
("3", "%DIESE_SEITE_GIBT_ES_NICHT%", "Page not found."),
("3", "%DOMAIN_NICHT_ERREICHBAR%", "Domain not available"),
("3", "%DOWNLOAD%", "Download"),
("3", "%DUMP%", "Dump"),
("3", "%EIGENE%", "Only own"),
("3", "%EIGENE_SEITEN%", "local pages"),
("3", "%EINE_ZEILE_NACH_OBEN%", "One line up"),
("3", "%EINE_ZEILE_NACH_UNTEN%", "One line down"),
("3", "%EINFUEGEN%", "Paste"),
("3", "%EINLOGGEN%", "Log-in"),
("3", "%EINTRAEGE_BEARBEITET%", "Entries processed"),
("3", "%EINTRAEGE_FINDEN%", "Find entries"),
("3", "%EINTRAGEN%", "Save"),
("3", "%EINTRAG_AENDERN%", "Edit entry"),
("3", "%EINTRAG_BEARBEITEN%", "Edit Entry"),
("3", "%EINTRAG_KOMMENTIEREN%", "Comment entry"),
("3", "%EMAIL%", "E-mail"),
("3", "%EMAILS_ALS_LISTE%", "Show e-mails as list"),
("3", "%EMAILS_AN_DIESE_EMPFAENGER%", "Send emails to these recipients"),
("3", "%EMAILS_SIND_VERSANDT_WORDEN%", "E-mails have been send."),
("3", "%EMAIL_ZEIGEN%", "Show email"),
("3", "%EMPFAENGER%", "Recipients"),
("3", "%ENDE_ABSTEIGEND%", "End descending"),
("3", "%ENDE_AUFSTEIGEND%", "End ascending"),
("3", "%ENTFERNEN%", "Remove "),
("3", "%ERLAUBTE_DATEIENDUNGEN%", "Please only upload files with the following file extensions"),
("3", "%ERSCHEINT_IM_MENUE%", "Appears in the menu"),
("3", "%ERSTELLEN%", "Create"),
("3", "%ERSTSTELLT_AM%", "created on"),
("3", "%EXPORT%", "Export"),
("3", "%FAX%", "Fax"),
("3", "%FCKEDITOR%", "FCKeditor"),
("3", "%FEHLER%", "An error occured"),
("3", "%FENSTERTITEL%", "Window Title"),
("3", "%FENSTER_SCHLIESSEN%", "Close window"),
("3", "%FETT%", "Bold"),
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
("3", "%FORMATE_ENTFERNEN%", "Remove format"),
("3", "%FORUM%", "Forum"),
("3", "%FORUMEINTRAG%", "Forum posts"),
("3", "%FORUMVORLAGE%", "Forum template"),
("3", "%FREISCHALTEN%", "Unlock"),
("3", "%FUER_MAIL_AUSWAEHLEN%", "Select e-mail"),
("3", "%Farben%", "Colors"),
("3", "%Formatiert%", "Formats"),
("3", "%GAESTEBUCH%", "Guestbook"),
("3", "%GAESTEBUCHSEITE%", "Guestbook page"),
("3", "%GAESTEBUCH_BEARBEITEN%", "Edit guestbook "),
("3", "%GALERIEN%", "Galleries"),
("3", "%GANZ_SICHER%", "Are you sure?"),
("3", "%GELOESCHT%", "Deleted"),
("3", "%GROESSENVORGABEN%", "Size presets"),
("3", "%HEUTE%", "Today"),
("3", "%HINTERGRUENDE%", "Backgrounds"),
("3", "%HINTERGRUND%", "Background"),
("3", "%HINTERGRUND2%", "Background"),
("3", "%HOCHGELADEN%", "Uploaded"),
("3", "%HOCHGELADEN_FEHLGESCHLAGEN%", "Something has gone wrong during upload."),
("3", "%HOCHLADEN%", "Upload"),
("3", "%HOCHLADEN_FEHLGESCHLAGEN%", "Upload failed "),
("3", "%HOEHE%", "Height"),
("3", "%IMPORT%", "Import"),
("3", "%IMPORTIEREN%", "Import"),
("3", "%IMPRESSUM%", "Imprint"),
("3", "%INFO_STICHWORTE%", "Important keywords should occur more often, they are displayed larger here."),
("3", "%IN_BEARBEITUNG%", "Under construction"),
("3", "%IN_NEUEM_FENSTER_OEFFNEN%", "Open in new Window"),
("3", "%IN_TEXT_EINFUEGEN%", "Insert into text"),
("3", "%KALENDERVORLAGE%", "Calendar Template"),
("3", "%KATEGAL%", "Show sub pages independent of groups"),
("3", "%KATEGORIE%", "Category"),
("3", "%KATEGORIEN%", "Groups"),
("3", "%KATEGORIEN_BEARBEITEN%", "Edit groups"),
("3", "%KATEGORIE_BEARBEITEN%", "Edit group"),
("3", "%KATEGORIE_IST_ANGELEGT%", "New group was created "),
("3", "%KATEGORIE_OHNE_TITEL%", "Without title, the group can not be saved. "),
("3", "%KEINE_ABONENNTEN_GEWAEHLT%", "No subscribers selected"),
("3", "%KEINE_EINTRAEGE%", "No entries found"),
("3", "%KEINE_EINTRAEGE_GEFUNDEN%", "No entries found"),
("3", "%KEINE_HTML_UNTERSEITEN%", "No html sub pages"),
("3", "%KEINE_NUM_UNTERSEITEN%", "No numeric sub pages"),
("3", "%KEIN_EMPFAENGER_GEWAEHLT%", "No recipients selected"),
("3", "%KLEIN%", "Small"),
("3", "%KLICK_TOGGLE%", "Click to show / hide"),
("3", "%KOMMAGETRENNT%", "Comma-separated"),
("3", "%KOMMENTAR%", "Comment"),
("3", "%KOMPRIMIERUNG%", "Use compression"),
("3", "%KONFIGURATIONSOPTIONEN%", "Configuration options"),
("3", "%KONTAKT%", "Contact"),
("3", "%KOPIEREN%", "Copy"),
("3", "%KOPIE_VON%", "Copy of"),
("3", "%LETZTE_GESPEICHERTE_VERSION%", "Last saved version"),
("3", "%LINIE%", "Line"),
("3", "%LINKS%", "Left"),
("3", "%LINK_EINFUEGEN%", "Paste as link"),
("3", "%LISTE%", "List"),
("3", "%LOESCHEN%", "Delete"),
("3", "%LOESCHEN_FEHLGESCHLAGEN%", "Remove failed"),
("3", "%LOESCHEN_ODER_ABBRECHEN%", "Confirm Delete (OK) oder Cancel operation (Cancel)"),
("3", "%LOGIN%", "Username"),
("3", "%LOGOUT%", "Logout"),
("3", "%LOGOUT_IM_MENUE%", "Logout in menu"),
("3", "%MAIL%", "Email"),
("3", "%MARKIERUNGEN_ENTFERNEN%", "Clear highlighting"),
("3", "%MARKIERUNGEN_VON_BEGRIFFEN_ENTFERNEN%", "Clear highlighting"),
("3", "%MAXZEICHEN%", "More than #MAXLENGTH# characters are not allowed."),
("3", "%MELDUNGEN%", "Messages / Errors"),
("3", "%MENU%", "Menu "),
("3", "%MENUEBILD%", "Menu image"),
("3", "%MENUEBILD2%", "Menu image (hover)"),
("3", "%MENUEBILDER%", "Menu images"),
("3", "%MENUEEINTRAG%", "Menu item"),
("3", "%MINDESTENS_SECHS_ZEICHEN%", "The password should contain at least six characters."),
("3", "%MOBIL%", "Mobile"),
("3", "%MYSQL%", "MySQL"),
("3", "%NACHBARSEITEN%", "Neighbor pages"),
("3", "%NACHRICHT%", "Message"),
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
("3", "%NEWSLETTER_ABSCHICKEN%", "Send newsletter"),
("3", "%NEWSLETTER_EINZELN_SENDEN%", "Send newsletter individually"),
("3", "%NEWSLETTER_VERSANDT%", "Newsletter send"),
("3", "%NEWSLETTER_VORSCHAU%", "Newsletter preview"),
("3", "%NICHT_GELOESCHT%", "Not deleted");

-- # Schnipp --
INSERT INTO `#PREFIX#_translate` (`LANG_ID`,`name`,`value`) VALUES
("3", "%NLEMAILVORLAGE%", "Newsletter e-mail"),
("3", "%NR%", "No."),
("3", "%NUR_AN_DIESE_EMPFAENGER%", "Only selected recipients"),
("3", "%NUR_TEXT_EINFUEGEN%", "Insert only  text"),
("3", "%ODER_KATEGORIEN_LOESCHEN%", "or delete groups - corresponding pages will be removed!"),
("3", "%ODER_VORLAGEN_LOESCHEN%", "or delete templates - all corresponding pages will be removed!"),
("3", "%OEFFNEN%", "Open"),
("3", "%OHNE%", "without"),
("3", "%OPTIMIEREN%", "Optimize"),
("3", "%ORDNER_ANGELEGT%", "Directory created"),
("3", "%ORDNER_GELOESCHT%", "Directory removed"),
("3", "%ORDNER_LOESCHEN_FEHLGESCHLAGEN%", "Removing directory failed"),
("3", "%ORT%", "Place"),
("3", "%OVER%", "Over"),
("3", "%PAGE%", "Page"),
("3", "%PASSWORT%", "Password"),
("3", "%PASSWORTGESPEICHERT%", "The new password has been saved."),
("3", "%PASSWORTGLEICHEIT%", "Please check that you have specified the same password both times."),
("3", "%PASSWORTZEICHENFEHLER%", "Your password contains invalid characters or is too short (spaces and special characters are not allowed and there should be minimum 6 characters)."),
("3", "%PASSWORT_AENDERN%", "Change Password"),
("3", "%PERSOENLICHE_DATEN%", "Personal data"),
("3", "%PERSOENLICHE_DATEN_BEARBEITEN%", "Edit personal data"),
("3", "%PERSON%", "User"),
("3", "%PERSONEN%", "People"),
("3", "%PERSONEN_ONLINE%", "Users online"),
("3", "%PFAD_ZUM_JAVASCRIPT%", "Path to javascript"),
("3", "%PFAD_ZU_BILDERN%", "Path to images "),
("3", "%PFAD_ZU_DEN_STYLESHEETS%", "Path to StyleSheet"),
("3", "%PFAD_ZU_DEN_VORLAGEN%", "Path to templates"),
("3", "%PFLICHTFELD%", "Required field"),
("3", "%PLUGINS%", "Plugins / modules"),
("3", "%POS%", "Pos"),
("3", "%POSITION%", "Position"),
("3", "%POS_ABSTEIGEND%", "Pos descending"),
("3", "%POS_AUFSTEIGEND%", "Pos ascending"),
("3", "%PREVIEW%", "Preview"),
("3", "%PROFILING%", "PHP Profiling"),
("3", "%PRO_SEITE%", "Per page"),
("3", "%RECHTE%", "Set rights"),
("3", "%RECHTS%", "Right"),
("3", "%SCHLIESSEN%", "Close"),
("3", "%SCHRAEG%", "Oblique"),
("3", "%SCHREIBFEHLER%", "error writing file"),
("3", "%SCHREIBWEISE%", "Spelling"),
("3", "%SEITE%", "Page"),
("3", "%SEITEN%", "Pages"),
("3", "%SEITENBESCHREIBUNG%", "Description of page content"),
("3", "%SEITENBESUCHE_ZAEHLEN%", "Visits count"),
("3", "%SEITENDETAILS%", "Page details"),
("3", "%SEITENUEBERSCHRIFT%", "Page Headline"),
("3", "%SEITENVORLAGE%", "Page Template"),
("3", "%SEITEN_ANLEGEN%", "Creating pages"),
("3", "%SEITEN_ANZEIGEN%", "Show pages"),
("3", "%SEITEN_BEARBEITEN%", "Edit Pages"),
("3", "%SEITEN_DIESER_AUSWAHL%", "Pages of this selection"),
("3", "%SEITEN_DIESER_KATEGORIE%", "Pages in this groups"),
("3", "%SEITEN_ZWISCHENSPEICHERN%", "Cached pages"),
("3", "%SEITE_ALS_EIGENE_UNTERSEITE%", "A page can not be her own bottom."),
("3", "%SEITE_ANZEIGEN%", "Preview"),
("3", "%SEITE_BEARBEITEN%", "Edit page"),
("3", "%SEITE_ERSTELLT_AM%", "Page created on"),
("3", "%SEITE_FREIGEBEN%", "release pages"),
("3", "%SEITE_GELOESCHT%", "Page deleted"),
("3", "%SEITE_OHNE_TITEL%", "The page can not be saved without a title."),
("3", "%SENDEN%", "Send"),
("3", "%SONDERSEITEN%", "Special pages"),
("3", "%SONDERVORLAGEN%", "Special Templates"),
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
("3", "%TAB%", "Tab"),
("3", "%TABELLE%", "Table"),
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
("3", "%TEXT%", "Text"),
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
("3", "%UMBRUCH%", "Line break"),
("3", "%UNBEDINGT_AUSWAEHLEN%", "please choose"),
("3", "%UND%", "and"),
("3", "%UNIDENTIFIZIERTER_FEHLER%", "Unidentified error"),
("3", "%UNTERSEITE%", "Sub page"),
("3", "%UNTERSEITEN%", "sub-pages"),
("3", "%UNTERSEITEN_ANZEIGEN%", "Browse subpages"),
("3", "%UNTERSEITE_VON%", "Subpage of"),
("3", "%UNTERSTRICHEN%", "Underline"),
("3", "%UPLOAD%", "Upload"),
("3", "%UPLOAD_ZU_GROSS%", "The sum of files to upload is too large (#SIZE#). More than #MFS# is not supported by the server. Please save and continue."),
("3", "%URL%", "Url"),
("3", "%Uhr%", "h"),
("3", "%VEROEFFENTLICHEN%", "Publish"),
("3", "%VERSCHIEBEN%", "Move"),
("3", "%VERSTECKEN%", "Hide"),
("3", "%VERWALTUNGSSEITEN%", "Translate back-end"),
("3", "%VERWALTUNGSSPRACHE%", "Admin language"),
("3", "%VERWEIS%", "Reference"),
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
("3", "%WEITERBLAETTERN%", "Go to next page"),
("3", "%WEITERE_ANGABEN%", "More settings"),
("3", "%WEITERE_DATEN%", "More information"),
("3", "%WIEDERHOLUNG%", "Repetition"),
("3", "%WIRD_BEARBEITET_VON%", "Someone is working here"),
("3", "%WORD_BEREINIGEN%", "Word Cleanup"),
("3", "%WWW%", "www"),
("3", "%ZEIGEN%", "Show"),
("3", "%ZEIT%", "Time"),
("3", "%ZENTRIERT%", "Centered"),
("3", "%ZUGEHOERIGE_SEITEN%", "Related Pages"),
("3", "%ZUGEHOERIGE_UNTERSEITEN%", "Related subpages"),
("3", "%ZUGEORDNETE_SEITEN%", "associated pages"),
("3", "%ZUGRIFF%", "Access"),
("3", "%ZURUECK%", "Back"),
("3", "%ZURUECKBLAETTERN%", "Go to previous page"),
("3", "%ZU_VIELE_UPLOADS%", "Too many uploads (#UPCOUNT#). More than #MFU# are not supported b the server. Please save and continue.");
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
  PRIMARY KEY  (`LANG_ID`,`PAGE_ID`,`PART_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=abschnitte # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "16", "1", "a%3A3%3A%7Bs%3A13%3A%22Menucode_code%22%3Bs%3A0%3A%22%22%3Bs%3A11%3A%22Iecode_code%22%3Bs%3A0%3A%22%22%3Bs%3A12%3A%22Iecode2_code%22%3Bs%3A0%3A%22%22%3B%7D", "", "99", "1", "", "2010-12-09", "0000-00-00"),
("0", "17", "1", "a%3A2%3A%7Bs%3A7%3A%22Js_code%22%3Bs%3A451%3A%22function+mouseeffect%28%29%7B%0D%0Avar+menus+%3D+document.getElementById%28%26quot%3Binhalt%26quot%3B%29.getElementsByTagName%28%26quot%3Bdiv%26quot%3B%29%3B%0D%0A++for+%28+var+i%3D0%3B+i+%26gt%3B+menus.length%3B+i%2B%2B+%29+%7B%0D%0A++++menus%5Bi%5D.setAttribute%28%26quot%3Bid%26quot%3B%2C%26quot%3Bmenu%26quot%3B%2Bi%29%3B%0D%0A++++menus%5Bi%5D.onmouseover+%3D+function+%28%29+%7Bdocument.getElementById%28this.id%29.className+%3D+%26quot%3Bmenuover%26quot%3B%3B%7D%0D%0A++++menus%5Bi%5D.onmouseout++%3D+function+%28%29+%7Bdocument.getElementById%28this.id%29.className+%3D+%26quot%3Bmenu%26quot%3B%3B%7D%0D%0A++%7D%0D%0A%7D%22%3Bs%3A14%3A%22Quellcode_code%22%3Bs%3A303%3A%22%26lt%3Bbody+id%3D%26quot%3Beine%26quot%3B%26gt%3B%0D%0A...%0D%0A%26lt%3Bul+class%3D%26quot%3Bmenu%26quot%3B%26gt%3B%0D%0A++%26lt%3Bli%26gt%3B%26lt%3Ba+class%3D%26quot%3Beine%26quot%3B+href%3D%26quot%3Beine.shtml%26quot%3B+%26gt%3BEine+Seite%26lt%3B%2Fa%26gt%3B%26lt%3B%2Fli%26gt%3B%0D%0A++%26lt%3Bli%26gt%3B%26lt%3Ba+class%3D%26quot%3Bandere%26quot%3B+href%3D%26quot%3Bandere.shtml%26quot%3B+%26gt%3BAndere+Seite%26lt%3B%2Fa%26gt%3B%26lt%3B%2Fli%26gt%3B%0D%0A%26lt%3B%2Ful%26gt%3B%22%3B%7D", "", "99", "1", "function mouseeffect(){
var menus = document.getElementById(&qu", "2010-12-09", "0000-00-00"),
("0", "18", "1", "a%3A3%3A%7Bs%3A7%3A%22Js_code%22%3Bs%3A930%3A%22function+seiteninhalt%28%29%7B%0D%0A++++var+header+%3D+document.getElementsByTagName%28%22body%22%29%5B0%5D.getElementsByTagName%28%22h4%22%29%3B%0D%0A++++if+%28header.length+%3E+1%29+%7B%0D%0A++++++++document.getElementsByTagName%28%22h3%22%29%5B0%5D.setAttribute%28%22id%22%2C%22header0%22%29%3B%0D%0A++++++++var+toc+%3D+document.createElement%28%22ul%22%29%3B%0D%0A++++++++toc.setAttribute%28%22class%22%2C%22toc%22%29%3B%0D%0A++++++++var+string+%3D+%22%26lt%3Bli%26gt%3B%26lt%3Ba+href%3D%22%23header0%22%26gt%3BAnfang%26lt%3B%2Fa%26gt%3B%26lt%3B%2Fli%26gt%3B%2Fn%22%3B%0D%0A++++++++for+%28+var+i%3D0%3B+i+%3C+header.length%3B+i%2B%2B+%29+%7B%0D%0A++++++++++++header%5Bi%5D.setAttribute%28%22id%22%2C%22header%22%2Bi%29%3B%0D%0A++++++++++++header%5Bi%5D.setAttribute%28%22name%22%2C%22header%22%2Bi%29%3B%0D%0A++++++++++++if+%28toclink+%3D+header%5Bi%5D.firstChild.innerHTML%29+%7B%7D%0D%0A++++++++++++else%0D%0A++++++++++++++++toclink+%3D+header%5Bi%5D.innerHTML%3B%0D%0A++++++++++++string+%3D+string+%2B+%27%26lt%3Bli%26gt%3B%26lt%3Ba+id%3D%22toc%27+%2B+i+%2B+%27%22+href%3D%22%23header%27+%2B+i+%2B+%27%22%26gt%3B%27+%2B+toclink+%2B+%27%26lt%3B%2Fa%3E%26lt%3B%2Fli%26gt%3B%27%3B%0D%0A++++++++%7D%0D%0A++++++++toc.innerHTML+%3D+string%3B%0D%0A++++++++document.getElementById%28%22toc%22%29.appendChild%28toc%29%3B%0D%0A++++%7D%0D%0A%7D%22%3Bs%3A17%3A%22Ueberschrift_code%22%3Bs%3A47%3A%22%26lt%3Bh4%26gt%3BAutomatischer+Seiteninhalt%26lt%3B%2Fh4%26gt%3B%22%3Bs%3A12%3A%22Geckojs_code%22%3Bs%3A1514%3A%22function+seiteninhalt%28%29%7B%0D%0A++++var+header+%3D+document.getElementsByTagName%28%22body%22%29%5B0%5D.getElementsByTagName%28%22h4%22%29%3B%0D%0A++++document.getElementsByTagName%28%22h3%22%29%5B0%5D.setAttribute%28%22id%22%2C%22header0%22%29%3B%0D%0A++++var+toc+%3D+document.createElement%28%22ul%22%29%3B%0D%0A++++toc.setAttribute%28%22class%22%2C%22toc%22%29%3B%0D%0A++++var+filename+%3D+document.URL.split%28%22%2F%22%29%0D%0A++++if+%28document.URL.replace%28filename%5Bfilename.length-1%5D%2C%22%22%29+%21%3D+%22http%3A%2F%2F%22%2Bwindow.location.host%2B%22%2F%22%29+%7B%0D%0A++++++++makeli%28toc%2C%22..%2F%22%2C%22Eine+Ebene+h%F6her%22%29%3B%0D%0A++++%7D%0D%0A++++if+%28document.URL.match%28%22shtml%22%29+%26%26+%21document.URL.match%28%22index%22%29%29+%7B%0D%0A++++++++makeli%28toc%2C%22.%2F%22%2C%22Dieses+Verzeichnis%22%29%3B%0D%0A++++%7D%0D%0A++++maketoc%28header%2Ctoc%29%3B%0D%0A%7D%0D%0Afunction+maketoc%28header%2Ctoc%29%7B%0D%0A++++if+%28header.length+%3E+1%29+%7B%0D%0A++++++++makeli%28toc%2C%22%23header0%22%2C%22Seitenanfang%22%29%3B%0D%0A++++++++for+%28+var+i%3D0%3B+i+%3C+header.length%3B+i%2B%2B+%29+%7B%0D%0A++++++++++++header%5Bi%5D.setAttribute%28%22id%22%2C%22header%22%2Bi%29%3B%0D%0A++++++++++++header%5Bi%5D.setAttribute%28%22name%22%2C%22header%22%2Bi%29%3B%0D%0A++++++++++++if+%28toclink+%3D+header%5Bi%5D.firstChild.innerHTML%29+%7B%7D%0D%0A++++++++++++else%0D%0A++++++++++++++++toclink+%3D+header%5Bi%5D.innerHTML%3B%0D%0A++++++++++++++++makeli%28toc%2C%22%23header%22%2Bi%2Ctoclink%29%3B%0D%0A++++++++++++%7D%0D%0A++++++++%7D%0D%0A++++++++document.getElementById%28%22toc%22%29.appendChild%28toc%29%3B%0D%0A%7D%0D%0Afunction+makeli%28toc%2Chref%2Ctext%29%7B%0D%0A++++var+lielement+%3D+document.createElement%28%22li%22%29%3B%0D%0A++++var+innerelement+%3D+document.createElement%28%22a%22%29%3B%0D%0A++++innerelement.setAttribute%28%22href%22%2Chref%29%3B%0D%0A++++elementtext+%3D+document.createTextNode%28text%29%3B%0D%0A++++innerelement.appendChild%28elementtext%29%3B%0D%0A++++lielement.appendChild%28innerelement%29%3B%0D%0A++++toc.appendChild%28lielement%29%3B%0D%0A%7D%22%3B%7D", "", "99", "1", "function seiteninhalt(){
    var header = document.getElementsB", "2010-12-09", "0000-00-00"),
("0", "19", "1", "a%3A11%3A%7Bs%3A8%3A%22Cc1_code%22%3Bs%3A96%3A%22%26lt%3B%21--%5Bif+IE%5D%26gt%3B%0D%0AAnweisungen%2C+die+nur+der+Internet+Explorer+sehen+soll...%0D%0A%26lt%3B%21%5Bendif%5D--%26gt%3B%22%3Bs%3A9%3A%22Ie5x_code%22%3Bs%3A20%3A%22%26lt%3B%21--%5Bif+IE+5%5D%26gt%3B%22%3Bs%3A9%3A%22Ie50_code%22%3Bs%3A22%3A%22%26lt%3B%21--%5Bif+IE+5.0%5D%26gt%3B%22%3Bs%3A9%3A%22Ie55_code%22%3Bs%3A22%3A%22%26lt%3B%21--%5Bif+IE+5.5%5D%26gt%3B%22%3Bs%3A8%3A%22Ie6_code%22%3Bs%3A20%3A%22%26lt%3B%21--%5Bif+IE+6%5D%26gt%3B%22%3Bs%3A8%3A%22Ie7_code%22%3Bs%3A20%3A%22%26lt%3B%21--%5Bif+IE+7%5D%26gt%3B%22%3Bs%3A10%3A%22Nicht_code%22%3Bs%3A21%3A%22%26lt%3B%21--%5Bif+%21IE+6%5D%26gt%3B%22%3Bs%3A7%3A%22Lt_code%22%3Bs%3A23%3A%22%26lt%3B%21--%5Bif+lt+IE+6%5D%26gt%3B%22%3Bs%3A8%3A%22Lte_code%22%3Bs%3A24%3A%22%26lt%3B%21--%5Bif+lte+IE+6%5D%26gt%3B%22%3Bs%3A7%3A%22Gt_code%22%3Bs%3A23%3A%22%26lt%3B%21--%5Bif+gt+IE+6%5D%26gt%3B%22%3Bs%3A8%3A%22Gte_code%22%3Bs%3A24%3A%22%26lt%3B%21--%5Bif+gte+IE+6%5D%26gt%3B%22%3B%7D", "", "99", "1", "&lt;!--[if IE]&gt;
Anweisungen, die nur der Internet Explorer s", "2010-12-09", "0000-00-00"),
("0", "22", "1", "a%3A2%3A%7Bs%3A11%3A%22Iecode_code%22%3Bs%3A197%3A%22%26lt%3Bhead%26gt%3B%0D%0A++...%5Bandere+Angaben%5D...%0D%0A++%26lt%3B%21--%5Bif+IE%5D%26gt%3B%0D%0A++++%26lt%3Blink+rel%3D%26quot%3Bstylesheet%26quot%3B+type%3D%26quot%3Btext%2Fcss%26quot%3B+href%3D%26quot%3Bnurie.css%26quot%3B+%2F%26gt%3B%0D%0A++%26lt%3B%21%5Bendif%5D--%26gt%3B%0D%0A%26lt%3B%2Fhead%26gt%3B%22%3Bs%3A12%3A%22Iecode2_code%22%3Bs%3A244%3A%22%26lt%3Bhead%26gt%3B%0D%0A++...%5Bandere+Angaben%5D...%0D%0A++%26lt%3B%21--%23if+expr%3D%26quot%3B%24%7BHTTP_USER_AGENT%7D+%3D+%2FMSIE%2F%29%26quot%3B+--%26gt%3B%0D%0A++++%26lt%3Blink+rel%3D%26quot%3Bstylesheet%26quot%3B+type%3D%26quot%3Btext%2Fcss%26quot%3B+href%3D%26quot%3Bnurie.css%26quot%3B+%2F%26gt%3B%0D%0A++%26lt%3B%21--%23endif+--%26gt%3B%0D%0A%26lt%3B%2Fhead%26gt%3B%22%3B%7D", "", "99", "1", "&lt;head&gt;
  ...[andere Angaben]...
  &lt;!--[if IE]&gt;", "2010-12-09", "0000-00-00"),
("0", "28", "1", "a%3A1%3A%7Bs%3A14%3A%22Sonstiges_text%22%3Bs%3A0%3A%22%22%3B%7D", "", "99", "1", "", "2010-08-16", "0000-00-00"),
("0", "30", "0", "", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "", "2010-08-26", "0000-00-00"),
("0", "30", "1", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A3%3A%22Ort%22%3Bs%3A3%3A%22Ort%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A6%3A%22Senden%22%3Bs%3A6%3A%22Senden%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A35%3A%22Bitte+f%C3%BCllen+Sie+diese+Felder+aus.%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A94%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AKontaktdaten%3A%0D%0A%23NAME%23%0D%0A%23STRASSE%23%0D%0A%23ORT%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AE-Mail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "Name", "2010-08-26", "0000-00-00"),
("0", "30", "2", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A6%3A%22%D8%A7%D8%B3%D9%85%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A8%3A%22%D8%B4%D8%A7%D8%B1%D8%B9%22%3Bs%3A3%3A%22Ort%22%3Bs%3A8%3A%22%D9%85%D9%83%D8%A7%D9%86%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A12%3A%22%D8%A7%D9%84%D9%87%D8%A7%D8%AA%D9%81%22%3Bs%3A5%3A%22Email%22%3Bs%3A33%3A%22%D8%A7%D9%84%D8%A8%D8%B1%D9%8A%D8%AF+%D8%A7%D9%84%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A14%3A%22%D8%A7%D9%84%D9%85%D9%88%D8%B6%D9%88%D8%B9%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A18%3A%22%D8%A7%D9%84%D8%A7%D8%AA%D8%B5%D8%A7%D9%84%D8%A7%D8%AA%22%3Bs%3A6%3A%22Senden%22%3Bs%3A10%3A%22%D8%A5%D8%B1%D8%B3%D8%A7%D9%84%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A36%3A%22%D9%8A%D8%B1%D8%AC%D9%89+%D9%85%D9%84%D8%A1+%D9%87%D8%B0%D9%87+%D8%A7%D9%84%D8%AD%D9%82%D9%88%D9%84.%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A94%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AKontaktdaten%3A%0D%0A%23NAME%23%0D%0A%23STRASSE%23%0D%0A%23ORT%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AE-Mail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "اسم", "2010-08-26", "0000-00-00"),
("0", "30", "3", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A4%3A%22Name%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A6%3A%22Street%22%3Bs%3A3%3A%22Ort%22%3Bs%3A5%3A%22Place%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A9%3A%22Telephone%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-mail%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A7%3A%22Subject%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A7%3A%22Message%22%3Bs%3A6%3A%22Senden%22%3Bs%3A4%3A%22Send%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A25%3A%22Please+fill+these+fields.%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A94%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AContact+data%3A%0D%0A%23NAME%23%0D%0A%23STRASSE%23%0D%0A%23ORT%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AE-mail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "Name", "2010-08-26", "0000-00-00"),
("0", "30", "4", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A9%3A%22%E0%A4%A8%E0%A4%BE%E0%A4%AE%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A12%3A%22%E0%A4%B8%E0%A4%A1%E0%A4%BC%E0%A4%95%22%3Bs%3A3%3A%22Ort%22%3Bs%3A9%3A%22%E0%A4%B6%E0%A4%B9%E0%A4%B0%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A18%3A%22%E0%A4%A6%E0%A5%82%E0%A4%B0%E0%A4%AD%E0%A4%BE%E0%A4%B7%22%3Bs%3A5%3A%22Email%22%3Bs%3A13%3A%22%E0%A4%88+%E0%A4%AE%E0%A5%87%E0%A4%B2%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A12%3A%22%E0%A4%B5%E0%A4%BF%E0%A4%B7%E0%A4%AF%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A15%3A%22%E0%A4%B8%E0%A4%82%E0%A4%A6%E0%A5%87%E0%A4%B6%22%3Bs%3A6%3A%22Senden%22%3Bs%3A15%3A%22%E0%A4%AD%E0%A5%87%E0%A4%9C%E0%A5%87%E0%A4%82%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A55%3A%22%E0%A4%87%E0%A4%A8+%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A5%87%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A5%8B%E0%A4%82+%E0%A4%95%E0%A5%8B+%E0%A4%AD%E0%A4%B0%E0%A5%87%E0%A4%82.%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A94%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AKontaktdaten%3A%0D%0A%23NAME%23%0D%0A%23STRASSE%23%0D%0A%23ORT%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AE-Mail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "नाम", "2010-08-26", "0000-00-00"),
("0", "30", "5", "a%3A10%3A%7Bs%3A4%3A%22Name%22%3Bs%3A6%3A%22%E5%90%8D%E7%A7%B0%22%3Bs%3A7%3A%22Strasse%22%3Bs%3A3%3A%22%E8%B7%AF%22%3Bs%3A3%3A%22Ort%22%3Bs%3A6%3A%22%E5%9F%8E%E5%B8%82%22%3Bs%3A7%3A%22Telefon%22%3Bs%3A6%3A%22%E7%94%B5%E8%AF%9D%22%3Bs%3A5%3A%22Email%22%3Bs%3A12%3A%22%E7%94%B5%E5%AD%90%E9%82%AE%E4%BB%B6%22%3Bs%3A7%3A%22Betreff%22%3Bs%3A6%3A%22%E4%B8%BB%E9%A2%98%22%3Bs%3A10%3A%22Mitteilung%22%3Bs%3A6%3A%22%E6%B6%88%E6%81%AF%22%3Bs%3A6%3A%22Senden%22%3Bs%3A6%3A%22%E5%8F%91%E9%80%81%22%3Bs%3A18%3A%22Pflichtfelder_text%22%3Bs%3A21%3A%22%E8%AF%B7%E5%A1%AB%E5%86%99%E8%BF%99%E4%BA%9B%E5%AD%97%E6%AE%B5%22%3Bs%3A9%3A%22Mail_text%22%3Bs%3A94%3A%22%23MITTEILUNG%23%0D%0A%0D%0A---%0D%0AKontaktdaten%3A%0D%0A%23NAME%23%0D%0A%23STRASSE%23%0D%0A%23ORT%23%0D%0ATel.%3A+%23TELEFON%23%0D%0AE-Mail%3A+%23EMAIL%23%22%3B%7D", "NAME,EMAIL,BETREFF,MITTEILUNG", "99", "1", "名称", "2010-08-26", "0000-00-00"),
("0", "31", "0", "", "", "20", "1", "", "2010-11-26", "0000-00-00"),
("0", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Dorothea+Brummerloh%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.dorothea-brummerloh.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A345%3A%22%3Cp%3EF%C3%BCr+die+freie+Journalistin+Dorothea+Brummerloh+entstand+dieser+Internet%C2%ADauftritt%2C+mit+dem+Dorothea+ihre+Arbeit+und+sich+selbst+vorstellen+m%C3%B6chte.+Zu+ihrem+Portfolio+geh%C3%B6ren+Medizinbeitr%C3%A4ge%2C+Buntes+und+Wissenschaftsjournalismus.+Selbstverst%C3%A4ndlich+gibt+es+auf+ihrer+Seite+auch+ein+paar+H%C3%B6rproben+aus+Beitr%C3%A4gen+f%C3%BCr+den+NDR+und+NWR.%3C%2Fp%3E%22%3B%7D", "", "20", "1", "Dorothea Brummerloh", "2010-11-26", "0000-00-00"),
("0", "31", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Dorothea+Brummerloh%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.dorothea-brummerloh.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A326%3A%22%3Cp%3E%D9%83%D8%A7%D9%86+%D8%A7%D9%84%D8%B5%D8%AD%D8%A7%D9%81%D9%8A+%D8%A7%D9%84%D9%85%D8%B3%D8%AA%D9%82%D9%84+Dorothea+Brummerloh+%D9%87%D8%B0%D8%A7+%D8%A7%D9%84%D9%85%D9%88%D9%82%D8%B9%D8%8C+%D9%85%D9%86+%D9%82%D8%A8%D9%84+%D8%AF%D9%88%D8%B1%D9%88%D8%AB%D9%8A%D8%A7+%D9%8A%D8%B1%D9%8A%D8%AF+%D8%B9%D9%85%D9%84%D9%87%D8%A7+%D9%88%D8%AA%D9%82%D8%AF%D9%8A%D9%85+%D9%86%D9%81%D8%B3%D9%83.+%D9%85%D8%AD%D9%81%D8%B8%D8%AA%D9%87%D8%A7+%D9%8A%D8%B4%D9%85%D9%84+%D9%88%D8%B8%D8%A7%D8%A6%D9%81+%D8%B7%D8%A8%D9%8A%D8%A9%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%B1%D9%81%D9%8A%D9%87%D8%8C+%D9%88%D8%A7%D9%84%D8%B5%D8%AD%D8%A7%D9%81%D8%A9+%D8%A7%D9%84%D8%B9%D9%84%D9%85%D9%8A%D8%A9.+%D8%A8%D8%A7%D9%84%D8%B7%D8%A8%D8%B9+%D9%87%D9%86%D8%A7%D9%83+%D8%A3%D9%8A%D8%B6%D8%A7+%D8%A8%D8%B9%D8%B6+%D8%A7%D9%84%D8%B9%D9%8A%D9%86%D8%A7%D8%AA+%D8%A7%D9%84%D9%89+%D8%AC%D8%A7%D9%86%D8%A8%D9%87%D9%85%3C%2Fp%3E%22%3B%7D", "", "20", "1", "Dorothea Brummerloh", "2010-11-26", "0000-00-00"),
("0", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Dorothea+Brummerloh%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.dorothea-brummerloh.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A214%3A%22%3Cp%3EDorothea+Brummerloh+is+a+freelance+journalist.+Her+portfolio+includes+medical+contributions%2C+miscellaneous+and+science+journalism.+Of+course%2C+there+are+a+few+samples+of+her+works+for+NDR+and+NWR+on+her+side.%3C%2Fp%3E%22%3B%7D", "", "20", "1", "Dorothea Brummerloh", "2010-11-26", "0000-00-00"),
("0", "31", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Dorothea+Brummerloh%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.dorothea-brummerloh.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A603%3A%22%3Cp%3E%E0%A4%B8%E0%A5%8D%E0%A4%B5%E0%A4%A4%E0%A4%82%E0%A4%A4%E0%A5%8D%E0%A4%B0+%E0%A4%AA%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A4%95%E0%A4%BE%E0%A4%B0+Dorothea+Brummerloh+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%A1%E0%A5%8B%E0%A4%B0%E0%A5%8B%E0%A4%A5%E0%A4%BE+%E0%A4%B8%E0%A4%BE%E0%A4%A5+%E0%A4%87%E0%A4%B8+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F%2C+%E0%A4%96%E0%A5%81%E0%A4%A6+%E0%A4%95%E0%A5%8B+%E0%A4%94%E0%A4%B0+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A4%BE%E0%A4%AE+%E0%A4%A5%E0%A4%BE+%E0%A4%B2%E0%A4%BE%E0%A4%97%E0%A5%82+%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A4%BE+%E0%A4%9A%E0%A4%BE%E0%A4%B9%E0%A4%A4%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82.+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%AA%E0%A5%8B%E0%A4%B0%E0%A5%8D%E0%A4%9F%E0%A4%AB%E0%A5%8B%E0%A4%B2%E0%A4%BF%E0%A4%AF%E0%A5%8B+%E0%A4%9A%E0%A4%BF%E0%A4%95%E0%A4%BF%E0%A4%A4%E0%A5%8D%E0%A4%B8%E0%A4%BE+%E0%A4%AA%E0%A4%A6%E0%A5%8B%E0%A4%82%2C+%E0%A4%B0%E0%A4%82%E0%A4%97%E0%A5%80%E0%A4%A8+%E0%A4%94%E0%A4%B0+%E0%A4%B5%E0%A4%BF%E0%A4%9C%E0%A5%8D%E0%A4%9E%E0%A4%BE%E0%A4%A8+%E0%A4%AA%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A4%95%E0%A4%BE%E0%A4%B0%E0%A4%BF%E0%A4%A4%E0%A4%BE+%E0%A4%AD%E0%A5%80+%E0%A4%B6%E0%A4%BE%E0%A4%AE%E0%A4%BF%E0%A4%B2+%E0%A4%B9%E0%A5%88.+%E0%A4%AC%E0%A5%87%E0%A4%B6%E0%A4%95+%E0%A4%89%E0%A4%A8%E0%A4%95%E0%A5%87+%E0%A4%AA%E0%A4%95%E0%A5%8D%E0%A4%B7+%E0%A4%94%E0%A4%B0+NDR+%E0%A4%94%E0%A4%B0+NWR+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%AF%E0%A5%8B%E0%A4%97%E0%A4%A6%E0%A4%BE%E0%A4%A8+%E0%A4%B8%E0%A5%87+%E0%A4%95%E0%A5%81%E0%A4%9B+%E0%A4%91%E0%A4%A1%E0%A4%BF%E0%A4%AF%E0%A5%8B+%E0%A4%A8%E0%A4%AE%E0%A5%82%E0%A4%A8%E0%A5%87+%E0%A4%AA%E0%A4%B0+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "20", "1", "Dorothea Brummerloh", "2010-11-26", "0000-00-00"),
("0", "33", "0", "", "", "95", "1", "", "2010-11-24", "0000-00-00"),
("0", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A230%3A%22%3Cp%3EPetra+Jaudszus+malt+Portraits+nach+Fotovorlage%2C+entwirft+individuelle+Wandgestaltungen+und+setzt+Ihr+Unternehmen+mit+Flyer-+und+Drucksachengestaltung+in+Szene.+Die+Gestaltung+beruht+auf+den+Entw%C3%BCrfen+der+Grafikerin+selbst.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Petra Jaudszus", "2010-11-24", "0000-00-00"),
("0", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A323%3A%22%3Cp%3EPetra+Jaudszus+%D9%8A%D8%B1%D8%B3%D9%85+%D9%84%D9%88%D8%AD%D8%A7%D8%AA+%D9%85%D9%86+%D8%A7%D9%84%D8%B5%D9%88%D8%B1+%D8%A7%D9%84%D9%81%D9%88%D8%AA%D9%88%D8%BA%D8%B1%D8%A7%D9%81%D9%8A%D8%A9.+%D9%88%D9%87%D9%8A+%D8%AA%D9%82%D9%88%D9%85+%D8%A3%D9%8A%D8%B6%D8%A7+%D8%A8%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%AC%D8%AF%D8%A7%D8%B1%D9%8A%D8%A9+%D8%A7%D9%84%D9%81%D8%B1%D8%AF%D9%8A%D8%A9+%D9%88%D8%B3%D8%AA%D8%B9%D8%B1%D8%B6+%D8%B4%D8%B1%D9%83%D8%A9+%D9%84%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D9%86%D8%B4%D8%B1%D8%A7%D8%AA+%D9%88%D8%A7%D9%84%D9%85%D8%B7%D8%A8%D9%88%D8%B9%D8%A7%D8%AA+%D9%81%D9%8A+%D8%AF%D8%A7%D8%A6%D8%B1%D8%A9+%D8%A7%D9%84%D8%B6%D9%88%D8%A1.+%D9%8A%D8%B1%D8%AA%D9%83%D8%B2+%D9%81%D9%8A+%D8%AA%D8%B5%D9%85%D9%8A%D9%85%D9%87+%D8%B9%D9%84%D9%89+%D8%AA%D8%B5%D8%A7%D9%85%D9%8A%D9%85+%D9%85%D9%86+%D8%A7%D9%84%D8%B1%D8%B3%D9%85+%D9%86%D9%81%D8%B3%D9%87.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Petra Jaudszus", "2010-11-24", "0000-00-00"),
("0", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A196%3A%22%3Cp%3EPetra+Jaudszus+paints+portraits+after+photo%2C+she+has+designed+custom+wall+design+and+puts+your+business+in+the+limelight+with+flyer+and+print+design.+The+design+is+based+on+her+own+designs.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Petra Jaudszus", "2010-11-24", "0000-00-00"),
("0", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A474%3A%22%3Cp%3EPetra+Jaudszus%2C+%E0%A4%AB%E0%A5%8B%E0%A4%9F%E0%A5%8B+%E0%A4%B8%E0%A4%82%E0%A4%A6%E0%A4%B0%E0%A5%8D%E0%A4%AD+%E0%A4%B8%E0%A5%87+%E0%A4%AA%E0%A5%8B%E0%A4%9F%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%9F+%E0%A4%AA%E0%A5%87%E0%A4%82%E0%A4%9F%E0%A4%BF%E0%A4%82%E0%A4%97+%E0%A4%B5%E0%A5%8D%E0%A4%AF%E0%A4%95%E0%A5%8D%E0%A4%A4%E0%A4%BF%E0%A4%97%E0%A4%A4+%E0%A4%AD%E0%A4%BF%E0%A4%A4%E0%A5%8D%E0%A4%A4%E0%A4%BF+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%94%E0%A4%B0+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%A6%E0%A5%83%E0%A4%B6%E0%A5%8D%E0%A4%AF+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AF%E0%A4%BE+%E0%A4%A4%E0%A5%8B+%E0%A4%AF%E0%A4%BE%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A4%BF%E0%A4%AF%E0%A5%8B%E0%A4%82+%E0%A4%94%E0%A4%B0+%E0%A4%AE%E0%A5%81%E0%A4%A6%E0%A5%8D%E0%A4%B0%E0%A4%BF%E0%A4%A4+%E0%A4%AE%E0%A4%BE%E0%A4%AE%E0%A4%B2%E0%A5%87+%E0%A4%B8%E0%A5%87+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%B5%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%AA%E0%A4%BE%E0%A4%B0+%E0%A4%B8%E0%A5%87%E0%A4%9F.+%E0%A4%96%E0%A5%81%E0%A4%A6+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A4%BE%E0%A4%AB%E0%A4%BF%E0%A4%95+%E0%A4%95%E0%A5%87+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%AA%E0%A4%B0+%E0%A4%86%E0%A4%A7%E0%A4%BE%E0%A4%B0%E0%A4%BF%E0%A4%A4+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Petra Jaudszus", "2010-11-24", "0000-00-00"),
("0", "34", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A59%3A%22Medizinisches+Versorgungszentrum+Fachbereich+RadioOnkologie%22%3Bs%3A3%3A%22Www%22%3Bs%3A30%3A%22www.strahlentherapie-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A310%3A%22%3Cp%3Eim+Medizinischen+Versorgungszentrum+Fachbereich+RadioOnkologie+am+Klinikum+Bremen-Mitte+werden+gut-+und+b%C3%B6sartige+Erkrankungen+behandelt.+Um+dem+Besucher+die+Angst+zu+nehmen+haben+wir+ein+helles+und+freundliches+Design+gew%C3%A4hlt.+Die+Inhalte+der+Webseite+erkl%C3%A4ren+was+den+Besucher%2FPatienten+erwartet.%3C%2Fp%3E%0D%0A%22%3B%7D", "", "1", "0", "Medizinisches Versorgungszentrum Fachbereich RadioOnkologie", "2010-11-25", "0000-00-00"),
("0", "34", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A40%3A%22Praxisgemeinschaft+f%C3%BCr+Strahlentherapie%22%3Bs%3A3%3A%22Www%22%3Bs%3A30%3A%22www.strahlentherapie-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A153%3A%22%3Cp%3EIn+the+Medical+Center%2C+Department+of+radio-oncology+Bremen+benign+and+malignant+diseases+are+treated.+We+have+chosen+a+bright+and+friendly+design.%3C%2Fp%3E%22%3B%7D", "", "1", "0", "Praxisgemeinschaft für Strahlentherapie", "2010-11-25", "0000-00-00"),
("0", "35", "0", "", "", "3", "0", "", "2010-11-25", "0000-00-00"),
("0", "35", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Businesstreffen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.businesstreffen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A291%3A%22%3Cp%3EDas+Businesstreffen+m%C3%B6chte+eine+Plattform+f%C3%BCr+Unternehmer%2C+Freiberufler+und+Existenz%C2%ADgr%C3%BCnder+schaffen%2C+die+neue+Gesch%C3%A4fts%C2%ADkontakte+oder+Kooperationspartner+finden+m%C3%B6chten%2C+eventuell+neue+Absatzm%C3%A4rkte+erschlie%C3%9Fen+und+bestehende+Business%C2%ADkontakte+pflegen+bzw.+kn%C3%BCpfen+wollen.%3C%2Fp%3E%22%3B%7D", "", "3", "0", "Businesstreffen", "2010-11-25", "0000-00-00"),
("0", "35", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Businesstreffen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.businesstreffen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A300%3A%22%3Cp%3EMit+dem+Businesstreffen+m%C3%B6chte+Dirk+Streb+eine+Plattform+f%C3%BCr+Unternehmer%2C+Freiberufler+und+Existenzgr%C3%BCnder+schaffen%2C+die+neue+Gesch%C3%A4ftskontakte+oder+Kooperationspartner+finden+m%C3%B6chten%2C+eventuell+neue+Absatzm%C3%A4rkte+erschlie%C3%9Fen+und+bestehende+Businesskontakte+pflegen+bzw.+kn%C3%BCpfen+wollen.%3C%2Fp%3E%22%3B%7D", "", "3", "0", "Businesstreffen", "2010-11-25", "0000-00-00"),
("0", "36", "0", "", "", "4", "1", "", "2010-11-20", "0000-00-00"),
("0", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Hand+zu+Hand+e.V.%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.handzuhand.net%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A496%3A%22%3Cp%3EDer+Verein+Hand+zu+Hand+wurde+2004+von+Jane+Haardt+und+Wilma+Pannen+mit+dem+Ziel+gegr%C3%BCndet%2C+eine+psychosoziale+Beratungsstelle+f%C3%BCr+Geh%C3%B6rlose+und+H%C3%B6rgesch%C3%A4digte+zu+er%C3%B6ffnen%2C+die+sich+gr%C3%B6%C3%9Ftenteils+%C3%BCber+Spenden+finanziert.+Mitte+2006+konnte+dieses+Vorhaben+in+die+Tat+umgesetzt+werden.+Mit+einem+lieben+Schreiben+haben+sich+die+beiden+Ende+2005+an+mich+gewendet+und+gebeten%2C+ihre+Homepage+zu+erstellen.+Das+konnte+ich+nicht+abschlagen+und+erkl%C3%A4rte+mich+bereit%2C+die+Seite+zu+stiften.%3C%2Fp%3E%22%3B%7D", "", "4", "1", "Hand zu Hand e.V.", "2010-11-20", "0000-00-00"),
("0", "36", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Hand+zu+Hand+e.V.%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.handzuhand.net%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A542%3A%22%3Cp%3EDer+Verein+Hand+zu+Hand+wurde+2004+von+Jane+Haardt+und+Wilma+Pannen+mit+dem+Ziel+gegr%C3%BCndet%2C+eine+psychosoziale+Beratungsstelle+f%C3%BCr+Geh%C3%B6rlose+und+H%C3%B6rgesch%C3%A4digte+zu+er%C3%B6ffnen%2C+die+sich+gr%C3%B6%C3%9Ftenteils+%C3%BCber+Spenden+finanziert.%0D%0A++++++++++++++Mitte+2006+konnte+dieses+Vorhaben+in+die+Tat+umgesetzt+werden.%0D%0A++++++++++++++%0D%0A++++++++++++++Mit+einem+lieben+Schreiben+haben+sich+die+beiden+Ende+2005+an+mich+gewendet+und+gebeten%2C+ihre+Homepage+zu+erstellen.+Das+konnte+ich+nicht+abschlagen+und+erkl%C3%A4rte+mich+bereit%2C+die+Seite+zu+stiften.%3C%2Fp%3E%22%3B%7D", "", "4", "1", "Hand zu Hand e.V.", "2010-11-20", "0000-00-00"),
("0", "38", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Sonnige+Geschichten%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.sonnige-geschichten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A125%3A%22%3Cp%3EChristel+Captijn-M%C3%BCller+hat+Feuilletons+des+niederl%C3%A4ndischen+Schriftstellers+Louis+Couperus+ins+Deutsche+%C3%BCbersetzt.%3C%2Fp%3E%22%3B%7D", "", "3", "0", "Sonnige Geschichten", "2010-11-25", "0000-00-00"),
("0", "38", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Sonnige+Geschichten%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.sonnige-geschichten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A125%3A%22%3Cp%3EChristel+Captijn-M%C3%BCller+hat+Feuilletons+des+niederl%C3%A4ndischen+Schriftstellers+Louis+Couperus+ins+Deutsche+%C3%BCbersetzt.%3C%2Fp%3E%22%3B%7D", "", "3", "0", "Sonnige Geschichten", "2010-11-25", "0000-00-00"),
("0", "39", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22marcus-haas.de%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A285%3A%22%3Cp%3EAuf+meinen+privaten+Seiten+bin+ich+verantwortlich+f%C3%BCr+interessante+Inhalte+und+die+Gestaltung+der+Webseiten.++++++Besucherzahlen+und+gute+Platzierungen+bei+Google+und+anderen+Suchmaschinen+geben+mir+in+der+Annahme+recht%2C+dass+man+keine+Linkfarmen+braucht%2C+um+bekannt+zu+werden.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "marcus-haas.de", "2010-11-26", "0000-00-00"),
("0", "39", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22marcus-haas.de%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A295%3A%22%3Cp%3EAuf+meinen+privaten+Seiten+bin+ich+verantwortlich+f%C3%BCr+interessante+Inhalte+und+die+Gestaltung+der+Webseiten.%0D%0A++++++%0D%0A++++++Besucherzahlen+und+gute+Platzierungen+bei+Google+und+anderen+Suchmaschinen+geben+mir+in+der+Annahme+recht%2C+dass+man+keine+Linkfarmen+braucht%2C+um+bekannt+zu+werden.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "marcus-haas.de", "2010-11-26", "0000-00-00"),
("0", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A32%3A%22Bitte+geben+Sie+einen+Namen+ein-%22%3B%7D", "", "1", "1", "Bitte geben Sie einen Namen ein-", "2012-01-29", "0000-00-00"),
("0", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A20%3A%22Please+enter+a+name.%22%3B%7D", "", "1", "1", "Please enter a name.", "2012-01-29", "0000-00-00"),
("0", "77", "0", "", "", "99", "1", "", "2010-12-21", "0000-00-00"),
("0", "77", "1", "a%3A35%3A%7Bs%3A10%3A%22Main_color%22%3Bs%3A7%3A%22%23ffff80%22%3Bs%3A12%3A%22Accent_color%22%3Bs%3A7%3A%22%2388eef7%22%3Bs%3A11%3A%22Light_color%22%3Bs%3A7%3A%22%23ffffff%22%3Bs%3A9%3A%22Mid_color%22%3Bs%3A7%3A%22%2376758a%22%3Bs%3A10%3A%22Dark_color%22%3Bs%3A7%3A%22%23000013%22%3Bs%3A10%3A%22Text_color%22%3Bs%3A7%3A%22%23e1e1e1%22%3Bs%3A9%3A%22Zuminhalt%22%3Bs%3A10%3A%22zum+Inhalt%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A9%3A%22zum+Men%C3%BC%22%3Bs%3A8%3A%22Headline%22%3Bs%3A14%3A%22Webdesign+Haas%22%3Bs%3A11%3A%22Slogan_text%22%3Bs%3A66%3A%22Individuelle+Beratung%0D%0Aund+Gestaltung+f%C3%BCr%0D%0AIhren+Internetauftritt%22%3Bs%3A11%3A%22Geoposition%22%3Bs%3A12%3A%2253.066%3B8.804%22%3Bs%3A9%3A%22Georegion%22%3Bs%3A2%3A%22DE%22%3Bs%3A12%3A%22Geoplacename%22%3Bs%3A6%3A%22Bremen%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A14%3A%22Webdesign+Haas%22%3Bs%3A11%3A%22Description%22%3Bs%3A16%3A%22Webdesign+Bremen%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A139%3A%22Webdesign+Bremen%2C+Webdesiger%2C+in+Bremen%2C+Bremen%2C+Webdesign%2C+Homepage%2C+Erstellung%2C+Gestaltung%2C+Entwicklung%2C+Webseiten%2C+CMS%2C+Redaktionssystem%22%3Bs%3A12%3A%22Neuesfenster%22%3Bs%3A24%3A%22in+neuem+Fenster+%C3%B6ffnen%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A3%3A%22Www%22%3Bs%3A3%3A%22WWW%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A4%3A%22Oben%22%3Bs%3A36%3A%22Nach+Oben%3A+-+zum+Anfang+dieser+Seite%22%3Bs%3A10%3A%22Rss_select%22%3Bs%3A3%3A%22109%22%3Bs%3A17%3A%22Googleverfication%22%3Bs%3A43%3A%22G2okCITUSIlEB1jmdpriY5Tbj8p-sBKl_JIHjefXwUg%22%3Bs%3A11%3A%22Suchbegriff%22%3Bs%3A15%3A%22Was+suchen+Sie%3F%22%3Bs%3A6%3A%22Suchen%22%3Bs%3A10%3A%22Finde+was%21%22%3Bs%3A8%3A%22Nachoben%22%3Bs%3A1%3A%22%5E%22%3Bs%3A7%3A%22Voriges%22%3Bs%3A1%3A%22%3C%22%3Bs%3A9%3A%22Folgendes%22%3Bs%3A1%3A%22%3E%22%3Bs%3A10%3A%22Ersteseite%22%3Bs%3A2%3A%22%3C%3C%22%3Bs%3A11%3A%22Letzteseite%22%3Bs%3A2%3A%22%3E%3E%22%3Bs%3A3%3A%22Und%22%3Bs%3A3%3A%22und%22%3Bs%3A4%3A%22Oder%22%3Bs%3A4%3A%22oder%22%3Bs%3A7%3A%22Pflicht%22%3Bs%3A1%3A%22%2A%22%3Bs%3A11%3A%22Footer_text%22%3Bs%3A211%3A%22Webdesign+in+Bremen+von+Marcus+Haas.+Erstellung+Ihrer+Website+oder+Homepage.+Kompetente+Beratung+professionelle+Gestaltung.+Unsere+Spezialit%C3%A4t+ist+die+Homepage+Erstellung%2C+Beratung+und+Suchmaschinenoptimierung.%22%3B%7D", "", "99", "1", "#ffff80", "2010-12-21", "0000-00-00"),
("0", "77", "2", "a%3A28%3A%7Bs%3A9%3A%22Zuminhalt%22%3Bs%3A32%3A%22%D8%A7%D9%86%D8%AA%D9%82%D9%84+%D8%A5%D9%84%D9%89+%D8%A7%D9%84%D9%85%D8%AD%D8%AA%D9%88%D9%89%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A21%3A%22%D8%A7%D9%84%D9%89+%D8%A7%D9%84%D9%85%D9%84%D8%A7%D8%AD%D8%A9%22%3Bs%3A8%3A%22Headline%22%3Bs%3A22%3A%22Webdesign+Haas%2C+Bremen%22%3Bs%3A11%3A%22Slogan_text%22%3Bs%3A89%3A%22%D8%A7%D9%84%D9%81%D8%B1%D8%AF+%D8%A7%D9%84%D8%AA%D8%B4%D8%A7%D9%88%D8%B1%0D%0A%D9%88%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%84%D9%84%D9%85%D9%88%D9%82%D8%B9%0D%0A%D9%85%D9%88%D9%82%D8%B9+%D8%A7%D9%84%D9%88%D9%8A%D8%A8+%D8%A7%D9%84%D8%AE%D8%A7%D8%B5+%D8%A8%D9%83%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A3%3A%22Web%22%3Bs%3A3%3A%22Web%22%3Bs%3A5%3A%22Email%22%3Bs%3A6%3A%22E-Mail%22%3Bs%3A11%3A%22Geoposition%22%3Bs%3A12%3A%2253.066%3B8.804%22%3Bs%3A9%3A%22Georegion%22%3Bs%3A2%3A%22DE%22%3Bs%3A12%3A%22Geoplacename%22%3Bs%3A6%3A%22Bremen%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A51%3A%22Marcus+Haas%2C+%D8%A7%D9%84%D9%81%D8%AA%D8%AD+%D8%A7%D9%84%D8%A5%D8%B3%D9%84%D8%A7%D9%85%D9%8A+%D8%A8%D8%B1%D9%8A%D9%85%D9%86%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A38%3A%22%D8%A7%D9%84%D9%81%D8%AA%D8%AD+%D8%A7%D9%84%D8%A5%D8%B3%D9%84%D8%A7%D9%85%D9%8A+%D8%A8%D8%B1%D9%8A%D9%85%D9%86%22%3Bs%3A4%3A%22Oben%22%3Bs%3A35%3A%22%D8%A5%D9%84%D9%89+%D8%A3%D8%B9%D9%84%D9%89+%D9%87%D8%B0%D9%87+%D8%A7%D9%84%D8%B5%D9%81%D8%AD%D8%A9%22%3Bs%3A10%3A%22Rss_select%22%3Bs%3A3%3A%22109%22%3Bs%3A12%3A%22Kartenbreite%22%3Bs%3A3%3A%22450%22%3Bs%3A11%3A%22Kartenhoehe%22%3Bs%3A3%3A%22200%22%3Bs%3A11%3A%22Grossekarte%22%3Bs%3A12%3A%22Gro%C3%9Fe+Karte%22%3Bs%3A11%3A%22Suchbegriff%22%3Bs%3A31%3A%22%D9%85%D8%A7+%D8%A7%D9%84%D8%B0%D9%8A+%D8%AA%D8%A8%D8%AD%D8%AB+%D8%B9%D9%86%D9%87%D8%9F%22%3Bs%3A6%3A%22Suchen%22%3Bs%3A25%3A%22%D8%A7%D9%84%D8%B9%D8%AB%D9%88%D8%B1+%D8%B9%D9%84%D9%89+%D9%85%D8%A7%21%22%3Bs%3A8%3A%22Nachoben%22%3Bs%3A1%3A%22%5E%22%3Bs%3A7%3A%22Voriges%22%3Bs%3A1%3A%22%3C%22%3Bs%3A9%3A%22Folgendes%22%3Bs%3A1%3A%22%3E%22%3Bs%3A10%3A%22Ersteseite%22%3Bs%3A2%3A%22%3C%3C%22%3Bs%3A11%3A%22Letzteseite%22%3Bs%3A2%3A%22%3E%3E%22%3Bs%3A3%3A%22Und%22%3Bs%3A5%3A%22+und+%22%3Bs%3A4%3A%22Oder%22%3Bs%3A6%3A%22+oder+%22%3Bs%3A7%3A%22Pflicht%22%3Bs%3A2%3A%22+%2A%22%3B%7D", "", "99", "1", "انتقل إلى المحتوى", "2010-12-21", "0000-00-00");

-- # Schnipp --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "77", "3", "a%3A24%3A%7Bs%3A9%3A%22Zuminhalt%22%3Bs%3A13%3A%22go+to+content%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A10%3A%22go+to+menu%22%3Bs%3A8%3A%22Headline%22%3Bs%3A22%3A%22Webdesign+Haas%2C+Bremen%22%3Bs%3A11%3A%22Slogan_text%22%3Bs%3A58%3A%22Personalized+consulting%0D%0Aand+web+design+for%0D%0Ayour+homepage%22%3Bs%3A3%3A%22Tel%22%3Bs%3A4%3A%22Tel.%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A6%3A%22Mobile%22%3Bs%3A11%3A%22Geoposition%22%3Bs%3A12%3A%2253.066%3B8.804%22%3Bs%3A9%3A%22Georegion%22%3Bs%3A2%3A%22DE%22%3Bs%3A12%3A%22Geoplacename%22%3Bs%3A6%3A%22Bremen%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A29%3A%22Webdesign+Bremen%3A+Marcus+Haas%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A114%3A%22web+design+bremen%2C+web+designer+bremen%2C+webdesign+in+Bremen%2C+Bremen%2C+web%2C+design%2C+designer%2C+graphics%2C+website%2C+cms%22%3Bs%3A4%3A%22Oben%22%3Bs%3A17%3A%22go+to+top+of+page%22%3Bs%3A10%3A%22Rss_select%22%3Bs%3A3%3A%22109%22%3Bs%3A17%3A%22Googleverfication%22%3Bs%3A43%3A%228GSyaBB5UUqKi37rd65iH5oe-zPvBMkq75LwwG8iPSc%22%3Bs%3A11%3A%22Suchbegriff%22%3Bs%3A24%3A%22What+are+you+looking+for%22%3Bs%3A6%3A%22Suchen%22%3Bs%3A7%3A%22Find+it%22%3Bs%3A8%3A%22Nachoben%22%3Bs%3A1%3A%22%5E%22%3Bs%3A7%3A%22Voriges%22%3Bs%3A1%3A%22%3C%22%3Bs%3A9%3A%22Folgendes%22%3Bs%3A1%3A%22%3E%22%3Bs%3A10%3A%22Ersteseite%22%3Bs%3A2%3A%22%3C%3C%22%3Bs%3A11%3A%22Letzteseite%22%3Bs%3A2%3A%22%3E%3E%22%3Bs%3A3%3A%22Und%22%3Bs%3A3%3A%22and%22%3Bs%3A4%3A%22Oder%22%3Bs%3A2%3A%22or%22%3Bs%3A7%3A%22Pflicht%22%3Bs%3A1%3A%22%2A%22%3B%7D", "", "99", "1", "go to content", "2010-12-21", "0000-00-00"),
("0", "77", "4", "a%3A28%3A%7Bs%3A9%3A%22Zuminhalt%22%3Bs%3A41%3A%22%E0%A4%B8%E0%A4%BE%E0%A4%AE%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%80+%E0%A4%95%E0%A5%8B+%E0%A4%9B%E0%A5%8B%E0%A4%A1%E0%A4%BC%22%3Bs%3A8%3A%22Zummenue%22%3Bs%3A29%3A%22%E0%A4%AE%E0%A5%87%E0%A4%A8%E0%A5%82+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F%22%3Bs%3A8%3A%22Headline%22%3Bs%3A22%3A%22Webdesign+Haas%2C+Bremen%22%3Bs%3A11%3A%22Slogan_text%22%3Bs%3A129%3A%22%E0%A4%B5%E0%A5%8D%E0%A4%AF%E0%A4%95%E0%A5%8D%E0%A4%A4%E0%A4%BF%E0%A4%97%E0%A4%A4+%E0%A4%AA%E0%A4%B0%E0%A4%BE%E0%A4%AE%E0%A4%B0%E0%A5%8D%E0%A4%B6%0D%0A%E0%A4%94%E0%A4%B0+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8%0D%0A%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F%22%3Bs%3A3%3A%22Tel%22%3Bs%3A12%3A%22%E0%A4%AB%E0%A4%BC%E0%A5%8B%E0%A4%A8%22%3Bs%3A5%3A%22Mobil%22%3Bs%3A18%3A%22%E0%A4%AE%E0%A5%8B%E0%A4%AC%E0%A4%BE%E0%A4%87%E0%A4%B2%22%3Bs%3A11%3A%22Geoposition%22%3Bs%3A12%3A%2253.066%3B8.804%22%3Bs%3A9%3A%22Georegion%22%3Bs%3A2%3A%22DE%22%3Bs%3A12%3A%22Geoplacename%22%3Bs%3A6%3A%22Bremen%22%3Bs%3A11%3A%22Titelprefix%22%3Bs%3A29%3A%22Webdesign+Bremen%2C+Marcus+Haas%22%3Bs%3A8%3A%22Keywords%22%3Bs%3A343%3A%22%E0%A4%B5%E0%A5%87%E0%A4%AC+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BC%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%80%E0%A4%AE%E0%A5%87%E0%A4%A8%2C+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%80%E0%A4%AE%E0%A5%87%E0%A4%A8%2C+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%80%E0%A4%AE%E0%A5%87%E0%A4%A8%2C+%E0%A4%B5%E0%A5%87%E0%A4%AC+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8%2C+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F%2C+%E0%A4%A8%E0%A4%BF%E0%A4%B0%E0%A5%8D%E0%A4%AE%E0%A4%BE%E0%A4%A3%2C+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8%2C+%E0%A4%B5%E0%A4%BF%E0%A4%95%E0%A4%BE%E0%A4%B8%2C+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F%2C+%E0%A4%B8%E0%A5%80%E0%A4%8F%E0%A4%AE%E0%A4%8F%E0%A4%B8%2C+%E0%A4%B8%E0%A4%BE%E0%A4%AE%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%80+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%AC%E0%A4%82%E0%A4%A7%E0%A4%A8+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A3%E0%A4%BE%E0%A4%B2%E0%A5%80+%E0%A4%AE%E0%A5%87%E0%A4%82+Webdesiger%22%3Bs%3A12%3A%22Neuesfenster%22%3Bs%3A48%3A%22%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A4%BF%E0%A4%82%E0%A4%A1%E0%A5%8B+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%96%E0%A5%8B%E0%A4%B2%E0%A5%87%E0%A4%82%22%3Bs%3A4%3A%22Oben%22%3Bs%3A45%3A%22%E0%A4%8A%E0%A4%AA%E0%A4%B0%3A+-+%E0%A4%AA%E0%A5%83%E0%A4%B7%E0%A5%8D%E0%A4%A0+%E0%A4%95%E0%A5%87+%E0%A4%8A%E0%A4%AA%E0%A4%B0%22%3Bs%3A10%3A%22Rss_select%22%3Bs%3A3%3A%22109%22%3Bs%3A12%3A%22Kartenbreite%22%3Bs%3A3%3A%22450%22%3Bs%3A11%3A%22Kartenhoehe%22%3Bs%3A3%3A%22200%22%3Bs%3A11%3A%22Grossekarte%22%3Bs%3A37%3A%22%E0%A4%AC%E0%A4%A1%E0%A4%BC%E0%A5%87+%E0%A4%AE%E0%A4%BE%E0%A4%A8%E0%A4%9A%E0%A4%BF%E0%A4%A4%E0%A5%8D%E0%A4%B0%22%3Bs%3A11%3A%22Suchbegriff%22%3Bs%3A67%3A%22%E0%A4%86%E0%A4%AA+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%95%E0%A5%8D%E0%A4%AF%E0%A4%BE+%E0%A4%A6%E0%A5%87%E0%A4%96+%E0%A4%B0%E0%A4%B9%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82%3F%22%3Bs%3A6%3A%22Suchen%22%3Bs%3A7%3A%22%E0%A4%B9%E0%A5%8B%21%22%3Bs%3A8%3A%22Nachoben%22%3Bs%3A1%3A%22%5E%22%3Bs%3A7%3A%22Voriges%22%3Bs%3A1%3A%22%3C%22%3Bs%3A9%3A%22Folgendes%22%3Bs%3A1%3A%22%3E%22%3Bs%3A10%3A%22Ersteseite%22%3Bs%3A2%3A%22%3C%3C%22%3Bs%3A11%3A%22Letzteseite%22%3Bs%3A2%3A%22%3E%3E%22%3Bs%3A3%3A%22Und%22%3Bs%3A8%3A%22+%E0%A4%94%E0%A4%B0+%22%3Bs%3A4%3A%22Oder%22%3Bs%3A8%3A%22+%E0%A4%AF%E0%A4%BE+%22%3Bs%3A7%3A%22Pflicht%22%3Bs%3A2%3A%22+%2A%22%3Bs%3A11%3A%22Footer_text%22%3Bs%3A400%3A%22Marcus+Haas+%E0%A4%A8%E0%A5%87+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%AE%E0%A5%87%E0%A4%A8+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%B5%E0%A5%87%E0%A4%AC+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8.+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%AF%E0%A4%BE+%E0%A4%B9%E0%A5%8B%E0%A4%AE%E0%A4%AA%E0%A5%87%E0%A4%9C+%E0%A4%AC%E0%A4%A8%E0%A4%BE%E0%A4%A8%E0%A5%87.+%E0%A4%B8%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%AE+%E0%A4%AA%E0%A4%B0%E0%A4%BE%E0%A4%AE%E0%A4%B0%E0%A5%8D%E0%A4%B6+%E0%A4%AA%E0%A5%87%E0%A4%B6%E0%A5%87%E0%A4%B5%E0%A4%B0+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8.+%E0%A4%B9%E0%A4%AE%E0%A4%BE%E0%A4%B0%E0%A5%80+%E0%A4%B5%E0%A4%BF%E0%A4%B6%E0%A5%87%E0%A4%B7%E0%A4%A4%E0%A4%BE+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%A8%E0%A4%BF%E0%A4%B0%E0%A5%8D%E0%A4%AE%E0%A4%BE%E0%A4%A3%2C+%E0%A4%AA%E0%A4%B0%E0%A4%BE%E0%A4%AE%E0%A4%B0%E0%A5%8D%E0%A4%B6+%E0%A4%94%E0%A4%B0+%E0%A4%96%E0%A5%8B%E0%A4%9C+%E0%A4%87%E0%A4%82%E0%A4%9C%E0%A4%A8+%E0%A4%85%E0%A4%A8%E0%A5%81%E0%A4%95%E0%A5%82%E0%A4%B2%E0%A4%A8+%E0%A4%B9%E0%A5%88.%22%3B%7D", "", "99", "1", "सामग्री को छोड़", "2010-12-21", "0000-00-00"),
("0", "78", "1", "a%3A3%3A%7Bs%3A12%3A%22Benutzername%22%3Bs%3A8%3A%22Benutzer%22%3Bs%3A8%3A%22Passwort%22%3Bs%3A8%3A%22Passwort%22%3Bs%3A9%3A%22Einloggen%22%3Bs%3A9%3A%22Einloggen%22%3B%7D", "BENUTZERNAME", "99", "1", "Benutzer", "2012-05-17", "0000-00-00"),
("0", "78", "3", "a%3A3%3A%7Bs%3A12%3A%22Benutzername%22%3Bs%3A4%3A%22User%22%3Bs%3A8%3A%22Passwort%22%3Bs%3A8%3A%22Password%22%3Bs%3A9%3A%22Einloggen%22%3Bs%3A6%3A%22Log+in%22%3B%7D", "BENUTZERNAME", "99", "1", "User", "2012-05-17", "0000-00-00"),
("1", "1", "0", "", "", "99", "1", "", "2012-02-20", "0000-00-00"),
("1", "1", "1", "a%3A3%3A%7Bs%3A17%3A%22Referenzen_select%22%3Bs%3A2%3A%2231%22%3Bs%3A13%3A%22Anzahl_number%22%3Bs%3A1%3A%228%22%3Bs%3A9%3A%22Extra_fck%22%3Bs%3A477%3A%22%3Cp%3EHompageerstellung+und+-entwicklung+aus+Bremen%3A+Wir+erstellen+Ihre+neue+Website+entweder+nach+vorhandener+Gestaltung+oder+in+Zusammenarbeit+mit+einer+Grafikerin+nach+Ihren+Vorstellungen.+Homepageerstellung+mit+Redaktionssystem+%28%3Ca+href%3D%22%23LINKTO%3A107%23%22+title%3D%22Das+Redaktionssystem+M-CMS+-+Verwalten+Sie+die+Inhalte+Ihre+Website+doch+einfach+selbst+selbst%22%3ECMS%3C%2Fa%3E%29%2C+damit+Sie+Inhalte+Ihrer+Internetseite+bequem+selbst+%C3%A4ndern+k%C3%B6nnen%3A+Marcus+Haas+Ihr+Webdesigner+in+Bremen.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "31", "2012-02-20", "0000-00-00"),
("1", "1", "2", "a%3A3%3A%7Bs%3A17%3A%22Referenzen_select%22%3Bs%3A2%3A%2231%22%3Bs%3A13%3A%22Anzahl_number%22%3Bs%3A1%3A%225%22%3Bs%3A9%3A%22Extra_fck%22%3Bs%3A326%3A%22%3Cp%3E%D8%B1%D8%B3%D8%A7%D9%84%D8%A9+%D8%AE%D8%A7%D8%B5%D8%A9+%D8%A5%D9%84%D9%89+%D8%AE%D9%84%D9%82+%D8%A8%D8%B1%D9%8A%D9%85%D9%86%3A+%D9%86%D8%AD%D9%86+%D9%86%D8%A8%D9%86%D9%8A+%D9%85%D9%86%D8%B2%D9%84%D9%83+%D8%A7%D9%84%D8%AC%D8%AF%D9%8A%D8%AF+%D8%B3%D9%88%D8%A7%D8%A1+%D8%B9%D9%84%D9%89+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D9%82%D8%A7%D8%A6%D9%85%D8%A9%D8%8C+%D8%A3%D9%88+%D8%A8%D8%A7%D9%84%D8%AA%D8%B9%D8%A7%D9%88%D9%86+%D9%85%D8%B9+%D9%81%D9%86%D8%A7%D9%86+%D8%A7%D9%84%D8%B1%D8%B3%D9%85+%D8%AA%D8%B1%D8%B6%D9%8A%D9%83.+%D8%A5%D9%86%D8%B4%D8%A7%D8%A1+%D9%85%D9%88%D9%82%D8%B9+%D9%85%D8%B9+%D9%86%D8%B8%D8%A7%D9%85+%D8%A5%D8%AF%D8%A7%D8%B1%D8%A9+%D8%A7%D9%84%D9%85%D8%AD%D8%AA%D9%88%D9%89+%28CMS%29+%D9%84%D8%B0%D9%84%D9%83+%D9%8A%D9%85%D9%83%D9%86%D9%83+%D8%A8%D8%B3%D9%87%D9%88%D9%84%D8%A9+%D8%AA%D8%BA%D9%8A%D9%8A%D8%B1+%D9%85%D8%AD%D8%AA%D9%88%D9%89+%D9%86%D9%81%D8%B3%D9%83.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "31", "2012-02-20", "0000-00-00"),
("1", "1", "3", "a%3A3%3A%7Bs%3A17%3A%22Referenzen_select%22%3Bs%3A2%3A%2231%22%3Bs%3A13%3A%22Anzahl_number%22%3Bs%3A1%3A%225%22%3Bs%3A9%3A%22Extra_fck%22%3Bs%3A319%3A%22%3Cp%3EHomepage+design+and+development%3A+We+build+your+new+homepage+based+on+an+existing+design+or+in+collaboration+with+a+graphic+designer.+We+build+your+web+site+with+the+content+management+system+%3Ca+href%3D%5C%22%23LINKTO%3A107%23%5C%22%3EM-CMS%3C%2Fa%3E.+That+way+you+can+easily+change+text+and+images+yourself+or+add+new+pages+and+content.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "31", "2012-02-20", "0000-00-00"),
("1", "1", "4", "a%3A3%3A%7Bs%3A17%3A%22Referenzen_select%22%3Bs%3A2%3A%2231%22%3Bs%3A13%3A%22Anzahl_number%22%3Bs%3A1%3A%225%22%3Bs%3A9%3A%22Extra_fck%22%3Bs%3A742%3A%22%3Cp%3E%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%AE%E0%A5%87%E0%A4%A8+%E0%A4%95%E0%A5%87+%E0%A4%B9%E0%A5%8B%E0%A4%AE%E0%A4%AA%E0%A5%87%E0%A4%9C+%E0%A4%A8%E0%A4%BF%E0%A4%B0%E0%A5%8D%E0%A4%AE%E0%A4%BE%E0%A4%A3+%E0%A4%94%E0%A4%B0+%E0%A4%B5%E0%A4%BF%E0%A4%95%E0%A4%BE%E0%A4%B8%3A+%E0%A4%B9%E0%A4%AE+%E0%A4%AE%E0%A5%8C%E0%A4%9C%E0%A5%82%E0%A4%A6%E0%A4%BE+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%AA%E0%A4%B0+%E0%A4%AF%E0%A4%BE+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%AA%E0%A4%B8%E0%A4%82%E0%A4%A6+%E0%A4%95%E0%A5%87+%E0%A4%B9%E0%A4%BF%E0%A4%B8%E0%A4%BE%E0%A4%AC+%E0%A4%B8%E0%A5%87+%E0%A4%8F%E0%A4%95+%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A4%BE%E0%A4%AB%E0%A4%BF%E0%A4%95+%E0%A4%95%E0%A4%B2%E0%A4%BE%E0%A4%95%E0%A4%BE%E0%A4%B0+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%B9%E0%A4%AF%E0%A5%8B%E0%A4%97+%E0%A4%B8%E0%A5%87+%E0%A4%AF%E0%A4%BE+%E0%A4%A4%E0%A5%8B+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%AC%E0%A4%A8%E0%A4%BE%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F.+%E0%A4%86%E0%A4%AA+%E0%A4%86%E0%A4%B8%E0%A4%BE%E0%A4%A8%E0%A5%80+%E0%A4%B8%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%AE%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%80+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%86%E0%A4%AA+%E0%A4%AC%E0%A4%A6%E0%A4%B2+%E0%A4%B8%E0%A4%95%E0%A4%A4%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82+%E0%A4%95%E0%A4%BF+%E0%A4%87%E0%A4%A4%E0%A4%A8%E0%A5%80+%E0%A4%B8%E0%A4%BE%E0%A4%AE%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%80+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%AC%E0%A4%82%E0%A4%A7%E0%A4%A8+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A3%E0%A4%BE%E0%A4%B2%E0%A5%80+%28%E0%A4%B8%E0%A5%80%E0%A4%8F%E0%A4%AE%E0%A4%8F%E0%A4%B8%29+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5+%E0%A4%8F%E0%A4%95+%E0%A4%B9%E0%A5%8B%E0%A4%AE%E0%A4%AA%E0%A5%87%E0%A4%9C+%E0%A4%AC%E0%A4%A8%E0%A4%BE%E0%A4%A8%E0%A4%BE.+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%AE%E0%A5%87%E0%A4%A8+%E0%A4%AE%E0%A5%87%E0%A4%82+%C2%A7NAME%C2%A7+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%B5%E0%A5%87%E0%A4%AC+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8%E0%A4%B0.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "31", "2012-02-20", "0000-00-00"),
("1", "1", "5", "a%3A3%3A%7Bs%3A17%3A%22Referenzen_select%22%3Bs%3A2%3A%2231%22%3Bs%3A13%3A%22Anzahl_number%22%3Bs%3A1%3A%225%22%3Bs%3A9%3A%22Extra_fck%22%3Bs%3A306%3A%22%3Cp%3E%E7%BD%91%E9%A1%B5%E7%9A%84%E5%88%9B%E5%BB%BA%E5%92%8C%E5%8F%91%E5%B1%95%EF%BC%8C%E4%B8%8D%E6%9D%A5%E6%A2%85%EF%BC%9A%E6%88%91%E4%BB%AC%E6%97%A0%E8%AE%BA%E6%98%AF%E5%9C%A8%E7%8E%B0%E6%9C%89%E7%9A%84%E8%AE%BE%E8%AE%A1%E6%88%96%E4%B8%80%E4%B8%AA%E5%9B%BE%E5%BD%A2%E8%89%BA%E6%9C%AF%E5%AE%B6%E5%90%88%E4%BD%9C%EF%BC%8C%E6%A0%B9%E6%8D%AE%E8%87%AA%E5%B7%B1%E7%9A%84%E5%96%9C%E5%A5%BD%E5%88%9B%E5%BB%BA%E6%96%B0%E7%9A%84%E7%BD%91%E7%AB%99%E3%80%82%E5%88%9B%E5%BB%BA%E4%B8%80%E4%B8%AA%E7%BD%91%E9%A1%B5%E7%9A%84%E5%86%85%E5%AE%B9%E7%AE%A1%E7%90%86%E7%B3%BB%E7%BB%9F%EF%BC%88CMS%EF%BC%89%EF%BC%8C%E8%BF%99%E6%A0%B7%E5%B0%B1%E5%8F%AF%E4%BB%A5%E5%BE%88%E5%AE%B9%E6%98%93%E5%9C%B0%E6%94%B9%E5%8F%98%E5%86%85%E5%AE%B9%E6%9C%AC%E8%BA%AB%E3%80%82%E9%A9%AC%E5%BA%93%E6%96%AF%C2%B7%E5%93%88%E6%96%AF%E5%9C%A8%E4%B8%8D%E6%9D%A5%E6%A2%85%E6%82%A8%E7%9A%84%E7%BD%91%E9%A1%B5%E8%AE%BE%E8%AE%A1%E5%B8%88%E3%80%82%3C%2Fp%3E%22%3B%7D", "", "99", "1", "31", "2012-02-20", "0000-00-00"),
("1", "32", "0", "", "", "99", "1", "", "2012-09-21", "0000-00-00"),
("1", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Der+MusikMacher%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.musikmacher-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A258%3A%22%3Cp%3EDJ+Holger+macht+Musik+bei+Hochzeiten%2C+Geburtstagen+oder+Weihnachtsfeiern+in+Bremen+oder+Umgebung.+Nicht+nur+Rock+%26amp%3B+Pop%2C+Schlager+%26amp%3B+Discofox%2C+Oldies+%26amp%3B+Top+40%2C+sondern+auch+Ska+%26amp%3B+Rockabilly%2C+Alternative+%26amp%3B+Crossover%2C+Soul+%26amp%3B+Swing.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Der MusikMacher", "2012-09-21", "0000-00-00"),
("1", "32", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A23%3A%22%D8%B5%D9%86%D8%A7%D8%B9+%D8%A7%D9%84%D9%85%D9%88%D8%B3%D9%8A%D9%82%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.musikmacher-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A376%3A%22%3Cp%3E%D9%87%D9%88%D9%84%D8%AC%D8%B1+DJ+%D8%AA%D9%84%D8%B9%D8%A8+%D8%A7%D9%84%D9%85%D9%88%D8%B3%D9%8A%D9%82%D9%89+%D9%81%D9%8A+%D8%AD%D9%81%D9%84%D8%A7%D8%AA+%D8%A7%D9%84%D8%B2%D9%81%D8%A7%D9%81+%D9%88%D8%A3%D8%B9%D9%8A%D8%A7%D8%AF+%D8%A7%D9%84%D9%85%D9%8A%D9%84%D8%A7%D8%AF+%D8%A3%D9%88+%D8%B9%D9%8A%D8%AF+%D8%A7%D9%84%D9%85%D9%8A%D9%84%D8%A7%D8%AF+%D9%81%D9%8A+%D8%A8%D8%B1%D9%8A%D9%85%D9%86+%D8%A3%D9%88+%D8%A7%D9%84%D8%A8%D9%8A%D8%A6%D8%A9.+%D9%84%D8%A7+%D8%B1%D9%88%D9%83+%D9%88%D8%A8%D9%88%D8%A8+%D9%81%D9%82%D8%B7%D8%8C+%D9%88%D8%A7%D9%84%D8%A8%D9%88%D8%A8+%E2%80%8B%E2%80%8B%D9%81%D9%88%D9%83%D8%B3+%D8%AF%D9%8A%D8%B3%D9%83%D9%88%D8%8C+%D9%88%D8%A3%D9%81%D8%B6%D9%84+40+%D8%A3%D8%BA%D8%A7%D9%86%D9%8A+%D9%82%D8%AF%D9%8A%D9%85%D8%A9%D8%8C+%D9%88%D9%84%D9%83%D9%86+%D8%A3%D9%8A%D8%B6%D8%A7+%D9%88%D8%B3%D9%83%D8%A7+%D8%B1%D9%88%D9%83%D8%A7%D8%A8%D9%8A%D9%84%D9%8A+%D8%A8%D8%AF%D9%8A%D9%84%D8%A9%D8%8C+%D9%88%D8%A7%D9%84%D8%A7%D9%86%D8%AA%D9%82%D8%A7%D9%84%D8%8C+%D9%88%D8%A7%D9%84%D8%B1%D9%88%D8%AD+%D8%B3%D9%88%D9%8A%D9%86%D8%BA%3C%2Fp%3E%22%3B%7D", "", "99", "1", "صناع الموسيق", "2012-09-21", "0000-00-00"),
("1", "32", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Der+MusikMacher%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.musikmacher-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A228%3A%22%3Cp%3EHolger+DJ+plays+music+at+weddings%2C+birthdays+or+Christmas+in+Bremen+and+around.+Not+only+Rock+%26amp%3B+Pop%2C+Pop+%26amp%3B+Disco+Fox%2C+Oldies+%26amp%3B+Top+40%2C+but+also+ska+and+rockabilly%2C+alternative+%26amp%3B+crossover%2C+Soul+%26amp%3B+Swing%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Der MusikMacher", "2012-09-21", "0000-00-00"),
("1", "33", "0", "", "", "96", "1", "", "2010-11-22", "0000-00-00"),
("1", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Werderfotos%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.werderfotos.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A252%3A%22%3Cp%3EThomas+Birkhahn+pr%C3%A4sentiert+auf+seiner+neuen+Internetseite+eine+Reihe+ausgew%C3%A4hlter+Fotos%2C+die+er+bei+verschiedenen+Anl%C3%A4ssen+oder+beim+Training+schie%C3%9Fen+konnte.+Das+Redaktionssystem+erlaubt+es%2C+flexibel+neue+Galerien+und+Seiten+hinzuzuf%C3%BCgen.%3C%2Fp%3E%22%3B%7D", "", "96", "1", "Werderfotos", "2010-11-22", "0000-00-00"),
("1", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Werderfotos%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.werderfotos.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A345%3A%22%3Cp%3E%D9%88%D9%83%D8%A7%D9%86+Thomas+Birkhahn+%D8%B9%D9%84%D9%89+%D9%85%D9%88%D9%82%D8%B9%D9%87+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D8%A7%D9%86%D8%AA%D8%B1%D9%86%D8%AA+%D9%8A%D8%B9%D8%B1%D8%B6+%D8%B5%D9%88%D8%B1%D8%A7+%D9%85%D8%AE%D8%AA%D8%A7%D8%B1%D8%A9+%D8%A3%D8%B7%D9%84%D9%82+%D8%A7%D9%84%D9%86%D8%A7%D8%B1+%D9%81%D9%8A+%D9%85%D9%86%D8%A7%D8%B3%D8%A8%D8%A7%D8%AA+%D9%85%D8%AE%D8%AA%D9%84%D9%81%D8%A9%D8%8C+%D8%A3%D9%88+%D9%81%D9%8A+%D8%AD%D8%A7%D9%86%D8%A9.+%D9%88%D9%8A%D8%B3%D8%AA%D9%86%D8%AF+%D8%A7%D9%84%D9%85%D9%88%D9%82%D8%B9+%D8%B9%D9%84%D9%89+%D9%86%D8%B8%D8%A7%D9%85+%D8%A5%D8%AF%D8%A7%D8%B1%D8%A9+%D8%A7%D9%84%D9%85%D8%AD%D8%AA%D9%88%D9%89+%D8%A7%D9%84%D8%AA%D9%8A+%D9%88%D8%B6%D8%B9%D9%87%D8%A7+%D9%84%D9%8A+%D9%88%D9%8A%D8%B3%D9%85%D8%AD+%D9%84%D9%83+%D9%84%D8%A5%D8%B6%D8%A7%D9%81%D8%A9+%D8%B5%D8%A7%D9%84%D8%A7%D8%AA+%D8%AC%D8%AF%D9%8A%D8%AF%D8%A9+%D9%85%D8%B1%D9%86%D8%A9+%D9%88%D8%B5%D9%81%D8%AD%D8%A7%D8%AA%3C%2Fp%3E%22%3B%7D", "", "96", "1", "Werderfotos", "2010-11-22", "0000-00-00"),
("1", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Werderfotos%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.werderfotos.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A142%3A%22%3Cp%3EThomas+Birkhahn+presents+a+number+of+selected+photos+of+Werder+Bremen%2C+he+could+shoot+on+various+occasions+or+during+training+sessions.%3C%2Fp%3E%22%3B%7D", "", "96", "1", "Werderfotos", "2010-11-22", "0000-00-00"),
("1", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Werderfotos%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.werderfotos.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A572%3A%22%3Cp%3EThomas+Birkhahn+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%B5%E0%A4%B9+%E0%A4%B5%E0%A4%BF%E0%A4%AD%E0%A4%BF%E0%A4%A8%E0%A5%8D%E0%A4%A8+%E0%A4%85%E0%A4%B5%E0%A4%B8%E0%A4%B0%E0%A5%8B%E0%A4%82+%E0%A4%AA%E0%A4%B0+%E0%A4%AF%E0%A4%BE+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B6%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%A3+%E0%A4%95%E0%A5%87+%E0%A4%A6%E0%A5%8C%E0%A4%B0%E0%A4%BE%E0%A4%A8+%E0%A4%97%E0%A5%8B%E0%A4%B2%E0%A5%80+%E0%A4%AE%E0%A4%BE%E0%A4%B0+%E0%A4%B8%E0%A4%95%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88+%E0%A4%95%E0%A4%BF+%E0%A4%9A%E0%A4%AF%E0%A4%A8%E0%A4%BF%E0%A4%A4+%E0%A4%A4%E0%A4%B8%E0%A5%8D%E0%A4%B5%E0%A5%80%E0%A4%B0%E0%A5%8B%E0%A4%82+%E0%A4%95%E0%A5%80+%E0%A4%8F%E0%A4%95+%E0%A4%B8%E0%A4%82%E0%A4%96%E0%A5%8D%E0%A4%AF%E0%A4%BE+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B8%E0%A5%8D%E0%A4%A4%E0%A5%81%E0%A4%A4+%E0%A4%95%E0%A4%B0%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88.+%E0%A4%B8%E0%A4%BE%E0%A4%AE%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%80+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%AC%E0%A4%82%E0%A4%A7%E0%A4%A8+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A3%E0%A4%BE%E0%A4%B2%E0%A5%80+%E0%A4%B2%E0%A4%9A%E0%A5%80%E0%A4%B2%E0%A4%BE%E0%A4%AA%E0%A4%A8+%E0%A4%A8%E0%A4%8F+%E0%A4%AA%E0%A5%83%E0%A4%B7%E0%A5%8D%E0%A4%A0%E0%A5%8B%E0%A4%82+%E0%A4%94%E0%A4%B0+%E0%A4%A6%E0%A5%80%E0%A4%B0%E0%A5%8D%E0%A4%98%E0%A4%BE%E0%A4%93%E0%A4%82+%E0%A4%9C%E0%A5%8B%E0%A4%A1%E0%A4%BC%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%85%E0%A4%A8%E0%A5%81%E0%A4%AE%E0%A4%A4%E0%A4%BF+%E0%A4%A6%E0%A5%87%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "96", "1", "Werderfotos", "2010-11-22", "0000-00-00"),
("1", "36", "0", "", "", "5", "0", "", "2010-11-20", "0000-00-00"),
("1", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22seeteufel-hb.de%22%3Bs%3A3%3A%22Www%22%3Bs%3A15%3A%22seeteufel-hb.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A370%3A%22%3Cp%3EIn+meinem+ehemaligen+Tauchverein+habe+ich+die+neue+Gestaltung+der+Seiten+umgesetzt.+Dazu+habe+ich+die+Seite+von+veralteten+Frame-+und+Tabellenstrukturen+befreit+und+auf+SSI+umgestellt%2C+so+dass+wiederholte+Inhalte%2C+wie+etwa+das+Men%C3%BC%2C+nur+noch+einmal+in+einer+extra+Datei+stehen.+Sobald+%C3%BCber+das+neue+Design+entschieden+war%2C+war+es+ein+Leichtes+dieses+umzusetzen.%3C%2Fp%3E%22%3B%7D", "", "5", "0", "seeteufel-hb.de", "2010-11-20", "0000-00-00"),
("1", "36", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22seeteufel-hb.de%22%3Bs%3A3%3A%22Www%22%3Bs%3A15%3A%22seeteufel-hb.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A432%3A%22%3Cp%3EIn+meinem+ehemaligen+Tauchverein+habe+ich+die+neue+Gestaltung+der+Seiten+umgesetzt.%0D%0A++++++++++++++%0D%0A++++++++++++++Dazu+habe+ich+die+Seite+von+veralteten+Frame-+und+Tabellenstrukturen+befreit+und+auf+SSI+umgestellt%2C+so+dass+wiederholte+Inhalte%2C+wie+etwa+das+Men%C3%BC%2C+nur+noch+einmal+in+einer+extra+Datei+stehen.%0D%0A++++++++++++++%0D%0A++++++++++++++Sobald+%C3%BCber+das+neue+Design+entschieden+war%2C+war+es+ein+Leichtes+dieses+umzusetzen.%3C%2Fp%3E%22%3B%7D", "", "5", "0", "seeteufel-hb.de", "2010-11-20", "0000-00-00"),
("1", "38", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Werderfotos%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.werderfotos.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A316%3A%22%3Cp%3EThomas+Birkhahn+pr%C3%A4sentiert+auf+seiner+neuen+Internetseite+eine+Reihe+ausgew%C3%A4hlter+Fotos%2C+die+er+bei+verschiedenen+Anl%C3%A4ssen%2C+oder+beim+Training+des+SV+Werder+schie%C3%9Fen+konnte.++++Die+Seite+basiert+auf+dem+von+mir+entwickelten+Redaktionssystem+und+erlaubt+es+flexibel+neue+Galerien+und+Seiten+hinzuzuf%C3%BCgen.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Werderfotos", "2010-11-24", "0000-00-00"),
("1", "38", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Werderfotos%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.werderfotos.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A319%3A%22%3Cp%3EThomas+Birkhahn+pr%C3%A4sentiert+auf+seiner+neuen+Internetseite+eine+Reihe+ausgew%C3%A4hlter+Fotos%2C+die+er+bei+verschiedenen+Anl%C3%A4ssen%2C+oder+beim+Training+des+SV+Werder+schie%C3%9Fen+konnte.%0D%0A+++++Die+Seite+basiert+auf+dem+von+mir+entwickelten+Redaktionssystem+und+erlaubt+es+flexibel+neue+Galerien+und+Seiten+hinzuzuf%C3%BCgen.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Werderfotos", "2010-11-24", "0000-00-00"),
("1", "39", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22Wissenschaft+und+Forschung%22%3Bs%3A3%3A%22Www%22%3Bs%3A27%3A%22wissenschaft.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A314%3A%22%3Cp%3ESeit+Anfang+2001+schreibe+ich+wissenschaftliche+Artikel+f%C3%BCr+das+%3Ca+href%3D%22http%3A%2F%2Fwww.corona-magazine.de%2F%22%3ECorona-Magazin%3C%2Fa%3E%2C+da+wurde+es+Zeit+auch+den+Internetauftritt+mal+gr%C3%BCndlich+zu+%C3%BCberarbeiten.++++++Herausgekommen+ist+ein+sch%C3%B6nes+schlichtes+Design%2C+das+die+Aufmerksamkeit+auf+das+Wesentliche+lenkt.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Wissenschaft und Forschung", "2010-11-26", "0000-00-00"),
("1", "39", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22Wissenschaft+und+Forschung%22%3Bs%3A3%3A%22Www%22%3Bs%3A27%3A%22wissenschaft.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A321%3A%22%3Cp%3ESeit+Anfang+2001+schreibe+ich+wissenschaftliche+Artikel+f%C3%BCr+das+%5Burl%3Dhttp%3A%2F%2Fwww.corona-magazine.de%2F%5DCorona-Magazin%5B%2Furl%5D%2C+da+wurde+es+Zeit+auch+den+Internetauftritt+mal+gr%C3%BCndlich+zu+%C3%BCberarbeiten.%0D%0A++++++%0D%0A++++++Herausgekommen+ist+ein+sch%C3%B6nes+schlichtes+Design%2C+das+die+Aufmerksamkeit+auf+das+Wesentliche+lenkt.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Wissenschaft und Forschung", "2010-11-26", "0000-00-00"),
("1", "40", "0", "", "", "5", "1", "", "2010-11-26", "0000-00-00"),
("1", "40", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22Grafik+%26+%5BKo%5D%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.grafik-ko.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A195%3A%22%3Cp%3EWerbung%2C+Grafik%2C+Grafik-Design%2C+alle+grafischen+Arbeiten+sind+Schwerpunkt+der+kreativen+Arbeit+in+der+Werbeagentur+Grafik+%26amp%3B+Ko+in+Kirchhatten.+Die+Gestaltung+stammt+von+Gerje+Kollmann.%3C%2Fp%3E%22%3B%7D", "", "5", "1", "Grafik & [Ko]", "2010-11-26", "0000-00-00"),
("1", "40", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22Grafik+%26+%5BKo%5D%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.grafik-ko.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A288%3A%22%3Cp%3E%D8%A7%D9%84%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D8%AC%D8%B1%D8%A7%D9%81%D9%8A%D9%83%D9%8A%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D8%AC%D8%B1%D8%A7%D9%81%D9%8A%D9%83%D9%8A%D8%8C+%D9%88%D8%AC%D9%85%D9%8A%D8%B9+%D8%A3%D8%B9%D9%85%D8%A7%D9%84+%D8%A7%D9%84%D8%B1%D8%B3%D9%85+%D9%87%D9%8A+%D9%85%D8%AD%D9%88%D8%B1+%D8%A7%D9%84%D8%B9%D9%85%D9%84+%D8%A7%D9%84%D8%A5%D8%A8%D8%AF%D8%A7%D8%B9%D9%8A+%D9%81%D9%8A+%D9%88%D9%83%D8%A7%D9%84%D8%A9+%D8%A7%D9%84%D8%AF%D8%B9%D8%A7%D9%8A%D8%A9+%D8%A7%D9%84%D8%B1%D8%B3%D9%85+%D9%88%D8%B4%D8%B1%D9%83%D8%A7%D9%87+%D9%81%D9%8A+Kirchhatten.+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%8A%D8%A3%D8%AA%D9%8A+%D9%85%D9%86+Kollmann+Gerje.%3C%2Fp%3E%22%3B%7D", "", "5", "1", "Grafik & [Ko]", "2010-11-26", "0000-00-00"),
("1", "40", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22Grafik+%26+%5BKo%5D%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.grafik-ko.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A179%3A%22%3Cp%3EAdvertising%2C+print+and+graphic+design+are+the+focus+of+creative+work+in+the+advertising+agency+Grafik+%26amp%3B+Ko+in+Kirchhatten.+The+design+comes+from+Gerje+Kollmann+herself.%3C%2Fp%3E%22%3B%7D", "", "5", "1", "Grafik & [Ko]", "2010-11-26", "0000-00-00"),
("1", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A48%3A%22Der+angegebene+Name+enth%C3%A4lt+ung%C3%BCltige+Zeichen.%22%3B%7D", "", "2", "1", "Der angegebene Name enthält ungültige Zeichen.", "2012-01-29", "0000-00-00"),
("1", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22Your+name+seems+to+contain+invalid+characters.%22%3B%7D", "", "2", "1", "Your name seems to contain invalid characters.", "2012-01-29", "0000-00-00"),
("1", "47", "0", "", "", "1", "1", "", "2011-11-14", "0000-00-00"),
("1", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Gute+K%C3%B6pfe%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.gute-koepfe.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A236%3A%22%3Cp%3EPersonalvermittlung%2C+Interimsmanagement+und+Zeitarbeit+mit+K%C3%B6pfchen.+Die+erfahre%C2%ADnen+Berater+unterst%C3%BCtzen+bei+der+Suche+nach+qualifiziertem+Personal%2C+helfen+bei+der+Unternehmenssanierung+und+vermitteln+flexibel+Arbeitskr%C3%A4fte.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Gute Köpfe", "2011-11-14", "0000-00-00"),
("1", "47", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Gute+K%C3%B6pfe%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.gute-koepfe.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A334%3A%22%3Cp%3E%D8%A7%D9%84%D8%AA%D9%88%D8%B8%D9%8A%D9%81+%D9%88%D8%A7%D9%84%D8%A5%D8%AF%D8%A7%D8%B1%D8%A9+%D8%A7%D9%84%D9%85%D8%A4%D9%82%D8%AA%D8%A9+%D9%88%D8%A7%D9%84%D8%B9%D9%85%D8%A7%D9%84%D8%A9+%D8%A7%D9%84%D9%85%D8%A4%D9%82%D8%AA%D8%A9+%D9%85%D8%B9+%D8%A7%D9%84%D8%B9%D9%82%D9%88%D9%84.+%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D9%8A%D9%8A%D9%86+%D9%85%D9%86+%D8%B0%D9%88%D9%8A+%D8%A7%D9%84%D8%AE%D8%A8%D8%B1%D8%A9+%D9%85%D8%B3%D8%A7%D8%B9%D8%AF%D8%AA%D9%83+%D9%81%D9%8A+%D8%A7%D9%84%D8%B9%D8%AB%D9%88%D8%B1+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D9%85%D9%88%D8%B8%D9%81%D9%8A%D9%86+%D8%A7%D9%84%D9%85%D8%A4%D9%87%D9%84%D9%8A%D9%86%D8%8C+%D9%88%D8%A7%D9%84%D9%85%D8%B3%D8%A7%D8%B9%D8%AF%D8%A9+%D9%81%D9%8A+%D8%A5%D8%B9%D8%A7%D8%AF%D8%A9+%D9%87%D9%8A%D9%83%D9%84%D8%A9+%D8%A7%D9%84%D8%B4%D8%B1%D9%83%D8%A7%D8%AA+%D9%88%D8%AA%D9%88%D9%81%D9%8A%D8%B1+%D9%82%D9%88%D8%A9+%D8%B9%D9%85%D9%84+%D9%85%D8%B1%D9%86%D8%A9.%3Cbr+%2F%3E%0D%0A%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Gute Köpfe", "2011-11-14", "0000-00-00"),
("1", "47", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Gute+K%C3%B6pfe%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.gute-koepfe.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A199%3A%22%3Cp%3ERecruitment%2C+interim+management+and+temporary+employment.+Our+experienced+consultants+assist+you+in+finding+qualified+staff%2C+assist+in+corporate+restructuring+and+provide+a+flexible+workforce.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Gute Köpfe", "2011-11-14", "0000-00-00"),
("1", "48", "1", "a%3A1%3A%7Bs%3A8%3A%22Bingauth%22%3Bs%3A32%3A%22602063BD9369FBE0AAFDA26A72EFDE19%22%3B%7D", "", "99", "1", "602063BD9369FBE0AAFDA26A72EFDE19", "2013-11-14", "0000-00-00"),
("1", "100", "1", "a%3A2%3A%7Bs%3A9%3A%22Cangefreq%22%3Bs%3A6%3A%22weekly%22%3Bs%3A7%3A%22Prority%22%3Bs%3A3%3A%220.5%22%3B%7D", "", "99", "1", "weekly", "2010-08-06", "0000-00-00"),
("1", "100", "2", "a%3A2%3A%7Bs%3A9%3A%22Cangefreq%22%3Bs%3A6%3A%22weekly%22%3Bs%3A7%3A%22Prority%22%3Bs%3A3%3A%220.5%22%3B%7D", "", "99", "1", "weekly", "2010-08-06", "0000-00-00"),
("1", "100", "3", "a%3A2%3A%7Bs%3A9%3A%22Cangefreq%22%3Bs%3A6%3A%22weekly%22%3Bs%3A7%3A%22Prority%22%3Bs%3A3%3A%220.5%22%3B%7D", "", "99", "1", "weekly", "2010-08-06", "0000-00-00"),
("1", "101", "1", "a%3A2%3A%7Bs%3A15%3A%22Anweisungen_raw%22%3Bs%3A74%3A%22User-agent%3A+%2A%0D%0ADisallow%3A+%2Fimages%2F%0D%0ADisallow%3A+%2Fintern%2F%0D%0ADisallow%3A+script.js%22%3Bs%3A14%3A%22Sitemap_select%22%3Bs%3A3%3A%22100%22%3B%7D", "", "99", "1", "User-agent: *
Disallow: /images/
Disallow: ...", "2010-08-06", "0000-00-00"),
("1", "101", "3", "a%3A2%3A%7Bs%3A15%3A%22Anweisungen_raw%22%3Bs%3A74%3A%22User-agent%3A+%2A%0D%0ADisallow%3A+%2Fimages%2F%0D%0ADisallow%3A+%2Fintern%2F%0D%0ADisallow%3A+script.js%22%3Bs%3A14%3A%22Sitemap_select%22%3Bs%3A3%3A%22100%22%3B%7D", "", "99", "1", "User-agent: *
Disallow: /images/
Disallow: ...", "2010-08-06", "0000-00-00"),
("1", "109", "0", "", "", "99", "1", "", "2012-09-21", "0000-00-00"),
("1", "109", "1", "a%3A2%3A%7Bs%3A12%3A%22Limit_number%22%3Bs%3A1%3A%227%22%3Bs%3A10%3A%22Referenzen%22%3Bs%3A15%3A%22Neue+Referenzen%22%3B%7D", "", "99", "1", "7", "2012-09-21", "0000-00-00");

-- # Schnipp --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("1", "109", "3", "a%3A1%3A%7Bs%3A10%3A%22Referenzen%22%3Bs%3A14%3A%22New+References%22%3B%7D", "", "99", "1", "New References", "2012-09-21", "0000-00-00"),
("2", "32", "0", "", "", "6", "0", "", "2010-11-26", "0000-00-00"),
("2", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22MuS+Promotion%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.muspromotion.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A189%3A%22%3Cp%3EMuS+Promotion+bietet+Ihnen+ein+umfassen%C2%ADdes+Dienstleitungsangebot+in+den+Bereich%C2%ADen%3A+Event+und+Veranstaltungen%2C+Promotion%2C+Merchandise%2C+Schulungen%2C+Stadtf%C3%BChrungen+und+vieles+mehr.%3C%2Fp%3E%22%3B%7D", "", "6", "0", "MuS Promotion", "2010-11-26", "0000-00-00"),
("2", "32", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22MuS+Promotion%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.muspromotion.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A233%3A%22%3Cp%3E%D8%A7%D9%84%D9%85%D8%B5%D8%AD%D9%81+%D8%AA%D8%B9%D8%B2%D9%8A%D8%B2+%D8%AA%D9%82%D8%AF%D9%85+%D8%B9%D8%B1%D8%B6+%D8%A7%D9%84%D8%AE%D8%AF%D9%85%D8%A9+%D8%A7%D9%84%D8%B4%D8%A7%D9%85%D9%84%D8%A9+%D9%81%D9%8A+%D9%85%D9%86%D8%A7%D8%B7%D9%82+%D8%A7%D9%84%D8%AD%D8%AF%D8%AB+%D9%88%D8%A7%D9%84%D8%A3%D8%AD%D8%AF%D8%A7%D8%AB%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%B1%D9%82%D9%8A%D8%A7%D8%AA%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%B1%D9%88%D9%8A%D8%AC%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8%D8%8C+%D9%88%D8%A7%D9%84%D8%AC%D9%88%D9%84%D8%A7%D8%AA%D8%8C+%D9%88%D8%A3%D9%83%D8%AB%D8%B1+%D9%85%D9%86+%D8%B0%D9%84%D9%83+%D8%A8%D9%83%D8%AB%D9%8A%D8%B1.%3C%2Fp%3E%22%3B%7D", "", "6", "0", "MuS Promotion", "2010-11-26", "0000-00-00"),
("2", "32", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22MuS+Promotion%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.muspromotion.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A163%3A%22%3Cp%3EMuS+promotion+offers+an+extensive+range+of+service+management+in+the+areas+of%3A+event%2C+promotion%2C+merchandise%2C+training+courses%2C+guided+tours%2C+and+much+more.%3C%2Fp%3E%22%3B%7D", "", "6", "0", "MuS Promotion", "2010-11-26", "0000-00-00"),
("2", "34", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A40%3A%22Praxis+f%C3%BCr+systemische+Familienberatung%22%3Bs%3A3%3A%22Www%22%3Bs%3A38%3A%22http%3A%2F%2Fwww.familienberatung-bremen.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A152%3A%22%3Cp%3EBei+Beate+Pries+finden+Sie+Angebote+zur+Unterst%C3%BCtzung+in+ganz+individuellen+Lebens%C2%ADsituation+f%C3%BCr+Einzelpersonen%2C+Paare%2C+Familien+und+Kinder.%3C%2Fp%3E%0D%0A%22%3B%7D", "", "2", "1", "Praxis für systemische Familienberatung", "2010-11-26", "0000-00-00"),
("2", "34", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A40%3A%22Praxis+f%C3%BCr+systemische+Familienberatung%22%3Bs%3A3%3A%22Www%22%3Bs%3A38%3A%22http%3A%2F%2Fwww.familienberatung-bremen.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A109%3A%22%3Cp%3EAt+Beate+Pries+offers+to+assist+in+all+life+situation+for+individuals%2C+couples%2C+families+and+children.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Praxis für systemische Familienberatung", "2010-11-26", "0000-00-00"),
("2", "35", "0", "", "", "4", "0", "", "2010-11-24", "0000-00-00"),
("2", "35", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A10%3A%22Schokoklub%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.schokoklub.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A209%3A%22%3Cp%3EDie+Gr%C3%BCnder+des+Schokoklubs+sind+Genie%C3%9Fer+und+k%C3%B6nnen+sich+f%C3%BCr+gute+Schokolade+begeistern%2C+deshalb+haben+sie+sich+entschlossen%2C+den+Schokoklub+zu+gr%C3%BCnden.+Die+Gestaltung+ist+einfach+zum+Reinbei%C3%9Fen.%3C%2Fp%3E%22%3B%7D", "", "4", "0", "Schokoklub", "2010-11-24", "0000-00-00"),
("2", "35", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A10%3A%22Schokoklub%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.schokoklub.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A218%3A%22%3Cp%3EDie+Gr%C3%BCnder+des+Schokoklubs+sind+Genie%C3%9Fer+und+k%C3%B6nnen+sich+f%C3%BCr+gute+Schokolade+begeistern%2C+deshalb+haben+sie+sich+entschlossen%2C+den+Schokoklub+zu+gr%C3%BCnden.++++++++++Die+Gestaltung+ist+einfach+zum+Reinbei%C3%9Fen.%3C%2Fp%3E%22%3B%7D", "", "4", "0", "Schokoklub", "2010-11-24", "0000-00-00"),
("2", "36", "0", "", "", "3", "1", "", "2010-11-21", "0000-00-00"),
("2", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Bhavana+Vihara%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.bhavana-vihara.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A309%3A%22%3Cp%3EBhavana+Vihara+-+Das+Buddha-Haus+im+Norden+e.V.+m%C3%B6chte+einen+Ort+%28Vihara%29+schaffen%2C+an+dem+sich+der+Geist+entfalten+%28Bhavana%29+und+die+Liebe+in+unser+aller+Herzen+wachsen+kann.+Auf+Ihrer+Internetseite+informiert+Bhavana+Vihara+%C3%B6ber+Pl%C3%A4ne%2C+aktuelle+Entwicklungen+und+M%C3%B6glichkeiten+der+Unterst%C3%BCtzung.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Bhavana Vihara", "2010-11-21", "0000-00-00"),
("2", "36", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Bhavana+Vihara%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.bhavana-vihara.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A324%3A%22%3Cp%3EBhavana+Vihara+-+Das+Buddha-Haus+im+Norden+e.V.+m%C3%B6chte+einen+Ort+%28Vihara%29+schaffen%2C+an+dem+sich+der+Geist+entfalten+%28Bhavana%29+und+die+Liebe+in+unser+aller+Herzen+wachsen+kann.%0D%0A++++++++++++++Auf+Ihrer+Internetseite+informiert+Bhavana+Vihara+%C3%BCber+Pl%C3%A4ne%2C+aktuelle+Entwicklungen+und+M%C3%B6glichkeiten+der+Unterst%C3%BCtzung.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Bhavana Vihara", "2010-11-21", "0000-00-00"),
("2", "38", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Anneke+ter+Veen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.anneke-ter-veen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A143%3A%22%3Cp%3EDie+vielseitige+Moderatorin+und+Schauspielerin+Anneke+ter+Veen+hat+umfangreiche+Erfahrung+sowohl+vor+der+Kamera+als+auch+auf+der+B%C3%BChne.%3C%2Fp%3E%22%3B%7D", "", "1", "0", "Anneke ter Veen", "2010-11-26", "0000-00-00"),
("2", "38", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Anneke+ter+Veen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.anneke-ter-veen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A143%3A%22%3Cp%3EDie+vielseitige+Moderatorin+und+Schauspielerin+Anneke+ter+Veen+hat+umfangreiche+Erfahrung+sowohl+vor+der+Kamera+als+auch+auf+der+B%C3%BChne.%3C%2Fp%3E%22%3B%7D", "", "1", "0", "Anneke ter Veen", "2010-11-26", "0000-00-00"),
("2", "39", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A10%3A%22Fotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22fotografie.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A593%3A%22%3Cp%3EMeine+Fotoseiten+pr%C3%A4sentieren+sich+seit+Weihnachten+2004+in+einem+v%C3%B6llig+neuen+modernen+Gewand%2C+das+es+verdient%2C+hier+extra+gew%C3%BCrdigt+zu+werden.+Statt+dem+bisherigen+schwarzen+Design+zeigen+sich+die+Seiten+jetzt+hell+und+freundlich.++++++Verabschiedet+habe+ich+mich+hier+auch+von+dem+linearen+Men%C3%BCaufbau%2C+statt+dessen+gibt+es+jetzt+eine+aufgelockerte+%C3%9Cbersicht+im+Kopfbereich.++++++Trotz+der+ver%C3%A4nderten+Verzeichnisstruktur+bleiben+aber+alle+Verweise+g%C3%BCltig%2C+da+ich+mit+serverseitigen+Weiterleitungen+auf+die+neuen+Seite+verweise+-+so+kommen+auch+Suchroboter+nicht+durcheinander.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Fotografie", "2010-11-26", "0000-00-00"),
("2", "39", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A10%3A%22Fotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22fotografie.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A612%3A%22%3Cp%3EMeine+Fotoseiten+pr%C3%A4sentieren+sich+seit+Weihnachten+2004+in+einem+v%C3%B6llig+neuen+modernen+Gewand%2C+das+es+verdient%2C+hier+extra+gew%C3%BCrdigt+zu+werden.+Statt+dem+bisherigen+schwarzen+Design+zeigen+sich+die+Seiten+jetzt+hell+und+freundlich.%0D%0A++++++%0D%0A++++++Verabschiedet+habe+ich+mich+hier+auch+von+dem+linearen+Menuaufbau%2C+statt+dessen+gibt+es+jetzt+eine+aufgelockerte+%C3%9Cbersicht+im+Kopfbereich.%0D%0A++++++%0D%0A++++++Trotz+der+ver%C3%A4nderten+Verzeichnisstruktur+bleiben+aber+alle+Verweise+g%C3%BCltig%2C+da+ich+mit+serverseitigen+Weiterleitungen+auf+die+neuen+Seite+verweise+-+so+kommen+auch+Suchroboter+nicht+durcheinander.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Fotografie", "2010-11-26", "0000-00-00"),
("2", "40", "0", "", "", "18", "0", "", "2010-11-26", "0000-00-00"),
("2", "40", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Grafik%2FDTP+Sonnenberg%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.sonnysi.de%2Fsign%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A314%3A%22%3Cp%3ESonny+Sonnenberg+besitzt+langj%C3%A4hrige+Erfahrung+im+Bereich+Grafikdesign%2C+DTP+und+Gestaltung%2C+ganz+zu+schweigen+davon%2C+dass+ihre+kreative+Energie+nahezu+unersch%C3%B6pflich+ist.+Das+spiegelt+sich+auf+der+Internetseite+wieder%2C+die+ich+f%C3%BCr+Sonny+umsetze%2C+mit+vielen+Beispielen+ihrer+Arbeit+und+originellem+Design.%3C%2Fp%3E%22%3B%7D", "", "18", "0", "Grafik/DTP Sonnenberg", "2010-11-26", "0000-00-00"),
("2", "40", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Grafik%2FDTP+Sonnenberg%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.sonnysi.de%2Fsign%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A296%3A%22%3Cp%3ESonny+Sonnenberg+%D9%88%D8%B3%D9%86%D9%88%D8%A7%D8%AA+%D9%85%D9%86+%D8%A7%D9%84%D8%AE%D8%A8%D8%B1%D8%A9+%D9%81%D9%8A+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D8%B1%D8%B3%D9%88%D9%85+%D8%A7%D9%84%D8%A8%D9%8A%D8%A7%D9%86%D9%8A%D8%A9%D8%8C+%D9%88%D8%A7%D9%84%D9%86%D8%B4%D8%B1+%D8%A7%D9%84%D9%85%D9%83%D8%AA%D8%A8%D9%8A+%D9%88%D8%A7%D9%84%D8%AA%D8%B5%D9%85%D9%8A%D9%85%D8%8C+%D9%86%D8%A7%D9%87%D9%8A%D9%83+%D8%B9%D9%86+%D8%AD%D9%82%D9%8A%D9%82%D8%A9+%D8%A3%D9%86+%D8%A7%D9%84%D8%B7%D8%A7%D9%82%D8%A9+%D8%A7%D9%84%D8%A5%D8%A8%D8%AF%D8%A7%D8%B9%D9%8A%D8%A9+%D9%84%D8%A7+%D9%8A%D9%86%D8%B6%D8%A8+%D8%B9%D9%85%D9%84%D9%8A%D8%A7.+%D9%88%D9%8A%D9%86%D8%B9%D9%83%D8%B3+%D9%87%D8%B0%D8%A7+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D9%85%D9%88%D9%82%D8%B9+%D9%85%D8%B1%D8%A9+%D8%A3%D8%AE%D8%B1%D9%89.%3C%2Fp%3E%22%3B%7D", "", "18", "0", "Grafik/DTP Sonnenberg", "2010-11-26", "0000-00-00"),
("2", "40", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Grafik%2FDTP+Sonnenberg%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.sonnysi.de%2Fsign%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A287%3A%22%3Cp%3ESonny+Sonnenberg+has+years+of+experience+in+graphic+design%2C+desktop+publishing+and+design%2C+not+to+mention+the+fact+that+her+creative+energy+is+virtually+inexhaustible.+This+reflected+on+the+website%2C+which+I+transposes+for+Sonny%2C+with+many+examples+of+her+work+and+original+design.%3C%2Fp%3E%22%3B%7D", "", "18", "0", "Grafik/DTP Sonnenberg", "2010-11-26", "0000-00-00"),
("2", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A47%3A%22Der+angegebene+Ort+enth%C3%A4lt+ung%C3%BCltige+Zeichen.%22%3B%7D", "", "3", "1", "Der angegebene Ort enthält ungültige Zeichen.", "2012-01-29", "0000-00-00"),
("2", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A59%3A%22The+name+of+your+place+seems+to+contain+invalid+characters.%22%3B%7D", "", "3", "1", "The name of your place seems to contain invalid characters.", "2012-01-29", "0000-00-00"),
("2", "47", "0", "", "", "2", "1", "", "2011-08-24", "0000-00-00"),
("2", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Kirsch+Beratung%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.beratung-kirsch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A98%3A%22%3Cp%3EIndividuelles+Coaching+und+Bewerbungs%C2%ADtraining+mit+systemisch+l%C3%B6sungsorientiertem+Ansatz.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Kirsch Beratung", "2011-08-24", "0000-00-00"),
("2", "47", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Kirsch+Beratung%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.beratung-kirsch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A133%3A%22%3Cp%3E%D9%81%D8%B1%D8%AF+%D8%A7%D9%84%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8+%D9%88%D8%A7%D9%84%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D8%B9%D9%85%D9%84+%D9%85%D8%B9+%D8%A7%D8%AA%D8%A8%D8%A7%D8%B9+%D9%86%D9%87%D8%AC+%D8%A7%D9%84%D8%AD%D9%84+%D8%A7%D9%84%D9%82%D8%A7%D8%A6%D9%85+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D9%85%D9%86%D9%87%D8%AC%D9%8A%D8%A9.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Kirsch Beratung", "2011-08-24", "0000-00-00"),
("2", "47", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Kirsch+Consulting%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.beratung-kirsch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A93%3A%22%3Cp%3EIndividual+coaching+and+application+training+with+systemic+solution-oriented+approach.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Kirsch Consulting", "2011-08-24", "0000-00-00"),
("2", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A8%3A%22Gesperrt%22%3B%7D", "", "0", "1", "Gesperrt", "2012-03-06", "0000-00-00"),
("2", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A9%3A%22Everybody%22%3B%7D", "", "0", "1", "Everybody", "2012-03-06", "0000-00-00"),
("3", "32", "0", "", "", "99", "1", "", "2013-10-25", "0000-00-00"),
("3", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22Bremer+Hochzeits+DJs%22%3Bs%3A3%3A%22Www%22%3Bs%3A27%3A%22www.bremer-hochzeits-djs.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A180%3A%22%3Cp%3EDie+DJs+Anne%2C+Holger%2C+Marco+und+Andreas+bieten+Ihre+Dienstleistungen+f%C3%BCr+Ihre+Party+an.+Dazu+geh%C3%B6rt+mehr+als+gute+Musik%2C+auch+Fotografen%2C+Caterer+und+andere+sind+vernetzt.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Bremer Hochzeits DJs", "2013-10-25", "0000-00-00"),
("3", "32", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22Bremer+Hochzeits+DJs%22%3Bs%3A3%3A%22Www%22%3Bs%3A27%3A%22www.bremer-hochzeits-djs.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A173%3A%22%3Cp%3EThe+DJ+Anne%2C+Holger%2C+Marco+and+Andreas+offer+their+services+for+your+party.+This+includes+more+than+just+good+music%2C+photographers%2C+caterers+and+others+are+connected.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Bremer Hochzeits DJs", "2013-10-25", "0000-00-00"),
("3", "34", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Esther-Mara+Kross%22%3Bs%3A3%3A%22Www%22%3Bs%3A32%3A%22http%3A%2F%2Fwww.esther-mara-kross.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A397%3A%22%3Cp%3EEsther-Mara+Kross+betreibt+eine+Praxis+f%C3%BCr+Familien-+und+Paartherapie%2C+die+sie+jetzt+auch+im+Internet+pr%C3%A4sentieren+m%C3%B6chte.+In+diesem+Design+habe+ich+versucht%2C+die+warme+und+freundliche+Atmosph%C3%A4re+der+Praxis+wiederzugeben.+Dazu+habe+ich+warme+Farben+gew%C3%A4hlt+und+die+Gestaltung+in+einer+schlichten+unaufdringlichen+Weise+umgesetzt%2C+die+sich+in+Details+an+ihrer+Visitenkarte+orientiert.%3C%2Fp%3E%0D%0A%22%3B%7D", "", "3", "0", "Esther-Mara Kross", "2010-11-24", "0000-00-00"),
("3", "34", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Esther-Mara+Kross%22%3Bs%3A3%3A%22Www%22%3Bs%3A32%3A%22http%3A%2F%2Fwww.esther-mara-kross.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A161%3A%22%3Cp%3EEsther-Mara+Kross+operates+a+practice+for+family+and+couples+therapy.+In+this+design%2C+I+tried+to+reflect+the+warm+and+friendly+atmosphere+of+the+practice.%3C%2Fp%3E%22%3B%7D", "", "3", "0", "Esther-Mara Kross", "2010-11-24", "0000-00-00"),
("3", "36", "0", "", "", "2", "0", "", "2010-11-26", "0000-00-00"),
("3", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Worpsweder+Kunsthalle%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.worpsweder-kunsthalle.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A295%3A%22%3Cp%3EAusstellungen%2C+Kunsthandel%2C+eine+gro%C3%9Fe+Auswahl+von+Worpswede-Literatur%2C+Kunstkarten+und+Drucke+geh%C3%B6ren+zum+Angebot+der+Worpsweder+Kunsthalle+in+Wopswede%2C+25+km+nord%C3%B6stlich+von+Bremen+am+Rande+des+Teufelsmoores.+Die+Vorhandene+Gestaltung+wurde+in+das+Redaktionssystem+M-CMS+%C3%BCbernommen.%3C%2Fp%3E%22%3B%7D", "", "2", "0", "Worpsweder Kunsthalle", "2010-11-26", "0000-00-00"),
("3", "36", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Worpsweder+Kunsthalle%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.worpsweder-kunsthalle.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A326%3A%22%3Cp%3EAusstellungen%2C+Kunsthandel%2C+eine+gro%C3%9Fe+Auswahl+von+Worpswede-Literatur%2C+Kunstkarten+und+Drucke+geh%C3%B6ren+zum+Angebot+der+Worpsweder+Kunsthalle+in+Wopswede%2C+25+km+nord%C3%B6stlich+von+Bremen+am+Rande+des+Teufelsmoores.%0D%0A++++++++++++++%0D%0A++++++++++++++Die+Vorhandene+Gestaltung+wurde+in+das+Redaktionssystem+M-CMS+%C3%BCbernommen.%3C%2Fp%3E%22%3B%7D", "", "2", "0", "Worpsweder Kunsthalle", "2010-11-26", "0000-00-00"),
("3", "38", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Kati+Rausch%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.katirausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A248%3A%22%3Cp%3EKati+Rausch+pr%C3%A4sentiert+auf+diesen+Webseiten+ihr+Schauspieltalent.+Mit+Informationen+zu+ihrer+Vita%2C+einer+Fotogalerie%2C+Videobeispielen+und+aktuellen+Projekten+f%C3%BCr+ihre+Fans+und+interessierte+Produzenten+%28in+Deutsch%2C+Englisch+und+D%C3%A4nisch%29.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Kati Rausch", "2010-12-09", "0000-00-00"),
("3", "38", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Kati+Rausch%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.katirausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A248%3A%22%3Cp%3EKati+Rausch+pr%C3%A4sentiert+auf+diesen+Webseiten+ihr+Schauspieltalent.+Mit+Informationen+zu+ihrer+Vita%2C+einer+Fotogalerie%2C+Videobeispielen+und+aktuellen+Projekten+f%C3%BCr+ihre+Fans+und+interessierte+Produzenten+%28in+Deutsch%2C+Englisch+und+D%C3%A4nisch%29.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Kati Rausch", "2010-12-09", "0000-00-00"),
("3", "39", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Kurzgeschichten%22%3Bs%3A3%3A%22Www%22%3Bs%3A30%3A%22kurzgeschichten.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A447%3A%22%3Cp%3EEnde+2004+habe+ich+auch+meiner+Kurzgeschichten-Seite+ein+neues+Aussehen+verpasst.+++An+Stelle+des+dunklen+Hintergrunds+mit+wechselnden+Texturen%2C+zeigt+sich+die+Seite+jetzt+einheitlich+wei%C3%9F+mit+einem+hellen+Gelb+in+der+Kopfzeile%2C+sodass+nichts+mehr+von+den+Geschichten+ablenkt.++++++Das+Men%C3%BC+ist+teilweise+sehr+tief+verschachtelt%2C+aber+daf%C3%BCr+kann+man+von+jeder+Seite+auf+fast+jede+andere+wechseln+ohne+viel+hin+und+her+klicken+zu+m%C3%BCssen.%3C%2Fp%3E%22%3B%7D", "", "4", "1", "Kurzgeschichten", "2010-11-26", "0000-00-00"),
("3", "39", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Kurzgeschichten%22%3Bs%3A3%3A%22Www%22%3Bs%3A30%3A%22kurzgeschichten.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A462%3A%22%3Cp%3EEnde+2004+habe+ich+auch+meiner+Kurzgeschichten-Seite+ein+neues+Aussehen+verpasst.%0D%0A++++++An+Stelle+des+dunklen+Hintergrunds+mit+wechselnden+Texturen%2C+zeigt+sich+die+Seite+jetzt+einheitlich+wei%C3%9F+mit+einem+hellen+Gelb+in+der+Kopfzeile%2C+sodass+nichts+mehr+von+den+Geschichten+ablenkt.%0D%0A++++++%0D%0A++++++Das+Men%C3%BC+ist+teilweise+sehr+tief+verschachtelt%2C+aber+daf%C3%BCr+kann+man+von+jeder+Seite+auf+fast+jede+andere+wechseln+ohne+viel+hin+und+her+klicken+zu+m%C3%BCssen.%3C%2Fp%3E%22%3B%7D", "", "4", "1", "Kurzgeschichten", "2010-11-26", "0000-00-00"),
("3", "40", "0", "", "", "7", "0", "", "2010-11-26", "0000-00-00"),
("3", "40", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22dilling.layout-printmedien%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.layout-webtec.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A275%3A%22%3Cp%3Edilling.layout+ist+ein+modernes+Printmedien-Unternehmen+und+biete+hohe+Qualit%C3%A4t+in+Digital-+und+Offsetdruck%2C+Webdesign+und+Werbetechnik.+Durch+eigene+Druckmaschinen+sowie+Grafiker+kann+Service+aus+einer+Hand+von+der+Konzeption+bis+zur+Fertigstellung+angeboten+werden.%3C%2Fp%3E%22%3B%7D", "", "7", "0", "dilling.layout-printmedien", "2010-11-26", "0000-00-00"),
("3", "40", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22dilling.layout-printmedien%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.layout-webtec.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A320%3A%22%3Cp%3Edilling.layout+ist+ein+modernes+Printmedien-Unternehmen+und+biete+hohe+Qualit%C3%A4t+in+Digital-+und+Offsetdruck%2C+Webdesign+und+Werbetechnik.++++++++++++++++++++++++++++++++++++++++Durch+eigene+Druckmaschinen+sowie+Grafiker+kann+Service+%EF%BF%BDaus+einer+Hand%EF%BF%BD+von+der+Konzeption+bis+zur+Fertigstellung+angeboten+werden.%3C%2Fp%3E%22%3B%7D", "", "7", "0", "dilling.layout-printmedien", "2010-11-26", "0000-00-00"),
("3", "40", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22dilling.layout-printmedien%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.layout-webtec.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A223%3A%22%3Cp%3EDilling.layout+is+a+modern+print+media+company+and+offers+high-quality+digital+and+offset+printing%2C+web+design+and+advertising+technology.+Web+design+by+%3Ca+href%3D%22http%3A%2F%2Fwww.pj-malereiundgrafik.de%2F%22%3EPetra+Jaudszus%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "7", "0", "dilling.layout-printmedien", "2010-11-26", "0000-00-00"),
("3", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A49%3A%22Die+E-Mail-Adresse+scheint+nicht+g%C3%BCltig+zu+sein.%22%3B%7D", "", "4", "1", "Die E-Mail-Adresse scheint nicht gültig zu sein.", "2012-01-29", "0000-00-00"),
("3", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A36%3A%22This+seems+not+to+be+a+email+address%22%3B%7D", "", "4", "1", "This seems not to be a email address", "2012-01-29", "0000-00-00"),
("3", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A4%3A%22Gast%22%3B%7D", "", "1", "1", "Gast", "2012-03-06", "0000-00-00"),
("3", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22Guest%22%3B%7D", "", "1", "1", "Guest", "2012-03-06", "0000-00-00"),
("4", "32", "0", "", "", "99", "1", "", "2013-01-29", "0000-00-00"),
("4", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Literatur-Express%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.literatur-express.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A282%3A%22%3Cp%3EManfred+Boermann+dichtet%2C+verfasst+Reden+und+vor+allem+liest+er+vor%2C+aus+Reiseberich%C2%ADten%2C+Romanen%2C+Gedichtb%C3%A4nden+uvm..%3Cbr+%2F%3E%0D%0ADar%C3%BCber+hinaus+bietet+er+seine+Litera%28d%29tou%C2%ADren+an%2C+in+der+E-Rikscha+durch+Bremen+mit+literarischer+Unterhaltung+und+Gedichten+oder+Seemannsgarn.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Literatur-Express", "2013-01-29", "0000-00-00"),
("4", "32", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Literatur-Express%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.literatur-express.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A268%3A%22%3Cp%3EManfred+Boermann+writes+poetry+and+speeches+and+above+all+he+reads%2C+from+travelogues%2C+novels%2C+volumes+of+poetry+and+much+more...%3Cbr+%2F%3E%0D%0AIn+addition%2C+he+offers+his+Litera%28d%29Touren+in+the+E-rickshaw+in+Bremen+with+literary+entertainment+and+poems+or+Seemannsgarn.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Literatur-Express", "2013-01-29", "0000-00-00"),
("4", "32", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Literatur-Express%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.literatur-express.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A645%3A%22%3Cp%3EManfred+Boermann+%E0%A4%9C%E0%A4%B5%E0%A4%BE%E0%A4%A8%E0%A5%8B%E0%A4%82%2C+%E0%A4%B2%E0%A4%BF%E0%A4%96%E0%A4%BF%E0%A4%A4+%E0%A4%AD%E0%A4%BE%E0%A4%B7%E0%A4%A3+%E0%A4%94%E0%A4%B0+%E0%A4%B8%E0%A4%AC+%E0%A4%B8%E0%A5%87+%E0%A4%8A%E0%A4%AA%E0%A4%B0+%E0%A4%B5%E0%A4%B9+%E0%A4%AA%E0%A4%A2%E0%A4%BC%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88%2C+%E0%A4%94%E0%A4%B0+%E0%A4%AA%E0%A4%B0%E0%A5%8D%E0%A4%AF%E0%A4%9F%E0%A4%A8+%E0%A4%96%E0%A4%BE%E0%A4%A4%E0%A5%8B%E0%A4%82%2C+%E0%A4%89%E0%A4%AA%E0%A4%A8%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%B8%2C+%E0%A4%95%E0%A4%B5%E0%A4%BF%E0%A4%A4%E0%A4%BE+%E0%A4%B8%E0%A4%82%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A4%B9+%E0%A4%B8%E0%A5%87+%E0%A4%AC%E0%A4%B9%E0%A5%81%E0%A4%A4+%E0%A4%85%E0%A4%A7%E0%A4%BF%E0%A4%95+..+%E0%A4%87%E0%A4%B8%E0%A4%95%E0%A5%87+%E0%A4%85%E0%A4%B2%E0%A4%BE%E0%A4%B5%E0%A4%BE%2C+%E0%A4%B5%E0%A4%B9+%E0%A4%AE%E0%A4%A8%E0%A5%8B%E0%A4%B0%E0%A4%82%E0%A4%9C%E0%A4%A8+%E0%A4%94%E0%A4%B0+%E0%A4%B8%E0%A4%BE%E0%A4%B9%E0%A4%BF%E0%A4%A4%E0%A5%8D%E0%A4%AF%E0%A4%BF%E0%A4%95+%E0%A4%95%E0%A4%B5%E0%A4%BF%E0%A4%A4%E0%A4%BE%E0%A4%93%E0%A4%82+%E0%A4%94%E0%A4%B0+%E0%A4%AF%E0%A4%BE%E0%A4%B0%E0%A5%8D%E0%A4%A8+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%AE%E0%A5%87%E0%A4%A8+%E0%A4%95%E0%A5%87+%E0%A4%AE%E0%A4%BE%E0%A4%A7%E0%A5%8D%E0%A4%AF%E0%A4%AE+%E0%A4%B8%E0%A5%87+%E0%A4%88+%E0%A4%B0%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B6%E0%A4%BE+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AF%E0%A4%BE%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A4%BE+%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%B9%E0%A4%BF%E0%A4%A4%E0%A5%8D%E0%A4%AF+%28%E0%A4%98%29+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A6%E0%A4%BE%E0%A4%A8+%E0%A4%95%E0%A4%B0%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Literatur-Express", "2013-01-29", "0000-00-00"),
("4", "34", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Winnie+Abraham%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.winnie-abraham.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A150%3A%22%3Cp%3EWinnie+Abraham+bietet+individuelle+und+Paarberatung.+Die+Gestaltung+der+Homepage+stammt+von%26nbsp%3B%3Ca+href%3D%5C%22http%3A%2F%2Fwww.verb.de%2F%5C%22%3EVerb.de%3C%2Fa%3E.%3C%2Fp%3E%0D%0A%22%3B%7D", "", "99", "1", "Winnie Abraham", "2012-12-22", "0000-00-00"),
("4", "35", "0", "", "", "5", "0", "", "2010-11-23", "0000-00-00"),
("4", "35", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Digitale+St%C3%B6rung%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.digitale-stoerung.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A155%3A%22%3Cp%3EF%C3%BCr+die+Filmgruppe+Digitale+St%C3%B6rung+habe+ich+nicht+nur+am+Drehbuch+f%C3%BCr+das+aktuelle+Projekt+mitgearbeitet%2C+sondern+auch+unsere+Homepage+erstellt.%3C%2Fp%3E%22%3B%7D", "", "5", "0", "Digitale Störung", "2010-11-23", "0000-00-00"),
("4", "35", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Digitale+St%C3%B6rung%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.digitale-stoerung.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A188%3A%22%3Cp%3EF%C3%BCr+die+Filmgruppe+Digitale+St%C3%B6rung+habe+ich+nicht+nur+am+Drehbuch+f%C3%BCr+das+aktuelle+Projekt+mitgearbeitet%2C+sondern+auch+unsere+Homepage+umgesetzt+und+das+G%C3%A4stebuch+programmiert.%3C%2Fp%3E%22%3B%7D", "", "5", "0", "Digitale Störung", "2010-11-23", "0000-00-00"),
("4", "36", "0", "", "", "1", "1", "", "2010-11-25", "0000-00-00"),
("4", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Freunde+Worpswedes%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.freunde-worpswedes.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A192%3A%22%3Cp%3EDer+gemeinn%C3%BCtzige+Verein+%5C%22Freunde+Worpswedes%5C%22+informiert+%C3%BCber+Aktivit%C3%A4ten%2C+Planungen+und+Veranstaltungen.+Die+vorhandene+Gestaltung+wurde+in+das+Redaktionssystem+M-CMS+%C3%BCbernommen.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Freunde Worpswedes", "2010-11-25", "0000-00-00"),
("4", "36", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Freunde+Worpswedes%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.freunde-worpswedes.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A223%3A%22%3Cp%3EDer+gemeinn%C3%BCtzige+Verein+%5C%22Freunde+Worpswedes%5C%22+informiert+%C3%BCber+Aktivit%C3%A4ten%2C+Planungen+und+Veranstaltungen.%0D%0A++++++++++++++%0D%0A++++++++++++++Die+vorhandene+Gestaltung+wurde+in+das+Redaktionssystem+M-CMS+%C3%BCbernommen.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Freunde Worpswedes", "2010-11-25", "0000-00-00"),
("4", "39", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A7%3A%22Tauchen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22tauchen.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A216%3A%22%3Cp%3ETauchen+ist+ein+weiteres+meiner+Hobbies%2C+das+ich+im+Internet+vorstelle%2C+auf+dieser+Seite+gibt+es+Informationen+zu+Medizin%2C+Technik+und+Physik+dieses+faszinierenden+Sports%2C+sowie+einige+meiner+Unterwasserfotos.%3C%2Fp%3E%22%3B%7D", "", "5", "1", "Tauchen", "2010-11-26", "0000-00-00"),
("4", "39", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A7%3A%22Tauchen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22tauchen.marcus-haas.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A216%3A%22%3Cp%3ETauchen+ist+ein+weiteres+meiner+Hobbies%2C+das+ich+im+Internet+vorstelle%2C+auf+dieser+Seite+gibt+es+Informationen+zu+Medizin%2C+Technik+und+Physik+dieses+faszinierenden+Sports%2C+sowie+einige+meiner+Unterwasserfotos.%3C%2Fp%3E%22%3B%7D", "", "5", "1", "Tauchen", "2010-11-26", "0000-00-00"),
("4", "40", "0", "", "", "2", "1", "", "2014-01-24", "0000-00-00"),
("4", "40", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Edelzeichen%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22http%3A%2F%2Fwww.edelzeichen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A207%3A%22%3Cp%3EEdelzeichen+steht+f%C3%BCr+klare%2C+direkte+Gestaltung%2C%3Cbr+%2F%3E%0D%0Awenig+worte+%E2%80%93+grosse+wirkung%21%3Cbr+%2F%3E%0D%0AVon+Entwicklung+der+Corporate+Identity+%C3%BCber+Gestaltung+der+Produkte+bis+zu+Organisation+der+Produktion.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Edelzeichen", "2014-01-24", "0000-00-00"),
("4", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22Die+Telefonnummer+enth%C3%A4lt+ung%C3%BCltige+Zeichen.%22%3B%7D", "", "5", "1", "Die Telefonnummer enthält ungültige Zeichen.", "2012-01-29", "0000-00-00"),
("4", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22This+seems+not+to+be+a+valid+telephone+number.%22%3B%7D", "", "5", "1", "This seems not to be a valid telephone number.", "2012-01-29", "0000-00-00"),
("4", "47", "0", "", "", "9", "1", "", "2010-11-26", "0000-00-00"),
("4", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A27%3A%22Corinna+Fromm+Communication%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.corinnafromm.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A277%3A%22%3Cp%3ECorinna+Fromm+Communication+ber%C3%A4t+und+unterst%C3%BCtzt+in+den+Bereichen+Public+Relations%2C+Markenbildung+und+Position%C2%ADierung%2C+Kommunikationstraining%2C+Coaching+und+Mediation.+Diesmal+habe+ich+die+Gestaltung+einer+anderen+Werbeagentur+nach+den+W%C3%BCnschen+der+Kundin+umgesetzt.%3C%2Fp%3E%22%3B%7D", "", "9", "1", "Corinna Fromm Communication", "2010-11-26", "0000-00-00"),
("4", "47", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A27%3A%22Corinna+Fromm+Communication%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.corinnafromm.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A400%3A%22%3Cp%3ECorinna+Fromm+Communication+%D9%8A%D9%82%D8%AF%D9%85+%D8%A7%D9%84%D9%85%D8%B4%D9%88%D8%B1%D8%A9+%D9%88%D8%A7%D9%84%D9%85%D8%B3%D8%A7%D8%B9%D8%AF%D8%A9+%D9%81%D9%8A+%D9%85%D8%AC%D8%A7%D9%84%D8%A7%D8%AA+%D8%A7%D9%84%D8%B9%D9%84%D8%A7%D9%82%D8%A7%D8%AA+%D8%A7%D9%84%D8%B9%D8%A7%D9%85%D8%A9%D8%8C+%D9%88%D8%A7%D9%84%D8%B9%D9%84%D8%A7%D9%85%D8%A7%D8%AA+%D8%A7%D9%84%D8%AA%D8%AC%D8%A7%D8%B1%D9%8A%D8%A9+%D9%88%D8%AA%D8%AD%D8%AF%D9%8A%D8%AF+%D8%A7%D9%84%D9%85%D9%88%D8%A7%D9%82%D8%B9%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8%D8%8C+%D9%88%D8%A7%D9%84%D8%A7%D8%AA%D8%B5%D8%A7%D9%84%D8%A7%D8%AA%D8%8C+%D9%88%D8%A7%D9%84%D8%AA%D8%AF%D8%B1%D9%8A%D8%A8+%D9%88%D8%A7%D9%84%D9%88%D8%B3%D8%A7%D8%B7%D8%A9.+%D9%87%D8%B0%D9%87+%D8%A7%D9%84%D9%85%D8%B1%D8%A9+%D9%84%D9%85+%D8%A3%D9%83%D9%86+%D9%81%D9%8A+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A2%D8%AE%D8%B1+%D9%88%D9%83%D8%A7%D9%84%D8%A9+%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D8%A7%D8%AA+%D9%88%D9%81%D9%82%D8%A7+%D9%84%D8%B1%D8%BA%D8%A8%D8%A7%D8%AA+%D8%A7%D9%84%D8%B9%D9%85%D9%8A%D9%84+%D8%AA%D9%86%D9%81%D9%8A%D8%B0%D9%87%D8%A7.%3C%2Fp%3E%22%3B%7D", "", "9", "1", "Corinna Fromm Communication", "2010-11-26", "0000-00-00");

-- # Schnipp --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("4", "47", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A27%3A%22Corinna+Fromm+Communication%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.corinnafromm.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A374%3A%22%3Cp%3ECorinna+Fromm+communication+advises+and+assists+in+the+areas+of+public+relations%2C+branding+and+positioning%2C+communication+training%2C+coaching+and+mediation.+This+time%2C+I%5C%27ve+implemented+the+design+of+a+different+advertising+agency+according+to+the+wishes+of+the+customer.+The+page+is+based+on+the+content+management+system+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.m-cms.de%2Fen%5C%22%3EM-CMS%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "9", "1", "Corinna Fromm Communication", "2010-11-26", "0000-00-00"),
("4", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A6%3A%22Editor%22%3B%7D", "", "88", "1", "Editor", "2012-03-06", "0000-00-00"),
("4", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A6%3A%22Editor%22%3B%7D", "", "88", "1", "Editor", "2012-03-06", "0000-00-00"),
("5", "32", "0", "", "", "99", "1", "", "2012-10-10", "0000-00-00"),
("5", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22MusicInterviewCorner%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.musicinterviewcorner.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A105%3A%22%3Cp%3EVideo-interviews%2C+Artikel+und+Konzertfotos+pr%C3%A4sentiert+Kati+Rausch+im+neuen+MusicInterviewCorner.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "MusicInterviewCorner", "2012-10-10", "0000-00-00"),
("5", "32", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22MusicInterviewCorner%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.musicinterviewcorner.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A136%3A%22%3Cp%3E%D9%88%D8%AA%D8%B8%D9%87%D8%B1+%D8%A7%D9%84%D9%85%D9%82%D8%A7%D8%A8%D9%84%D8%A7%D8%AA+%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88+%D9%88%D8%A7%D9%84%D9%85%D9%82%D8%A7%D9%84%D8%A7%D8%AA+%D9%88%D8%A7%D9%84%D8%B5%D9%88%D8%B1+%D8%AD%D9%81%D9%84%D9%87+%D9%81%D9%8A+MusicInterviewCorner+%D9%85%D9%86+Kati+Rausch.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "MusicInterviewCorner", "2012-10-10", "0000-00-00"),
("5", "32", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22MusicInterviewCorner%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.musicinterviewcorner.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A108%3A%22%3Cp%3EVideo+interviews%2C+articles+and+concert+pictures+are+shown+in+the+MusicInterviewCorner+by+Kati+Rausch.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "MusicInterviewCorner", "2012-10-10", "0000-00-00"),
("5", "32", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22MusicInterviewCorner%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.musicinterviewcorner.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A264%3A%22%3Cp%3E%E0%A4%B5%E0%A5%80%E0%A4%A1%E0%A4%BF%E0%A4%AF%E0%A5%8B+%E0%A4%B8%E0%A4%BE%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%BE%E0%A4%A4%E0%A5%8D%E0%A4%95%E0%A4%BE%E0%A4%B0%2C+%E0%A4%B2%E0%A5%87%E0%A4%96+%E0%A4%94%E0%A4%B0+%E0%A4%95%E0%A5%89%E0%A4%A8%E0%A5%8D%E0%A4%B8%E0%A4%B0%E0%A5%8D%E0%A4%9F+%E0%A4%A4%E0%A4%B8%E0%A5%8D%E0%A4%B5%E0%A5%80%E0%A4%B0%E0%A5%87%E0%A4%82+%E0%A4%A8%E0%A4%88+%E0%A4%B8%E0%A4%82%E0%A4%97%E0%A5%80%E0%A4%A4+%E0%A4%B8%E0%A4%BE%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%BE%E0%A4%A4%E0%A5%8D%E0%A4%95%E0%A4%BE%E0%A4%B0+%E0%A4%95%E0%A5%89%E0%A4%B0%E0%A5%8D%E0%A4%A8%E0%A4%B0+%E0%A4%AE%E0%A5%87%E0%A4%82+Kati+Rausch+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B8%E0%A5%8D%E0%A4%A4%E0%A5%81%E0%A4%A4+%E0%A4%95%E0%A4%BF%E0%A4%AF%E0%A4%BE.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "MusicInterviewCorner", "2012-10-10", "0000-00-00"),
("5", "33", "0", "", "", "95", "1", "", "2010-11-24", "0000-00-00"),
("5", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Gertje+und+Arno+Kollmann%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kunst-raum.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A291%3A%22%3Cp%3EArno+und+Gertje+Kollmann+pr%C3%A4sentieren+ihren+Kunstraum+als+Atelier+und+Galerie+f%C3%BCr+zeitgen%C3%B6ssische+Malerei+und+Fotografie.+Die+Gestaltung+hat+Gertje+selbst+entworfen+und+wurde+von+Webdesign+Haas+so+umgesetzt%2C+dass+%C3%84nderungen+an+Texten+und+Bildern+leicht+vorgenommen+werden+k%C3%B6nnen.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Gertje und Arno Kollmann", "2010-11-24", "0000-00-00"),
("5", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Gertje+und+Arno+Kollmann%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kunst-raum.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A376%3A%22%3Cp%3EArno+und+Gertje+Kollmann+%D8%AA%D9%82%D8%AF%D9%8A%D9%85+%D9%85%D8%AC%D8%A7%D9%84%D9%87%D8%A7+%D8%A7%D9%84%D9%81%D9%86+%D9%83%D9%85%D8%A7+%D8%A7%D8%B3%D8%AA%D9%88%D8%AF%D9%8A%D9%88+%D9%88%D9%85%D8%B9%D8%B1%D8%B6+%D9%84%D9%84%D9%81%D9%86+%D8%A7%D9%84%D9%85%D8%B9%D8%A7%D8%B5%D8%B1+%D9%88%D8%A7%D9%84%D8%AA%D8%B5%D9%88%D9%8A%D8%B1+%D8%A7%D9%84%D9%81%D9%88%D8%AA%D9%88%D8%BA%D8%B1%D8%A7%D9%81%D9%8A.+%D9%88%D9%82%D8%AF+%D8%AA%D9%85+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%88%D8%AA%D8%AE%D8%B7%D9%8A%D8%B7%D8%8C+%D9%88%D8%A7%D9%84%D9%81%D8%AA%D8%AD+%D8%A7%D9%84%D8%A5%D8%B3%D9%84%D8%A7%D9%85%D9%8A+Gertje+%D8%A8%D9%88%D8%A7%D8%B3%D8%B7%D8%A9+%D9%87%D8%A7%D8%B3+%D8%AA%D9%86%D9%81%D9%8A%D8%B0%D9%87%D8%A7+%D8%A8%D8%B7%D8%B1%D9%8A%D9%82%D8%A9+%D9%8A%D9%85%D9%83%D9%86+%D8%A5%D8%AF%D8%AE%D8%A7%D9%84+%D8%AA%D8%BA%D9%8A%D9%8A%D8%B1%D8%A7%D8%AA+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D9%86%D8%B5%D9%88%D8%B5+%D9%88%D8%A7%D9%84%D8%B5%D9%88%D8%B1+%D8%A7%D9%84%D8%AA%D9%8A+%D8%A8%D8%B3%D9%87%D9%88%D9%84%D8%A9.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Gertje und Arno Kollmann", "2010-11-24", "0000-00-00"),
("5", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Gertje+und+Arno+Kollmann%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kunst-raum.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A185%3A%22%3Cp%3EArno+and+Gertje+Kollmann+present+their+art+studio+and+gallery+for+contemporary+painting+and+photography.+The+design+was+made+Gertje+herself+and+was+implemented+by+Webdesign+Haas.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Gertje und Arno Kollmann", "2010-11-24", "0000-00-00"),
("5", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Gertje+und+Arno+Kollmann%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kunst-raum.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A615%3A%22%3Cp%3EArno++%E0%A4%94%E0%A4%B0+Gertje+Kollmann+%E0%A4%B8%E0%A4%AE%E0%A4%95%E0%A4%BE%E0%A4%B2%E0%A5%80%E0%A4%A8+%E0%A4%AA%E0%A5%87%E0%A4%82%E0%A4%9F%E0%A4%BF%E0%A4%82%E0%A4%97+%E0%A4%94%E0%A4%B0+%E0%A4%AB%E0%A5%8B%E0%A4%9F%E0%A5%8B%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A4%BE%E0%A4%AB%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%8F%E0%A4%95+%E0%A4%B8%E0%A5%8D%E0%A4%9F%E0%A5%82%E0%A4%A1%E0%A4%BF%E0%A4%AF%E0%A5%8B+%E0%A4%94%E0%A4%B0+%E0%A4%97%E0%A5%88%E0%A4%B2%E0%A4%B0%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%B0%E0%A5%82%E0%A4%AA+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%95%E0%A4%B2%E0%A4%BE+%E0%A4%85%E0%A4%82%E0%A4%A4%E0%A4%B0%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7+%E0%A4%89%E0%A4%AA%E0%A4%B8%E0%A5%8D%E0%A4%A5%E0%A4%BF%E0%A4%A4+%E0%A4%A5%E0%A5%87.+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%96%E0%A5%81%E0%A4%A6+%E0%A4%AA%E0%A4%BE%E0%A4%A0+%E0%A4%94%E0%A4%B0+%E0%A4%9B%E0%A4%B5%E0%A4%BF%E0%A4%AF%E0%A5%8B%E0%A4%82+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AA%E0%A4%B0%E0%A4%BF%E0%A4%B5%E0%A4%B0%E0%A5%8D%E0%A4%A4%E0%A4%A8+%E0%A4%86%E0%A4%B8%E0%A4%BE%E0%A4%A8%E0%A5%80+%E0%A4%B8%E0%A5%87+%E0%A4%AC%E0%A4%A8%E0%A4%BE%E0%A4%AF%E0%A4%BE+%E0%A4%9C%E0%A4%BE+%E0%A4%B8%E0%A4%95%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88%2C+%E0%A4%A4%E0%A4%BE%E0%A4%95%E0%A4%BF+Gertje+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%95%E0%A4%BF%E0%A4%AF%E0%A4%BE+%E0%A4%97%E0%A4%AF%E0%A4%BE+%E0%A4%B9%E0%A5%88+%E0%A4%94%E0%A4%B0+Webdesign+Haas+%E0%A4%A6%E0%A5%8D%E0%A4%B5%E0%A4%BE%E0%A4%B0%E0%A4%BE+%E0%A4%B2%E0%A4%BE%E0%A4%97%E0%A5%82+%E0%A4%95%E0%A4%BF%E0%A4%AF%E0%A4%BE+%E0%A4%97%E0%A4%AF%E0%A4%BE+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "95", "1", "Gertje und Arno Kollmann", "2010-11-24", "0000-00-00"),
("5", "34", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22DK+Kosmetik%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.dk-kosmetik.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A291%3A%22%3Cp%3EDagmar+Kammeier+betreibt+ein+Kosmetik%C2%ADstudio+f%C3%BCr+Gesichts-+u.+K%C3%B6rperbehand%C2%ADlungen+%28Wellness-Massagen%29+mit+MALU-WILZ-Produkten+f%C3%BCr+Damen%2C+Herren+und+Teenies.+Um+Preise+und+Inhalte+verwalten+zu+k%C3%B6nnen+basiert+diese+Seite+auf+dem+von+Webdesign+Haas+entwickelten+Redaktionssystem.%3C%2Fp%3E%0D%0A%22%3B%7D", "", "15", "1", "DK Kosmetik", "2010-11-26", "0000-00-00"),
("5", "34", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22DK+Kosmetik%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.dk-kosmetik.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A337%3A%22%3Cp%3EDagmar+Kammeier+%26%23160%3B%D8%AA%D8%AF%D9%8A%D8%B1+%D8%B5%D8%A7%D9%84%D9%88%D9%86+%D8%AA%D8%AC%D9%85%D9%8A%D9%84+%D9%84%D9%84%D8%B9%D9%84%D8%A7%D8%AC%D8%A7%D8%AA+%D8%A7%D9%84%D9%88%D8%AC%D9%87+%D9%88%D8%A7%D9%84%D8%AC%D8%B3%D9%85+%28%D9%88%D8%A7%D8%B3+%D8%AA%D8%AF%D9%84%D9%8A%D9%83%29+%D9%85%D8%B9+%D8%A7%D9%84%D9%85%D9%86%D8%AA%D8%AC%D8%A7%D8%AA+WILZ+%D9%85%D8%A7%D9%84%D9%88+%D9%84%D9%84%D9%86%D8%B3%D8%A7%D8%A1+%D9%88%D8%A7%D9%84%D8%B1%D8%AC%D8%A7%D9%84+%D9%88%D8%A7%D9%84%D9%85%D8%B1%D8%A7%D9%87%D9%82%D9%8A%D9%86.+%D9%85%D9%86+%D8%A3%D8%AC%D9%84+%D8%A5%D8%AF%D8%A7%D8%B1%D8%A9+%D8%A7%D9%84%D8%AA%D8%B3%D8%B9%D9%8A%D8%B1+%D9%88%D9%8A%D9%85%D9%83%D9%86+%D8%AA%D8%B7%D9%88%D9%8A%D8%B1+%D9%85%D8%AD%D8%AA%D9%88%D9%89+%D9%87%D8%B0%D8%A7+%D8%A7%D9%84%D9%85%D9%88%D9%82%D8%B9+%D9%87%D9%88+%D9%85%D8%AF%D8%B9%D9%88%D9%85+%D9%85%D9%86+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%87%D8%A7%D8%B3.%3C%2Fp%3E%22%3B%7D", "", "15", "1", "DK Kosmetik", "2010-11-26", "0000-00-00"),
("5", "34", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22DK+Kosmetik%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.dk-kosmetik.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A146%3A%22%3Cp%3EDagmar+Kammeier+operates+a+beauty+salon+for+face+%26amp%3B+body+treatments+%28wellness+massage%29+with+MALU+WILZ+products+for+women%2C+men+and+teens.%3C%2Fp%3E%22%3B%7D", "", "15", "1", "DK Kosmetik", "2010-11-26", "0000-00-00"),
("5", "35", "0", "", "", "1", "1", "", "2010-11-26", "0000-00-00"),
("5", "35", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Nat%C3%BCrlich+Reisen%22%3Bs%3A3%3A%22Www%22%3Bs%3A32%3A%22http%3A%2F%2Fwww.natuerlich-reisen.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A187%3A%22%3Cp%3ENat%C3%BCrlich+Reisen+setzt+seine+Erfahrung+und+Kompetenz+ein%2C+um+sanfte+Reisen+unter+umwelt-+und+sozialvertr%C3%A4glichen+Gesichts%C2%ADpunkten+mit+deutlichem+regionalem+Bezug+zu+konzipieren.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Natürlich Reisen", "2010-11-26", "0000-00-00"),
("5", "35", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Nat%C3%BCrlich+Reisen%22%3Bs%3A3%3A%22Www%22%3Bs%3A32%3A%22http%3A%2F%2Fwww.natuerlich-reisen.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A185%3A%22%3Cp%3ENat%C3%BCrlich+Reisen+setzt+seine+Erfahrung+und+Kompetenz+ein%2C+um+sanfte+Reisen+unter+umwelt-+und+sozialvertr%C3%A4glichen+Gesichtspunkten+mit+deutlichem+regionalem+Bezug+zu+konzipieren.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Natürlich Reisen", "2010-11-26", "0000-00-00"),
("5", "36", "0", "", "", "99", "0", "", "2012-12-22", "0000-00-00"),
("5", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A46%3A%22Segelgemeinschaft+der+Universit%C3%A4t+Bremen+e.V.%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.sub-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A249%3A%22%3Cp%3ESeit+mehr+als+30+Jahren+existiert+die+Segel%C2%ADgemeinschaft+der+Universit%C3%A4t+Bremen+e.V.+%28SUB%29.%3Cbr+%2F%3E%0D%0AUnd+jetzt+gibt+es+eine+neue+Homepage+nach+der+Gestaltung+von+Mechtild+Pfeiffer%3A+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.pfeifferdesign.de%2F%5C%22%3EPfeifferDesign%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Segelgemeinschaft der Universität Bremen e.V.", "2012-12-22", "0000-00-00"),
("5", "39", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Ausser+Reichweite%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.ausser-reichweite.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A56%3A%22%3Cp%3EUnd+hier+finden+Sie+meinen+Science-Fiction+Roman.%3C%2Fp%3E%22%3B%7D", "", "6", "1", "Ausser Reichweite", "2010-11-26", "0000-00-00"),
("5", "39", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A17%3A%22Ausser+Reichweite%22%3Bs%3A3%3A%22Www%22%3Bs%3A24%3A%22www.ausser-reichweite.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A56%3A%22%3Cp%3EUnd+hier+finden+Sie+meinen+Science-Fiction+Roman.%3C%2Fp%3E%22%3B%7D", "", "6", "1", "Ausser Reichweite", "2010-11-26", "0000-00-00"),
("5", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A48%3A%22Die+Mobilfunknummer+enth%C3%A4lt+ung%C3%BCltige+Zeichen.%22%3B%7D", "", "6", "1", "Die Mobilfunknummer enthält ungültige Zeichen.", "2012-01-29", "0000-00-00"),
("5", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A49%3A%22This+seems+not+to+be+a+valid+mobile+phone+number.%22%3B%7D", "", "6", "1", "This seems not to be a valid mobile phone number.", "2012-01-29", "0000-00-00"),
("5", "99", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22Admin%22%3B%7D", "", "99", "1", "Admin", "2012-03-06", "0000-00-00"),
("5", "99", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A5%3A%22Admin%22%3B%7D", "", "99", "1", "Admin", "2012-03-06", "0000-00-00"),
("6", "32", "0", "", "", "97", "1", "", "2010-11-23", "0000-00-00"),
("6", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22Kati+Rausch+-+Comedy%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kati-rausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A174%3A%22%3Cp%3EF%C3%BCr+die+Kleink%C3%BCnstlerin+Kati+Rausch+aus+K%C3%B6ln+entstand+diese+Internetseite.+Mit+dem+Redaktionssystem+kann+Kati+ihre+aktuellen+Termine+eintragen+und+Videos+einbinden.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - Comedy", "2010-11-23", "0000-00-00"),
("6", "32", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A28%3A%22Kati+Rausch+-+%D9%83%D9%88%D9%85%D9%8A%D8%AF%D9%8A%D8%A7%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kati-rausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A294%3A%22%3Cp%3E%D8%A5%D8%B0%D8%A7+%D8%AC%D8%A7%D8%A1%D8%AA+%D8%B5%D8%BA%D9%8A%D8%B1+Kati+Rausch+%D9%81%D9%86%D8%A7%D9%86+%D9%85%D9%86+%D8%A8%D8%B1%D9%8A%D9%85%D9%86+%D9%85%D9%86+%D9%87%D8%B0%D8%A7+%D8%A7%D9%84%D9%85%D9%88%D9%82%D8%B9.+%D9%88%D9%81%D9%82%D8%A7+%D9%84%D8%A3%D9%87%D8%AF%D8%A7%D9%81+%D9%83%D8%A7%D8%AA%D9%8A+%D9%84%D9%87%D8%B0%D9%87+%D8%A7%D9%84%D9%86%D8%B8%D8%B1%D8%A9.+%D9%85%D8%B9+%D8%A3%D9%86+%D9%86%D8%B8%D8%A7%D9%85+%D8%A5%D8%AF%D8%A7%D8%B1%D8%A9+%D9%85%D8%AD%D8%AA%D9%88%D9%89+%D8%AA%D8%B3%D8%AC%D9%8A%D9%84+%D8%A7%D9%84%D9%85%D9%88%D8%A7%D8%B9%D9%8A%D8%AF+%D9%88%D8%B6%D8%B9%D9%87%D8%A7+%D8%A7%D9%84%D8%B1%D8%A7%D9%87%D9%86+%D9%88%D8%A3%D8%B4%D8%B1%D8%B7%D8%A9+%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88+%D8%AA%D8%B6%D9%85%D9%8A%D9%86+%D8%A7%D9%84%D9%82%D8%A7%D8%B7%D9%8A.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - كوميديا", "2010-11-23", "0000-00-00"),
("6", "32", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22Kati+Rausch+-+Comedy%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kati-rausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A75%3A%22%3Cp%3EThis+website+was+created+for+the+comedienne+Kati+Rausch+from+Colgne.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - Comedy", "2010-11-23", "0000-00-00"),
("6", "32", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A20%3A%22Kati+Rausch+-+Comedy%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.kati-rausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A378%3A%22%3Cp%3E%E0%A4%95%E0%A5%8B%E0%A4%B2%E0%A5%8B%E0%A4%A8+%E0%A4%B8%E0%A5%87+%E0%A4%9B%E0%A5%8B%E0%A4%9F%E0%A5%87+%E0%A4%95%E0%A4%B2%E0%A4%BE%E0%A4%95%E0%A4%BE%E0%A4%B0+Kati+%E2%80%8B%E2%80%8BRausch+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%87%E0%A4%B8+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%95%E0%A5%8B+%E0%A4%AC%E0%A4%A8%E0%A4%BE%E0%A4%AF%E0%A4%BE+%E0%A4%97%E0%A4%AF%E0%A4%BE+%E0%A4%A5%E0%A4%BE.+%E0%A4%B8%E0%A4%82%E0%A4%AA%E0%A4%BE%E0%A4%A6%E0%A4%95%E0%A5%80%E0%A4%AF+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A3%E0%A4%BE%E0%A4%B2%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5+Kati+%E0%A4%89%E0%A4%A8%E0%A4%95%E0%A5%87+%E0%A4%B5%E0%A4%B0%E0%A5%8D%E0%A4%A4%E0%A4%AE%E0%A4%BE%E0%A4%A8+%E0%A4%A6%E0%A4%BF%E0%A4%A8%E0%A4%BE%E0%A4%82%E0%A4%95+%E0%A4%94%E0%A4%B0+%E0%A4%8F%E0%A4%AE%E0%A5%8D%E0%A4%AC%E0%A5%87%E0%A4%A1+%E0%A4%B5%E0%A5%80%E0%A4%A1%E0%A4%BF%E0%A4%AF%E0%A5%8B+%E0%A4%A6%E0%A4%B0%E0%A5%8D%E0%A4%9C+%E0%A4%95%E0%A4%B0+%E0%A4%B8%E0%A4%95%E0%A4%A4%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - Comedy", "2010-11-23", "0000-00-00"),
("6", "33", "0", "", "", "94", "1", "", "2010-11-26", "0000-00-00"),
("6", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Anneke+ter+Veen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.anneke-ter-veen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A145%3A%22%3Cp%3EDie+vielseitige+Moderatorin+und+Schauspie%C2%ADlerin+Anneke+ter+Veen+hat+umfangreiche+Erfahrung+sowohl+vor+der+Kamera+als+auch+auf+der+B%C3%BChne.%3C%2Fp%3E%22%3B%7D", "", "94", "1", "Anneke ter Veen", "2010-11-26", "0000-00-00"),
("6", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Anneke+ter+Veen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.anneke-ter-veen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A152%3A%22%3Cp%3E%D9%85%D9%82%D8%AF%D9%85+%D8%AA%D9%86%D9%88%D8%B9%D8%A7+%D9%88%D8%A7%D9%84%D9%85%D9%85%D8%AB%D9%84%D8%A9+Anneke+ter+Veen+%D9%8A%D9%85%D9%84%D9%83+%D8%AE%D8%A8%D8%B1%D8%A9+%D9%88%D8%A7%D8%B3%D8%B9%D8%A9+%D8%B3%D9%88%D8%A7%D8%A1+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D9%83%D8%A7%D9%85%D9%8A%D8%B1%D8%A7+%D9%88%D8%B9%D9%84%D9%89+%D8%AE%D8%B4%D8%A8%D8%A9+%D8%A7%D9%84%D9%85%D8%B3%D8%B1%D8%AD%3C%2Fp%3E%22%3B%7D", "", "94", "1", "Anneke ter Veen", "2010-11-26", "0000-00-00"),
("6", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Anneke+ter+Veen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.anneke-ter-veen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A125%3A%22%3Cp%3EThe+versatile+moderator+and+actress+Anneke+ter+Veen+has+extensive+experience+both+in+front+of+the+camera+and+on+stage.%3C%2Fp%3E%22%3B%7D", "", "94", "1", "Anneke ter Veen", "2010-11-26", "0000-00-00"),
("6", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Anneke+ter+Veen%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.anneke-ter-veen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A225%3A%22%3Cp%3E%E0%A4%AC%E0%A4%B9%E0%A5%81%E0%A4%AE%E0%A5%81%E0%A4%96%E0%A5%80+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B8%E0%A5%8D%E0%A4%A4%E0%A5%81%E0%A4%A4%E0%A4%95%E0%A4%B0%E0%A5%8D%E0%A4%A4%E0%A4%BE+%E0%A4%94%E0%A4%B0+%E0%A4%85%E0%A4%AD%E0%A4%BF%E0%A4%A8%E0%A5%87%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A5%80+Anneke+ter+Veen+%E0%A4%95%E0%A5%88%E0%A4%AE%E0%A4%B0%E0%A5%87+%E0%A4%AA%E0%A4%B0+%E0%A4%94%E0%A4%B0+%E0%A4%AE%E0%A4%82%E0%A4%9A+%E0%A4%AA%E0%A4%B0+%E0%A4%A6%E0%A5%8B%E0%A4%A8%E0%A5%8B%E0%A4%82+%E0%A4%B5%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%AA%E0%A4%95+%E0%A4%85%E0%A4%A8%E0%A5%81%E0%A4%AD%E0%A4%B5+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "94", "1", "Anneke ter Veen", "2010-11-26", "0000-00-00"),
("6", "35", "0", "", "", "2", "1", "", "2010-11-25", "0000-00-00"),
("6", "35", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A12%3A%22Literanauten%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.literanauten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A222%3A%22%3Cp%3EDie+Literanauten+sind+eine+Bremer+Schreib%C2%ADwerkstatt.+Sie+treffen+sich+regelm%C3%A4%C3%9Fig+um+ihre+Geschichten+zu+lesen+und+zu+kritisieren.+Au%C3%9Ferdem+veranstalten+sie+Lesungen+und+nehmen+%28erfolgreich%29+an+Wettbewerben+Teil.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Literanauten", "2010-11-25", "0000-00-00"),
("6", "35", "3", "a%3A4%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A12%3A%22Literanauten%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.literanauten.de%22%3Bs%3A4%3A%22name%22%3Bs%3A16%3A%22literanauten.jpg%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A230%3A%22%3Cp%3EDie+Literanauten+sind+eine+Bremer%2FL%C3%BCbecker+Schreibwerkstatt.+Sie+treffen+sich+regelm%C3%A4%C3%9Fig+um+ihre+Geschichten+zu+lesen+und+zu+kritisieren.+Au%C3%9Ferdem+veranstalten+sie+Lesungen+und+nehmen+%28erfolgreich%29+an+Wettbewerben+Teil.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Literanauten", "2010-11-25", "0000-00-00"),
("6", "36", "0", "", "", "99", "1", "", "2016-05-21", "0000-00-00"),
("6", "36", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22Worpsweder+Internetzeitung%22%3Bs%3A3%3A%22Www%22%3Bs%3A33%3A%22www.worpsweder-internetzeitung.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A200%3A%22%3Cp%3EDie+Worpsweder+Internetzeitung+ist+ein+Forum+f%C3%BCr+Ereignisse+und+Meinungen+zum+K%C3%BCnstlerdorf.+Sie+wird+herausgeben+von+den+Freunden+Worpswedes+und+der+Worpsweder+Kunststiftung+Friedrich+Netzel.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Worpsweder Internetzeitung", "2016-05-21", "0000-00-00"),
("6", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A31%3A%22Bitte+geben+Sie+ein+Betreff+an.%22%3B%7D", "", "8", "1", "Bitte geben Sie ein Betreff an.", "2012-01-29", "0000-00-00"),
("6", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A23%3A%22Please+enter+a+subject.%22%3B%7D", "", "8", "1", "Please enter a subject.", "2012-01-29", "0000-00-00"),
("6", "47", "0", "", "", "3", "1", "", "2011-07-29", "0000-00-00"),
("6", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A12%3A%22Presse+Engel%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.presse-engel.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A289%3A%22%3Cp%3EWenn+Sie+Ihre+Unternehmens%C2%ADkommu%C2%ADnika%C2%ADtion+verbessern+und+Ihre+Zielgruppe+ver%C2%ADgr%C3%B6%C3%9Fern+m%C3%B6chten+sind+sie+bei+Frau+Engel+gut+aufgehoben.+Die+klare+Gestaltung+von+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.pfeifferdesign.de%2F%5C%22+target%3D%5C%22_blank%5C%22%3EPfeiffer+Design%3C%2Fa%3E+unterst%C3%BCtzt+den+Internet%C2%ADauftritt.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Presse Engel", "2011-07-29", "0000-00-00"),
("6", "47", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Engel+Effizienz%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22www.engel-effizienz.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A229%3A%22%3Cp%3E%D8%A5%D8%B0%D8%A7+%D9%83%D9%86%D8%AA+%D8%AA%D8%B1%D8%BA%D8%A8+%D9%81%D9%8A+%D8%AA%D8%AD%D8%B3%D9%8A%D9%86+%D8%A7%D9%84%D8%A7%D8%AA%D8%B5%D8%A7%D9%84%D8%A7%D8%AA+%D8%B9%D9%85%D9%84%D9%83+%D9%88%D8%B2%D9%8A%D8%A7%D8%AF%D8%A9+%D8%AC%D9%85%D9%87%D9%88%D8%B1%D9%83%D8%8C+%D9%81%D9%87%D9%8A+%D9%81%D9%8A+%D8%A3%D9%8A%D8%AF+%D8%A3%D9%85%D9%8A%D9%86%D8%A9+%D9%85%D8%B9+%D8%A5%D9%86%D8%AC%D9%84+%D8%A7%D9%84%D8%B3%D9%8A%D8%AF%D8%A9.+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%88%D8%A7%D8%B6%D8%AD+%D9%85%D9%86+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%81%D8%A7%D9%8A%D9%81%D8%B1+%D9%8A%D8%AF%D8%B9%D9%85+%D8%A7%D9%84%D9%85%D9%88%D9%82%D8%B9.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Engel Effizienz", "2011-07-29", "0000-00-00"),
("6", "47", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A12%3A%22Presse+Engel%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.presse-engel.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A197%3A%22%3Cp%3EIf+you+want+to+improve+your+corporate+communication+and+increase+your+audience+this+Mrs.+Engel+is+the+one+to+ask.+Web+design+by+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.pfeifferdesign.de%2F%5C%22%3EPfeiffer+Design%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Presse Engel", "2011-07-29", "0000-00-00"),
("7", "32", "0", "", "", "99", "0", "", "2013-02-27", "0000-00-00"),
("7", "32", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Epulum-Service%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.epulum-service.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A286%3A%22%3Cp%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+verdana%2C+helvetica%2C+sans-serif%3B+font-size%3A+14px%3B+line-height%3A+23.799999237060547px%3B+background-color%3A+rgb%28255%2C+255%2C+255%29%3B%5C%22%3ESie+planen+eine+Feier%3F+Dann+sind+ist+Epulum-Service+Ihr+Partner+im+Bereich+Veranstaltungsmanagement.%3C%2Fspan%3E%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Epulum-Service", "2013-02-27", "0000-00-00"),
("7", "33", "0", "", "", "97", "1", "", "2011-07-31", "0000-00-00"),
("7", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Kati+Rausch+-+Schauspiel%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.katirausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A261%3A%22%3Cp%3EKati+Rausch+zeigt+auf+diesen+Webseiten+ihr+Schauspieltalent.+Mit+Informationen+zu+ihrer+Vita%2C+einer+Fotogalerie%2C+Videobeispielen+und+aktuellen+Projekten+f%C3%BCr+ihre+Fans+und+interessierte+Produzenten+%28in+Deutsch%2C+Englisch%2C+D%C3%A4nisch+und+bald+auch+Finnisch%29.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - Schauspiel", "2011-07-31", "0000-00-00"),
("7", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A22%3A%22Kati+Rausch+-+%D9%85%D8%B4%D9%87%D8%AF%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.katirausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A418%3A%22%3Cp%3EKati+Rausch+%D8%A7%D9%84%D9%85%D8%B9%D8%B1%D9%88%D8%B6%D8%A9+%D8%B9%D9%84%D9%89+%D9%87%D8%B0%D9%87+%D8%A7%D9%84%D9%85%D9%88%D8%A7%D9%82%D8%B9+%D9%85%D9%88%D9%87%D8%A8%D8%AA%D9%87%D8%A7+%D9%81%D9%8A+%D8%A7%D9%84%D8%AA%D9%85%D8%AB%D9%8A%D9%84.+%D9%85%D8%B9+%D9%85%D8%B9%D9%84%D9%88%D9%85%D8%A7%D8%AA+%D8%B9%D9%86+%D8%B3%D9%8A%D8%B1%D8%AA%D9%87%D9%85+%D8%A7%D9%84%D8%B0%D8%A7%D8%AA%D9%8A%D8%A9%D8%8C+%D9%85%D8%B9%D8%B1%D8%B6+%D8%B5%D9%88%D8%B1+%D9%81%D9%88%D8%AA%D9%88%D8%BA%D8%B1%D8%A7%D9%81%D9%8A%D8%A9%D8%8C+%D9%88%D8%A7%D9%84%D8%A3%D9%85%D8%AB%D9%84%D8%A9+%D9%88%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88+%D9%88%D8%A7%D9%84%D9%85%D8%B4%D8%A7%D8%B1%D9%8A%D8%B9+%D8%A7%D9%84%D8%AD%D8%A7%D9%84%D9%8A%D8%A9+%D9%84%D9%85%D8%B4%D8%AC%D8%B9%D9%8A%D9%87+%D9%88%D8%A7%D9%84%D9%85%D9%86%D8%AA%D8%AC%D9%8A%D9%86+%D8%A7%D9%84%D9%85%D8%B9%D9%86%D9%8A%D9%8A%D9%86+%28%D9%81%D9%8A+%D8%A7%D9%84%D8%A7%D9%86%D9%83%D9%84%D9%8A%D8%B2%D9%8A%D8%A9+%D9%88%D8%A7%D9%84%D8%A3%D9%84%D9%85%D8%A7%D9%86%D9%8A%D8%A9+%D9%88%D8%A7%D9%84%D8%AF%D9%86%D9%85%D8%A7%D8%B1%D9%83%D9%8A%D8%A9+%D9%88%D8%A7%D9%84%D9%81%D9%86%D9%84%D9%86%D8%AF%D9%8A%D8%A9+%D9%82%D8%B1%D9%8A%D8%A8%D8%A7%29.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - مشهد", "2011-07-31", "0000-00-00"),
("7", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Kati+Rausch+-+Actress%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.katirausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A219%3A%22%3Cp%3EKati+Rausch+presents+her+acting+talent+on+these+web+pages.+With+information+about+her+Vita%2C+a+photo+gallery%2C+video+samples%2C+and+current+projects+for+her+fans+and+interested+producers+%28in+German%2C+English%2C+Danish%29.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - Actress", "2011-07-31", "0000-00-00"),
("7", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Kati+Rausch+-+Schauspiel%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.katirausch.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A563%3A%22%3Cp%3E%E0%A4%87%E0%A4%B8+%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%AA%E0%A4%B0+Kati+%E2%80%8B%E2%80%8BRausch+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%85%E0%A4%AD%E0%A4%BF%E0%A4%A8%E0%A4%AF+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A4%E0%A4%BF%E0%A4%AD%E0%A4%BE+%E0%A4%B9%E0%A5%88.+%E0%A4%89%E0%A4%A8%E0%A4%95%E0%A5%87+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B6%E0%A4%82%E0%A4%B8%E0%A4%95%E0%A5%8B%E0%A4%82+%E0%A4%94%E0%A4%B0+%E0%A4%B0%E0%A5%81%E0%A4%9A%E0%A4%BF+%E0%A4%89%E0%A4%A4%E0%A5%8D%E0%A4%AA%E0%A4%BE%E0%A4%A6%E0%A4%95%E0%A5%8B%E0%A4%82+%28%E0%A4%85%E0%A4%82%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%9C%E0%A5%80%2C+%E0%A4%A1%E0%A5%87%E0%A4%A8%E0%A4%AE%E0%A4%BE%E0%A4%B0%E0%A5%8D%E0%A4%95+%E0%A4%94%E0%A4%B0+%E0%A4%AB%E0%A4%BF%E0%A4%A8%E0%A4%B2%E0%A5%88%E0%A4%82%E0%A4%A1+%E0%A4%9C%E0%A4%B2%E0%A5%8D%E0%A4%A6+%E0%A4%B9%E0%A5%80+%E0%A4%9C%E0%A4%B0%E0%A5%8D%E0%A4%AE%E0%A4%A8+%E0%A4%AE%E0%A5%87%E0%A4%82%29+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+CV%2C+%E0%A4%8F%E0%A4%95+%E0%A4%AB%E0%A5%8B%E0%A4%9F%E0%A5%8B+%E0%A4%97%E0%A5%88%E0%A4%B2%E0%A4%B0%E0%A5%80%2C+%E0%A4%B5%E0%A5%80%E0%A4%A1%E0%A4%BF%E0%A4%AF%E0%A5%8B+%E0%A4%89%E0%A4%A6%E0%A4%BE%E0%A4%B9%E0%A4%B0%E0%A4%A3+%E0%A4%94%E0%A4%B0+%E0%A4%AE%E0%A5%8C%E0%A4%9C%E0%A5%82%E0%A4%A6%E0%A4%BE+%E0%A4%AA%E0%A4%B0%E0%A4%BF%E0%A4%AF%E0%A5%8B%E0%A4%9C%E0%A4%A8%E0%A4%BE%E0%A4%93%E0%A4%82+%E0%A4%95%E0%A5%87+%E0%A4%AC%E0%A4%BE%E0%A4%B0%E0%A5%87+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%9C%E0%A4%BE%E0%A4%A8%E0%A4%95%E0%A4%BE%E0%A4%B0%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5.%3C%2Fp%3E%22%3B%7D", "", "97", "1", "Kati Rausch - Schauspiel", "2011-07-31", "0000-00-00"),
("7", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A34%3A%22Bitte+geben+Sie+eine+Nachricht+an.%22%3B%7D", "", "9", "1", "Bitte geben Sie eine Nachricht an.", "2012-01-29", "0000-00-00"),
("7", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A23%3A%22Please+enter+a+message.%22%3B%7D", "", "9", "1", "Please enter a message.", "2012-01-29", "0000-00-00"),
("7", "47", "0", "", "", "99", "1", "", "2014-06-03", "0000-00-00"),
("7", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A16%3A%22Upmeier-Beratung%22%3Bs%3A3%3A%22Www%22%3Bs%3A23%3A%22www.upmeier-beratung.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A206%3A%22%3Cp%3EFrau+Upmeier+praktiziert+Systemische+Beratung%2C+L%C3%B6sungsorientiert+und+im+Kontext+wichtiger+Bezugspersonen+in+Ilmenau.%3Cbr+%2F%3E%0D%0AGestaltung%3A+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.verb.de%2F%5C%22+title%3D%5C%22www.Verb.de%5C%22%3Everb%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Upmeier-Beratung", "2014-06-03", "0000-00-00"),
("8", "31", "0", "", "", "13", "0", "", "2010-11-30", "0000-00-00"),
("8", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Corinna+Ott%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.corinnaott.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A251%3A%22%3Cp%3ECorinna+Ott+unterst%C3%BCtzt+mit+Ihrem+B%C3%BCro%C2%ADservice+unter+Anderem+Kleinunternehmer+und+Existenzgr%C3%BCnder+mit+moderner+Tech%C2%ADnik%2C+ihrer+Erfahrungen+und+geschultem+Wissen+in+folgenden+Bereiche%3A+Buch%C2%ADhaltung%2C+B%C3%BCroorganisation%2C+L%C3%B6hne+und+Geh%C3%A4lter.%3C%2Fp%3E%22%3B%7D", "", "13", "0", "Corinna Ott", "2010-11-30", "0000-00-00"),
("8", "31", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Corinna+Ott%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.corinnaott.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A245%3A%22%3Cp%3ECorinna+Ott+unterst%C3%BCtzt+mit+Ihrem+B%C3%BCroservice+unter+Anderem+Kleinunternehmer+und+Existenzgr%C3%BCnder+mit+moderner+Technik%2C+ihrer+Erfahrungen+und+geschultem+Wissen+in+folgenden+Bereiche%3A+Buchhaltung%2C+B%C3%BCroorganisation%2C+L%C3%B6hne+und+Geh%C3%A4lter.%3C%2Fp%3E%22%3B%7D", "", "13", "0", "Corinna Ott", "2010-11-30", "0000-00-00");

-- # Schnipp --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("8", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Corinna+Ott%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.corinnaott.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A187%3A%22%3Cp%3ECorinna+Ott+supports+you+with+her+virtual+office+with+modern+technology%2C+her+experience+and+trained+knowledge+in+following+areas%3A+accounting%2C+office+management%2C+wages+and+salaries.%3C%2Fp%3E%22%3B%7D", "", "13", "0", "Corinna Ott", "2010-11-30", "0000-00-00"),
("8", "31", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Corinna+Ott%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.corinnaott.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A559%3A%22%3Cp%3E%E0%A4%B2%E0%A5%87%E0%A4%96%E0%A4%BE%E0%A4%82%E0%A4%95%E0%A4%A8%2C+%E0%A4%95%E0%A4%BE%E0%A4%B0%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%B2%E0%A4%AF+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B6%E0%A4%BE%E0%A4%B8%E0%A4%A8%2C+%E0%A4%AE%E0%A4%9C%E0%A4%A6%E0%A5%82%E0%A4%B0%E0%A5%80+%E0%A4%94%E0%A4%B0+%E0%A4%B5%E0%A5%87%E0%A4%A4%E0%A4%A8%3A+%E0%A4%85%E0%A4%A8%E0%A5%8D%E0%A4%AF+%E0%A4%9B%E0%A5%8B%E0%A4%9F%E0%A5%87+%E0%A4%B5%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%AA%E0%A4%BE%E0%A4%B0+%E0%A4%AE%E0%A4%BE%E0%A4%B2%E0%A4%BF%E0%A4%95%E0%A5%8B%E0%A4%82+%E0%A4%94%E0%A4%B0+%E0%A4%A8%E0%A4%BF%E0%A4%AE%E0%A5%8D%E0%A4%A8%E0%A4%B2%E0%A4%BF%E0%A4%96%E0%A4%BF%E0%A4%A4+%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A5%87%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A5%8B%E0%A4%82+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B6%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%BF%E0%A4%A4+%E0%A4%86%E0%A4%A7%E0%A5%81%E0%A4%A8%E0%A4%BF%E0%A4%95+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A5%8C%E0%A4%A6%E0%A5%8D%E0%A4%AF%E0%A5%8B%E0%A4%97%E0%A4%BF%E0%A4%95%E0%A5%80%2C+%E0%A4%89%E0%A4%A8%E0%A4%95%E0%A5%87+%E0%A4%85%E0%A4%A8%E0%A5%81%E0%A4%AD%E0%A4%B5+%E0%A4%94%E0%A4%B0+%E0%A4%9C%E0%A5%8D%E0%A4%9E%E0%A4%BE%E0%A4%A8+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5+%E0%A4%89%E0%A4%A6%E0%A5%8D%E0%A4%AF%E0%A4%AE%E0%A4%BF%E0%A4%AF%E0%A5%8B%E0%A4%82+%E0%A4%95%E0%A5%87+%E0%A4%AC%E0%A5%80%E0%A4%9A+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%87+%E0%A4%B8%E0%A4%9A%E0%A4%BF%E0%A4%B5%E0%A5%80%E0%A4%AF+%E0%A4%B8%E0%A5%87%E0%A4%B5%E0%A4%BE%E0%A4%8F%E0%A4%82%2C+%E0%A4%B8%E0%A4%BE%E0%A4%A5+Corinna+Ott+%E0%A4%B8%E0%A4%AE%E0%A4%B0%E0%A5%8D%E0%A4%A5%E0%A4%A8.%3C%2Fp%3E%22%3B%7D", "", "13", "0", "Corinna Ott", "2010-11-30", "0000-00-00"),
("8", "33", "0", "", "", "99", "1", "", "2010-11-24", "0000-00-00"),
("8", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Bremer+Literanauten%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.literanauten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A165%3A%22%3Cp%3EDie+Bremer+Literanauten+sind+eine+Gruppe+schreibfreudiger+Bremer+die+sich+weiterentwickeln+m%C3%B6chten+und+Lesungen+veranstalten%2C+um+ihre+Werke+zu+pr%C3%A4sentieren.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Bremer Literanauten", "2010-11-24", "0000-00-00"),
("8", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Bremer+Literanauten%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.literanauten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A161%3A%22%3Cp%3E%D9%88Literanauten+%D8%A8%D8%B1%D9%8A%D9%85%D8%B1+%D9%83%D8%AA%D8%A7%D8%A8%D8%A9+%D8%A7%D9%84%D9%82%D8%B5%D8%B5+%D8%A7%D9%84%D9%82%D8%B5%D9%8A%D8%B1%D8%A9%D8%8C+%D9%88%D8%A7%D9%84%D9%85%D8%B4%D8%A7%D8%B1%D9%83%D8%A9+%D9%81%D9%8A+%D8%A7%D9%84%D9%85%D8%B3%D8%A7%D8%A8%D9%82%D8%A7%D8%AA+%D9%88%D8%AA%D9%86%D8%B8%D9%8A%D9%85+%D8%A7%D9%84%D9%82%D8%B1%D8%A7%D8%A1%D8%A7%D8%AA+%D9%85%D8%B9+%D9%82%D8%B5%D8%B5%D9%87%D9%85.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Bremer Literanauten", "2010-11-24", "0000-00-00"),
("8", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Bremer+Literanauten%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.literanauten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A132%3A%22%3Cp%3EThe+Bremer+Literanauten+are+a+group+of+writers+who+want+to+develop+their+skills+and+organize+lectures+to+present+their+works.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Bremer Literanauten", "2010-11-24", "0000-00-00"),
("8", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Bremer+Literanauten%22%3Bs%3A3%3A%22Www%22%3Bs%3A19%3A%22www.literanauten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A347%3A%22%3Cp%3E%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%AE%E0%A5%87%E0%A4%A8+Literanauten+%E0%A4%B9%E0%A4%B0%E0%A5%8D%E0%A4%B7%E0%A4%BF%E0%A4%A4+%E0%A4%AC%E0%A5%8D%E0%A4%B0%E0%A5%87%E0%A4%AE%E0%A4%B0+%E0%A4%B2%E0%A4%BF%E0%A4%96%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%8F%E0%A4%95+%E0%A4%B8%E0%A4%AE%E0%A5%82%E0%A4%B9+%E0%A4%95%E0%A5%8B+%E0%A4%B5%E0%A4%BF%E0%A4%95%E0%A4%B8%E0%A4%BF%E0%A4%A4+%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A5%87+%E0%A4%94%E0%A4%B0+%E0%A4%89%E0%A4%A8%E0%A4%95%E0%A5%87+%E0%A4%95%E0%A4%BE%E0%A4%B0%E0%A5%8D%E0%A4%AF%E0%A5%8B%E0%A4%82+%E0%A4%95%E0%A4%BE+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A6%E0%A4%B0%E0%A5%8D%E0%A4%B6%E0%A4%A8+%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%B0%E0%A5%80%E0%A4%A1%E0%A4%BF%E0%A4%82%E0%A4%97+%E0%A4%95%E0%A4%BE+%E0%A4%86%E0%A4%AF%E0%A5%8B%E0%A4%9C%E0%A4%A8+%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A4%BE+%E0%A4%9A%E0%A4%BE%E0%A4%B9%E0%A4%A4%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Bremer Literanauten", "2010-11-24", "0000-00-00"),
("8", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A47%3A%22Vielen+Dank%2C+die+Nachricht+ist+versandt+worden.%22%3B%7D", "", "10", "1", "Vielen Dank, die Nachricht ist versandt worden.", "2012-01-29", "0000-00-00"),
("8", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A37%3A%22Thank+you.+The+Message+has+been+send.%22%3B%7D", "", "10", "1", "Thank you. The Message has been send.", "2012-01-29", "0000-00-00"),
("8", "47", "0", "", "", "99", "1", "", "2014-06-10", "0000-00-00"),
("8", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22Circularis+Coaching%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.circularis-coaching.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A265%3A%22%3Cp%3ECoaching+ist+ein+Prozess.+Und+Frau+Arndt-Dinkel+arbeitet+mit+Ihren+Kunden+an+L%C3%B6sungen+und+M%C3%B6glichkeiten%2C+einzeln+und+in+Gruppen%2C+aber+immer+mit+Blick+auf+die+Gesamtsituation.%3Cbr+%2F%3E%0D%0AGestaltung%3A+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.verb.de%2F%5C%22+title%3D%5C%22www.Verb.de%5C%22%3Everb%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Circularis Coaching", "2014-06-10", "0000-00-00"),
("9", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A44%3A%22Bitte+f%C3%BCllen+Sie+die+folgendewn+Felder+aus%3A%22%3B%7D", "", "20", "1", "Bitte füllen Sie die folgendewn Felder aus:", "2012-01-29", "0000-00-00"),
("9", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A33%3A%22Please+fill+the+following+fields%3A%22%3B%7D", "", "20", "1", "Please fill the following fields:", "2012-01-29", "0000-00-00"),
("9", "47", "0", "", "", "99", "1", "", "2012-11-05", "0000-00-00"),
("9", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Winnie+Abraham%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.winnie-abraham.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A161%3A%22%3Cp%3EIndividuelle+Beratung+und+Paarberatung.%3Cbr+%2F%3E%0D%0ADie+Gestaltung+der+Webseite+stammt+von+der+Werbeagentur+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.verb.de%2F%5C%22%3Everb%3C%2Fa%3E+in+Berlin.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Winnie Abraham", "2012-11-05", "0000-00-00"),
("10", "12", "0", "", "", "3", "1", "", "2010-12-09", "0000-00-00"),
("10", "12", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A230%3A%22%3Cp%3EPetra+Jaudszus+malt+Portraits+nach+Fotovorlage%2C+entwirft+individuelle+Wandgestaltungen+und+setzt+Ihr+Unternehmen+mit+Flyer-+und+Drucksachengestaltung+in+Szene.+Die+Gestaltung+beruht+auf+den+Entw%C3%BCrfen+der+Grafikerin+selbst.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Petra Jaudszus", "2010-12-09", "0000-00-00"),
("10", "12", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A291%3A%22%3Cp%3E%D8%AC%D9%88%D8%AF%D8%B3%D8%B2%D9%88%D8%B3+%D8%A7%D9%84%D8%A3%D8%B1%D8%AF%D9%86%D9%8A%D8%A9+%28%D8%A8%D8%AA%D8%B1%D8%A7%29+%D9%8A%D8%B1%D8%B3%D9%85+%D8%B5%D9%88%D8%B1+%D8%A8%D8%B9%D8%AF+%D8%B5%D9%88%D8%B1%D8%A9+%D9%88%D9%82%D8%AF+%D8%B5%D9%85%D9%85+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%AC%D8%AF%D8%A7%D8%B1+%D9%85%D8%AE%D8%B5%D8%B5+%D9%88%D9%8A%D8%B6%D8%B9+%D8%B9%D9%85%D9%84%D9%83+%D9%85%D8%B9+%D9%86%D8%B4%D8%B1%D8%A9+%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D9%8A%D8%A9+%D9%88%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D8%B7%D8%A8%D8%A7%D8%B9%D8%A9+%D9%81%D9%8A+%D9%85%D9%83%D8%A7%D9%86+%D8%A7%D9%84%D8%AD%D8%A7%D8%AF%D8%AB.+%D9%88%D9%8A%D8%B3%D8%AA%D9%86%D8%AF+%D8%A7%D9%84%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%AA%D8%B5%D8%A7%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D9%85%D8%B5%D9%85%D9%85+%D9%86%D9%81%D8%B3%D9%87.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Petra Jaudszus", "2010-12-09", "0000-00-00"),
("10", "12", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A14%3A%22Petra+Jaudszus%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.pj-malereiundgrafik.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A119%3A%22%3Cp%3EPetra+Jaudszus+paints+portraits+from+photographs.+She+does+graphic+design+for+flyers%2C+statinaries+and+web+sites.%3C%2Fp%3E%22%3B%7D", "", "3", "1", "Petra Jaudszus", "2010-12-09", "0000-00-00"),
("10", "33", "0", "", "", "99", "1", "", "2010-11-25", "0000-00-00"),
("10", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Mich%C3%A8le+Burluraux%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.michele-burluraux.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A171%3A%22%3Cp%3EMich%C3%A8le+hat+sich+schon+fr%C3%BCh+im+Zeichnen+ge%C3%BCbt+und+sich+autodidaktisch+weiter%C2%ADentwickelt+und+perfektioniert.+Ihre+Werke+zeigt+sie+jetzt+auf+ihrer+neuen+Homepage.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Michèle Burluraux", "2010-11-25", "0000-00-00"),
("10", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Mich%C3%A8le+Burluraux%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.michele-burluraux.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A188%3A%22%3Cp%3E%D9%88%D9%82%D8%AF+%D9%85%D8%A7%D8%B1%D8%B3%D8%AA+Mich%C3%A8le+%D9%81%D9%8A+%D8%A7%D9%84%D8%B1%D8%B3%D9%85+%D9%81%D9%8A+%D9%88%D9%82%D8%AA+%D9%85%D8%A8%D9%83%D8%B1%D8%8C+%D9%88%D8%AA%D8%B9%D9%84%D9%8A%D9%85+%D9%86%D9%81%D8%B3%D9%87+%D9%88%D8%B6%D8%B9%D8%AA+%D9%88%D8%A7%D9%84%D9%83%D9%85%D8%A7%D9%84.+%D9%88%D9%8A%D8%B9%D9%85%D9%84+%D9%84%D9%87%D8%A7+%D8%A7%D9%84%D8%A2%D9%86+%D9%8A%D8%B4%D9%8A%D8%B1+%D8%A5%D9%84%D9%89+%D9%85%D9%86%D8%B2%D9%84%D9%87%D8%A7+%D8%A7%D9%84%D8%AC%D8%AF%D9%8A%D8%AF%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Michèle Burluraux", "2010-11-25", "0000-00-00"),
("10", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Mich%C3%A9le+Burluraux%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.michele-burluraux.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A112%3A%22%3Cp%3EMich%C3%A8le+has+practiced+her+drawing+skills+since+early+age.+She+now+displays+her+works+on+her+new+website.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Michéle Burluraux", "2010-11-25", "0000-00-00"),
("10", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Mich%C3%A8le+Burluraux%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.michele-burluraux.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A314%3A%22%3Cp%3EMich%C3%A8le+%E0%A4%9C%E0%A4%B2%E0%A5%8D%E0%A4%A6%E0%A5%80+%E0%A4%A1%E0%A5%8D%E0%A4%B0%E0%A4%BE%E0%A4%87%E0%A4%82%E0%A4%97+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%85%E0%A4%AD%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%B8+%E0%A4%94%E0%A4%B0+%E0%A4%86%E0%A4%A4%E0%A5%8D%E0%A4%AE+%E0%A4%B8%E0%A4%BF%E0%A4%96%E0%A4%BE%E0%A4%AF%E0%A4%BE+%E0%A4%94%E0%A4%B0+%E0%A4%B8%E0%A4%BF%E0%A4%A6%E0%A5%8D%E0%A4%A7+%E0%A4%B5%E0%A4%BF%E0%A4%95%E0%A4%B8%E0%A4%BF%E0%A4%A4+%E0%A4%95%E0%A4%BF%E0%A4%AF%E0%A4%BE+%E0%A4%97%E0%A4%AF%E0%A4%BE+%E0%A4%B9%E0%A5%88.+%E0%A4%89%E0%A4%B8%E0%A4%95%E0%A5%87+%E0%A4%95%E0%A4%BE%E0%A4%AE+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%85%E0%A4%AC+%E0%A4%89%E0%A4%A8%E0%A4%95%E0%A5%80+%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%AA%E0%A4%B0+%E0%A4%A6%E0%A4%BF%E0%A4%96+%E0%A4%B0%E0%A4%B9%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Michèle Burluraux", "2010-11-25", "0000-00-00"),
("10", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A39%3A%22Die+Seite+konnte+nicht+gefunden+werden.%22%3B%7D", "", "404", "1", "Die Seite konnte nicht gefunden werden.", "2012-01-29", "0000-00-00"),
("10", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A28%3A%22The+page+could+not+be+found.%22%3B%7D", "", "404", "1", "The page could not be found.", "2012-01-29", "0000-00-00"),
("10", "47", "0", "", "", "99", "1", "", "2016-05-21", "0000-00-00"),
("10", "47", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22Krisen+und+Chancen%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.krisen-und-chancen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A359%3A%22%3Cp%3EMenschen+verf%C3%BCgen+%C3%BCber+Sch%C3%A4tze+und+Kr%C3%A4fte%2C+die+uns+nicht+immer+zug%C3%A4nglich+sind.+Sie+gemeinsam+mit+dem+Patienten%2FKunden+ans+Licht+zu+bringen%2C+ist+Frau+Weidewisch+Aufgabe.%3Cbr+%2F%3E%0D%0ASchwerpunkte+von+Beate+Weidewitsch+sind+Krisenbew%C3%A4ltigung%2C+Traumaheilung%2C+Familientherapie.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EGestaltung+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.grafik-ko.de%5C%22%3EGrafik+%26amp%3B+Ko%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Krisen und Chancen", "2016-05-21", "0000-00-00"),
("11", "33", "0", "", "", "99", "1", "", "2011-07-07", "0000-00-00"),
("11", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Naturfotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.thomasbirkhahn.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A112%3A%22%3Cp%3EThomas+Birkhahn+pr%C3%A4sentiert+auf+seiner+neuen+Webseite+Naturaufnahmen+aus+dem+Bereich+der+Makrofotografie%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Naturfotografie", "2011-07-07", "0000-00-00"),
("11", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A25%3A%22%D8%B7%D8%A8%D9%8A%D8%B9%D8%A9+%D8%A7%D9%84%D8%AA%D8%B5%D9%88%D9%8A%D8%B1%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.thomasbirkhahn.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A160%3A%22%3Cp%3EThomas+Birkhahn+%26%23160%3B%D9%88%D9%8A%D8%B9%D8%B1%D8%B6+%D9%85%D9%88%D9%82%D8%B9%D9%87%D8%A7+%D8%A7%D9%84%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A+%D8%A7%D9%84%D8%AC%D8%AF%D9%8A%D8%AF+%D9%81%D9%8A+%D9%85%D8%AC%D8%A7%D9%84+%D8%A7%D9%84%D8%AA%D8%B5%D9%88%D9%8A%D8%B1+%D8%A7%D9%84%D9%81%D9%88%D8%AA%D9%88%D8%BA%D8%B1%D8%A7%D9%81%D9%8A+%D8%B7%D8%A8%D9%8A%D8%B9%D8%A9+%D8%A7%D9%84%D9%83%D9%84%D9%8A%3C%2Fp%3E%22%3B%7D", "", "99", "1", "طبيعة التصوير", "2011-07-07", "0000-00-00"),
("11", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Naturfotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.thomasbirkhahn.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A100%3A%22%3Cp%3EThomas+Birkhahn+presents+nature+shots+from+the+field+of+macro+photography+on+his+new+website.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Naturfotografie", "2011-07-07", "0000-00-00"),
("11", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Naturfotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.thomasbirkhahn.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A211%3A%22%3Cp%3EThomas+Birkhahn+%E0%A4%B8%E0%A5%8D%E0%A4%A5%E0%A5%82%E0%A4%B2+%E0%A4%AB%E0%A5%8B%E0%A4%9F%E0%A5%8B%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A4%BE%E0%A4%AB%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A5%87%E0%A4%A4%E0%A5%8D%E0%A4%B0+%E0%A4%B8%E0%A5%87+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%95%E0%A5%83%E0%A4%A4%E0%A4%BF+%E0%A4%B6%E0%A5%89%E0%A4%9F%E0%A5%8D%E0%A4%B8+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%B8%E0%A5%8D%E0%A4%A4%E0%A5%81%E0%A4%A4.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Naturfotografie", "2011-07-07", "0000-00-00"),
("12", "31", "0", "", "", "10", "0", "", "2010-11-26", "0000-00-00"),
("12", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A35%3A%22Holtmann+Solar-+und+Heizungssysteme%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.holtmann-solarsysteme.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A307%3A%22%3Cp%3EMit+Kompetenz+und+den+technisch+hochwertigen+Komponenten+ist+J%C3%BCrgen+Holtmann+in+der+Lage+den+Wunsch+nach+mehr+Unabh%C3%A4ngigkeit+von+Gas+und+%C3%96l+in+die+Tat+umzusetzen.+Auf+seiner+Webseite+gibt+es+zudem+Informationen+zu+F%C3%B6rderm%C3%B6glichkeiten+und+Bespiele+von+abgeschlossenen+Projekten+in+den+Referenzen.%3C%2Fp%3E%22%3B%7D", "", "10", "0", "Holtmann Solar- und Heizungssysteme", "2010-11-26", "0000-00-00"),
("12", "31", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A35%3A%22Holtmann+Solar-+und+Heizungssysteme%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.holtmann-solarsysteme.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A326%3A%22%3Cp%3EMit+Kompetenz+und+den+technisch+hochwertigen+Komponenten+ist+J%C3%BCrgen+Holtmann+in+der+Lage+den+Wunsch+nach+mehr+Unabh%C3%A4ngigkeit+von+Gas+und+%C3%96l+in+die+Tat+umzusetzen.++++++++++++++++++++Auf+seiner+Webseite+gibt+es+zudem+Informationen+zu+F%C3%B6rderm%C3%B6glichkeiten+und+Bespiele+von+abgeschlossenen+Projekten+in+den+Referenzen.%3C%2Fp%3E%22%3B%7D", "", "10", "0", "Holtmann Solar- und Heizungssysteme", "2010-11-26", "0000-00-00"),
("12", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A35%3A%22Holtmann+Solar-+und+Heizungssysteme%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.holtmann-solarsysteme.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A235%3A%22%3Cp%3EWith+competence+and+the+high-quality+components%2C+J%C3%BCrgen+Holtmann+is+able+to+implement+more+independence+from+gas+and+oil.+On+his+website%2C+you%5C%27ll+find+information+about+funding+opportunities%2C+and+examples+of+completed+projects.%3C%2Fp%3E%22%3B%7D", "", "10", "0", "Holtmann Solar- und Heizungssysteme", "2010-11-26", "0000-00-00"),
("12", "31", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A35%3A%22Holtmann+Solar-+und+Heizungssysteme%22%3Bs%3A3%3A%22Www%22%3Bs%3A28%3A%22www.holtmann-solarsysteme.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A624%3A%22%3Cp%3E%E0%A4%B5%E0%A4%BF%E0%A4%B6%E0%A5%87%E0%A4%B7%E0%A4%9C%E0%A5%8D%E0%A4%9E%E0%A4%A4%E0%A4%BE+%E0%A4%94%E0%A4%B0+%E0%A4%A4%E0%A4%95%E0%A4%A8%E0%A5%80%E0%A4%95%E0%A5%80+%E0%A4%97%E0%A5%81%E0%A4%A3%E0%A4%B5%E0%A4%A4%E0%A5%8D%E0%A4%A4%E0%A4%BE+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5+%E0%A4%98%E0%A4%9F%E0%A4%95%E0%A5%8B%E0%A4%82+J%C3%BCrgen+Holtmann+%E0%A4%95%E0%A4%BE%E0%A4%B0%E0%A5%8D%E0%A4%B0%E0%A4%B5%E0%A4%BE%E0%A4%88+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%A4%E0%A5%87%E0%A4%B2+%E0%A4%94%E0%A4%B0+%E0%A4%97%E0%A5%88%E0%A4%B8+%E0%A4%B8%E0%A5%87+%E0%A4%85%E0%A4%A7%E0%A4%BF%E0%A4%95+%E0%A4%B8%E0%A5%8D%E0%A4%B5%E0%A4%A4%E0%A4%82%E0%A4%A4%E0%A5%8D%E0%A4%B0%E0%A4%A4%E0%A4%BE+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%87%E0%A4%9A%E0%A5%8D%E0%A4%9B%E0%A4%BE+%E0%A4%95%E0%A5%8B+%E0%A4%AC%E0%A4%A6%E0%A4%B2%E0%A4%A8%E0%A5%87+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%B8%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%AE+%E0%A4%B9%E0%A5%88.+%E0%A4%85%E0%A4%AA%E0%A4%A8%E0%A5%80+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%AA%E0%A4%B0+%E0%A4%A7%E0%A4%A8+%E0%A4%95%E0%A5%87+%E0%A4%85%E0%A4%B5%E0%A4%B8%E0%A4%B0%E0%A5%8B%E0%A4%82+%E0%A4%94%E0%A4%B0+%E0%A4%B8%E0%A4%82%E0%A4%A6%E0%A4%B0%E0%A5%8D%E0%A4%AD+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AA%E0%A5%82%E0%A4%B0%E0%A5%80+%E0%A4%95%E0%A5%80+%E0%A4%97%E0%A4%88+%E0%A4%AA%E0%A4%B0%E0%A4%BF%E0%A4%AF%E0%A5%8B%E0%A4%9C%E0%A4%A8%E0%A4%BE%E0%A4%93%E0%A4%82+%E0%A4%95%E0%A5%87+%E0%A4%89%E0%A4%A6%E0%A4%BE%E0%A4%B9%E0%A4%B0%E0%A4%A3+%E0%A4%95%E0%A5%87+%E0%A4%AC%E0%A4%BE%E0%A4%B0%E0%A5%87+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%9C%E0%A4%BE%E0%A4%A8%E0%A4%95%E0%A4%BE%E0%A4%B0%E0%A5%80+%E0%A4%AD%E0%A5%80+%E0%A4%A8%E0%A4%B9%E0%A5%80%E0%A4%82+%E0%A4%B9%E0%A5%88.%3Cbr+%2F%3E%0D%0A%3C%2Fp%3E%22%3B%7D", "", "10", "0", "Holtmann Solar- und Heizungssysteme", "2010-11-26", "0000-00-00"),
("12", "33", "0", "", "", "99", "0", "", "2010-11-25", "0000-00-00"),
("12", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22Sonny+Delight+-+Fotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.sonnysi.de%2Flight%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A174%3A%22%3Cp%3EBremen%2C+Hellas%2C+St%C3%A4dte%2C+L%C3%A4nder%2C+Architektur+und+Struktur%2C+Makrofotografie+und+Natur%2C+Bizarres+und+Morbides+-+Sonnys+fotogra%C2%ADfische+Palette+ist+%C3%BCppig+und+wandelbar.%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Sonny Delight - Fotografie", "2010-11-25", "0000-00-00"),
("12", "33", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Sonny+Delight+-+%D8%AA%D8%B5%D9%88%D9%8A%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.sonnysi.de%2Flight%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A311%3A%22%3Cp%3E%D9%81%D9%8A%D8%B1%D8%AF%D8%B1+%D8%A8%D8%B1%D9%8A%D9%85%D9%86%D8%8C+%D9%87%D9%8A%D9%84%D8%A7%D8%B3%D8%8C+%D9%88%D8%A7%D9%84%D9%85%D8%AF%D9%86%D8%8C+%D9%88%D8%A7%D9%84%D8%AF%D9%88%D9%84%D8%8C+%D9%88%D8%A7%D9%84%D9%87%D9%86%D8%AF%D8%B3%D8%A9+%D8%A7%D9%84%D9%85%D8%B9%D9%85%D8%A7%D8%B1%D9%8A%D8%A9+%D9%88%D8%A8%D9%86%D9%8A%D8%A9+%D9%88%D8%B7%D8%A8%D9%8A%D8%B9%D8%A9+%D9%88%D8%A7%D9%84%D9%85%D8%A7%D9%83%D8%B1%D9%88+%D9%88%D8%A7%D9%84%D8%AA%D8%B5%D9%88%D9%8A%D8%B1+%D8%A7%D9%84%D9%81%D9%88%D8%AA%D9%88%D8%BA%D8%B1%D8%A7%D9%81%D9%8A%D8%8C+%D8%BA%D8%B1%D9%8A%D8%A8%D8%A9+%D9%88%D8%A7%D9%84%D9%85%D9%87%D9%88%D9%88%D8%B3%D9%8A%D9%86+-+%D9%84%D9%88%D8%AD%D8%A9+Sonny+%D8%A7%D9%84%D9%81%D9%88%D8%AA%D9%88%D8%BA%D8%B1%D8%A7%D9%81%D9%8A%D8%A9+%D8%BA%D9%86%D9%8A%D8%A9+%D9%88%D9%82%D8%A7%D8%A8%D9%84%D8%A9+%D9%84%D9%84%D8%AA%D8%BA%D9%8A%D9%8A%D8%B1%3Cbr+%2F%3E%0D%0A%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Sonny Delight - تصوي", "2010-11-25", "0000-00-00"),
("12", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22Sonny+Delight+-+Fotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.sonnysi.de%2Flight%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A176%3A%22%3Cp%3EBremen%2C+Hellas%2C+cities%2C+countries%2C+architecture+and+structure%2C+macro+photography+and+nature%2C+bizarre+and+morbid+-+Sonny%5C%27s+photographic+portfolio+is+rich+and+changeable.%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Sonny Delight - Fotografie", "2010-11-25", "0000-00-00"),
("12", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A26%3A%22Sonny+Delight+-+Fotografie%22%3Bs%3A3%3A%22Www%22%3Bs%3A20%3A%22www.sonnysi.de%2Flight%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A304%3A%22%3Cp%3E%E0%A4%B6%E0%A4%B9%E0%A4%B0%E0%A5%8B%E0%A4%82%2C+%E0%A4%A6%E0%A5%87%E0%A4%B6%E0%A5%8B%E0%A4%82%2C+%E0%A4%B5%E0%A4%BE%E0%A4%B8%E0%A5%8D%E0%A4%A4%E0%A5%81%E0%A4%95%E0%A4%B2%E0%A4%BE+%E0%A4%94%E0%A4%B0+%E0%A4%B8%E0%A4%82%E0%A4%B0%E0%A4%9A%E0%A4%A8%E0%A4%BE%2C+%E0%A4%AE%E0%A5%88%E0%A4%95%E0%A5%8D%E0%A4%B0%E0%A5%8B+%E0%A4%94%E0%A4%B0+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%95%E0%A5%83%E0%A4%A4%E0%A4%BF+%E0%A4%AB%E0%A5%8B%E0%A4%9F%E0%A5%8B%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A4%BE%E0%A4%AB%E0%A5%80%2C+%E0%A4%B5%E0%A4%BF%E0%A4%9A%E0%A4%BF%E0%A4%A4%E0%A5%8D%E0%A4%B0+%E0%A4%94%E0%A4%B0+%E0%A4%B0%E0%A5%81%E0%A4%97%E0%A5%8D%E0%A4%A3+-+Sonny+%E0%A4%AB%E0%A5%8B%E0%A4%9F%E0%A5%8B+%E0%A4%AA%E0%A5%88%E0%A4%B2%E0%A5%87%E0%A4%9F+%E0%A4%85%E0%A4%AE%E0%A5%80%E0%A4%B0+%E0%A4%94%E0%A4%B0+%E0%A4%85%E0%A4%B8%E0%A5%8D%E0%A4%A5%E0%A4%BF%E0%A4%B0+%E0%A4%B9%E0%A5%88.%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Sonny Delight - Fotografie", "2010-11-25", "0000-00-00"),
("15", "12", "0", "", "", "1", "1", "", "2010-12-09", "0000-00-00"),
("15", "12", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22Grafik+%26+%5BKo%5D%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.grafik-ko.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A195%3A%22%3Cp%3EWerbung%2C+Grafik%2C+Grafik-Design%2C+alle+grafischen+Arbeiten+sind+Schwerpunkt+der+kreativen+Arbeit+in+der+Werbeagentur+Grafik+%26amp%3B+Ko+in+Kirchhatten.+Die+Gestaltung+stammt+von+Gerje+Kollmann.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Grafik & [Ko]", "2010-12-09", "0000-00-00"),
("15", "12", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Grafik+%26+Ko%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.grafik-ko.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A293%3A%22%3Cp%3E%D8%A7%D9%84%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D8%8C+%D8%B7%D8%A8%D8%A7%D8%B9%D8%A9%D8%8C+%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D8%A7%D9%84%D8%B1%D8%B3%D9%88%D9%85%D8%A7%D8%AA%D8%8C+%D9%83%D9%84+%D8%B9%D9%85%D9%84+%D8%B1%D8%B3%D9%88%D9%85%D9%8A%D8%A9+%D8%B3%D9%88%D9%81+%D8%AA%D8%B1%D9%83%D8%B2+%D8%B9%D9%84%D9%89+%D8%A7%D9%84%D8%B9%D9%85%D9%84+%D8%A7%D9%84%D8%A5%D8%A8%D8%AF%D8%A7%D8%B9%D9%8A+%D9%81%D9%8A+%D9%88%D9%83%D8%A7%D9%84%D8%A9+%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D8%A7%D8%AA+%3Cspan+class%3D%22pre%22%3EGrafik+%26amp%3B+Ko%3C%2Fspan%3E+%D9%81%D9%8A+%D9%83%D9%8A%D8%B1%D9%83%D9%87%D8%A7%D8%AA%D9%8A%D9%86.+%D9%88%D9%8A%D8%A3%D8%AA%D9%8A+%D8%A7%D9%84%D8%AA%D8%B5%D9%85%D9%8A%D9%85+%D9%85%D9%86+%D8%AC%D9%8A%D8%B1%D9%8A+%D9%83%D9%88%D9%84%D9%85%D8%A7%D9%86.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Grafik & Ko", "2010-12-09", "0000-00-00"),
("15", "12", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A13%3A%22Grafik+%26+%5BKo%5D%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.grafik-ko.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A204%3A%22%3Cp%3EAdvertising%2C+graphic+design%2C+graphic+design%2C+all+graphic+works+are+the+focus+of+creative+work+in+the+advertising+agency+Graphik+%26amp%3B+Ko+in+Kirchhatten.+The+design+was+made+by+from+Gertje+Kollmann.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Grafik & [Ko]", "2010-12-09", "0000-00-00"),
("15", "33", "0", "", "", "99", "1", "", "2013-05-14", "0000-00-00"),
("15", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A35%3A%22Geige%2C+Bratsche+und+Cello+in+Bremen%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.geige-cello-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A258%3A%22%3Cp%3EHella+Klu%C3%9Fmeyer+%28Geigen-+und+Bratschenlehrerin%29+und+Thomas+Birkhahn+%28Cellolehrer%29+bieten%26nbsp%3Bqualifiziertem+Unterricht.+Die+neu+Homepage+nutzt+das+Redaktionssystem+M-CMS+und+basiert+auf+der+Gestaltung+der+vorherigen+Version+-+nur+etwas+aufgefrischt.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Geige, Bratsche und Cello in Bremen", "2013-05-14", "0000-00-00"),
("15", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A35%3A%22Geige%2C+Bratsche+und+Cello+in+Bremen%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.geige-cello-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A304%3A%22%3Cp%3EHella+Klu%C3%9Fmeyer+%28violin+and+viola+teacher%29+and+Thomas+Birkhahn+%28teacher+of+the+cello%29+offer+qualified+instruction.+The+new+homepage+uses+the+content+management+system+%3Ca+href%3D%5C%22%23LINKTO%3A107%23%5C%22+title%3D%5C%22Service+-+M-CMS%5C%22%3EM-CMS%3C%2Fa%3E+and+is+based+on+the+design+of+the+previous+version+-+just+refreshed.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Geige, Bratsche und Cello in Bremen", "2013-05-14", "0000-00-00"),
("15", "33", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A18%3A%22geige-cello-bremen%22%3Bs%3A3%3A%22Www%22%3Bs%3A25%3A%22www.geige-cello-bremen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A578%3A%22%3Cp%3EHella+Klu%C3%9Fmeyer+%28%E0%A4%B5%E0%A4%BE%E0%A4%AF%E0%A4%B2%E0%A4%BF%E0%A4%A8+%E0%A4%94%E0%A4%B0+%E0%A4%89%E0%A4%B2%E0%A5%8D%E0%A4%B2%E0%A4%82%E0%A4%98%E0%A4%A8+%E0%A4%B6%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%95%29+%E0%A4%94%E0%A4%B0+Thomas+Birkhahn+%28%E0%A4%B5%E0%A4%BE%E0%A4%AF%E0%A4%B2%E0%A4%A8%E0%A4%9A%E0%A5%87%E0%A4%B2%E0%A5%8B+%E0%A4%B6%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%95%29+%E0%A4%AF%E0%A5%8B%E0%A4%97%E0%A5%8D%E0%A4%AF+%E0%A4%B6%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%BE+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A6%E0%A4%BE%E0%A4%A8+%E0%A4%95%E0%A4%B0%E0%A4%A4%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82.+%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%8F%E0%A4%AE+%E0%A4%B8%E0%A5%80%E0%A4%8F%E0%A4%AE%E0%A4%8F%E0%A4%B8+%E0%A4%B8%E0%A4%BE%E0%A4%AE%E0%A4%97%E0%A5%8D%E0%A4%B0%E0%A5%80+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%AC%E0%A4%82%E0%A4%A7%E0%A4%A8+%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A3%E0%A4%BE%E0%A4%B2%E0%A5%80+%E0%A4%95%E0%A4%BE+%E0%A4%89%E0%A4%AA%E0%A4%AF%E0%A5%8B%E0%A4%97+%E0%A4%95%E0%A4%B0%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88+%E0%A4%94%E0%A4%B0+%E0%A4%AA%E0%A4%BF%E0%A4%9B%E0%A4%B2%E0%A5%87+%E0%A4%B8%E0%A4%82%E0%A4%B8%E0%A5%8D%E0%A4%95%E0%A4%B0%E0%A4%A3+%E0%A4%95%E0%A5%87+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%AA%E0%A4%B0+%E0%A4%86%E0%A4%A7%E0%A4%BE%E0%A4%B0%E0%A4%BF%E0%A4%A4+%E0%A4%B9%E0%A5%88+-+%E0%A4%B8%E0%A4%BF%E0%A4%B0%E0%A5%8D%E0%A4%AB+%E0%A4%8F%E0%A4%95+%E0%A4%9B%E0%A5%8B%E0%A4%9F%E0%A5%87+%E0%A4%B8%E0%A5%87+%E0%A4%A8%E0%A4%B5%E0%A4%B8%E0%A4%BF%E0%A4%96%E0%A5%81%E0%A4%86.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "geige-cello-bremen", "2013-05-14", "0000-00-00"),
("16", "12", "0", "", "", "7", "0", "", "2010-12-09", "0000-00-00"),
("16", "12", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A6%3A%22Amarok%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.amarok.ch%2Fhome%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A228%3A%22%3Cp%3EIn+der+Schweiz+arbeite+ich+mit+Amarok+zusammen.+Bei+Amarok+steht+bei+der+ganzheitliche+Beratungsansatz+im+Vordergrund.+In+enger+Zusammenarbeit+mit+den+Kunden+entwickelt+man+dort+wegweisende+Ideen+und+innovative+L%C3%B6sungen.%3C%2Fp%3E%22%3B%7D", "", "7", "0", "Amarok", "2010-12-09", "0000-00-00"),
("16", "12", "2", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A6%3A%22Amarok%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.amarok.ch%2Fhome%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A289%3A%22%3Cp%3E%D8%A3%D9%86%D8%A7+%D8%A3%D8%B9%D9%85%D9%84+%D9%81%D9%8A+%D8%B3%D9%88%D9%8A%D8%B3%D8%B1%D8%A7%D8%8C+%D8%AC%D9%86%D8%A8%D8%A7+%D8%A5%D9%84%D9%89+%D8%AC%D9%86%D8%A8+%D9%85%D8%B9+Amarok.+%D8%B9%D9%86%D8%AF%D9%85%D8%A7+%D9%8A%D9%83%D9%88%D9%86+Amarok+%D9%86%D9%87%D8%AC+%D8%A7%EF%BB%BB%D8%B3%D8%AA%D8%B4%D8%A7%D8%B1%D9%8A%D8%A9+%D9%83%D9%84%D9%8A+%D9%81%D9%8A+%D8%A7%D9%84%D9%85%D9%82%D8%AF%D9%85%D8%A9.+%D8%A8%D8%A7%D9%84%D8%AA%D8%B9%D8%A7%D9%88%D9%86+%D8%A7%D9%84%D9%88%D8%AB%D9%8A%D9%82+%D9%85%D8%B9+%D8%A7%D9%84%D8%B9%D9%85%D9%84%D8%A7%D8%A1+%D9%88%D8%B6%D8%B9+%D9%87%D9%86%D8%A7%D9%83+%D8%A7%D9%84%D8%A3%D9%81%D9%83%D8%A7%D8%B1+%D8%A7%D9%84%D8%B1%D8%A7%D8%A6%D8%AF%D8%A9+%D9%88%D8%A7%D9%84%D8%AD%D9%84%D9%88%D9%84+%D8%A7%D9%84%D9%85%D8%A8%D8%AA%D9%83%D8%B1%D8%A9.%3C%2Fp%3E%22%3B%7D", "", "7", "0", "Amarok", "2010-12-09", "0000-00-00");

-- # Schnipp --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("16", "12", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A6%3A%22Amarok%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.amarok.ch%2Fhome%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A206%3A%22%3Cp%3EIn+Switzerland%2C+I+work+with+Amarok.+At+Amarok+the+holistic+approach+to+consulting+stands+in+the+foreground.+In+close+cooperation+with+customers+they+develop+pioneering+ideas+and+innovative+solutions.%3C%2Fp%3E%22%3B%7D", "", "7", "0", "Amarok", "2010-12-09", "0000-00-00"),
("17", "12", "0", "", "", "2", "1", "", "2014-01-24", "0000-00-00"),
("17", "12", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Edelzeichen%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.edelzeichen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A207%3A%22%3Cp%3EEdelzeichen+steht+f%C3%BCr+klare%2C+direkte+Gestaltung%2C%3Cbr+%2F%3E%0D%0Awenig+worte+%E2%80%93+grosse+wirkung%21%3Cbr+%2F%3E%0D%0AVon+Entwicklung+der+Corporate+Identity+%C3%BCber+Gestaltung+der+Produkte+bis+zu+Organisation+der+Produktion.%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Edelzeichen", "2014-01-24", "0000-00-00"),
("17", "12", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A11%3A%22Edelzeichen%22%3Bs%3A3%3A%22Www%22%3Bs%3A18%3A%22www.edelzeichen.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A84%3A%22%3Cp%3EEdelzeichen+stands+for+clear+direct+designs%2C%3Cbr+%2F%3E%0D%0Afew+words+%E2%80%93+big+impact%21%3C%2Fp%3E%22%3B%7D", "", "2", "1", "Edelzeichen", "2014-01-24", "0000-00-00"),
("17", "33", "0", "", "", "99", "1", "", "2013-11-08", "0000-00-00"),
("17", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Brennholzverlei%22%3Bs%3A3%3A%22Www%22%3Bs%3A23%3A%22www.brennholzverleih.eu%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A1953%3A%22%3Cp%3E%3Cspan+_mstdst%3D%5C%220_0%3A3%5C%22+_mstsrc%3D%5C%220_0%3A3%5C%22+id%3D%5C%22Dst%5B0%5D%5B0%3A3%3A0%3A3%5D%5C%22+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3EA+very%3C%2Fspan%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3E+%3C%2Fspan%3E%3Cspan+_mstdst%3D%5C%220_5%3A8%5C%22+_mstsrc%3D%5C%220_5%3A9%5C%22+id%3D%5C%22Dst%5B0%5D%5B5%3A9%3A5%3A8%5D%5C%22+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3Enice%3C%2Fspan%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3E+%3C%2Fspan%3E%3Cspan+_mstdst%3D%5C%220_10%3A14%5C%22+_mstsrc%3D%5C%220_11%3A16%5C%22+id%3D%5C%22Dst%5B0%5D%5B11%3A16%3A10%3A14%5D%5C%22+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3Eangle%3C%2Fspan%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3E%2C%3C%2Fspan%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3E+brennholzverleih%3A+%3C%2Fspan%3E%3Cspan+_mstdst%3D%5C%220_22%3A36%5C%22+_mstsrc%3D%5C%220_25%3A39%5C%22+id%3D%5C%22Dst%5B0%5D%5B25%3A39%3A22%3A36%5D%5C%22+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3Ereggae%2Fska+%3C%2Fspan%3E%3Cspan+_mstdst%3D%5C%220_38%3A41%5C%22+_mstsrc%3D%5C%220_41%3A43%5C%22+id%3D%5C%22Dst%5B0%5D%5B41%3A43%3A38%3A41%5D%5C%22+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3Efrom%3C%2Fspan%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3E+%3C%2Fspan%3E%3Cspan+_mstdst%3D%5C%220_43%3A48%5C%22+_mstsrc%3D%5C%220_45%3A50%5C%22+id%3D%5C%22Dst%5B0%5D%5B45%3A50%3A43%3A48%5D%5C%22+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3EBremen%3C%2Fspan%3E%3Cspan+style%3D%5C%22color%3A+rgb%280%2C+0%2C+0%29%3B+font-family%3A+Arial%3B+font-size%3A+12px%3B+line-height%3A+normal%3B+white-space%3A+pre-wrap%3B%5C%22%3E.%3C%2Fspan%3E%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Brennholzverlei", "2013-11-08", "0000-00-00"),
("17", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A15%3A%22Brennholzverlei%22%3Bs%3A3%3A%22Www%22%3Bs%3A23%3A%22www.brennholzverleih.eu%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A61%3A%22%3Cp%3EGanz+sch%C3%B6n+schr%C3%A4g%2C+diese+Reggae%2FSka-Band+aus+Bremen.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Brennholzverlei", "2013-11-08", "0000-00-00"),
("18", "12", "0", "", "", "4", "1", "", "2016-03-04", "0000-00-00"),
("18", "12", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A10%3A%22CodingArts%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22https%3A%2F%2Fcodingarts.eu%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A151%3A%22%3Cp%3ECodingArts+bietet+einen+einmalig+g%C3%BCnstigen+und+schnellen+Service+f%C3%BCr+Unternehmen+jeder+Art%2C+Selbstst%C3%A4ndige%2C+K%C3%BCnstler+oder+Privatpersonen+an.%3C%2Fp%3E%22%3B%7D", "", "4", "1", "CodingArts", "2016-03-04", "0000-00-00"),
("18", "33", "0", "", "", "99", "1", "", "2014-02-09", "0000-00-00"),
("18", "33", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22die+galerie+im+Heuerhaus%22%3Bs%3A3%3A%22Www%22%3Bs%3A33%3A%22http%3A%2F%2Fwww.galerie-doetlingen.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A294%3A%22%3Cp%3EDie+Galerie+in+D%C3%B6tlingen+steht+unter+neuer+Leitung+und+pr%C3%A4sentiert+sich+mit+neuer+Gestaltung+im+Internet.+Anne+Hollmann+und+Gertje+Kollmann+pr%C3%A4sentieren+Kunstwerke+zeitgen%C3%B6ssischer+Maler%2C+Skulpturen+und+Zeichnungen.+Gestaltung%3A+%3Ca+href%3D%5C%22%23LINKTO%3A12%23%23Grafik_Ko%5C%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "99", "1", "die galerie im Heuerhaus", "2014-02-09", "0000-00-00"),
("18", "33", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22die+galerie+im+Heuerhaus%22%3Bs%3A3%3A%22Www%22%3Bs%3A33%3A%22http%3A%2F%2Fwww.galerie-doetlingen.de%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A294%3A%22%3Cp%3EDie+Galerie+in+D%C3%B6tlingen+steht+unter+neuer+Leitung+und+pr%C3%A4sentiert+sich+mit+neuer+Gestaltung+im+Internet.+Anne+Hollmann+und+Gertje+Kollmann+pr%C3%A4sentieren+Kunstwerke+zeitgen%C3%B6ssischer+Maler%2C+Skulpturen+und+Zeichnungen.+Gestaltung%3A+%3Ca+href%3D%5C%22%23LINKTO%3A12%23%23Grafik_Ko%5C%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "99", "1", "die galerie im Heuerhaus", "2014-02-09", "0000-00-00"),
("22", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A9%3A%22Bis+bald.%22%3B%7D", "", "100", "1", "Bis bald.", "2012-01-29", "0000-00-00"),
("22", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A4%3A%22Bye.%22%3B%7D", "", "100", "1", "Bye.", "2012-01-29", "0000-00-00"),
("23", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A23%3A%22Das+hat+nicht+geklappt.%22%3B%7D", "", "102", "1", "Das hat nicht geklappt.", "2012-01-29", "0000-00-00"),
("23", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A33%3A%22Sorry+we+didn%5C%27t+find+your+login.%22%3B%7D", "", "102", "1", "Sorry we didn't find your login.", "2012-01-29", "0000-00-00"),
("24", "31", "0", "", "", "1", "1", "", "2013-08-23", "0000-00-00"),
("24", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A8%3A%22Sar-Mini%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.sar-mini.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A280%3A%22%3Cp%3ESAR-Mini+ist+ein+GPS-Tracker%2C+der+helfen+soll+zum+Beispiel+Fahrr%C3%A4der+nach+einem+Diebstahl+wiederzufinden%2C+oder+eine+uner%C2%ADlaubte+Bewegung+zu+melden.+Au%C3%9Ferdem+%C3%BCbermittelt+das+Ger%C3%A4t+Daten%2C+um+zum+Beispiel+live+Positionsdaten+zum+Beispiel+bei+einem+Wettrennen+auszuwerten.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Sar-Mini", "2013-08-23", "0000-00-00"),
("24", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A8%3A%22Sar-Mini%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.sar-mini.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A196%3A%22%3Cp%3ESAR-Mini+is+a+GPS-Tracker%2C+supposed+to+help+find+a+stolen+bike%2C+or+detect+movement+of+propperty+during+theft.+Apart+from+that+it+can+be+used+to+track+positions+during+a+race+or+on+holidays.%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Sar-Mini", "2013-08-23", "0000-00-00"),
("24", "31", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A8%3A%22Sar-Mini%22%3Bs%3A3%3A%22Www%22%3Bs%3A16%3A%22www.sar-mini.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A680%3A%22%3Cp%3E%E0%A4%8F%E0%A4%B8%E0%A4%8F%E0%A4%86%E0%A4%B0+%E0%A4%8F%E0%A4%95+%E0%A4%9A%E0%A5%8B%E0%A4%B0%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%AC%E0%A4%BE%E0%A4%A6+%E0%A4%89%E0%A4%A6%E0%A4%BE%E0%A4%B9%E0%A4%B0%E0%A4%A3+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F%2C+%E0%A4%AC%E0%A4%BE%E0%A4%87%E0%A4%95+%E0%A4%89%E0%A4%AC%E0%A4%B0%E0%A4%A8%E0%A5%87+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AE%E0%A4%A6%E0%A4%A6+%E0%A4%95%E0%A4%B0%E0%A5%87%E0%A4%82%E0%A4%97%E0%A5%87%2C+%E0%A4%AF%E0%A4%BE+%E0%A4%8F%E0%A4%95+%E0%A4%85%E0%A4%A8%E0%A4%BE%E0%A4%A7%E0%A4%BF%E0%A4%95%E0%A5%83%E0%A4%A4+%E0%A4%86%E0%A4%82%E0%A4%A6%E0%A5%8B%E0%A4%B2%E0%A4%A8+%E0%A4%B0%E0%A4%BF%E0%A4%AA%E0%A5%8B%E0%A4%B0%E0%A5%8D%E0%A4%9F+%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%95%E0%A4%BF+%E0%A4%8F%E0%A4%95+%E0%A4%AE%E0%A4%BF%E0%A4%A8%E0%A5%80+%E0%A4%9C%E0%A5%80%E0%A4%AA%E0%A5%80%E0%A4%8F%E0%A4%B8+%E0%A4%9F%E0%A5%8D%E0%A4%B0%E0%A5%88%E0%A4%95%E0%A4%B0+%E0%A4%B9%E0%A5%88.+%E0%A4%87%E0%A4%B8%E0%A4%95%E0%A5%87+%E0%A4%85%E0%A4%B2%E0%A4%BE%E0%A4%B5%E0%A4%BE%2C+%E0%A4%87%E0%A4%B8+%E0%A4%89%E0%A4%AA%E0%A4%95%E0%A4%B0%E0%A4%A3+%E0%A4%95%E0%A4%BE+%E0%A4%AE%E0%A5%82%E0%A4%B2%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%82%E0%A4%95%E0%A4%A8%2C+%E0%A4%89%E0%A4%A6%E0%A4%BE%E0%A4%B9%E0%A4%B0%E0%A4%A3+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F%2C+%E0%A4%B8%E0%A5%8D%E0%A4%A5%E0%A4%BF%E0%A4%A4%E0%A4%BF+%E0%A4%A1%E0%A5%87%E0%A4%9F%E0%A4%BE%2C+%E0%A4%89%E0%A4%A6%E0%A4%BE%E0%A4%B9%E0%A4%B0%E0%A4%A3+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F%2C+%E0%A4%8F%E0%A4%95+%E0%A4%A6%E0%A5%8C%E0%A4%A1%E0%A4%BC+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%B0%E0%A4%B9%E0%A4%A8%E0%A5%87+%E0%A4%95%E0%A5%87+%E0%A4%B2%E0%A4%BF%E0%A4%8F+%E0%A4%A1%E0%A5%87%E0%A4%9F%E0%A4%BE+%E0%A4%B8%E0%A5%8D%E0%A4%A5%E0%A4%BE%E0%A4%A8%E0%A4%BE%E0%A4%82%E0%A4%A4%E0%A4%B0%E0%A4%BF%E0%A4%A4+%E0%A4%95%E0%A4%B0%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88.%3Cbr+%2F%3E%0D%0A%3C%2Fp%3E%22%3B%7D", "", "1", "1", "Sar-Mini", "2013-08-23", "0000-00-00"),
("24", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A23%3A%22Das+hat+nicht+geklappt.%22%3B%7D", "", "103", "1", "Das hat nicht geklappt.", "2012-01-29", "0000-00-00"),
("24", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A31%3A%22Your+login+is+not+active+%28yet%29.%22%3B%7D", "", "103", "1", "Your login is not active (yet).", "2012-01-29", "0000-00-00"),
("25", "31", "0", "", "", "99", "1", "", "2013-10-08", "0000-00-00"),
("25", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Graupner+Mode+%26+Style%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.pelze-graupner.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A219%3A%22%3Cp%3EBei+GRAUPNER+Mode+%26amp%3B+Style+-+direkt+in+der+Bremer+City+-+finden+Sie+Edles+aus+Pelz%2C+Leder%2C+Lammfell+und+Cashmere.+Die+Gestaltung+der+Webseite+stammt+von+%3Ca+href%3D%5C%22%23LINKTO%3A12%23%23Grafik_Ko%5C%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Graupner Mode & Style", "2013-10-08", "0000-00-00"),
("25", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Graupner+Mode+%26+Style%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.pelze-graupner.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A193%3A%22%3Cp%3EAt+GRAUPNER+Mode+%26amp%3B+Style+-+dirctly+in+the+Bremer+City+-+You%5C%27ll+find+finest+fur%2C+leather%2C+shearling+and+cashmere.+Design+by+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.grafik-ko.de%5C%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Graupner Mode & Style", "2013-10-08", "0000-00-00"),
("25", "31", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A21%3A%22Graupner+Mode+%26+Style%22%3Bs%3A3%3A%22Www%22%3Bs%3A21%3A%22www.pelze-graupner.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A292%3A%22%3Cp%3EGRAUPNER+%E0%A4%AB%E0%A5%88%E0%A4%B6%E0%A4%A8+%E0%A4%94%E0%A4%B0+%E0%A4%B8%E0%A5%8D%E0%A4%9F%E0%A4%BE%E0%A4%87%E0%A4%B2+%E0%A4%AE%E0%A5%87%E0%A4%82%2C+%E0%A4%AB%E0%A4%B0%2C+%E0%A4%9A%E0%A4%AE%E0%A4%A1%E0%A4%BC%E0%A5%87%2C+%E0%A4%AB%E0%A4%B0+%E0%A4%94%E0%A4%B0+%E0%A4%95%E0%A4%B6%E0%A5%8D%E0%A4%AE%E0%A5%80%E0%A4%B0%E0%A5%80+%E0%A4%95%E0%A5%87+%E0%A4%A8%E0%A5%8B%E0%A4%AC%E0%A4%B2+%E0%A4%A6%E0%A5%87%E0%A4%96%E0%A5%87%E0%A4%82.+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%95%E0%A5%87+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8+%E0%A4%B8%E0%A5%87+%E0%A4%86%E0%A4%A4%E0%A4%BE+%E0%A4%B9%E0%A5%88+%3Ca+href%3D%22http%3A%2F%2Fwww.grafik-ko.de%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Graupner Mode & Style", "2013-10-08", "0000-00-00"),
("25", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A38%3A%22Diese+Seite+k%C3%B6nnte+die+gesuchte+sein.%22%3B%7D", "", "301", "1", "Diese Seite könnte die gesuchte sein.", "2012-01-29", "0000-00-00"),
("25", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A45%3A%22I+hope+this+is+the+page+you+were+looking+for.%22%3B%7D", "", "301", "1", "I hope this is the page you were looking for.", "2012-01-29", "0000-00-00"),
("26", "31", "0", "", "", "99", "1", "", "2013-09-09", "0000-00-00"),
("26", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22S%C3%A4gewerk+Neuhatten%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.saegewerk-neuhatten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A227%3A%22%3Cp%3EDas+S%C3%A4gewerk+Neuhatten+kann+auf+eine+lange+Tradition+zur%C3%BCckblicken+und+mit+dem+neuen+Internetauftritt%2C+nach+der+Gestaltung+von+%3Ca+href%3D%5C%22%23LINKTO%3A12%23%23Grafik_Ko%5C%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E%2C+auch+selbstbewusst+in+die+Zukunft.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Sägewerk Neuhatten", "2013-09-09", "0000-00-00"),
("26", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22S%C3%A4gewerk+Neuhatten%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.saegewerk-neuhatten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A185%3A%22%3Cp%3EThe+sawmill+Neuhatten+can+look+back+on+a+long+tradition+and+with+the+new+website+confidently+into+the+future.+Design+by+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.grafik-ko.de%5C%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Sägewerk Neuhatten", "2013-09-09", "0000-00-00"),
("26", "31", "4", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A19%3A%22S%C3%A4gewerk+Neuhatten%22%3Bs%3A3%3A%22Www%22%3Bs%3A26%3A%22www.saegewerk-neuhatten.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A342%3A%22%3Cp%3E%E0%A4%9A%E0%A5%80%E0%A4%B0%E0%A4%98%E0%A4%B0+Neuhatten+%E0%A4%86%E0%A4%A4%E0%A5%8D%E0%A4%AE%E0%A4%B5%E0%A4%BF%E0%A4%B6%E0%A5%8D%E0%A4%B5%E0%A4%BE%E0%A4%B8+%E0%A4%B8%E0%A5%87+%E0%A4%AD%E0%A4%B5%E0%A4%BF%E0%A4%B7%E0%A5%8D%E0%A4%AF+%E0%A4%AE%E0%A5%87%E0%A4%82+%E0%A4%AD%E0%A5%80%2C+%E0%A4%8F%E0%A4%95+%E0%A4%B2%E0%A4%82%E0%A4%AC%E0%A5%80+%E0%A4%AA%E0%A4%B0%E0%A4%82%E0%A4%AA%E0%A4%B0%E0%A4%BE+%E0%A4%AA%E0%A4%B0+%E0%A4%94%E0%A4%B0+%E0%A4%A8%E0%A4%88+%E0%A4%B5%E0%A5%87%E0%A4%AC%E0%A4%B8%E0%A4%BE%E0%A4%87%E0%A4%9F+%E0%A4%95%E0%A5%87+%E0%A4%B8%E0%A4%BE%E0%A4%A5+%E0%A4%B5%E0%A4%BE%E0%A4%AA%E0%A4%B8+%E0%A4%95%E0%A4%B0+%E0%A4%B8%E0%A4%95%E0%A4%A4%E0%A5%87+%E0%A4%B9%E0%A5%88%E0%A4%82.+%E0%A4%A1%E0%A4%BF%E0%A4%9C%E0%A4%BE%E0%A4%87%E0%A4%A8%3A+%3Ca+href%3D%22http%3A%2F%2Fwww.grafik-ko.de%22%3EGrafik+%26amp%3B+%5BKo%5D%3C%2Fa%3E.%3C%21--%3C%2Fp--%3E%0D%0A%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Sägewerk Neuhatten", "2013-09-09", "0000-00-00"),
("26", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A48%3A%22Bitte+keinen+Code+ins+Nachrichtenfeld+schreiben.%22%3B%7D", "", "11", "1", "Bitte keinen Code ins Nachrichtenfeld schreiben.", "2012-10-22", "0000-00-00"),
("26", "46", "3", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A38%3A%22Please+din%5C%27tuse+code+in+message+area.%22%3B%7D", "", "11", "1", "Please din'tuse code in message area.", "2012-10-22", "0000-00-00"),
("27", "31", "0", "", "", "99", "1", "", "2013-12-04", "0000-00-00"),
("27", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A39%3A%22Tietje+Zinn%2C+Maurer+und+Betonbaumeister%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.tietjezinn.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A251%3A%22%3Cp%3EMit+Erfahrung+im+Bauwesen+und+unterst%C3%BCtzt+von+qualifizierten+Mitarbeitern+erledigt+Tietje+Zinn+Mauer%2C+Stuck-+und+Fliesenarbeiten+nach+dem+neusten+stand+der+Technik.+Gestaltung%3A+Karsten+Elze%2C+%3Ca+href%3D%5C%22%23LINKTO%3A12%23%23Edelzeichen%5C%22%3EEdelzeichen%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Tietje Zinn, Maurer und Betonbaumeister", "2013-12-04", "0000-00-00"),
("27", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A38%3A%22Tietje+Zinn%2C+Maler+und+Betonbaumeister%22%3Bs%3A3%3A%22Www%22%3Bs%3A17%3A%22www.tietjezinn.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A186%3A%22%3Cp%3EWith+experience+in+the+construction+and+supported+by+qualified+staff+Tietje+Zinn+does+wall%2C+stucco+and+tile+work+to+the+latest+state+of+the+art.+Design%3A+Karsten+Elze%2C+Edelzeichen.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Tietje Zinn, Maler und Betonbaumeister", "2013-12-04", "0000-00-00"),
("27", "46", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A56%3A%22Der+angegebene+Stra%C3%9Fenname+enth%C3%A4lt+ung%C3%BCltige+Zeichen.%22%3B%7D", "", "7", "1", "Der angegebene Straßenname enthält ungültige Zeichen.", "2013-02-05", "0000-00-00"),
("28", "31", "0", "", "", "99", "1", "", "2012-01-13", "0000-00-00"),
("28", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A27%3A%22London+Aquarium+Maintenance%22%3Bs%3A3%3A%22Www%22%3Bs%3A34%3A%22www.londonaquariummaintenance.com%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A169%3A%22%3Cp%3EF%C3%BCr+den+Londoner+Aquariums+Service+entstanden+diese+Seiten+nach+der+Gestaltung+von+James+Harrup+%28%3Ca+href%3D%5C%22http%3A%2F%2Fwww.jwh-creative.net%2F%5C%22%3EJWH-creative%3C%2Fa%3E%29%26nbsp%3B%3C%2Fp%3E%22%3B%7D", "", "99", "1", "London Aquarium Maintenance", "2012-01-13", "0000-00-00"),
("28", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A27%3A%22London+Aquarium+Maintenance%22%3Bs%3A3%3A%22Www%22%3Bs%3A34%3A%22www.londonaquariummaintenance.com%2F%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A160%3A%22%3Cp%3EFor+the+London+Aquarium+Service+we+made+these+pages+based+on+the+design+by+James+Harrup+%28%3Ca+href%3D%5C%22http%3A%2F%2Fwww.jwh-creative.net%2F%5C%22%3EJWH-creative%3C%2Fa%3E%29%26nbsp%3B%3C%2Fp%3E%22%3B%7D", "", "99", "1", "London Aquarium Maintenance", "2012-01-13", "0000-00-00"),
("29", "31", "0", "", "", "99", "0", "", "2014-04-10", "0000-00-00"),
("29", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A23%3A%22Velibre+-+Pure+Espresso%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22http%3A%2F%2Fwww.velibre.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A237%3A%22%3Cp%3EVelibre+stellt+Kaffeekapseln+her%2C+hohe+Qualit%C3%A4t%2C+hoher+Anspruch%2C+niedriger+Preis+und+kompatibel+zu+Nespresso%3Csup%3E%C2%AE%3C%2Fsup%3E+Kapseln.+Gestaltung%3A+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.hansindia.com%2F%5C%22+rel%3D%5C%22nofollow%5C%22+target%3D%5C%22_blank%5C%22%3EHansindia%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Velibre - Pure Espresso", "2014-04-10", "0000-00-00"),
("29", "31", "3", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A23%3A%22Velibre+-+Pure+Espresso%22%3Bs%3A3%3A%22Www%22%3Bs%3A22%3A%22http%3A%2F%2Fwww.velibre.com%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A210%3A%22%3Cp%3EVelibre+produces+coffee+capsules%2C+high+quality%2C+low+price+and+compatible+to+Nespresso%3Csup%3E%C2%AE%3C%2Fsup%3E+Capsules.+Design%3A+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.hansindia.com%2F%5C%22+rel%3D%5C%22nofollow%5C%22+target%3D%5C%22_blank%5C%22%3EHansindia%3C%2Fa%3E%3C%2Fp%3E%22%3B%7D", "", "99", "0", "Velibre - Pure Espresso", "2014-04-10", "0000-00-00"),
("30", "31", "0", "", "", "99", "1", "", "2016-05-21", "0000-00-00"),
("30", "31", "1", "a%3A3%3A%7Bs%3A5%3A%22Titel%22%3Bs%3A24%3A%22Elektro-Technik+Kollmann%22%3Bs%3A3%3A%22Www%22%3Bs%3A23%3A%22www.elektro-kollmann.de%22%3Bs%3A16%3A%22Beschreibung_fck%22%3Bs%3A315%3A%22%3Cp%3EElektro-Technik+Kollmann+bietet+Ihnen+fachm%C3%A4nnische+Elektroarbeiten+rund+ums+Geb%C3%A4ude%2C+man+ist+spezialisiert+auf+Geb%C3%A4udetechnik%2C+erledigt+alle+Elektroarbeiten+in+Ihrem+Neubau%2C+saniert+und+wartet+Ihre+Anlagen+diese+professionell.%3C%2Fp%3E%0D%0A%0D%0A%3Cp%3EGestaltung+%3Ca+href%3D%5C%22http%3A%2F%2Fwww.grafik-ko.de%5C%22%3EGrafik+%26amp%3B+Ko%3C%2Fa%3E.%3C%2Fp%3E%22%3B%7D", "", "99", "1", "Elektro-Technik Kollmann", "2016-05-21", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#bilder`;
-- # Schnipp --
CREATE TABLE `#PREFIX#bilder` (
  `BILD_ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `LANG_ID` smallint(5) NOT NULL,
  `PART_ID` varchar(32) NOT NULL DEFAULT '0',
  `Position` smallint(3) NOT NULL DEFAULT '0',
  `Dateiname` varchar(65) NOT NULL DEFAULT '',
  `visibility` int(1) DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`BILD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=282 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=bilder # --
INSERT INTO `#PREFIX#bilder` (`BILD_ID`,`PAGE_ID`,`LANG_ID`,`PART_ID`,`Position`,`Dateiname`,`visibility`,`views`) VALUES
("1", "32", "0", "4", "0", "referenz_bild_lit-exp.jpg", "1", "0"),
("2", "31", "0", "24", "0", "referenz_bild_sar-mini.jpg", "1", "0"),
("3", "32", "0", "1", "0", "referenz_bild_Musikmacher.jpg", "1", "0"),
("4", "31", "0", "12", "0", "referenz_bild_holtmann-solar.jpg", "1", "0"),
("5", "40", "0", "1", "0", "referenz_bild_grafik-ko.jpg", "1", "0"),
("6", "40", "0", "3", "0", "referenz_bild_layoutwebtec.jpg", "1", "0"),
("7", "40", "0", "2", "0", "referenz_bild_sonny.jpg", "1", "0"),
("8", "47", "0", "1", "0", "referenz_bild_gute-koepfe.jpg", "1", "0"),
("9", "47", "0", "2", "0", "referenz_bild_beratung-kirsch.jpg", "1", "0"),
("10", "47", "0", "4", "0", "referenz_bild_cfc.jpg", "1", "0"),
("12", "33", "0", "15", "0", "referenz_bild_geige-cello-bremen.jpg", "1", "0"),
("13", "31", "0", "25", "0", "referenz_bild_graupner.jpg", "1", "0"),
("14", "31", "0", "26", "0", "referenz_bild_saegewerk-neuhatten.jpg", "1", "0"),
("15", "32", "0", "3", "0", "referenz_bild_hochzeits-djs.jpg", "1", "0"),
("17", "31", "0", "27", "0", "referenz_bild_zinn.jpg", "1", "0"),
("18", "31", "0", "28", "0", "referenz_bild_lam.jpg", "1", "0"),
("19", "12", "0", "17", "0", "referenz_bild_edelzeichen.jpg", "1", "0"),
("20", "33", "0", "18", "0", "referenz_bild_heuerhaus.jpg", "1", "0"),
("21", "33", "0", "8", "0", "referenz_bild_literanauten.jpg", "1", "0"),
("22", "35", "0", "6", "0", "referenz_bild_literanauten.jpg", "1", "0"),
("23", "31", "0", "29", "0", "referenz_bild_velibre.jpg", "1", "0"),
("24", "40", "0", "4", "0", "referenz_bild_edelzeichen.jpg", "1", "0"),
("178", "31", "0", "0", "0", "referenz_bild_doro.jpg", "1", "0"),
("181", "33", "0", "0", "0", "referenz_bild_pj-malereiundgrafik.jpg", "1", "0"),
("182", "33", "0", "1", "0", "referenz_bild_werderfotos.jpg", "1", "0"),
("184", "32", "0", "6", "0", "referenz_bild_kati_comedy.jpg", "1", "0"),
("185", "34", "0", "0", "0", "referenz_bild_strahlentherapie.jpg", "1", "0"),
("187", "35", "0", "0", "0", "referenz_bild_businesstreffen.jpg", "1", "0"),
("189", "35", "0", "2", "0", "referenz_bild_schokoklub.jpg", "1", "0"),
("191", "35", "0", "4", "0", "referenz_bild_digistoer.jpg", "1", "0"),
("192", "36", "0", "0", "0", "referenz_bild_handzuhand.jpg", "1", "0"),
("196", "38", "0", "0", "0", "referenz_bild_sonnige-geschichten.jpg", "1", "0"),
("197", "38", "0", "1", "0", "referenz_bild_werderfotos.jpg", "1", "0"),
("198", "39", "0", "0", "0", "referenz_bild_marcus-haas.jpg", "1", "0"),
("199", "39", "0", "1", "0", "referenz_bild_wissenschaft.jpg", "1", "0"),
("200", "39", "0", "2", "0", "referenz_bild_fotografie.jpg", "1", "0"),
("201", "39", "0", "3", "0", "referenz_bild_kurzgeschichten.jpg", "1", "0"),
("202", "39", "0", "4", "0", "referenz_bild_tauchen.jpg", "1", "0"),
("203", "39", "0", "5", "0", "referenz_bild_roman.jpg", "1", "0"),
("207", "33", "0", "5", "0", "referenz_bild_kunstraum.jpg", "1", "0"),
("214", "33", "0", "6", "0", "referenz_bild_atv.jpg", "1", "0"),
("216", "34", "0", "5", "0", "referenz_bild_dk-kosmetik.jpg", "1", "0"),
("223", "31", "0", "8", "0", "referenz_bild_corinnaott.jpg", "1", "0"),
("224", "38", "0", "2", "0", "referenz_bild_atv.jpg", "1", "0"),
("227", "36", "0", "2", "0", "referenz_bild_bhavanavihara.jpg", "1", "0"),
("230", "33", "0", "7", "0", "referenz_bild_katirausch.jpg", "1", "0"),
("240", "33", "0", "10", "0", "referenz_bild_michele-burluraux.jpg", "1", "0"),
("241", "31", "0", "16", "0", "referenz_bild_cfc.jpg", "1", "0"),
("242", "32", "0", "2", "0", "referenz_bild_muspromotion.jpg", "1", "0"),
("246", "12", "0", "10", "0", "referenz_bild_pj-malereiundgrafik.jpg", "1", "0"),
("247", "12", "0", "15", "0", "referenz_bild_grafik-ko.jpg", "1", "0"),
("250", "35", "0", "5", "0", "referenz_bild_natuerlich-reisen.jpg", "1", "0"),
("251", "36", "0", "3", "0", "referenz_bild_worpsweder-kunsthalle.jpg", "1", "0"),
("252", "36", "0", "4", "0", "referenz_bild_freunde-worpswedes.jpg", "1", "0"),
("253", "34", "0", "2", "0", "referenz_bild_pries.jpg", "1", "0"),
("254", "34", "0", "3", "0", "referenz_bild_kross.jpg", "1", "0"),
("255", "12", "0", "16", "0", "referenz_bild_amarok.jpg", "1", "0"),
("258", "38", "0", "3", "0", "referenz_bild_katirausch.jpg", "1", "0"),
("260", "33", "0", "11", "0", "referenz_bild_tb_naturfotos.jpg", "1", "0"),
("261", "47", "0", "6", "0", "referenz_bild_engel.jpg", "1", "0"),
("273", "33", "0", "12", "0", "referenz_bild_sonny-delight.jpg", "1", "0"),
("277", "77", "0", "0", "0", "logo_bild_logo.jpg", "1", "0"),
("279", "32", "0", "5", "0", "referenz_bild_mic.jpg", "1", "0"),
("280", "36", "0", "5", "0", "referenz_bild_sub.jpg", "1", "0"),
("281", "34", "0", "4", "0", "referenz_bild_abraham.jpg", "1", "0");
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
  PRIMARY KEY (`DATEI_ID`)
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
  PRIMARY KEY  (`LANG_ID`,`KAT_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=kategorien # --
INSERT INTO `#PREFIX#kategorien` (`KAT_ID`,`LANG_ID`,`Titel`,`Beschreibung`,`position`,`visibility`,`follow`,`status`) VALUES
("1", "0", "Oben", "", "1", "1", "1", "0"),
("2", "0", "Unten", "", "2", "1", "1", "0"),
("3", "0", "sonstige", "", "4", "1", "0", "0"),
("4", "0", "Backlinks", "", "3", "1", "1", "0"),
("5", "0", "Intern", "", "5", "0", "0", "88,99");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#person`;
-- # Schnipp --
CREATE TABLE `#PREFIX#person` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LANG_ID` tinyint(3) NOT NULL,
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
  `kontakt` tinyint(1) DEFAULT '0',
  `impressum` tinyint(1) DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`),
  KEY `Ort` (`Ort`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
-- # Schnipp --

-- # DUMP=person # --
INSERT INTO `#PREFIX#person` (`ID`,`LANG_ID`,`Firma`,`Name`,`Strasse`,`Ort`,`Telefon`,`Fax`,`Mobil`,`Email`,`www`,`Login`,`Passwort`,`anmeldung`,`status`,`kontakt`,`impressum`,`verified`) VALUES
("1", "1", "", "Gast", "", "", "", "", "", "", "", "Gast", "edb45f4dc4c15da029b7ec9ebf149550f6658a19:10000:sha1:9504d6cf3545a82e934cb965934ab4e0f423de7a", "0000-00-00 00:00:00", "88", "0", "0", "1"),
("2", "1", "Webdesign Haas", "Marcus Haas", "Flüggestr. 14", "30161 Hannover", "0421 / 387 13 60", "", "0162 / 95 75 407", "kontakt@webdesign-haas.de", "www.webdesign-haas.de", "marcus", "819fd4bccd50b7aeeab6b3b8984b839b0c0475cd:10000:sha1:e04927391b85c4fb5c528292f6b787b6788b7063", "2007-05-16 07:00:56", "99", "1", "1", "29");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten` (
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `LANG_ID` smallint(5) NOT NULL DEFAULT '0',
  `editor_ID` int(11) NOT NULL,
  `Titel` varchar(128) DEFAULT NULL,
  `Ueberschrift` varchar(255) NOT NULL DEFAULT '',
  `Kurzname` varchar(65) NOT NULL DEFAULT '',
  `Menu` varchar(65) NOT NULL DEFAULT '',
  `AK` varchar(3) NOT NULL,
  `Text` text NOT NULL,
  `Beschreibung` varchar(255) NOT NULL DEFAULT '',
  `insdate` datetime NOT NULL,
  `lastmod` datetime DEFAULT NULL,
  `fix_kn` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`LANG_ID`,`PAGE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("1", "1", "2", "Innovatives und individuelles Webdesign, Gestaltung, Beratung und Umsetzung: Webdesign Haas, Hannover", "Individuelle Gestaltung und professionelles Webdesign aus Hannover", "Home", "Home", "H", "", "Individuelles Webdesign, Grafik, Gestaltung und Service aus Bremen. Jede Homepage mit CMS: bearbeiten Sie Ihre Webseite ganz einfach selbst. Webdesigner aus Hannover. Grafik und Gestaltung von Visitenkarten und Flyer. ", "2010-12-28 00:00:00", "2019-09-23 12:18:02", "0"),
("1", "2", "2", "التشاور الفردية والمهنية تصميم الموقع من بريمن", "التشاور الفردية والمهنية تصميم الموقع من بريمن", "home", "الصفحة الرئيسية", "h", "<h4>مرحبا بك في Webdesign Haas</h4>
<p><span style=\"color:#800000;\">هذه هي الترجمة من Google ، ولاكينّي أتعلم اللغة</span></p>
<p>§FETCHIMAGE:PAGE_ID=12;order=random;avisi=1;aexcl=3,9,16§وماذا عن موقع على شبكة الإنترنت مخصص التي مصممة خصيصا للاحتياجات الخاصة بك. مع تصميم الذي يعكس شخصيتك وما كنت قد حصلت على عرض. موقع على شبكة الإنترنت التي توفر عامل الاعتراف الذي يميز الشخص أو الشركة الخاصة بك من المنافسة.</p>
<h4>الخدمة</h4>
<p>§FETCHIMAGE:PAGE_ID=31;order=random;avisi=1;aexcl=1,18§االخدمة الشخصية، والتشاور، وتصميم وتنفيذ بطبيعة الحال معنا. علينا أن نركز على محادثة أولية مفصلة، تعرف أنت واحتياجات الخاصة بك. فقط حيث يمكن جعل موقع على شبكة الإنترنت، أن يلائم لك أو الشركة الخاصة بك.</p>
<p>§FETCHIMAGE:PAGE_ID=33;order=random;avisi=1;aexcl=5§     للشركات العاملين لحسابهم الخاص والصغيرة أو المتوسطة الحجم معهم نتمتع بجهة الاتصال حتى بعد انتهاء العلاقة التجارية الفعلية والتي نحن فيها وتقديم المشورة، سيركز على صفحات ويب.</p>
<p>وبطبيعة الحال، يمكنك إجراء التغييرات والإضافات على موقع الويب الخاص بك نفسك إذا كنت تريد. ومن السهل مع م-نظام الإدارة الوظيفية، وضعتها Webdesign Haas، نظام إدارة محتوى خالية من العوائق محرك بحث ودية وقابلة للتكيف لتصميم مواقع الإنترنت تقريبا أي.<br />
</p>
<p>§FETCHIMAGE:PAGE_ID=34;order=random;avisi=1;aexcl=1§     <a href=\"#LINKTO:12#\">ونحن نتعاون مع المصممين والوكالات</a> في ألمانيا وسويسرا. (إذا كنت مصمم رسوميات الذي يبحث عن شريك المختصة وموثوقة- <a href=\"#LINKTO:30#\">اتصل بن</a>ا.)</p>
<h4>مراجع</h4>
<p>§FETCHIMAGE:PAGE_ID=38;order=random;avisi=1,3§ألق نظرة على صفحة ويب أوضحنا في أعمالنا <a href=\"#LINKTO:9#\">المراجع</a> .</p>
<h4>جهة الاتصال</h4>
<p>الرجاء استخدام <a href=\"#LINKTO:30#\">نموذج الاتصال</a> للأسئلة والمقترحات أو اتصل بنا: <span class=\"pre\">+49 (421) 387 13 60</span>.</p>", "وماذا عن موقع على شبكة الإنترنت مخصص التي مصممة خصيصا للاحتياجات الخاصة بك. مع تصميم الذي يعكس شخصيتك وما كنت قد حصلت على عرض. موقع على شبكة ا", "2011-09-26 00:00:00", "2012-04-16 10:01:48", "1"),
("1", "3", "2", "Innovative and individual web design", "Innovative and individual web design, consulting and CMS", "Home", "Home", "S", "<h4>Welcome to Webdesign Haas</h4>
<p>Innovative and custom web design from Bremen, Germany. Starting with your wishes and ideas, through consultation and design to the finished website it is important for us to understand what you need and want.</p>
<h4>Service</h4>
<p>§FETCHIMAGE:PAGE_ID=31;order=random;avisi=1;aexcl=1,2,18§ The <strong>personal service</strong> in consulting, design and development is our primary goal. We want to know about you and your business to build a website that fits.</p>
<p>Our focus is on websites for self-employed, small and midsize companies. It's important for us to maintain the relationship even after the website is finished to advise and cooperate.</p>
<p>§FETCHIMAGE:PAGE_ID=33;order=random;avisi=1;aexcl=5,33§ Of course, you can make changes and additions to your website yourself - if you want to. This is easy with <a href=\"#LINKTO:107#\"><strong>M-CMS</strong></a>, the barrier-free content managment system that is search engine friendly and adaptable to almost any web design (including existing pages).</p>
<p>Webdesign Haas offers a <strong>complete package</strong> for your individual appearance in public, from business cards and advertising and stationery to web design.</p>
<h4>Cooperation and Partnership</h4>
<p>§FETCHIMAGE:PAGE_ID=12;order=random;avisi=1;aexcl=1§<a href=\"#LINKTO:12#\">We cooperate with designers and agencies</a> in Germany and Switzerland. (if you are a graphic designer who is looking for a competent and reliable partner - <a href=\"#LINKTO:30#\">contact us</a>.)</p>
<h4>Contact</h4>
<p>§FETCHIMAGE:PAGE_ID=38;order=random;avisi=1;aexcl=1,3§Please use the <a href=\"#LINKTO:30#\">contact form</a> for questions and suggestions or call us: <strong>+49 (421) 387 13 60</strong>.</p>
<h4>References</h4>
<p>Take a look at the webpages we've made at our <a href=\"#LINKTO:9#\"><strong>references</strong></a>.</p>", "Innovative and custom web design from Bremen, Germany. Starting with your wishes and ideas, through consultation and design to the finished website it is important for us to understand what you need and want.", "2011-09-05 00:00:00", "2013-11-08 18:43:00", "0"),
("1", "4", "2", "ब्रेमेन के लिए नवीन और अनुकूलित वेब डिजाइन, डिजा", "ब्रेमेन से व्यक्तिगत डिजाइन और पेशेवर वेब डिजाइन", "home", "घर", "", "<h4>Webdesign Haas में आपका स्वागत है</h4>
<p><span style=\"color:#FF0000;\">अनुवाद माफ करना. इसका Google का</span></p>
<p>कैसे आप और आपके व्यवसाय सूट है कि एक वेबसाइट के बारे में. आप और आपकी चिंताओं को अलग करने वाली मान्यता कारक के लिए प्रदान करता है जो वेबसाइट, व्यापार कार्ड और व्यापार के कागजात, का एक डिजाइन के साथ?</p>
<p>हम स्वरोजगार और अपनी आवश्यकताओं के अनुरूप रहे हैं क्रिएटिव, अन्य बातों के अलावा, कंपनियों के लिए कस्टम डिजाइन वेबसाइट बनाने. साथ रचनात्मक विचारों, परामर्श और अपनी इच्छाओं और इच्छाओं के अनुसार वेब डिजाइन, हम आपको संतुष्ट होना चाहते हैं.</p>
<h4>सेवा</h4>
<p>§FETCHIMAGE:PAGE_ID=31;order=random;avisi=1;aexcl=1,2,18§ परामर्श में व्यक्तिगत सेवा, ग्राफिक्स, डिजाइन और कार्यान्वयन स्वयं स्पष्ट है. हम तुम और अपनी आवश्यकताओं को पता पाने के लिए एक प्रारंभिक मूल्य.</p>
<p>हम व्यापार कार्ड और विज्ञापनों और उड़ता डिजाइन से वेब डिजाइन करने के लिए, जनता में अपनी उपस्थिति के लिए एक सिलवाया दृष्टिकोण के साथ प्रदान करते हैं.</p>
<p>§FETCHIMAGE:PAGE_ID=33;order=random;avisi=1;aexcl=5,33§ बेशक आप नवीनतम समाचार और प्रस्ताव की ओर ध्यान आकर्षित करने के लिए, खुद की वेबसाइट में परिवर्तन और जोड़ कर सकते हैं. एम सीएमएस Webdesign Haas, बाधा मुक्त, उपयोगकर्ता के अनुकूल और खोज इंजन के अनुकूल सामग्री प्रबंधन प्रणाली द्वारा विकसित के साथ यह आसान है.</p>
<h4>सहयोग और भागीदारी</h4>
<p>§FETCHIMAGE:PAGE_ID=12;order=random;avisi=1;aexcl=3,9,16§      हम सहयोग के साथ जो ग्राफिक कलाकार, वेब डिजाइनर और एजेंसियों जर्मनी और स्विट्जरलैंड में आधारित हैं. (आप रचनात्मक और अपने डिजाइनों अनुवाद करने के लिए एक सक्षम और विश्वसनीय साथी की तलाश कर रहे हैं? हमसे संपर्क करें.)</p>
<h4>संपर्क</h4>
<p>§FETCHIMAGE:PAGE_ID=38;order=random;avisi=1;aexcl=1,3§सवालों और सुझावों के लिए हमारे संपर्क फार्म से संपर्क करें या मुझे फोन कृपया: §TELEFON§ (उच्च 3, Schildstr 27, 28203 ब्रेमेन में तीन, मैं व्यक्तिगत रूप से सामना करना पड़ा 14-18 घड़ी कार्यदिवस रहा हूँ.).</p>", "व्यक्तिगत वेब डिजाइन, ब्रेमेन से ग्राफिक डिजाइन और सेवा. आप आसानी से पहले अपनी वेबसाइट पर भी परिव", "2013-10-23 00:00:00", "2013-11-08 18:43:27", "1"),
("1", "5", "2", "不来梅创新和定制的网页设计，设计，咨询和实施", "从不来梅的个性化设计和专业的网页设计", "home", "家", "", "<h4>欢迎光临网页设计Haas公司</h4>
<p><span style=\"color:#FF0000;\">请原谅翻译。这是来自谷歌</span></p>
<p>怎么样一个网站，适合你和你的企业。随着设计的网站，名片和商业文件，它提供的识别因素，区分你和你的关注？</p>
<p>我们创建自定义设计的网站的公司，除其他外，个体户和您的需求量身定做的广告。随着创意的想法，咨询和网页设计，根据您的意愿和欲望，因为我们希望你能满意<br />
</p>
<h4>如何与取得联系</h4>
<p>§FETCHIMAGE:PAGE_ID=31;order=random;avisi=1;aexcl=1,2,18§  <a title=\"Kontakt - für Ihre Anfragen und ...\" href=\"#LINKTO:30#\">联系人窗体</a>可供的问题和建议，或打电话给我: <strong>§TELEFON§</strong> (<a title=\"Die Agentur für Kreativität und Medien in Bremen: Grafik, Gestaltung, Webdesign uvm.\" target=\"_blank\" href=\"http://www.3hoch3.net/\">DREI hoch 3</a>，我上午在平日从 2 下午 6 下午以满足的人).</p>", "个人网页设计，平面设计和服务从不来梅。我们创造的每一个网站内容管理系统，所以你可以很容易地把甚至改变到你的网站之前。我们还提供平面设计和名片和传单", "2013-10-24 00:00:00", "2013-10-25 15:47:37", "1"),
("2", "1", "2", "Service von der ersten Idee, über die Gestaltung,  bis zur fertigen Homepage", "Service bei Beratung, Gestaltung und Programmierung aus Bremen", "Homepage-Service", "Service", "S", "<p>Wir begleiten den Prozess der Entstehung Ihrer Homepage von der ersten Idee über die Gestaltung und die Umsetzung, bis hin zum Anmelden bei den Suchmaschinen (<a href=\"#LINKTO:6#\">SEO</a>) und bieten Ihnen einen Platz im Internet (Registrierung Ihrer Wunschdomain und Hosting), wenn Sie das wünschen.<br />
Und mit dem Redaktionssystem <a href=\"#LINKTO:107#\">M-CMS</a> können Sie Ihre Website selbst pflegen, so bleibt ihre Webseite immer Aktuell und Sie unabhängig.<br />
</p>", "Wir begleiten den Prozess der Entstehung Ihrer Homepage von der ersten Idee über die Gestaltung und die Umsetzung, bis hin zum Anmelden bei Suchmaschinen und Internetkatalogen. Und mit dem Redaktionssystem M-CMS können Sie  Ihre Inhalte selbst pflegen.", "2010-08-04 00:00:00", "2013-01-31 16:46:58", "1"),
("2", "3", "2", "Service from initial concept through design, to finished web site", "Services in consulting, design and programming from Bremen", "Homepage-Service", "Service", "S", "<p>We accompany the process of creating your website from initial idea through the design and implementation, to the Register with search engines and Internet catalogs. And with the M-CMS content management system you can maintain your own content.</p>
<p>§BRIDGE§</p>", "We accompany the process of creating your website from initial idea through the design and implementation, to the Register with search engines and Internet catalogs. And with the M-CMS content management system you can maintain your own content.", "2011-09-08 00:00:00", "2012-03-01 10:43:46", "1"),
("3", "1", "2", "Beratung: Webdesign, Barrierefreiheit, Technik und Optimierung für Suchmaschinen", "Beratung: Webdesign, Barrierefreiheit, Technik und Optimierung für Suchmaschinen", "Beratung", "Beratung", "B", "<p>Gerne stehe ich Ihnen bei Entwurf und Planung Ihrer Internetseite zur Verfügung, sei es was das Webdesign angeht, oder die Unsetzung der Programmierung für Ihrer Internetanwendung.</p>

<h4 id=\"h1\">Webdesign</h4>

<p>Bei der Gestaltung einer Internetseite kommt es darauf an, dass sie die Persönlichkeit des Unternehmens, bzw. des Firmeninhabers widerspiegelt. Deshalb legen wir wert auf ein ausführliches Vorgespräch, um das Unternehmen und die Idee, die dahintersteckt, kennen zu lernen. Nur so kann ein <a href=\"#LINKTO:4#\">Webdesign</a> gelingen, dass mit der Firma in Bezug steht.</p>

<h4 id=\"h2\">Lokal und international</h4>

<p>Ein Unternehmen aus Bremen kann sich im Internet einer breiten öffentlichkeit präsentieren, es tritt damit aber auch in Konkurrenz zu allen anderen Geschäften in diesem Bereich. Deshalb ist es wichtig, nicht in der Masse unterzugehen, sondern durch Qualität und Originalität zu überzeugen.</p>

<p>Aber auch der lokale Bezug ist wichtig, denn die häufigsten Besucher sind zufriedene Kunden, die sich über das Internet über Ihre aktuellen Angebote informieren und den Kontakt halten.</p>

<p>Deshalb ist es auch sinnvoll immer wieder Neuigkeiten und Informationen zu ergänzen und zu aktualisieren, dann kommen die Leute auch wieder und ziehen einen Mehrwert aus ihrem Angebot, das durchaus über die eigentlichen Geschäftsinteressen hinausgehen kann.</p>

<p>Service, Information und der persönliche Kontakt wird von den Kunden geschätzt.</p>

<p>Auch vor der internationalen Konkurrenz müssen wir uns in Bremen nicht verstecken, mit Ihren Seiten präsentieren Sie sich weltweit, stellen sich dem Vergleich und bieten auch Touristen und Gästen die Möglichkeit Informationen zu bekommen, die vielleicht sogar zu einem Besuch in Bremen und in Ihrem Geschäft führen.</p>

<h4 id=\"h3\">Accessibility und Barrierefreiheit</h4>

<p>Ich berate Sie sowohl hinsichtlich des Designs, das immer nutzbar und übersichtlich bleiben muss und bei den Inhalten, für die sich Ihre Besucher ja in erster Linie interessieren und die auch von den Suchmaschinen abgefragt werden.</p>

<p>Barrierefreiheit tritt immer mehr ins Bewusstsein der Internetgemeinde und der Aufwand, den man betreiben muss, um auch Menschen mit Behinderungen das Netz effektiv nutzen zu lassen, ist nicht so groß, wie man annehmen könnte, vorausgesetzt man macht sich schon bei der Konzeption Gedanken darüber.</p>

<p>Aber nicht nur Behinderte profitieren von Barrierefreiheit und Accessibility, die Benutzung wird für jeden Besucher einfacher und übersichtlicher, die Besucher bleiben länger und verlassen Ihre Seiten nicht frustriert von einer komplizierten Benutzerführung. Und vor allem: Sie kommen wieder.</p>

<h4 id=\"h4\">Technik</h4>

<p>Auch bei den technischen Aspekten stehe ich Ihnen mit Rat und Tat zur Seite, wenn Sie einen neuen Provider suchen oder Informationen brauchen, welcher Anbieter ein Paket bietet, das Ihren Ansprüchen am ehesten entspricht.<br />
<a href=\"/praxis/technik/index.shtml\">Vorstellung der Techniken</a></p>

<h4 id=\"h5\">Optimierung</h4>

<p>Man kann eine Webseite hinsichtlich verschiedener Gesichtspunkte optimieren. Geschwindigkeit, Browserkompatibilität und Platzierung in Suchmaschinen.</p>

<p>Die Geschwindigkeit sollte man auch in Zeiten von DSL nicht außer Acht lassen, denn zum Einen besitzt noch nicht jeder DSL, zum Anderen belasten große Seiten auch den Server und das Transfervolumen.</p>

<p>Browserkompatibilität wird oft vernachlässigt, weil bei manchen Webmastern der Eindruck vorherrscht, es gäbe nur einen Browser der zählt (Die ehemals große Rolle des Internet Explorers nimmt ab, aber dafür tauchen neue Mitspieler aus, wie zum Beispiel auf Smartphones oder Tablet-PCs).</p>

<p>Ganz wichtig ist die Suchmaschinenoptimierung hinsichtlich der Suchbegriffe und der Indizierbarkeit, denn diese geben den Ausschlag bei der Platzierung in den Suchmaschine.</p>

<p>Doch das wichtigste sind qualitativ hochwertige Seiten mit gutem Inhalt, dann braucht man keine Tricks, um die Plazierung bei den Suchmaschienen zu verbessern.</p>
", "Webdesign Haas - Beratung und Gestaltung aus Bremen: Beratung hinsichtlich Lokaler und internationaler Wirkung von Webseiten, Barrierefreiheit und Accessibility, verwendeten Techniken und Optimierung für Menschen und Suchroboter", "2009-04-21 00:00:00", "2014-07-20 18:39:21", "0"),
("3", "3", "2", "Consulting: web design, accessibility, technology and optimization for search engines", "Consulting: web design, accessibility, technology and optimization for search engines", "Consulting", "Consulting", "B", "<p>I am happy to help you with designing and planning your website. I'll assist in putting your ideas to the web.</p>

<h4>Web Design&nbsp;</h4>

<p>When designing a website it is important that it reflects the<strong> personality of the company or the company owner</strong>. Therefore we place value on a detailed preliminary consulting to learn about the company and the idea behind it.</p>

<h4>Locally and Internationally&nbsp;</h4>

<p>A company from Bremen on the Internet can present itself to the general public, but it does so in competition with all other shops in this area. Therefore it is important not to drown in the crowd, but to convince by quality and originality.&nbsp;</p>

<p>But the<strong> local reference</strong> is important because the most frequent visitors are satisfied customers who inform others via internet and word of mouth.</p>

<h4>Accessibility&nbsp;</h4>

<p>Accessibility is important. It helps impaired people to access your content and in the same way search engeines profit from accessible content.&nbsp;</p>

<p>But not only disabled people benefit from accessibility, Every body else will <strong>appreciate a simple and clear design</strong>. The visitors stay longer and will not leave your site frustrated by a complicated user interface. And above all, they come back.&nbsp;</p>

<h4>Optimization</h4>

<p>You can optimize a Web site in terms of different aspects. Speed, browser compatibility and search engine placement.&nbsp;</p>

<p>The speed should not be neglected, even in times of DSL. Firstly because not everyone has DSL, and on the other side, you are preserving resources if you try to minimize your <strong>ecological footprint</strong> in CPU-time and kilobytes to transfer. &nbsp;</p>

<p>Search engine optimization is important because these make the difference in the placement in the search engine.&nbsp;But most important is <strong>good content</strong>, then you do not need tricks to improve the placement in the search engines.</p>
", "Consultancy and design from Bremen: advice on local and international impact of websites, Barrier free and accessibility, and optimization techniques used for humans and search robots.", "2011-09-08 00:00:00", "2014-07-20 18:42:33", "0"),
("4", "1", "2", "Webdesign: Gestaltung und Grafik für Ihre Internetseiten mit Kreativität und Know-how", "Webdesign: Entwürfe für Ihre Internetseiten mit Kreativität und Know-how", "Webdesign", "Webdesign", "W", "<p>Design ohne Inhalt ist leer, aber Inhalt ohne Design ist langweilig.<br />
Deshalb werden wir mit Ihnen zusammen eine Internetseite gestalten, die in Ausstrahlung und Funktionalität Ihnen und Ihrem Anliegen entspricht und Ihre Individualität widerspiegelt.</p>
<h4 id=\"h6\">Eindruck</h4>
<p>Der erste Eindruck einer Webseite ist wichtig. Der Besucher muss schon auf den ersten Blick sehen, mit wem er es zu tun hat und was vermittelt werden soll.</p>
<p>Das innovative Webdesign (siehe <a href=\"#LINKTO:9#\">Referenzen</a> und <a href=\"#LINKTO:12#\">Partner</a>) steht deshalb zusammen mit Ihrer Aussage und Ihrem Anliegen im Vordergrund und soll schon auf der ersten Seite den gewünschten Eindruck beim Kunden hinterlassen.</p>
<h4 id=\"h7\">Entwurf</h4>
<p>Unsere Vorschläge entstehen nach einem ausführlichen Vorgespräch, bei dem Wir Sie und Ihr Anliegen kennenlernen. Dann entstehen unsere Vorschläge für Ihre neue Webseite.</p>
<p>Diese Vorlagen entsteht in der Regel in einem Bildbearbeitungs- oder Grafikprogramm und werden, wenn Sie das OK geben sind, für das Internet umgesetzt. So können wir schnell erste Vorschläge präsentieren, Änderungen und Wünsche in das Webdesign einfließen lassen, bis Sie mit unserem Entwurf zufrieden sind.</p>
<p>Selbstverständlich können Sie uns auch Ihre Entwürfe geben (ganz gleich ob Computer-Datei oder Handgezeichnete Skizze), die wir dann umsetzen, oder an denen wir gemeinsam arbeiten.</p>
<h4 id=\"h8\">Kreativität</h4>
<p>Die Zeiten, in denen der Designer, von den Fähigkeiten des Browsers in seiner Kreativität beschränkt wurde, sind vorbei. Es gibt kaum etwas, das sich mit etwas Fantasie nicht umsetzen ließe.</p>
<p>Der Kreativität sind beim Webdesign Ihres Internetauftritts kaum Grenzen gesetzt. Fordern Sie uns heraus!</p>
<h4 id=\"h9\">Corporate Identity</h4>
<p>Selbstverständlich muss sich eine neue Webseite in das bestehende Unternehmen eingliedern und Gestaltungselemente übernehmen, so dass sich ein stimmiges Gesamtbild ergibt, das Ihr Unternehmen widerspiegelt.</p>
<p>Wenn Sie es wünschen, können wir die Corporate Identity für Ihr Unternehmen von der Visitenkarte über den Briefkopf bis hin zum Webdesign gestalten oder bestehende Elemente für Ihre neue Internetpräsenz übernehmen.</p>", "Text allein ist nicht genug. Zu einem gelungenen Webdesign für Ihren Auftritt im Internet gehören auch Fotos, Grafik und eine individuelle Gestaltung. Das Zusammenspiel aller Komponenten macht Ihre Webseite unverwechselbar.", "2010-12-09 00:00:00", "2012-05-17 09:50:06", "0"),
("4", "3", "2", "Web Design: Designs for your web pages with creativity and know-how", "Web Design: Designs for your web pages with creativity and know-how", "Web_Design", "Web Design", "W", "<p>Design without content is empty, but design without content, is boring.<br />
Therefore, we will work with you to make a website that reflects you and your company in appearance and functionality</p>

<h4 id=\"h6\">Impression</h4>

<p>The first impression of a website is important. The visitor needs to see at first glance, who stand behind the site and what is his intention.</p>

<h4 id=\"h7\">Design</h4>

<p>When designing your website we like to try something new.</p>

<p>The template for our new web site usually arises in an image-processing or graphics program and is put to HTML after your approval.<br />
That way we can quickly present initial proposals, amendments and requests can be incorporated into the web design until you are satisfied with our design.</p>

<p>Of course you can also give us your designs, which we then implement, or where we work together.</p>

<h4 id=\"h8\">Creativity</h4>

<p>The times in which the designer has been limited by browser limitations in their creativity, are finally over, thanks to CSS. There is hardly anything that could not be implemented with a little imagination.</p>

<p>The creativity in web design of your web site is virtually unlimited. Challenge us!</p>

<h4 id=\"h9\">Corporate Identity</h4>

<p>Of course, a new website must integrate into the existing business and design elements in a way that a coherent overall picture is created that reflects your business.</p>

<p>If you wish, we can design the corporate identity for your company from business cards to letterhead through to web design or take over existing elements for your new website.</p>
", "Design without content is empty, but design without content, is boring.
Therefore, we will work with you to make a website that reflects you and your company in appearance and functionality ", "2011-09-08 00:00:00", "2014-07-21 16:49:49", "0"),
("5", "1", "2", "Service - Programmierung: Layout, Programmierung und Optimierung mit Liebe zum Detail und individuellen Lösungen", "Programmierung: Layout, Programmierung und Optimierung mit Liebe zum Detail und individuellen Lösungen.", "Programmierung", "Programmierung", "P", "<p>Bei der Umsetzung der gemeinsam erarbeiteten Vorlagen lege ich Wert auf Handarbeit und individuelle Lösungen.</p>
<h4 id=\"h10\">Standards</h4>
<p>Ich programmiere gemäß den Standards, die vom W3C vorgegeben werden und erweitere den Code anschließend, um die Besonderheiten von bestimmten Browsern zu berücksichtigen. So gewährleiste ich, dass die Seiten sowohl in aktuellen als auch alten und zukünftigen Browsern dargestellt und genutzt werden können.</p>
<h4 id=\"h11\">Layout</h4>
<p>Zwei Aspekte stehen bei der Webseitenerstellung im Vordergrund.</p>
<p>Zum Einen muss die Seite übersichtlich bleiben und der Besucher soll sich leicht und schnell zurechtfinden, ohne lange nach Navigationselementen oder Inhalten suchen zu müssen.</p>
<p>Zum anderen soll auch der Quelltext der Seite leicht zu lesen sein, so dass Sie - sollten Sie das wünschen - selbst Änderungen vornehmen können, ohne Angst zu haben, dass Ihnen das Layout um die Ohren fliegt. Dazu gehört auch, dass ich Layout, Inhalt und Funktionalität soweit möglich voneinander trenne, so dass sich bei kleineren Änderungen im Aussehen nur eine Datei ändert und nicht das ganze Projekt neu erstellt werden muss.</p>
<h4 id=\"h12\">Techniken</h4>
<p>Für die Programmierung von statischen Seiten setze ich auf <a href=\"/praxis/technik/xhtml.shtml\">XHTML</a>. Diese Erweiterung der Hypertext Markup Language (HTML) erlaubt es leicht, browserübergreifend zu programmieren ohne für alle (genau genommen einige ältere) Browserversionen unterschiedliche Seiten zu erstellen, da dem Browser gleich zu Anfang gesagt wird, dass er standardkonform arbeiten soll.</p>
<p>Das führt auch dazu, dass die Seiten schneller angezeigt werden können, weil sich die Browser nicht die Mühe machen müssen erst festzustellen, was der Programmierer eigentlich gemeint haben könnte.</p>
<p>Dynamische Anwendungen erstelle ich mit der Scriptsprache PHP und der kostenlosen Datenbank mySQL, beides ist kostenlos zu nutzen und wird inzwischen von vielen Anbietern von Webspace zur Verfügung gestellt.</p>
<h4 id=\"h13\">Optimierung</h4>
<p>Zum Anderen optimiere ich aber auch die Kurzbeschreibung und die Suchbegriffe, sodass sie auf den Inhalt der Seite abgestimmt sind und ihre Seiten von Suchmaschinen indiziert werden können.</p>
<p>Ich setze hierbei aber nicht auf Linkfarmen oder andere Tricks, denn der Nutzer bekommt bei diesem Vorgehen oft nicht das Suchergebnis, das er wünscht und verlässt die Seite bald wieder frustriert, was nicht das Ziel sein kann, wenn man möchte, dass die Besucher wiederkommen.</p>
<p>Statt dessen sind klare Worte und Information sowie eine übersichtliche Navigation ausgesprochen wichtig.</p>
<p>Durch die Anwendung von Richtlinien zur Barrierefreiheit und Accessibility mache ich die Seiten auch für Menschen mit Behinderungen zugänglich und verbessere damit auch die Möglichkeiten der Suchmaschinen, die Webseite zu indizieren.</p>", "Zu guter Letzt erfolgt die Umsetzung des Konzepts im Internet, bei der Sie auf unsere Fähigkeiten und Kenntnisse bauen können. Die Seiten werden mit gängigen Browsern getestet und befolgen Standards, so dass größtmögliche Kompatibilität gewährleis", "2010-06-29 00:00:00", "2012-05-17 09:51:01", "0"),
("6", "1", "2", "Service - Suchmaschinenoptimierung: Qualität und Barrierefreiheit für die bessere Indizierung", "Suchmaschinenoptimierung: Qualität und Barrierefreiheit für die bessere Indizierung", "SEO", "SEO", "S", "<p>Natürlich kann ich an dieser Stelle nicht alle Tipps und Trick verraten, die ich anwende, aber es gibt einige Punkte, die man auf jeden Fall beachten sollte, wenn man eine Webseite veröffentlicht, die auch gefunden werden soll.</p>
<h4 id=\"h14\">Qualität</h4>
<p>Der erste Schritt auf dem Weg zu einer guten Platzierung ist die Sorge um eine qualitativ hochwertige Seite, d. h. sie muss über relevante Inhalte verfügen, die sich auch vom Besucher gut erschließen lassen. Hier spielen vor allem die Texte eine große Rolle, denn sie werden schließlich von den Suchmaschinen und ihren Robotern durchforstet.</p>
<p>Bezieht sich der Text auf die Inhalte, welche vertreten werden sollen, so ergibt sich fast von selbst, dass die relevanten Worte auch im Text vorkommen und wenn die Inhalte von Interesse sind, dann werden vielleicht auch andere Seiten darauf verweisen. Deshalb ist es nützlich und sinnvoll, mit der Anzahl der Seiten nicht zu knauserig zu sein, sondern auch Zusatzinformationen zu veröffentlichen, die zum Thema passen, aber unabhängig vom eigentlichen einen zusätzlichen Nutzen für den Besucher bieten.</p>
<h4 id=\"h15\">Barrierefreiheit</h4>
<p>Konkret heißt das, dass Menüs nicht aus Bildern aufgebaut sein , Links einen Titel haben und Bilder über einen alternativen Text verfügen sollten, der angezeigt wird, wenn das Bild nicht geladen wird. Das sind Kleinigkeiten, die vielen Besuchern gar nicht auffallen, aber wenn der Roboter einer Suchmaschine darüber stolpert oder gar als einzigen Satz zurückliefert, dass der Browser Framsets unterstützen muss (es gibt aber selbst hier noch Möglichkeiten, etwas zu retten), dann darf man sich nicht wundern, dass die eigene Seite nicht gefunden wird.</p>
<h4 id=\"h16\">Stichworte und Beschreibung</h4>
<p>Stichworte und Beschreibung des Seiteninhalts sind immer noch wichtig, wenn man sich um die Suchmaschinenoptimierung einer Webseite kümmert. Allerdings helfen Keyword-Wüsten nicht weiter; es sollten eher wenige Stichworte sein, die dafür wichtig für den Inhalt sind und im Haupttext auch tatsächlich vorkommen.</p>
<p>Das Gleiche gilt für die Beschreibung der Seite: je besser sie zum Inhalt passt, desto größer ist auch die Chance, dass dieser Text angezeigt wird, wenn die Seite als Treffer bei der Suchmaschine angeführt wird und nicht irgendein Textbruchstück mitten aus dem Haupttext.</p>
<h4 id=\"h17\">Suchmaschinen und Verzeichnisse</h4>
<p>Zur Suchmaschinenoptimierung gehört auch die Anmeldung der Seite bei den Suchmaschinen selbst und in Verzeichnissen. Dabei muss man es nicht übertreiben, denn tatsächlich sind es nur wenige Suchmaschinen, die tatsächlich von vielen Menschen genutzt werden, aber die Ergebnisse dort werden dann auch wieder von anderen Robotern übernommen.</p>
<p>Auf der anderen Seite gibt es Verzeichnisse und Kataloge, bei denen man sich die Mühe machen muss, seine Seiten auch anzumelden, teilweise sind diese Verzeichnisse sogar redaktionell gepflegt und versuchen ein Mindestmaß an Qualität zu gewährleisten. Mit guten Inhalten steigen auch hier die Chancen, aufgenommen zu werden.</p>
<h4 id=\"h18\">Linktausch</h4>
<p>Schließlich  gibt es noch den Linktausch mit anderen Seiten, doch auch hier sollte man auswählen, mit wem man sich verlinkt, denn wenn die Seite nicht zum eigenen Angebot passt, wirkt der Verweis eher fremd und wird wenige zusätzliche Besucher anlocken (bei den Suchrobotern wird ohnehin spekuliert, dass relevante Links stärker bewertet werden als willkürliche). Außerdem sollte der eigene Link nicht in einer endlosen Liste untergehen, schöner ist eine kürzere Liste, auf der sich auch weitere nützliche Verweise finden lassen.</p>
<p>Auch ausgehende Links können einen positiven Einfluss auf die Relevanz der Seite haben, selbst wenn sie den berüchtigten Pagerank bei Google etwas verringern. Hier ist von Bedeutung, dass sie zusätzliche Informationen bereitstellen, was auch gewürdigt wird (so zumindest mein Eindruck), wenn sie zum Inhalt der eigenen Seite passen und es nicht zu viele ausgehende Links gibt.</p>", "Die Optimierung einer Seite für Suchmaschinen ist im Grunde keine große Kunst, denn eine qualitativ hochwertige Seite mit guten Inhalten, welche Barrierefreiheit berücksichtigt, hat schon gute Chancen, von Suchmaschinen besucht und verzeichnet zu werde", "2010-06-29 00:00:00", "2012-12-11 10:15:35", "0");

-- # Schnipp --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("6", "3", "2", "Service - Search engine optimization: Quality and accessibility for better indexing", "Search engine optimization: Quality and accessibility for better indexing", "SEO_-_Search_Engine_Optimization", "SEO - Search Engine Optimization", "S", "<p>There are a few things you should consider when publishing a Web page.</p>

<h4>Quality</h4>

<p>The first step on the way to a good placement is concern for a high-quality site, i.e.&nbsp;it must have relevant content. If the copy is relevant to the human visitor it's good to the search engines too.</p>

<p>The relevant words in the copy have to occur more often but not excessively. Search engines can't see your images but read your texts. Additional information can be helpful to users and engines.</p>

<h4>Accessibility</h4>

<p>This means, that menus and links need to have a title and images should have alternate text (which is displayed when the image is not loaded). Try to embed relevant keywords into titles an descriptions.</p>

<h4>Keywords and Description</h4>

<p>Keywords and description of the page contents are still important, if one takes care of the SEO of a website. However keyword deserts do not help; It's better to limit the amount of keyword to just a few per page and add more pages if necessary..</p>

<p>The same applies to the description of the page: the better it fits the content, the better the chance for it to be displayed with the search results</p>

<h4>Link Exchange</h4>

<p>Create incoming links with webpage catalogs, blogs and in forums or with other websites. These links are found by search engines and give relevance and reputation to your site.</p>

<h4>Technology</h4>

<p>And finally the search engines need to be informed about the content, which is done through the sitemap (<a href=\"#LINKTO:100#\">sitemap.xml</a>) which is read by the search engine robots. There they'll find the information which pages have been changed and need to be revisited.</p>
", "Optimizing a site for search engines is basically no great art, because a high-quality site with good content, that takes accessibility into account has already good chance to be visited and indexed by search engines.", "2012-05-14 00:00:00", "2014-07-21 16:51:19", "0"),
("7", "1", "2", "Service - Hosting:  Ein individuell geschnürtes Paket aus Webspace, Domain und einer ganze Reihe Zusätzen", "Hosting:  Ein individuell geschnürtes Paket aus Webspace, Domain und einer ganze Reihe Zusätzen", "Hosting", "Hosting", "H", "<p>Mit großen Providern kann ich selbstverständlich nicht mithalten. Aber ich biete Ihnen zu einem günstigen Preis ein individuell geschnürtes Paket aus Webspace, Domain und einer ganze Reihe Zusätzen wie <a href=\"#LINKTO:103#\">PHP</a>, mySQL, PERL, PHYTON, CGI und vielem anderen mehr.</p>

<h4 id=\"h19\">Zusätzliche Leistungen</h4>

<p>Zusätzlich biete ich Ihnen ein Gästebuch, einen kleinen Shop oder auch Newsletter, ein Kontaktformular und sogar CRON-Jobs zur zeitgenauen Automatisierung bestimmter Aufgaben (z. B. von Aktualisierungen oder Angeboten, die pünktlich erscheinen müssen auch wenn Sie gerade nicht da sind).</p>

<h4 id=\"h20\">Speicherplatz</h4>

<p>Wie viel Platz Sie brauchen, entscheiden Sie selbst. Wenn Sie mit 5Mb auskommen, dann brauchen Sie auch nicht für 50 bezahlen, aber wenn Sie Videos und Musik von Ihrer Arbeit anbieten möchten, dann können Sie jederzeit aufstocken.</p>

<h4 id=\"h21\">Domains</h4>

<p>Ihre eigene Internetadresse (de-domain) bekommen Sie bei mir schon ab einem Euro im Monat mit vielen Zusatzleistungen. Dieses Angebot gilt jedoch nur in Verbindung mit einer Webseitengestaltung und -programmierung.</p>

<p>Hier können sie prüfen, ob ihre Wunschdomain noch frei ist und, wenn Sie das wünschen, auch gleich bestellen: <a href=\"http://affiliate.hosteurope.de/click.php/ZfaJR70xobwiGVPd3uZ46Xib-HHhqxb2BCnB7U1iOYg,\" target=\"_self\" title=\"Ist Ihre Wunschdomain noch frei? Jetzt prüfen\">Wunschdomain prüfen</a>.<br />
(Wenn Sie ein Redaktionssystem,wie zum Beispiel <a href=\"http://www.m-cms.de\">M-CMS</a>, einsetzen möchten brauchen Sie auch eine <a href=\"#LINKTO:102#\">mySQL-Datenbank</a>.</p>

<h4 id=\"h22\">Zugang</h4>

<p>Über Ihren FTP-Zugang können Sie selbst Ihre Seiten verwalten und auch eigene Scripte in Ihre Seiten einbauen. Oder Sie überlassen einfach mir die Wartung Ihrer Seiten und brauchen sich um kaum noch etwas zu kümmern - frische Inhalte können Sie mir z. B. im Rahmen einer Service-Vereinbarung zukommen lassen und ich sorge dafür, dass sie eingebunden werden.</p>
", "Wenn Sie noch keinen Provider haben, können wir Ihre Seiten auch gerne zu günstigen Konditionen hosten. Schon für einen geringen Monatsbetrag können Sie per FTP auf Ihre Seiten zugreifen, aber auch mySQL oder PHP, SSI und vieles anderes mehr einsetzen", "2010-06-29 00:00:00", "2014-05-22 12:17:09", "0"),
("8", "1", "2", "Service: Notfall-Service - In 5 Tagen mit Ihrer Website ins Netz (inklusive Gestaltung und Programmierung).", "Notfall-Service: In 5 Tagen mit Ihrer Website ins Netz", "Notfaelle", "Notfälle", "N", "<h4 id=\"h23\">Ins Netz in 5 Tagen</h4>
<p>Die Werbung steht, die Anzeigen sind geschaltet, aber die Website lässt auf sich warten?</p>
<p>Das muss nicht sein!</p>
<p>Wir bringen Sie innerhalb von 5 Werktagen ins Netz, und zwar mit einer professionell gestalteten Internetseite, die später auch von den Suchmaschinen gefunden wird.</p>
<h4 id=\"h24\">Ablauf</h4>
<p>Wenn bei dieser Geschwindigkeit die Qualität nicht leiden soll, müssen wir uns gut strukturieren, aber durch unsere professionelle Arbeitsweise können wir Ihnen folgendes Angebot machen:</p>
<p>Am ersten Tag erfolgt ein Vorgespräch und die Unterzeichnung der Verträge. Wir müssen Sie natürlich kennen lernen, um eine individuelle Gestaltung vorschlagen zu können (Bei komplexen Entwürfen kann es ein paar Tage länger dauern, aber das sagen wir Ihnen vorher).</p>
<p>Wenn Sie noch keine Domain haben, klären wir, ob die von Ihnen gewünschte noch frei ist und registrieren sie.</p>
<p>Am zweiten Tag legen wir Ihnen unsere Entwürfe vor und arbeiten daran, bis sie zufrieden sind.</p>
<p>Der dritte und vierte Tag gehört dem Programmierer<br />
Ihre Website wird erstellt und getestet.</p>
<p>Spätestens am fünften Tag müssen Texte und Bilder von Ihnen zur Verfügung gestellt werden, die dann von uns eingepflegt werden.</p>
<p><span class=\"bolder\">Fertig, jetzt geht Ihre Website ins Netz.</span></p>
<p>In den folgenden Tagen optimieren wir noch für die Suchmaschinen, damit ihre Seite auch gefunden wird (bis das wirkt und Ihre Webseite indiziert ist, vergehen natürlich mehr als fünf Tage).</p>
<h4 id=\"h25\">Kontakt</h4>
<p>Für Fragen zu diesem besonderen Angebot benutzen Sie doch bitte unser <a href=\"/kontakt.php\">Kontaktformular</a>, oder rufen Sie mich an: §TELEFON§, dann machen wir einen Termin aus.</p>", "Die Werbung steht, die Anzeigen sind geschaltet, aber die Homepage lässt auf sich warten? Das muss nicht sein!
Wir kännen Sie mit unserem Notfall-Service innerhalb von 5 Tagen ins Netz bringen.", "2010-06-29 00:00:00", "2012-05-17 09:55:34", "0"),
("9", "1", "2", "Referenzen: Webdesign für Geschäftliche, kreative und private Webseiten", "Referenzen: Webdesign für Geschäftliche, kreative und private Internetseiten", "Homepage-Referenzen", "Referenzen", "R", "<p>Auf den folgenden Seiten finden Sie eine Auswahl unserer Referenzen: Webdesign für private und geschäftliche Kunden sowie Vereine und Organisationen - Shops Portale und Homepages mit und ohne <a href=\"#LINKTO:107#\">Redaktionssystem</a> (CMS).</p>", "Auf den folgenden Seiten finden Sie eine Auswahl unserer Referenzen: Webdesign für private und geschäftliche Kunden sowie Vereine und Organisationen - Shops Portale und Homepages mit und ohne Redaktionssystem.", "2010-06-26 00:00:00", "2013-10-23 14:28:11", "1"),
("9", "2", "2", "المراجع: تم تصميم الموقع للأعمال التجارية، والمواقع الإبداعية، والشخ�", "المراجع: تم تصميم الموقع للأعمال التجارية، والمواقع الإبداعية، والشخصية", "references", "المراجع", "R", "<p>في الصفحات التالية سوف تجد مجموعة مختارة من المراجع لدينا: تصميم مواقع الإنترنت للعملاء من الافراد والشركات - المحلات التجارية وبوابات المواقع مع ودون وجود نظام إدارة المحتوى..<br />
</p>", "في الصفحات التالية سوف تجد مجموعة مختارة من المراجع لدينا: تصميم مواقع الإنترنت للعملاء من الافراد والشركات - المحلات التجارية وبوابات المو", "2012-02-21 00:00:00", "2012-02-21 07:45:22", "1"),
("9", "3", "2", "Portfolio: Web Design for Business, creative and private websites", "Portfolio: Web Design for Business, creative and private websites", "Portfolio", "Portfolio", "R", "<p>Here you will find a selection of web sites we've build. Web design for private and business customers - shops, web portals and web sites with or without content management system (<a href=\"#LINKTO:107#\">CMS</a>).</p>
", "Here you will find a selection of web sites we've build. Web design for private and business customers - shops, web portals and web sites with or without content management system (CMS).", "2011-09-05 00:00:00", "2014-07-21 16:48:56", "0"),
("9", "4", "2", "सन्दर्भ: व्यवसाय के लिए वेब डिजाइन, रचनात्मक और न", "सन्दर्भ: व्यवसाय के लिए वेब डिजाइन, रचनात्मक और निजी वेबसाइटों", "references", "साख", "", "<p>अगले पन्नों पर आप हमारे संदर्भ की एक चयन मिल जाएगा: वेब निजी और व्यावसायिक ग्राहकों के लिए डिजाइन के साथ ही क्लबों और संगठनों - सामग्री प्रबंधन प्रणाली (सीएमएस) के साथ और बिना दुकानें पोर्टलों और मुखपृष्ठों.<br />
</p>", "अगले पन्नों पर आप हमारे संदर्भ की एक चयन मिल जाएगा: निजी और व्यावसायिक ग्राहकों के साथ ही क्लबों औ", "2013-10-23 00:00:00", "2013-10-23 14:49:16", "1"),
("10", "1", "2", "Praxis: Techniken, Anwendungen, Philosophie", "Praxis: Techniken, Anwendungen, Philosophie und Philosophie sowie viel Erfahrung", "Webdesign-Praxis", "Praxis", "P", "<p>&#160;Was steckt hinter Webdesign Haas? Hier finden Sie unsere Philosophie, Informationen zu unserer Arbeit sowie einige Tipps und Tricks. Wenn Sie selbst lernen möchten, wie man eine Webseite programmiert, können Sie uns auch für individuelle Schulungen und Kurse buchen.&#160;</p>", " Was steckt hinter Webdesign Haas? Hier finden Sie unsere Philosophie, Informationen zu unserer Arbeit sowie einige Tipps und Tricks.", "2010-06-29 00:00:00", "2012-09-03 09:06:53", "1"),
("11", "1", "2", "Individuelle Computerkurse: Computerfragen, Einstieg ins Internet oder Gestalten mit Grafikprogrammen in Bremen", "Individuelle Computerkurse und Schulungen", "Kurse", "Kurse", "K", "<p>Alle Kurse finden nach Absprache in den Räumen von &nbsp;<a href=\"http://www.3hoch3.net\">DREI hoch 3</a> statt.</p>

<h4 id=\"h40\">Internet für Einsteiger</h4>

<p>Einführung in die Internetrecherche und Arbeit mit dem Internet, Vorstellung verschiedener Browser.</p>

<p><a href=\"http://www.3hoch3.net/kurse/computer/internet\" target=\"_blank\">Internet für Einsteiger</a></p>

<h4 id=\"h41\">Individuelle Computerfragen</h4>

<p>Nach Absprache nehmen wir uns genau die Themen vor, die Sie interessieren.</p>

<p><a href=\"http://www.3hoch3.net/kurse/computer/fragen\" target=\"_blank\">Individuelle Computerfragen</a></p>

<h4 id=\"h42\">Gestalten mit Grafikprogrammen</h4>

<p>Die eigene Visitenkarte, den Briefbogen oder einen bunten Flyer - lernen Sie, Ihre eigenen Ideen gestalterisch umzusetzen.</p>

<p><a href=\"http://www.3hoch3.net/kurse/computer/grafik\" target=\"_blank\">Gestalten mit Grafikprogrammen</a></p>

<h4 id=\"h44\">Schulung zur Suchmaschinenoptimierung</h4>

<p>Die Schulung zur <a href=\"/service/suchmaschinenoptimierung.shtml\">Suchmaschinenoptimierung</a> kombiniert Beratung und Leere im Bereich Suchmaschinen. Im Einzelgespräch wird eine bestehende oder geplante Internetseite analysiert und es werden Konzepte und Strategien erarbeitet, wie sich ihre Positionierung verbessern lässt. Gemeinsam können dann erste Schritte in diese Richtung unternommen werden.</p>

<p>Die Schulung richtet sich ganz nach Bedarf und Vorwissen des Teilnehmers. Eine Stunde kostet 48 Euro (inkl. MwSt.).</p>
", "Unser Computerkurse finden nach Absprache in den Räumen von  DREI hoch 3 statt.", "2010-06-30 00:00:00", "2014-05-22 12:17:28", "0"),
("12", "1", "2", "Partner und Kooperationen - Innovatives Webdesign und Layout aus Bremen und Umgebung", "Partner und Kooperationen - Innovatives Webdesign und Layout aus Bremen und Umgebung", "Webdesign-Partner", "Partner", "P", "<p>Unsere Partner für Gestaltung und Umsetzung Ihrer Wünsche und Ideen in Bremen, Deutschland und der Schweiz: Wir bieten Webdesign-Ideen für kreative und innovative Homepages mit kreativen Ansätzen in Gestaltung und Layout von Grafikern und Künstlern.</p>

<p>Suchen Sie selbst nach einem kompetenten Partner für die Umsetzung ihrer Webseitengestaltungen? Zögern sie nicht, uns <a href=\"#LINKTO:30#\">anzusprechen</a>.</p>
", "Unsere Partner für Gestaltung und Umsetzung Ihrer Wünsche und Ideen in Bremen, Deutschland und der Schweiz: Wir bieten Webdesign-Ideen für kreative und innovative Homepages mit kreativen Ansätzen in Gestaltung und Layout von Grafikern und Künstlern.", "2010-12-09 00:00:00", "2016-10-14 14:26:49", "1"),
("12", "2", "2", "الشركاء وأوجه التعاون: تصميم \"الموقع ابتكارية\" وتخطيط من بريمن والمناط", "الشركاء وأوجه التعاون: تصميم \"الموقع ابتكارية\" وتخطيط من بريمن والمناطق المحيطة بها", "partners", "شريك", "P", "<p>شريكنا لتصميم وتنفيذ لرغبات والأفكار الخاصة بك في بريمن، ألمانيا وسويسرا: أفكار تصميم ويب لمواقع ويب خلاقة ومبتكرة مع النهج الجديد في تصميم وتخطيط لمصممي الرسومات والفنانين<br />
</p>", "شريكنا لتصميم وتنفيذ لرغبات والأفكار الخاصة بك في بريمن، ألمانيا وسويسرا: أفكار تصميم ويب لمواقع ويب خلاقة ومبتكرة مع النهج الجديد في تصميم", "2011-09-28 00:00:00", "2011-09-29 07:49:25", "1"),
("12", "3", "2", "Partners and cooperations: innovative web design and layout from Bremen and the world", "Partners and cooperations: innovative web design and layout from Bremen and the world", "Webdesign-Partners", "Partners", "P", "<p>Our partners for designing and implementing your wishes and ideas in Bremen, Germany and Switzerland: web design ideas for creative and innovative Web sites with new approaches in design and layout .</p>

<p>You are looking fo a competent partner in web design, PHP and MySQL yourself? Don't hesitate to <a href=\"javascript:void(0);/*1315228693341*/\">contact</a> us.</p>
", "Our partners for designing and implementing your wishes and ideas in Bremen, Germany and Switzerland: web design ideas for creative and innovative Web sites with new approaches in design and layout .", "2011-09-05 00:00:00", "2014-05-21 07:58:20", "1"),
("13", "1", "2", "Praxis - Techniken: Verschiedene Internettechnologien und ihrer Einsatzmöglichkeiten", "Technikenn: Internettechnologien und ihrer Einsatzmöglichkeiten", "Techniken", "Techniken", "T", "<p>Eine kurze Vorstellung verschiedener Internettechnologien und ihrer Einsatzmöglichkeiten.</p>
<p>§BRIDGE§</p>", "Eine kurze Vorstellung verschiedener Internettechnologien und ihrer Einsatzmöglichkeiten.", "2010-06-29 00:00:00", "2013-03-25 16:04:04", "0"),
("14", "1", "2", "Praxis - Philosophie - Alle Browser, Benutzerfreundlichkeit, Suchmaschinenoptimiert, Behindertengerecht und Wartungsfreundlich", "Philosophie: Alle Browser, Benutzerfreundlichkeit, Suchmaschinenoptimiert", "Philosophie", "Philosophie", "P", "<h4 id=\"h57\">Alle Browser</h4>
<p>Es gibt nichtnur einen Browser sondern eine ganze Kollektion, viele unterstützen die etablierten Standards, aber das heißt nicht, dass man nicht trotzdem nachschauen sollte, ob die Darstellung auch in Ordnung ist.<br />
</p>
<p>Da inzwischen alle Browser die <a href=\"#LINKTO:45#\">HTML</a>(5)-Spezifikation verstehen, genügt es eine Seite gemäß diesen Standards zu programmieren und muss bestenfalls ein paar Details nachbessern.</p>
<p>Selbstverständlich prüfe ich die Darstellung der Seiten mit den gängigen Browsern.</p>
<h4 id=\"h58\">Accessibility / Benutzerfreundlich</h4>
<p>Den Begriff Accessibility könnte man vielleicht mit    Benutzerfreundlich  übersetzen, aber das ist eigentlich zu kurz gegriffen, denn seine Bedeutung geht weit darüber hinaus.</p>
<p>Genau genommen müsste man Accessibility mit Zugreifbarkeit übersetzen und das gilt nicht nur für Menschen mit Einschränkungen, wie z. B einer Sehschwäche, sondern auch für Gesunde - für diese ist es Benutzerfreundlichkeit - und sogar für die Roboter der Suchmaschinen - denn auch sie erwarten Seiten, die sie lesen können. Weder Codewüsten, noch Texte, die in Bildern versteckt sind haben da Bestand.&#160;</p>
<p>Die Zugreifbarkeit zu gewährleisten ist mit HTML5 und <a href=\"#LINKTO:44#\">CSS</a> sehr gut zu realisieren. Nebenbei hat die Berücksichtigung der Richtlinien im Quelltext auch für den Programmierer Vorteile, denn auch der Code wird einfacher zu handhaben, weil er klar und logisch strukturiert ist.</p>
<h4 id=\"h59\">Design und Inhalt</h4>
<p>Inhalt, Design und Funktion sind getrennte Bereiche einer Internetrepräsentanz und sollten bei der Programmierung auch so behandelt werden. Die Möglichkeit Stylesheetangaben und Javascript in getrennten Dateien auszulagern ist die ideale Möglichkeit diese Bereiche auseinander zu halten und so die Pflege und Erweiterbarkeit zu optimieren.</p>
<p>Für mich ist deshalb nicht nur das Aussehen der Seite wichtig - obwohl es natürlich Vorrang hat, sondern auch der Weg dahin, mit komplizierten Tabellenkonstrukten kann man schön gestaltete Internetseiten erstellen, aber sie sind für den Administrator oft unübersichtlich und zeitaufwendig zu warten. Und ganz schwierig wird es, wenn der Webmaster wechselt und sich der Nachfolger in dem Spagetticode zurechtfinden soll.</p>
<p>Deshalb ist ein klares Design nicht nur für den sichtbaren Teil wichtig, sondern auch für den dahinter stehenden Code. Durch die klare Trennung wird die Seite übersichtlich und Änderungen lassen sich mit Leichtigkeit sogar von Laien vornehmen (Einige meiner Kunden waren dazu schon nach einer kurzer Einführung fähig, aber noch besser geht es natürlich mit dem von mir entwickelten Redaktionssystem <a href=\"#LINKTO:107#\">M-CMS</a>, mit dem wirklich jede(r) umgehen kann).</p>
<p>Ein weiterer Punkt ist die Einhaltung von Standards, die vom W3C vorgegeben werden - wozu insbesondere das Document Object Model (DOM) und die Document Type Definition (DTD) gehören.</p>
<p>Selbst wenn diese Standards nicht immer eins zu eins von den Browsern umgesetzt werden, stellen Sie sicher, das die Seiten jetzt und in Zukunft dargestellt werden können und erleichtern dem Programmierer die Arbeit, weil er nicht für jeden Browser eine eigene Version erstellen muss. Außerdem werden konforme Seiten schneller und in vorhersagbarer Weise angezeigt - und das auch noch in zukünftigen Browsergenerationen.</p>
<h4 id=\"h60\">Handarbeit</h4>
<p>Ein letzter Punkt ist die Handarbeit. Ich benutzt keine WYSIWYG-Programme, sondern nur Editoren in denen ich die volle Kontrolle über den Code behalte, ganz gleich um welche Programmiersprache es sich handelt. Es mag sein, das man etwas schneller arbeiten kann, wenn man sich nicht, um den zugrunde liegenden Code kümmern muss. Aber durch die Handarbeit weiß ich, welches Ergebnis ich auf welchen Wege erreichen kann und behalte den Überblick über einen sauberen und lesbaren Programmcode.</p>", "Es braucht mehr als das Wissen, den korrekten HTML-Code zu schreiben, um eine erfolgreiche Internetseite zu gestalten. Webseiten sollten mit aktuellen Browsern und von allen Besuchern genutzt werden können.", "2010-06-29 00:00:00", "2012-05-17 10:17:57", "0"),
("15", "1", "2", "Praxis - Tipps und Tricks", "Tipps und Tricks zur Browserübergreifenden Programmierung und Javascript-Anwendungen", "Tipps_und_Tricks", "Tipps und Tricks", "T", "<p>Vorweg ein Hinweis: Die folgenden Tipps wenden sich nicht an den blutigen Anfänger, ich setze voraus, das der Leser Javascript und CSS beherrscht und ich die einzelnen Funktionen und Anweisungen nicht näher erläutern muss.</p>
<p>Viel Spaß beim Tüfteln.</p>
<p>§BRIDGE§</p>", "Tipps zur Browserübergreifenden Programmierung und Javascript-Anwendungen. Ob Javascript, CSS, SSI oder PHP, and dieser Stelle gibt es Tipps und Tricks zur Programmierung und zum Umgang mit widerspenstigen Browsern.", "2010-06-29 00:00:00", "2012-07-10 10:44:46", "0"),
("16", "1", "2", "Praxis - Tipps und Tricks - Menüs aus Listen mit CSS", "Menüs aus Listen mit CSS", "Menues_aus_Listen_mit_CSS", "Menüs aus Listen mit CSS", "M", "<p>Eine Vorgehensweise Menüs zu gestalten setzt sich immer mehr durch, statt mit Tabellen oder div-Elementen können Menüs sehr leicht und übersichtlich mit Listen und CSS formatiert werden.</p>
<p>Dabei speilt es noch nicht einmal eine Rolle, ob sie horizontal oder vertikal angeordnet werden sollen und Untermenus kann man so auch ohne großen zusätzlichen Aufwand einbinden (und in den meisten Browsern ist dafür noch nicht einmal Javascript erforderlich, nur beim Internetexplorer braucht man ein paar Zeilen).</p>
<p>Die Liste im HTML sieht dann wie folgt aus:</p>
<ul class=\"demo\">
	<li><a href=\"#\">Ebene 1</a>
	<ul>
		<li><a href=\"#\">Ebene 1.1</a></li>
		<li><a href=\"#\">Ebene 1.2</a>
		<ul>
			<li><a href=\"#\">Ebene 1.2.1</a></li>
			<li><a href=\"#\">Ebene 1.2.2</a></li>
		</ul>
		</li>
		<li><a href=\"#\">Ebene 1.3</a>
		<ul>
			<li><a href=\"#\">Ebene 1.3.1</a></li>
			<li><a href=\"#\">Ebene 1.3.2</a></li>
		</ul>
		</li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 2</a>
	<ul>
		<li><a href=\"#\">Ebene 2.1</a></li>
		<li><a href=\"#\">Ebene 2.2</a></li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 3</a></li>
</ul>
<p>Das soll erst mal reichen, der Code dazu ist ganz einfach:</p>
<pre>
&lt;ul id=\"menu\"&gt;
  &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1&lt;/a&gt;
    &lt;ul&gt;
      &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.1&lt;/a&gt;&lt;/li&gt;
      &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.2&lt;/a&gt;
        &lt;ul&gt;
          &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.2.1&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.2.2&lt;/a&gt;&lt;/li&gt;
        &lt;/ul&gt;
      &lt;/li&gt;
      &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.3&lt;/a&gt;
        &lt;ul&gt;
          &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.3.1&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 1.3.2&lt;/a&gt;&lt;/li&gt;
        &lt;/ul&gt;
      &lt;/li&gt;
    &lt;/ul&gt;
  &lt;/li&gt;
  &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 2&lt;/a&gt;
    &lt;ul&gt;
      &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 2.1&lt;/a&gt;&lt;/li&gt;
      &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 2.2&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
  &lt;/li&gt;
  &lt;li&gt;&lt;a href=\"#\"&gt;Ebene 3&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;</pre>
<h4>Vertikale Menüs</h4>
<p>Ein bisschen Format kann nicht schaden, denn wenn die Liste nachher ausklappen soll, müssen wir ihre Breite kennen (die Hintergrundfarbe soll das nur deutlicher machen), außerdem verstecken wir mal die Listenpunkte und die Unterebenen, dazu brauchen wir folgende Zeilen im CSS:</p>
<pre>
#menu ul,#menu li{
  margin:0;
  padding:0;
  float:left;
  clear:both;
}
#menu li{
  width: 130px;
  position: relative;
  top:0px;
  list-style: none;
}
#menu a{
  display:block;
  background-color: #ccc;
  width: 130px;
}
#menu li ul {
  display: none;
}
</pre>
<p>unsere Liste sieht dann so aus (schauen Sie sich den Quellcode an, wenn Sie nicht glauben, das es noch dieselbe ist):</p>
<ul class=\"demo step2\" id=\"demo0\">
	<li><a href=\"#\">Ebene 1</a>
	<ul>
		<li><a href=\"#\">Ebene 1.1</a></li>
		<li><a href=\"#\">Ebene 1.2</a>
		<ul>
			<li><a href=\"#\">Ebene 1.2.1</a></li>
			<li><a href=\"#\">Ebene 1.2.2</a></li>
		</ul>
		</li>
		<li><a href=\"#\">Ebene 1.3</a>
		<ul>
			<li><a href=\"#\">Ebene 1.3.1</a></li>
			<li><a href=\"#\">Ebene 1.3.2</a></li>
		</ul>
		</li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 2</a>
	<ul>
		<li><a href=\"#\">Ebene 2.1</a></li>
		<li><a href=\"#\">Ebene 2.2</a></li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 3</a></li>
</ul>
<p>Jetzt sollen aber die Untermenus wieder aufklappen, wenn man mit der Maus darüberfährt, das kann man mit :hover machen (Benutzer des IE müssen noch einen Augenblick geduld haben), also fügen wir im CSS folgende Zeilen hinzu:</p>
<pre>
#menu ul,#menu li:hover ul ul{
  position: absolute;
  display: none;
  left: 95px;
  top:-5px;
}
#menu li:hover ul, #menu ul li:hover ul, #menu ul ul li:hover ul{display: block;}
</pre>
<p>Ergebnis:</p>
<ul class=\"demo step3\" id=\"demo1\">
	<li><a href=\"#\">Ebene 1</a>
	<ul>
		<li><a href=\"#\">Ebene 1.1</a></li>
		<li><a href=\"#\">Ebene 1.2</a>
		<ul>
			<li><a href=\"#\">Ebene 1.2.1</a></li>
			<li><a href=\"#\">Ebene 1.2.2</a></li>
		</ul>
		</li>
		<li><a href=\"#\">Ebene 1.3</a>
		<ul>
			<li><a href=\"#\">Ebene 1.3.1</a></li>
			<li><a href=\"#\">Ebene 1.3.2</a></li>
		</ul>
		</li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 2</a>
	<ul>
		<li><a href=\"#\">Ebene 2.1</a></li>
		<li><a href=\"#\">Ebene 2.2</a></li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 3</a></li>
</ul>
<p>Das genügt erstmal, man kann so noch mehr Ebenen verschachteln, aber das wird dann langsam kompliziert.</p>
<h4>Horizontale Menüs</h4>
<p>Auch ein horizontales Menü ist damit sehr leicht zu realisieren.<br />
Man muss nur die CSS-Anweisungen etwas ändern:</p>
<pre>
#menu ul,#menu li{
  margin:0;
  padding:0;
  float:left;
}
#menu li{
  width: 90px;
  float:left;
}
#menu a{
  margin: 0;
  padding: 1px;
  display: block;
  position: relative;
  width: 90px;
  height: 18px;
  line-height: 18px;
}
#menu ul{
  position: absolute;
  display: none;
  top:20px;
  left: -36px;
}
/*Durch das Komma getrennt werden hier zwei Zuweisungen vorgenommen,
eine für den IE, eine für Browser, die :hover interpretieren*/
#menu li ul ul,#menu li:hover ul ul{
  position: absolute;
  display: none;
  top:0px;
  left: 49px;
}
#menu li:hover ul, #menu ul li:hover ul{display: block;}
</pre>
<p>Das Menü sieht dann (bei sonst gleichem HTML) so aus:</p>
<ul class=\"demo step4\" id=\"demo2\">
	<li><a href=\"#\">Ebene 1</a>
	<ul>
		<li><a href=\"#\">Ebene 1.1</a></li>
		<li><a href=\"#\">Ebene 1.2</a>
		<ul>
			<li><a href=\"#\">Ebene 1.2.1</a></li>
			<li><a href=\"#\">Ebene 1.2.2</a></li>
		</ul>
		</li>
		<li><a href=\"#\">Ebene 1.3</a>
		<ul>
			<li><a href=\"#\">Ebene 1.3.1</a></li>
			<li><a href=\"#\">Ebene 1.3.2</a></li>
		</ul>
		</li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 2</a>
	<ul>
		<li><a href=\"#\">Ebene 2.1</a></li>
		<li><a href=\"#\">Ebene 2.2</a></li>
	</ul>
	</li>
	<li><a href=\"#\">Ebene 3</a></li>
</ul>
<p style=\"clear:both;\">Bei den Formatierungen für das Aussehen muss man darauf achten, dass es keine Lücken zwischen den Menüpunkten gibt, damit das Menu nicht vorzeitig wieder zusammenklappt, ansonsten ist man sehr frei in der Gestaltung.</p>
<h4>Javascript für den IE</h4>
<p>Nun fehlt aber noch etwas Javascript für die Benutzer des IE (das muss dann am Ende stehen, damit es nach dem Menu geladen wird):</p>
<pre>
&lt;!--[if IE]&gt;
&lt;script type=\"text/javascript\"&gt;
  var menu = document.getElementById(\"menu\").getElementsByTagName(\"ul\");
  for (i=0;i&lt;menu.length;i++) {
    menu[i].setAttribute(\"id\",\"menu\"+i)
    if (menu[i].parentNode.nodeName == \"LI\") {
      menu[i].parentNode.onmouseover = function () {
        this.lastChild.style.display = \"block\";
      }
      menu[i].parentNode.onmouseout = function () {
        this.lastChild.style.display = \"none\";
      }
    }
  }
&lt;/script&gt;
&lt;![endif]--&gt;</pre>
<p>Der Vorteil dieser Browserspezifischen Anweisung (siehe: <a xml:lang=\"en\" title=\"Anweisung für bestimmte Versionen des IE\" href=\"/praxis/tipps/conditionalcomments.shtml\">Conditional Comments</a>) ist natürlich, das andere Browser gar nicht erst in die Versuchung kommen, sich mit dem Ausführen dieses Scripts aufzuhalten, noch besser ist es aber, wenn man auf <a xml:lang=\"en\" title=\"Server Side Includes\" href=\"/praxis/technik/ssi.shtml\">SSI</a> zurückgreifen kann, dann wird dieser Teil tatsächlich nur an den IE ausgeliefert, aber leider auch an jeden Browser, der sich als IE ausgibt, deshalb sollte man trotzdem nicht auf <span xml:lang=\"en\">Conditional Comments</span> verzichten:</p>
<pre>
&lt;!--#if expr=\"${HTTP_USER_AGENT} = /MSIE/)\" --&gt;
     &lt;!--[if IE]&gt;...Anweisungen, die nur der Internet Explorer sehen soll...&lt;![endif]--&gt;
&lt;!--#endif --&gt;</pre>
<p><!--[if IE]></p>
<script type=\"text/javascript\">
	var demo1 = document.getElementById(\"demo1\").getElementsByTagName(\"ul\");
	var demo2 = document.getElementById(\"demo2\").getElementsByTagName(\"ul\");
	menu(demo1);
	menu(demo2);
	function menu(demo) {
		for (i=0;i<demo.length;i++) {
			demo[i].setAttribute(\"id\",\"menu\"+i)
			if (demo[i].parentNode.nodeName == \"LI\") {
				demo[i].parentNode.onmouseover = function () {
					this.lastChild.style.display = \"block\";
				}
				demo[i].parentNode.onmouseout = function () {
					this.lastChild.style.display = \"none\";
				}
			}
		}
	}
</script>
<p><![endif]--></p>", "Menus kann man ohne viel Aufwand mit Listen erstellen und über CSS formatieren.", "2010-12-09 00:00:00", "2012-07-10 10:45:17", "0");

-- # Schnipp --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("17", "1", "2", "Praxis - Tipps und Tricks - Mouseover Effekte", "Mouseover Effekte", "Mouseover_Effekte", "Mouseover Effekte", "M", "<p>Es gibt eigentlich kaum noch Men�s bei denen sich nichts tut, wenn man mit der Maus dar�ber f�hrt, das ist nichts neues. Aber folgende L�sung ben�tigt keine onMouseover / onMouseOut -Anweisungen mehr und damit wird die Men�liste wesentlich �bersichtlicher.</p>
<h4 id=\"h1\">Mouseover (Javascript)</h4>
<p>Im Javascript Bereich muss dazu folgender Abschnitt auftauchen:</p>
<pre>
function mouseeffect(){<br />var menus = document.getElementById(\"inhalt\").getElementsByTagName(\"div\");<br />  for ( var i=0; i &gt; menus.length; i++ ) {<br />    menus[i].setAttribute(\"id\",\"menu\"+i);<br />    menus[i].onmouseover = function () {document.getElementById(this.id).className = \"menuover\";}<br />    menus[i].onmouseout  = function () {document.getElementById(this.id).className = \"menu\";}<br />  }<br />}</pre>
<p>Die Menupunkte sind hier in DIVSs geschachtelt, von dem Script werden solche heraus gesucht, die mit id=\"inhalt\" versehen sind und automatisch entsprechend der&#160;<acronym title=\"Cascading Style Sheets\" xml:lang=\"en\">CSS</acronym>-Klassen \"menu\" und \"menuover\" formatiert.</p>
<p>Ich spare mir die M�he die Funktion im Detail zu erl�utern, wenn Funktionen unklar sind, schauen Sie bitte in Ihrer Referenz nach.</p>
<h4>Mouseover (CSS)</h4>
<p>Aber nat�rlich kann man <span xml:lang=\"en\">Mouseover</span>-Effekte auch nur mit CSS realisieren, was sogar noch einfacher ist.</p>
<p>Da der Internetexplorer 6 die Pseudoklasse :hover nur beim A-Tag kennt, m�ssen diese entsprechend formatiert werden.</p>
<p>Der Quellcode sieht dann wie folgt aus:</p>
<pre>
&lt;body id=\"eine\"&gt;
...
&lt;ul class=\"menu\"&gt;
  &lt;li&gt;&lt;a class=\"eine\" href=\"eine.shtml\" &gt;Eine Seite&lt;/a&gt;&lt;/li&gt;
  &lt;li&gt;&lt;a class=\"andere\" href=\"andere.shtml\" &gt;Andere Seite&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;</pre>
<p>Und im <acronym title=\"Cascading Style Sheets\" xml:lang=\"en\">CSS</acronym>-Bereich sollte etwas wie dieses stehen:</p>
<pre>
body#eine a.eine,
body#andere a.andere {
  [Ihre Formatierungen f�r
  den Link, auf dem sich der
  Besucher gerade befindet]
}
#menu li a:hover {
  [Formatierungen f�r den Link,
  �ber dem der Mauszeiger steht]
}
</pre>
<p>Damit wird dann auch gleich die aktuelle Seite markiert und der Besucher wei� sofort, wo er sich gerade befindet           (da eine ID nur einmal vorkommen darf verwende ich im Menu Klassen, es w�re aber auch m�glich auch im BODY-Tag eine Klasse anzugeben).</p>", "Es gibt eigentlich kaum noch Menus bei denen sich nichts tut, wenn man   mit der Maus darüber fährt, das ist nichts neues. Aber folgenden Lösungen benötigt keine onMouseover-/onMouseOut-Anweisungen mehr und damit wird die Menuliste wesentlich übersic", "2010-12-09 00:00:00", "2012-07-10 10:45:47", "0"),
("18", "1", "2", "Praxis - Tipps und Tricks - Automatischer Seiteninhalt", "Automatischer Seiteninhalt", "Automatischer_Seiteninhalt", "Automatischer Seiteninhalt", "A", "<h4 id=\"h69\">Allgemein</h4>
<p>Um mit Javascript die Überschriften einer Seite auszulesen gen�gt schon folgendes Script ausführen zu lassen (z. B. mit onload beim Laden der Seite):</p>
<pre>
function seiteninhalt(){<br />function seiteninhalt(){<br />    var header = document.getElementsByTagName(\"body\")[0].getElementsByTagName(\"h4\");<br />    if (header.length &gt; 1) {<br />        document.getElementsByTagName(\"h3\")[0].setAttribute(\"id\",\"header0\");<br />        var toc = document.createElement(\"ul\");<br />        toc.setAttribute(\"class\",\"toc\");<br />        var string = \"&lt;ul&gt;&lt;li&gt;&lt;a href=\"#header0\"&gt;Anfang&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;/n\";<br />        for ( var i=0; i &lt; header.length; i++ ) {<br />            header[i].setAttribute(\"id\",\"header\"+i);<br />            header[i].setAttribute(\"name\",\"header\"+i);<br />            if (toclink = header[i].firstChild.innerHTML) {}<br />            else<br />                toclink = header[i].innerHTML;<br />            string = string + '&lt;ul&gt;&lt;li&gt;&lt;a id=\"toc' + i + '\" href=\"#header' + i + '\"&gt;' + toclink + '&lt;/a&gt;&lt;/li&gt;&lt;/ul&gt;';<br />        }<br />        toc.innerHTML = string;<br />        document.getElementById(\"toc\").appendChild(toc);<br />    }<br />}</pre>
<p>Diese Operation funktioniert auch bei XHTML (weil nicht mit document.write() gearbeitet wird), allerdings haben Browser, die auf der Gecko-Engine basieren, wie Firefox, Mozilla usw. ein Problem mit innerHTML, sodass diese Seiten (noch) nicht als XHTML ausgeliefert werden k�nnen.</p>
<p>Da das Script die Überschriften selbstständig heraussucht braucht man im HTML keine weiteren Punkte beachten, die Überschrift kann ganz einfach wie folgt aussehen:</p>
<pre>
&lt;h3&gt;Automatischer Seiteninhalt&lt;/h3&gt;</pre>
<p>Durch die Abfrage der Länge des Arrays am Anfang wird der Seiteninhalt nicht angezeigt, wenn nur eine Überschrift auf der Seite vorkommt.</p>
<h4>f�r XHTML und Gecko im besonderen</h4>
<p>Man kann das oben genannte Problem mit Gecko-Browsern der ersten Generation (Mozilla, Firefox usw.) aber umgehen, indem man einig Zeilen etwas ändert:</p>
<pre>
function seiteninhalt(){
    var header = document.getElementsByTagName(\"body\")[0].getElementsByTagName(\"h4\");
    document.getElementsByTagName(\"h3\")[0].setAttribute(\"id\",\"header0\");
    var toc = document.createElement(\"ul\");
    toc.setAttribute(\"class\",\"toc\");
    var filename = document.URL.split(\"/\")
    if (document.URL.replace(filename[filename.length-1],\"\") != \"http://\"+window.location.host+\"/\") {
        makeli(toc,\"../\",\"Eine Ebene h�her\");
    }
    if (document.URL.match(\"shtml\") &amp;&amp; !document.URL.match(\"index\")) {
        makeli(toc,\"./\",\"Dieses Verzeichnis\");
    }
    maketoc(header,toc);
}
function maketoc(header,toc){
    if (header.length &gt; 1) {
        makeli(toc,\"#header0\",\"Seitenanfang\");
        for ( var i=0; i &lt; header.length; i++ ) {
            header[i].setAttribute(\"id\",\"header\"+i);
            header[i].setAttribute(\"name\",\"header\"+i);
            if (toclink = header[i].firstChild.innerHTML) {}
            else
                toclink = header[i].innerHTML;
                makeli(toc,\"#header\"+i,toclink);
            }
        }
        document.getElementById(\"toc\").appendChild(toc);
}
function makeli(toc,href,text){
    var lielement = document.createElement(\"li\");
    var innerelement = document.createElement(\"a\");
    innerelement.setAttribute(\"href\",href);
    elementtext = document.createTextNode(text);
    innerelement.appendChild(elementtext);
    lielement.appendChild(innerelement);
    toc.appendChild(lielement);
}</pre>
<p>Dieses Script enthält am Anfang auch ein paar zusätzliche Zeilen, die für die Verzeichnisnavigation zuständig sind. Sie testen, ob man sich auf der Hauptseite des Verzeichnisses befindet oder auf einer Unterseite und binden entsprechend zusätzliche Navigationselemente ein.</p>
<p>Jetzt funktionieren dieses Script tatsächlich in allen Browsern, die XHTML unterstützen.</p>", "Überschriften aus der aktuellen Webseite heraussuchen und ein Inhaltsverzeichnis generieren, das automatisch angezeigt wird", "2010-12-09 00:00:00", "2012-07-10 10:46:50", "0"),
("19", "1", "2", "Praxis - Tipps und Tricks - Conditional Comments", "Conditional Comments", "Conditional_Comments", "Conditional Comments", "C", "<p>Um Anweisungen vor bestimmten Versionen des Internet Explorer zu verbergen, oder andere Browser nicht zu beeinflussen, braucht man keine komplizierten Hacks, die mit der nächsten Browsergeneration schon wieder obsolet sind. Microsoft hat dafür ein mächtiges Hilfsmittel bereitgestellt, die Conditional Comments.</p>
<p>Der Gebrauch ist ganz einfach:</p>
<pre>
&lt;!--[if IE]&gt;
Anweisungen, die nur der Internet Explorer sehen soll...
&lt;![endif]--&gt;</pre>
<h4>Versionsauswahl</h4>
<p>Um bestimmte Versionen auszuwählen, muss man noch etwas spezifischer werden:</p>
<p>Internet Explorer Version 5.x:</p>
<pre>
&lt;!--[if IE 5]&gt;</pre>
<p>Internet Explorer Version 5.0:</p>
<pre>
&lt;!--[if IE 5.0]&gt;</pre>
<p>Internet Explorer Version 5.5:</p>
<pre>
&lt;!--[if IE 5.5]&gt;</pre>
<p>Internet Explorer Version 6:</p>
<pre>
&lt;!--[if IE 6]&gt;</pre>
<p>Internet Explorer Version 7:</p>
<pre>
&lt;!--[if IE 7]&gt;</pre>
<h4>Operatoren</h4>
<p>Und dann gibt es noch eine Reihe von Operatoren:</p>
<p>Nicht-Operator <strong>!</strong> (z. B. nicht IE 6):</p>
<pre>
&lt;!--[if !IE 6]&gt;</pre>
<p>Kleiner-als-Operator <strong>lt</strong> (z. B. kleiner als IE 6):</p>
<pre>
&lt;!--[if lt IE 6]&gt;</pre>
<p>Kleiner-gleich-Operator <strong>lte</strong> (z. B. kleiner als oder gleich IE 6):</p>
<pre>
&lt;!--[if lte IE 6]&gt;</pre>
<p>Größer-als-Operator <strong>gt</strong> (z. B. größer IE 6):</p>
<pre>
&lt;!--[if gt IE 6]&gt;</pre>
<p>Größer-gleich-Operator <strong>gte</strong> (z. B. größer als oder gleich IE 6):</p>
<pre>
&lt;!--[if gte IE 6]&gt;</pre>
<h4>Mehr als ein IE</h4>
<p>Für Testzwecke ist es manchmal nötig mehrere Versionen des Internet Explorer auf einem Computer zu nutzen, wenn man dazu nicht mehrere Betriebssysteme oder Virtualisierungstechniken benutzen möchte, bieten sich die IE-Standalones an. Damit hier die Conditional Comments korrekt funktionieren, muss man allerdings etwas tricksen. Ich empfehle dazu die Lektüre des zweiten Links unten.</p>
<h4>Links</h4>
<p><a target=\"_blank\" href=\"http://msdn.microsoft.com/workshop/author/dhtml/overview/ccomment_ovw.asp\">About Conditional Comments</a></p>
<p><a target=\"_blank\" href=\"http://www.positioniseverything.net/articles/multiIE.html\">Taming Your Multiple IE Standalones</a></p>", "Insbesondere die älteren Versionen des Internet Explorer arbeiten nicht immer gemäß den Standards des W3C. Aber zu unserem Glück stellt IE die Conditional Comments zur Verfügung.", "2010-12-09 00:00:00", "2012-07-10 10:47:27", "0"),
("20", "1", "2", "Praxis - Tipps und Tricks - Transparente Bilder im IE6", "IE6 Hintergrundflackern", "IE6_Hintergrundflackern", "IE6 Hintergrundflackern", "I", "<p>Der Internetexplorer in der Version 6 hat ein Problem, wenn Hintergründe in CSS von dynamischen Effekten betroffen sind, sie werden dann nachgeladen, was zu einem flackern führt, das lässt sich aber sehr leicht abstellen, und zwar mit einer Zeile Javascript (da dynamische Menüs im IE6 ohnehin nur mit zusätzlichem Javascript funktionieren dürfte sich dafür sicher noch irgendwo ein Plätzchen finden):</p>
<p>&#160;</p>
<pre>
try {
  document.execCommand('BackgroundImageCache', false, true);
} catch(e) {}</pre>
<p>&#160;</p>
<p>Die try-catch-Syntax fängt Fehler ab, wenn der Browser das Konstrukt dennoch nicht versteht.</p>
<p>Quelle: <a target=\"_blank\" href=\"http://evil.che.lu/2006/9/25/no-more-ie6-background-flicker%20%20target=%20_blank\">No more IE6 background flicker</a>.</p>", "Der Internetexplorer in der Version 6 hat ein Problem, wenn Hintergründe in CSS von dynamischen Effekten betroffen sind, sie werden dann nachgeladen, was zu einem flackern führt, das lässt sich aber sehr leicht abstellen", "2010-12-09 00:00:00", "2012-07-10 10:47:52", "0"),
("21", "1", "2", "Praxis - Tipps und Tricks - Transparente Bilder im IE6", "Transpante Bilder im IE6", "Transpante_Bilder_im_IE6", "Transpante Bilder im IE6", "T", "<p>Alle aktuellen Browser unterstützen transparente Portable Networks Graphics (PNG), aber nicht der veraltete Internet Explorer 6.</p>
<h4 id=\"h70\">Alle Bilder (und Elemente)</h4>
<p>Es gibt zwei Tricks, denn der IE ab Version 5 bringt ein paar proprietäre Filter mit, mit denen sich Transparenzen nutzen lassen.</p>
<p>Zunächst ist da der Alpha-Filter (als Style-Anweisung):</p>
<pre>
style=\"filter:Alpha(opacity=100,finishopacity=0startx=0,starty=0,finishx=0,finishy=90,style=1);\"</pre>
<p>Der Filter erwartet folgende Parameter:<br />
</p>
<ul>
	<li>opacity = Deckkraft am Anfang (100 = keine Transparenz)<br />
	</li>
	<li>finishopacity = Deckkraft am Ende (0 = komplett Transparent)<br />
	</li>
	<li>style = Art des Verlaufs (0 = Addition von Vorder- und Hintergrund, 1 = linear, 2 = elliptisch, 3 = rechteckig ).<br />
	Der Lineare Verlauf erwartet zusätzlich Koordinaten (in Pixel) für den Start und Endpunkt des Verlaufs, Obiges Beispiel entspricht einer Verlauf, der von oben nach unten an Transparenz zunimmt.</li>
</ul>
<p>Probleme macht dieser Filter, wenn Schriftzüge betroffen sind, denn die Transparenz wirkt sich nicht nur auf das Hintergrundbild aus und kann die Lesbarkeit erschweren.</p>
<h4 id=\"h71\">PNGs mit Alphachannel</h4>
<p>Der AlphaImageLoader lädt PNG-Bilder, bei denen Bereiche als Transparent, definiert sind, das funktioniert leider - wie alle diese Filter - nur bei eingeschaltetem Javascript. Hier der Filter als Stylesheet-Anweisung:</p>
<pre>
.png{
  background: url(transparent.png);
  background: expression(\"none\");
  filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=scale src='transparent.png');
}</pre>
<p>Nachdem die Grafik - hier als Hintergrund - eingebunden ist muss man IE erst mal beibringen, das er sie doch nicht laden soll, dazu dient die zweite Zeile, da kein anderer Browser \"expressions\" versteht dürfte das keine Schwierigkeiten machen.</p>
<p>Eine andere Möglichkeit ist eine zusätzliche Anweisung, die IE (noch?) nicht interpretiert, wie in diesem Beispiel:</p>
<pre>
.png{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=scale src='transparent.png');}
body&gt;.png{background: url(transparent.png);}</pre>
<p>Der Filter erwartet folgende Parameter:<br />
</p>
<ul>
	<li>enabled = true|false (Aktiv oder nicht)<br />
	</li>
	<li>sizingMethod = cropscale (Beschneiden, wie Bild oder Anpassen)<br />
	</li>
	<li>src = Pfad zum Bild</li>
</ul>
<p>Probleme machen hier Links, denn der IE verhält sich etwas seltsam. Besteht die Grafik aus bis zu 2x2 Pixel scheint es zu funktionieren, bei größeren Bildern wird der Link zwar angezeigt ist aber nicht mehr anzuklicken (um sich zu behelfen könnte man aber den Hintergrund mit einem Mouseover-Effekt austauschen).</p>", "Alle aktuellen Browser unterstützen transparente Portable Networks Graphics (PNG), aber nicht der veraltete Internet Explorer 6.", "2007-12-27 00:00:00", "2012-07-16 17:09:32", "0"),
("22", "1", "2", "Praxis - Tipps und Tricks - Fixierte Elemente im IE", "Fixierte Elemente im IE", "Fixierte_Elemente_im_IE", "Fixierte Elemente im IE", "F", "<p>Leider versteht IE bis zur Version 6 die Anweisung \"position:fixed\" nicht. Es gibt zwar CSS-Hacks oder Javascript-Lösungen, aber die sind oft recht kompliziert einzubinden oder machen mehr Schwierigkeiten als sie lösen.</p>
<h4 id=\"h1\">position:fixed (mit expression)</h4>
<p>Diese Methode ist also vor allem geeignet, um Teile innerhalb eines Fensters zu fixieren, das eigene Scrollbalken hat (z.B. weil mit overflow:auto solche angezeigt werden) und funktioniert nur mit Javascript.</p>
<p>Durch die Verwendung von experssions (Javascript Anweisungen im CSS) validiert ein solches Stylesheet leider nicht mehr.</p>
<pre>
.fixed{
  position:fixed;
  position:expression(\"absolute\");
  top:expression((egal = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) +\"px\");
}</pre>
<p>Jedes Element mit der Klasse \"fixed\" wird jetzt in der gleichen Weise verschoben, wie man das Element scrollt.</p>
<p>Das sieht jetzt noch etwas seltsam aus, zum einen wird die Eigenschaft zunächst einer Variablen zugewiesen und dazu erfolgt eine Abfrage, ob \"document.documentElement.scrollTop\" überhaupt definiert ist. Die Abfrage ist unterschiedlichen Versionen des IE geschuldet, denn wenn er Standardkonform arbeitet und nicht im Kompatibilitätsmodus, wird der Wert \" documentElement \" zugewiesen und ohne die Variablenzuweisung wird die Position nicht erneuert.</p>
<p>Noch besser als obige Lösung ist es natürlich die expression-Anweisungen für den IE vor anderen Browsern zu verstecken, z. B. mit Conditional Comments</p>
<h4 id=\"h2\">position:fixed (nur CSS)</h4>
<p>Wenn ein Element nur relativ zum BODY-Tag fixiert werden soll genügt eine einfachere Konstruktion:</p>
<pre>
html{overflow: hidden;}
body{overflow: auto;}
.text{position:static;}
.menu{position:absolute;}</pre>
<p>Alle Elemente mit dem Attribut position:static werden gescrollt, während Elemente mit position:absolute im IE jetzt statisch dargestellt werden.</p>
<p>Allerdings machen diese Anweisungen bei allen Browsers, die position:fixed verstehen natürlich Probleme, so dass man diesen Abschnitt vor Ihnen verstecken muss. Das kann man mit verschiedenen Browser-Hacks erreichen, aber die eleganteste Lösung ist, diesen Abschnitt wirklich nur dem IE zu zeigen, dazu muss man nur eine kleine Abfrage in den HEAD einbauen, die auch nur vom IE verstanden wird:</p>
<pre>
&lt;head&gt;
  ...[andere Angaben]...
  &lt;!--[if IE]&gt;
    &lt;link rel=\"stylesheet\" type=\"text/css\" href=\"nurie.css\" /&gt;
  &lt;![endif]--&gt;
&lt;/head&gt;</pre>
<p>Wenn man SSI nutzen kann geht es sogar noch eleganter, und andere Browser sehen noch nicht einmal einen Kommentar:</p>
<pre>
&lt;head&gt;
  ...[andere Angaben]...
  &lt;!--#if expr=\"${HTTP_USER_AGENT} = /MSIE/)\" --&gt;
    &lt;link rel=\"stylesheet\" type=\"text/css\" href=\"nurie.css\" /&gt;
  &lt;!--#endif --&gt;
&lt;/head&gt;</pre>
<p>Letztere Methode hat allerdings den Nachteil, dass auch Browser mit diesem Script versorgt werden, die sich aus mangelndem Selbstbewusstsein als IE ausgeben, so dass man hier zumindest zusätzlich zu SSI auch Conditional Comments einsetzen sollte.</p>
<h4 id=\"h3\">Links</h4>
<p><a target=\"_blank\" href=\"http://www.howtocreate.co.uk/fixedPosition.html\">Making Internet Explorer use position: fixed;</a></p>", "Leider versteht IE die Anweisung position:fixed nicht. Es gibt zwar CSS-Hacks oder Javascript-Lösungen, aber die sind oft recht kompliziert einzubinden oder machen mehr Schwierigkeiten als sie lösen. Es geht auch leichter.", "2010-12-09 00:00:00", "2012-07-10 10:49:32", "0"),
("23", "1", "2", "Praxis - Anwendungen: Redaktionssysteme, Portale, Shops und andere Datenbankanwendungen", "Anwendungen: Redaktionssysteme, Portale, Shops und andere Datenbankanwendungen", "Anwendungen", "Anwendungen", "A", "<h4 id=\"h75\">Shops, Portale und Datenbanken</h4>
<p><img alt=\"\" class=\"left\" src=\"/images/bilder/thumbs/23_kanalportal.jpg\" />Das Kanal-Portal basiert auf meinem Redaktionssystem, das ich so erweitert habe, dass beliebige (sogar dynamische) Formulare für die einzelnen Rubriken erstellt werden können.</p>
<p>&#160;<a target=\"_blank\" href=\"http://www.kanal-portal.de%20%20target=%20_blank\">kanal-portal.de</a><br />
&#160;</p>
<p><img alt=\"\" class=\"left\" src=\"/images/bilder/thumbs/23_nakoko.png\" />Nakoko.de ist ein großer Shop (mit über 1500 Produkten, die regelmäßig ergänzt werden), die organisiert und verwaltet werden müssen – inklusive Bestellverwaltung und Anbindung an ein externes Bezahl- und ein Bestellsystem.</p>
<p><a target=\"_blank\" href=\"http://www.nakoko.de%20%20target=%20_blank\">nakoko.d</a>e<br />
&#160;</p>
<h4 id=\"h76\">Redaktionssysteme</h4>
<p>Das Redaktionssystem <a href=\"http://www.m-cms.de\"><strong>M-CMS</strong></a> ist Suchmaschinenoptimiert und verwendet eine virtuelle Verzeichnisstruktur, so dass die URLs immer lesbar bleiben. Ein ausgeklügeltes Vorlagensystem macht es flexibel und vielfältig einsetzbar und die Schlüsselworte werden automatisch ausgelesen.</p>
<p>Außerdem ist es mehrsprachig ausgelegt und kommt auch mit nicht-lateinischen Zeichensätzen, wie bei Arabisch oder Russisch zurecht.</p>
<p>Foren, Newsletter, und Galerien oder Diashows einzubinden ist selbstverständlich eine Kleinigkeit. Es ist sehr flexibel, was die Gestaltung angeht und trotzdem ist die Bedienung leicht zu erlernen.</p>", "Redaktionssystem mit virtueller Verzeichnisstruktur und selbstständiger Verschlagwortung für Suchmaschinen, Flexibilität und Dynamik für Ihre Projekte, Shops und Portale.", "2010-12-21 00:00:00", "2012-05-17 10:18:16", "0"),
("24", "1", "2", "Praxis - Programmierung: Datenbankklassen, binäre Bäume und automatische Formulare", "Programmierung: Datenbankklassen, binäre Bäume und automatische Formulare", "Programmierung", "Programmierung", "P", "<h4 id=\"h77\">Datenbankklasse</h4>
<p>Eigentlich kein Experiment mehr ist die Datenbankklasse, mit der ich arbeite. Mit ihr kann ich fast von selbst Arrays in eine Datenbank schreiben (auch Updates) ohne lange SQL-Statements formulieren zu müssen. Sie kann prüfen, ob ein Eintrag bereits existiert, arbeitet auch multiple Anfrage der Reihe nach ab und nimmt mir noch viele andere Kleinigkeiten bei der Arbeit mit <a href=\"#LINKTO:13#\">mySQL</a> ab.</p>
<h4 id=\"h78\">Binäre Bäume</h4>
<p>Mit dieser Technik, können hierarchische Strukturen und Organisationen dargestellt werden - vergleichbar mit dem Dateisystem des Computers mit Verzeichnissen und Unterverzeichnissen.<br />
Sie findet Verwendung in der Menüverwaltung des Redaktionssystems <a href=\"http://www.m-cms.de\">M-CMS</a>.</p>
<h4 id=\"h79\">Formulare erstellen</h4>
<p>Diese Klasse ist eigentlich ein Overkill für gewöhnliche Formulare, aber sie merkt sich Eingaben und trägt die Werte wieder in das Formular ein, was praktisch ist, wenn man die Daten erst überprüfen möchte, bevor man sie in eine Datenbank speichert.<br />
Eintragen und Prüfen funktioniert dabei auch, wenn die Daten in beliebig tiefen Arrays übergeben werden.<br />
</p>
<h4 id=\"h80\">Templates</h4>
<p>Noch eine Programmklasse - eigentlich nur ein paar wenige Zeilen, aber sie füllen mir meine Vorlagen (HTML-Abschnitte mit Platzhaltern für Inhalte) automatisch, statt jedes Feld einzeln anzusprechen, dass ersetzt werden soll, nimmt dieses Skript ein Array und das zu verwendende Template entgegen und macht den Rest selbst.</p>", "Einige Experimente und Ideen in PHP, wie sie in zukünfttigen Pojekten zur Anwendung kommen könnten.", "2010-06-29 00:00:00", "2012-05-17 10:20:01", "0"),
("25", "1", "2", "Praxis - Erfahrung: Neue Techniken und ständige Weiterentwicklung bei Konzeption und Erstellung von Internetseiten", "Erfahrung: Neue Techniken und ständige Weiterentwicklung bei Konzeption und Webdesign", "Erfahrung", "Erfahrung", "E", "<h4 id=\"h81\">erste Schritte</h4>
<p>Als ich 1996 meine ersten Internetseiten (eine kritische Analyse des UFO-Phänomens) ins Netz stellte, befand sich das WWW noch in den Kinderschuhen und Mosaik war der Browser der Wahl.</p>
<p>Etwas Layout konnte man damals nur mit Tabellen und Font-Tags erreichen, was die Dateien sehr aufblähte und unübersichtlich machte, aber dafür hat man auch noch nicht mit so vielen Grafiken und Texturen gearbeitet</p>
<p>Seit dieser Zeit hat sich viel geändert und ich berücksichtige die neuen Entwicklungen bei der Konzeption aktueller Internetseiten.</p>
<h4 id=\"h82\">Einstieg in CSS</h4>
<p>Mit der weitgehenden Unterstützung von Cascading Style Sheets (<a href=\"#LINKTO:44#\">CSS</a>) der gängigen Browser und dem Verschwinden der älteren vom Markt, habe ich mich entschlossen meine Seiten nach und nach komplett auf CSS umzustellen.</p>
<p>Die Menüstruktur der Seiten unter <a href=\"http://wissenschaft.marcus-haas.de\">wissenschaft.marcus-haas.de</a> ist immer noch sehr stark von Javascript abhängig, weil zu jedem Themenbereich die Menüpunkte in einer ausgelagerten Datei gespeichert sind, so lässt sich das Menü auch ohne <a href=\"#LINKTO:43#\">SSI</a> sehr leicht erweitern und muss vom Browser auch nur einmal geladen werden.</p>
<p>Der Nachteil dieser Vorgehensweise ist, das Javascript von Suchmaschinen nicht indiziert wird - dem entgegne ich mit Zwischenseiten, die auch bei abgeschaltetem Javascript die vollständige Navigation erlauben.</p>
<h4 id=\"h83\">PHP</h4>
<p>In PHP programmiere ich seit Anfang 2004, das erste Projekt war eine Galerie, die noch ohne Datenbank auskommt und Verzeichnisse nach Bildern und zugehörigen Texten durchsucht.</p>
<p>Bei einer aufstrebenden Internetfirma in Oldenburg habe ich 2005 zunächst ein Gästebuch mit Smilies, Textformatierung und Vorschau programmiert und danach einen kleinen Shop entwickelt. Für die Filmgruppe Digitale Störung habe ich eine Projektverwaltung für die Drehplanung geschrieben, die jetzt noch um eine Casting-Datenbank erweitert wird.</p>
<p>In den letzten jahren lag mein Hauptaugenmerk auf der Weiterentwicklung des Redaktionssystems <a href=\"http://www.m-cms.de\">m-cms</a>, mit dem sich nahezu alle denkbaren Aufgaben umsetzen lassen</p>
<h4 id=\"h84\">Umstieg auf XHTML</h4>
<p>Meine Seiten entsprechen seit Ende 2004 dem <a href=\"#LINKTO:45#\">XHTML</a>-Standard und werden als XML an diejenigen Browser ausgeliefert, die dies verstehen - alle anderen Browser sind aber Kompatibel und stellen die Seiten ohne Schwierigkeiten dar.</p>
<p>Die strengeren Anforderungen an die Programmierung lassen, im Gegensatz zu HTML, keinen Spielraum für Fehler, was aber den Vorteil hat, dass diese Seiten in verschiedenen Browsern identisch und schneller angezeigt werden können (ohne die sonst notwendige Fehlerkorrektur und der Interpretation, was der Programmierer nun tatsächlich zeigen wollte, kann der Browser schneller darstellen).</p>
<h4 id=\"h85\">Selbstständigkeit</h4>
<p>Seit November 2004 bin ich selbstständig. Ich entwickle und programmiere Internetseiten, wobei ich beim Design nicht allein auf mich vertraue, sondern die Hilfe einer Grafikerin (<a href=\"http://www.sonnysi.de/sign/\">Grafik/DTP Sonnenberg</a>) in Anspruch nehme.</p>
<p>Daneben trete ich als Provider auf, registriere Internetadressen und stelle den Speicherplatz für die Internetseiten zur Verfügung - selbstverständlich mit den Eigenschaften, die ich selbst kennen und schätzen gelernt habe, wie PHP, SSI, mySQL und vielem mehr.</p>
<h4 id=\"h86\">AJAX und jquery</h4>
<p>Mit Ajax und der Javascriptbibliothek <a target=\"_blank\" href=\"http://jquery.com/%20%20target=%20_blank\">jquery</a> eröffnen sich interessante Perspektiven, um dem Besucher einer Webseite völlig neue Möglichkeiten der Interaktion zu ermöglichen oder dynamisch auf Eingaben zu reagieren. Ich nutze dies bereits auf verschieden Seiten um bei der Produktsuche zu unterstützen oder dynamische Formulare zu erstellen (siehe \"<a href=\"#LINKTO:23#\">Anwendungen</a>\" und das Redaktionssystem \"<a target=\"_blank\" href=\"http://www.m-cms.de/%20%20target=%20_blank\">m-cms</a>\").</p>", "Meine ersten Internetseiten gingen etwas 1996 online und seit dieser Zeit habe ich mich stets weiterentwickelt und meinen Erfahrungsschatz erweitert um technisch auf der Höhe der Zeit zu bleiben und innovatives Webdesign anzubieten.", "2010-06-29 00:00:00", "2012-05-17 10:20:18", "0"),
("26", "1", "2", "Links zu sehenswerten Seiten - HTML, CSS, Webdesign uvm.", "Links", "Links", "Links", "L", "<p>Lassen Sie sich inspirieren, lernen Sie oder stöbern Sie einfach nur mal durch Netz, hier gibt es ein paar erste Anlaufstellen.</p>
<p>Ich spare mir den Disclaimer, die hier angeführten Seiten enthielten zum Zeitpunkt meines letzten Besuchs nach bestem Wissen und Gewissen keine rechtswidrigen Inhalte.</p>
<h4 id=\"h87\">HTML und XHTML</h4>
<p><a href=\"http://www.barrierefreies-webdesign.de/referenz/xhtml-und-html.php\">Die Unterschiede zwischen XHTML und HTML</a></p>
<p><a href=\"http://www.webkrauts.de/category/html5-einfuehrung/\">Webkrauts - HTML5-Einführung</a></p>
<p><a href=\"http://de.selfhtml.org/\">SELFHTML - HTML-Dateien selbst erstellen</a></p>
<h4 id=\"h89\">CSS</h4>
<p><a href=\"http://www.csszengarden.com/\">css Zen Garden: The Beauty in CSS Design</a></p>
<p><a href=\"http://www.stylegala.com/\">Stylegala - the finest CSS and web standards resource</a></p>
<h4 id=\"h90\">PHP</h4>
<p><a href=\"http://www.php.net/\">PHP: Hypertext Preprocessor</a></p>
<h4 id=\"h91\">mySQL</h4>
<p><a href=\"http://dev.mysql.com/doc/refman/5.0/en/index.html\">MySQL 5.0 Reference Manual</a></p>
<h4 id=\"h92\">SSI</h4>
<p><a href=\"http://www.georgedillon.com/web/ssivar.shtml\">SSI, XSSI &amp; CGI variables</a></p>
<p><a href=\"http://httpd.apache.org/docs/2.0/howto/ssi.html\">Apache Tutorial: introduction to Server Side Includes</a></p>
<h4 id=\"h93\">WWW</h4>
<p><a href=\"http://www.w3.org/\">World Wide Web Consortium</a></p>
<p><a href=\"http://validator.w3.org/\">The W3C Markup Validation Service</a></p>
<h4 id=\"h94\">Accessibility</h4>
<p><a href=\"http://www.digital-web.com/articles/optimizing_your_chances_with_accessibility/\">Optimizing Your Chances with Accessibility</a></p>
<p><a href=\"http://www.w3.org/WAI/\">Web Accessibility Initiative (WAI)</a></p>
<h4 id=\"h95\">Sonstige</h4>
<p><a href=\"http://www.webstandards.org/\">The Web Standards Project</a></p>
<p><a href=\"http://www.alistapart.com/\">A List Apart</a></p>
<h4 id=\"h96\">Opera Only</h4>
<p><a href=\"http://www.opera.com/\">Opera</a></p>
<h4>Verzeichnisse</h4>
<p>Redaktionell gepflegte Kataloge:</p>
<p><a href=\"http://www.dmoz.org/World/Deutsch/\">Open Directory Project</a></p>
<p>Die folgenden Verzeichnisse bieten auch Linktausch an:</p>
<p><a href=\"http://www.dehnes-kino-verzeichnis.de/web-design/index.html\">DEHNEs Webdesigner-Verzeichnis</a></p>
<p><a href=\"http://www.webkatalog-webverzeichnis.com/Computer_Internet/Internet/Webdesign/Deutschland/Bremen.html\">Bremen Webkatalog</a></p>
<p><a href=\"http://www.catall.de/\">Webkatalog Catall</a></p>
<p><a href=\"http://www.dienstleistungen-finden.de/\">Dienstleistungen finden</a></p>
<p><a title=\"Suchmaschinenoptimierung\" href=\"http://www.webverzeichnis-webkatalog.de\">Suchmaschinenoptimierung - Webkatalog</a></p>", "Lassen Sie sich inspirieren, lernen Sie oder stöbern Sie einfach nur mal durch Netz, hier gibt es ein paar erste Anlaufstellen.", "2010-12-09 00:00:00", "2012-10-25 07:49:33", "0");

-- # Schnipp --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("26", "3", "2", "Links - HTML, CSS, Webdesign uvm.", "Links", "Links", "Links", "", "<h4 id=\"h89\">CSS</h4>
<p><a href=\"http://www.csszengarden.com/\">css Zen Garden: The Beauty in CSS Design</a></p>
<p><a href=\"http://www.stylegala.com/\">Stylegala - the finest CSS and web standards resource</a></p>
<h4 id=\"h90\">PHP</h4>
<p><a href=\"http://www.php.net/\">PHP: Hypertext Preprocessor</a></p>
<h4 id=\"h91\">mySQL</h4>
<p><a href=\"http://dev.mysql.com/doc/refman/5.0/en/index.html\">MySQL 5.0 Reference Manual</a></p>
<h4 id=\"h92\">SSI</h4>
<p><a href=\"http://www.georgedillon.com/web/ssivar.shtml\">SSI, XSSI &amp; CGI variables</a></p>
<p><a href=\"http://httpd.apache.org/docs/2.0/howto/ssi.html\">Apache Tutorial: introduction to Server Side Includes</a></p>
<h4 id=\"h93\">WWW</h4>
<p><a href=\"http://www.w3.org/\">World Wide Web Consortium</a></p>
<p><a href=\"http://validator.w3.org/\">The W3C Markup Validation Service</a></p>
<h4 id=\"h94\">Accessibility</h4>
<p><a href=\"http://www.digital-web.com/articles/optimizing_your_chances_with_accessibility/\">Optimizing Your Chances with Accessibility</a></p>
<p><a href=\"http://www.w3.org/WAI/\">Web Accessibility Initiative (WAI)</a></p>
<h4 id=\"h95\">Sonstige</h4>
<p><a href=\"http://www.webstandards.org/\">The Web Standards Project</a></p>
<p><a href=\"http://www.alistapart.com/\">A List Apart</a></p>
<h4 id=\"h96\">Opera Only</h4>
<p><a href=\"http://www.opera.com/\">Opera</a></p>
<h4>Verzeichnisse</h4>
<p>Redaktionell gepflegte Kataloge:</p>
<p><a href=\"http://www.dmoz.org/World/Deutsch/\">Open Directory Project</a></p>
<p>Die folgenden Verzeichnisse bieten auch Linktausch an:</p>
<p><a href=\"http://www.dehnes-kino-verzeichnis.de/web-design/index.html\">DEHNEs Webdesigner-Verzeichnis</a></p>
<p><a href=\"http://www.webkatalog-webverzeichnis.com/Computer_Internet/Internet/Webdesign/Deutschland/Bremen.html\">Bremen Webkatalog</a></p>
<p><a href=\"http://www.catall.de/\">Webkatalog Catall</a></p>
<p><a href=\"http://www.dienstleistungen-finden.de/\">Dienstleistungen finden</a></p>
<p><a title=\"Suchmaschinenoptimierung\" href=\"http://www.webverzeichnis-webkatalog.de\">Suchmaschinenoptimierung - Webkatalog</a></p>", "Find information on CSS, PHP and the art of web design.", "2012-10-25 00:00:00", "2012-10-25 07:50:28", "0"),
("27", "1", "2", "weitere Links", "weitere Links", "weitere_Links", "weitere Links", "w", "<p>Die hier angeführten Seiten (Backlinks) enthielten zum Zeitpunkt meines<br />
letzten Besuchs nach bestem Wissen und Gewissen keine rechtswidrigen Inhalte.</p>
<h4>Verzeichnisse</h4>
<p><a href=\"http://www.suchebiete.com/details_Werbebranche_Marketing,Erstellung-Webseiten,12448431.html\">Erstellung von Webseiten</a><br />
<a href=\"http://www.contentmanager.de/\">contentmanager.de</a><br />
<a href=\"http://www.sknil-bew.de\">webkatalog</a><br />
<a href=\"http://www.seitensuche.info/\">Seitensuche.info</a></p>
<p><a href=\"http://www.easywebguide.de/Webkatalog/\">Webkatalog powered by Easywebguide</a><br />
<a title=\"eBooks, PHP-Scripte alles f�r Webmaster und Reseller?\" target=\"_blank\" href=\"http://www.media-products.de/\">eBooks, PHP-Scripte</a><br />
<a title=\"Last Minute Reisen\" target=\"_blank\" href=\"http://www.sumaxl.de/\">Reiseservice</a><br />
<a href=\"http://www.verlinkt-dich.de\">Verlinkt-Dich Webkatalog</a><br />
<a href=\"http://www.aviso24.com/\">aviso24.com</a><br />
<a title=\"links kostenlos eintragen\" href=\"http://www.links-az.de\">Links von A - Z </a><br />
<a title=\"Online-Branchenbuch\" target=\"_top\" href=\"http://www.der-branchenindex.de\">Online-Branchenbuch</a><br />
<a href=\"http://www.designverzeichnis.de\">designverzeichnis.de</a><br />
<a target=\"_blank\" href=\"http://www.99kat.de\">Webkatalog und Webverzeichnis 99kat</a><br />
<a title=\"Mobil im Alter mit der RiesterRente\" href=\"http://www.riester-rente.net\">Mobil im Alter mit der RiesterRente</a><br />
<a title=\"Autos\" href=\"http://www.auto2net.de/\">Autos</a><br />
<a href=\"http://www.riu-check.de/reisen/\">www.riu-check.de Reisetipps</a><br />
<a target=\"_blank\" href=\"http://www.arnayo.de\">www.arnayo.de</a><br />
<a target=\"_blank\" href=\"http://www.soja-wissen.de/\">www.soja-wissen.de</a><br />
<a href=\"http://www.creative-styles.de\">Creative Styles - Das kreative Verzeichnis</a></p>
<!--branchen-info.net Start-->
<div style=\"color: #666; font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: normal; text-decoration: underline;\"><a target=\"_blank\" href=\"http://www.branchen-info.net/bremen/webdesign-1109-1.php\">Webdesign Bremen</a></div>
<!--branchen-info.net Ende-->
<p><a href=\"http://www.homepage-designer.net\"><img border=\"0\" alt=\"Gepr�fte Internetagentur\" src=\"http://www.homepage-designer.net/img/backlink3.gif\" /></a> <a target=\"_blank\" href=\"http://www.stichwort-katalog.de/\"><img alt=\"Stichwort Webkatalog - Jetzt Webseite Eintragen\" width=\"80\" height=\"30\" border=\"0\" src=\"http://www.stichwort-katalog.de/banner/banner_80x30.gif\" /></a></p>
<p><a href=\"http://www.scebs.com/\">Scebs.com  Community Link Webkatalog Event Branchen  Shop  Toplisten  - jetzt kostenlos eintragen</a> <a href=\"http://www.deutscher-index.info\">Webkatalog</a> <a target=\"_blank\" href=\"http://www.flashgames-flashspiele.de\">Flashgames-Flashspiele.de</a> <a target=\"_blank\" href=\"http://www.songtexte-lyrics.com\">Songtexte-Lyrics.com</a></p>
<p><a target=\"_new\" title=\"Veranstaltungen, Termine und Events\" href=\"http://www.eventfinder.de\"><b>eventfinder.de</b> - Der Veranstaltungskalender im Internet</a></p>", "weitere Links", "2010-12-09 00:00:00", "2013-11-21 15:04:47", "0"),
("28", "1", "2", "Impressum", "Impressum", "Impressum", "Impressum", "I", "<h4>§FIRMA§</h4>

<p>Tel.: §TELEFON§<br />
Mobil: §MOBIL§<br />
E-Mail: §EMAIL2§</p>

<h4>Firmensitz / Inhaltliche Verantwortung</h4>

<p>§FIRMA§, Inhaber: §NAME§<br />
§STRASSE§<br />
§ORT§</p>

<h3>Datenschutzerklärung</h3>

<p>Diese Datenschutzerklärung klärt Sie über die Art, den Umfang und Zweck der Verarbeitung von personenbezogenen Daten (nachfolgend kurz „Daten“) innerhalb unseres Onlineangebotes und der mit ihm verbundenen Webseiten, Funktionen und Inhalte sowie externen Onlinepräsenzen, wie z.B. unser Social Media Profile auf (nachfolgend gemeinsam bezeichnet als „Onlineangebot“). Im Hinblick auf die verwendeten Begrifflichkeiten, wie z.B. „Verarbeitung“ oder „Verantwortlicher“ verweisen wir auf die Definitionen im Art. 4 der Datenschutzgrundverordnung (DSGVO).<br />
&nbsp;</p>

<h3 id=\"dsg-general-controller\">Verantwortlicher</h3>

<p><span class=\"tsmcontroller\">§NAME§ / §FIRMA§<br />
§STRASSE§<br />
§ORT§<br />
E-Mailadresse: §EMAIL2§<br />
Geschäftsführer/ Inhaber: §NAME§<br />
Link zum Impressum: §WWW2§</span></p>

<h3 id=\"dsg-general-datatype\">Arten der verarbeiteten Daten:</h3>

<p>- Bestandsdaten (z.B., Namen, Adressen).<br />
- Kontaktdaten (z.B., E-Mail, Telefonnummern).<br />
- Inhaltsdaten (z.B., Texteingaben, Fotografien, Videos).<br />
- Nutzungsdaten (z.B., besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).<br />
- Meta-/Kommunikationsdaten (z.B., Geräte-Informationen, IP-Adressen).</p>

<h3 id=\"dsg-general-datasubjects\">Kategorien betroffener Personen</h3>

<p>Besucher und Nutzer des Onlineangebotes (Nachfolgend bezeichnen wir die betroffenen Personen zusammenfassend auch als „Nutzer“).</p>

<h3 id=\"dsg-general-purpose\">Zweck der Verarbeitung</h3>

<p>- Zurverfügungstellung des Onlineangebotes, seiner Funktionen und Inhalte.<br />
- Beantwortung von Kontaktanfragen und Kommunikation mit Nutzern.<br />
- Sicherheitsmaßnahmen.<br />
- Reichweitenmessung/Marketing</p>

<h3 id=\"dsg-general-terms\">Verwendete Begrifflichkeiten</h3>

<p>„Personenbezogene Daten“ sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person (im Folgenden „betroffene Person“) beziehen; als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identität dieser natürlichen Person sind.<br />
<br />
„Verarbeitung“ ist jeder mit oder ohne Hilfe automatisierter Verfahren ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten.<br />
<br />
„Pseudonymisierung“ die Verarbeitung personenbezogener Daten in einer Weise, dass die personenbezogenen Daten ohne Hinzuziehung zusätzlicher Informationen nicht mehr einer spezifischen betroffenen Person zugeordnet werden können, sofern diese zusätzlichen Informationen gesondert aufbewahrt werden und technischen und organisatorischen Maßnahmen unterliegen, die gewährleisten, dass die personenbezogenen Daten nicht einer identifizierten oder identifizierbaren natürlichen Person zugewiesen werden.<br />
<br />
„Profiling“ jede Art der automatisierten Verarbeitung personenbezogener Daten, die darin besteht, dass diese personenbezogenen Daten verwendet werden, um bestimmte persönliche Aspekte, die sich auf eine natürliche Person beziehen, zu bewerten, insbesondere um Aspekte bezüglich Arbeitsleistung, wirtschaftliche Lage, Gesundheit, persönliche Vorlieben, Interessen, Zuverlässigkeit, Verhalten, Aufenthaltsort oder Ortswechsel dieser natürlichen Person zu analysieren oder vorherzusagen.<br />
<br />
Als „Verantwortlicher“ wird die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet.<br />
<br />
„Auftragsverarbeiter“ eine natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die personenbezogene Daten im Auftrag des Verantwortlichen verarbeitet.</p>

<h3 id=\"dsg-general-legalbasis\">Maßgebliche Rechtsgrundlagen</h3>

<p>Nach Maßgabe des Art. 13 DSGVO teilen wir Ihnen die Rechtsgrundlagen unserer Datenverarbeitungen mit. Sofern die Rechtsgrundlage in der Datenschutzerklärung nicht genannt wird, gilt Folgendes: Die Rechtsgrundlage für die Einholung von Einwilligungen ist Art. 6 Abs. 1 lit. a und Art. 7 DSGVO, die Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer Leistungen und Durchführung vertraglicher Maßnahmen sowie Beantwortung von Anfragen ist Art. 6 Abs. 1 lit. b DSGVO, die Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer rechtlichen Verpflichtungen ist Art. 6 Abs. 1 lit. c DSGVO, und die Rechtsgrundlage für die Verarbeitung zur Wahrung unserer berechtigten Interessen ist Art. 6 Abs. 1 lit. f DSGVO. Für den Fall, dass lebenswichtige Interessen der betroffenen Person oder einer anderen natürlichen Person eine Verarbeitung personenbezogener Daten erforderlich machen, dient Art. 6 Abs. 1 lit. d DSGVO als Rechtsgrundlage.</p>

<h3 id=\"dsg-general-securitymeasures\">Sicherheitsmaßnahmen</h3>

<p>Wir treffen nach Maßgabe des Art. 32 DSGVO unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeit und Schwere des Risikos für die Rechte und Freiheiten natürlicher Personen, geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.<br />
<br />
Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen Zugangs zu den Daten, als auch des sie betreffenden Zugriffs, der Eingabe, Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, Löschung von Daten und Reaktion auf Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz personenbezogener Daten bereits bei der Entwicklung, bzw. Auswahl von Hardware, Software sowie Verfahren, entsprechend dem Prinzip des Datenschutzes durch Technikgestaltung und durch datenschutzfreundliche Voreinstellungen (Art. 25 DSGVO).</p>

<h3 id=\"dsg-general-coprocessing\">Zusammenarbeit mit Auftragsverarbeitern und Dritten</h3>

<p>Sofern wir im Rahmen unserer Verarbeitung Daten gegenüber anderen Personen und Unternehmen (Auftragsverarbeitern oder Dritten) offenbaren, sie an diese übermitteln oder ihnen sonst Zugriff auf die Daten gewähren, erfolgt dies nur auf Grundlage einer gesetzlichen Erlaubnis (z.B. wenn eine Übermittlung der Daten an Dritte, wie an Zahlungsdienstleister, gem. Art. 6 Abs. 1 lit. b DSGVO zur Vertragserfüllung erforderlich ist), Sie eingewilligt haben, eine rechtliche Verpflichtung dies vorsieht oder auf Grundlage unserer berechtigten Interessen (z.B. beim Einsatz von Beauftragten, Webhostern, etc.).<br />
<br />
Sofern wir Dritte mit der Verarbeitung von Daten auf Grundlage eines sog. „Auftragsverarbeitungsvertrages“ beauftragen, geschieht dies auf Grundlage des Art. 28 DSGVO.</p>

<h3 id=\"dsg-general-thirdparty\">Übermittlungen in Drittländer</h3>

<p>Sofern wir Daten in einem Drittland (d.h. außerhalb der Europäischen Union (EU) oder des Europäischen Wirtschaftsraums (EWR)) verarbeiten oder dies im Rahmen der Inanspruchnahme von Diensten Dritter oder Offenlegung, bzw. Übermittlung von Daten an Dritte geschieht, erfolgt dies nur, wenn es zur Erfüllung unserer (vor)vertraglichen Pflichten, auf Grundlage Ihrer Einwilligung, aufgrund einer rechtlichen Verpflichtung oder auf Grundlage unserer berechtigten Interessen geschieht. Vorbehaltlich gesetzlicher oder vertraglicher Erlaubnisse, verarbeiten oder lassen wir die Daten in einem Drittland nur beim Vorliegen der besonderen Voraussetzungen der Art. 44 ff. DSGVO verarbeiten. D.h. die Verarbeitung erfolgt z.B. auf Grundlage besonderer Garantien, wie der offiziell anerkannten Feststellung eines der EU entsprechenden Datenschutzniveaus (z.B. für die USA durch das „Privacy Shield“) oder Beachtung offiziell anerkannter spezieller vertraglicher Verpflichtungen (so genannte „Standardvertragsklauseln“).</p>

<h3 id=\"dsg-general-rightssubject\">Rechte der betroffenen Personen</h3>

<p>Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen und Kopie der Daten entsprechend Art. 15 DSGVO.<br />
<br />
Sie haben entsprechend. Art. 16 DSGVO das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.<br />
<br />
Sie haben nach Maßgabe des Art. 17 DSGVO das Recht zu verlangen, dass betreffende Daten unverzüglich gelöscht werden, bzw. alternativ nach Maßgabe des Art. 18 DSGVO eine Einschränkung der Verarbeitung der Daten zu verlangen.<br />
<br />
Sie haben das Recht zu verlangen, dass die Sie betreffenden Daten, die Sie uns bereitgestellt haben nach Maßgabe des Art. 20 DSGVO zu erhalten und deren Übermittlung an andere Verantwortliche zu fordern.<br />
<br />
Sie haben ferner gem. Art. 77 DSGVO das Recht, eine Beschwerde bei der zuständigen Aufsichtsbehörde einzureichen.</p>

<h3 id=\"dsg-general-revokeconsent\">Widerrufsrecht</h3>

<p>Sie haben das Recht, erteilte Einwilligungen gem. Art. 7 Abs. 3 DSGVO mit Wirkung für die Zukunft zu widerrufen</p>

<h3 id=\"dsg-general-object\">Widerspruchsrecht</h3>

<p>Sie können der künftigen Verarbeitung der Sie betreffenden Daten nach Maßgabe des Art. 21 DSGVO jederzeit widersprechen. Der Widerspruch kann insbesondere gegen die Verarbeitung für Zwecke der Direktwerbung erfolgen.</p>

<h3 id=\"dsg-general-cookies\">Cookies und Widerspruchsrecht bei Direktwerbung</h3>

<p>Als „Cookies“ werden kleine Dateien bezeichnet, die auf Rechnern der Nutzer gespeichert werden. Innerhalb der Cookies können unterschiedliche Angaben gespeichert werden. Ein Cookie dient primär dazu, die Angaben zu einem Nutzer (bzw. dem Gerät auf dem das Cookie gespeichert ist) während oder auch nach seinem Besuch innerhalb eines Onlineangebotes zu speichern. Als temporäre Cookies, bzw. „Session-Cookies“ oder „transiente Cookies“, werden Cookies bezeichnet, die gelöscht werden, nachdem ein Nutzer ein Onlineangebot verlässt und seinen Browser schließt. In einem solchen Cookie kann z.B. der Inhalt eines Warenkorbs in einem Onlineshop oder ein Login-Status gespeichert werden. Als „permanent“ oder „persistent“ werden Cookies bezeichnet, die auch nach dem Schließen des Browsers gespeichert bleiben. So kann z.B. der Login-Status gespeichert werden, wenn die Nutzer diese nach mehreren Tagen aufsuchen. Ebenso können in einem solchen Cookie die Interessen der Nutzer gespeichert werden, die für Reichweitenmessung oder Marketingzwecke verwendet werden. Als „Third-Party-Cookie“ werden Cookies bezeichnet, die von anderen Anbietern als dem Verantwortlichen, der das Onlineangebot betreibt, angeboten werden (andernfalls, wenn es nur dessen Cookies sind spricht man von „First-Party Cookies“).<br />
<br />
Wir können temporäre und permanente Cookies einsetzen und klären hierüber im Rahmen unserer Datenschutzerklärung auf.<br />
<br />
Falls die Nutzer nicht möchten, dass Cookies auf ihrem Rechner gespeichert werden, werden sie gebeten die entsprechende Option in den Systemeinstellungen ihres Browsers zu deaktivieren. Gespeicherte Cookies können in den Systemeinstellungen des Browsers gelöscht werden. Der Ausschluss von Cookies kann zu Funktionseinschränkungen dieses Onlineangebotes führen.<br />
<br />
Ein genereller Widerspruch gegen den Einsatz der zu Zwecken des Onlinemarketing eingesetzten Cookies kann bei einer Vielzahl der Dienste, vor allem im Fall des Trackings, über die US-amerikanische Seite <a href=\"http://www.aboutads.info/choices/\">http://www.aboutads.info/choices/</a> oder die EU-Seite <a href=\"http://www.youronlinechoices.com/\">http://www.youronlinechoices.com/</a> erklärt werden. Des Weiteren kann die Speicherung von Cookies mittels deren Abschaltung in den Einstellungen des Browsers erreicht werden. Bitte beachten Sie, dass dann gegebenenfalls nicht alle Funktionen dieses Onlineangebotes genutzt werden können.</p>

<h3 id=\"dsg-general-erasure\">Löschung von Daten</h3>

<p>Die von uns verarbeiteten Daten werden nach Maßgabe der Art. 17 und 18 DSGVO gelöscht oder in ihrer Verarbeitung eingeschränkt. Sofern nicht im Rahmen dieser Datenschutzerklärung ausdrücklich angegeben, werden die bei uns gespeicherten Daten gelöscht, sobald sie für ihre Zweckbestimmung nicht mehr erforderlich sind und der Löschung keine gesetzlichen Aufbewahrungspflichten entgegenstehen. Sofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich sind, wird deren Verarbeitung eingeschränkt. D.h. die Daten werden gesperrt und nicht für andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen.<br />
<br />
Nach gesetzlichen Vorgaben in Deutschland, erfolgt die Aufbewahrung insbesondere für 10 Jahre gemäß §§ 147 Abs. 1 AO, 257 Abs. 1 Nr. 1 und 4, Abs. 4 HGB (Bücher, Aufzeichnungen, Lageberichte, Buchungsbelege, Handelsbücher, für Besteuerung relevanter Unterlagen, etc.) und 6 Jahre gemäß § 257 Abs. 1 Nr. 2 und 3, Abs. 4 HGB (Handelsbriefe).<br />
<br />
Nach gesetzlichen Vorgaben in Österreich erfolgt die Aufbewahrung insbesondere für 7 J gemäß § 132 Abs. 1 BAO (Buchhaltungsunterlagen, Belege/Rechnungen, Konten, Belege, Geschäftspapiere, Aufstellung der Einnahmen und Ausgaben, etc.), für 22 Jahre im Zusammenhang mit Grundstücken und für 10 Jahre bei Unterlagen im Zusammenhang mit elektronisch erbrachten Leistungen, Telekommunikations-, Rundfunk- und Fernsehleistungen, die an Nichtunternehmer in EU-Mitgliedstaaten erbracht werden und für die der Mini-One-Stop-Shop (MOSS) in Anspruch genommen wird.</p>

<p>&nbsp;</p>

<h3 id=\"dsg-commercialpurpose\">Geschäftsbezogene Verarbeitung</h3>

<p><span class=\"ts-muster-content\">Zusätzlich verarbeiten wir<br />
- Vertragsdaten (z.B., Vertragsgegenstand, Laufzeit, Kundenkategorie).<br />
- Zahlungsdaten (z.B., Bankverbindung, Zahlungshistorie)<br />
von unseren Kunden, Interessenten und Geschäftspartner zwecks Erbringung vertraglicher Leistungen, Service und Kundenpflege, Marketing, Werbung und Marktforschung.</span></p>

<p>&nbsp;</p>

<h3 id=\"dsg-services-agency\">Agenturdienstleistungen</h3>

<p><span class=\"ts-muster-content\">Wir verarbeiten die Daten unserer Kunden im Rahmen unserer vertraglichen Leistungen zu denen konzeptionelle und strategische Beratung, Kampagnenplanung, Software- und Designentwicklung/-beratung oder Pflege, Umsetzung von Kampagnen und Prozessen/ Handling, Serveradministration, Datenanalyse/ Beratungsleistungen und Schulungsleistungen gehören.<br />
<br />
Hierbei verarbeiten wir Bestandsdaten (z.B., Kundenstammdaten, wie Namen oder Adressen), Kontaktdaten (z.B., E-Mail, Telefonnummern), Inhaltsdaten (z.B., Texteingaben, Fotografien, Videos), Vertragsdaten (z.B., Vertragsgegenstand, Laufzeit), Zahlungsdaten (z.B., Bankverbindung, Zahlungshistorie), Nutzungs- und Metadaten (z.B. im Rahmen der Auswertung und Erfolgsmessung von Marketingmaßnahmen). Besondere Kategorien personenbezogener Daten verarbeiten wir grundsätzlich nicht, außer wenn diese Bestandteile einer beauftragten Verarbeitung sind. Zu den Betroffenen gehören unsere Kunden, Interessenten sowie deren Kunden, Nutzer, Websitebesucher oder Mitarbeiter sowie Dritte. Der Zweck der Verarbeitung besteht in der Erbringung von Vertragsleistungen, Abrechnung und unserem Kundenservice. Die Rechtsgrundlagen der Verarbeitung ergeben sich aus Art. 6 Abs. 1 lit. b DSGVO (vertragliche Leistungen), Art. 6 Abs. 1 lit. f DSGVO (Analyse, Statistik, Optimierung, Sicherheitsmaßnahmen). Wir verarbeiten Daten, die zur Begründung und Erfüllung der vertraglichen Leistungen erforderlich sind und weisen auf die Erforderlichkeit ihrer Angabe hin. Eine Offenlegung an Externe erfolgt nur, wenn sie im Rahmen eines Auftrags erforderlich ist. Bei der Verarbeitung der uns im Rahmen eines Auftrags überlassenen Daten handeln wir entsprechend den Weisungen der Auftraggeber sowie der gesetzlichen Vorgaben einer Auftragsverarbeitung gem. Art. 28 DSGVO und verarbeiten die Daten zu keinen anderen, als den auftragsgemäßen Zwecken.<br />
<br />
Wir löschen die Daten nach Ablauf gesetzlicher Gewährleistungs- und vergleichbarer Pflichten. die Erforderlichkeit der Aufbewahrung der Daten wird alle drei Jahre überprüft; im Fall der gesetzlichen Archivierungspflichten erfolgt die Löschung nach deren Ablauf (6 J, gem. § 257 Abs. 1 HGB, 10 J, gem. § 147 Abs. 1 AO). Im Fall von Daten, die uns gegenüber im Rahmen eines Auftrags durch den Auftraggeber offengelegt wurden, löschen wir die Daten entsprechend den Vorgaben des Auftrags, grundsätzlich nach Ende des Auftrags.</span></p>

<p>&nbsp;</p>

<h3 id=\"dsg-contact\">Kontaktaufnahme</h3>

<p><span class=\"ts-muster-content\">Bei der Kontaktaufnahme mit uns (z.B. per Kontaktformular, E-Mail, Telefon oder via sozialer Medien) werden die Angaben des Nutzers zur Bearbeitung der Kontaktanfrage und deren Abwicklung gem. Art. 6 Abs. 1 lit. b) DSGVO verarbeitet. Die Angaben der Nutzer können in einem Customer-Relationship-Management System (\"CRM System\") oder vergleichbarer Anfragenorganisation gespeichert werden.<br />
<br />
Wir löschen die Anfragen, sofern diese nicht mehr erforderlich sind. Wir überprüfen die Erforderlichkeit alle zwei Jahre; Ferner gelten die gesetzlichen Archivierungspflichten.</span></p>

<p>&nbsp;</p>

<h3 id=\"dsg-hostingprovider\">Hosting und E-Mail-Versand,</h3>

<p><span class=\"ts-muster-content\">Die von uns in Anspruch genommenen Hosting-Leistungen dienen der Zurverfügungstellung der folgenden Leistungen: Infrastruktur- und Plattformdienstleistungen, Rechenkapazität, Speicherplatz und Datenbankdienste, E-Mail-Versand, Sicherheitsleistungen sowie technische Wartungsleistungen, die wir zum Zwecke des Betriebs dieses Onlineangebotes einsetzen.<br />
<br />
Hierbei verarbeiten wir, bzw. unser Hostinganbieter Bestandsdaten, Kontaktdaten, Inhaltsdaten, Vertragsdaten, Nutzungsdaten, Meta- und Kommunikationsdaten von Kunden, Interessenten und Besuchern dieses Onlineangebotes auf Grundlage unserer berechtigten Interessen an einer effizienten und sicheren Zurverfügungstellung dieses Onlineangebotes gem. Art. 6 Abs. 1 lit. f DSGVO i.V.m. Art. 28 DSGVO (Abschluss Auftragsverarbeitungsvertrag).</span></p>

<p>&nbsp;</p>

<h3 id=\"dsg-logfiles\">Erhebung von Zugriffsdaten und Logfiles</h3>

<p><span class=\"ts-muster-content\">Wir, bzw. unser Hostinganbieter, erhebt auf Grundlage unserer berechtigten Interessen im Sinne des Art. 6 Abs. 1 lit. f. DSGVO Daten über jeden Zugriff auf den Server, auf dem sich dieser Dienst befindet (sogenannte Serverlogfiles). Zu den Zugriffsdaten gehören Name der abgerufenen Webseite, Datei, Datum und Uhrzeit des Abrufs, übertragene Datenmenge, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite), IP-Adresse und der anfragende Provider.<br />
<br />
Logfile-Informationen werden aus Sicherheitsgründen (z.B. zur Aufklärung von Missbrauchs- oder Betrugshandlungen) für die Dauer von maximal 7 Tagen gespeichert und danach gelöscht. Daten, deren weitere Aufbewahrung zu Beweiszwecken erforderlich ist, sind bis zur endgültigen Klärung des jeweiligen Vorfalls von der Löschung ausgenommen.</span></p>

<p><a class=\"dsg1-5\" href=\"https://datenschutz-generator.de\" rel=\"nofollow\" target=\"_blank\">Erstellt mit Datenschutz-Generator.de von RA Dr. Thomas Schwenke</a></p>
", "§FIRMA§ - §STRASSE§ - §ORT§", "2011-09-05 00:00:00", "2018-05-23 21:29:29", "0"),
("28", "2", "2", "بصمة", "بصمة", "OOUO", "بصمة", "", "<h4>§FIRMA§</h4>

<p>الهاتف: <span class=\"pre\">+49 (0)421 387 13 60</span></p>

<p>البريد الإلكتروني: §EMAIL2§</p>

<h4>Firmensitz / Inhaltliche Verantwortung</h4>

<p>§FIRMA§, Inhaber: §NAME§<br />
§STRASSE§<br />
§ORT§</p>
", "§FIRMA§ - §STRASSE§ - §ORT§", "2013-10-23 00:00:00", "2016-03-23 11:40:47", "0"),
("28", "3", "2", "Imprint", "Imprint", "Imprint", "Imprint", "I", "<h4>§FIRMA§</h4>

<p>Tel.: §TELEFON§<br />
Mobile: §MOBIL§<br />
E-mail: §EMAIL2§</p>

<h4>Headquarters / Content Responsibility</h4>

<p>§NAME§<br />
§STRASSE§<br />
§ORT§</p>
", "Weekdays 14-18 clock can you meet me at DREI hoch 3 (Schildstr. 27, 28203 Bremen).", "2011-09-05 00:00:00", "2016-03-23 11:40:09", "0"),
("28", "4", "2", "छाप", "छाप", "imprint", "छाप", "", "<h4>§FIRMA§</h4>

<p>दूरभाष: §TELEFON§<br />
मोबाइल: §MOBIL§<br />
ई मेल: §EMAIL2§</p>

<h4>Firmensitz / Inhaltliche Verantwortung</h4>

<p>§FIRMA§, Inhaber: §NAME§<br />
§STRASSE§<br />
§ORT§</p>
", "§FIRMA§ - §STRASSE§ - §ORT§", "2013-10-23 00:00:00", "2016-03-23 11:41:04", "1"),
("29", "1", "2", "In eigener Sache", "Marcus Haas: In eigener Sache", "In_eigener_Sache", "In eigener Sache", "I", "<p style=\"clear:none\"><img alt=\"DSC0801_2_1\" class=\"right\" src=\"images/weitere/DSC0801_2_1.jpg\" />Ich bin Diplom-Physiker und habe ich mich Ende 2004 mit <strong><a href=\"http://www.webdesign-haas.de\" title=\"Beratung, Gestaltung und Programmierung aus Bremen\">Webdesign Haas</a></strong> selbstständig gemacht.</p>

<p style=\"clear:none\">Auf meinen privaten Internetseiten schreibe ich über die unterschiedlichsten Themen, mit denen ich mich beschäftige.</p>

<p style=\"clear:none\">Dazu gehört zum Beispiel das Schreiben von <strong><a href=\"http://kurzgeschichten.marcus-haas.de\" title=\"Kurzgeschichten lesen, schreiben und ver�ffentlichen\">Kurzgeschichten</a></strong>, die auf meinen Internetseiten zu finden sind (ein paar davon sind auch veröffentlicht worden), aber auch der SF-Roman <strong><a href=\"http://www.ausser-reichweite.de\">Ausser Reichweite</a></strong>.</p>

<p>In der <strong><a href=\"http://fotografie.marcus-haas.de\" title=\"Aur�stung, Wahrnehmung, Physik und Recht in der Fotografie\">Fotografie</a></strong> liegen meine Präferenzen beim Fotografieren von Menschen. Aber auch die Fotografie von wilden Tieren reizt mich sehr. Um zu lernen und meine Bilder mit anderen zu vergleichen besuche ich Kurse und Seminare. Inzwischen stolzer Besitzer einer Nikon D80 und gebe selbst <a href=\"http://www.3hoch3.net/kurse/kreativ/foto\">Kurse</a>.</p>

<p>Eine weitere Seite beschäftigt sich mit <strong><a href=\"http://tauchen.marcus-haas.de\" title=\"Ausr�stung, Medizin und Physik Unterwasser\">Tauchsport</a></strong>. Den Bremer Unisee habe ich schon betaucht, genauso, wie das Rote Meer und den indischen Ozean vor Kenia.</p>

<p>Im Jahr 2000 habe ich mein <strong>Studium der Physik</strong> abgeschlossen, die Schwerpunkte meines Studiums lagen in der Biophysik und der Theoretischen Physik. In der Biophysik habe ich mich mit Neurophysik, Wahrnehmung und Molekularbiologie auseinandergesetzt und in der Theoretischen Physik hörte ich Vorlesungen zu Quantenmechanik, Relativitätstheorie und Feldtheorie.</p>

<p>Meine Begeisterung für die <strong>Wissenschaften</strong> versuche ich mit meinen populärwissenschaftlichen Artikeln weiterzugeben, die ich monatlich für das <strong><a href=\"http://www.corona-magazine.de\" rel=\"nofolow\" title=\"Deutschlands gr��tes SF-Magazin im Internet\">Corona-Magazin</a></strong> schreibe und die ich kurz darauf auf meinen <strong><a href=\"http://wissenschaft.marcus-haas.de/\" title=\"Wissenschaft und Forschung\">wissenschaftlichen Seiten</a></strong> einstelle.</p>

<p>Ich spreche neben recht gutem Englisch auch ein paar Brocken Französisch, verstehe ein wenig Deutsche Gebärdensprache und lerne jetzt Arabisch an der VHS.</p>

<p>Nach ersten beruflichen Experimenten habe ich mich 2002 entschlossen, in die <strong>Medizinphysik</strong> einzusteigen, wo ich sowohl mit moderner Technik und Wissenschaft, als auch mit Menschen zusammenarbeiten kann. Deshalb habe mich im Herbst 2002 zu einem weiterführenden Studium der medizinischen Physik und Technik eingeschrieben. Dieses Ergänzungsstudium habe ich im Herbst 2004 erfolgreich abgeschlossen.</p>

<p>Im Herbst 2003 habe ich bei der VHS eine Einführung ins Theaterspiel mitgemacht (auf englisch) und von Anfang 2004 bis Ende 2005 spielte ich bei <strong>Theater Contrast</strong> (Unser Stück \"Wird schon werden\" hatte am 29.09.04 Premiere im Schlachthof. Eine zweite Aufführung folgte am 01.10.04), leider hat sich die Gruppe dann aufgelöst.</p>

<p>Und seit dem Sommer 2004 bin ich Teil der Filmgruppe <strong><a href=\"http://www.digitale-stoerung.de\" title=\"Die Bremer Filmikanten\">Digitale Störung</a></strong>, wir machen Filme in Bremen, hier schreibe ich an Drehbüchern mit und kümmere mich um unsere Webseiten. Unser erster Kurzfilm hatte am 12.02.2005 im Kulturzentrum Lagerhaus Premiere.</p>

<p>Seit März 2005 existiert <a href=\"http://www.3hoch3.net\" title=\"Dienstleistungen wie Gestaltung, Webdesign und Beratung\"><strong>DREI hoch 3 - die Agentur für Kreativitüt und Medien</strong></a>. Zusammen mit <a href=\"http://www.sonnysi.de/sign\" title=\"Grafik/DTP Sonnenberg\">Sonny Sonnenberg</a> haben wir in der Schildstr. 27 (Bremen-Ostertor) Räumlichkeiten angemietet. In der Agentur werden Kunden empfangen, Kurse und Seminare veranstaltet und Ausstellungen für Künstler abgehalten.</p>

<p>Von Herbst 2006 bis Frühjahr 2007 habe ich <a href=\"http://www.tanzwerk-bremen.de/\" rel=\"nofollow\" title=\"Tanzwerk Bremen - Zentrum f�r Zeitgen�ssischen Tanz\"><strong>neuen Tanz</strong></a> ausprobiert, um meinem Körper ein paar neue Bewegungsmuster beizubringen, Rhythmusgefühl und Körperbewusstsein zu steigern.</p>

<p>Die zweite Jahreshälfte 2007 und viel von 2009 gehörten wieder dem Theater. Das erste Stück der englischen <strong>Theatergruppe</strong>, hatte am 30. Mai 2008 im <a href=\"http://www.schnuerschuh-theater.de/\">Schnürschuhtheater</a> Premiere - bei vollem Haus.</p>

<p>Im Mai 2009 gründete ich mit vier weiteren schreibbegeisterten die \"<a href=\"http://www.literanauten.de\" target=\"_blank\"><strong>Bremer Literanauten</strong></a>\", wir schreiben Kurzgeschichten und gaben unsere erste Lesung am 15. November 2009 im \"Alten Fundamt\", Bremen. Die zweite Lesung fand am 27.02.2011 um 17 Uhr auf der <a href=\"http://www.treue-bremen.de\">MS Treue</a> statt (Schlachte Anleger 5).</p>

<p>Von 2010 bis 2012 habei ich im Chor der Bremer VHS gesungen und lernte arabisch und swahili.</p>

<p>Im März 2014 habe ich mich verlobt :-D</p>

<p style=\"text-align:center\"><img alt=\"Marcus Haas in Kenia mit einer Meerkatze\" longdesc=\"http://www.marcus-haas.de/marcus.txt\" src=\"/images/marcus.jpg\" style=\"max-width:100%\" /></p>
", "Diplom-Physiker, Autor von Kurzgeschichten und wissenschaftlichen Artikeln. leidenschaftlicher Hobbyfotograf und noch einiges mehr. ", "2010-12-09 00:00:00", "2014-05-13 09:02:01", "0");

-- # Schnipp --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("30", "1", "2", "Kontakt - für Ihre Anfragen und Nachrichten", "Kontakt", "Kontakt", "Kontakt", "K", "<p class=\"left\">Sie können mir Nachrichten und Anfragen gerne an §EMAIL2§ schicken, oder das folgende Kontaktformular benutzen.<br />
<br />
Tel.: §TELEFON§<br />
Mobil: §MOBIL§</p>

<p>#KONTAKTFORMULAR#</p>

<p>§GOOGLEMAP§</p>
", "Tel.: §TELEFON§ - Mobil: §MOBIL§ - E-Mail: §EMAIL§ - Werktags ab 14 Uhr treffen Sie mich bei DREI hoch 3 (Schildstr. 27, 28203 Bremen) persönlich.", "2010-12-20 00:00:00", "2018-08-21 14:05:37", "0"),
("30", "2", "2", "اتصل بنا-عن الاستفسارات والرسائل الخاصة بك", "جهة الاتصال", "contact", "جهة الاتصال", "K", "<p>يمكنك إرسال رسائل لي والأسئلة التي تود §EMAIL2§، أو يمكنك استخدام نموذج الاتصال التالي..</p>

<p>#KONTAKTFORMULAR#</p>

<p>الهاتف: <span class=\"pre\">+49 (0)421 387 13 60</span></p>

<p>البريد الإلكتروني: §EMAIL2§</p>
", "يمكنك إرسال الرسائل والطلبات عبر البريد الإلكتروني، أو استخدام نموذج الاتصال.", "2011-09-28 00:00:00", "2016-03-23 11:38:10", "1"),
("30", "3", "2", "Kontakt - für Ihre Anfragen und Nachrichten", "Contact", "Contact", "Contact", "K", "<p>You can send me messages and inquiries to §EMAIL2§, or use the contact form below.</p>

<p>#KONTAKTFORMULAR#</p>

<p>Tel.: §TELEFON§<br />
Mobile: §MOBIL§<br />
E-mail: §EMAIL2§</p>
", "Contact - for your messages and inquiries", "2011-09-05 00:00:00", "2016-03-23 11:36:44", "0"),
("30", "4", "2", "हमसे संपर्क करें - अपनी जांच और संदेशों के लिए", "संपर्क", "contact", "संपर्क", "", "<p>तुम मेरे संदेश और अनुरोध भेजने के लिए स्वागत कर रहे हैं करने के लिए §EMAIL2§ , या निम्नलिखित संपर्क फार्म का उपयोग करें.</p>

<p>#KONTAKTFORMULAR#</p>

<p>दूरभाष: §TELEFON§<br />
मोबाइल: §MOBIL§<br />
ई मेल: §EMAIL2§</p>
", "दूरभाष: §TELEFON§ - मोबाइल: §MOBIL§ - ई मेल: §EMAIL§ - 14 घड़ी से कार्यदिवस आप DREI hoch 3 (Schildstr. 27, 28203 ब्रेमेन) पर व्यक्ति में मु�", "2013-10-23 00:00:00", "2016-03-23 11:37:50", "1"),
("30", "5", "2", "如何联系与-为您的请求和消息", "如何与取得联系", "contact", "如何与取得联系", "c", "<p>你可以喜欢 §EMAIL2§ 发送消息和问题来问我，或者使用下面的联系表单。</p>

<p>#KONTAKTFORMULAR#</p>

<p>电话: §TELEFON§<br />
&nbsp;移动电话: §MOBIL§<br />
&nbsp;电子邮件: §EMAIL2§</p>
", "电话： §TELEFON§-移动： §MOBIL§-电子邮件： §EMAIL§-平日从你将亲自见我在 DREI hoch 3 (Schildstr. 27, 28203 Bremen) 2:00", "2013-10-25 00:00:00", "2016-03-23 11:37:36", "1"),
("31", "1", "2", "Referenzen - Geschäftliche Webseiten für Unternehmer, Selbstständige und Freiberufler", "Referenzen - Geschäftliche Webseiten für Unternehmer, Selbstständige und Freiberufler", "Unternehmer_SelbststAndige_und_Freiberufler", "Unternehmer, Selbstständige und Freiberufler", "G", "<p>Für Unternehmen und Selbstständige versuchen wir, Persönlichkeit und individuellen Charakter in die Gestaltung der Webseiten einfließen zu lassen.</p>
", "Für Unternehmen und Selbstständige versuchen wir, Persönlichkeit und individuellen Charakter in die Gestaltung der Webseiten einfließen zu lassen.", "2010-12-21 00:00:00", "2016-05-21 09:49:15", "0"),
("31", "2", "2", "المراجع - مواقع الأعمال لرجال الأعمال، لحسابهم الخاص والمستقلين", "المراجع - مواقع الأعمال لرجال الأعمال، لحسابهم الخاص والمستقلين", "business", "محترف", "B", "<p>بالنسبة للشركات والعاملين لحسابهم الخاص، ونحن نحاول غرس شخصية وفردية شخصية في تصميم المواقع على شبكة الإنترنت.</p>", "بالنسبة للشركات والعاملين لحسابهم الخاص، ونحن نحاول غرس شخصية وفردية شخصية في تصميم المواقع على شبكة الإنترنت.", "2012-02-21 00:00:00", "2012-10-10 14:51:37", "1"),
("31", "3", "2", "Business, Freelance and commercial websites", "Business, Freelance and commercial websites", "Business_Freelance_and_commercial", "Business, Freelance and commercial", "P", "<p>For companies and self-employed, we try to incorporate personality and individual character in the design of web sites.</p>
", "For companies and self-employed, we try to incorporate personality and individual character in the design of web sites.", "2011-09-05 00:00:00", "2014-04-16 16:29:48", "0"),
("31", "4", "2", "सन्दर्भ - व्यवसाय वेबसाइटों उद्यमियों, स्वरोजगा", "सन्दर्भ - व्यवसाय वेबसाइटों उद्यमियों, स्वरोजगार और फ्रीलांसरों के लिए", "business", "उद्यमियों, स्वरोजगार और", "", "<p>व्यवसायों और स्वरोजगार के लिए, हम वेबसाइटों की डिजाइन में व्यक्तित्व और व्यक्तिगत चरित्र को शामिल करने की कोशिश.</p>", "व्यवसायों और स्वरोजगार के लिए, हम वेबसाइटों की डिजाइन में व्यक्तित्व और व्यक्तिगत चरित्र को शाम", "2013-10-23 00:00:00", "2013-10-23 14:48:11", "1"),
("32", "1", "2", "Unterhaltung, Freizeit und Events", "Unterhaltung, Freizeit und Events", "Unterhaltung_Freizeit_und_Events", "Unterhaltung, Freizeit und Events", "", "<p>Veranstaltungen planen, oder einen DJ engagieren. Unsere Kunden zeigen, was sie können.</p>
", "Veranstaltungen planen, oder einen DJ engagieren. Unsere Kunden zeigen, was sie können.", "2013-04-15 00:00:00", "2017-03-27 14:33:34", "0"),
("32", "3", "2", "Entertainment, Events and DJs", "Entertainment, Events and DJs", "Entertainment_Events_and_DJs", "Entertainment, Events and DJs", "", "<p>Organizing events and parties. DJs, readings, music or comedy. Our clients do the show.</p>
", "Organizing events and parties. DJs, readings, music or comedy. Our clients do the show.", "2013-04-15 00:00:00", "2014-05-14 08:09:17", "0"),
("33", "1", "2", "Referenzen - Webdesign für Fotografen, Maler, Schauspieler sowie andere Künstler und Kreative", "Webdesign für Künstler und Kreative", "Kuenstler_und_Kreative", "Künstler und Kreative", "K", "<p>Fotografen, Kleinkünstler, Bildhauer und andere Kreative brauchen Webseiten, die ihre Persönlichkeit widerspiegeln und ein individuelles Bild des Künstlers und seiner Werke im Internet schaffen.</p>
", "Fotografen, Kleinkünstler, Bildhauer und andere Kreative brauchen Webseiten, die ihre Persönlichkeit widerspiegeln und ein individuelles Bild des Künstlers und seiner Werke im Internet schaffen.", "2011-09-05 00:00:00", "2015-03-21 07:57:22", "1"),
("33", "2", "2", "المراجع - تصميم مواقع الإنترنت للمصورين والرسامين والفنانين وغيرهم من", "الفنانين والتصميمات", "artist_and_creatives", "الفنانين والتصميمات", "K", "<p>المصورين والفنانين الصغيرة، والنحاتين والمبدعين أخرى تحتاج المواقع التي تعكس شخصيتهم وخلق صورة الفردية للفنان وأعماله على شبكة الإنترنت.</p>", "المصورين والفنانين الصغيرة، والنحاتين والمبدعين أخرى تحتاج المواقع التي تعكس شخصيتهم وخلق صورة الفردية للفنان وأعماله على شبكة الإنترنت.", "2012-02-21 00:00:00", "2012-10-10 14:49:56", "1"),
("33", "3", "2", "References - web design for photographers, painters, actors and other artists and creatives", "Websites for Artists and creative people", "Artists_and_creative_people", "Artists and creative people", "A", "<p>Photographers, artists, sculptors and other creative people need websites that reflect their personality and create a personal picture of the artist and his works on the Internet.</p>
", "Web design for photographers, painters, actors and other artists and creatives.", "2011-09-05 00:00:00", "2014-03-14 11:23:30", "0"),
("33", "4", "2", "सन्दर्भ - फोटोग्राफर, चित्रकार, अभिनेताओं और अन्", "कलाकारों और रचनात्मक के लिए वेब डिजाइन", "creativity", "कलाकारों और रचनात्मक", "", "<p>फोटोग्राफर, छोटे कलाकारों, मूर्तिकारों और उनके व्यक्तित्व को दर्शाते हैं और इंटरनेट पर कलाकार और अपने काम करता है के एक निजी चित्र बनाते हैं जो अन्य रचनात्मक आवश्यकता पर वेबसाइटों.</p>", "फोटोग्राफर, छोटे कलाकारों, मूर्तिकारों और उनके व्यक्तित्व को दर्शाते हैं और इंटरनेट पर कलाकार औ", "2013-10-23 00:00:00", "2013-10-23 14:48:45", "1"),
("34", "1", "2", "Referenzen - Gesundheit, Wellness und Wohlbefinden", "Gesundheit, Wohlbefinden und Therapie", "Gesundheit_Wohlbefinden_und_Therapie", "Gesundheit, Wohlbefinden und Therapie", "G", "<p>Dem Wunsch nach Gesundheit, Wellness und Wohlbefinden versuchen wir mit folgenden Webdesign-Ideen zu entsprechen.</p>
", "Dem Wunsch nach Gesundheit, Wellness und Wohlbefinden versuchen wir mit folgenden Webdesign-Ideen zu entsprechen.", "2010-12-09 00:00:00", "2014-02-09 08:16:21", "0"),
("34", "3", "2", "References - health and quality of life", "Health and quality of life", "Health_and_quality_of_life", "Health and quality of life", "G", "<p>With these web design ideas we try to incorporate the desire for a healthy life that is worth living.</p>", "With these web design ideas we try to incorporate the desire for a healty life that is worth living.", "2011-09-09 00:00:00", "2012-04-04 08:11:02", "0"),
("35", "1", "2", "Referenzen - Internetseiten für Projekte und Veranstaltungen", "Projekte und Veranstaltungen", "Projekte_und_Veranstaltungen", "Projekte und Veranstaltungen", "P", "<p>Projektseiten, für Gruppen und Vereine mit besonderen Anliegen oder Angeboten. Diese Seiten sind nicht unbedingt kommerziell orientiert.</p>
", "Projektseiten, für Gruppen und Vereine mit besonderen Anliegen oder Angeboten. Diese Seiten sind nicht unbedingt kommerziell orientiert.", "2010-12-09 00:00:00", "2017-03-27 14:27:08", "0"),
("35", "3", "2", "References - Websites for projects and events", "Projects and Events", "Projects_and_Events", "Projects and Events", "P", "<p>Project pages, groups and associations with specific needs or offers. These pages are not necessarily commercially oriented.</p>", "Project pages, groups and associations with specific needs or offers. These pages are not necessarily commercially oriented.", "2011-09-05 00:00:00", "2012-03-28 10:33:34", "0"),
("36", "1", "2", "Referenzen - Vereine, Verbände und ihre Websites", "Vereine und Verbände", "Vereine_und_VerbAnde", "Vereine und Verbände", "V", "<p>Vereine und Verbände haben ein Anliegen und Ziel, das man mit Kreativität und Kompetenz in Szene setzen kann.</p>
", "Vereine und Verbände haben ein Anliegen und Ziel, das man mit Kreativität und Kompetenz in Szene setzen kann.", "2010-12-09 00:00:00", "2017-03-27 14:26:19", "0"),
("36", "3", "2", "References - clubs, associations and their websites", "Clubs and Associations", "Clubs_and_Associations", "Clubs and Associations", "V", "<p>Clubs and associations have a concern and goal you can set with creativity and expertise in the limelight.</p>", "Clubs and associations have a concern and goal you can set with creativity and expertise in the limelight.", "2011-09-05 00:00:00", "2011-09-09 16:34:53", "0"),
("37", "1", "2", "Referenzen - nur für Erwachsene und nicht Jugendfreies", "Erwachsene", "Erwachsene", "Erwachsene", "E", "<p>Einige der von uns entworfenen Internetseiten sind eher für ein erwachsenes Publikum bestimmt, aber der Auftritt muss trotzdem stimmig und qualitativ hochwertig sein.</p>", "Einige der von uns entworfenen Internetseiten sind eher für ein erwachsenes Publikum bestimmt, aber der Auftritt muss trotzdem stimmig und qualitativ hochwertig sein.", "2010-12-09 00:00:00", "2012-05-17 10:24:33", "0"),
("38", "1", "2", "Referenzen - Private Seiten", "Private Seiten", "Private_Seiten", "Private Seiten", "P", "<p>Für einzelne Personen, Persönlichkeiten und Privatleute erschaffen wir professionell gestaltete Internetseiten und setzen Ihre Wünsche stilvoll um.</p>", "Für einzelne Personen, Persönlichkeiten und Privatleute erschaffen wir professionell gestaltete Internetseiten und setzen Ihre Wünsche stilvoll um.", "2010-12-09 00:00:00", "2013-10-25 15:48:47", "0"),
("38", "3", "2", "References - Personal web pages", "Personal web pages", "Personal_web_pages", "Personal web pages", "P", "<p>Created for individuals, public figures and private citizens we create professionally designed web pages.</p>", "Created for individuals, public figures and private citizens we create professionally designed web pages.", "2011-09-05 00:00:00", "2011-09-09 16:30:24", "0"),
("39", "1", "2", "Referenzen - Meine eigenen Seiten", "Meine eigenen Seiten", "Eigene_Seiten", "Eigene Seiten", "E", "<p>Und dann sind da noch meine eigenen Webseiten, auf denen ich meine Hobbys und Interessen vorstelle. Ein passendes Webdesign unterstreicht das jeweilige Thema ohne sich aufzudrängen.</p>", "Und dann sind da noch meine eigenen Webseiten, auf denen ich meine Hobbys und Interessen vorstelle. Ein passendes Webdesign unterstreicht das jeweilige Thema ohne sich aufzudrängen.", "2010-12-09 00:00:00", "2012-05-17 10:28:06", "0"),
("39", "3", "2", "References - My own pages", "My own pages", "My_own_pages", "My own pages", "E", "<p>And then there are my own websites where I introduce my hobbies and interests. A suitable web design underlines the topic without imposing itself.</p>", "And then there are my own websites where I introduce my hobbies and interests. A suitable web design underlines the topic without imposing itself.", "2011-09-05 00:00:00", "2011-09-05 15:56:14", "0"),
("40", "1", "2", "Werbung, Grafik und Design", "Werbung, Grafik und Design", "Werbung_Grafik_und_Design", "Werbung, Grafik und Design", "", "<p>Hier gibt es was auf die Augen, kreative Gestaltung, individueller Service: Werbung, die sich sehen lassen kann.</p>
", "Hier gibt es was auf die Augen, kreative Gestaltung, individueller Service: Werbung, die sich sehen lassen kann", "2013-04-16 00:00:00", "2016-05-21 10:15:13", "0"),
("40", "3", "2", "Advertising, Grafics and Design", "Advertising, Grafics and Design", "Advertising_Grafics_and_Design", "Advertising, Grafics and Design", "", "<p>Something for the eyes. creative design, personal service and impressive advertising.</p>", "Something for the eyes. creative design, personal service and impressive advertising.", "2013-04-16 00:00:00", "2013-04-16 14:49:57", "0"),
("41", "1", "2", "Webdesign Haas - Praxis - Techniken - CMS", "CMS", "CMS", "CMS", "C", "<p>Content Management Systeme (CMS) sind sehr weit verbreitet, bei vorgegebenen Templates füllen sie die Seiten mit Inhalten, die vom Nutzer, auch ohne den Webmaster, erstellt und geändert werden können.</p>
<h4 id=\"h98\">Statische oder dynamische CMS</h4>
<p>Dabei unterscheidet man im wesentlichen zwei Arten von CMS. Zum einen gibt es solche, die statische Seiten erzeugen, d.h. es werden unveränderliche Seiten erstellt, die dann publiziert werden, das hat den Vorteil, das die Belastung des Servers nicht so groß ist, was insbesondere bei viel Inhalt, der sich nicht laufend ändert von Vorteil ist.</p>
<p>Andere Systeme erzeugen die nachgefragten Seiten erst bei Abruf, was nützlich ist, wenn sich die Seiten sehr oft ändern oder wenn sehr individuelle Anfragen bearbeitet werden müssen. Den Nachteil der größeren Serverlast kann man relativieren, indem die Seiten bis zur nächsten Änderung zwischengespeichert werden (Cache).</p>
<p>Sicher sind auch Mischformen denkbar. Bei der Auswahl eines CMS sollte man den jeweiligen Bedarf im Auge halten.</p>
<h4 id=\"h99\">Komplexität</h4>
<p>Bei der Entscheidung für ein CMS - auch Redaktionssystem - müssen aber noch andere Aspekte berücksichtigt werden, denn je größer die Anforderungen an das Redaktionssystem, desto komplexer wird auch die Bedienung und die Verwaltung.</p>
<p>Einfache Systeme unterscheiden nur zwischen dem Administrator und Redakteuren. Während der Administrator die Verwaltung der Seite übernimmt, können die Redakteure Artikel einstellen und ändern. Größere CMS machen bei den Redakteuren eine ganze Reihe von Abstufungen oder legen automatisch fest, in welchen Rubriken die Artikel erscheinen. Blogs kann man zu noch einfacheren Redaktionssystemen zählen, im einfachsten Fall zeigen Sie die letzten veröffentlichten Artikel in chronologischer Reihenfolge an.</p>
<h4 id=\"h100\">Gestaltung</h4>
<p>Die meisten Redaktionssysteme sind in den gestalterischen Möglichkeiten eingeschränkt, weil sie immer noch auf den Aufbau der Seite in Tabellen setzen. Das ist nachvollziehbar, wenn viele Module, wie Kalender und Ähnliches eingebunden werden sollen, aber die Flexibilität im Design wird damit eingeschränkt. Aber allmählich setzt sich auch hier CSS durch, obwohl die Umsetzung noch nicht überall optimal ist und die Vorlagen für den Laien nicht immer übersichtlich gestaltet sind, so dass man oft auf vorgefertigte Templates angewiesen ist, die man in Grenzen an die eigenen Vorstellungen anpassen kann.</p>
<p>Die gestalterischen Einschränkungen versuche ich durch die Entwicklung eines eigenen CMS zu umgehen, das auf einfachen Vorlagen beruht, die vollständig und individuell mit CSS formatiert werden. Der Nutzer auf der anderen Seite nimmt keinen Einfluss auf die Darstellung, er soll sich nur auf die Inhalte konzentrieren können, Links und Bilder verwalten und sich in einer sehr übersichtlichen Schnittstelle ohne große Einarbeitung zurecht finden.</p>
<h4 id=\"h101\">Links</h4>
<p><a target=\"_blank\" href=\"http://www.contentmanager.de/%20%20target=%20_blank\">Contentmanager.de - Das Content Management Portal</a></p>
<p><a href=\"http://www.m-cms.de\">M-CMS - Die Eigenentwicklung von Webdesign Haas</a></p>", "Content Management Systeme (CMS) sind sehr weit verbreitet, bei vorgegebener Gestaltung füllen sie die Seiten mit dem Inhalt, den der Nutzer selbst pflegen kann.", "2010-06-28 00:00:00", "2012-07-10 10:52:05", "0"),
("42", "1", "2", "Praxis - Techniken - Javascript", "Javascript", "Javascript", "Javascript", "J", "<h4 id=\"h102\">Was ist Javascript</h4>
<p>Im Gegensatz zu PHP oder SSI werden Javascript-Anweisungen auf dem Rechner des Besuchers ausgeführt, wenn dessen Browser dies unterstützt und die Funktion eingeschaltet ist.</p>
<p>Aus Sicherheitsgründen verzichten viele auf Javascript, so dass man der Verwendung dieser Programmiersprache auch diese Nutzer im Auge behalten muss.</p>
<p>Es macht deshalb keinen Sinn z. B. das Menü einer Seite komplett mit Javascript aufzubauen oder Weiterleitungen hiermit zu realisieren. Da Suchroboter Javascript nicht interpretieren, behindert dies nicht nur die Nutzbarkeit der Seite, sondern erschwert auch die Indizierung und Katalogisierung durch die Suchmaschinen.</p>
<p>Eine Einführung würde hier zu weit führen, schauen Sie sich doch bitte die Links an, wenn Sie anfangen möchten, in Javascript zu programmieren.</p>
<h4 id=\"h103\">Links</h4>
<p><a target=\"_blank\" href=\"http://de.selfhtml.org/javascript/index.htm%20%20target=%20_blank\">Javascript/DOM</a></p>
<p><a target=\"_blank\" href=\"http://www.developerchannel.de/javascript/javascript_main.php%20%20target=%20_blank\">Javascript Einsteiger Kurs</a></p>", "Im Gegensatz zu PHP oder SSI werden Javascript-Anweisungen auf dem Rechner des Besuchers ausgeführt, wenn dessen Browser dies unterstützt und die Funktion eingeschaltet ist.", "2008-01-23 00:00:00", "2012-05-17 10:10:22", "0"),
("43", "1", "2", "Praxis - Techniken - SSI", "SSI", "SSI", "SSI", "S", "<p>Server Side Includes sind eine Funktion des Apache-Webservers, sie werden auf dem Server ausgeführt. Mit ihnen ist es möglich z. B. Weitere Dateien in eine Webseite einzubinden. Das ist sehr nützlich, wenn kein <a href=\"#LINKTO:103#\">PHP</a> zur Verfügung steht.<br />
</p>
<p>In der .htaccess sollten dazu folgende Zeilen stehen:</p>
<pre>
DirectoryIndex  index.shtml index.html
AddHandler server-parsed .shtml
Options Indexes FollowSymLinks Includes</pre>
<p>Und auf dem Server muss SSI aktiv sein, dann kann man z. B mit</p>
<pre>
&lt;!--#include virtual=\"/menu.inc.html\" --&gt;</pre>
<p>eine Datei einbinden (im Obigen Fall handelt es sich um einen Absoluten Pfad, so dass diese Codezeile auch in Unterordnern funktioniert). Zum Beispiel könnte man so ein Menü einbinden, das dann nur noch in dieser einzufügenden Datei gepflegt werden muss und nicht mehr auf jeder einzelnen Unterseite.<br />
</p>", "Server Side Includes sind eine Funktion des Apache-Webservers, sie werden auf dem Server ausgeführt", "2008-01-23 00:00:00", "2012-05-17 10:10:09", "0"),
("44", "1", "2", "Webdesign Haas - Praxis - Techniken - CSS", "CSS", "CSS", "CSS", "C", "<h4>Was ist CSS?</h4>
<p>Stylesheet-Anweisungen übernehmen in zunehmendem Maße die Formatierung in Webseiten, d.h. Tags, wie  und andere Anweisungen verschwinden.</p>
<p>Um dem Browser mitzuteilen, wie eine Überschrift oder ein Absatz formatiert werden sollte, genügten früher p h1 usw. usw., aber die Darstellung war damit immer noch dem jeweiligen Browser überlassen. Um mehr Individualität zu ermöglichen kam es zu einem Wildwuchs von mehr oder weniger gut unterstützten Erweiterungen, welche die Darstellung beeinflussen sollten.</p>
<p>Aber das Design war so eng mit dem Inhalt verwoben, das man kaum, oder nur mit viel Aufwand, etwas daran ändern konnte.</p>
<p>Das änderte sich erst mit der Einführung von Cascading Stylesheets, dies geschah Ende 1996 gleichzeitig mit der Einführung von HTML 4.0. Sowohl Netscape 4 als auch der Internetexplorer unterstützten CSS und nach und nach setzt sich die Technik in immer breiteren Kreisen durch.</p>
<h4>Ein kurze Einführung</h4>
<p>Es gibt drei Möglichkeiten Style-Anweisungen einzubinden, als externe Datei, im -Tag und als Attribut bei einzelnen Elementen.</p>
<p>Dabei überlagern Attribute Anweisungen im &lt;head&gt; diejenigen in der externen Datei und diese wiederum werden gegenüber der Datei bevorzugt, in der Reihenfolge halt, wie sie vorgefunden werden (und alle haben Vorrang vor den Voreinstellungen des Browsers). Darüber hinaus werden auch Eigenschaften vererbt, wenn Schriftart und -größe z. B. im &lt;body&gt; festgelegt werden, so gilt das für das ganze Dokument.</p>
<p>Im folgenden Beispiel sind alle drei Möglichkeiten demonstriert:</p>
<pre>
&lt;html&gt;<br />  &lt;head&gt;<br />    &lt;meta http-equiv=\"Content-Style-Type\" content=\"text/css\" /&gt;<br />    &lt;title&gt;Titel der Datei&lt;/title&gt;<br />    &lt;link rel=\"stylesheet\" type=\"text/css\" href=\"[Link zum Stylesheet]\"&gt;<br />    &lt;style type=\"text/css\"&gt;<br />    ...[ Hier werden die Formate definiert ]...<br />    &lt;/style&gt;<br />  &lt;/head&gt;<br />  &lt;body style=\"[Formate für dieses und darunter liegende Elemente]\"&gt;<br />    &lt;h1 style=\"[Formate für dieses Element]\"&gt;Eine Überschrift&lt;/h1&gt;<br />    &lt;p style=\"[Formate für dieses Element]\"&gt;Ein Absatz&lt;/p&gt;<br />  &lt;/body&gt;<br />&lt;/html&gt;</pre>
<p>Die meta-Angabe teilt dem Browser mit, in welchem Format er die Stylesheet-Datei vorfindet, sie ist bei aktuellen Browsern nicht unbedingt erforderlich.</p>
<p>Daneben gibt es noch die Möglichkeit unterschiedliche Stylesheets für verschiedenen Medien, wie Handhelds, Drucker usw. anzubieten:<br />
</p>
<pre>
&lt;style type=\"text/css\"&gt;
  @import url(druck.css) print, embossed;
  @import url(pocketcomputer.css) handheld;
  @import url(normal.css) screen;
&lt;/style&gt;

</pre>
<p>oder:<br />
</p>
<pre>
&lt;style type=\"text/css\"&gt;
  @media print
  {
    ...[Formate fürs Drucken]...
  }
  @media screen, handheld
  {
    ...[Formate für Bildschirmausgabe]...
  }
&lt;/style&gt;
</pre>
<p>Diese Möglichkeiten werden aber noch nicht von allen Browsern unterstützt.</p>
<p>An dieser Stelle auf die Details einzugehen würde zu weit führen, deshalb möchte ich nur noch erwähnen, dass natürlich nicht nur die Schrift kontrolliert werden kann, sondern praktisch alle Aspekte der Darstellung, von Rändern, über die Positionierung, Hintergründe und sogar einige dynamische Effekte (ein Teil davon wird unter <a title=\"www.webdesign-haas.de/praxis/tipps/%20%20target=%20_blank - [Neues Fenster öffnen]\" target=\"_blank\" rel=\"external\" href=\"http://www.webdesign-haas.de/praxis/tipps/%20%20target=%20_blank\">Tipps und Tricks </a>angesprochen).</p>
<p>Eine sehr schöne Einführung und Referenz gibt es bei <a title=\"de.selfhtml.org/css/index.htm\" rel=\"external\" href=\"http://de.selfhtml.org/css/index.htm\">Selfhtml</a></p>
<h4 id=\"h110\">Vorteile</h4>
<p>Die Vorteile sind offensichtlich, man kann Inhalt und Aussehen von einander trennen, die Seiten sehr viel übersichtlicher programmieren und sogar für unterschiedliche Bedingungen verschiedene Stylesheets zur Verfügung stellen (z. B. für PDAs, Druckausgabe oder auch eine Brillezeile).</p>
<p>Da man nicht mehr auf Tabellen und GIFs für die Positionierung angewiesen ist und sogar Objekte überlagern kann wird das Design viel flexibler, es eröffnen sich völlig neue Möglichkeiten und Freiheiten.</p>
<h4 id=\"h111\">Links</h4>
<p><a title=\"www.heise.de/ix/artikel/2003/03/050/%20%20target=%20_blank - [Neues Fenster öffnen]\" target=\"_blank\" rel=\"external\" href=\"http://www.heise.de/ix/artikel/2003/03/050/\">Cascading Stylesheets: Tutorial</a></p>
<p><a title=\"www.csszengarden.com/\" rel=\"external\" href=\"http://www.csszengarden.com/\">css Zen Garden: The Beauty in CSS Design</a></p>
<p><a title=\"www.stylegala.com/\" target=\"_blank\" rel=\"external\" href=\"http://www.stylegala.com/\">Stylegala - the finest CSS and web standards resource</a></p>", "Stylesheet-Anweisungen übernehmen in zunehmendem Maße die Formatierung", "2008-04-02 00:00:00", "2012-07-10 11:06:02", "0"),
("45", "1", "2", "Praxis - Techniken - XHTML", "XHTML", "XHTML", "XHTML", "X", "&lt;h4&gt;Was ist XHTML?&lt;/h4&gt;
&lt;p&gt;&lt;acronym title=&quot;Extensible Hypertext Markup Language&quot; xml:lang=&quot;en&quot;&gt;XHTML&lt;/acronym&gt; ist die
 	&lt;acronym title=&quot;Extensible Markup Language&quot; xml:lang=&quot;en&quot;&gt;XML&lt;/acronym&gt;-Erweiterung
 	zu &lt;acronym title=&quot;Hypertext Markup Language&quot; xml:lang=&quot;en&quot;&gt;HTML&lt;/acronym&gt;,
 	d.h. jeder &lt;span xml:lang=&quot;en&quot;&gt;Tag&lt;/span&gt; muss einen Abschluss haben
 	und es sind bei den einzelnen Tags strenge Regeln hinsichtlich der verwendeten Attribute
 	und der Verschachtelung einzuhalten. Der Lohn f&amp;uuml;r die M&amp;uuml;he ist ein schnellerer Aufbau
 	der Seiten und eine	bessere und einheitlichere Darstellung auf unterschiedlichen
 	Plattformen, das gilt insbesondere auch f&amp;uuml;r Mobile Ger&amp;auml;te, deren begrenzte
 	Leistungsf&amp;auml;higkeit besser ausgenutzt wird.&lt;/p&gt;
&lt;p&gt;Aber nicht nur die neuesten Browser verstehen und interpretieren XHTML, auch
 	&amp;auml;ltere Browser haben in der Regel keine Schwierigkeiten damit, weil es auf HTML 4.01
 	aufbaut.&lt;/p&gt;
&lt;p&gt;Die Version 1.0 wird vom &lt;acronym title=&quot;World Wide Web Consortium&quot;&gt;W3C&lt;/acronym&gt;
 	seit dem 26. Januar 2000 als Webstandard empfohlen.&lt;/p&gt;
&lt;h4&gt;Eine kurze Einf&amp;uuml;hrung&lt;/h4&gt;
&lt;p&gt;Die &amp;Auml;nderungen, die vorgenommen werden m&amp;uuml;ssen, um von HTML auf XHTML
 	umzustellen sind nicht sehr gravierend. Aber da XML eine Sprache ist, die
 	Datenstrukturen wiedergibt muss genau darauf geachtet werden, dass alle Tags
 	abgeschlossen sind und die Verschachtelung den Vorgaben entspricht&lt;/p&gt;
&lt;p&gt;Au&amp;szlig;erdem werden alle Tags und Attribute klein geschrieben, in
 	Anf&amp;uuml;hrungszeichen stehen und d&amp;uuml;rfen nicht verk&amp;uuml;rzt werden, d.h. jedem Attribut
 	muss auch ein Wert zugewiesen werden.&lt;/p&gt;
&lt;p&gt;Bisher war es kein Problem z.B. eine Liste wie folgt aufzubauen:&lt;/p&gt;
&lt;pre&gt;
&amp;lt;UL&amp;gt;
  &amp;lt;LI STYLE=&amp;quot;color:red&amp;quot;&amp;gt;Punkt eins
  &amp;lt;LI STYLE=&amp;quot;color:blue&amp;quot;&amp;gt;Punkt zwei
&amp;lt;/UL&amp;gt;
&amp;lt;P&amp;gt;Ein Absatz.
&amp;lt;P&amp;gt;Noch ein Absatz.
&amp;lt;input checked value=Haken&amp;gt;
&lt;/pre&gt;
&lt;p&gt;In XHTML muss das so aussehen&lt;/p&gt;
&lt;pre&gt;
&amp;lt;ul&amp;gt;
  &amp;lt;li style=&amp;quot;color:red&amp;quot;&amp;gt;Punkt eins&amp;lt;/li&amp;gt;
  &amp;lt;li style=&amp;quot;color:blue&amp;quot;&amp;gt;Punkt zwei&amp;lt;/li&amp;gt;
&amp;lt;/ul&amp;gt;
&amp;lt;p&amp;gt;Ein Absatz.&amp;lt;/p&amp;gt;
&amp;lt;p&amp;gt;Noch ein Absatz.&amp;lt;/p&amp;gt;
&amp;lt;input checked=&amp;quot;checked&amp;quot; value=&amp;quot;Haken&amp;quot;&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Einige Tags haben aber kein Abschluss-Tag, das man einbauen kann, hier wird der
 	Abschluss im gleichen Element angezeigt.&lt;/p&gt;
&lt;pre&gt;
&amp;lt;img src=&amp;quot;bild.jpg&amp;quot; /&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Das Leerzeichen vor dem Slash hilft den &amp;auml;lteren Browsern sich nicht an
 	dieser Syntax zu verschlucken. das gleich gilt auch f&amp;uuml;r &amp;lt;meta [...]&amp;gt;,
 	&amp;lt;br&amp;gt;, &amp;lt;hr&amp;gt; usw., daraus wird: &amp;lt;meta [...] /&amp;gt;, &amp;lt;br /&amp;gt;,
 	&amp;lt;hr /&amp;gt;&lt;/p&gt;
&lt;p&gt;In HTML 4.01 gibt es das &amp;quot;name&amp;quot;-Attribut f&amp;uuml;r a, applet, frame, iframe,
 	img, und map. In XHTML ist dies nicht mehr g&amp;uuml;ltig, statt dessen wird hier
 	das &amp;quot;id&amp;quot;-Attribut verwendet. Au&amp;szlig;erdem muss das alt-Attribut angegeben
 	werden (dies soll die Barrierefreiheit f&amp;ouml;rdern, es darf aber leer sein, wenn das
 	Bild keine Information enth&amp;auml;lt)&lt;/p&gt;
&lt;p&gt;Statt:&lt;/p&gt;
&lt;pre&gt;
&amp;lt;img src=&amp;quot;bild.gif&amp;quot; name=&amp;quot;bild&amp;quot;&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Hei&amp;szlig;t es jetzt:&lt;/p&gt;
&lt;pre&gt;
&amp;lt;img src=&amp;quot;bild.gif&amp;quot; id=&amp;quot;bild&amp;quot; alt=&amp;quot;ein Bild&amp;quot; /&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Schlie&amp;szlig;lich gibt es noch eine &amp;Auml;nderung hinsichtlich des Einbaus von
 	&lt;a href=&quot;javascript.shtml&quot;&gt;Javascript&lt;/a&gt;, weil Kommentare von XML-Browsern
 	ignoriert werden d&amp;uuml;rfen muss ein CDATA-Bereich eingebaut werden:&lt;/p&gt;
&lt;pre&gt;
&amp;lt;script type=&amp;quot;text/javascript&amp;quot;&amp;gt;
  &amp;lt;!--
  ...[Javascript-Anweisungen]...
  //--&amp;gt;
&amp;lt;/script&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Wird in XHTML zu:&lt;/p&gt;
&lt;pre&gt;
&amp;lt;script type=&amp;quot;text/javascript&amp;quot;&amp;gt;
  // &amp;lt;![CDATA[
  ...[Javascript-Anweisungen]...
  // ]]&amp;gt;
&amp;lt;/script&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Und nat&amp;uuml;rlich muss dem Browser mitgeteilt werden, dass er jetzt XHTML
 	verarbeiten soll. Das erfolgt mit der DOCTYPE-Definition (DTD), die ganz oben im
 	Dokument stehen muss:&lt;/p&gt;
&lt;pre&gt;
&amp;lt;!DOCTYPE [DOCTYPE-Definition]&amp;quot;&amp;gt;
&amp;lt;html xmlns=&amp;quot;http://www.w3.org/1999/xhtml&amp;quot; xml:lang=&amp;quot;de&amp;quot;&amp;gt;
&amp;lt;head&amp;gt; ...[Metaangaben, Titel usw.]... &amp;lt;/head&amp;gt;
&amp;lt;body&amp;gt; ...[Dokumentinhalt]... &amp;lt;/body&amp;gt;
&amp;lt;/html&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Die zus&amp;auml;tzlichen Angaben im html-Tag legen die Sprache fest.&lt;/p&gt;
&lt;p&gt;Es stehen verschiedene DTDs zur Auswahl, die je nach Bedarf eingesetzt
 	werden k&amp;ouml;nnen:&lt;/p&gt;
&lt;p&gt;XHTML 1.0 Strict (Trennt Inhalt und Layout - in Verbindung mit
 		&lt;a title=&quot;Cascading Style Sheets&quot; href=&quot;css.shtml&quot;&gt;CSS&lt;/a&gt;):&lt;/p&gt;
&lt;pre&gt;
&amp;lt;!DOCTYPE html PUBLIC &amp;quot;-//W3C//DTD XHTML 1.0 Strict//EN&amp;quot;
&amp;quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd&amp;quot;&amp;gt;
&lt;/pre&gt;
&lt;p&gt;XHTML 1.0 Transitional (F&amp;uuml;r den &amp;Uuml;bergang von HTML3.2, oder wenn iframes
 		und Target benutzt werden soll):&lt;/p&gt;
&lt;pre&gt;
&amp;lt;!DOCTYPE html PUBLIC &amp;quot;-//W3C//DTD XHTML 1.0 Transitional//EN&amp;quot;
&amp;quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&amp;quot;&amp;gt;
&lt;/pre&gt;
&lt;p&gt;XHTML 1.0 Frameset (F&amp;uuml;r den Einsatz von Frames):&lt;/p&gt;
&lt;pre&gt;
&amp;lt;!DOCTYPE html PUBLIC &amp;quot;-//W3C//DTD XHTML 1.0 Frameset//EN&amp;quot;
&amp;quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd&amp;quot;&amp;gt;
&lt;/pre&gt;
&lt;p&gt;XHTML 1.1 (Modulares XHTML. Hier k&amp;ouml;nnen zus&amp;auml;tzliche Module
 		geladen werden):&lt;/p&gt;
&lt;pre&gt;
&amp;lt;!DOCTYPE html PUBLIC &amp;quot;-//W3C//DTD XHTML 1.1//EN&amp;quot;
&amp;quot;http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd&amp;quot;&amp;gt;
&lt;/pre&gt;
&lt;p&gt;Eine Version 2.0 ist in Arbeit, wird aber voraussichtlich nicht mehr
 	abw&amp;auml;rtskompatibel sein.&lt;/p&gt;
&lt;h4&gt;Vorteile&lt;/h4&gt;
&lt;p&gt;Im Internet findet ein &amp;Uuml;bergang zu XML statt, mit der Daten
 	viel besser repr&amp;auml;sentiert werden k&amp;ouml;nnen, da diese Sprach auch f&amp;uuml;r
 	Maschinen besser Lesbar ist. Damit k&amp;ouml;nnen Daten inhaltlich verkn&amp;uuml;pft
 	und inhaltliche Zusammenh&amp;auml;nge werden ersichtlich.&lt;/p&gt;
&lt;p&gt;XHTML ist ein einfach umzusetzender erster Schritt zum semantischen
 	Web, das nicht mehr nur Texte und Informationen anh&amp;auml;uft, sondern
 	zusammenh&amp;auml;ngende Informationen versteht und zeigt.&lt;/p&gt;
&lt;p&gt;Mit XHTML sind die Dokumente deutlich klarer strukturiert, logisch aufgebaut und
 	lassen sich leichter Warten, was gerade bei der zunehmenden Kommerzialisierung und
 	in Unternehmen klare Vorteile bietet&lt;/p&gt;
&lt;p&gt;Die klare Struktur und die festen Regeln machen das Netz zuverl&amp;auml;ssiger und
 	erlauben die Nutzung auf mehr unterschiedlichen Ger&amp;auml;ten - auch Bildschirmleseger&amp;auml;te
 	und Braillezeilen f&amp;uuml;r Blinde und Sehbehinderte. Damit wird das Netz
 	Barrierefreier und leichter nutzbar f&amp;uuml;r breitere Bev&amp;ouml;lkerungsgruppen.&lt;/p&gt;
&lt;h4&gt;Links&lt;/h4&gt;
&lt;p&gt;&lt;a href=&quot;http://www.barrierefreies-webdesign.de/referenz/xhtml-und-html.php&quot;&gt;Die Unterschiede zwischen XHTML und HTML&lt;/a&gt;&lt;/p&gt;
&lt;p&gt;&lt;a href=&quot;http://de.selfhtml.org/&quot;&gt;SELFHTML - HTML-Dateien selbst erstellen&lt;/a&gt;&lt;/p&gt;
&lt;p&gt;&lt;a hreflang=&quot;en&quot; href=&quot;http://www.alistapart.com/articles/betterliving/&quot;&gt;Better Living Through XHTML&lt;/a&gt;&lt;/p&gt;", "XHTML ist die XML-Erweiterung zu HTML, d.h. jeder Tag muss einen Abschluss haben und es sind bei den einzelnen Tags strenge Regeln hinsichtlich der verwendeten Attribute und der Verschachtelung einzuhalten.", "2008-01-23 00:00:00", "2011-05-17 15:03:09", "0");

-- # Schnipp --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("46", "1", "2", "Fehlermeldungen", "Fehlermeldungen", "Fehlermeldungen", "Fehlermeldungen", "F", "<p>Interne Seite f�r Fehlermeldungen.</p>
<p>(Positionsnummer = Fehlernummer)</p>", "Fehlermeldungen", "2011-09-23 00:00:00", "2013-02-05 16:35:57", "0"),
("46", "3", "2", "Messages", "Messages", "Messages", "Messages", "F", "<p>Interne Seite für Fehlermeldungen.</p>
<p>(Positionsnummer = Fehlernummer)</p>", "Messages", "2011-09-23 00:00:00", "2012-10-22 07:39:02", "0"),
("47", "1", "2", "Beratung, Coaching und Consulting", "Beratung, Coaching und Consulting", "Beratung_Coaching_und_Consulting", "Beratung, Coaching und Consulting", "", "<p>In jeder Lebens- oder Unternehmenslage der richtige Ansprechpartner.&nbsp;</p>
", "In jeder Lebens- oder Unternehmenslage der richtige Ansprechpartner. ", "2013-04-16 00:00:00", "2016-05-21 10:14:01", "0"),
("47", "3", "2", "Coaching and Consulting", "Coaching and Consulting", "Coaching_and_Consulting", "Coaching and Consulting", "", "<p>In every life or business situation the right partner.&#160;<br />
</p>", "In every life or business situation the right partner.", "2013-04-16 00:00:00", "2013-10-15 15:25:29", "0"),
("48", "1", "2", "BingSiteAuth.xml", "", "BingSiteAuth.xml", "BingSiteAuth.xml", "", "", "", "2013-11-14 00:00:00", "2013-11-21 15:04:06", "1"),
("77", "1", "2", "alle Seiten", "alle Seiten", "alle_Seiten", "alle Seiten", "a", "", "alle Seiten", "2010-12-21 00:00:00", "2019-09-23 13:20:11", "0"),
("77", "2", "2", "alle Seiten", "alle Seiten", "alle_seiten", "alle Seiten", "a", "<p><br />
&#160;</p>
<p>&#160;</p>", "alle Seiten", "2011-09-26 00:00:00", "2012-09-24 15:12:24", "0"),
("77", "3", "2", "all pages", "", "all_pages", "all pages", "a", "<p><br />
&nbsp;</p>

<p>&nbsp;</p>
", "alle Seiten", "2011-09-07 00:00:00", "2017-06-25 14:27:05", "0"),
("77", "4", "2", "alle Seiten", "alle Seiten", "alle_Seiten", "alle Seiten", "", "", "alle Seiten", "2013-10-23 00:00:00", "2013-10-23 15:07:09", "0"),
("78", "1", "2", "Login", "Login", "Login", "Login", "L", "", "Login", "2010-01-20 00:00:00", "2013-03-08 10:29:40", "0"),
("78", "3", "2", "Login", "Login", "Login", "Login", "", "", "Login", "2019-09-23 00:00:00", "2019-09-23 11:50:09", "0"),
("79", "1", "2", "Logout", "Logout", "Logout", "Logout", "", "", "Logout", "0000-00-00 00:00:00", "2010-01-20 09:24:28", "0"),
("99", "1", "10", "Personenstatus", "Personenstatus", "Personenstatus", "Personenstatus", "", "", "", "0000-00-00 00:00:00", "2010-05-21 07:14:47", "0"),
("99", "3", "2", "person status", "", "person_status", "person status", "P", "<p><br />
</p>", "", "2012-02-23 00:00:00", "2012-03-06 09:14:19", "0"),
("100", "1", "2", "sitemap.xml", "", "sitemap.xml", "sitemap.xml", "s", "<p><br />
</p>", "", "2010-08-06 00:00:00", "2011-09-07 17:44:22", "1"),
("100", "2", "2", "sitemap.xml", "", "sitemap.xml", "sitemap.xml", "s", "", "", "2012-09-21 00:00:00", "2012-09-21 16:35:20", "0"),
("100", "3", "2", "sitemap.xml", "", "sitemap.xml", "sitemap.xml", "s", "<p>&#160;<br />
</p>", "", "2011-09-07 00:00:00", "2011-09-07 17:44:01", "0"),
("101", "1", "2", "robots.txt", "", "robots.txt", "robots.txt", "r", "<p><br />
&#160;</p>
<p>&#160;</p>", "", "2010-08-06 00:00:00", "2012-05-17 09:31:14", "1"),
("101", "3", "2", "robots.txt", "", "robots.txt", "robots.txt", "r", "<p><br />
&#160;</p>
<p>&#160;</p>", "", "2012-09-21 00:00:00", "2012-09-21 16:34:38", "0"),
("102", "1", "2", "Praxis - Techniken - mySQL", "mySQL", "mySQL", "mySQL", "m", "<p>In enger Verbindung mit PHP hat sich mySQL für Datenbankanwendung im Internet praktisch durchgesetzt.</p>
<p>mySQL unterstützt nicht so viele Funktionen, wie andere Datenbanken, aber für die meisten Anwendungen ist es völlig ausreichend und durch die Unterstützung von PHP recht einfach einzusetzen.</p>", "In enger Verbindung mit PHP hat sich mySQL für Datenbankanwendung im Internet praktisch durchgesetzt.", "2011-01-15 00:00:00", "2012-05-17 10:09:37", "0"),
("103", "1", "2", "Praxis - Techniken - PHP", "PHP", "PHP", "PHP", "P", "&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;PHP ist eine serverseitige Skriptsprache, die Anfragen des Nutzers auswertet und bearbeitet, so lassen sich Webseiten dynamisch und dem Kundenwunsch entsprechend erstellen. Letzteres ist z. B. in Zusammenhang mit Datenbankanwendungen interessant, wenn Produktinformationen abgefragt werden und nicht f&amp;uuml;r jedes Angebot eine Internetseite erstellt werden soll.&lt;/p&gt;
&lt;p&gt;Die durch PHP erstellten Seiten sollten von Suchmaschinen eigentlich genauso indiziert werden wie statische Seiten, da sie vom Server erstellt werden und die Roboter den zu Grunde liegenden Code gar nicht zu sehen bekommen. Das funktioniert um so besser, wenn man Pfade (URLs) zu den einzelnen Seiten erzeugt, die lesbar sind und nicht aus kryptischen Zahlen und Buchstabenfolgen bestehen.&lt;/p&gt;", "PHP ist eine serverseitige Skriptsprache, die Anfragen des Nutzers auswertet und bearbeitet, so lassen sich Webseiten dynamisch und dem Kundenwunsch entsprechend erstellen. Letzteres ist z. B. in Zusammenhang mit Datenbankanwendungen interessant.", "2011-01-15 00:00:00", "2011-05-17 15:03:35", "0"),
("104", "1", "2", "Praxis - Techniken - AJAX", "AJAX", "AJAX", "AJAX", "A", "<p>AJAX verbindet Javascript (Benutzerseitig ausgeführte Skripte) mit Programmteilen, die auf dem Server ausgeführt werden. Damit erhält der Programmierer die Möglichkeit dynamisch Inhalte nachzuladen oder Benutzereingaben zu verarbeiten, ohne dass eine Seite neu geladen werden muss. Die neuen Möglichkeiten werden allerdings mit Schwierigkeiten bei der Barrierefreiheit erkauft, da dem Benutzer nicht immer signalisiert wird, was sich wo auf der Seite geändert hat.</p>", "AJAX verbindet Javascript (Benutzerseitig ausgeführte Skripte) mit Programmteilen, die auf dem Server ausgeführt werden. Damit erhält der Programmierer die Möglichkeit dynamisch Inhalte nachzuladen oder Benutzereingaben zu verarbeiten.", "2011-01-15 00:00:00", "2012-05-17 10:11:08", "0"),
("105", "1", "2", "Praxis - Techniken - Flash", "Flash", "Flash", "Flash", "F", "<p>Interessant bei Flash ist die Skalierbarkeit in unterschiedlichen Bildschirmauflösungen, die sich oft nur im Vektorformat realisieren lassen und natürlich der bewegte Inhalt.</p>
<p>Da das Plugin heute mit fast jedem Browser mitgeliefert wird, ist die Verbreitung zweifellos kein Kriterium mehr, das gegen den Einsatz sprechen würde (einige Mobile Geräte verweigern sich allerdings dagegen).</p>
<p>Viele der Aufgaben, für die Flash eingesetzt wird, lassen sich aber auch mit Javascript lösen - wenn auch nicht immer so hübsch animiert.</p>
<p>Auch Flash wird nicht von allen Suchmaschinen erkannt und indiziert.</p>", "Interessant bei Flash ist die Skalierbarkeit in unterschiedlichen Bildschirmauflösungen, die sich oft nur im Vektorformat realisieren lassen und natürlich der bewegte Inhalt.", "2011-01-15 00:00:00", "2012-05-17 10:11:18", "0"),
("107", "1", "2", "Service - M-CMS: Mit einem Redaktionssystem verwalten Sie Ihre Inhalte, Texte und Bilder selbst", "M-CMS: Mit unserem Redaktionssystem verwalten Sie Ihre Inhalte, Texte und Bilder selbst", "M-CMS_-_Redaktionssystem", "M-CMS - Redaktionssystem", "R", "<p><img class=\"right\" alt=\"M-CMS Logo\" width=\"100\" height=\"100\" src=\"/images/weitere/mcms_logo_1.jpg\" />Das Redaktionssystem <a href=\"http://www.m-cms.de/\">M-CMS</a> ist auf Suchmaschinen­freundlichkeit und Barrierefreiheit ausgelegt und bietet gleichzeitig weitgehende Freiheiten hinsichtlich Gestaltung, Aufbau und Mehrsprachigkeit.</p>
<h4>Die wichtigsten Eigenschaften</h4>
<ul>
	<li><strong>Mehrsprachigkeit</strong>:  M-CMS unterstützt mehrere Sprachen, darunter auch solche mit nichteuropäischen Schriftsätzen, wie arabisch, mandarin oder kyrillisch (mit den jeweiligen Zeichensätzen, oder UTF-8). Sprachversionen des selben Inhalts sind mit einander verknüpft, so dass man schnell zwischen den Sprachen wechseln kann, aber es muss nicht jede Seite auch in jeder Sprache existieren.</li>
	<li><strong>Barrierefreiheit/-armut</strong>: Links und Bilder können mit Alternativtexten versehen werden (Für sehbehinderte Nutzer und Suchmaschinen) und es gibt Sprungmarken, um schnell zum Menü oder dem Seiteninhalt zu kommen. Tastaturbedienung wird unterstützt.</li>
	<li><strong>Facebook &amp; Co. mit RSS</strong>:  Jede Seite kann als RSS-Feed eingerichtet werden, diese können zum Beispiel bei Facebook über Graffiti als Statusmeldung erscheinen, so brauchen Sie nur ihre eigenen Homepage zu pflegen und ihre Netzwerke bleiben auf dem laufenden (und ihre Fans auch, denn einen RSS-Feed kann jeder abonnieren).</li>
	<li><strong>Vorschau</strong>: Mit der Vorschaufunktion sehen Sie, wie die Webpräsenz aussehen wird, noch bevor sie die Änderungen abspeichern.</li>
	<li><strong>Suchmaschinenoptimierung</strong>: Schlüsselwörter pickt sich das System selbstständig aus Ihrem Text. Es kann zu jeder Unterseite ein Titel und eine Beschreibung angegeben werden. Das System erstellt automatisch eine \"<a href=\"#LINKTO:100#\">Sitemap.xml</a>\" mit den Änderungsdaten der Seiten, die von Google ausgewertet wird.<br />
	(Und das streben nach Barrierefreiheit nutzt immer auch den Suchmaschinen).</li>
	<li><strong>Statische URLs</strong>: Die Verlinkung der Seiten geschieht im Klartext, das heißt, es tauchen in den Links keine kryptischen Zeichen auf. Der Besucher weiß immer, wo er sich befindet und Suchmaschinen sehen unterschiedliche Seiten und nicht eine Seite, deren Inhalt sich ändert.</li>
	<li><strong>Webstandards</strong>: Webstandards, wie XHTML oder HTML5 und CSS werden selbstverständlich ohne Abstriche unterstützt, so bleibt Ihre Webseite Zukunftssicher.</li>
	<li><strong>Formulare</strong>: Die Eingaben werden überprüft und es werden aussagekräftige Fehlermeldungen angezeigt. In der Verwaltung kann ausgewählt werden welche Felder ausgefüllt werden sollen. Felder, bei denen Eingaben fehlen werden, farblich hervorgehoben.</li>
	<li><strong>Vorlagensystem</strong>: Was M-CMS so mächtig macht, ist sein Vorlagensystem, ob Galerie, Kontaktformular, Linksammlung. Damit lässt sich jede Seite individualisieren und besonderen Anforderungen anpassen. Es gibt die Möglichkeit Funktionen (wie zum Beispiel einen interaktiven Kalender) direkt aus der Vorlage heraus aufzurufen und zu integrieren. Zusammen mit dem flexiblen Pluginsystem lässt sich so nahezu jede Anwendung realisieren (Shop, Portale und andere Datenbankanwendungen sind so bereits entstanden).</li>
	<li><strong>Optimierung</strong>: Durch die Optimierung der Datenbankabfragen sind selbst größere Anwendungen schnell verfügbar und man braucht nicht lange auf die Seite zu warten. Unterstützt wird dies noch durch einen eingebauten Cache, welcher die Seiten zwischenspeichert und sie so noch schneller ausliefern kann. So dauert die Generierung einer Seite oftmals weniger als 200 ms.<br />
	&#160;	Die Datenmenge, die übertragen wird, wird durch optimierte Grafiken und Bilder gering gehalten. Das schont Bandbreite und Ressourcen.</li>
	<li><strong>Individuell</strong>: Das Redaktionssystem wird immer an die Bedürfnisse des Kunden angepasst. So ist Ihre Corporate Identity auf jeder Seite sichtbar.</li>
	<li><strong>Kosten</strong>: Da die Entwicklungsarbeit bereits geleistet ist, fallen für die Einrichtung nur geringe Kosten an und da die Verwaltung sehr einfach ist entstehen praktisch keine Kosten mehr, sobald Sie Ihre Webseiten selbst verwalten.</li>
	<li><strong>Aus alt mach neu</strong>: Ihnen gefällt ihre Webseite, so wie sie ist, aber sie möchten trotzdem alle oben genannten Vorteile nutzen. M-CMS lässt sich praktisch hinter jede beliebige Webseite setzen (nur nicht bei Flash-Seiten).</li>
</ul>
<h4>Referenzen</h4>
<p>�FETCHIMAGE:PAGE_ID=12;order=random;avisi=1;aexcl=1� Fast jede Seite, die Sie in unseren <a href=\"#LINKTO:9#\">Referenzen</a> sehen und alle <a href=\"#LINKTO:12#\">Partnerseiten</a> sind mit <a href=\"http://www.m-cms.de/\">M-CMS</a> entstanden. (Sind Sie selbst Grafiker und k�nnen sich so etwas f�r Ihre Kunden vorstellen? Dann nehmen Sie <a href=\"#LINKTO:30#\">Kontakt</a> auf.)</p>", "Das Redaktionssystem M-CMS ist auf Suchmaschinenfreundlichkeit und Barrierefreiheit ausgelegt und bietet gleichzeitig weitgehende Freiheiten hinsichtlich Gestaltung, Aufbau und Mehrsprachigkeit.", "2011-04-19 00:00:00", "2013-10-24 17:50:54", "0"),
("107", "3", "2", "Service - M-CMS: a content management system for managing your web site contents", "M-CMS: a content management system for managing your web site contents", "M-CMS_-_Content_Management_System", "M-CMS - Content Management System", "M", "<p><img alt=\"M-CMS Logo\" class=\"right\" height=\"100\" src=\"/images/weitere/mcms_logo_1.jpg\" width=\"100\" />The content management system M-CMS is designed for search engine friendliness and accessibility. It offers extensive freedom in terms of design, structure and multilingualism of web sites.</p>

<h4>The Most Important Features</h4>

<ul>
	<li><strong>Multilingual</strong>: M-CMS supports multiple languages, including those with non-european charachters, such as arabic, mandarin or cyrillic (with the respective character sets or UTF-8). Language versions of the same content are associated with each other, so that you can quickly switch between the languages.</li>
	<li><strong>Accessibility</strong>: Links and images can be provided with alternative texts (for visually impaired users and search engines) and there are labels to get quickly to the menu or the page content. Keyboard operation is supported.</li>
	<li><strong>Preview</strong>: Using the preview function you see how the website will look before you save the changes.</li>
	<li><strong>Search engine optimization</strong>: the system picks keywords from your text. A title and description can be specified to each page. M-CMS automatically creates a \"Sitemap\" with the change data for the pages that will be evaluated by Google.</li>
	<li><strong>Static URLs</strong>: the linking of pages is done in plain text. The visitor always knows where he is, and search engines see different pages.</li>
	<li><strong>Web standards</strong>: Web standards, like XHTML or HTML5 and CSS are supported of course.</li>
	<li><strong>Forms</strong>: Check the input and display meaningful error messages. In the Administration you can select which fields should be filled out. Fields in which entries are missing, are highlighted.</li>
	<li><strong>Template system</strong>: What makes M-CMS so powerful is its template system, Gallery, contact form, link collection. Thus, each page can be customized to specific requirements. There is the possibility to integrate and call functions (such as for example an interactive calendar) directly from the template. Together with the flexible plugin system almost every application can be (shop, portals, and other database applications are developed so already).</li>
	<li><strong>Optimization</strong>: Through the optimization of database queries, even larger applications are readily available and you won't need to wait for the page. This is supported by a built-in cache. This way, the generation of a page takes often less than 200 ms.<br />
	The amount of data that is transferred is kept low through optimized graphics and images as well as compression. This saves bandwidth and resources.</li>
	<li><strong>Individuallity</strong>: The content management system is customized to the customer's needs. So, your corporate identity on each page stays visible.</li>
	<li><strong>From old to new</strong>: You like your webpage as it is, but you want to use all the benefits mentioned above. M-CMS can be implementnted behind almost any Web page (exept for Flash sites).</li>
</ul>

<h4>References</h4>

<p>§FETCHIMAGE:PAGE_ID=12;order=random;avisi=1;aexcl=1§ Most of the pages in our <a href=\"#LINKTO:9#\">refereces</a> an all pages of our <a href=\"#LINKTO:12#\">partners</a> are created with <a href=\"http://www.m-cms.de/en\">M-CMS</a>.</p>
", "The content management system M-CMS is designed for search engine friendliness and accessibility. It offers  extensive freedom in terms of design, structure and multilingualism of web sites.", "2011-09-08 00:00:00", "2014-07-21 16:50:04", "0"),
("108", "1", "2", "galerie", "", "galerie", "galerie", "g", "<p>§REDIRECT:http://fotografie.marcus-haas.de/Galerien/Tiere/Unterwasserfotografie/Kenia§</p>", "", "2012-03-14 00:00:00", "2012-05-17 09:42:29", "0"),
("109", "1", "2", "Neue Referenzen", "", "rss.xml", "RSS", "R", "", "Neue Webseiten die wir erstellt haben und Partner mit denen wir zusammen arbeiten.", "2012-09-21 00:00:00", "2016-05-21 11:17:06", "1"),
("109", "3", "2", "New References", "", "rss", "RSS", "R", "", "New homepages and partners", "2012-09-24 00:00:00", "2012-09-24 15:11:50", "0");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten_attr`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten_attr` (
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  `KAT_ID` smallint(5) NOT NULL DEFAULT '1',
  `TPL_ID` smallint(5) NOT NULL DEFAULT '1',
  `parent_ID` smallint(5) NOT NULL DEFAULT '0',
  `person_ID` int(11) NOT NULL DEFAULT '0',
  `position` smallint(3) DEFAULT '99',
  `order_by` varchar(15) NOT NULL,
  `visibility` smallint(1) DEFAULT '1',
  `status` smallint(1) DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  PRIMARY KEY  (`TPL_ID`,`KAT_ID`,`PAGE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten_attr # --
INSERT INTO `#PREFIX#seiten_attr` (`PAGE_ID`,`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("1", "1", "49", "0", "2", "1", "PO_ASC", "1", "0", "1", "2"),
("2", "1", "49", "0", "2", "2", "", "1", "0", "3", "18"),
("3", "1", "1", "2", "2", "21", "", "1", "0", "4", "5"),
("4", "1", "1", "2", "2", "22", "", "1", "0", "6", "7"),
("5", "1", "1", "2", "2", "23", "", "1", "0", "10", "11"),
("6", "1", "1", "2", "2", "24", "", "1", "0", "12", "13"),
("7", "1", "1", "2", "2", "25", "", "1", "0", "14", "15"),
("8", "1", "1", "2", "2", "26", "", "1", "0", "16", "17"),
("9", "1", "49", "0", "2", "3", "", "1", "0", "19", "42"),
("10", "2", "1", "0", "2", "7", "", "1", "0", "49", "96"),
("11", "1", "1", "10", "2", "1", "", "1", "0", "50", "51"),
("12", "1", "31", "0", "2", "12", "PO_ASC", "1", "0", "47", "48"),
("13", "1", "1", "10", "2", "44", "", "1", "0", "68", "87"),
("14", "1", "1", "10", "2", "45", "", "1", "0", "88", "89"),
("15", "1", "1", "10", "2", "43", "", "1", "0", "52", "67"),
("16", "1", "1", "15", "2", "441", "PO_ASC", "1", "0", "53", "54"),
("17", "1", "1", "15", "2", "442", "PO_ASC", "0", "0", "55", "56"),
("18", "1", "1", "15", "2", "443", "PO_ASC", "0", "0", "57", "58"),
("19", "1", "1", "15", "2", "444", "PO_ASC", "1", "0", "59", "60"),
("20", "1", "1", "15", "2", "445", "", "0", "0", "61", "62"),
("21", "1", "1", "15", "2", "446", "", "1", "0", "63", "64"),
("22", "1", "1", "15", "2", "447", "PO_ASC", "1", "0", "65", "66"),
("23", "1", "1", "10", "2", "46", "", "0", "0", "90", "91"),
("24", "1", "1", "10", "2", "47", "", "0", "0", "92", "93"),
("25", "1", "1", "10", "2", "48", "", "0", "0", "94", "95"),
("26", "2", "1", "0", "2", "9", "", "1", "0", "99", "100"),
("27", "4", "1", "0", "2", "10", "", "1", "0", "101", "102"),
("28", "1", "1", "0", "2", "6", "", "1", "0", "45", "46"),
("29", "2", "1", "0", "2", "8", "", "1", "0", "97", "98"),
("30", "1", "5", "0", "2", "5", "PO_ASC", "1", "0", "43", "44"),
("31", "1", "31", "9", "2", "2", "PUB_DESC", "1", "0", "22", "23"),
("32", "1", "31", "9", "2", "6", "PUB_DESC", "1", "0", "30", "31"),
("33", "1", "31", "9", "2", "5", "PUB_DESC", "1", "0", "28", "29"),
("34", "1", "31", "9", "2", "4", "PUB_DESC", "1", "0", "26", "27"),
("35", "1", "31", "9", "2", "7", "PUB_DESC", "1", "0", "32", "33"),
("36", "1", "31", "9", "2", "8", "PUB_DESC", "1", "0", "34", "35"),
("37", "1", "31", "9", "2", "9", "PO_ASC", "0", "0", "36", "37"),
("38", "1", "31", "9", "2", "10", "PUB_DESC", "1", "0", "38", "39"),
("39", "1", "31", "9", "2", "11", "P_ASC", "1", "0", "40", "41"),
("40", "1", "31", "9", "2", "1", "PUB_DESC", "1", "0", "20", "21"),
("41", "1", "1", "13", "2", "1", "", "1", "0", "69", "70"),
("42", "1", "1", "13", "2", "7", "", "1", "0", "81", "82"),
("43", "1", "1", "13", "2", "6", "", "1", "0", "79", "80"),
("44", "1", "1", "13", "2", "2", "", "1", "0", "71", "72"),
("45", "1", "1", "13", "2", "3", "", "1", "0", "73", "74"),
("46", "5", "43", "77", "2", "11", "PO_ASC", "0", "0", "118", "119"),
("47", "1", "31", "9", "2", "3", "PUB_DESC", "1", "0", "24", "25"),
("48", "3", "2", "0", "2", "18", "", "1", "0", "113", "114"),
("77", "5", "36", "0", "2", "19", "PO_ASC", "0", "0", "117", "122"),
("78", "3", "38", "0", "2", "12", "PO_ASC", "1", "0", "103", "104"),
("79", "3", "1", "0", "2", "13", "PO_ASC", "1", "0", "105", "106"),
("99", "5", "43", "77", "2", "15", "PO_ASC", "0", "0", "120", "121"),
("100", "3", "44", "0", "2", "14", "PO_ASC", "1", "0", "107", "108"),
("101", "3", "46", "0", "2", "99", "PO_ASC", "1", "0", "115", "116"),
("102", "1", "1", "13", "2", "5", "", "1", "0", "77", "78"),
("103", "1", "1", "13", "2", "4", "", "1", "0", "75", "76"),
("104", "1", "1", "13", "2", "8", "", "1", "0", "83", "84"),
("105", "1", "1", "13", "2", "9", "", "1", "0", "85", "86"),
("107", "1", "1", "2", "2", "22", "", "1", "0", "8", "9"),
("108", "3", "1", "0", "2", "16", "", "1", "0", "109", "110"),
("109", "3", "51", "0", "2", "17", "", "1", "0", "111", "112");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten_personen`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten_personen` (
  `person_ID` varchar(15) NOT NULL,
  `attr` varchar(15) NOT NULL,
  `attr_ID` varchar(11) NOT NULL,
  PRIMARY KEY  (`person_ID`,`attr_ID`,`attr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten_personen # --
INSERT INTO `#PREFIX#seiten_personen` (`person_ID`,`attr`,`attr_ID`) VALUES
("1", "1_pages", "1"),
("1", "2_statistik", "1"),
("1", "Benutzer", "1"),
("1", "KAT_ID", "alles"),
("1", "PAGE_ID", "alles"),
("1", "TPL_ID", "alles"),
("1", "move", "1"),
("1", "nosave", "1"),
("1", "pages", "1"),
("1", "rem", "1"),
("1", "such", "1"),
("1", "vis", "1"),
("2", "1_admin_mysql", "1"),
("2", "1_categories", "1"),
("2", "1_pages", "1"),
("2", "2_statistik", "1"),
("2", "2_templates", "1"),
("2", "3_languages", "1"),
("2", "3_translate", "1"),
("2", "4_presets", "1"),
("2", "KAT_ID", "alles"),
("2", "PAGE_ID", "alles"),
("2", "TPL_ID", "alles"),
("2", "kats", "1"),
("2", "lang", "1"),
("2", "move", "1"),
("2", "neu", "1"),
("2", "pages", "1"),
("2", "rem", "1"),
("2", "subp", "1"),
("2", "such", "1"),
("2", "tpl", "1"),
("2", "vis", "1");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#seiten_redirects`;
-- # Schnipp --
CREATE TABLE `#PREFIX#seiten_redirects` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `ex_kurzname` varchar(65) NOT NULL DEFAULT '',
  `PAGE_ID` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=seiten_redirects # --
INSERT INTO `#PREFIX#seiten_redirects` (`ID`,`ex_kurzname`,`PAGE_ID`) VALUES
("26", "computerkurse.shtml", "11"),
("28", "tipps", "15"),
("29", "techniken", "13"),
("30", "cms.shtml", "41"),
("31", "philosophie.shtml", "14"),
("32", "anwendungen.shtml", "23"),
("34", "PHP-Experimente", "24"),
("35", "erfahrung.shtml", "25"),
("37", "programmierung.shtml", "5"),
("39", "hosting.shtml", "7"),
("40", "notfall.shtml", "8"),
("45", "iehintergrungflackern.shtml", "20"),
("46", "links.shtml", "26"),
("47", "links2.shtml", "27"),
("48", "xhtml.shtml", "45"),
("50", "ssi.shtml", "43"),
("51", "javascript.shtml", "42"),
("58", "Personal_pages", "38"),
("72", "beratung.shtml", "3"),
("75", "Praxis", "10"),
("82", "Partners", "12"),
("84", "Service", "2"),
("85", "Fehlermeldungen", "46"),
("87", "Personenstatus", "99"),
("88", "cssmenuliste.shtml", "16"),
("89", "index.php", "108"),
("90", "Partner", "12"),
("91", "Erfahrung", "10"),
("93", "Webdesign-Service", "2"),
("94", "conditionalcomments.shtml", "19"),
("98", "erwachsene.shtml", "10"),
("101", "kontakt.php", "30"),
("102", "galerie", "39"),
("103", "php.shtml", "103"),
("104", "tipps.shtml", "15"),
("106", "Service", "2"),
("109", "References_-_health_and_quality_of_life", "34"),
("115", "marcus.txt", "40"),
("117", "iefilter.shtml", "21"),
("118", "css.shtml", "44"),
("123", "alle_seiten", "77"),
("125", "Unterhaltung_Freizeit_Events", "32"),
("128", "agrave_curren_agrave_curren_sup2_agrave_curren_frac34_agrave_curr", "33"),
("129", "agrave_curren_cedil_agrave_curren_frac34_agrave_curren", "9"),
("130", "Startseite", "1"),
("131", "Web_design", "4"),
("132", "M-CMS_-_Content_management_system", "107"),
("133", "SEO", "6"),
("134", "Oslash_uml_Oslash_micro_Ugrave_Oslash_copy", "28"),
("135", "Oslash_uml_Oslash_micro_Ugrave_Oslash_copy", "28"),
("136", "Vereine_und_Verbaende", "36"),
("137", "Vereine_und_Verbaende", "36"),
("138", "Unternehmer_Selbststaendige_und_Freiberufler", "31"),
("139", "Unternehmer_Selbststaendige_und_Freiberufler", "31");
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
("alle_sprachen", "1"),
("bildfixed", "width"),
("bildx", "500"),
("bildy", "500"),
("bodyclass", "inhalt"),
("bodyid", "inhalt"),
("cleanword", "1"),
("compress", "1"),
("css_path", "templates/css"),
("fontformats", "p;h3;h4;pre"),
("galeriebildx", "500"),
("galeriebildy", "500"),
("galeriefixed", "fit"),
("galerievorschaufixed", "width"),
("galerievorschaux", "250"),
("galerievorschauy", "250"),
("hintergrund2bildx", ""),
("hintergrund2bildy", ""),
("hintergrund2fixed", "fit"),
("hintergrundbildx", ""),
("hintergrundbildy", ""),
("hintergrundfixed", "fit"),
("https_domain", ""),
("img_path", "images/bilder"),
("js_path", "templates/js"),
("kategal", "1"),
("kontakt_seite", "30"),
("last_change", "23.09.2019 13:24"),
("logout_seite", "78"),
("meldungen_seite", "46"),
("menubildx", ""),
("menubildy", ""),
("menufixed", "fit"),
("menuvorschaux", ""),
("menuvorschauy", ""),
("mysql_backup", "2021-03-28"),
("nohtmlsubp", "0"),
("nonumsubp", "0"),
("passwortvergessen_seite", ""),
("redtexth", "300"),
("seiten_tpl", "36"),
("seitenzaehler", "0"),
("select_subject", "2"),
("select_tbs_1", "basic"),
("select_tbs_2", "mini"),
("showblocks", "1"),
("statistics_domain", "stats.§DOMAIN§"),
("statistics_id", "622633"),
("status_seite", "99"),
("statusaenderung_seite", ""),
("template", "<p><br /></p>"),
("texth", "800"),
("tpl_path", "templates/tpl"),
("verwaltung_sprache", "3"),
("videox", "400"),
("videoy", "300"),
("vorschaufixed", "width"),
("vorschaux", "250"),
("vorschauy", "250");
-- # /DUMP # --

-- # Schnipp --

DROP TABLE IF EXISTS `#PREFIX#vorlagen`;
-- # Schnipp --
CREATE TABLE `#PREFIX#vorlagen` (
  `TPL_ID` smallint(5) NOT NULL DEFAULT '0',
  `position` smallint(5) NOT NULL DEFAULT '0',
  `Titel` varchar(255) NOT NULL DEFAULT '',
  `Beschreibung` varchar(255) NOT NULL DEFAULT '',
  `Template` text NOT NULL,
  `script` text NOT NULL,
  `styles` text,
  `JS` varchar(128) NOT NULL,
  `CSS` varchar(128) NOT NULL,
  `anzahl` smallint(5) NOT NULL DEFAULT '1',
  `proseite` smallint(5) NOT NULL,
  `showta` tinyint(1) NOT NULL DEFAULT '1',
  `neu` smallint(3) NOT NULL DEFAULT '0',
  `cache` tinyint(1) NOT NULL DEFAULT '0',
  `stats` tinyint(1) NOT NULL DEFAULT '1',
  `VorschauX` smallint(3) NOT NULL DEFAULT '0',
  `VorschauY` smallint(3) NOT NULL DEFAULT '0',
  `BildX` smallint(3) NOT NULL DEFAULT '0',
  `BildY` smallint(3) NOT NULL DEFAULT '0',
  `vorschaufixed` varchar(12) NOT NULL DEFAULT '',
  `bildfixed` varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (`TPL_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- # Schnipp --

-- # DUMP=vorlagen # --
INSERT INTO `#PREFIX#vorlagen` (`TPL_ID`,`position`,`Titel`,`Beschreibung`,`Template`,`script`,`styles`,`JS`,`CSS`,`anzahl`,`proseite`,`showta`,`neu`,`cache`,`stats`,`VorschauX`,`VorschauY`,`BildX`,`BildY`,`vorschaufixed`,`bildfixed`) VALUES
("1", "1", "Text", "Text", " ", "", "", "", "", "1", "0", "1", "0", "1", "1", "0", "0", "0", "0", "fit", "fit"),
("2", "11", "BingSiteAuth.xml", "Auth for Bing", "<!-- SUB=main_tpl --><?xml version=\"1.0\"?>
<users>
  <user>%BINGAUTH%</user>
</users><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->", "", "", "", "", "1", "0", "0", "1", "1", "0", "250", "250", "500", "500", "fit", "fit"),
("5", "4", "Kontaktformular", "Kontaktformular", "§CONTACT§
<!-- SUB=mailform --><form action=\"\" method=\"post\">
§PHPSESSID§
<div class=\"kontaktformular\">
<p><label for=\"name\">%NAME%:</label>       <input name=\"kontakt[name]\"    type=\"text\"  id=\"name\"    value=\"#NAME#\" /><br />
    <label for=\"strasse\">%STRASSE%:</label><input name=\"kontakt[strasse]\" type=\"text\"  id=\"strasse\" value=\"#STRASSE#\" /><br />
    <label for=\"ort\">%ORT%:</label>        <input name=\"kontakt[ort]\"     type=\"text\"  id=\"ort\"     value=\"#ORT#\" /><br />
    <label for=\"telefon\">%TELEFON%:</label><input name=\"kontakt[telefon]\" type=\"text\"  id=\"telefon\" value=\"#TELEFON#\" /><br />
    <label for=\"email\">%EMAIL%:</label>    <input name=\"kontakt[email]\"   type=\"email\" id=\"email\"   value=\"#EMAIL#\" /><br />
    <label for=\"betreff\">%BETREFF%:</label><input name=\"kontakt[betreff]\" id=\"betreff\" value=\"#BETREFF#\" /><br />
</p>
<p><label for=\"mitteilung\">%MITTEILUNG%:</label>
    <textarea name=\"kontakt[mitteilung]\" cols=\"36\" rows=\"7\" id=\"mitteilung\">#MITTEILUNG#</textarea><br /></p>
</div>
<p style=\"clear:both;\"><input class=\"submit\" name=\"send\" type=\"submit\" id=\"senden\" value=\"%SENDEN%\" /></p>
<p>§PFLICHTFELD§ %PFLICHTFELDER_TEXT%</p>
</form>
<!-- /SUB -->
<!-- SUB=emailbody -->%MAIL_TEXT%<!-- /SUB -->
<!-- SUB=bodyhtml --><html><head><div style=\"font-family:arial,sans-serif;\">#MSG#</div><!-- /SUB -->
<!-- SUB=bodyplain -->#MSG#<!-- /SUB -->", "", "", "", "", "1", "0", "1", "0", "1", "1", "0", "0", "0", "0", "fit", "fit"),
("31", "3", "Referenzen", "", "<!-- SUB=prefix -->§SUBNAV§<!-- /SUB -->
<div class=\"referenz\" id=\"id_%PAGE_ID%_%PART_ID%\">
  <h4 id=\"§MAKE_KN:#FIRST#§\">%TITEL%</h4>
  <p><span><a href=\"http://%WWW%\"><img class=\"left\" src=\"%REFERENZ_BILD%\" alt=\"%WWW% - %TITEL%\" /></a></span> </p> 
  %BESCHREIBUNG_FCK%
  <p><a href=\"http://%WWW%\">%WWW%</a></p>
</div>
<!-- SUB=suffix -->§SUBNAV§<!-- /SUB -->

<!-- SUB=popup --><div class=\"referenz\">
  <h4>%TITEL%</h4>
  §FETCHIMAGE:PART_ID=unterseite_id;tpl=refimg§
  %BESCHREIBUNG_FCK%
  <p><a href=\"http://%WWW%\">%WWW%</a></p>
</div>
<div class=\"flr cb\">#ZURUECK# #TOP# #VOR#
</div>
<!-- /SUB -->

<!-- SUB=refimg --><p><span><a href=\"http://%WWW%\"><img class=\"left\" src=\"$SRC$\" alt=\"%WWW% - %TITEL%\" /></a></span></p><!-- /SUB -->
<!-- SUB=subnavext -->html<!-- /SUB -->


", "", ".referenz {clear:both;min-height:200px}", "", "", "99", "7", "1", "1", "1", "1", "200", "0", "500", "0", "width", "fit"),
("36", "7", "alle Seiten", "", "<!-- SUB=colormain -->%MAIN_COLOR%<!-- /SUB -->
<!-- SUB=coloraccent -->%ACCENT_COLOR%<!-- /SUB -->
<!-- SUB=colorlight -->%LIGHT_COLOR%<!-- /SUB -->
<!-- SUB=colormid -->%MID_COLOR%<!-- /SUB -->
<!-- SUB=colordark -->%DARK_COLOR%<!-- /SUB -->
<!-- SUB=colortext -->%TEXT_COLOR%<!-- /SUB -->

<!-- SUB=headline --><header id=\"headline\">
<p id=\"access\"><a href=\"#text\">%ZUMINHALT%</a> §ODER§ <a href=\"#menu\">%ZUMMENUE%</a>.</p> 
<h1 title=\"§FIRMA§\"><a href=\"#LINKTO:home#\">%HEADLINE%</a></h1>
<h2>%SLOGAN_TEXT%</h2>
</header><!-- /SUB -->
<!-- SUB=geoposition -->%GEOPOSITION%<!-- /SUB -->
<!-- SUB=georegion -->%GEOREGION%<!-- /SUB -->
<!-- SUB=geoplacename -->%GEOPLACENAME%<!-- /SUB -->
<!-- SUB=titleprefix -->%TITELPREFIX%<!-- /SUB -->
<!-- SUB=descriptionprefix -->%DESCRIPTION%<!-- /SUB -->
<!-- SUB=keywordsprefix -->%KEYWORDS%<!-- /SUB -->
<!-- SUB=extern -->%NEUESFENSTER%<!-- /SUB -->

<!-- SUB=seitenvorlage --><h3>#UEBERSCHRIFT#</h3>
$ERROR$
#TEXT#
#ABSCHNITT#<!-- /SUB -->
<!-- SUB=footer --><footer><div class=\"vcard flexcols\" itemscope itemtype=\"http://schema.org/LocalBusiness\">
  <p><span class=\"org\"  itemprop=\"name\">§FIRMA§</span><br />
    <span  class=\"fn n\" itemprop=\"name\">§NAME§</span><br />
    <span  class=\"adr\"  itemscope itemtype=\"http://schema.org/PostalAddress\">
      <span class=\"street-address\" itemprop=\"streetAddress\">§STRASSE§</span><br />
      <span class=\"postal-code\"    itemprop=\"postalCode\">§PLZ§</span>
      <span class=\"locality\"       itemprop=\"addressLocality\">§STADT§</span>
    </span>
  </p>
<p>
    %TEL%    <span class=\"tel\" itemprop=\"telephone\">§TELEFON2§</span><br />
    %MOBIL%: <span class=\"tel\" itemprop=\"telephone\">§MOBIL2§</span><br />
    %WWW%: <span class=\"url\" itemprop=\"url\">§WWW2§</span><br />
   	%EMAIL%: <span class=\"email\" itemprop=\"email\">§EMAIL2§</p>
</div></footer><!-- /SUB -->
<!-- SUB=totop --> <a href=\"#top\" title=\"%OBEN%\" class=\"flr\">^</a> <!-- /SUB -->
<!-- SUB=meta|oicon --><link rel=\"icon\" type=\"§TYPE:%LOGO_BILD%§\" href=\"%LOGO_BILD%\"><!-- /SUB -->
<!-- SUB=meta|rss -->§BRIDGE:PAGE_ID=%RSS_SELECT:seiten%;tpl=rsslink§<!-- /SUB -->
<!-- SUB=meta|google --><meta name=\"google-site-verification\" content=\"%GOOGLEVERFICATION%\" /><!-- /SUB -->
<!-- SUB=rsslink --><link rel=\"alternate\" type=\"application/rss+xml\" title=\"$TITEL$\" href=\"§LINKTO:$PAGE_ID$§\" /><!-- /SUB -->

<!-- SUB=suchformular --><form action=\"#LINKTO:94#\" method=\"post\">
<label style=\"width:250px\">%SUCHBEGRIFF% <input type=\"text\" name=\"search[term]\" value=\"#SUCHBEGRIFF#\"></label>
<input class=\"submit\" type=\"submit\" value=\"%SUCHEN%\">
</form><!-- /SUB -->

<!-- SUB=bridge --><div class=\"bridge\">
<h4><a class=\"tooltip\" href=\"#LINKTO:$PAGE_ID$#\" title=\"$TITEL$\">$MENU$</a></h4>
<p>$BESCHREIBUNG$</p>
<p><a href=\"#LINKTO:$PAGE_ID$#\" title=\"$TITEL$\">$MENU$</a></p>
</div><!-- /SUB -->
<!-- SUB=img --><a href=\"#LINKTO:$PAGE_ID$#\" title=\"§GETDESC:$PAGE_ID$§\"><img class=\"right\" style=\"width:125px;\" src=\"$SRC$\" alt=\"\"></a><!-- /SUB -->

<!-- SUB=top -->%NACHOBEN%<!-- /SUB -->
<!-- SUB=voriges -->%VORIGES%<!-- /SUB -->
<!-- SUB=folgendes -->%FOLGENDES%<!-- /SUB -->
<!-- SUB=ersteseite -->%ERSTESEITE%<!-- /SUB -->
<!-- SUB=letzteseite -->%LETZTESEITE%<!-- /SUB -->
<!-- SUB=und -->%UND%<!-- /SUB -->
<!-- SUB=oder -->%ODER%<!-- /SUB -->
<!-- SUB=vor -->§FOLGENDES§<!-- /SUB -->
<!-- SUB=zurueck -->§VORIGES§<!-- /SUB -->

<!-- SUB=pflichtfeld --><span class=\"error\">%PFLICHT%</span><!-- /SUB -->
<!-- SUB=bgimg -->style=\"background-image:url($IMG$)\"<!-- /SUB -->
<!-- SUB=footer --><div style=\"display:none\">%FOOTER_TEXT%</div><!-- /SUB -->

<!-- SUB=menublock --><ul id=\"$ID$\">$ENTRIES$</ul><!-- /SUB -->
<!-- SUB=menuentry -->    <li class=\"$CLASS$\"><a class=\"§ACTIVE:$PAGE_ID$§\" href=\"/$PATH$§SID§\" accesskey=\"$AK$\" title=\"$BESCHREIBUNG$\" alt=\"$TITEL$\">$MENU$<span></span></a>§SUBMENU:$PAGE_ID$§</li><!-- /SUB -->

<!-- SUB=languageblock --><ul class=\"sprachen\">$ENTRIES$</ul><!-- /SUB -->
<!-- SUB=languageentry --><li><a href=\"$LINK$\" id=\"$SHORT$\" class=\"l_*LANG_ID* $DIRECTION$\">$LANG_LOCAL$</a></li><!-- /SUB -->
<!-- SUB=flag_css -->.sprachen a.l_#L_ID#:hover {color:#ccc;}
.l_#L_ID# .sprachen a.l_#L_ID# {color:#ddd;}<!-- /SUB -->
 ", "", "", "", "styles.css
https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap", "1", "0", "0", "0", "0", "0", "800", "600", "1440", "960", "width", "width"),
("38", "6", "Login", "", "<form action=\"§HTTPSLINKTO:login.php§\" method=\"post\">
  <p><label for=\"login\">%BENUTZERNAME%:</label><input value=\"#BENUTZERNAME#\" type=\"text\" name=\"login\" autofocus /><br />
     <label for=\"passwort\">%PASSWORT%:</label> <input value=\"\" type=\"password\" name=\"password\" /></p>
  <p><input type=\"submit\" value=\"%EINLOGGEN%\" /></p>
</form>

", "", "input {width:8em}", "", "", "1", "0", "1", "0", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("43", "8", "Datenfeld", "", "%FELD%
", "", "", "", "", "999", "0", "0", "1", "0", "0", "0", "0", "0", "0", "", ""),
("44", "9", "sitemap.xml", "Sitemap für Google", "<!-- SUB=main_tpl --><?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
         xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
         xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
§SITEMAPURLS:#LANG_ID#§
</urlset>
<!-- /SUB -->
<!-- SUB=sitemapurls --><url>
    <loc>#PATH#</loc>
    <lastmod>#LASTMOD#</lastmod>
    <changefreq>%CANGEFREQ%</changefreq>
    <priority>%PRORITY%</priority>
</url><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->", "", "", "", "", "1", "0", "0", "1", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("46", "10", "robots.txt", "Anweisungen f�r Suchrobooter", "<!-- SUB=main_tpl -->%ANWEISUNGEN_RAW%
Sitemap: #LINKTO:%SITEMAP_SELECT:seiten%;absolute#
<!-- /SUB -->
<!-- SUB=Content-type -->text/plain<!-- /SUB -->
", "", "", "", "", "1", "0", "0", "1", "1", "0", "0", "0", "0", "0", "fit", "fit"),
("49", "2", "Brückenseite", "", "§BRIDGE§
<!-- SUB=bridge --><div class=\"bridge\">
<h4><a class=\"tooltip\" href=\"#LINKTO:$PAGE_ID$#\" title=\"$TITEL$\">$MENU$</a></h4>
<p>§FETCHIMAGE:PAGE_ID=$PAGE_ID$;order=random;avisi=1§
  $BESCHREIBUNG$</p>
<p><a href=\"#LINKTO:$PAGE_ID$#\" title=\"$TITEL$\">$MENU$</a></p>
</div><!-- /SUB -->
", "", "", "", "", "0", "0", "1", "0", "1", "1", "250", "250", "500", "500", "fit", "fit"),
("51", "5", "RSS-Feed", "", "<!-- SUB=main_tpl --><?xml version=\"1.0\" encoding=\"§CODEPAGE§\"?>
<?xml-stylesheet type=\"text/css\" href=\"§LINKTO:file=/rss.css;SET=absolute§\" ?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">
  <channel>
    <title>§TITLE§</title>
    <description>§DESCRIPTION§</description>
    <language>§LANG§</language>
    <copyright>Copyright §YEAR§ §FIRMA§, §WWW§</copyright>
    <link>§LINKTO:PAGE_ID=home;SET=absolute§</link>
    <atom:link href=\"§LINKTO:PAGE_ID=page_id;SET=absolute§\" rel=\"self\" type=\"application/rss+xml\" />
    §GET_VORLAGE:PAGE_ID=40,31,47,36;order_by=PUB_DESC;template=news;filter_fck=abslinks;nocache=1;limit=%LIMIT_NUMBER%§
  </channel>
</rss><!-- /SUB -->
<!-- SUB=news --><item>
    <title><![CDATA[
§FIRMA§: %REFERENZEN%:  $TITEL$
]]> </title>
    <description><![CDATA[
<img align=\"left\" src=\"§FETCHIMAGE:PAGE_ID=*PAGE_ID*;PART_ID=*PART_ID*§\" alt=\"$WWW$ - $TITEL$\" /> 
$BESCHREIBUNG_FCK$
<a href=\"http://$WWW$\">$WWW$</a>
]]> </description>
<link>§LINKTO:PAGE_ID=*PAGE_ID*§/#id_*PAGE_ID*_*PART_ID*</link>
    <pubDate>*PUBDATE*</pubDate>
<guid>§LINKTO:PAGE_ID=*PAGE_ID*§/#id_*PAGE_ID*_*PART_ID*</guid>
    <category><![CDATA[
§FIRMA§
]]></category>
</item><!-- /SUB -->
<!-- SUB=Content-type -->text/xml<!-- /SUB -->  ", "", "", "", "", "1", "0", "0", "1", "0", "0", "250", "250", "500", "500", "fit", "fit");
-- # /DUMP # --

-- # Schnipp --