<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteTrazabilidadModel extends Db{

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
	$opciones=array(0=>array('value'=>'MC','text'=>'MANIFIESTO'),1=>array('value'=>'DU','text'=>'DESPACHO URBANO'));
	return $opciones;
   }
   
   public function GetTrazabilidad($Conex){
	$opciones=array(0=>array('value'=>'OP','text'=>'OPERATIVA'),1=>array('value'=>'FI','text'=>'FINANCIERA'));
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }  
   
  public function getReporte1($oficina_id,$desde,$hasta,$Conex){ 
	   	
	$select = "SELECT m.manifiesto AS orden_despacho, m.fecha_mc AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.manifiesto_id = dd.manifiesto_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,	
    (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,	
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_manifiesto im WHERE im.manifiesto_id = m.manifiesto_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
	
	FROM manifiesto m WHERE m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) ORDER BY m.manifiesto_id";	
		
    $results = $this -> DbFetchAll($select,$Conex);	
	
	for($i=0;$i<count($results);$i++){
		$results[$i]['utilidad']=$results[$i]['valfactura']-$results[$i]['valor_flete'];
		$results[$i]['porcentaje_utilidad']= round(($results[$i]['utilidad'] / $results[$i]['valfactura'])*100,2);	
		
		$results[$i]['saldo_a_pagar'] = ($results[$i]['saldo_pagar'] + $results[$i]['sobreflete']) - 
		($results[$i]['dto_papeleria'] + $results[$i]['dto_seguro'] + $results[$i]['dto_averias'] + $results[$i]['dto_noreportes'] + $results[$i]['dto_mora']);
		
	}
	
	return $results;
  }   
  
  public function getReporte2($oficina_id,$desde,$hasta,$Conex){ 
	   	
	$select = "SELECT m.despacho AS orden_despacho, m.fecha_du AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.despachos_urbanos_id = dd.despachos_urbanos_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,	
    (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,		
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_despacho im WHERE im.despachos_urbanos_id = m.despachos_urbanos_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
	
	FROM despachos_urbanos m WHERE m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) ORDER BY m.despachos_urbanos_id";	
		  
    $results = $this -> DbFetchAll($select,$Conex);	
	
	for($i=0;$i<count($results);$i++){
		$results[$i]['utilidad']=$results[$i]['valfactura']-$results[$i]['valor_flete'];
		$results[$i]['porcentaje_utilidad']= round(($results[$i]['utilidad'] / $results[$i]['valfactura'])*100,2);	
		
		$results[$i]['saldo_a_pagar'] = ($results[$i]['saldo_pagar'] + $results[$i]['sobreflete']) - 
		($results[$i]['dto_papeleria'] + $results[$i]['dto_seguro'] + $results[$i]['dto_averias'] + $results[$i]['dto_noreportes'] + $results[$i]['dto_mora']);
		
	}
	
	return $results;
  }  
  
