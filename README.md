# PixelDiet

WordPress-Plugin, das hochgeladene Bilder automatisch auf eine in den
Einstellungen hinterlegte maximale Größe verkleinert.

## Features

- Automatisches Verkleinern direkt nach dem Upload (`wp_handle_upload`-Hook)
- Einstellungsseite unter **Einstellungen → PixelDiet**
  - Maximale Breite und Höhe in Pixeln
  - JPEG-/WebP-Qualität (1-100)
  - Auswahl der zu verarbeitenden Dateitypen (JPEG, PNG, WebP)
  - Optional: Original als `<datei>.original.<ext>` als Backup behalten
- Self-Update direkt vom GitHub-Branch `main` via
  [plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker)
  von YahnisElsts (eingecheckt unter `vendor/plugin-update-checker/`)

## Installation

1. Repository klonen oder die ZIP-Datei eines Releases herunterladen.
2. Den Ordner als `wp-content/plugins/pixel-diet/` in deine WordPress-Installation
   ablegen (der Ordnername muss `pixel-diet` lauten, damit Updates korrekt
   greifen).
3. Im Backend unter **Plugins** aktivieren.
4. Unter **Einstellungen → PixelDiet** die gewünschten Werte konfigurieren.

## Release-Workflow (für Maintainer)

Updates werden direkt vom Branch `main` ausgeliefert. GitHub-Releases und Tags
werden vom Updater ignoriert.

1. Entwickeln auf dem Branch `beta`.
2. Versionsnummer in `pixel-diet.php` (Plugin-Header **und** Konstante
   `PIXEL_DIET_VERSION`) sowie in `readme.txt` (`Stable tag`) erhöhen.
3. `beta` nach `main` übernehmen und pushen.
4. WordPress-Installationen sehen das Update beim nächsten automatischen Check
   (alle 12 h) bzw. sofort über *Dashboard → Aktualisierungen → Erneut prüfen*.

## Lizenz

GPL-2.0-or-later. Die enthaltene Bibliothek `plugin-update-checker` steht
unter MIT-Lizenz; siehe `vendor/plugin-update-checker/license.txt`.
