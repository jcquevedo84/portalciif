<?php
	/**
	*CIIF usuario
	*
	*Clase classUsuario 
	*En esta clase representa el usuario de la aplicación
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexM
	*/
	class usuario 
	{
		/**
		* string que guarda el nombre del usuario.
		* @var string $nombre
		* @access public
		*/
		private $nombre=""; 
		/**
		* string que guarda el apellido del usuario.
		* @var string $apellido
		* @access public
		*/
		private $apellido="";
		/**
		* @var string $email
		* @access public
		*/
		private $email="";
		/**
		* string que guarda la identificación del usuario.
		* @var string $idUsuario
		* @access public
		*/
		private $idUsuario="";
		/**
		* string que guarda el login del usuario para accesar a la aplicación.
		* @var string $login
		* @access public
		*/
		private $login="";
		/**
		* string que guarda la clave de l usuario para accesar a la aplicación.
		* @var string $clave
		* @access public
		*/
		private $clave="";
		/**
		* string que guarda el perfil del usuario dentro de la aplicación.
		* @var string $nivel
		* @access public
		*/
		private $tipoUsuario="";
		/**
		* string que guarda identificador de usuario en CANTV.
		* @var string $poo
		* @access public
		*/
		private $poo="";
		private $roles="";
		private $modulos="";
		/**
		* string que guarda la institucion del usuario dentro de la aplicación.
		* @var string $institucion
		* @access public
		*/
		/*
		* string que guarda el nombre de la clase.
		* @var string $nombreClase
		* @access public
		*/
		var $nombreClase=__CLASS__;
		/**
		*
		*Constructor
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*
		*@return void
		*/
		function usuario() 
		{
			
		}
		/**
		 * @return string
		 */
		public function getPoo() {
			return $this->poo;
		}
		
		/**
		 * @param string $poo
		 */
		public function setPoo($poo) {
			$this->poo = $poo;
		}
		/**
		*
		*setNombre
		*
		*Es la encargada de actualizar el nombre del usuario.
		*
		*@param string $nombre (Obligatorio) Es el nombre del usuario.
		*@return void
		*/
		function setNombre($nombre="") 
		{
				$this->nombre=$nombre;
		}
		/**
		*
		*setEmail
		*
		*Es la encargada de actualizar el mail del usuario.
		*
		*@param string $email (Obligatorio) Es el mail del usuario.
		*@return void
		*/
		function setEmail($email="") 
		{
				$this->email=$email;
		}
		/**
		*
		*setIdUsuario
		*
		*Es la encargada de actualizar el identificador del usuario.
		*
		*@param string $idusuario (Obligatorio) Es el identificador del usuario.
		*@return void
		*/
		function setIdUsuario($idusuario="") 
		{
				$this->idUsuario=$idusuario;
		}
		/**
		*
		*setNivel
		*
		*Es la encargada de actualizar el nivel del usuario.
		*
		*@param string $nivel (Obligatorio) Es el nivel del usuario.
		*@return void
		*/
		function setTipoUsuario($nivel="") 
		{
				$this->tipoUsuario=$nivel;
		}
		/**
		*
		*setLogin
		*
		*Es la encargada de actualizar el login del usuario.
		*
		*@param string $login (Obligatorio) Es el login del usuario.
		*@return void
		*/
		function setLogin($login="") 
		{
				$this->login=$login;
		}	
		/**
		*
		*getNombre
		*
		*Es la encargada de retornar el nombre del usuario.
		*
		*@return string $nombre Es el nombre del usuario.
		*/
		function getNombre() 
		{
			return $this->nombre;
		}
		/**
		*
		*getEmail
		*
		*Es la encargada de retornar el mail del usuario.
		*
		*@return $email Es el mail del usuario.
		*/
		function getEmail() 
		{
			return $this->email;
		}
		/**
		*
		*getIdUsuario
		*
		*Es la encargada de retornar el identificador del usuario.
		*
		*@return $idusuario Es identificador del usuario.
		*/
		function getIdUsuario() 
		{
			return $this->idUsuario;
		}
		/**
		*
		*getNivel
		*
		*Es la encargada de retornar el nivel del usuario.
		*
		*@return string $nivel (Obligatorio) Es el nivel del usuario.
		*/
		function getTipoUsuario() 
		{
			return $this->tipoUsuario;
		}
		/**
		*
		*getLogin
		*
		*Es la encargada de retornar el login del usuario.
		*
		*@return string $login (Obligatorio) Es el login del usuario.
		*/
		function getLogin() 
		{
			return $this->login;
		}
	/**
	 * @return string
	 */
	public function getClave() {
		return $this->clave;
	}
	
	/**
	 * @param string $clave
	 */
	public function setClave($clave) {
		$this->clave = $clave;
	}
	/**
	 * @return string
	 */
	public function getApellido() {
		return $this->apellido;
	}
	
	/**
	 * @param string $apellido
	 */
	public function setApellido($apellido) {
		$this->apellido = $apellido;
	}


		
		
	}
?>