<?php
/**
 * Contrôleur User - Gestion de l'authentification et des utilisateurs
 */

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Produit.php';
require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../core/Router.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::validateCSRF($_POST['csrf_token'] ?? '')) {
                $error = "Token CSRF invalide";
            } else {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                
                $user = $this->userModel->authenticate($email, $password);
                
                if ($user) {
                    Session::login($user);
                    Router::redirect('index.php?controller=produit&action=liste');
                } else {
                    $error = "Email ou mot de passe incorrect";
                }
            }
        }
        
        include __DIR__ . '/../views/users/login.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::validateCSRF($_POST['csrf_token'] ?? '')) {
                $error = "Token CSRF invalide";
            } else {
                $nom = htmlspecialchars($_POST['nom']);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                
                if ($password !== $confirm_password) {
                    $error = "Les mots de passe ne correspondent pas";
                } elseif ($this->userModel->emailExists($email)) {
                    $error = "Cet email est déjà utilisé";
                } else {
                    $user_id = $this->userModel->create($nom, $email, $password);
                    $user = $this->userModel->findById($user_id);
                    Session::login($user);
                    Router::redirect('index.php?controller=produit&action=liste');
                }
            }
        }
        
        include __DIR__ . '/../views/users/register.php';
    }
    
    public function logout() {
        Session::logout();
        Router::redirect('index.php?controller=user&action=login');
    }
    
    public function dashboard() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $produitModel = new Produit();
        $commandeModel = new Commande();
        
        $stats_produits = $produitModel->getStats();
        $stats_commandes = $commandeModel->getStats();
        
        include __DIR__ . '/../views/users/dashboard.php';
    }
    
    public function liste() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $users = $this->userModel->getAll();
        include __DIR__ . '/../views/users/liste.php';
    }
    
    public function supprimer() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        
        // Empêcher la suppression de son propre compte
        if ($id != Session::getUserId()) {
            $this->userModel->delete($id);
        }
        
        Router::redirect('index.php?controller=user&action=liste');
    }
    
    public function toggleRole() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        $role = $_GET['role'] ?? '';
        
        $allowed_roles = ['client', 'admin'];
        
        if (in_array($role, $allowed_roles) && $id != Session::getUserId()) {
            $user = $this->userModel->findById($id);
            if ($user) {
                $this->userModel->update($id, $user['nom'], $user['email'], $role);
            }
        }
        
        Router::redirect('index.php?controller=user&action=liste');
    }
}
?>