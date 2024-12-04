<?php

class Product extends Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
        // Asignar nombre de la tabla correspondiente
        $this->setTable('productos_art_co_v1');
        $this->table = $this->getTableName();
    }

    public function getAll() {
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table);
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    public function getWithCategory() {
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table . " INNER JOIN categoria_art_co_v1 ON productos_art_co_v1.categoria_id = categoria_art_co_v1.categoria_id");
        return $query->fetchAll(PDO::FETCH_OBJ); // Devolver como objetos
    }

    public function find($id){
        $db = Database::getConnection();
        $query = $db->query("SELECT * FROM ".$this->table." WHERE product_id = $id");
        return $query->fetch(PDO::FETCH_OBJ); // Devolver como objeto
    }

    public function delete($id){
        $db = Database::getConnection();
        $query = $db->query("DELETE FROM ".$this->table." WHERE product_id = $id");
        return $query;
    }

    public function update( $name_product, $description, $price, $category_id, $img, $stock, $id ){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET name_product = '$name_product', descripcion_product = '$description', precio_product = '$price', categoria_id = '$category_id', product_image = '$img', stock = '$stock' WHERE product_id = $id");
        return $query;
    }

    public function updateStock($id, $stock){
        $db = Database::getConnection();
        $query = $db->query("UPDATE ".$this->table." SET stock = '$stock' WHERE product_id = $id");
        return $query;
    }

    public function create($name_product, $description, $price, $category_id, $img, $stock){
        $db = Database::getConnection();
        $query = $db->query("INSERT INTO ".$this->table." (name_product, descripcion_product, precio_product, categoria_id, product_image, stock) VALUES ('$name_product', '$description', '$price', '$category_id', '$img', '$stock')");
        return $query;
    }


}
