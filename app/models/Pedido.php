<?php

class Pedido extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('pedidos_art_co_v1');
        $this->table = $this->getTableName();
    }

    public function getAll(){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table);
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    //Para los pedidos realizados por los usuarios cuando esten finalizados que se pasen a ventas
    public function getAllOrdes() {
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table. " WHERE estado_preparacion IN (1,2,3)");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    public function getByPrudctoPedido($pedido_id) {
        $db = Database::getConnection();
        $query = $db->query("SELECT productos_art_co_v1.*, products_has_pedidos.* FROM ".$this->table . " INNER JOIN products_has_pedidos ON pedidos_art_co_v1.pedido_id = products_has_pedidos.pedidos_id". " INNER JOIN productos_art_co_v1 ON products_has_pedidos.product_id = productos_art_co_v1.product_id WHERE pedidos_art_co_v1.pedido_id = $pedido_id");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    public function find($id){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE pedido_id = $id");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function delete($id){
        $db = Database::getConnection();
        $query = $db->query("DELETE FROM ".$this->table." WHERE pedido_id = $id");
        return $query;
    }

    public function update( $id, $name, $lastname, $email, $rol ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET name_user = '$name', lastname_user = '$lastname', email_user = '$email', role_id = '$rol' WHERE user_id = $id");
        return $query;
    }
    // $userLogged, $fecha_compra, $totalFactura, 1
    public function create($userLogged, $fecha_compra, $totalFactura, $iva_pedido, $total_iva, $estado_pedido, $stripe_id, $tipo_entrega){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (user_id, fecha_pedido, total_pedido, iva_pedido, total_iva, estado_pedido, stripe_id, tipo_entrega) VALUES ('$userLogged', '$fecha_compra', '$totalFactura', '$iva_pedido','$total_iva', '$estado_pedido', '$stripe_id', '$tipo_entrega')");
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

    public function getByStripeId($stripe_id){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE stripe_id = '$stripe_id'");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function getByUser($userLogged){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE user_id = $userLogged");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function updatePrepracion($pedido_id, $state){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET estado_preparacion = '$state' WHERE pedido_id = $pedido_id");
        return $query;
    }

    public function getProductByName($name){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM productos_art_co_v1 WHERE descripcion_product = '$name'");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

}
