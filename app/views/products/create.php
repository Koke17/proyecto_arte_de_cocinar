<?php


?>

<div class="container">

    <h2 class="d-flex justify-content-center h2-usuarios mt-4">Crear Producto</h2>

    <form class="p-5" action="<?php echo url('Products/store') ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name_product" class="form-label">Nombre del producto</label>
            <input type="text" class="form-control" id="name_product" name="name_product">
        </div>
        <div class="mb-3">
            <label for="name_category" class="form-label">Categoría del producto</label>
            <select class="form-select" id="name_category" name="name_category">
                <?php foreach ($data['categorias'] as $category) : ?>
                    <option value="<?= $category->categoria_id ?>"?><?= $category->name_category ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="description_product" class="form-label">Descripción del producto</label>
            <input type="text" class="form-control" id="descripcion_product" name="description">
        </div>
        <div class="mb-3">
            <label for="price_product" class="form-label">Precio del producto</label>
            <input type="text" class="form-control" id="precio_product" name="price">
        </div>

        <div class="mb-3">
            <label for="stock_produc" class="form-label">Stock</label>
            <input type="number" step="1" class="form-control" id="stock_product" name="stock">
        </div>
        
        <div class="mb-3">
            <label for="img_product" class="form-label">Imagen del producto</label>
            <input name="imagen" class="file-upload" type="file" />
        </div>
        <button type="submit" class="btn btn-navbar">Crear</button>
    </form>

</div>