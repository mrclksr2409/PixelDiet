# Updates

PixelDiet aktualisiert sich über den
[Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) (v5.7, gebündelt unter
`vendor/plugin-update-checker/`) direkt aus dem GitHub-Repository
[`mrclksr2409/PixelDiet`](https://github.com/mrclksr2409/PixelDiet) – wie ein Plugin aus dem
offiziellen Verzeichnis.

## Stabile Updates (Standard)

WordPress prüft den **`main`-Branch**: Steht dort im Plugin-Header von `pixel-diet.php` eine höhere
Versionsnummer als die installierte, erscheint das Update unter **Dashboard → Aktualisierungen**
und in der Plugin-Liste und lässt sich mit einem Klick installieren (oder automatisch, wenn
Auto-Updates für das Plugin aktiviert sind).

**GitHub-Releases und Tags werden ignoriert** – maßgeblich ist allein der Stand des Branches.

## Beta-Kanal

**Einstellungen → PixelDiet → Updates → Beta-Updates**

Statt `main` folgt das Plugin dem **`beta`-Branch**. Jede höhere Versionsnummer dort (z. B.
`1.3.0-beta.1`) wird als Update angeboten. Sinnvoll für Testseiten – **nicht** für Produktivseiten,
denn Beta-Versionen können Fehler enthalten.

Beim Umschalten des Kanals löscht PixelDiet den zwischengespeicherten Update-Status (die
Site-Option `external_updates-pixel-diet` und das Site-Transient `update_plugins`). So liest der
nächste Check die Version sofort vom anderen Branch.

### Zurück zu stabil

Beta-Updates ausschalten und speichern. Ein **Downgrade findet nicht statt**: Die Seite bleibt auf
ihrer Beta-Version, bis auf `main` eine höhere Versionsnummer erscheint als die installierte Beta.

## Update wird nicht angezeigt

1. **Dashboard → Aktualisierungen → Erneut prüfen** klicken. Ansonsten prüft WordPress
   automatisch etwa alle 12 Stunden.
2. Der Plugin-Ordner muss `pixel-diet` heißen.
3. Der Server muss `github.com` und `api.github.com` erreichen können.
4. GitHub begrenzt anonyme API-Anfragen; bei vielen Seiten hinter einer IP kann die Prüfung
   vorübergehend scheitern – später erneut versuchen.
5. Fehlt der Ordner `vendor/plugin-update-checker/`, ist die Update-Funktion stillschweigend
   abgeschaltet. Das Plugin funktioniert sonst normal.

## Änderungen nachlesen

Siehe [Changelog](Changelog).
