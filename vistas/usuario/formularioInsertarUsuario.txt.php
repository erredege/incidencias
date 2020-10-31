<?php
	// Comprobamos si hay una sesion iniciada o no
		echo "<h1>Alta usuario</h1>";

		// Creamos el formulario con los campos del libro
		echo "<form action = 'index.php' method = 'get'>
				Nombre:<input type='text' name='nombre'><br>
				Apellidos:<input type='text' name='apellidos'><br>
				Clave:<input type='password' name='password'><br>
				Tipo:<br><select name='tipo' multiple size='2'>
							 <option value='0'>Usuario</option>
							 <option value='1'>Admin</option>
					     </select><br><br>";

		// Finalizamos el formulario
		echo "  <input type='hidden' name='action' value='insertarUsuario'>
				<input type='submit'>
			</form>";
		echo "<p><a href='index.php'>Volver</a></p>";