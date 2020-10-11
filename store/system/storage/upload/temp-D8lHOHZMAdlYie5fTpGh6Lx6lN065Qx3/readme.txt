$Id: readme.txt 4583 2016-12-07 20:50:26Z mic $

readme German Translation (de-DE) for OpenCart
==============================================

Package/Paket	Languages (admin/user) - Sprachen (Admin/Benutzer)
Requirement		OpenCart 2.x
Copyright		https://osworx.net
License			GNU/GPL http://www.gnu.org/copyleft/gpl.html
-----------------------------------------------------------------

English
=======

Description
***********
Complete German Translation for admin (Backend) and user (Frontend / shop)

Notes
*****

A.	up to version 2.1.0.2 English language folder was named: english
B.	from 2.2.x on the language folder is named: en-gb
C.	German was always de-DE from the beginning on

This installer takes care of this and the folder structure.
The correct shop version is detected and not needed folders and files
will be removed automatically.


Installation (and/or Update)
****************************

Method 1 (shop is already not installed and to use German during the installation process)
------------------------------------------------------------------------------------------

To install this language package, extract the zipped package locally
and transfer the files (same structure as you can see) with your FTP-Program
to your server (current shop files but shop is not installed already).

During the installation process, select the language you want.
After the shop installation is done, you will see a message at step 4 (summary).

To use German in the shop, you have to click on the link displayed inside the message window!
=============================================================================================

Method 2 (shop is already installed or to update existing language files)
-------------------------------------------------------------------------

To install this language package, navigate in the backend to Extensions > Installer,
select this package and follow the onscreen instructions.

Note: if you want to update an existing translation, disable and delete first this extension
(Menu Extensions > Modifications)

Method 3 (shop is already full installed and running)
-----------------------------------------------------

The language package installer can be used also as 'stand-alone' solution.
This is applicable only if your shop is already full installed and running.
Simply open your browser, and use:

http://YOURSHOPURL/install/install_language.php

(replace http with https if SSL is used, and YOURSHOPURL with your real URL)

Other
=====

Following is applicable only if:
--------------------------------
1.	After a (new) shop installation AND files are copied by FTP only
	AND NOT installed by the internal installer
2.	German (or other language) was used during the installation process (see Method 1),
	but the link to Install German was not clicked

To define the new settings for German, open the Shop backend and follow these steps:
------------------------------------------------------------------------------------

1. Menu > System -> Localisation -> Languages
2. Click the Edit button
3. Fill in the following values:

	3.1 Language	Deutsch (German)
	3.2 Code		de
	3.3 Locale		de,de-DE,de_DE,de_DE.UTF-8,de-de,de-AT,de-CH,german (only OpenCart < 2.2.x )
	3.4 Image		de.png (only OpenCart < 2.2.x )
	3.5 Directory	de-DE (only OpenCart < 2.2.x )
	3.6 Status		Enabled
	3.7 Sort Order	1

    Save

4. Menu > System -> Settings
5. Click on the tab Locale and define your standard languages for
    front- and backend (backend language will not change BEFORE this step!)
6. Save
7. Ready

Deutsch
=======

Beschreibung
************
Komplette deutsche Übersetzung für Admin (Backend) und Benutzer (Frontend / Shop)
inklusive Installationssprache

Installation (und Update)
*************************

Methode 1 (Shop ist noch nicht installiert und Deutsch soll während der Installation verwendet werden)
------------------------------------------------------------------------------------------------------

Um dieses Sprachenpaket zu installieren, das gezippte Paket lokal entpacken.
Anschließend die Dateien (gleiche Verzeichnisstruktur wie sichtbar im Ordner upload)
per FTP auf den Server kopieren.

Während der Installation gewünschte Sprache auswählen.

Nach Abschluß der Installation in der Zusammenfassung (Schritt 4) wird eine Nachricht angezeigt.

Um das deutsche Sprachpaket fertig zu installieren, muss auf den Link in dieser Nachricht geklcikt werden!
==========================================================================================================

Methode 2 (Shop ist bereits installiert oder vorhandene Sprachdateien akualisieren)
-----------------------------------------------------------------------------------

Im Shopbackend über das Menü Erweiterungen > Installer
dieses Paket auswählen und den Anweisungen am Bildschirm folgen

Hinweis: soll die Sprache nur aktualisiert werden, muss vorher über das Menü
Erweiterungen > Anpassungen diese Spracherweiterung deaktiviert und gelöscht werden.

Methode 3 (nur anwendbar wenn der Shop bereits komplett installiert und in Betrieb ist)
---------------------------------------------------------------------------------------

Der Sprachpaketinstaller kann auch als 'Einzellösung' aufgerufen werden.
Dazu im Browser eingeben:

http://MEINESHOPURL/install/install_language.php

(http mit https ersetzen wenn SSL im Einsatz ist, MEINESHOPURL mit der Tatsächlichen)

Sonstiges
*********

Nur anzuwenden wenn:
====================
A.	Nach einer (neuen) Shopinstallation und Sprachdateien wurden nur per FTP kopiert
	und Sprachpaket wurde NICHT über den integrierten Installer installiert
B.	Deutsch (oder andere Sprache) wurde während der Neuinstallation angewendet,
	aber der Link in Schritt 4 (siehe Methode 1 oben) NICHT angeklickt
-------------------------------------------------------------------------------------

Um die neuen Einstellungen für die dt. Sprache zu definieren, wie folgt vorgehen:

