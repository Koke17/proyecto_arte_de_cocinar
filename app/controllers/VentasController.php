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

            // Crear la factura
            $invoice = $stripe->invoices->create([
                'customer' => $customerId,
            ]);
        
            // Crear elementos de línea (Invoice Items)
            foreach ($productosPedido as $producto) {

                $existingProduct = $stripe->products->search([
                    'query' => "name:\"{$producto->name_product}\" AND metadata[\"pedido_id\"]:\"$pedido->pedido_id\"",
                ]);

                //En caso de que no existe el producto en stripe, que nos lo genere
                if ( count($existingProduct["data"]) > 0 ) {
                    $productoStripe = $existingProduct["data"];
                } else {
                    $productoStripe = $stripe->products->create([
                        'name' => $producto->name_product,
                        'description' => $producto->descripcion_product,
                        'tax_code' => 'txcd_99999999',
                        'metadata' => [
                            'name' => $producto->name_product,
                            'pedido_id' => $pedido->pedido_id,
                        ],
                        'images' => [$producto->product_image],
                        'default_price_data' => [
                            'currency' => 'eur',
                            'unit_amount' => intval($producto->precio_product * 100),
                        ],
                    ]);
                }
            }

            $product = $stripe->products->search([
                'query' => "active:\"true\" AND metadata[\"pedido_id\"]:\"$pedido->pedido_id\"",
            ]);

            //Tenemos que hacerlo ademas de para las facturas(invioces), Stripe tambien necesita un id de cada producto con su precio y todo, es por eso que realizamos otro bucle
            foreach ($product["data"] as $productoStripe) {

                // verificar si el precio ya existe
                $existePrecio = $stripe->prices->search([
                    'query' => "active:\"true\" AND metadata[\"pedido_id\"]:\"$pedido->pedido_id\"",
                ]);
                
                $productInBd = $this->pedidosModel->getProductByName($productoStripe->description); //Comprobamos si ese producto existe en nuestra bb.dd

                if ( count($existePrecio["data"]) > 0 ) {
                    $price = $existePrecio["data"][0];
                }else{
                    $price = $stripe->prices->create([
                        'currency' => 'eur',
                        'unit_amount' => intval($productInBd->precio_product * 100),
                        'product' => $productoStripe->id,
                        'metadata' => [
                            'pedido_id' => $pedido->pedido_id,
                        ],
                    ]);
                }


                $stripe->invoiceItems->create([
                    'customer'      => $customerId,
                    'currency'      => 'eur',
                    'description'   => $productoStripe->description,
                    'price'         => $price->id,
                    'invoice'       => $invoice->id,
                ]);
            }

            // Finalizamos la factura
            $finalizedInvoice = $stripe->invoices->finalizeInvoice($invoice->id);

            // Obtener la URL del PDF
            $invoicePdfUrl = $finalizedInvoice->invoice_pdf;

            // Consultar con curl, tenemos que realizarlos con cURL, porque Stripe genera una URL externa
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $invoicePdfUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Permitir redirecciones si es necesario
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignorar errores SSL si es necesario (opcional)
            $pdfContent = curl_exec($ch);

            // Manejo de errores en la consulta cURL
            if ($pdfContent === false) {
                $error = curl_error($ch);
                curl_close($ch);
                die("Error al descargar el PDF: $error");
            }

            curl_close($ch);

            // Obtenemos el ID de la venta
            $ventaID = $this->ventas->getByPedidoId($pedido->pedido_id)->venta_id;

            // Definimos la ruta donde se almacenará el archivo
            $directoryPath = "../public/assets/invoices/$ventaID";
            $filePath = "$directoryPath/{$invoice->id}.pdf";

            // Crear el directorio si no existe
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }

            // Guardar el contenido del PDF en el archivo, recuerda que file_put_contents(), necesita la ruta entera, es por eso que le hemos pasado el directorio completo anteriormente, ya que Stripe genera una ruta externa
            file_put_contents($filePath, $pdfContent);

            // Descargar el archivo
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $invoice->id . '.pdf"');
            readfile($filePath);


            redirect('/Ventas');

            exit;

        
        
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo "Error de Stripe: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}


?>