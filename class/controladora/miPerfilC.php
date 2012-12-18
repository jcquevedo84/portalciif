<?php
	/**
	*CIIF miPerfilC
	*
	*Clase Controladora de la pagina index.php
	*Esta clase se encarga de controlar los eventos realizados en la pagina index.php.
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexC
	*
	*/
	class miPerfilC  extends templeteC 
	{
		/**
		*
		*Constructor
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*También se encarga de ejecutar el hilo del proceso.
		*Solo contiene el constructor por que es alli donde dependiendo del evento se sabe que se va a ejecutar.
		*
		*@param string $pagOrigen (Obligatorio) Es la pagina desde donde se esta llamando a la pagina index.php 
		*@param array $objSesion (Obligatorio) Es el Objeto Session
		*@return void
		*/
		function __construct($pagOrigen="",$objSesion="",$objError="",$varGlobal="",$varPag=""){
			$this->objSesion=$objSesion;
			$objetEvent=new eventos();
			//Se crea el objeto  pagina
			$this->objPaginas = new pagina(substr(__CLASS__,0,strlen(__CLASS__)-1),$this->objError);
			//Este es el caso de que se provenga de otra pagina diferente a miPerfil.php
			//se crea el objeto  vista
			$this->view=new miPerfilV();
			//Se crea el objeto model 
			$this->model= new gestionUsuarioM($this->objSesion);
			//instanciamos el objeto de la clase xajax
			$xajax = new xajax();
			//registramos la función creada anteriormente al objeto xajax
			$xajax->registerFunction(array("modificarUsuario",&$this,"modificarUsuario"));
			$xajax->registerFunction(array("redirect",&$objetEvent,"redirect"));
			//El objeto xajax tiene que procesar cualquier petición
			$xajax->processRequests();
			$this->objPaginas->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			//actualiza la pagina donde se a ir en la siguiente pagina
			$this->view->setPaginaSiguiente($this->objPaginas->getVar("nombre"));
			//echo $pagOrigen."-".$this->objPaginas->getVar("nombre")."-";
			if($pagOrigen!=$this->objPaginas->getVar("nombre")){
				$this->user=$this->objSesion->get("user");
				//se crea el objeto  vista
				$viewGestionUsuario=new gestionUsuarioV();
				$dato=$this->model->seleccionar($this->user->getIdUsuario());
				$tipoUsuario=$this->model->tipousuario();
				$menuInferior=$this->objSesion->get("roles");//optimizar estas lineas
				$page=$this->view->principal($menuInferior,$viewGestionUsuario->registrarUsuario("",$dato,0,$this->user->getIdUsuario()));
				$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$this->user->getNombre()));
				$this->objPaginas->setCabecera($this->view->cabecera());
				$this->objPaginas->setPie($this->view->pie());
				$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
				echo $this->pagina($this->objPaginas);
			}
		}
		function validarRegistraModificarUsuario($respuesta="",$form="" ){
			//validacion de nombres
			validaciones::setResul(1);
			$msg[0]=mensajes::$VALIDARCARACTERES_010;
			$msg[1]=mensajes::$VALIDARNOMBRE_006;
			$respuesta=validaciones::validarNombres("txtnombre_solicitante",$form['txtnombre_solicitante'],"msg_nombre_solicitante",$respuesta,$msg);
			//validacion de apellido
			$msg1[0]=mensajes::$VALIDARCARACTERES_010;
			$msg1[1]=mensajes::$VALIDARAPELLIDO_007;
			$respuesta=validaciones::validarNombres("txtapellido_solicitante",$form['txtapellido_solicitante'],"msg_apellido",$respuesta,$msg1);
			//validacion de correo electrónico
			$msg2[0]=mensajes::$VALIDARFORMATOMAIL_011;
			$msg2[1]=mensajes::$VALIDARCORREO_008;
			$respuesta=validaciones::validarEmail("txtemail_solicitante",$form['txtemail_solicitante'],"msg_email_solicitante",$respuesta,$msg2);
			//validacion de poo
			$msg1[0]=mensajes::$VALIDARNUM_012;
			$msg1[1]=mensajes::$VALIDARPOO_009;
			$respuesta=validaciones::validarNumeros("txtnumpoo",$form['txtnumpoo'],"msg_txtnumpoo",$respuesta,$msg1);
			//print_r($form);
			if(isset($form['cmbtipoUsuario']))
			{
				$respuesta=validaciones::validarCombo("cmbtipoUsuario",$form['cmbtipoUsuario'],"msg_tipousuario",$respuesta,mensajes::$VALIDARTIPOUSER_010);
			}
			return $respuesta;
		}
		function modificarUsuario($form="",$id=""){
			$aux=1;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarUsuario($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
				$msm=$this->model->modificar($form,$id);
				$msm=utf8_encode($msm);
				$respuesta->addScript("alert('".$msm."')");
				$_SESSION["interno"]=true;
				$dirServidor=varConf::getServidor("direccionServidor");
				$respuesta->addRedirect($dirServidor."index.php");
			}
			return $respuesta;
		}
	
	}
?>