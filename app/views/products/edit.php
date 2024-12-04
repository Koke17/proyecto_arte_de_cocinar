<?php

    // recuperar las variables
    $producto   = $data["producto"];
    $categorias = $data["categorias"];

?>

<div class="container">

    <h2 class="d-flex justify-content-center h2-usuarios mt-4">Editar el producto <?= $producto->name_product ?></h2>

    <form class="p-5" action="<?php echo url("Products/update/$producto->product_id") ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name_product" class="form-label">Nombre del producto</label>
            <input 
                type="text" 
                class="form-control" 
                id="name_product" 
                name="name_product"
                value="<?= $producto->name_product ?>"
            >
        </div>
        <div class="mb-3">
            <label for="name_category" class="form-label">Categoría del producto</label>
            <select class="form-select" id="name_category" name="name_category">
                <?php foreach ($categorias as $category) : ?>
                    <option 
                        value="<?= $category->categoria_id ?>"?
                        <?= ($category->categoria_id == $producto->categoria_id) ? 'selected' : '' ?>
                    >
                        <?= $category->name_category ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="name_produc" class="form-label">Descripción del producto</label>
            <input 
                type="text" 
                class="form-control" 
                id="descripcion_product" 
                name="description"
                value="<?= $producto->descripcion_product ?>"
            >
        </div>
        <div class="mb-3">
            <label for="name_produc" class="form-label">Precio del producto</label>
            <input 
                type="text" 
                class="form-control" 
                id="precio_product" 
                name="price"
                value="<?= $producto->precio_product ?>"
            >
        </div>

        <div class="mb-3">
            <label for="name_produc" class="form-label">stock</label>
            <input 
                type="text" 
                class="form-control" 
                id="precio_product" 
                name="stock"
                value="<?= $producto->stock ?>"
            >
        </div>
        <div class="mb-3">
            <!-- Vista previa de la imagen subida -->
            <img 
                src="<?= $producto->product_image ?>" 
                alt="<?= $producto->name_product ?>" 
                class="img-fluid img-thumbnail" 
                style="width: 100px; height: 100px;"
            />

            <label for="name_produc" class="form-label">Imagen del producto</label>
            <input name="imagen" class="file-upload" type="file" />
        </div>
        <button type="submit" class="btn btn-navbar">Editar</button>
    </form>

</div>