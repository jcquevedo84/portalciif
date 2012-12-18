<?php
	/**
	*CIIF varConf
	*
	*Clase varConf de la página 
	*Esta clase se encarga de 
	*@@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package admonC
	*
	*/
	class varConf
	{
		 /**
		* array que guarda las variables de las rutas generales.
		* @var array $rutasGenerales
		* @access public
		*/
		static private $rutasGenerales=array();
		 /**
		* array que guarda las variables de las rutas de las imagenes.
		* @var array $rutasAccesoImagen
		* @access public
		*/
		static private $rutasAccesoImagen=array();
		 /**
		* array que guarda las variables las rutas de los archivos javascript.
		* @var array $rutasAccesoJs
		* @access public
		*/
		static private $rutasAccesoJs=array();
		 /**
		* array que guarda las variables de las rutas de las hojas de estilos.
		* @var array $rutasAccesoEstilo
		* @access public
		*/
		static private $rutasAccesoEstilo=array();
		 /**
		* array que guarda las variables de las rutas de las librerias.
		* @var array $rutasAccesoLibreriasI
		* @access public
		*/
		static private $rutasAccesoLibrerias=array();
		 /**
		* array que guarda las variables de las rutas de las consultas a base de datos predefinidas.
		* @var array $rutasAccesoBDConsultas
		* @access public
		*/
		static private $rutasAccesoBDConsultas=array();
		 /**
		* array que guarda las variables de las rutas de los archivos que se encuentran en la carpeta other.
		* @var array $rutasAccesoOther
		* @access public
		*/
		static private $rutasAccesoOther=array();
		 /**
		* array que guarda las variables para conectarse a la base de datos.
		* @var array $rutasPlugins
		* @access public
		*/
		static private $rutasPlugins=array();
		 /**
		* array que guarda las variables de las rutas de los archivos que se encuentran en la carpeta controladora.
		* @var array $rutasAccesoControlador
		* @access public
		*/
		static private $rutasAccesoControlador=array();
		 /**
		* array que guarda las variables de las rutas de los archivos que se encuentran en la carpeta vista.
		* @var array $rutasAccesoVista
		* @access public
		*/
		static private $rutasAccesoVista=array();
		 /**
		* array que guarda las variables de las rutas de los archivos que se encuentran en la modelo.
		* @var array $rutasAccesoModelo
		* @access public
		*/
		static private $rutasAccesoModelo=array();
		 /**
		* array que guarda las variables de las rutas de los archivos que se encuentran en la carpeta pagina.
		* @var array $paginas
		* @access public
		*/
		static private $paginas=array();
		 /**
		* array que guarda las variables para conectarse a la base de datos.
		* @var array $baseDatosPgsql
		* @access public
		*/
		static private $baseDatosPgsql=array();
		 /**
		* array que guarda las variables d3el servidor 	Web.
		* @var array $servidor
		* @access public
		*/
		static private $servidor=array();
		static private $logs=array();
		/**
		*
		*Es un array que contiene todos los atributos posibles de cada una de las pagina de la aplicación
		*El index de este array el nombre de la pagina el cual contiene un array con los siguienets elementos:
		*array[nombrePagina]=array[titulo]='' Es el titulo de la pagina
		*		 			 array[nombre]='' Es el nombre del fichero
		*		 			 array[charset]=''
		*		 			 array[idioma]=''
		*		 			 array[httpequiv]=''
		*		 			 array[content]=''
		*		 			 array[ficEstilos]='' Es el conjunto de archivos.css (estilos) que van ha ser aplicados a la página. Deben estar separados por ;
		*		 			 array[ficJavaScript]='' Es el conjunto de archivos.js (javascript) que van ha ser aplicados en la página. Deben estar separados por ;
		*		 			 array[javaScriptGeneral]='' Es un campo que puede ser modificado en la vista o el controlador para aqurega codigo javascript al momento de ejecutar la pagina.
		*		 			 array[javaScriptBody]='' Se coloca los llamados a funciones javascript junto con el evento que se ejecutaran en el body.
		*		 			 array[idbody]='' Es el id del body
		*Todos estos campos pueden ser alterados y modificados en el controlador.
		*@global array $atributosPag
		*@name $atributosPag
		*/							
		static private $atributosPag=array();
		/**
		*
		*Es un array que contiene cada uno de los ficheros que  ha se incluidos en una pagina de la aplicación
		*El index de este array es el nombre de la pagina y este a su vez contien un array que tiene todos los ficheros a incluir en esta pagina.
		*array[nombrePagina]=array[rutasAccesoLibreriasI]='' Es el conjunto que se encuentran en la carpeta librerias y que van ha ser incluidas en la página. Deben estar separados por ;. Estas librerias son de uso general y estan contenidas en la carpeta de la misma aplicación.
		*		 			 array[rutasAccesoBDConsultas]='' Es el conjunto de archivos que se encuentran en class\Bd y que van ha ser incluidas en la página. Deben estar separados por ;.Estas librerias son para realizar consultas a base de datos.
		*		 			 array[rutasAccesoOther]=''  Es el conjuntode archivos  que se encuentran en class\Other y que van ha ser incluidas en la página. Deben estar separados por ;.Estos Script son utilizados para realizar eventos javascript
		*		 			 array[rutasAccesoVista]='' Es el conjunto de librerias que se encuentran en class\Vista y que van ha ser incluidas en la página. Deben estar separados por ;. Existe una por cada pagina. Alli se encuentra todo lo referente a la presentación de la pagina.
		*		 			 array[rutasAccesoControlador]='' Es el conjunto de librerias que se encuentran en lclass\Controladora y que van ha ser incluidas en la página. Deben estar separados por ;. Existe una por cada pagina, alli se encuentra codificada cada uno de los eventos que se genera en la pagina.
		*		 			 array[rutasAccesoModelo]='' Es el conjunto de librerias que se encuentran en class\Modelo y que van ha ser incluidas en la página. Deben estar separados por ;. Pueden existir varias por cada pagina. Alli se codifica cada uno de los modelos de datos que se utilizaran en la pagina					
		*Todos estos campos pueden ser alterados y modificados en el controlador.
		*@global array $librerias
		*@name $librerias
		*/	
		static private $librerias=array();
		static private $nombre=__CLASS__;
		/**
		*
		*varConf
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*
		*@param string $nombreArchivo 
		*@param string $ruta 
		*@param array $nombrePag
		*@param string $nomArchClass
		*@param string $nomArchPag
		*@return void
		*/
		public function varConf($nombreArchivo="",$ruta="",$nombrePag="",$nomArchClass="",$nomArchPag="")
		{
			$varGlobal=array();
			if(empty($nombreArchivo))
				die("Nombre del archivo de Configuración de la aplicación Vacio");
			if(empty($nomArchClass))
				die("Nombre del archivo de Configuración de las clases Vacio");
			if(empty($nomArchPag))
				die("Nombre del archivo de Configuración de las paginas Vacio");
			if(file_exists($ruta.$nombreArchivo))
			{
				$varGlobal= parse_ini_file($ruta.$nombreArchivo,true);
				foreach ($varGlobal as $key => $value){
					$aux="";
					$aux=ucwords($key);
					if(method_exists("varConf","set$aux"))
					{
						$var="self::set$aux(\$varGlobal[".$key."]);";
						eval($var);
					} 
				}
			}
			else 
				die("no existe la ruta del archivo de configuración de la aplicación: ".$ruta.$nombreArchivoCompleto);	
			if(file_exists($ruta.$nomArchClass)){
				$varGlobal= parse_ini_file($ruta.$nomArchClass,true);
				self::setLibrerias($varGlobal[$nombrePag],$nombrePag);
			}
			else 
				die("no existe la ruta del archivo de configuración de las clases: ".$ruta.$nomArchClass);	
			if(file_exists($ruta.$nomArchPag))
			{
				$varGlobal= parse_ini_file($ruta.$nomArchPag,true);
				self::setAtributosPag($varGlobal[$nombrePag],$nombrePag);
			}
			else 
				die("no existe la ruta del archivo de configuración de las paginas: ".$ruta.$nombrePag);	
			unset($varGlobal);
		}
		/**
		*
		*setAtributosPag
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		private function setAtributosPag($atPag="",$nom=""){
			if(is_array($atPag))
				self::$atributosPag[$nom]=$atPag;
		}
		/**
		*
		*setLibrerias
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		private function setLibrerias($lib="",$nom="")
		{
			if(is_array($lib))
				self::$librerias[$nom]=$lib;
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasPlugins($rutasPlugins="")
		{
			if(is_array($rutasPlugins))
				self::$rutasPlugins=$rutasPlugins;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setBaseDatosPgsql($baseDatosPgsql="")
		{
			if(is_array($baseDatosPgsql))
				self::$baseDatosPgsql=$baseDatosPgsql;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setPaginas($paginas="")
		{
			if(is_array($paginas))
				self::$paginas=$paginas;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoEstilo($rutasAccesoEstilo="")
		{
			if(is_array($rutasAccesoEstilo))
				self::$rutasAccesoEstilo=$rutasAccesoEstilo;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoImagen($rutasAccesoImagen="")
		{
			if(is_array($rutasAccesoImagen))
				self::$rutasAccesoImagen=$rutasAccesoImagen;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoJs($rutasAccesoJs="")
		{
			if(is_array($rutasAccesoJs))
				self::$rutasAccesoJs=$rutasAccesoJs;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoBDConsultas($rutasAccesoBDConsultas="")
		{
			if(is_array($rutasAccesoBDConsultas))
				self::$rutasAccesoBDConsultas=$rutasAccesoBDConsultas;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoLibrerias($rutasAccesoLibrerias="")
		{
			if(is_array($rutasAccesoLibrerias))
				self::$rutasAccesoLibrerias=$rutasAccesoLibrerias;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoModelo($rutasAccesoModelo="")
		{
			if(is_array($rutasAccesoModelo))
				self::$rutasAccesoModelo=$rutasAccesoModelo;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoOther($rutasAccesoOther="")
		{
			if(is_array($rutasAccesoOther))
				self::$rutasAccesoOther=$rutasAccesoOther;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoVista($rutasAccesoVista="")
		{
			if(is_array($rutasAccesoVista))
				self::$rutasAccesoVista=$rutasAccesoVista;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasGenerales($rutasGenerales="")
		{
			if(is_array($rutasGenerales))
				self::$rutasGenerales=$rutasGenerales;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/	
		public static function setServidor($servidor)
		{
			if(is_array($servidor))
				self::$servidor=$servidor;	
		}
		
		
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function setRutasAccesoControlador($rutasAccesoControlador)
		{
			if(is_array($rutasAccesoControlador))
				self::$rutasAccesoControlador=$rutasAccesoControlador;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/		
		public static function getPaginas($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$paginas))
					return self::$paginas[$nombre];
			}
			else 
				return self::$paginas;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoEstilo($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoEstilo))
					return self::$rutasAccesoEstilo[$nombre];
			}
			else 
				return self::$rutasAccesoEstilo;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoImagen($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoImagen))
					return self::$rutasAccesoImagen[$nombre];
			}
			else 
				return self::$rutasAccesoImagen;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoJs($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoJs))
					return self::$rutasAccesoJs[$nombre];
			}
			else 
				return self::$rutasAccesoJs;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoBDConsultas($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoBDConsultas))
					return self::$rutasAccesoBDConsultas[$nombre];
			}
			else 
				return self::$rutasAccesoBDConsultas;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoLibrerias($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoLibrerias))
					return self::$rutasAccesoLibrerias[$nombre];
			}
			else 
				return self::$rutasAccesoLibrerias;		
		}
		
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoModelo($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoModelo))
					return self::$rutasAccesoModelo[$nombre];
			}
			else 
				return self::$rutasAccesoModelo;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoOther($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoOther))
					return self::$rutasAccesoOther[$nombre];
			}
			else 
				return self::$rutasAccesoOther;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoVista($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoVista))
					return self::$rutasAccesoVista[$nombre];
			}
			else 
				return self::$rutasAccesoVista;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasAccesoControlador($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasAccesoControlador))
					return self::$rutasAccesoControlador[$nombre];
			}
			else 
				return self::$rutasAccesoControlador;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasGenerales($nombre="")
		{
			if(!empty($nombre))
			{
				$unidad=substr($_SERVER['DOCUMENT_ROOT'],0,1);
				if(is_array(self::$rutasGenerales))
					return $unidad.self::$rutasGenerales[$nombre];
			}
			else 
			{
				$unidad=substr($_SERVER['DOCUMENT_ROOT'],0,1);
				$varGlobal=self::$rutasGenerales;
				foreach( $varGlobal as $key => $value ) 
					$varGlobal2[$key]=$unidad.$value;
				return $varGlobal2;	
			}
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getServidor($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$servidor))
					return self::$servidor[$nombre];
			}
			else 
				return self::$servidor;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getBaseDatosPgsql($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$baseDatosPgsql))
					return self::$baseDatosPgsql[$nombre];
			}
			else 
				return self::$baseDatosPgsql;	
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getRutasPlugins($nombre="")
		{
			if(!empty($nombre))
			{
				if(is_array(self::$rutasPlugins))
					return self::$rutasPlugins[$nombre];
			}
			else 
				return self::$rutasPlugins;	
		}
		/**
		*
		* Incluye las librerias 
		*
		*@access public 
		*@param string $ruta Es la ruta de la libreria a incluir
		*@return void 
		*/
		public static function incluirLibreria($ruta="")
		{
			if(!empty($ruta))
			{
				if(file_exists($ruta))
					require_once($ruta);
				else 
					die("El archivo que se encuentra en la ruta $ruta no existe");
			}
		}
		/**
		*
		*Funciones Globales
		*
		*Esta Función se encarga de incluir uun lote de librerias
		*
		*@param array $varConf (Obligatorio) Array que continen las direciones de todas las librerias
		*@param string $lib (Obligatorio) Continen las librerias a incluir separadas por ;.<br> El nombre de las libreria debe ser igual al nombre de laslibrerias que se encuentra en el archivo configuracion.ini
		*@return void
		*/
		public static function incluirLibrerias($lib="")
		{
			
			if(!empty($lib))
			{
				foreach ($lib as $key => $value)
				{
					$aux="";
					$aux=ucwords($key); 
					//TODO Validar si existe el metodo
					$var="\$lib2=self::get$aux();";
					eval($var);
					if(!empty($lib2))
					{
						$libreriaIncluir=explode(";",$value);
						foreach ($libreriaIncluir as $valor)
							self::incluirLibreria($lib2[$valor]);
					}
				}
			}
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getAtributosPag($nombre="",$subIndice="")
		{
			if(!empty($nombre))
			{
				if(!empty($subIndice))
					return self::$atributosPag[$nombre][$subIndice];
				else 
				{
					if(self::$atributosPag[$nombre]["banner"])
						self::$atributosPag[$nombre]["banner"]=self::getRutasAccesoImagen("imagenes").self::$atributosPag[$nombre]["banner"];	
					return self::$atributosPag[$nombre];
				}
			}
		}
		/**
		*
		*nombre
		*
		*Descripsión
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		public static function getLibrerias($nombre=""){
			return self::$librerias[$nombre];
		}
	/**
	 * @return unknown
	 */
	public static function getLogs() {
		return self::$logs;
	}
	
	/**
	 * @param unknown_type $logs
	 */
	public static function setLogs($logs) {
		self::$logs = $logs;
	}

	}
?>