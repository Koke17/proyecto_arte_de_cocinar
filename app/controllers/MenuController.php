<?php

require_once '../core/Controller.php';

class MenuController extends Controller{

    private $productsModel;

    public function __construct(){
        $this->productsModel = $this->model('Product');
    }

    public function index(){
        $products = $this->productsModel->getAll();

        $this->view('layouts/main', [
            'content' => '/menu/index',
            'products' => $products
        ]);
    }

}