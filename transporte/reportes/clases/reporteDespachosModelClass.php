<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteDespachosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getOficinas($empresa_id,$oficina_id,$Conex){  
  
   $select = "SELECT oficina_id AS value, nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id";
   $result = $this -> DbFetchAll($select,$Conex);	  
   return $result;	  	    
   
  }  
  
  public function selectInformacionRemesas($empresa_id,$oficina_id,$Conex){
  
    $fecha_inicio       = $this -> requestData('fecha_inicio');
    $fecha_final        = $this -> requestData('fecha_final');
    $opciones_conductor = $this -> requestData('opciones_conductor');
    $conductor_id       = $this -> requestData('conductor_id');
    $opciones_placa     = $this -> requestData('opciones_placa');
    $placa_id           = $this -> requestData('placa_id');		
    $opciones_oficinas  = $this -> requestData('opciones_oficinas');	
    $oficina_id         = $this -> requestData('oficina_id');
    $opciones_estado    = $this -> requestData('opciones_estado');	
    $estado             = $this -> requestData('estado');
	
	if($opciones_conductor == 'U'){
	 $condicionConductor = " AND m.conductor_id IN ($conductor_id) ";
	}else{
	    $condicionConductor = null;
	  }	  
	  
	if($opciones_placa == 'U'){
	 $condicionPlaca = " AND m.placa_id IN ($placa_id) ";
	}else{
	    $condicionPlaca = null;
	  }	  	  

	$condicionOficinas = " AND m.oficina_id IN ($oficina_id) ";	  

	$estado            = str_replace(',',"','",$estado);
	$condicionEstado   = " AND m.estado IN ('$estado')";
	
    $select = "SELECT m.manifiesto_id,m.oficina, 
m.placa,m.conductor,m.numero_identificacion,m.tenedor,m.numero_identificacion_tenedor,m.manifiesto,m.nacional,m.propio,m.estado,m.fecha_planilla,l.lugar_autorizado_pago,m.origen,m.destino,m.numero_anticipos,l.fecha_liquidacion,IF(l.valor_despacho > 0,l.valor_despacho,m.valor_flete) AS valor_total,m.observacion_anulacion,IF(l.saldo_por_pagar > 0,l.saldo_por_pagar,m.saldo_por_pagar) AS saldo_por_pagar FROM (SELECT m.manifiesto_id,om.nombre AS oficina, m.placa,m.nombre AS conductor,m.numero_identificacion,m.tenedor,m.numero_identificacion_tenedor,m.manifiesto,'SI' AS nacional,IF(m.propio = 1,'SI','NO') AS propio,IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,m.fecha_mc AS fecha_planilla,op.nombre AS lugar_autorizado_pago,og.nombre AS origen,dt.nombre AS destino,(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id) AS numero_anticipos,m.valor_flete,m.observacion_anulacion,m.saldo_por_pagar FROM manifiesto m, oficina om, oficina op, ubicacion og, 
ubicacion dt WHERE m.fecha_mc BETWEEN '$fecha_inicio' AND '$fecha_final' $condicionPlaca $condicionConductor $condicionOficinas $condicionEstado AND m.oficina_id = om.oficina_id AND m.oficina_pago_saldo_id = op.oficina_id AND og.ubicacion_id = m.origen_id AND dt.ubicacion_id = m.destino_id) m LEFT JOIN (SELECT m.manifiesto_id,(ld.valor_despacho+ld.valor_sobre_flete) AS valor_despacho,ld.saldo_por_pagar,ld.fecha AS fecha_liquidacion,op.nombre AS lugar_autorizado_pago FROM liquidacion_despacho ld, manifiesto m, oficina op WHERE ld.manifiesto_id = m.manifiesto_id AND ld.oficina_id = op.oficina_id AND m.fecha_mc BETWEEN '$fecha_inicio' AND '$fecha_final' $condicionConductor $condicionOficinas $condicionEstado) l ON m.manifiesto_id = l.manifiesto_id ORDER BY m.oficina,m.fecha_planilla ASC";	 
	 	 
     $data      = $this -> DbFetchAll($select,$Conex,true);
	 
	 $select    = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";  
	 $impuestos = $this -> DbFetchAll($select,$Conex,true);		  
	  
	 for($i = 0; $i < count($impuestos); $i++){
	 
	   $comparar = $impuestos[$i]['nombre'];	  		   	  	  	  
	   $nombre   = strtoupper(preg_replace( "([ ]+)", "", str_replace('%','',$impuestos[$i]['nombre'])));	
	   
	   $impuestos[$i]['comparar'] = $nombre;	  		   	  	  	  
	   	   
	   for($j = 0; $j < count($data); $j++){
	 
	     $manifiesto_id = $data[$j]['manifiesto_id'];
		 		 
	     $select  = "SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND impuestos_manifiesto_id IN (SELECT impuestos_manifiesto_id 
	     FROM impuestos_manifiesto ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.manifiesto_id = $manifiesto_id)";	 		 
		 
	     $impuesto = $this -> DbFetchAll($select,$Conex,true);		  		 
		 
		 if($impuesto[0]['valor'] > 0){
		   $data[$j][$nombre] = $impuesto[0]['valor'];	   	 		 
		 }else{
		 
	         $select   = "SELECT SUM(valor) AS valor FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar'))";	 	 		
	         $impuesto = $this -> DbFetchAll($select,$Conex,true);	
			 
		     $data[$j][$nombre] = $impuesto[0]['valor'];
		 
		   }
	 
	    }	   	   
	   
	 }	  
	 
	 for($i = 0; $i < count($data); $i++){
	 
	   $manifiesto_id = $data[$i]['manifiesto_id'];
	   
	   $select    = "SELECT SUM(valor) AS valor FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
       $anticipos = $this -> DbFetchAll($select,$Conex,true);	   
	   
	   $data[$i]['anticipos'] = $anticipos[0]['valor'];
		
	 }		 
	 
     $select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
	 $descuentos = $this -> DbFetchAll($select,$Conex,true);	
	  
	 for($i = 0; $i < count($descuentos); $i++){
	 
	   $comparar = $descuentos[$i]['nombre'];	 	  
	   $nombre   = strtoupper(str_replace('.','',preg_replace( "([ ]+)", "",$descuentos[$i]['nombre'])));	  	  	   	  	  		 
	   
       $descuentos[$i]['comparar'] = $comparar;	   
	   
	   for($j = 0; $j < count($data); $j++){
	   
	     $manifiesto_id = $data[$j]['manifiesto_id'];
		 
	     $select = "SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE descuento = 1 AND descuentos_manifiesto_id IN (SELECT descuentos_manifiesto_id 
	     FROM descuentos_manifiesto dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.manifiesto_id = $manifiesto_id)";			 
		 
	 	 $descuento = $this -> DbFetchAll($select,$Conex,true);	
		 
		 if($descuento[0]['valor'] > 0){		 
		   $data[$j][$nombre] = $descuento[0]['valor'];		 
		 }else{
		 
 	          $select    = "SELECT SUM(valor) AS valor FROM descuentos_manifiesto WHERE manifiesto_id = $manifiesto_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar'))";					
	 	      $descuento = $this -> DbFetchAll($select,$Conex,true);			 
		 
		      $data[$j][$nombre] = $descuento[0]['valor'];		 
			  
		   }
	   
//         $data[$j]['saldo_pagar'] = $data[$j]['saldo_por_pagar'];	   
//   	   unset($data[$j]['saldo_por_pagar']);
	   }
	   
	 }	 	 
	 	 
    $select = "SELECT m.despachos_urbanos_id,m.oficina, m.placa,m.conductor,m.numero_identificacion,m.tenedor,m.numero_identificacion_tenedor,m.manifiesto,m.nacional,m.propio,m.estado,m.fecha_planilla,l.lugar_autorizado_pago,m.origen,m.destino,m.numero_anticipos,l.fecha_liquidacion,IF(l.valor_despacho > 0,l.valor_despacho,m.valor_flete) AS valor_total,m.observacion_anulacion,IF(l.saldo_por_pagar > 0,l.saldo_por_pagar,m.saldo_por_pagar) AS saldo_por_pagar FROM (SELECT m.despachos_urbanos_id,om.nombre AS oficina, m.placa,m.nombre AS conductor,m.numero_identificacion,m.tenedor,m.numero_identificacion_tenedor,m.despacho AS manifiesto,'NO' AS nacional,IF(m.propio = 1,'SI','NO') AS propio,IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,m.fecha_du AS fecha_planilla,op.nombre AS lugar_autorizado_pago,og.nombre AS origen,dt.nombre AS destino,(SELECT GROUP_CONCAT(consecutivo) 
	 FROM anticipos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id) AS numero_anticipos,m.valor_flete,m.observacion_anulacion,m.saldo_por_pagar FROM despachos_urbanos m, oficina om, oficina op, ubicacion og, ubicacion dt WHERE m.fecha_du BETWEEN '$fecha_inicio' AND '$fecha_final' $condicionPlaca $condicionConductor $condicionOficinas $condicionEstado AND m.oficina_id = om.oficina_id AND m.oficina_pago_saldo_id = op.oficina_id AND og.ubicacion_id = m.origen_id AND dt.ubicacion_id = m.destino_id) m LEFT JOIN (SELECT m.despachos_urbanos_id,(ld.valor_despacho+ld.valor_sobre_flete) AS valor_despacho,ld.saldo_por_pagar,ld.fecha AS fecha_liquidacion,op.nombre AS lugar_autorizado_pago FROM liquidacion_despacho ld, despachos_urbanos m, oficina op WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND ld.oficina_id = op.oficina_id AND m.fecha_du BETWEEN '$fecha_inicio' AND '$fecha_final' $condicionConductor $condicionOficinas $condicionEstado) l ON m.despachos_urbanos_id = l.despachos_urbanos_id ORDER BY m.oficina,m.fecha_planilla ASC";	 
	 	 
     $data2 = $this -> DbFetchAll($select,$Conex,true);	 
	 
	 $select    = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";  
	 $impuestos = $this -> DbFetchAll($select,$Conex,true);		  
	  
	 for($i = 0; $i < count($impuestos); $i++){
	 
	   $comparar = $impuestos[$i]['nombre'];	  		   	  	  	  
	   $nombre   = strtoupper(preg_replace( "([ ]+)", "", str_replace('%','',$impuestos[$i]['nombre'])));	
	   
	   $impuestos[$i]['comparar'] = $nombre;	  		   	  	  	  
	   	   
	   for($j = 0; $j < count($data2); $j++){
	 
	     $despachos_urbanos_id = $data2[$j]['despachos_urbanos_id'];
		 		 
	     $select  = "SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND impuestos_despacho_id IN (SELECT impuestos_despacho_id 
	     FROM impuestos_despacho ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.despachos_urbanos_id = $despachos_urbanos_id)";	 		 
		 
	     $impuesto = $this -> DbFetchAll($select,$Conex,true);		  		 
		 
		 if($impuesto[0]['valor'] > 0){
		   $data2[$j][$nombre] = $impuesto[0]['valor'];	   	 		 
		 }else{
		 
	         $select   = "SELECT SUM(valor) AS valor FROM impuestos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar'))";	 	 		
	         $impuesto = $this -> DbFetchAll($select,$Conex,true);	
			 
		     $data2[$j][$nombre] = $impuesto[0]['valor'];	   	 		 			 	  		 		     
		 
		   }
	 
	   }	   	   
	   
	 }	  
	 
	 for($i = 0; $i < count($data2); $i++){
	 
	   $despachos_urbanos_id = $data2[$i]['despachos_urbanos_id'];
	   
	   $select    = "SELECT SUM(valor) AS valor FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
       $anticipos = $this -> DbFetchAll($select,$Conex,true);	   
	   
	   $data2[$i]['anticipos'] = $anticipos[0]['valor'];
		
	 }		 
	 
     $select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
	 $descuentos = $this -> DbFetchAll($select,$Conex,true);	
	  
	 for($i = 0; $i < count($descuentos); $i++){
	 
	   $comparar = $descuentos[$i]['nombre'];	 	  
	   $nombre   = strtoupper(str_replace('.','',preg_replace( "([ ]+)", "",$descuentos[$i]['nombre'])));	  	  	   	  	  		 
	   
       $descuentos[$i]['comparar'] = $comparar;	   
	   
	   for($j = 0; $j < count($data2); $j++){
	   
	     $manifiesto_id = $data2[$j]['manifiesto_id'];
		 
	     $select = "SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE descuento = 1 AND descuentos_despacho_id IN (SELECT descuentos_despacho_id 
	     FROM descuentos_despacho dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.despachos_urbanos_id = $despachos_urbanos_id)";			 
		 
	 	 $descuento = $this -> DbFetchAll($select,$Conex,true);	
		 
		 if($descuento[0]['valor'] > 0){		 
		   $data2[$j][$nombre] = $descuento[0]['valor'];		 
		 }else{
		 
 	          $select    = "SELECT SUM(valor) AS valor FROM descuentos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id AND UPPER(TRIM(nombre)) 

			                = UPPER(TRIM('$comparar'))";					
	 	      $descuento = $this -> DbFetchAll($select,$Conex,true);			 
		 
		      $data2[$j][$nombre] = $descuento[0]['valor'];		 
			  
		   }
	   
//	   	 $data2[$j]['saldo_pagar'] = $data2[$j]['saldo_por_pagar'];
	   
	//   unset($data2[$j]['saldo_por_pagar']);

	   }
	   
	 }	 		 
	 		 
	 $arrayResult = array();
	 
	 if(is_array($data) && is_array($data2)){
	   $arrayResult = array_merge($data,$data2);
	 }else if(is_array($data) && !is_array($data2)){
	     $arrayResult = $data;	 
	   }else if(!is_array($data) && is_array($data2)){
	       $arrayResult = $data2;	 	   
	     }		 
			 
	 return  array(data => $arrayResult, impuestos => $impuestos, descuentos => $descuentos);
  
  }        
   
}

?>