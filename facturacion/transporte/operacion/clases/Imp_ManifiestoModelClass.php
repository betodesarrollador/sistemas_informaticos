<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ManifiestoModel extends Db{

  
  public function getManifiesto($manifiesto_id,$Conex){
	
	if(is_numeric($manifiesto_id)){
					
      $select = "SELECT d.*, m.* FROM (SELECT (SELECT logo FROM empresa WHERE empresa_id = m.empresa_id) AS logo,(SELECT nombre FROM oficina WHERE oficina_id = m.oficina_id) AS oficina, 
				(SELECT direccion FROM oficina WHERE oficina_id = m.oficina_id) AS direccion_oficina,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS razon_social,
				(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS sigla, (SELECT concat(numero_identificacion,'-',digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS  numero_identificacion_empresa,
				(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id))) AS ciudad,
                (SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS telefono,(SELECT email FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS email,(SELECT codigo_regional FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS codigo_regional,(SELECT codigo_empresa FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS codigo_empresa,
				(SELECT codigo_regional FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS habilitacion,(SELECT rango_manif_ini FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS rango_manif_ini,(SELECT rango_manif_fin FROM resolucion_habilitacion WHERE empresa_id = m.empresa_id) AS rango_manif_fin,
		        (SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,(SELECT tipo_manifiesto FROM tipo_manifiesto WHERE tipo_manifiesto_id = m.tipo_manifiesto_id) AS tipo_manifiesto,m.numero_identificacion AS numero_identificacion_conductor,
	            (SELECT archivo_imagen_frontal  AS archivo_imagen_frontals  FROM vehiculo WHERE placa_id=m.placa_id) AS foto_vehiculo,
				(SELECT foto AS fotos FROM conductor WHERE conductor_id =m.conductor_id) AS foto_conductor,
	               (IF(cargue_pagado_por = 'R','REMITENTE',IF(cargue_pagado_por = 'D','DESTINATARIO',IF(cargue_pagado_por = 'C','CONDUCTOR',IF(cargue_pagado_por = 'CI','CLIENTE','TRANSPORTADORA'))))) AS cargue_pagado_por,
	               
	               (IF(descargue_pagado_por = 'R','REMITENTE',IF(descargue_pagado_por = 'D','DESTINATARIO',IF(descargue_pagado_por = 'C','CONDUCTOR',IF(descargue_pagado_por = 'CI','CLIENTE','TRANSPORTADORA'))))) AS descargue_pagado_por,(SELECT SUM(valor)FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND devolucion=0) AS valor_anticipo,manifiesto_id,empresa_id,oficina_id,manifiesto 	,tipo_manifiesto_id,modalidad,origen_id,destino_id ,aseguradora 	,poliza 	,vencimiento_poliza 	,titular_manifiesto_id 	,ciudad_titular_manifiesto_divipola 	,titular_manifiesto 	,numero_identificacion_titular_manifiesto ,aprobacion_ministerio,direccion_titular_manifiesto,telefono_titular_manifiesto 	,ciudad_titular_manifiesto 	,placa_id 	,placa 	,propio 	,placa_remolque_id 	,fecha_mc 	,fecha_entrega_mcia_mc 	,hora_entrega 	,valor_flete 	,preliquido 	,marca 	,linea 	,modelo 	,modelo_repotenciado 	,serie 	,color 	,carroceria 	,registro_nacional_carga 	,
				   (SELECT descripcion_config FROM configuracion WHERE configuracion=m.configuracion) AS configuracion 	,peso_vacio 	,numero_soat 	,nombre_aseguradora 	,vencimiento_soat 	,placa_remolque 	,propietario 	,numero_identificacion_propietario 	,direccion_propietario 	,telefono_propietario 	,ciudad_propietario 	,tenedor 	,tenedor_id 	,numero_identificacion_tenedor 	,direccion_tenedor 	,telefono_tenedor 	,ciudad_tenedor 	,conductor_id 	,conductor 	,numero_identificacion 	,(SELECT CONCAT_WS(' - ',l.categoria,c.numero_licencia_cond) FROM categoria_licencia l, conductor c WHERE c.conductor_id = m.conductor_id AND c.categoria_id=l.categoria_id) AS numero_licencia_cond 	,nombre 	,direccion_conductor 	,telefono_conductor 	,ciudad_conductor 	,categoria_licencia_conductor 	,fecha_pago_saldo 	,oficina_pago_saldo_id 	,lugar_pago_saldo 	,saldo_por_pagar 	,valor_neto_pagar,numero_precinto,observaciones,usuario_id 	,usuario_registra, CONCAT('http://162.241.4.183../../../imagenes/transporte/manifiesto/',REPLACE(usuario_registra,' ','_'),'.JPG') as firma_desp 	,usuario_registra_numero_identificacion,estado,id_mobile, numero_contenedor,fecha_estimada_salida,hora_estimada_salida,aprobacion_ministerio2,aprobacion_ministerio3,
	   ultimo_error_reportando_ministario2,ultimo_error_reportando_ministario3,
   	   (SELECT activo_impresion FROM rndc ORDER BY rndc_id LIMIT 1) AS activo_impresion
	               
	               
	               
	               FROM manifiesto m WHERE m.manifiesto_id = $manifiesto_id) m LEFT JOIN dta d 
				   ON m.manifiesto_id = d.manifiesto_id ";		
					
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	  	  
	return $result;
  }
  
  public function getRemesas($manifiesto_id,$Conex){

    $select  = "SELECT r.*,r.numero_remesa,(SELECT m.medida FROM medida m WHERE medida_id = r.medida_id) AS medida,r.cantidad,r.peso,(SELECT n.naturaleza_id FROM naturaleza n WHERE naturaleza_id = r.naturaleza_id) AS naturaleza,(SELECT e.codigo FROM empaque e WHERE  empaque_id = r.empaque_id) AS empaque,(SELECT p.codigo FROM producto p WHERE producto_id = r.producto_id) AS producto,substring(r.descripcion_producto,1,40) AS descripcion_producto,r.remitente,r.destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
	(IF(r.amparada_por = 'E','EMPRESA DE TRANSPORTE',IF(r.amparada_por = 'R','REMITENTE',IF(r.amparada_por = 'D','DESTINATARIO','NO EXISTE POLIZA'))))AS dueno_poliza,
    
    
    (SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = r.aseguradora_id) AS aseguradora,
    
    
    (SELECT nit_aseguradora FROM aseguradora WHERE aseguradora_id = r.aseguradora_id) AS nit_aseguradora,r.numero_poliza,r.direccion_remitente,(SELECT naturaleza FROM naturaleza WHERE naturaleza_id = r.naturaleza_id) AS naturaleza,(SELECT empaque FROM empaque WHERE empaque_id = r.empaque_id) AS empaque
    
    
    FROM detalle_despacho d, remesa r  WHERE d.manifiesto_id = $manifiesto_id  AND d.remesa_id=r.remesa_id AND r.remesa_id = d.remesa_id ORDER BY r.numero_remesa ASC";

    $result = $this -> DbFetchAll($select,$Conex);  

    return $result;  
  
  }
  
  public function getTrafico($manifiesto_id,$Conex){
  	
	if(is_numeric($manifiesto_id)){

	  $select  = "SELECT
	  					IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
						IF(t.seguimiento_id>0,(SELECT configuracion FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT configuracion FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT configuracion FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS configuracion,
						IF(t.seguimiento_id>0,(SELECT marca FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT marca FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT marca FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS marca_vehiculo,	
						IF(t.seguimiento_id>0,(SELECT linea FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT linea FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT linea FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS linea_vehiculo,
						IF(t.seguimiento_id>0,(SELECT color FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT color FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT color FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS color_vehiculo,
						IF(t.seguimiento_id>0,(SELECT carroceria FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT carroceria FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT carroceria FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS cceria_vehiculo,						
						IF(t.seguimiento_id>0,(SELECT nombre FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT conductor FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS conductor,
						IF(t.seguimiento_id>0,(SELECT numero_identificacion FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT numero_identificacion FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT numero_identificacion FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS conductor_doc,
						IF(t.seguimiento_id>0,'Despacho Particular',IF(t.manifiesto_id>0,'Manifiesto de Carga','Despacho Urbano')) AS tipo_doc,
						IF(t.seguimiento_id>0,(SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS num_doc,
						t.fecha_inicial_salida,
						t.hora_inicial_salida,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino
	  				FROM trafico t
					WHERE t.trafico_id=(SELECT trafico_id FROM trafico WHERE manifiesto_id = $manifiesto_id LIMIT 1)";

	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
		
   	    $result = array();
	}
	return $result;
  }
  
  
  public function getDetalles($manifiesto_id,$ruta_id,$Conex){
	  
	$select_r = "SELECT ruta_id FROM trafico WHERE manifiesto_id = $manifiesto_id";	
	$result_r = $this -> DbFetchAll($select_r,$Conex,true);
	$ruta_id = $result_r[0]['ruta_id'];  	
	if(is_numeric($ruta_id)){

	  /*$select  = "SELECT p.nombre,
	  				p.direccion,
					LOWER(p.observacion) AS  observacion,
					tp.nombre AS tipo_ref,
	  				tp.nombre AS tipo_punto
	  				FROM  detalle_seguimiento d, punto_referencia p, tipo_punto_referencia tp
					WHERE d.trafico_id=$trafico_id AND p.punto_referencia_id=d.punto_referencia_id AND 
					tp.tipo_punto_referencia_id=p.tipo_punto_referencia_id  ORDER BY d.orden_det_ruta ASC "; */
					
      $select = "SELECT origen_id,destino_id FROM manifiesto WHERE manifiesto_id = $manifiesto_id";					
  	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  $origen_id  = $result[0]['origen_id'];
	  $destino_id = $result[0]['destino_id'];	  
	  
      $select     = "SELECT ubicacion_id,orden_det_ruta FROM detalle_ruta WHERE ruta_id = $ruta_id AND ubicacion_id = $origen_id";					
  	  $dataOrigen = $this -> DbFetchAll($select,$Conex,true);	
	  $orden_org  = $dataOrigen[0]['orden_det_ruta']; 	  	    
	  
      $select     = "SELECT ubicacion_id,orden_det_ruta FROM detalle_ruta WHERE ruta_id = $ruta_id AND ubicacion_id = $destino_id";					
  	  $dataDestino= $this -> DbFetchAll($select,$Conex,true);	
	  $orden_dst  = $dataDestino[0]['orden_det_ruta']; 	  	    	    	  
	  
	  $orderBy    = null;
	  
	  if($orden_org > $orden_dst){
	    $orderBy = 'DESC';
	  }else{
     	   $orderBy = 'ASC';
	    }
	  
					
      $select  = "SELECT p.nombre,
	  				p.direccion,
					LOWER(p.observacion) AS  observacion,
					tp.nombre AS tipo_ref,
	  				p.nombre AS tipo_punto
	  				FROM  detalle_ruta d, punto_referencia p, tipo_punto_referencia tp, ruta r
					WHERE r.ruta_id = $ruta_id AND r.ruta_id = d.ruta_id AND d.punto_referencia_id = p.punto_referencia_id AND 
					tp.tipo_punto_referencia_id=p.tipo_punto_referencia_id AND p.imprimir = 1 ORDER BY d.orden_det_ruta $orderBy ";		

	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	return $result;
  }
  
  public function getHojadeTiempos($manifiesto_id,$Conex){
  
    $select = "SELECT h.*,r.*, (SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id 
	FROM conductor WHERE conductor_id = h.conductor_cargue_id)) AS conductor,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor 
	WHERE conductor_id = h.conductor_cargue_id)) AS identificacion_conductor FROM hoja_de_tiempos h, remesa r,detalle_despacho d WHERE d.manifiesto_id = $manifiesto_id 
	AND d.remesa_id = r.remesa_id AND  r.remesa_id = h.remesa_id";
    $result = $this -> DbFetchAll($select,$Conex);  
	
    return $result;  	
  
  }
  
  public function getTiemposCargue($manifiesto_id,$Conex){
  
    $select = "SELECT r.*, m.nombre AS conductor, m.manifiesto,
	m.numero_identificacion  AS identificacion_conductor,
	(SELECT fecha_llegada_cargue  FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id LIMIT 1) AS fecha_llegada_lugar_cargue,
	(SELECT hora_llegada_cargue  FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id LIMIT 1) AS hora_llegada_lugar_cargue,	
	(SELECT fecha_salida_cargue  FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id LIMIT 1) AS fecha_salida_lugar_cargue,
	(SELECT hora_salida_cargue  FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id LIMIT 1) AS hora_salida_lugar_cargue
	FROM remesa r, detalle_despacho d, manifiesto m
	WHERE m.manifiesto_id=$manifiesto_id AND  d.manifiesto_id=m.manifiesto_id AND r.remesa_id=d.remesa_id ";
    $result = $this -> DbFetchAll($select,$Conex);  
	
    return $result;  	
  
  }
  
  public function getImpuestos($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id";
	 
     $result = $this -> DbFetchAll($select,$Conex);  

     return $result;    
  
  }  
  
  
  
   public function getCodigoQR($manifiesto_id,$Conex){
  
     $select = "SELECT m.manifiesto,m.aprobacion_ministerio2, m.fecha_mc, m.placa, (SELECT placa_remolque FROM remolque WHERE placa_remolque_id =m.placa_remolque_id)as remolque, (SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,(SELECT codigo_reporte FROM configuracion WHERE configuracion=m.configuracion)AS configuracion,(SELECT descripcion_producto FROM remesa WHERE remesa_id =(SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = m.manifiesto_id LIMIT 1))as producto,m.numero_identificacion as id_conductor,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = m.empresa_id)) AS empresa,m.observacionesqr,m.seguridadqr FROM manifiesto m WHERE m.manifiesto_id = $manifiesto_id";
	 
     $result = $this -> DbFetchAll($select,$Conex);  

     return $result;    
  
  }  
  
  
   
}


?>