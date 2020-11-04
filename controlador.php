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
			
			// --------------------------------- MOSTRAR LISTA DE LIBROS ----------------------------------------

        public function mostrarListaIncidencias() {
			$idUsuario = $_SESSION["idUsuario"];
			$data['listaIncidencias'] = $this->incidencia->getAll();
			$data['tipoUser'] = $this->usuario->getTipo($idUsuario);
			$this->vista->mostrar("incidencias/mostrarListaIncidencias", $data);
        }

			// --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

        public function formularioInsertarIncidencia() {
			if (isset($_SESSION["idUsuario"])) {
				// Primero, accedemos al modelo de usuarios para obtener la lista de usuarios
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar('incidencias/formularioInsertarIncidencia', $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
        }
		

			// --------------------------------- INSERTAR LIBROS ----------------------------------------

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
					// Si la insercion del libro ha funcionado, continuamos insertando en la tabla "escriben"
					// Tenemos que averiguar que idLibro se ha asignado al libro que acabamos de insertar
					$ultimoId = $this->incidencia->getLastId();
					// Ya podemos insertar todos los autores junto con el libro en "escriben"
					$data['msjInfo'] = "Usuario insertado con exito";
				} else {
					// Si la insercion del libro ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar el usuario. Por favor, intentelo mas tarde.";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencias/mostrarListaIncidencias", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
				
		}

		// --------------------------------- INSERTAR AUTOR ----------------------------------------
/*
		public function formularioInsertarAutor() {
			if (isset($_SESSION["idUsuario"])) {
				// Primero, accedemos al modelo de personas para obtener la lista de autores
				$data['listaAutores'] = $this->persona->getAll();
				$this->vista->mostrar('persona/formularioInsertarAutor', $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
        }
		
		public function insertarAutor() {
			
			if (isset($_SESSION["idUsuario"])) {
				// Vamos a procesar el formulario de alta de libros
				// Primero, recuperamos todos los datos del formulario
				$nombre = $_REQUEST["nombre"];
				$apellidos = $_REQUEST["apellidos"];
				$result = $this->persona->insert($nombre, $apellidos);

				// Lanzamos el INSERT contra la BD.
				if ($result == 1) {
					// Si la insercion del libro ha funcionado, continuamos insertando en la tabla "escriben"
					// Tenemos que averiguar que idLibro se ha asignado al libro que acabamos de insertar
					$insert = $this->persona->getLastId();
					// Ya podemos insertar todos los autores junto con el libro en "escriben"
					$data['msjInfo'] = "persona insertada con exito";
				} else {
					// Si la insercion del libro ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar persona. Por favor, intentelo mas tarde.";
				}
				$data['listaPersona'] = $this->persona->getAll();
				$this->vista->mostrar("libro/mostrarFormularioModificar", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
				
		}
*/
			// --------------------------------- BORRAR LIBROS ----------------------------------------

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
				$this->vista->mostrar("incidencias/mostrarListaIncidencias", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}

		}

		// --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

		public function formularioModificarIncidencia() {
			if (isset($_SESSION["idUsuario"])) {

				$idUsuario = $_SESSION["idUsuario"];
				$idIncidencia = $_REQUEST["idIncidencia"];
				$data['incidencia'] = $this->incidencia->get($idIncidencia);
				$data['usuario'] = $this->usuario->get($idUsuario);
				//$data['listaAutoresLibro'] = $this->libro->getAutores($idLibro);
				//$data['listaTodosLosAutores'] = $this->persona->getAll();
				$this->vista->mostrar('incidencias/formularioModificarIncidencia', $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/mostrarListaIncidencias", $data);
			}
		}

		// --------------------------------- MODIFICAR LIBROS ----------------------------------------

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
				$this->vista->mostrar("incidencias/mostrarListaIncidencias", $data);
			} else {
				$data['msjError'] = "No tienes permisos para hacer eso";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
		}

		// --------------------------------- BUSCAR LIBROS ----------------------------------------

        public function buscarLibros() {
			// Recuperamos el texto de b�squeda de la variable de formulario
			// Recuperamos el texto de búsqueda de la variable de formulario
			$textoBusqueda = $_REQUEST["textoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de libros
			$data['listaIncidencias'] = $this->incidencia->busquedaAproximada($textoBusqueda);
			$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
			$this->vista->mostrar("incidencias/mostrarListaIncidencias", $data);
		}


    }
