<?php
require 'vendor/autoload.php';

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		require 'verVuelos.php';

		break;
	case 'POST':
		require 'insertarVuelo.php';

		break;
	case 'DELETE':
		require 'borrarVuelo.php';

		break;
	case 'PUT':
		require 'actualizarVuelo.php';

		break;
	default:
		break;
}
?>
