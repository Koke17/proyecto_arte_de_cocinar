<?php

class PedidosProduct extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('products_has_pedidos');
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
    // $pedido, $productoDB->product_id, $quantity, $price
    public function create($pedido, $product_id, $quantity, $price){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (pedidos_id, product_id, cantidad, precio) VALUES ('$pedido', '$product_id', '$quantity', '$price')");
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

    public function getByPedido($pedido){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE pedidos_id = $pedido");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function getByProduct($product){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE product_id = $product");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objeto
    }

}
