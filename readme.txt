=== PixelDiet ===
Contributors: mrclksr2409
Tags: images, upload, resize, optimize, media
Requires at least: 5.5
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Verkleinert hochgeladene Bilder automatisch auf eine in den Einstellungen hinterlegte maximale Größe.

== Description ==

PixelDiet hängt sich in den WordPress-Upload-Prozess ein und verkleinert Bilder direkt nach dem Upload auf eine konfigurierbare Maximalbreite und -höhe. Das Seitenverhältnis bleibt dabei erhalten. So sparst du Speicherplatz und Bandbreite, ohne dass deine Redakteure manuell auf die Bildgröße achten müssen.

Funktionen:

* Automatisches Verkleinern beim Upload (kein manueller Eingriff nötig)
* Einstellbare Maximalbreite und -höhe
* Einstellbare JPEG-/WebP-Qualität
* Auswahl, welche Dateitypen verarbeitet werden (JPEG, PNG, WebP)
* Optional: Originaldatei als Backup behalten
* Self-Updates direkt vom GitHub-Branch main (via plugin-update-checker)
* Einheitliches, modernes Admin-Design (gebündelte Bibliothek WP-Backend UI)

== Installation ==

1. Plugin-Ordner `pixel-diet` nach `wp-content/plugins/` hochladen.
2. Im WordPress-Backend unter "Plugins" aktivieren.
3. Unter "Einstellungen → PixelDiet" die gewünschte Maximalgröße und Qualität setzen.

== Frequently Asked Questions ==

= Werden bestehende Bilder in der Mediathek verkleinert? =

Nein, PixelDiet verarbeitet ausschließlich neue Uploads. Bestehende Bilder bleiben unverändert.

= Wo kommen die Updates her? =

Die Updates werden direkt vom Branch `main` im Repository `mrclksr2409/pixeldiet` bereitgestellt und über die Bibliothek plugin-update-checker direkt im WordPress-Backend angezeigt.

== Changelog ==

= 1.2.1 =
* Autor ist jetzt Marcel Kaiser, Autor-Link auf das GitHub-Profil.
* Neuer Link „Wiki“ in der Plugin-Übersicht.

= 1.2.0 =
* Neu: Beta-Update-Kanal. Unter Einstellungen → PixelDiet → Updates lassen sich Updates vom Branch "beta" statt "main" beziehen.
* Beim Wechsel des Update-Kanals wird der zwischengespeicherte Update-Status verworfen, damit der nächste Check sofort den gewählten Branch nutzt.

= 1.1.0 =
* Einstellungsseite im einheitlichen Admin-Design über die gebündelte Bibliothek WP-Backend UI 1.0.2 (unter lib/wp-backend-ui/).
* Neuer Seitenkopf mit Icon, Untertitel und Versionsanzeige.
* "Plugin aktiv" und "Original-Backup behalten" als Schalter (Toggle).
* Dateityp-Auswahl als barrierearmes Fieldset ohne Inline-Styles.

= 1.0.1 =
* Updates kommen jetzt direkt vom Branch main, GitHub-Releases werden ignoriert.
* Plugin Update Checker auf v5.7 aktualisiert.

= 1.0.0 =
* Erste Veröffentlichung: automatisches Verkleinern beim Upload, Einstellungsseite, GitHub-Self-Update.
