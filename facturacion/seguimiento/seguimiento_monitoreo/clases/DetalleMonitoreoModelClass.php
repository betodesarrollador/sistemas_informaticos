<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleMonitoreoModel extends Db{

  private $Permisos;
  
  public function getDetallesSeguimiento($Conex){
  
    $seguimiento_id = $_REQUEST['seguimiento_id'];
	
	if(is_numeric($seguimiento_id)){
	
	  $select  = "SELECT d.*,
	  			  (SELECT nombre FROM ubicacion WHERE ubicacion_id = d.ubicacion_id) AS ubicacion,
				  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=d.novedad_id) AS novedad,
				  (SELECT puesto_control FROM puesto_control WHERE ubicacion_id = d.ubicacion_id) AS puesto_control,
				  (SELECT CONCAT_WS('<br>',responsable_puesto_control,direccion_puesto_control,telefono_puesto_control,movil_puesto_control) FROM puesto_control WHERE ubicacion_id = d.ubicacion_id) AS detalle_puesto_control
				  FROM detalle_seguimiento d 
				  WHERE seguimiento_id = $seguimiento_id 
				  ORDER BY d.orden_det_seg";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
  
  public function getFechaHoraSalida($Conex){
  
    $seguimiento_id = $_REQUEST['seguimiento_id'];
	
	if(is_numeric($seguimiento_id)){
	
	  $select  = "SELECT CONCAT_WS(' ',fecha_transito,hora_transito) AS salida
	  FROM seguimiento
	  WHERE seguimiento_id = $seguimiento_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  }
    
  public function Save($Campos,$Conex){
  
    $seguimiento_id = $_REQUEST['seguimiento_id'];
    $detalle_seg_id = $_REQUEST['detalle_seg_id'];
    $orden_det_seg  = $_REQUEST['orden_det_seg'];
    $ubicacion_id   = $_REQUEST['ubicacion_id'];
    $paso_estimado  = $_REQUEST['paso_estimado'];
    $fecha_reporte  = $_REQUEST['fecha_reporte'];
    $hora_reporte   = $_REQUEST['hora_reporte'];
    $novedad_id     = $_REQUEST['novedad_id'];
    $tiempo_novedad = $_REQUEST['tiempo_novedad'];
    $retraso        = $_REQUEST['retraso'];
    $obser_deta     = $_REQUEST['obser_deta'];
	
    $detalle_seg_id = $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex);	
	$detalle_seg_id = ($detalle_seg_id + 1);

    $insert = "INSERT INTO detalle_seguimiento 
					(detalle_seg_id,seguimiento_id,orden_det_seg,ubicacion_id,tiempo_tramo,paso_estimado,distancia_tramo,
					 recorrido_acumulado,fecha_reporte,hora_reporte,novedad_id,tiempo_novedad,retraso,obser_deta) 
	           VALUES ($detalle_seg_id,$seguimiento_id,$orden_det_seg,$ubicacion_id,0,'$paso_estimado',0,
					 0,'$fecha_reporte','$hora_reporte',$novedad_id,$tiempo_novedad,$retraso,
					 ".(($obser_deta != 'NULL')? "obser_deta='$obser_deta'":"obser_deta=NULL" ).")";
	
    $this -> query($insert,$Conex);
	
	return $detalle_seg_id;

  }

  public function Update($Campos,$Conex){
  
    $seguimiento_id = $_REQUEST['seguimiento_id'];
    $detalle_seg_id = $_REQUEST['detalle_seg_id'];
    $orden_det_seg  = $_REQUEST['orden_det_seg'];
    $ubicacion_id   = $_REQUEST['ubicacion_id'];
    //$paso_estimado  = $_REQUEST['paso_estimado'];
    $fecha_reporte  = $_REQUEST['fecha_reporte'];
    $hora_reporte   = $_REQUEST['hora_reporte'];
    $novedad_id     = $_REQUEST['novedad_id'];
    $tiempo_novedad = $_REQUEST['tiempo_novedad'];
    $retraso        = $_REQUEST['retraso'];
    $obser_deta     = $_REQUEST['obser_deta'];
	
    $insert = "UPDATE detalle_seguimiento 
				SET orden_det_seg=$orden_det_seg,
					ubicacion_id=$ubicacion_id, fecha_reporte='$fecha_reporte', hora_reporte='$hora_reporte',
					novedad_id=$novedad_id, tiempo_novedad=$tiempo_novedad, retraso=$retraso, 
					".(($obser_deta != 'NULL')? "obser_deta='$obser_deta',":"obser_deta=NULL," )."
					fecha_hora_registro=NOW()
				WHERE detalle_seg_id = $detalle_seg_id";
	
    $this -> query($insert,$Conex);

  }

  public function Delete($Campos,$Conex){

    $detalle_seg_id = $_REQUEST['detalle_seg_id'];
	
    $insert = "DELETE FROM detalle_seguimiento WHERE detalle_seg_id = $detalle_seg_id";
	
    $this -> query($insert,$Conex);	

  }

//// GRID ////
  public function getQueryDetalleMonitoreoGrid(){
	   	   
     $Query = "SELECT pc.puesto_control_id,pc.puesto_control,u.nombre AS ubicacion,
	 			pc.responsable_puesto_control, pc.telefono_puesto_control, 
				pc.movil_puesto_control,pc.direccion_puesto_control 
	 			
				FROM puesto_control pc, ubicacion u
				WHERE pc.ubicacion_id=u.ubicacion_id";
   
     return $Query;
   }
   
}



?>