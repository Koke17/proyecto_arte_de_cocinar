<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../core/Controller.php';

class AnouncesController extends Controller {

    private $userModel;
    private $AnouncesModel;

    public function __construct(){
        $this->userModel = $this->model('User');
        $this->AnouncesModel = $this->model('Anounces');
    }

    public function index(){
        $this->view('layouts/main', ['content' => '/Anounces/index']);
    }

    public function store(){
        $anounce    = $_POST['anounce'];
        $vigencia   = $_POST['vigencia'];
        $user_id    = $_SESSION['user']->user_id;
        
        $this->AnouncesModel->create($anounce, $vigencia, $user_id);
        
        // Enviar el correo a todos los usuario de mi tabla users

        try {
            
            $users = $this->userModel->getAll();

            $destinatarios = [];

            foreach ($users as $user) {
                $destinatarios[] = $user->email_user;
            }

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'SebCompanyEsAdmin@sebcompanyes.com';
            $mail->Password = '@Sebas1124';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('SebCompanyEsAdmin@sebcompanyes.com', 'Arte de cocinar');
            
            foreach ($destinatarios as $destinatario) {
                $mail->addAddress($destinatario);
            }

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo anuncio';
            $mail->Body = $anounce. ' - Vigencia: '.$vigencia;

            $mail->send();
            
            dd('Correo enviado correctamente');

        } catch (\Throwable $th) {
            throw new Exception("Error ".$th->getMessage());
        }

        // header('Location: '.url('Anounces/index'));
    }

}