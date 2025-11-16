<?php
/**
 * Contrôleur Produit - Gestion des produits et catalogue
 */

require_once __DIR__ . '/../models/Produit.php';
require_once __DIR__ . '/../core/Router.php';

class ProduitController {
    private $produitModel;
    
    public function __construct() {
        $this->produitModel = new Produit();
    }
    
    public function liste() {
        $category_id = $_GET['category'] ?? null;
        
        if ($category_id) {
            $produits = $this->produitModel->getByCategory($category_id);
        } else {
            $produits = $this->produitModel->getAll();
        }
        
        $categories = $this->produitModel->getCategories();
        
        // Différencier les vues selon le rôle
        if (Session::isAdmin()) {
            include __DIR__ . '/../views/produits/liste_admin.php';
        } elseif (Session::isLoggedIn()) {
            include __DIR__ . '/../views/produits/liste_client.php';
        } else {
            include __DIR__ . '/../views/produits/liste_public.php';
        }
    }
    
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $produit = $this->produitModel->findById($id);
        
        if (!$produit) {
            Router::redirect('index.php?controller=produit&action=liste');
        }
        
        include __DIR__ . '/../views/produits/detail.php';
    }
    
    public function admin() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $produits = $this->produitModel->getAll();
        include __DIR__ . '/../views/produits/admin.php';
    }
    
    public function ajouter() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::validateCSRF($_POST['csrf_token'] ?? '')) {
                $error = "Token CSRF invalide";
            } else {
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);
                $prix = floatval($_POST['prix']);
                $stock = intval($_POST['stock']);
                $category_id = intval($_POST['category_id']);
                
                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $image = $this->uploadImage($_FILES['image']);
                }
                
                $this->produitModel->create($nom, $description, $prix, $stock, $image, $category_id);
                Router::redirect('index.php?controller=produit&action=admin');
            }
        }
        
        $categories = $this->produitModel->getCategories();
        include __DIR__ . '/../views/produits/ajouter.php';
    }
    
    public function modifier() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        $produit = $this->produitModel->findById($id);
        
        if (!$produit) {
            Router::redirect('index.php?controller=produit&action=admin');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::validateCSRF($_POST['csrf_token'] ?? '')) {
                $error = "Token CSRF invalide";
            } else {
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);
                $prix = floatval($_POST['prix']);
                $stock = intval($_POST['stock']);
                $category_id = intval($_POST['category_id']);
                
                $image = $produit['image'];
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $image = $this->uploadImage($_FILES['image']);
                }
                
                $this->produitModel->update($id, $nom, $description, $prix, $stock, $image, $category_id);
                Router::redirect('index.php?controller=produit&action=admin');
            }
        }
        
        $categories = $this->produitModel->getCategories();
        include __DIR__ . '/../views/produits/modifier.php';
    }
    
    public function supprimer() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        $this->produitModel->delete($id);
        Router::redirect('index.php?controller=produit&action=admin');
    }
    
    private function uploadImage($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Type de fichier non autorisé");
        }
        
        if ($file['size'] > $maxSize) {
            throw new Exception("Fichier trop volumineux");
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $destination = UPLOAD_PATH . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }
        
        throw new Exception("Erreur lors de l'upload");
    }
}
?>