<?php
include '../class/vista/comun.php';
include '../class/vista/templeteV.php';
include '../class/vista/indexV.php';
require_once("../config/varConf.php");
require_once ("../config/mensajesFrame.php");
$varConf= new varConf("conf.ini","../config/",basename("index.php",".php"),"class.ini","atributo.ini");
$view=new indexV();
$view->setPaginaSiguiente("e");
?>