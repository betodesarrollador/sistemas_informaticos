<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InterfazMinModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }  

  public function selectAnticiposRangoFecha($desde,$hasta,$tipo,$Conex){

 		if($tipo=='P'){
		
		$select = "SELECT ti.codigo_ministerio AS pertipid, 
		t.numero_identificacion AS periden, 
		t.primer_apellido AS perapell1, 
		t.segundo_apellido AS perapell2, 
		CONCAT_WS( ' ', t.primer_nombre, t.segundo_nombre ) AS pernombre, 
		IF(t.telefono!='',t.telefono,'4139567') AS pertelefono, 
		IF(t.direccion!='',t.direccion,'CALLE 19 A  91 - 05 CC CAPELLANIA L 46') AS perdireccion, 
		u.ubicacion_id  AS perciudad, 
		(SELECT cl.codigo FROM categoria_licencia cl, conductor c WHERE c.tercero_id = t.tercero_id AND c.categoria_id = cl.categoria_id) AS percateglice,
		(SELECT numero_licencia_cond FROM conductor c WHERE t.tercero_id = c.tercero_id) AS pernumerolice
		FROM tercero t, ubicacion u, tipo_identificacion ti 
		WHERE u.ubicacion_id = t.ubicacion_id AND ti.tipo_identificacion_id = t.tipo_identificacion_id
		AND t.tipo_identificacion_id = 1 AND t.estado = 'D' GROUP BY t.numero_identificacion"; 
		
		$personas = $this -> DbFetchAll($select,$Conex,true);
		
		}elseif($tipo=='V'){
		
		$select2 = "SELECT v.placa AS vehplaca, 
		m.marca_id AS vehmarca,
		IF(l.codigo_antiguo IS NOT NULL,l.codigo_antiguo,l.codigo_linea) AS vehlinea, 
		v.modelo_vehiculo AS vehmodelo, 
		v.modelo_repotenciado AS vehmodelotransf, 
		c.codigo AS vehcolor, 
		(SELECT codigo FROM carroceria WHERE carroceria_id=v.carroceria_id) AS vehtipocarrocer, 
		configuracion AS vehconfiguraci, 
		v.peso_vacio AS vehpeso, 
		numero_soat AS vehnro_poliza, 
		'N' AS vehtipidasegur, 
		CONCAT_WS( '', a.nit_aseguradora, a.digito_verificacion ) AS vehidenasegur, 
		v.vencimiento_soat AS vehfechvenci, 
		v.capacidad AS vehcapacidad, 
		v.numero_ejes AS vehnroejes, 
		v.combustible_id AS vehtipocombus, 
		ti.codigo_ministerio AS vehtipidpropiet,
		t.numero_identificacion AS vehidentprop, 
		ti.codigo_ministerio AS vehtipidtenenc,
		t.numero_identificacion AS vehidentenenc 
		FROM vehiculo v, marca m, linea l, color c, aseguradora a, tipo_identificacion ti, tercero t, tenedor te
		WHERE v.marca_id = m.marca_id AND v.linea_id = l.linea_id AND v.color_id = c.color_id AND v.aseguradora_soat_id = a.aseguradora_id
		AND v.propietario_id = t.tercero_id AND t.tipo_identificacion_id = ti.tipo_identificacion_id AND v.tenedor_id = te.tenedor_id AND te.tercero_id = t.tercero_id GROUP BY v.placa";
		
		$vehiculos = $this -> DbFetchAll($select2,$Conex,true);
		
		}elseif($tipo=='E'){
		
		$select3 = "
		(SELECT 'N' AS emptipid, 
		CONCAT_WS( '', t.numero_identificacion, t.digito_verificacion ) AS empident,
		CONCAT_WS(' ' ,t.primer_nombre, t.segundo_nombre,t.primer_nombre,t.segundo_nombre,t.razon_social) AS empnombr, 
		IF(t.telefono!='',t.telefono,'4139567') AS emptelefono, 
		IF(t.direccion!='',t.direccion,'CALLE 19 A  91 - 05 CC CAPELLANIA L 46') AS empdireccion, 
		u.ubicacion_id  AS empciudad, 
		(SELECT	cod_ministerio  FROM empresa WHERE tercero_id=t.tercero_id) AS empnumautoriza 
		FROM tercero t, ubicacion u 
		WHERE t.ubicacion_id = u.ubicacion_id AND t.tipo_identificacion_id = 2 AND t.estado = 'D')

		UNION ALL 
		
		(SELECT 'N' AS emptipid, 
		CONCAT_WS( '', a.nit_aseguradora, a.digito_verificacion ) AS empident, 
		a.nombre_aseguradora AS empnombr,
		telefono AS emptelefono , 
		direccion AS empdireccion, 
		ubicacion_id  AS empciudad, 
		'' AS empnumautoriza 
		FROM aseguradora a  WHERE estado=1)";
		
		$empresas = $this -> DbFetchAll($select3,$Conex,true);
		
		}elseif($tipo=='R'){
			
		$select4 = "SELECT CONCAT_WS( '', t.numero_identificacion, t.digito_verificacion ) AS nitempresa, 
		CONCAT_WS('',e.cod_ministerio,LPAD(m.manifiesto,8,0))  AS remnumero, 
		r.numero_remesa AS remnroremempresa, 
		me.ministerio AS remunida_medida, 
		r.cantidad AS remcantidad, 
		n.naturaleza_id AS remnaturaleza, 
		em.codigo_antiguo AS remunida_empaq, 
		r.peso AS remcontenedorvacio, 
		p.codigo AS remcodproducto2, 
		r.descripcion_producto AS remdescr_produ, 
		(SELECT codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = r.tipo_identificacion_remitente_id) AS remtipidremitente, 
		r.doc_remitente AS remidenremitente, 
		(SELECT ubicacion_id FROM ubicacion WHERE ubicacion_id = r.origen_id) AS remciudad_orig,
		r.direccion_remitente AS remdireccionorigen, 
		(SELECT codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = r.tipo_identificacion_destinatario_id) AS remtipiddestinatario, 
		r.doc_destinatario as remidendestinatario, 
		(SELECT ubicacion_id FROM ubicacion WHERE ubicacion_id = r.destino_id) AS remciudad_desti, 
		r.direccion_destinatario AS remdirecciondestino, 
		(SELECT codigo_ministerio FROM tipo_identificacion WHERE codigo = r.tipo_identificacion_propietario_mercancia) AS remtipidpropietario,
		r.numero_identificacion_propietario_mercancia AS remidenpropietario, 
		r.amparada_por AS remduenopoliza, 
		r.numero_poliza AS rempoliza,
		CONCAT_WS( '',a.nit_aseguradora,a.digito_verificacion) AS remaseguradora,
		r.fecha_vencimiento_poliza AS remvencimiento 
		
		FROM tercero t, remesa r, oficina o, empresa e, manifiesto m, detalle_despacho dd, medida me, naturaleza n, empaque em, producto p, aseguradora a
		WHERE r.oficina_id = o.oficina_id AND o.empresa_id = e.empresa_id AND e.tercero_id = t.tercero_id AND r.remesa_id = dd.remesa_id AND dd.manifiesto_id = m.manifiesto_id
		AND m.manifiesto_id AND m.estado != 'A' AND r.medida_id = me.medida_id AND r.naturaleza_id = n.naturaleza_id AND r.empaque_id = em.empaque_id
		AND r.producto_id = p.producto_id AND r.aseguradora_id = a.aseguradora_id AND (DATE(r.fecha_remesa) BETWEEN date('$desde') AND date('$hasta'))";
	
		$remesas = $this -> DbFetchAll($select4,$Conex,true);
		
		}elseif($tipo=='M'){
			
		$select5 = "SELECT CONCAT_WS( '', t.numero_identificacion, t.digito_verificacion ) AS nitempresa, 
		CONCAT_WS('',e.cod_ministerio,LPAD(m.manifiesto,8,0)) AS mannumero, 
		m.fecha_mc AS manfechexped,
		m.origen_id	 AS manciud_origen, 
		m.destino_id AS manciud_destin, 
		m.placa AS manplaca, 
		IF(m.tipo_identificacion_conductor_codigo>0,(SELECT codigo_ministerio FROM tipo_identificacion WHERE codigo = m.tipo_identificacion_conductor_codigo ), m.tipo_identificacion_conductor_codigo) AS mantipidconduc,
		m.numero_identificacion AS manidenconduc, 
		m.placa_remolque AS manplacsemir, 
		m.valor_flete AS manvlrtoviaje, 
		(SELECT im.valor FROM impuestos_manifiesto im, tabla_impuestos ti WHERE im.manifiesto_id = m.manifiesto_id AND ti.impuesto_id=im.impuesto_id AND ti.oficina_id=m.oficina_id AND ti.rte=1 LIMIT 1 ) AS manretefuente,
		(SELECT im.valor FROM impuestos_manifiesto im, tabla_impuestos ti WHERE im.manifiesto_id = m.manifiesto_id AND ti.impuesto_id=im.impuesto_id AND ti.oficina_id=m.oficina_id AND ti.ica=1 LIMIT 1 ) AS mandescu_ley, 
		(SELECT valor FROM anticipos_manifiesto WHERE manifiesto_id=m.manifiesto_id LIMIT 1) AS manvlr_anticip,
		u.ubicacion_id AS manlugar_pago, 
		m.fecha_pago_saldo AS manfechpagsal, 
		CASE m.cargue_pagado_por WHEN 'E' THEN 'R' WHEN 'C' THEN 'R' WHEN 'CL' THEN 'R' WHEN 'R' THEN 'R' WHEN 'D' THEN 'D' WHEN 'DE' THEN 'D' WHEN 'RE' THEN 'R' ELSE 'R' END AS manpago_cargue, 
		CASE m.descargue_pagado_por WHEN 'E' THEN 'D' WHEN 'C' THEN 'D' WHEN 'CL' THEN 'R' WHEN 'R' THEN 'R' WHEN 'D' THEN 'D' WHEN 'DE' THEN 'D' WHEN 'RE' THEN 'R' ELSE 'R' END  AS manpago_descar,
		m.observaciones AS manobservacion, 
		
		(SELECT tip.codigo_ministerio FROM tipo_identificacion tip, tenedor te, tercero tr  
		 WHERE te.tenedor_id=m.titular_manifiesto_id AND tr.tercero_id=te.tercero_id AND tip.tipo_identificacion_id=tr.tipo_identificacion_id ) AS mantipidtitular,
		
		m.numero_identificacion_titular_manifiesto AS manidentitular, 
		m.fecha_entrega_mcia_mc AS manfechaentrega, 
		tm.codigo AS mantipomanifiesto,
		CASE m.estado WHEN 'A' THEN 'A' WHEN 'P' THEN 'R' WHEN 'M' THEN 'R' WHEN 'L' THEN 'R' ELSE 'R' END AS manestado 
		FROM  tercero t, manifiesto m, oficina o, empresa e, ubicacion u, tipo_manifiesto tm
		WHERE m.oficina_id = o.oficina_id AND o.empresa_id = e.empresa_id AND e.tercero_id = t.tercero_id  AND m.lugar_pago_saldo = u.nombre
		AND m.tipo_manifiesto_id = tm.tipo_manifiesto_id AND (DATE(m.fecha_mc) BETWEEN date('$desde') AND date('$hasta'))";
	
		$manifiestos = $this -> DbFetchAll($select5,$Conex,true);
		
		}elseif($tipo=='T'){
			
		$select6 = "SELECT  
		CONCAT_WS('',e.cod_ministerio,LPAD(m.manifiesto,8,0))  AS Mannumero, 
		r.numero_remesa AS Remnumero,
		
		IF((SELECT horas_pactadas_cargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id)>0,(SELECT horas_pactadas_cargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),15) AS Remhoraspactocargue,
		IF((SELECT horas_pactadas_descargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id)>0,(SELECT horas_pactadas_descargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),15) AS Remhoraspactodescargue,
		
		IF((SELECT fecha_llegada_lugar_cargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT fecha_llegada_lugar_cargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT fecha_llegada_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT fecha_llegada_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				DATE(SUBTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'02:00:00'))    )) AS Remfechallegacargue,
		
		IF((SELECT hora_llegada_lugar_cargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT hora_llegada_lugar_cargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT hora_llegada_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT hora_llegada_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				TIME(SUBTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'02:00:00'))    )) AS Remhorallegacargue,
		
		IF((SELECT fecha_salida_lugar_cargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT fecha_salida_lugar_cargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT fecha_salida_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT fecha_salida_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				m.fecha_estimada_salida    )) AS Remfechafincargue,
		
		IF((SELECT hora_salida_lugar_cargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT hora_salida_lugar_cargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT hora_salida_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT hora_salida_cargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				m.hora_estimada_salida    )) AS Remhorafincargue,
		
		IF((SELECT fecha_llegada_lugar_descargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT fecha_llegada_lugar_descargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT fecha_llegada_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT fecha_llegada_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				m.fecha_entrega_mcia_mc    )) AS Remfechainiciodescargue,
		
		IF((SELECT hora_llegada_lugar_descargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT hora_llegada_lugar_descargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT hora_llegada_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT hora_llegada_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				m.hora_entrega    )) AS Remhorainiciodescargue,
		
		IF((SELECT fecha_salida_lugar_descargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT fecha_salida_lugar_descargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT fecha_salida_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT fecha_salida_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00'))    ))	 AS Remfechafindescargue,
		
		IF((SELECT hora_salida_lugar_descargue  FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id) IS NOT NULL,
			(SELECT hora_salida_lugar_descargue FROM hoja_de_tiempos WHERE remesa_id=r.remesa_id),
			IF((SELECT hora_salida_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id) !='',
				(SELECT hora_salida_descargue FROM tiempos_clientes_remesas WHERE manifiesto_id=m.manifiesto_id AND cliente_id=r.cliente_id), 
				TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00'))    )) AS Remhorafindescargue 
		
		FROM  manifiesto m, detalle_despacho dd, remesa r, oficina o, empresa e
		WHERE m.estado !='A' AND (DATE(m.fecha_mc) BETWEEN '$desde' AND '$hasta') AND dd.manifiesto_id=m.manifiesto_id AND r.remesa_id=dd.remesa_id AND r.estado!='A' AND r.estado!='AN'
		 AND m.oficina_id = o.oficina_id AND o.empresa_id = e.empresa_id";
		$tiempos = $this -> DbFetchAll($select6,$Conex,true);
		
		}
			
	$arrayInterfaz = array();	 
	
	if($tipo=='P'){
	   
   		for($i = 0; $i < count($personas); $i++){
         	
			$pertipid	   = $personas[$i]['pertipid'];
			$periden 	   = $personas[$i]['periden'];
			$perapell1	   = $personas[$i]['perapell1'];
			$perapell2 	   = $personas[$i]['perapell2'];
			$pernombre 	   = $personas[$i]['pernombre'];
			$pertelefono   = $personas[$i]['pertelefono'];
			$perdireccion  = $personas[$i]['perdireccion'];
			$perciudad     = $personas[$i]['perciudad'];
			$percateglice  = $personas[$i]['percateglice'];
			$pernumerolice = $personas[$i]['pernumerolice'];
							
			$arrayInterfaz[$i]['pertipid']      = substr($personas[$i]['pertipid'],0,1);	
			$arrayInterfaz[$i]['periden']       = substr($personas[$i]['periden'],0,11);		
			$arrayInterfaz[$i]['perapell1']     = utf8_decode(substr($personas[$i]['perapell1'],0,12));	
			$arrayInterfaz[$i]['perapell2']     = utf8_decode(substr($personas[$i]['perapell2'],0,12));				
			$arrayInterfaz[$i]['pernombre']     = utf8_decode(substr($personas[$i]['pernombre'],0,20));	
			$arrayInterfaz[$i]['pertelefono']   = substr($personas[$i]['pertelefono'],0,10);					
			$arrayInterfaz[$i]['perdireccion']  = utf8_decode(substr($personas[$i]['perdireccion'],0,100));	
			$arrayInterfaz[$i]['perciudad']     = utf8_decode(substr($personas[$i]['perciudad'],0,8));	
			$arrayInterfaz[$i]['percateglice']  = substr($personas[$i]['percateglice'],0,3);		
			$arrayInterfaz[$i]['pernumerolice'] = substr($personas[$i]['pernumerolice'],0,15);
	
	 	} // FIN FOR	    	 
		// FIN PERSONAS
	}elseif($tipo=='V'){
      	
		for($i = 0; $i < count($vehiculos); $i++){
         	
			$vehplaca 		 = $vehiculos[$i]['vehplaca'];
			$vehmarca 		 = $vehiculos[$i]['vehmarca'];
			$vehlinea 	     = $vehiculos[$i]['vehlinea'];
			$vehmodelo 		 = $vehiculos[$i]['vehmodelo'];
			$vehmodelotransf = $vehiculos[$i]['vehmodelotransf'];
			$vehcolor 		 = $vehiculos[$i]['vehcolor'];
			$vehtipocarrocer = $vehiculos[$i]['vehtipocarrocer'];
			$vehconfiguraci  = $vehiculos[$i]['vehconfiguraci'];
			$vehpeso 		 = $vehiculos[$i]['vehpeso'];
			$vehnro_poliza	 = $vehiculos[$i]['vehnro_poliza']; 
			$vehtipidasegur  = $vehiculos[$i]['vehtipidasegur'];
			$vehidenasegur 	 = $vehiculos[$i]['vehidenasegur'];
			$vehfechvenci 	 = $vehiculos[$i]['vehfechvenci'];
			$vehcapacidad 	 = $vehiculos[$i]['vehcapacidad'];
			$vehnroejes 	 = $vehiculos[$i]['vehnroejes'];
			$vehtipocombus 	 = $vehiculos[$i]['vehtipocombus'];
			$vehtipidpropiet = $vehiculos[$i]['vehtipidpropiet'];
			$vehidentprop 	 = $vehiculos[$i]['vehidentprop'];
			$vehtipidtenenc	 = $vehiculos[$i]['vehtipidtenenc'];
			$vehidentenenc   = $vehiculos[$i]['vehidentenenc'];
							
			$arrayInterfaz[$i]['vehplaca']         = substr($vehiculos[$i]['vehplaca'],0,6);	
			$arrayInterfaz[$i]['vehmarca']         = substr($vehiculos[$i]['vehmarca'],0,3);		
			$arrayInterfaz[$i]['vehlinea']         = substr($vehiculos[$i]['vehlinea'],0,3);	
			$arrayInterfaz[$i]['vehmodelo']        = substr($vehiculos[$i]['vehmodelo'],0,4);				
			$arrayInterfaz[$i]['vehmodelotransf']  = substr($vehiculos[$i]['vehmodelotransf'],0,4);	
			$arrayInterfaz[$i]['vehcolor']   	   = substr($vehiculos[$i]['vehcolor'],0,3);					
			$arrayInterfaz[$i]['vehtipocarrocer']  = substr($vehiculos[$i]['vehtipocarrocer'],0,3);	
			$arrayInterfaz[$i]['vehconfiguraci']   = substr($vehiculos[$i]['vehconfiguraci'],0,2);	
			$arrayInterfaz[$i]['vehpeso']  		   = substr($vehiculos[$i]['vehpeso'],0,5);		
			$arrayInterfaz[$i]['vehnro_poliza']    = substr($vehiculos[$i]['vehnro_poliza'],0,20);
			$arrayInterfaz[$i]['vehtipidasegur']   = substr($vehiculos[$i]['vehtipidasegur'],0,1);	
			$arrayInterfaz[$i]['vehidenasegur']    = substr($vehiculos[$i]['vehidenasegur'],0,11);		
			$arrayInterfaz[$i]['vehfechvenci']     = substr($vehiculos[$i]['vehfechvenci'],0,10);	
			$arrayInterfaz[$i]['vehcapacidad']     = substr($vehiculos[$i]['vehcapacidad'],0,5);				
			$arrayInterfaz[$i]['vehnroejes']       = substr($vehiculos[$i]['vehnroejes'],0,2);	
			$arrayInterfaz[$i]['vehtipocombus']    = substr($vehiculos[$i]['vehtipocombus'],0,2);					
			$arrayInterfaz[$i]['vehtipidpropiet']  = substr($vehiculos[$i]['vehtipidpropiet'],0,1);	
			$arrayInterfaz[$i]['vehidentprop']     = substr($vehiculos[$i]['vehidentprop'],0,11);	
			$arrayInterfaz[$i]['vehtipidtenenc']   = substr($vehiculos[$i]['vehtipidtenenc'],0,1);		
			$arrayInterfaz[$i]['vehidentenenc']    = substr($vehiculos[$i]['vehidentenenc'],0,11);

	 	} // FIN FOR	 
		// FIN VEHICULOS
		}elseif($tipo=='E'){
   
   		for($i = 0; $i < count($empresas); $i++){
         	
			$emptipid 		= $empresas[$i]['emptipid'];
			$empident 		= $empresas[$i]['empident'];
			$empnombr 		= $empresas[$i]['empnombr'];
			$emptelefono 	= $empresas[$i]['emptelefono'];
			$empdireccion 	= $empresas[$i]['empdireccion'];
			$empciudad 		= $empresas[$i]['empciudad'];
			$empnumautoriza = $empresas[$i]['empnumautoriza'];
					
			$arrayInterfaz[$i]['emptipid']       = substr($empresas[$i]['emptipid'],0,1);	
			$arrayInterfaz[$i]['empident']       = substr($empresas[$i]['empident'],0,11);		
			$arrayInterfaz[$i]['empnombr']       = utf8_decode(substr($empresas[$i]['empnombr'],0,200));	
			$arrayInterfaz[$i]['emptelefono']    = substr($empresas[$i]['emptelefono'],0,10);				
			$arrayInterfaz[$i]['empdireccion']   = utf8_decode(substr($empresas[$i]['empdireccion'],0,100));	
			$arrayInterfaz[$i]['empciudad']   	 = utf8_decode(substr($empresas[$i]['empciudad'],0,8));					
			$arrayInterfaz[$i]['empnumautoriza'] = substr($empresas[$i]['empnumautoriza'],0,4);	
		
	 	} // FIN FOR	 
		// FIN EMPRESAS
		} elseif($tipo=='R'){
      	
		for($i = 0; $i < count($remesas); $i++){
		
			$nitempresa 			 = substr($remesas[$i]['nitempresa'],0,11);//1 nit empresa
			$remnumero 		 		 = substr($remesas[$i]['remnumero'],0,20);//2	numero planilla
			$remnroremempresa 	     = substr($remesas[$i]['remnroremempresa'],0,15);//3	numero remesa
			$remunida_medida 		 = substr($remesas[$i]['remunida_medida'],0,1); //4	unidad de medida	
			$remcantidad 			 = $remesas[$i]['remcantidad'];//5 cantidad
			$remnaturaleza 			 = $remesas[$i]['remnaturaleza'];//6	naturaleza
			$remunida_empaq 		 = $remesas[$i]['remunida_empaq'];//7	 unidad empaque
			$remcontenedorvacio  	 = $remesas[$i]['remcontenedorvacio'];//8 contenedor vacio
			$remcodproducto2 		 = $remesas[$i]['remcodproducto2'];//9 codigo producto
			$remdescr_produ	 		 = $remesas[$i]['remdescr_produ']; //10 descripcion producto
			$remtipidremitente  	 = $remesas[$i]['remtipidremitente'];//11 tipo ident remitente
			$remidenremitente 	 	 = $remesas[$i]['remidenremitente'];//12 numero iden remitente	
			$remciudad_orig 	 	 = $remesas[$i]['remciudad_orig'];//13 ciudad origen
			$remdireccionorigen      = utf8_decode($remesas[$i]['remdireccionorigen']);	//14 direccion del remitente	agregado
			$remtipiddestinatario 	 = $remesas[$i]['remtipiddestinatario'];//15 tipo iden destinatario
			$remidendestinatario 	 = $remesas[$i]['remidendestinatario'];//16 número de identificacion del destinatario
			$remciudad_desti 	 	 = $remesas[$i]['remciudad_desti'];//17 municipio destino 	
			$remdirecciondestino 	 = $remesas[$i]['remdirecciondestino'];//18 direccion destino 
			$remtipidpropietario 	 = $remesas[$i]['remtipidpropietario'];//19 tipo iden propietario
			$remidenpropietario	 	 = $remesas[$i]['remidenpropietario'];//20 num iden propietario	
			$remduenopoliza   		 = $remesas[$i]['remduenopoliza'];	//21 dueno poliza		
			$rempoliza 				 = $remesas[$i]['rempoliza'];//22 numero poliza	
			$remaseguradora	 	 	 = $remesas[$i]['remaseguradora'];//23 aseguradora
			$remvencimiento   		 = substr(str_replace("-","",$remesas[$i]['remvencimiento']),0,10);//24 aseguradora	
							
			$arrayInterfaz[$i]['nitempresa']         	   = substr($remesas[$i]['nitempresa'],0,11);	//1 nit empresa
			$arrayInterfaz[$i]['remnumero']          	   = substr($remesas[$i]['remnumero'],0,20);	//2	numero planilla
			$arrayInterfaz[$i]['remnroremempresa']         = substr($remesas[$i]['remnroremempresa'],0,15); //3	numero remesa
			$arrayInterfaz[$i]['remunida_medida']          = substr($remesas[$i]['remunida_medida'],0,1); //4	unidad de medida			
			$arrayInterfaz[$i]['remcantidad']  			   = substr($remesas[$i]['remcantidad'],0,6);	//5 cantidad
			$arrayInterfaz[$i]['remnaturaleza']   	   	   = substr($remesas[$i]['remnaturaleza'],0,1);	//6	naturaleza
			$arrayInterfaz[$i]['remunida_empaq']  		   = substr($remesas[$i]['remunida_empaq'],0,2);//7	 unidad empaque
			$arrayInterfaz[$i]['remcontenedorvacio']   	   = substr($remesas[$i]['remcontenedorvacio'],0,5); //8 contenedor vacio
			$arrayInterfaz[$i]['remcodproducto2']  		   = substr($remesas[$i]['remcodproducto2'],0,6);	//9 codigo producto
			$arrayInterfaz[$i]['remdescr_produ']    	   = utf8_decode(substr($remesas[$i]['remdescr_produ'],0,60)); //10 descripcion producto
			$arrayInterfaz[$i]['remtipidremitente']   	   = substr($remesas[$i]['remtipidremitente'],0,1); //11 tipo ident remitente
			$arrayInterfaz[$i]['remidenremitente']    	   = substr($remesas[$i]['remidenremitente'],0,11);	//12 numero iden remitente	
			$arrayInterfaz[$i]['remciudad_orig']       	   = substr($remesas[$i]['remciudad_orig'],0,8);	//13 ciudad origen	
			$arrayInterfaz[$i]['remdireccionorigen']       = utf8_decode(substr($remesas[$i]['remdireccionorigen'],0,100));	//14 direccion del remitente	agregado
			$arrayInterfaz[$i]['remtipiddestinatario']     = substr($remesas[$i]['remtipiddestinatario'],0,1);	//15 tipo iden destinatario
			$arrayInterfaz[$i]['remidendestinatario']      = substr($remesas[$i]['remidendestinatario'],0,11);	//16 número de identificacion del destinatario
			$arrayInterfaz[$i]['remciudad_desti']    	   = substr($remesas[$i]['remciudad_desti'],0,8);	//17 municipio destino 			
			$arrayInterfaz[$i]['remdirecciondestino']  	   = utf8_decode(substr($remesas[$i]['remdirecciondestino'],0,100)); //18 direccion destino 	
			$arrayInterfaz[$i]['remtipidpropietario']      = substr($remesas[$i]['remtipidpropietario'],0,1); //19 tipo iden propietario
			$arrayInterfaz[$i]['remidenpropietario']   	   = substr($remesas[$i]['remidenpropietario'],0,11);	//20 num iden propietario	
			$arrayInterfaz[$i]['remduenopoliza']    	   = substr($remesas[$i]['remduenopoliza'],0,1);//21 dueno poliza	
			$arrayInterfaz[$i]['rempoliza']     		   = substr($remesas[$i]['rempoliza'],0,20);	//22 numero poliza	
			$arrayInterfaz[$i]['remaseguradora']   		   = substr($remesas[$i]['remaseguradora'],0,11);	//23 aseguradora	
			$arrayInterfaz[$i]['remvencimiento']    	   = substr(str_replace("-","",$remesas[$i]['remvencimiento']),0,10);//24 aseguradora	

	 	} // FIN FOR
		 // FIN REMESAS
		}elseif($tipo=='M'){
      	
		for($i = 0; $i < count($manifiestos); $i++){
		
			$nitempresa 			 = $manifiestos[$i]['nitempresa'];
			$mannumero 		 		 = $manifiestos[$i]['mannumero'];
			$manfechexped 	    	 = $manifiestos[$i]['manfechexped'];
			$manciud_origen 		 = $manifiestos[$i]['manciud_origen'];
			$manciud_destin			 = $manifiestos[$i]['manciud_destin'];
			$manplaca	 			 = $manifiestos[$i]['manplaca'];
			$mantipidconduc 		 = $manifiestos[$i]['mantipidconduc'];
			$manidenconduc		  	 = $manifiestos[$i]['manidenconduc'];
			$manplacsemir	 		 = $manifiestos[$i]['manplacsemir'];
			$manvlrtoviaje	 		 = $manifiestos[$i]['manvlrtoviaje']; 
			$manretefuente		  	 = $manifiestos[$i]['manretefuente'];
			$mandescu_ley	 	 	 = $manifiestos[$i]['mandescu_ley'];
			$manvlr_anticip 	 	 = $manifiestos[$i]['manvlr_anticip'];
			$manlugar_pago		 	 = $manifiestos[$i]['manlugar_pago'];
			$manfechpagsal		 	 = $manifiestos[$i]['manfechpagsal'];
			$manpago_cargue 	 	 = $manifiestos[$i]['manpago_cargue'];
			$manpago_descar		 	 = $manifiestos[$i]['manpago_descar'];
			$manobservacion		 	 = $manifiestos[$i]['manobservacion'];
			$mantipidtitular	 	 = $manifiestos[$i]['mantipidtitular'];
			$manidentitular   		 = $manifiestos[$i]['manidentitular'];			
			$manfechaentrega		 = $manifiestos[$i]['manfechaentrega'];
			$mantipomanifiesto 	 	 = $manifiestos[$i]['mantipomanifiesto'];
			$manestado		   		 = $manifiestos[$i]['manestado'];
							
			$arrayInterfaz[$i]['nitempresa']          = substr($manifiestos[$i]['nitempresa'],0,11);//1 nit empresa que expide manifiesto	
			$arrayInterfaz[$i]['mannumero']           = substr($manifiestos[$i]['mannumero'],0,15);	//2 numero manifiesto	
			$arrayInterfaz[$i]['manfechexped']        = substr($manifiestos[$i]['manfechexped'],0,10);	//3 fecha expedicion
			$arrayInterfaz[$i]['manciud_origen']      = substr($manifiestos[$i]['manciud_origen'],0,8);	//4 ciudad origen
			$arrayInterfaz[$i]['manciud_destin']  	  = substr($manifiestos[$i]['manciud_destin'],0,8);	//5 ciudad destino
			$arrayInterfaz[$i]['manplaca']   	   	  = substr($manifiestos[$i]['manplaca'],0,6);	//6 placa				
			$arrayInterfaz[$i]['mantipidconduc']  	  = substr($manifiestos[$i]['mantipidconduc'],0,1);	//7 tipo iden conductor	
			$arrayInterfaz[$i]['manidenconduc']   	  = substr($manifiestos[$i]['manidenconduc'],0,11);	//8 num iden conductor	
			$arrayInterfaz[$i]['manplacsemir']  	  = substr($manifiestos[$i]['manplacsemir'],0,6);	//9 num placa semiremolque	
			$arrayInterfaz[$i]['manvlrtoviaje']    	  = substr($manifiestos[$i]['manvlrtoviaje'],0,12);//10 valor pactado viaje	
			$arrayInterfaz[$i]['manretefuente']   	  = substr($manifiestos[$i]['manretefuente'],0,12);	//11 retefuente	
			$arrayInterfaz[$i]['mandescu_ley']    	  = substr($manifiestos[$i]['mandescu_ley'],0,12);	//12 reteica
			$arrayInterfaz[$i]['manvlr_anticip']      = substr($manifiestos[$i]['manvlr_anticip'],0,12);//13 anticipo 1 conductor	
			$arrayInterfaz[$i]['manlugar_pago']       = substr($manifiestos[$i]['manlugar_pago'],0,8);	//14 codigo ciudad pago saldo ojo colocaron departamento				
			$arrayInterfaz[$i]['manfechpagsal']       = substr(str_replace("-","",$manifiestos[$i]['manfechpagsal']),0,10);	//15 fecha pago saldo
			$arrayInterfaz[$i]['manpago_cargue']      = substr($manifiestos[$i]['manpago_cargue'],0,1);		//16 pago cargue D DESTINATARIO R REMITENTE
			$arrayInterfaz[$i]['manpago_descar']  	  = substr($manifiestos[$i]['manpago_descar'],0,1);	//17 pago descargue D DESTINATARIO R REMITENTE
			$arrayInterfaz[$i]['manobservacion']      = utf8_decode(substr($manifiestos[$i]['manobservacion'],0,200));	//18 observacion
			$arrayInterfaz[$i]['mantipidtitular']     = substr($manifiestos[$i]['mantipidtitular'],0,1);//19 tipo iden titular
			$arrayInterfaz[$i]['manidentitular']      = substr($manifiestos[$i]['manidentitular'],0,11);//20 num iden titular
			$arrayInterfaz[$i]['manfechaentrega']     = substr(str_replace("-","",$manifiestos[$i]['manfechaentrega']),0,10);	//21 fecha entrega
			$arrayInterfaz[$i]['mantipomanifiesto']   = substr($manifiestos[$i]['mantipomanifiesto'],0,1);		//22 fecha entrega
			$arrayInterfaz[$i]['manestado']    	   	  = substr($manifiestos[$i]['manestado'],0,30);//23 estado

	 	} // FIN FOR
		 // FIN MANIFIESTOS
		}elseif($tipo=='T'){
      	
		for($i = 0; $i < count($tiempos); $i++){

			$Mannumero 		 		 = $tiempos[$i]['Mannumero'];
			$Remnumero 	    	 	 = $tiempos[$i]['Remnumero'];
			$Remhoraspactocargue	 = $tiempos[$i]['Remhoraspactocargue'];
			$Remhoraspactodescargue	 = $tiempos[$i]['Remhoraspactodescargue'];
			$Remfechallegacargue	 = $tiempos[$i]['Remfechallegacargue'];
			$Remhorallegacargue 	 = $tiempos[$i]['Remhorallegacargue'];
			$Remfechafincargue		 = $tiempos[$i]['Remfechafincargue'];
			$Remhorafincargue	 	 = $tiempos[$i]['Remhorafincargue'];
			$Remfechainiciodescargue = $tiempos[$i]['Remfechainiciodescargue']; 
			$Remhorainiciodescargue	 = $tiempos[$i]['Remhorainiciodescargue'];
			$Remfechafindescargu 	 = $tiempos[$i]['Remfechafindescargue'];
			$Remhorafindescargue 	 = $tiempos[$i]['Remhorafindescargue'];
							
			$arrayInterfaz[$i]['Mannumero']           		= substr($tiempos[$i]['Mannumero'],0,15);		
			$arrayInterfaz[$i]['Remnumero']        			= substr($tiempos[$i]['Remnumero'],0,20);	
			$arrayInterfaz[$i]['Remhoraspactocargue']      	= substr($tiempos[$i]['Remhoraspactocargue'],0,3);				
			$arrayInterfaz[$i]['Remhoraspactodescargue']  	= substr($tiempos[$i]['Remhoraspactodescargue'],0,3);	
			$arrayInterfaz[$i]['Remfechallegacargue']   	= substr(str_replace("-","",$tiempos[$i]['Remfechallegacargue']),0,8);					
			$arrayInterfaz[$i]['Remhorallegacargue']  	  	= substr($tiempos[$i]['Remhorallegacargue'],0,5);	
			$arrayInterfaz[$i]['Remfechafincargue']   	  	= substr(str_replace("-","",$tiempos[$i]['Remfechafincargue']),0,8);	
			$arrayInterfaz[$i]['Remhorafincargue']  	  	= substr($tiempos[$i]['Remhorafincargue'],0,5);		
			$arrayInterfaz[$i]['Remfechainiciodescargue']   = substr(str_replace("-","",$tiempos[$i]['Remfechainiciodescargue']),0,8);
			$arrayInterfaz[$i]['Remhorainiciodescargue']   	= substr($tiempos[$i]['Remhorainiciodescargue'],0,5);	
			$arrayInterfaz[$i]['Remfechafindescargue']    	= substr(str_replace("-","",$tiempos[$i]['Remfechafindescargue']),0,8);		
			$arrayInterfaz[$i]['Remhorafindescargue']      	= substr($tiempos[$i]['Remhorafindescargue'],0,5);	

	 	} // FIN FOR

	} // FIN TIEMPOS
		
 	return $arrayInterfaz;
	
	//echo $arrayInterfaz;
	
   } 
 
}

?>