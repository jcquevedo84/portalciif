<?php
	/**
	*CIIF indexC
	*
	*Clase Controladora de la pagina index.php
	*Esta clase se encarga de controlar los eventos realizados en la pagina index.php.
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexC
	*
	*/
	class gestionUsuarioC extends templeteC 
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
		function __construct($pagOrigen="",$objSesion=""){
			$this->objSesion=$objSesion;
			$objetEvent=new eventos();
			//Se crea el objeto  pagina
			$this->objPaginas = new pagina(substr(__CLASS__,0,strlen(__CLASS__)-1));
			//Este es el caso de que se provenga de otra pagina diferente a gestionUsuario.php
			//Se crea el objeto model 
			$this->model= new gestionUsuarioM($this->objSesion);
			//se crea el objeto  vista
			$this->view=new gestionUsuarioV();
			//instanciamos el objeto de la clase xajax
			$xajax = new xajax();
			//registramos la función creada anteriormente al objeto xajax
			$xajax->registerFunction(array("gestionVista",&$this,"gestionVista"));
			$xajax->registerFunction(array("guardarUsuario",&$this,"guardarUsuario"));
			$xajax->registerFunction(array("verDetalleUsuario",&$this,"verDetalleUsuario"));
			$xajax->registerFunction(array("cambiarEstadoUsuario",&$this,"cambiarEstadoUsuario"));
			$xajax->registerFunction(array("vermodificarUsuario",&$this,"vermodificarUsuario"));
			$xajax->registerFunction(array("modificarUsuario",&$this,"modificarUsuario"));
			$xajax->registerFunction(array("redirect",&$objetEvent,"redirect"));
			//El objeto xajax tiene que procesar cualquier petición
			$xajax->processRequests();
			$this->objPaginas->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			//actualiza la pagina donde se a ir en la siguiente pagina
			$this->view->setPaginaSiguiente($this->objPaginas->getVar("nombre"));
			//echo $pagOrigen."-".$this->objPaginas->getVar("nombre")."-";
			if($pagOrigen!=$this->objPaginas->getVar("nombre")){
				//se captura los que se va a imprimir en la pagina 
				$this->user=$this->objSesion->get("user");
				$menuInferior=$this->objSesion->get("roles");
				$b=$this->objSesion->get("menuModulos");//optimizar estas lineas
				$menuLateralIzquierdo=array();
				$menuLateralIzquierdo[substr(__CLASS__,0,strlen(__CLASS__)-1)]=$b[$this->user->getTipoUsuario()][substr(__CLASS__,0,strlen(__CLASS__)-1)];
				$this->view->setModuloActual(__CLASS__);
				$page=$this->view->principal($menuLateralIzquierdo,$menuInferior,$this->user->getTipoUsuario());
				$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$this->user->getNombre()));
				$this->objPaginas->setCabecera($this->view->cabecera());
				$this->objPaginas->setPie($this->view->pie());
				$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
				echo $this->pagina($this->objPaginas);
			}
		}
		function gestionVista($num="")
		{
			$respuesta = new xajaxResponse();
			if(!empty($num)&& is_numeric($num)){
				if($num==1){ //este evento es cuando se registra un usuario
					//se crea el objeto  vista
					$tipoUsuario=$this->model->tipousuario();
					$usuario=$this->view->llenarCombo("tipoUsuario",$tipoUsuario);
					$this->view=new gestionUsuarioV();
					$html=$this->view->registrarUsuario($usuario);
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
				}
				elseif($num==2){ //este evento es cuando se listan los usuarios
					$campos=array(0=>array('id'=>'nombre','nombre'=>'Nombre','Ord'=>'1'),
							  1=>array('id'=>'apellido','nombre'=>'Apellido','Ord'=>'1'),
							  2=>array('id'=>'email','nombre'=>'Correo','Ord'=>'0'),
							  3=>array('id'=>'estado','nombre'=>'Estado','Ord'=>'0'),
							  4=>array('id'=>'accion','nombre'=>'Accion','Ord'=>'0')
							 );
				 	$action=array(0=>array('nomImg'=>'detalle.jpg','eventoJs'=>"onclick=\"xajax_verDetalleUsuario();\"",'alt'=>'Ver'),
			  				   1=>array('nomImg'=>'eliminar15x15.png','eventoJs'=>"onclick=\"if(confirm('Deseas Desactivar un Operador')){xajax_cambiarEstadoUsuario()};\"",'alt'=>'deshabilitar'),
			  				   2=>array('nomImg'=>'habilitar.png','eventoJs'=>"onclick=\"xajax_cambiarEstadoUsuario();\"",'alt'=>'habilitar'),
			  				   3=>array('nomImg'=>'modificar15x15.png','eventoJs'=>"onclick=\"xajax_vermodificarUsuario();\"",'alt'=>'modificar')
			  				 );
			  		$datos=$this->model->listar();
					$html=$this->view->gestionar($campos,$datos,$action);
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
				}
			}
			return $respuesta;
		}
		function guardarUsuario($form){
			$aux=0;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarUsuario($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
					$msm=$this->model->guardar($form);
					$msm=utf8_encode($msm);
					$respuesta->addScript("alert('".$msm."')");
					$nuevapantalla=$this->gestionVista(1);
					$newView=$nuevapantalla->getXML();
					$respuesta->clear("detalles_contenido","innerHTML");
					$respuesta->addAssign("detalles_contenido","innerHTML",$newView->aCommands[1]['data']);
			}
			return $respuesta;
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
	    function verDetalleUsuario($id=""){
	    	$xajax = new xajax();
			$respuesta = new xajaxResponse();
			$pagina=new pagina("index");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Ver Detalle Usuario ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			$dato=$this->model->seleccionar($id);
			$tipoUsuario=$this->model->tipousuario();
			$usuario=$this->view->llenarCombo("tipoUsuario",$tipoUsuario,"",$dato[1][6],1);
			$html=$this->view->registrarUsuario($usuario,$dato,1,$id);
			$pagina->setHTML($html);
			$pagina->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			$html2.=$pagina->flibHtmHead();
			$html2.=$pagina->getHTML();
			$html2.=$pagina->flibCierre();
			$html2=addslashes($html2);
			$html2 = preg_replace("[\n|\r|\n\r]", ' ', $html2);
			$respuesta->addScript("abrirVentana(\"$html2\",'685','500')");
			return $respuesta;
		}
		function modificarUsuario($form="",$id=""){
			$aux=0;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarUsuario($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
					$msm=$this->model->modificar($form,$id);
					$msm=utf8_encode($msm);
					$respuesta->addScript("alert('".$msm."')");
					$respuesta->addScript("window.close()");
			}
			return $respuesta;
		}
	    function vermodificarUsuario($id=""){
			$respuesta = new xajaxResponse();
	    	$xajax = new xajax();
			$xajax->registerFunction(array("modificarUsuario",&$this,"modificarUsuario"));
			$xajax->registerFunction(array("vermodificarUsuario",&$this,"vermodificarUsuario"));
			$pagina=new pagina("index");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Modificar Detalle Usuario ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			$pagina->setVar("charset","charset=ISO-8859-1");
			$pagina->setVar("idioma","Es");
			$pagina->setVar("httpequiv","Content-Type");
			$pagina->setVar("nombre","gestionUsuario.php");
			$pagina->setVar("httpequiv","Content-Type");
			$pagina->setVar("ficJavaScript","redirecciona.js;menu.js;ventana.js;");
			$pagina->setVar("idbody","gestionUsuario");
			$pagina->setVar("divContenido","cont_gestionUsuario");
			$pagina->setVar("javaScriptBody","onload=redirecciona('gestionUsuario');");
			$this->model= new gestionUsuarioM($this->objSesion);
			//se crea el objeto  vista
			$this->view=new gestionUsuarioV();
			$this->view->setPaginaSiguiente($pagina->getVar("nombre"));
			$dato=$this->model->seleccionar($id);
			$tipoUsuario=$this->model->tipousuario();
			$usuario=$this->view->llenarCombo("tipoUsuario",$tipoUsuario,"",$dato[1][6],0);
			$html=$this->view->registrarUsuario($usuario,$dato,0,$id);
			$pagina->setHTML($html);
			$pagina->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			$html2.=$pagina->flibHtmHead();
			$html2.=$pagina->getHTML();
			$html2.=$pagina->flibCierre();
			$html2=addslashes($html2);
			$html2 = preg_replace("[\n|\r|\n\r]", '', $html2);
			$respuesta->addScript( "abrirVentana(\"$html2\",'685','500')");
			return $respuesta;
		}
 		function cambiarEstadoUsuario($evento="",$id=""){
			$respuesta = new xajaxResponse();
			if(is_numeric($evento) && ($evento==1 || $evento==2)){
				if($evento==1)
					$newEstado=0;
				else 
					$newEstado=1;
				$msm=$this->model->actdes($id,$newEstado);
				$msm=utf8_encode($msm);
				$respuesta->addScript("alert('".$msm."')");
				$nuevapantalla=$this->gestionVista(2);
				$newView=$nuevapantalla->getXML();
				$respuesta->addAssign("detalles_contenido","innerHTML",$newView->aCommands[0]['data']);
			}
			return $respuesta;
		}
	}
?>