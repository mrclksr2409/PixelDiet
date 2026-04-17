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
- Self-Update über GitHub-Releases via
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

Damit das Self-Update funktioniert, müssen neue Versionen als GitHub-Release
veröffentlicht werden:

1. Versionsnummer in `pixel-diet.php` (Plugin-Header **und** Konstante
   `PIXEL_DIET_VERSION`) sowie in `readme.txt` (`Stable tag`) erhöhen.
2. Änderungen committen und pushen.
3. Tag setzen, z. B. `git tag v1.1.0 && git push origin v1.1.0`.
4. Auf GitHub → *Releases* → *Draft a new release* den Tag auswählen.
5. Ein ZIP-Asset namens z. B. `pixel-diet-1.1.0.zip` an den Release anhängen.
   Das ZIP muss den Plugin-Ordner `pixel-diet/` mit allen Dateien (inkl.
   `vendor/plugin-update-checker/`) enthalten.
6. Release veröffentlichen. WordPress-Installationen sehen das Update beim
   nächsten automatischen Check (alle 12 h) bzw. sofort über
   *Dashboard → Aktualisierungen → Erneut prüfen*.

> Wenn kein ZIP-Asset angehängt wird, fällt das plugin-update-checker auf den
> automatisch von GitHub erzeugten Tag-Tarball zurück. Ein eigenes ZIP-Asset
> ist aber empfehlenswert, weil es auch die `vendor/`-Bibliothek garantiert
> mitbringt.

## Lizenz

GPL-2.0-or-later. Die enthaltene Bibliothek `plugin-update-checker` steht
unter MIT-Lizenz; siehe `vendor/plugin-update-checker/license.txt`.
