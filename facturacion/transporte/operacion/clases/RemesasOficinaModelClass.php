<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemesasOficinasModel extends Db{

//// GRID ////
  public function getQueryRemesasOficinasGrid($oficina_id){
     $Query = "SELECT 
	 				r.numero_remesa,
					
				IF(r.estado = 'PD', 'PENDIENTE', IF(r.estado = 'PC','PROCESANDO',IF(r.estado = 'MF','MANIFESTADO',IF(r.estado = 'AN','ANULADO',IF(r.estado = 'LQ','LIQUIDADA',IF(r.estado = 'FT','FACTURADA','INCONSISTENTE')))))) AS estado,
										
					
					(SELECT tipo_remesa FROM tipo_remesa WHERE tipo_remesa_id=r.tipo_remesa_id) AS tipo_remesa,
					r.fecha_remesa,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)
						 FROM cliente c, tercero t 
						 WHERE c.cliente_id=r.cliente_id
						 AND c.tercero_id=t.tercero_id) 
					AS cliente,
					
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					r.remitente,				
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
					r.destinatario,
					r.orden_despacho,
					d.referencia_producto,
					d.cantidad,					
					(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,
					r.descripcion_producto,
					(SELECT naturaleza FROM naturaleza WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,
					(SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
					(SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,
					d.peso_volumen,
					d.peso
					
	 			FROM remesa r,detalle_remesa d WHERE r.oficina_id = $oficina_id AND r.remesa_id = d.remesa_id ORDER BY numero_remesa DESC";
	 
     return $Query;
  }

   
}
?>