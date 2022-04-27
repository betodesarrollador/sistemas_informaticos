<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DespachoModel extends Db{

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

  public function getQueryDespachoGrid(){	//MODIFICAR FECHA INICIAL Y DIAS
				
	$Query = "SELECT a.alistamiento_salida_id,
	IF((a.estado='E' AND a.alistamiento_salida_id NOT IN(SELECT d.alistamiento_salida_id FROM wms_despacho d WHERE d.alistamiento_salida_id=a.alistamiento_salida_id AND d.estado NOT IN('AN','D')) AND a.turno IS NOT NULL AND a.muelle_id IS NOT NULL),
	CONCAT('','<a href=\"javascript:popPup(\'sistemas_informaticos/bodega/operacion/clases/DespachoAlistamientoClass.php?alistamiento_salida_id=',a.alistamiento_salida_id,'\',\'1000\',\'1150\');\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Despachar\">','</a>' ),
	CONCAT('','<a href=\"javascript:popPup(\'sistemas_informaticos/bodega/operacion/clases/DespachoAlistamientoClass.php?alistamiento_salida_id=',a.alistamiento_salida_id,'\',\'1000\',\'1150\');\">','<input type=\"button\" class=\"btn btn-success\" value=\"Terminar Despacho\">','</a>'))AS alistamiento_salida_id1,
    a.turno,
	a.fecha,
    CASE a.estado WHEN 'A' THEN CONCAT('','<div class=\"alistamiento\">','ALISTAMIENTO','</div>') WHEN 'D' THEN CONCAT('','<div class=\"despachado\">','DESPACHADO','</div>') WHEN 'E' THEN CONCAT('','<div class=\"enturnado\">','ENTURNADO','</div>') WHEN 'AN' THEN CONCAT('','<div class=\"anulado\">','ANULADO','</div>') END as estado,
    (SELECT m.nombre FROM wms_muelle m WHERE m.muelle_id=a.muelle_id)AS muelle,
    a.fecha_registro,
    a.usuario_id,
    a.fecha_actualiza,
	a.usuario_actualiza_id,
	a.observacion,
	a.observacion_muelle

	 FROM wms_alistamiento_salida a WHERE a.turno IS NOT NULL AND a.muelle_id IS NOT NULL AND a.estado = 'E' ORDER BY a.turno DESC"; 
     
     return $Query;
   }

   public function Save($alistamiento_salida_id,$alistamiento_salida_id1,$turno,$observacion,$observacion_muelle,$muelle_id,$Campos,$Conex){	
	
	$fecha_actualiza = date('Y-m-d H:i:s');
	$usuario_id = $_REQUEST['usuario_id'];
   
	if(!$muelle_id > 0){
		$update="UPDATE wms_alistamiento_salida SET turno = $turno, fecha_actualiza = '$fecha_actualiza',usuario_actualiza_id = $usuario_id ,observacion = '$observacion' WHERE alistamiento_salida_id = $alistamiento_salida_id";
		$this -> query($update,$Conex,true); 	
	}

	if(!$turno > 0){
		$update="UPDATE wms_alistamiento_salida SET muelle_id = $muelle_id, fecha_actualiza = '$fecha_actualiza',usuario_actualiza_id = $usuario_id , observacion = '$observacion_muelle' WHERE alistamiento_salida_id = $alistamiento_salida_id1";
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