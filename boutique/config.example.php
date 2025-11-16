<?php
/**
 * Fichier de configuration d'exemple
 * Copiez ce fichier vers config.php et modifiez les valeurs selon votre environnement
 */

// Configuration de la base de données
define('DB_HOST', 'localhost');           // Adresse du serveur MySQL
define('DB_NAME', 'boutique_db');         // Nom de la base de données
define('DB_USER', 'root');                // Nom d'utilisateur MySQL
define('DB_PASS', '');                    // Mot de passe MySQL

// Configuration de l'application
define('BASE_URL', 'http://localhost/boutique/');  // URL de base de l'application
define('UPLOAD_PATH', __DIR__ . '/public/images/'); // Chemin d'upload des images
define('UPLOAD_URL', BASE_URL . 'public/images/');  // URL des images uploadées

// Configuration de l'environnement
define('ENVIRONMENT', 'development');     // 'development' ou 'production'

// Sécurité
define('CSRF_TOKEN_NAME', 'csrf_token');  // Nom du token CSRF
define('SESSION_NAME', 'boutique_session'); // Nom de la session

// Configuration email (optionnel - pour les notifications)
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('FROM_EMAIL', 'noreply@boutique.com');
define('FROM_NAME', 'Ma Boutique');

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Génération du token CSRF
if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
    $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
}

// Configuration des erreurs selon l'environnement
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}
?>