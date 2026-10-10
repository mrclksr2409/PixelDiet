# Einstellungen

**Einstellungen → PixelDiet** (Seiten-Slug `pixel-diet`, erfordert `manage_options`). Alle Werte
werden gemeinsam in der Option `pixel_diet_settings` gespeichert – siehe
[Datenbank und Deinstallation](Datenbank-und-Deinstallation).

Die Seite hat zwei Abschnitte: **Bildverkleinerung** und **Updates**. Ein Klick auf
**Änderungen speichern** speichert beide.

---

## Abschnitt: Bildverkleinerung

| Einstellung | Schlüssel | Beschreibung | Standard | Erlaubte Werte |
|---|---|---|---|---|
| **Plugin aktiv** | `enabled` | Schalter „Bilder beim Upload automatisch verkleinern“. Aus = PixelDiet verkleinert nichts und beeinflusst auch die Bildqualität nicht mehr. | an (`1`) | an / aus |
| **Maximale Breite (px)** | `max_width` | Größte erlaubte Breite nach dem Upload | `1920` | 100 – 20000 |
| **Maximale Höhe (px)** | `max_height` | Größte erlaubte Höhe nach dem Upload | `1920` | 100 – 20000 |
| **JPEG-/WebP-Qualität (1-100)** | `jpeg_quality` | Kompressionsqualität für JPEG und WebP. Empfohlen: 80–85. | `82` | 1 – 100 |
| **Zu verarbeitende Dateitypen** | `mime_types` | Checkboxen: JPEG (.jpg, .jpeg), PNG (.png), WebP (.webp) | alle drei | beliebige Teilmenge |
| **Original-Backup behalten** | `keep_original` | Vor dem Verkleinern eine Kopie als `<Dateiname>.original.<Endung>` speichern | aus (`0`) | an / aus |

### Wie Eingaben geprüft werden

Beim Speichern bereinigt PixelDiet alle Werte:

- **Breite, Höhe, Qualität** werden in positive Ganzzahlen umgewandelt und auf den erlaubten
  Bereich begrenzt. Zu kleine Werte werden auf das Minimum angehoben, zu große auf das Maximum
  gesenkt – es gibt keine Fehlermeldung. Beispiel: `50` px wird zu `100`, `30000` zu `20000`,
  Qualität `0` wird zu `1`. Ein leeres Feld ergibt ebenfalls das Minimum.
- **Dateitypen**: Nur `image/jpeg`, `image/png` und `image/webp` werden übernommen. Ist **kein**
  Typ angehakt, wird eine leere Liste gespeichert – dann verkleinert PixelDiet **gar nichts**.
- **Schalter** werden als `1` (an) oder `0` (aus) gespeichert.

### Hinweise

- Breite und Höhe wirken als **Rahmen**: Das Bild wird so verkleinert, dass es in beide Grenzen
  passt, ohne Zuschnitt. Soll nur die Breite begrenzt werden, setze die Höhe auf einen hohen Wert
  (z. B. `20000`). Beispiele unter [Funktionsweise](Funktionsweise#4-verkleinern).
- Die Qualität gilt nicht nur für verkleinerte Bilder, sondern – solange das Plugin aktiv ist – für
  alle JPEG-/WebP-Dateien, die WordPress über seinen Bild-Editor speichert, also auch für die
  Zwischengrößen. Siehe [Funktionsweise](Funktionsweise#qualität-auch-für-zwischengrößen).
- Änderungen gelten nur für **künftige** Uploads.

---

## Abschnitt: Updates

„Updates werden direkt aus GitHub geladen.“

| Einstellung | Schlüssel | Beschreibung | Standard |
|---|---|---|---|
| **Beta-Updates** | `beta_updates` | Schalter „Beta-Versionen installieren (Branch „beta“ statt „main“)“ | aus (`0`) |

Beta-Versionen enthalten neue Funktionen vor dem offiziellen Release und können Fehler enthalten.
Wird der Schalter umgelegt, verwirft PixelDiet beim Speichern den zwischengespeicherten
Update-Status, damit der nächste Check sofort den gewählten Branch nutzt. Details unter
[Updates](Updates).

---

## Standardwerte auf einen Blick

```php
array(
    'enabled'       => 1,
    'max_width'     => 1920,
    'max_height'    => 1920,
    'jpeg_quality'  => 82,
    'mime_types'    => array( 'image/jpeg', 'image/png', 'image/webp' ),
    'keep_original' => 0,
    'beta_updates'  => 0,
)
```

Fehlt in der gespeicherten Option ein Schlüssel, ergänzt PixelDiet ihn beim Lesen mit dem
Standardwert.
