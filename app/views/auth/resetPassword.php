
<!-- Formulario para cambiar la contraseña -->
<?php 
    $token = $data["token"];
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <h1>Cambiar contraseña</h1>
            <form action="<?= url('/auth/updatePassword') ?>" method="POST">
                <div class="form-group">
                    <label for="password">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password2">Repetir contraseña</label>
                    <input type="password" name="password2" class="form-control">
                </div>
                <input type="hidden" name="token" value="<?= $token ?>">
                <button type="submit" class="btn btn-outline-primary mt-2 mb-2">Cambiar contraseña</button>
            </form>
        </div>
    </div>
</div>