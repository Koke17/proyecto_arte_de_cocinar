<?php

class Categoria extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('categoria_art_co_v1');
        $this->table = $this->getTableName();
    }

    public function getAll() {
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table);
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    public function find($id){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE categoria_id = $id");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function delete($id){
        $db = Database::getConnection();
        $query = $db->query("DELETE FROM ".$this->table." WHERE categoria_id = $id");
        return $query;
    }

    public function update( $id, $name, $lastname, $email ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET name_user = '$name', lastname_user = '$lastname', email_user = '$email' WHERE categoria_id = $id");
        return $query;
    }

    public function create($name_category){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (name_category) VALUES ('$name_category')");
        return $query;
    }

}
