<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleOrdenCompraModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){
	  
    $detalle_ordenconexo_id = $this -> DbgetMaxConsecutive("detalle_ordenconexo","detalle_ordenconexo_id",$Conex,false,1);
	$this -> assignValRequest('detalle_ordenconexo_id',$detalle_ordenconexo_id);
    $this -> DbInsertTable("detalle_ordenconexo",$Campos,$Conex,true,false);
	
	return $detalle_ordenconexo_id;
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("detalle_ordenconexo",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
    $this -> DbDeleteTable("detalle_ordenconexo",$Campos,$Conex,true,false);
  }
  
  public function getDetalleOrdenCompra($Conex){
  
	$ordencompra_id = $this -> requestDataForQuery('ordencompra_id','integer');
	
	if(is_numeric($ordencompra_id)){
	
	  $select  = "SELECT 
	  				d.*,
						(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id)
					AS remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.origen_id) 
					AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.destino_id) 
					AS destino  
	  				FROM detalle_ordenconexo d 
	  				WHERE ordencompra_id = $ordencompra_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  }
}
?>