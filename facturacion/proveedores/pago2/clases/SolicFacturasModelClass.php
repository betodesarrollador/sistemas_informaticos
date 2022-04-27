<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicFacturasModel extends Db{

  private $Permisos;
  
  public function getSolicFacturas($cliente_id,$Conex){
	
	if(is_numeric($cliente_id)){		
		$select = "SELECT 
					f.factura_proveedor_id,
					IF(f.encabezado_registro_id>0,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id),f.consecutivo_factura_proveedor) AS consecutivo_id,
					CASE f.fuente_factura_proveedorcion_cod WHEN 'OS' THEN 'Orden de Servicio' ELSE 'Remesas' END AS tipo,
					f.fecha,
					f.vencimiento,
					f.valor,
					(SELECT IF(valor_liquida>0,valor_liquida,(deb_item_factura_proveedor+cre_item_factura_proveedor)) AS neto  FROM detalle_factura_proveedor_puc WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura_proveedor='A')	AS abonos_nc,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura_proveedor='C')	AS abonos
				FROM factura_proveedor f
				WHERE f.cliente_id=$cliente_id AND f.estado='C' 
				AND ((SELECT IF(valor_liquida>0,valor_liquida,(deb_item_factura_proveedor+cre_item_factura_proveedor)) AS neto  FROM detalle_factura_proveedor_puc WHERE  factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) >	(SELECT SUM(ra.rel_valor_abono) AS abonos FROM relacion_abono ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura_proveedor='C')
				OR 	(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura_proveedor ab 
				WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura_proveedor='C') IS NULL)";
		  $result = $this -> DbFetchAll($select,$Conex);

	  	$i=0;
	  	foreach($result as $items){
			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$results[$i]=array(factura_proveedor_id=>$items[factura_proveedor_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],valor=>$items[valor],valor_neto=>$items[valor_neto],abonos_nc=>$items[abonos_nc],abonos=>$items[abonos],saldo=>$saldo);	
			$i++;
		}
	}else{
   	    $results = array();
	 }
	
	return $results;
  }

  public function getDescuentos($oficina_id,$Conex){

		$select = "SELECT 
					p.parametros_descuento_factura_proveedor_id,
					p.naturaleza,
					p.nombre
				FROM parametros_descuento_factura_proveedor p
				WHERE p.estado=1 AND p.oficina_id=$oficina_id"; 
				
		  $result = $this -> DbFetchAll($select,$Conex);
		  
		return $result;

  }
  
}


?>