<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesHistoricoModel extends Db{

  private $Permisos;
  
  public function getReporte1($oficina_id,$desde,$hasta,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,
		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id) 
		  ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  } // HISTORICO GENERAL
  
  public function getReporte2($oficina_id,$desde,$hasta,$cliente_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,
		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND r.cliente_id IN($cliente_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  } // HISTORICO CLIENTE
  
  public function getReporte3($oficina_id,$desde,$hasta,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // HISTORICO TENEDOR 
  
  public function getReporte4($oficina_id,$desde,$hasta,$conductor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // HISTORICO CONDUCTOR  
  
  public function getReporte5($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.placa_id IN($vehiculo_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // HISTORICO VEHICULO 
  
    public function getReporte6($oficina_id,$desde,$hasta,$vehiculo_id,$cliente_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.placa_id IN($vehiculo_id) AND r.cliente_id IN($cliente_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE VEHICULO - CLIENTE
  
    public function getReporte7($oficina_id,$desde,$hasta,$vehiculo_id,$conductor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.placa_id IN($vehiculo_id) AND m.conductor_id IN($conductor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE VEHICULO - CONDUCTOR  
  
    public function getReporte8($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.placa_id IN($vehiculo_id) AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE VEHICULO - TENEDOR  
  
    public function getReporte9($oficina_id,$desde,$hasta,$conductor_id,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CONDUCTOR - TENEDOR  
  
      public function getReporte10($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) AND r.cliente_id IN($cliente_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CONDUCTOR - CLIENTE
  
      public function getReporte11($oficina_id,$desde,$hasta,$cliente_id,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND r.cliente_id IN($cliente_id) AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CLIENTE - TENEDOR
  
      public function getReporte12($oficina_id,$desde,$hasta,$conductor_id,$vehiculo_id,$cliente_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) AND m.placa_id IN($vehiculo_id) AND r.cliente_id IN($cliente_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CONDUCTOR - VEHICULO - CLIENTE
  
      public function getReporte13($oficina_id,$desde,$hasta,$conductor_id,$vehiculo_id,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) AND m.placa_id IN($vehiculo_id) AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CONDUCTOR - VEHICULO - TENEDOR  
  
      public function getReporte14($oficina_id,$desde,$hasta,$cliente_id,$vehiculo_id,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND r.cliente_id IN($cliente_id) AND m.placa_id IN($vehiculo_id) AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CLIENTE - VEHICULO - TENEDOR  

      public function getReporte15($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$tenedor_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) AND r.cliente_id IN($cliente_id) AND m.tenedor_id IN($tenedor_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CONDUCTOR - CLIENTE - TENEDOR 
  
      public function getReporte16($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$tenedor_id,$vehiculo_id,$Conex){ 

		  $select = "SELECT r.numero_remesa,r.fecha_remesa,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente cl, tercero t 
		  WHERE cl.cliente_id = r.cliente_id AND cl.tercero_id=t.tercero_id) AS cliente,		  
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
		  (SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,conductor c WHERE c.conductor_id=m.conductor_id AND t.tercero_id = c.tercero_id) AS conductor,		  
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
		  FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
		  r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado, r.clase_remesa,m.manifiesto,		  
		  (SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS vehiculo
		  FROM remesa r, detalle_despacho dd, manifiesto m
		  WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)
		  AND m.conductor_id IN($conductor_id) AND r.cliente_id IN($cliente_id) AND m.tenedor_id IN($tenedor_id) AND m.placa_id IN($vehiculo_id) ORDER BY cliente,r.fecha_remesa";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  
		  foreach($results as $items){
		  
		  $result[$i]=array(numero_remesa=>$items[numero_remesa],fecha_remesa=>$items[fecha_remesa],cliente=>$items[cliente],
		  origen=>$items[origen],destino=>$items[destino],descripcion_producto=>$items[descripcion_producto],conductor=>$items[conductor],
		  peso=>$items[peso],cantidad=>$items[cantidad],valor=>$items[valor],estado=>$items[estado],clase_remesa=>$items[clase_remesa],
		  tenedor=>$items[tenedor],manifiesto=>$items[manifiesto],vehiculo=>$items[vehiculo]);	
		  $i++;
		  }
		  
		  return $result;
  }  // REPORTE CONDUCTOR - CLIENTE - TENEDOR - VEHICULO 

}

?>