<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_FacturaPDFModel extends Db{

public function getFacturas($rango_desde,$rango_hasta,$factura_id,$Conex){
	
	 $oficina_id = $_SESSION['OFICINAID'];
	$select = "SELECT factura_id FROM factura WHERE factura_id BETWEEN $factura_id AND $factura_id AND oficina_id=$oficina_id";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	
	
	return $result;
	
}
  
  public function getEncabezado($factura_id,$Conex){
	
	if(is_numeric($factura_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];
				
        $select = "SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = of.empresa_id) AS logo,(SELECT pagina_web AS pagina FROM empresa WHERE empresa_id = of.empresa_id) AS pagina_web,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS telefono,(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla, (SELECT CONCAT_WS(' - ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad,

		(SELECT ti.nombre FROM tercero t, tipo_identificacion ti WHERE t.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT resolucion_dian FROM parametros_factura WHERE parametros_factura_id=o.parametros_factura_id)as resolucion_dian,
		(SELECT fecha_resolucion_dian FROM parametros_factura WHERE parametros_factura_id=o.parametros_factura_id)as fecha_resolucion_dian,
		(SELECT observacion_uno FROM parametros_factura WHERE parametros_factura_id=o.parametros_factura_id)as observacion_uno,
		(SELECT observacion_dos FROM parametros_factura WHERE parametros_factura_id=o.parametros_factura_id)as observacion_dos,
		(SELECT CONCAT_WS(' - ',rango_inicial,rango_final)as rango FROM parametros_factura WHERE parametros_factura_id=o.parametros_factura_id)as rango,
		t.*,
		p.*,
		(SELECT  nombre FROM  forma_compra_venta WHERE forma_compra_venta_id =o.forma_compra_venta_id ) AS forma_compra,
		(SELECT  nombre FROM  ubicacion WHERE ubicacion_id =t.ubicacion_id ) AS ciudad,	
		t.direccion AS dir_cliente,
		t.apartado AS apartado_cliente,
		t.telefono AS telefono_cliente,
		t.ubicacion_id AS ubicacion_cliente,
		(SELECT  CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) AS nom_cliente,
		(SELECT  nombre FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS documento,
		(SELECT  texto_soporte FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS texto_soporte,
		(SELECT  texto_tercero  FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS texto_tercero,
		(SELECT  observacion_uno  FROM  parametros_factura WHERE parametros_factura_id =o.parametros_factura_id ) AS observacion1,
		(SELECT  observacion_dos  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS observacion2,
		(SELECT  resolucion_dian  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS resolucion_dian,
		(SELECT  fecha_resolucion_dian 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS fecha_resolucion_dian,
		(SELECT  prefijo 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS prefijo,
		of.nombre AS nombre_oficina,
		(SELECT  CONCAT_WS(' ','Rango autorizado del ',rango_inicial,' al ',rango_final) 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS rangos_factura,		
		
		(SELECT  CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS usuario  FROM  usuario u, tercero t WHERE u.usuario_id=o.usuario_id AND t.tercero_id=u.tercero_id) AS elaborado,
		of.nombre AS nom_oficina,
		of.direccion AS dir_oficna,
		of.ubicacion_id AS ubicacion_id,
		of.telefono  AS tel_oficina,
		of.movil as cel_oficina,
		(SELECT TRIM(nombre) FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi,
		o.fecha,
		o.vencimiento,
		o.consecutivo_factura,
		o.observacion,
		o.concepto,
		o.concepto_item,
		o.estado,
		of.email,
		o.fuente_facturacion_cod,
		(SELECT  nombre  FROM  forma_compra_venta WHERE forma_compra_venta_id=o.forma_compra_venta_id ) AS forma_compra_venta,
		(SELECT GROUP_CONCAT(r.numero_remesa) FROM detalle_factura df, remesa r WHERE df.factura_id=o.factura_id AND r.remesa_id=df.remesa_id ORDER BY df.detalle_factura_id DESC LIMIT 1) AS remesas_rel,
		(SELECT GROUP_CONCAT(DISTINCT(os.consecutivo)) FROM detalle_factura df, orden_servicio os WHERE df.factura_id=o.factura_id AND os.orden_servicio_id=df.orden_servicio_id) AS os_rel,
		(SELECT GROUP_CONCAT(os.seguimiento_id) FROM detalle_factura df, seguimiento os WHERE df.factura_id=o.factura_id AND os.seguimiento_id=df.seguimiento_id) AS seg_rel
		
        FROM factura o, oficina of, cliente p, tercero t WHERE o.factura_id = $factura_id AND of.oficina_id=o.oficina_id AND p.cliente_id=o.cliente_id  AND t.tercero_id=p.tercero_id";		
	    $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


   public function getitemFactura($factura_id,$Conex){
  
	if(is_numeric($factura_id)){
				
        $select = "SELECT d.*,
		IF(d.remesa_id>0,(SELECT cantidad FROM remesa WHERE remesa_id=d.remesa_id),d.cantidad) AS cantidades,
		IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),' ') AS no_remesa,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
		IF(d.remesa_id>0,(SELECT fecha_remesa FROM remesa WHERE remesa_id=d.remesa_id), IF(d.seguimiento_id>0,(SELECT fecha FROM seguimiento WHERE seguimiento_id=d.seguimiento_id),(SELECT fecha_orden_servicio FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id))) AS fecha_doc,
		(SELECT orden_despacho FROM remesa WHERE remesa_id=d.remesa_id) AS documento_cliente,
		IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,(SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=d.seguimiento_id),(SELECT consecutivo FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id))) AS num_doc,
		IF(d.remesa_id>0,'Remesa',IF(d.seguimiento_id>0,'Despacho Particular','Orden de Servicio')) AS fuente,

		IF(d.producto_id>0,d.descripcion,d.descripcion) AS descripcion

		/*IF(d.producto_id>0,(SELECT p.referencia FROM producto_inv p WHERE p.producto_id=d.producto_id ),'')as codigo_producto,
		 IF(d.item_liquida_servicio_id>0,(SELECT peso_total FROM item_liquida_servicio WHERE item_liquida_servicio_id = d.item_liquida_servicio_id),'')AS pesos_producto*/
         FROM detalle_factura d  WHERE d.factura_id = $factura_id ";	
	    $result = $this -> DbFetchAll($select,$Conex,true);
		
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getTotal($encabezado_registro_id,$Conex){
  
    $encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');
	
	if(is_numeric($encabezado_registro_id)){
				
        $select = "SELECT SUM(debito) AS total_debito, SUM(credito) AS total_credito		
         FROM  imputacion_contable    WHERE encabezado_registro_id = $encabezado_registro_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex,true);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

 public function get_pucFactura($factura_id,$Conex){
  
        
	if(is_numeric($factura_id)){
		 
		 $select = "SELECT c.despuc_bien_servicio_factura, c.contra_bien_servicio_factura, c.natu_bien_servicio_factura, (d.deb_item_factura+d.cre_item_factura) AS valor,d.desc_factura AS tipo_texto, c.tercero_bien_servicio_factura, c.ret_tercero_bien_servicio_factura,  c.aplica_ingreso, d.valor_liquida
         FROM  detalle_factura_puc d, factura o,  codpuc_bien_servicio_factura c  
		 WHERE o.factura_id = $factura_id AND d.factura_id=o.factura_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.puc_id=d.puc_id AND c.aplica_ingreso=0
		 ORDER BY d.detalle_factura_puc_id";		


	    $result = $this -> DbFetchAll($select,$Conex,true);
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  public function getTotales($factura_id,$Conex){
	
	if(is_numeric($factura_id)){
				
        $select = "SELECT valor_liquida AS total		
         FROM  detalle_factura_puc    WHERE factura_id = $factura_id  AND contra_factura=1";		
	
	    $result = $this -> DbFetchAll($select,$Conex,true);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

}


?>