<?php
	/**
	*CIIF pagina
	*
	*Clase classlibCabPie de la nombreaplicacion
	*En esta clase se encuentran la base para todas las paginas de la aplicaci�n
	*@copyright CANTV
	*@author Kery P�rez
	*@version 1.0
	*@package pagina
	*
	*/
	include_once '../class/exepciones/myExeption.php';
	class pagina
	{
		/**
		* string que guarda la direcci�n de las imagenes.
		* @var Array $dirImagen
		* @access private
		*/
		private $dirImagen="";
		/**
		* Array que guarda los atributos de una p�gina en particular.
		* @var Array $atributos
		* @access private
		*/
		private $atributos=array();
		/**
		* string que guarda el codigo html correspondiente a la cabecera.
		* @var string $cabecera
		* @access private
		*/
		private $cabecera="";
		/**
		* string que guarda el codigo html correspondiente al pie de p�gina.
		* @var string $piePagina
		* @access private
		*/
		private $piePagina="";
		/**
		* string que guarda el codigo html correspondiente al cotenido a mostrar en la p�gina.
		* @var string $contenido
		* @access private
		*/
		private $contenido="";
		/**
		* string que guarda la direcci�n de los archivos css de la aplicaci�n.
		* @var string $dirEstilo
		* @access private
		*/
		private $dirEstilo="";
		/**
		* string que guarda la direcci�n de los archivos js de la aplicaci�n.
		* @var string $dirJavaScript
		* @access private
		*/
		private $dirJavaScript="";
		/**
		* string que guarda todo el codigo html que se desplegara deacuerdo a un evento.
		* @var string $html
		* @access private
		*/
		private $html="";
		/**
		* array que guarda las diferentes direcci�nes de los achivos php. js y css de los diferentes plugins. 
		* @var string $dirPlugins
		* @access private
		*/
		private $dirPlugins=array();
		/**
		* string que guarda los diferentes plugins que se insertaran en la aplicaci�n.
		* @var string $listPlugins
		* @access private
		*/
		private $listPlugins="";
		private $rutaLogs="";
		/**
		*
		*Constructor
		*
		*Esta Funci�n asigna parametros a las variables miembros de la clase.
		*
		*@param array $atributosConf (Obligatorio) Es una array que contiene los atributos de una p�gina en particular.
		*@param string $dirE (Obligatorio) Es la direcci�n de los archivos css de la aplicaci�n.
		*@param string $dirJS (Obligatorio) Es la direcci�n de los archivos js de la aplicaci�n.
		**@param string $dirImg (Obligatorio) Es la direcci�n de las imagenes de la aplicaci�n.
		**@param array $dirPlugins (Obligatorio) array que contien las direcciones en las categorias de php, css y js de  los pugins a incluir.
		**@param array $listPlugins (Obligatorio) array que contien los nombres de los archivos en las categorias de php, css y js dque se van a incluir.
		**@param object $objError (Obligatorio) objeto que se encarga de la gestion de los errores en la pagina
		*@access public
		*@return void
		*/
		public function pagina($atributosConf="",$dirE="",$dirJS="",$dirImg="",$dirPlugins="",$listPlugins="") 
		{
			$this->rutaLogs=varConf::getLogs();
			$this->rutaLogs=$this->rutaLogs["general"];
			try{
				
				if(!empty($atributosConf) and is_array($atributosConf))
					$this->inicializarVariables($atributosConf);
				else 
				{
					if(is_string($atributosConf) and !empty($atributosConf))
						$this->inicializarVariables(varConf::getAtributosPag($atributosConf));
				}
				if(!empty($dirE))
					$this->dirEstilo=$dirE;
				else 
					$this->dirEstilo=varConf::getRutasAccesoEstilo("estilo");;
				if(!empty($dirJS))
					$this->dirJavaScript=$dirJS;
				else 
					$this->dirJavaScript=varConf::getRutasAccesoJs("javaScript");
				if(!empty($dirImg))
					$this->dirImagen=$dirImg;
				else 
					$this->dirImagen=varConf::getRutasAccesoImagen("imagenes");;
				if(!file_exists($this->dirEstilo))
					throw new myExeption(2,$this->rutaLogs,mensajesFrame::$MSG_001,"","FrameWork",__LINE__,__CLASS__,__FUNCTION__);
				if(!file_exists($this->dirJavaScript))
					throw new myExeption(2,$this->rutaLogs,mensajesFrame::$MSG_002,"","FrameWork",__LINE__,__CLASS__,__FUNCTION__);
				if(!file_exists($this->dirImagen))
					throw new myExeption(2,$this->rutaLogs,mensajesFrame::$MSG_003,"","FrameWork",__LINE__,__CLASS__,__FUNCTION__);
			}
			catch (Exception $e){
				//throw new myExeption(2,$this->rutaLogs,$e->getMessage(),$e->getCode(),"FrameWork",__LINE__,__CLASS__,__FUNCTION__);
			}
		}
		/**
		*
		*flibHtmHead
		*
		*Retorna el c�digo $html que se visualizara correspondiente al inicio, head y body de la pagina html.
		*@access public
		*@return string $htmCab
		*/
		public function flibHtmHead($anexo="")
		{
			
			$htmCab="<!--<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 4.01 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>-->
				<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"".$this->atributos['idioma']."\" xml:lang=\"".$this->atributos['idioma']."\" >
				<head>
					<meta http-equiv=\"".$this->atributos['httpequiv']."\" content=\"".$this->atributos['content'].";".$this->atributos['charset']."\">
					<title>".$this->atributos['titulo']."</title>
					".$this->extraeFicherosCCS($this->atributos['ficEstilos'])."
					".$this->extraeFicherosJavaScript($this->atributos['ficJavaScript'])."
					".$this->asignaValidacionesJavaScript($this->atributos['javaScriptGeneral'])."
					
				</head>
				<body ".$this->atributos['javaScriptBody'].">
				<div id=\"".$this->atributos['idbody']."\">
				";
			return $htmCab;
		}
		/**
		*
		*getCabecera
		*
		*Retorna el c�digo $html que se visualizara correspondiente a la cabecera  de la pagina html.
		*@access public
		*@return string $cabecera 
		*/
		public function getCabecera()
		{
			return $this->cabecera;	
		}
		/**
		*
		*getCabecera
		*
		*Funcion que actualiza la cabecera de una pagina
		*@param string $valor (Obligatorio) es un string que contiene el valor que tomara la cabecera de una pagina
		*@access public
		*@return void 
		*/
		public function setCabecera($valor="")
		{
			if(is_string($valor))
				$this->cabecera=$valor;
		}
		 /**
		*
		*getContenido
		*
		*Retorna el c�digo $html que se visualizara correspondiente al contenido  de la pagina html.
		*@access public
		*@return string $contenido
		*/
		public function getContenido()
		{
			return $this->contenido;
		}
		/**
		*
		*setContenido
		*
		*Funcion que actualiza el contenido de una pagina
		*@param string $valor (Obligatorio) es un string que contiene el valor que tomara el contenido
		*@access public
		*@return void 
		*/
		public function setContenido($valor="")
		{
			if(is_string($valor))
				$this->contenido=$valor;
		}
		/**
		*
		*getPie
		*
		*Retorna el c�digo $html que se visualizara correspondiente al pie de p�gina  de la pagina html.
		*@access public
		*@return string $piePagina 
		*/
		public function getPie()
		{
			return $this->piePagina;
		}
		/**
		*
		*setPie
		*
		*Funcion que actualiza el pie de pagina de una pagina
		*@param string $valor (Obligatorio) es un string que contiene el valor que tomara el pie de pagina de una pagina
		*@access public
		*@return void 
		*/
		public function setPie($valor="")
		{
			if(is_string($valor))
				$this->piePagina=$valor;
		}
		 /**
		*
		*flibCierre
		*
		*Retorna el c�digo $html que se visualizara correspondiente al cierre del inicio, body de la pagina html.
		*@access public
		*@return string $html 
		*/
		public function flibCierre()
		{
			$html="</div></body></html>";
			return $html;
		}
		/**
		*
		*extraeFicherosCCS
		*
		*Esta funcion extrae la lista de ficheros de Estilo que se utilizaran en la pagina
		*@param string $ficheroEstilos (Obligatorio) Es un string que contiene los nombre de los archivos de estilos que seran
		*											 incluido en la pagina. Los nombres deben estar separado por ;
		*@access private
		*@return string $html string con cada uno de los archivos js  maquetados
		*/
		private function extraeFicherosCCS($ficheroEstilos="")
		{
			$html="";
			$arrayEstilos=explode(";",$ficheroEstilos);
			$tam=count($arrayEstilos);
			if($tam>0)
			{
				for($i=0;$i<$tam-1;$i++)
					$html.=$this->incluirFicheroCSS($arrayEstilos[$i],$this->dirEstilo);
			}
			return $html;		
		}
		/**
		*
		*extraeFicherosPluingsJavaScript
		*
		*Incluye todos los archivos css de cada pluings insertado.
		*@param string $arrayPhp (Obligatorio) es un array que contiene los archivos a incluir por cada uno de los plugins. 
		*@param string $nombrePluings es un string que contiene el nombre de los plugins separados por coma,
		*@access private
		*@return string $html string con cada uno de los archivos js  maquetados
		*/
		private function extraeFicherosPluingsCCS($arrayEstilos="",$nombrePluings="")
		{
			$html="";
			if(!empty($this->listPlugins))
			{
				$ccsAccesibles=explode(",",$this->listPlugins['css']);
				$arrayNombrePluings=explode(",",$nombrePluings);
				$tam1=count($arrayNombrePluings);
				if($tam1>0)
				{
					for($j=0;$j<$tam1;$j++)
					{
						if(in_array($arrayNombrePluings[$j],$ccsAccesibles))
						{
							$tam=count($arrayEstilos[$arrayNombrePluings[$j]]);
							if($tam>0)
							{
								for($i=0;$i<$tam;$i++)
									$html.=$this->incluirFicheroCSS(trim($arrayEstilos[$arrayNombrePluings[$j]][$i]),$this->dirPlugins["css"].trim($arrayNombrePluings[$j])."/");
							}
						}
					}	
				}
				return $html;	
			}
			else 
			{
				return "";
			}
		}
		/**incluirFicheroCSS
		*
		*Esta funcion incluye la lista de ficheros de css que se utilizaran en la pagina
		*@param string $ficheroEstilos (Obligatorio) Es un string que contiene los nombre de los archivos de estilos que seran
		*											 incluido en la pagina. Los nombres deben estar separado por ;
		*@access private
		*@return string $html string con cada uno de los archivos js  maquetados
		*/
		public function incluirFicheroCSS($nombreFichero,$direccionFichero)
		{
			$html="";
			$dirF=$direccionFichero.$nombreFichero;
			if(preg_match('/\\\/',$dirF))
				$dirF = str_replace('\\', '/', $dirF);
			if(file_exists($dirF))
				$html="<link href=\"".$dirF."\" rel=\"stylesheet\" type=\"text/css\">\n";
			else
				echo "error";
			return $html;
		}
		/**
		*
		*extraeFicherosPluingsJavaScript
		*
		*Incluye todos los archivos js de cada pluings insertado.
		*@param string $arrayPhp (Obligatorio) es un array que contiene los archivos a incluir por cada uno de los plugins. 
		*@param string $nombrePluings es un string que contiene el nombre de los plugins separados por coma,
		*@access private
		*@return string $html string con cada uno de los archivos js  maquetados
		*/
		private function extraeFicherosPluingsJavaScript($arrayJavaScript="",$nombrePluings="")
		{
			$html="";
			if(!empty($this->listPlugins))
			{
				$jsAccesibles=explode(",",$this->listPlugins['js']);
				$arrayNombrePluings=explode(",",$nombrePluings);
				$tam1=count($arrayNombrePluings);
				if($tam1>0)
				{
					for($j=0;$j<$tam1;$j++)
					{
						if(in_array($arrayNombrePluings[$j],$jsAccesibles))
						{
							$tam=count($arrayJavaScript[$arrayNombrePluings[$j]]);
							if($tam>0)
							{
								for($i=0;$i<$tam;$i++)
									$html.=$this->incluirFicheroJavaScript(trim($arrayJavaScript[$arrayNombrePluings[$j]][$i]),$this->dirPlugins["js"].trim($arrayNombrePluings[$j])."/");
							}
						}
					}	
				}
				return $html;	
			}
			else 
			{
				return "";
			}
		}
		/**
		*
		*extraeFicherosPluingsPhp
		*
		*Incluye todos los archivos php de cada pluings insertado.
		*@param string $arrayPhp (Obligatorio) es un array que contiene los archivos a incluir por cada uno de los plugins. 
		*@param string $nombrePluings es un string que contiene el nombre de los plugins separados por coma,
		*@access private
		*@return string void
		*/
		private function extraeFicherosPluingsPhp($arrayPhp="",$nombrePluings="")
		{
			$html="";
			if(!empty($this->listPlugins))
			{
				$phpAccesibles=explode(",",$this->listPlugins['php']);
				$arrayNombrePluings=explode(",",$nombrePluings);
				$tam1=count($arrayNombrePluings);
				if($tam1>0)
				{
					for($j=0;$j<$tam1;$j++)
					{
						if(in_array($arrayNombrePluings[$j],$phpAccesibles))
						{
							$tam=count($arrayPhp[$arrayNombrePluings[$j]]);
							rsort($arrayPhp[$arrayNombrePluings[$j]]);
							reset($arrayPhp[$arrayNombrePluings[$j]]);
							if($tam>0)
							{
								for($i=0;$i<$tam;$i++)
								{
									if(file_exists($this->dirPlugins["php"].trim($arrayNombrePluings[$j])."/".trim($arrayPhp[$arrayNombrePluings[$j]][$i])))
										require_once($this->dirPlugins["php"].trim($arrayNombrePluings[$j])."/".trim($arrayPhp[$arrayNombrePluings[$j]][$i]));
									else
										throw new myExeption(2,mensajesFrame::$MSG_004." ".$this->dirPlugins["php"].trim($arrayNombrePluings[$j])."/".trim($arrayPhp[$arrayNombrePluings[$j]][$i]),"","FrameWork",__LINE__,__CLASS__,__FUNCTION__);
								}
							}
						}
					}	
				}
			}
		}
		/**
		*
		*extraeFicherosJavaScript
		*
		*Esta funcion extrae la lista de ficheros de JavaScript que se utilizaran en la pagina
		*@param string $ficheroJavaScript (Obligatorio) Es un string que contiene los nombre de los archivos de estilos que seran
		*											 incluido en la pagina. Los nombres deben estar separado por ;
		*@access private
		*@return string $html
		*/
		private function extraeFicherosJavaScript($ficheroJavaScript="")
		{
			$html="";
			$arrayJavaScript=explode(";",$ficheroJavaScript);
			$tam=count($arrayJavaScript);
			if($tam>0)
			{
				for($i=0;$i<$tam-1;$i++)
					$html.=$this->incluirFicheroJavaScript($arrayJavaScript[$i],$this->dirJavaScript);
			}
			return $html;		
		}
		/**
		*
		*incluirFicheroJavaScript
		*
		*
		*@param string $nombreFichero (Obligatorio) Es un string que contiene los nombre del archivo de estilos que seran incluido en la pagina
*		*@param string $direccionFichero (Obligatorio) Es un string que contiene la direcci�n relativa donde se encuentra el fichero
		*@access private
		*@return string $html
		*/
		public function incluirFicheroJavaScript($nombreFichero,$direccionFichero)
		{
			$html="";
			$dirF=$direccionFichero.$nombreFichero;
			if(preg_match('/\\\/',$dirF))
				$dirF = str_replace('\\', '/', $dirF);
			if(file_exists($dirF))
				$html="<SCRIPT type=\"text/javascript\" src=\"".$dirF."\"></SCRIPT>\n";
			else
				throw new myExeption(2,mensajesFrame::$MSG_002." ".$dirF,"","FrameWork",__LINE__,__CLASS__,__FUNCTION__);
			return $html;
		}
		/**
		*
		*extraeValidacionesJavaScript
		*
		*Es la encargad de colocar codigo javascript en el head
		*@param string $codJavaScript (Obligatorio) es un string que contiene todo el codigo javascript 
		*@access public
		*@return string $html
		*/
		public function asignaValidacionesJavaScript($codJavaScript="")
		{
			$html="";
			if($codJavaScript!="")
			{
					if(!preg_match("/javascript/",$codJavaScript))
						$html.="<SCRIPT type=\"text/javascript\">".$codJavaScript."</SCRIPT>\n";
					else
						$html.=$codJavaScript;
			}
			return $html;		
		}
		/**
		*
		*@name inicializarVariables
		*Esta funcion inicializa todos los atributos que contiene una pagina
		*@param Array $valores (Obligatorio) Es la matriz que contiene los nombres de los atributos y los valores
		*@access private
		*@return void 
		*/
		private function inicializarVariables($valores="")
		{
			if((!empty($valores))&&(is_array($valores)))
			{
				$tam=count($valores);
				if($tam>0)
				{
					while (list($key, $val) = each($valores)) 
						$this->setVar($key,$val);
				}
			}
		}
		/**
		*
		*setVar
		*
		*Funcion que actualiza el contenido de una atributo de una pagina.
		*@param string $nombre (Obligatorio) Es el nombre del atributo.
		*@param string $valor (Obligatorio) Es el valor que tomara el atributo.
		*@access public
		*@return void 
		*/
		public function setVar($nombre="",$valor="")
		{
			$this->atributos[$nombre]=$valor;
		}
		/**
		*
		*getVar
		*
		*Funcion que retorna el contenido de una atributo de una pagina.
		*@param string $nombre (Obligatorio) Es el nombre del atributo.
		*@access public
		*@return string 
		*/
		public function getVar($nombre="")
		{
			return $this->atributos[$nombre];
		}
		/**
		*
		*setDivContenido
		*
		*Es la encargada de asignarle un valor a la variable $html que se visualizara en el brower y es impreso 
		*@param string $contenido (Obligatorio) es un string que contiene todo el codigo html que se va a mostrar en el brower
		**@param string $divCont (Obligatorio) esting que contien el nombre del el div principal.
		*@access public
		*@return $string  $html es todo el contenido html maquetado
		*/
		public function setDivContenido($contenido="",$divCont="")
	    {
	    	$html="";
	    	$html.="<div id=\"".$divCont."\">";
	    	$html.=$contenido;
	    	$html.="</div>";
	    	return $html;
	    }
		/**
		*
		*getHTML
		*
		*Es la encarga de retornar lo que se visualizara en el brower
		*
		*@access public
		*@return string $this->$html codigo html que se visualizara en el brower de la pagina
		*/
		public function getHTML() 
		{
			return $this->html;
	    }
	    /**
		*
		*setHTML
		*
		*Es la encargada de asignarle un valor a la variable $html que se visualizara en el brower y es impreso 
		*@param string $contenido (Obligatorio) es un string que contiene todo el codigo html que se va a mostrar en el brower
		*@access public
		*@return void 
		*/
	    public function setHTML($contenido="")
	    {
	    	if(is_string($contenido))
	    		$this->html=$contenido;
	    }
	    /**
		*
		*scandirByExt
		*
		*Insrta en un array los nombres de los archivos con una extensi�n especifica, y luego reorna esa matriz.
		*@param string $dir es la direcci�n relativa de la carpeta en donde se buscara los archivos de una extensi� especifica.
		*@param string $extension es la extensi�n de los archivos que desea buscar.
		*@param string $nombrePluings es un string que contiene el nombre de los plugins separados por coma,
		*@access private
		*@return array $files array con todos los nombres de los archivos correspondiente a todos los plugins.
		*/
	    private function scandirByExt($dir="", $extension="",$nombrePluings="")
		{
		    if((!empty($dir))and (!empty($extension)) and (!empty($nombrePluings)))
		    {
			    $arrayNombrePluings=explode(",",$nombrePluings);
				$tam1=count($arrayNombrePluings);
				$files = array();
				if($tam1>0)
				{
				    for($j=0;$j<$tam1;$j++)
					{
					    $dh  = opendir($dir.trim($arrayNombrePluings[$j]));
					    while (false !== ($filename = readdir($dh))) 
					    {
				            if (substr(strrchr($filename, "."), 1) == $extension) 
				                $files[$arrayNombrePluings[$j]][] = $filename;
					    }
					}
				}
				return $files;
		    }
		    else 
		    {
		    	return "";
		    }
		}
    }
?>