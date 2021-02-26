<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$colección = $cliente->adat_vuelos->usuarios;

$parameters = file_get_contents("php://input");
$arrayMensaje = array();
if (isset($parameters)) {
  $jsonRecibido = json_decode($parameters, true);
  $usuario = $jsonRecibido["user"];
  $contraseña = $jsonRecibido["pwd"];

  $doc = array(
    'user' => $usuario,
    'pwd' => $contraseña,
    'rol' => 0
  );
$resultado = $colección->insertOne($doc);
if ($resultado) {
  $arrayMensaje["estado"] = "Registro Correcto";
} else {
    $arrayMensaje["estado"] = "Registro Correcto";
}
$mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
echo $mensajeJSON;
}
?>
