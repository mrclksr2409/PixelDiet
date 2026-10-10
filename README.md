# PixelDiet

WordPress-Plugin, das hochgeladene Bilder automatisch auf eine in den
Einstellungen hinterlegte maximale Größe verkleinert.

📖 **Ausführliche Dokumentation im [Wiki](https://github.com/mrclksr2409/PixelDiet/wiki)**

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
- Einheitliches, modernes Admin-Design über die gemeinsame Bibliothek
  **WP-Backend UI** (gebündelt unter `lib/wp-backend-ui/`)

## Voraussetzungen

- WordPress 5.5+
- PHP 7.2+
- Gebündelt (keine separate Installation nötig):
  - WP-Backend UI 1.0.2 (`lib/wp-backend-ui/`) – gemeinsames Admin-Design.
    Bündeln mehrere Plugins unterschiedliche Kopien, lädt WordPress nur die
    neueste.
  - plugin-update-checker v5.7 (`vendor/plugin-update-checker/`)

## Installation

1. Repository klonen oder die ZIP-Datei eines Releases herunterladen.
2. Den Ordner als `wp-content/plugins/pixel-diet/` in deine WordPress-Installation
   ablegen (der Ordnername muss `pixel-diet` lauten, damit Updates korrekt
   greifen).
3. Im Backend unter **Plugins** aktivieren.
4. Unter **Einstellungen → PixelDiet** die gewünschten Werte konfigurieren.

## Release-Workflow (für Maintainer)

Updates werden direkt vom Branch `main` ausgeliefert. GitHub-Releases und Tags
werden vom Updater ignoriert. Ist unter **Einstellungen → PixelDiet → Updates**
die Option *Beta-Updates* aktiv, kommen die Updates stattdessen vom Branch
`beta`. Damit ein Beta-Update angeboten wird, muss die Version auf `beta` höher
sein als die installierte (z. B. `1.3.0-beta.1`).

1. Entwickeln auf dem Branch `beta`.
2. Versionsnummer in `pixel-diet.php` (Plugin-Header **und** Konstante
   `PIXEL_DIET_VERSION`) sowie in `readme.txt` (`Stable tag`) erhöhen.
3. `beta` nach `main` übernehmen und pushen.
4. WordPress-Installationen sehen das Update beim nächsten automatischen Check
   (alle 12 h) bzw. sofort über *Dashboard → Aktualisierungen → Erneut prüfen*.

## Projektstruktur

```
pixel-diet.php                       Plugin-Header, Konstanten, Bootstrap
includes/class-pixel-diet.php        Singleton, initialisiert die Komponenten
includes/class-pixel-diet-settings.php  Einstellungsseite (Settings API)
includes/class-pixel-diet-resizer.php   Verkleinern beim Upload
includes/class-pixel-diet-updater.php   Self-Update via plugin-update-checker
lib/wp-backend-ui/                   Gebündelte Bibliothek WP-Backend UI (nicht ändern)
vendor/plugin-update-checker/        Gebündelte Bibliothek plugin-update-checker
uninstall.php                        Entfernt die Option beim Löschen
```

Die gebündelte Kopie von WP-Backend UI wird nicht direkt bearbeitet. Für ein
Update die neue Version aus dem WP-Backend-UI-Repository nach
`lib/wp-backend-ui/` kopieren (ohne `demo/`, `examples/`, `docs/`, `.git`).

## Changelog

### 1.2.1
- Autor ist jetzt Marcel Kaiser, Autor-Link auf das GitHub-Profil.
- Neuer Link „Wiki“ in der Plugin-Übersicht.

### 1.2.0
- Neu: Beta-Update-Kanal. Unter **Einstellungen → PixelDiet → Updates** lassen
  sich Updates vom Branch `beta` statt `main` beziehen.
- Beim Wechsel des Update-Kanals wird der zwischengespeicherte Update-Status
  verworfen, damit der nächste Check sofort den gewählten Branch nutzt.

### 1.1.0
- Einstellungsseite im einheitlichen Admin-Design über die gebündelte
  Bibliothek WP-Backend UI 1.0.2 (`lib/wp-backend-ui/`).
- Neuer Seitenkopf mit Icon, Untertitel und Versionsanzeige.
- „Plugin aktiv“ und „Original-Backup behalten“ als Schalter (Toggle).
- Dateityp-Auswahl als barrierearmes Fieldset ohne Inline-Styles.

### 1.0.1
- Updates kommen jetzt direkt vom Branch `main`, GitHub-Releases werden ignoriert.
- Plugin Update Checker auf v5.7 aktualisiert.

### 1.0.0
- Erste Veröffentlichung: automatisches Verkleinern beim Upload,
  Einstellungsseite, GitHub-Self-Update.

## Lizenz

GPL-2.0-or-later. Die enthaltene Bibliothek `plugin-update-checker` steht
unter MIT-Lizenz; siehe `vendor/plugin-update-checker/license.txt`. Die
enthaltene Bibliothek WP-Backend UI steht unter GPL-2.0-or-later.
