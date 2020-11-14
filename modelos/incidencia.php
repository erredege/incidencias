<?php  
     include_once("DB.php");
     
    class Incidencia {
        private $db;

        public function __construct() {
            $this->db = new DB;
            //$this->db = new mysqli("localhost", "rosen", "Rosen123*", "incidencias_rosendo");
        }

        // Devuelve un libro a partir de su id, o null en caso de error
        public function get($idIncidencia) {
            
            $result = $this->db->consulta("SELECT * FROM incidencias WHERE incidencias.idIncidencia = '$idIncidencia'")
                
            return $result;
        }

        // Devuelve todos los libros en un array o null en caso de error
        public function getAll() {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM incidencias ORDER BY incidencias.idIncidencia")
               
            return $result;
        }

        public function getOrder($tipoBusqueda) {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM incidencias ORDER BY incidencias.$tipoBusqueda")

            return $arrayResult;
        }

        public function insert($fecha, $lugar, $equipo, $observaciones, $estado, $descripcion) {
            $idUsuario = $_SESSION["idUsuario"];
            $nombre = $_SESSION["nombre"];
            $tipo = $_SESSION["tipo"];
            $fecha = $_REQUEST["fecha"];
            $lugar = $_REQUEST["lugar"];
            $equipo = $_REQUEST["equipo"];
            $observaciones = $_REQUEST["observaciones"];
            $estado = $_REQUEST["estado"];
            $descripcion = $_REQUEST["descripcion"];

            $result = $this->db->manipulacion("INSERT INTO incidencias (fecha, lugar, equipo, observaciones, estado, descripcion, idUsuario, nombre, tipo) 
                        VALUES ('$fecha','$lugar', '$equipo', '$observaciones', '$estado', '$descripcion', '$idUsuario', '$nombre', '$tipo')");        
            return $result;
        }

        public function update($idIncidencia, $fecha, $lugar, $equipo, $observaciones, $estado, $descripcion) {
            $idUsuario = $_SESSION["idUsuario"];
            $nombre = $_SESSION["nombre"];
            $tipo = $_SESSION["tipo"];

            $result = $this->db->manipulacion("UPDATE incidencias SET fecha = '$fecha', lugar = '$lugar', equipo = '$equipo', observaciones = '$observaciones', estado = '$estado', descripcion = '$descripcion', idUsuario = '$idUsuario', nombre = '$nombre', tipo = '$tipo' WHERE idIncidencia = '$idIncidencia'");
            
            return $result;
        }

        public function delete($idIncidencia) {
            $result = $this->db->manipulacion("DELETE FROM incidencias WHERE idIncidencia = '$idIncidencia'");
            return $result;
        }

        public function getLastId() {
            $result = $this->db->consulta("SELECT MAX(idIncidencia) AS ultimoIdIncidencia FROM incidencias");
            $idIncidencia = $result->ultimoIdIncidencia;
            return $idIncidencia;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            if ($result = $this->db->consulta("SELECT * FROM incidencias
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