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


	public function getReporte1($tipo_guia,$union_all,$tabla,$id,$numero_guia,$desde1,$hasta1,$oficina,$estado_id,$tipo_servicio_mensajeria_id,$consulta_origen,$consulta_destino,$consulta_usuario,$consulta_peso,$consulta_mensajero,$consulta_placa,$Conex){ 
		
		$select = "SELECT 
		'$tipo_guia' AS tipo_guia,
		CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
		g.solicitud_id,
		g.numero_guia_padre,
		g.fecha_guia,
		(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
		(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
		
		(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.$id=dd.$id AND r.estado!='A') AS fecha_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe_doc,							
		
		(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS reexpedido,
		
		(SELECT  GROUP_CONCAT(r.placa) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS placa,
		
		(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS interno,		
		
							
		(SELECT d.fecha_dev FROM devolucion d, detalle_devolucion dd  WHERE  g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve_doc,
		
		(SELECT GROUP_CONCAT(c.causal) FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,
		

		(SELECT d.fecha_ree FROM reenvio d, detalle_reenvio dd  WHERE  g.$id=dd.$id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio_doc,

		(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.$id=g.$id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
		(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.$id=de.$id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							
		
		(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.$id=de.$id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega_doc,
		
		

		(SELECT e.usuario_registra_numero_identificacion FROM entrega e, detalle_entrega de  WHERE  g.$id=de.$id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS usuario_entrega_doc,
		(SELECT e.usuario_registra FROM entrega e, detalle_entrega de  WHERE  g.$id=de.$id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS usuario_entrega,							
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
		if(g.estado_mensajeria_id = 8,0,g.valor_flete) AS valor_flete,
		if(g.estado_mensajeria_id = 8,0,g.valor_seguro) AS valor_seguro,
		if(g.estado_mensajeria_id = 8,0,g.valor_otros) AS valor_otros,
		if(g.estado_mensajeria_id = 8,0,g.valor_descuento) AS valor_descuento,
		if(g.estado_mensajeria_id = 8,0,g.valor_total) AS valor_total,						
		g.tipo_liquidacion,
		g.observaciones
		FROM
		$tabla
		WHERE g.$id >0 $numero_guia $estado_id $tipo_servicio_mensajeria_id $oficina $desde1 $hasta1 $consulta_origen $consulta_destino $consulta_usuario $consulta_peso $consulta_mensajero $consulta_placa

		$union_all";
						
		$results = $this -> DbFetchAll($select,$Conex,true); 
			//print_r ($results);
		return $results;
	}
	public function getReporte2($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex){ 

		$select = "SELECT 
		'$tipo_guia' AS tipo_guia,
		g.numero_guia,
		g.solicitud_id,							
		g.numero_guia_padre,							
		g.fecha_guia,
		(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
		(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
		
		(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.$id=dd.$id AND r.estado!='A') AS fecha_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe_doc,
		
		
		(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS reexpedido,
		
		
		
		(SELECT GROUP_CONCAT(r.placa) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS placa,
		
		(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS interno,	
		
		(SELECT d.fecha_dev FROM devolucion d, detalle_devolucion dd  WHERE  g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve_doc,
		
		
		(SELECT c.causal FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,

		(SELECT d.fecha_ree FROM reenvio d, detalle_reenvio dd  WHERE  g.$id=dd.$id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio_doc,

		(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.$id=g.$id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
		(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.$id=de.$id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

		(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.$id=de.$id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega_doc,
		
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
		r.placa,
		g.tipo_liquidacion,
		g.observaciones
		FROM
		$tabla, reexpedido r, detalle_despacho_guia dg
		WHERE
		$documento
		ORDER BY
		g.numero_guia
		";
						//echo $select;
						//exit ($select);
		$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
	}

	public function getReporte3($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex){ 

		$select = "SELECT 
		'$tipo_guia' AS tipo_guia,
		g.numero_guia,
		g.solicitud_id,							
		g.numero_guia_padre,							
		g.fecha_guia,
		(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
		(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
		
		(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.$id=dd.$id AND r.estado!='A') AS fecha_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe_doc,
		
		(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS reexpedido,
		
		(SELECT  GROUP_CONCAT(r.placa) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS placa,
		
		(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS interno,	
		
		(SELECT d.fecha_dev FROM devolucion d, detalle_devolucion dd  WHERE  g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve_doc,
		
		(SELECT c.causal FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,
		
		(SELECT d.fecha_ree FROM reenvio d, detalle_reenvio dd  WHERE  g.$id=dd.$id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio_doc,

		(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.$id=g.$id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
		(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.$id=de.$id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

		(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.$id=de.$id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega_doc,
		
		
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
		$tabla
		WHERE
		$documento
		ORDER BY
		g.numero_guia
		";
						//echo $select;
						//echo $select.'sss';
		$results = $this -> DbFetchAll($select,$Conex,true);

		return $results;
	}

	public function getReporte4($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex){ 

		$select = "SELECT 
		'$tipo_guia' AS tipo_guia,
		g.numero_guia,
		g.solicitud_id,
		g.numero_guia_padre,							
		g.fecha_guia,
		(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
		(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
		
		(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.$id=dd.$id AND r.estado!='A') AS fecha_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe,
		
		(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A') AS mensajero_recibe_doc,
		
		(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS reexpedido,
		
		(SELECT  GROUP_CONCAT(r.placa) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS placa,
		
		(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS interno,	
		
		(SELECT d.fecha_dev FROM devolucion d, detalle_devolucion dd  WHERE  g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve_doc,
		
		(SELECT c.causal FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.$id=dd.$id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,
		
		(SELECT d.fecha_ree FROM reenvio d, detalle_reenvio dd  WHERE  g.$id=dd.$id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio_doc,

		(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.$id=g.$id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
		(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.$id=de.$id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

		(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.$id=de.$id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
		
		(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
		
		(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.$id = g.$id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega_doc,
		
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
		r.placa,
		g.cantidad,
		g.tipo_liquidacion,
		g.observaciones
		FROM
		$tabla, reexpedido r, detalle_despacho_guia dg
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