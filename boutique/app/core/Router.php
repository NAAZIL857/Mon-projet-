<?php
/**
 * Classe Router - Gestion des routes et dispatch des contrôleurs
 */

class Router {
    
    public static function dispatch() {
        $controller = $_GET['controller'] ?? 'produit';
        $action = $_GET['action'] ?? 'liste';
        
        // Sécurisation des noms de contrôleurs et actions
        $controller = ucfirst(strtolower($controller));
        $action = strtolower($action);
        
        $controllerClass = $controller . 'Controller';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                if (method_exists($controllerInstance, $action)) {
                    $controllerInstance->$action();
                } else {
                    self::error404();
                }
            } else {
                self::error404();
            }
        } else {
            self::error404();
        }
    }
    
    public static function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
    
    private static function error404() {
        http_response_code(404);
        echo "<h1>Page non trouvée</h1>";
        exit;
    }
}
?>