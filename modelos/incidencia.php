<?php  
    class Incidencia {
        private $db;
        public function __construct() {
            $this->db = new mysqli("localhost", "root", "", "incidencias");
            //$this->db = new mysqli("localhost", "rosen", "Rosen123*", "incidencias_rosendo");
        }

        // Devuelve un libro a partir de su id, o null en caso de error
        public function get($idIncidencia) {
            
        if ($result = $this->db->query("SELECT * FROM incidencias WHERE incidencias.idIncidencia = '$idIncidencia'")) {
            $result = $result->fetch_object();
        } else {
            $result = null;
        }
        return $result;
        }

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

        public function getOrder($tipoBusqueda) {
            $arrayResult = array();
            if ($result = $this->db->query("SELECT * FROM incidencias ORDER BY incidencias.$tipoBusqueda")) {
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
            $nombre = $_SESSION["nombre"];
            $tipo = $_SESSION["tipo"];
            $this->db->query("INSERT INTO incidencias (fecha, lugar, equipo, observaciones, estado, descripcion, idUsuario, nombre, tipo) 
                        VALUES ('$fecha','$lugar', '$equipo', '$observaciones', '$estado', '$descripcion', '$idUsuario', '$nombre', '$tipo')");        
            return $this->db->affected_rows;
        }

        public function update($idIncidencia, $fecha, $lugar, $equipo, $observaciones, $estado, $descripcion) {
            $idUsuario = $_SESSION["idUsuario"];
            $nombre = $_SESSION["nombre"];
            $tipo = $_SESSION["tipo"];
            $this->db->query("UPDATE incidencias SET fecha = '$fecha', lugar = '$lugar', equipo = '$equipo', observaciones = '$observaciones', estado = '$estado', descripcion = '$descripcion', idUsuario = '$idUsuario', nombre = '$nombre', tipo = '$tipo' WHERE idIncidencia = '$idIncidencia'");
            return $this->db->affected_rows;
        }

        public function delete($idIncidencia) {
            $this->db->query("DELETE FROM incidencias WHERE idIncidencia = '$idIncidencia'");
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
                        OR incidencias.nombre LIKE '%$textoBusqueda%'
                        OR incidencias.estado LIKE '%$textoBusqueda%'
                        OR incidencias.descripcion LIKE '%$textoBusqueda%'
                        ORDER BY incidencias.fecha")) {
                while ($fila = $result->fetch_object()) {
                    $arrayResult[] = $fila;
                }
            } else {
                $arrayResult = null;
            }
            return $arrayResult;
        }

    }