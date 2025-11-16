# Mon-projet-

Boutique e-commerce développée en PHP avec architecture MVC

## Technologies utilisées
- PHP 7+
- MySQL
- Bootstrap 5
- JavaScript

## Installation

1. Cloner le projet
```bash
git clone https://github.com/NAAZIL857/Mon-projet-.git
```

2. Importer la base de données
- Ouvrir phpMyAdmin
- Créer une base de données `boutique_db`
- Importer le fichier `boutique/database.sql`

3. Configurer la connexion
- Copier `boutique/config.example.php` vers `boutique/config.php`
- Modifier les paramètres de connexion à la base de données

4. Lancer le serveur
```bash
cd boutique
php -S localhost:8000
```

## Fonctionnalités
- Gestion des produits
- Panier d'achat
- Gestion des commandes
- Authentification utilisateur
- Panel administrateur
