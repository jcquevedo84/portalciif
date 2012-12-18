<?php
	/**
	*CIIF indexM
	*
	*Clase Modelo de la Pagina index.php
	*En esta clase se encuentran todos los modelos de datos y conexiones a base de datos realizadas desde la pagina info.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexM
	*
	*/
	class indexM extends templeteM 
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
		*pagina
		*
		*Es la encargada logear al usuario que va a entrar a la aplicación y muestra la interface deacuerdo a su perfil
		*@param string $usuario (Obligatorio) en el login del usuario
		*@param string $pass (Obligatorio) Es el pasword del usuario
		*@return string $html es Todo el codigo HTML que se va a desplegar en la pagina
		*/
		function consultarLogin($usuario=" ", $pass=" ")
		{
			$resultadoLogin="";
			$objPG= new consultas("",__CLASS__,__FUNCTION__);
			$resultadoLogin=$objPG->selecion("0,".$usuario.";1,".$pass.";",__LINE__);
			return $resultadoLogin;
		}
		
		function recordarPass()//validar
	    {
	    	//instanciamos el objeto para generar la respuesta con ajax
			$respuesta = new xajaxResponse();
			$view=new recordarPassV();
			//$xajax = new xajax();
			$nombre="recordarpass";
			$pagina=new pagina($nombre,$this->objError);//OJO VERIFICAR
			$view->setPaginaSiguiente(varConf::getServidor("direccionServidor").$pagina->getVar("nombre"));
			$html=$view->principal();
			$pagina->setHTML($html);
			$html2.=$pagina->flibHtmHead();
			$html2.=$pagina->getHTML();
			$html2.=$pagina->flibCierre();
			$html2=addslashes($html2);
			$html2 = eregi_replace("[\n|\r|\n\r]", ' ', $html2);
			$respuesta->addScript( "abrirVentana(\"$html2\",'500','250')");
			return $respuesta;
	    }
	}
?>