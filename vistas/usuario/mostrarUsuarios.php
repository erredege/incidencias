<?php

	if($_SESSION['tipo'] ==  "admin"){
		echo "<p><h1>Registro de <a href='index.php?action=mostrarListaIncidencias'>Incidencias</a> y 
		<a href='index.php?action=mostrarUsuarios'>Usuarios</a> IES Celia Viñas</h1></p>";
	}else{
		echo "<p><a href='index.php?action=mostrarListaIncidencias'><h1>Registro de Incidencias IES Celia Viñas</h1></a></p>";
	}
	// Mostramos info del usuario logueado (si hay alguno)
	if (isset($_SESSION['idUsuario'])) {
		echo "<p>Sesion iniciada como, ".$_SESSION['nombre']."</p>";
	}
	// Mostramos mensaje de error o de informaci�n (si hay alguno)
	if (isset($data['msjError'])) {
		echo "<p style='color:red'>".$data['msjError']."</p>";
	}
	if (isset($data['msjInfo'])) {
		echo "<p style='color:blue'>".$data['msjInfo']."</p>";
	}
	
	// Primero, el formulario de busqueda
	if ($_SESSION['tipo'] ==  "admin"){
		echo "<form action='index.php'>
				<input type='hidden' name='action' value='buscarUsuarios'>
				BUSCAR POR:
				<input type='text' name='textoBusqueda' placeholder='id, nombre, apellidos o tipo de usuario' size='30'>
				<input type='submit' value='Buscar'>
			</form><br>";
	}

	// El bot�n "Nuevo libro" solo se muestra si hay una sesi�n iniciada
	if (isset($_SESSION["idUsuario"])) {
		echo "<p><a href='index.php?action=formularioInsertarUsuario'>Nuevo</a></p>";
	}

	if (count($data['listaUsuarios']) > 0) {

		// Ahora, la tabla con los datos de los libros
		echo "<table border ='1'>";
			echo "<tr>";
				echo "<td>Nombre</td>";
				echo "<td>Apellidos</td>";
				echo "<td>Tipo</td>";
				if (isset($_SESSION["idUsuario"])){
					echo "<td colspan='2'>Opciones</td>";
				}
            echo "</tr>";
            
			foreach($data['listaUsuarios'] as $usuarios) {
				echo "<tr>";
					echo "<td>".$usuarios->nombre."</td>";
					echo "<td>".$usuarios->apellidos."</td>";
					echo "<td>".$usuarios->tipo."</td>";
					if (isset($_SESSION["idUsuario"])){
						echo "<td><a href='index.php?action=formularioModificarUsuario&idUsuario=".$usuarios->idUsuario."'>Modificar</a></td>";
                        echo "<td><a href='index.php?action=borrarUsuario&idUsuario=".$usuarios->idUsuario."'>Borrar</a></td>";
					}
				echo "</tr>";
			}
		
		echo "</table>";
	} 
	else {
		// La consulta no contiene registros
		echo "No se encontraron datos";
	}

	// Enlace a "Iniciar sesion" o "Cerrar sesion"
	if (isset($_SESSION["idUsuario"])) {
		echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesion</a></p>";
	}
	else {
		echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesion</a></p>";
	}