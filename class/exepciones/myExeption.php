<?php
include_once '../modelo/mensaje.php';
;
class myExeption extends Exception {
	
	private $numLine;
	private $nameClass;
	private $nameFuction;
	private $type;
	private $modulo;
	private $nameFile="";
	public function myExeption($type="",$nameFile="",$message="", $code="",$modulo="",$numLine="",$nameClass="",$nameFuction=""){
		
		$this->nameFile=$nameFile;
		$this->type=$type;
		$this->modulo=$modulo;
		$this->numLine=$numLine;
		$this->nameClass=$nameClass;
		$this->nameFuction=$nameFuction;
		$this->loadLoader($nameFile);
		$msg=$this->armarMensaje($message,$modulo, $nameClass, $nameFuction,$numLine);
		$this->resgistrarExpection($tipo,$msg);
	}
	
	
	/**
	 * @return unknown
	 */
	public function getMensaje() {
		return $this->mensaje;
	}
	
	/**
	 * @return unknown
	 */
	public function getModulo() {
		return $this->modulo;
	}
	
	/**
	 * @return unknown
	 */
	public function getNameClass() {
		return $this->nameClass;
	}
	
	/**
	 * @return unknown
	 */
	public function getNameFuction() {
		return $this->nameFuction;
	}
	
	/**
	 * @return unknown
	 */
	public function getNumLine() {
		return $this->numLine;
	}
	
	/**
	 * @return unknown
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param unknown_type $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}
	
	/**
	 * @param unknown_type $file
	 */
	public function setFile($file) {
		$this->file = $file;
	}
	
	/**
	 * @param unknown_type $line
	 */
	public function setLine($line) {
		$this->line = $line;
	}
	
	/**
	 * @param unknown_type $mensaje
	 */
	public function setMensaje($mensaje) {
		$this->mensaje = $mensaje;
	}
	
	/**
	 * @param unknown_type $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}
	
	/**
	 * @param unknown_type $modulo
	 */
	public function setModulo($modulo) {
		$this->modulo = $modulo;
	}
	
	/**
	 * @param unknown_type $nameClass
	 */
	public function setNameClass($nameClass) {
		$this->nameClass = $nameClass;
	}
	
	/**
	 * @param unknown_type $nameFuction
	 */
	public function setNameFuction($nameFuction) {
		$this->nameFuction = $nameFuction;
	}
	
	/**
	 * @param unknown_type $numLine
	 */
	public function setNumLine($numLine) {
		$this->numLine = $numLine;
	}
	
	/**
	 * @param unknown_type $type
	 */
	public function setType($type) {
		$this->type = $type;
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