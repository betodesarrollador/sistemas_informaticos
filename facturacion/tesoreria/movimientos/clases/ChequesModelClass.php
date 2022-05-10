<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ChequesModel extends Db{

  private $Permisos;
  
  public function getCheques($oficina_id,$Conex){
	
	if(is_numeric($oficina_id)){		
	
		$select = "SELECT 
					f.abono_factura_id, f.fecha,f.num_cheque,f.valor_neto_factura,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo
				FROM abono_factura f
				WHERE f.oficina_id=$oficina_id AND f.estado_cheque='E' AND estado_abono_factura!='I'";
		  $result = $this -> DbFetchAll($select,$Conex); 
	}else{
   	    $result = array();
	 }
	
	return $result;
  }
}


?>