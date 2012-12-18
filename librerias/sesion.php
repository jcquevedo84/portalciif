<?php
	/**
	*classlibSession
	*
	*Clase  classlibSession.php
	*En esta Clase se gestiona las variables de session
	*@copyright CANTV
	*@author Kery Pérez
	*@version 1.0
	*@package classlibSession
	*
	*/
	class sesion 
	{
		/**
		*classlibSession
		*Continua y crea la Session
		*@return void
		*/
		public function __construct()
		{
			session_start();
		}
		/**
		*
		*setVarSession
		*
		*Esta funcion crea una variable de session.
		*
		*@param string $nombreVarSession Noimbre de la variable de session
		*@param string $valorVarSession el valor que toma la variable de session
		*@return void
		*/
		public function set($nombreVarSession="",$valorVarSession="",$atributo="")
		{
			
			if((is_object($_SESSION[$nombreVarSession]))and (!empty($_SESSION[$nombreVarSession])))
			{
				if(!empty($atributo))
					$_SESSION[$nombreVarSession]->$atributo=$valorVarSession;
				else 
					$_SESSION[$nombreVarSession]=$valorVarSession;		
			}
			else 
			{
				if(!empty($valorVarSession))
				{
					if(preg_match('/\[|\]/',$nombreVarSession))
					{
						
						if(is_array($valorVarSession))
						{
							$caracteres = preg_split('/\[|\]/', $nombreVarSession,-1,PREG_SPLIT_NO_EMPTY);
							$c=count($caracteres);
							if($c==2)
								$_SESSION[$caracteres[0]][$caracteres[1]]=$valorVarSession;
							else
								$_SESSION[$caracteres[0]][$caracteres[1]][$caracteres[2]]=$valorVarSession;
						}
						else
						{
							$caracteres = preg_split('/\[|\]/', $nombreVarSession,-1,PREG_SPLIT_NO_EMPTY);
							$v="\$_SESSION";
							foreach ($caracteres as $valor)
								$v.="[\"$valor\"]";
							if(is_string($valorVarSession))
								$v.="=\"".$valorVarSession."\";";
							else
								$v.="=$valorVarSession;";
							eval($v);
						}
					}
					else
						$_SESSION[$nombreVarSession]=$valorVarSession;	
				}
			}
		}
		/**
		*
		*destruirSession
		*
		*Esta funcion destruye toda la session
		*
		*@return void
		*/
		public function killAll()
		{
			session_destroy();
			unset($_SESSION);
		}
		/**
		*
		*destruirVarSession
		*
		*elimina una variable de sesión
		*
		*@param string $nombreVarSession es el nombre de la variable de sesión que deseamos eliminar
		*@return void
		*/
		public function killVar($nombreVarSession="",$atributo="")
		{
			if(is_object($nombreVarSession))
			{
				if(!empty($atributo))
					unset($_SESSION[$nombreVarSession]->$atributo);
				else
					unset($_SESSION[$nombreVarSession]);
			}
			else 
			{
				if(preg_match('/\[|\]/',$nombreVarSession))
				{
					$caracteres = preg_split('/\[|\]/', $nombreVarSession,-1,PREG_SPLIT_NO_EMPTY);
					$v="unset(\$_SESSION";
					foreach ($caracteres as $valor)
						$v.="[\"$valor\"]";
					$v.=");";
					eval($v);		
				}
				else
					unset($_SESSION[$nombreVarSession]);
			}
		}
		/**
		*
		*devuelve el valor de una variable de session
		*
		*Descripsión.
		*
		*@param string $nombreVarSession es el nombre de la variable de session que deseamos obtener.
		*@return void
		*/
		public function get($nombreVarSession="",$atributo="")
		{
			if(is_object($nombreVarSession))
			{
				if(!empty($atributo))
					return $_SESSION[$nombreVarSession]->$atributo;
				else
					return $_SESSION[$nombreVarSession];
			}
			else 
			{
				if(preg_match('/\[|\]/',$nombreVarSession))
				{
					$x="";
					$caracteres = preg_split('/\[|\]/', $nombreVarSession,-1,PREG_SPLIT_NO_EMPTY);
					$v="\$x=\$_SESSION";
					foreach ($caracteres as $valor)
						$v.="[\"$valor\"]";
					$v.=";";
					eval($v);
					return $x;		
				}
				else
					return $_SESSION[$nombreVarSession];
			}		
		}
		/**
		*
		*estadoVarSession
		*
		*Descripsión.
		*
		*@param string $nombreVarSession 
		*@return bool
		*/
		public function info($nombreVarSession="",$atributo="")
		{
			if(is_object($nombreVarSession))
			{
				if(!empty($atributo))
				{
					if(isset($_SESSION[$nombreVarSession]->$atributo)and (!empty($_SESSION[$nombreVarSession]->$atributo)))
						return true;
					else 
						return false;	
				}
				else
				{
					if(isset($_SESSION[$nombreVarSession])and (!empty($_SESSION[$nombreVarSession])))
						return true;
					else
						return false;
				}
			}
			elseif(preg_match('/\[|\]/',$nombreVarSession))
			{
				$x="";
				$caracteres = preg_split('/\[|\]/', $nombreVarSession,-1,PREG_SPLIT_NO_EMPTY);
				$v="\$x=\$_SESSION";
				foreach ($caracteres as $valor)
					$v.="[\"$valor\"]";
				$v.=";";
				eval($v);
				if(isset($x)and (!empty($x)))
					return true;
				else
					return false;	
			}
			else 
			{
				if(isset($_SESSION[$nombreVarSession])and (!empty($_SESSION[$nombreVarSession])))
					return true;
				else 
					return false;	
			}
		}
	}
?>