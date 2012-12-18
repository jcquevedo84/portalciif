<?php
	/**
	*CIIF vulnerabilidadesC
	*
	*Clase Controladora de la pagina vulnerabilidades.php
	*Esta clase se encarga de controlar los eventos realizados en la pagina index.php.
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package vulnerabilidadesC
	*
	*/
	class vulnerabilidadesC extends templeteC 
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
			$this->objPaginas = new pagina(substr(__CLASS__,0,strlen(__CLASS__)-1),$this->objError);
			//Este es el caso de que se provenga de otra pagina diferente a vulnerabilidades.php
			//Se crea el objeto model 
			$this->model= new vulnerabilidadesM($this->objSesion);
			//se crea el objeto  vista
			$this->view=new vulnerabilidadesV();
			//instanciamos el objeto de la clase xajax
			$xajax = new xajax();
			//registramos la función creada anteriormente al objeto xajax
			$xajax->registerFunction(array("gestionVista",&$this,"gestionVista"));
			$xajax->registerFunction(array("guardarVulnerabilidad",&$this,"guardarVulnerabilidad"));
			$xajax->registerFunction(array("verDetalleVulnerabilidad",&$this,"verDetalleVulnerabilidad"));
			$xajax->registerFunction(array("cambiarEstadoVulnerabilidad",&$this,"cambiarEstadoVulnerabilidad"));
			$xajax->registerFunction(array("modificarVulnerabilidad",&$this,"modificarVulnerabilidad"));
			$xajax->registerFunction(array("buscarVulnerabilidad",&$this,"buscarVulnerabilidad"));
			$xajax->registerFunction(array("mostrarSubCaso",&$this,"mostrarSubCaso"));
			$xajax->registerFunction(array("ocultarSubCaso",&$this,"ocultarSubCaso"));
			$xajax->registerFunction(array("redirect",&$objetEvent,"redirect"));
			$xajax->registerFunction(array("imprimirPdf",&$this,"imprimirPdf"));
			
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
				$b=$this->objSesion->get("menuModulos");//optimizar estas lineas//optimizar estas lineas
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
		function gestionVista($num="",$tipo="",$tituloSubCaso="",$idCaso="")
		{
			$respuesta = new xajaxResponse();
			if(!empty($num)&& is_numeric($num)){
				if($num==1){ //este evento es cuando se muestra la interfaz para registra un caso
					//se crea el objeto  vista
					$this->view=new vulnerabilidadesV();
					$respuesta->addAssign("titulo_contenido","innerHTML","Registro de Vulnerabilidad");
					$html=$this->view->registrarVulnerabilidad("Datos de la Vulnerabilidad",$tipo);
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
					$respuesta->addScript("calen();");
				}
				elseif($num==2){//Es este es el evento cuando se muestra la interfaz para registra un subcaso
					$this->view=new vulnerabilidadesV();
					if(!empty($idCaso)) //Se muestar la interfaz en el caso de que se halla registrado primero la vulnerabilidad y se van a registrar un sub caso
						$html=$this->view->registrarVulnerabilidad("Datos del Sub Caso",$tipo,$idCaso);
					else //Este es el caso que se muestra la interfaz para registrar un solo subcaso a una vulnerabilidad
						$html=$this->view->registrarVulnerabilidad("Datos del Sub Caso",$tipo);
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
					if(empty($tituloSubCaso)&& empty($idCaso))//Se actualiza el titulo cuando se va ha mostrar la interfaz para registrar un solo subcaso a una vulnerabilidad
						$respuesta->addAssign("titulo_contenido","innerHTML","Registro de Sub Caso");
					if(!empty($tituloSubCaso))
						$respuesta->addAssign("titulo_contenido","innerHTML","Registro de Sub Caso de la Vulnerabilidad ".$tituloSubCaso);
					$respuesta->addScript("calen();");
				}
				elseif($num==3){//Es este es el evento cuando se muestra la interfaz para  busca un caso
					$this->view=new vulnerabilidadesV();
					$html=$this->view->buscarVulnerabilidad("Busqueda de Caso/Sub-Caso");
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
				}
				elseif($num==4){ //este evento es cuando se muestra la interfaz para listan los casos
					$campos=array(0=>array('id'=>'identificador','nombre'=>'Identificador','Ord'=>'1'),
							  1=>array('id'=>'nombre','nombre'=>'Nombre del Caso','Ord'=>'1'),
							  2=>array('id'=>'cantidadsubcaso','nombre'=>'Cantidad Subcaso','Ord'=>'0'),
							  3=>array('id'=>'status','nombre'=>'Status','Ord'=>'0'),
							  4=>array('id'=>'accion','nombre'=>'Accion','Ord'=>'0')
							 );
				 	$action=array(0=>array('nomImg'=>'detalle.jpg','eventoJs'=>"onclick=\"xajax_verDetalleVulnerabilidad();\"",'alt'=>'Ver'),
			  				   1=>array('nomImg'=>'eliminar15x15.png','eventoJs'=>"onclick=\"if(confirm('Deseas Desactivar la Vulnerabilidad')){xajax_cambiarEstadoVulnerabilidad()};\"",'alt'=>'deshabilitar'),
			  				   2=>array('nomImg'=>'habilitar.png','eventoJs'=>"onclick=\"xajax_cambiarEstadoVulnerabilidad();\"",'alt'=>'habilitar'),
			  				   3=>array('nomImg'=>'modificar15x15.png','eventoJs'=>"onclick=\"xajax_modificarVulnerabilidad();\"",'alt'=>'modificar'),
			  				   4=>array('nomImg'=>'pdf.gif','eventoJs'=>"onclick=\"xajax_imprimirPdf();\"",'alt'=>'modificar')
			  				 );
			  		$datos=$this->model->listar();
					$html=$this->view->gestionar($campos,$datos,$action);
					$respuesta->addAssign("detalles_contenido","innerHTML",$html);
				}
			}
			return $respuesta;
		}
		function guardarVulnerabilidad($form,$tipo="",$idCaso=""){
			$aux=0;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarVulnerabilidad($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
					$msm=$this->model->guardar($form,$tipo,$idCaso);
					$msm=explode(",", $msm);
					$respuesta->addScript("alert('".utf8_encode($msm[0])."')");
					if(count($msm)==3){
						$html="if(confirm('¿Deseas Registrar un subcaso?')){xajax_gestionVista(2,2,'".$msm[1]."','".$msm[2]."');}else{xajax_gestionVista(1,1);}";
						$html=utf8_encode($html);
						$respuesta->addScript($html);
					}
					else {
						$html="if(confirm('¿Deseas Registrar un subcaso?')){xajax_gestionVista(2,2,'','".$msm[1]."');}else{xajax_gestionVista(1,1);}";
						$html=utf8_encode($html);
						$respuesta->addScript($html);
					}	
			}
			return $respuesta;
		}
		function validarRegistraModificarVulnerabilidad($respuesta="",$form="" ){
			validaciones::setResul(1);
			$respuesta->addAssign("msg_casoVulnerabilidad","innerHTML","");
			$respuesta->addAssign("msg_descripcion","innerHTML","");
			$respuesta->addAssign("msg_rt","innerHTML","");
			$respuesta->addAssign("msg_fecha1","innerHTML","");
			$respuesta->addAssign("msg_txtresponsable","innerHTML","");
			if(isset($form['txtcasoVulnerabilidadPadre']))
				$respuesta=validaciones::validarvacio("txtcasoVulnerabilidadPadre",$form['txtcasoVulnerabilidadPadre'],"msg_casoVulnerabilidadPadre",$respuesta,mensajes::$_014VALIDARCASO);
			//Se valida que el caso no debe de ser vacio
			$respuesta=validaciones::validarvacio("txtcasoVulnerabilidad",$form['txtcasoVulnerabilidad'],"msg_casoVulnerabilidad",$respuesta,mensajes::$_014VALIDARCASO);
			//validacion descripción
			$respuesta=validaciones::validarVacio("txtdescripcion",$form['txtdescripcion'],"msg_descripcion",$respuesta,mensajes::$_015VALIDARDESC);
			//validar RT 
			$respuesta=validaciones::validarVacio("txtrt",$form['txtrt'],"msg_rt",$respuesta,mensajes::$_019VALIDARRT);
			//validacion fecha detaectada
			$respuesta=validaciones::validarVacio("txtfecha1",$form['txtfecha1'],"msg_fecha1",$respuesta,mensajes::$_016VALIDARFECHADETECTADA);
			//validacion de responsable
			$respuesta=validaciones::validarVacio("txtresponsable",$form['txtresponsable'],"msg_txtresponsable",$respuesta,mensajes::$_017VALIDARRESPONSABLE);	
			return $respuesta;
		}
	    function verDetalleVulnerabilidad($id=""){
	    	$xajax = new xajax();
			$respuesta = new xajaxResponse();
			$pagina=new pagina("index");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Ver Detalle Vulnerabilidad ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			$dato=$this->model->verDetalle($id);
			$html=$this->view->registrarVulnerabilidad("Detalle de Vulnerabilidad","",$id,$dato,1);
			$pagina->setHTML($html);
			$pagina->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			$html2.=$pagina->flibHtmHead();
			$html2.=$pagina->getHTML();
			$html2.=$pagina->flibCierre();
			$html2=addslashes($html2);
			$html2 = preg_replace("[\n|\r|\n\r]", ' ', $html2);
			$respuesta->addScript( "abrirVentana(\"$html2\",'685','500')");
			return $respuesta;
		}
	    function modificarVulnerabilidad($id=""){
			$xajax = new xajax();
			$respuesta = new xajaxResponse();
			$pagina=new pagina("index");
			$pagina->setVar("javaScriptGeneral","window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../librerias/xajax/xajax_js/xajax.js'); } }, 6000);");
			$pagina->setVar("titulo","Portal  - Modificar Detalle Usuario ");
			$pagina->setVar("ficEstilos","estilo.css;contenidos.css;");
			$pagina->setVar("ficJavaScript","calendar.js;calendar-es.js;calendar-setup.js;calendarioFecha.js;");
			$dato=$this->model->verDetalle($id);
			$html=$this->view->registrarVulnerabilidad("Detalle de Vulnerabilidad","",$id,$dato,0);
			$pagina->setHTML($html);
			//TODO INCLUIR EL METODO calen EN EL JAVASCRIPT
			$pagina->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			$html2.=$pagina->flibHtmHead();
			$html2.=$pagina->getHTML();
			$html2.=$pagina->flibCierre();
			$html2=addslashes($html2);
			$html2 = preg_replace("[\n|\r|\n\r]", ' ', $html2);
			$respuesta->addScript( "abrirVentana(\"$html2\",'685','500')");
			return $respuesta;
		}
		function cambiarEstadoVulnerabilidad($evento="",$id=""){
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
				$n=$nuevapantalla->getXML();
				$respuesta->clear("detalles_contenido","innerHTML");
				$respuesta->addAssign("detalles_contenido","innerHTML",$n->aCommands[1]['data']);
			}
			return $respuesta;
		}
		function validarBuscarVulnerabilidad($respuesta="",$form=""){
			validaciones::setResul(1);
			if($form["opcionbusqueda"]=="numero"){
				$msg[0]=mensajes::$BUSQUEDA_022;
				$msg[1]=mensajes::$BUSQUEDA_023;
				$respuesta=validaciones::validarNumeros("txttextbusqueda",$form['txttextbusqueda'],"msg_textbusqueda",$respuesta,$msg);
			}
			elseif ($form["opcionbusqueda"]=="nombre"){
				$msg[0]=mensajes::$BUSQUEDA_024;
				$msg[1]=mensajes::$BUSQUEDA_023;
				$respuesta=validaciones::validarVacio("txttextbusqueda",$form['txttextbusqueda'],"msg_textbusqueda",$respuesta,$msg);
			}
			elseif ($form["opcionbusqueda"]=="descripcion"){
				$msg[0]=mensajes::$BUSQUEDA_024;
				$msg[1]=mensajes::$BUSQUEDA_023;
				$respuesta=validaciones::validarVacio("txttextbusqueda",$form['txttextbusqueda'],"msg_textbusqueda",$respuesta,$msg);
			}
			return $respuesta;
		}
		function buscarVulnerabilidad($form=""){
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarBuscarVulnerabilidad($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
				$campos=array(0=>array('id'=>'identificador','nombre'=>'Identificador','Ord'=>'1'),
							  1=>array('id'=>'nombre','nombre'=>'Nombre del Caso','Ord'=>'1'),
							  2=>array('id'=>'descripcion','nombre'=>'Descripci&oacute;n','Ord'=>'0'),
							  3=>array('id'=>'tipocaso','nombre'=>'Tipo','Ord'=>'0'),
							  4=>array('id'=>'accion','nombre'=>'Accion','Ord'=>'0')
							 );
			 	$action=array(0=>array('nomImg'=>'detalle.jpg','eventoJs'=>"onclick=\"xajax_verDetalleVulnerabilidad();\"",'alt'=>'Ver'),
		  				   3=>array('nomImg'=>'modificar15x15.png','eventoJs'=>"onclick=\"xajax_modificarVulnerabilidad();\"",'alt'=>'modificar')
		  				 );
		  		$datos=$this->model->buscar($form["opcionbusqueda"],$form["txttextbusqueda"]);
				if(!empty($datos)){
					$html=$this->view->mostrarBusqueda($campos,$datos,$action);
				$respuesta->addAssign("resutadobusqueda","innerHTML",$html);
				}
		  		else
					$respuesta->addAssign("resutadobusqueda","innerHTML",mensajes::$BUSQUEDA_025); 	 
			}
			return $respuesta;
		}
		function mostrarSubCaso($idCaso){
			$respuesta = new xajaxResponse();
			$campos=array(0=>array('id'=>'identificador','nombre'=>'Identificador','Ord'=>'1'),
							  1=>array('id'=>'nombre','nombre'=>'Nombre del Caso','Ord'=>'1'),
							  2=>array('id'=>'descripcion','nombre'=>'Descripcion','Ord'=>'0'),
							  3=>array('id'=>'estado','nombre'=>'Estado','Ord'=>'0'),
							  4=>array('id'=>'accion','nombre'=>'Accion','Ord'=>'0')
							 );
			$action=array(0=>array('nomImg'=>'detalle.jpg','eventoJs'=>"onclick=\"xajax_verDetalleVulnerabilidad();\"",'alt'=>'Ver'),
		  				   1=>array('nomImg'=>'eliminar15x15.png','eventoJs'=>"onclick=\"if(confirm('Deseas Desactivar la Vulnerabilidad')){xajax_cambiarEstadoVulnerabilidad()};\"",'alt'=>'deshabilitar'),
		  				   2=>array('nomImg'=>'habilitar.png','eventoJs'=>"onclick=\"xajax_cambiarEstadoVulnerabilidad();\"",'alt'=>'habilitar'),
		  				   3=>array('nomImg'=>'modificar15x15.png','eventoJs'=>"onclick=\"xajax_modificarVulnerabilidad();\"",'alt'=>'modificar')
		  				 );
			$datos=$this->model->mostrarSubCaso($idCaso);
			//print_r($dato);
			$html=$this->view->gestionar($campos,$datos,$action);
			$respuesta->addAssign("txt".$idCaso,"innerHTML",$html);
			$newValor="<img src=\"".varConf::getRutasAccesoImagen("imagenes")."/menos.jpg\" onclick=\"xajax_ocultarSubCaso('$idCaso')\"  style=\"cursor:pointer\"/>";
			$respuesta->addAssign("signomas".$idCaso,"innerHTML",$newValor); 
			return $respuesta;
		}
		function ocultarSubCaso($idCaso){
			$respuesta = new xajaxResponse();
			$respuesta->addAssign("txt".$idCaso,"innerHTML","");
			$newValor="<img src=\"".varConf::getRutasAccesoImagen("imagenes")."/mas.jpg\" onclick=\"xajax_mostrarSubCaso('$idCaso')\"  style=\"cursor:pointer\"/>";
			$respuesta->addAssign("signomas".$idCaso,"innerHTML",$newValor); 
			return $respuesta;
		}
		function imprimirPdf($idCaso)
		{
			require_once '../librerias/html2pdf/html2pdf.class.php';
			$respuesta = new xajaxResponse();
			$campos=array(0=>array('id'=>'identificador','nombre'=>'Identificador','Ord'=>'1'),
							  1=>array('id'=>'nombre','nombre'=>'Nombre del Caso','Ord'=>'1'),
							  2=>array('id'=>'descripcion','nombre'=>'Descripcion','Ord'=>'0'),
							  3=>array('id'=>'estado','nombre'=>'Estado','Ord'=>'0')
							 );
			
			$datos=$this->model->mostrarSubCaso($idCaso);
			//print_r($dato);
			$html=$this->view->gestionar($campos,$datos);
			//echo $html;
			try
		    {
		        $html2pdf = new HTML2PDF('P', 'A4', 'es');
		        $html=utf8_encode($html);
		        $html2pdf->writeHTML($html);
		        $html2pdf->Output('../documentos/exemple01.pdf','F');
		    }
		    catch(HTML2PDF_exception $e) {
		        echo $e;
		    }
			$respuesta->addScript("alert('Se ha generado exitoso')");
			return $respuesta;
		}
		function modificarCaso($form="",$id=""){
			$aux=0;
			$respuesta = new xajaxResponse();
			$respuesta=$this->validarRegistraModificarVulnerabilidad($respuesta,$form);
			$aux=validaciones::$resul;
			if ($aux){
					$msm=$this->model->modificar($form,$id);
					$msm=utf8_encode($msm);
					$respuesta->addScript("alert('".$msm."')");
					$respuesta->addScript("window.close()");
			}
			return $respuesta;
		}
	}
?>