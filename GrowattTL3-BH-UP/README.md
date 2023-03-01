# GrowattTL3-BH UP
   Diese Instanz ermöglicht es einen Growatt TL3-BH UP Wechselrichter in IP-Symcon einzubinden.
     
   ## Inhaltverzeichnis
- [GrowattTL3-BH UP](#growatttl3-bh-up)
  - [Inhaltverzeichnis](#inhaltverzeichnis)
  - [1. Konfiguration](#1-konfiguration)
  - [2. Funktionen](#2-funktionen)
   
   ## 1. Konfiguration
   
   Feld | Beschreibung
   ------------ | ----------------
   Timer Intervall | Zeit in ms, wie oft die Werte über ModBus abgerufen werden sollen.
   Variablen | In dieser Liste können einzelne Variablen aktiviert bzw. deaktiviert werden.
   
   ## 2. Funktionen

   ```php
   RequestAction($VariablenID, $Value);
   ```
   Mit dieser Funktion können alle Aktionen einer Variable ausgelöst werden.

   **Beispiel:**
   
   Variable ID Wirkleistungsrate: 12345
   ```php
   RequestAction(12345, 70); //Wirkleistungsrate auf 70% setzen
   ```

   ```php
   GWTL3BHUP_RequestRead($InstanzID);
   ```
   Mit dieser Funktion können alle Werte über ModBus abgerufen werden.
   
   ```php
   GWTL3BHUP_RequestRead(12345); //Werte aktualisieren
   ```