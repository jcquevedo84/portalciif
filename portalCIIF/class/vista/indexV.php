<?php
//TODO culminar documentacion de metodos
	/**
	*CIIF indexV
	*
	*Clase Vista de la Pagina index.php
	*En esta clase se encuentran todas las interfaces de la pagina index.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexV
	*
	*/
	class indexV extends templeteV 
	{
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
		function __construct($dirImagenes="",$divCont="",$paginas=""){		
			templeteV::__construct(__CLASS__,$dirImagenes,$divCont,$paginas);
		}
	    /**
		*
		*login
		*
		*Esta función devuelve el  cdigo html del 
		*
		*@return tipo $html Devuelve el Html en la región del autenticación
		*/
	    function login($msg=""){
	    	$html="
	    			<table id=\"tbllogin\" class=\"arealogin\" cellpadding=\"1\" >
					<tr>
						<td>
							<div id=\"areadeacceso\">
								<form id=\"entrarSistema\" name=\"entrarSistema\" method=\"post\" action=\"".$this->pagina[index]."\">
									<table style=\"font-size:10px\" border=\"0\">
										<tr>
											<td align=\"right\">
												<b>Usuario:</b>
											</td>
											<td>
												<input type=\"text\" id=\"usuario\" name=\"txtusuario\" size=\"18\" maxlength=\"20\">
											</td>
										</tr>
										<tr>
											<td align=\"right\">
												<b>Contrase&ntilde;a:</b>
											</td>
											<td>
												<input type=\"password\" id=\"pass\" name=\"txtpass\" size=\"18\" maxlength=\"10\">
											</td>
										</tr>
										<tr>
											<td align=\"center\" colspan=\"2\" >
												<input type=\"submit\" id=\"entrar\" name=\"entrar\" value=\"Entrar\" />
											</td>
										</tr>
										<tr>
											<td colspan=\"2\" align=\"center\">
												<span id=\"msg_entrar\" class=\"acceso2\">".$msg."</span>
											</td>
										</tr>	
									</table>
								</form>
							</div>
						</td>
					</tr>
				</table>
	    	";	
	    	return $html;
	    }
	     /**
		*
		*principal
		*
		*Esta función devuelve el  cdigo html de  la pantalla principal cuando se entra al sistema
		*
		*@param tipo $tipousuario es tipo de usuario de la aplicación
		*@return tipo $html Devuelve el Html en la pantalla principal cuando se entra al sistema
		*/
	    function principal($menu="")
    	{
    		$html.= "
				<!-- tabla general -->
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td>
							<table>
								<tr>
									<!-- area derecha -->
									<td width=\"985px\" class=\"areaD\">
										<div id=\"contenido\" style=\"font-size:12px\">
											<div id=\"titulo_contenido\" class=\"titleContenidoD\">
												Menu Principal
											</div>
											<div id=\"detalles_contenido\"  align=\"center\">
												<table border =\"0\" height=\"100%\" width=\"100%\">
													<tr>
														<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
															<span id=\"botonIndicadores\" onclick=\"xajax_redirect(7);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
															<img src=\"".$this->dirImagenes."indicadores3.PNG\" class=\"imgsinborde\" onclick=\"xajax_redirect(7);\"><br><b>Indicadores</b></a>
															</span>
														</td>
														<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
															<span id=\"botonVulnerabilidades\" onclick=\"xajax_redirect(6);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
															<img src=\"".$this->dirImagenes."vulnerabilidades1.PNG\" class=\"imgsinborde\" onclick=\"xajax_redirect(6);\"><br><b>Vulnerabilidades</b></a>
															</span>
														</td>
													</tr>
													<tr>
														<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
															<span id=\"botonBiblioteca\" onclick=\"xajax_redirect(8);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
															<img src=\"".$this->dirImagenes."bibliotecaS2.PNG\" class=\"imgsinborde\" onclick=\"xajax_redirect(8);\"><br><b>Biblioteca</b></a>
															</span>
														</td>
														<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
															<span id=\"botonProcedimiento\" onclick=\"xajax_redirect(9);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
															<img src=\"".$this->dirImagenes."procedimientos.PNG\" class=\"imgsinborde\" onclick=\"xajax_redirect(9);\"><br><b>Procedimientos</b></a>
															</span>
														</td>
													</tr>
													
												</table>									
											</div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width=\"895px\" align=\"right\">
							<div id=\"div_menuPrincipal\" class=\"menuPrincipal\">
								".$this->menuPrincipal(substr(__CLASS__,0,strlen(__CLASS__)-1),$menu)."
							</div>
						</td>
					</tr>
				</table>						
    		";
    		return $html;	
    	}
	
	}
?>