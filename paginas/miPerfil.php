<?php
	/**
	*CIIF miPerfil.php
	*
	*Pagina Principal de la Aplicación
	*Desde este archivo es que es creada las pagina de miPerfil.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package miPerfil.php
	*
	*/
	/**
	*
	*Array que contiene todas la variables de configuración de la pagina miPerfil.php
	*
	*@global array $varPag
	*@name $varPag
	*/
	$varPag="";
	/**
	*Object que representa el controlador de la pagina miPerfil.php
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
	//se crea el objeto sesion
	$objSession=new sesion();
	if(!empty($_SERVER['HTTP_REFERER']))
		$controller= new miPerfilC(basename($_SERVER['HTTP_REFERER']),$objSession);
	else 
		header("Location: ".varConf::getServidor("direccionServidor")."index.php");
?>