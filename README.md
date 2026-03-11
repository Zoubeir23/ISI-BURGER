<div align="center">

# 🍔 ISI BURGER

### Système de gestion de commandes pour restaurant

Application web full-stack permettant aux clients de commander en autonomie via un kiosque numérique,
et au personnel de gérer les commandes, stocks, paiements et factures depuis un back-office dédié.

<br>

**Backend**

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-336791?logo=postgresql&logoColor=white)

**Frontend**

![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-4.0-06B6D4?logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.0-646CFF?logo=vite&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.0-FF6384?logo=chartdotjs&logoColor=white)

**Statut**

![Version](https://img.shields.io/badge/Version-1.0.0-e53e3e)
![PHP](https://img.shields.io/badge/PHP-%3E%3D8.2-777BB4?logo=php&logoColor=white)
![License](https://img.shields.io/badge/Licence-Académique-lightgrey)
![ISI](https://img.shields.io/badge/ISI-L3%20IAGE%202025--2026-1a1a2e)

</div>

---

## Table des matières

- [Aperçu](#-aperçu)
- [Fonctionnalités](#-fonctionnalités)
- [Stack technique](#-stack-technique)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Accès & identifiants](#-accès--identifiants)
- [Structure du projet](#-structure-du-projet)
- [Flux de commande](#-flux-de-commande)
- [Emails transactionnels](#-emails-transactionnels)
- [Tests](#-tests)
- [Licence](#-licence)

---

## 🎯 Aperçu

ISI BURGER est une application de gestion de restaurant en deux parties :

```
┌─────────────────────────────────────┐    ┌──────────────────────────────────────┐
│         KIOSQUE CLIENT              │    │         ESPACE ADMIN                 │
│          (public)                   │    │         (authentifié)                │
│                                     │    │                                      │
│  📋 Catalogue de burgers            │    │  📊 Dashboard & statistiques         │
│  🔍 Recherche + filtres             │    │  🍔 Gestion des burgers              │
│  🛒 Panier en temps réel            │    │  📦 Gestion des commandes            │
│  📝 Passage de commande             │    │  📈 Gestion des stocks               │
│  ✅ Confirmation + n° de commande   │    │  💰 Enregistrement des paiements     │
│                                     │    │  🧾 Génération de factures PDF       │
│  localhost:8000/                    │    │  localhost:8000/admin                │
└─────────────────────────────────────┘    └──────────────────────────────────────┘
```

---

## ✨ Fonctionnalités

### 🛒 Kiosque Client

| Fonctionnalité | Détail |
|---|---|
| **Catalogue** | Affichage paginé des burgers avec image, description et prix |
| **Recherche & Filtres** | Par nom, catégorie et fourchette de prix (min/max FCFA) |
| **Stocks temps réel** | Badge `Disponible` / `Stock faible` / `Épuisé` sur chaque carte |
| **Panier** | Géré en `localStorage` — persistent entre les pages |
| **Commande** | Saisie du nom + téléphone, email optionnel |
| **Confirmation** | Page de confirmation avec numéro `ISI-BURGER-YYYY-NNNN` |
| **Interface** | Mode sombre/clair, responsive, animations fluides |

### 🔐 Espace Administration

| Module | Fonctionnalités |
|---|---|
| **Dashboard** | Commandes en cours, recettes du jour, taux d'annulation, graphiques Chart.js |
| **Burgers** | Ajout, modification, archivage ; upload image (fichier ou URL) |
| **Commandes** | Liste filtrée, vue détail, changement de statut, annulation avec restitution stock |
| **Stocks** | Mise à jour des quantités disponibles par burger |
| **Paiements** | Enregistrement en espèces (une fois par commande, montant validé) |
| **Factures PDF** | Générée automatiquement au statut *Prête*, téléchargeable depuis le détail |

### 📧 Notifications Email

Envoi automatique à chaque étape clé de la commande :

| Événement | Email envoyé |
|---|---|
| Commande créée | Confirmation de commande |
| Commande prête | Notification de retrait au comptoir |
| Paiement enregistré | Reçu de paiement + facture PDF en pièce jointe |
| Commande livrée | Email de clôture + invitation à noter |

---

## 🛠️ Stack technique

### Backend
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-336791?logo=postgresql&logoColor=white)

### Frontend
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-4.0-06B6D4?logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.0-646CFF?logo=vite&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.0-FF6384?logo=chartdotjs&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-FF2D20?logo=laravel&logoColor=white)

### Librairies notables

| Package | Usage |
|---|---|
| `barryvdh/laravel-dompdf ^3.1` | Génération de factures PDF |
| `laravel/framework ^12.0` | Framework principal |
| `@tailwindcss/vite ^4.0` | Compilation CSS |
| `laravel-vite-plugin ^2.0` | Intégration Vite/Laravel |
| Material Symbols (Google Fonts) | Icônes UI |

---

## ⚡ Installation

### Prérequis

- **PHP** >= 8.2 avec extensions `pdo_pgsql`, `mbstring`, `openssl`, `gd`
- **Composer** >= 2.x
- **Node.js** >= 18 + **npm**
- **PostgreSQL** >= 14

### Démarrage rapide

```bash
# 1. Cloner le dépôt
git clone https://github.com/Zoubeir23/ISI-BURGER.git
cd ISI-BURGER

# 2. Dépendances PHP + Node
composer install
npm install

# 3. Environnement
cp .env.example .env
php artisan key:generate

# 4. Base de données (voir section Configuration ci-dessous)
php artisan migrate
php artisan db:seed --class=AdminUserSeeder

# 5. Stockage & assets
php artisan storage:link
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
npm run build

# 6. Démarrer
php artisan serve
```

→ Ouvrir **http://localhost:8000**

---

## ⚙️ Configuration

### Base de données

Éditer le fichier `.env` :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db-isi-burger
DB_USERNAME=Votre_nom_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

Créer la base avant de migrer :

```sql
CREATE DATABASE "db-isi-burger";
```

### Emails (SMTP)

ISI BURGER envoie 4 emails transactionnels. Configuration recommandée avec Gmail :

```env
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre@gmail.com
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"   # Mot de passe d'application Gmail
MAIL_FROM_ADDRESS="votre@gmail.com"
MAIL_FROM_NAME="ISI BURGER"
```

> **Note** : Utilisez un [mot de passe d'application Google](https://myaccount.google.com/apppasswords) (pas votre mot de passe Gmail habituel). La variable `MAIL_ENCRYPTION` n'est plus utilisée dans Laravel 12 — seul `MAIL_SCHEME` est nécessaire.

Pour tester sans serveur mail (développement local) :

```env
MAIL_MAILER=log
```

→ Les emails s'écrivent dans `storage/logs/laravel.log`

### Stockage des images & factures

```env
FILESYSTEM_DISK=local   # Par défaut
```

Après `php artisan storage:link`, les fichiers uploadés sont accessibles via `/storage/`.

---

## 🚪 Accès & identifiants

| Interface | URL | Identifiants par défaut |
|---|---|---|
| **Kiosque client** | `http://localhost:8000` | — (public, sans connexion) |
| **Administration** | `http://localhost:8000/admin` | `admin@isiburger.com` / `password` |

> ⚠️ Changer le mot de passe admin après la première connexion en production.

---

## 📁 Structure du projet

```
ISI-BURGER/
├── app/
│   ├── Http/Controllers/
│   │   ├── KioskController.php          # Kiosque public — catalogue, commande
│   │   └── Admin/
│   │       ├── AuthController.php       # Connexion / déconnexion admin
│   │       ├── DashboardController.php  # Tableau de bord + statistiques
│   │       ├── OrderController.php      # Commandes, statuts, PDF factures
│   │       ├── BurgerController.php     # CRUD burgers + upload image
│   │       ├── StockController.php      # Mise à jour des stocks
│   │       └── PaymentController.php    # Enregistrement paiements
│   ├── Mail/
│   │   ├── OrderConfirmation.php        # Email de confirmation de commande
│   │   ├── OrderReady.php               # Email commande prête (+ facture PDF)
│   │   ├── OrderPaid.php                # Email paiement confirmé
│   │   └── OrderDelivered.php           # Email commande livrée
│   └── Models/
│       ├── Burger.php                   # Burger (soft delete via archivage)
│       ├── Order.php                    # Commande (numéro ISI-BURGER-YYYY-NNNN)
│       ├── OrderItem.php                # Ligne de commande
│       └── Payment.php                  # Paiement (un par commande)
│
├── database/
│   ├── migrations/                      # 11 migrations
│   └── seeders/
│       └── AdminUserSeeder.php          # Crée l'admin par défaut
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── admin.blade.php          # Layout back-office
│   │   │   └── kiosk.blade.php          # Layout kiosque (dark/light mode)
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── burgers/                 # index, create, edit
│   │   │   ├── orders/                  # index, show
│   │   │   └── stocks/                  # index
│   │   ├── kiosk/
│   │   │   ├── index.blade.php          # Catalogue + recherche + panier
│   │   │   ├── checkout.blade.php       # Formulaire de commande
│   │   │   └── confirmation.blade.php   # Page de confirmation
│   │   ├── emails/
│   │   │   ├── order-confirmation.blade.php
│   │   │   ├── order-ready.blade.php
│   │   │   ├── order-paid.blade.php
│   │   │   └── order-delivered.blade.php
│   │   └── invoices/
│   │       └── order.blade.php          # Template facture PDF
│   └── css/
│       └── app.css                      # Tailwind CSS 4 + source paths
│
├── routes/
│   └── web.php                          # Toutes les routes (kiosque + admin)
│
└── tests/
    └── Feature/
        └── KioskOrderTest.php           # Tests de passage de commande
```

---

## 🔄 Flux de commande

```
Client (Kiosque)                    Admin (Back-office)
       │                                    │
       │  Passe une commande                │
       ▼                                    │
  ┌─────────┐                               │
  │ PENDING │  ←── Email confirmation       │
  └────┬────┘      envoyé au client         │
       │                          Admin traite la commande
       ▼                                    │
  ┌────────────┐                            │
  │ PREPARING  │  ←── Statut mis à jour     │
  └─────┬──────┘      par l'admin           │
        │                                   │
        ▼                                   │
  ┌───────┐                                 │
  │ READY │  ←── Facture PDF générée        │
  └───┬───┘      + Email client             │
      │                                     │
      ▼                                     │
  ┌──────┐                                  │
  │ PAID │  ←── Paiement enregistré         │
  └──┬───┘      + Email reçu                │
     │                                      │
     ▼                                      │
┌──────────┐                                │
│ DELIVERED│  ←── Email final envoyé        │
└──────────┘                                │
     │
     │  (à tout moment)
     ▼
┌──────────┐
│CANCELLED │  ←── Stock restitué automatiquement
└──────────┘
```

---

## 📧 Emails transactionnels

Les 4 emails sont des templates HTML email-compatible (table-based, système fonts, responsive).

| Email | Couleur accent | Déclencheur |
|---|---|---|
| Confirmation de commande | Rouge `#e53e3e` | Création de la commande (`KioskController`) |
| Commande prête | Orange `#f97316` | Statut → `ready` (`OrderController`) |
| Paiement confirmé | Émeraude `#10b981` | Statut → `paid` (`OrderController`) |
| Commande livrée | Ambre `#f59e0b` | Statut → `delivered` (`OrderController`) |

---

## 🧪 Tests

```bash
# Lancer tous les tests
php artisan test

# Avec détail
php artisan test --verbose
```

Le fichier `tests/Feature/KioskOrderTest.php` couvre :
- Création d'une commande via le kiosque
- Validation du format du numéro de commande (`ISI-BURGER-YYYY-NNNN`)
- Décrémentation du stock à la commande
- Persistance en base de données

---

## 📐 Numérotation des commandes

Chaque commande reçoit un identifiant unique au format :

```
ISI-BURGER-{ANNÉE}-{NUMÉRO_SÉQUENTIEL}

Exemples :
  ISI-BURGER-2026-0001
  ISI-BURGER-2026-0042
  ISI-BURGER-2026-0150
```

Le compteur repart de `0001` chaque année civile.

---

## 📄 Licence

Projet académique réalisé dans le cadre du cursus **L3 IAGE 2025-2026**
à l'**ISI — Institut Supérieur d'Informatique**, Dakar, Sénégal.

---

<div align="center">
  <sub>Développé avec ❤️ · ISI BURGER · L3 IAGE 2025-2026</sub>
</div>
