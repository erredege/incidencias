<h1>Iniciar sesion</h1>

<?php
	if (isset($data['msjError'])) {
		echo "<p style='color:red'>".$data['msjError']."</p>";
	}
	if (isset($data['msjInfo'])) {
		echo "<p style='color:blue'>".$data['msjInfo']."</p>";
	}
?>

<form action='index.php'>
	Usuario:<input type='text' name='nombre'><br>
	Clave:<input type='password' name='password'><br>
	<input type='hidden' name='action' value='procesarLogin'>
	<input type='submit'>
</form>
