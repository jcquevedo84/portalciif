<?php
	/**
	*CIIF proyecto.php
	*
	*Pagina Principal de la Aplicación
	*Desde este archivo es que es creada las pagina de proyecto.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package proyecto.php
	*
	*/
	/**
	*
	*Array que contiene todas la variables de configuración de la pagina proyecto.php
	*
	*@global array $varPag
	*@name $varPag
	*/
	$varPag="";
	/**
	*Object que representa el controlador de la pagina proyecto.php
	*
	*@global Object $controller
	*@name $controller
	*/
	$controller="";
	//Se incluye el archivo de las variables globales
	require_once("../config/varConf.php");
	require_once ("../config/mensajesFrame.php");
	$varConf= new varConf("conf.ini","../config/",basename(__FILE__,".php"),"class.ini","atributo.ini");
	//se incluyen los archivos .php necesario para crae la pagina.
	$lib=varConf::getLibrerias(basename($_SERVER['PHP_SELF'],".php"));
	varConf::incluirLibrerias($lib);
	$objSession=new sesion();
	if(!($objSession->info("roles") && $objSession->info("menuModulos"))){
		$roles=parse_ini_file("../config/roles.ini",true);
		$menuModulos=parse_ini_file("../config/menuModulos.ini",true);
		$objSession->set("roles",$roles);
		$objSession->set("menuModulos",$menuModulos);
	}
	if(!empty($_SERVER['HTTP_REFERER']))
		$controller= new proyectoC(basename($_SERVER['HTTP_REFERER']),$objSession);
	else 
		header("Location: ".varConf::getServidor("direccionServidor")."index.php");
?>