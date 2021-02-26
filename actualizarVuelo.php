<?php

function actualizarVuelo($conn){
	$arrEsperado = array(
    "peticion" => "update",
    "vuelos" => array(
    	"id" => "10",
			"Codigo_Vuelo" => "12345",
			"Origen" => "Premia",
			"Destino" => "Barcelona",
			"Fecha" => "2020-10-10",
			"Hora" => "20:10:10",
			"Plazas_Totales" => "80",
			"Plazas_Disponibles" => "20"
    )
    );

function JSONCorrectoAnnadir($recibido){

    $aux = false;

    if(isset($recibido["peticion"]) && $recibido["peticion"]=="update" ){

        if(isset($recibido["vuelos"])){

            $auxVuelo = $recibido["vuelos"];

            if(isset($auxVuelo["id"])
            	|| isset($auxVuelo["Codigo_Vuelo"])
              || isset($auxVuelo["Origen"])
              || isset($auxVuelo["Destino"])
            	|| isset($auxVuelo["Fecha"])
            	|| isset($auxVuelo["Hora"])
            	|| isset($auxVuelo["Plazas_Totales"])
            	|| isset($auxVuelo["Plazas_Disponibles"]) ){
                    $aux = true;
                }
        }

    }

    return $aux;
}

$arrMensaje = array();

$parameters = file_get_contents("php://input");


if(isset($parameters)){

    $mensajeRecibido = json_decode($parameters, true);

	if(JSONCorrectoAnnadir($mensajeRecibido)){

		$vuelo = $mensajeRecibido["vuelos"];

		$id = $vuelo["id"];

		if(isset($vuelo["codigo_vuelo"]) && $vuelo["codigo_vuelo"] !== ""){
			$Codigo_Vuelo = $vuelo["codigo_vuelo"];
			$query  = "UPDATE vuelos SET CODIGO_VUELO = '$Codigo_Vuelo'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
				}
		if(isset($vuelo["origen"]) && $vuelo["origen"] !== ""){
			$Origen = $vuelo["origen"];
			$query  = "UPDATE vuelos SET ORIGEN = '$Origen'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
				}
		if(isset($vuelo["destino"]) && $vuelo["destino"] !== ""){
			$Destino = $vuelo["destino"];
			$query  = "UPDATE vuelos SET DESTINO = '$Destino'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
				}
		if(isset($vuelo["fecha"]) && $vuelo["fecha"] !== ""){
			$Fecha = $vuelo["fecha"];
			$query  = "UPDATE vuelos SET FECHA = '$Fecha'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
				}
		if(isset($vuelo["hora"]) && $vuelo["hora"] !== ""){
			$Hora = $vuelo["hora"];
			$query  = "UPDATE vuelos SET HORA = '$Hora'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
				}
		if(isset($vuelo["plazas_totales"]) && $vuelo["plazas_totales"] !== ""){
			$Plazas_Totales = $vuelo["plazas_totales"];
			$query  = "UPDATE vuelos SET PLAZAS_TOTALES = '$Plazas_Totales'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
			  }
		if(isset($vuelo["plazas_disponibles"]) && $vuelo["plazas_disponibles"] !== ""){
			$Plazas_Disponibles = $vuelo["plazas_disponibles"];
			$query  = "UPDATE vuelos SET PLAZAS_DISPONIBLES = '$Plazas_Disponibles'";
			$query .= "WHERE ID = $id";
			$result = $conn->query ( $query );
				}



		if (isset ( $result ) && $result) {

			$arrMensaje["estado"] = "ok";
			$arrMensaje["mensaje"] = "Vuelo ACTUALIZADO correctamente";
			$lastId = $conn->insert_id;
			$arrMensaje["lastId"] = $lastId;

		}else{

			$arrMensaje["estado"] = "error";
			$arrMensaje["mensaje"] = "SE HA PRODUCIDO UN ERROR AL ACCEDER A LA BASE DE DATOS";
			$arrMensaje["error"] = $conn->error;
			$arrMensaje["query"] = $query;

		}


	}else{

		$arrMensaje["estado"] = "error";
		$arrMensaje["mensaje"] = "EL JSON NO CONTIENE LOS CAMPOS ESPERADOS";
		$arrMensaje["recibido"] = $mensajeRecibido;
		$arrMensaje["esperado"] = $arrEsperado;
	}

}else{

	$arrMensaje["estado"] = "error";
	$arrMensaje["mensaje"] = "EL JSON NO SE HA ENVIADO CORRECTAMENTE";

}
$mensajeJSON = json_encode($arrMensaje,JSON_PRETTY_PRINT);
echo $mensajeJSON;

}

?>
