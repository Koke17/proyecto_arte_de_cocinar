
<!-- Formulario para recuperar la contraseña -->

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <h1>Recuperar contraseña</h1>
            <form action="<?= url('/auth/sendRecoveryEmail') ?>" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <button type="submit" class="btn btn-outline-primary mt-2 mb-2">Recuperar contraseña</button>
            </form>
        </div>
    </div>
</div>