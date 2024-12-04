
<!-- Mi perfil -->
<div class="container">

    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Mi perfil</h1>
        </div>
    </div>

    <?php 
        $rol = '';

        if ( $_SESSION['user']->role_id == 1 ) {
            $rol = 'Administrador';
        }else{
            $rol = 'Cliente';
        }

        $direccion = $data["detalles"]->direccion;
        $telefono = $data["detalles"]->telefono;
        $imagen = $data["detalles"]->imagen;
        $politics = $data["detalles"]->politics;
        $ofertas = $data["detalles"]->ofertas;

    ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Datos personales</h5>

                    <div class="avatar-wrapper">
                        <img
                        class="profile-pic" src="<?= $imagen ?>" />
                        <div class="upload-button">
                            <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                        </div>
                    </div>

                    <p class="card-text">Nombre:    <?= $_SESSION['user']->name_user ?></p>
                    <p class="card-text">Apellido:  <?= $_SESSION['user']->lastname_user ?></p>
                    <p class="card-text">Email:     <?= $_SESSION['user']->email_user ?></p>
                    <p class="card-text">Rol:       <?= $rol ?></p>

                    <!-- datos personales -->
                    <h5 class="card-title">Datos de contacto</h5>
                    <p class="card-text">Dirección: <?= $direccion ?></p>
                    <p class="card-text">Teléfono: <?= $telefono ?></p>

                    <!-- preferencias -->
                    <h5 class="card-title">Contacto</h5>
                    <p class="card-text">Recibir ofertas: <?= $ofertas == 1 ? 'Si' : 'No' ?></p>
                    <p class="card-text">Recibir políticas: <?= $politics == 1 ? 'Si' : 'No' ?></p>

                    <a href=<?= url('Auth/editarPerfil') ?> class="btn btn-primary">Editar perfil</a>

                </div>
            </div>
        </div>
    </div>

</div>

<script>

    openLoader();

    document.addEventListener('DOMContentLoaded', () => {
        closeLoader();
    });

</script>

<style>
    .imagenPerfil{
        width: 200px;
        height: 200px;
        border-radius: 50%;
    }
</style>
