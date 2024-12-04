<?php

class Role extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('roles_art_co_v1');
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

    public function create($name, $lastname, $email, $password, $rol){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (role_id, name_user, lastname_user, email_user, password_user) VALUES ('$rol', '$name', '$lastname', '$email', '$password')");
        return $query;
    }

}
