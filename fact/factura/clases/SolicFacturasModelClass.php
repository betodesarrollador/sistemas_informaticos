<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicFacturasModel extends Db{

  private $Permisos;

  public function getComprobar($tipo_bien_servicio_factura_id,$Conex){
	   	
	  $select = "SELECT COUNT(*) AS movimientos FROM codpuc_bien_servicio_factura   WHERE tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND tercero_bien_servicio_factura=1";

      $result = $this -> DbFetchAll($select,$Conex);
	  
	  $movimientos = $result[0]['movimientos'];
	  return $movimientos; 
  }

//// GRID ////
  public function getQuerySolicFacturasGrid($cliente_id){
	

	$Query = "(SELECT 
				CONCAT_WS('','<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',o.orden_servicio_id,'\" name=\"check\"/>','<input type=\"hidden\" name=\"fuente_fac\"  value=\"OS\" />') AS link,
				'Orden de Servicio' AS fuente,
				o.consecutivo AS  consecutivo,
				(SELECT nombre_bien_servicio_factura  FROM tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id) AS tipo_servicio,				
				(SELECT ipl.deb_item_puc_liquida FROM item_puc_liquida_servicio ipl WHERE ipl.orden_servicio_id=o.orden_servicio_id AND ipl.contra_liquida_servicio=1 LIMIT 1) AS valor_facturar,				
				(SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
				'No Aplica' AS origen,
				'No Aplica' AS destino,
				'No Aplica' AS producto,					
				o.fecha_orden_servicio AS fecha
			FROM orden_servicio o
			WHERE o.cliente_id=$cliente_id AND  o.estado_orden_servicio='L')
			UNION
			(SELECT 
					CONCAT_WS('','<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',r.remesa_id,'\" name=\"check\"/>','<input type=\"hidden\" name=\"valor_facturar\"  value=\"',r.valor_facturar,'\" />','<input type=\"hidden\" name=\"valor_costo\"  value=\"',r.valor_costo,'\" />','<input type=\"hidden\" name=\"fuente_fac\"  value=\"RM\" />') AS link,
					'Remesa' AS fuente,	
					r.numero_remesa AS consecutivo,
					'No Aplica' AS tipo_servicio,	
					r.valor_facturar,
					(SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
					(SELECT producto  FROM producto WHERE producto_id=r.producto_id) AS producto,					
					r.fecha_remesa AS fecha
				FROM remesa r
				WHERE r.cliente_id=$cliente_id AND r.estado='LQ' AND r.clase_remesa='NN')
			UNION
			(SELECT 
					CONCAT_WS('','<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',r.seguimiento_id,'\" name=\"check\" />','<input type=\"hidden\" name=\"fuente_fac\"  value=\"ST\" />') AS link,
					'Despacho Particular' AS fuente,
					r.seguimiento_id AS  consecutivo,
					'No Aplica' AS tipo_servicio,	
					r.valor_facturar,
					(SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					(SELECT nombre  FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
					r.observaciones AS producto,					
					r.fecha AS fecha
				FROM seguimiento r
				WHERE r.cliente_id=$cliente_id AND r.estado='L')"; 

	return $Query;
   }
   
}



?>