
<div class="container">

    <h2 class="d-flex justify-content-center h2-usuarios mt-4">Products</h2>

    <?php if ( !isset($data["productos"]) ) : ?>
        <div class="alert alert-warning" role="alert">
            No hay productos registrados
        </div>

    <?php else : ?>
        <div class="p-5">

            <div class="mb-5 div-usuarios rounded p-3">
                <ul class="list-group list-group-flush ">
                    <?php foreach ($data["productos"] as $product) : ?>

                        <div class="rounded">
                            <li class="d-flex justify-content-between list-group-item li-usuarios">

                                <img
                                    src="<?= $product->product_image ?>"
                                    alt="<?= $product->name_product ?>"
                                    class="img-fluid img-thumbnail"
                                    style="width: 100px; height: 100px;"
                                />

                                <?= $product->name_product?> |
                                <?= $product->name_category ?>

                                <div class="d-flex justify-content-around gap-3">
                                    <a
                                        class="btn btn-outline-light"
                                        href="<?php echo url('Products/edit/' . $product->product_id) ?>">
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
        <a class="btn btn-navbar" href="<?php echo url('Products/create') ?>">
            Crear producto
        </a>
    </div>
    

</div>