<?php

class App {

    function __construct(){
        $url = isset($_GET['url']) ? $_GET['url']: null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        // Solo se permiten urls del estilo: {host}/{recurso} y {host}/{recurso}/{id}
        if(count($url) > 2){
            http_response_code(405);
        }

        // Cuando se ingresa sin definir controlador
        if(empty($url[0])){
            $date = new \DateTime('now');
            http_response_code(200);
            echo "RESTful API | Status: OK | " . $date->format('D M d, Y G:i');
            return false;
        }

        $fileController = 'controllers/' . $url[0] . '_controller.php';
        if(file_exists($fileController)){
            require_once $fileController;

            // Instanciar el controlador
            $controllerName = $url[0] . 'Controller';
            $controller = new $controllerName;

            // Cargar el modelo
            $controller->loadModel($url[0]);

            // Obtener los parametros de la petición
            $json = file_get_contents('php://input');
            $inputs = null;
            if(isset($json)){
                $inputs = (array) json_decode($json);
            }
             
            // Establecer el metodo de acceso
            switch($_SERVER['REQUEST_METHOD'])
            {
                case 'GET':
                    if(isset($url[1])){
                        $controller->show($url[1]);
                    }else{
                        $controller->index($inputs);
                    }

                    break;
                case 'POST':
                    $controller->store($inputs);
                    break;
                case 'PUT':
                    if(isset($url[1])){
                        $controller->update($url[1], $inputs);
                    }else{
                        // No existe el recurso requerido
                        http_response_code(405);
                    }

                    break;
                case 'DELETE':
                    if(isset($url[1])){
                        $controller->destroy($url[1]);
                    }else{
                        // No existe el recurso requerido
                        http_response_code(405);
                    }

                    break;
                default:
            }
        }else{
            // No existe el recurso requerido
            http_response_code(405);
        }
    }
}

?>