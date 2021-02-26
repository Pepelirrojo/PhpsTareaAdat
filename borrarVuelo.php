<?php

function borrarVuelo($conn){
	$arrEsperado = array(
    "peticion" => "delete",
    "vuelos" => array(
    	"id" => "10"
    )
    );

function JSONCorrectoAnnadir($recibido){
    $aux = false;
    if(isset($recibido["peticion"]) && $recibido["peticion"]=="delete" ){

        if(isset($recibido["vuelos"])){

            $auxVuelo = $recibido["vuelos"];

            if(isset($auxVuelo["id"])){
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

		$query  = "DELETE FROM vuelos WHERE ID = $id";

		$result = $conn->query ( $query );

		if (isset ( $result ) && $result) {

			$arrMensaje["estado"] = "ok";
			$arrMensaje["mensaje"] = "Vuelo BORRADO correctamente";
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
