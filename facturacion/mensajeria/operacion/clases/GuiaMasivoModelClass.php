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
  public function getTipoEnvio1($destino_id,$Conex){ 
     $select = "SELECT tipo_envio_id FROM ubicacion WHERE ubicacion_id = $destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 if ($result[0]['tipo_envio_id']>0)
	 {
		 return $result[0]['tipo_envio_id'];
	 }else
	 {
		 $select="SELECT nombre FROM ubicacion WHERE ubicacion_id = $destino_id";
		  $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
		  exit ("La cuidad ".$result[0]['nombre']." no tiene configurado un tipo de envio!!");
	 }
	 
	 return $result[0]['tipo_envio_id'];    
  }  
  public function getTipoEnvioMetro($origen_id,$destino_id,$Conex){ 
     $select = "SELECT ubicacion_id FROM ubicacion WHERE ubicacion_id = $destino_id AND metropolitana_id=$origen_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 if($result[0]['ubicacion_id']>0){
		 return true;    
	 }else{
		 return false;
	 }
  }  

  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'  
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }
  
  public function saveDetalleGuiaMasivo($oficina_id,$cliente_id,$camposArchivo,$Conex){
  	 $array_guias=array();
	 $insert1='';
	 $cadena='';
	 $cont=0;
     $this -> Begin($Conex);

	   $select = "SELECT ss.*, ds.*, 
	   			 (SELECT t.tipo_identificacion_id FROM cliente c, tercero t WHERE c.cliente_id=ss.cliente_id AND t.tercero_id=c.tercero_id)  AS tipo_identificacion_id
	   			  FROM solicitud_servicio_guia ss, detalle_solicitud_servicio_guia ds 
	   			  WHERE ss.cliente_id = $cliente_id AND ss.oficina_id=$oficina_id  AND  ds.solicitud_id=ss.solicitud_id AND ds.estado='D'
	             ORDER BY detalle_ss_id ASC LIMIT 0,2000";
     //exit($select);
	  $result = $this -> DbFetchAll($select,$Conex,true);
       if(count($result)>0){      
	   
		   $select2 = "SELECT rango_guia_ini,rango_guia_fin FROM rango_guia WHERE oficina_id = $oficina_id AND estado = 'A'";
		   $result2 = $this -> DbFetchAll($select2,$Conex,true);
		   $rango_guia_fin = $result2[0]['rango_guia_fin'];	
		   $rango_guia_ini = $result2[0]['rango_guia_ini'];	

  		   $guia_id  = $this -> DbgetMaxConsecutive("guia","guia_id",$Conex,false,1);	  

		   $select1 = "SELECT MAX(numero_guia) AS numero_guia FROM guia WHERE oficina_id = $oficina_id AND manual=0";
		   $result1 = $this -> DbFetchAll($select1,$Conex,true);	
		   $numero_guia = $result1[0]['numero_guia'];
		   
		   	$peso   = $_REQUEST['peso'];	

			if($peso>5000){
				exit ('El Peso de la Guia debe ser Inferior a 5.000 Gramos');	
			}


		   for($i = 0; $i < count($result); $i++){
			 if($origen_id==$destino_id){
				 $nacional= 0;
				 $clase_servicio_mensajeria_id=  2 ;
			 }else{
				 $nacional= 1;
				 $clase_servicio_mensajeria_id=  1;
				 
			 }
	
			
			if(is_numeric($numero_guia)){	
				$numero_guia += 1;		
				
				if($numero_guia > $rango_guia_fin){
				  exit('El numero de Guia para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!');
				  return false;
				}

				if($numero_guia < $rango_guia_ini || $numero_guia > $rango_guia_fin){//aca
				  $numero_guia = $rango_guia_ini;
				}

			}else{	
				if(is_numeric($rango_guia_ini)){		
				  $numero_guia = $rango_guia_ini;
				}else{		
					exit('Debe Definir un rango de Guias para la oficina!!!');
					return false;		
				  }	
			}			
			
			 $array_guias[$i]=$numero_guia;
			 
			 $zona= $result[$i]['zona']!='' ? "'".$result[$i]['zona']."'" : "NULL";
			 $orden_despacho= $result[$i]['orden_despacho']!='' ? "'".$result[$i]['orden_despacho']."'" : "NULL";

			$origen_id = $result[$i]['origen_id'];
			$destino_id = $result[$i]['destino_id'];
			if($origen_id==$destino_id){ 
				$tipo_envio_id=2;
			}else{
				$tipo_envio_id=$this -> getTipoEnvio1($destino_id,$Conex);
			}
		
			if($this -> getTipoEnvioMetro($origen_id,$destino_id,$Conex) ) $tipo_envio_id=2;	

			 $insert = "INSERT INTO guia (guia_id,nacional,oficina_id,tipo_servicio_mensajeria_id,tipo_envio_id,solicitud_id,orden_despacho,forma_pago_mensajeria_id,planilla,
						estado_mensajeria_id,estado_cliente,fecha_guia,numero_guia,cliente_id,origen_id,destino_id,
						tipo_identificacion_id,remitente,remitente_id,doc_remitente,direccion_remitente,telefono_remitente,
						destinatario,doc_destinatario,direccion_destinatario,telefono_destinatario,
						descripcion_producto,peso,medida_id,cantidad,valor,zona) 	 VALUES ";

				 $cont++;
				 $insert1.="($guia_id,$nacional,".$result[$i]['oficina_id'].",".$result[$i]['tipo_servicio_mensajeria_id'].",$tipo_envio_id,".$result[$i]['solicitud_id'].",$orden_despacho,2,1,
						 1,'EL','".$result[$i]['fecha_ss']."','".$numero_guia."','".$result[$i]['cliente_id']."',".$result[$i]['origen_id'].",".$result[$i]['destino_id'].",
						 ".$result[$i]['tipo_identificacion_id'].",'".$result[$i]['remitente']."',".$result[$i]['remitente_id'].",'".$result[$i]['doc_remitente']."','".$result[$i]['direccion_remitente']."','".$result[$i]['telefono_remitente']."',
						 '".$result[$i]['destinatario']."','".$result[$i]['doc_destinatario']."','".$result[$i]['direccion_destinatario']."','".$result[$i]['telefono_destinatario']."',
						 '".$result[$i]['referencia_producto']."',".$result[$i]['peso'].",".$result[$i]['unidad_peso_id'].",'".$result[$i]['cantidad']."','".$result[$i]['valor']."',$zona),";
				 $cadena.= $result[$i]['detalle_ss_id'].',';
 				 $guia_id += 1;		

			 if($i == (count($result)-1) || $cont==100){
				 
				$insert = $insert.''.substr($insert1,0,-1).';';
				$this -> query($insert,$Conex,true);
				
				 $update = "UPDATE detalle_solicitud_servicio_guia SET estado = 'R' WHERE detalle_ss_id IN (".substr($cadena,0,-1).")";
				 $this -> query($update,$Conex,true);
				 $insert1='';
				 $cadena='';
			 }
		
		   
		   } //fin for
			$guia_menor=min($array_guias);	   
			$guia_mayor=max($array_guias);
			$this -> Commit($Conex);
			return "Guias Generadas Exitosamente<br> Rango Generado: ".$guia_menor."-".$guia_mayor;
	   }else{
		   return "No existen Solicitudes pendientes para generar Guias de esta oficina y cliente";
	   }
  }
  
}
 /*$detalle_guia_id  = $this -> DbgetMaxConsecutive("detalle_guia","detalle_guia_id",$Conex,false,1);	  

 $insert1 = "INSERT INTO detalle_guia (detalle_guia_id,guia_id,detalle_ss_id,referencia_producto,descripcion_producto,peso,cantidad,valor)
 VALUES ($detalle_guia_id,$guia_id,'".$result[$i]['detalle_ss_id']."','".$result[$i]['referencia_producto']."','".$result[$i]['referencia_producto']."',
		 ".$result[$i]['peso'].",".$result[$i]['cantidad'].",'".$result[$i]['valor']."')";
 $this -> query($insert1,$Conex,true);

 if($this -> GetNumError() > 0){
   return false;
 }    */

?>