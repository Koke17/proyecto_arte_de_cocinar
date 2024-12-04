<?php

require_once '../core/Controller.php';

class ProductsController extends Controller {

    private $productModel;
    private $categoriaModel;

    public function __construct(){
        verifyAdmin();
        $this->productModel = $this->model('Product');
        $this->categoriaModel = $this->model('Categoria');
    }

    public function index(){

        $productos = $this->productModel->getWithCategory();

        $this->view('layouts/main', [
            'content' => '/products/index',
            'productos' => $productos
        ]);

    }

    public function show($id){
        $producto = $this->productModel->find($id);

        $this->view('layouts/main', [
            'content' => '/products/show',
            'producto' => $producto
        ]);
    }

    public function create(){

        $categorias = $this->categoriaModel->getAll();

        $this->view('layouts/main', [
            'content' => '/products/create',
            'categorias' => $categorias
        ]);

    }

    public function store(){

        $name_product           = $_POST['name_product'];
        $descripcion_product    = $_POST['description'];
        $price                  = $_POST['price'];
        $category_id            = $_POST['name_category'];
        $stock                  = $_POST['stock'];

        $archivo = $_FILES['imagen'];
        $path   = '../public/assets/img/';
        $folder = 'products';

        $subir = uploadImagesServer( $archivo, $path, $folder );

        if ( !$subir["status"] ) {
            redirect('/Products/create?error='.$subir["message"]);
        }

        $ruta = $subir["url"];


        $this->productModel->create(
            $name_product, 
            $descripcion_product, 
            $price, 
            $category_id,
            $ruta,
            $stock
        );

        redirect('/Products');

    }

    public function delete($id){
        $this->productModel->delete($id);

        redirect('/Products');
    }

    public function edit( $id ){
        $producto   = $this->productModel->find($id);
        $categorias = $this->categoriaModel->getAll();

        $this->view('layouts/main', [
            'content' => '/products/edit',
            'producto' => $producto,
            'categorias' => $categorias
        ]);
    }

    public function update( $id ){
        try {

            $producto = $this->productModel->find($id);

            $name_product   = $_POST['name_product'];
            $price          = $_POST['price'];
            $stock          = $_POST['stock'];
            $category_id    = $_POST['name_category'];
            $description    = $_POST['description'];

            $imagen = $_FILES["imagen"];
            $path   = '../public/assets/img/';
            $folder = 'products';
            $subir  = uploadImagesServer( $imagen, $path, $folder );
            $ruta   = $producto->product_image;

            if ( $subir["status"] ) {
                $ruta = $subir["url"];
            }
            
            $this->productModel->update(
                $name_product,
                $description,
                $price,
                $category_id,
                $ruta,
                $stock,
                $id
            );

            redirect('/Products?success=Producto actualizado');
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            redirect("/Products?error=$error"); 
        }
    }


}