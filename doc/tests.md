# ✅ Testdokumentation – Haushaltsbuch Webanwendung

Autor: Kenan Mahmic
Projekt: Haushaltsbuch

---

## 🔐 Benutzerlogin

### T01: Login als Admin – erfolgreich
- **E-Mail**: admin@example.com
- **Passwort**: admin123
- ✅ Erwartet: Weiterleitung zum Dashboard mit Adminrechten
- ✅ Ergebnis: ✔️ Erfolgreich

### T02: Login mit falschem Passwort
- E-Mail: admin@example.com
- Passwort: falschespasswort
- ❌ Erwartet: Fehlermeldung
- ✅ Ergebnis: ✔️ Fehler korrekt erkannt

### T03: Login mit leerem Passwort
- E-Mail: admin@example.com
- Passwort: [leer]
- ✅ Ergebnis: Formularvalidierung greift

---

## 👥 Rollen & Rechte

### R01: Admin sieht Admin-Bereich
- ✅ Erwartet: Menü zeigt Statistik, Benutzerverwaltung, Kategorien
- ✅ Ergebnis: ✔️ Sichtbar

### R02: Normaler Benutzer sieht kein Adminbereich
- ✅ Ergebnis: ✔️ Kein Zugriff auf Adminmenü

### R03: Benutzer ruft `/controllers/StatisticController.php` direkt auf
- ✅ Erwartet: 403 Fehler
- ✅ Ergebnis: ✔️ Zugriff verweigert

---

## 📁 Kategorien (Admin)

### C01: Kategorie anlegen
- Name: „Freizeit“
- ✅ Ergebnis: ✔️ Erfolgreich angelegt

### C02: Kategorie bearbeiten
- Name ändern: „Miete“ → „Wohnung“
- ✅ Ergebnis: ✔️ Erfolgreich

### C03: Kategorie löschen
- Kategorie mit keiner Transaktion
- ✅ Ergebnis: ✔️ Erfolgreich gelöscht

### C04: Kategorie löschen (verknüpft)
- Erwartet: Fehler oder referentielle Löschung
- Ergebnis: ✔️ Wird korrekt behandelt

---

## 💳 Transaktionen

### T10: Neue Buchung anlegen
- Daten: 2025-06-01, -20€, „Lebensmittel“
- ✅ Ergebnis: ✔️ Wird gespeichert und gelistet

### T11: Buchung bearbeiten
- Betrag ändern auf -25€
- ✅ Ergebnis: ✔️ Update erfolgreich

### T12: Buchung löschen
- ✅ Ergebnis: ✔️ Buchung entfernt (soft-delete oder hard-delete)

### T13: Negative Buchung = Ausgabe
- ✅ Ergebnis: Wird korrekt als Ausgabe gezählt

### T14: Positive Buchung = Einnahme
- ✅ Ergebnis: Wird korrekt als Einnahme gezählt

### T15: Leere Pflichtfelder
- ✅ Ergebnis: Validierungsfehler werden angezeigt

---

## 🧪 Gesamturteil

Die Applikation reagiert korrekt auf gültige und fehlerhafte Eingaben.
Rollenspezifische Views und Rechte sind sauber getrennt.
CRUD-Operationen funktionieren wie erwartet.

---
