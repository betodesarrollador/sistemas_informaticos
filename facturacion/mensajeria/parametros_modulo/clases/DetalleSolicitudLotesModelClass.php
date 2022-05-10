<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleSolicitudLotesModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){
	  
    $relacion_archivo_det_solicitud_id = $this -> DbgetMaxConsecutive("relacion_archivo_detalle_solicitud","relacion_archivo_det_solicitud_id",$Conex,false,1);
	$this -> assignValRequest('relacion_archivo_det_solicitud_id',$relacion_archivo_det_solicitud_id);
    $this -> DbInsertTable("relacion_archivo_detalle_solicitud",$Campos,$Conex,true,false);
	
	return $relacion_archivo_det_solicitud_id;
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("relacion_archivo_detalle_solicitud",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
    $this -> DbDeleteTable("relacion_archivo_detalle_solicitud",$Campos,$Conex,true,false);
  }
  
  public function getDetalleSolicitudLotes($Conex){
  
	$campo_archivo_solicitud_id = $this -> requestDataForQuery('campo_archivo_solicitud_id','integer');
	
	if(is_numeric($campo_archivo_solicitud_id)){
	
	  $select  = "SELECT 
	  				 *
	  				FROM relacion_archivo_detalle_solicitud  
	  				WHERE campo_archivo_solicitud_id = $campo_archivo_solicitud_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  }
  
  public function getAutoSugerente($Conex){
  
	$campo_archivo_solicitud_id = $this -> requestDataForQuery('campo_archivo_solicitud_id','integer');
	
	if(is_numeric($campo_archivo_solicitud_id)){
	
	  $select  = "SELECT 
	  				 cd.lista_autosugerente
	  				FROM  campo_archivo_detalle_solicitud ca, campo_detalle_solicitud cd
	  				WHERE ca.campo_solicitud_id=cd.campo_solicitud_id
					AND ca.campo_archivo_solicitud_id=$campo_archivo_solicitud_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = 'NULL';
	  }
	
	return $result[0]['lista_autosugerente'];
  }
}
?>