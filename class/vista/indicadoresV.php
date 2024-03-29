<?php
	/**
	*CIIF indicadoresV
	*
	*Clase Vista de la Pagina gestionUsuario.php
	*En esta clase se encuentran todas las interfaces de la pagina gestionUsuario.php
	*@copyright CANTV
	*@author Kery P�rez
	*@version 1.0
	*@package indicadoresV
	*
	*/
	class indicadoresV extends templeteV  
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
		*registrarRoles
		*
		*Esta funci�n crea el codigo html para visualizar, cargar y modificar los datos
		*
		*@param string $combotipouser Es el codigo html del combo estado 
		*@param array $form confiene los datos del registro que se mostrara por pantalla para visualizar o modificar.
		*@param integer $evento Es una variable de control para bloquear o desbloquear la carga de los datos 1 para estar bloqueada (viualizar), 2 para desbloquear (modificar)
		*@param integer $id es el id del registro que se va a modificar (se pasa por aqui para poder pasarselo a la funci�n que modificar�)
		*@return string $html Es el codigo html.
		*/
		function generarIndicadores()
		{
			
			$html="
					<form  id=\"registro\" name=\"registro\" action=\"\" method=\"POST\">
						<table width=\"720px\" align=\"center\">
							<tr>
								<td align=\"center\">
									<span id=\"msg_general\"></span>
								</td>
							</tr>
							<tr>
								<td class=\"tdtitulo_form\" align=\"center\">
									<p class=\"titulo_secciones\">Datos del Rol</p>
								</td>
							</tr>
							<tr>
								<td align=\"center\">
									<div id=\"divusuario\" style=\"display:block\">
									<table width=\"700px\" style=\"font-size:12px\">
							           	  <tr>
							            	<td width=\"280px\" align=\"right\">
							                	Nombre <sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                	<input class=\"cajatexto\" type=\"text\" id=\"nombre\" name=\"txtnombre\" size=\"60\" ".$nombre."/>
							                    <div id=\"msg_nombre\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr>
							            ";
			$html.="</table>
								</td>
							</tr>";
			
							$html.="
							<tr>
								<td align=\"center\">
									<div id=\"boton\" style=\"text-align:center\">
										<br />
										<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_generarGraficoIndicadores(xajax.getFormValues('registro'))\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
										<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
									</div>
								</td>
							</tr>";
			$html.="    <tr><td><div id=\"graficoindicadores\"  ></div></td></tr>
						</table>
					</form>
				</div>
			";
			return $html;	
		}
	}
?>