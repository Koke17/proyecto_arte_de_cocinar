<?php

class UserDetail extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('users_details_art_co_v1');
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

    public function update( $id, $direccion, $telefono, $imagen, $politics, $ofertas ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET direccion = '$direccion', telefono = '$telefono', imagen = '$imagen', politics = '$politics', ofertas = '$ofertas' WHERE user_id = $id");
        return $query;
    }

    public function create($user_id, $direccion, $telefono, $imagen, $politics, $ofertas){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (user_id, direccion, telefono, imagen, politics, ofertas) VALUES ('$user_id', '$direccion', '$telefono', '$imagen', '$politics', '$ofertas')");
        return $query;
    }

}
?>