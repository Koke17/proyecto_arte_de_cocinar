<?php

$nombre     = $data['user']->name_user;
$apellido   = $data['user']->lastname_user;
$correo     = $data['user']->email_user;
$id         = $data['user']->user_id;

if ( $data["detalles"] ) {
    $imagen = $data['detalles']->imagen;
}

?>

<div class="container p-5">


    <div class="d-flex justify-content-start mb-5">
        <h2 class="h2-usuarios">Detalles del usuario <?= $nombre ?></h2>
    </div>

    <div class="d-flex justify-content-start allign-items-center mb-5">

        <div class="d-flex">

            <div class="avatar-wrapper me-5">
                <img
                    class="profile-pic" src="<?= $imagen ?>" />
                <div class="upload-button">
                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                </div>
            </div>

            <div class="row">
                <h3 class="h3-usuarios mt-5">Nombre del Usuario:</h2>
                <h3 class="border"><?= $nombre . " " . $apellido ?></h3>
                <h3 class="h3-usuarios">Correo:</h2>
                <h5 class="border"><?= $correo ?></h5>
                <h3 class="h3-usuarios">ID:</h2>
                <h5 class="border"><?= $id ?></h5>
            </div>
        </div>


    </div>

    <div class="d-flex justify-content-center gap-3">
        <a
            id="deleteUserBtn"
            class="btn btn-outline-danger"
            href="<?php echo url("Users/delete/$id") ?>">
            Eliminar
        </a>
        <a
            class="btn btn-navbar"
            href="<?php echo url("Users/index") ?>">
            Volver
        </a>
    </div>


</div>

<script>

    const deleteUserBtn = document.getElementById('deleteUserBtn');

    deleteUserBtn.addEventListener('click', (event) => {

        event.preventDefault();

        Swal.fire({
            'title': '¿Estás seguro?',
            'text': 'Esta acción no se puede deshacer',
            'icon': 'warning',
            'showCancelButton': true,
            'confirmButtonColor': '#3085d6',
            'cancelButtonColor': '#d33',
            'confirmButtonText': 'Sí, eliminar',
            'cancelButtonText': 'Cancelar'
        }).then((result) => {
            if( result.isConfirmed ){
                window.location.href = deleteUserBtn.getAttribute('href');
            }
        });


    });


</script>