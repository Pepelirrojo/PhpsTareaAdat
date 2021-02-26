<?php
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$colección = $cliente->adat_vuelos->vuelos_compra;

$parameters = file_get_contents("php://input");

$asientos = array();

$arrayInfo = array();

if (isset($parameters)) {

$jsonRecibido = json_decode($parameters, true);

$codigoVuelo = $jsonRecibido['codigo'];
$dniViajero = $jsonRecibido['dni'];
$codigoVenta = $jsonRecibido['codigoVenta'];

$resultados = $colección->updateOne(
array("codigo" => $codigoVuelo),
array( '$pull' =>
    array(
        "vendidos" => array(
            "dni" => $dniViajero,
            "codigoVenta" => $codigoVenta
        )
    )
)
);

  if($resultados->getModifiedCount() == 1){
  $arrayInfo['estado'] = true;
}else{
  $arrayInfo['estado'] = false;
  $arrayInfo['mensaje'] = "Los datos introducidos no son correctos";
}

$mensajeJSON = json_encode($arrayInfo, JSON_PRETTY_PRINT);
echo $mensajeJSON;
}

 ?>
