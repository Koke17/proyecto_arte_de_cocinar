
<!-- Formulario para crear categoria -->


<div class="container">

    <h2 class="d-flex justify-content-center h2-usuarios mt-4">Crear Categoria</h2>

    <form class="p-5" action="<?php echo url('Categorias/store') ?>" method="POST">
        <div class="mb-3">
            <label for="name_category" class="form-label">Nombre de la categoria</label>
            <input type="text" class="form-control" id="name_category" name="name_category">
        </div>
        <button type="submit" class="btn btn-navbar">Crear</button>
    </form>

</div>