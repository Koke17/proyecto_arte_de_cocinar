<?php

class Venta extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('ventas_art_co_v1');
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
    // pedido_id, empresa_id, estado_venta, created_at
    public function create( $pedido_id, $empresa_id, $estado_venta, $created_at ){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (pedido_id, empresa_id, estado_venta, created_at) VALUES ('$pedido_id', '$empresa_id', '$estado_venta', '$created_at')");
        $query = $db->lastInsertId();
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

    public function updateStatePedido( $pedido, $estado, $stripe_id ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET estado_pedido = '$estado', stripe_id = '$stripe_id' WHERE pedido_id = $pedido");
        return $query;
    }

    public function updateStripeId( $pedido, $stripe_id ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET stripe_id = '$stripe_id' WHERE pedido_id = $pedido");
        return $query;
    }

}
