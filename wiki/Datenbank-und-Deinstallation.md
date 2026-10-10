# Datenbank und Deinstallation

PixelDiet legt **keine eigenen Tabellen**, keine Post-Meta und keine Cron-Aufgaben an.

## Gespeicherte Daten

| Name | Art | Inhalt | Angelegt von |
|---|---|---|---|
| `pixel_diet_settings` | Option (`wp_options`) | Array mit allen [Einstellungen](Einstellungen) | Aktivierung (mit Standardwerten, nur falls noch nicht vorhanden) bzw. Speichern der Einstellungsseite |
| `external_updates-pixel-diet` | Site-Option | Zwischengespeicherter Update-Status | Plugin Update Checker (siehe [Updates](Updates)) |

Auf der Festplatte entstehen außerdem – nur bei aktiviertem **Original-Backup behalten** – Dateien
der Form `<Dateiname>.original.<Endung>` in den Upload-Ordnern.

### Einstellungen per WP-CLI ansehen

```bash
wp option get pixel_diet_settings --format=json
```

## Deaktivieren

Beim Deaktivieren führt PixelDiet selbst keine Aufräumarbeiten aus. Die Einstellungen bleiben
erhalten; neue Uploads werden nicht mehr verkleinert.

## Deinstallieren (Plugin löschen)

Beim Löschen über **Plugins → Löschen** führt WordPress `uninstall.php` aus. Diese Datei entfernt
**ausschließlich** die Option `pixel_diet_settings`:

```php
delete_option( 'pixel_diet_settings' );
```

**Nicht** entfernt werden:

- die verkleinerten Bilder – sie bleiben in der verkleinerten Fassung in der Mediathek
- die `.original.`-Backup-Dateien in den Upload-Ordnern – diese musst du bei Bedarf selbst löschen
  (z. B. per FTP/SSH)

### Backup-Dateien finden

Auf der Kommandozeile im WordPress-Verzeichnis:

```bash
find wp-content/uploads -name '*.original.*'
```

> Prüfe die Liste, bevor du etwas löschst: Das Muster trifft auch Dateien, die zufällig
> `.original.` im Namen tragen, aber nicht von PixelDiet stammen.
