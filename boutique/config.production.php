<?php
/**
 * Configuration de production pour Render
 * Utilise les variables d'environnement
 */

// Configuration de la base de données depuis les variables d'environnement
define('DB_HOST', getenv('DB_HOST') ?: 'mysql-nanziibrahim.alwaysdata.net');
define('DB_NAME', getenv('DB_NAME') ?: 'nanziibrahim_gabonshop');
define('DB_USER', getenv('DB_USER') ?: '441098');
define('DB_PASS', getenv('DB_PASS') ?: 'Nanzibac2k23');

// Configuration de l'application
define('BASE_URL', getenv('RENDER_EXTERNAL_URL') ? getenv('RENDER_EXTERNAL_URL') . '/' : '/');
define('UPLOAD_PATH', __DIR__ . '/public/images/');
define('UPLOAD_URL', ''); // Les images Cloudinary sont des URLs complètes
define('CURRENCY', 'FCFA');

// Sécurité
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_NAME', 'boutique_session');

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Génération du token CSRF
if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
    $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
}
?>
