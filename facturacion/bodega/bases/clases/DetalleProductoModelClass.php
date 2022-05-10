<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleProductoModel extends Db{

  private $Permisos;
      
  public function getDetallesSalarios($Conex){
  
	$producto_id = $this -> requestDataForQuery('producto_id','integer');
	
	if(is_numeric($producto_id)){

		$select = "SELECT 
					(SELECT f.fecha_factura_proveedor FROM factura_proveedor f WHERE f.orden_compra_id IN(SELECt orden_compra_id FROM orden_compra WHERE orden_compra_id IN (SELECT orden_compra_id FROM    wms_item_liquida_orden      WHERE producto_id=$producto_id)) ORDER By fecha_factura_proveedor DESC LIMIT 0,1 ) AS fecha_ult1,

					(SELECT i.valoruni_item_liquida_orden FROM    wms_item_liquida_orden      i WHERE i.producto_id=$producto_id AND i.orden_compra_id = (SELECT f.orden_compra_id FROM factura_proveedor f WHERE f.orden_compra_id IN(SELECt orden_compra_id FROM orden_compra WHERE orden_compra_id IN (SELECT orden_compra_id FROM    wms_item_liquida_orden      WHERE producto_id=$producto_id)) ORDER By fecha_factura_proveedor DESC LIMIT 0,1 ) LIMIT 1)AS valor_ult1,

					(SELECT f.fecha_factura_proveedor FROM factura_proveedor f WHERE f.orden_compra_id IN(SELECt orden_compra_id FROM orden_compra WHERE orden_compra_id IN (SELECT orden_compra_id FROM    wms_item_liquida_orden      WHERE producto_id=$producto_id)) ORDER By fecha_factura_proveedor DESC LIMIT 1,1 ) AS fecha_ult2,

					(SELECT i.valoruni_item_liquida_orden FROM    wms_item_liquida_orden      i WHERE i.producto_id=$producto_id AND i.orden_compra_id = (SELECT f.orden_compra_id FROM factura_proveedor f WHERE f.orden_compra_id IN(SELECt orden_compra_id FROM orden_compra WHERE orden_compra_id IN (SELECT orden_compra_id FROM    wms_item_liquida_orden      WHERE producto_id=$producto_id)) ORDER By fecha_factura_proveedor DESC LIMIT 1,1 ) LIMIT 1)AS valor_ult2,

					(SELECT f.fecha_factura_proveedor FROM factura_proveedor f WHERE f.orden_compra_id IN(SELECt orden_compra_id FROM orden_compra WHERE orden_compra_id IN (SELECT orden_compra_id FROM    wms_item_liquida_orden      WHERE producto_id=$producto_id)) ORDER By fecha_factura_proveedor DESC LIMIT 2,1 ) AS fecha_ult3,

					(SELECT i.valoruni_item_liquida_orden FROM    wms_item_liquida_orden      i WHERE i.producto_id=$producto_id AND i.orden_compra_id = (SELECT f.orden_compra_id FROM factura_proveedor f WHERE f.orden_compra_id IN(SELECt orden_compra_id FROM orden_compra WHERE orden_compra_id IN (SELECT orden_compra_id FROM    wms_item_liquida_orden      WHERE producto_id=$producto_id)) ORDER By fecha_factura_proveedor DESC LIMIT 2,1 ) LIMIT 1)AS valor_ult3,

					(SELECT valor_venta1 FROM    wms_detalle_precios        WHERE producto_id=$producto_id AND valor_venta1 >0 ORDER By fecha DESC LIMIT 1)AS valor_venta1,

					(SELECT valor_venta2 FROM    wms_detalle_precios        WHERE producto_id=$producto_id AND valor_venta2 >0 ORDER By fecha DESC LIMIT 1)AS valor_venta2,

					(SELECT valor_venta3 FROM    wms_detalle_precios        WHERE producto_id=$producto_id AND valor_venta3 >0 ORDER By fecha DESC LIMIT 1)AS valor_venta3,

					(SELECT fecha FROM    wms_detalle_precios        WHERE producto_id=$producto_id ORDER By fecha DESC LIMIT 1)AS fecha,

					(SELECT valor FROM    wms_detalle_precios        WHERE producto_id=$producto_id AND valor >0 ORDER By fecha DESC LIMIT 1)AS valor
					  ";
				
		 	
		$result  = $this -> DbFetchAll($select,$Conex,true);

		if(!count($result)>0){
			$result = array('valor' => '');
		}
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
public function SaveCosto($Campos,$Conex){
	
	$detalle_precios_id = $this -> DbgetMaxConsecutive("   wms_detalle_precios       ","detalle_precios_id",$Conex,true,1);
		$producto_id = $this -> requestDataForQuery('producto_id','integer');
		$fecha 		 = $this -> requestDataForQuery('fecha','date');
		$valor 		 = $this -> requestDataForQuery('valor','numeric');

        $insert = "INSERT INTO    wms_detalle_precios        (detalle_precios_id,producto_id,fecha,valor)VALUES($detalle_precios_id,$producto_id,$fecha,$valor)";
		$this -> query($insert,$Conex,true);	
	
		return $detalle_precios_id;

  }

  public function SaveVenta($Campos,$Conex){
	
	$detalle_precios_id = $this -> DbgetMaxConsecutive("   wms_detalle_precios       ","detalle_precios_id",$Conex,true,1);
		$producto_id = $this -> requestDataForQuery('producto_id','integer');
		$fecha 		 = $this -> requestDataForQuery('fecha','date');
		$valor 		 = $this -> requestDataForQuery('valor','numeric');
		$campo 		 = $this -> requestDataForQuery('campo','numeric');
		
        $insert = "INSERT INTO    wms_detalle_precios        (detalle_precios_id,producto_id,fecha,$campo)VALUES($detalle_precios_id,$producto_id,$fecha,$valor)";
		$this -> query($insert,$Conex,true);	
	
		return $detalle_precios_id;

  }

  public function UpdateCosto($Campos,$Conex){
  
		$detalle_precios_id = $this -> requestDataForQuery('detalle_precios_id','integer');
		$fecha 		 = $this -> requestDataForQuery('fecha','date');
		$valor 		 = $this -> requestDataForQuery('valor','numeric');
		
		
		$Update = "UPDATE    wms_detalle_precios        SET fecha=$fecha, valor=$valor WHERE detalle_precios_id=$detalle_precios_id";
		$this -> query($Update,$Conex,true);	
		return $detalle_precios_id;
	
  }

   public function UpdateVenta($Campos,$Conex){
  
		$detalle_precios_id = $this -> requestDataForQuery('detalle_precios_id','integer');
		$fecha 		 = $this -> requestDataForQuery('fecha','date');
		$valor 		 = $this -> requestDataForQuery('valor','numeric');
		$campo 		 = $this -> requestDataForQuery('campo','numeric');

		$Update = "UPDATE    wms_detalle_precios        SET fecha=$fecha,$campo=$valor WHERE detalle_precios_id=$detalle_precios_id";
		$this -> query($Update,$Conex,true);	
		return $detalle_precios_id;
	
  }

   
}



?>