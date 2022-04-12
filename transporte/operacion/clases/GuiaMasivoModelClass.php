<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaMasivoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  

//LISTA MENU

  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'  
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }
  
  public function saveDetalleGuiaMasivo($usuario_id,$usuario_registra,$empresa_id,$oficina_id,$cliente_id,$solicitud_id,$Conex){
  	 $array_remesas=array();
     
	 
	 if($solicitud_id>0){
		 $this -> Begin($Conex);
		 $select_cli="SELECT cliente_id FROM solicitud_servicio WHERE cliente_id = $cliente_id AND solicitud_id=$solicitud_id";
		 $result_cli = $this -> DbFetchAll($select_cli,$Conex,true);
		 if(count($result_cli)>0){ 
		 
				$select="SELECT ss.*, ds.*, 
				(SELECT t.tipo_identificacion_id FROM cliente c, tercero t WHERE c.cliente_id=ss.cliente_id AND t.tercero_id=c.tercero_id)  AS tipo_identificacion_id
				FROM solicitud_servicio ss, detalle_solicitud_servicio ds 
				WHERE ss.solicitud_id=$solicitud_id AND  ds.solicitud_id=ss.solicitud_id AND ds.estado='D'
				ORDER BY detalle_ss_id ASC";
				
				$result = $this -> DbFetchAll($select,$Conex);
				if(count($result)>0){ 
					 for($i = 0; $i < count($result); $i++){
								// $consul_manual = $result[$i]['numero_remesa']!='' ? "AND manual = 1" :  "AND manual = 0" ; 
					 			$consul_manual ='';
								
								 $remesa_id  = $this -> DbgetMaxConsecutive("remesa","remesa_id",$Conex,false,1);	  
						
								$select1 = "SELECT MAX(numero_remesa) AS numero_remesa FROM remesa WHERE remesa_id>0 AND oficina_id = $oficina_id $consul_manual";
								$result1 = $this -> DbFetchAll($select1,$Conex,true);	
								
								$numero_remesa= $result[$i]['numero_remesa']!='' ? $result[$i]['numero_remesa'] : $result1[0]['numero_remesa'];
								//$numero_remesa = $result1[0]['numero_remesa'];
								
								if(is_numeric($numero_remesa)){	
									$select1 = "SELECT rango_remesa_fin FROM rango_remesa WHERE  estado = 'A'  AND oficina_id = $oficina_id $consul_manual";
									$result1 = $this -> DbFetchAll($select1,$Conex,true);
									$rango_remesa_fin = $result1[0]['rango_remesa_fin'];	
									$numero_remesa= $result[$i]['numero_remesa']!='' ? $numero_remesa : $numero_remesa+1;
									//$numero_remesa += 1;		
									if($numero_remesa > $rango_remesa_fin){
									  print 'El numero de Remesa para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!<br>'.$select1;
									  return false;
									}
									
								}else{	 
									$select1 = "SELECT rango_remesa_ini FROM rango_remesa WHERE estado = 'A' AND oficina_id = $oficina_id ";
									$result1 = $this -> DbFetchAll($select1,$Conex,true);
									$rango_remesa_ini = $result1[0]['rango_remesa_ini'];		
									if(is_numeric($rango_remesa_ini)){		
									  $numero_remesa = $rango_remesa_ini;
									}else{		
										print 'Debe Definir un rango de Remesas para la oficina!!!';
										return false;		
									  }	
								  }			
								
								 $array_remesas[$i]=$numero_remesa;
								 
								 $zona= $result[$i]['zona']!='' ? "'".$result[$i]['zona']."'" : "NULL";
								 $orden_despacho= $result[$i]['orden_despacho']!='' ? "'".$result[$i]['orden_despacho']."'" : "NULL";
								 
								 $valor_flete= $result[$i]['valor_flete']>0 ? "'".$result[$i]['valor_flete']."'" : "NULL";
								 $valor_seguro= $result[$i]['valor_seguro']>0 ? "'".$result[$i]['valor_seguro']."'" : "NULL";
								 $valor_otros= $result[$i]['valor_otros']>0 ? "'".$result[$i]['valor_otros']."'" : "NULL";
								 $valor_total= $result[$i]['valor_total']>0 ? "'".$result[$i]['valor_total']."'" : "NULL";
								 $cliente_proyecto_id= $result[$i]['cliente_proyecto_id']>0 ? "'".$result[$i]['cliente_proyecto_id']."'" : "NULL";
								 
								 $fecha_recogida_ss = $result[$i]['fecha_recogida_ss']>0 ? "'".$result[$i]['fecha_recogida_ss']."'" : "NULL";
								 $hora_recogida_ss = $result[$i]['hora_recogida_ss']>0 ? "'".$result[$i]['hora_recogida_ss']."'" : "NULL";
								 
								 //Propietario mercancia inicio
									$select_prop = "SELECT tercero_id AS propietario_mercancia_id, 
									CONCAT_WS(' ',(CONCAT_WS('-',numero_identificacion,digito_verificacion)),primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS propietario_mercancia,
									CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) AS propietario_mercancia_txt,    
									(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_propietario_mercancia,
									
									numero_identificacion AS numero_identificacion_propietario_mercancia FROM tercero t WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = $cliente_id)";
									
									$result_prop = $this -> DbFetchAll($select_prop,$Conex,$ErrDb = false);      
									
									$propietario_mercancia_id		= $result_prop[0]['propietario_mercancia_id'];
									$propietario_mercancia			= $result_prop[0]['propietario_mercancia'];
									$tipo_identificacion_propietario_mercancia		= $result_prop[0]['tipo_identificacion_propietario_mercancia'];
									$numero_identificacion_propietario_mercancia	= $result_prop[0]['numero_identificacion_propietario_mercancia'];
								 //propietario mercancia fin
								 
								 $destinatario_id=$result[$i]['destinatario_id']>0 ? $result[$i]['destinatario_id'] : 'NULL';
								 
								 //poliza de seguro 
									
									$select_pol = "SELECT p.aseguradora_id, p.numero, p.fecha_vencimiento FROM poliza_empresa p 
									WHERE  p.estado = 'A' AND p.empresa_id=$empresa_id ORDER BY p.poliza_empresa_id DESC";
									
									$result_pol = $this -> DbFetchAll($select_pol,$Conex,$ErrDb = false);      
									
									$aseguradora_id		= $result_pol[0]['aseguradora_id'];
									$numero_poliza			= $result_pol[0]['numero'];
									$fecha_vencimiento_poliza		= $result_pol[0]['fecha_vencimiento'];			 
							
								 
								 
								 
								 $insert = "INSERT INTO remesa (tipo_remesa_id,clase_remesa,remesa_id,nacional,oficina_id,solicitud_id,orden_despacho,planilla,
											estado_cliente,fecha_remesa,numero_remesa,cliente_id,origen_id,destino_id,fecha_recogida_ss,hora_recogida_ss,
											propietario_mercancia_id,propietario_mercancia,tipo_identificacion_propietario_mercancia,numero_identificacion_propietario_mercancia,aseguradora_id,numero_poliza,
fecha_vencimiento_poliza,											tipo_identificacion_destinatario_id,remitente,remitente_id,tipo_identificacion_remitente_id,doc_remitente,direccion_remitente,telefono_remitente,
												destinatario_id,destinatario,doc_destinatario,direccion_destinatario,telefono_destinatario,
											descripcion_producto,peso,medida_id,cantidad,valor_facturar,producto_id,naturaleza_id,empaque_id,valor,observaciones,usuario_id,usuario_registra) 
								 VALUES (2,'NN',$remesa_id,1,".$result[$i]['oficina_id'].",".$result[$i]['solicitud_id'].",$orden_despacho,1,'EL','".$result[$i]['fecha_ss']."','".$numero_remesa."','".$result[$i]['cliente_id']."',".$result[$i]['origen_id'].",".$result[$i]['destino_id'].",$fecha_recogida_ss,$hora_recogida_ss,
																																																																						  $propietario_mercancia_id,'$propietario_mercancia',$tipo_identificacion_propietario_mercancia,$numero_identificacion_propietario_mercancia,$aseguradora_id,
'$numero_poliza','$fecha_vencimiento_poliza',".$result[$i]['tipo_identificacion_id'].",'".$result[$i]['remitente']."',".$result[$i]['remitente_id'].",".$result[$i]['tipo_identificacion_remitente_id'].",'".$result[$i]['doc_remitente']."','".$result[$i]['direccion_remitente']."','".$result[$i]['telefono_remitente']."',
										 $destinatario_id,'".$result[$i]['destinatario']."','".$result[$i]['doc_destinatario']."','".$result[$i]['direccion_destinatario']."','".$result[$i]['telefono_destinatario']."',
										 '".$result[$i]['descripcion_producto']."',".$result[$i]['peso'].",".$result[$i]['unidad_peso_id'].",'".$result[$i]['cantidad']."','".$result[$i]['valor']."',3511,1,0,$valor_flete,'".$result[$i]['observaciones']."',".$usuario_id.",'".$usuario_registra."')";
								 //exit($insert);
							
								$this -> query($insert,$Conex,true);
						
								 if($this -> GetNumError() > 0){
								   return false;
								 }     
								 //exit($result[$i]['nombre_producto']."result");
								// 
								$productos  = '';
								$cantidades = '';
								$item_producto = '';
								$item_cantidad = '';
								 if($result[$i]['nombre_producto']!='' && $result[$i]['cantidad_producto']!=''){
									
									 $productos  = $result[$i]['nombre_producto'];
									 $cantidades = $result[$i]['cantidad_producto'];
									 
									 $item_producto = explode('-',$productos);
									 $item_cantidad = explode('-',$cantidades);
									 
									 for($j=0;$j<=count($item_producto);$j++){
										 
										 if($item_producto[$j]!='' && $item_cantidad[$j]!=''){
											 $detalle_remesa_id  = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,false,1);	  
											 
											 $insert1 = "INSERT INTO detalle_remesa (detalle_remesa_id,remesa_id,detalle_ss_id,referencia_producto,descripcion_producto,peso,cantidad,valor,guia_cliente)
														VALUES ($detalle_remesa_id,$remesa_id,'".$result[$i]['detalle_ss_id']."','".$item_producto[$j]."','".$item_producto[$j]."',".$item_cantidad[$j].",".$item_cantidad[$j].",'".$result[$i]['valor']."','".$result[$i]['orden_despacho']."')";
															
											 $this -> query($insert1,$Conex,true);
									
											 $update = "UPDATE detalle_solicitud_servicio SET estado = 'R' WHERE detalle_ss_id = ".$result[$i]['detalle_ss_id'];
							
											 $this -> query($update,$Conex,true);
									
											 if($this -> GetNumError() > 0){
											   exit("error");return false;
											 }       
										 }
										 
									 }
									// exit("porsi acaso2");
								 }else{
									 
									 //exit("porsi acaso2");
									 $detalle_remesa_id  = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,false,1);	  
							
									 $insert1 = "INSERT INTO detalle_remesa (detalle_remesa_id,remesa_id,detalle_ss_id,referencia_producto,descripcion_producto,peso,cantidad,valor)
									 VALUES ($detalle_remesa_id,$remesa_id,'".$result[$i]['detalle_ss_id']."','".$result[$i]['referencia_producto']."','".$result[$i]['descripcion_producto']."',
											 ".$result[$i]['peso'].",".$result[$i]['cantidad'].",'".$result[$i]['valor']."')";
									 $this -> query($insert1,$Conex,true);
							
									 if($this -> GetNumError() > 0){
									   return false;
									 }     
							
									 $update = "UPDATE detalle_solicitud_servicio SET estado = 'R' WHERE detalle_ss_id = ".$result[$i]['detalle_ss_id'];
							
									 $this -> query($update,$Conex,true);
							
									 if($this -> GetNumError() > 0){
									   return false;
									 }     
								 }
			   }
			   
			  
					$remesa_menor=min($array_remesas);	   
					$remesa_mayor=max($array_remesas);
					
				$this -> Commit($Conex);
				return "Remesas Generadas Exitosamente<br> Rango Generado: ".$remesa_menor."-".$remesa_mayor;
					
			}else{
					exit("La soliictud ingresada no se encuentra disponible o ya fue remesada!!");
				}	
		
		 }else{
			  exit('La solicitud ingresada no corresponde al cliente!!!');
					  // exit("La soliictud ingresada no se encuentra disponible o no existe!!");
						 
			}
				 
				 
	 }else{
	$this -> Begin($Conex);
	   $select = "SELECT ss.*, ds.*, 
	   			 (SELECT t.tipo_identificacion_id FROM cliente c, tercero t WHERE c.cliente_id=ss.cliente_id AND t.tercero_id=c.tercero_id)  AS tipo_identificacion_id
	   			  FROM solicitud_servicio ss, detalle_solicitud_servicio ds 
	   			  WHERE ss.cliente_id = $cliente_id AND ss.oficina_id=$oficina_id  AND  ds.solicitud_id=ss.solicitud_id AND ds.estado='D'
	             ORDER BY detalle_ss_id ASC";

	  $result = $this -> DbFetchAll($select,$Conex);
       if(count($result)>0){                     
		   for($i = 0; $i < count($result); $i++){
			 
			 $remesa_id  = $this -> DbgetMaxConsecutive("remesa","remesa_id",$Conex,false,1);	  
	
			$select1 = "SELECT MAX(numero_remesa) AS numero_remesa FROM remesa WHERE oficina_id = $oficina_id";
			$result1 = $this -> DbFetchAll($select1,$Conex,true);	
			$numero_remesa = $result1[0]['numero_remesa'];
			
			if(is_numeric($numero_remesa)){	
				$select1 = "SELECT rango_remesa_fin FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
				$result1 = $this -> DbFetchAll($select1,$Conex,true);
				$rango_remesa_fin = $result1[0]['rango_remesa_fin'];	
				$numero_remesa += 1;		
				if($numero_remesa > $rango_remesa_fin){
				  print 'El numero de Remesa para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!';
				  return false;
				}
				
			}else{	
				$select1 = "SELECT rango_remesa_ini FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
				$result1 = $this -> DbFetchAll($select1,$Conex,true);
				$rango_remesa_ini = $result1[0]['rango_remesa_ini'];		
				if(is_numeric($rango_remesa_ini)){		
				  $numero_remesa = $rango_remesa_ini;
				}else{		
					print 'Debe Definir un rango de Remesas para la oficina!!!';
					return false;		
				  }	
			  }			
			
			 $array_remesas[$i]=$numero_remesa;
			 
			 $zona= $result[$i]['zona']!='' ? "'".$result[$i]['zona']."'" : "NULL";
			 $orden_despacho= $result[$i]['orden_despacho']!='' ? "'".$result[$i]['orden_despacho']."'" : "NULL";
			 
			 $valor_flete= $result[$i]['valor_flete']>0 ? "'".$result[$i]['valor_flete']."'" : "NULL";
			 $valor_seguro= $result[$i]['valor_seguro']>0 ? "'".$result[$i]['valor_seguro']."'" : "NULL";
			 $valor_otros= $result[$i]['valor_otros']>0 ? "'".$result[$i]['valor_otros']."'" : "NULL";
			 $valor_total= $result[$i]['valor_total']>0 ? "'".$result[$i]['valor_total']."'" : "NULL";
			 $cliente_proyecto_id= $result[$i]['cliente_proyecto_id']>0 ? "'".$result[$i]['cliente_proyecto_id']."'" : "NULL";
			 
			 $fecha_recogida_ss = $result[$i]['fecha_recogida_ss']>0 ? "'".$result[$i]['fecha_recogida_ss']."'" : "NULL";
			 $hora_recogida_ss = $result[$i]['hora_recogida_ss']>0 ? "'".$result[$i]['hora_recogida_ss']."'" : "NULL";
			 
			 //Propietario mercancia inicio
				$select_prop = "SELECT tercero_id AS propietario_mercancia_id, 
				CONCAT_WS(' ',(CONCAT_WS('-',numero_identificacion,digito_verificacion)),primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS propietario_mercancia,
				CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) AS propietario_mercancia_txt,    
				(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_propietario_mercancia,
				
				numero_identificacion AS numero_identificacion_propietario_mercancia FROM tercero t WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = $cliente_id)";
				
				$result_prop = $this -> DbFetchAll($select_prop,$Conex,$ErrDb = false);      
			 	
				$propietario_mercancia_id		= $result_prop[0]['propietario_mercancia_id'];
				$propietario_mercancia			= $result_prop[0]['propietario_mercancia'];
				$tipo_identificacion_propietario_mercancia		= $result_prop[0]['tipo_identificacion_propietario_mercancia'];
				$numero_identificacion_propietario_mercancia	= $result_prop[0]['numero_identificacion_propietario_mercancia'];
			 //propietario mercancia fin
			 
			  $destinatario_id=$result[$i]['destinatario_id']>0 ? $result[$i]['destinatario_id'] : 'NULL';
			 
			 $insert = "INSERT INTO remesa (paqueteo,tipo_remesa_id,clase_remesa,remesa_id,nacional,oficina_id,solicitud_id,orden_despacho,planilla,
						estado_cliente,fecha_remesa,numero_remesa,cliente_id,origen_id,destino_id,fecha_recogida_ss,hora_recogida_ss,
						propietario_mercancia_id,propietario_mercancia,tipo_identificacion_propietario_mercancia,numero_identificacion_propietario_mercancia,
						
						tipo_identificacion_destinatario_id,remitente,remitente_id,tipo_identificacion_remitente_id,doc_remitente,direccion_remitente,telefono_remitente,
						destinatario_id,destinatario,doc_destinatario,direccion_destinatario,telefono_destinatario,
						descripcion_producto,peso,medida_id,cantidad,valor,producto_id,naturaleza_id,empaque_id,valor_flete,valor_seguro,valor_otros,valor_total,cliente_proyecto_id,observaciones,unidades_internas,usuario_id,usuario_registra) 
			 VALUES (1,2,'NN',$remesa_id,1,".$result[$i]['oficina_id'].",".$result[$i]['solicitud_id'].",$orden_despacho,1,'EL','".$result[$i]['fecha_ss']."','".$numero_remesa."','".$result[$i]['cliente_id']."',".$result[$i]['origen_id'].",".$result[$i]['destino_id'].",$fecha_recogida_ss,$hora_recogida_ss,
																																																																	  $propietario_mercancia_id,'$propietario_mercancia',$tipo_identificacion_propietario_mercancia,$numero_identificacion_propietario_mercancia,
					 ".$result[$i]['tipo_identificacion_id'].",'".$result[$i]['remitente']."',".$result[$i]['remitente_id'].",".$result[$i]['tipo_identificacion_remitente_id'].",'".$result[$i]['doc_remitente']."','".$result[$i]['direccion_remitente']."','".$result[$i]['telefono_remitente']."',
					 $destinatario_id,'".$result[$i]['destinatario']."','".$result[$i]['doc_destinatario']."','".$result[$i]['direccion_destinatario']."','".$result[$i]['telefono_destinatario']."',
					 '".$result[$i]['descripcion_producto']."',".$result[$i]['peso'].",".$result[$i]['unidad_peso_id'].",'".$result[$i]['cantidad']."','".$result[$i]['valor']."',3511,1,0,$valor_flete,$valor_seguro,$valor_otros,$valor_total,$cliente_proyecto_id,'".$result[$i]['observaciones']."','".$result[$i]['unidades_internas']."',".$usuario_id.",'".$usuario_registra."')";
			 //exit($insert);
	
			$this -> query($insert,$Conex,true);
	
			 if($this -> GetNumError() > 0){
			   return false;
			 }     
			 $detalle_remesa_id  = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,false,1);	  
	
			 $insert1 = "INSERT INTO detalle_remesa (detalle_remesa_id,remesa_id,detalle_ss_id,referencia_producto,descripcion_producto,peso,cantidad,valor)
			 VALUES ($detalle_remesa_id,$remesa_id,'".$result[$i]['detalle_ss_id']."','".$result[$i]['referencia_producto']."','".$result[$i]['descripcion_producto']."',
					 ".$result[$i]['peso'].",".$result[$i]['cantidad'].",'".$result[$i]['valor']."')";
			 $this -> query($insert1,$Conex,true);
	
			 if($this -> GetNumError() > 0){
			   return false;
			 }     
	
			 $update = "UPDATE detalle_solicitud_servicio SET estado = 'R' WHERE detalle_ss_id = ".$result[$i]['detalle_ss_id'];
	
			 $this -> query($update,$Conex,true);
	
			 if($this -> GetNumError() > 0){
			   return false;
			 }     
		   
		   }
			$remesa_menor=min($array_remesas);	   
			$remesa_mayor=max($array_remesas);
			$this -> Commit($Conex);
			return "Remesas Generadas Exitosamente<br> Rango Generado: ".$remesa_menor."-".$remesa_mayor;
	   }else{
		   return "No existen Solicitudes pendientes para generar Remesas de esta oficina y cliente";
	   }
	 }
  }

   
}



?>