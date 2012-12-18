<?php
	/**
	*CIIF indicadoresC
	*
	*Clase Controladora de la pagina index.php
	*Esta clase se encarga de controlar los eventos realizados en la pagina index.php.
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexC
	*
	*/
	class indicadoresC extends templeteC 
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
			//Este es el caso de que se provenga de otra pagina diferente a indicadores.php
			//Se crea el objeto model 
			$this->model= new indicadoresM($this->objSesion);
			//se crea el objeto  vista
			$this->view=new indicadoresV();
			//instanciamos el objeto de la clase xajax
			$xajax = new xajax();
			//registramos la función creada anteriormente al objeto xajax
			$xajax->registerFunction(array("gestionVista",&$this,"gestionVista"));
			$xajax->registerFunction(array("generarGraficoIndicadores",&$this,"generarGraficoIndicadores"));
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
				//TODO VALIDAR POR QUE SI ES UNO SOLO DA ERROR AL PRESIONAR CLICK EN EL MENU IZQUIERDO
				$page=$this->view->principal($menuLateralIzquierdo,$menuInferior,$this->user->getTipoUsuario());
				$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$this->user->getNombre()));
				$this->objPaginas->setCabecera($this->view->cabecera());
				$this->objPaginas->setPie($this->view->pie());
				$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
				echo $this->pagina($this->objPaginas);
			}
		}
		function gestionVista()
		{
			$respuesta = new xajaxResponse();
			$html=$this->view->generarIndicadores();
			$respuesta->addAssign("titulo_contenido","innerHTML","Generar Indicadores");
			$respuesta->addAssign("detalles_contenido","innerHTML",$html);
			return $respuesta;
		}
		function validarRegistraModificarRolUsuario($respuesta="",$form="" ){
			//validacion de nombres
			validaciones::setResul(1);
			$msg[0]=mensajes::$VALIDARCARACTERES_010;
			$msg[1]=mensajes::$VALIDARNOMBRE_006;
			$respuesta=validaciones::validarNombres("txtnombre",$form['txtnombre'],"msg_nombre",$respuesta,$msg);
			//validacion descripción
			$msg1[0]=mensajes::$VALIDARCARACTERES_010;
			$msg1[1]=mensajes::$VALIDARDESC_015;
			$respuesta=validaciones::validarVacio("txtdescripcion",$form['txtdescripcion'],"msg_descripcion",$respuesta,$msg1);
			return $respuesta;
		}
		function generarGraficoIndicadores($form){
			$respuesta = new xajaxResponse();
			$html=$this->view->generarIndicadores();

			//include("../librerias/pchart/pchart/pData.class");
			//include("../librerias/pchart/pchart/pChart.class");
			 // Dataset definition 
			 $DataSet = new pData;
			 $DataSet->AddPoint(array(10,2,3,5,3),"Serie1");
			 $DataSet->AddPoint(array("January","February","March","April","May"),"Serie2");
			 $DataSet->AddAllSeries();
			 $DataSet->SetAbsciseLabelSerie("Serie2");
			
			 // Initialise the graph
			 $Test = new pChart(420,250);
			 $Test->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
			 $Test->drawRoundedRectangle(5,5,415,245,5,230,230,230);
			 $Test->createColorGradientPalette(195,204,56,223,110,41,5);
			
			 // Draw the pie chart
			 $Test->setFontProperties("../librerias/pchart/fonts/tahoma.ttf",8);
			 $Test->AntialiasQuality = 0;
			 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
			 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
			
			 // Write the title
			 $Test->setFontProperties("../librerias/pchart/fonts/MankSans.ttf",10);
			 $Test->drawTitle(10,20,"Sales per month",100,100,100);
			 
			 $Test->Render("../imagenes/graficos/example10.png");
			 $html="<img  src=\"../imagenes/graficos/example10.png\" height=\"250px\" width=\"420px\" />";
			$respuesta->addAssign("graficoindicadores","innerHTML",$html);
			return $respuesta;
		}
		/* $DataSet = new pData;
 $DataSet->AddPoint(array(1,4,-3,2,-3,3,2,1,0,7,4),"Serie1");
 $DataSet->AddPoint(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");
 $DataSet->AddPoint(array(4,1,2,-1,-4,-2,3,2,1,2,2),"Serie3");
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie();
 $DataSet->SetSerieName("January","Serie1");
 $DataSet->SetSerieName("February","Serie2");
 $DataSet->SetSerieName("March","Serie3");

 // Initialise the graph
 $Test = new pChart(700,230);
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->setGraphArea(50,30,680,200);
 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
 $Test->drawGraphArea(255,255,255,TRUE);
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
 $Test->drawGrid(4,TRUE,230,230,230,50);

 // Draw the 0 line
 $Test->setFontProperties("Fonts/tahoma.ttf",6);
 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

 // Draw the bar graph
 $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,80);


 // Finish the graph
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->drawLegend(596,150,$DataSet->GetDataDescription(),255,255,255);
 $Test->setFontProperties("Fonts/tahoma.ttf",10);
 $Test->drawTitle(50,22,"Example 12",50,50,50,585);
 $Test->Render("example12.png");*/
	}
?>