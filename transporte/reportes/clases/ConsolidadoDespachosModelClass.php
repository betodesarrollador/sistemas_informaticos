<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ConsolidadoDespachosModel extends Db{

   public function getColumnsImpGridConsolidadoDespachos($Conex){
      
	  $select    = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";  
	  $impuestos = $this -> DbFetchAll($select,$Conex,true);		  
	  
	  for($i = 0; $i < count($impuestos); $i++){
	     $impuestos[$i]['comparar'] = $impuestos[$i]['nombre'];	  		   	  	  	  
	     $impuestos[$i]['nombre']   = strtoupper(preg_replace( "([ ]+)", "", str_replace('%','',$impuestos[$i]['nombre'])));	
	  }	  
	  
	  return $impuestos;        
   
   }
   
   
   public function getColumnsDesGridConsolidadoDespachos($Conex){
 
      $select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
	  $descuentos = $this -> DbFetchAll($select,$Conex,true);	
	  
	  for($i = 0; $i < count($descuentos); $i++){
	     $descuentos[$i]['comparar'] = $descuentos[$i]['nombre'];	 	  
	     $descuentos[$i]['nombre']   = strtoupper(str_replace('.','',preg_replace( "([ ]+)", "",$descuentos[$i]['nombre'])));	  	  	   	  	  		 
	  }
	  	 	 
	  return $descuentos;        
   
   }
      
//// GRID ////   
  public function getQueryManifiestosGrid($oficina_id,$colsImpuestos,$colsDescuentos){
	   
	 $columnsImpuestos  = null;  
	 $columnsDescuentos = null;
	   	     	 
	 for($i = 0; $i < count($colsImpuestos); $i++){	 	 	 
	   $column            = $colsImpuestos[$i]['nombre'];
	   $comparar          = $colsImpuestos[$i]['comparar'];
	   $columnsImpuestos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND impuestos_manifiesto_id IN (SELECT impuestos_manifiesto_id 
	   FROM impuestos_manifiesto ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.manifiesto_id = m.manifiesto_id)) AS $column,";	 
	 }

	 for($i = 0; $i < count($colsDescuentos); $i++){	 
	   $column             = $colsDescuentos[$i]['nombre'];
	   $comparar           = $colsDescuentos[$i]['comparar'];	   
	   $columnsDescuentos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho WHERE descuento = 1 AND descuentos_manifiesto_id IN (SELECT descuentos_manifiesto_id 
	   FROM descuentos_manifiesto dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.manifiesto_id = m.manifiesto_id)) AS $column,";	 
	 }	 	 
	 
    $Query1 = "SELECT om.nombre AS oficina, m.manifiesto,IF(m.propio = 1,'SI','NO') AS propio,'SI' AS nacional,IF(m.estado 
	= 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,m.fecha_mc AS fecha_manifiesto,ld.fecha AS fecha_liquidacion,op.nombre 
	AS lugar_autorizado_pago, m.placa,m.numero_identificacion_tenedor,m.tenedor,m.numero_identificacion,m.nombre AS conductor,og.nombre AS origen,dt.nombre AS destino,(ld.valor_despacho+ld.valor_sobre_flete) AS 
	valor_total,(SELECT SUM(valor) FROM detalle_liquidacion_despacho dld WHERE anticipo = 1 AND liquidacion_despacho_id = ld.liquidacion_despacho_id) AS anticipos,$columnsImpuestos    $columnsDescuentos ld.saldo_por_pagar FROM liquidacion_despacho ld, manifiesto m, oficina om, oficina op, ubicacion og, ubicacion dt WHERE ld.manifiesto_id = m.manifiesto_id AND m.oficina_id = om.oficina_id AND m.oficina_pago_saldo_id = op.oficina_id AND og.ubicacion_id = m.origen_id AND dt.ubicacion_id = m.destino_id";
	 
	 $columnsImpuestos  = null;  
	 $columnsDescuentos = null;
	 
	 
	 for($i = 0; $i < count($colsImpuestos); $i++){	 	 	 
	   $column            = $colsImpuestos[$i]['nombre'];
	   $comparar          = $colsImpuestos[$i]['comparar'];
	   $columnsImpuestos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND impuestos_despacho_id IN (SELECT impuestos_despacho_id 
	   FROM impuestos_despacho ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.despachos_urbanos_id = m.despachos_urbanos_id)) AS $column,";	 
	 }

	 for($i = 0; $i < count($colsDescuentos); $i++){	 
	   $column             = $colsDescuentos[$i]['nombre'];
	   $comparar           = $colsDescuentos[$i]['comparar'];	   
	   $columnsDescuentos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho WHERE descuento = 1 AND descuentos_despacho_id IN (SELECT descuentos_despacho_id 
	   FROM descuentos_despacho dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.despachos_urbanos_id = m.despachos_urbanos_id)) AS $column,";	 
	 }	 	 
	 
	$Query2 = "SELECT om.nombre AS oficina,m.despacho AS manifiesto,IF(m.propio = 1,'SI','NO') AS propio,'NO' AS nacional,IF(m.estado = 'P','PENDIENTE',
	IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,m.fecha_du AS fecha_manifiesto,ld.fecha AS fecha_liquidacion,op.nombre AS 
	lugar_autorizado_pago,m.placa,m.numero_identificacion_tenedor,m.tenedor,m.numero_identificacion,m.nombre AS conductor,og.nombre AS origen, dt.nombre AS destino,
	(ld.valor_despacho+ld.valor_sobre_flete) AS valor_total,(SELECT SUM(valor) FROM detalle_liquidacion_despacho dld WHERE anticipo = 1 AND liquidacion_despacho_id = ld.liquidacion_despacho_id) AS anticipos,$columnsImpuestos $columnsDescuentos ld.saldo_por_pagar FROM liquidacion_despacho ld, despachos_urbanos m, ubicacion og, ubicacion dt,oficina op,oficina om WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.destino_id = dt.ubicacion_id AND m.oficina_pago_saldo_id = op.oficina_id AND og.ubicacion_id = m.origen_id AND dt.ubicacion_id = m.destino_id";	
	 	 
	 $columnsImpuestos  = null;  
	 $columnsDescuentos = null;
	   	     	 
	 for($i = 0; $i < count($colsImpuestos); $i++){	 	 	 
	   $column            = $colsImpuestos[$i]['nombre'];
	   $comparar          = $colsImpuestos[$i]['comparar'];
	   $columnsImpuestos .= "(SELECT SUM(valor) FROM impuestos_manifiesto ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.manifiesto_id = m.manifiesto_id) AS $column,";	 
	 }

	 for($i = 0; $i < count($colsDescuentos); $i++){	 
	   $column             = $colsDescuentos[$i]['nombre'];
	   $comparar           = $colsDescuentos[$i]['comparar'];	   
	   $columnsDescuentos .= "(SELECT SUM(valor) FROM descuentos_manifiesto dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.manifiesto_id = m.manifiesto_id) AS $column,";	 
	 }	 	 
	 
	 $Query3 = "SELECT om.nombre AS oficina, m.manifiesto,IF(m.propio = 1,'SI','NO') AS propio,'SI' AS nacional,IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(
	 estado = 'L','LIQUIDADO','ANULADO'))) estado,m.fecha_mc AS fecha_manifiesto,'  ' AS fecha_liquidacion,'  ' AS lugar_autorizado_pago, m.placa,m.numero_identificacion_tenedor,m.tenedor,m.numero_identificacion,m.nombre AS conductor,og.nombre AS origen, dt.nombre AS destino,m.valor_flete AS valor_total,
	 (SELECT SUM(valor) FROM anticipos_manifiesto am
	  WHERE am.manifiesto_id = m.manifiesto_id) AS anticipos,$columnsImpuestos $columnsDescuentos m.saldo_por_pagar
	 FROM manifiesto m,ubicacion og, ubicacion dt,oficina om WHERE m.estado != 'L' AND m.destino_id = dt.ubicacion_id AND og.ubicacion_id = m.origen_id AND dt.ubicacion_id = m.destino_id";
	 	 
	 $columnsImpuestos  = null;  
	 $columnsDescuentos = null;
	   	     	 
	 for($i = 0; $i < count($colsImpuestos); $i++){	 	 	 
	   $column            = $colsImpuestos[$i]['nombre'];
	   $comparar          = $colsImpuestos[$i]['comparar'];
	   $columnsImpuestos .= "(SELECT SUM(valor) FROM impuestos_despacho ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND 
	                         ip.despachos_urbanos_id = m.despachos_urbanos_id) AS $column,";	 
	 }

	 for($i = 0; $i < count($colsDescuentos); $i++){	 
	   $column             = $colsDescuentos[$i]['nombre'];
	   $comparar           = $colsDescuentos[$i]['comparar'];	   
	   $columnsDescuentos .= "(SELECT SUM(valor) FROM descuentos_despacho dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.despachos_urbanos_id = 
	                           m.despachos_urbanos_id) AS $column,";	 
	 }	 	 
	 
	 $Query4 = "SELECT om.nombre AS oficina,m.despacho AS manifiesto,IF(m.propio = 1,'SI','NO') AS propio,'NO' AS nacional,IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,m.fecha_du AS fecha_manifiesto,'  ' AS fecha_liquidacion,'  ' AS lugar_autorizado_pago, m.placa,m.numero_identificacion_tenedor,m.tenedor,m.numero_identificacion,m.nombre AS conductor,og.nombre AS origen, dt.nombre AS destino,m.valor_flete AS valor_total,
	 (SELECT SUM(valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id) AS anticipos,$columnsImpuestos $columnsDescuentos m.saldo_por_pagar
	 FROM despachos_urbanos m,ubicacion og, ubicacion dt,oficina om WHERE m.estado != 'L' AND m.destino_id = dt.ubicacion_id AND og.ubicacion_id = m.origen_id AND dt.ubicacion_id = m.destino_id";	 
	 	   	 
    PRINT  $Query = "($Query1) UNION ALL ($Query2) UNION ALL ($Query3) UNION ALL ($Query4)";exit();
     
   
     return $Query;
   }
   

}


?>