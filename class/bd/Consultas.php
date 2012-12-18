<?php
/**
*LPAIS Consultas
*
*Archivo donde se configuran todas las consultas a la base de datos
*En este archivo estan contenidas todas aquellas variables gloabales al sistema Web
*@copyright Instituto de Ingenieria CPDI
*@author Juan Carlos Rodriguez - Jesus Rodriguez - Rosa Aguilar
*@version 1.0
*@package Consultas
*/

/**
*
*Contiene todas las consultas que se realizaran en la aplicación.
*En caso de que la consulta fuera de insercion o actualizaciónen el index campos 0=>array( 'CAMPO'=>'a.fechaexp','VALOR'=>'')
*array[]=array[nombrePagina]=array[campos] es un array que contiene todos los campos a seleccionar, eliminar o modificar en la consulta
*		 					 array[tablas] son las tablas a las cuales se le aplicara la consulta
							 array[condicion]= es un array que contiene los valores que se tomara en las condicion de la consulta, pueden ser varias condiciones
							 				   array[CAMPO] es el campos a la cual se aplicar ala condición.
							 				   array[OPERADORR] es el operador de relacion =,<,>,<=,>=,!=
							 				   array[OPERADORL] en el operador logico and, or, not
							 				   array[VALOR] Es el valor que tomara la condición.
							 array[orden]=	 Es un array que contien el orden en que se presentara la consulta  
							 				   array[CAMPO] es el nombre del campo
							 				   array[ORD] es el orden en que aparecera desc, asc.
*@global array $Consulta registroSolicitanteM
*@name $Consulta
*/
$Consulta=array(

'indexM'=>array(
					'consultarLogin'=>array(
										'campos'=>array('a.id','a.nombre','b.nombre','a.email','a.poo','a.apellido'),
										'tablas'=>array('autenticacion.usuarios as a','autenticacion.tipo_usuarios as b'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'login','OPERADORR'=>'=','OPERADORL'=>' and ','VALOR'=>''),
															1=>array( 'CAMPO'=>'password','OPERADORR'=>'=','OPERADORL'=>' and ','VALOR'=>''),
															2=>array( 'CAMPO'=>'a.codtipousuario','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'b.id')
							      						  ),
										'orden'=>''
					),
					'recordarPass'=>array(
										'campos'=>array('id','login','password','nombre','codtipousuario','codempresa'),
										'tablas'=>array('autenticacion.usuarios'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'login','OPERADORR'=>'=','OPERADORL'=>' and ','VALOR'=>''),
															1=>array( 'CAMPO'=>'docidentidad','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
							      						  ),
										'orden'=>''
					)
				),

'gestionUsuarioM'=>array(
				  'tipousuario'=>array(
										'campos'=>array('id','nombre'),
										'tablas'=>array('autenticacion.tipo_usuarios'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'estado','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'1')
							      						  ),
										'orden'=>''
					),
					'guardar'=>array(
										'campos'=>array(
													
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'apellido','VALOR'=>''),
														2=>array( 'CAMPO'=>'email','VALOR'=>''),
														3=>array( 'CAMPO'=>'poo','VALOR'=>''),
														4=>array( 'CAMPO'=>'codtipousuario','VALOR'=>''),
														5=>array( 'CAMPO'=>'idu','VALOR'=>''),
														6=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
										'tablas'=>array('autenticacion.usuarios')
					),
					'listar'=>array(
										'campos'=>array('a.id','a.nombre','a.apellido','a.email','a.estado'),
										'tablas'=>array('autenticacion.usuarios as a','autenticacion.tipo_usuarios as b'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'a.codtipousuario','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'b.id'),
							      						  ),
										'orden'=>array(
					        							0=>array('CAMPO'=>'a.nombre','ORD'=>'ASC')
												      )
							      						  
							      						  
							      	),										
					'seleccionar'=>array(
										'campos'=>array('id','nombre','apellido','email','poo','codtipousuario'),
										'tablas'=>array('autenticacion.usuarios'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>''),
							      						  ),
										'orden'=>''
					),
					'modificar'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'apellido','VALOR'=>''),
														2=>array( 'CAMPO'=>'email','VALOR'=>''),
														3=>array( 'CAMPO'=>'poo','VALOR'=>''),
														4=>array( 'CAMPO'=>'idu','VALOR'=>''),
														5=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
					       				'tablas'=>array('autenticacion.usuarios'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												),
					'actdes'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'estado','VALOR'=>''),
													),
					       				'tablas'=>array('autenticacion.usuarios'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												)
),
'vulnerabilidadesM'=>array(
				  
					'guardar'=>array(
										'campos'=>array(
													
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'rt','VALOR'=>''),
														3=>array( 'CAMPO'=>'fechadetectada','VALOR'=>''),
														4=>array( 'CAMPO'=>'fechareportada','VALOR'=>''),
														5=>array( 'CAMPO'=>'responsable','VALOR'=>''),
														6=>array( 'CAMPO'=>'tipocaso','VALOR'=>''),
														7=>array( 'CAMPO'=>'fechacierre','VALOR'=>''),
														8=>array( 'CAMPO'=>'idu','VALOR'=>''),
														9=>array( 'CAMPO'=>'ip','VALOR'=>''),
														10=>array( 'CAMPO'=>'status','VALOR'=>'')
														),
										'tablas'=>array('vulnerabilidades.vulnerabilidad')
					),
					'listar'=>array(
										'campos'=>array('a.id','a.identificador','a.nombre','(select count(b.idcaso) from vulnerabilidades.vulnerabilidad as b where (a.identificador=b.idcaso or cast(a.id as text)=b.idcaso) and b.tipocaso=2) as cantidad','status','estado'),
										'tablas'=>array('vulnerabilidades.vulnerabilidad as a'),
										'condicion'=>array(0=>array( 'CAMPO'=>'a.tipocaso','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'1')
										   						),
										'orden'=>array(
					        							0=>array('CAMPO'=>'a.nombre','ORD'=>'ASC')
												      )
							      	),
				    'buscar'=>array(
										'campos'=>array('a.id','a.identificador','a.nombre','a.descripcion','a.tipocaso','estado'),
										'tablas'=>array('vulnerabilidades.vulnerabilidad as a'),
										'condicion'=>'',
										'orden'=>array(
					        							0=>array('CAMPO'=>'a.identificador','ORD'=>'ASC')
												      )
							      	),										
					'seleccionar'=>array(
										'campos'=>array('id','identificador','nombre','descripcion','estado'),
										'tablas'=>array('vulnerabilidades.vulnerabilidad'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'idcaso','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
							      						  ),
										'orden'=>''
					),
					'mostrarSubCaso'=>array(
										'campos'=>array('a.id','a.identificador','a.nombre','a.descripcion','a.estado'),
										'tablas'=>array('vulnerabilidades.vulnerabilidad as a'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'a.idcaso','OPERADORR'=>'=','OPERADORL'=>' or ','VALOR'=>''),
															1=>array( 'CAMPO'=>'a.idcaso','OPERADORR'=>' in (select b.identificador from vulnerabilidades.vulnerabilidad as b where b.id=','OPERADORL'=>')','VALOR'=>'')
							      						  ),
										'orden'=>''
					),
					'verDetalle'=>array(
										'campos'=>array('id','nombre','descripcion','rt','fechadetectada','fechareportada','responsable','fechacierre'),
										'tablas'=>array('vulnerabilidades.vulnerabilidad'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>''),
							      						  ),
										'orden'=>''
					),
					'modificar'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'rt','VALOR'=>''),
														3=>array( 'CAMPO'=>'fechadetectada','VALOR'=>''),
														4=>array( 'CAMPO'=>'fechareportada','VALOR'=>''),
														5=>array( 'CAMPO'=>'responsable','VALOR'=>'')
														
														),
					       				'tablas'=>array('vulnerabilidades.vulnerabilidad'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												),
					'actdes'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'estado','VALOR'=>''),
													),
					       				'tablas'=>array('vulnerabilidades.vulnerabilidad'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												),
					'actualizarIdentificador'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'identificador','VALOR'=>''),
													),
					       				'tablas'=>array('vulnerabilidades.vulnerabilidad'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												)
),
'administracionM'=>array(
				  'tipousuario'=>array(
										'campos'=>array('id','nombre'),
										'tablas'=>array('autenticacion.tipo_usuarios'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'estado','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'1')
							      						  ),
										'orden'=>''
					),
					'guardarRol'=>array(
										'campos'=>array(
													
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'idu','VALOR'=>''),
														3=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
										'tablas'=>array('autenticacion.tipo_usuarios')
					),
					'listarRol'=>array(
										'campos'=>array('a.id','a.nombre','a.descripcion','a.estado'),
										'tablas'=>array('autenticacion.tipo_usuarios as a'),
										'condicion'=>'',
										'orden'=>array(
					        							0=>array('CAMPO'=>'a.nombre','ORD'=>'ASC')
												      )	  
							      	),										
					'seleccionarRol'=>array(
										'campos'=>array('id','nombre','descripcion'),
										'tablas'=>array('autenticacion.tipo_usuarios'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>''),
							      						  ),
										'orden'=>''
					),
					'modificarRol'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'idu','VALOR'=>''),
														3=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
					       				'tablas'=>array('autenticacion.tipo_usuarios'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												),
					'actdesRol'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'estado','VALOR'=>''),
													),
					       				'tablas'=>array('autenticacion.tipo_usuarios'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												)
),
'bibliotecaM'=>array(
				  
					'guardarSoftware'=>array(
										'campos'=>array(
													
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'link_externo','VALOR'=>''),
														3=>array( 'CAMPO'=>'idu','VALOR'=>''),
														4=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
										'tablas'=>array('biblioteca.biblioteca_software')
					),
					'listarSoftware'=>array(
										'campos'=>array('a.id','a.nombre','a.descripcion','a.estado'),
										'tablas'=>array('biblioteca.biblioteca_software as a'),
										'condicion'=>'',
										'orden'=>array(
					        							0=>array('CAMPO'=>'a.nombre','ORD'=>'ASC')
												      )	  
							      	),										
					'seleccionarSoftware'=>array(
										'campos'=>array('id','nombre','descripcion'),
										'tablas'=>array('biblioteca.biblioteca_software'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>''),
							      						  ),
										'orden'=>''
					),
					'modificarSoftware'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'idu','VALOR'=>''),
														3=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
					       				'tablas'=>array('biblioteca.biblioteca_software'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												),
					'actdesSoftware'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'estado','VALOR'=>''),
													),
					       				'tablas'=>array('biblioteca.biblioteca_software'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												)
),
'proyectoM'=>array(
				  
					'guardarProyecto'=>array(
										'campos'=>array(
													
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'fecha_creacion','VALOR'=>''),
														3=>array( 'CAMPO'=>'idu','VALOR'=>''),
														4=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
										'tablas'=>array('proyectos.proyectos')
					),
					'listarProyecto'=>array(
										'campos'=>array('a.id','a.nombre','a.fecha_creacion','a.estado'),
										'tablas'=>array('proyectos.proyectos as a'),
										'condicion'=>'',
										'orden'=>array(
					        							0=>array('CAMPO'=>'a.nombre','ORD'=>'ASC')
												      )	  
							      	),										
					'seleccionarProyecto'=>array(
										'campos'=>array('id','nombre','descripcion','fecha_creacion'),
										'tablas'=>array('proyectos.proyectos'),
										'condicion'=>array(
															0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>''),
							      						  ),
										'orden'=>''
					),
					'modificarProyecto'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'nombre','VALOR'=>''),
														1=>array( 'CAMPO'=>'descripcion','VALOR'=>''),
														2=>array( 'CAMPO'=>'fecha_creacion','VALOR'=>''),
														3=>array( 'CAMPO'=>'idu','VALOR'=>''),
														4=>array( 'CAMPO'=>'ip','VALOR'=>'')
														),
					       				'tablas'=>array('proyectos.proyectos'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												),
					'actdesProyecto'=>array('campos'=>array(
														0=>array( 'CAMPO'=>'estado','VALOR'=>''),
													),
					       				'tablas'=>array('proyectos.proyectos'),
					    				'condicion'=>array(0=>array( 'CAMPO'=>'id','OPERADORR'=>'=','OPERADORL'=>'','VALOR'=>'')
										   						),
					        			'orden'=>''
												)
)
)
?>