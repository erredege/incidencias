<?php

$incidencia = $data['incidencia'];
//$listaAutoresLibro = $data['listaAutoresLibro'];
//$listaTodosLosAutores = $data['listaTodosLosAutores'];

echo "<h1>Modificar Libro</h1>";

echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='idIncidencia' value='$incidencia->idIncidencia'>
        Fecha:<input type='text' name='fecha' value='$incidencia->fecha'><br>
        Lugar:<input type='text' name='lugar' value='$incidencia->lugar'><br>
        Equipo:<input type='text' name='equipo' value='$incidencia->equipo'><br>
        Observaciones:<input type='text' name='observaciones' value='$incidencia->observaciones'><br>
        Estado:"; if ($incidencia->estado ==  'abierta'){
                    echo "<select name='estado'>
							<option value='abierta' selected >ABIERTA</option>
							<option value='encurso'>EN CURSO</option>
							<option value='cerrada'>CERRADA</option> 
                        </select><br>";
                }else if($incidencia->estado ==  'encurso'){
                    echo "<select name='estado'>
							<option value='abierta' >ABIERTA</option>
							<option value='encurso' selected>EN CURSO</option>
							<option value='cerrada'>CERRADA</option> 
                    </select><br>";
                }else{
                    echo "<select name='estado'>
							<option value='abierta'>ABIERTA</option>
							<option value='encurso'>EN CURSO</option>
							<option value='cerrada' selected>CERRADA</option> 
                        </select><br>";
                }
        echo "Descripcion:<input type='text' name='descripcion' value='$incidencia->descripcion'><br>"; 

    echo "<input type='hidden' name='action' value='modificarIncidencia'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarListaIncidencias'>Volver</a></p>";
?>