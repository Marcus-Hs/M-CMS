-- IMPORT AS NEW--

-- # DUMP=seiten_attr:53 # --
INSERT INTO `#PREFIX#seiten_attr` (`KAT_ID`,`TPL_ID`,`parent_ID`,`person_ID`,`position`,`order_by`,`visibility`,`status`,`lft`,`rgt`) VALUES
("4", 43, "0", "2", "13", "PO_ASC", "1", "0", "78", "79");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=seiten:53 # --
INSERT INTO `#PREFIX#seiten` (`PAGE_ID`,`LANG_ID`,`editor_ID`,`Titel`,`Ueberschrift`,`Kurzname`,`Menu`,`AK`,`Text`,`Beschreibung`,`insdate`,`lastmod`,`fix_kn`) VALUES
("PAGE_NEW", "1", "2", "Fehlermeldungen", "Fehlermeldungen", "Fehlermeldungen", "Fehlermeldungen", "F", "&lt;p&gt;Interne Seite für Fehlermeldungen.
     
         
     
         (Positionsnummer = Fehlernummer)&lt;/p&gt;", "Fehlermeldungen", "2010-09-09 00:00:00", "2011-08-18 14:09:07", "0"),
("PAGE_NEW", "3", "0", "Error messages", "Error messages", "Error_messages", "Error messages", "", "&lt;p&gt;Internal page for error messages.
   
   (Positionsnummer = Fehlernummer)&lt;/p&gt;", "", "0000-00-00 00:00:00", "2009-06-26 17:24:55", "0");
-- # /DUMP # --

-- # Schnipp ---- # DUMP=abschnitte:53 # --
INSERT INTO `#PREFIX#abschnitte` (`PART_ID`,`PAGE_ID`,`LANG_ID`,`Content`,`pflicht`,`position`,`visibility`,`first`,`publish`,`finish`) VALUES
("0", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A45%3A%22Danke%2C+Ihre+Nachricht+ist+abgeschickt+worden.%22%3B%7D", "", "10", "1", "Danke, Ihre Nachricht ist abgeschickt worden.", "2010-09-09", "0000-00-00"),
("1", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A30%3A%22Bitte+gebe+Sie+Ihren+Namen+an.%22%3B%7D", "", "1", "1", "Bitte gebe Sie Ihren Namen an.", "2010-09-09", "0000-00-00"),
("2", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A35%3A%22Ihr+Name+enth%E4lt+ung%FCltige+Zeichen.%22%3B%7D", "", "2", "1", "Ihr Name enthält ungültige Zeichen.", "2010-09-09", "0000-00-00"),
("3", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A46%3A%22Ihre+Ortsbezeichnung+enth%E4lt+ung%FCltige+Zeichen%22%3B%7D", "", "3", "1", "Ihre Ortsbezeichnung enthält ungültige Zeichen", "2010-09-09", "0000-00-00"),
("4", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A47%3A%22Sie+haben+keine+g%FCltige+Emailadresse+angegeben.%22%3B%7D", "", "4", "1", "Sie haben keine gültige Emailadresse angegeben.", "2010-09-09", "0000-00-00"),
("5", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A50%3A%22Sie+haben+keine+g%FCltige+Telefonnummer+angegeben.++%22%3B%7D", "", "5", "1", "Sie haben keine gültige Telefonnummer angegeben.", "2010-09-09", "0000-00-00"),
("6", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A32%3A%22Bitte+geben+Sie+ein+Betreff+ein.%22%3B%7D", "", "8", "1", "Bitte geben Sie ein Betreff ein.", "2010-09-09", "0000-00-00"),
("7", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A45%3A%22Die+Seite+konnte+leider+nicht+gefunden+werden%22%3B%7D", "", "404", "1", "Die Seite konnte leider nicht gefunden werden", "2010-09-09", "0000-00-00"),
("8", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A35%3A%22Bitte+geben+Sie+eine+Nachricht+ein.%22%3B%7D", "", "9", "1", "Bitte geben Sie eine Nachricht ein.", "2010-09-09", "0000-00-00"),
("9", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A37%3A%22Bitte+f%FCllen+Sie+folgende+Felder+aus%3A%22%3B%7D", "", "20", "1", "Bitte füllen Sie folgende Felder aus:", "2010-09-09", "0000-00-00"),
("10", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A50%3A%22Sie+haben+keine+g%FCltige+Mobilfunknummer+angegeben.%22%3B%7D", "", "6", "1", "Sie haben keine gültige Mobilfunknummer angegeben.", "2010-09-09", "0000-00-00"),
("7", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A27%3A%22The+page+could+not+be+found%22%3B%7D", "", "404", "1", "The page could not be found", "2010-09-09", "0000-00-00"),
("9", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A33%3A%22Please+fill+the+following+fields%3A%22%3B%7D", "", "20", "1", "Please fill the following fields:", "2010-09-09", "0000-00-00"),
("0", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A37%3A%22Thank+you.+The+Message+has+been+send.%22%3B%7D", "", "10", "1", "Thank you. The Message has been send.", "2010-09-09", "0000-00-00"),
("8", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A23%3A%22Please+enter+a+message.%22%3B%7D", "", "9", "1", "Please enter a message.", "2010-09-09", "0000-00-00"),
("6", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A23%3A%22Please+enter+a+subject.%22%3B%7D", "", "8", "1", "Please enter a subject.", "2010-09-09", "0000-00-00"),
("10", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A44%3A%22This+seems+not+to+be+al+valid+mobile+number.%22%3B%7D", "", "6", "1", "This seems not to be al valid mobile number.", "2010-09-09", "0000-00-00"),
("5", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A49%3A%22This+seems+not+to+be+al+valid+telephone+number.%0D%0A%22%3B%7D", "", "5", "1", "This seems not to be al valid telephone number.", "2010-09-09", "0000-00-00"),
("4", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A55%3A%22This+seems+not+to+be+al+email+address+telephone+number.%22%3B%7D", "", "4", "1", "This seems not to be al email address telephone number.", "2010-09-09", "0000-00-00"),
("3", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A60%3A%22The+name+of+your+place+seems+to+contain+invalid+charachters.%22%3B%7D", "", "3", "1", "The name of your place seems to contain invalid charachters.", "2010-09-09", "0000-00-00"),
("2", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A47%3A%22Your+name+seems+to+contain+invalid+charachters.%22%3B%7D", "", "2", "1", "Your name seems to contain invalid charachters.", "2010-09-09", "0000-00-00"),
("1", "PAGE_NEW", "3", "a%3A1%3A%7Bs%3A18%3A%22Fehlermeldung_text%22%3Bs%3A20%3A%22Please+enter+a+name.%22%3B%7D", "", "1", "1", "Please enter a name.", "2010-09-09", "0000-00-00"),
("19", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A26%3A%22Sie+haben+sich+abgemeldet.%22%3B%7D", "", "100", "1", "Sie haben sich abgemeldet.", "2010-09-09", "0000-00-00"),
("20", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A47%3A%22Ihre+neuen+Zugangsdaten+sind+verschickt+worden.%22%3B%7D", "", "62", "1", "Ihre neuen Zugangsdaten sind verschickt worden.", "2010-09-09", "0000-00-00"),
("21", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A95%3A%22Zur+angegebenen+Email+oder+dem+Benutzernamen+konnten+leider+keine+Zugangsdaten+gefunden+werden.%22%3B%7D", "", "63", "1", "Zur angegebenen Email oder dem Benutzernamen konnten leider ...", "2010-09-09", "0000-00-00"),
("22", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A30%3A%22Das+hat+leider+nicht+geklappt.%22%3B%7D", "", "102", "1", "Das hat leider nicht geklappt.", "2011-08-18", "0000-00-00"),
("23", "PAGE_NEW", "1", "a%3A1%3A%7Bs%3A4%3A%22Feld%22%3Bs%3A30%3A%22Das+hat+leider+nicht+geklappt.%22%3B%7D", "", "102", "1", "Das hat leider nicht geklappt.", "2011-08-18", "0000-00-00");
-- # /DUMP # --

-- # Schnipp --