<?php
/**
 * Point d'entrée principal de l'application
 * Initialise l'environnement et route les requêtes
 */

// Chargement de la configuration
require_once 'config.php';

// Chargement des classes core
require_once 'app/core/Database.php';
require_once 'app/core/Session.php';
require_once 'app/core/Router.php';

// Démarrage de la session
Session::start();

// Gestion des erreurs en mode développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sécurité : Protection contre les attaques XSS
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

try {
    // Dispatch de la requête vers le bon contrôleur
    Router::dispatch();
    
} catch (Exception $e) {
    // Gestion des erreurs
    error_log("Erreur application: " . $e->getMessage());
    
    // En production, afficher une page d'erreur générique
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
        http_response_code(500);
        echo "<h1>Erreur interne du serveur</h1>";
        echo "<p>Une erreur s'est produite. Veuillez réessayer plus tard.</p>";
    } else {
        // En développement, afficher l'erreur complète
        echo "<h1>Erreur de développement</h1>";
        echo "<pre>" . $e->getMessage() . "</pre>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}
?>