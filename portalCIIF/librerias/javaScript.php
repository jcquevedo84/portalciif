<?php
	/*
	Caracas; 18/05/2006
    Clase Libreria de Pc (classLibPc)
    Fundación Instituto de Ingenieria Version 1.0
    Tienes como función crear codigo java scipt general para ser utilizado en cualquier pagina
    */
	class javaScript 
	{
 
        /*
		FUNCION REDIRECCIONA DESDE PHP
		$pag= es la pagina a donde quiero ir
		*/
		public static function flibRed($pag="")
		{
			$script=
			" 
				<script language=\"javascript\">
				location.href ='".$pag."'
				</script>

			";
			return $script;
		}
		/*
		FUNCION CIERRA VENTANA
		*/
		public static function flibCerrar()
		{
			$script=
			" 
				<script language=\"javascript\">
				window.close();
				</script>
			
			";
			return $script;
		}
		/*
		FUNCION QUE REDIRECIONA 
		$pag= es la pagina a donde quiero ir
		*/
		public static function flibRedirecciona($pag="")
		{
			$script=
			" 
				location.href ='".$pag."'
			
			";
			return $script;
		}
		/*MUESTRA UN MENSAJE Y SE REDIRECCIONA A OTRA PAGINA
		  $msm=mensaje
		  $pag=pagina para donde se redireccionara
		  RETORNA EL SCRIPT */
		public static function flibMensajeRedirecciona($msm="", $pag="")
		{
			$script=
			"<script language=\"javascript\">
				alert('".$msm."')
				location.href ='".$pag."'
			</script>
			";
			return $script;
		}
		/*MUESTRA UN MENSAJE 
		  $msm=mensaje
		  RETORNA EL SCRIPT*/
		public static function flibMensaje($msm="")
		{
			$script=
			"<script language=\"javascript\">
				alert('".$msm."')
			</script>
			";
			return $script;
		}
		/*
		MUESTRA UN MENSAJE Y CIERRA LA PAGINA
		$msm=mensaje
		*/
		public static function flibMensajeCierra($msm="")
		{
			$script=
			"<script language=\"javascript\">
				alert('".$msm."')
				window.close();
			</script>
			";
			return $script;
		}
        /*
		FUNCION QUE NO ADMITE NUMEROS
		*/
		public static function flibNoLetras()
		{
			$js="
				function NoLetras()
				{
					if(( event.keyCode >= 97 && event.keyCode <= 122) || (event.keyCode >=65 && event.keyCode <=90))
					{
						event.keyCode=0;
					}
			}";
			return $js;
		}
		public static function flibNoNumeros()
		{
			$js="
				function NoNumeros()
				{
					if(!(( event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >=97 && event.keyCode <=122)) || (event.keyCode ==32) )
					{
						event.keyCode=0;
					}
			}";
			return $js;
		}
		public static function flibVerificaEnvio()
        {
        	$js="function verificaEnvio(variable,valor)
		    {
			    if (confirm(\"¿Seguro que quieres'+valor+' los datos?\")) 
				{
					aux='document.'+variable+'.submit()';
					eval(aux);
				}
			}";
        	
        	return $js;
        	
		}	
		public static function flibInnerHtml($id="",$value=""){
			$script=
			" 
				<script language=\"javascript\">
				document.getElementById(\"".$id."\").innerHTML=".$value."
				</script>
			";
			return 	$script;	
		}	
	}
?>