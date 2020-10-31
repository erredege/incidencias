<?php  
    class Incidencia {
        private $db;
        public function __construct() {
            $this->db = new mysqli("localhost", "root", "", "incidencias");
        }

        // Devuelve un libro a partir de su id, o null en caso de error
        public function get($id) {
            if ($result = $this->db->query("SELECT * FROM incidencias
                                            WHERE incidencias.idIncidencia = '$id'")) {
            $result = $result->fetch_object();
        } else {
            $result = null;
        }
        return $result;
        }

        /*public function getAutores($idLibro) {
            $autoresLibro = $this->db->query("SELECT personas.idPersona FROM libros
                            INNER JOIN escriben ON libros.idLibro = escriben.idLibro
                            INNER JOIN personas ON escriben.idPersona = personas.idPersona
                            WHERE libros.idLibro = '$idLibro'");             // Obtener solo los autores del libro que estamos buscando
            // Vamos a convertir esa lista de autores del libro en un array de ids de personas
            $listaAutoresLibro = array();
            while ($autor = $autoresLibro->fetch_object()) {
                $listaAutoresLibro[] = $autor->idPersona;
            }
            return $listaAutoresLibro;
        }*/

        // Devuelve todos los libros en un array o null en caso de error
        public function getAll() {
            $arrayResult = array();
            if ($result = $this->db->query("SELECT * FROM incidencias ORDER BY incidencias.idIncidencia")) {
                while ($fila = $result->fetch_object()) {
                    $arrayResult[] = $fila;
                }
            } else {
                $arrayResult = null;
            }
            return $arrayResult;
        }

        public function insert($fecha, $lugar, $equipo, $observaciones, $estado, $descripcion) {
            $idUsuario = $_SESSION["idUsuario"];
            $this->db->query("INSERT INTO incidencias (fecha, lugar, equipo, observaciones, estado, descripcion, idUsuario) 
                        VALUES ('$fecha','$lugar', '$equipo', '$observaciones', '$estado', '$descripcion', '$idUsuario')");        
            return $this->db->affected_rows;
        }

        public function update($idIncidencia, $fecha, $lugar, $equipo, $observaciones, $estado, $descripcion) {
            $idUsuario = $_SESSION["idUsuario"];
            $this->db->query("UPDATE incidencias SET fecha = '$fecha', lugar = '$lugar', observaciones = '$observaciones', estado = '$estado', descripcion = '$descripcion', idUsuario = '$idUsuario' WHERE idIncidencia = '$idIncidencia'");
            return $this->db->affected_rows;
        }

/*        public function updateAutores($idLibro, $autores) {
            var_dump($autore);
            $cantidadDeAutores = count($autores);
    
            // Primero borraremos todos los registros del libro actual y luego los insertaremos de nuevo
            $this->db->query("DELETE FROM escriben WHERE idLibro = '$idLibro'");
            
            // Ya podemos insertar todos los autores junto con el libro en "escriben"
            $insertados = 0;
            foreach ($autores as $idAutor) {
                $this->db->query("INSERT INTO escriben(idLibro, idPersona) VALUES('$idLibro', '$idAutor')");
                if ($this->db->affected_rows == 1) $insertados++;
            }
    
            // Si el número de autores insertados en "escriben" es igual al número de elementos del array $autores, todo ha ido bien
            if ($cantidadDeAutores == $insertados) return 1;
            else return 0; 
        }
*/
        public function delete($id) {
            $this->db->query("DELETE FROM incidencias WHERE idIncidencia = '$id'");
            return $this->db->affected_rows;
        }

        public function getLastId() {
            $result = $this->db->query("SELECT MAX(idIncidencia) AS ultimoIdIncidencia FROM incidencias");
            $idIncidencia = $result->fetch_object()->ultimoIdIncidencia;
            return $idIncidencia;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            if ($result = $this->db->query("SELECT * FROM incidencias
                        WHERE incidencias.fecha LIKE '%$textoBusqueda%'
                        OR incidencias.lugar LIKE '%$textoBusqueda%'
                        OR incidencias.equipo LIKE '%$textoBusqueda%'
                        OR incidencias.idUsuario LIKE '%$textoBusqueda%'
                        OR incidencias.estado LIKE '%$textoBusqueda%'
                        OR incidencias.descripcion LIKE '%$textoBusqueda%'
                        ORDER BY incidencias.idIncidencias")) {
                while ($fila = $result->fetch_object()) {
                    $arrayResult[] = $fila;
                }
            } else {
                $arrayResult = null;
            }
            return $arrayResult;
        }

    }