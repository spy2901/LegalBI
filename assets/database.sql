DROP DATABASE IF EXISTS legalBI;

CREATE DATABASE IF NOT EXISTS legalBI;

USE legalBI;

CREATE TABLE IF NOT EXISTS korisnici (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    uloga ENUM('admin','analiticar','operativni') NOT NULL,
    datum_kreiranja TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `korisnici` (`id`, `username`, `password_hash`, `uloga`, `datum_kreiranja`) VALUES (NULL, 'admin', '$2y$10$KpOPJae3eqxCN5cTs7n4xeYgYuH.ltnJXYMyiEBn.Bcxc1urvtiHG', 'admin', '2026-01-28 21:09:41')