<script>
	// **** Petición y respuesta AJAX con JS tradicional ****
	peticionAjax = new XMLHttpRequest();

	function borrarPorAjax(idIncidencia) {
		idIncidenciaGlobal = idIncidencia;
		peticionAjax.onreadystatechange = borradoIncidenciaCompletado;
		peticionAjax.open("GET", "index.php?action=borrarIncidenciaAjax&idIncidencia=" + idIncidencia, true);
		peticionAjax.send(null);
	}

	function borradoIncidenciaCompletado() {
		if(peticionAjax.readyState == 4) {
			if (peticionAjax.status == 200) {
				idIncidencia = peticionAjax.responseText;
				if (idIncidencia == -1) {
					document.getElementById('msjError').innerHTML = "Ha ocurrido un error al borrar la Incidencia";
				}
				else {
					document.getElementById('msjInfo').innerHTML = "Incidencia borrada con éxito";
					document.getElementById('incidencia' + idIncidencia).remove();
				}
			}
		} 
	}

	// **** Petición y respuesta AJAX con jQuery ****

	$(document).ready(function() {
		$(".btnBorrar").click(function() {
			$.get("index.php?action=borrarIncidenciaAjax&idIncidencia=" + this.idIncidencia, null, function(idIncidenciaBorrada) {
				alert(idIncidenciaBorrada);
				
				if (idIncidenciaBorrada == -1) {
					$('#msjError').html("Ha ocurrido un error al borrar la incidencia");
				}
				else {
					$('#msjInfo').html("Incidencia borrada con éxito");
					$('#incidencia' + idIncidencia).remove();
				}
			});
		});
	});
</script>


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
		echo "<p style='color:red' id='msjError'>".$data['msjError']."</p>";
	} else {
		echo "<p style='color:red' id='msjError'></p>";
	}

	if (isset($data['msjInfo'])) {
		echo "<p style='color:blue' id='msjInfo'>".$data['msjInfo']."</p>";
	} else {
		echo "<p style='color:blue' id='msjInfo'></p>";
	}
	
	// Primero, el formulario de busqueda
	if ($_SESSION['tipo'] ==  "admin"){
		echo "<form action='index.php'>
				<input type='hidden' name='action' value='buscarIncidencias'>
				BUSCAR POR:
				<input type='text' name='textoBusqueda' placeholder='descripción, id o nombre del usuario, estado, fecha, lugar o equipo' size='55'>
				<input type='submit' value='Buscar'>
			</form><br>";
	}

	if (isset($_SESSION["idUsuario"])) {
		echo "<form action = 'index.php' method = 'get'>
			Ordenar por: 
			<select name='tipoBusqueda'>
				<option value='fecha'>fecha</option>
				<option value='lugar'>lugar</option>
				<option value='equipo'>equipo</option>
				<option value='idUsuario'>idUsuario</option>
				<option value='nombre'>nombre</option>
				<option value='observaciones'>observaciones</option>
				<option value='estado'>estado</option>
				<option value='descripcion'>descripcion</option>
			</select>
			<input type='hidden' name='action' value='tipoBusqueda'>
			<input type='submit' value='Ordenar'>";
	}

	if (count($data['listaIncidencias']) > 0) {

		// Ahora, la tabla con los datos de las incidencias
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
				echo "<tr id='incidencia".$incidencias->idIncidencia."'>";
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
							echo "<td><a href='#' onclick='borrarPorAjax(".$incidencias->idIncidencia.")'>Borrar por Ajax/JS</a></td>";
							echo "<td><a href='#' class='btnBorrar' idIncidencia='".$incidencias->idIncidencia."'>Borrar por Ajax/jQuery</a></td>";
						}
					}
				echo "</tr>";
			}
		}else if($_SESSION["tipo"] == "user"){
			foreach($data['listaIncidencias'] as $incidencias) {
				if($incidencias->idUsuario == $_SESSION["idUsuario"]){
					echo "<tr id='incidencia".$incidencias->idIncidencia."'>";
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
								echo "<td><a href='#' onclick='borrarPorAjax(".$incidencias->idIncidencia.")'>Borrar por Ajax/JS</a></td>";
								echo "<td><a href='#' class='btnBorrar' idIncidencia='".$incidencias->idIncidencia."'>Borrar por Ajax/jQuery</a></td>";
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

	// Enlace a "Iniciar sesion" o "Cerrar sesion"
	if (isset($_SESSION["idUsuario"])) {
		echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesion</a></p>";
	}
	else {
		echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesion</a></p>";
	}