<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteAnticiposModel extends Db{

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

   public function GetTipo($Conex){
	$opciones=array(0=>array('value'=>'MC','text'=>'MANIFIESTO'),1=>array('value'=>'DU','text'=>'DESPACHOS URBANOS'),2 =>array('value'=>'DP','text'=>'DESPACHOS PARTICULARES'));
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
    public function GetSi_Pro2($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
  public function getReporteMC1($oficina_id,$desde,$hasta,$Conex){ 	   	
 
	    $select = "SELECT 'MC' AS tipo_documento, m.manifiesto AS numero_documento, m.fecha_mc AS fecha_manifiesto, 
		CASE m.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_manifiesto,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, date(am.fecha_egreso) AS fecha_anticipo,		 
		IF(am.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
		m.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
		WHERE encabezado_registro_id = am.encabezado_registro_id) AS estado_encabezado FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' ORDER BY m.placa_id";		  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  } 
  
  public function getReporteDU1($oficina_id,$desde,$hasta,$Conex){ 
	   	
  	    $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
		CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
		IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
		WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
		AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' ORDER BY du.placa_id";
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
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
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;	  
   }  
   
  public function getReporteDU2($oficina_id,$desde,$hasta,$tenedor_id,$Conex){
	  		 
  	    $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
		CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
		IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
		WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
		AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.tenedor_id IN ($tenedor_id) ORDER BY du.placa_id";	
		  
		//echo $select;		  
		$results = $this -> DbFetchAll($select,$Conex);
		return $results;	  
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
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;	  
	}
	
  public function getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento, du.despacho AS numero_documento, du.fecha_du AS fecha_despacho, 
	  CASE du.estado WHEN 'L' THEN 'LIQUIDADO' WHEN 'A' THEN 'ANULADO' WHEN 'M' THEN 'MANIFESTADO' WHEN 'P' THEN 'PENDIENTE' END AS estado_despacho,
	  (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, date(adu.fecha_egreso) AS fecha_anticipo,		 
	  IF(adu.encabezado_registro_id >= 0,'SI','NO') AS contabilizado, adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
	  du.placa AS placa, (SELECT IF(estado ='C','CONTABILIZADO','ANULADO') AS estado_encabezado FROM encabezado_de_registro 
	  WHERE encabezado_registro_id = adu.encabezado_registro_id) AS estado_encabezado FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) ORDER BY du.placa_id";
		  
		  //echo $select;
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;	  
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
		  
	 // echo $select;
	 $results = $this -> DbFetchAll($select,$Conex);
	  return $results;	  
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
		return $results;	  
	}
	
  public function getReporteDP4($oficina_id,$desde,$hasta,$Conex){	   	
		 return NULL;
  }	   

}

?>