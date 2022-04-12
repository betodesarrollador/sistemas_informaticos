<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidacionesManifiestosModel extends Db{
  
   public function getColumnsImpGridLiquidacionesManifiestos($Conex){
      
      $select    = "SELECT DISTINCT im.nombre FROM detalle_liquidacion_despacho dl,impuestos_manifiesto im WHERE dl.impuestos_manifiesto_id = im.impuestos_manifiesto_id";
	  $impuestos = $this -> DbFetchAll($select,$Conex,true);		  
	  
	  for($i = 0; $i < count($impuestos); $i++){
	     $impuestos[$i]['comparar'] = $impuestos[$i]['nombre'];	  		   	  	  	  
	     $impuestos[$i]['nombre']   = preg_replace( "([ ]+)", "", str_replace('%','',$impuestos[$i]['nombre']));	
	  }
	  
	  
	  return $impuestos;        
   
   }
   
   
   public function getColumnsDesGridLiquidacionesManifiestos($Conex){
      
      $select     = "SELECT DISTINCT dm.nombre FROM detalle_liquidacion_despacho dl,descuentos_manifiesto dm WHERE dl.descuentos_manifiesto_id = dm.descuentos_manifiesto_id";
	  $descuentos = $this -> DbFetchAll($select,$Conex,true);	
	  
	  for($i = 0; $i < count($descuentos); $i++){
	     $descuentos[$i]['comparar'] = $descuentos[$i]['nombre'];	 	  
	     $descuentos[$i]['nombre']   = preg_replace( "([ ]+)", "",$descuentos[$i]['nombre']);	  	  	   	  	  		 
	  }
	  
	  return $descuentos;        
   
   }
      
//// GRID ////   
  public function getQueryManifiestosGrid($oficina_id,$colsImpuestos,$colsDescuentos){
	   	    
     $columsImpuestos = null;			
	 $colsDescuentos  = null;
	 
	 for($i = 0; $i < count($colsImpuestos); $i++){	 	 	 
	   $column           = $colsImpuestos[$i]['nombre'];
	   $comparar         = $colsImpuestos[$i]['comparar'];
	   $columsImpuestos .= "(SELECT valor FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND impuestos_manifiesto_id = (SELECT impuestos_manifiesto_id 
	   FROM impuestos_manifiesto ip WHERE TRIM(nombre) = TRIM('$comparar') AND ip.manifiesto_id = m.manifiesto_id)) AS $column,";	 
	 }

	 for($i = 0; $i < count($colsDescuentos); $i++){	 
	   $column             = $colsDescuentos[$i]['nombre'];
	   $comparar           = $colsDescuentos[$i]['comparar'];	   
	   $columnsDescuentos .= "(SELECT valor FROM detalle_liquidacion_despacho WHERE descuento = 1 AND descuentos_manifiesto_id = (SELECT descuentos_manifiesto_id 
	   FROM descuentos_manifiesto dm WHERE TRIM(nombre) = TRIM('$comparar') AND dm.manifiesto_id = m.manifiesto_id)) AS $column,";	 
	 }	 	 
	 
	 $Query = "SELECT m.manifiesto,m.placa,m.numero_identificacion_tenedor,m.tenedor,ld.valor_despacho+ld.valor_sobre_flete AS valor_total,
	 (SELECT SUM(valor) FROM detalle_liquidacion_despacho dld WHERE anticipo = 1 AND LiquidacionesManifiestos_despacho_id = ld.LiquidacionesManifiestos_despacho_id) AS anticipos,$columsImpuestos $columnsDescuentos ld.saldo_por_pagar
	 FROM LiquidacionesManifiestos_despacho ld, manifiesto m WHERE ld.manifiesto_id = m.manifiesto_id";
     
   
     return $Query;
   }
   

}


?>