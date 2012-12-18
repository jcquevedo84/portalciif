<?php
//TODO CULMINAR DOCUMENACIÓN DE LOS METODOS
class templeteV extends comun{
		/**
		* string que guarda el nombre del dev de contenido  de la pagina gestionUsuario.php.
		* @var string $divCont
		* @access private
		*/
		private $divCont="";
		/**
		* string que guarda el nombre de la pagina que seguira luego del evento.
		* @var string $paginaSiguiente
		* @access private
		*/
		private $paginaSiguiente="";
		/** string que guarda el nombre del modulo actual.
		* @var string $pagina$classActualActual
		* @access private
		*/
		private $moduloActual="";
		/**
		* array que guarda el conjunto de paginas que tiene registrada la aplicación.
		* @var string $pagina
		* @access private
		*/
		private $pagina="";
		/**
		*
		*Constructor
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*
		*@param string $dirImagenes es la dirección donde se encuentran las imagenes de la aplicación.
		*@param string $divCont es id de el div donde se colocara todo el contenido de la pagina.
		*@param array $pagina array que guarda el conjunto de paginas que tiene registrada la aplicación.
		*@return void
		*/
		function __construct($nameClass="",$dirImagenes="",$divCont="",$paginas=""){		
			//TODO Validar $nameClass
			if(!empty($divCont))
				$this->divCont=$divCont;
			else
				$this->divCont=varConf::getAtributosPag(substr($nameClass, 0, -1),"divContenido");
			if(!empty($paginas))
				$this->pagina=$paginas;
			else
				$this->pagina=varConf::getPaginas();
			comun::__construct($dirImagenes);
			
		}
		/**
		*
		*desplegarRegionEditable
		*
		*Esta funcióndevuelve el  cogido html de la región editable
		*
		*@param tipo $htmll es el codigo html que se colocará en la región editable
		*@return tipo $html Devuelve el Html en la región editable
		*/
		function desplegarRegionEditable($htmll=""){
			$html="<table id=\"tblpagina\" class=\"tblpagina\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"400px\" width=\"100%\">
					<tr id=\"panel_cen\" class=\"trpanel_cen\">
						<td align=\"center\">".$htmll."</td>
					</tr>     
					</table>";
			return $html;	
		}
		/**
		*
		*abrirPanelCentral
		*
		*Esta función se le asigna un cogido html a la región editable
		*
		*@param tipo $regionEditable es el codigo html que se colocará en la región editable
		*@return tipo $html Devuelve el Html en la región central
		*/
		function abrirPanelCentral($regionEditable="", $bienvenida=""){
       		$html.="
       		<table id=\"tblpagina\" class=\"tblpagina\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> 
				<!-- Panel Central -->
				<tr id=\"panel_cen\" class=\"trpanel_cen\">
					<td>
						<table id=\"panel_cen\" class=\"tblpanel_cen\" cellpadding=\"0\" cellspacing=\"0\">
							<tr>
								<td class=\"tdeditable2 bordecelda\" align=\"center\">
									<!-- Región de Contenido -->
									<table id=\"region_editable\" class=\"tblregion_editable2 bordecelda\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
											 	<tr height=\"20px\" valign=\"top\">
													<td>
														<table height=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
											 				<tr class=\"trbanner_inf\">
																<td class=\"esquinas\"><img src=\"".$this->dirImagenes."sup_izq2.png\" /></td>
																<td class=\"barra_cen3\" valign=\"middle\"><b style=\"font-size:11px; color:#0000CC\">".$bienvenida."</b></td>
																<td class=\"esquinas\"><img src=\"".$this->dirImagenes."sup_der2.png\" /></td>
															</tr>
											 			</table>
													</td>
												</tr>
												<tr valign=\"top\">
													<td class=\"tdbordefino\">
														<div id=\"detalle\">".$regionEditable."</div>
													</td>
												</tr>
											</table>
											<!-- fin Región de Contenido -->
										</td>
									</tr>
								</table>
							</td>
						</tr>
						</table>
						<!-- fin Panel Central -->
    		";
			return $html;
	    }
	     /**
		*
		*login
		*
		*Esta función devuelve el  cdigo html de  la pantalla principal cuando se entra al sistema
		*
		*@param tipo $tipousuario es tipo de usuario de la aplicación
		*@return tipo $html Devuelve el Html en la pantalla principal cuando se entra al sistema
		*/
	    function principal($menu="",$submenu="",$tipoUsuario="")
    	{
    		//TODO Buscar la forma de asignarle valor ala variable $titulo desde afuera de la aplicacion
    		$html.= "
				<!-- tabla general -->
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td>
							<table>
								<tr>
									<td width=\"175px\" style=\"background-color:#f5f5f5; border-color:#b3cce6; border-style:solid; border-width:1px; vertical-align:top\" >
										<div id=\"div_menuLateral\" style=\"font-size:11px\">
											<div id=\"div_opcionesPrincipal\" >
												".$this->opcionesAdmon($menu, $submenu,$tipoUsuario)."
											</div>
										</div>
									</td>
									<!-- area derecha -->
									<td width=\"985px\" class=\"areaD\">
										<div id=\"contenido\" style=\"font-size:12px width:718px; position: absolute;\">
											<div id=\"titulo_contenido\" class=\"titleContenidoD\"></div>
											<div id=\"detalles_contenido\" class=\"scroll2\"></div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width=\"895px\" align=\"right\">
							<div id=\"div_menuPrincipal\" class=\"menuPrincipal\">
								".$this->menuPrincipal(substr($this->getModuloActual(),0,strlen($this->getModuloActual())-1),$submenu)."
							</div>
						</td>
					</tr>
				</table>						
    		";
    		return $html;	
    	}
	/**
	 * @return string
	 */
	public function getDivCont() {
		return $this->divCont;
	}
	
	/**
	 * @return string
	 */
	public function getPagina() {
		return $this->pagina;
	}
	
	/**
	 * @return string
	 */
	public function getPaginaSiguiente() {
		return $this->paginaSiguiente;
	}
	
	/**
	 * @param string $divCont
	 */
	public function setDivCont($divCont) {
		$this->divCont = $divCont;
	}
	
	/**
	 * @param string $pagina
	 */
	public function setPagina($pagina) {
		$this->pagina = $pagina;
	}
	
	/**
	 * @param string $paginaSiguiente
	 */
	public function setPaginaSiguiente($paginaSiguiente) {
		$this->paginaSiguiente = $paginaSiguiente;
	}
	/**
	 * @return string
	 */
	public function getModuloActual() {
		return $this->moduloActual;
	}
	
	/**
	 * @param string $classActual
	 */
	public function setModuloActual($moduloActual) {
		$this->moduloActual = $moduloActual;
	}


		
}

?>