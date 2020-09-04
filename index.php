<?php

	// Permitir acceso a la api desde dominios diferentes al de la api rest
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
	header("Access-Control-Allow-Headers: X-Requested-With");
	header('Content-Type: text/html; charset=utf-8');

    require 'libs/database.php';
    require 'libs/model.php';
    require 'libs/controller.php';
    require 'libs/view.php';
    require 'libs/app.php';

    require 'config/config.php';
    
    $app = new App();

 ?>