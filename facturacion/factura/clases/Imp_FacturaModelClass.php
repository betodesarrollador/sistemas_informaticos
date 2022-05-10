<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_FacturaModel extends Db{


 public function getParametros($Conex){
				
        $select = "SELECT * FROM parametro_impresion_factura p";	

	    $result = $this -> DbFetchAll($select,$Conex,true);
		
	    return $result;
  }

  public function getCodigoQR($factura_id,$Conex){
  
     $select = "SELECT f.consecutivo_factura, 
	                  CONCAT_WS('',(SELECT prefijo FROM parametros_factura WHERE parametros_factura_id=f.parametros_factura_id),f.consecutivo_factura)AS NumFac, 
					  CONCAT_WS('',DATE_FORMAT(f.fecha, '%Y%m%d'),DATE_FORMAT(f.ingreso_factura, '%h%i%s')) AS FecFac,
					   f.ingreso_factura,
					  (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS NitFac,
					  (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = f.cliente_id)) AS DocAdq, 
					  f.valor AS ValFac, 

                      (SELECT i.valor_liquida FROM detalle_factura_puc i WHERE i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos IN('IV') AND i.factura_id=f.factura_id))AS ValIva,
   
                      IF(f.fuente_facturacion_cod = 'RM',
					  (f.valor)-(SELECT valor_liquida FROM detalle_factura_puc WHERE factura_id = f.factura_id AND contra_factura=1),
					  (SELECT i.valor_liquida FROM detalle_factura_puc i WHERE i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos IN('IC','RIC','RT') AND i.factura_id=f.factura_id AND contra_factura=1)))AS ValOtroIm,  

                      (SELECT valor_liquida FROM detalle_factura_puc WHERE factura_id = f.factura_id AND contra_factura=1)AS ValFacIm,

                      f.cufe AS CUFE 
					  
					  FROM factura f, oficina of WHERE f.factura_id = $factura_id AND of.oficina_id=f.oficina_id";
	 
     $result = $this -> DbFetchAll($select,$Conex,true);  

     return $result;    
  
  } 

  
  public function getFactura($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');

	
	if(is_numeric($factura_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];

				
        $select = "SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = of.empresa_id) AS logo,
		(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla,
		(SELECT CONCAT_WS(' - ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero t, tipo_identificacion ti WHERE t.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion_emp,
		t.*,
		p.*,
		IF(o.sede_id>0,(SELECT direccion_cliente_operativa FROM cliente_factura_operativa WHERE cliente_id = o.cliente_id ORDER BY cliente_factura_operativa_id DESC LIMIT 1),(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = p.cliente_id)))AS direccion,
		IF(o.sede_id>0,(SELECT u.nombre FROM ubicacion u, cliente_factura_operativa co WHERE u.ubicacion_id=co.ubicacion_id AND co.cliente_id=o.cliente_id ORDER BY cliente_factura_operativa_id DESC LIMIT 1),(SELECT nombre FROM  ubicacion WHERE ubicacion_id =t.ubicacion_id))AS ciudad,
		IF(o.sede_id>0,(SELECT telefono_cliente_operativa FROM cliente_factura_operativa WHERE cliente_id = o.cliente_id ORDER BY cliente_factura_operativa_id DESC LIMIT 1),(t.telefono))AS telefono,
		IF(o.sede_id>0,(SELECT correo_cliente_factura_operativa FROM cliente_factura_operativa WHERE cliente_id = o.cliente_id ORDER BY cliente_factura_operativa_id DESC LIMIT 1),(t.email))AS email,
		(SELECT  nombre FROM  forma_compra_venta WHERE forma_compra_venta_id =o.forma_compra_venta_id ) AS forma_compra,
		(SELECT  nombre FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS documento,
		(SELECT  texto_soporte FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS texto_soporte,
		(SELECT  texto_tercero  FROM  tipo_de_documento WHERE tipo_documento_id =o.tipo_documento_id ) AS texto_tercero,
		(SELECT  observacion_uno  FROM  parametros_factura WHERE parametros_factura_id =o.parametros_factura_id ) AS observacion1,
		(SELECT  observacion_dos  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS observacion2,
		(SELECT  resolucion_dian  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS resolucion_dian,
		(SELECT  tipo  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS tipo,
		(SELECT  fact_electronica  FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS fac_electronica,
		(SELECT  fecha_resolucion_dian 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS fecha_resolucion_dian,
		(SELECT  prefijo 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS prefijo,
		
		(SELECT  CONCAT_WS(' ','Rango autorizado ',(SELECT  prefijo FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ),' del ',rango_inicial,' al ',rango_final, ' Fecha Resolución ',fecha_resolucion_dian,' Fecha vencimiento resolución ',fecha_vencimiento_resolucion_dian) 	FROM  parametros_factura WHERE parametros_factura_id=o.parametros_factura_id ) AS rangos_factura,		
		
		(SELECT  CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS usuario  FROM  usuario u, tercero t WHERE u.usuario_id=o.usuario_id AND t.tercero_id=u.tercero_id) AS elaborado,		
		of.nombre AS nom_oficina,
		of.direccion AS dir_oficina,
		of.telefono  AS tel_oficina,
		of.email  AS email_oficina,
		(SELECT TRIM(nombre) FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi,
		CONCAT_WS(' ',o.fecha,TIME(o.ingreso_factura))AS fecha,
		o.vencimiento,
		o.consecutivo_factura,
		o.observacion,
		o.concepto,
		o.concepto_item,
		o.estado,
		o.cliente_id,
		o.fuente_facturacion_cod,
		o.cufe,
		(SELECT  nombre  FROM  forma_compra_venta WHERE forma_compra_venta_id=o.forma_compra_venta_id ) AS forma_compra_venta,
		(SELECT GROUP_CONCAT(r.numero_remesa) FROM detalle_factura df, remesa r WHERE df.factura_id=o.factura_id AND r.remesa_id=df.remesa_id) AS remesas_rel,
		(SELECT GROUP_CONCAT(os.consecutivo) FROM detalle_factura df, orden_servicio os WHERE df.factura_id=o.factura_id AND os.orden_servicio_id=df.orden_servicio_id) AS os_rel,
		(SELECT GROUP_CONCAT(os.seguimiento_id) FROM detalle_factura df, seguimiento os WHERE df.factura_id=o.factura_id AND os.seguimiento_id=df.seguimiento_id) AS seg_rel,
		p.observacion_factura,
		(SELECT COUNT(d.remesa_id) FROM detalle_factura d WHERE d.factura_id=$factura_id)as cantidad_remesas,
		(SELECT COUNT(d.orden_servicio_id) FROM detalle_factura d WHERE d.factura_id=$factura_id)as cantidad_ordenes
		
        FROM factura o, oficina of, cliente p, tercero t WHERE o.factura_id = $factura_id AND of.oficina_id=o.oficina_id AND p.cliente_id=o.cliente_id  AND t.tercero_id=p.tercero_id";		

	    $result = $this -> DbFetchAll($select,$Conex,true);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getitemFactura($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
	if(is_numeric($factura_id)){
				
        $select = "SELECT d.*,
		IF(d.remesa_id>0,'1',d.cantidad) AS cantidades,
		IF(d.remesa_id>0,(SELECT cantidad FROM remesa WHERE remesa_id=d.remesa_id),d.cantidad) AS cantidad_cargada,
		IF(d.remesa_id>0,d.valor,d.valor_unitario) AS valor_unitario,
		IF(d.remesa_id>0,(SELECT valor_unidad_facturar FROM remesa WHERE remesa_id=d.remesa_id),d.valor_unitario) AS valor_unitario_total,
		IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),' ') AS no_remesa,
		IF(d.remesa_id>0,(SELECT valor FROM remesa WHERE remesa_id=d.remesa_id),' ') AS valor_declarado,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
		
		IF(d.remesa_id>0,(SELECT fecha_remesa FROM remesa WHERE remesa_id=d.remesa_id), IF(d.seguimiento_id>0,(SELECT fecha FROM seguimiento WHERE seguimiento_id=d.seguimiento_id),(SELECT fecha_orden_servicio FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id))) AS fecha_doc,
		(SELECT orden_despacho FROM remesa WHERE remesa_id=d.remesa_id) AS documento_cliente,
		(SELECT tipo_liquidacion FROM remesa WHERE remesa_id=d.remesa_id) AS tipo_liquidacion,
		IF(d.remesa_id>0,(SELECT numero_remesa FROM remesa WHERE remesa_id=d.remesa_id),IF(d.seguimiento_id>0,(SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=d.seguimiento_id),(SELECT consecutivo FROM orden_servicio WHERE orden_servicio_id=d.orden_servicio_id))) AS num_doc,
		IF(d.remesa_id>0,'Remesa',IF(d.seguimiento_id>0,'Despacho Particular','Orden de Servicio')) AS fuente,
		(SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id) AS producto,IF(d.remesa_id>0,(SELECT producto_empresa FROM producto WHERE producto_id=d.producto_id),d.descripcion) AS descripcion,
		(SELECT peso FROM remesa WHERE remesa_id = d.remesa_id)AS peso,
		(SELECT descripcion_producto FROM remesa WHERE remesa_id = d.remesa_id)AS descripcion_producto,
		( Format(ROUND((SELECT valor_facturar FROM remesa WHERE remesa_id = d.remesa_id)/((SELECT peso FROM remesa WHERE remesa_id = d.remesa_id)/(1000))),0, 'de_DE'))AS valor_tonelada,

        IF((SELECT remesa_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)>0,
			(IF((SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)>0,
			(SELECT placa FROM manifiesto WHERE manifiesto_id=(SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)),
			(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=(SELECT despachos_urbanos_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1))
			)),'N/A'
		)AS placa,

		 IF((SELECT remesa_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)>0,
			(IF((SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)>0,
			(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=(SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)),
			(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=(SELECT despachos_urbanos_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1))
			)),'N/A'
		)AS manifiesto,

		IF((SELECT remesa_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)>0,
			(IF((SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1)>0,
			(SELECT pasador_vial FROM ruta WHERE ruta_id = (SELECT ruta_id FROM manifiesto WHERE manifiesto_id=(SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id=d.remesa_id ORDER BY detalle_despacho_id DESC LIMIT 1))),
			('N/A')
			)),'N/A'
		)AS pasador_vial

         FROM detalle_factura d  WHERE d.factura_id = $factura_id ";	
       
	    $result = $this -> DbFetchAll($select,$Conex,true);
		
		//echo $select;

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

    public function get_pucFactura($fuente_facturacion_cod,$Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
	if(is_numeric($factura_id)){



		if ($fuente_facturacion_cod =='RM') {
			$select = "SELECT SUBSTRING_INDEX(d.desc_factura, '-', 1)AS despuc_bien_servicio_factura,
						  IF(d.deb_item_factura>0,'D','C') AS natu_bien_servicio_factura,
						  d.contra_factura AS contra_bien_servicio_factura,
						  '0' AS tercero_bien_servicio_factura,
						  '0' AS ret_tercero_bien_servicio_factura,
						  '0' AS aplica_ingreso,
						  d.puc_id,
						  d.formula_factura,
						  d.valor_liquida,
						  f.fuente_facturacion_cod						 
						 FROM detalle_factura_puc d, factura f
						 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id AND d.ingreso_tercero IS NULL GROUP BY d.puc_id ORDER BY d.detalle_factura_puc_id";	
		}else {
			$select  = "SELECT SUBSTRING_INDEX(d.desc_factura, '-', 1)AS despuc_bien_servicio_factura,
						  IF(d.deb_item_factura>0,'D','C') AS natu_bien_servicio_factura,
						  d.contra_factura AS contra_bien_servicio_factura,
						  '0' AS tercero_bien_servicio_factura,
						  '0' AS ret_tercero_bien_servicio_factura,
						  '0' AS aplica_ingreso,
						  d.puc_id,
						  d.formula_factura,
						  SUM(d.valor_liquida),
						  f.fuente_facturacion_cod,						  
						  IF(d.valor_liquida>0,SUM(d.valor_liquida),SUM(d.deb_item_factura+d.cre_item_factura)) AS valor 
						 FROM detalle_factura_puc d, factura f
						 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id GROUP BY d.puc_id ORDER BY d.contra_factura";
		}
         //echo $select;
	    $result = $this -> DbFetchAll($select,$Conex,true);

	}else{
   	    $result = array();
	  }
	return $result;
  }

  /* public function get_pucFactura($Conex){
  
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
  } */

  public function get_valor_letras($Conex){
  
        $factura_id = $this -> requestData('factura_id','integer');
	
	if(is_numeric($factura_id)){
	
        $select = "SELECT IF(valor_liquida>0,valor_liquida,(deb_item_factura+cre_item_factura)) AS valor
         FROM  detalle_factura_puc 
		 WHERE factura_id = $factura_id AND contra_factura=1";		

	    $result = $this -> DbFetchAll($select,$Conex,true);

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