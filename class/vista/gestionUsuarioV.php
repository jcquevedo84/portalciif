<?php
	/**
	*CIIF gestionUsuarioV
	*
	*Clase Vista de la Pagina gestionUsuario.php
	*En esta clase se encuentran todas las interfaces de la pagina gestionUsuario.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package gestionUsuarioV
	*
	*/
	class gestionUsuarioV extends templeteV  
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
		*crear
		*
		*Esta función crea el codigo html para visualizar, cargar y modificar los datos
		*
		*@param string $combotipouser Es el codigo html del combo estado 
		*@param array $form confiene los datos del registro que se mostrara por pantalla para visualizar o modificar.
		*@param integer $evento Es una variable de control para bloquear o desbloquear la carga de los datos 1 para estar bloqueada (viualizar), 2 para desbloquear (modificar)
		*@param integer $id es el id del registro que se va a modificar (se pasa por aqui para poder pasarselo a la función que modificará)
		*@return string $html Es el codigo html.
		*/
		function registrarUsuario($combotipouser="",$form="",$evento="",$id="")
		{
			if(!empty($form) and is_array($form))
			{
				if($evento==1)
					$bloqued=" disabled=\"true\"";
				else 
					$bloqued=" ";
				$nombre="value=\"".htmlentities($form[1][2])."\"".$bloqued;
				$apellido="value=\"".htmlentities($form[1][3])."\"".$bloqued;
				$coreo1="value=\"".htmlentities($form[1][4])."\"".$bloqued;
				$numpoo="value=\"".htmlentities($form[1][5])."\"".$bloqued;
			}
			else 
			{
				$usuario="";
				$contrasena="";
				$nombre="";
				$coreo1="";
				$numpoo="";
				$apellido="";
			}
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
									<p class=\"titulo_secciones\">Datos del Usuario</p>
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
							                	<input class=\"cajatexto\" type=\"text\" id=\"nombre\" name=\"txtnombre_solicitante\" size=\"40\" maxlength=\"40\" ".$nombre."/>
							                    <div id=\"msg_nombre_solicitante\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr>
							           	 <tr>
							            	<td width=\"280px\" align=\"right\">
							            		Apellido<sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                	<input class=\"cajatexto\" type=\"text\" id=\"apellido\" name=\"txtapellido_solicitante\" size=\"40\" maxlength=\"40\" ".$apellido."/>
							                    <div id=\"msg_apellido\" class=\"mensajeerror\"></div>
							                </td>
							           	</tr>
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                    Correo electr&oacute;nico<sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                    <input class=\"cajatexto\" type=\"text\" id=\"email\" name=\"txtemail_solicitante\" size=\"40\" maxlength=\"40\" ".$coreo1."/>
							                    <div id=\"msg_email_solicitante\" class=\"mensajeerror\"></div>
							                </td>
							            </tr>
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                </td>
							             	<td width=\"440px\" align=\"left\">
							                	<span class=\"forminfo\">&laquo; Formato de Correo electr&oacute;nico: usuario@cantv.com.ve <br> </span>
							            	</td>
							            </tr>
							            <tr>
							                <td width=\"280px\" align=\"right\">
							                    N&uacute;mero POO <sup class=\"asterisk\">*</sup>:
							                </td>
							                <td width=\"440px\" align=\"left\">
							                    <input class=\"cajatexto\" type=\"text\" id=\"numpoo\" name=\"txtnumpoo\" size=\"10\" maxlength=\"10\" ".$numpoo."/>
							                    <div id=\"msg_txtnumpoo\" class=\"mensajeerror\"></div>
							                </td>
							            </tr>
							            ";
			if(!empty($combotipouser))
			{
						 $html.=" <tr>
											<td width=\"280px\" align=\"right\">
												Tipo de Usuario<sup class=\"asterisk\">*</sup>: 
											</td>
											<td width=\"440px\" align=\"left\">
												<div id=\"divtipousuario\">".$combotipouser."</div>
												 <div id=\"msg_tipousuario\" class=\"mensajeerror\"></div>
												
											</td>
										</tr>";
									
			}
			$html.="</table>
								</td>
							</tr>";
			if(!empty($id)and $evento==0)
			{
							$html.="
							<tr>
								<td align=\"center\">
									<div id=\"boton\" style=\"text-align:center\">
										<br />
										<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_modificarUsuario(xajax.getFormValues('registro'),".$id.");\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
										<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
									</div>
								</td>
							</tr>";
			}
			if(empty($form))
			{
							$html.="
							<tr>
								<td align=\"center\">
									<div id=\"boton\" style=\"text-align:center\">
										<br />
										<img id=\"btnguardar_actDesOperador\" src=\"../imagenes/boton_guardar.png\" onclick=\"xajax_guardarUsuario(xajax.getFormValues('registro'))\" onmouseover=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar_on.png'\" onmouseout=\"javascript:document.getElementById('btnguardar_actDesOperador').src='../imagenes/boton_guardar.png'\"/><br />
										<span style=\"font-size:9px\"><sup class=\"asterisk\">*</sup> <b>Campos obligatorios</b></span>
									</div>
								</td>
							</tr>";
			}
			$html.="
						</table>
					</form>
				</div>
			";
			return $html;	
		}
	}
?>