<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_AutorizaPagoModel extends Db{
  
  public function getOrdenCompra($Conex){
  
			$select = "SELECT
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=f.proveedor_id) AS proveedor,					
					f.codfactura_proveedor,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					f.concepto_factura_proveedor,
					f.valor_factura_proveedor
				FROM factura_proveedor f
				WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.valor_factura_proveedor>0 AND f.autoriza_pago=1 AND f.estado_factura_proveedor='C' AND f.aut_fecha_factura=TODAY()";
			$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
  }


}


?>