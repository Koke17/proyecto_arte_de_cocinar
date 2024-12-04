<div class="container p-5">
    <form method="POST" action="<?= url('/auth/confirmarRegistro') ?>">
        <div class="form-floating mb-3">
            <input 
                type="text" 
                class="form-control" 
                id="floatingInput" 
                placeholder="name@example.com"
                name="nombre"
            >
            <label for="floatingInput">Nombre</label>
        </div>
        <div class="form-floating mb-3">
            <input 
                type="text" 
                class="form-control" 
                id="floatingInput" 
                placeholder="name@example.com"
                name="apellido"
            >
            <label for="floatingInput">Apellido</label>
        </div>
        <div class="form-floating mb-3">
            <input 
                type="email" 
                class="form-control" 
                id="floatingInput" 
                placeholder="name@example.com"
                name="email"
            >
            <label for="floatingInput">Dirección de email</label>
        </div>
        <div class="form-floating mb-3">
            <input 
                type="number" 
                class="form-control" 
                id="floatingPassword" 
                placeholder="Password"
                name="telefono"
            >
            <label for="floatingPassword">Teléfono de contacto</label>
        </div>
        <div class="form-floating mb-3">
            <input 
                type="text" 
                class="form-control" 
                id="floatingPassword" 
                placeholder="Direccion"
                name="domicilio"
            >
            <label for="floatingPassword">Domicilio</label>
        </div>
        <div class="form-floating mb-3">
            <input 
                type="password" 
                class="form-control" 
                id="floatingPassword" 
                placeholder="Contraseña"
                name="password"
            >
            <label for="floatingPassword">Contraseña</label>
        </div>
    
        <div class="form-floating mb-3">
            <input 
                type="password" 
                class="form-control" 
                id="floatingPassword" 
                placeholder="Repetir contraseña"
                name="password_confirmation"
            >
            <label for="floatingPassword">Repetir contraseña</label>
        </div>
    
        <div class="mb-3 form-check">
            <input 
                type="checkbox" 
                class="form-check-input" 
                id="exampleCheck1"
                name="activarOfertas"
            >
            <label class="form-check-label" for="exampleCheck1">Deseo recibir correos informativos sobre nuevas ofertas</label>
        </div>
    
        <div class="mb-3 form-check">
            <input 
                type="checkbox" 
                class="form-check-input" 
                id="exampleCheck1"
                name="aceptarPolitica"
            >
            <label class="form-check-label" for="exampleCheck1">Acepto la política</label>
        </div>
    
        <button type="submit" class="btn btn-navbar">Submit</button>
    </form>
</div>
