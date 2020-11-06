<?php
    class Usuario {
        private $db;
        public function __construct() {
            $this->db = new mysqli("localhost", "root", "", "incidencias");
            //$this->db = new mysqli("localhost", "rosen", "Rosen123*", "incidencias_rosendo");
        }

        public function buscarUsuario($nombre,$password) {

            if ($result = $this->db->query("SELECT idUsuario, nombre, tipo  FROM usuarios WHERE nombre = '$nombre' AND password = '$password'")) {
                if ($result->num_rows == 1) {
                    $usuario = $result->fetch_object();
                    // Iniciamos la sesion
                    $_SESSION["idUsuario"] = $usuario->idUsuario;
                    $_SESSION["nombre"] = $usuario->nombre;
                    $_SESSION["tipo"] = $usuario->tipo;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        public function get($idUsuario) {
            
            if ($result = $this->db->query("SELECT * FROM usuarios WHERE usuarios.idUsuario = '$idUsuario'")) {
                $result = $result->fetch_object();
            } else {
                $result = null;
            }
            return $result;
        }

        public function getAll() {
            $arrayResult = array();
            if ($result = $this->db->query("SELECT * FROM usuarios")) {
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
            if ($result = $this->db->query("SELECT * FROM usuarios ORDER BY usuarios.$tipoBusqueda")) {
                while ($fila = $result->fetch_object()) {
                    $arrayResult[] = $fila;
                }
            } else {
                $arrayResult = null;
            }
            return $arrayResult;
        }

        public function insert($nombre, $apellidos, $password, $tipo) {
            $this->db->query("INSERT INTO usuarios (nombre,apellidos,password,tipo) 
                        VALUES ('$nombre', '$apellidos', '$password', '$tipo')");        
            return $this->db->affected_rows;
        }

        public function update($idUsuario, $nombre, $apellidos, $password, $tipo) {
            $this->db->query("UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', password = '$password', tipo = '$tipo' WHERE idUsuario = '$idUsuario'");
            return $this->db->affected_rows;
        }

        public function delete($idUsuario) {
            $this->db->query("DELETE FROM usuarios WHERE idUsuario = '$idUsuario'");
            return $this->db->affected_rows;
        }

        public function getLastId() {
            $result = $this->db->query("SELECT MAX(idUsuario) AS ultimoIdUsuario FROM usuarios");
            $idUsuario = $result->fetch_object()->ultimoIdUsuario;
            return $idUsuario;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            if ($result = $this->db->query("SELECT * FROM usuarios
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
    }
