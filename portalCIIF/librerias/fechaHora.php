<?php
/*
    Caracas; 18/05/2006
    Clase Libreria de Fechas y Horas (classLibFecHor)
    Fundación Instituto de Ingenieria Version 1.0
*/
	class fechaHora
	{
		/*
		    Funcion de libreria, Mes en String (flibMesString($numMes))
		    $numMes: un numero entre [0,12] y 
		    retorna el mes asociado a ese numero.
		*/
		function flibMesString($numMes)
        {
            //prueba 
        	if($numMes>=1 && $numMes<=12)
            {
            	$nombreMes= array(
            		"1"	=>"Enero",
            		"2"	=>"Febrero",
            		"3"	=>"Marzo",
            		"4"	=>"Abril",
            		"5"	=>"Mayo",
            		"6"	=>"Junio",
            		"7"	=>"Julio",
            		"8"	=>"Agosto",
            		"9"	=>"Septiembre",
            		"10"=>"Octubre",
            		"11"=>"Noviembre",
            		"12"=>"Diciembre");
            	return $nombreMes[$numMes];
            }
            else
            {
                return "Error 0001: Valor del parámetro incorrecto. [01,12]";
            }
        }
		/*
    		Funcion de libreria, Invertir de Español a Ingles flibInvertirEsIn($fechaEs)
    		Formato Español: dd/mm/yyyy
    		Formato Ingles: yyyy/mm/dd 
		*/
		function flibInvertirEsIn($fechaEs)
        {
        	$dia=substr($fechaEs, 0, 2);
        	$mes=substr($fechaEs, 3, 2);
        	$ano=substr($fechaEs, 6, 4);
        	$fechaIn = ($ano."/".$mes."/".$dia);
        	return $fechaIn;
        }
        /*
    		Funcion de libreria, Invertir de Ingles a Español flibInvertirInEs($fechaIn)
    		Formato Ingles: yyyy/mm/dd 
    		Formato Español: dd/mm/yyyy
		*/
		function flibInvertirInEs($fechaIn)
        {
        	$dia=substr($fechaIn, 8, 2);
        	$mes=substr($fechaIn, 5, 2);
        	$ano=substr($fechaIn, 0, 4);
        	$fechaEs = ($dia."/".$mes."/".$ano);
        	return $fechaEs;
        }
		/*
            Funcion libreria, Suma N dias a una fecha Dada flibSumNdiaFecha($nDia, $fecha, $formato)
            Uso de los parámetros:
                $nDia: Numeros de días que se desean Sumar
                $fecha: Fecha que se le desea sumar los días
                $formato:
                            0 => Indica si es Español. (dd/mm/yyyy)
                            1 => Indica si es Ingles. (yyyy/mm/dd)
        */
        function flibSumNdiaFecha($nDia, $fecha, $formato)
        {
            if($formato>=0 && $Formato<=1)
            {
                if($nDia>=0)
                {
                    if($formato==0)
                        $fechaFun=$this->flibInvertirEsIn($fecha);//Convertimos al formato ingles
                    else
                        $fechaFun=$fecha;
                    //Extraemos las sub cadenas
                    $dia=substr($fechaFun, 8, 2);
                	$mes=substr($fechaFun, 5, 2);
                	$ano=substr($fechaFun, 0, 4);
                    $fechaFunAux= mktime (0, 00, 00, $mes, $dia, $ano );
                    $sum=$fechaFunAux + 86400*$nDia;
                    $fechaFun= getdate($sum);
					// Para poder hacer la conversion de datos
                    if($fechaFun['mday']<10)
                    {
                    	$dia="0".$fechaFun['mday'];
                    }
                    else
                    {
                    	$dia=$fechaFun['mday'];
                    }
                    // Para poder hacer la conversion de datos
                    if($fechaFun['mon']<10)
                    {
                    	$mes="0".$fechaFun['mon'];
                    }
                    else
                    {
                    	$mes=$fechaFun['mon'];
                    }
                    $fechaFun=$fechaFun['year']."/".$mes."/".$dia;
                    if($formato==0)
                        return $this->flibInvertirInEs($fechaFun);
                    else
                        return $fechaFun;
                }
                else
                {
                    return "Error 0001: Valor del parámetro 'nDia' incorrecto. [nDia >= 0]";
                }
            }
            else
            {
                return "Error 0001: Valor del parámetro 'Formato' incorrecto. [0,1]";
            }
        }
        /*
            Funcion libreria, Resta N dias a una fecha Dada flibResNdiaFecha($nDia, $fecha, $formato)
            Uso de los parámetros:
                $nDia: Numeros de días que se desean Sumar
                $fecha: Fecha que se le desea restar los días
                $formato:
                            0 => Indica si es Español. (dd/mm/yyyy)
                            1 => Indica si es Ingles. (yyyy/mm/dd)
        */
        function flibResNdiaFecha($nDia, $fecha, $formato)
        {
            if($formato>=0 && $Formato<=1)
            {
                if($nDia>=0)
                {
                    if($formato==0)
                        $fechaFun=$this->flibInvertirEsIn($fecha);//Convertimos al formato ingles
                    else
                        $fechaFun=$fecha;
                    //Extraemos las sub cadenas
                    $dia=substr($fechaFun, 8, 2);
                	$mes=substr($fechaFun, 5, 2);
                	$ano=substr($fechaFun, 0, 4);
                    $fechaFunAux= mktime (0, 00, 00, $mes, $dia, $ano );
                    $resta=$fechaFunAux - 86400*$nDia;
                    $fechaFun= getdate($resta);
                    if($fechaFun['mday']<10)
                    {
                    	$dia="0".$fechaFun['mday'];
                    }
                    else
                    {
                    	$dia=$fechaFun['mday'];
                    }
                    // Para poder hacer la conversion de datos
                    if($fechaFun['mon']<10)
                    {
                    	$mes="0".$fechaFun['mon'];
                    }
                    else
                    {
                    	$mes=$fechaFun['mon'];
                    }
                    $fechaFun=$fechaFun['year']."/".$mes."/".$dia;
                    if($formato==0)
                        return $this->flibInvertirInEs($fechaFun);
                    else
                        return $fechaFun;
                }
                else
                {
                    return "Error 0001: Valor del parámetro 'nDia' incorrecto. [nDia >= 0]";
                }
            }
            else
            {
                return "Error 0001: Valor del parámetro 'Formato' incorrecto. [0,1]";
            }
        }
         /*
            Funcion de libreria, Data Time (flibDataTime())
            Retorna el dato: Dia y Hora actual, unidos.
		*/
		function flibDataTime()
		{
			return $this->flibDia()." ".$this->flibHora();
		}
		/*
            Funcion de libreria, Dia Actual del Servidor (flibDia())
            Retorna el día actual en formato Ingles.
        */
        function flibDia()
        {
        	return date("Y/m/d");
        }
        /*
            Funcion de libreria, Hora Actual del servidor (flibHora())
            retorna la hora actual en formato: Hora:Minutos:Segundos
        */
        function flibHora()
        {
        	return date("H:i:s");
        }
        /*
        	Función de Libreria Calcula la cantidad de Horas Existentes en un intervalo de Fechas.
        	Uso de los parametros:
	        	$fechaInicio:  Es la fecha inferior del intervalo yyyy/mm/dd hh:mm:ss
	        	$fechaFin: Es la fecha superior del intervalo yyyy/mm/dd hh:mm:ss
        	retorna la cantidad de horas existentes en el intervalo.
        */
        function tiempoHoras($fechaInicio="", $fechaFin="")
		{
			if(($fechaInicio!='') and ($fechaFin!=''))
			{
				//se asigna los valores a variables independientes
				$numdia=0;
				$fechaI=substr($fechaInicio, 0, 10);
				$fechaF=substr($fechaFin, 0, 10);
				$añoI=substr($fechaI, 0, 4);
				$mesI=substr($fechaI, 5, 2);
				$diaI=substr($fechaI, 8, 2);
				$horasI=substr($fechaInicio, 11, 18);
				$horaI=substr($horasI, 0, 2);
				$minutoI=substr($horasI, 3, 2);
				$segundoI=substr($horasI, 6, 8);
				$añoF=substr($fechaF, 0, 4);
				$mesF=substr($fechaF, 5, 2);
				$diaF=substr($fechaF, 8, 2);
				$horasF=substr($fechaFin, 11, 18);
				$horaF=substr($horasF, 0, 2);
				$minutoF=substr($horasF, 3, 2);
				$segundoF=substr($horasF, 6, 8);
				//Se extrae la cantidad de Horas y Minutos que se encuentran en los extremos, es decir los sobrantes de los dias completos
				//si estan en la misma hora
				if($horaI==$horaF)
				{
					$hora=0;
					//si estan en el mismo minuto
					if($minutoI==$minutoF)
					{
						$minuto=0;
					}
					else
					{
						if($minutoI>$minutoF)
						{
							$minuto=($minutoI-$minutoF)/60;
						}
						else
						{
							$minuto=($minutoF-$minutoI)/60;
						}   
					}   
				}
				else
				{
					if($horaI>$horaF)
					{
						$hora=$horaI-$horaF;
					}
					else
					{
						$hora=$horaF-$horaI;
					}
					if($minutoI==$minutoF)
					{
						$minutoI=0;
						$minutoF=0;
					}
					else
					{
						$minuto=($minutoF-$minutoI)/60;
					}
				}
				//se extraen la cantidad de Segundos
				$segundoI=60-$segundoI;
				$segundo=($segundoI+$segundoF)/3600;
				//se calcula el tiempo total en horas
				$tiempoTotal= $hora + $minuto + $segundo;
				//Se extrae la cantidad de dias existentes en el intervalo
				$numdia=abs($this->CuentaDiasSinFinSemanas($añoI, $añoF,$mesI, $mesF, $diaI, $diaF));
				//se convierte los dias en horas
				$numdia*=24;	
				if($numdia==0)
				{
					$tiempoTotal+=$numdia;
				}
				else
				{
					// se deside si el tiempo calculado en horas en la linea 285 es un exceso o un faltantes
					if($horaI>$horaF)
					{
						$tiempoTotal=$numdia-$tiempoTotal;
					}
					else
					{
						$tiempoTotal=$numdia+$tiempoTotal;
					}  
				}   
				//aprocima la cantidad de horas
				$tiempoTotal=ceil($tiempoTotal);
			}
			//imprime s/n si estan vacios los campos de entrada
			else
			{
				$tiempoTotal="S/n";
			}	
			return $tiempoTotal;
		}
     	/*
        	Función de Libreria Calcula la cantidad de dias en un intervalo de Fechas solo mese y dias.
        	Uso de los parametros:
	        	$mesInicio:  Es el mes de inicio
	        	$mesFin:  Es el mes de finalización
	        	$diaInicio:  Es el día de inicio
	        	$diaFin:  Es el día de finalización
        	retorna la cantidad dias existentes en un intervalo.
        	Excluye un dia, por ejemplo si el dia inicio es 18 y el dia fin es 20 son dos dias.
        */
		function calculoDias($mesInicio="", $mesFin="", $diaInicio="", $diaFin="")
		{
	      $catDias=0;
	      $aux=0;
	      $diaMes=0;
	      if($mesInicio==$mesFin)
	      {
	         $catDias=$diaFin-$diaInicio;
	      }
	      else
	      {
	         for($i=$mesInicio;$i<=$mesFin; $i++)
	         {
	            $diaMes=$this->verificaMes($i);
	            if($aux==0)
	            {
	               $catDias+=$diaMes-$diaInicio;
	               $aux=1;
	            }
	            else
	            {
	               if($i==$mesFin)
	               {
	                  $catDias+=$diaFin;
	               }
	               else
	               {
	                  $catDias+=$diaMes;
	               }
	            }
	         }
	      }
	      return $catDias;
		}
		/*
			Función de Libreria que extrae el numero de dias del mes correspondiente.
			Uso de los parametros:
	        	$mes:  Es el mes a la cual deseo extraer la cantidad de dias.
        	Esta función retorna la cantidad de dias de un mes.
		*/
		function verificaMes($mes="")
		{
		   $nomMes=array('01'=> array(1=>31),'02'=> array(1=>28),'03'=> array(1=>31),'04'=> array(1=>30),
		                     '05'=> array(1=>31),'06'=> array(1=>30),'07'=> array(1=>31),'08'=> array(1=>31),
		                     '09'=> array(1=>30),'10'=> array(1=>31),'11'=> array(1=>30),'12'=> array(1=>31));
		   return $nomMes[$mes][1];
		
		}
	    /*
        	Función de Libreria Calcula la cantidad de dias en un intervalo de Fechas solo mese y dias.
        	Uso de los parametros:
	        	$añosInicio: Es el año de Inicio 
	        	$añoFin: Es el año de Fin
        		$mesInicio:  Es el mes de inicio
	        	$mesFin:  Es el mes de finalización
	        	$diaInicio:  Es el día de inicio
	        	$diaFin:  Es el día de finalización
        	retorna la cantidad dias existentes en un intervalo.
        	Excluye un dia, por ejemplo si el dia inicio es 18 y el dia fin es 20 son dos dias Incluye Sabados y Domingos.
        */ 
		function CuentaDias($añosInicio="", $añoFin="",$mesInicio="", $mesFin="", $diaInicio="", $diaFin="")
	     {
			$mesMayor=0;
			$mesMenor=0;
			$numDias=0;
			$i=0;
			$cantAño=$añoFin-$añosInicio;
			$cantDias=0;
			if($añosInicio==$añoFin)
			{
				$cantDias=$this->calculoDias($mesInicio, $mesFin, $diaInicio, $diaFin);
			}
			else
			{
				while($i<$cantAño)
				{
					//lo unico que fal es verificar si el año es viciesto
					if($i!=$cantAño-1)
					{
					 	$cantDias+=365;
					}
					else
					{
						$cantDias+=$this->calculoDias($mesInicio, 12, $diaInicio, 31);
						$cantDias+=$this->calculoDias(01, $mesFin, 01, $diaFin);
					}
					$i++;
				}  
			}
			return $cantDias;
	     }
	     /*
        	Función de Libreria Calcula la cantidad de dias en un intervalo de Fechas solo mese y dias.
        	Uso de los parametros:
	        	$añosInicio: Es el año de Inicio 
	        	$añoFin: Es el año de Fin
        		$mesInicio:  Es el mes de inicio
	        	$mesFin:  Es el mes de finalización
	        	$diaInicio:  Es el día de inicio
	        	$diaFin:  Es el día de finalización
        	retorna la cantidad dias existentes en un intervalo.
        	Excluye un dia, por ejemplo si el dia inicio es 18 y el dia fin es 20 son dos dias no Incluye Sabados ni Domingos.
        */ 
	     function CuentaDiasSinFinSemanas($añosInicio="", $añoFin="",$mesInicio="", $mesFin="", $diaInicio="", $diaFin="")
	     {
		      $cantDias=0;
		      $semana=0;
		      $decimal=0.7142871;
		      $cantDias=$this->CuentaDias($añosInicio, $añoFin,$mesInicio, $mesFin, $diaInicio, $diaFin);
		      //ECHO "<BR> EN CUAENTA DIAS FERIADOS ".$cantDias;
		      //hay que ap`roxiamr cuando pase de 0,7142871
		      $aux=($cantDias/7);
		      $auxx=floor($cantDias/7);
		      $au=$auxx+$decimal;
		      if($aux>$au)
		      {
		         $semana=$auxx;
		      }
		      else
		      {
		         $semana=floor($aux/7);
		      }
		      $semana*=2;
		      $cantDias-=$semana;
		      return  $cantDias;
	     }
    }
?>