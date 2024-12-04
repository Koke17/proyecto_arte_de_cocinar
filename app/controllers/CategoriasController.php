<?php

require_once '../core/Controller.php';

class CategoriasController extends Controller {

    private $categoriaModel;

    public function __construct(){
        verifyAdmin();
        $this->categoriaModel = $this->model('Categoria');
    }

    public function index(){

        $categorias = $this->categoriaModel->getAll();

        $this->view('layouts/main', [
            'content' => '/categorias/index',            
            'categorias' => $categorias
        ]);

    }

    public function create(){

        $this->view('layouts/main', [
            'content' => '/categorias/create'
        ]);

    }

    public function store(){

        $name_category = $_POST['name_category'];

        $this->categoriaModel->create($name_category);

        redirect('/Categorias');

    }

    public function edit($id){
            
        $categoria = $this->categoriaModel->find($id);

        $this->view('layouts/main', [
            'content' => '/categorias/edit',
            'categoria' => $categoria
        ]);
    }


}