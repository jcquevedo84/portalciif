<?php
	/**
	*CIIF gestionUsuarioM
	*
	*Clase Modelo de la Pagina gestionUsuario.php
	*En esta clase se encuentran todos los modelos de datos y conexiones a base de datos realizadas desde la pagina info.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package gestionUsuarioM
	*
	*/
	class vulnerabilidadesM extends templeteM 
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
		function guardar($form="",$tipo="",$idCaso="")
		{	
			require_once "../librerias/auditoria.php";
			$ip=auditoria::getRealIP();
			$resulQuery="";
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
    		$user=$this->objS->get("user");
    		if(($form["txtfecha2"]=="")){
    			$form["txtfecha2"]='null';
    		}
			if(($form["txtfecha3"]=="")){
    			$form["txtfecha3"]='null';
    		}
    		if(!empty($form["txtfecha1"])){
    			$status="Detectada";
    		}
    		if (!empty($form["txtfecha2"])){
    			$status="Reportada";
    		}
			if (!empty($form["txtfecha3"])){
    			$status="Cerrada";
    		}
    		if($tipo==2 && (!empty($idCaso) || isset($form["txtcasoVulnerabilidadPadre"]))){
    			if(empty($idCaso))
    				$idCaso=$form["txtcasoVulnerabilidadPadre"];
    			$objPG->addCampos("idcaso");
    			$resulQuery=$objPG->insercion("0,".$form["txtcasoVulnerabilidad"].";1,".$form["txtdescripcion"].";2,".$form["txtrt"].";3,".$form["txtfecha1"].";4,".$form["txtfecha2"].";5,".$form["txtresponsable"].";6,".$tipo.";7,".$form["txtfecha3"].";8,".$user->getIdUsuario().";9,".$ip.";10,".$status.";11,".$idCaso.";",__LINE__);
    		}
    		else {
    			$resulQuery=$objPG->insercion("0,".$form["txtcasoVulnerabilidad"].";1,".$form["txtdescripcion"].";2,".$form["txtrt"].";3,".$form["txtfecha1"].";4,".$form["txtfecha2"].";5,".$form["txtresponsable"].";6,".$tipo.";7,".$form["txtfecha3"].";8,".$user->getIdUsuario().";9,".$ip.";10,".$status.";",__LINE__);
				
    		}
    		$identificador=$resulQuery['arg']['lastOid'].date("dmY");
			$this->actualizarIdentificador($resulQuery['arg']['lastOid'],$identificador);
    		unset($objPG);
			$rutaLogs=varConf::getLogs();
			if($tipo==1){
				$mensaje= new mensaje(1,$rutaLogs[substr(__CLASS__,0,strlen(__CLASS__)-1)],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." registro una vulnerabilidad desde la ip: ".$ip,substr(__CLASS__,0,strlen(__CLASS__)-1),__CLASS__,__FUNCTION__,__LINE__);
				return mensajes::$_020REGISSTRO.",".$form["txtcasoVulnerabilidad"]."-".$identificador.",".$resulQuery['arg']['lastOid'];
			}
    		elseif ($tipo==2){
				$mensaje= new mensaje(1,$rutaLogs[substr(__CLASS__,0,strlen(__CLASS__)-1)],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." registro un subcaso desde la ip: ".$ip,substr(__CLASS__,0,strlen(__CLASS__)-1),__CLASS__,__FUNCTION__,__LINE__);
				return mensajes::$REGISSTRO_021.",".$idCaso;
    		}
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
		function modificar($form="",$id=""){		   
    		$resulQuery="";
		if(($form["txtfecha2"]=="")){
    			$form["txtfecha2"]='null';
    		}
			if(($form["txtfecha3"]=="")){
    			$form["txtfecha3"]='null';
    		}
    		if(!empty($form["txtfecha1"])){
    			$status="Detectada";
    		}
    		if (!empty($form["txtfecha2"])){
    			$status="Reportada";
    		}
			if (!empty($form["txtfecha3"])){
    			$status="Cerrada";
    		}
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
	    	$resulQuery=$objPG->actualizacion("0,".$form["txtcasoVulnerabilidad"].";1,".$form["txtdescripcion"].";2,".$form["txtrt"].";3,".$form["txtfecha1"].";4,".$form["txtfecha2"].";5,".$form["txtresponsable"].";6,".$form["txtfecha3"].";7,".$user->getIdUsuario().";8,".$ip.";9,".$status.";","0,".$id.";",__LINE__);
			$mensaje= new mensaje(1,$rutaLogs[substr(__CLASS__,0,strlen(__CLASS__)-1)],"El usuario con id: ".$user->getIdUsuario()." y nombre: ".$user->getname." Modifico una vulnerabilidad desde la ip: ".$ip,substr(__CLASS__,0,strlen(__CLASS__)-1),__CLASS__,__FUNCTION__,__LINE__);
	    	unset($objPG);
			return "La empresa se ha actualizado con exito";
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
		function actdes($id="",$est=""){
			$resulQuery="";
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
	    	$resulQuery=$objPG->actualizacion("0,".$est.";","0,".$id.";",__LINE__);
			unset($objPG);
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
		function seleccionar($id=""){
			$resul="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			$resul=$objPG->selecion("0,".$id.";",__LINE__);
			unset($objPG);
			return 	$resul['resul'];
		}
		function verDetalle($id=""){
			$resul="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			$resul=$objPG->selecion("0,".$id.";",__LINE__);
			unset($objPG);
			return 	$resul['resul'];
		}
	    function listar(){
			$resul="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			$resul=$objPG->selecion("",__LINE__);
			unset($objPG);
			return 	$resul['resul'];
		}
			/**
		*
		*actualizarIdentificador
		*
		*Este metodo actualiza el estado de un registro a activo=1 o inactivo =0.
		*
		*@param integer $id (Obligatorio)Es el identificador para realizar la consulta a la BD y buscar el registro
		*@param integer $est (Obligatorio) es estado en que cambiara el registro a activo=1 o inactivo =0.
		*@return String Mensaje de que se realizó la operación
		*/
		function actualizarIdentificador($id="",$identificador=""){
			$resulQuery="";
    		$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
	    	$resulQuery=$objPG->actualizacion("0,".$identificador.";","0,".$id.";",__LINE__);
			unset($objPG);
			return true;
		}
		//buscar
		function buscar($tipo="",$text=""){
			$resulQuery="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			if($tipo=="numero"){
				$condicion=array(0=>array( 'CAMPO'=>'a.identificador','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>''));
				$objPG->setCondicion($condicion);
				$resul=$objPG->selecion("0,".$text.";",__LINE__);
			}
			elseif ($tipo=="nombre"){
				$condicion=array(0=>array( 'CAMPO'=>'a.nombre ','OPERADORR'=>' like ','OPERADORL'=>'','VALOR'=>''));
				$objPG->setCondicion($condicion);
				$resul=$objPG->selecion("0,'%".trim($text)."%';",__LINE__);
			}
			elseif ($tipo=="descripcion"){
				$condicion=array(0=>array( 'CAMPO'=>'a.descripcion ','OPERADORR'=>' like ','OPERADORL'=>'','VALOR'=>''));
				$objPG->setCondicion($condicion);
				$resul=$objPG->selecion("0,'%".trim($text)."%';",__LINE__);
			}
			unset($objPG);
			return 	$resul['resul'];
		}
		function mostrarSubCaso($id=""){
			$resul="";
			$objPG= new consultas(__FILE__,__CLASS__,__FUNCTION__);
			$resul=$objPG->selecion("0,".$id.";1,".$id.";",__LINE__);
			unset($objPG);
			return 	$resul['resul'];
		}
		
	}
?>