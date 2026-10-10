# Fehlerbehebung

PixelDiet schreibt kein eigenes Log und zeigt keine Fehlermeldungen an: Schlägt ein Schritt fehl,
bleibt der Upload einfach unverändert. Die folgenden Punkte gehen die Bedingungen aus der
[Funktionsweise](Funktionsweise) der Reihe nach durch.

---

## Ein Bild wurde nicht verkleinert

Prüfe nacheinander:

1. **Plugin aktiv?** Unter **Einstellungen → PixelDiet** muss „Plugin aktiv“ eingeschaltet sein.
2. **Dateityp angehakt?** Der Typ des Bildes (JPEG, PNG oder WebP) muss unter
   *Zu verarbeitende Dateitypen* ausgewählt sein. Ist **kein** Typ angehakt, wird nichts
   verarbeitet. GIF, SVG und andere Formate werden grundsätzlich nicht verarbeitet.
3. **Wirklich größer als das Maximum?** Verkleinert wird nur, wenn Breite **oder** Höhe den
   eingestellten Wert überschreitet. Ein Bild mit 1900 × 1200 px bleibt bei 1920 × 1920 unverändert.
4. **Neu hochgeladen?** Bilder, die vor der Aktivierung oder Einstellungsänderung hochgeladen
   wurden, werden nicht nachträglich verarbeitet.
5. **Bild-Editor vorhanden?** PixelDiet nutzt den WordPress-Bild-Editor (Imagick oder GD). Unter
   **Werkzeuge → Website-Zustand → Bericht → Medien-Verarbeitung** siehst du, welcher Editor aktiv
   ist und welche Formate unterstützt werden. Ohne Editor – oder wenn der Editor ein Format nicht
   beherrscht, z. B. WebP bei älteren GD-Versionen – bleibt die Datei unverändert.
6. **Schreibrechte?** Die Datei im Upload-Ordner muss für PHP beschreibbar sein.
7. **Anderer Upload-Weg?** PixelDiet hängt am Filter `wp_handle_upload`. Bilder, die ein anderes
   Plugin oder Skript ohne diesen Filter in den Upload-Ordner schreibt, werden nicht verarbeitet.

## Bilder sind unscharf oder zeigen Artefakte

Die **JPEG-/WebP-Qualität** ist zu niedrig. Empfohlen sind 80–85 (Standard 82). Beachte, dass die
Qualität – solange das Plugin aktiv ist – auch für alle Zwischengrößen gilt, die WordPress erzeugt.
Ein neuer Wert wirkt nur auf künftige Uploads.

## Bild ist kleiner als erwartet

Breite und Höhe bilden einen **Rahmen**, in den das Bild proportional eingepasst wird. Ein
Hochformat 3000 × 4000 wird bei 1920 × 1920 zu 1440 × 1920 – die Höhe ist hier die begrenzende
Seite. Soll nur die Breite zählen, setze die Höhe hoch (bis 20000).

## Mein eingegebener Wert wurde geändert

Werte außerhalb des erlaubten Bereichs werden beim Speichern stillschweigend angepasst:
Breite/Höhe auf 100–20000, Qualität auf 1–100. Siehe [Einstellungen](Einstellungen#wie-eingaben-geprüft-werden).

## Es wurde kein Backup angelegt

- **Original-Backup behalten** war beim Upload nicht eingeschaltet.
- Das Bild war nicht größer als das Maximum – dann gibt es auch kein Backup, weil nichts verändert wird.
- Eine Datei mit dem Backup-Namen existierte bereits; sie wird nicht überschrieben.
- Das Kopieren ist fehlgeschlagen (z. B. Schreibrechte, Speicherplatz). Fehler beim Kopieren
  werden unterdrückt, das Bild wird trotzdem verkleinert.

Backups erscheinen nicht in der Mediathek, sondern nur als Datei im Upload-Ordner.

## Die Einstellungsseite fehlt

Die Seite **Einstellungen → PixelDiet** ist nur für Benutzer mit der Berechtigung
`manage_options` (in der Regel Administratoren) sichtbar.

## Updates werden nicht angezeigt

Siehe [Updates](Updates#update-wird-nicht-angezeigt).
