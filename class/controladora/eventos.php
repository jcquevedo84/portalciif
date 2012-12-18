<?php

class eventos{
	
	function redirect($num){
			$respuesta = new xajaxResponse();
			$dirServidor=varConf::getServidor("direccionServidor");
			if(is_numeric($num)){
				if($num==1)//Administracion
					$respuesta->addRedirect($dirServidor."administracion.php");
				else if($num==2)//Mi perfil
					$respuesta->addRedirect($dirServidor."miPerfil.php");
				else if($num==3)//Gestiona Usuario
					$respuesta->addRedirect($dirServidor."gestionUsuario.php");
				else if($num==4){//Inicio
					//echo "aqui";
					$_SESSION["interno"]=true;
					$respuesta->addRedirect($dirServidor."index.php");
				}
				else if($num==5){//Salir
					require_once '../librerias/sesion.php';
					$objSession=new sesion();
					$objSession->killAll();
					session_destroy();
					unset($_SESSION);
					$respuesta->addRedirect($dirServidor."index.php");
				}
				elseif ($num==6){//Vulnerabilidades
					$respuesta->addRedirect($dirServidor."vulnerabilidades.php");
				}
				elseif ($num==7){//indicadores
					$respuesta->addRedirect($dirServidor."indicadores.php");
				}
				elseif ($num==8){//bilioteca
					$respuesta->addRedirect($dirServidor."biblioteca.php");
				}
				elseif ($num==9){//Procedimientos
					$respuesta->addRedirect($dirServidor."proyecto.php");
				}
			}
			return $respuesta;
		}
}
?>