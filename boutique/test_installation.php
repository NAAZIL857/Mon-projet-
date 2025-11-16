<?php
/**
 * Script de test pour vérifier l'installation de la boutique
 * À exécuter après l'installation pour s'assurer que tout fonctionne
 */

echo "<h1>Test d'installation - Boutique E-commerce</h1>";

// Test 1: Configuration
echo "<h2>1. Test de configuration</h2>";
if (file_exists('config.php')) {
    require_once 'config.php';
    echo "✅ Fichier config.php trouvé<br>";
    echo "✅ Base de données configurée: " . DB_NAME . "<br>";
    echo "✅ URL de base: " . BASE_URL . "<br>";
} else {
    echo "❌ Fichier config.php manquant<br>";
}

// Test 2: Connexion à la base de données
echo "<h2>2. Test de connexion à la base de données</h2>";
try {
    require_once 'app/core/Database.php';
    $db = Database::getInstance();
    echo "✅ Connexion à la base de données réussie<br>";
    
    // Test des tables
    $tables = ['users', 'categories', 'produits', 'commandes', 'commande_produit'];
    foreach ($tables as $table) {
        $result = $db->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            echo "✅ Table '$table' existe<br>";
        } else {
            echo "❌ Table '$table' manquante<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Erreur de connexion: " . $e->getMessage() . "<br>";
}

// Test 3: Permissions des dossiers
echo "<h2>3. Test des permissions</h2>";
$upload_dir = __DIR__ . '/public/images/';
if (is_dir($upload_dir)) {
    if (is_writable($upload_dir)) {
        echo "✅ Dossier d'upload accessible en écriture<br>";
    } else {
        echo "❌ Dossier d'upload non accessible en écriture<br>";
    }
} else {
    echo "❌ Dossier d'upload manquant<br>";
}

// Test 4: Extensions PHP
echo "<h2>4. Test des extensions PHP</h2>";
$extensions = ['pdo', 'pdo_mysql', 'gd', 'session'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ Extension '$ext' chargée<br>";
    } else {
        echo "❌ Extension '$ext' manquante<br>";
    }
}

// Test 5: Fichiers principaux
echo "<h2>5. Test des fichiers principaux</h2>";
$files = [
    'index.php',
    'app/core/Database.php',
    'app/core/Router.php',
    'app/core/Session.php',
    'app/controllers/ProduitController.php',
    'app/controllers/UserController.php',
    'app/controllers/CommandeController.php',
    'app/models/Produit.php',
    'app/models/User.php',
    'app/models/Commande.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ Fichier '$file' présent<br>";
    } else {
        echo "❌ Fichier '$file' manquant<br>";
    }
}

// Test 6: Données de test
echo "<h2>6. Test des données de test</h2>";
try {
    // Test utilisateur admin
    $admin = $db->fetch("SELECT * FROM users WHERE email = 'admin@boutique.com'");
    if ($admin) {
        echo "✅ Compte administrateur trouvé<br>";
    } else {
        echo "❌ Compte administrateur manquant<br>";
    }
    
    // Test produits
    $produits = $db->fetchAll("SELECT COUNT(*) as count FROM produits");
    if ($produits[0]['count'] > 0) {
        echo "✅ Produits de test présents (" . $produits[0]['count'] . ")<br>";
    } else {
        echo "❌ Aucun produit de test<br>";
    }
    
    // Test catégories
    $categories = $db->fetchAll("SELECT COUNT(*) as count FROM categories");
    if ($categories[0]['count'] > 0) {
        echo "✅ Catégories de test présentes (" . $categories[0]['count'] . ")<br>";
    } else {
        echo "❌ Aucune catégorie de test<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur lors du test des données: " . $e->getMessage() . "<br>";
}

echo "<h2>🎉 Test terminé</h2>";
echo "<p><strong>Si tous les tests sont verts (✅), votre installation est prête !</strong></p>";
echo "<p><a href='index.php'>🚀 Accéder à la boutique</a></p>";
echo "<p><em>Supprimez ce fichier test_installation.php après vérification.</em></p>";
?>