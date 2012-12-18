<?php
	/**
	*CIIF index.php
	*
	*Pagina Principal de la Aplicación
	*Desde este archivo es que es creada las pagina de index.php
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package index.php
	*
	*/
	/**
	*
	*Array que contiene todas la variables de configuración de la pagina index.php
	*
	*@global array $varPag
	*@name $varPag
	*/
	$varPag="";
	/**
	*Object que representa el controlador de la pagina index.php
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
	$controller= new indexC(basename($_SERVER['HTTP_REFERER']),$objSession);
?>