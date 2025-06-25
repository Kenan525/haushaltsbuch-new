# 📘 Haushaltsbuch – Mini-MVC-Framework in PHP

**Ein PHP-MVC-System für die Verwaltung von Haushaltsfinanzen.**  
Features: Benutzerverwaltung, Auth, Kategorien, Buchungen, Statistik, Upload, Adminbereich.  
Volle Trennung von Model, Service, Controller, Templates und einfache Erweiterbarkeit.

---

## 🚀 Quick Start

### Voraussetzungen

- PHP >= 8.1 (mit PDO)
- MariaDB/MySQL
- Docker (empfohlen, siehe unten)

---

### Installation

#### 1. **Projekt clonen und Abhängigkeiten installieren**
#### 2. **Umgebungsvariablen anpassen**
Kopiere .env.example zu .env und passe DB-Zugang an.

#### 3. Docker Start (empfohlen)
docker compose up --build -d

#### Projektstruktur
haushaltsbuch/
├─ assets/
│  ├─ css/style.css
│  └─ js/script.js
├─ config/
│  ├─ config.php
│  └─ routes.php
├─ doc/
│  └─ README.md
├─ public/
│  ├─ index.php
│  └─ assets/
├─ src/
│  ├─ Controller/
│  ├─ Model/
│  ├─ Service/
│  ├─ Database/
│  ├─ Templates/
│  │  ├─ layout.php
│  │  ├─ partials/
│  │  ├─ auth/
│  │  ├─ admin/
│  │  ├─ category/
│  │  └─ transaction/
│  └─ ...
├─ sql/
│  └─ init.sql
└─ .env

### Architektur
public/: Einstiegspunkt, nur index.php als Front-Controller  
src/Controller/: Steuert Requests, prüft Auth, sammelt Daten aus Services, ruft Views auf  
src/Service/: Kapselt Business-Logik und DB-Zugriffe, gibt Models oder Arrays an Controller
src/Model/: Datenmodelle (z.B. User, Transaction, Category)
src/Templates/: Views/Templates (nur Präsentation, keine Logik!)  
assets/: Statische Ressourcen wie CSS, JS, Bilder  

### Routing
Die Routen werden in config/routes.php zentral definiert.

### Templates
Keine Logik, nur Anzeige!  
Layout (layout.php) inkludiert Header/Footer und bindet das jeweilige Content-Template ein
