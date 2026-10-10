# Installation

## Voraussetzungen

| Komponente | Mindestens | Hinweis |
|---|---|---|
| WordPress | 5.5 | |
| PHP | 7.2 | |
| Bild-Editor | – | WordPress muss einen Bild-Editor bereitstellen können (Imagick oder GD), sonst wird nichts verkleinert – siehe [Fehlerbehebung](Fehlerbehebung) |
| HTTPS-Verbindung zu GitHub | – | Nur für die [Updates](Updates) |

Alles Weitere ist gebündelt und muss nicht separat installiert werden:

- **WP-Backend UI 1.0.2** (`lib/wp-backend-ui/`) – gemeinsames Admin-Design. Bündeln mehrere
  Plugins unterschiedliche Kopien, lädt WordPress nur die neueste.
- **plugin-update-checker v5.7** (`vendor/plugin-update-checker/`) – für die Updates aus GitHub.

## Plugin installieren

### Variante A: ZIP über den WordPress-Admin

1. Im [Repository](https://github.com/mrclksr2409/PixelDiet) über **Code → Download ZIP** den
   Branch `main` herunterladen.
2. Die ZIP entpacken und den enthaltenen Ordner (z. B. `PixelDiet-main`) in **`pixel-diet`**
   umbenennen, dann wieder als `pixel-diet.zip` packen.
3. In WordPress **Plugins → Installieren → Plugin hochladen** wählen, die ZIP-Datei auswählen,
   **Jetzt installieren**, danach **Aktivieren**.

### Variante B: Manuell per FTP/SSH oder Git

1. Den Plugin-Ordner nach `wp-content/plugins/pixel-diet/` kopieren bzw. das Repository dorthin
   klonen.
2. Unter **Plugins** auf **Aktivieren** klicken.

> Der Ordnername muss `pixel-diet` lauten, damit die automatischen Updates greifen.

## Was beim Aktivieren passiert

- Existiert die Option `pixel_diet_settings` noch nicht, wird sie mit den Standardwerten angelegt
  (siehe [Einstellungen](Einstellungen)). Bestehende Einstellungen werden nicht überschrieben.
- Es werden **keine** Datenbanktabellen angelegt und keine Cron-Aufgaben eingeplant.
- PixelDiet ist ab sofort aktiv: Neue Uploads werden mit den Standardwerten verarbeitet
  (max. 1920 × 1920 px, Qualität 82, JPEG/PNG/WebP).

Unter **Einstellungen** erscheint der Eintrag **PixelDiet**. Die Seite erfordert
Administratorrechte (`manage_options`). In der Plugin-Liste stehen bei PixelDiet zusätzlich die
Links **Einstellungen** (bei den Aktionen) und **Wiki** (in der Beschreibungszeile, seit 1.2.1).

## Deaktivieren und Deinstallieren

| Aktion | Folge |
|---|---|
| **Deaktivieren** | Neue Uploads werden nicht mehr verkleinert. Einstellungen bleiben erhalten. Bereits verkleinerte Bilder bleiben verkleinert. |
| **Löschen** | Entfernt die Option `pixel_diet_settings`. Bilder in der Mediathek und eventuelle `.original.`-Backups bleiben unangetastet. |

Details: [Datenbank und Deinstallation](Datenbank-und-Deinstallation).

Weiter mit dem **[Schnellstart](Schnellstart)**.
