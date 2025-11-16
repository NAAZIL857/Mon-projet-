<?php
/**
 * Modèle Produit - Gestion des produits et catégories
 */

class Produit {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($nom, $description, $prix, $stock, $image, $category_id) {
        $sql = "INSERT INTO produits (nom, description, prix, stock, image, category_id) VALUES (?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, [$nom, $description, $prix, $stock, $image, $category_id]);
        return $this->db->lastInsertId();
    }
    
    public function getAll() {
        $sql = "SELECT p.*, c.nom as category_name 
                FROM produits p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql);
    }
    
    public function findById($id) {
        $sql = "SELECT p.*, c.nom as category_name 
                FROM produits p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    public function update($id, $nom, $description, $prix, $stock, $image, $category_id) {
        $sql = "UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ?, image = ?, category_id = ? WHERE id = ?";
        return $this->db->query($sql, [$nom, $description, $prix, $stock, $image, $category_id, $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM produits WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
    
    public function getByCategory($category_id) {
        $sql = "SELECT p.*, c.nom as category_name 
                FROM produits p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ?";
        return $this->db->fetchAll($sql, [$category_id]);
    }
    
    public function updateStock($id, $quantity) {
        $sql = "UPDATE produits SET stock = stock - ? WHERE id = ? AND stock >= ?";
        return $this->db->query($sql, [$quantity, $id, $quantity]);
    }
    
    public function getCategories() {
        $sql = "SELECT * FROM categories ORDER BY nom";
        return $this->db->fetchAll($sql);
    }
    
    public function createCategory($nom, $description) {
        $sql = "INSERT INTO categories (nom, description) VALUES (?, ?)";
        $this->db->query($sql, [$nom, $description]);
        return $this->db->lastInsertId();
    }
    
    public function getStats() {
        $sql = "SELECT COUNT(*) as total_produits FROM produits";
        return $this->db->fetch($sql);
    }
}
?>