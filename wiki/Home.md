# PixelDiet Wiki

**PixelDiet** ist ein WordPress-Plugin, das hochgeladene Bilder direkt nach dem Upload automatisch
auf eine in den Einstellungen hinterlegte maximale Breite und Höhe verkleinert. Das
Seitenverhältnis bleibt erhalten. So sparst du Speicherplatz und Bandbreite, ohne dass jemand
beim Hochladen auf die Bildgröße achten muss.

> Aktuelle Version: **1.2.1** · Voraussetzungen: WordPress 5.5+, PHP 7.2+ · Autor:
> [Marcel Kaiser](https://github.com/mrclksr2409)

---

## So funktioniert PixelDiet in einem Satz

```
Bild-Upload ──► wp_handle_upload ──► Dateityp gewählt? Größer als Maximum?
            ──► (optional Backup als .original.) ──► proportional verkleinern ──► Datei überschreiben
            ──► WordPress erzeugt wie gewohnt die Zwischengrößen
```

Mehr dazu unter **[Funktionsweise](Funktionsweise)**.

## Einstieg

| Seite | Wofür |
|---|---|
| [Installation](Installation) | Plugin hochladen, aktivieren, Voraussetzungen |
| [Schnellstart](Schnellstart) | In zwei Minuten eingerichtet |
| [Funktionsweise](Funktionsweise) | Was beim Upload genau passiert |

## Bedienung

| Seite | Wofür |
|---|---|
| [Einstellungen](Einstellungen) | Alle Optionen mit Standardwerten und Grenzen |
| [Updates](Updates) | Updates vom `main`-Branch, Beta-Kanal |

## Referenz

| Seite | Wofür |
|---|---|
| [Datenbank und Deinstallation](Datenbank-und-Deinstallation) | Gespeicherte Option, was beim Löschen entfernt wird |
| [Fehlerbehebung](Fehlerbehebung) | Typische Probleme und Lösungen |
| [FAQ](FAQ) | Häufige Fragen |
| [Entwicklung](Entwicklung) | Code-Struktur, verwendete Hooks, Release |
| [Changelog](Changelog) | Änderungen je Version |

## Funktionen im Überblick

- **Automatisches Verkleinern beim Upload** – über den WordPress-Filter `wp_handle_upload`
- **Maximale Breite und Höhe** – Standard 1920 × 1920 px, einstellbar von 100 bis 20000 px
- **JPEG-/WebP-Qualität** – Standard 82, einstellbar von 1 bis 100
- **Dateitypen wählbar** – JPEG, PNG und WebP (standardmäßig alle drei)
- **Optionales Original-Backup** – als `<Dateiname>.original.<Endung>` neben der Datei
- **Automatische Updates** direkt vom GitHub-Branch `main` – oder `beta` mit aktiviertem Beta-Kanal
- **Einheitliches Admin-Design** über die gebündelte Bibliothek WP-Backend UI
