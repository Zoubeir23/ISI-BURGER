# ISI BURGER — Application de Gestion des Commandes

Application web de gestion des commandes d'un restaurant de burgers, développée avec **Laravel 12** et **PostgreSQL**.

---

## Fonctionnalités

### Kiosque Client (public, sans connexion)

- Catalogue des burgers avec recherche par nom
- Filtrage par catégorie et par fourchette de prix
- Indicateurs de stock en temps réel (Disponible / Stock faible / Épuisé)
- Panier géré en localStorage
- Passage de commande avec nom et numéro de téléphone
- Page de confirmation avec numéro de commande

### Espace Administration

- Authentification sécurisée (email / mot de passe)
- **Dashboard** : commandes en cours, commandes du jour, recettes, annulations, graphiques Chart.js
- **Gestion des burgers** : ajout, modification, archivage, upload d'image ou URL
- **Gestion des commandes** : liste, détail, changement de statut, annulation avec restitution du stock
- **Gestion des stocks** : mise à jour des quantités
- **Paiements** : enregistrement en espèces (une seule fois par commande)
- **Facture PDF** : générée automatiquement au passage au statut "Prête", téléchargeable

### Statuts d'une commande

| Statut | Description |
| --- | --- |
| En attente | Commande reçue, non traitée |
| En préparation | En cours de préparation |
| Prête | Prête — facture PDF générée |
| Payée | Paiement enregistré |
| Livrée | Commande remise au client |
| Annulée | Commande annulée — stock restitué |

---

## Stack technique

| Composant | Technologie |
| --- | --- |
| Framework | Laravel 12 |
| Base de données | PostgreSQL |
| Frontend | Blade, Tailwind CSS, Chart.js |
| PDF | barryvdh/laravel-dompdf |
| Icônes | Material Symbols |
| Auth | Laravel Auth intégré |

---

## Installation

### Prérequis

- PHP >= 8.2
- Composer
- Node.js & npm
- PostgreSQL

### 1. Cloner le projet

```bash
git clone https://github.com/Zoubeir23/ISI-BURGER.git
cd ISI-BURGER
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Modifier le fichier `.env` :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db-isi-burger
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
```

### 4. Publier la config DomPDF

```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### 5. Lancer les migrations et le seeder admin

```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

### 6. Créer le lien de stockage

```bash
php artisan storage:link
```

### 7. Installer les assets frontend

```bash
npm install
npm run build
```

### 8. Démarrer le serveur

```bash
php artisan serve
```

---

## Accès

| Interface | URL | Identifiants |
| --- | --- | --- |
| Kiosque client | <http://localhost:8000> | — |
| Administration | <http://localhost:8000/admin> | `admin@isiburger.com` / `password` |

---

## Structure du projet

```text
app/
├── Http/Controllers/
│   ├── KioskController.php          # Kiosque client
│   └── Admin/
│       ├── AuthController.php       # Authentification
│       ├── DashboardController.php  # Tableau de bord
│       ├── OrderController.php      # Commandes + PDF
│       ├── BurgerController.php     # CRUD burgers
│       ├── StockController.php      # Gestion stocks
│       └── PaymentController.php    # Paiements
├── Models/
│   ├── Burger.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── Payment.php
resources/views/
├── layouts/
│   ├── admin.blade.php
│   └── kiosk.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── burgers/
│   ├── orders/
│   └── stocks/
├── kiosk/
│   ├── index.blade.php
│   ├── checkout.blade.php
│   └── confirmation.blade.php
└── invoices/
    └── order.blade.php              # Template facture PDF
```

---

## Licence

Projet académique — ISI (Institut Supérieur d'Informatique), L3 IAGE 2025-2026.
