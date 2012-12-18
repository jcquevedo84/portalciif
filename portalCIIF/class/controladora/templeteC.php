<?php

class templeteC {
		/**
		*
		*Object que representa el modelo de la pagina index.php
		*
		*@global Object $model
		*@name $model
		*/
		private  $model="";
		/**
		*
		*Object que representa la vista de la pagina index.php
		*
		*@global Object $view
		*@name $view
		*/
		private $view="";
		/**
		*
		*Object que representa el esqueleto de la pagina index.php
		*
		*@global Object $objPaginas
		*@name $objPaginas
		*/
		private $objPaginas="";
		/**
		*
		*Object que representa las variables de session que se captura en la aplicación.
		*
		*@global Object $objSesion
		*@name $objSesion
		*/
		private $objSesion="";
		/**
		*
		*Object 
		*
		*@global Object $usuario
		*@name $usuario
		*/
		private $user="";
		/**
		*
		*pagina
		*
		*Es la encargada de crear la estructura de una pagina
		*@return string $html es Todo el codigo HTML que se va a desplegar en la pagina
		*/
		function pagina($objPag="")
		{
			$html="";
			$html.=$objPag->flibHtmHead();
			$html.=$objPag->getCabecera();
			$html.=$objPag->getContenido();
			$html.=$objPag->getPie();
			$html.=$objPag->flibCierre();
			return $html;	
		}
}

?>