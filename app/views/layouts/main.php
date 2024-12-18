<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>El Arte de Cocinar</title>

    <!-- Importacion de Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Importacion del css-->
    <link rel="stylesheet" href=<?php echo public_url("assets/css/style.css") ?>>
    <!-- Importacion de las letras Google Fonts-->
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <div class="loaderContainer">
        <div class="loader"></div>
    </div>

    <script>
        const loader = document.querySelector('.loaderContainer');

        const openLoader = () => {
            loader.style.display = 'flex';
        }

        const closeLoader = () => {
            loader.style.display = 'none';
        }

        // cuando arranca la pagina se ejecuta el loader
        openLoader();

        // cuando termina de cargar la pagina se cierra el loader
        document.addEventListener('DOMContentLoaded', () => {
            closeLoader();
        });

    </script>

    <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">

            <div class="d-flex align-items-center me-5">
                <a
                    href=<?= url() ?>
                >
                    <img src=<?php echo public_url("assets/img/Art-of-cooking-logo-navbar.png") ?> width="150" height="150" alt="logo-arte-de-cocinar">
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Boton del carito -->
            <button 
                class="btn btn-outline-light d-lg-none carritoCounterShow" 
                type="button"
                data-bs-toggle="offcanvas" 
                data-bs-target="#offcanvasWithBothOptions" 
                aria-controls="offcanvasWithBothOptions"
                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <span class="carritoCounter">0</span>
                <ion-icon name="cart-outline"></ion-icon>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                <div class="lista-navbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= url('/')?>">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href=<?= url('/Menu') ?>>Menu</a>
                        </li>

                        <?php if (isset($_SESSION['user'])) : ?>
                            <!-- DropDown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $_SESSION['user']->name_user ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href=<?= url('Auth/miPerfil') ?>>Mi perfil</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=<?= url('Pedidos') ?>>Mis Pedidos</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=<?= url('Auth/logout') ?>>Cerrar Sesión</a>
                                    </li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href=<?= url('Auth') ?>>Iniciar Sesión</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="url('Contacto')">Contacto</a>
                        </li>

                    </ul>
                </div>

                <div class="d-flex justify-content-between gap-3">
                    <!-- Carrito Logo -->
                    <button 
                        class="btn btn-outline-light d-none d-lg-block carritoCounterShow"
                        type="button"
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#offcanvasWithBothOptions" 
                        aria-controls="offcanvasWithBothOptions"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <span class="carritoCounter">0</span>
                        <ion-icon name="cart-outline"></ion-icon>
                    </button>
    
                    <form class="d-flex" role="search">
                        <input class="form-control me-2 form-navbar" type="search" placeholder="Buscar" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main>

        <div class="d-flex">
            
            <?php if ( isset($_SESSION['user']) && $_SESSION['user']->role_id == 1 ) : ?>
                <div class="border-end border-2">
                    <aside class="aside">
                        <!-- Menu para el admin -->
                        <div class="container">
                            <h4 class="text-center mt-3 aside-h4">Administración</h4>
                            <ul class="list-group d-flex justify-content-center aside-ul mt-3">
                                <li class="list-group">
                                    <a href=<?= url('Users') ?> class="list-group">Usuarios</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Categorias') ?> class="list-group">Categorias</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Products') ?> class="list-group">Productos</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Anounces') ?> class="list-group">Anuncios</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Empresas') ?> class="list-group">Empresa</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Pedidos') ?> class="list-group">Pedidos</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Roles') ?> class="list-group">Roles</a>
                                </li>
                                <li class="list-group">
                                    <a href=<?= url('Ventas') ?> class="list-group">Ventas</a>
                                </li>
                            </ul>
                    </aside>
                </div>
            <?php endif; ?>

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="payment-form">
                        <div id="card-element">
                        <!-- Stripe Element de la tarjeta -->
                        </div>
                        <div id="paypal">
                        <!-- Paypal Element -->
                        </div>
                        <button class="btn btn-outline-success mt-2" id="submit">Pagar</button>
                        <div id="payment-result"></div>
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                    </div>
                </div>
            </div>


            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Carrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Carrito -->
                     <div id="idCarritoElement" class="container">
                        <aside class="col-sm-12">
                            <h2>Carrito</h2>
                            <!-- Elementos del carrito -->
                            <div id="carrito">
                            </div>
                            <hr>
                            <!-- Precio total -->
                            <p class="text-right">Total: <span id="total-carrito"></span>&euro;</p>

                            <!-- Selector de entrega a domicilio -->
                            <div class="col-5">
                                <select id="tipo_entregaPedido" class="form-select mb-2" aria-label="Default select example">
                                    <option value="1">Recogida</option>
                                    <option value="2">Entrega a domicilio</option>
                                </select>
                            </div>

                            <!-- Boton de vaciar carrito -->
                            <button id="boton-vaciar" class="btn btn-danger">Vaciar</button>

                            <!-- Boton de checkout abrir modal -->
                            <button 
                                type="button" 
                                class="btn btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#staticBackdrop"
                                id="boton-pagar"
                            >
                                Ir a pagar <ion-icon name="card"></ion-icon>
                            </button>
                        </aside>
                     </div>
                </div>
            </div>

            <script>
                const botonPagar = $('button#boton-pagar');

                const confirmPayment = ( pedido_id, status, stripe_id ) => {

                    $.ajax({
                        url: '<?= url('Pedidos/update') ?>',
                        type: 'POST',
                        data: {
                            'pedido_id': pedido_id,
                            'status': status,
                            'stripe_id': stripe_id
                        },
                        success: function(response){
                            console.log(response); // TODO: manejar la respuesta como tu prefieras, una nueva venta, un mensaje en el modal 
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });

                }

                botonPagar.on('click', function(event){
                    event.preventDefault();
                    
                    const carritoLocal = localStorage.getItem('carrito');
                    const carrito = JSON.parse(carritoLocal);

                    $.ajax({
                        url: '<?= url('Auth/miPerfilApi') ?>',
                        type: 'GET',
                        success: function(response){
                            const res = JSON.parse(response);
                            if ( !res ) {
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    text: 'Debes Completar tu perfil para poder realizar compras',
                                    footer: '<a href="<?= url('Auth/miPerfil') ?>">Completar perfil</a>',
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                                return;
                            }

                            if ( carrito.length == 0 ) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: '¡Atención!',
                                    text: 'No hay productos en el carrito',
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                                return;
                            }

                            const tipoEntrega = $('#tipo_entregaPedido').val();

                            $.ajax({
                                'url': '<?= url('Pedidos/create') ?>',
                                'type': 'POST',
                                'data': {
                                    'carrito': carrito,
                                    'tipo_entrega': tipoEntrega
                                },
                                beforeSend: function(){
                                    openLoader();
                                },
                                success: function (response){
                                    closeLoader();

                                    let res = JSON.parse(response);

                                    const stripe    = Stripe('pk_test_51Q9RKwRw3Ybmso9wpcRLu2ULbsFkiPsJi3Y0BOq0SLziPPbupZTOrwSWf5DRkYlQ0IoKuhs5GoyhRlAwoMLLo5Tz00A7VttW7J');
                                    const appearance = {
                                        theme: 'stripe',
                                        locale: 'auto',
                                        display: {
                                            locale: 'auto',
                                            iconStyle: 'solid',
                                            logo: true,
                                            paymentMethods: {
                                                card: {
                                                    name: 'Tarjeta de crédito o débito',
                                                    amount: response.totalFactura
                                                }
                                            }
                                        }
                                    };
                                    const options = {
                                        layout: {
                                            type: 'accordion',
                                            defaultCollapsed: false,
                                            radios: false,
                                            spacedAccordionItems: true
                                        }
                                    };
                                    const clientSecret = res.clientSecret;
                                    const elements = stripe.elements({ clientSecret, appearance });
                                    const cardElement = elements.create('payment', options);
                                    cardElement.mount('#card-element');
                                            
                                    $('#payment-form').on('submit', function(event){
                                        openLoader();
                                        event.preventDefault();

                                        stripe.confirmPayment({
                                            elements,
                                            confirmParams: {
                                                return_url: '<?= url('Pedidos/getResponse') ?>',
                                            }
                                        })
                                        .then( (result) => {

                                            if( result.error ){
                                                $('#payment-result').html(`
                                                    <div class="alert alert-danger" role="alert">
                                                        ${result.error.message}
                                                    </div>
                                                `);
                                            }
                                            else{
 
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: '¡Éxito!',
                                                    text: 'Pago realizado correctamente',
                                                    showConfirmButton: false,
                                                    timer: 3500
                                                });

                                                $('#payment-result').html(`
                                                    <div class="alert alert-success" role="alert">
                                                        Pago realizado correctamente
                                                    </div>
                                                `);
                                                
                                            }

                                            closeLoader();
                                            const paymentIntentId = (result.paymentIntent) ? result.paymentIntent.id : result.error.payment_intent.id;
                                            const status = !result.paymentIntent ? '3' : '4';

                                            confirmPayment(res.pedido_id, status , paymentIntentId);
                                        })
                                    })

                                },
                                error: function (error){
                                    closeLoader();
                                }
                            });

                        },
                        error: function(error){
                            console.log(error);
                        }
                    });

                })

            </script>


            <div class="container">
                <?php require_once '../app/views' . $data["content"] . '.php' ?>
            </div>

            <?php 
                if (isset($_GET["success"])) {
                    $string = $_GET["success"];
                    $string = str_replace("\\", "/", $string);
                    echo '
                        <script>
                            Swal.fire({
                                icon: "success",
                                title: "¡Éxito!",
                                text: "'.htmlspecialchars($string).'",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        </script>
                    ';
                    
                } else if (isset($_GET["error"])) {
                    $string = $_GET["error"];
                    $string = str_replace("\\", "/", $string);

                    echo '
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "¡Error!",
                                text: "'.htmlspecialchars($string).'",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        </script>
                    ';
                } else if (isset($_GET["warning"])) {
                    $string = $_GET["warning"];
                    $string = str_replace("\\", "/", $string);

                    echo '
                        <script>
                            Swal.fire({
                                icon: "warning",
                                title: "¡Atención!",
                                text: "'.htmlspecialchars($string).'",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        </script>
                    ';
                } else if (isset($_GET["info"])) {
                    $string = $_GET["info"];
                    $string = str_replace("\\", "/", $string);

                    echo '
                        <script>
                            Swal.fire({
                                icon: "info",
                                title: "¡Información!",
                                text: "'.htmlspecialchars($string).'",
                                showConfirmButton: false,
                                timer: 3500
                            });
                        </script>
                    ';
                } else if (isset($_GET["pago"])) {
                    $string = $_GET["pago"];
                    $string = str_replace("\\", "/", $string);
                    $string = str_replace("&quot", "", $string);

                    echo '
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                localStorage.removeItem("carrito");
                                document.getElementById("idCarritoElement").innerHTML = "";
                                document.querySelectorAll(".carritoCounter").forEach(el => el.innerHTML = "0");
                                
                                Swal.fire({
                                    icon: "success",
                                    title: "¡Éxito!",
                                    text: "Pago procesado correctamente",
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    confirmButtonText: "Aceptar",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = window.location.href.split("?")[0];
                                    }
                                });

                                

                            });
                        </script>
                    ';
                }
            ?>


        </div>


    </main>

    <footer>
        <div class="footer-div bg-black sticky-bottom d-flex justify-content-center align-items-center p-2">
            <p>Powered by <a class="mi-instagram" href="https://www.instagram.com/koke__pzc/?hl=es">Jorge</a> © All rights reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>