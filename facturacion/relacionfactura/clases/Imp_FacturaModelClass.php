<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_FacturaModel extends Db{

  
  public function getFactura($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');

	
	if(is_numeric($factura_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];

				
        $select = "SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = of.empresa_id) AS logo,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla, (SELECT CONCAT_WS(' - ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad,
		(SELECT ti.nombre FROM tercero t, tipo_identificacion ti WHERE t.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion_emp,
		t.*,
		p.*,
		(SELECT  nombre FROM  forma_compra_venta WHERE forma_compra_venta_id =o.forma_compra_venta_id ) AS forma_compra,
		(SELECT  nombre FROM  ubicacion WHERE ubicacion_id =t.ubicacion_id ) AS ciudad,	
		(SELECT  nombre FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS documento,
		(SELECT  texto_soporte FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS texto_soporte,
		(SELECT  texto_tercero  FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS texto_tercero,
		(SELECT  observacion_uno  FROM  parametros_factura WHERE parametros_factura_id =o.parametros_factura_id ) AS observacion1,
		(SELECT  observacion_dos  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS observacion2,
		(SELECT  resolucion_dian  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS resolucion_dian,
		(SELECT  fecha_resolucion_dian 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS fecha_resolucion_dian,
		(SELECT  prefijo 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS prefijo,
		
		(SELECT  CONCAT_WS(' ','Rango autorizado del ',rango_inicial,' al ',rango_final) 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS rangos_factura,		
		
		(SELECT  CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS usuario  FROM  usuario u, tercero t WHERE u.usuario_id=o.usuario_id AND t.tercero_id=u.tercero_id) AS elaborado,		
		of.nombre AS nom_oficina,
		of.direccion AS dir_oficna,
		of.telefono  AS tel_oficina,
		(SELECT TRIM(nombre) FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi,
		o.fecha,
		o.vencimiento,
		o.consecutivo_factura,
		o.observacion,
		o.concepto,
		o.concepto_item,
		o.estado,
		o.cliente_id,
		o.fuente_facturacion_cod,
		(SELECT  nombre  FROM  forma_compra_venta WHERE forma_compra_venta_id=o.forma_compra_venta_id ) AS forma_compra_venta,
		(SELECT GROUP_CONCAT(r.numero_remesa) FROM detalle_factura df, remesa r WHERE df.factura_id=o.factura_id AND r.remesa_id=df.remesa_id) AS remesas_rel,
		(SELECT GROUP_CONCAT(os.consecutivo) FROM detalle_factura df, orden_servicio os WHERE df.factura_id=o.factura_id AND os.orden_servicio_id=df.orden_servicio_id) AS os_rel,
		(SELECT GROUP_CONCAT(os.seguimiento_id) FROM detalle_factura df, seguimiento os WHERE df.factura_id=o.factura_id AND os.seguimiento_id=df.seguimiento_id) AS seg_rel
		
        FROM factura o, oficina of, cliente p, tercero t WHERE o.factura_id = $factura_id AND of.oficina_id=o.oficina_id AND p.cliente_id=o.cliente_id  AND t.tercero_id=p.tercero_id";		

	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getitemFactura($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
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
		(SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id) AS producto,IF(d.remesa_id>0,(SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id),d.descripcion) AS descripcion
         FROM detalle_factura d  WHERE d.factura_id = $factura_id ";	

	    $result = $this -> DbFetchAll($select,$Conex);
		
		//echo $select;

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function get_pucFactura($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
	if(is_numeric($factura_id)){
	
        $select = "SELECT c.despuc_bien_servicio_factura, c.contra_bien_servicio_factura, c.natu_bien_servicio_factura, (d.deb_item_factura+d.cre_item_factura) AS valor, c.tercero_bien_servicio_factura, c.ret_tercero_bien_servicio_factura,  c.aplica_ingreso, d.valor_liquida
         FROM  detalle_factura_puc d, factura o,  codpuc_bien_servicio_factura c  
		 WHERE o.factura_id = $factura_id AND d.factura_id=o.factura_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.puc_id=d.puc_id
		 ORDER BY d.detalle_factura_puc_id";		
		 
		 $select  = "SELECT  d.desc_factura AS despuc_bien_servicio_factura,
						  IF(d.deb_item_factura>0,'D','C') AS natu_bien_servicio_factura,
						  d.contra_factura AS contra_bien_servicio_factura,
						  '0' AS tercero_bien_servicio_factura,
						  '0' AS ret_tercero_bien_servicio_factura,
						  '0' AS aplica_ingreso,
						  d.puc_id,
						  d.formula_factura,
						  d.valor_liquida,
						  f.fuente_facturacion_cod,						  
						  IF(d.valor_liquida>0,d.valor_liquida,(d.deb_item_factura+d.cre_item_factura)) AS valor 
						 FROM detalle_factura_puc d, factura f
						 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id   ORDER BY d.contra_factura";

	    $result = $this -> DbFetchAll($select,$Conex);

	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function get_valor_letras($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
	if(is_numeric($factura_id)){
	
        $select = "SELECT IF(valor_liquida>0,valor_liquida,(deb_item_factura+cre_item_factura)) AS valor
         FROM  detalle_factura_puc 
		 WHERE factura_id = $factura_id AND contra_factura=1";		

	    $result = $this -> DbFetchAll($select,$Conex);

	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function get_valor_detalles($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
	if(is_numeric($factura_id)){
	
        $select = "SELECT SUM(valor) AS valor
         FROM  detalle_factura 
		 WHERE factura_id = $factura_id ";		

	    $result = $this -> DbFetchAll($select,$Conex);

	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getImputacionesContables($Conex){
	$factura_id = $this -> requestData('factura_id','integer');	   	
	if(is_numeric($factura_id)){

	  $select  = "SELECT f.fuente_facturacion_cod,
						 f.factura_id,
						 IF(d.orden_servicio_id>0,'Orden de Servicio',IF(d.remesa_id,'Remesa','Despacho Particular')) AS fuente,
	  					 d.*,
						 (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
						 (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
						 IF(d.remesa_id>0,(SELECT destinatario FROM remesa WHERE remesa_id=d.remesa_id),' ') AS destinatario,
						 (SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id) AS producto,
						 f.cliente_id,
						 IF(d.remesa_id>0,(SELECT fecha_remesa FROM remesa WHERE remesa_id=d.remesa_id),'') as fecha_remesa,
						 IF(d.remesa_id>0,(SELECT orden_despacho FROM remesa WHERE remesa_id=d.remesa_id),'') as orden_despacho,
						 IF(d.remesa_id>0,(SELECT cp.nombre FROM remesa r,cliente_proyecto cp WHERE r.remesa_id=d.remesa_id AND cp.cliente_proyecto_id=r.cliente_proyecto_id),'') as proyecto,
						 						 
						 IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,d.seguimiento_id,(SELECT consecutivo FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id)) ) AS numero
	  		FROM detalle_factura  d, factura f WHERE f.factura_id = $factura_id AND d.factura_id=f.factura_id";

	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }

}


?>