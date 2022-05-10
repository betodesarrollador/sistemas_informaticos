<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteRemesasModel extends Db{

  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
   public function GetOficina($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,$ErrDb = false);
   }

   public function GetEstado($Conex){
	$opciones=array(0=>array('value'=>'PD,P','text'=>'PENDIENTE'),1=>array('value'=>'PC','text'=>'PROCESANDO'),2=>array('value'=>'MF','text'=>'MANIFESTADA'),
					3 =>array('value'=>'LQ','text'=>'LIQUIDADA'),
                    4=>array('value'=>'AN','text'=>'ANULADA'),5=>array('value'=>'FT','text'=>'FACTURADA'),
					6=>array('value'=>'ET','text'=>'FINALIZADAS'));
	return $opciones;
   }
   
   public function GetClase($Conex){
	$opciones=array(0=>array('value'=>'NN','text'=>'NORMAL'),1=>array('value'=>'CP','text'=>'COMPLEMENTO'),2=>array('value'=>'SM','text'=>'SUMINISTRO'),
					3 =>array('value'=>'DV','text'=>'DEVOLUCION'));
	return $opciones;
   }   

   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }

  public function getReporte1($oficina_id,$estado,$desde,$hasta,$consulta_cliente,$clase,$Conex){ 
	   	
	  $select = "
	  (
		SELECT 
		(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina_planilla,
		'MC' AS tipo,
		m.manifiesto AS planilla, 
		IF(r.nacional=1,'SI','NO') AS nacional, 
		IF(m.propio=1,'SI','NO') AS propio, 
		m.placa,
		m.nombre AS conductor,
		m.numero_identificacion AS ced_conductor,
		m.fecha_mc AS fecha_planilla,
		(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
		r.numero_remesa,
		CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'MANIFESTADO' WHEN 'MF' THEN 'MANIFESTADO' 
		WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END AS estado,
		IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS clase,
		r.fecha_remesa,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente, 
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
		r.remitente,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
		r.destinatario,
		r.orden_despacho,
	  (SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,
	  r.descripcion_producto,
	  (SELECT naturaleza FROM naturaleza WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,
	  (SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
	  (SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,
	  r.cantidad,
	  r.peso,
	  r.peso_volumen,
	  r.valor as valor_mercancia,
	  r.observacion_anulacion,
	  (SELECT nombre FROM causal_anulacion WHERE r.causal_anulacion_id = causal_anulacion_id) AS causal_anulacion,
	  r.fecha_anulacion,
	  (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM usuario u, tercero t  WHERE r.usuario_anulo_id = u.usuario_id  AND u.tercero_id  = t.tercero_id)  AS usuario_anulacion,
	  (SELECT GROUP_CONCAT(f.consecutivo_factura) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS numero_factura,
	  (SELECT GROUP_CONCAT(f.fecha) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS fecha_factura,
	  (SELECT GROUP_CONCAT(df.valor) FROM factura f,detalle_factura df WHERE df.remesa_id = r.remesa_id AND f.factura_id=df.factura_id AND f.estado!='I') AS valor_facturado,
	 (SELECT GROUP_CONCAT(ld.consecutivo) FROM liquidacion_despacho ld WHERE  ld.manifiesto_id = m.manifiesto_id AND ld.estado_liquidacion='L') AS numero_liquidacion,
	 (SELECT GROUP_CONCAT(ld.fecha) FROM liquidacion_despacho ld WHERE  ld.manifiesto_id = m.manifiesto_id AND ld.estado_liquidacion='L') AS fecha_liquidacion  
	  FROM remesa r, manifiesto m, detalle_despacho d 
	  WHERE r.remesa_id = d.remesa_id AND d.manifiesto_id = m.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' 
	  AND r.oficina_id IN($oficina_id) AND r.estado IN ('$estado') AND r.clase_remesa IN ('$clase') $consulta_cliente
	  
	  )UNION ALL(  
	  SELECT 
		(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina_planilla,
		'DU' AS tipo,
		m.despacho AS planilla, 
		IF(r.nacional=1,'SI','NO') AS nacional, 
		IF(m.propio=1,'SI','NO') AS propio, 
		m.placa,
		m.nombre AS conductor, 
		m.numero_identificacion AS ced_conductor,
		m.fecha_du AS fecha_planilla,
		(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
		r.numero_remesa,
		CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'MANIFESTADO' WHEN 'MF' THEN 'MANIFESTADO' 
		WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END AS estado,
		IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS clase,
		r.fecha_remesa,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente, 
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
		r.remitente,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
		r.destinatario,
		r.orden_despacho,
	  (SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,
	  r.descripcion_producto,
	  (SELECT naturaleza FROM naturaleza WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,
	  (SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
	  (SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,
	  r.cantidad,
	  r.peso,
	  r.peso_volumen,
	  r.valor as valor_mercancia,
	  r.observacion_anulacion,
	  (SELECT nombre FROM causal_anulacion WHERE r.causal_anulacion_id = causal_anulacion_id) AS causal_anulacion,
	  r.fecha_anulacion,
	  (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM usuario u, tercero t   WHERE r.usuario_anulo_id = u.usuario_id  AND u.tercero_id  = t.tercero_id)  AS usuario_anulacion,
	  (SELECT GROUP_CONCAT(f.consecutivo_factura) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS numero_factura,
	  (SELECT GROUP_CONCAT(f.fecha) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS fecha_factura,
	  (SELECT GROUP_CONCAT(df.valor) FROM factura f,detalle_factura df WHERE df.remesa_id = r.remesa_id AND f.factura_id=df.factura_id AND f.estado!='I') AS valor_facturado,
	  (SELECT GROUP_CONCAT(ld.consecutivo) FROM liquidacion_despacho ld WHERE  ld.despachos_urbanos_id = m.despachos_urbanos_id AND ld.estado_liquidacion='L') AS numero_liquidacion,
	  (SELECT GROUP_CONCAT(ld.fecha) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND ld.estado_liquidacion='L') AS fecha_liquidacion  
	  
	  FROM remesa r, despachos_urbanos m, detalle_despacho d 
	  WHERE r.remesa_id = d.remesa_id AND d.despachos_urbanos_id = m.despachos_urbanos_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' 
	  AND r.oficina_id IN($oficina_id) AND r.estado IN ('$estado') AND r.clase_remesa IN ('$clase') $consulta_cliente
	  
	  )UNION ALL(	  
	  SELECT 
		'N/A' oficina_planilla,
		'N/A' AS tipo,
		'N/A' AS planilla, 
		IF(r.nacional=1,'SI','NO') AS nacional, 
		'N/A' AS propio,
		'N/A' AS placa,
		'N/A' AS conductor, 
		'N/A' AS ced_conductor,
		'N/A' AS fecha_planilla, 	
		(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa, 
		r.numero_remesa,
		CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'MANIFESTADO' WHEN 'MF' THEN 'MANIFESTADO' 
		WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END AS estado,
		IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS clase,
		r.fecha_remesa,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente, 
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
		r.remitente,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
		r.destinatario,
		r.orden_despacho,
	  (SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,
	  r.descripcion_producto,
	  (SELECT naturaleza FROM naturaleza WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,
	  (SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
	  (SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,
	  r.cantidad,
	  r.peso,
	  r.peso_volumen,
	  r.valor as valor_mercancia,
	  r.observacion_anulacion,
	  (SELECT nombre FROM causal_anulacion WHERE r.causal_anulacion_id = causal_anulacion_id) AS causal_anulacion,
	  r.fecha_anulacion,
	  (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM usuario u, tercero t  WHERE r.usuario_anulo_id = u.usuario_id  AND u.tercero_id  = t.tercero_id)  AS usuario_anulacion,
	  'N/A' AS numero_factura,
	  'N/A' AS fecha_factura,
	  'N/A' AS valor_facturado,
	  'N/A' AS numero_liquidacion,
      'N/A' AS fecha_liquidacion  
	  FROM remesa r
	  WHERE r.remesa_id NOT IN (SELECT remesa_id FROM detalle_despacho) AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' 
	  AND r.oficina_id IN($oficina_id) AND r.estado IN ('$estado') AND r.clase_remesa IN ('$clase') $consulta_cliente) ORDER BY cliente";	
		  
	  //echo $select;
	  $results = $this -> DbFetchAll($select,$Conex);		  
	  $i=0;
	  
	  return $results;
  }  
}

?>