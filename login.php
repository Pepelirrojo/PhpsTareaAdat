<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$colección = $cliente->adat_vuelos->usuarios;

$arrMensaje = array();

if(isset($_GET["user"]) && isset($_GET["pwd"])){
    $user = $_GET['user'];
    $pwd = $_GET['pwd'];
  $resultado = $colección->find(['$and' => [ ['user' => $user], ['pwd' => $pwd] ] ]);
  if (isset($resultado) && $resultado)  {
    foreach ($resultado as $entry) {
      $user = array();
      $user['user'] = $entry['user'];
      $user['pwd'] = $entry['pwd'];
      $user['rol'] = $entry['rol'];
    }
  } 
  $mensajeJSON = json_encode($user, JSON_PRETTY_PRINT);
  echo $mensajeJSON;
}
?>
