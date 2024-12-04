<?php

class Anounces extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('anuncios_art_co_v1');
        $this->table = $this->getTableName();
    }

    public function getAll() {
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table);
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    public function find($id){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE user_id = $id");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function delete($id){
        $db = Database::getConnection();
        $query = $db->query("DELETE FROM ".$this->table." WHERE user_id = $id");
        return $query;
    }

    public function update( $id, $name, $lastname, $email ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET name_user = '$name', lastname_user = '$lastname', email_user = '$email' WHERE user_id = $id");
        return $query;
    }

    public function create($anuncio, $vigencia, $user_id){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (descripcion_anuncio, vigencia, user_id) VALUES ('$anuncio', '$vigencia', $user_id)");
        return $query;
    }

}
