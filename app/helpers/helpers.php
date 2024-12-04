<?php

if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die(); // Detiene la ejecución del script
    }
}

if (!function_exists('public_path')) {

    function public_url($path = '')
    {
        // Asegurarse de que la URL base es la correcta
        $base_url = 'http://127.0.0.1/proyecto_arte_de_cocinar/public';

        // Devuelve la URL completa combinada con el path, si se especifica
        return $base_url . ($path ? '/' . ltrim($path, '/') : '');
    }
}

// url de mi app

if (!function_exists('url')) {

    function url($path = '')
    {
        // Asegurarse de que la URL base es la correcta
        $base_url = 'http://127.0.0.1/proyecto_arte_de_cocinar/public';
        return $base_url . ($path ? '/' . ltrim($path, '/') : '');
    }
}

// metodo para redireccionar

if( !function_exists('redirect') ) {
    function redirect($path = '') {
        header('Location: ' . url($path));
    }
}

// Metodo para verificar si el usuario logueado es admin sino redireccionarlo al home
if( !function_exists('verifyAdmin') ){
    function verifyAdmin(){
        if ( isset($_SESSION["user"]) && $_SESSION["user"]->role_id !== 1 ) {
            redirect('/');
        }
    }
}

// Metodo para verificar si el usuario está logueado
if( !function_exists('verifyUserLogged') ){
    function verifyUserLogged(){
        if ( !isset($_SESSION["user"]) ) {
            redirect('/auth?error=Debes iniciar sesión');
        }
    }
}

// Metodo para subir imagenes al servidor con las validaciones de png, jpg y jpeg, gif
if( !function_exists('uploadImagesServer') ){
    function uploadImagesServer( $archivo, $ruta, $folder ){

        $nombre     = $archivo['name'];
        $tipo       = $archivo['type'];
        $tamano     = $archivo['size'];
        $tmp_name   = $archivo['tmp_name'];

        // validar si se subio un archivo
        if ( empty($nombre) || !$archivo ) {
            return [
                "error" => "No se ha seleccionado un archivo",
                'status' => false
            ];
        }

        // verificar tipo
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        $extencion = explode('.', $nombre);
        $extencion = strtolower(end($extencion));

        // verificar el tamaño
        if ( $tamano > 1000000 ) {
            return [
                "error" => "El archivo es muy grande",
                'status' => false
            ];
        }

        // validar la extencion
        if ( !in_array($extencion, $allowed) ) {
            return [
                "error" => "El archivo no es una imagen",
                'status' => false
            ];
        }

        // crear la ruta
        $ruta = $ruta . $folder;

        // crear la carpeta si no existe
        if ( !file_exists($ruta) ) {
            mkdir($ruta, 0777);
        }

        // crear un nombre unico
        $nombreNuevo = uniqid('', true) . "." . $extencion;

        // mover el archivo
        move_uploaded_file($tmp_name, $ruta . "/" . $nombreNuevo);

        // Ruta final donde se almacena la imagen
        $finalUrl = url("assets/img/$folder/$nombreNuevo");

        return [
            "message" => "Imagen subida correctamente",
            "status" => true,
            "url" => $finalUrl
        ];

    }
}