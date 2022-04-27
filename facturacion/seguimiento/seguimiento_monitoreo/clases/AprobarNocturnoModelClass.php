<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AprobarNocturnoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
  public function Update($usuario_id,$Campos,$Conex){
	$this -> Begin($Conex);
	
	$trafico_id 				= $this -> requestDataForQuery('trafico_id','integer');	
	$trafico_nocturno_id		= $this -> requestDataForQuery('trafico_nocturno_id','integer');
	$estado						= $this -> requestDataForQuery('estado','alphanum');
	$estado						= $this -> requestDataForQuery('estado','alphanum');
	$autoriza_nocturno			= $this -> requestDataForQuery('autoriza_nocturno','alphanum');
	$hora						= explode(':',$_REQUEST['hora_inicial_salida']);
	$fecha						= explode('-',$_REQUEST['fecha_inicial_salida']);
	$fecha_actual				= date('Y-m-d H:m');
	
	if($estado=="'N'" && $autoriza_nocturno=="'S'" ){
		
		$actual=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
		$salida=mktime($hora[0],$hora[1],00,$fecha[1],$fecha[2],$fecha[0]);
		$estado_nuevo=$salida>$actual ? 'R' : 'T';
		$update = "UPDATE trafico SET  	estado='$estado_nuevo'
					WHERE trafico_id=$trafico_id"; 
		$this -> query($update,$Conex);
		
		if($this -> GetNumError() > 0){
		  return false;
		}else{
			$update = "UPDATE trafico_nocturno  SET  	estado='AN',
														fecha_aprobacion='$fecha_actual',
														usuario_id=$usuario_id
						WHERE trafico_nocturno_id=$trafico_nocturno_id"; 
	
			$this -> query($update,$Conex);
			
			if($this -> GetNumError() > 0){
				return false;
			}
		}	
		
	}


  $this -> Commit($Conex);	 

  }


  
  public function getDataMap($Conex){
  
	$trafico_id = $_REQUEST['trafico_id'];
	
	$select = "SELECT u.x AS lat, u.y AS lon, u.nombre AS nom 
				FROM ubicacion u, detalle_ruta dr, trafico t
				WHERE t.trafico_id=$trafico_id AND dr.ruta_id=t.ruta_id
				AND u.ubicacion_id=dr.ubicacion_id
				AND u.x IS NOT NULL
				AND u.y IS NOT NULL
				ORDER BY dr.orden_det_ruta";
			
	return $this -> DbFetchAll($select,$Conex,$ErrDb = false);  
	  
  }

  public function getEstado($Conex){
  
	$trafico_id = $_REQUEST['trafico_id'];
	
	$select = "SELECT estado 
				FROM trafico
				WHERE trafico_id=$trafico_id ";
			
	$result = $this -> DbFetchAll($select,$Conex); 
	$estado = $result[0]['estado'];
	
	return $estado;	  
	  
  }



//LISTA MENU
  public function GetEstadoSeg($Conex){
	$opciones = array ( 0 => array ( 'value' => 'P', 'text' => 'PENDIENTE RUTA' ), 1 => array ( 'value' => 'R', 'text' => 'CON RUTA' ), 2 => array ( 'value' => 'T', 'text' => 'TRANSITO' ), 3 => array ( 'value' => 'F', 'text' => 'FINALIZADO' ), 4 => array ( 'value' => 'N', 'text' => 'APROBAR NOCTURNO' ) );
	return  $opciones;
  }
  
  public function GetNocturno($Conex){
	$opciones = array ( 0 => array ( 'value' => '0', 'text' => 'NO' ), 1 => array ( 'value' => '1', 'text' => 'SI' ) );
	return  $opciones;
  }

  public function GetAprobar($Conex){
	$opciones = array ( 0 => array ( 'value' => 'N', 'text' => 'NO' ), 1 => array ( 'value' => 'S', 'text' => 'SI' ) );
	return  $opciones;
  }

 

