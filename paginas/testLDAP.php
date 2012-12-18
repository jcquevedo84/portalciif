<?php
$servidor_ldap = "cantv.com.ve";  // el servidor LDAP al que se quiere conectar "ldap.example.com"
$puerto_ldap   = 389;              // el puerto al que se conectara
// Estableciendo la conexion con el servidor LDAP
$username="";//usuario paraconectarse al ldap
$userclave="";//contraseña para conectarse al LDAP
$conexion_ldap = ldap_connect($servidor_ldap, $puerto_ldap);
if($conexion_ldap){
	$r=@ldap_bind($this->conexion_ldap, $username."@".$servidor_ldap, $userclave);
    // Verificamos que el usuario y contraseña sean validos para el Ldap
    if($r)
    {
    	$info = $this->select->select_usuario($campos['USUARIO']);
		if( count($info) > 0) 
		{
			print_r($info);
		}
    }
    else
    {
              
    }
}


?>