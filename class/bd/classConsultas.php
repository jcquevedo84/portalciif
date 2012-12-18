<?php
	/**
	*consultas
	*
	*Clase que gestiona las sentencias realizadas a la base de datos
	*@copyright Instituo de Ingenieria CPDI
	*@author Juan Carlos Rodriguez
	*@version 1.0
	*@package nombrepaginaM
	*
	*/
	class consultas extends classBdPg
	{
		/**
		* array guarda los resultados de las sentencia de selección.
		* @var string $resulQuery
		* @access public
		*/
		var $resulQuery=array();
		/**
		* string Guarda el nombre del archivo donde se almacenan la consulta.
		* @var string $archivo
		* @access public
		*/
		var $archivo="";
		/**
		* array que guarda los elementos necesarios para realizar las condiciones de la consulta.
		* @var string $condicion
		* @access public
		*/
		var $condicion=array();
		/**
		* array que guarda los el conjunto de tablas asociados a una consulta.
		* @var string $tabla
		* @access public
		*/
		var $tabla=array();
		/**
		* array que contiene el conjunto de campos asociados a la consulta.
		* @var string $campos
		* @access public
		*/
		var $campos=array();
		/**
		* array que guarda los elementos  necesarios para la parte del orden en la consulta de seleccion
		* @var string $orden
		* @access public
		*/
		var $orden=array();
		/**
		* string que guarda el nombre de la función desde donde se esta realizando la consulta.
		* @var string $dbName
		* @access public
		*/
		var $nombreF="";
		var $nombreClase="";
		var $nombrePagina="";
		var $varGlobalsBD=array();
		/**
		*
		*consultas
		*
		*Comstrucctor de la clase.
		*@param array $varGlobalsBD (Obligatorio) contiene todos los parametros de conexion hacia la base de datos.
		*@param string $nombrePagina (Obligatorio) Nombre de la pagina desde dond ese esta accediendo a la base de datos.
		*@param string $nombreClase (Obligatorio)  Nombre de la clase desde donde se estar creando la conexion.
		*@param string $archivo (Obligatorio) contiene la ruta completa del archivo donde se encuentran las consultas a la base de datos.
		*@param string $nombreFuncion (Obligatorio) contiene el nombre de la función desde donde es realizada la consulta.
		*@return void
		*/
		function consultas($nombrePagina="",$nombreClase="",$nombreFuncion="",$varGlobalsBD="",$archivo="")
		{
			if(!empty($varGlobalsBD)){
				$this->varGlobalsBD['nombrePGL']=$varGlobalsBD['nombrePGL'];
				$this->varGlobalsBD['servidorPGL']=$varGlobalsBD['servidorPGL'];
				$this->varGlobalsBD['loginPGL']=$varGlobalsBD['loginPGL'];
				$this->varGlobalsBD['clavePGL']=$varGlobalsBD['clavePGL'];
				$this->varGlobalsBD['puerto']=$varGlobalsBD['puerto'];
			}
			else {
				$this->varGlobalsBD['nombrePGL']="";
				$this->varGlobalsBD['servidorPGL']="";
				$this->varGlobalsBD['loginPGL']="";
				$this->varGlobalsBD['clavePGL']="";
				$this->varGlobalsBD['puerto']="";
			}
			if(!empty($nombrePagina))
				$this->nombrePagina=$nombrePagina;
			else 
				$this->nombrePagina="";//almacenar el error
			if(!empty($nombreClase))
			{
				$this->nombreClase=$nombreClase;
			}
			else 
			{
				//almacenar error
				$this->nombreClase="";
			}
			if(!empty($archivo))
			{
				$this->archivo=$archivo;
				require($this->archivo);
			}
			else 
			{
				$this->archivo=varConf::getRutasAccesoBDConsultas("consultas");
				require($this->archivo);
			}
			if(!empty($nombreFuncion))
			{
				$this->nombreF=$nombreFuncion;
			}
			else 
			{
				//almacenar error
				$this->nombreF="";
			}
			if(!empty($this->nombreClase) and !empty($this->nombreF))
			{
				$this->condicion=$Consulta[$this->nombreClase][$this->nombreF]['condicion'];
				$this->tabla=$Consulta[$this->nombreClase][$this->nombreF]['tablas'];
				$this->campos=$Consulta[$this->nombreClase][$this->nombreF]['campos'];
				$this->orden=$Consulta[$this->nombreClase][$this->nombreF]['orden'];
			}
			classBdPg::classBdPg($varGlobalsBD['nombrePGL'], $varGlobalsBD['servidorPGL'],$varGlobalsBD['loginPGL'],$varGlobalsBD['clavePGL'],$varGlobalsBD['puerto'],$nombrePagina,$nombreClase);	
		}
		/**
		*
		*selecion
		*
		*Construye y ejecuta una consulta de selección.
		*@param array $valores (Obligatorio) contiene los valores para la condición
		*@param string $numLinea (Obligatorio) Numeor de linea desde donde se realiza la oclumna
		*@param string $anexo (Obligatorio)  un anexo que se le puede colocar a las consultas de seleccion algun gryp by  o algo de ese estilo
		*@return array $resulQuery contiene todas las tuplas resultantes de la consulta
		*/
		function selecion($valores="",$numLinea="",$anexo=""){
			if(substr_count($valores,';')>0)
			{
				$this->actValoresCondicion($valores);
			}
			if(!empty($this->orden))
			{
				$this->actValoresOrden($this->orden);
			}
			$this->actCondicion();
			$this->resulQuery['resul']=$this->fbdSelect($this->tabla,$this->campos,$this->condicion,$this->orden,$numLinea,$this->nombreF,$anexo);
			$this->resulQuery['arg']=$this->getArgumentConsulta();
			return $this->resulQuery;
		}
		/**
		*
		*insercion
		*
		*Construye y ejecuta una consulta de inserción.
		*@param array $valores (Obligatorio) contiene los valores para la condición
		*@param string $numLinea (Obligatorio) Numeor de linea desde donde se realiza la oclumna
		*@return void
		*/
		function insercion($valores="",$numLinea=""){
			$this->actValoresInsercion($valores);
			$this->resulQuery['resul']=$this->fdbInsert($this->tabla[0],$this->campos,$numLinea,$this->nombreF);
			$this->resulQuery['arg']=$this->getArgumentConsulta();
			return $this->resulQuery;
		}
		/**
		*
		*actualizacion
		*
		*Construye y ejecuta una consulta de update.
		*@param array $valores (Obligatorio) contiene los valores que se van a actualizar
		*@param array $valoresCondicion (Obligatorio) contiene los valores para la condición
		*@param string $numLinea (Obligatorio) Numeor de linea desde donde se realiza la oclumna
		*@return void
		*/
		function actualizacion($valores="",$valoresCondicion="",$numLinea=""){
			$this->actValoresInsercion($valores);
			$this->actValoresCondicion($valoresCondicion);
			$this->actCondicion();
			$this->resulQuery['resul']=$this->fdbdUpdate($this->tabla[0],$this->campos,$this->condicion,$numLinea,$this->nombreF);
			$this->resulQuery['arg']=$this->getArgumentConsulta();
			return $this->resulQuery;
		}
		/**
		*
		*actCondicion
		*
		*Agrega un conjunto de condiciones de una consulta.
		*@return void
		*/
		function actCondicion(){
			$this->condicion=$this->fArmaCondicion($this->condicion);
		}
		/**
		*
		*actTabla
		*
		*Actualiza los valores de la tabla de una consulta.
		*@param array $valor (Obligatorio) contiene los valores de las tablas.
		*@return void
		*/
		function actTabla($valor=""){
			$this->tabla=$valor;
		}
		/**
		*
		*actTabla
		*
		*Agrega un conjunto de valores de los campos de una consulta.
		*@param array $valor (Obligatorio) contiene los valores de los campos.
		*@return void
		*/
		function actCampos($valor=""){
			$this->campos=$valor;
		}
		/**
		*
		*addTabla
		*
		*Agrega una tabla a la consulta.
		*@param array $valor (Obligatorio) contiene els valor de la tabla.
		*@return void
		*/
		function addTabla($valor=""){
			$this->tabla[]=$valor;
		}
		/**
		*
		*addCondicion
		*
		*Agrega una condición  a la consulta.
		*@param array $campo (Obligatorio) Nombre del Campo.
		*@param array $operador (Obligatorio) Operador de relación.
		*@param array $operadorl (Obligatorio) Operador Logico.
		*@param array $valor (Obligatorio) Valor del campo.
		*@return void
		*/
		function addCondicion($operadorRLast="",$campo="",$operador="",$operadorl="",$valor=""){
		$pos=count($this->condicion);
		if ($this->condicion[$pos-1]!=""){
			$this->condicion[$pos-1]['OPERADORL']= "' ".$operadorRLast." '";
		}
		$this->condicion[]=array('CAMPO'=>$campo,'OPERADORR'=>$operador,'OPERADORL'=>$operadorl,'VALOR'=>$valor);	
		}
		
		/**
		*
		*addOrden
		*
		*Agrega una sentencia de orden a la consulta.
		*@param array $campo (Obligatorio) Nombre del campo.
		*@param array $ord (Obligatorio) orden.
		*@return void
		*/
		function addOrden($campo="",$ord=""){
			$this->orden[]=array('CAMPO'=>$campo,'ORD'=>$ord);
		}		
		/**
		*
		*addCampos
		*
		*Agrega un campo a la consulta.
		*@param array $valor (Obligatorio) Nombre del campo.
		*@return void
		*/
		function addCampos($campo=""){
			$this->campos[]=array('CAMPO'=>$campo,'VALOR'=>'');
		}
		/**
		*
		*setCondicion
		*
		*actualizo una condición  a la consulta.
		*@param array $campo (Obligatorio) Nombre del Campo.
		*@param array $operador (Obligatorio) Operador de relación.
		*@param array $operadorl (Obligatorio) Operador Logico.
		*@param array $valor (Obligatorio) Valor del campo.
		*@return void
		*/
		function setCondicion($valor=""){
			$this->condicion=$valor;	
		}
		/**
		*
		*addOrden
		*
		*actualizo una sentencia de orden a la consulta.
		*@param array $campo (Obligatorio) Nombre del campo.
		*@param array $ord (Obligatorio) orden.
		*@return void
		*/
		function setOrden($id="",$campo="",$valor=""){
			$this->orden[$id][$campo]=$valor;
		}
		function setNombrePagina($nombrePagina=""){
			$this->nombrePagina=$nombrePagina;
		}
		function setNombreFuncion($nombreFuncion=""){
			$this->nombreF=$nombreFuncion;
		}
		/**
		*
		*addCampos
		*
		*actualizo  un campo a la consulta.
		*@param array $valor (Obligatorio) Nombre del campo.
		*@return void
		*/
		function setCampos($id="",$valor=""){
			$this->campos[$id]=$valor;
		}
		/**
		*
		*setDatosconsultas
		*
		*Actualiza el nombre de la función desde donde se realiza la consulta.
		*@param array $valor (Obligatorio) Nombre de la función.
		*@return void
		*/
		function setDatosconsultas(){
			include($this->archivo);
			$this->condicion=$Consulta[$this->nombreClase][$this->nombreF]['condicion'];
			$this->tabla=$Consulta[$this->nombreClase][$this->nombreF]['tablas'];
			$this->campos=$Consulta[$this->nombreClase][$this->nombreF]['campos'];
			$this->orden=$Consulta[$this->nombreClase][$this->nombreF]['orden'];
		}
		/**
		*
		*actValoresCondicion
		*
		*Actualiza el array de los valores de las condiciones.
		*@param array $valor (Obligatorio) conjunto de valores correspondiente a los campos de las condiciones.
		*@return void
		*/
		function actValoresCondicion($valor=""){
			$this->condicion=$this->actualizaConsulta($this->condicion,$valor);
		}
		/**
		*
		*actValoresInsercion
		*
		*Actualiza los valores de los campos de la consulta.
		*@param array $valor (Obligatorio) Conjunto de valores correspondiente a los campos.
		*@return void
		*/
		function actValoresInsercion($valor=""){
			$this->actCampos($this->actualizaConsulta($this->campos,$valor));
		}
		/**
		*
		*actValoresOrden
		*
		*Actualiza los valores del array del Orden dentro de la consulta.
		*@param array $valor (Obligatorio) Conjunto de valores del roden.
		*@return void
		*/
		function actValoresOrden($valorOrden=""){
			$this->orden=$this->fArmaOrden($valorOrden);
		}
	}
?>