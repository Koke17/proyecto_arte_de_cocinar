<?php

require_once '../core/Controller.php';

class UsersController extends Controller {

    private $userModel;
    private $userDetailsModel;

    public function __construct(){

        verifyAdmin();

        $this->userModel = $this->model('User');
        $this->userDetailsModel = $this->model('UserDetail');
    }

    public function index() {

        $users = $this->userModel->getAll(); // Obtiene todos los usuarios de la base de datos
        // dd($users); // dd es un helper que he creado para debuggear variables y ver su contenido en la pantalla
        // Enviar los usuarios a la vista
        $this->view('layouts/main', [
            'content' => '/users/index', 
            'users' => $users
        ]);
    }

    // ['content' => '/users/index', 'users' => $users] // esto es la $data

    public function show($id) {

        $userModel = $this->model('User'); // Carga el modelo
        $user = $userModel->find($id);

        if ( !isset($_SESSION["user"]) ){
            redirect('/auth?error=Debes iniciar sesión');
        }

        $userDetails = $this->userDetailsModel->find( $id );

        // Enviar el usuario a la vista
        $this->view('layouts/main', [
            'content' => '/users/show', 
            'user' => $user,
            'detalles' => $userDetails  
        ]);
    }

    public function delete($id){

        $this->userDetailsModel->delete($id);
        $this->userModel->delete($id);

        redirect('Users');
    }

    public function update($id){

        $user = $this->userModel->find($id);
        $roles = $this->userModel->getRoles();

        $this->view('layouts/main', [
            'content' => '/users/update', 
            'user' => $user,
            'roles' => $roles
        ]);

    }

    public function store($id){

        $name       = $_POST['name_user'];
        $lastname   = $_POST['lastname_user'];
        $email      = $_POST['email_user'];
        $rol        = $_POST["role_id"];

        $this->userModel->update($id, $name, $lastname, $email, $rol);

        redirect('Users');
    }

    public function create(){

        $roles = $this->userModel->getRoles();

        $this->view('layouts/main', [
            'content' => '/users/create',
            'roles' => $roles
        ]);
    }

    public function storeNewUser(){

        $name       = $_POST['name_user'];
        $lastname   = $_POST['lastname_user'];
        $email      = $_POST['email_user'];
        $password   = $_POST['password_user'];
        $rol        = $_POST["role_id"];

        $this->userModel->create($name, $lastname, $email, $password, $rol);

        redirect('Users');
    }
}
