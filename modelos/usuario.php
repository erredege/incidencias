<?php
    class Usuario {
        private $db;
        public function __construct() {
            $this->db = new mysqli("localhost", "root", "", "incidencias");
        }

        public function buscarUsuario($nombre,$password) {

            if ($result = $this->db->query("SELECT idUsuario, nombre FROM usuarios WHERE nombre = '$nombre' AND password = '$password'")) {
                if ($result->num_rows == 1) {
                    $usuario = $result->fetch_object();
                    // Iniciamos la sesion
                    $_SESSION["idUsuario"] = $usuario->idUsuario;
                    $_SESSION["nombre"] = $usuario->nombre;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        public function get($id) {
            $arrayResult = array();
            if ($result = $this->db->query("SELECT * FROM usuarios WHERE usuarios.idUsario = '$id'")) {
                $arrayResult[] = $result->fetch_object();
            } else {
                $arrayResult = null;
            }
            return $arrayResult;
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

        public function insert($nombre, $password) {
            $this->db->query("INSERT INTO usuarios (nombre,password) 
                        VALUES ('$nombre', '$password')");        
            return $this->db->affected_rows;
        }

        public function update() {
        }

        public function delete() {
            $this->db->query("DELETE FROM usuarios WHERE idUsuario = '$id'");
            return $this->db->affected_rows;
        }


    }