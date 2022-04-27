<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesEdadesModel extends Db{

  private $Permisos;
  
  public function getReporteMC1($oficina_id,$desde,$hasta,$Conex){


	    $select = "SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.fecha_mc BETWEEN '$desde' AND '$hasta' ORDER BY placa DESC";
		//echo $select;
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		if ($items[estado_anticipo]=='PENDIENTE'){
			$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
			numero_egreso=>$items[numero_egreso],oficina=>$items[oficina],dias=>$items[dias],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],			placa=>$items[placa]);
				$i++;
				}
		}
		
		return $result;
  } 
  
 
  
  public function getReporteDU1($oficina_id,$desde,$hasta,$Conex){ 
  
  	    $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta' ORDER BY du.placa_id DESC";
		//echo $select;
		
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
	if ($items[estado_anticipo]=='PENDIENTE'){
		$result[$i]=array(tipo_documento=>$items[tipo_documento],estado_anticipo=>$items[estado_anticipo],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
		numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],
		oficina=>$items[oficina],dias=>$items[dias]);
		$i++;}
		}
	  
		  return $result;
  } 
  
  public function getReporteDP1($oficina_id,$desde,$hasta,$Conex){ 	   	
		  return NULL;
  }   
  
  public function getReporteMC2($oficina_id,$desde,$hasta,$tenedor_id,$Conex){
	  
	  $select = "SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento, 
	   IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
	   (SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, 		
		date(am.fecha_egreso) AS fecha_anticipo,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa
	  FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN ($tenedor_id) ORDER BY m.placa_id ";	  
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	  if ($items[estado_anticipo]=='PENDIENTE'){
		$result[$i]=array(tipo_documento=>$items[tipo_documento],estado_anticipo=>$items[estado_anticipo],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
		numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],oficina=>$items[oficina],
		dias=>$items[dias]);
		$i++;}
	  }
	  
	  return $result;	  
   }  
   
  public function getReporteDU2($oficina_id,$desde,$hasta,$tenedor_id,$Conex){
	  		 
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 		
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 		
		date(adu.fecha_egreso) AS fecha_anticipo,							
		 adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.tenedor_id IN ($tenedor_id) ORDER BY du.placa_id DESC";
	  
	  //echo $select;
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	if ($items[estado_anticipo]=='PENDIENTE'){  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],
	  dias=>$items[dias],oficina=>$items[oficina]);
	  $i++;}
	  }
		
		return $result;	  
   } 
   
  public function getReporteDP2($oficina_id,$desde,$hasta,$Conex){ 	   	
		  return NULL;
  }   

  public function getReporteMC3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, 
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		date(am.fecha_egreso) AS fecha_anticipo,			
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor
	  FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id DESC";		 
		  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	if ($items[estado_anticipo]=='PENDIENTE'){	  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],estado_anticipo=>$items[estado_anticipo],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],oficina=>$items[oficina],
	  dias=>$items[dias]);
	  $i++;}
	  }
		  
		  return $result;	  
	}
	
  public function getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 		
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, 
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias

		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) ORDER BY du.placa_id";
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	  if ($items[estado_anticipo]=='PENDIENTE'){	
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo], tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],
	  dias=>$items[dias],oficina=>$items[oficina]);
	  $i++;}
	  }		
		return $result;	  
   } 
	
  public function getReporteDP3($oficina_id,$desde,$hasta,$Conex){ 	   	
		 return NULL;
  }	
 
  public function getReporteMC4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	 
	  $select = "SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento, 
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
        (SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso, 
		date(am.fecha_egreso) AS fecha_anticipo,	
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor, 
		m.placa AS placa,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina
	  FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
	  AND m.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN($tenedor_id) AND m.placa_id IN($vehiculo_id) ORDER BY m.placa_id";		  
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
	if ($items[estado_anticipo]=='PENDIENTE'){	  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],estado_anticipo=>$items[estado_anticipo],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],oficina=>$items[oficina],
	  dias=>$items[dias]);
	  $i++;}
	  }
		 return $result;	  
	}
	
  public function getReporteDU4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	 
	  $select = "SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 		
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa, 
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
	  
	  FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	  AND du.despachos_urbanos_id = du.despachos_urbanos_id AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) AND du.tenedor_id IN($tenedor_id) ORDER BY du.placa_id";	
	  
	  $results = $this -> DbFetchAll($select,$Conex);
	  $i=0;
	  foreach($results as $items){
		  
	  $result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
	  numero_egreso=>$items[numero_egreso],fecha_anticipo=>$items[fecha_anticipo], tenedor=>$items[tenedor],valor=>$items[valor],placa=>$items[placa],
	  dias=>$items[dias],oficina=>$items[oficina]);
	  $i++;
	  }
		  return $result;	  
	}
	
    public function getReporteALL1($oficina_id,$desde,$hasta,$Conex){
	   
	   $select = "(SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.fecha_mc BETWEEN '$desde' AND '$hasta')
	   UNION ALL
	   (SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta')
	   ORDER BY placa DESC";
		//echo $select;
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		if ($items[estado_anticipo]=='PENDIENTE'){
			$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
			numero_egreso=>$items[numero_egreso],oficina=>$items[oficina],dias=>$items[dias],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],			placa=>$items[placa]);
				$i++;
				}
		}
	   return $result;	  
   }	

	
	 public function getReporteALL2($oficina_id,$desde,$hasta,$tenedor_id,$Conex){
	   
	   $select = "(SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.tenedor_id IN($tenedor_id))
	   UNION ALL
	   (SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso, 
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.tenedor_id IN($tenedor_id))
	   ORDER BY placa DESC";
		//echo $select;
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		if ($items[estado_anticipo]=='PENDIENTE'){
			$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
			numero_egreso=>$items[numero_egreso],oficina=>$items[oficina],dias=>$items[dias],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],			placa=>$items[placa]);
				$i++;
				}
		}
	   return $result;	  
   }	
   
   
    public function getReporteALL3($oficina_id,$desde,$hasta,$vehiculo_id,$Conex){
	   
	   $select = "(SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.placa_id IN($vehiculo_id))
	   UNION ALL
	   (SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso,
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id)) 
	   ORDER BY placa DESC";
		//echo $select;
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		if ($items[estado_anticipo]=='PENDIENTE'){
			$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
			numero_egreso=>$items[numero_egreso],oficina=>$items[oficina],dias=>$items[dias],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],			placa=>$items[placa]);
				$i++;
				}
		}
	   return $result;	  
   }	
   
   public function getReporteALL4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$Conex){
	   
	   $select = "(SELECT 'MC' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewMC(',m.manifiesto_id,')\">',m.manifiesto,'</a>' ) ) AS numero_documento,		
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = am.encabezado_registro_id) AS numero_egreso,
		IF(am.estado='A','ANULADO',IF(am.legalizacion_manifiesto_id>0 OR am.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		(SELECT nombre FROM oficina  WHERE oficina_id=am.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),am.fecha_egreso) AS dias,		
		date(am.fecha_egreso) AS fecha_anticipo,
		(SELECT placa FROM vehiculo WHERE placa_id=m.placa_id) AS placa,
		am.tenedor AS tenedor, am.conductor AS conductor, am.valor AS valor		
		FROM anticipos_manifiesto am ,manifiesto m WHERE am.manifiesto_id = m.manifiesto_id 
		AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.placa_id IN($vehiculo_id) AND m.tenedor_id IN($tenedor_id))
	   UNION ALL
	   (SELECT 'DU' AS tipo_documento,(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDU(',du.despachos_urbanos_id,')\">',du.despacho,'</a>' ) ) AS numero_documento, 
		(SELECT CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',encabezado_registro_id,')\">',consecutivo,'</a>' ) FROM encabezado_de_registro WHERE encabezado_registro_id = adu.encabezado_registro_id) AS numero_egreso,
		IF(adu.estado='A','ANULADO',IF(adu.legalizacion_despacho_id>0 OR adu.detalle_liquidacion_despacho_id>0,'LEGALIZADO','PENDIENTE'))as estado_anticipo,
		
		date(adu.fecha_egreso) AS fecha_anticipo,	
		adu.tenedor AS tenedor, adu.conductor AS conductor, adu.valor AS valor, 
		du.placa AS placa,
		(SELECT nombre FROM oficina  WHERE oficina_id=adu.oficina_id) AS oficina,
		DATEDIFF(CURDATE(),adu.fecha_egreso) AS dias
		
		FROM anticipos_despacho adu ,despachos_urbanos du WHERE adu.despachos_urbanos_id = du.despachos_urbanos_id 
	    AND du.fecha_du BETWEEN '$desde' AND '$hasta' AND du.placa_id IN($vehiculo_id) AND du.tenedor_id IN($tenedor_id))
	   ORDER BY placa DESC";
		//echo $select;
		$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
		if ($items[estado_anticipo]=='PENDIENTE'){
			$result[$i]=array(tipo_documento=>$items[tipo_documento],numero_documento=>$items[numero_documento],conductor=>$items[conductor],
			numero_egreso=>$items[numero_egreso],oficina=>$items[oficina],dias=>$items[dias],fecha_anticipo=>$items[fecha_anticipo],tenedor=>$items[tenedor],valor=>$items[valor],			placa=>$items[placa]);
				$i++;
				}
		}
	   return $result;	  
   }	
	
	
}

?>