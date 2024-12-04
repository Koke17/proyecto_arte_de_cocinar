<?php

    $nombre     = $data['user']->name_user;
    $apellido   = $data['user']->lastname_user;
    $correo     = $data['user']->email_user;
    $id         = $data['user']->user_id;

?>

<div class="container p-5">

    <h2 class="h2-usuarios">Detalles del usuario <?= $nombre ?></h2>
    
    <div class="container mt-3">
        <form action="<?php echo url('Users/store/' . $id) ?>" method="POST">
            <div class="mb-3">
                <label for="name_user" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name_user" name="name_user" value="<?= $nombre ?>">
            </div>
            <div class="mb-3">
                <label for="lastname_user" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="lastname_user" name="lastname_user" value="<?= $apellido ?>">
            </div>
            <div class="mb-3">
                <label for="email_user" class="form-label">Correo</label>
                <input type="email" class="form-control" id="email_user" name="email_user" value="<?= $correo ?>">
            </div>

            <!-- Select para roles -->
            <div class="mb-5">
                <label for="role_id" class="form-label">Rol</label>
                <select class="form-select" id="role_id" name="role_id">
                    <?php foreach ($data['roles'] as $role) : ?>
                        <option value="<?= $role->role_id ?>" <?= $role->role_id == $data['user']->role_id ? 'selected' : '' ?>><?= $role->role_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class=" d-flex gap-3">
                <button type="submit" class="btn btn-navbar">Actualizar</button>
                <a class="btn btn-navbar" href="<?php echo url("Users/index") ?>">Volver</a>
            </div>
        </form>
    </div>
</div>

