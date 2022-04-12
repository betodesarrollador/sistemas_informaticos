<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleLiquidacionRemesasModel extends Db{

  private $Permisos;
    
  public function Update($remesa_id,$valor_facturar,$Conex){
    
    $remesa_id             = $this -> requestDataForQuery('remesa_id','integer'); 
	$orden_despacho     = $this -> requestDataForQuery('orden_despacho','text'); 
	$tipo_liquidacion      = $this -> requestDataForQuery('tipo_liquidacion','integer'); 
	$valor_unidad_facturar = $this -> requestDataForQuery('valor_unidad_facturar','integer'); 
    $valor_facturar	       = $this -> requestDataForQuery('valor_facturar','integer'); 
	
    $update         = "UPDATE remesa SET estado= 'LQ',tipo_liquidacion='$tipo_liquidacion',valor_unidad_facturar=$valor_unidad_facturar,
	                   valor_facturar=$valor_facturar,orden_despacho=$orden_despacho WHERE remesa_id = $remesa_id";
	
    $this -> query($update,$Conex,true);

  }
  
  
  public function getDetallesDespacho($Conex){
  
	$manifiesto_despacho_id = $this -> requestDataForQuery('manifiesto_despacho_id','integer');
	$tipo                   = $this -> requestDataForQuery('tipo','integer');
	
	if(is_numeric($manifiesto_despacho_id)){
	
	    if($tipo == 'MANIFIESTO'){
		
		   $select = "SELECT r.remesa_id,r.numero_remesa,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) 
		   AS cliente,r.remitente,r.destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id 
		   = r.destino_id) AS destino,(SELECT producto_empresa FROM producto WHERE producto_id = r.producto_id) AS  descripcion_producto,(SELECT medida FROM medida WHERE 
		   medida_id = r.medida_id) AS unidad,r.cantidad,r.peso,r.tipo_liquidacion,r.valor_unidad_facturar,r.valor_facturar,r.orden_despacho FROM remesa r WHERE 
		   remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = $manifiesto_despacho_id)";	
		   
	  	   $result = $this -> DbFetchAll($select,$Conex,true);				
		
		}else{
		
		    $select = "SELECT r.remesa_id,r.numero_remesa,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) 
		   AS cliente,r.remitente,r.destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id 
		   = r.destino_id) AS destino,(SELECT producto_empresa FROM producto WHERE producto_id = r.producto_id) AS descripcion_producto,(SELECT medida FROM medida WHERE 
		   medida_id = r.medida_id) AS unidad, r.cantidad,r.peso,r.tipo_liquidacion,r.valor_unidad_facturar,r.valor_facturar,r.orden_despacho FROM remesa r WHERE remesa_id 
		   IN (SELECT remesa_id  FROM detalle_despacho WHERE despachos_urbanos_id = $manifiesto_despacho_id)";	
		   
	  	    $result = $this -> DbFetchAll($select,$Conex,true);		
		
		  }
		  	  
	}else{
   	    $result = array();
	  }	  
	  
	return $result;
  }
  
   
}

?>