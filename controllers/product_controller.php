<?php

class ProductController extends Controller {

    function __construct(){
        parent::__construct();
    }

    /*
    * Obtener todos los productos
    */
    function index($params){
        $products = $this->model->get($params);
        if(isset($products) && count($products) > 0){
            header("Content-Type: application/json;charset=utf-8");
            http_response_code(200);
            echo json_encode($products);
        }else{
            http_response_code(204);
        }
    }

    /*
    * Obtener un producto
    */
    function show($id){
        $product = $this->model->find($id);
        if(isset($product)){
            header("Content-Type: application/json;charset=utf-8");
            http_response_code(200);
            echo json_encode($product);
        }else{
            http_response_code(204);
        }
    }

    /*
    * Almacenar un producto
    */
    function store($params){
        // Validations
        $messages = [];
        $withError = false;
        if(!isset($params['name']) || empty($params['name'])){
            $withError = true;
            array_push($messages, "El nombre del producto es requerido.");
        }
        if(!isset($params['reference']) || empty($params['reference'])){
            $withError = true;
            array_push($messages, "La referencia del producto es requerida.");
        }
        if(!isset($params['price'])){
            $withError = true;
            array_push($messages, "El precio del producto es requerido.");
        }
        if(!isset($params['weight'])){
            $withError = true;
            array_push($messages, "El peso del producto es requerido.");
        }
        if(!isset($params['category']) || empty($params['category'])){
            $withError = true;
            array_push($messages, "La categoría del producto es requerida.");
        }
        if(!isset($params['stock'])){
            $withError = true;
            array_push($messages, "El stock del producto es requerido.");
        }
        if(isset($params['price']) && !filter_var($params['price'], FILTER_VALIDATE_INT)) {
            $withError = true;
            array_push($messages, "El campo precio debe ser un entero.");
        }
        if(isset($params['weight']) && !filter_var($params['weight'], FILTER_VALIDATE_INT)) {
            $withError = true;
            array_push($messages, "El campo peso debe ser un entero.");
        }
        if(isset($params['stock']) && !filter_var($params['stock'], FILTER_VALIDATE_INT)) {
            $withError = true;
            array_push($messages, "El stock peso debe ser un entero.");
        }

        // Crear el producto
        if(!$withError){
            $params['created_at'] = (new \DateTime('now'))->format('Y-m-d');
            $created = $this->model->create($params);
            if($created){
                header('Content-type: application/json');
                http_response_code(201);
                array_push($messages, "El producto ha sido creado.");
                echo json_encode($messages);
            }else{
                header('Content-type: application/json');
                http_response_code(409);
                array_push($messages, "Ocurrió un error al intentar crear el producto.");
                echo json_encode($messages);
            }
        }

        if($withError){
            header('Content-type: application/json');
            http_response_code(400);
            echo json_encode($messages);
        }
    }

    /*
    * Modificar un producto
    */
    function update($id, $params){
        // Validations
        $messages = [];
        $withError = false;

        $product = $this->model->find($id);
        if(!isset($product)){
            $withError = true;
            array_push($messages, "Producto no encontrado.");
        }
        if(!isset($params['name']) || empty($params['name'])){
            $withError = true;
            array_push($messages, "El nombre del producto es requerido.");
        }
        if(!isset($params['reference']) || empty($params['reference'])){
            $withError = true;
            array_push($messages, "La referencia del producto es requerida.");
        }
        if(!isset($params['price'])){
            $withError = true;
            array_push($messages, "El precio del producto es requerido.");
        }
        if(!isset($params['weight'])){
            $withError = true;
            array_push($messages, "El peso del producto es requerido.");
        }
        if(!isset($params['category']) || empty($params['category'])){
            $withError = true;
            array_push($messages, "La categoría del producto es requerida.");
        }
        if(!isset($params['stock'])){
            $withError = true;
            array_push($messages, "El stock del producto es requerido.");
        }
        if(isset($params['price']) && !filter_var($params['price'], FILTER_VALIDATE_INT)) {
            $withError = true;
            array_push($messages, "El campo precio debe ser un entero.");
        }
        if(isset($params['weight']) && !filter_var($params['weight'], FILTER_VALIDATE_INT)) {
            $withError = true;
            array_push($messages, "El campo peso debe ser un entero.");
        }
        if(isset($params['stock']) && !filter_var($params['stock'], FILTER_VALIDATE_INT)) {
            $withError = true;
            array_push($messages, "El stock peso debe ser un entero.");
        }

        // Actualizar atributos
        if(array_key_exists("name", $params)) $product->name = $params['name'];
        if(array_key_exists("reference", $params)) $product->reference = $params['reference'];
        if(array_key_exists("price", $params)) $product->price = $params['price'];
        if(array_key_exists("weight", $params)) $product->weight = $params['weight'];
        if(array_key_exists("category", $params)) $product->category = $params['category'];
        if(array_key_exists("stock", $params)) $product->stock = $params['stock'];

        // Modificar el producto
        if(!$withError){
            $updated = $this->model->update($id, (array) $product);
            if($updated){
                header('Content-type: application/json');
                http_response_code(200);
                array_push($messages, "El producto ha sido modificado.");
                echo json_encode($messages);
            }else{
                header('Content-type: application/json');
                http_response_code(409);
                array_push($messages, "Ocurrió un error al intentar modificar el producto.");
                echo json_encode($messages);
            }
        }

        if($withError){
            header('Content-type: application/json');
            http_response_code(400);
            echo json_encode($messages);
        }
    }

    /*
    * Eliminar un producto
    */
    function destroy($id){
        $product = $this->model->find($id);
        if(isset($product)){
            $deleted = $this->model->destroy($id);
            if($deleted){
                http_response_code(200);
            }else{
                http_response_code(409);
            }
        }else{
            // Producto no encontrado
            http_response_code(404);
        }
    }

}

?>