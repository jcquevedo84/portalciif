<?php
	/**
	*CIIF administracionC
	*
	*Clase Controladora de la pagina index.php
	*Esta clase se encarga de controlar los eventos realizados en la pagina index.php.
	*@copyright CANTV
	*@author Kery P�rez
	*@version 1.0
	*@package indexC
	*
	*/
	class administracionC extends templeteC 
	{
		/**
		*
		*Constructor
		*
		*Esta Funci�n asigna parametros a las variables miembros de la clase.
		*Tambi�n se encarga de ejecutar el hilo del proceso.
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
			//Este es el caso de que se provenga de otra pagina diferente a administracion.php
			//Se crea el objeto model 
			$this->model= new administracionM($this->objSesion);
			//se crea el objeto  vista
			$this->view=new administracionV();
			//instanciamos el objeto de la clase xajax
			$xajax = new xajax();
			//registramos la funci�n creada anteriormente al objeto xajax
			$xajax->registerFunction(array("gestionVista",&$this,"gestionVista"));
			$xajax->registerFunction(array("guardarRolUsuario",&$this,"guardarRolUsuario"));
			$xajax->registerFunction(array("verDetalleRolUsuario",&$this,"verDetalleRolUsuario"));
			$xajax->registerFunction(array("cambiarEstadoRolUsuario",&$this,"cambiarEstadoRolUsuario"));
			$xajax->registerFunction(array("vermodificarRolUsuario",&$this,"vermodificarRolUsuario"));
			$xajax->registerFunction(array("modificarRolUsuario",&$this,"modificarRolUsuario"));
			$xajax->registerFunction(array("redirect",&$objetEvent,"redirect"));
			//El objeto xajax tiene que procesar cualquier petici�n
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
				if($num==1){ //este evento es cuando se muestra la interfaz para registrar un Rol
					//se crea el objeto  vista
					$html=$this->view->registrarRoles();
					$respuesta->addAssign("titulo_contenido","innerHTML","Registrar Rol");
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
				}
				elseif($num==2){ //este evento es cuando se muestra la inerfaz que listan los roles
					$campos=array(0=>array('id'=>'nombre','nombre'=>'Nombre','Ord'=>'1'),
							  1=>array('id'=>'descripcion','nombre'=>'Descripcion','Ord'=>'1'),
							  2=>array('id'=>'estado','nombre'=>'Estado','Ord'=>'0'),
							  3=>array('id'=>'accion','nombre'=>'Accion','Ord'=>'0')
							 );
				 	$action=array(0=>array('nomImg'=>'detalle.jpg','eventoJs'=>"onclick=\"xajax_verDetalleRolUsuario();\"",'alt'=>'Ver'),
			  				   1=>array('nomImg'=>'eliminar15x15.png','eventoJs'=>"onclick=\"if(confirm('Deseas Desactivar un Operador')){xajax_cambiarEstadoRolUsuario()};\"",'alt'=>'deshabilitar'),
			  				   2=>array('nomImg'=>'habilitar.png','eventoJs'=>"onclick=\"xajax_cambiarEstadoRolUsuario();\"",'alt'=>'habilitar'),
			  				   3=>array('nomImg'=>'modificar15x15.png','eventoJs'=>"onclick=\"xajax_vermodificarRolUsuario();\"",'alt'=>'modificar')
			  				 );
			  		$datos=$this->model->listarRol();
					$html=$this->view->gestionar($campos,$datos,$action);
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
				}
			}
			return $respuesta;
		}
		function guardarRolUsuario($form){
			$aux=0;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarRolUsuario($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
					$msm=$this->model->guardarRol($form);
					$msm=utf8_encode($msm);
					$respuesta->addScript("alert('".$msm."')");
					$nuevapantalla=$this->gestionVista(1);
					$newView=$nuevapantalla->getXML();
					$respuesta->addAssign("detalles_contenido","innerHTML",$newView->aCommands[0]['data']);
			}
			return $respuesta;
		}
		function validarRegistraModificarRolUsuario($respuesta="",$form="" ){
			//validacion de nombres
			validaciones::setResul(1);
			$msg[0]=mensajes::$VALIDARCARACTERES_010;
			$msg[1]=mensajes::$VALIDARNOMBRE_006;
			$respuesta=validaciones::validarNombres("txtnombre",$form['txtnombre'],"msg_nombre",$respuesta,$msg);
			//validacion descripci�n
			$msg1[0]=mensajes::$VALIDARCARACTERES_010;
			$msg1[1]=mensajes::$VALIDARDESC_015;
			$respuesta=validaciones::validarVacio("txtdescripcion",$form['txtdescripcion'],"msg_descripcion",$respuesta,$msg1);
			return $respuesta;
		}
	    function verDetalleRolUsuario($id=""){
	    	$xajax = new xajax();
			$respuesta = new xajaxResponse();
			$pagina=new pagina("index");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Ver Detalle Rol ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			$dato=$this->model->seleccionarRol($id);
			$html=$this->view->registrarRoles($dato,1,$id);
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
		function modificarRolUsuario($form="",$id=""){
			$aux=0;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarRolUsuario($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
					$msm=$this->model->modificarRol($form,$id);
					$msm=utf8_encode($msm);
					$respuesta->addScript("alert('".$msm."')");
					$respuesta->addScript("window.close()");
			}
			return $respuesta;
		}
	    function vermodificarRolUsuario($id=""){
			$respuesta = new xajaxResponse();
	    	$xajax = new xajax();
			$xajax->registerFunction(array("modificarRolUsuario",&$this,"modificarUsuario"));
			$xajax->registerFunction(array("vermodificarRolUsuario",&$this,"vermodificarUsuario"));
			$pagina=new pagina("index");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Ver Detalle Rol ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			/*$pagina=new pagina("administracion");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Modificar Detalle Rol ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			$pagina->setVar("charset","charset=ISO-8859-1");
			$pagina->setVar("idioma","Es");
			$pagina->setVar("httpequiv","Content-Type");
			$pagina->setVar("nombre","administracion.php");
			$pagina->setVar("httpequiv","Content-Type");
			$pagina->setVar("ficJavaScript","redirecciona.js;menu.js;ventana.js;");
			$pagina->setVar("idbody","administracion");
			$pagina->setVar("divContenido","cont_administracion");
			$pagina->setVar("javaScriptBody","onload=redirecciona('administracion');");*/
			$this->view->setPaginaSiguiente($pagina->getVar("nombre"));
			$dato=$this->model->seleccionarRol($id);
			$html=$this->view->registrarRoles($dato,0,$id);
			$pagina->setHTML($html);
			$pagina->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			$html2.=$pagina->flibHtmHead();
			$html2.=$pagina->getHTML();
			$html2.=$pagina->flibCierre();
			$html2=addslashes($html2);
			$html2 = preg_replace("[\n|\r|\n\r]", '', $html2);
			//echo $html2;
			$respuesta->addScript( "abrirVentana(\"$html2\",'685','500')");
			//$respuesta->addAssign("detalles_contenido","innerHTML",$html2);
			return $respuesta;
		}
		function listarRol($evento="",$id=""){
			$respuesta = new xajaxResponse();
			if(is_numeric($evento) && ($evento==1 || $evento==2)){
				if($evento==1)
					$newEstado=0;
				else 
					$newEstado=1;
				$msm=$this->model->actdesRol($id,$newEstado);
				$msm=utf8_encode($msm);
				$respuesta->addScript("alert('".$msm."')");
				$nuevapantalla=$this->gestionVista(2);
				$newView=$nuevapantalla->getXML();
				$respuesta->addAssign("detalles_contenido","innerHTML",$newView->aCommands[0]['data']);
			}
			return $respuesta;
		}
	    function cambiarEstadoRolUsuario($evento="",$id=""){
	    	$respuesta = new xajaxResponse();
			if(is_numeric($evento) && ($evento==1 || $evento==2)){
				if($evento==1)
					$newEstado=0;
				else 
					$newEstado=1;
				$msm=$this->model->actdesRol($id,$newEstado);
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