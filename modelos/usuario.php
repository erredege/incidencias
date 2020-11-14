<?php
     include_once("DB.php");

    class Usuario {
        private $db;

        public function __construct() {
            $this->db = new DB;
        }

        public function buscarUsuario($nombre,$password) {

            $result = $this->db->consulta("SELECT idUsuario, nombre, tipo  FROM usuarios WHERE nombre = '$nombre' AND password = '$password'")
            
            if ($usuario) {
                return $usuario;
            } else {
                return null;
            }

        }

        public function get($idUsuario) {
            
            $result = $this->db->consulta("SELECT * FROM usuarios WHERE usuarios.idUsuario = '$idUsuario'")
           
            return $result;

        }

        public function getAll() {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM usuarios")
            
            return $result;

        }

        public function getOrder($tipoBusqueda) {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM usuarios ORDER BY usuarios.$tipoBusqueda")
            
            return $result;
        }

        public function insert($nombre, $apellidos, $password, $tipo) {

            $nombre = $_REQUEST["nombre"];
            $apellidos = $_REQUEST["apellidos"];
            $password = $_REQUEST["password"];
            $tipo = $_REQUEST["tipo"];

            $result = $this->db->manipulacion("INSERT INTO usuarios (nombre,apellidos,password,tipo) 
                        VALUES ('$nombre', '$apellidos', '$password', '$tipo')");        
            
            return $result;
        }

        public function update($idUsuario, $nombre, $apellidos, $password, $tipo) {
            $result = $this->db->manipulacion("UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', password = '$password', tipo = '$tipo' WHERE idUsuario = '$idUsuario'");
            return $result;
        }

        public function delete($idUsuario) {
            $result = $this->db->manipulacion("DELETE FROM usuarios WHERE idUsuario = '$idUsuario'");
            return $result;
        }

        public function getLastId() {
            $result = $this->db->consulta("SELECT MAX(idUsuario) AS ultimoIdUsuario FROM usuarios");
            $idUsuario = $result->ultimoIdUsuario;
            return $idUsuario;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            if ($result = $this->db->consulta("SELECT * FROM usuarios
                        WHERE usuarios.idUsuario LIKE '%$textoBusqueda%'
                        OR usuarios.nombre LIKE '%$textoBusqueda%'
                        OR usuarios.apellidos LIKE '%$textoBusqueda%'
                        OR usuarios.tipo LIKE '%$textoBusqueda%'
                        ORDER BY usuarios.idUsuario")) {
                while ($fila = $result->fetch_object()) {
                    $arrayResult[] = $fila;
                }
            } else {
                $arrayResult = null;
            }
            return $arrayResult;
        }

        public function existeNombre($nombre) {
            $result = $this->db->consulta("SELECT * FROM usuarios WHERE nombre = '$nombre'");
            if ($result != null)
                return 1;
            else  
                return 0;

        }
    }
