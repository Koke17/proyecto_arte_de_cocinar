<?php

require_once '../core/Controller.php';

class PedidosController extends Controller{

    private $productsModel;
    private $pedidosModel;
    private $PedidosProductoModel;
    private $userModel;
    private $VentaModel;
    private $roleUser = 2;
    private $userDetail;

    public function __construct(){
        $this->productsModel = $this->model('Product');
        $this->pedidosModel = $this->model('Pedido');
        $this->PedidosProductoModel = $this->model('PedidosProduct');
        $this->userModel = $this->model('User');
        $this->VentaModel = $this->model('Venta');
        $this->userDetail = $this->model('UserDetail');

        verifyUserLogged();

        // verificar si el usuario es admin
        if ( isset($_SESSION["user"]) && $_SESSION["user"]->role_id === 1 ) {
            $this->roleUser = 1;
        }

    }

    public function index(){

        if ( $this->roleUser === 1 ) {
            $pedidos = $this->pedidosModel->getAllOrdes(); //Creamos este nuevo modelo para que no aparezccan los pedidos entregados
            foreach ($pedidos as $pedido) {
                $productosPedido = $this->pedidosModel->getByPrudctoPedido($pedido->pedido_id);
                $user = $this->userModel->find($pedido->user_id);
                $userDetail = $this->userDetail->find($pedido->user_id);
                $pedido->Productos = $productosPedido;
                $pedido->user = $user;
                $pedido->userDetail = $userDetail;
            }
        }else{
            $userLogged = $_SESSION['user']->user_id;
            $pedidos = $this->pedidosModel->getByUser($userLogged);
            foreach ($pedidos as $pedido) {
                $productosPedido = $this->pedidosModel->getByPrudctoPedido($pedido->pedido_id);
                $user = $this->userModel->find($pedido->user_id);
                $userDetail = $this->userDetail->find($pedido->user_id);
                $pedido->Productos = $productosPedido;
                $pedido->user = $user;
                $pedido->userDetail = $userDetail;
            }
        }
        
        $data = [
            'pedidos' => $pedidos,
        ];

        $this->view('layouts/main', [
            'content' => '/Pedidos/index',
            'pedidos' => $data,
        ]);
    }

    public function create(){
        try {
            
            $carrito        = $_POST['carrito'];
            $total          = 0;
            $userLogged     = $_SESSION['user']->user_id;
            $fecha_compra   = date('Y-m-d H:i:s');
            $tipo_entrega   = $_POST['tipo_entrega'];

            $stripe = new \Stripe\StripeClient("sk_test_51Q9RKwRw3Ybmso9wLLFw49XlglbieIsQnWUrR0Fi0Welf1WxHfMjIrgaCEzeBg5S2rFdCbqcttTC7ZWmP3YmVz0c008nddrlVH");
            
            foreach ($carrito as $producto) {
                
                // Verificar si el producto es valido
                $productoDB = $this->productsModel->find($producto['product_id']);

                if ( !$productoDB ) {
                    throw new Exception('Ha ocurrido un error al procesar el pedido');
                }

                $price      = doubleval($productoDB->precio_product);
                $quantity   = intval($producto['cantidad']);

                if ( !is_int($quantity) ) {
                    throw new Exception('Ha ocurrido un error al procesar el pedido');
                }

                $total += $price * $quantity;
            }

            $iva = 0.21;

            $totalIva = $total * $iva;
            $totalFactura = $total + $totalIva;

            $pedido = $this->pedidosModel->create($userLogged, $fecha_compra, $totalFactura, $iva, $totalIva, 1, null, $tipo_entrega);

            foreach ($carrito as $producto) {
                // Verificar si el producto es valido
                $productoDB = $this->productsModel->find($producto['product_id']);

                if ( !$productoDB ) {
                    throw new Exception('Ha ocurrido un error al procesar el pedido');
                }

                $price      = doubleval($productoDB->precio_product);
                $quantity   = intval($producto['cantidad']);

                if ( !is_int($quantity) ) {
                    throw new Exception('Ha ocurrido un error al procesar el pedido');
                }

                $this->PedidosProductoModel->create($pedido, $productoDB->product_id, $quantity, $price);
            }

            $amount = $totalFactura * 100;
            
            // validar si el valor tiene decimales
            if ( $amount != round($amount) ) {
                $amount = round($amount);
            }

            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $amount,
                'currency' => 'eur',
                'payment_method_types' => ['card', 'paypal'],
            ]);

