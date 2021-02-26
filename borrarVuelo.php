
<?php

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$coleccion = $cliente->adat_vuelos->vuelos_compra;

$parameters = file_get_contents("php://input");

$arrayInfo = array();

$datosViajero = array();

if (isset($parameters)) {
  $jsonRecibido = json_decode($parameters, true);

    $codigo = $jsonRecibido["codigo"];
	$resultado = $coleccion->deleteOne(['codigo' => $codigo]);

$arrayInfo["estado"] = $resultado;
$arrayInfo["mensaje"] = "Borrado correctamente";
$mensajeJSON = json_encode($arrayInfo, JSON_PRETTY_PRINT);
echo $mensajeJSON;
}else {
  $arrayInfo["estado"] = false;
  $arrayInfo["mensaje"] = "Fallo al insertar el vuelo";
}

?>
