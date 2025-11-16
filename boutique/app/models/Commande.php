<?php
/**
 * Modèle Commande - Gestion des commandes et du panier
 */

class Commande {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($user_id, $total) {
        $sql = "INSERT INTO commandes (user_id, total) VALUES (?, ?)";
        $this->db->query($sql, [$user_id, $total]);
        return $this->db->lastInsertId();
    }
    
    public function addProduit($commande_id, $produit_id, $quantite, $prix_unitaire) {
        $sql = "INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)";
        return $this->db->query($sql, [$commande_id, $produit_id, $quantite, $prix_unitaire]);
    }
    
    public function getByUser($user_id) {
        $sql = "SELECT * FROM commandes WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($sql, [$user_id]);
    }
    
    public function getAll() {
        $sql = "SELECT c.*, u.nom as user_name, u.email as user_email 
                FROM commandes c 
                JOIN users u ON c.user_id = u.id 
                ORDER BY c.created_at DESC";
        return $this->db->fetchAll($sql);
    }
    
    public function findById($id) {
        $sql = "SELECT c.*, u.nom as user_name, u.email as user_email 
                FROM commandes c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    public function getDetails($commande_id) {
        $sql = "SELECT cp.*, p.nom as produit_name, p.image 
                FROM commande_produit cp 
                JOIN produits p ON cp.produit_id = p.id 
                WHERE cp.commande_id = ?";
        return $this->db->fetchAll($sql, [$commande_id]);
    }
    
    public function updateStatut($id, $statut) {
        $sql = "UPDATE commandes SET statut = ? WHERE id = ?";
        return $this->db->query($sql, [$statut, $id]);
    }
    
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total_commandes,
                    COALESCE(SUM(total), 0) as total_ventes
                FROM commandes";
        return $this->db->fetch($sql);
    }
    
    public function createFromPanier($user_id, $panier) {
        try {
            $this->db->getConnection()->beginTransaction();
            
            $total = 0;
            foreach ($panier as $item) {
                $total += $item['prix'] * $item['quantite'];
            }
            
            $commande_id = $this->create($user_id, $total);
            
            foreach ($panier as $item) {
                $this->addProduit($commande_id, $item['id'], $item['quantite'], $item['prix']);
                
                // Mise à jour du stock
                $produitModel = new Produit();
                $produitModel->updateStock($item['id'], $item['quantite']);
            }
            
            $this->db->getConnection()->commit();
            return $commande_id;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw $e;
        }
    }
}
?>