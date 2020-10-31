<?php
			// Comprobamos si hay una sesi�n iniciada o no
				echo "<h1>Alta de incidencia</h1>";

				// Creamos el formulario con los campos del libro
				echo "<form action = 'index.php' method = 'get'>
						Fecha:<input type='date' name='fecha'><br>
						Lugar:<input type='text' name='lugar'><br>
						Equipo:<input type='text' name='equipo'><br>
						Observaciones:<input type='text' name='observaciones'><br>";
						echo "Estado: <select name='estado'>
							<option value='abierta' selected>ABIERTA</option>
							<option value='encurso'>EN CURSO</option>
							<option value='cerrada'>CERRADA</option> 
						</select><br>
						Descripcion:<input type='text' name='descripcion'><br>";

				// Finalizamos el formulario
				echo "  <input type='hidden' name='action' value='insertarIncidencia'>
						<input type='submit'>
					</form>";
				echo "<p><a href='index.php?action=mostrarListaIncidencias'>Volver</a></p>";