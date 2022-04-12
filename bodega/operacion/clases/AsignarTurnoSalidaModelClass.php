<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AsignarTurnoSalidaModel extends Db{

  private $Permisos;
  private $usuario_id;

   
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }

   public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
//// GRID ////

  public function getQueryAsignarTurnoSalidaGrid($Conex){	

	$turno = $this -> DbgetMaxConsecutive("wms_alistamiento_salida","turno",$Conex,false,1);
	
	if($turno == '' || $turno == null || $turno == 'NULL'){
		//exit("entra".$turno);
        $turno = 0;
	}
				
	$Query = "(SELECT a.alistamiento_salida_id,
	IF((a.estado IN('A','E') AND a.turno IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',a.alistamiento_salida_id,',',$turno,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Asignar Turno\">','</a>' ),'')AS alistamiento_salida_id1,
	IF((a.estado IN('A','E') AND a.muelle_id IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc1(',a.alistamiento_salida_id,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Asignar Muelle\">','</a>' ),'')AS alistamiento_salida_id2,
    a.fecha,
    CASE a.estado WHEN 'A' THEN CONCAT('','<div class=\"alistamiento\">','ALISTAMIENTO','</div>') WHEN 'D' THEN CONCAT('','<div class=\"despachado\">','DESPACHADO','</div>') WHEN 'AN' THEN CONCAT('','<div class=\"anulado\">','ANULADO','</div>') WHEN 'E' THEN CONCAT('','<div class=\"enturnado\">','ENTURNADO','</div>') END as estado,
    a.turno,
    (SELECT m.nombre FROM wms_muelle m WHERE m.muelle_id=a.muelle_id)AS muelle,
    a.fecha_registro,
    a.usuario_id,
    a.fecha_actualiza,
	a.usuario_actualiza_id,
	a.observacion,
	a.observacion_muelle

	 FROM wms_alistamiento_salida a WHERE a.turno IS NULL AND a.muelle_id IS NULL AND a.estado IN('A','E')) 
	 
	UNION ALL

	(SELECT a.alistamiento_salida_id,
	IF((a.estado IN('A','E') AND a.turno IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',a.alistamiento_salida_id,',',$turno,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Asignar Turno\">','</a>' ),'')AS alistamiento_salida_id1,
	IF((a.estado IN('A','E') AND a.muelle_id IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc1(',a.alistamiento_salida_id,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Asignar Muelle\">','</a>' ),'')AS alistamiento_salida_id2,
    a.fecha,
    CASE a.estado WHEN 'A' THEN CONCAT('','<div class=\"alistamiento\">','ALISTAMIENTO','</div>') WHEN 'D' THEN CONCAT('','<div class=\"despachado\">','DESPACHADO','</div>') WHEN 'AN' THEN CONCAT('','<div class=\"anulado\">','ANULADO','</div>') WHEN 'E' THEN CONCAT('','<div class=\"enturnado\">','ENTURNADO','</div>') END as estado,
    a.turno,
    (SELECT m.nombre FROM wms_muelle m WHERE m.muelle_id=a.muelle_id)AS muelle,
    a.fecha_registro,
    a.usuario_id,
    a.fecha_actualiza,
	a.usuario_actualiza_id,
	a.observacion,
	a.observacion_muelle

     FROM wms_alistamiento_salida a WHERE a.turno IS NULL AND a.muelle_id IS NOT NULL AND a.estado IN('A','E')) 
     
     UNION ALL

	 (SELECT a.alistamiento_salida_id,
	 IF((a.estado IN('A','E') AND a.turno IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',a.alistamiento_salida_id,',',$turno,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Asignar Turno\">','</a>' ),'')AS alistamiento_salida_id1,
	 IF((a.estado IN('A','E') AND a.muelle_id IS NULL),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc1(',a.alistamiento_salida_id,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Asignar Muelle\">','</a>' ),'')AS alistamiento_salida_id2,
    a.fecha,
    CASE a.estado WHEN 'A' THEN CONCAT('','<div class=\"alistamiento\">','ALISTAMIENTO','</div>') WHEN 'D' THEN CONCAT('','<div class=\"despachado\">','DESPACHADO','</div>') WHEN 'AN' THEN CONCAT('','<div class=\"anulado\">','ANULADO','</div>') WHEN 'E' THEN CONCAT('','<div class=\"enturnado\">','ENTURNADO','</div>') END as estado,
    a.turno,
    (SELECT m.nombre FROM wms_muelle m WHERE m.muelle_id=a.muelle_id)AS muelle,
    a.fecha_registro,
    a.usuario_id,
    a.fecha_actualiza,
	a.usuario_actualiza_id,
	a.observacion,
	a.observacion_muelle

     FROM wms_alistamiento_salida a WHERE a.muelle_id IS NULL AND a.turno IS NOT NULL AND a.estado IN('A','E'))
     "; 
     
     return $Query;
   }

   public function Save($alistamiento_salida_id,$alistamiento_salida_id1,$turno,$observacion,$observacion_muelle,$muelle_id,$Campos,$Conex){	
	
	$fecha_actualiza = date('Y-m-d H:i:s');
	$usuario_id = $_REQUEST['usuario_id'];
   
	if(!$muelle_id > 0){

		$update="UPDATE wms_alistamiento_salida SET turno = $turno, estado = 'E', fecha_actualiza = '$fecha_actualiza',usuario_actualiza_id = $usuario_id ,observacion = '$observacion' WHERE alistamiento_salida_id = $alistamiento_salida_id";
		$this -> query($update,$Conex,true); 

	}

	if(!$turno > 0){
		$update="UPDATE wms_alistamiento_salida SET muelle_id = $muelle_id, estado = 'E', fecha_actualiza = '$fecha_actualiza',usuario_actualiza_id = $usuario_id , observacion = '$observacion_muelle' WHERE alistamiento_salida_id = $alistamiento_salida_id1";
		$this -> query($update,$Conex,true); 
	} 
    
  }

   // LISTA MENU //

	  
	  public function getMuelle($Conex){

			$select = "SELECT  muelle_id AS value, nombre AS text FROM wms_muelle";

			$result = $this -> DbfetchAll($select,$Conex,true);

			return $result;

  	}


   
}



?>