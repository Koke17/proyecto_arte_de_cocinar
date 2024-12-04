<?php

class User extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('users_art_co_v1');
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

    public function update( $id, $name, $lastname, $email, $rol ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET name_user = '$name', lastname_user = '$lastname', email_user = '$email', role_id = '$rol' WHERE user_id = $id");
        return $query;
    }

    public function create($name, $lastname, $email, $password, $rol){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (role_id, name_user, lastname_user, email_user, password_user) VALUES ('$rol', '$name', '$lastname', '$email', '$password')");
        return $query;
    }

    public function getByEmail($email){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE email_user = '$email'");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function getRoles(){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM roles_art_co_v1");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function saveResetToken($email, $token){
        $db = Database::getConnection();
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
        // $query = $db->query("UPDATE ".$this->table." SET reset_token = $token, reset_expire = $expire WHERE email_user = $email");
        $query = $db->query("UPDATE ".$this->table." SET reset_token = '$token', token_expiry = '$expire' WHERE email_user = '$email'");
        return $query;
    }

    public function getByToken($token){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE reset_token = '$token'");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function updatePassword($id, $password){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET password_user = '$password' WHERE user_id = $id");
        return $query;
    }

}
