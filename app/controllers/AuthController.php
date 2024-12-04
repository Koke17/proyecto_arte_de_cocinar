<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../core/Controller.php';

class AuthController extends Controller {

    private $userModel;
    private $userDetailsModel;

    public function __construct(){
        $this->userModel = $this->model('User');
        $this->userDetailsModel = $this->model('UserDetail');
    }

    public function index(){
        $this->view('layouts/main', ['content' => '/auth/login']);
    }

    public function registro(){
        $this->view('layouts/main', ['content' => '/auth/registro']);
    }
    
    public function confirmarRegistro(){

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $nombre     = $_POST['nombre'];
        $apellido   = $_POST['apellido'];
        $email      = $_POST['email'];
        $telefono   = $_POST['telefono'];
        $domicilio  = $_POST['domicilio'];
        $password   = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];
        $rol        = 2;

        $active     = $_POST['activarOfertas'];
        $politics   = $_POST['aceptarPolitica'];

        if ( $password != $password_confirmation ) {
            redirect('/auth/registro?error=Las contraseñas no coinciden');
        }
        
        // verificar si el email ya existe

        $emailExists = $this->userModel->getByEmail( $email );
        
        if ( $emailExists ) {
            redirect('/auth/registro?error=El email ya se encuentra registrado');
        }

        // Encriptar la contraseña
        $password = password_hash($password, PASSWORD_DEFAULT);

        $this->userModel->create($nombre, $apellido, $email, $password, $rol);

        $userCreated = $this->userModel->getByEmail( $email );

        $this->userDetailsModel->create($userCreated->user_id, $domicilio, $telefono, '', $politics, $active);
        
        if ( $userCreated ) {
            $_SESSION['user'] = $userCreated;
            redirect('/?success=Usuario registrado correctamente');
        }else{
            redirect('/auth/registro?error=Error al registrar el usuario');
        }

    }

    public function confirmLogin(){

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $email      = $_POST['email'];
        $password   = $_POST['password'];

        $user = $this->userModel->getByEmail($email);

        if ( !$user ) {
            redirect('/auth?error=Usuario no encontrado');
        }

        if ( !password_verify($password, $user->password_user) ) {
            redirect('/auth?error=Email o contraseña incorrectos');
        }

        $_SESSION['user'] = $user;

        redirect('/?success=Usuario logueado correctamente');

    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        redirect('/');
    }

    public function miPerfil(){

        verifyUserLogged();

        $userDetails = $this->userDetailsModel->find( $_SESSION['user']->user_id );

        return $this->view('layouts/main', [
            'content' => '/auth/miPerfil',
            'detalles' => $userDetails
        ]);

    }

    public function miPerfilApi(){

        verifyUserLogged();

        $userDetails = $this->userDetailsModel->find( $_SESSION['user']->user_id );

        echo json_encode($userDetails);
    }

    public function editarPerfil(){

        verifyUserLogged();

        $userDetails = $this->userDetailsModel->find( $_SESSION['user']->user_id );

        return $this->view('layouts/main', [
            'content' => '/auth/editarPerfil',
            'detalles' => $userDetails
        ]);

    }

    public function updatePerfil(){

        $imagen     = $_FILES['imagen'];
        $nombre     = $_POST['name'];
        $apellido   = $_POST['lastname'];
        $email      = $_POST['email'];
        $password   = $_POST['password'];
        $direccion  = $_POST['direccion'];
        $telefono   = $_POST['telefono'];
        $politics   = $_POST['politics'];
        $ofertas    = $_POST['ofertas'];

        // Encriptar la contraseña
        $password = password_hash($password, PASSWORD_DEFAULT);

        // almacer la imagen en el servidor

        $imagenName     = $imagen['name'];
        $imagenTmp      = $imagen['tmp_name'];
        $imagenSize     = $imagen['size'];
        $imagenError    = $imagen['error'];
        $imagenExt      = explode('.', $imagenName);
        $imagenActualExt = strtolower(end($imagenExt));
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if ( in_array($imagenActualExt, $allowed) ){

            if ( $imagenSize < 1000000 ){

                $path   = '../public/assets/img/';
                $folder = 'profile_pics';

                if (!file_exists($path.$folder)) {
                    mkdir($path.$folder, 0777);
                }
 
                $imagenNameNew      = uniqid('', true) . "." . $imagenActualExt;
                $imagenDestination  = $path . $folder . "/" . $imagenNameNew;
                move_uploaded_file($imagenTmp, $imagenDestination);
                $finalUrl = url('assets/img/profile_pics/' . $imagenNameNew);

                $this->userModel->update($_SESSION['user']->user_id, $nombre, $apellido, $email);
                $this->userDetailsModel->update($_SESSION['user']->user_id, $direccion, $telefono, $finalUrl, $politics, $ofertas);

                $_SESSION['user'] = $this->userModel->find($_SESSION['user']->user_id);

                redirect('/auth/miPerfil?success=Perfil actualizado correctamente');

            }else{
                redirect('/auth/editarPerfil?error=El archivo es muy grande');
            }

        }else{
            redirect('/auth/editarPerfil?error=El archivo no es una imagen');
        }

    }

    // metodo para enviar un correo de recuperacion de contraseña
    public function showRecoverPassword(){
        return $this->view('layouts/main', ['content' => '/auth/recoverPassword']);
    }

    public function sendRecoveryEmail(){
        try {
            
            $email = $_POST['email'];

            $user = $this->userModel->getByEmail($email);

            if ( !$user ) {
                throw new Exception('El email no se encuentra registrado');
            }

            $token = bin2hex(random_bytes(32));
            $this->userModel->saveResetToken($email, $token);

            $resetLink = url('/auth/resetPassword?token=' . $token);

            // enviar el correo

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'SebCompanyEsAdmin@sebcompanyes.com';
            $mail->Password = '@Sebas1124';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('SebCompanyEsAdmin@sebcompanyes.com', 'Soporte Arte de cocinar');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Has solicitado recuperar tu contraseña!';
            $mail->Body = "Has solicitado recuperar tu contraseña, haz click en el siguiente enlace para recuperarla: <a href='$resetLink'>Recuperar contraseña</a>";

            $mail->send();
            
            redirect('/auth/showRecoverPassword?success=Correo enviado correctamente');

        } catch (\Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function resetPassword(){
        $token = $_GET['token'];

        $user = $this->userModel->getByToken($token);

        if ( !$user ) {
            redirect('/auth/showRecoverPassword?error=Token invalido');
        }

        return $this->view('layouts/main', ['content' => '/auth/resetPassword', 'token' => $token]);
    }

    public function updatePassword(){
            
        $password   = $_POST['password'];
        $password2  = $_POST['password2'];
        $token      = $_POST['token'];

        if ( $password != $password2 ) {
            redirect('/auth/resetPassword?token=' . $token . '&error=Las contraseñas no coinciden');
        }

        $user = $this->userModel->getByToken($token);

        if ( !$user ) {
            redirect('/auth/showRecoverPassword?error=Token invalido');
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $this->userModel->updatePassword($user->user_id, $password);

        redirect('/auth?success=Contraseña actualizada correctamente');
    }

}