<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test de configuration</h1>";

// Test 1: Variables d'environnement
echo "<h2>Variables d'environnement:</h2>";
echo "RENDER: " . (getenv('RENDER') ? 'OUI' : 'NON') . "<br>";
echo "DB_HOST: " . getenv('DB_HOST') . "<br>";
echo "DB_NAME: " . getenv('DB_NAME') . "<br>";
echo "DB_USER: " . getenv('DB_USER') . "<br>";

// Test 2: Chargement de la config
echo "<h2>Chargement config:</h2>";
try {
    if (getenv('RENDER')) {
        require_once 'config.production.php';
        echo "Config production chargée<br>";
    } else {
        require_once 'config.php';
        echo "Config locale chargée<br>";
    }
    
    echo "DB_HOST: " . DB_HOST . "<br>";
    echo "DB_NAME: " . DB_NAME . "<br>";
    echo "DB_USER: " . DB_USER . "<br>";
    
} catch (Exception $e) {
    echo "ERREUR: " . $e->getMessage();
}

// Test 3: Connexion base de données
echo "<h2>Test connexion MySQL:</h2>";
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );
    echo "✅ Connexion réussie!";
} catch (PDOException $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>
