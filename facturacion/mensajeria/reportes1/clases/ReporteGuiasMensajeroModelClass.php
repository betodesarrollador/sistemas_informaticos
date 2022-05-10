<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ReporteGuiasMensajeroModel extends Db{

		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}

		public function GetPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function GetEstado($Conex){
			$select = "SELECT estado_mensajeria_id AS value, nombre_estado AS text FROM estado_mensajeria";
			$result = $this -> DbFetchAll($select,$Conex);

			return $result;
		}

		public function GetServicio($Conex){
			$select = "SELECT tipo_servicio_mensajeria_id AS value, nombre AS text FROM tipo_servicio_mensajeria";
			$result = $this -> DbFetchAll($select,$Conex);

			return $result;
		}

		public function GetOficina($oficina_id,$empresa_id,$Conex){

			$select = "SELECT oficina_id AS value, nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id";
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function GetSi_ME($Conex){
			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}
		
		public function GetSi_Usu($Conex){
			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}


		public function getReporte1($desde,$hasta,$oficina,$estado_id,$tipo_servicio_mensajeria_id,$consulta_origen,$consulta_destino,$consulta_usuario,$consulta_peso,$consulta_mensajero,$Conex){ 

			$select = "SELECT 
							CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
							g.solicitud_id,
							g.numero_guia_padre,
							g.fecha_guia,
							(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
							(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
							(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.guia_id=dd.guia_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS fecha_recibe,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) AS numero_identificacion FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe_doc,							
							(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS reexpedido,
							(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS interno,							
							(SELECT GROUP_CONCAT(d.fecha_dev) FROM devolucion d, detalle_devolucion dd  WHERE  g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
							(SELECT GROUP_CONCAT(c.causal) FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,
							

							(SELECT GROUP_CONCAT(d.fecha_ree) FROM reenvio d, detalle_reenvio dd  WHERE  g.guia_id=dd.guia_id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,

							(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.guia_id=g.guia_id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
							(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.guia_id=de.guia_id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							
							
							(SELECT GROUP_CONCAT(fecha_ent) FROM entrega e, detalle_entrega de  WHERE  g.guia_id=de.guia_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
							(SELECT e.usuario_registra_numero_identificacion FROM entrega e, detalle_entrega de  WHERE  g.guia_id=de.guia_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS usuario_entrega_doc,
							(SELECT e.usuario_registra FROM entrega e, detalle_entrega de  WHERE  g.guia_id=de.guia_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS usuario_entrega,							
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
							(SELECT t.nombre FROM tipo_servicio_mensajeria t WHERE t.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria,							
							g.doc_remitente,
							g.remitente,
							g.telefono_remitente,
							g.direccion_remitente,
							g.destinatario,
							g.direccion_destinatario,
							g.descripcion_producto,
							(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
							(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=g.tipo_envio_id)AS tipo_envio,
							g.peso,
							g.peso_volumen,
							g.largo,
							g.orden_despacho,
							g.alto,
							g.ancho,
							g.cantidad,
							g.valor_flete,
							g.valor_seguro,							
							g.valor_otros,							
							g.valor_total,							
							g.tipo_liquidacion,
							g.observaciones
						FROM
							guia g
						WHERE
							g.estado_mensajeria_id IN ($estado_id) AND g.tipo_servicio_mensajeria_id IN ($tipo_servicio_mensajeria_id) AND g.oficina_id IN($oficina) AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_origen $consulta_destino $consulta_usuario $consulta_peso $consulta_mensajero";
						 //echo $select;
			$results = $this -> DbFetchAll($select,$Conex,true); 
			//print_r ($results);
			return $results;
		}
		public function getReporte2($documento,$Conex){ 

			$select = "SELECT 
							g.numero_guia,
							g.solicitud_id,							
							g.numero_guia_padre,							
							g.fecha_guia,
							(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
							(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
							(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.guia_id=dd.guia_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS fecha_recibe,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe,
							(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS reexpedido,
							(SELECT GROUP_CONCAT(d.fecha_dev) FROM devolucion d, detalle_devolucion dd  WHERE  g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
							(SELECT GROUP_CONCAT(c.causal) FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,

							(SELECT GROUP_CONCAT(d.fecha_ree) FROM reenvio d, detalle_reenvio dd  WHERE  g.guia_id=dd.guia_id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,

							(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.guia_id=g.guia_id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
							(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.guia_id=de.guia_id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

							(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.guia_id=de.guia_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
							(SELECT t.nombre FROM tipo_servicio_mensajeria t WHERE t.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria,							
							g.doc_remitente,
							g.remitente,
							g.telefono_remitente,
							g.direccion_remitente,
							g.destinatario,
							g.direccion_destinatario,
							g.descripcion_producto,
							(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
							(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=g.tipo_envio_id)AS tipo_envio,
							g.peso,
							g.largo,
							g.orden_despacho,
							g.alto,
							g.ancho,
							g.cantidad,
							g.tipo_liquidacion,
							g.observaciones
						FROM
							guia g, reexpedido r, detalle_despacho_guia dg
						WHERE
							$documento
						ORDER BY
							g.numero_guia
						";
						 //echo $select;
			$results = $this -> DbFetchAll($select,$Conex,true);

			return $results;
		}

		public function getReporte3($documento,$Conex){ 

			$select = "SELECT 
							g.numero_guia,
							g.solicitud_id,							
							g.numero_guia_padre,							
							g.fecha_guia,
							(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
							(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
							(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.guia_id=dd.guia_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS fecha_recibe,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe,
							(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS reexpedido,
							(SELECT GROUP_CONCAT(d.fecha_dev) FROM devolucion d, detalle_devolucion dd  WHERE  g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1 LIMIT 1) AS fecha_devuelve,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
							(SELECT GROUP_CONCAT(c.causal) FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,
							
							(SELECT GROUP_CONCAT(d.fecha_ree) FROM reenvio d, detalle_reenvio dd  WHERE  g.guia_id=dd.guia_id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,

							(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.guia_id=g.guia_id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
							(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.guia_id=de.guia_id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

							(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.guia_id=de.guia_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
							(SELECT t.nombre FROM tipo_servicio_mensajeria t WHERE t.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria,							
							g.doc_remitente,
							g.remitente,
							g.telefono_remitente,
							g.direccion_remitente,
							g.destinatario,
							g.direccion_destinatario,
							g.descripcion_producto,
							(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
							(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=g.tipo_envio_id)AS tipo_envio,
							g.peso,
							g.largo,
							g.orden_despacho,							
							g.alto,
							g.ancho,
							g.cantidad,
							g.tipo_liquidacion,
							g.observaciones
						FROM
							guia g
						WHERE
							$documento
						";
						//echo $select.'sss';
			$results = $this -> DbFetchAll($select,$Conex,true);

			return $results;
		}

		public function getReporte4($documento,$Conex){ 

			$select = "SELECT 
							g.numero_guia,
							g.solicitud_id,
							g.numero_guia_padre,							
							g.fecha_guia,
							(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
							(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
							(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.guia_id=dd.guia_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS fecha_recibe,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe,
							(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_id=dg.guia_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS reexpedido,
							(SELECT GROUP_CONCAT(d.fecha_dev) FROM devolucion d, detalle_devolucion dd  WHERE  g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
							(SELECT GROUP_CONCAT(c.causal) FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.guia_id=dd.guia_id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,
							
							(SELECT GROUP_CONCAT(d.fecha_ree) FROM reenvio d, detalle_reenvio dd  WHERE  g.guia_id=dd.guia_id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,

							(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.guia_id=g.guia_id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
							(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.guia_id=de.guia_id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

							(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.guia_id=de.guia_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
							(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.guia_id = g.guia_id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
							(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
							(SELECT t.nombre FROM tipo_servicio_mensajeria t WHERE t.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria,							
							g.doc_remitente,
							g.remitente,
							g.telefono_remitente,
							g.direccion_remitente,
							g.destinatario,
							g.direccion_destinatario,
							g.descripcion_producto,
							(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
							g.peso,
							g.largo,
							g.orden_despacho,							
							g.alto,
							g.ancho,
							g.cantidad,
							g.tipo_liquidacion,
							g.observaciones
						FROM
							guia g, reexpedido r, detalle_despacho_guia dg
						WHERE
							$documento
						ORDER BY
							g.numero_guia
						";
						//echo $select;
						$results = $this -> DbFetchAll($select,$Conex,true);
			return $results;
		}
	}
?>