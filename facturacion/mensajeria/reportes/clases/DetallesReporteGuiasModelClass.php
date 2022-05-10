<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesReporteGuiasModel extends Db{

  private $Permisos;
  public function getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$estado_id,$tipo_servicio_mensajeria_id,$consulta_usuario,$consulta_remitente,$consulta_destinatario,$consulta_oficina,$Conex){ 

	$select = "SELECT	
				g.numero_guia, g.prefijo,
			    g.orden_despacho AS documento_cliente,
				g.solicitud_id AS orden_servicio,
				(SELECT	em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,				
				(SELECT CONCAT_WS(' ',ca.causal,IF(d.obser_dev!='',' - ',''),d.obser_dev) FROM causal_devolucion ca, devolucion d, detalle_devolucion dv WHERE ca.causal_devolucion_id = dv.causal_devolucion_id AND d.devolucion_id = dv.devolucion_id AND dv.guia_id = g.guia_id LIMIT 1) AS nov_devolucion,				
				g.fecha_guia,g.hora_guia,
				(SELECT e.fecha_ent FROM entrega_oficina e, detalle_entrega_oficina de WHERE de.guia_id=g.guia_id AND e.entrega_oficina_id=de.entrega_oficina_id AND e.estado='E' ORDER BY e.fecha_ent DESC LIMIT 1) AS fecha_entrega_oficina,				
				(SELECT e.hora_ent FROM entrega_oficina e, detalle_entrega_oficina de WHERE de.guia_id=g.guia_id AND e.entrega_oficina_id=de.entrega_oficina_id AND e.estado='E' ORDER BY e.fecha_ent DESC LIMIT 1) AS hora_entrega_oficina,				
				
				(SELECT e.fecha_ent FROM entrega e, detalle_entrega de WHERE de.guia_id=g.guia_id AND e.entrega_id=de.entrega_id AND e.estado='E' ORDER BY e.fecha_ent DESC LIMIT 1) AS fecha_entrega,			
				(SELECT e.hora_ent FROM entrega e, detalle_entrega de WHERE de.guia_id=g.guia_id AND e.entrega_id=de.entrega_id AND e.estado='E' ORDER BY e.fecha_ent DESC LIMIT 1) AS hora_entrega,			
				
				(SELECT GROUP_CONCAT(e.fecha_dev) FROM devolucion e, detalle_devolucion de WHERE de.guia_id=g.guia_id AND e.devolucion_id=de.devolucion_id AND e.estado='D' ORDER BY e.fecha_dev DESC LIMIT 1) AS fecha_devolucion,				
				(SELECT	o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido,t.segundo_apellido) FROM cliente c, tercero t WHERE c.cliente_id=g.cliente_id AND t.tercero_id=c.tercero_id) AS nombre_cliente,
				(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
				(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
				(SELECT u.cod_postal FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS codigo_postal,
				(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero,
				(SELECT tsm.nombre_corto FROM tipo_servicio_mensajeria tsm WHERE tsm.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio,
				(SELECT r.fecha_rxp FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' LIMIT 0,1) AS fecha_man1,				
				(SELECT r.reexpedido FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' LIMIT 0,1) AS manifiesto1,
				(SELECT r.fecha_rxp FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' LIMIT 1,1) AS fecha_man2,				
				(SELECT r.reexpedido FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' LIMIT 1,1) AS manifiesto2,
				(SELECT r.fecha_rxp FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' LIMIT 2,1) AS fecha_man3,				
				(SELECT r.reexpedido FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' LIMIT 2,1) AS manifiesto3,
				g.doc_remitente,
				g.remitente,
				g.telefono_remitente,
				g.direccion_remitente,
				g.destinatario,
				g.doc_destinatario AS nit_destinatario,
				g.direccion_destinatario,
				g.telefono_destinatario,
				g.descripcion_producto,
				(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
				(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=g.tipo_envio_id) AS tipo_envio,
				g.proceso,
				g.pedido,
				g.unidad,
				g.facturas,
				g.peso,
				g.largo,
				g.alto,
				g.ancho,
				g.cantidad,
				IF(g.tipo_liquidacion = 'P','PENDIENTE', IF(tipo_liquidacion = 'M','MANIFESTADO', IF(tipo_liquidacion = 'L','LIQUIDADO','ANULADO'))) AS tipo_liquidacion,
				g.observaciones,
				IF(g.estado_mensajeria_id!=8,g.valor_flete,'0') AS valor_flete,
				IF(g.estado_mensajeria_id!=8,g.valor_seguro,'0') AS valor_seguro,
				IF(g.estado_mensajeria_id!=8,g.valor_descuento,'0') AS valor_descuento,
				IF(g.estado_mensajeria_id!=8,g.valor_otros,'0') AS valor_otros,
				g.foto_cumplido,
				IF(g.estado_mensajeria_id!=8,g.valor_total,'0') AS valor_total,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE u.usuario_id=g.usuario_id AND t.tercero_id=u.tercero_id) AS usuario,
				(SELECT CONCAT_WS(' ',t.numero_identificacion,t.digito_verificacion) FROM tercero t, usuario u WHERE u.usuario_id=g.usuario_id AND t.tercero_id=u.tercero_id) AS doc_usuario
				FROM
					guia g
				WHERE
					g.estado_mensajeria_id IN ($estado_id) AND g.tipo_servicio_mensajeria_id IN ($tipo_servicio_mensajeria_id) AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_origen $consulta_destino $consulta_usuario $consulta_remitente $consulta_destintario $consulta_oficina ";
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