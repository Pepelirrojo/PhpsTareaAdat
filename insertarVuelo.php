<?php

function escribirVuelo($conn){
	$arrEsperado = array(
    "peticion" => "add",
    "vuelos" => array(
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

    if(isset($recibido["peticion"]) && $recibido["peticion"]=="add" ){

        if(isset($recibido["vuelos"])){

            $auxVuelo = $recibido["vuelos"];

            if(isset($auxVuelo["Codigo_Vuelo"])
                && isset($auxVuelo["Origen"])
                && isset($auxVuelo["Destino"])
            	&& isset($auxVuelo["Fecha"])
            	&& isset($auxVuelo["Hora"])
            	&& isset($auxVuelo["Plazas_Totales"])
            	&& isset($auxVuelo["Plazas_Disponibles"]) ){
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

		$Codigo_Vuelo = $vuelo["Codigo_Vuelo"];
		$Origen = $vuelo["Origen"];
		$Destino = $vuelo["Destino"];
		$Fecha = $vuelo["Fecha"];
		$Hora = $vuelo["Hora"];
		$Plazas_Totales = $vuelo["Plazas_Totales"];
		$Plazas_Disponibles = $vuelo["Plazas_Disponibles"];

		$query  = "INSERT INTO  vuelos (CODIGO_VUELO, ORIGEN, DESTINO, FECHA, HORA, PLAZAS_TOTALES, PLAZAS_DISPONIBLES) ";
		$query .= "VALUES ('$Codigo_Vuelo','$Origen','$Destino','$Fecha','$Hora','$Plazas_Totales','$Plazas_Disponibles')";

		$result = $conn->query ( $query );

		if (isset ( $result ) && $result) {

			$arrMensaje["estado"] = "ok";
			$arrMensaje["mensaje"] = "Vuelo insertado correctamente";
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