public function getReporte3($oficina_id,$desde,$hasta,$Conex){ 
	   	
	$select = "(SELECT m.manifiesto AS orden_despacho, m.fecha_mc AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.manifiesto_id = dd.manifiesto_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,
    (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,	
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_manifiesto im WHERE im.manifiesto_id = m.manifiesto_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
	
	FROM manifiesto m WHERE m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id))
	
	UNION ALL
	
	(SELECT m.despacho AS orden_despacho, m.fecha_du AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.despachos_urbanos_id = dd.despachos_urbanos_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,
   (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_despacho im WHERE im.despachos_urbanos_id = m.despachos_urbanos_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
	
	FROM despachos_urbanos m WHERE m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) ORDER BY m.despachos_urbanos_id)";	
		  
    $results = $this -> DbFetchAll($select,$Conex);	
	
	for($i=0;$i<count($results);$i++){
		$results[$i]['utilidad']=$results[$i]['valfactura']-$results[$i]['valor_flete'];
		$results[$i]['porcentaje_utilidad']= round(($results[$i]['utilidad'] / $results[$i]['valfactura'])*100,2);	
		
		$results[$i]['saldo_a_pagar'] = ($results[$i]['saldo_pagar'] + $results[$i]['sobreflete']) - 
		($results[$i]['dto_papeleria'] + $results[$i]['dto_seguro'] + $results[$i]['dto_averias'] + $results[$i]['dto_noreportes'] + $results[$i]['dto_mora']);
		
	}
	
	return $results;
  }
  
 public function getReporte4($oficina_id,$desde,$hasta,$cliente_id,$Conex){ 
	   	
	$select = "SELECT m.manifiesto AS orden_despacho, m.fecha_mc AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.manifiesto_id = dd.manifiesto_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,
    (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id AND c.cliente_id = $cliente_id) AS cliente,	
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_manifiesto im WHERE im.manifiesto_id = m.manifiesto_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS valfactura
	
	FROM manifiesto m WHERE m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) AND m.manifiesto_id IN (SELECT manifiesto_id FROM detalle_despacho dd, remesa r
	WHERE r.cliente_id = $cliente_id AND dd.remesa_id = r.remesa_id) ORDER BY m.manifiesto_id";	
		
    $results = $this -> DbFetchAll($select,$Conex);	
	
	for($i=0;$i<count($results);$i++){
		$results[$i]['utilidad']=$results[$i]['valfactura']-$results[$i]['valor_flete'];
		$results[$i]['porcentaje_utilidad']= round(($results[$i]['utilidad'] / $results[$i]['valfactura'])*100,2);	
		
		$results[$i]['saldo_a_pagar'] = ($results[$i]['saldo_pagar'] + $results[$i]['sobreflete']) - 
		($results[$i]['dto_papeleria'] + $results[$i]['dto_seguro'] + $results[$i]['dto_averias'] + $results[$i]['dto_noreportes'] + $results[$i]['dto_mora']);
		
	}
	
	return $results;
  } 
  
  public function getReporte5($oficina_id,$desde,$hasta,$cliente_id,$Conex){ 
	   	
	$select = "SELECT m.despacho AS orden_despacho, m.fecha_du AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.despachos_urbanos_id = dd.despachos_urbanos_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,	
    (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id AND c.cliente_id = $cliente_id) AS cliente,		
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_despacho im WHERE im.despachos_urbanos_id = m.despachos_urbanos_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS valfactura
	
	FROM despachos_urbanos m WHERE m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) AND m.despachos_urbanos_id IN (SELECT despachos_urbanos_id 
    FROM detalle_despacho dd, remesa r WHERE r.cliente_id = $cliente_id AND dd.remesa_id = r.remesa_id) ORDER BY m.despachos_urbanos_id";	
		  
    $results = $this -> DbFetchAll($select,$Conex);	
	
	for($i=0;$i<count($results);$i++){
		$results[$i]['utilidad']=$results[$i]['valfactura']-$results[$i]['valor_flete'];
		$results[$i]['porcentaje_utilidad']= round(($results[$i]['utilidad'] / $results[$i]['valfactura'])*100,2);	
		
		$results[$i]['saldo_a_pagar'] = ($results[$i]['saldo_pagar'] + $results[$i]['sobreflete']) - 
		($results[$i]['dto_papeleria'] + $results[$i]['dto_seguro'] + $results[$i]['dto_averias'] + $results[$i]['dto_noreportes'] + $results[$i]['dto_mora']);
		
	}
	
	return $results;
	
 }   
  
public function getReporte6($oficina_id,$desde,$hasta,$cliente_id,$Conex){ 
	   	
	$select = "(SELECT m.manifiesto AS orden_despacho, m.fecha_mc AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.manifiesto_id = dd.manifiesto_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,
    (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id AND c.cliente_id = $cliente_id) AS cliente,	
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_manifiesto im WHERE im.manifiesto_id = m.manifiesto_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS valfactura
	
	FROM manifiesto m WHERE m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) AND m.manifiesto_id IN (SELECT manifiesto_id FROM detalle_despacho dd,remesa r
	WHERE r.cliente_id = $cliente_id AND dd.remesa_id = r.remesa_id))
	
	UNION ALL
	
	(SELECT m.despacho AS orden_despacho, m.fecha_du AS fecha,
	(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.despachos_urbanos_id = dd.despachos_urbanos_id AND
	dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
	(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id 
    AND t.tercero_id = te.tercero_id) AS tenedor,
   (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd 
	WHERE dd.remesa_id = r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
	(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
	(SELECT GROUP_CONCAT(am.valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' 
    AND am.oficina_id IN($oficina_id)) AS anticipo,
	(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
	AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
	(SELECT GROUP_CONCAT(im.valor) FROM impuestos_despacho im WHERE im.despachos_urbanos_id = m.despachos_urbanos_id) AS retefuente,
	m.saldo_por_pagar AS saldo_pagar,
	(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' 
    AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,				  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,			  
	(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,'' AS saldo_a_pagar,	
	(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er
	WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta') AS numeroegreso,	
	(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS numfactura,
	(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS fecfactura,
	(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd 
	WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.cliente_id = $cliente_id) AS valfactura
	
	FROM despachos_urbanos m WHERE m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id) AND m.despachos_urbanos_id IN (SELECT despachos_urbanos_id 
    FROM detalle_despacho dd, remesa r WHERE r.cliente_id = $cliente_id AND dd.remesa_id = r.remesa_id) ORDER BY m.despachos_urbanos_id)";	
		  
    $results = $this -> DbFetchAll($select,$Conex);	
	
	for($i=0;$i<count($results);$i++){
		$results[$i]['utilidad']=$results[$i]['valfactura']-$results[$i]['valor_flete'];
		$results[$i]['porcentaje_utilidad']= round(($results[$i]['utilidad'] / $results[$i]['valfactura'])*100,2);	
		
		$results[$i]['saldo_a_pagar'] = ($results[$i]['saldo_pagar'] + $results[$i]['sobreflete']) - 
		($results[$i]['dto_papeleria'] + $results[$i]['dto_seguro'] + $results[$i]['dto_averias'] + $results[$i]['dto_noreportes'] + $results[$i]['dto_mora']);
		
	}
	
	return $results;
  }   
   
}

?>