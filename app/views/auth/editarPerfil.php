
<!-- Formulario para editar perfil con imagen -->

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

<div class="container" style="margin-bottom: 150px;">

    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Editar perfil</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Datos personales</h5>

                    <form 
                        action=<?= url('Auth/updatePerfil') ?> 
                        method="POST" 
                        enctype="multipart/form-data"
                    >

                        <div class="avatar-wrapper">
                            <img class="profile-pic" src="<?= $imagen ?>" />
                            <div class="upload-button">
                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                            </div>
                            <input name="imagen" class="file-upload" type="file" />
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre</label>
                            <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= $_SESSION['user']->name_user ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Apellido</label>
                            <input name="lastname" type="text" class="form-control" id="exampleInputPassword1" value="<?= $_SESSION['user']->lastname_user ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleInputPassword1" value="<?= $_SESSION['user']->email_user ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Dirección</label>
                            <input name="direccion" type="text" class="form-control" id="exampleInputPassword1" value="<?= $direccion ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Teléfono</label>
                            <input name="telefono" type="text" class="form-control" id="exampleInputPassword1" value="<?= $telefono ?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input name="ofertas" type="checkbox" class="form-check-input" id="exampleCheck1" <?= $ofertas == 1 ? 'checked' : '' ?>>
                            <label class="form-check" for="exampleCheck1">Recibir ofertas</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input name="politics" type="checkbox" class="form-check-input" id="exampleCheck1" <?= $politics == 1 ? 'checked' : '' ?>>
                            <label class="form-check" for="exampleCheck1">Recibir políticas</label>
                        </div>
                        <button id="loginBtn" type="submit" class="btn btn-navbar">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let readURL = function (input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    document.querySelector('.profile-pic').setAttribute('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.querySelector(".file-upload").addEventListener('change', function () {
            readURL(this);
        });

        document.querySelector(".upload-button").addEventListener('click', function () {
            document.querySelector(".file-upload").click();
        });
    });
</script>
