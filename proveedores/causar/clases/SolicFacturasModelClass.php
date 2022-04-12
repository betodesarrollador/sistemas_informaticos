<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicFacturasModel extends Db{

  private $Permisos;
  
  public function getSolicFacturas($proveedor_id,$Conex){
	
	if(is_numeric($proveedor_id)){		
	
		$select = "SELECT  
				 ap.anticipos_proveedor_id AS id_interno, 
				 ap.valor AS valor,
				 
				 (SELECT SUM(atp.valor) FROM  anticipos_proveedor atp WHERE atp.sub_anticipos_proveedor_id=ap.anticipos_proveedor_id AND atp.devolucion=1 AND atp.estado!='A' ) AS devoluciones,				 
				 
				 ap.consecutivo,
				
				 ap.fecha AS fecha,
				 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_proveedor_id=ap.anticipos_proveedor_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C') AS abonos,
				 (SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_proveedor_id=ap.anticipos_proveedor_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='A') AS abonos_nc,
				 (ap.valor-(SELECT SUM(ra.rel_valor_abono_anticipo) FROM  relacion_anticipos_abono ra, abono_factura_proveedor af WHERE ra.anticipos_proveedor_id=ap.anticipos_proveedor_id AND af.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND af.estado_abono_factura='C')) AS saldo

				FROM anticipos_proveedor ap
				WHERE ap.anticipos_proveedor_id NOT IN (IF ((SELECT GROUP_CONCAT(REPLACE(anticipos_cruzar,'\'','')) FROM factura_proveedor WHERE estado_factura_proveedor != 'I' AND proveedor_id =$proveedor_id)IS NOT NULL,(SELECT GROUP_CONCAT(REPLACE(anticipos_cruzar,'\'','')) FROM factura_proveedor WHERE estado_factura_proveedor != 'I' AND proveedor_id =$proveedor_id),0))AND ap.proveedor_id = $proveedor_id AND devolucion = 0 AND estado !='A'";
				
		  $results = $this -> DbFetchAll($select,$Conex,true); 
	  
	}else{
   	    $results = array();
	 }
	
	return $results;
  }
}


?>