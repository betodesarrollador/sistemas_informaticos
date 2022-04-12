<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicOrdenesModel extends Db{

  private $Permisos;
  
  public function getSolicOrdenes($proveedor_id,$Conex){
	
	if(is_numeric($proveedor_id)){		
	
		$select = "SELECT  
						o.orden_compra_id,
						o.fecha_orden_compra as fecha,
						o.consecutivo,
						(SELECT CONCAT(codigo_tipo_servicio,' - ',nombre_bien_servicio)as nom FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=o.tipo_bien_servicio_id) as tipo_servicio,
						(SELECT SUM(deb_item_puc_liquida+cre_item_puc_liquida) AS valor FROM item_puc_liquida_orden  WHERE orden_compra_id=o.orden_compra_id AND contra_liquida_orden=1) as valor,
						o.descrip_orden_compra as concepto
						
						FROM orden_compra o 
						WHERE o.proveedor_id= $proveedor_id AND o.estado_orden_compra='L'  
						
				";
				
		  $results = $this -> DbFetchAll($select,$Conex,true); 
	  
	}else{
   	    $results = array();
	 }
	
	return $results;
  }
}


?>