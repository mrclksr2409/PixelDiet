# Funktionsweise

Diese Seite beschreibt genau, was PixelDiet beim Hochladen eines Bildes tut – und was nicht.

## Der Einstiegspunkt: `wp_handle_upload`

PixelDiet hängt sich mit Priorität 10 in den WordPress-Filter **`wp_handle_upload`** ein. Dieser
Filter läuft, nachdem WordPress die hochgeladene Datei in den Upload-Ordner verschoben hat, aber
**bevor** der Anhang in der Mediathek angelegt und die Zwischengrößen (Thumbnails usw.) erzeugt
werden. PixelDiet verkleinert also die Originaldatei selbst; alle weiteren Größen erzeugt WordPress
anschließend wie gewohnt aus der bereits verkleinerten Datei.

Der Filter wird von WordPress für normale Uploads und für „Sideloads“ (Dateien, die per Code von
einer URL übernommen werden) ausgelöst. PixelDiet unterscheidet dabei nicht.

## Ablauf Schritt für Schritt

```
wp_handle_upload
   │
   ├─ Upload-Daten unvollständig (keine Datei / kein Typ)? ──────────► nichts tun
   ├─ „Plugin aktiv“ aus? ───────────────────────────────────────────► nichts tun
   ├─ MIME-Typ nicht unter „Zu verarbeitende Dateitypen“? ───────────► nichts tun
   ├─ Datei existiert nicht oder ist nicht beschreibbar? ────────────► nichts tun
   ├─ Kein Bild-Editor verfügbar / Datei nicht ladbar? ──────────────► nichts tun
   ├─ Abmessungen nicht lesbar? ─────────────────────────────────────► nichts tun
   ├─ Breite ≤ max. Breite UND Höhe ≤ max. Höhe? ────────────────────► nichts tun
   │
   ├─ „Original-Backup behalten“ an? ──► Kopie <Name>.original.<Endung> anlegen
   ├─ JPEG oder WebP? ─────────────────► Qualität aus den Einstellungen setzen
   ├─ proportional verkleinern (ohne Zuschnitt)
   └─ über die Originaldatei speichern
```

In jedem Fall gibt PixelDiet die Upload-Daten unverändert an WordPress zurück – Dateiname, Pfad,
URL und MIME-Typ bleiben gleich. Geändert wird nur der Inhalt der Datei.

### 1. Prüfungen

- **Plugin aktiv** muss eingeschaltet sein.
- Der MIME-Typ des Uploads (`image/jpeg`, `image/png` oder `image/webp`) muss in der Einstellung
  **Zu verarbeitende Dateitypen** angehakt sein. Andere Typen (z. B. GIF, SVG, PDF) werden nie
  angefasst, weil sie gar nicht auswählbar sind.
- Die Datei muss existieren und für PHP beschreibbar sein.

### 2. Bild-Editor

PixelDiet lädt die Datei mit `wp_get_image_editor()`. Damit verwendet es den Bild-Editor, den
WordPress auf dem Server wählt (in der Regel **Imagick** oder **GD**). PixelDiet bringt keine
eigene Bildbibliothek mit. Kann WordPress keinen Editor für die Datei liefern, bleibt der Upload
unverändert.

### 3. Größenvergleich

Ist das Bild **nicht größer** als die eingestellte maximale Breite **und** Höhe, passiert nichts –
auch kein erneutes Speichern, also keine erneute Komprimierung. Kleinere Bilder werden **nie
vergrößert**.

### 4. Verkleinern

Das Bild wird so verkleinert, dass es vollständig in den Rahmen *max. Breite × max. Höhe* passt.
Das **Seitenverhältnis bleibt erhalten**, es wird **nicht zugeschnitten**.

| Original | Einstellung | Ergebnis |
|---|---|---|
| 4000 × 3000 (Querformat) | 1920 × 1920 | 1920 × 1440 |
| 3000 × 4000 (Hochformat) | 1920 × 1920 | 1440 × 1920 |
| 5000 × 1000 (Panorama) | 1920 × 1920 | 1920 × 384 |
| 1600 × 1200 | 1920 × 1920 | unverändert |

### 5. Qualität

Bei **JPEG und WebP** setzt PixelDiet vor dem Speichern die **JPEG-/WebP-Qualität** aus den
Einstellungen (Standard 82). **PNG** wird mit den Standardwerten des Bild-Editors gespeichert.

### 6. Speichern

Die verkleinerte Fassung wird **unter demselben Pfad** gespeichert und ersetzt damit die
hochgeladene Datei. Ohne aktiviertes Backup ist das Original danach nicht mehr auf dem Server.

## Original-Backup

Ist **Original-Backup behalten** eingeschaltet, kopiert PixelDiet die Datei **vor** dem
Verkleinern:

```
wp-content/uploads/2026/10/urlaub.jpg            ← verkleinert, in der Mediathek
wp-content/uploads/2026/10/urlaub.original.jpg   ← unverändertes Original
```

- Das Backup wird **nur** angelegt, wenn das Bild tatsächlich verkleinert werden muss.
- Existiert die Backup-Datei bereits, wird sie **nicht überschrieben**.
- Das Backup ist **kein Anhang** in der Mediathek – es liegt nur als Datei im Upload-Ordner.
- Schlägt das Kopieren fehl, wird das Bild trotzdem verkleinert (der Fehler wird unterdrückt).
- Beim Löschen des Bildes in der Mediathek oder des Plugins bleibt die Backup-Datei liegen.

## Qualität auch für Zwischengrößen

Unabhängig vom Upload-Filter registriert PixelDiet zwei weitere Filter:

| Filter | Wirkung (nur wenn „Plugin aktiv“ an ist) |
|---|---|
| `jpeg_quality` | Gibt die eingestellte Qualität zurück |
| `wp_editor_set_quality` | Gibt für `image/jpeg` und `image/webp` die eingestellte Qualität zurück, sonst den unveränderten Wert |

Damit verwendet WordPress die eingestellte Qualität auch für die **Zwischengrößen** (Thumbnails,
Medium, Large …) und andere JPEG-/WebP-Dateien, die es über seinen Bild-Editor speichert. Das gilt
**unabhängig** von der Dateityp-Auswahl und davon, ob das Originalbild verkleinert wurde.

## Was PixelDiet nicht tut

- **Bestehende Bilder** in der Mediathek werden nicht verarbeitet – es gibt keine
  Stapelverarbeitung. Nur neue Uploads ab Aktivierung.
- Es gibt **keine Konvertierung** zwischen Formaten (z. B. JPEG → WebP).
- PixelDiet enthält **keine eigene Auswertung von EXIF-Daten** oder der Bildausrichtung.
- PixelDiet schreibt **kein Log** und zeigt keine Meldung an. Schlägt ein Schritt fehl, bleibt
  der Upload einfach so, wie er hochgeladen wurde.
- PixelDiet greift nicht in die WordPress-eigene Begrenzung großer Bilder
  (`big_image_size_threshold`) ein.
