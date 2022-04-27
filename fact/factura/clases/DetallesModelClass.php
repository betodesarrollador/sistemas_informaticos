<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;

  public function aprobacionDian($factura_id,$Conex){

	$select  = "SELECT reportada, 
	                   cufe 
			    FROM factura f WHERE f.factura_id = $factura_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);

	  return $result;

  }
  
  public function getImputacionesContables($factura_id,$fuente_facturacion_cod,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($factura_id)){

	  $select  = "SELECT f.fuente_facturacion_cod,
						 f.factura_id,
						 IF(d.orden_servicio_id>0,'Orden de Servicio',IF(d.remesa_id,'Remesa','Despacho Particular')) AS fuente,
	  					 d.*,
						 (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
						 (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
						 (SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id) AS producto,
						 IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,d.seguimiento_id,(SELECT consecutivo FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id)) ) AS numero
	  		FROM detalle_factura  d, factura f WHERE f.factura_id = $factura_id AND d.factura_id=f.factura_id";

	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }

  public function getImputacionesContablesPreview($concepto_item,$Conex){
	   	
	$item				= str_replace("'","",$concepto_item);
  $item				= explode(',',$item);

  $arrayResult= array();
  $result1 = array();
  $result2 = array();
  $result3 = array();

  foreach($item as $item_id){
	  if($item_id!=''){
		  
		   $item_fr	= explode('-',$item_id);

		   if($item_fr[1]=='OS'){
			  $select = "SELECT
						  CONCAT_WS('-',o.orden_servicio_id,'OS')AS id,
						  'Orden de Servicio' AS fuente,
						  o.consecutivo AS numero,
						  i.desc_item_liquida_servicio AS descripcion,
						  i.cant_item_liquida_servicio AS cantidad,
						  i.valoruni_item_liquida_servicio AS valor_unitario,
						  (i.cant_item_liquida_servicio*i.valoruni_item_liquida_servicio) AS valor_total
						  FROM orden_servicio o, item_liquida_servicio i
						  WHERE o.orden_servicio_id='$item_fr[0]' AND i.orden_servicio_id=o.orden_servicio_id ORDER BY o.consecutivo ASC";
				  $result1 = $this -> DbFetchAll($select,$Conex,true);
				  foreach ($result1 as $item1) {
							  $arrayResult[] = $item1;
						  }
			  
		  }elseif($item_fr[1]=='RM'){

			  $select = "SELECT
						  CONCAT_WS('-',r.remesa_id,'RM')AS id,
						  'Remesa' AS fuente,
						  r.numero_remesa AS numero,
						  CONCAT_WS(' ','SERVICIO FLETES',r.descripcion_producto)AS descripcion,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						  
						  r.cantidad,
						  r.valor_facturar AS valor_unitario,
						  r.valor_facturar AS valor_total	
						  
						  
						  FROM remesa r
						  WHERE r.remesa_id='$item_fr[0]' ORDER BY r.numero_remesa ASC";
						  $result2 = $this -> DbFetchAll($select,$Conex,true);

						  foreach ($result2 as $item2) {
							  $arrayResult[] = $item2;
						  }
						  

		  }elseif($item_fr[1]=='ST'){

			  $select = "SELECT
						  CONCAT_WS('-',r.seguimiento_id,'ST')AS id,
						  r.seguimiento_id,
						  r.origen_id,
						  r.destino_id,
						  r.observaciones,
						  r.valor_facturar
						  FROM seguimiento r
						  WHERE r.seguimiento_id='$item_fr[0]' ORDER BY r.seguimiento_id ASC";
	  
			  $result3 = $this -> DbFetchAll($select,$Conex,true);
			  foreach ($result3 as $item3) {
							  $arrayResult[] = $item3;
						  }
			  
		  }
	  }
  }
  
  
  return $arrayResult;

}
  
   
}
