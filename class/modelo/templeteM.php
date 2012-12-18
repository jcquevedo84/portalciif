<?php

class templeteM {
		//TODO: Implementar Metodos de set y get y valiar su uso en el resto de las clases
		/**
		* array que guarda las variables para conectarse a la base de datos.
		* @var array $varGlobalBD
		* @access private
		*/
		public $varGlobalBD="";
		/* string que guarda ruta dpnde se encuentran las consuktas predefinidas de base de datosn.
		* @var string $rutaConsulta
		* @access private
		*/
		public $rutaConsulta="";
		/* array que guarda las variables de sessión.
		* @var array $objS
		* @access private
		*/
		public $objS="";
		/**
		*
		*Constructor
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*
		*@param array $varGlobalsBD. Es un array que contiene las variables de sessión.
		*@param array $varGlobalsBD.  Es un array que contiene toda la información necesaria para la conexion a la base de datos.
		*@param string $rutaConsulta. Es la ruta donde se encuentras las consultas predefinidas en la aplicación.
		*@return void
		*/
		function __construct($objS="",$varGlobalsBD="",$rutaConsulta="")
		{
			if(!empty($objS))
				$this->objS=$objS;
			if(!empty($varGlobalsBD))
				$this->varGlobalsBD=$varGlobalsBD;
			else 
				$this->varGlobalsBD=varConf::getBaseDatosPgsql();
			if(!empty($rutaConsulta))
				 $this->rutaConsulta=$rutaConsulta;
			else 
				$this->rutaConsulta=varConf::getRutasAccesoBDConsultas("consulta");
		}
}

?>