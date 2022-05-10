<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DespachosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getOficinas($empresa_id,$oficina_id,$Conex){  
  
   $select = "SELECT oficina_id AS value, nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id";
   $result = $this -> DbFetchAll($select,$Conex);	  
   return $result;	  	    
   
  }  
 
       

  public function selectInformacionRemesas($empresa_id,$oficina_id,$Conex){

    $fecha_inicio       = $this -> requestData('fecha_inicio');
    $fecha_final        = $this -> requestData('fecha_final');
    $opciones_conductor = $this -> requestData('opciones_conductor');
    $conductor_id       = $this -> requestData('conductor_id');
    $opciones_placa     = $this -> requestData('opciones_placa');
    $placa_id           = $this -> requestData('placa_id');		
    $opciones_oficinas  = $this -> requestData('opciones_oficinas');	
    $oficina_id         = $this -> requestData('oficina_id');
    $opciones_estado    = $this -> requestData('opciones_estado');	
    $estado             = $this -> requestData('estado');

    $opciones_documento    = $this -> requestData('opciones_documento');	
    $documento             = $this -> requestData('documento');


	$condicionConductor = $opciones_conductor == 'U' ? " AND m.conductor_id =$conductor_id " : '';
	$condicionPlaca = $opciones_placa == 'U' ?  " AND m.placa_id = $placa_id " : '';
	$condicionOficinas = $opciones_oficinas=='U' ? " AND m.oficina_id IN ($oficina_id) " : "";	  
	$estado            = str_replace(',',"','",$estado);
	$condicionEstado   = $opciones_estado=='U' ? " AND m.estado IN ('$estado')" : "";
		
	$select    = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";  
	$impuestos = $this -> DbFetchAll($select,$Conex,true);		  

	$tam_impuestos=count($impuestos);
	$cadena_imp_m='';
	$cadena_imp_ml='';
	$cadena_imp_d='';
	$cadena_imp_dl='';	


	for($i = 0; $i < $tam_impuestos; $i++){
	   $comparar = $impuestos[$i]['nombre'];		
	   $arreglo_car=array('%','*','/','+');
	   $nombre   = strtoupper(preg_replace( "([ ]+)", "", str_replace($arreglo_car,'',$impuestos[$i]['nombre'])));
	   $nombre	=  str_replace('.','',$nombre);
	   
	   $cadena_imp_ml .= "IF (m.estado!='A', 
							(SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND liquidacion_despacho_id=ld.liquidacion_despacho_id AND UPPER(TRIM(descripcion)) LIKE UPPER(TRIM('".$comparar."%'))  )
	   					,0) AS $nombre,";

	   $cadena_imp_m .= "IF (m.estado!='A', 
						   	(SELECT SUM(valor) AS valor FROM impuestos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')))
	   					,0) AS $nombre,";

	   $cadena_imp_dl .= "IF (m.estado!='A', 
							(SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND liquidacion_despacho_id=ld.liquidacion_despacho_id AND UPPER(TRIM(descripcion)) LIKE UPPER(TRIM('".$comparar."%'))  )
	   					,0) AS $nombre,";


	   $cadena_imp_d .= "IF (m.estado!='A', 
						   	(SELECT SUM(valor) AS valor FROM impuestos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')))
	   					,0) AS $nombre,";
		
	}


	$select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
	$descuentos = $this -> DbFetchAll($select,$Conex,true);	

	$tam_descuentos=count($descuentos);
	$cadena_des_m='';
	$cadena_des_ml='';
	$cadena_des_d='';
	$cadena_des_dl='';	
	
	for($i = 0; $i < $tam_descuentos; $i++){
	   $comparar = $descuentos[$i]['nombre'];		   	  	  	  
	   $nombre   = strtoupper(preg_replace( "([ ]+)", "", str_replace('%','',$descuentos[$i]['nombre'])));
	   $nombre	=  str_replace('.','',$nombre);
	   
	   $cadena_des_ml .= "IF (m.estado!='A', 
							(SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE descuento = 1 AND liquidacion_despacho_id=ld.liquidacion_despacho_id AND  UPPER(TRIM(descripcion)) LIKE UPPER(TRIM('".$comparar."%')) )
	   					,0) AS $nombre,";

	   $cadena_des_m .= "IF (m.estado!='A', 
						   	(SELECT SUM(valor) AS valor FROM descuentos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')))
	   					,0) AS $nombre,";

	   $cadena_des_dl .= "IF (m.estado!='A', 
							(SELECT SUM(valor) AS valor FROM detalle_liquidacion_despacho WHERE descuento = 1 AND liquidacion_despacho_id=ld.liquidacion_despacho_id AND UPPER(TRIM(descripcion)) LIKE UPPER(TRIM('".$comparar."%')) )
	   					,0) AS $nombre,";


	   $cadena_des_d .= "IF (m.estado!='A', 
						   	(SELECT SUM(valor) AS valor FROM descuentos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id AND UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')))
	   					,0) AS $nombre,";
		
	}

    $select_man = "
	(SELECT 
	 m.manifiesto_id,
 	 '' AS despachos_urbanos_id,
	(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina,
	m.placa,
	m.nombre AS conductor,
	m.numero_identificacion,
	m.tenedor,
	m.numero_identificacion_tenedor,
	m.manifiesto AS num_planilla,
	'SI' AS nacional,
	IF(m.propio = 1,'SI','NO') AS propio,
	IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,
	m.fecha_mc AS fecha_planilla,
	(SELECT nombre FROM oficina WHERE oficina_id= ld.oficina_id) AS lugar_autorizado_pago,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.destino_id) AS destino,
	(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id) AS numero_anticipos,
	ld.fecha AS fecha_liquidacion,
	'' AS fecha_legalizacion,
	IF(m.estado!='A',IF(ld.valor_despacho > 0,ld.valor_despacho,m.valor_flete),'0') AS valor_total,
	$cadena_imp_ml	
	IF(m.estado!='A',(SELECT SUM(valor) AS valor FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id),'0') AS anticipos,
	$cadena_des_ml	
	IF(m.estado!='A',IF(ld.saldo_por_pagar >=0,ld.saldo_por_pagar,m.saldo_por_pagar),'0') AS saldo_por_pagar
	FROM liquidacion_despacho ld, manifiesto m
	WHERE  ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$fecha_inicio' AND '$fecha_final' 
	$condicionConductor $condicionPlaca $condicionOficinas $condicionEstado  
	ORDER BY m.oficina_id,m.fecha_mc ASC )
	
	UNION ALL
	
	(
	(SELECT 
	 m.manifiesto_id,
	 '' AS despachos_urbanos_id,
	(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina,
	m.placa,
	m.nombre AS conductor,
	m.numero_identificacion,
	m.tenedor,
	m.numero_identificacion_tenedor,
	m.manifiesto AS num_planilla,
	'SI' AS nacional,
	IF(m.propio = 1,'SI','NO') AS propio,
	IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,
	m.fecha_mc AS fecha_planilla,
	m.lugar_pago_saldo AS lugar_autorizado_pago,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.destino_id) AS destino,
	(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id) AS numero_anticipos,
	'N/A' AS fecha_liquidacion,
	(SELECT fecha FROM legalizacion_manifiesto WHERE manifiesto_id=m.manifiesto_id) AS fecha_legalizacion,
	IF(m.estado!='A',m.valor_flete,'0') AS valor_total,
	$cadena_imp_m	
	IF(m.estado!='A',(SELECT SUM(valor) AS valor FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id),'0') AS anticipos,
	$cadena_des_m	
	IF(m.estado!='A',m.saldo_por_pagar,'0') AS saldo_por_pagar 
	FROM  manifiesto m
	WHERE  m.fecha_mc BETWEEN '$fecha_inicio' AND '$fecha_final' AND manifiesto_id NOT IN (SELECT manifiesto_id FROM liquidacion_despacho WHERE manifiesto_id IS NOT NULL)
	$condicionConductor $condicionPlaca $condicionOficinas $condicionEstado  
	ORDER BY m.oficina_id,m.fecha_mc ASC )
	 
	 )";

    $select_des = "
	(SELECT
 	 '' AS manifiesto_id,
 	 m.despachos_urbanos_id,
	(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina,
	m.placa,
	m.nombre AS conductor,
	m.numero_identificacion,
	m.tenedor,
	m.numero_identificacion_tenedor,
	m.despacho AS num_planilla,
	'NO' AS nacional,
	IF(m.propio = 1,'SI','NO') AS propio,
	IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,
	m.fecha_du AS fecha_planilla,
	(SELECT nombre FROM oficina WHERE oficina_id= ld.oficina_id) AS lugar_autorizado_pago,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.destino_id) AS destino,
	(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_despacho  WHERE despachos_urbanos_id = m.despachos_urbanos_id) AS numero_anticipos,
	ld.fecha AS fecha_liquidacion,
	'' AS fecha_legalizacion,
	IF(m.estado!='A',IF(ld.valor_despacho > 0,ld.valor_despacho,m.valor_flete),'0') AS valor_total,
	$cadena_imp_dl
	IF(m.estado!='A',(SELECT SUM(valor) AS valor FROM anticipos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id),'0') AS anticipos,
	$cadena_des_dl
	IF(m.estado!='A',IF(ld.saldo_por_pagar >=0,ld.saldo_por_pagar,m.saldo_por_pagar),'0') AS saldo_por_pagar 
	FROM liquidacion_despacho ld, despachos_urbanos  m
	WHERE  ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$fecha_inicio' AND '$fecha_final' 
	$condicionConductor $condicionPlaca $condicionOficinas $condicionEstado  
	ORDER BY m.oficina_id,m.fecha_du ASC )
	
	UNION ALL
	
	(
	(SELECT 
 	 '' AS manifiesto_id,
 	 m.despachos_urbanos_id,
	(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina,
	m.placa,
	m.nombre AS conductor,
	m.numero_identificacion,
	m.tenedor,
	m.numero_identificacion_tenedor,
	m.despacho AS num_planilla,
	'NO' AS nacional,
	IF(m.propio = 1,'SI','NO') AS propio,
	IF(m.estado = 'P','PENDIENTE',IF(estado = 'M','MANIFESTADO',IF(estado = 'L','LIQUIDADO','ANULADO'))) estado,
	m.fecha_du AS fecha_planilla,
	m.lugar_pago_saldo AS lugar_autorizado_pago,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id= m.destino_id) AS destino,
	(SELECT GROUP_CONCAT(consecutivo) FROM anticipos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id) AS numero_anticipos,
	'N/A' AS fecha_liquidacion,
	(SELECT fecha FROM legalizacion_despacho WHERE despachos_urbanos_id=m.despachos_urbanos_id) AS fecha_legalizacion,	
	IF(m.estado!='A',m.valor_flete,'0') AS valor_total,
	$cadena_imp_d
	IF(m.estado!='A',(SELECT SUM(valor) AS valor FROM anticipos_despacho WHERE despachos_urbanos_id = m.despachos_urbanos_id),'0') AS anticipos,
	$cadena_des_d
	IF(m.estado!='A',m.saldo_por_pagar,'0') AS saldo_por_pagar 
	FROM  despachos_urbanos m
	WHERE  m.fecha_du BETWEEN '$fecha_inicio' AND '$fecha_final'  AND despachos_urbanos_id NOT IN (SELECT despachos_urbanos_id FROM liquidacion_despacho WHERE despachos_urbanos_id IS NOT NULL)
	$condicionConductor $condicionPlaca $condicionOficinas $condicionEstado  
	ORDER BY m.oficina_id,m.fecha_du ASC )
	 
	 )";

	 if($opciones_documento!='U'){
		 $select = $select_man.' UNION ALL '.$select_des.' ORDER BY oficina, fecha_planilla ';
	 }elseif($documento=='MC'){
		 $select = $select_man;
	 }elseif($documento=='DU'){	 
		 $select = $select_des;		 
	 }
	 
	 //exit($select);
     $data      = $this -> DbFetchAll($select,$Conex,true);
	 $tam_data	= count($data);
	 $select    = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";  
	 $impuestos = $this -> DbFetchAll($select,$Conex,true);		  
	 
     $select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
	 $descuentos = $this -> DbFetchAll($select,$Conex,true);	

	$arrayResult = array();
	 
	 if(is_array($data) && is_array($data2)){
	    $arrayResult = array_merge($data,$data2);
	 }else if(is_array($data) && !is_array($data2)){
	    $arrayResult = $data;	 
	 }else if(!is_array($data) && is_array($data2)){
	 	$arrayResult = $data2;	 	   
     }		 
	 return  array(data => $arrayResult, impuestos => $impuestos, descuentos => $descuentos);

  }
}
?>