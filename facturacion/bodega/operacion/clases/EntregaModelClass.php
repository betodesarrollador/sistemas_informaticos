<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EntregaModel extends Db{

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

  public function getQueryEntregaGrid(){	//MODIFICAR FECHA INICIAL Y DIAS
				
	$Query = "SELECT a.despacho_id,
	IF((a.estado='D'),CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',a.despacho_id,')\">','<input type=\"button\" class=\"btn btn-primary\" value=\"Entregar\">','</a>' ),'')AS despacho_id1,
    a.turno,
	a.fecha,
    CASE a.estado WHEN 'A' THEN CONCAT('','<div class=\"alistamiento\">','ALISTAMIENTO','</div>') WHEN 'D' THEN CONCAT('','<div class=\"despachado\">','DESPACHADO','</div>') WHEN 'E' THEN CONCAT('','<div class=\"enturnado\">','ENTURNADO','</div>') WHEN 'AN' THEN CONCAT('','<div class=\"anulado\">','ANULADO','</div>') END as estado,
    (SELECT m.nombre FROM wms_muelle m WHERE m.muelle_id=a.muelle_id)AS muelle,
    a.fecha_registro,
    a.usuario_id,
    a.fecha_actualiza,
	a.usuario_actualiza_id

	 FROM wms_despacho a WHERE a.turno IS NOT NULL AND a.muelle_id IS NOT NULL AND a.estado = 'D' ORDER BY a.turno DESC"; 
    
     return $Query;
   }

   public function Save($despacho_id,$despacho_id1,$fecha_entrega,$observacion_entrega,$Campos,$Conex){	
	
	$usuario_entrega = $_REQUEST['usuario_id'];
   
	if($despacho_id > 0){

		$update="UPDATE wms_despacho SET estado = 'EN',fecha_entrega = '$fecha_entrega',usuario_entrega = $usuario_entrega,observacion_entrega = '$observacion_entrega' WHERE despacho_id = $despacho_id";
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