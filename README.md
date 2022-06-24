[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
![Version](https://img.shields.io/badge/Symcon%20Version-6.0%20%3E-blue.svg)
[![License](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-green.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![Check Style](https://github.com/Schnittcher/IPS-Shelly/workflows/Check%20Style/badge.svg)](https://github.com/Schnittcher/Growatt/actions)

# Growatt
   Mit diesem Modul ist es möglich die Wechselrichter der Firma Growatt über ModBus oder Grott (https://github.com/johanmeijer/grott) in IP-Symcon einzubinden.
 
   ## Inhaltverzeichnis
   1. [Voraussetzungen](#1-voraussetzungen)
   2. [Enthaltene Module](#2-enthaltene-module)
   3. [Installation](#3-installation)
   4. [Konfiguration in IP-Symcon](#4-konfiguration-in-ip-symcon)
   5. [Spenden](#5-spenden)
   6. [Lizenz](#6-lizenz)
   
## 1. Voraussetzungen

* mindestens IPS Version 6.0
* Grott oder ModBus

### 1.1 Einbindung über Grott
Für die Einbindung über Grott muss das Projekt Grott (https://github.com/johanmeijer/grott) installiert und eingerichtet worden sein.

### 1.2 Einbindung über ModBus
Für die Einbindung über ModBus muss der Wechselrichter via ModBus RTU mit IP-Symcon verbunden sein.
Über ModBus sind zur Zeit nur die TL3-X Modelle verfügbar, weitere Modelle können bei Bedarf ergänzt werden.

## 2. Enthaltene Module

* [Grott](Grott/README.md)
* [GrowattTL3-X](GrowattTL3-X/README.md)
* [Growatt-S](Growatt-S/README.md)

## 3. Installation
Installation über den IP-Symcon Module Store.

## 4. Konfiguration in IP-Symcon
Die Dokumentation bitte den einzelnen Modulen entnehmen.

## 5. Spenden
Dieses Modul ist für die nicht kommerzielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:    

<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EK4JRP87XLSHW" target="_blank"><img src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_LG.gif" border="0" /></a> <a href="https://www.amazon.de/hz/wishlist/ls/3JVWED9SZMDPK?ref_=wl_share" target="_blank">Amazon Wunschzettel</a>

## 6. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)

Eine großer Dank geht an Nall-Chan für die Vorlage für das ModBus Modul und an paresy für die Erklärungen zu ModBus.