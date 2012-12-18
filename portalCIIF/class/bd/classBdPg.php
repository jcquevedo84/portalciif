<?php
	/**
	*classBdPg
	*
	*Clase que crea la conexion y sentencias SQL entre una aplicación y la base de datos Postgres
	*@copyright Instituo de Ingenieria CPDI
	*@author Juan Carlos Rodriguez
	*@version 1.0
	*@package nombrepaginaM
	*
	*/
	class classBdPg
	{
		/**
		* string que guarda el nombre de la base de datos donde nos vamos a conectar.
		* @var string $dbName
		* @access public
		*/
		var $dbName=""; 
		/**
		* string que guarda el login del usuario de la base de d atos donde nos vamos a conectar.
		* @var string $dbLogin
		* @access public
		*/
		var $dbLogin=""; 
		/**
		* string Es el pasword del el usuario donde nos vamos a conectar.
		* @var string $dbPassword
		* @access public
		*/
		var $dbPassword=""; 
		/**
		* string la direccion ip donde esta ubicaco el servidor de base de datos.
		* @var string $dbServidor
		* @access public
		*/
		var $dbServidor=""; 
		/**
		* string Es el numero de puerto a traves del cual se conectara a la base de datos.
		* @var string $dbPuerto
		* @access public
		*/
		var $dbPuerto="";
		/**
		* string Es el nombre de la pagina desde donde eme estoy conectando.
		* @var string $direccionS
		* @access public
		*/
		var $pagina=""; 
		/**
		* string Es el nombre de la clase dsde donde estoy creando el objeto BD.
		* @var string $direccionS
		* @access public
		*/
		var $clase=""; 
		/**
		* string Id de la conexion entre la aplicacion y la base de datos.
		* @var string $conex
		* @access public
		*/
		var $conex="";
		var $numRow="";
		var $lastError="";
		var $affRow="";
		var $lastOid="";
		/**
		*
		*classBdPg
		*
		*Comstrucctor de la clase.
		*@param string $nombreBdPGL (Obligatorio) Nombre de la base de datos.
		*@param string $servidorBdPGL (Obligatorio) Direccion IP del Servidor de Base de Datos.
		*@param string $loginBdPGL (Obligatorio) Login para acceder a la Base de datos.
		*@param string $claveBdPGL (Obligatorio) Pasword para acceder a la base de datos.
		*@param string $puerto (Obligatorio) Puerto de conexion para la base de datos.
		*@param string $nombrePagina (Obligatorio) Nombre de la pagina desde dond ese esta accediendo a la base de datos.
		*@param string $nombreClase (Obligatorio)  Nombre de la clase desde donde se estar creando la conexion.
		*@return string $html es Todo el codigo HTML que se va a desplegar en la pagina
		*/
		function classBdPg($nombreBdPGL="", $servidorBdPGL="",$loginBdPGL="",$claveBdPGL="",$puerto="",$nombrePagina="",$nombreClase="")
		{
			if(varConf::getBaseDatosPgsql("nombrePGL"))
				$this->dbName=varConf::getBaseDatosPgsql("nombrePGL");
			else 
			{
				if(!empty($nombreBdPGL))
					$this->dbName=$nombreBdPGL;	
			}
			if(varConf::getBaseDatosPgsql("loginPGL"))
				$this->dbLogin=varConf::getBaseDatosPgsql("loginPGL");
			else 
			{
				if(!empty($loginBdPGL))
					$this->dbLogin=$loginBdPGL;	
			}
			if(varConf::getBaseDatosPgsql("clavePGL"))
				$this->dbPassword=varConf::getBaseDatosPgsql("clavePGL");
			else 
			{
				if(!empty($claveBdPGL))
					$this->dbPassword=$claveBdPGL;	
			}
			if(varConf::getBaseDatosPgsql("servidorPGL"))
				$this->dbServidor=varConf::getBaseDatosPgsql("servidorPGL");
			else 
			{
				if(!empty($servidorBdPGL))
					$this->dbServidor=$servidorBdPGL;	
			}
			if(varConf::getBaseDatosPgsql("puerto"))
				$this->dbPuerto=varConf::getBaseDatosPgsql("puerto");
			else 
			{
				if(!empty($puerto))
					$this->dbPuerto=$puerto;	
			}
			if(!empty($nombrePagina))
				$this->pagina=$nombrePagina;	
			if(!empty($nombreClase))
				$this->clase=$nombreClase;	
			//echo "<br> que paso".$this->dbName." ".$this->dbLogin." ".$this->dbPassword." ".$this->dbServidor." ".$this->dbPuerto;
		}
		/**
		*
		*fdbConectar
		*
		*Es la encarga de hacer la conexion a la Base de Datos
		*@param string $nombreFuncion Es el nombre de la función
		*@return string $conexion Es el identificador de la conexión.
		*/
		function fdbConectar($nombreFuncion="")
		{
	    	$conexion="";
	    	$conexion = pg_connect("host=".$this->dbServidor." port=".$this->dbPuerto." dbname='".$this->dbName."' user=".$this->dbLogin." password=".$this->dbPassword);
	    	if($conexion)
	    	{
				return $conexion;
	    	}
	    	else
	    	{
	    		echo "Error 0500: Error en la Funcion fdbConectar en la pagina ".$this->pagina." envocada desde la clase ".$this->clase." y la función ".$nombreFuncion.",<br>No se logro la conexion";
	    		die;
	    	}
		}
		/**
		*
		*pagina
		*
		*Es la encarga de hacer la desconexion a la Base de Datos.
		*@param string $conexion Es el id de conexion
		*@return void
		*/
		function fdbDesConexion($conexion="")
		{
			pg_close ($conexion);
		}
		/**
		*
		*fdbInsert
		*
		*Esta funcion permite insertar datos dentro de una base de datos
		*@param string $nombreTabla Es el nombre de la tabla
		*@param array $arregloDatos Son los datos que se van a insertar 
		*@param string $numLinea Es el numero de linea desde donde se realiza la consulta
		*@param string $nombreFuncion Es el nmombre de la función desde donde se ejecuta la consulta
		*@return void
		*/
		function fdbInsert($nombreTabla="",$arregloDatos="",$numLinea="",$nombreFuncion="") 
		{
			$tamañoArregloDatos=count($arregloDatos);
			$this->conex=$this->fdbConectar($nombreFuncion);
			if($this->conex)
			{
	            $sql = "insert into $nombreTabla (";
	            $datos = '';
	            if($tamañoArregloDatos>0)
				{
					for ($i=0;$i<$tamañoArregloDatos;$i++)
		            {
		            		$sql .=   $arregloDatos[$i]["CAMPO"] . ",";
			            	
		            		if($arregloDatos[$i]["VALOR"]=='null')
		            		{
		            			$datos .= "null,";
		            		}
		            		else 
		            			$datos .= "'". $arregloDatos[$i]["VALOR"] . "',";
		            } 
		            $sql=substr($sql,0,strlen($sql)-1);
				}
				else 
				{
					die("La matriz de ArregloDatos Esta vacia ");
				}
	            $datos=substr($datos,0,strlen($datos)-1);
	            $sql.= ") values (" . $datos. '); select lastval()';
	            $arrayResultado=pg_query($sql);
	            if (!@$arrayResultado)
	            {
	            	$this->setLastError();
	            	echo "Error 0501: Error en la Funcion fdbInsert en la pagina ".$this->pagina."en la linea ".$numLinea." y función ".$nombreFuncion." envocada desde la clase ".$this->clase.",<br>Al momento de realizar la insercción, No se logro con Exito. <br> El sql es el siguiente:<br>". $sql;
	            	exit;
	            }
	            else
	            {
	            	$this->setAffRow($arrayResultado);
	            	$arrayResultado=pg_fetch_array($arrayResultado, 0);
	            	$this->setLastOid($arrayResultado[0]);
	            	$this->fdbDesConexion($this->conex);
	            }
			}
		}
		/**
		*
		*fdbdUpdate
		*
		*Esta funcion permite modificar datos dentro de una base de datos
		*@param string $nombreTabla Es el nombre de la tabla
		*@param array $arregloDatos Son los datos que se van actualizar
		*@param array $arregloCondicion Son los datos de la condición que deben de cumplir lo selemento s que se van a  actualizar
		*@param string $numLinea Es el numero de linea desde donde se realiza la consulta
		*@param string $nombreFuncion Es el nmombre de la función desde donde se ejecuta la consulta
		*@return string $html es Todo el codigo HTML que se va a desplegar en la pagina
		*/
		function fdbdUpdate($nombreTabla="", $arregloDatos="", $arregloCondicion="",$numLinea="",$nombreFuncion="")
		{
			$tamañoArregloDatos=count($arregloDatos);
			$tamañoCondicion=count($arregloCondicion);
			$this->conex=$this->fdbConectar($nombreFuncion);
			if($this->conex)
			{
				$sql = "update $nombreTabla set ";
	            $datos = '';
	            if(($tamañoArregloDatos>0) and (is_array($arregloDatos)))
				{
		            for ($i=0;$i<$tamañoArregloDatos;$i++)
		            {
		            	$sql .= ' ' . $arregloDatos[$i]["CAMPO"] . ' = ';
		            	if(!strpos($arregloDatos[$i]["VALOR"],"+"))
		            	{
		            		$sql .= '\'' .$arregloDatos[$i]["VALOR"].'\' ';
		            	}
		            	else 
		            	{   
		            		$sql .= $arregloDatos[$i]["VALOR"]."  ";
		            	}
		            	if($i!=$tamañoArregloDatos-1)
		            	{
		            		$sql.=" , ";	
		            	}
		            }
		                       
		            $sql=substr($sql,0,strlen($sql)-1);
				}
				else 
				{
					die("La matriz de Arreglo Datos Esta vacia  campo");
				}
	            // Se verifica que existe un criterio
				if(($tamañoCondicion>0) and (is_array($arregloCondicion)))
				{
					$sql.=" WHERE ";
					for ($i=0;$i<=$tamañoCondicion;$i++)
					{
						$sql.=" ".$arregloCondicion[$i]." ";
					}
				}
				//ECHO $sql;
				$arrayResultado=pg_query($sql);
				if (!@arrayResultado)
	            {
	            	$this->setLastError();
	            	echo "Error 0502: Error en la Funcion fdbUpdate en la pagina ".$this->pagina." en la linea ".$numLinea." y función ".$nombreFuncion." envocada desde la clase ".$this->clase.",<br>Al momento de realizar la modificacion, No se logro con Exito. <br> El sql es el siguiente:<br>". $sql;
	            	exit;
	            }
	            else
	            {
	            	
	            	$this->setAffRow($arrayResultado);
	            	$this->setLastOid($arrayResultado);
	            	$this->fdbDesConexion($this->conex);
	            }
			}
		}
		/**
		*
		*fbdSelect
		*
		*Esta funcion permite modificar datos dentro de una base de datos
		*@param array $arregloTable Son los nombres de las tablas involucradas en la consulta
		*@param array $arregloDatos Son los datos que se van actualizar
		*@param array $arregloCondicion Son los datos de la condición que deben de cumplir lo selemento s que se van a  actualizar
		*@param string $numLinea Es el numero de linea desde donde se realiza la consulta
		*@param string $nombreFuncion Es el nmombre de la función desde donde se ejecuta la consulta
		*@param string $anexo Es algun tipo de anexo que s ele quiera realizar a la consulta
		*@return array $matrizDatos Matriz con los resultados de la consulta comensando en $matrizDatos[1][1]
		*/
		function fbdSelect($arregloTable="", $arregloCampos="", $arregloCondicion="",$arregloOrden="",$numLinea="",$nombreFuncion="",$anexo="")
		{
			$sql="";
			$this->conex=$this->fdbConectar($nombreFuncion);
			if($this->conex)
			{
				$x=1;// VARIABLE QUE CONTROLA LAS FILAS DE LA MATRIZ
				$tamañoCondicion=count($arregloCondicion);
				$tamañoTable=count($arregloTable);
				$tamañoCampos=count($arregloCampos);
				$tamañoOrden=count($arregloOrden);
				if(($tamañoCampos>0) and (is_array($arregloCampos)))							
				{
					$sql="SELECT ";
					foreach ($arregloCampos as $index => $valor)
					{
						if(($index!=$tamañoCampos-1) and ($valor!=""))						
						{
							$sql.=$valor.",";
						}
						else 
						{
							$sql.=$valor;
						}
					}
				}
				else 
				{
					die("La matriz de Campos Esta vacia. ");
				}
				$sql.=" FROM ";
				if(($tamañoTable>0) and (is_array($arregloTable)))
				{
					foreach ($arregloTable as $index => $valor)
					{
						if($index!=$tamañoTable-1)						
						{
							$sql.=$valor.",";
						}
						else 
						{
							$sql.=$valor;
						}
					}
				}
				else 
				{
					die("La matriz de tablas Esta vacia ");
				}				
				if(($tamañoCondicion>0) and (is_array($arregloCondicion)))
				{
					$sql.=" WHERE ";
					for ($i=0;$i<=$tamañoCondicion;$i++)
					{
						$sql.=" ".$arregloCondicion[$i]." ";
					}
				}	
				$sql.=$anexo;
				if(($tamañoOrden>0) and (is_array($arregloOrden)))
				{
					$sql.=" ORDER BY ";
					for ($i=0;$i<$tamañoOrden;$i++)
					{
						$sql.=" ".$arregloOrden[$i]." ";
					}
				}
			//echo $sql; 
				$arrayResultado=pg_query($sql);
	        	if (!@$arrayResultado)
	            {
	            	$this->setLastError();
	            	die("Error 0503: Error en la Funcion fbdSelect en la pagina ".$this->pagina." en la linea ".$numLinea." y función ".$nombreFuncion." envocada desde la clase ".$this->clase.",<br>Al momento de realizar la consulta, No se logro con Exito. <br> El sql es el siguiente:<br>". $sql);
	            	exit;
	            }
	            else
	            {
	            	$this->setNumRow($arrayResultado);
	            	while($array_resul=pg_fetch_array($arrayResultado, null, PGSQL_NUM))
					{
						$j=1;
						$tam=count($array_resul);
						for ($y = 0; $y <$tam; $y++)
						{
							$matrizDatos[$x][$j] = $array_resul[$y];							
							$j++;
						}
						$x++;
					}
				    return $matrizDatos;
				    $this->fdbDesConexion($this->conex); 
	            }
			}
		}
			/**
		*
		*actualizaConsulta
		*
		*Asigna los valores en el arreglo de datos de los campos
		*@param array $campos contiene el Nombre del campo.
		*@param string $valores es el conjunto de valores que se le va asignar a los campos. Primero se coloca la posición que tiene la condición en la matrizy luego el valor
		*@return array $campos es un array con el nombre de los campos cons sus respectivos valores.
		*/
		function actualizaConsulta($campos="",$valores="")
		{
			if(strlen($valores)>0)
			{
				$arrayValores=explode(";",$valores);
				$tamañoValores=count($arrayValores);
				for ($i=0;$i<$tamañoValores-1;$i++)
				{
					$auxValor=explode(",",$arrayValores[$i]);
					$campos[$auxValor[0]]["VALOR"]=$auxValor[1];
				}				
			}
			return $campos;
		}
		/*Actualiza el array de las condiciones*/
		/**
		*
		*pagina
		*
		*Arma toda la condición de una consulta
		*@param array $campos conjunto de campos y valores que contiene la condición (campo, valores y aoperdores logicos).
		*@return string $arrayWhere La parte de la condición
		*/
		function fArmaCondicion($campos="")
		{
			$tamañoCampos=count($campos);	
			if(($tamañoCampos>0) and (is_array($campos)))
			{
				$arrayWhere=array();
				for ($i=0;$i<$tamañoCampos;$i++)
				{
					$condicion=$campos[$i]["CAMPO"].$campos[$i]["OPERADORR"].$this->fAntesCondicion($campos[$i]["OPERADORR"],$campos[$i]["VALOR"]).$campos[$i]["VALOR"].$this->fDespuesCondicion($campos[$i]["OPERADORR"],$campos[$i]["VALOR"]).$campos[$i]["OPERADORL"];
					$arrayWhere[]=$condicion;
				}
				return $arrayWhere;
			}
			else 
			{
				return "";	
			}
		}
		/**
		*
		*fArmaOrden
		*
		*Es la encargada de crear la estructura de una pagina
		*@param array $orden contiene los valores que se necesitam para incorporar el order by en ua sentecia de selsccion.
		*@return array $arrayOrden contiene un conjunto de string con la parte de order by de la sentencia de selección.
		*/
		function fArmaOrden($orden="")
		{
			$tamañoOrden=count($orden);			
			if(($tamañoOrden>0) and (is_array($orden)))
			{
				$arrayOrden=array();
				for ($i=0;$i<$tamañoOrden;$i++)
				{
					if($i!=($tamañoOrden-1))
					{
						$coma=",";	
					}
					else 
					{
						$coma="";
					}
					$auxOrden=$orden[$i]["CAMPO"]." ".$orden[$i]["ORD"].$coma;
					$arrayOrden[]=$auxOrden;
				}
				return $arrayOrden;
			}
			else 
			{
				return "";	
			}
		}
		/**
		*
		*fAntesCondicion
		*
		*Retorna el valor que va antes del operador logico.
		*@param string $operador es el operador relacional (=,<,>,<=,>=,in,like,!=
		*@param string $valor es el valor que se va a relacionar
		*@return string $aux es el valor que corresponde antes del operador logico.
		*/
		function fAntesCondicion($operador="",$valor="")
		{
			$aux="";
			if((($operador=="=")or($operador=="!=") or ($operador=="like")) and (!strpos($valor,".")))
			{
				$aux="'";
			}
			elseif ($operador=="in")
			{
				$aux=" ( ";
			}
			return $aux;
		}
		/**
		*
		*fDespuesCondicion
		*
		*Retorna el valor que va despues del operador logico.
		*@param string $operador es el operador relacional (=,<,>,<=,>=,in,like,!=
		*@param string $valor es el valor que se va a relacionar
		*@return string $aux es el valor que corresponde antes del operador logico.
		*/
		function fDespuesCondicion($operador="",$valor="")
		{
			$aux="";
			if((($operador=="=")or($operador=="!=")or ($operador=="like")) and (!strpos($valor,".")))
			{
				$aux="'";
			}
			elseif ($operador=="in")
			{
				$aux=" ) ";
			}
			return $aux;
		}
		function getNumRow()
		{
			if(!empty($this->numRow))
				return $this->numRow;
			else 
				return false;
		}
		function getLastError()
		{
			if(!empty($this->lastError))
				return $this->lastError;
			else 
				return false;
		}
		function getLastOid()
		{
			if(!empty($this->lastOid))
				return $this->lastOid;
			else 
				return false;
		}
		function getAffRow()
		{
			if(!empty($this->affRow))
				return $this->affRow;
			else 
				return false;
		}
		function setNumRow($resultado)
		{
			$this->numRow=pg_num_rows($resultado);
		}
		function setLastError()
		{
			$this->lastError=pg_last_error();
		}
		function setLastOid($resultado)
		{
			$this->lastOid=$resultado; 
		}
		function setAffRow($resultado)
		{
			$this->affRow=pg_affected_rows($resultado);
		}
		function getArgumentConsulta()
		{
			$argumentos=array();
			$a=$this->getAffRow();
			if ($a!=false)
			{
				$argumentos['affRow']=$a;
			}
			$a=$this->getNumRow();
			if ($a!=false)
			{
				$argumentos['numRow']=$a;
			}
			$a=$this->getLastError();
			if ($a!=false)
			{
				$argumentos['lastError']=$a;
			}
			$a=$this->getLastOid();
			if ($a!=false)
			{
				$argumentos['lastOid']=$a;
			}
			return $argumentos;				
		}
    }
?>