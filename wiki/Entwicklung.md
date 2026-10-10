# Entwicklung

PixelDiet ist bewusst klein gehalten: vier Klassen, eine Option, keine eigenen Tabellen.

## Architektur

```
pixel-diet.php
   ├─ lädt lib/wp-backend-ui und includes/*
   ├─ wpb_admin_ui_register()      Admin-Design für die Seite „pixel-diet“
   ├─ register_activation_hook ──► Pixel_Diet_Settings::set_defaults_on_activate()
   └─ plugins_loaded ───────────► Pixel_Diet::instance()
                                      ├─ new Pixel_Diet_Settings   Einstellungsseite, Option
                                      ├─ new Pixel_Diet_Resizer    Verkleinern beim Upload
                                      └─ new Pixel_Diet_Updater    Updates aus GitHub
```

## Verzeichnisstruktur

```
pixel-diet/
├── pixel-diet.php                          Plugin-Header, Konstanten, Bootstrap
├── uninstall.php                           Entfernt die Option beim Löschen
├── includes/
│   ├── class-pixel-diet.php                Singleton, initialisiert die Komponenten
│   ├── class-pixel-diet-settings.php       Einstellungsseite (Settings API), Defaults, Sanitizing
│   ├── class-pixel-diet-resizer.php        Verkleinern beim Upload, Qualitätsfilter
│   └── class-pixel-diet-updater.php        Self-Update via plugin-update-checker
├── lib/wp-backend-ui/                      Gebündelte Bibliothek WP-Backend UI 1.0.2 (nicht ändern)
├── vendor/plugin-update-checker/           Gebündelte Bibliothek plugin-update-checker v5.7
└── wiki/                                   Quelle dieses Wikis
```

## Konstanten

| Konstante | Wert |
|---|---|
| `PIXEL_DIET_VERSION` | `1.2.1` |
| `PIXEL_DIET_FILE` | Pfad zu `pixel-diet.php` |
| `PIXEL_DIET_PATH` | Plugin-Verzeichnis (mit abschließendem `/`) |
| `PIXEL_DIET_URL` | Plugin-URL (mit abschließendem `/`) |
| `PIXEL_DIET_OPTION` | `pixel_diet_settings` |

## Klassen

| Klasse | Aufgabe |
|---|---|
| `Pixel_Diet` | Singleton (`Pixel_Diet::instance()`), erzeugt die drei Komponenten |
| `Pixel_Diet_Settings` | `defaults()`, `get_settings()` (gespeicherte Werte mit Defaults zusammengeführt), `sanitize()`, Rendern der Seite. Konstanten `OPTION_KEY = 'pixel_diet_settings'`, `PAGE_SLUG = 'pixel-diet'` |
| `Pixel_Diet_Resizer` | `process_upload()` am Filter `wp_handle_upload`, `backup_original()`, Qualitätsfilter |
| `Pixel_Diet_Updater` | Baut den Update Checker für `https://github.com/mrclksr2409/pixeldiet/`, Slug `pixel-diet`, wählt Branch `main` bzw. `beta` und entfernt die Erkennungsstrategien `latest_release` und `latest_tag` |

## Verwendete WordPress-Hooks

PixelDiet stellt **keine eigenen** Actions oder Filter bereit. Es nutzt diese WordPress-Hooks:

| Hook | Typ | Klasse / Methode | Zweck |
|---|---|---|---|
| `plugins_loaded` | Action | `Pixel_Diet::instance` | Plugin starten |
| `admin_init` | Action | `Pixel_Diet_Settings::register_settings` | Setting, Abschnitte und Felder registrieren |
| `admin_menu` | Action | `Pixel_Diet_Settings::register_menu` | Seite unter *Einstellungen* anlegen |
| `plugin_action_links_pixel-diet/pixel-diet.php` | Filter | `Pixel_Diet_Settings::action_links` | Link „Einstellungen“ in der Plugin-Liste |
| `plugin_row_meta` | Filter | `Pixel_Diet_Settings::row_meta` | Link „Wiki“ in der Plugin-Liste |
| `wp_handle_upload` | Filter (Prio 10) | `Pixel_Diet_Resizer::process_upload` | Bild verkleinern |
| `jpeg_quality` | Filter (Prio 10) | `Pixel_Diet_Resizer::filter_jpeg_quality` | JPEG-Qualität |
| `wp_editor_set_quality` | Filter (Prio 10) | `Pixel_Diet_Resizer::filter_editor_quality` | JPEG-/WebP-Qualität |
| `puc_vcs_update_detection_strategies-pixel-diet` | Filter | `Pixel_Diet_Updater::filter_strategies` | Releases und Tags ignorieren (Name über `getUniqueName()` des Update Checkers) |

Der Aktivierungs-Hook (`register_activation_hook`) ruft
`Pixel_Diet_Settings::set_defaults_on_activate()` auf.

## Konventionen

- Klassen mit Präfix `Pixel_Diet_`, Dateien `includes/class-pixel-diet-*.php`, Text-Domain `pixel-diet`
- Oberfläche auf Deutsch, Code und Kommentare auf Englisch
- Neue Einstellung: Schlüssel in `Pixel_Diet_Settings::defaults()` **und** in `sanitize()`
  ergänzen – `sanitize()` baut das gespeicherte Array komplett neu auf, nicht dort behandelte
  Schlüssel gehen beim Speichern verloren. Gelesen wird immer über `get_settings()`, das fehlende
  Schlüssel mit den Defaults auffüllt.
- `lib/wp-backend-ui/` wird nicht direkt bearbeitet. Für ein Update die neue Version aus dem
  WP-Backend-UI-Repository nach `lib/wp-backend-ui/` kopieren (ohne `demo/`, `examples/`, `docs/`,
  `.git`).

## Lokal testen

- Syntax: `find . -name '*.php' -not -path './vendor/*' -not -path './lib/*' -exec php -l {} \;`
- Einstellungen ansehen: `wp option get pixel_diet_settings --format=json`
- Ein großes Testbild hochladen, z. B. per WP-CLI: `wp media import /pfad/zu/gross.jpg`

## Release

Updates werden direkt vom Branch `main` ausgeliefert, GitHub-Releases und Tags werden ignoriert
(siehe [Updates](Updates)).

1. Entwickeln auf dem Branch `beta`.
2. Versionsnummer in `pixel-diet.php` (Plugin-Header **und** Konstante `PIXEL_DIET_VERSION`) sowie
   in `readme.txt` (`Stable tag`) erhöhen. Für Beta-Stände eine Vorabversion wie `1.3.0-beta.1`.
3. Changelog in `README.md`, `readme.txt` und [Changelog](Changelog) ergänzen.
4. `beta` nach `main` übernehmen und pushen.
5. WordPress-Installationen sehen das Update beim nächsten automatischen Check bzw. sofort über
   *Dashboard → Aktualisierungen → Erneut prüfen*.

## Wiki

Dieses Wiki liegt im Ordner `wiki/` des Repositorys. Der Workflow
`.github/workflows/wiki-sync.yml` spiegelt den Ordner bei jedem Push auf `main` (mit Änderungen in
`wiki/`) in das GitHub-Wiki. Änderungen direkt im GitHub-Wiki werden dabei überschrieben.
