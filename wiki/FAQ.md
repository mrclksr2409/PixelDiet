# FAQ

### Werden bestehende Bilder in der Mediathek verkleinert?
Nein. PixelDiet verarbeitet ausschließlich **neue Uploads**. Bestehende Bilder bleiben unverändert.

### Werden kleine Bilder vergrößert?
Nein. Ist ein Bild nicht größer als die eingestellte Breite und Höhe, wird es nicht angefasst –
auch nicht neu komprimiert.

### Bleibt das Seitenverhältnis erhalten?
Ja. Das Bild wird proportional in den Rahmen *max. Breite × max. Höhe* eingepasst, nicht
zugeschnitten.

### Welche Dateitypen werden unterstützt?
JPEG, PNG und WebP – jeweils einzeln abwählbar. Andere Formate wie GIF oder SVG werden nie
verarbeitet.

### Wird PNG auch komprimiert?
PNG wird verkleinert, aber die Einstellung *JPEG-/WebP-Qualität* gilt nur für JPEG und WebP. PNG
wird mit den Standardwerten des Bild-Editors gespeichert.

### Wandelt PixelDiet Bilder in WebP um?
Nein. Das Format bleibt immer gleich, Dateiname und Endung ändern sich nicht.

### Wo liegt das Original, wenn ich das Backup aktiviert habe?
Im selben Upload-Ordner wie das Bild, als `<Dateiname>.original.<Endung>` – z. B.
`urlaub.original.jpg` neben `urlaub.jpg`. Es ist kein Mediathek-Eintrag, nur eine Datei.

### Werden die Backups beim Löschen des Plugins entfernt?
Nein. Beim Löschen wird nur die Option `pixel_diet_settings` entfernt. Siehe
[Datenbank und Deinstallation](Datenbank-und-Deinstallation).

### Ändert PixelDiet auch die Qualität meiner Thumbnails?
Ja, solange das Plugin aktiv ist: Über die Filter `jpeg_quality` und `wp_editor_set_quality`
verwendet WordPress die eingestellte Qualität für alle JPEG-/WebP-Dateien, die es über seinen
Bild-Editor speichert – also auch für die Zwischengrößen. Siehe [Funktionsweise](Funktionsweise#qualität-auch-für-zwischengrößen).

### Was ist mit der WordPress-eigenen Grenze von 2560 px?
WordPress verkleinert sehr große Bilder seit Version 5.3 selbst (`big_image_size_threshold`) und
legt dafür eine `-scaled`-Datei an. PixelDiet greift in diesen Mechanismus nicht ein. Da PixelDiet
vorher läuft, ist das Bild bei einer Maximalgröße unter dieser Grenze bereits klein genug.

### Verarbeitet PixelDiet EXIF-Daten oder die Bildausrichtung?
PixelDiet selbst enthält keine Logik dafür. Es nutzt den Bild-Editor von WordPress zum Verkleinern
und Speichern.

### Hat PixelDiet eigene Hooks oder Filter zum Erweitern?
Nein. PixelDiet nutzt nur WordPress-Hooks, stellt aber keine eigenen bereit. Eine Übersicht steht
unter [Entwicklung](Entwicklung#verwendete-wordpress-hooks).

### Was kostet PixelDiet?
Nichts. Es ist Open Source unter GPL-2.0-or-later.

### Wo melde ich Fehler oder Wünsche?
Unter [Issues](https://github.com/mrclksr2409/PixelDiet/issues).
