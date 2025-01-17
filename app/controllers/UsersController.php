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

        try {
             
            $this->userDetailsModel->delete($id);
            $this->userModel->delete($id);

            redirect('Users');

        } catch (\Throwable $th) {
            redirect('Users?error=Error al eliminar el usuario&message=' . $th->getMessage());
        }
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

        try{
            
            $name       = $_POST['name_user'];
            $lastname   = $_POST['lastname_user'];
            $email      = $_POST['email_user'];
            $rol        = $_POST["role_id"];

            $this->userModel->update($id, $name, $lastname, $email, $rol);

            redirect('Users');

        }catch(\Throwable $th){
            redirect('Users/update/' . $id . '?error=Error al actualizar el usuario&message=' . $th->getMessage());
        }
    }

    public function create(){

        $roles = $this->userModel->getRoles();

        $this->view('layouts/main', [
            'content' => '/users/create',
            'roles' => $roles
        ]);
    }

    public function storeNewUser(){

        

        try {
            $name       = $_POST['name_user'];
            $lastname   = $_POST['lastname_user'];
            $email      = $_POST['email_user'];
            $contraseña   = $_POST['password_user'];
            $rol        = $_POST["role_id"];

            $password = password_hash($contraseña, PASSWORD_DEFAULT);

            $userCreated=$this->userModel->create($name, $lastname, $email, $password, $rol);

            if ( $userCreated ) {
                redirect('/?success=Usuario registrado correctamente');
            }else{
                redirect('Users/create?error=Error al crear el usuario');
            }

        } catch (\Throwable $th) {
            redirect('Users/create?error=Error al crear el usuario&message=' . $th->getMessage());
        }


    }
}
