<?php
include_once '../../librerias/log4j/Logger.php';
class mensaje {
	
	private $codigo;
    private $descripcion;
    private $logger;
	function mensaje($tipo="",$nameFile="",$desripcion="",$modulo="", $nameClass="", $nameFuction="",$numLine="")
	{
		$this->loadLoader($nameFile);
		$msg=$this->armarMensaje($desripcion,$modulo, $nameClass, $nameFuction,$numLine);
		$this->resgistrarExpection($tipo,$msg);
	}
	/**
	 * @return unknown
	 */
	public function getCodigo() {
		return $this->codigo;
	}
	
	/**
	 * @return unknown
	 */
	public function getDescripcion() {
		return $this->descripcion;
	}
	
	/**
	 * @param unknown_type $codigo
	 */
	public function setCodigo($codigo) {
		$this->codigo = $codigo;
	}
	
	/**
	 * @param unknown_type $descripcion
	 */
	public function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
	}
	public function loadLoader($nameFile=""){
		Logger::configure($nameFile);
		$this->logger = Logger::getRootLogger();
	}
	public function resgistrarExpection($tipo="",$msg=""){
		if($tipo=="1"){
			$this->logger->info($msg);
		}
		else 
			$this->logger->error($msg);
	}
	public function armarMensaje($desripcion="",$modulo="", $nameClass, $nameFuction,$numLine)
	{
		
		return $desripcion.". En el MODULO: ".$modulo." CLASE: ".$nameClass." FUNCION: ".$nameFuction." LINEA: ".$numLine;
	}
	
}

?>