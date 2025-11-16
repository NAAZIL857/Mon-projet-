<?php
/**
 * Modèle User - Gestion des utilisateurs (clients et administrateurs)
 */

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($nom, $email, $password, $role = 'client') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [$nom, $email, $hashedPassword, $role]);
        
        return $this->db->lastInsertId();
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function emailExists($email) {
        return $this->findByEmail($email) !== false;
    }
    
    public function getAll() {
        $sql = "SELECT id, nom, email, role, created_at FROM users ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }
    
    public function update($id, $nom, $email, $role) {
        $sql = "UPDATE users SET nom = ?, email = ?, role = ? WHERE id = ?";
        return $this->db->query($sql, [$nom, $email, $role, $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
}
?>