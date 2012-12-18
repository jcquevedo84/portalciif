<?php
	/**
	*CIIF vulnerabilidadesV
	*
	*Clase Vista de la Pagina index.php
	*En esta clase se encuentran todas las interfaces de la pagina index.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexV
	*
	*/
	class vulnerabilidadesV extends templeteV  
	{
		/*Constructor
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
		*Esta función devuelve el  cdigo html de  la pantalla principal cuando se entra al sistema
		*
		*@param tipo $tipousuario es tipo de usuario de la aplicación
		*@return tipo $html Devuelve el Html en la pantalla principal cuando se entra al sistema
		*/
	    function principal($menu="",$submenu="",$tipoUsuario="")
    	{
    		$html.= "
				<!-- tabla general -->
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
					<tr>
						<td>
							<table>
								<tr>
									<td width=\"150px\" style=\"background-color:#f5f5f5; border-color:#b3cce6; border-style:solid; border-width:1px; vertical-align:top\" >
										<div id=\"div_menuLateral\" style=\"font-size:11px\">
											<div id=\"div_opcionesPrincipal\" style=\"display:block\">
												".$this->opcionesAdmon($menu, $submenu,$tipoUsuario)."
											</div>
										</div>
									</td>
									<!-- area derecha -->
									<td width=\"985px\" class=\"areaD\">
										<div id=\"contenido\" style=\"font-size:12px width:718px; position: absolute; vertical-align:top;\">
											<div id=\"titulo_contenido\" class=\"titleContenidoD\">
												Registrar Vulnerabilidad
											</div>
											<div id=\"detalles_contenido\" class=\"scroll2\">
																					
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
	    
		/**
		*
		*crear
		*
		*Esta función crea el codigo html para visualizar, cargar y modificar los datos
		*
		*@param string $comboEstado Es el codigo html del combo estado 
		*@param string $comboMunicipio Es el codigo html del combo municipio 
		*@param string $comboParroquia Es el codigo html del combo parroquia 
		*@param array $form confiene los datos del registro que se mostrara por pantalla para visualizar o modificar.
		*@param integer $evento Es una variable de control para bloquear o desbloquear la carga de los datos 1 para estar bloqueada (viualizar), 2 para desbloquear (modificar)
		*@param integer $id es el id del registro que se va a modificar (se pasa por aqui para poder pasarselo a la función que modificará)
		*@return string $html Es el codigo html.
		*/
		function registrarVulnerabilidad($titulo="",$tipo="",$idCaso="",$form="",$evento="")
		{
			if(!empty($form) and is_array($form))
			{
				if($evento==1)
					$bloqued=" disabled=\"true\"";
				else 
					$bloqued=" ";
					
				$casoVulnerabilidad="value=\"".htmlentities($form[1][2])."\"".$bloqued;
				$descripcion=htmlentities($form[1][3]);
				$descripcion2=$bloqued;
				$rt="value=\"".htmlentities($form[1][4])."\"".$bloqued;
				$fachaDetectada="value=\"".htmlentities($form[1][5])."\"".$bloqued;
				$fachaReportada="value=\"".htmlentities($form[1][6])."\"".$bloqued;
				$txtresponsable="value=\"".htmlentities($form[1][7])."\"".$bloqued;
				$fechaCierre="value=\"".htmlentities($form[1][8])."\"".$bloqued;
			}
			else 
			{
				$casoVulnerabilidad="";
				$descripcion="";
				$descripcion2="";;
				$rt="";
				$fachaDetectada="";
				$fachaReportada="";
				$txtresponsable="";
				$fechaCierre="";
			}
			if($tipo==2 && empty($idCaso)){
				$html2="<tr>
			            	<td width=\"280px\" align=\"right\">
			                	N&uacute;mero de Caso/Vulnerabilidad Padre<sup class=\"asterisk\">*</sup>:
			                </td>
			                <td width=\"440px\" align=\"left\">
			                	<input class=\"cajatexto\" type=\"text\" id=\"casoVulnerabilidadPadre\" name=\"txtcasoVulnerabilidadPadre\" size=\"60\" ".$casoVulnerabilidad."/>
			                    <div id=\"msg_casoVulnerabilidadPadre\" class=\"mensajeerror\"></div>
			                </td>
			           	</tr>";
			}
			else
				$html2="";
			$html="
					<form  id=\"registro\" name=\"registro\" action=\"\" method=\"POST\">
						<table align=\"center\">
							<tr>
								<td align=\"center\">
									<span id=\"msg_general\"></span>
								</td>
							</tr>
							<tr>
								<td class=\"tdtitulo_form\" align=\"center\">
									<p class=\"titulo_secciones\">".$titulo."</p>
								</td>
							</tr>
							<tr>
								<td align=\"center\">
									<div id=\"divusuario\" style=\"display:block\">
									<table width=\"700px\" style=\"font-size:12px\">
										".$html2."								    
							            <tr>
							            	<td width=\"280px\" align=\"right\">
							                	Caso/Vulnerabilidad <sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                	<input class=\"cajatexto\" type=\"text\" id=\"casoVulnerabilidad\" name=\"txtcasoVulnerabilidad\" size=\"60\" ".$casoVulnerabilidad."/>
							                    <div id=\"msg_casoVulnerabilidad\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr>
							           	<tr>
							            	<td width=\"280px\" align=\"right\">
							            		Descripci&oacute;n<sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
								                <textarea id=\"descripcion\" name=\"txtdescripcion\" rows=\"4\" cols=\"40\" ".$descripcion2.">".$descripcion."</textarea>
								                <div id=\"msg_descripcion\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr>
							           	<tr>
							            	<td width=\"280px\" align=\"right\">
							                	Caso RT <sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                	<input class=\"cajatexto\" type=\"text\" id=\"rt\" name=\"txtrt\" size=\"60\" ".$rt."/>
							                    <div id=\"msg_rt\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr> 
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                    Fecha Detectada<sup class=\"asterisk\">*</sup>:
							                </td>
											<td width=\"440px\" align=\"left\">
                                               <input class=\"texto_textarea\" type=\"text\" name=\"txtfecha1\" id=\"txtfecha1\" readonly=\"readonly\" size=\"10\" style=\"background-color:#f5f5f5; vertical-align:middle\" ".$fachaDetectada."/>
                                               <img src=\"../imagenes/icono-calendario.jpg\" id=\"lanzador1\" width=\"20\" height=\"20\" border=\"0\" style=\"cursor: pointer;vertical-align:text-bottom\" title=\"fecha detectada\">
                                              <div id=\"msg_fecha1\" class=\"mensajeerror\"></div>
                                          </td>                                                                                   
							            </tr>
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                    Fecha Reportada :
							                </td>
							                <td width=\"440px\" align=\"left\">
                                               <input class=\"texto_textarea\" type=\"text\" name=\"txtfecha2\" id=\"txtfecha2\" readonly=\"readonly\" size=\"10\" style=\"background-color:#f5f5f5; vertical-align:middle\" ".$fachaReportada."/>
                                               <img src=\"../imagenes/icono-calendario.jpg\" id=\"lanzador2\" width=\"20\" height=\"20\" border=\"0\" style=\"cursor: pointer;vertical-align:text-bottom\" title=\"fecha reportada\">
                                             </td>
							            </tr>
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                    Responsable <sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                    <input class=\"cajatexto\" type=\"text\" id=\"responsable\" name=\"txtresponsable\" size=\"40\" ".$txtresponsable."/>
							                    <div id=\"msg_txtresponsable\" class=\"mensajeerror\"></div>
							                </td>
							            </tr>
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                    Fecha Cierre :
							                </td>
							                <td width=\"440px\" align=\"left\">
                                               <input class=\"texto_textarea\" type=\"text\" name=\"txtfecha3\" id=\"txtfecha3\" readonly=\"readonly\" size=\"10\" style=\"background-color:#f5f5f5; vertical-align:middle\" ".$fechaCierre."/>
                                               <img src=\"../imagenes/icono-calendario.jpg\" id=\"lanzador3\" width=\"20\" height=\"20\" border=\"0\" style=\"cursor: pointer;vertical-align:text-bottom\" title=\"fecha cierre\">
                                             </td>
							            </tr>
									</table>
								</td>
							</tr>";
			if(!empty($idCaso) &&  $evento==0)
			{
							$html.="
							<tr>
								<td align=\"center\">
									<div id=\"boton\" style=\"text-align:center\">
										<br />
										<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_modificarVulnerabilidad(xajax.getFormValues('registro'));\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
										<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
									</div>
								</td>
							</tr>";
			}
			if(empty($form))
			{
				if(!empty($idCaso)){
					$html.="
							<tr>
								<td align=\"center\">
									<div id=\"boton\" style=\"text-align:center\">
										<br />
										<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_guardarVulnerabilidad(xajax.getFormValues('registro'),".$tipo.",".$idCaso.")\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
										<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
									</div>
								</td>
							</tr>";
				}
				else{
							$html.="
							<tr>
								<td align=\"center\">
									<div id=\"boton\" style=\"text-align:center\">
										<br />
										<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_guardarVulnerabilidad(xajax.getFormValues('registro'),".$tipo.")\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
										<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
									</div>
								</td>
							</tr>";
				}
			}
			$html.="
						</table>
					</form>
				</div>
			";
			return $html;	
		}
		function buscarVulnerabilidad($titulo="")
		{
			$html="
					<form  id=\"registro\" name=\"registro\" action=\"\" method=\"POST\">
						<table align=\"center\">
							<tr>
								<td align=\"center\">
									<span id=\"msg_general\"></span>
								</td>
							</tr>
							<tr>
								<td class=\"tdtitulo_form\" align=\"center\">
									<p class=\"titulo_secciones\">".$titulo."</p>
								</td>
							</tr>
							<tr>
								<td align=\"center\">
									<div id=\"divusuario\" style=\"display:block\">
									<table width=\"700px\" style=\"font-size:12px\">								    
							            <tr>
							            	<td colspan=\"3\">Seleccione una opci&oacute;n para buscar Caso &oacute; Sub-Caso<sup class=\"asterisk\">*</sup></td>
							            </tr>
										<tr>
							            	<td width=\"280px\" align=\"right\"><input type=\"radio\" name=\"opcionbusqueda\" value=\"numero\">N&uacutemero</td>
							            	<td width=\"280px\" align=\"right\"><input type=\"radio\" name=\"opcionbusqueda\" value=\"nombre\">Nombre</td>
							            	<td width=\"280px\" align=\"right\"><input type=\"radio\" name=\"opcionbusqueda\" value=\"descripcion\">Desripci&oacute;n</td>
							            </tr>
							            <tr>
							            	<td colspan=\"3\">Introduzca el valor de la busqueda (de acuerdo a la opci&oacute;n seleccionada) y presione buscar <sup class=\"asterisk\">*</sup></td>
							            </tr>
							            <tr>
							                <td width=\"440px\" align=\"center\" colspan=\"3\">
							                	<input class=\"cajatexto\" type=\"text\" id=\"textbusqueda\" name=\"txttextbusqueda\" size=\"60\"/>
							                    <div id=\"msg_textbusqueda\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr>
							           	<tr>
											<td align=\"center\" colspan=\"3\">
												<div id=\"boton\" style=\"text-align:center\">
													<br />
													<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_buscarVulnerabilidad(xajax.getFormValues('registro'))\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
													<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
												</div>
											</td>
										</tr>
										<tr>
											<td align=\"center\" colspan=\"3\">
												<div id=\"resutadobusqueda\"></div>
											</td>
										</tr>
									</table>
									</div>
								 </td>
							</tr>
						</table>
					</form>
				</div>
				";
			return $html;	
		}
		function mostrarBusqueda($campos="",$datoConsulta="",$action="")
		{
			$html = "<table border=\"0\" cellpadding=\"1\" cellspacing=\"2\" style=\"font-size:10px\" width=\"100%\">
					<tr bgcolor=\"#6699cc\";
					class=\"bgcolorGestionar\">";
			
			$cou=count($campos);
			if(!empty($campos)){
			foreach ($campos as $cmp)
			{
				$anexo="";
				
				$html.="
					<td align=\"center\">
						<span id=\"".$cmp['id']."\" style=\"cursor:pointer\" ".$anexo." >".htmlentities(utf8_encode($cmp['nombre']))."<span id=\"flecha_".$cmp['id']."\"></span><input type=\"hidden\" name =\"hid_".$cmp['id']."\" id=\"hid_".$cmp['id']."\" value=\"DESC\"/></span>
					</td>
				";
			}}
			$html.="</tr>";
			//print_r($datoConsulta);
			if(!empty($datoConsulta))
			{
				//var_dump($datoConsulta);
				$contador = 0;
				foreach ($datoConsulta as $columna)	
				{
					$contador++;
					if ($contador % 2 == 0) {
						$colorCelda = "#dcdcdc";
					} else $colorCelda = "#ffffff";
					
					$html.= "<tr bgcolor=\"".$colorCelda."\" style=\"font-size:10px\">";
				
					for ($i=2;$i<=$cou;$i++)
					{
						$valor = "";
						$nuevoEstado = "";
						$valor = htmlentities($columna[$i],ENT_QUOTES,'UTF-8');
						if($i==5)
						{
							if($valor == 1)
								$valor = "Caso";
							else 
								$valor = "Sub-Caso";
						}
						if($valor == "t")
						{
							$valor = "<span style=\"color:#99cc00\"><b>habilitado</b></span>";
							$nuevoEstado = 0;
						}
						elseif( $valor == "f" )
						{
							$valor = "<span style=\"color:#e20a16\"><b>deshabilitado</b></span>";
							$nuevoEstado = 1;
						}
						$html.= "
									<td align=\"center\">
										".$valor."
									</td>
						";
					}
					$html.="<td align=\"center\">";
					if(!empty($action))
					{

						$a="'".$columna[1]."'";
						if($action[0])
							$html.="<img src=\"".$this->dirImagenes."".$action[0]['nomImg']."\" ".str_replace("(","($a",utf8_encode($action[0]['eventoJs']))." alt=\"".utf8_encode($action[0]['alt'])."\" style=\"cursor:pointer\"/>";
						if($action[3])
							$html.="<img src=\"".$this->dirImagenes."".$action[3]['nomImg']."\" ".str_replace("(","($a",utf8_encode($action[3]['eventoJs']))." alt=\"".utf8_encode($action[3]['alt'])."\" style=\"cursor:pointer\"/>";
					}
					$html.="</td>
							</tr>";
				}
			}					
			$html .= "
				</table>
			";
			return $html;
		}
		function gestionar($campos="",$datoConsulta="",$action="")
		{
			$html = "<table border=\"0\" cellpadding=\"1\" cellspacing=\"2\" style=\"font-size:10px\" width=\"100%\">";
			//print_r($datoConsulta);
			if(!empty($campos))
				$cou=count($campos);
			else{
				if(!empty($datoConsulta))
					$cou=count($datoConsulta[1]);
			}
			if(!empty($campos)){
				$html .="<tr bgcolor=\"#6699cc\"; class=\"bgcolorGestionar\">";
				foreach ($campos as $cmp){
					$anexo="";
					$html.="
						<td align=\"center\">
							<span id=\"".$cmp['id']."\" style=\"cursor:pointer\" ".$anexo." >".htmlentities($cmp['nombre'])."<span id=\"flecha_".$cmp['id']."\"></span><input type=\"hidden\" name =\"hid_".$cmp['id']."\" id=\"hid_".$cmp['id']."\" value=\"DESC\"/></span>
						</td>
					";
				}
				$html.="</tr>";
			}
			//print_r($datoConsulta);
			if(!empty($datoConsulta))
			{
				//var_dump($datoConsulta);
				$contador = 0;
				foreach ($datoConsulta as $columna)	
				{
					$contador++;
					$tieneSubCaso=false;
					if ($contador % 2 == 0) {
						$colorCelda = "#dcdcdc";
					} else $colorCelda = "#ffffff";
					
					$html.= "<tr bgcolor=\"".$colorCelda."\" style=\"font-size:10px\">";
				
					for ($i=2;$i<=$cou;$i++)
					{
						$valor = "";
						$nuevoEstado = "";
						$valor = htmlentities($columna[$i],ENT_QUOTES,'UTF-8');
						//echo $valor;
						if($i==4)
						{
							if($valor>0){//position: relative
								$idCaso=$columna[1];
								$tieneSubCaso=true;
								$newValor="<table><tr style=\"font-size:10px\"><td>".$valor."</td><td><div id=\"signomas".$idCaso."\" style=\"position: relative; width:12px;\" ><img src=\"".$this->dirImagenes."/mas.jpg\" onclick=\"xajax_mostrarSubCaso('$idCaso')\"  style=\"cursor:pointer\"/></div></td></tr></table>";
								$valor=$newValor;
							}
						}
						if($valor == "t")
						{
							$valor = "<span style=\"color:#99cc00\"><b>habilitado</b></span>";
							$nuevoEstado = 0;
						}
						elseif( $valor == "f" )
						{
							$valor = "<span style=\"color:#e20a16\"><b>deshabilitado</b></span>";
							$nuevoEstado = 1;
						}
						$html.= "
									<td align=\"center\">
										".$valor."
									</td>
						";
					}
					$html.="<td align=\"center\">";
					if(!empty($action))
					{
						$a="'".$columna[1]."'";
						$html.="<img src=\"".$this->dirImagenes."".$action[0]['nomImg']."\" ".str_replace("(","($a",$action[0]['eventoJs'])." alt=\"".$action[0]['alt']."\" style=\"cursor:pointer\"/>";
						if($nuevoEstado == 0)
						{
							$html.="<img src=\"".$this->dirImagenes."".$action[1]['nomImg']."\" ".str_replace("o(","o(1,$a",$action[1]['eventoJs'])." alt=\"".$action[1]['alt']."\" style=\"cursor:pointer\"/>";
						}
						elseif($nuevoEstado == 1)
						{
							$html.="<img src=\"".$this->dirImagenes."".$action[2]['nomImg']."\" ".str_replace("o(","o(2,$a",$action[2]['eventoJs'])." alt=\"".$action[2]['alt']."\" style=\"cursor:pointer\"/>";
						}
						$html.="<img src=\"".$this->dirImagenes."".$action[3]['nomImg']."\" ".str_replace("(","($a",$action[3]['eventoJs'])." alt=\"".$action[3]['alt']."\" style=\"cursor:pointer\"/>";
						$html.="<img src=\"".$this->dirImagenes."".$action[4]['nomImg']."\" ".str_replace("(","($a",$action[4]['eventoJs'])." alt=\"".$action[4]['alt']."\" style=\"cursor:pointer\"/>";
					}
					$html.="</td>
							</tr>";
					if($tieneSubCaso){
						$html .= "<tr><td colspan=\"".$cou."\"><div id=\"txt".$idCaso."\"></div></td></tr>";
					}
				}
			}					
			$html .= "
				</table>
			";
			return $html;
		}
	}
?>