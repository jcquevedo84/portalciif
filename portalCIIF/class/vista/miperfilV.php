<?php
//TODO culminar documentacion de metodos
	/**
	*CIIF miPerfilV
	*
	*Clase Vista de la Pagina miPerfilV.php
	*En esta clase se encuentran todas las interfaces de la pagina gestionUsuario.php
	*@copyright CANTV
	*@author Kery P�rez
	*@version 1.0
	*@package miPerfilV
	*
	*/
	class miPerfilV extends templeteV  
	{
		/**
		*
		*Constructor
		*
		*Esta Funci�n asigna parametros a las variables miembros de la clase.
		*
		*@param string $dirImagenes es la direcci�n donde se encuentran las imagenes de la aplicaci�n.
		*@param string $divCont es id de el div donde se colocara todo el contenido de la pagina.
		*@param array $pagina array que guarda el conjunto de paginas que tiene registrada la aplicaci�n.
		*@return void
		*/
		function __construct($dirImagenes="",$divCont="",$paginas=""){		
			templeteV::__construct(__CLASS__,$dirImagenes,$divCont,$paginas);
		}

	    /**
		*
		*login
		*
		*Esta funci�n devuelve el  cdigo html de  la pantalla principal cuando se entra al sistema
		*
		*@param tipo $tipousuario es tipo de usuario de la aplicaci�n
		*@return tipo $html Devuelve el Html en la pantalla principal cuando se entra al sistema
		*/
	    function principal($menu="",$interfaz="")
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
										<div id=\"contenido\" style=\"font-size:12px width:918px; position: absolute;\">
											<div id=\"titulo_contenido\" class=\"titleContenidoD\">
												Mi Perfil
											</div>
											<div id=\"detalles_contenido\" >
													".$interfaz."								
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