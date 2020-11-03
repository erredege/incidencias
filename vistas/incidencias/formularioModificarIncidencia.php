<?php

$incidencia = $data['incidencia'];
$usuario = $data2['usuario'];
//$listaAutoresLibro = $data['listaAutoresLibro'];
//$listaTodosLosAutores = $data['listaTodosLosAutores'];

echo "<h1>Modificar Libro</h1>";

echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='idIncidencia' value='$incidencia->idIncidencia'>
        Fecha:<input type='text' name='fecha' value='$incidencia->fecha'><br>
        Lugar:<input type='text' name='lugar' value='$incidencia->lugar'><br>
        Equipo:<input type='text' name='equipo' value='$incidencia->equipo'><br>
        Observaciones:<input type='text' name='observaciones' value='$incidencia->observaciones'><br>";
        if($_SESSION["tipo"] == 'admin'){
            echo "Estado:"; if ($incidencia->estado ==  'abierta'){
                        echo "<select name='estado'>
                                <option value='ABIERTA' selected >ABIERTA</option>
                                <option value='EN CURSO'>EN CURSO</option>
                                <option value='CERRADA'>CERRADA</option> 
                            </select><br>";
                    }else if($incidencia->estado ==  'encurso'){
                        echo "<select name='estado'>
                                <option value='ABIERTA' >ABIERTA</option>
                                <option value='EN CURSO' selected>EN CURSO</option>
                                <option value='CERRADA'>CERRADA</option> 
                        </select><br>";
                    }else{
                        echo "<select name='estado'>
                                <option value='ABIERTA'>ABIERTA</option>
                                <option value='EN CURSO'>EN CURSO</option>
                                <option value='CERRADA' selected>CERRADA</option> 
                            </select><br>";
                    }
        }else if($_SESSION["tipo"] == 'user'){
            echo "Estado:"; if ($incidencia->estado ==  'abierta'){
                echo "<select name='estado'>
                        <option value='ABIERTA' selected >ABIERTA</option>
                        <option value='EN CURSO'>EN CURSO</option>
                    </select><br>";
            }else if($incidencia->estado ==  'encurso'){
                echo "<select name='estado'>
                        <option value='ABIERTA' >ABIERTA</option>
                        <option value='EN CURSO' selected>EN CURSO</option>
                </select><br>";
            }
        }
        echo "Descripcion:<input type='text' name='descripcion' value='$incidencia->descripcion'><br>"; 

    echo "<input type='hidden' name='action' value='modificarIncidencia'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarListaIncidencias'>Volver</a></p>";
?>