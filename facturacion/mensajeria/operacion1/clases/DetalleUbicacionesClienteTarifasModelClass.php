<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleUbicacionesClienteTarifasModel extends Db{


  public function getUbicacionesSolicitud($Conex){
  
     $select = "SELECT ubicacion_id AS value,CONCAT_WS(' - ',u.nombre,(SELECT nombre FROM ubicacion WHERE ubicacion_id = u.ubi_ubicacion_id)) AS text FROM ubicacion u WHERE tipo_ubicacion_id = 3 ORDER BY nombre ASC";
     
     $result = $this -> DbFetchAll($select,$Conex,true);
     
     return $result;	  
  
  }
  
  public function getDetallesUbicacionesArchivoCliente($cliente_id,$Conex){
    	
	$select  = "SELECT * FROM ubicacion_cliente_tarifa WHERE cliente_id = $cliente_id ORDER BY nombre ASC";	
	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	return $result;
	
  }
  
   
}

?>