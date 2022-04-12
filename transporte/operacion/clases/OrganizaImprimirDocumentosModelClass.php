<?php

require_once("../../../framework/clases/DbClass.php");

final class OrganizaImprimirModel extends Db{


	public function getRemesasManifiesto($manifiesto_id,$Conex){
		
		// if(is_numeric($manifiesto_id)){
		
			$select  = "SELECT
							r.remesa_id,
							r.numero_remesa
						FROM manifiesto m,
							detalle_despacho d,
							remesa r
						WHERE 
							m.manifiesto_id = $manifiesto_id AND
							m.manifiesto_id = d.manifiesto_id AND 
							d.remesa_id=r.remesa_id";
		
			$result = $this -> DbFetchAll($select,$Conex);
		// }else{
		// 	$result = array();
		// }
		return $result;
	}

	public function getAnticiposManifiesto($manifiesto_id,$Conex){

		$select = "SELECT encabezado_registro_id FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
		$result = $this -> DbFetchAll($select,$Conex);

		return $result;
	}

	public function getOrdenesCompra($remesa_id,$Conex){

		$select = "SELECT
						oc.orden_compra_id
					FROM
						item_liquida_orden ilo,
						orden_compra oc
					WHERE
						ilo.remesa_id=$remesa_id AND
						ilo.orden_compra_id=oc.orden_compra_id AND
						oc.estado_orden_compra!='I'"
					;
		$result = $this -> DbFetchAll($select,$Conex);
		return $result;
	}

	public function getRemesasDespachos($despachos_urbanos_id,$Conex){
		
		// if(is_numeric($manifiesto_id)){
		
			$select  = "SELECT
							r.remesa_id,
							r.numero_remesa
						FROM despachos_urbanos du,
							detalle_despacho d,
							remesa r
						WHERE 
							du.despachos_urbanos_id = $despachos_urbanos_id AND
							du.despachos_urbanos_id = d.despachos_urbanos_id AND 
							d.remesa_id=r.remesa_id";
		
			$result = $this -> DbFetchAll($select,$Conex);
		// }else{
		// 	$result = array();
		// }
		return $result;
	}

	public function getAnticiposDespachos($despachos_urbanos_id,$Conex){

		$select = "SELECT encabezado_registro_id FROM anticipos_manifiesto WHERE despachos_urbanos_id = $despachos_urbanos_id";
		$result = $this -> DbFetchAll($select,$Conex);

		return $result;
	}
}
?>