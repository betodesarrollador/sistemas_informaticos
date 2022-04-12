<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesReporteGuiasPendientesModel extends Db{

  private $Permisos;
  public function getReporte1($desde,$hasta,$consulta_oficina,$Conex){ 

	$select = "SELECT g.numero_guia,
	 g.fecha_guia,	 
	 g.remitente,g.prefijo,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id=g.origen_id)AS origen,g.destinatario,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id=g.destino_id)AS destino,	
	 (SELECT nombre FROM oficina WHERE oficina_id=g.oficina_id)As oficina,
	 (SELECT nombre_estado FROM estado_mensajeria WHERE g.estado_mensajeria_id=estado_mensajeria_id)AS estado
	 FROM guia g WHERE g.estado_mensajeria_id NOT IN (6,7,8) AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_oficina ";
					 //echo $select;
				$results = $this -> DbFetchAll($select,$Conex,true);
		  
		  
		  return $results;
	
  }

  public function getReporte2($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$tipo_servicio_mensajeria_id,$consulta_cliente,$consulta_oficina,$Conex){ 

	$select = "SELECT	
				g.foto_cumplido
				FROM
					guia g
				WHERE foto_cumplido IS NOT NULL AND
					estado_mensajeria_id IN ($estado_id) AND tipo_servicio_mensajeria_id IN ($tipo_servicio_mensajeria_id) AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_origen $consulta_destino $consulta_cliente $consulta_oficina ";
					// echo $select;
				$results = $this -> DbFetchAll($select,$Conex);
		  
		  
		  return $results;
	
  }
  

}

?>