-- FitZone Database Script
CREATE DATABASE IF NOT EXISTS fitzone;
USE fitzone;

-- Table machines
CREATE TABLE IF NOT EXISTS machines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    categorie VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Table utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table messages (contact)
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(150),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table commandes (panier / achats)
CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_nom VARCHAR(100) NOT NULL,
    client_email VARCHAR(150) NOT NULL,
    client_phone VARCHAR(30) NOT NULL,
    machine_id INT NOT NULL,
    machine_nom VARCHAR(100) NOT NULL,
    machine_prix DECIMAL(10,2) NOT NULL,
    statut ENUM('panier','acheté') DEFAULT 'panier',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (machine_id) REFERENCES machines(id)
);

-- Sample data
INSERT INTO machines (nom, categorie, prix, image) VALUES
('Tapis de course Pro', 'Cardio', 1200.00, 'image2.png'),
('Vélo elliptique X1', 'Cardio', 850.00, 'image3.png'),
('Banc de musculation', 'Musculation', 450.00, 'image4.png'),
('Rack à haltères', 'Musculation', 320.00, 'image2.png'),
('Rameur sportif', 'Cardio', 700.00, 'image3.png'),
('Cage de squat', 'Musculation', 1100.00, 'image4.png');
