<?php

class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        $config = require_once __DIR__ . '/../config/database.php';

        try {
            $this->pdo = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['db'] . ';charset=' . $config['charset'],
                $config['user'],
                $config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public static function getConnection() {
        return self::$instance->pdo;
    }
}
