<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://localhost:27017");

$colección = $cliente->adat_vuelos->vuelos_compra;
	$usuario = $_GET["user"];
$busqueda = array();
$contador = 0;
$arrayVuelos = array();
$arrayInfo = array();
$arrayDatos = array();
$filtrado = false;
if (isset($_GET["user"])) {

		$query = array('vendidos.user' => $usuario);
		$resultado = $colección->find($query);
}

if (isset($resultado) && $resultado) {
    foreach ($resultado as $entry) {

			$arrayDatos = $entry["vendidos"];

			foreach ($arrayDatos as $value) {
				$vuelo = array();
				if (isset($value["user"])) {
				if ($value["user"] == $usuario) {
					$contador++;
					$vuelo["codigo"] = $entry["codigo"];
					$vuelo["asiento"] = $value["asiento"];
					$vuelo["nombre"] = $value["nombre"];
					$vuelo["apellido"] = $value["apellido"];
					$vuelo["dniPagador"] = $value["dniPagador"];
					$vuelo["tarjeta"] = $value["tarjeta"];
					$vuelo["codigoVenta"] = $value["codigoVenta"];
					$vuelo["dni"] = $value["dni"];
					$arrayVuelos[] = $vuelo;
				}
			}
			}
    }
    $arrayInfo["estado"] = true;
    $arrayInfo["encontrados"]= $contador;

    if ($contador != 0) {
      if ($filtrado) {
        $arrayInfo["busqueda"] = $busqueda;
      }

    $arrayInfo["vuelos"] = $arrayVuelos;

    }
  } else {
  $arrayInfo["estado"] = false;
  $arrayInfo["mensaje"] = "No se ha podido realizar la consulta";

}

$mensajeJSON = json_encode($arrayInfo, JSON_PRETTY_PRINT);
echo $mensajeJSON;


?>
