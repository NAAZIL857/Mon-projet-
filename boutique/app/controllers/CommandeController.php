<?php
/**
 * Contrôleur Commande - Gestion du panier et des commandes
 */

require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../models/Produit.php';
require_once __DIR__ . '/../core/Router.php';

class CommandeController {
    private $commandeModel;
    private $produitModel;
    
    public function __construct() {
        $this->commandeModel = new Commande();
        $this->produitModel = new Produit();
    }
    
    public function panier() {
        $panier = Session::get('panier', []);
        $total = 0;
        
        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        
        include __DIR__ . '/../views/commandes/panier.php';
    }
    
    public function ajouterPanier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produit_id = intval($_POST['produit_id']);
            $quantite = intval($_POST['quantite'] ?? 1);
            
            $produit = $this->produitModel->findById($produit_id);
            
            if ($produit && $produit['stock'] >= $quantite) {
                $panier = Session::get('panier', []);
                
                if (isset($panier[$produit_id])) {
                    $panier[$produit_id]['quantite'] += $quantite;
                } else {
                    $panier[$produit_id] = [
                        'id' => $produit['id'],
                        'nom' => $produit['nom'],
                        'prix' => $produit['prix'],
                        'quantite' => $quantite,
                        'image' => $produit['image']
                    ];
                }
                
                Session::set('panier', $panier);
                
                if (isset($_POST['ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier']);
                    exit;
                }
            }
        }
        
        Router::redirect('index.php?controller=commande&action=panier');
    }
    
    public function ajaxAjouterAuPanier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produit_id = intval($_POST['produit_id'] ?? 0);
            $quantite = 1; // Ajoute un produit à la fois depuis la liste

            $produit = $this->produitModel->findById($produit_id);

            if ($produit && $produit['stock'] >= $quantite) {
                $panier = Session::get('panier', []);

                if (isset($panier[$produit_id])) {
                    $panier[$produit_id]['quantite'] += $quantite;
                } else {
                    $panier[$produit_id] = [
                        'id' => $produit['id'],
                        'nom' => $produit['nom'],
                        'prix' => $produit['prix'],
                        'quantite' => $quantite,
                        'image' => $produit['image']
                    ];
                }

                Session::set('panier', $panier);

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Produit ajouté au panier !',
                    'panierCount' => count(Session::get('panier', []))
                ]);
                exit;
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Impossible d\'ajouter le produit.']);
        exit;
    }

    public function retirerPanier() {
        $produit_id = $_GET['id'] ?? 0;
        $panier = Session::get('panier', []);
        
        if (isset($panier[$produit_id])) {
            unset($panier[$produit_id]);
            Session::set('panier', $panier);
        }
        
        Router::redirect('index.php?controller=commande&action=panier');
    }
    
    public function viderPanier() {
        Session::remove('panier');
        Router::redirect('index.php?controller=commande&action=panier');
    }
    
    public function commander() {
        if (!Session::isLoggedIn()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $panier = Session::get('panier', []);
        
        if (empty($panier)) {
            Router::redirect('index.php?controller=commande&action=panier');
        }
        
        try {
            $commande_id = $this->commandeModel->createFromPanier(Session::getUserId(), $panier);
            Session::remove('panier');
            
            Router::redirect('index.php?controller=commande&action=confirmation&id=' . $commande_id);
        } catch (Exception $e) {
            $error = "Erreur lors de la commande : " . $e->getMessage();
            include __DIR__ . '/../views/commandes/panier.php';
        }
    }
    
    public function confirmation() {
        if (!Session::isLoggedIn()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        $commande = $this->commandeModel->findById($id);
        
        if (!$commande || $commande['user_id'] != Session::getUserId()) {
            Router::redirect('index.php?controller=produit&action=liste');
        }
        
        $details = $this->commandeModel->getDetails($id);
        include __DIR__ . '/../views/commandes/confirmation.php';
    }
    
    public function historique() {
        if (!Session::isLoggedIn()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $commandes = $this->commandeModel->getByUser(Session::getUserId());
        include __DIR__ . '/../views/commandes/historique.php';
    }
    
    public function admin() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $commandes = $this->commandeModel->getAll();
        include __DIR__ . '/../views/commandes/admin.php';
    }
    
    public function detail() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        $commande = $this->commandeModel->findById($id);
        $details = $this->commandeModel->getDetails($id);
        
        include __DIR__ . '/../views/commandes/detail.php';
    }
    
    public function updateStatut() {
        if (!Session::isAdmin()) {
            Router::redirect('index.php?controller=user&action=login');
        }
        
        $id = $_GET['id'] ?? 0;
        $statut = $_GET['statut'] ?? '';
        
        $allowed_statuts = ['en_attente', 'confirmee', 'expediee', 'livree'];
        
        if (in_array($statut, $allowed_statuts)) {
            $this->commandeModel->updateStatut($id, $statut);
        }
        
        Router::redirect('index.php?controller=commande&action=admin');
    }
    
    public function getPanierCount() {
        header('Content-Type: application/json');
        $panier = Session::get('panier', []);
        echo json_encode(['count' => count($panier)]);
        exit;
    }
    
    public function updateQuantity() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produit_id = intval($_POST['produit_id'] ?? 0);
            $quantite = intval($_POST['quantite'] ?? 0);
            
            if ($quantite < 1) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Quantité invalide']);
                exit;
            }
            
            $produit = $this->produitModel->findById($produit_id);
            
            if (!$produit) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Produit introuvable']);
                exit;
            }
            
            if ($quantite > $produit['stock']) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Stock insuffisant']);
                exit;
            }
            
            $panier = Session::get('panier', []);
            
            if (isset($panier[$produit_id])) {
                $panier[$produit_id]['quantite'] = $quantite;
                Session::set('panier', $panier);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        exit;
    }
}
?>