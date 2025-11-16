# 🛍️ Boutique E-commerce - Architecture MVC

## 📋 Description du projet

Ce projet est une boutique e-commerce complète développée en PHP avec une architecture MVC (Modèle-Vue-Contrôleur). Il permet la gestion des produits, des clients et des commandes avec une interface moderne et responsive utilisant Bootstrap 5.

## ✨ Fonctionnalités principales

### 👥 Gestion des utilisateurs
- ✅ Inscription et connexion sécurisées
- ✅ Gestion des rôles (client/administrateur)
- ✅ Hachage des mots de passe avec bcrypt
- ✅ Protection CSRF sur tous les formulaires

### 🛍️ Gestion des produits
- ✅ CRUD complet (Créer, Lire, Modifier, Supprimer)
- ✅ Catégories de produits
- ✅ Upload et gestion d'images
- ✅ Gestion des stocks
- ✅ Catalogue avec filtres

### 🧾 Gestion des commandes
- ✅ Panier dynamique avec JavaScript
- ✅ Calcul automatique des totaux
- ✅ Validation et enregistrement des commandes
- ✅ Historique des commandes clients
- ✅ Interface d'administration des commandes

### 📊 Dashboard administrateur
- ✅ Statistiques en temps réel
- ✅ Nombre de produits, commandes et chiffre d'affaires
- ✅ Interface responsive avec Bootstrap 5
- ✅ Actions rapides d'administration

## 🛠️ Technologies utilisées

- **Backend** : PHP 8+
- **Frontend** : HTML5, CSS3, JavaScript (ES6)
- **Framework CSS** : Bootstrap 5
- **Base de données** : MySQL
- **Architecture** : MVC (Modèle-Vue-Contrôleur)
- **Sécurité** : PDO, requêtes préparées, protection CSRF/XSS

## 📁 Structure du projet

```
/boutique/
├── index.php                 # Point d'entrée principal
├── config.php               # Configuration de l'application
├── database.sql             # Script de création de la base de données
├── README.md                # Documentation du projet
├── /app/
│   ├── /controllers/        # Contrôleurs MVC
│   │   ├── ProduitController.php
│   │   ├── UserController.php
│   │   └── CommandeController.php
│   ├── /models/            # Modèles de données
│   │   ├── Produit.php
│   │   ├── User.php
│   │   └── Commande.php
│   ├── /views/             # Vues et templates
│   │   ├── layout.php      # Template principal
│   │   ├── /produits/      # Vues des produits
│   │   ├── /users/         # Vues des utilisateurs
│   │   └── /commandes/     # Vues des commandes
│   └── /core/              # Classes système
│       ├── Database.php    # Gestion base de données
│       ├── Router.php      # Routeur URL
│       └── Session.php     # Gestion des sessions
└── /public/                # Ressources publiques
    ├── /css/
    │   └── style.css       # Styles personnalisés
    ├── /js/
    │   └── app.js          # JavaScript de l'application
    ├── /images/            # Images uploadées
    └── index.php           # Point d'entrée alternatif
```

## 🚀 Installation et configuration

### Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx) ou XAMPP/WAMP
- Extension PHP : PDO, PDO_MySQL, GD (pour les images)

### Étapes d'installation

1. **Cloner ou télécharger le projet**
   ```bash
   git clone [url-du-projet]
   cd boutique
   ```

2. **Configuration de la base de données**
   - Créer une base de données MySQL nommée `boutique_db`
   - Importer le fichier `database.sql` :
   ```sql
   mysql -u root -p boutique_db < database.sql
   ```

3. **Configuration de l'application**
   - Modifier le fichier `config.php` avec vos paramètres :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'boutique_db');
   define('DB_USER', 'votre_utilisateur');
   define('DB_PASS', 'votre_mot_de_passe');
   define('BASE_URL', 'http://localhost/boutique/');
   ```

4. **Permissions des dossiers**
   ```bash
   chmod 755 public/images/
   ```

5. **Accès à l'application**
   - Ouvrir votre navigateur : `http://localhost/boutique/`

## 👤 Comptes de test

