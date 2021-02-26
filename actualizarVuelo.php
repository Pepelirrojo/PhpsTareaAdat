<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$colección = $cliente->adat_vuelos->vuelos_compra;

$parameters = file_get_contents("php://input");
$arrayMensaje = array();
if (isset($parameters)) {
  $jsonRecibido = json_decode($parameters, true);
  $codigo = $jsonRecibido["codigo"];
  $campo = $jsonRecibido["campo"];
	$nuevoRegistro = $jsonRecibido["nuevoRegistro"];
	$resultado =  $colección->updateOne(
    array('codigo' => $codigo ),
		array( '$set' => array(
		            $campo => $nuevoRegistro)
							)
);
if($resultado->getModifiedCount() == 1){
$arrayMensaje['estado'] = true;
}else{
$arrayMensaje['estado'] = false;
$arrayMensaje['mensaje'] = "Los datos introducidos no son correctos";
}

$mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
echo $mensajeJSON;

}



?>
