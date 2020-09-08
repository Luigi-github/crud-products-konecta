<?php

require 'models/product_model.php';

class InvoiceController extends Controller {

    function __construct(){
        parent::__construct();
    }

    function loadModel($model){
        $this->model = new ProductModel();
    }

    /*
    * Facturar un producto
    */
    function store($params){
        // Validations
        $messages = [];
        $withError = false;
        $product = null;
        if(!isset($params['product_id'])){
            $withError = true;
            array_push($messages, "El producto es requerido.");
        }else{
            $product = $this->model->find($params['product_id']);
            if(!isset($product)){
                $withError = true;
                array_push($messages, "El producto no esta registrado.");
            }else if(isset($product) && $product->stock == 0){
                $withError = true;
                array_push($messages, "No se ha realizado la venta, debido a que el producto no presenta stock.");
            }
        }

        // Crear la venta
        if(!$withError){
            $product->stock -= 1;
            $product->last_selled_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
            $updated = $this->model->update($product->id, (array) $product);
            if($updated){
                header('Content-type: application/json');
                http_response_code(200);
                array_push($messages, "La venta del producto se ha realizado.");
                echo json_encode($messages);
            }else{
                header('Content-type: application/json');
                http_response_code(409);
                array_push($messages, "Ocurrió un error al intentar realizar la venta.");
                echo json_encode($messages);
            }
        }

        if($withError){
            header('Content-type: application/json');
            http_response_code(400);
            echo json_encode($messages);
        }
    }

}

?>