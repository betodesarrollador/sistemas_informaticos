<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesAnticiposModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($oficina_id,$desde,$hasta,$Conex){ 

	    $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
		CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
		IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
		m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
		WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' ORDER BY m.placa_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_manifiesto=>$items[fecha_manifiesto],conductor=>$items[conductor],
		numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_manifiesto=>$items[estado_manifiesto],contabilizado=>$items[contabilizado],
		tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
		$i++;
		}
		
		return $result;
  } 
  
  public function getReporteDU1($oficina_id,$desde,$hasta,$Conex){ 
  
  	    $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
		CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
		IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
		WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
		AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' ORDER BY du.placa_id";
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		
		$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_despacho=>$items[fecha_despacho],conductor=>$items[conductor],
		numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_despacho=>$items[estado_despacho],contabilizado=>$items[contabilizado],
		tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
		$i++;
		}
	  
		  return $result;
  } 
  
  public function getReporteDP1($oficina_id,$desde,$hasta,$Conex){ 	   	
		  return NULL;
  }   
  
  public function getReporteMC2($oficina_id,$desde,$hasta,$tenedor_id,$Conex){
	  
	  $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
	  CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
	  IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
	  m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN ($tenedor_id) ORDER BY m.placa_id";	  
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	  
		$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_manifiesto=>$items[fecha_manifiesto],conductor=>$items[conductor],
		numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_manifiesto=>$items[estado_manifiesto],contabilizado=>$items[contabilizado],
		tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
		$i++;
	  }
	  
	  return $result;	  
   }  
   
  public function getReporteDU2($oficina_id,$desde,$hasta,$tenedor_id,$Conex){
	  		 
	  $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
	  IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
	  du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.tenedor_id IN ($tenedor_id) ORDER BY du.placa_id";
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_despacho=>$items[fecha_despacho],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_despacho=>$items[estado_despacho],contabilizado=>$items[contabilizado],
	  tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
	  $i++;
	  }
		
		return $result;	  
   } 
   
  public function getReporteDP2($oficina_id,$desde,$hasta,$Conex){ 	   	
		  return NULL;
  }   

  public function getReporteMC3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
	  CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
	  IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
	  m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id";		 
		  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
		  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_manifiesto=>$items[fecha_manifiesto],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_manifiesto=>$items[estado_manifiesto],contabilizado=>$items[contabilizado],
	  tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
	  $i++;
	  }
		  
		  return $result;	  
	}
	
  public function getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
	  IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
	  du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) ORDER BY du.placa_id";
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_despacho=>$items[fecha_despacho],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_despacho=>$items[estado_despacho],contabilizado=>$items[contabilizado],
	  tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
	  $i++;
	  }		
		return $result;	  
   } 
	
  public function getReporteDP3($oficina_id,$desde,$hasta,$Conex){ 	   	
		 return NULL;
  }	
 
  public function getReporteMC4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
	  CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
	  IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
	  m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN($tenedor_id) AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id";		  
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
		  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_manifiesto=>$items[fecha_manifiesto],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_manifiesto=>$items[estado_manifiesto],contabilizado=>$items[contabilizado],
	  tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
	  $i++;
	  }
		 return $result;	  
	}
	
  public function getReporteDU4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
	  IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
	  du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) AND du.tenedor_id IN($tenedor_id) ORDER BY du.placa_id";	
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
		  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],fecha_despacho=>$items[fecha_despacho],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],estado_despacho=>$items[estado_despacho],contabilizado=>$items[contabilizado],
	  tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],estado_encabezado=>$items[estado_encabezado]);
	  $i++;
	  }
		  return $result;	  
	}
	
  public function getReporteDP4($oficina_id,$desde,$hasta,$Conex){	   	
		 return NULL;
	}	

}

?>