<div class="col p-5">
    <form action="<?= url('/auth/confirmLogin') ?>" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <a href="<?= url('/auth/registro') ?>">¿No estas registrado? ¡Registrate ahora!</a>
        </div>

        <!-- olvidaste tu contraseña -->
        <div class="mb-3">
            <a href="<?= url('/auth/showRecoverPassword') ?>">¿Olvidaste tu contraseña?</a>
        </div>

        <button id="loginBtn" type="submit" class="btn btn-navbar">Submit</button>
    </form>
</div>

<script>

    const loginBtn = document.getElementById('loginBtn');

    loginBtn.addEventListener('click', (event) => {
        openLoader();
    })

</script>
