<?php

$incidencia = $data['incidencia'];
var_dump($incidencia);
echo "<h1>Modificar Libro</h1>";
echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='idIncidencia' value='$incidencia->idIncidencia'>
        Fecha:<input type='text' name='fecha' value='$incidencia->fecha'><br>
        Lugar:<input type='text' name='lugar' value='$incidencia->lugar'><br>
        Equipo:<input type='text' name='equipo' value='$incidencia->equipo'><br>
        Observaciones:<input type='text' name='observaciones' value='$incidencia->observaciones'><br>";
        if($incidencia->tipo == 'admin'){
            echo "Estado:"; if ($incidencia->estado ==  'ABIERTA'){
                        echo "<select name='estado'>
                                <option value='ABIERTA' selected >ABIERTA</option>
                                <option value='EN CURSO'>EN CURSO</option>
                                <option value='CERRADA'>CERRADA</option> 
                            </select><br>";
                    }else if($incidencia->estado ==  'EN CURSO'){
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
        }else if($incidencia->tipo == 'user'){
            echo "Estado:"; if ($incidencia->estado ==  'ABIERTA'){
                        echo "<select name='estado'>
                                <option value='ABIERTA' selected >ABIERTA</option>
                                <option value='EN CURSO'>EN CURSO</option>
                            </select><br>"; 
                    }else{
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