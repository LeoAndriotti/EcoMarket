-- EcoMarket - schema inicial
CREATE DATABASE IF NOT EXISTS ecomarket
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ecomarket;

CREATE TABLE IF NOT EXISTS tbusu (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS tbCategorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS tbproduto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    descricao VARCHAR(200) NOT NULL,
    preco VARCHAR(10) NOT NULL,
    categoria INT NOT NULL,
    link_img VARCHAR(255),
    id_usuario INT NOT NULL,
    FOREIGN KEY (categoria) REFERENCES tbCategorias(id),
    FOREIGN KEY (id_usuario) REFERENCES tbusu(id)
);

INSERT INTO tbCategorias (nome) VALUES
    ('Grãos'),
    ('Oleaginosas'),
    ('Leguminosas'),
    ('Fibra e Café'),
    ('Sementes');

-- Para popular com exemplos, importe também: config/seed.sql
