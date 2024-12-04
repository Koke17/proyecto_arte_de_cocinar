<?php

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para definir la tabla
    public function setTable($table) {
        $this->table = $table;
    }

    public function getTableName() {
        return $this->table;
    }

}
