
<div class="container">

    <h2 class="d-flex justify-content-center h2-usuarios mt-4">Categorias</h2>

    <?php if ( !$data["categorias"] ) : ?>
        <div class="alert alert-warning" role="alert">
            No hay categorias registradas
        </div>

    <?php else : ?>
        <div class="p-5">

            <div class="mb-5 div-usuarios rounded p-3">
                <ul class="list-group list-group-flush ">
                    <?php foreach ($data["categorias"] as $categoria) : ?>

                        <div class="rounded">
                            <li class="d-flex justify-content-between list-group-item li-usuarios">
                                <?= $categoria->name_category?>

                                <div class="d-flex justify-content-around gap-3">
                                    <a
                                        class="btn btn-outline-light"
                                        href="<?php echo url('Categorias/edit/' . $categoria->categoria_id) ?>">
                                        Editar
                                    </a>
                                </div>
                            </li>

                        </div>
                        
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    <?php endif; ?>


    <div 
        class="d-flex justify-content-center">
        <a class="btn btn-navbar" href="<?php echo url('Categorias/create') ?>">
            Crear Categoria
        </a>
    </div>
    

</div>