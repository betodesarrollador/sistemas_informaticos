<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicFacturasModel extends Db{

  private $Permisos;
  
  public function getSolicFacturas($cliente_id,$Conex){
	
	if(is_numeric($cliente_id)){		
		$select = "SELECT 
					f.factura_id,
					IF(f.encabezado_registro_id>0,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id),f.consecutivo_factura) AS consecutivo_id,
					CASE f.fuente_facturacion_cod WHEN 'OS' THEN 'Orden de Servicio' ELSE 'Remesas' END AS tipo,
					f.fecha,
					f.vencimiento,
					f.valor,
					(SELECT IF(valor_liquida>0,valor_liquida,(deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='A')	AS abonos_nc,
					(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C')	AS abonos
				FROM factura f
				WHERE f.cliente_id=$cliente_id AND f.estado='C' 
				AND ((SELECT IF(valor_liquida>0,valor_liquida,(deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) >	(SELECT SUM(ra.rel_valor_abono) AS abonos FROM relacion_abono ra, abono_factura ab 
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C')
				OR 	(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab 
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C') IS NULL)";
		  $result = $this -> DbFetchAll($select,$Conex);

	  	$i=0;
	  	foreach($result as $items){
			$saldo=floatval($items[valor_neto])-floatval($items[abonos]); 
			$results[$i]=array(factura_id=>$items[factura_id],consecutivo_id=>$items[consecutivo_id],tipo=>$items[tipo],fecha=>$items[fecha],vencimiento=>$items[vencimiento],valor=>$items[valor],valor_neto=>$items[valor_neto],abonos_nc=>$items[abonos_nc],abonos=>$items[abonos],saldo=>$saldo);	
			$i++;
		}
	}else{
   	    $results = array();
	 }
	
	return $results;
  }

  public function getDescuentos($oficina_id,$Conex){

		$select = "SELECT 
					p.parametros_descuento_factura_id,
					p.naturaleza,
					p.nombre
				FROM parametros_descuento_factura p
				WHERE p.estado=1 AND p.oficina_id=$oficina_id"; 
				
		  $result = $this -> DbFetchAll($select,$Conex);
		  
		return $result;

  }
  
}


?>