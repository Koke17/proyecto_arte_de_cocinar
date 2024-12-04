
<?php

// los modelos deben de llevar la conexion a bd;

class Productos {

    public function getAllProducts(){
        return [
            [
                'titulo' => 'Producto 1',
                'contenido' => 'Nike Air Max 90',
            ],
            [
                'titulo' => 'Producto 2',
                'contenido' => 'Adidas Superstar',
            ],
            [
                'titulo' => 'Producto 3',
                'contenido' => 'Vans Old Skool',
            ],
        ];
    }

}