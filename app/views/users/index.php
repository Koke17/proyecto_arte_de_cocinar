<!-- CRUD -->
<!-- C = create -->
<!-- R = read -->
<!-- U = update -->
<!-- D = delete -->

<!-- Create -->

<div class="container">

    <h2 class="d-flex justify-content-center h2-usuarios mt-4">USUARIOS</h2>

    <div class="p-5">

        <div class="mb-5 div-usuarios rounded p-3">
            <ul class="list-group list-group-flush ">
                <?php foreach ($data["users"] as $user) : ?>

                    <div class="rounded">
                        <li class="d-flex justify-content-between list-group-item li-usuarios">
                            <?= $user->name_user ?>

                            <div class="d-flex justify-content-around gap-3">
                                <a
                                    class="btn btn-outline-light"
                                    href="<?php echo url('Users/show/' . $user->user_id) ?>">
                                    Detalles
                                </a>
                                <a
                                    class="btn btn-outline-light"
                                    href="<?php echo url('Users/update/' . $user->user_id) ?>">
                                    Editar
                                </a>
                            </div>
                        </li>

                    </div>
                    
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="d-flex justify-content-center"><a class="btn btn-navbar" href="<?php echo url('Users/create') ?>">Crear Usuario</a></div>

    </div>

</div>