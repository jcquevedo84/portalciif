<?php
	/**
	*CIIF bibliotecaM
	*
	*Clase Modelo de la Pagina biblioteca.php
	*En esta clase se encuentran todos los modelos de datos y conexiones a base de datos realizadas desde la pagina info.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package bibliotecaM
	*
	*/
	class bibliotecaM extends templeteM 
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
		function guardarSoftware($form="")
		{	
			require_once "../librerias/auditoria.php";
			$ip=auditoria::getRealIP();
			$user=$this->objS->get("user");
			$resulQuery="";
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
	    	$resulQuery=$objPG->insercion("0,".$form["txtnombre"].";1,".$form["txtdescripcion"].";2,".$form["txtlink"].";3,".$user->getIdUsuario().";4,".$ip.";",__LINE__);
			unset($objPG);
			$rutaLogs=varConf::getLogs();
			$mensaje= new mensaje(1,$rutaLogs["biblioteca"],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." registro un Software desde la ip: ".$ip,"biblioteca",__CLASS__,__FUNCTION__,__LINE__);
			return mensajes::$REGISSTRO_004;
		}
		/**
		*
		*modificar
		*
		*Este metodo Modifica los datos de un registro 
		*
		*@param integer $id (Obligatorio)Es el identificador para realizar la consulta a la BD y buscar el registro
		*@param integer $form (Obligatorio) Son los datos del registro que se modificaran
		*@return String Mensaje de que se realizó la operación
		*/
		function modificar($form="",$id="")
		{		   
			require_once "../librerias/auditoria.php";
			$ip=auditoria::getRealIP();
			$resulQuery="";
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
    		if($form["cmbtipoUsuario"]){
    			$campos=array(
								0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
								1=>array( 'CAMPO'=>'apellido','VALOR'=>''),
								2=>array( 'CAMPO'=>'email','VALOR'=>''),
								3=>array( 'CAMPO'=>'poo','VALOR'=>''),
								4=>array( 'CAMPO'=>'codtipousuario','VALOR'=>''),
								5=>array( 'CAMPO'=>'ip','VALOR'=>'')
								);
				$objPG->actCampos($campos);
				$resulQuery=$objPG->actualizacion("0,".$form["txtnombre_solicitante"].";1,".$form["txtapellido_solicitante"].";2,".$form["txtemail_solicitante"].";3,".$form["txtnumpoo"].";4,".$form["cmbtipoUsuario"].";5,".$ip.";","0,".$id.";",__LINE__);
    		}
    		else {
    			$resulQuery=$objPG->actualizacion("0,".$form["txtnombre_solicitante"].";1,".$form["txtapellido_solicitante"].";2,".$form["txtemail_solicitante"].";3,".$form["txtnumpoo"].";4,".$ip.";","0,".$id.";",__LINE__);
    		}
			unset($objPG);
			$rutaLogs=varConf::getLogs();
			$user=$this->objS->get("user");
			$mensaje= new mensaje(1,$rutaLogs["biblioteca"],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." Actualizo un usuario desde la ip: ".$ip,"biblioteca",__CLASS__,__FUNCTION__,__LINE__);
			return mensajes::$MODIFICCION_018;
		}
				/**
		*
		*actdes
		*
		*Este metodo actualiza el estado de un registro a activo=1 o inactivo =0.
		*
		*@param integer $id (Obligatorio)Es el identificador para realizar la consulta a la BD y buscar el registro
		*@param integer $est (Obligatorio) es estado en que cambiara el registro a activo=1 o inactivo =0.
		*@return String Mensaje de que se realizó la operación
		*/
		function actdesSoftware($id="",$est="")
		{
			require_once "../librerias/auditoria.php";
			$ip=auditoria::getRealIP();
			$resulQuery="";
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
	    	$resulQuery=$objPG->actualizacion("0,".$est.";","0,".$id.";",__LINE__);
			unset($objPG);
			$rutaLogs=varConf::getLogs();
			$user=$this->objS->get("user");
			if($est)
				$mensaje= new mensaje(1,$rutaLogs["biblioteca"],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." Activo un usuario desde la ip: ".$ip,"biblioteca",__CLASS__,__FUNCTION__,__LINE__);
			else
				$mensaje= new mensaje(1,$rutaLogs["biblioteca"],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." Desactivo un usuario desde la ip: ".$ip,"biblioteca",__CLASS__,__FUNCTION__,__LINE__);
			return mensajes::$CAMBOESTADO_005;
		}
		/**
		*
		*seleccionar
		*
		*Selecciona un registro deacuerdo a un ID y devuelve los datos del registro
		*
		*@param integer $id (Obligatorio)Es el identificador para realizar la consulta a la BD y buscar el registro
		*@return array $resul datos del registro
		*/
		function seleccionarSoftware($id="")
		{
			$resul="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			$resul=$objPG->selecion("0,".$id.";",__LINE__);
			unset($objPG);
			return 	$resul['resul'];
		}
	    function listarSoftware()
		{
			$resul="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			$resul=$objPG->selecion("",__LINE__);
			unset($objPG);
			return 	$resul['resul'];
		}
	}
?>