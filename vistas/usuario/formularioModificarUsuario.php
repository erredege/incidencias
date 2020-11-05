<?php

$usuario = $data['usuario'];

echo "<h1>Modificar Usuario</h1>";
echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='idUsuario' value='$usuario->idUsuario'>
        Nombre:<input type='text' name='nombre' value='$usuario->nombre'><br>
        Apellidos:<input type='text' name='apellidos' value='$usuario->apellidos'><br>
        Clave:<input type='password' name='password' value='$usuario->password'><br>
        Tipo:"; if ($usuario->tipo ==  'admin'){
                    echo "<select name='tipo'>
                            <option value='admin' selected >admin</option>
                            <option value='user'>user</option>
                            </select><br>";
                }else{
                    echo "<select name='tipo'>
                            <option value='admin'>admin</option>
                            <option value='user' selected >user</option>
                            </select><br>";
                }
    echo "<input type='hidden' name='action' value='modificarUsuario'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarUsuarios'>Volver</a></p>";
?>