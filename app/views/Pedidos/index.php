

<?php
    $pedidos = $data["pedidos"];
?>

<div class="container">

    <?php foreach ($pedidos as $index => $pedido) : ?>

        <?php foreach ($pedido as $pedido) : ?>
        
            <?php
                $products = $pedido->Productos;
                $estado = ($pedido->estado_pedido == 1) ? "Pendiente" : (($pedido->estado_pedido == 2) ? "En Proceso" : (($pedido->estado_pedido == 3) ? "Cancelado" : "Facturado"));
                $estadoPreparacion = ($pedido->estado_preparacion == 1) ? "Recibido" : (($pedido->estado_preparacion == 2) ? "En Preparación" : (($pedido->estado_preparacion == 3) ? "Enviado" : "Entregado"));
            ?>

            <?php if ( count($products) > 0 && $pedido->estado_pedido === 4) : ?>
                <hr>
                <div class="row">
                    <div class="col">

                        <!-- Validar si el array de productos viene con datos sino mostrar un warning sin registros -->
                        <div class="d-flex justify-content-between">
                            <div class="container">
                                <div class="row">

                                    <!-- Tipo de entrega 1 = recogida y 2 = Domicilio -->
                                    <div class="mb-2">
                                        <h1>Tipo de entrega: <?= ($pedido->tipo_entrega == 1) ? "Recogida" : "Domicilio" ?></h1>
                                    </div>

                                    <div class="mb-5">
                                        <h1>Pedido #<?=$pedido->pedido_id?></h1>
                                        <h4>Fecha: <?=$pedido->fecha_pedido?></h2>
                                        <h4>Total: <?=number_format($pedido->total_pedido, 2, '.', ',')?>€</h3>
                                        <h4>Iva: <?=$pedido->iva_pedido?>%</h3>
                                        <h4>Estado <?=$estadoPreparacion?></h3>
                                        <h4>Facturado: <?= $estado ?></h3>
                                    </div>

                                    <div>
                                        <h1>Datos del cliente: </h1>
                                    </div>

                                    <div class="container mb-5">
                                        <div>
                                            <h4>Cliente: <?= $pedido->user->name_user ?> <?= $pedido->user->lastname_user ?></h3>
                                            <h4>Email: <?= $pedido->user->email_user ?></h3>
                                            <h4>Direccion: <?= $pedido->userDetail->direccion ?></h3>
                                            <h4>Telefono: <?= $pedido->userDetail->telefono ?></h3>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <?php if($_SESSION["user"]->role_id === 1) : ?>
                                <div>
                                    <select 
                                        class="form-select changeStatusPedido" 
                                        aria-label="Default select example"
                                        data-pedido="<?=$pedido->pedido_id?>"
                                        data-estado="<?=$pedido->estado_preparacion?>"
                                    >
                                        <option value="1">Recibido</option>
                                        <option value="2">En Preparación</option>
                                        <option value="3">Enviado</option>
                                        <option value="4">Entregado</option>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!--Datos del pedido-->

                        <div class="container">

                            <div>
                                <h1>Datos del pedido:</h1>
                            </div>

                            <div class="row d-flex justify-content-start flex-wrap gap-5">
                                <?php foreach ($products as $product) : ?>
                                    <div class="col-md-4">
                                        <div class="card p-2 m-2" style="width: 18rem;">
                                            <img src="<?= $product->product_image ?>" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $product->name_product ?></h5>
                                                <p class="card-text"><?= $product->descripcion_product ?></p>
                                                <p class="card-text"><?= $product->precio ?>€</p>
                                                <p class="card-text"><?= $product->cantidad ?> unidades</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
        
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach;?>
    <?php endforeach;?>

</div>

<script>
    const changeStatusPedido = document.querySelectorAll(".changeStatusPedido");

    changeStatusPedido.forEach( element => {

        element.value = element.getAttribute("data-estado");

        element.addEventListener("change", async (e) => {

            const pedido_id = e.target.getAttribute("data-pedido");
            const estadoActual = e.target.getAttribute("data-estado");
            const estado = e.target.value;
            const url = "<?=url("/Pedidos/changeStatusPedido")?>";

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    pedido_id,
                    estado
                },
                beforeSend: function(){
                    openLoader();
                },
                success: function(response) {
                    closeLoader();
                    if (response.status == true) {
                        e.target.setAttribute("data-estado", estado);
                        Swal.fire({
                            icon: 'success',
                            title: 'Estado actualizado correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function(error){
                    conseole.log(error);
                    closeLoader();
                }
            });
            
        });
    });

</script>