            $this->pedidosModel->updateStripeId($pedido, $paymentIntent->id);
            
            echo json_encode([
                'status'        => true,
                'message'       => 'Pedido procesado correctamente',
                'clientSecret'  => $paymentIntent->client_secret,
                'amount'        => $amount,
                'pedido_id'     => $pedido,
            ]);

        }catch (Exception $e){
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
        }
    }

    public function update(){
        try {
            
            $pedido     = $_POST['pedido_id'];
            $estado     = $_POST['status'];
            $stripe_id  = $_POST['stripe_id'];


            $resultado = $this->pedidosModel->updateStatePedido($pedido, $estado, $stripe_id);

            if ( !$resultado ) {
                throw new Exception('Ha ocurrido un error al actualizar el pedido');
            }

            // si el estado == 4, entonces guardamos en la tabla de ventas y restamos el stock
            if ( $estado == 4 ) {
                
                $productosPedido = $this->PedidosProductoModel->getByPedido($pedido);
                
                foreach( $productosPedido as $productoPedido ){
                    $productoDB = $this->productsModel->find($productoPedido->product_id);
                    $stock      = $productoDB->stock - $productoPedido->cantidad;
                    $this->productsModel->updateStock($productoDB->product_id, $stock);
                }

                // Guardar en la tabla de ventas
                $this->VentaModel->create($pedido, 1, 1, date('Y-m-d H:i:s'));
            }else if ( $estado == 3 ){
                $this->VentaModel->create($pedido, 1, 0, date('Y-m-d H:i:s'));
            }

            echo json_encode([
                'status' => true,
                'message' => 'Pedido actualizado correctamente',
            ]);

        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function getResponse(){
        try {
            $paymentIntent      = $_GET['payment_intent'];
            $cliente_secret     = $_GET['payment_intent_client_secret'];
            $redirect_status    = $_GET['redirect_status'];

            // verificar si el pago fue exitoso
            if ( $redirect_status == 'succeeded' ) {

                $pedido     = $this->pedidosModel->getByStripeId($paymentIntent);
                $pedido     = $pedido->pedido_id;
                $estado     = 4;

                $resultado = $this->pedidosModel->updateStatePedido($pedido, $estado, $paymentIntent);

                if ( !$resultado ) {
                    throw new Exception('Ha ocurrido un error al actualizar el pedido');
                }

                // si el estado == 4, entonces guardamos en la tabla de ventas y restamos el stock
                if ( $estado == 4 ) {
                    
                    $productosPedido = $this->PedidosProductoModel->getByPedido($pedido);
                    
                    foreach( $productosPedido as $productoPedido ){
                        $productoDB = $this->productsModel->find($productoPedido->product_id);
                        $stock      = $productoDB->stock - $productoPedido->cantidad;
                        $this->productsModel->updateStock($productoDB->product_id, $stock);
                    }

                    // Guardar en la tabla de ventas
                    $this->VentaModel->create($pedido, 1, 1, date('Y-m-d H:i:s'));
                }

                redirect('Menu?pago="Pago procesado correctamente"');

            }else{
                redirect('Menu?error="Ha ocurrido un error al procesar el pago"');
            }

        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function changeStatusPedido(){ // cambiar estado de preparacion del pedido
        try {
            
            $pedido_id = $_POST['pedido_id'];
            $estado    = $_POST['estado'];

            $pedido = $this->pedidosModel->find($pedido_id);

            if ( !$pedido ) {
                throw new Exception('Ha ocurrido un error al cambiar el estado del pedido');
            }

            // actualizar estado
            $resultado = $this->pedidosModel->updatePrepracion($pedido_id, $estado);

            if ( !$resultado ) {
                throw new Exception('Ha ocurrido un error al cambiar el estado del pedido');
            }

            echo json_encode([
                'status' => true,
                'message' => 'Estado actualizado correctamente',
            ]);

        } catch (\Throwable $th) {
            $message = $th->getMessage();
            throw new Exception("Ha ocurrido un error al cambiar el estado del pedido, $message");
        }

    }

}