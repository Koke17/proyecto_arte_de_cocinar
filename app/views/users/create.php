
<!-- crear usuario -->

<div class="container p-5">

    <h2 class="h2-usuarios">Añadir un nuevo usuario</h2>

    <div class="container mt-4">
        <form action="<?= url('Users/storeNewUser') ?>" method="POST">
            <div class="form-group mb-2">
                <label for="name_user"><b>Nombre</b></label>
                <input type="text" class="form-control" id="name_user" name="name_user" placeholder="Nombre">
            </div>
            <div class="form-group mb-2">
                <label for="lastname_user"><b>Apellido</b></label>
                <input type="text" class="form-control" id="lastname_user" name="lastname_user" placeholder="Apellido">
            </div>
            <div class="form-group mb-2">
                <label for="email_user"><b>Correo</b></label>
                <input type="email" class="form-control" id="email_user" name="email_user" placeholder="Correo">
            </div>
            <div class="form-group mb-3">
                <label for="password_user"><b>Contraseña</b></label>
                <input type="password" class="form-control" id="password_user" name="password_user" placeholder="Contraseña">
            </div>
            <div class="form-group-mb-2">
                <label for="role_id"><b>Rol</b></label>
                <select class="form-select mb-2" id="role_id" name="role_id">
                    <?php foreach ($data["roles"] as $rol) : ?>
                        <option value="<?= $rol->role_id ?>"><?= $rol->role_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary ">Guardar</button>
        </form>
    </div>
</div>