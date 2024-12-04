<?php
    $products = $data['products'];
?>

<div class="container">

    <div class="row">
        <div class="col-md-12">

            <!-- Validar si el array de productos viene con datos sino mostrar un warning sin registros -->

            <?php if (count($products) > 0) : ?>

                <h1 class="text-center">Menu</h1>

                <div class="row d-flex justify-content-start flex-wrap gap-5">
                    <?php foreach ($products as $product) : ?>
                        <div class="col-md-4">
                            <div class="card p-2 m-2" style="width: 18rem;">
                                <img src="<?= $product->product_image ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product->name_product ?></h5>
                                    <p class="card-text"><?= $product->descripcion_product ?></p>
                                    <p class="card-text"><?= $product->precio_product ?>€</p>
                                    <p class="card-text"><?= $product->stock ?> unidades</p>
                                    <button 
                                        data-id="<?= $product->product_id ?>"
                                        class="btn btn-primary addCarritoBtn"
                                        <?php if ($product->stock <= 0) : ?>
                                            disabled
                                        <?php endif; ?>
                                    >
                                        Comprar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>
                    
                <div class="alert alert-warning" role="alert">
                    No hay productos registrados
                </div>

            <?php endif; ?>

        </div>
    </div>

</div>

<script>

    const carritoContainer = document.getElementById('carrito');
    const products         = <?= json_encode($products) ?>;
    const addButton        = document.querySelectorAll('.addCarritoBtn');
    const vaciarCarritoBtn = document.getElementById('boton-vaciar');
    const totalCarrito     = document.getElementById('total-carrito');
    // const carritoCounterShow = document.querySelectorAll('.carritoCounterShow');
    const carritoCounter   = document.querySelectorAll('.carritoCounter');
    
    const actualizarContadorCarrito = () => {
        carritoCounter.forEach( (contador) => {
            contador.innerText = carrito.length;
        });
    }
  
    addButton.forEach((boton) => {
        boton.addEventListener('click', () => {
            const idProducto = boton.getAttribute('data-id');

            const product = products.find( product => product.product_id == idProducto );
            addProduct( product );
        });
    });

    vaciarCarritoBtn.addEventListener('click', () => {
        vaciarCarrito();
    })

    let carrito = [];
    // funciones

    const renderCarrito = () => {

        carritoContainer.innerHTML = '';

        carrito.forEach( product => {

            const div       = document.createElement('div');
            const name      = document.createElement('p');
            const image     = document.createElement('img');
            const p         = document.createElement('p');
            const precio    = document.createElement('p');
            const cantidad  = document.createElement('span');

            div.classList.add(
                'card', 
                'p-2', 
                'm-2', 
                'd-flex', 
                'justify-content-between', 
                'align-items-center',
                'flex-wrap',
                'gap-2',
                'flex-row'
            );

            // Botones
            const divButtons = document.createElement('div');
            const btnAdd    = document.createElement('button');
            const btnRemove = document.createElement('button');
            const btnRest   = document.createElement('button');
            const btnDomicilio = document.createElement('select');

            name.innerText      = product.name_product;
            image.src           = product.product_image;
            
            image.classList.add('img-fluid');
            image.style.width   = '100px';
            image.style.height  = '100px';

            const valorProduct = product.precio_product * product.cantidad;

            p.innerText         = product.descripcion_product;
            precio.innerText    = valorProduct+'€';
            cantidad.innerText  = `Cantidad: ${product.cantidad}`;
            cantidad.classList.add('badge', 'bg-primary', 'rounded-pill', 'text-bg-primary');

            divButtons.classList.add('d-flex', 'gap-2', 'flex-wrap');
            btnAdd.innerHTML        = '<ion-icon name="add-outline"></ion-icon>'
            btnRemove.innerHTML     = '<ion-icon name="trash-outline"></ion-icon>'
            btnRest.innerHTML       = '<ion-icon name="remove-outline"></ion-icon>'

            btnAdd.classList.add('btn', 'btn-outline-primary', 'addCarritoBtn');
            btnAdd.setAttribute('data-id', product.product_id);

            btnRemove.classList.add('btn', 'btn-outline-danger', 'removeProductBtn');
            btnRemove.setAttribute('data-id', product.product_id);

            btnRest.classList.add('btn', 'btn-outline-warning', 'restProductBtn');
            btnRest.setAttribute('data-id', product.product_id);

            divButtons.appendChild( btnAdd );
            divButtons.appendChild( btnRemove );
            divButtons.appendChild( btnRest );
            
            div.appendChild( name );
            div.appendChild( image );
            div.appendChild( p );
            div.appendChild( precio );
            div.appendChild( cantidad );
            div.appendChild( divButtons );

            carritoContainer.appendChild( div );
        });

        const addCarritoBtn     = carritoContainer.querySelectorAll('.addCarritoBtn');
        const removeProductBtn  = carritoContainer.querySelectorAll('.removeProductBtn');
        const restProductBtn    = carritoContainer.querySelectorAll('.restProductBtn');

        addCarritoBtn.forEach( btn => {
            btn.addEventListener('click', () => {
                const idProduct = btn.getAttribute('data-id');
                const product = products.find( product => product.product_id == idProduct );
                addProduct( product );
            });
        });

        removeProductBtn.forEach( btn => {
            btn.addEventListener('click', () => {
                const idProduct = btn.getAttribute('data-id');
                const product = carrito.find( product => product.product_id == idProduct );
                removeProduct( product );
                totalCarrito.innerText = getTotalCarrito();
                renderCarrito();
            });
        });

        restProductBtn.forEach( btn => {
            btn.addEventListener('click', () => {
                const idProduct = btn.getAttribute('data-id');
                const product = carrito.find( product => product.product_id == idProduct );
                if ( product.cantidad > 1 ) {
                    product.cantidad--;
                    updateCantidad( product, product.cantidad );
                    totalCarrito.innerText = getTotalCarrito();
                    UpdateCarritoLocalStorage();
                    renderCarrito();
                }else{
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'No puedes tener menos de 1 producto en el carrito',
                    })
                }
            });
        });

    }

    // Verificar si hay productos en el carrito
    const verifyCarrito = () => {
        const carritoStorage = localStorage.getItem('carrito');
        if (carritoStorage) {
            carrito = JSON.parse(carritoStorage);
            renderCarrito();
            totalCarrito.innerText = getTotalCarrito();
            actualizarContadorCarrito();
        }
    };

    // verificar si el producto ya esta en el carrito
    const verifyProduct = ( product ) => {
        const productExist = carrito.find( p => p.product_id == product.product_id );
        return productExist;
    }

    // Obtener el total del carrito
    const getTotalCarrito = () => {
        let total = 0;
        carrito.forEach((producto) => {
            total += producto.precio_product * producto.cantidad;
        })
        return total;
    }

    // cargar el carrito del localstorage
    verifyCarrito();

    const UpdateCarritoLocalStorage = () => {
        localStorage.setItem('carrito', JSON.stringify(carrito));
    };

    const addProduct = (product) => {
        // Verificar si el producto ya existe en el carrito
        const index = carrito.findIndex(p => p.product_id === product.product_id);

        // VERIFICAR SI EL PRODUCTO TIENE STOCK
        if ( product.stock <= 0 ) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'No hay stock disponible',
            })
            return;
        }

        if (index !== -1) {
            // Si el producto existe, aumentar la cantidad
            carrito[index].cantidad++;

            actualizarContadorCarrito();
        } else {
            // Si el producto no existe, agregarlo al carrito con cantidad 1
            product.cantidad = 1;
            carrito.push(product);
            actualizarContadorCarrito();
        }

        // Actualizar el contador del carrito y el localStorage
        UpdateCarritoLocalStorage();
        totalCarrito.innerText = getTotalCarrito();
        renderCarrito();
    };

    const updateCantidad = (product, cantidad) => {
        // Buscar el índice del producto en el carrito
        const index = carrito.findIndex(p => p.product_id === product.product_id);
        if (index !== -1) {
            carrito[index].cantidad = cantidad;
            UpdateCarritoLocalStorage();  // Guardar los cambios en localStorage
            renderCarrito();              // Renderizar el carrito actualizado
            actualizarContadorCarrito();
        }
    };

    const vaciarCarrito = () => {
        carrito = [];
        totalCarrito.innerText = '0';

        actualizarContadorCarrito();

        UpdateCarritoLocalStorage();
        renderCarrito();
    }

    const removeProduct = (product) => {
        // Buscar el índice del producto en el carrito
        const index = carrito.findIndex(p => p.product_id === product.product_id);
        if (index !== -1) {
            carrito.splice(index, 1); // Eliminar el producto del carrito
            UpdateCarritoLocalStorage(); // Guardar los cambios en localStorage
            renderCarrito();             // Renderizar el carrito actualizado
            actualizarContadorCarrito();
        }
    };

</script>