1.	Backend aufrufen Menü > System -> Localisation -> Languages
2.	Button "Insert" anklicken
3.	Folgende Werte eingeben:

	3.1 Language	Deutsch (German)
	3.2 Code		de
	3.3 Locale		de-DE,de_DE,de-de,de_DE.UTF-8,german (nur OpenCart < 2.2.x )
	3.4 Image		de.png (nur OpenCart < 2.2.x )
	3.5 Directory	de-DE (nur OpenCart < 2.2.x )
	3.6 Status		Enabled
	3.7 Sort Order	1

    Sichern (Button Save rechts oben anklicken)

4.	Menü > System -> Settings aufrufen
5.	Reiter "Locale" anklicken und die Standardsprache für Admin und Benutzer
	festlegen > erst dann schaltet das Backend auf die hier eingestellte Sprache
    um!
6.	Speichern (Button Sichern rechts oben anklicken)
7.	Fertig

!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! WICHTIG !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
! Um den verschiedenen Gesetzen zu entprechen (speziell EU-Raum, AT, DE),         !
! kann es erforderlich sein, dass verschiedene Variablen (z.B. $_['text_price'] ) !
! angepasst werden müssen!                                                        !
! Näheres dazu auf https://osworx.net wo wir ein spezielles Paket zur Verfügung   !
! stellen, mit welchem die rechtlichen Anforderungen abgedeckt werden.            !
!                                                                                 !
! Siehe dazu Module LEGAL sowie EUCookie auf https://osworx.net                   !
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! WICHTIG !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

Installationssprache
********************
In diesem Paket ist auch die dt. Sprache für eine Installation in Deutsch enthalten.
Wird das Sprachpaket VOR der ERSTINSTALLATION auf den Server kopiert, kann die
Installation in Deutsch erfolgen (siehe Methode 1)

Support
*******
https://osworx.net

Guarantee & Warranty / Garantie & Gewährleitung
***********************************************
This extension is created under best effort.
Unlikely we cannot guarantee for any lost of data or malfunction.

Diese Erweiterung wurde mit besten Wissen erstellt.
Es kann jedoch nicht garantiert werden dass Daten verloren gehen oder Fehlfunktionen
nicht auftreten.

License / Lizenz
****************
Notes:
    > this package can be used for own works / derivates to following conditions:
    - headers:
		- must stay intact
        - you are allowed to add your own lines
        - you are NOT allowed to delete any line of the headers
    - this readme has always to be included in further packages
    - building own commercial packages with this as base is strictly forbidden!

Hinweise:
    > dieses Paket kann für eigene Werke zu folgenden Konditionen verwendet werden:
    - Kopfzeilen:
		- müssen intakt bleiben
        - es können eigene Zeilen hinzugefügt werden
        - es dürfen KEINE Kopfzeilen sowie Copyrightinformationen gelöscht werden
    - diese Datei (readme.txt) muss in allen zukünftigen Paketen inkludiert sein
    - eigene kommerzielle Pakete damit zu erstellen ist strikt verboten (siehe Lizenz)!

Versionen/Changelog (rev)
*************************
legend
* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note
-------------------------
2.0.3	2016.12.08	# missing vars, missing translations (account)
2.0.2	2016.12.07	# encoding, typos
2.0.1	2016.12.01	# typos
2.0.0	2016.10.11	+ external installer function
					+ automatic settings definition
					+ check for used VERSION and adoption of folders/files
					+ missing translations
1.3.0	2016.10.04	+ 2.3.x terms
					+ sql to install language autmatically when installer is used
1.2.1	2016.06.10	+ datetimepicker locale de (front- & backend)
1.2.0	2016.04.01	+ OC 2.2.x. vars
					+ missing var (reward)
					^ minor rewording
1.1.1	2016.02.09	^ minor rewording
					^ language package as ocmod installer
1.0.20	2016.02.02	^ rewording activities
1.0.19	2016.01.30	+ new vars
1.0.18	2016.01.18	^ minor rewording
1.0.17	2016.01.05	^ minor rewording
					# typo
1.0.16	2016.01.05	# file encoding
					^ minor rewording
1.0.15	2015.12.02	^ admin - installer > links removed
1.0.14	2015.10.20	^ minor rewording, admin date changed
					# recaptcha, file encoding UTF-8
1.0.13	2015.10.15	^ typos, rewording, file encoding
1.0.12	2015.10.07	+ OC 2.1.x values
1.0.11	2015.09.05	# typo payment paypal_standard
					+ paypal_standard colored states
					+ new var (general)
1.0.10	2015.08.23	# typo, wording
1.0.9	2015.04.06	# typos
					+ OC 2.0.2.0 vars
					+ missing payment images
					+ jquery.jqvmap localized German map
					^ reworked install file
					^ renamed default.php to LANGUAGE_NAME.php (changed 2.0.2.0 again!)
1.0.8	2015.03.28	# default.php (UTF-8)
					# typos
1.0.7	2015.03.02	+ new vars (OC v.2.0.1.1)
					# typos
1.0.6	2014.10.02	+ new vars (backend)
1.0.5	2014.10.02	^ minor rewording
1.0.4	2014.10.01	^ final stable release 2.0.0.0 vars
1.0.3	2014.09.28	+ files and vars as of beta 4
1.0.2	2014.08.18	+ new vars
					- old vars
					# typos
1.0.1	2014.06.10	+ new vars
					- old vars
					- double vars
					# typos
1.0.0	2014.06.06	initial release