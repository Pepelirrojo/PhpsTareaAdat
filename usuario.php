<?php
require 'vendor/autoload.php';

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
  require 'login.php';
    break;
  case 'POST':
		require 'registro.php';
    break;
	}
?>
