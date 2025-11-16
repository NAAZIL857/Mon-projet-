-- Script de création de la base de données pour la boutique e-commerce
-- Architecture MVC avec gestion des utilisateurs, produits et commandes

-- Table des catégories de produits
-- Création de la base
CREATE DATABASE IF NOT EXISTS boutique_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE boutique_db;

-- Table des catégories
CREATE TABLE categories (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des utilisateurs (clients et administrateurs)
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('client','admin') NOT NULL DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des produits
CREATE TABLE produits (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    category_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produits_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des commandes
CREATE TABLE commandes (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    statut ENUM('en_attente','confirmee','expediee','livree','annulee') NOT NULL DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commandes_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table de liaison commande-produit (panier)
CREATE TABLE commande_produit (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_cp_commande FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_cp_produit FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de test
INSERT INTO categories (nom, description) VALUES
('Boissons', 'Boissons chaudes et froides'),
('Vêtements', 'Vêtements pour homme et femme'),
('Accessoires', 'Accessoires de mode et technologie');

-- Exemples de comptes : le mot de passe est un hash bcrypt d'exemple
INSERT INTO users (nom, email, password, role) VALUES
('Admin', 'admin@boutique.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Client Test', 'client@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client');

INSERT INTO produits (nom, description, prix, stock, category_id) VALUES
('Café Premium', 'Café arabica de haute qualité', 15.99, 50, 1),
('T-shirt Coton', 'T-shirt 100% coton bio', 29.99, 25, 2),
('Montre Connectée', 'Montre intelligente avec GPS', 199.99, 10, 3);
