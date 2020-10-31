<!-- BIBLIOTECA VERSIoN 3
     Caracteristicas de esta version:
       - Codigo con arquitectura MVC
       - Con seguridad
       - Con sesiones y control de acceso
       - Sin reutilizacion de codigo
-->

<?php

	//iniciamos sesion
	session_start();
	
	// Creamos los objetos vista y modelos
	include_once("controlador.php");
	$controlador = new Controlador();
	
	if (isset($_REQUEST["action"])) {
		$action = $_REQUEST["action"];
	} else {
		$action = "mostrarFormularioLogin";  // Accion por defecto
	}

	$controlador->$action();