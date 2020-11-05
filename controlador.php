<?php
	include_once("vista.php");
	include_once("modelos/usuario.php");
	include_once("modelos/incidencia.php");

	// Creamos los objetos vista y modelos
 
 
    class Controlador {
 
        private $vista, $usuario, $incidencia;

        public function __construct() {
            $this->vista = new Vista();
            $this->usuario = new Usuario();
            $this->incidencia = new Incidencia();
        }

        public function mostrarFormularioLogin() {
			$this->vista->mostrar("usuario/formularioLogin");
        }
 
        public function procesarLogin() {
			$nombre = $_REQUEST["nombre"];
			$password = $_REQUEST["password"];

			$result = $this->usuario->buscarUsuario($nombre, $password);
			
			if ($result) {
				// De momento, dejamos aqu� este echo. Ya lo quitaremos
				echo "<script>location.href='index.php?action=mostrarListaIncidencias'</script>";
			} 
			else {
				// Error al iniciar la sesion
				$data['msjError'] = "Nombre de usuario o contraseña incorrectos";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
        }

		public function cerrarSesion() {
			session_destroy();
			$data['msjInfo'] = "Sesion cerrada correctamente";
			$this->vista->mostrar("usuario/formularioLogin", $data);
        }
			
			// --------------------------------- MOSTRAR LISTA DE INCIDENCIAS ----------------------------------------

        public function mostrarListaIncidencias() {
			$idUsuario = $_SESSION["idUsuario"];
			$data['listaIncidencias'] = $this->incidencia->getAll();
			$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
        }

			// --------------------------------- FORMULARIO INSERTAR INCIDENCIAS ----------------------------------------

        public function formularioInsertarIncidencia() {
			if (isset($_SESSION["idUsuario"])) {
				$this->vista->mostrar('incidencia/formularioInsertarIncidencia');
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
        }
		

			// --------------------------------- INSERTAR INCIDENCIAS ----------------------------------------

        public function insertarIncidencia() {
			
			if (isset($_SESSION["idUsuario"])) {
				// Vamos a procesar el formulario de alta de libros
				// Primero, recuperamos todos los datos del formulario
				$fecha = $_REQUEST["fecha"];
				$lugar = $_REQUEST["lugar"];
				$equipo = $_REQUEST["equipo"];
                $observaciones = $_REQUEST["observaciones"];
                $estado = $_REQUEST["estado"];
				$descripcion = $_REQUEST["descripcion"];
				$result = $this->incidencia->insert($fecha, $lugar, $equipo, $observaciones,  $estado, $descripcion);

				// Lanzamos el INSERT contra la BD.
				if ($result == 1) {
					// Tenemos que averiguar que idUsuario se ha asignado a la incidencia que acabamos de insertar
					$ultimoId = $this->incidencia->getLastId();
					$data['msjInfo'] = "Incidencia insertado con exito";
				} else {
					// Si la insercion de la incidencia ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar la incidencia. Por favor, intentelo mas tarde.";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
				
		}

			// --------------------------------- BORRAR INCIDENCIAS ----------------------------------------

        public function borrarIncidencia() {
			if (isset($_SESSION["idUsuario"])) {
				$idIncidencia = $_REQUEST["idIncidencia"];
				$result = $this->incidencia->delete($idIncidencia);
				if ($result == 0) {
					$data['msjError'] = "Ha ocurrido un error al borrar esa incidencia. Por favor, intentelo de nuevo";
				} else {
					$data['msjInfo'] = "Incidencia borrada con exito";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}

		}

		// --------------------------------- FORMULARIO MODIFICAR INCIDENCIAS ----------------------------------------

		public function formularioModificarIncidencia() {
			if (isset($_SESSION["idUsuario"])) {

				$idUsuario = $_SESSION["idUsuario"];
				$idIncidencia = $_REQUEST["idIncidencia"];
				$data['incidencia'] = $this->incidencia->get($idIncidencia);
				$this->vista->mostrar('incidencia/formularioModificarIncidencia', $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
			}
		}

		// --------------------------------- MODIFICAR INCIDENCIAS ----------------------------------------

		public function modificarIncidencia() {

			if (isset($_SESSION["idUsuario"])) {

				// Vamos a procesar el formulario de modificaci�n de libros
				// Primero, recuperamos todos los datos del formulario
				$idIncidencia = $_REQUEST["idIncidencia"];
				$fecha = $_REQUEST["fecha"];
				$lugar = $_REQUEST["lugar"];
				$equipo = $_REQUEST["equipo"];
				$observaciones = $_REQUEST["observaciones"];
				$estado = $_REQUEST["estado"];
				$descripcion = $_REQUEST["descripcion"];

				//lanzamos la consulta pa la bd
				$result = $this->incidencia->update($idIncidencia, $fecha, $lugar, $equipo, $observaciones, $estado, $descripcion);
				
				if ($result == 1) {
				// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
					$data['msjInfo'] = "Incidencia actualizada con éxito";
				}else {
					$data['msjError'] = "Error al actualizar la incidencia";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
		}

		// --------------------------------- BUSCAR INCIDENCIAS ----------------------------------------

        public function buscarIncidencias() {
			// Recuperamos el texto de b�squeda de la variable de formulario
			// Recuperamos el texto de búsqueda de la variable de formulario
			$textoBusqueda = $_REQUEST["textoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de libros
			$data['listaIncidencias'] = $this->incidencia->busquedaAproximada($textoBusqueda);
			$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
			$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
		}

		//---------------------------------MOSTRAR LISTA USUARIOS ------------------------------------

		public function mostrarUsuarios() {
			$data['listaUsuarios'] = $this->usuario->getAll();
			$this->vista->mostrar("usuario/mostrarUsuarios", $data);
        }


		// --------------------------------- INSERTAR USUARIO ----------------------------------------

		 public function formularioInsertarUsuario() {
			if (isset($_SESSION["idUsuario"])) {
				$this->vista->mostrar('usuario/formularioInsertarUsuario');
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
        }
		

			// --------------------------------- INSERTAR INCIDENCIAS ----------------------------------------

        public function insertarUsuario() {
			
			if (isset($_SESSION["idUsuario"])) {
				// Vamos a procesar el formulario de alta de libros
				// Primero, recuperamos todos los datos del formulario
				$nombre = $_REQUEST["nombre"];
				$apellidos = $_REQUEST["apellidos"];
				$password = $_REQUEST["password"];
				$tipo = $_REQUEST["tipo"];
				$result = $this->usuario->insert($nombre, $apellidos, $password, $tipo);

				// Lanzamos el INSERT contra la BD.
				if ($result == 1) {
					// Tenemos que averiguar que idusuario se ha asignado al usuario que acabamos de insertar
					$ultimoId = $this->usuario->getLastId();
					$data['msjInfo'] = "Usuario insertado con exito";
				} else {
					// Si la insercion del usuario ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar el usuario. Por favor, intentelo mas tarde.";
				}
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
				
		}

		//---------------------------------- BORRAR USUARIO ---------------------------------

		public function borrarUsuario() {
			if (isset($_SESSION["idUsuario"])) {
				$idUsuario = $_REQUEST["idUsuario"];
				$result = $this->usuario->delete($idUsuario);
				if ($result == 0) {
					$data['msjError'] = "Ha ocurrido un error al borrar ese usuario. Por favor, intentelo de nuevo";
				} else {
					$data['msjInfo'] = "Usuario borrado con exito";
				}
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}

		}

		// --------------------------------- FORMULARIO MODIFICAR USUARIOS ----------------------------------------

		public function formularioModificarUsuario() {
			if (isset($_SESSION["idUsuario"])) {

				$idUsuario = $_REQUEST["idUsuario"];
				$data['usuario'] = $this->usuario->get($idUsuario);
				$this->vista->mostrar('usuario/formularioModificarUsuario', $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			}
		}

		// --------------------------------- MODIFICAR INCIDENCIAS ----------------------------------------

		public function modificarUsuario() {

			if (isset($_SESSION["idUsuario"])) {

				// Vamos a procesar el formulario de modificaci�n de libros
				// Primero, recuperamos todos los datos del formulario
				$idUsuario = $_REQUEST["idUsuario"];
				$nombre = $_REQUEST["nombre"];
				$apellidos = $_REQUEST["apellidos"];
				$password = $_REQUEST["password"];
				$tipo = $_REQUEST["tipo"];

				//lanzamos la consulta pa la bd
				$result = $this->usuario->update($idUsuario, $nombre, $apellidos, $password, $tipo);
				
				if ($result == 1) {
				// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
					$data['msjInfo'] = "Usuario actualizado con éxito";
				}else {
					$data['msjError'] = "Error al actualizar el usuario";
				}
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
		}

		// --------------------------------- BUSCAR USUARIOS ----------------------------------------

        public function buscarUsuarios() {
			// Recuperamos el texto de b�squeda de la variable de formulario
			// Recuperamos el texto de búsqueda de la variable de formulario
			$textoBusqueda = $_REQUEST["textoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de libros
			$data['listaUsuarios'] = $this->usuario->busquedaAproximada($textoBusqueda);
			$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
			$this->vista->mostrar("usuario/mostrarUsuarios", $data);
		}
    }
