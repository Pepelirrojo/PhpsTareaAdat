<?php
require 'vendor/autoload.php';

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		require 'verVuelos.php';
		break;
	case 'POST':
		require 'comprarVuelos.php';
		break;
	case 'DELETE':
		require 'cancelarVuelo.php';
		break;
	case 'PUT':
		require 'actualizarCompra.php';
		break;
	default:
		break;
}
?>
