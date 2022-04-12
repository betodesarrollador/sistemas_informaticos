<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ReexpedidoModel extends Db{
  
  public function getReexpedido($oficina_id,$Conex,$usuario){
  
	$reexpedido_id=$_REQUEST['reexpedido_id'];			
	$select = "SELECT r.reexpedido_id,r.reexpedido,r.interno,r.hora_salida,
    r.fecha_rxp,r.proveedor_id,(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) 
    FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor, r.origen_id,
    (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,r.destino_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,(SELECT 
	numero_identificacion FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS identificacion, (SELECT 
	logo FROM empresa e, tercero t WHERE t.tercero_id=t.tercero_id AND e.tercero_id=t.tercero_id) AS logo,(SELECT razon_social FROM empresa e, tercero t WHERE t.tercero_id=t.tercero_id
	AND e.tercero_id=t.tercero_id) AS nombre_empresa, (SELECT (CONCAT_WS(' - ',t.numero_identificacion, digito_verificacion)) FROM empresa e, tercero t WHERE t.tercero_id=t.tercero_id
	AND e.tercero_id=t.tercero_id) AS id_empresa, (SELECT telefono FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS telefono, 
	(SELECT movil FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS movil, (SELECT direccion FROM tercero t, proveedor p 
	WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS direccion, (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id ) AS ciudad_reexpedidor,
	r.usuario_registra,r.obser_rxp, r.estado 
	FROM reexpedido r WHERE reexpedido_id=$reexpedido_id";	
	
	
	$result  = $this -> DbFetchAll($select,$Conex,true);	
	$reexpedido = $result;
	
	
			
	return $reexpedido;
	
  }
  

 public function getDetalle($oficina_id,$Conex,$usuario){
  
	$reexpedido_id=$_REQUEST['reexpedido_id'];			
	$select = "SELECT CONCAT(r.prefijo,r.numero_guia) AS numero_guia, r.valor_flete AS valor_rxp , r.fecha_guia, r.remitente, r.destinatario,r.direccion_destinatario,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	(SELECT nombre_corto FROM tipo_servicio_mensajeria WHERE tipo_servicio_mensajeria_id=r.tipo_servicio_mensajeria_id) AS tipo_mensajeria,
	(SELECT descripcion_producto FROM detalle_guia WHERE guia_id=r.guia_id) AS descripcion_producto
	FROM detalle_despacho_guia dd, guia r WHERE dd.reexpedido_id=$reexpedido_id AND r.guia_id=dd.guia_id ORDER BY r.numero_guia ASC";	
	
	$result  = $this -> DbFetchAll($select,$Conex,true);	
			
	return $result;
	
  }
  
 public function getDetalle1($oficina_id,$Conex,$usuario){
  
	$reexpedido_id=$_REQUEST['reexpedido_id'];			
	$select = "SELECT r.numero_guia, r.valor_flete AS valor_rxp , r.fecha_guia, r.remitente, r.destinatario,r.direccion_destinatario,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	(SELECT nombre_corto FROM tipo_servicio_mensajeria WHERE tipo_servicio_mensajeria_id=r.tipo_servicio_mensajeria_id) AS tipo_mensajeria,
	(SELECT descripcion_producto FROM detalle_guia_interconexion WHERE guia_interconexion_id=r.guia_interconexion_id) AS descripcion_producto
	FROM detalle_despacho_guia dd, guia_interconexion r WHERE dd.reexpedido_id=$reexpedido_id AND r.guia_interconexion_id=dd.guia_interconexion_id ORDER BY r.numero_guia ASC";	
	
	$result  = $this -> DbFetchAll($select,$Conex,true);	
			
	return $result;
	
  }  
   
}


?>