//BUSQUEDA
  public function selectAprobarNocturno($trafico_nocturno_id,$Conex){
    
   $select = "SELECT 
   				t.trafico_id,
				tn.trafico_nocturno_id,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,
				IF(t.seguimiento_id>0,(SELECT o.nombre FROM seguimiento s, oficina o WHERE s.seguimiento_id=t.seguimiento_id AND o.oficina_id=s.oficina_id),
				IF(t.despachos_urbanos_id>0,(SELECT o.nombre FROM  despachos_urbanos s, oficina o WHERE s.despachos_urbanos_id=t.despachos_urbanos_id AND o.oficina_id=s.oficina_id),
				(SELECT o.nombre FROM manifiesto s, oficina o WHERE s.manifiesto_id=t.manifiesto_id AND o.oficina_id=s.oficina_id))) AS agencia,
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT placa FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS placa,
				IF(t.seguimiento_id>0,(SELECT marca FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT marca FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT marca FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS marca,
				IF(t.seguimiento_id>0,(SELECT categoria_licencia_conductor FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT categoria_licencia_conductor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT categoria_licencia_conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS categoria,
				IF(t.seguimiento_id>0,(SELECT v.link_monitoreo_satelital FROM seguimiento s, vehiculo v WHERE s.seguimiento_id=t.seguimiento_id AND v.placa_id=s.placa_id ),
				IF(t.despachos_urbanos_id>0,(SELECT v.link_monitoreo_satelital FROM  despachos_urbanos d, vehiculo v WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND v.placa_id=d.placa_id),
				(SELECT v.link_monitoreo_satelital FROM manifiesto m, vehiculo v  WHERE m.manifiesto_id=t.manifiesto_id   AND v.placa_id=m.placa_id ))) AS link_gps,
				IF(t.seguimiento_id>0,(SELECT v.usuario FROM seguimiento s, vehiculo v WHERE s.seguimiento_id=t.seguimiento_id AND v.placa_id=s.placa_id ),
				IF(t.despachos_urbanos_id>0,(SELECT v.usuario FROM  despachos_urbanos d, vehiculo v WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND v.placa_id=d.placa_id),
				(SELECT v.usuario FROM manifiesto m, vehiculo v  WHERE m.manifiesto_id=t.manifiesto_id   AND v.placa_id=m.placa_id ))) AS usuario_gps,
				IF(t.seguimiento_id>0,(SELECT v.password FROM seguimiento s, vehiculo v WHERE s.seguimiento_id=t.seguimiento_id AND v.placa_id=s.placa_id ),
				IF(t.despachos_urbanos_id>0,(SELECT v.password FROM  despachos_urbanos d, vehiculo v WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND v.placa_id=d.placa_id),
				(SELECT v.password FROM manifiesto m, vehiculo v  WHERE m.manifiesto_id=t.manifiesto_id   AND v.placa_id=m.placa_id ))) AS clave_gps,
				IF(t.seguimiento_id>0,(SELECT categoria_licencia_conductor FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT categoria_licencia_conductor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT categoria_licencia_conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS categoria,
				IF(t.seguimiento_id>0,(SELECT color FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT color FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT color FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS color,
				IF(t.seguimiento_id>0,(SELECT nombre FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT conductor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS conduct,
				IF(t.seguimiento_id>0,(SELECT movil_conductor FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT te.movil FROM  despachos_urbanos d, conductor c, tercero te WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND c.conductor_id=d.conductor_id AND te.tercero_id=c.tercero_id),
				(SELECT te.movil FROM manifiesto m, conductor c, tercero te  WHERE m.manifiesto_id=t.manifiesto_id AND c.conductor_id=m.conductor_id AND te.tercero_id=c.tercero_id))) AS celular,
				IF(t.seguimiento_id>0,(SELECT fecha FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT fecha_du FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT fecha_mc FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS fecha,
				IF(t.seguimiento_id>0,(SELECT CONCAT('OS: ',seguimiento_id) AS numero FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT CONCAT('DU: ',despacho) AS numero FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT CONCAT('MC: ',manifiesto) AS numero  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS numero,
				t.estado AS estado,
				(SELECT CONCAT_WS(' ',ruta,pasador_vial) AS ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.t_nocturno,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,
				t.escolta_recibe,
				t.escolta_entrega
   				FROM  trafico t, trafico_nocturno tn
				WHERE tn.trafico_nocturno_id=$trafico_nocturno_id AND  t.trafico_id=tn.trafico_id ";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
  
  
   
}
?>