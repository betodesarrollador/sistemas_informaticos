<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesReporteTotalModel extends Db{

  	private $Permisos;
  
	public function getReporte1($desde,$hasta,$consulta_cliente,$Conex){ 
	
		$select = "SELECT	
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE  t.tercero_id=c.tercero_id) AS nombre_cliente,
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=1) AS g_alistamiento,		
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=2) AS g_origen,
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=3) AS g_destino,
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=4) AS g_transito, 
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=5) AS g_distribucion,
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=6) AS g_entregado,
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=7) AS g_devuelto,
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id AND estado_mensajeria_id=8) AS g_anulado, 
		(SELECT COUNT(*) FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' AND cliente_id=c.cliente_id) AS total_guias
		FROM cliente c WHERE c.cliente_id IN (SELECT cliente_id FROM guia WHERE fecha_guia BETWEEN '$desde' AND '$hasta' )	$consulta_cliente";
		//echo $select;
		$results = $this -> DbFetchAll($select,$Conex,true);
		
		
		return $results;
	
	}

}

?>