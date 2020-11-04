<?php
	
	echo "<p><a href='index.php?action=mostrarListaIncidencias'><h1>Registro de Incidencias</h1></a></p>";
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

	// Enlace a "Iniciar sesion" o "Cerrar sesion"
	if (isset($_SESSION["idUsuario"])) {
		echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesion</a></p>";
	}
	else {
		echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesion</a></p>";
	}
	//echo var_dump($data);
	// Primero, el formulario de busqueda
	if ($_SESSION['tipo'] ==  "admin"){
		echo "<form action='index.php'>
				<input type='hidden' name='action' value='buscarLibros'>
				BUSCAR POR:
				<input type='text' name='textoBusqueda' placeholder='descripción, id o nombre del usuario, estado, fecha, lugar o equipo' size='55'>
				<input type='submit' value='Buscar'>
			</form><br>";
	}

	if (count($data['listaIncidencias']) > 0) {

		// Ahora, la tabla con los datos de los libros
		echo "<table border ='1'>";
			echo "<tr>";
				echo "<td>Fecha</td>";
				echo "<td>Lugar</td>";
				echo "<td>Equipo</td>";
				echo "<td colspan='2'>Usuario</td>";
				echo "<td>Observacion</td>";
				echo "<td>Estado</td>";
				echo "<td>Descripcion</td>";
				if (isset($_SESSION["idUsuario"])){
					echo "<td colspan='2'>Opciones</td>";
				}
			echo "</tr>";
		if($_SESSION["tipo"] == "admin"){
			foreach($data['listaIncidencias'] as $incidencias) {
				echo "<tr>";
					echo "<td>".$incidencias->fecha."</td>";
					echo "<td>".$incidencias->lugar."</td>";
					echo "<td>".$incidencias->equipo."</td>";
					echo "<td>".$incidencias->idUsuario."</td>";
					echo "<td>".$incidencias->nombre."</td>";
					echo "<td>".$incidencias->observaciones."</td>";
					echo "<td>".$incidencias->estado."</td>";
					echo "<td>".$incidencias->descripcion."</td>";
					if (isset($_SESSION["idUsuario"])){
						echo "<td><a href='index.php?action=formularioModificarIncidencia&idIncidencia=".$incidencias->idIncidencia."'>Modificar</a></td>";
						if($_SESSION["tipo"] == 'admin'){
							echo "<td><a href='index.php?action=borrarIncidencia&idIncidencia=".$incidencias->idIncidencia."'>Borrar</a></td>";
						}
					}
				echo "</tr>";
			}
		}else if($_SESSION["tipo"] == "user"){
			foreach($data['listaIncidencias'] as $incidencias) {
				if($incidencias->idUsuario == $_SESSION["idUsuario"]){
					echo "<tr>";
						echo "<td>".$incidencias->fecha."</td>";
						echo "<td>".$incidencias->lugar."</td>";
						echo "<td>".$incidencias->equipo."</td>";
						echo "<td>".$incidencias->idUsuario."</td>";
						echo "<td>".$incidencias->nombre."</td>";
						echo "<td>".$incidencias->observaciones."</td>";
						echo "<td>".$incidencias->estado."</td>";
						echo "<td>".$incidencias->descripcion."</td>";
						if (isset($_SESSION["idUsuario"])){
							echo "<td><a href='index.php?action=formularioModificarIncidencia&idIncidencia=".$incidencias->idIncidencia."'>Modificar</a></td>";
							if($_SESSION["tipo"] == 'admin'){
								echo "<td><a href='index.php?action=borrarIncidencia&idIncidencia=".$incidencias->idIncidencia."'>Borrar</a></td>";
							}
						}
					echo "</tr>";
				}
			}
		}
		echo "</table>";
	} 
	else {
		// La consulta no contiene registros
		echo "No se encontraron datos";
	}
	// El bot�n "Nuevo libro" solo se muestra si hay una sesi�n iniciada
	if (isset($_SESSION["idUsuario"])) {
		echo "<p><a href='index.php?action=formularioInsertarIncidencia'>Nuevo</a></p>";
	}