Le script SQL inclut des comptes de démonstration :

### Administrateur
- **Email** : admin@boutique.com
- **Mot de passe** : password

### Client
- **Email** : client@test.com
- **Mot de passe** : password

## 🔧 Configuration avancée

### Variables d'environnement
Modifiez `config.php` pour adapter l'application à votre environnement :

```php
// Mode développement/production
define('ENVIRONMENT', 'development'); // ou 'production'

// Chemin d'upload des images
define('UPLOAD_PATH', __DIR__ . '/public/images/');
define('UPLOAD_URL', BASE_URL . 'public/images/');

// Configuration de sécurité
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_NAME', 'boutique_session');
```

### Base de données
La base de données comprend les tables suivantes :
- `users` : Utilisateurs (clients et administrateurs)
- `categories` : Catégories de produits
- `produits` : Produits avec images et stock
- `commandes` : Commandes des clients
- `commande_produit` : Détails des commandes (panier)

## 🎨 Personnalisation

### Styles CSS
Modifiez `public/css/style.css` pour personnaliser l'apparence :
- Variables CSS pour les couleurs
- Classes utilitaires Bootstrap étendues
- Animations et transitions

### JavaScript
Le fichier `public/js/app.js` contient :
- Gestion du panier dynamique (AJAX)
- Animations et interactions
- Validation des formulaires
- Notifications toast

## 🔒 Sécurité

Le projet implémente plusieurs mesures de sécurité :
- **Protection CSRF** : Tokens sur tous les formulaires
- **Protection XSS** : Échappement des données avec `htmlspecialchars()`
- **Injection SQL** : Requêtes préparées PDO
- **Authentification** : Hachage bcrypt des mots de passe
- **Sessions** : Gestion sécurisée des sessions utilisateur
- **Upload** : Validation des types et tailles de fichiers

## 📱 Responsive Design

L'interface est entièrement responsive grâce à Bootstrap 5 :
- Navigation adaptative avec menu burger
- Grilles flexibles pour les produits
- Tableaux responsives pour l'administration
- Optimisation mobile et tablette

## 🚀 Fonctionnalités avancées

### Panier dynamique
- Ajout de produits sans rechargement de page
- Mise à jour des quantités en temps réel
- Calcul automatique des totaux
- Notifications visuelles

### Administration
- Dashboard avec statistiques
- Gestion complète des produits
- Suivi des commandes et statuts
- Interface intuitive et moderne

## 🐛 Dépannage

### Erreurs courantes

1. **Erreur de connexion à la base de données**
   - Vérifier les paramètres dans `config.php`
   - S'assurer que MySQL est démarré
   - Vérifier les permissions utilisateur

2. **Images non affichées**
   - Vérifier les permissions du dossier `public/images/`
   - Contrôler le chemin `UPLOAD_URL` dans `config.php`

3. **Erreur 404 sur les routes**
   - Vérifier la configuration du serveur web
   - S'assurer que `mod_rewrite` est activé (Apache)

### Logs d'erreurs
Les erreurs sont enregistrées dans les logs PHP. En mode développement, elles s'affichent directement.

## 📈 Améliorations possibles

- Système de paiement en ligne
- Gestion des promotions et codes de réduction
- Système de notation et commentaires
- API REST pour applications mobiles
- Système de notifications par email
- Gestion multi-langues
- Cache et optimisation des performances

## 📄 Licence

Ce projet est développé à des fins éducatives et de démonstration.

## 👨‍💻 Auteur

Projet développé dans le cadre d'un exercice d'architecture MVC en PHP.

---

**Note** : Ce projet est conçu pour l'apprentissage et la démonstration. Pour un usage en production, des améliorations de sécurité et de performance supplémentaires seraient nécessaires.





Commande pour créer un admin
```sql
 INSERT INTO users (nom, email, password, role)
VALUES (
  'Azerty',
  'azerty@exemple.com',
  '$2y$10$a5dvUkGk5RemGNdD9df6duNyMVOpyRvf1uQUYdY1bRiCJ4RGLL9H6',
  'admin'
);
