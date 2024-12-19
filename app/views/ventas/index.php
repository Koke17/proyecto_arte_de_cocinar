<?php

    $ventas = $data['ventas'];

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ventas</h3>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Total</th>
                        <th>Fecha Pedido</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?= $venta->stripe_id ?></td>
                            <td><?= formatMoney($venta->total_pedido) ?></td>
                            <td><?= $venta->fecha_pedido ?></td>
                            <td><?= $venta->estado_pedido ?></td>
                            <td>
                                <a 
                                    href="<?= url('Sales/generateFactura?id=' . $venta->stripe_id) ?>" 
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    Factura
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>