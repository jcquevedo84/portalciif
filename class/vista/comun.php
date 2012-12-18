<?php
    /**
	*CIIF comun
	*
	*Clase Vista de la Pagina index.php
	*En esta clase se encuentran todas las interfaces de la pagina index.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package indexV
	*
	*/
	class comun  
	{
		/**
		* string que guarda la dirección delas imagenes de la aplicacion.
		* @var string $dirImagen
		* @access private
		*/
		public  $dirImagenes="";
		/**
		*
		*Constructor
		*
		*Esta Función asigna parametros a las variables miembros de la clase.
		*
		*@param string $dirImg (Obligatorio) dirección delas imagenes de la aplicacion.
		*@return void
		*/
		function __construct($dirImagenes="")
		{
			if(!empty($dirImagenes))
				$this->dirImagenes=$dirImagenes;
			else
				$this->dirImagenes=varConf::getRutasAccesoImagen("imagenes");
		} 
		/**
		*
		*cabecera
		*
		*Es la encargada de crear la cabecera por default
		*@return void 
		*/
		function cabecera()
	    {
	    	$cabecera="		  
			<div id=\"topePagina\"> 
		    	<table id=\"tblpagina\" class=\"tblpagina\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\">
					<!-- Cintillo -->
					<tr id=\"cintillo\" class=\"trcintillo\">
						<td><img class=\"imgcintillo\" src=\"".$this->dirImagenes."cabecera_gobenlinea2.gif\" /></td>
					
						
					</tr>
					<!-- fin Cintillo -->
				</table> 
		  	</div>
		  	";	
	    	return $cabecera;
	    }
	    /**
		*
		*pie
		*
		*Es la encargada de crear el pie de pagina por default
		*@return void 
		*/
	    function pie()
	    {
	    	$piePagina = "
				<div id=\"piePagina\">
				  <!-- Aqui se colocar el pie de pagina -->
				    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
				      <!-- Panel Inferior -->
						<tr id=\"trpanel_inf\" class=\"panel_inf\">
						<td class=\"tdpanel_inf\"><i class=\"slogan\">
						<br>Gerencia General de Seguridad Integral / Gerencia de Investigaciones / Coordinaci&oacute;n de Investigaci&oacute;n de Inform&aacute;tica Forense</br>
						Compa&ntilde;ia An&oacute;nima Nacional Tel&eacute;fonos de Venezuela. RIF: J-00124134-5.- Todos los derechos reservados.
						<br></br>
						</tr>
					<!-- fin Panel Inferior -->
				    </table>
				 </div>
			";
	    	return $piePagina;
	    }
	    /*
		*opcionesAdmon
		*
		*Menu lateral del panel de administracion
		*@return string $html.
		*/
		function opcionesAdmon($menu="",$submenu="",$tipoUsuario="")
		{
			$i=0;
			if(!empty($menu) &&!empty($submenu)){
				foreach ($menu as $id=> $value)
				{
					$opsion=$submenu[$id][$tipoUsuario];
					if(count($opsion)>1)
					{
						$html .= "
							<div id=\"div_".$i."\" onclick=\"desplegarDivMenu('div_".$i."_det');fondomenu_act_des(this.id)\" class=\"menulateral\">
								".htmlentities($value)."
							</div>
							<div id=\"div_".$i."_det\" style=\"padding-left:10\" style=\"display:none\">";
						foreach ($opsion as $idsp => $sp)
						{
							$a=explode(";",$sp);
							$html .= "
								<a class=\"asecciones2\" href=\"#\" onclick=\"".htmlentities($a[1])."\">&#8226; ".htmlentities($a[0])."</a><br/>";
						}
						$html .= "</div>";
					}
					elseif(count($opsion)==1)
					{
						$p=array_values($opsion);
						$a=explode(";",$p[0]);
						$html .= "
							<div id=\"div_".$i."\" onclick=\"fondomenu_act_des(this.id);".htmlentities($a[1])."\" class=\"menulateral\">
								".htmlentities($a[0])."
							</div>
							";
					}
					$i++;
				}
			}
			else
				 $html="";	
			return $html;
		}
		/*
		*menuPrincipal
		*
		*Esta función muestra el menu que se encuentra en la parte inferior de la pagina
		*@param integer $pagActual Es el identificador de la pagina actual.
		*@param array $menu Es el array que el usuario tiene acceso.
		*@return string $html es el codigo html de el menu construido.
		*/
		function menuPrincipal($pagActual="",$menu="")
		{
			$html .= "
				<table cellpadding=\"3\" cellspacing=\"0\">
					<tr>
				";
			if("administracion"!=$pagActual && array_key_exists("administracion",$menu))
			{
				$html .= "
					<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
					<span id=\"botonAdmin\" onclick=\"xajax_redirect(1);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
						<img src=\"../imagenes/sistema/administracion1.png\" class=\"imgsinborde\" onclick=\"xajax_redirect(1);\"><br><b>Admin</b>
					</span>
					</td>
				";
			}
			
			if("gestionUsuario"!=$pagActual && array_key_exists("gestionUsuario",$menu))
			{
				$html .= "
					<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
					<span id=\"botonGestionaUsuario\" onclick=\"xajax_redirect(3);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
							<img src=\"../imagenes/sistema/usuarios1.png\" class=\"imgsinborde\" onclick=\"xajax_redirect(3);\"><br><b>Gestiona Usuario</b></a>
					</span>
					</td>
				";
			}
			if("index"!=$pagActual)
			{
				$html .= "
						
					<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
					<span id=\"botonInicio\" onclick=\"xajax_redirect(4);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
					<img src=\"../imagenes/sistema/home1.png\" class=\"imgsinborde\" onclick=\"xajax_redirect(4);\"><br><b>Inicio</b></a>
					</span>
					</td>
				";
			}
			if("miPerfil"!=$pagActual)
			{
				$html .= "
				<td align=\"center\" style=\"padding-right:10px;color:#666666;text-decoration: none; font-size:11px\" >
			    <span id=\"MiPerfil\" onclick=\"xajax_redirect(2);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
							<img src=\"../imagenes/sistema/micuenta1.png\" class=\"imgsinborde\" onclick=\"xajax_redirect(2);\"><br><b>Mi Perfil</b></a>
				</span>
				</td>
				";
			}
			$html .= "
					    <td align=\"center\" style=\"padding-right:5px\">
							<span id=\"botonSalir\" onclick=\"xajax_redirect(5);\" onmouseover=\"resaltarSpan(this.id,'1')\" onmouseout=\"resaltarSpan(this.id,'0')\" style=\"font-size:11px;color:#666666\">
							<img src=\"".$this->dirImagenes."/sistema/cerrarsesion1.png\" class=\"imgsinborde\" onclick=\"xajax_redirect(5);\"><br><b>Salir</b>
							</span>
						</td>
					</tr>
				</table>
			";
			return $html;
		}
		function llenarCombo($nombreCombo="",$dep="",$eventoJS="",$sel="",$blok="",$x="",$y="",$estilo="style=\"font-family:Verdana;font-size:11px;\"")
		{
			$html = "";
			$siglas = "";
			$comboEstados = array();
			$datosCombo = array();
			if($blok==1)
					$bloqued=" disabled=\"true\"";
				else 
					$bloqued=" ";
			$html .= "
				<select class=\"cajatexto\" id=\"".$nombreCombo."\" name=\"cmb".$nombreCombo."\" ".$eventoJS." ".$estilo." ".$bloqued.">
					<option value=\"".$x."\">".$y."</option>
			";
			if(is_array($dep))
			{
				if(!empty($sel))
				{
					foreach($dep as $clave => $valor)
				    {
				    	if($sel == $valor[1])
				    	{
				    		$seleccionado = "selected=\"selected\"";
				    	} else
				    	{
				    		$seleccionado = "";
				    	}
				    	$html .= "<option value=\"".$valor[1]."\"  ".$seleccionado.">".htmlentities($valor[2])."</option>";
				    }
				}
				else 
				{
					foreach($dep as $clave => $valor)
				    {
				    	$html .= "<option value=\"".$valor[1]."\">".htmlentities($valor[2])."</option>";
				    }
				}
			}
			$html .= "
				</select>
				<span id=\"msg_".$nombreCombo."\"></span>
			";
			return $html; 
		}
	/**
		*
		*gestionar
		*
		*Pinta la lista de registro con las opciones de modificar, ver y activar/desactivar
		*
		*@param array $campos Son los titulos de cada una de las celdas
		*@param array $datoConsulta Son los registro 
		*@param array $action Son las acciones por cada registro
		*@return tipo $html El codigo HTML de la lista de registro con las opciones de modificar, ver y activar/desactivar
		*/
		function gestionar($campos="",$datoConsulta="",$action="")
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
						//echo $valor."\n";
						//$valor = htmlentities($columna[$i]);
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
						$html.="<img src=\"".$this->dirImagenes."".$action[0]['nomImg']."\" ".str_replace("(","($a",utf8_encode($action[0]['eventoJs']))." alt=\"".utf8_encode($action[0]['alt'])."\" style=\"cursor:pointer\"/>";
						if($nuevoEstado == 0)
						{
							$html.="<img src=\"".$this->dirImagenes."".$action[1]['nomImg']."\" ".str_replace("o(","o(1,$a",utf8_encode($action[1]['eventoJs']))." alt=\"".utf8_encode($action[1]['alt'])."\" style=\"cursor:pointer\"/>";
						}
						elseif($nuevoEstado == 1)
						{
							$html.="<img src=\"".$this->dirImagenes."".$action[2]['nomImg']."\" ".str_replace("o(","o(2,$a",utf8_encode($action[2]['eventoJs']))." alt=\"".utf8_encode($action[2]['alt'])."\" style=\"cursor:pointer\"/>";
						}
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
	}	
?>