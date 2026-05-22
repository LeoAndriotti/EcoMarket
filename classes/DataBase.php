<?php
class DataBase {
    public static function getConnection() {
        $host = 'localhost';
        $db   = 'ecomarket';
        $user = 'root'; // ajuste conforme necessário
        $pass = '';     // ajuste conforme necessário
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Erro na conexão com o banco: " . $e->getMessage());
        }
    }
}
