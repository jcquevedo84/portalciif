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
	class indexC extends templeteC
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
			//Este es el caso de que se provenga de otra pagina diferente a index.php
			//Se crea el objeto model 
			$this->model= new indexM();
			//se crea el objeto  vista
			$this->view=new indexV();
			//instanciamos el objeto de la clase xajax
			$xajax = new xajax();
			//registramos la función creada anteriormente al objeto xajax
			$xajax->registerFunction(array("redirect",&$objetEvent,"redirect"));
			//El objeto xajax tiene que procesar cualquier petición
			$xajax->processRequests();
			$this->objPaginas->setVar("javaScriptGeneral",$xajax->getJavascript("../librerias/xajax/"));
			//actualiza la pagina donde se a ir en la siguiente pagina
			$this->view->setPaginaSiguiente($this->objPaginas->getVar("nombre"));
			//echo $pagOrigen."-".$this->objPaginas->getVar("nombre")."-";
			if(($pagOrigen!=$this->objPaginas->getVar("nombre") && empty($_SESSION["interno"]) )|| ($pagOrigen==$this->objPaginas->getVar("nombre")&& $pagOrigen=="index.php" && empty($_POST["txtusuario"]) && empty($_POST["txtpass"]))){ //pagina de inicio
				//Es la pagina principal
				$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($this->view->login())));
				$this->objPaginas->setCabecera($this->view->cabecera());
				$this->objPaginas->setPie($this->view->pie());
				$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
				echo $this->pagina($this->objPaginas);
			}
			elseif($_POST["txtusuario"] && $_POST["txtpass"]){ //Cuando el usuario presionar el boton Entrar 
				$roles=parse_ini_file("../config/roles.ini",true);
				$menuModulos=parse_ini_file("../config/menuModulos.ini",true);
				$this->objSesion->set("roles",$roles);
				$this->objSesion->set("menuModulos",$menuModulos);
				$usuario=$_POST["txtusuario"];	
				$clave=$_POST["txtpass"];
				if(!empty($usuario) && !empty($clave)){
					$resultadoLogin=$this->model->consultarLogin($usuario,$clave);
					if(!empty($resultadoLogin['resul'])){
						$this->user= new usuario();
				 		$this->user->setNombre($resultadoLogin["resul"][1][2]);
				 		$this->user->setTipoUsuario($resultadoLogin["resul"][1][3]);
				 		$this->user->setIdUsuario($resultadoLogin["resul"][1][1]);
				 		$this->user->setPoo($resultadoLogin["resul"][1][5]);
				 		$this->user->setEmail($resultadoLogin["resul"][1][4]);
				 		$this->user->setApellido($resultadoLogin["resul"][1][6]);		 	
				 		$this->objSesion->set("user",$this->user);
				 		$b=$this->objSesion->get("menuModulos");
				 		$page=$this->view->principal($b[$this->user->getTipoUsuario()]);
					}
					else
						$page=$this->view->login(mensajes::$INGRESO_001);
				}
				
				if(!empty($this->user))
					$nombre=$this->user->getNombre();
				else 
					$nombre="";
				$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$nombre));
				$this->objPaginas->setCabecera($this->view->cabecera());
				$this->objPaginas->setPie($this->view->pie());
				$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
				echo $this->pagina($this->objPaginas);
			}
			else
			{
				if(empty($_POST["txtusuario"]) && $pagOrigen==$this->objPaginas->getVar("nombre")){
					$page=$this->view->login(mensajes::$INGRESO_002);
					$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$nombre));
					$this->objPaginas->setCabecera($this->view->cabecera());
					$this->objPaginas->setPie($this->view->pie());
					$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
					echo $this->pagina($this->objPaginas);
				}
				else if(empty($_POST["txtpass"]) && $pagOrigen==$this->objPaginas->getVar("nombre") ){
				   $page=$this->view->login(mensajes::$INGRESO_003);
				   $this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$nombre));
					$this->objPaginas->setCabecera($this->view->cabecera());
					$this->objPaginas->setPie($this->view->pie());
					$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
					echo $this->pagina($this->objPaginas);
				}
				else 
				{
						unset($_SESSION["interno"]);
						$this->user=$this->objSesion->get("user");
						$b=$this->objSesion->get("menuModulos");//optimizar estas lineas
						$page=$this->view->principal($b[$this->user->getTipoUsuario()]);
						$this->objPaginas->setHTML($this->view->abrirPanelCentral($this->view->desplegarRegionEditable($page),$this->user->getNombre()));
						$this->objPaginas->setCabecera($this->view->cabecera());
						$this->objPaginas->setPie($this->view->pie());
						$this->objPaginas->setContenido($this->objPaginas->setDivContenido($this->objPaginas->getHTML(),$this->view->getDivCont()));
						echo $this->pagina($this->objPaginas);
				}
			}
		}
	}
?>