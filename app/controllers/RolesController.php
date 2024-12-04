<?php

require_once '../core/Controller.php';

class RolesController extends Controller {

    private $roleModel;

    public function __construct(){
        verifyAdmin();
        $this->roleModel = $this->model('Role');
    }

    public function index(){

        $roles = $this->roleModel->getAll();

        $this->view('layouts/main', [
            'content' => '/roles/index',
            'roles' => $roles
        ]);
    }

}