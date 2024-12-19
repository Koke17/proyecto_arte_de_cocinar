<?php

require_once '../core/Controller.php';

class VentasController extends Controller{
    
    private $pedidos;
    private $ventas;

    private $pedidosModel;
    private $userModel;
    private $userDetail;


    public function __construct()
    {
        verifyAdmin();

        $this->pedidos = $this->model('Pedido');
        $this->ventas = $this->model('Venta');

        $this->pedidosModel = $this->model('Pedido');
        $this->userModel = $this->model('User');
        $this->userDetail = $this->model('UserDetail');
    }


    public function index(){

        $ventas = $this->ventas->getAll();


        foreach ($ventas as $venta) {

            //Como hemos quitado los inner joins del modelo porque salian varios pedidos con el mismo stripe_id tenemos que para cada venta obtener los datos(productos y usuarios)

            $productosPedido    = $this->pedidosModel->getByPrudctoPedido($venta->pedido_id);
            $user               = $this->userModel->find($venta->user_id);
            $userDetail         = $this->userDetail->find($venta->user_id);

            $venta->Productos   = $productosPedido; //Asignamos los valores con el correspondiente indice
            $venta->user        = $user;
            $venta->userDetail  = $userDetail;

            $this->view('layouts/main', [
                'content' => '/ventas/index',
                'ventas' => $ventas
            ]);
        }

    }

    public function generateFactura(){
        try {
            // Configuración de Stripe
            $stripe = new \Stripe\StripeClient("sk_test_51Q9RKwRw3Ybmso9wLLFw49XlglbieIsQnWUrR0Fi0Welf1WxHfMjIrgaCEzeBg5S2rFdCbqcttTC7ZWmP3YmVz0c008nddrlVH");
        
            // Obtener ID del intento de pago (Payment Intent)
            $pedido_id = $_GET['id'];
            $paymentIntent = $stripe->paymentIntents->retrieve($pedido_id);
            $customerId = $paymentIntent->customer;
        
            // Obtener datos del pedido
            $pedido = $this->pedidos->getByStripeId($pedido_id);
        
            // Crear cliente si no existe
            if (!$customerId) {
                $userPedido = $this->userModel->find($pedido->user_id);
        
                $customerData = [
                    "name" => $userPedido->name_user,
                    "email" => $userPedido->email_user,
                    "description" => "Cliente de Arte de cocinar",
                ];
        
                $customer = $stripe->customers->create($customerData);
        
                // Asociar el cliente al Payment Intent
                $stripe->paymentIntents->update($pedido_id, [
                    'customer' => $customer->id,
                ]);
        
                $customerId = $customer->id;
            }
        
            // Obtener productos del pedido
            $productosPedido = $this->pedidosModel->getByPrudctoPedido($pedido->pedido_id);
        
            // Crear elementos de línea (Invoice Items)
            foreach ($productosPedido as $producto) {
                $stripe->invoiceItems->create([
                    'customer' => $customerId,
                    'amount' => intval($producto->precio_product * 100), // Convertir a centavos
                    'currency' => 'eur',
                    'description' => $producto->name_product,
                ]);
            }
        
            // Crear la factura
            $invoice = $stripe->invoices->create([
                'customer' => $customerId,
            ]);
            // Finalizar la factura
            $finalizedInvoice = $stripe->invoices->finalizeInvoice($invoice->id);
            // Obtener la URL del PDF
            $invoicePdfUrl = $finalizedInvoice->invoice_pdf;


            //Descargar el PDF y guardarlo localmente
            $pdfContent = file_get_contents($invoicePdfUrl);
            $filePath = public_url("invoices/{$invoice->id}.pdf");
            if (!file_exists(public_url('invoices'))) {
                mkdir(public_url('invoices'), 0777, true);
            }
            file_put_contents($filePath, $pdfContent);
            

            // dd($filePath);
        
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo "Error de Stripe: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}


?>