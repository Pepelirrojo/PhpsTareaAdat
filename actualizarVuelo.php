<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$coleccion = $cliente->adat_vuelos->vuelos_compra;

$parameters = file_get_contents("php://input");
$arrayMensaje = array();

if (isset($parameters)) {
  $jsonRecibido = json_decode($parameters, true);
  $codigo = $jsonRecibido["codigo"];

if (!$jsonRecibido["origen"] == "") {
  $origen = $jsonRecibido["origen"];
$resultado = updateFun("origen", $origen, $codigo);
}

if (!$jsonRecibido["destino"] == "") {
  $origen = $jsonRecibido["destino"];
$resultado = updateFun("destino", $origen, $codigo);
}

if (!$jsonRecibido["fecha"] == "") {
  $origen = $jsonRecibido["fecha"];
$resultado = updateFun("fecha", $origen, $codigo);
}

if (!$jsonRecibido["hora"] == "") {
  $origen = $jsonRecibido["hora"];
$resultado = updateFun("hora", $origen, $codigo);
}

if (!$jsonRecibido["plazas_totales"] == "") {
  $origen = $jsonRecibido["plazas_totales"];
$resultado = updateFun("plazas_totales", $origen, $codigo);
}

if (!$jsonRecibido["plazas_disponibles"] == "") {
  $origen = $jsonRecibido["plazas_disponibles"];
$resultado = updateFun("plazas_disponibles", $origen, $codigo);
}


if($resultado->getModifiedCount() == 1){
$arrayMensaje['estado'] = true;
}else{
$arrayMensaje['estado'] = false;
$arrayMensaje['mensaje'] = "Los datos introducidos no son correctos";
}

$mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
echo $mensajeJSON;

}


function updateFun($campo, $nuevoRegistro, $codigoVuelo) {
  $cliente = new MongoDB\Client("mongodb://localhost:27017");

  $coleccion = $cliente->adat_vuelos->vuelos_compra;
  $resultado = $coleccion->updateOne(
    array('codigo' => $codigoVuelo ),
		array( '$set' => array(
		            $campo => $nuevoRegistro)
							)
);

    return $resultado;
}


?>
