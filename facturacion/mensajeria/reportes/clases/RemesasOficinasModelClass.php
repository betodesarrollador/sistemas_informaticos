<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemesasOficinasModel extends Db{

//// GRID ////
  public function getQueryRemesasOficinasGrid($oficina_id){
     $Query = "(SELECT o.nombre AS oficina,IF(dp.manifiesto_id > 0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT despacho 
	           FROM despachos_urbanos WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS planilla,IF(dp.manifiesto_id > 0,'SI','NO') AS nacional,				    
			   IF(dp.manifiesto_id > 0,(SELECT IF(propio = 1,'SI','NO') FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT IF(propio = 1,'SI','NO')
			   FROM despachos_urbanos WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS propio,IF(dp.manifiesto_id > 0,(SELECT placa FROM manifiesto WHERE manifiesto_id =  
				dp.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS placa,IF(dp.manifiesto_id > 0,
				(SELECT nombre FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT nombre FROM despachos_urbanos WHERE despachos_urbanos_id = dp.despachos_urbanos_id))					
				AS conductor,IF(dp.manifiesto_id > 0,(SELECT fecha_mc FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT fecha_du FROM despachos_urbanos 
				WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS fecha_planilla,r.numero_remesa,r.estado,
				
							
				IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO','SUMINISTRO'))) AS clase_remesa,
				
				
				r.fecha_remesa,(SELECT 
				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id
				AND c.tercero_id=t.tercero_id) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				r.remitente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.destinatario,r.orden_despacho,d.referencia_producto,
				d.cantidad,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,r.descripcion_producto,(SELECT naturaleza FROM naturaleza 
				WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,(SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
				(SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,d.peso_volumen,d.peso,IF(r.estado_cliente = 'EL','ELABORACION',IF(r.estado_cliente = 'ET','ENTREGADO',IF(r.estado_cliente = 'DV','DEVUELTO',IF(estado_cliente = 'TR','TRANSITO','SIN ESTADO')))) AS estado_cliente,r.observaciones FROM remesa r,detalle_remesa d, detalle_despacho dp, oficina o WHERE 
				r.remesa_id = d.remesa_id AND r.remesa_id = dp.remesa_id AND r.oficina_id = o.oficina_id ORDER BY numero_remesa DESC) 
				
				UNION ALL				
				
				(SELECT o.nombre AS oficina,'' AS planilla,'' AS nacional,'' AS propio,'' AS placa,'' AS conductor,'' AS fecha_planilla,r.numero_remesa,r.estado,
								IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO','SUMINISTRO'))) AS clase_remesa,r.fecha_remesa,(SELECT 
				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id
				 AND c.tercero_id=t.tercero_id) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				r.remitente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.destinatario,r.orden_despacho,d.referencia_producto,d.cantidad,					
				(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,r.descripcion_producto,(SELECT naturaleza FROM naturaleza WHERE 
				naturaleza_id=r.naturaleza_id) AS naturaleza,(SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,(SELECT medida FROM medida WHERE 
				medida_id=r.medida_id) AS medida,d.peso_volumen,
					d.peso,IF(r.estado_cliente = 'EL','ELABORACION',IF(r.estado_cliente = 'ET','ENTREGADO',IF(r.estado_cliente = 'DV','DEVUELTO','SIN ESTADO'))) AS estado_cliente,
				r.observaciones
					
	 			FROM remesa r,detalle_remesa d, oficina o WHERE r.remesa_id = d.remesa_id AND r.oficina_id = o.oficina_id AND r.remesa_id 
				NOT IN (SELECT remesa_id FROM detalle_despacho)	ORDER BY numero_remesa DESC)";
	 
     return $Query;
  }

   
}
?>