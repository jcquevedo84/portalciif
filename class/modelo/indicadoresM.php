<?php
	/**
	*CIIF indicadoresM
	*
	*Clase Modelo de la Pagina indicadores.php
	*En esta clase se encuentran todos los modelos de datos y conexiones a base de datos realizadas desde la pagina info.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indicadoresM
	*
	*/
	class indicadoresM extends templeteM 
	{
		/**
		*
		*Constructor
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*
		*@param array $varGlobalsBD (Obligatorio) Es un array que contiene toda la información necesaria para la conexion a la base de datos.
		*@param string $rutaConsulta (Obligatorio) Es la ruta donde se encuentras las consultas predefinidas en la aplicación.
		*@return void
		*/
		function __construct($objS="",$varGlobalsBD="",$rutaConsulta="")
		{
			templeteM::__construct($objS,$varGlobalsBD,$varGlobalsBD);
		}
		/**
		*
		*guardar
		*
		*Este metodo inserta los datos de un registro a la BD
		*		
		*@param integer $form (Obligatorio) Son los datos del registro que se INSERTARÁ
		*@return String Mensaje de que se realizó la operación
		*/
		function consultarDatos($form="")
		{	
			//Aqui va la consulta SQL a la base de datos o archivo
		}
		
		
	}
?>