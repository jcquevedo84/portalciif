<?php
	/**
	*validacionesAjax
	*
	*Clase Modelo de la Pagina validacionesAjax.php
	*En esta clase se encuentran todos los modelos de datos y conexiones a base de datos realizadas desde la pagina admon.php
	*@copyright Instituo de Ingenieria CPDI
	*@author Juan Carlos Rodriguez - Jesus Rodriguez
	*@version 1.0
	*@package validacionesAjax
	*
	*/
	class validaciones
	{
	public static $resul=1;
	//TODO Organizar estos metodos
	/**
	 * @return unknown
	 */
	public static function getResul() {
		return self::$resul;
	}
	
	/**
	 * @param unknown_type $resul
	 */
	public static function setResul($r) {
		self::$resul=$r;
	}
		
		
		/**
		* Funciones generales de tratamientos de objetos de formularios 
		*/
		
		/**
		* notificacion
		* 
		* Funcion general que imprime mensajes en un campo especifico
		* @param $campo nombre del campo de notificacion
		* @param $mensaje texto del mensaje a imprimir en el campo de notificacion
		* @param $tipo categoria del mensaje enviado (error, correcto, aviso)
		* @param $casilla nombre del campo de texto a resaltar
		* @param $respuesta objeto xajax
		* @return $respuesta objeto xajax con las validaciones realizadas 
		*/
		public static function notificacion($campo, $mensaje, $tipo, $casilla, $respuesta)
		{
			$fondo = "";
			$fuente = "";
			$opcion = "";
			$tam = "";
			
			if($campo == "msg_general")
			{
				$tam = "12px";
			}else
			{
				$tam = "10px";
			}
			
			switch ($tipo)
			{
				case "aviso":
					$fondo = "#ffffff";
					$fuente = "#ff9900";
					$opcion = "1";
					break;
				case "error":
					$fondo = "#ffffff";
					$fuente = "#e20a16";
					$opcion = "1";
					break;
				case "correcto":
					$fondo = "#ffffff";
					$fuente = "#99cc00";
					$opcion = "0";
					break;	
			}
			
		   	$respuesta->addAssign($campo,"style.backgroundColor",$fondo);
		   	$respuesta->addAssign($campo,"style.color",$fuente);
		   	$respuesta->addAssign($campo,"style.fontWeight","bold");
		   	$respuesta->addAssign($campo,"style.fontFamily","verdana");
		   	$respuesta->addAssign($campo,"style.fontSize",$tam);
		   	$respuesta->addAssign($campo,"style.verticalAlign","middle");
		   	//imprime el mensaje en la zona de notificaciones
		   	$respuesta->addAssign($campo,"innerHTML",$mensaje);
		   	
		   	//llamada a funcion para marcar el campo afectado
		   	if(!empty($casilla)){self::resaltarCampo($casilla, $opcion,$respuesta);}
		   	
		   	return $respuesta;
		}
		
		public static function aviso($tipo="", $mensaje="")
		{
			$color = "";
			$aviso = "";
			switch ($tipo)
			{
				case "correcto":
					$color = "99cc00";
					break;
				case "error":
					$color = "e20a16";
					break;
			}
			$aviso = "<span style=\"color:".$color."; font-size:12px; font-weight:bold;\"><img src=\"../imagenes/".$tipo.".jpg\" style=\"vertical-align:middle\"/>&nbsp;&nbsp;".$mensaje."</span><br />";
			return $aviso;
		}
		
		/**
		* resaltarCampo
		* 
		* Funcion general resalta o desmarca un campo especifico
		* @param $casilla nombre del campo de texto a resaltar
		* @param $opcion resaltar o desmarcar
		* @param $respuesta objeto xajax
		* @return $respuesta objeto xajax con las validaciones realizadas 
		*/
		public static function resaltarCampo($casilla, $opcion, $respuesta)
		{
			$anchoborde = "";
			$estiloborde = "";
			$colorborde = "";
			
			switch ($opcion)
			{
				case "0":
					$anchoborde = "1px";
					$estiloborde = "solid";
					$colorborde = "#b3cce6";
					break;
				case "1":
					$anchoborde = "thin";
					$estiloborde = "double";
					$colorborde = "#336699";
					break;
		
			}
			if($casilla != '')
			{
				//resalta la casilla donde se origino el evento
				$respuesta->addAssign($casilla,"style.borderColor",$colorborde);
				$respuesta->addAssign($casilla,"style.borderWidth",$anchoborde);
				$respuesta->addAssign($casilla,"style.borderStyle",$estiloborde);
				
				return $respuesta;
			}
		}
		
		
		
		/**
		*
		*validarSiglas
		*
		*se encarga de validar siglas de instituciones o departamentos
		*@param string $campo Es el nombre de la caja de texto
		*@param string $valor Es el valor de la caja de texto
		*@param string $notificador Es el nombre de la etiqueta span donde se mostrara el mensaje
		*@param object $respuesta objeto xajax
		*@return object $respuesta objeto xajax.
		*/
		public static function validarVacio($campo, $valor, $notificador, $respuesta, $meg)
		{
			if(empty($valor))
			{
				//echo $campo."-".$valor;
				$respuesta = self::notificacion($notificador, $meg, "aviso", $campo, $respuesta);
				self::$resul=0;	
			}
			return $respuesta;
		}
		
		/**
		*
		*validarCombo
		*
		*Se encarga de validar que se elija una opcion en un combo
		*@param string $campo Es el nombre de la caja de texto
		*@param string $valor Es el valor de la caja de texto

		
		/**
		*
		*validarEmail
		*
		*Se encarga de validar las direcciones de correo electronico
		*@param string $campo Es el nombre de la caja de texto
		*@param string $valor Es el valor de la caja de texto
		*@param string $notificador Es el nombre de la etiqueta span donde se mostrara el mensaje
		*@param object $respuesta objeto xajax
		*@return object $respuesta objeto xajax.
		*/
		public static function validarEmail($campo, $valor, $notificador, $respuesta,$mensajes)
		{
			if(!empty($valor))
			{
				$correo = $valor;
				//$patronEmail ="/^[\w\.\-\_]+@[\w\-\_]+\.([\w\-\_]+\.)*[\w]{2,4}$/";
				$patronEmail = "/^[\w\.\-\_]+@cantv.com.ve$/";
				if(preg_match($patronEmail,$correo))
				{
					$respuesta->addAssign($campo,"value",$correo);
					$respuesta->addClear($notificador,"innerHTML");
					$respuesta = self::resaltarCampo($campo, "0", $respuesta);
				} else
				{
					$respuesta = self::notificacion($notificador,$mensajes[0], "error", $campo, $respuesta);
					self::$resul=0;
				}
			} else
			{
				$respuesta = self::notificacion($notificador, $mensajes[1], "aviso", $campo, $respuesta);
				self::$resul=0;
			}
			return $respuesta;
		}
		
		
		
			/**
			*
			*validarNombres
			*
			*se encarga de validar nombres propios
			*@param string $campo Es el nombre de la caja de texto
			*@param string $valor Es el valor de la caja de texto
			*@param string $notificador Es el nombre de la etiqueta span donde se mostrara el mensaje
			*@param object $respuesta objeto xajax
			*@return object $respuesta objeto xajax.
			*/
			public static function validarNombres($campo, $valor, $notificador, $respuesta,$mensajes)
			{
				if(!empty($valor))
				{
					$nombre = "";
					$nombre = trim(strtoupper($valor));//^[a-z A-Z]+$
					$patronNombres = "/^[[:alpha:]]+|[[:space:]]{1}|[[:alpha:]]+$/";//"/^\S([\D\'\(\)\-\/0-9]+[\.]?[\,]?[\s]?)+\S$/"
					if(preg_match($patronNombres,$nombre))
					{
						$respuesta->addAssign($campo,"value",$nombre);
						$respuesta->addClear($notificador,"innerHTML");
						$respuesta = self::resaltarCampo($campo, "0", $respuesta);	
					}else
					{
						$respuesta = self::notificacion($notificador,$mensajes[0], "error", $campo, $respuesta);
						self::$resul=0;
					}
				}else
				{
					$respuesta = self::notificacion($notificador,$mensajes[1] , "aviso", $campo, $respuesta);
					self::$resul=0;
				}
				return $respuesta;
				
			}
			/**
			*
			*validarNumeros
			*
			*se encarga de validar nombres propios
			*@param string $campo Es el nombre de la caja de texto
			*@param string $valor Es el valor de la caja de texto
			*@param string $notificador Es el nombre de la etiqueta span donde se mostrara el mensaje
			*@param object $respuesta objeto xajax
			*@return object $respuesta objeto xajax.
			*/
			public static function validarNumeros($campo, $valor, $notificador, $respuesta,$mensajes)
			{
				if(!empty($valor))
				{
					$nombre = "";
					$nombre = trim(strtoupper($valor));
					$patronNombres = "/^[[:digit:]]+$/";
					if(preg_match($patronNombres,$nombre))
					{
						$respuesta->addAssign($campo,"value",$nombre);
						$respuesta->addClear($notificador,"innerHTML");
						$respuesta = self::resaltarCampo($campo, "0", $respuesta);	
					}else
					{
						$respuesta = self::notificacion($notificador,$mensajes[0], "error", $campo, $respuesta);
						self::$resul=0;
					}
				}else
				{
					$respuesta = self::notificacion($notificador,$mensajes[1] , "aviso", $campo, $respuesta);
					self::$resul=0;
				}
				return $respuesta;
			}
	/**
		*
		*validarCombo
		*
		*Se encarga de validar que se elija una opcion en un combo
		*@param string $campo Es el nombre de la caja de texto
		*@param string $valor Es el valor de la caja de texto
		*@param string $notificador Es el nombre de la etiqueta span donde se mostrara el mensaje
		*@param object $respuesta objeto xajax
		*@return object $respuesta objeto xajax.
		*/
		public static function  validarCombo($campo, $valor, $notificador, $respuesta)
		{
			if($valor != "")
			{
				$respuesta->addClear($notificador,"innerHTML");
				$respuesta = self::resaltarCampo($campo, "0", $respuesta);
			} else
			{
				$respuesta = self::notificacion($notificador, "Elija una opci&oacute;n", "aviso", $campo, $respuesta);
			}
			
			return $respuesta;
		}

	}
?>