<?php

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$colección = $cliente->adat_vuelos->vuelos_compra;

$parameters = file_get_contents("php://input");

$arrayInfo = array();

$datosViajero = array();

if (isset($parameters)) {
  $jsonRecibido = json_decode($parameters, true);

  $codigo = $jsonRecibido["codigo"];
  $origen = $jsonRecibido["origen"];
  $destino = $jsonRecibido["destino"];
	$fecha = $jsonRecibido["fecha"];
	$hora = $jsonRecibido["hora"];
	$plazasTotales = $jsonRecibido["plazas_totales"];
	$plazasDisponibles = $jsonRecibido["plazas_disponibles"];
  $precio = $jsonRecibido["precio"];


  $buscarVuelo = $colección->insertOne(['codigo' => $codigo, 'origen' => $origen,
	'destino' => $destino, 'fecha' => $fecha, 'hora' => $hora,
	'plazas_totales' => $plazasTotales, 'plazas_disponibles' => $plazasDisponibles, 'precio' => $precio]);

$arrayInfo["estado"] = true;
$arrayInfo["mensaje"] = "Insertado correctamente";
$mensajeJSON = json_encode($arrayInfo, JSON_PRETTY_PRINT);
echo $mensajeJSON;
}else {
  $arrayInfo["estado"] = false;
  $arrayInfo["mensaje"] = "Fallo al insertar el vuelo";
}

?>
