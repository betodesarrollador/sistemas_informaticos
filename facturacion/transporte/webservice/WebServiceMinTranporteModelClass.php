<?php

require_once($_SERVER['DOCUMENT_ROOT']."../../../framework/clases/DbClass.php");

final class WebServiceMinTransporteModel extends Db{

//para nuevo cambio	
 public function getActivorndc($Conex){
  
    $select = "SELECT * FROM rndc";
    $result = $this -> DbFetchAll($select,$Conex,true); 

	
	if($result[0]['activo_envio'] =='S'){
	  return true;
	}else{
	    return false;
	  }

  }
//para nuevo cambio	

  public function tenedorFueReportadoMinisterio($tenedor_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM tenedor WHERE tenedor_id = $tenedor_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }

  }
  
  public function propietarioFueReportadoMinisterio($propietario_id,$Conex){

    $select = "SELECT reportado_ministerio FROM tercero WHERE tercero_id = $propietario_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }
  
  
  }

  public function getDivipolaUbicacion($ubicacion_id,$Conex){
	
	  $select = "SELECT divipola FROM ubicacion WHERE ubicacion_id = $ubicacion_id";
   	  $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	  return $result[0]['divipola'];
	
  }
  
  public function getCodCategoriaLicencia($categoria_id,$Conex){
  
      $select = "SELECT categoria FROM categoria_licencia WHERE categoria_id = $categoria_id";
   	  $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	  return $result[0]['categoria'];	  
  
  }	
  
  public function setAprobacionConductor($conductor_id,$ingresoid,$path_xml,$Conex){
  
    $this -> Begin($Conex); $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
  
	 $update = "UPDATE conductor SET path_xml = '$path_xml',reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), 
	 aprobacion_ministerio = '$ingresoid' WHERE conductor_id = $conductor_id";
	 
	 $this -> query($update,$Conex,true);   
	 
	 $update = "UPDATE tercero SET reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), aprobacion_ministerio = 
				'$ingresoid' WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id)";
	 
	 $this -> query($update,$Conex,true);   	 
	 
	$this -> Commit($Conex);
  
  }
  
  public function setAprobacionAnulacionRemesa($remesa_id,$ingresoid,$Conex){  
  
     $update    = "UPDATE remesa SET anulado_ministerio = 1, fecha_anulacion_ministerio = NOW(), anulacion_ministerio = 
				$ingresoid WHERE remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);   
  
  }
  
  public function setErrorAnulacionRemesa($remesa_id,$respuesta,$Conex){
  
      $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	   
	  $update = "UPDATE remesa SET error_anulando_ministerio = 1, fecha_error_anulando_ministerio = NOW(), 
				ultimo_error_anulando_ministario = '$respuesta' WHERE remesa_id = $remesa_id";
	 
	  $this -> query($update,$Conex,true);      
  
  }
  
  public function setErrorReporteConductor($conductor_id,$respuesta,$path_xml,$Conex){
  
    $this -> Begin($Conex); $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
  
	  $update = "UPDATE conductor SET path_xml = '$path_xml',error_reportando_ministerio = 1, fecha_error_reportando_ministerio = 
	  NOW(),ultimo_error_reportando_ministario = '$respuesta' WHERE conductor_id = $conductor_id";
	 
	  $this -> query($update,$Conex,true);  
	  
	  $update = "UPDATE tercero SET error_reportando_ministerio = 1, fecha_error_reportando_ministerio = NOW(), 
				ultimo_error_reportando_ministario = '$respuesta' WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id)";
	 
	  $this -> query($update,$Conex,true);  	  
	 
	$this -> Commit($Conex);
  
  }	
  
  
  public function setAprobacionTenedor($tenedor_id,$ingresoid,$path_xml,$Conex){
  
    $this -> Begin($Conex); $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
  
	  $update = "UPDATE tenedor SET path_xml = '$path_xml',reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), 
	  aprobacion_ministerio = '$ingresoid' WHERE tenedor_id = $tenedor_id";
	 
	  $this -> query($update,$Conex,true);   

	  $update = "UPDATE tercero SET reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), aprobacion_ministerio = 
				'$ingresoid' WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
	 
	  $this -> query($update,$Conex,true);   

	 
    $this -> Begin($Conex); $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));	 
  
  }
  
  public function setErrorReporteTenedor($tenedor_id,$respuesta,$path_xml,$Conex){
  
    $this -> Begin($Conex); $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
  
	 $update = "UPDATE tenedor SET path_xml = '$path_xml',error_reportando_ministerio = 1, fecha_error_reportando_ministerio = 
	 NOW(), ultimo_error_reportando_ministario = '$respuesta' WHERE tenedor_id = $tenedor_id";
	 
	 $this -> query($update,$Conex,true);  
	 
	 $update = "UPDATE tercero SET error_reportando_ministerio = 1, fecha_error_reportando_ministerio = NOW(), 
				ultimo_error_reportando_ministario = '$respuesta' WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE 
				tenedor_id = $tenedor_id)";
	 
	 $this -> query($update,$Conex,true);  	 
	 
    $this -> Commit($Conex);
  
  }	
  
  public function setAprobacionRemitenteDestinatario($remitente_destinatario_id,$ingresoid,$path_xml,$Conex){
  
	 $update = "UPDATE remitente_destinatario SET path_xml = '$path_xml',reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), 
	 aprobacion_ministerio = '$ingresoid' WHERE remitente_destinatario_id = $remitente_destinatario_id";
	 
	 $this -> query($update,$Conex,true);   
  
  }
  
  public function setErrorReportePropietario($tercero_id,$respuesta,$path_xml,$Conex){
	 $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	 $update = "UPDATE tercero SET path_xml = '$path_xml',error_reportando_ministerio = 1, fecha_error_reportando_ministerio = 
	 NOW(),ultimo_error_reportando_ministario = '$respuesta' WHERE tercero_id = $tercero_id";
	 
	 $this -> query($update,$Conex,true);  
  
  }	
  
  public function setAprobacionPropietario($tercero_id,$ingresoid,$path_xml,$Conex){
  
	 $update = "UPDATE tercero SET path_xml = '$path_xml',reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), 
	 aprobacion_ministerio = '$ingresoid' WHERE tercero_id = $tercero_id";
	 
	 $this -> query($update,$Conex,true);   
  
  }  
  
  public function setErrorReporteRemitenteDestinatario($remitente_destinatario_id,$respuesta,$path_xml,$Conex){
  
	 $update = "UPDATE remitente_destinatario SET path_xml = '$path_xml',error_reportando_ministerio = 1, 
	 fecha_error_reportando_ministerio = NOW(),ultimo_error_reportando_ministario = '$respuesta' WHERE remitente_destinatario_id = 
	 $remitente_destinatario_id";
	 
	 $this -> query($update,$Conex,true);  
  
  }	   
  
  public function setAprobacionVehiculo($placa_id,$ingresoid,$path_xml,$Conex){
  
	 $update = "UPDATE vehiculo SET path_xml= '$path_xml', reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), 
	 aprobacion_ministerio = '$ingresoid' WHERE placa_id = $placa_id";
	 
	 $this -> query($update,$Conex,true);   
  
  }  
  
  public function setErrorReporteVehiculo($placa_id,$respuesta,$path_xml,$Conex){
  	 $respuesta= str_replace("'","",$respuesta);
	 $update = "UPDATE vehiculo SET path_xml = '$path_xml',error_reportando_ministerio = 1, fecha_error_reportando_ministerio = 
	 NOW(),ultimo_error_reportando_ministario = '$respuesta' WHERE placa_id = $placa_id";
	 
	 $this -> query($update,$Conex,true);  
  
  }	   
  
  public function setAprobacionRemolque($placa_remolque_id,$ingresoid,$path_xml,$Conex){
  
	 $update = "UPDATE remolque SET path_xml = '$path_xml',reportado_ministerio = 1, fecha_ultimo_reporte = NOW(), 
	 aprobacion_ministerio = '$ingresoid' WHERE placa_remolque_id = $placa_remolque_id";
	 
	 $this -> query($update,$Conex,true);   
  
  }  
  
  public function setErrorReporteRemolque($placa_remolque_id,$respuesta,$path_xml,$Conex){

  
	 $update = "UPDATE remolque SET path_xml = '$path_xml',error_reportando_ministerio = 1, fecha_error_reportando_ministerio = 
	 NOW(),ultimo_error_reportando_ministario = '$respuesta' WHERE placa_remolque_id = $placa_remolque_id";
	 
	 $this -> query($update,$Conex,true);  
  
  }	  
  
  public function setAprobacionInformacionCarga($fp,$numero_remesa,$ingresoid,$Conex){
  
	 $update = "UPDATE remesa SET path_xml_informacion_carga = '$fp',reportado_ministerio = 1, 
	 fecha_ultimo_reporte = NOW(), aprobacion_ministerio = '$ingresoid' WHERE numero_remesa = $numero_remesa";
	 
	 $this -> query($update,$Conex,true);   
  
  
  }
  
   public function setCorreccionAprobacionInformacionCarga($fp,$numero_remesa,$ingresoid,$Conex){
  
	 $update = "UPDATE remesa SET path_xml_informacion_carga = '$fp',reportado_ministerio2 = 1, 
	 fecha_ultimo_reporte2 = NOW(), aprobacion_ministerio2 = '$ingresoid' WHERE numero_remesa = $numero_remesa";
	 
	 $this -> query($update,$Conex,true);   
  
  
  }
  
  public function setErrorReporteInformacionCarga($fp,$numero_remesa,$respuesta,$Conex){
  
     $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	   
	 $update = "UPDATE remesa SET path_xml_informacion_carga = '$fp',error_reportando_ministerio = 1, 
	 fecha_error_reportando_ministerio = NOW(),ultimo_error_reportando_ministario = '$respuesta' WHERE 
	 numero_remesa = $numero_remesa";
	 
	 $this -> query($update,$Conex,true);  
    
  }
  
  public function setAprobacionInformacionViaje($manifiesto_id,$informacion_viaje,$ingresoid,$Conex){
  
	 $update = "UPDATE manifiesto SET informacion_viaje = $informacion_viaje,reportado_ministerio = 1, 
	           fecha_ultimo_reporte = NOW(), aprobacion_ministerio = '$ingresoid' WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);   	
  
  
  }
  
  public function setErrorReporteInformacionViaje($manifiesto_id,$informacion_viaje,$respuesta,$Conex){
  
     $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
  
	 $update = "UPDATE manifiesto SET informacion_viaje = $informacion_viaje,error_reportando_ministerio = 1, fecha_error_reportando_ministerio = NOW(), 
				ultimo_error_reportando_ministario = '$respuesta' WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);  
    
  }
  
  public function setPathXMLRemesa($manifiesto_id,$remesa_id,$pathXML,$Conex){
  
   $this -> Commit($Conex);
  
    $update = "UPDATE remesa SET path_xml_remesa = '$pathXML' WHERE remesa_id = $remesa_id";
	
    $this -> query($update,$Conex,true);  	
	
	
	$update = "UPDATE manifiesto SET path_xml_remesas = '$pathXML' WHERE manifiesto_id = $manifiesto_id";
	
    $this -> query($update,$Conex,true);  		
	
   $this -> Commit($Conex);
  
  }
  
  public function setPathXMLInfoViaje($manifiesto_id,$pathXML,$Conex){
  
    $update = "UPDATE manifiesto SET path_xml_informacion_viaje = '$pathXML' WHERE manifiesto_id = $manifiesto_id";
	
    $this -> query($update,$Conex,true);  	    
  
  }
  
  public function setAprobacionRemesa($manifiesto_id,$remesa_id,$ingresoid,$Conex){
  
	 $update = "UPDATE remesa SET reportado_ministerio2 = 1, fecha_ultimo_reporte2 = NOW(), aprobacion_ministerio2 = '$ingresoid' 
	 WHERE remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);     
  }
  
  
  public function setErrorReporteRemesa($manifiesto_id,$remesa_id,$respuesta,$Conex){
  
     $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));

	 $update = "UPDATE manifiesto SET error_reportando_ministerio2 = 1, fecha_error_reportando_ministerio2 = NOW(), 
				ultimo_error_reportando_ministario2 = '$respuesta' WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);     
  
	 $update = "UPDATE remesa SET error_reportando_ministerio2 = 1, fecha_error_reportando_ministerio2 = NOW(), 
				ultimo_error_reportando_ministario2 = '$respuesta' WHERE remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);    
  
  }


  public function setAprobacionManifiesto($manifiesto_id,$informacion_viaje,$ingresoid,$observacionesqr,$seguridadqr,$Conex){
  
	 $update = "UPDATE manifiesto SET informacion_viaje = '$informacion_viaje',reportado_ministerio2 = 1, 
	           fecha_ultimo_reporte2 = NOW(), aprobacion_ministerio2 = '$ingresoid',observacionesqr='$observacionesqr',seguridadqr='$seguridadqr' WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);   	
    
  }
  
  public function setErrorReporteManifiesto($manifiesto_id,$informacion_viaje,$respuesta,$Conex){
  
     $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
  
	 $update = "UPDATE manifiesto SET informacion_viaje = $informacion_viaje,error_reportando_ministerio2 = 1, fecha_error_reportando_ministerio2 = NOW(), 
				ultimo_error_reportando_ministario2 = '$respuesta' WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);  
    
  }
    
  public function setPathXMLManifiesto($manifiesto_id,$pathXML,$Conex){
    
    $update = "UPDATE manifiesto SET path_xml_manifiesto = '$pathXML' WHERE manifiesto_id = $manifiesto_id";
	
    $this -> query($update,$Conex,true);      
  
  }			   		 	

//este
 public function getDataManifiestoLiquidacion($liquidacion_despacho_id,$Conex){
  
    $select = "SELECT m.manifiesto_id, l.liquidacion_despacho_id, m.observacion_anulacion,m.manifiesto, m.estado,l.fecha,l.valor_sobre_flete,
	m.fecha_mc,	m.fecha_entrega_mcia_mc,m.hora_entrega,m.fecha_estimada_salida, m.hora_estimada_salida,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS fecha_entrada_cargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS fecha_llegada_cargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS hora_entrada_cargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS hora_llegada_cargue,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS fecha_entrada_descargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS fecha_salida_descargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS hora_entrada_descargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS hora_salida_descargue,	
	
	(SELECT SUM(valor) FROM anticipos_manifiesto WHERE manifiesto_id=m.manifiesto_id LIMIT 1,5) AS valor_sobreanticipos,
	(SELECT SUM(valor) FROM descuentos_manifiesto WHERE manifiesto_id=m.manifiesto_id AND nombre LIKE '%FALTANTE%' ) AS descuentos
	FROM liquidacion_despacho l, manifiesto m WHERE l.liquidacion_despacho_id = $liquidacion_despacho_id AND m.manifiesto_id=l.manifiesto_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if(count($result)>0){
	  return $result;
	}else{
	    return array();
	  }

  }
  
   public function getDataManifiestoLiquidacionDesc($liquidacion_despacho_descu_id,$Conex){
  
    $select = "SELECT m.manifiesto_id, l.liquidacion_despacho_descu_id, m.observacion_anulacion,m.manifiesto, m.estado,l.fecha,
	(SELECT valor_sobre_flete FROM 	liquidacion_despacho_sobre WHERE manifiesto_id=m.manifiesto_id AND estado_liquidacion!='A' ) AS valor_sobre_flete,
	m.fecha_mc,	m.fecha_entrega_mcia_mc,m.hora_entrega,m.fecha_estimada_salida, m.hora_estimada_salida,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS fecha_entrada_cargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS fecha_llegada_cargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS hora_entrada_cargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS hora_llegada_cargue,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS fecha_entrada_descargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS fecha_salida_descargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS hora_entrada_descargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS hora_salida_descargue,	

	(SELECT SUM(valor) FROM anticipos_manifiesto WHERE manifiesto_id=m.manifiesto_id LIMIT 1,5) AS valor_sobreanticipos,
	(SELECT SUM(valor) FROM descuentos_manifiesto WHERE manifiesto_id=m.manifiesto_id AND nombre LIKE '%FALTANTE%' ) AS descuentos
	FROM liquidacion_despacho_descu l, manifiesto m WHERE l.liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id AND m.manifiesto_id=l.manifiesto_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if(count($result)>0){
	  return $result;
	}else{
	    return array();
	  }

  }
  
  public function getDataManifiestoLiquidacionMan($manifiesto_id,$Conex){
  
    $select = "SELECT m.manifiesto_id,  m.observacion_anulacion,m.manifiesto, m.estado,
	(DATE(ADDTIME(CONCAT_WS(' ',m.fecha_mc,'10:00:00'),'168:00:00'))) AS fecha,m.valor_sobre_flete,
	m.fecha_mc,	m.fecha_entrega_mcia_mc,m.hora_entrega,m.fecha_estimada_salida, m.hora_estimada_salida,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS fecha_entrada_cargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS fecha_llegada_cargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS hora_entrada_cargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS hora_llegada_cargue,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS fecha_entrada_descargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS fecha_salida_descargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS hora_entrada_descargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS hora_salida_descargue,	
	
	(SELECT SUM(valor) FROM anticipos_manifiesto WHERE manifiesto_id=m.manifiesto_id LIMIT 1,5) AS valor_sobreanticipos,
	(SELECT SUM(valor) FROM descuentos_manifiesto WHERE manifiesto_id=m.manifiesto_id AND nombre LIKE '%FALTANTE%' ) AS descuentos
	FROM  manifiesto m WHERE m.manifiesto_id=$manifiesto_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if(count($result)>0){
	  return $result;
	}else{
	    return array();
	  }

  }  
  
//bloque reporte cumplido
 public function getDataManifiestoLiquidacionPropio($legalizacion_manifiesto_id,$Conex){
  
    $select = "SELECT m.manifiesto_id, l.legalizacion_manifiesto_id, m.observacion_anulacion,m.manifiesto, m.estado,l.fecha,'0' AS valor_sobre_flete,
	m.fecha_mc,	m.fecha_entrega_mcia_mc,m.hora_entrega,m.fecha_estimada_salida, m.hora_estimada_salida,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS fecha_entrada_cargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS fecha_llegada_cargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-02:00:00')) AS hora_entrada_cargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_estimada_salida,m.hora_estimada_salida),'-04:00:00')) AS hora_llegada_cargue,
	
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS fecha_entrada_descargue,
	DATE(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS fecha_salida_descargue,	

	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'02:00:00')) AS hora_entrada_descargue,
	TIME(ADDTIME(CONCAT_WS(' ',m.fecha_entrega_mcia_mc,m.hora_entrega),'04:00:00')) AS hora_salida_descargue,	

	(SELECT SUM(valor) FROM anticipos_manifiesto WHERE manifiesto_id=m.manifiesto_id LIMIT 1,5) AS valor_sobreanticipos,
	(SELECT SUM(valor) FROM descuentos_manifiesto WHERE manifiesto_id=m.manifiesto_id AND nombre LIKE '%FALTANTE%' ) AS descuentos
	FROM legalizacion_manifiesto l, manifiesto m WHERE l.legalizacion_manifiesto_id = $legalizacion_manifiesto_id AND m.manifiesto_id=l.manifiesto_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if(count($result)>0){
	  return $result;
	}else{
	    return array();
	  }

  }
//bloque reporte cumplido  

  public function getObservacionANulacion($remesa_id,$Conex){
  
    $select = "SELECT observacion_anulacion FROM remesa WHERE remesa_id = $remesa_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['observacion_anulacion'];	
  
  }

  public function getEstaCumplidaRemesa($remesa_id,$Conex){
  
    $select = "SELECT reportado_ministerio3, aprobacion_ministerio3 FROM remesa WHERE remesa_id = $remesa_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	if($result[0]['reportado_ministerio3']==1 && $result[0]['aprobacion_ministerio3']!=''){  
		return true;	
	}else{
		return false;	
	}
  
  }

  public function getEstaCumplidaManifiesto($manifiesto_id,$Conex){
  
    $select = "SELECT reportado_ministerio3, aprobacion_ministerio3 FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	if($result[0]['reportado_ministerio3']==1 && $result[0]['aprobacion_ministerio3']!=''){  
		return true;	
	}else{
		return false;	
	}
  
  }

  public function getDatosDescargue($manifiesto_id,$cliente_id,$Conex){
  
    $select = "SELECT * FROM tiempos_clientes_remesas WHERE manifiesto_id = $manifiesto_id AND cliente_id=$cliente_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result;	
  
  }

  public function setAprobacionRemesaCumplido($manifiesto_id,$remesa_id,$ingresoid,$Conex){
  
	 $update = "UPDATE remesa SET reportado_ministerio3 = 1, 
	 fecha_ultimo_reporte3 = NOW(), aprobacion_ministerio3 = '$ingresoid' WHERE remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);   
  
  
  }
  
  public function setErrorReporteRemesaCumplido($manifiesto_id,$remesa_id,$respuesta,$Conex){
  
     $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	   
	 $update = "UPDATE remesa SET error_reportando_ministerio3 = 1, 
	 fecha_error_reportando_ministerio3 = NOW(),ultimo_error_reportando_ministario3 = '$respuesta' WHERE 
	 remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);  
    
  }

  public function setAprobacionManifiestoCumplido($manifiesto_id,$ingresoid,$Conex){
  
	 $update = "UPDATE manifiesto SET reportado_ministerio3 = 1, 
	 fecha_ultimo_reporte3 = NOW(), aprobacion_ministerio3 = '$ingresoid' WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);   
  
  
  }
  
  public function setErrorReporteManifiestoCumplido($manifiesto_id,$respuesta,$Conex){
  
     $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	   
	 $update = "UPDATE manifiesto SET error_reportando_ministerio3 = 1, 
	 fecha_error_reportando_ministerio3 = NOW(),ultimo_error_reportando_ministario3 = '$respuesta' WHERE 
	 manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);  
    
  }

//aca

  public function getCodProducto($producto_id,$Conex){
  
    $select = "SELECT codigo FROM producto WHERE producto_id = $producto_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['codigo'];	
  
  }
  
  public function getCodMarca($marca_id,$Conex){
  
    if(!is_null($marca_id)){
  
     $select = "SELECT codigo FROM marca WHERE marca_id = '$marca_id'";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['codigo'];
	
	}else{
	    return null;
	  }
	  
  }  
  
  public function getCodMarcaRemolque($marca_remolque_id,$Conex){
  
    if(!is_null($marca_remolque_id)){
	
     $select = "SELECT codigo FROM marca_remolque WHERE marca_remolque_id = '$marca_remolque_id'";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['codigo'];  
	
	}else{
	    return null;
	  }
  
  }
  
  public function getCodLinea($linea_id,$Conex){
  
  
    if(!is_null($linea_id)){
	
     $select = "SELECT codigo_linea FROM linea WHERE linea_id = $linea_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['codigo_linea'];		
	
	}else{
	    return null;
	  }
	
  
  }
  
  public function getCodTipoIdentificacion($tipo_identificacion_id,$Conex){
  
    $select = "SELECT codigo_ministerio FROM tipo_identificacion  WHERE tipo_identificacion_id = $tipo_identificacion_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['codigo_ministerio'];		
  
  }
  
  public function getCodTipoIdentificacionRemDest($remitente_destinatario_id,$Conex){
  
    $select = "SELECT codigo_ministerio FROM tipo_identificacion  WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id  
	FROM remitente_destinatario WHERE remitente_destinatario_id = $remitente_destinatario_id)";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['codigo_ministerio'];		  
  
  }

  public function getIdentificacionRemDest($remitente_destinatario_id,$Conex){
  
    $select = " SELECT numero_identificacion,digito_verificacion 	
	FROM remitente_destinatario WHERE remitente_destinatario_id = $remitente_destinatario_id";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['numero_identificacion'].$result[0]['digito_verificacion'];  
  
  }

  public function getNitAseguradora($aseguradora_soat_id,$Conex){
  
     $select = "SELECT nit_aseguradora,digito_verificacion FROM aseguradora WHERE 
	            aseguradora_id = $aseguradora_soat_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['nit_aseguradora'].$result[0]['digito_verificacion'];		 
  
  }
  
  public function getNumeroIdentificacionPropietario($propietario_id,$Conex){
  
     $select = "SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id = $propietario_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['numero_identificacion'].$result[0]['digito_verificacion'];		     
	   
  }
  
  public function getDocRemitenteDestinatario($remitente_destinatario_id,$Conex){
  
    $select = "SELECT numero_identificacion,digito_verificacion FROM remitente_destinatario WHERE
	remitente_destinatario_id = $remitente_destinatario_id";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
    return $result[0]['numero_identificacion'].$result[0]['digito_verificacion'];		     	
  
  }

  public function getNumeroIdentificacionTitular($titular_manifiesto_id,$Conex){
	  
    $select = "SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $titular_manifiesto_id)";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	 return $result[0]['numero_identificacion'].$result[0]['digito_verificacion'];		     
	   
  }
  public function getCodSedePropietario($propietario_id,$Conex){

     $select = "SELECT remitente_destinatario_id FROM remitente_destinatario WHERE tercero_id = $propietario_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['remitente_destinatario_id'];		     
  
  
  }
  
  public function getCodTipoIdentificacionPropietario($propietario_id,$Conex){
  
     $select = "SELECT codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
	            FROM tercero WHERE tercero_id = $propietario_id)";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['codigo_ministerio'];		     
  
  }			
  
  public function getIdentificacionPropietario($propietario_id,$Conex){
  
     $select = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id = $propietario_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['numero_identificacion'].''.$result[0]['digito_verificacion'];	  
  
  }
  
  public function getCodTipoIdentificacionTenedor($tenedor_id,$Conex){
  
     $select = "SELECT codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
	            FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id))";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['codigo_ministerio'];
  
  }	
  
  public function getIdentificacionTenedor($tenedor_id,$Conex){
  
     $select = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE 
	            tenedor_id = $tenedor_id)";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	  
	 return $result[0]['numero_identificacion'].''.$result[0]['digito_verificacion'];  
  
  }
  
  public function getCodTipoRemesa($tipo_remesa_id,$Conex){
  
     $select = "SELECT codigo FROM tipo_remesa WHERE tipo_remesa_id = $tipo_remesa_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	 
	 return $result[0]['codigo'];  
  
  }	
  
  public function getCodUnidadMedida($medida_id,$Conex){
  
    $select = "SELECT codigo FROM medida WHERE medida_id = $medida_id";
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	 
	return $result[0]['codigo'];  	
  
  }
  
  public function selectManifiesto($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);

	 //adicion
     $select1 =  "SELECT numero_remesa,remesa_id,estado,tipo_remesa_id,peso,peso_costo, cliente_id 
	 FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE	manifiesto_id = $manifiesto_id)";
   	 $result1 = $this  -> DbFetchAll($select1,$Conex,true);
	 
	 $result[0]['remesas']=$result1;
	//fin adicion	


	 return $result;     
  
  }
  
  public function selectRemesasManifiesto($manifiesto_id,$Conex){
  	 
     $select = "SELECT r.*,m.*,t.* FROM remesa r, manifiesto m, detalle_despacho d,tiempos_clientes_remesas t WHERE 
	  m.manifiesto_id = $manifiesto_id AND m.manifiesto_id = d.manifiesto_id AND d.remesa_id = r.remesa_id AND 
	 m.manifiesto_id = t.manifiesto_id AND t.cliente_id = r.cliente_id";
	 
	 
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	 
	 return $result;    
  
  }  														
  
  public function getCodTipoManifiesto($tipo_manifiesto_id,$Conex){
  
     $select = "SELECT codigo FROM tipo_manifiesto WHERE tipo_manifiesto_id = $tipo_manifiesto_id";
	 
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	 
	 return $result[0]['codigo'];  	 
  
  }
  
  public function getRetencionManifiesto($manifiesto_id,$Conex){
  
   $select = "SELECT porcentaje FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id AND impuesto_id IN (SELECT 
              impuesto_id FROM tabla_impuestos WHERE rte = 1)";
			  
   $result = $this  -> DbFetchAll($select,$Conex,true);
	 
    if(($result[0]['porcentaje']-intval($result[0]['porcentaje']))>0){
     return number_format($result[0]['porcentaje'],2);
	}else{
	 return number_format($result[0]['porcentaje'],0);
    }		  
  
  }
  
   public function getRetencionicaManifiesto($manifiesto_id,$Conex){
  
   $select = "SELECT porcentaje FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id AND impuesto_id IN (SELECT 
              impuesto_id FROM tabla_impuestos WHERE ica = 1)";
			  
   $result = $this  -> DbFetchAll($select,$Conex,true);
	 
    if(($result[0]['porcentaje']-intval($result[0]['porcentaje']))>0){
     return number_format($result[0]['porcentaje'],2);
	}else{
	 return number_format($result[0]['porcentaje'],0);
    }		  
  
  }
  
  public function getAnticipoManifiesto($manifiesto_id,$Conex){
  
    $select = "SELECT SUM(valor) AS valor FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
    $result = $this  -> DbFetchAll($select,$Conex,true);
	 
    return $result[0]['valor'];  	  
  
  }

  public function getCodCiudadPagoSaldo($manifiesto_id,$Conex){
  
    $select = "SELECT ubicacion_id FROM oficina WHERE oficina_id = (SELECT oficina_pago_saldo_id FROM manifiesto 
	           WHERE manifiesto_id = $manifiesto_id)";
			   
    $result = $this  -> DbFetchAll($select,$Conex,true);
	 
    return $result[0]['ubicacion_id']; 			   
  
  }
  
  
  public function getFechaCitadaDescargue($manifiesto_id,$Conex){
  
    $select = "SELECT fecha_entrega_mcia_mc FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
    $result = $this  -> DbFetchAll($select,$Conex,true);
	 
    return $result[0]['fecha_entrega_mcia_mc']; 			   	
  
  }
  
  public function getHoraCitadaDescargue($manifiesto_id,$Conex){
  
    $select = "SELECT hora_entrega FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
    $result = $this  -> DbFetchAll($select,$Conex,true);
	 
    return $result[0]['hora_entrega']; 			   	  
  
  }
  
  public function getCodTipoIdentificacionTitularManifiesto($titular_manifiesto_id,$Conex){
  
    $select = "SELECT codigo_ministerio FROM tipo_identificacion  WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $titular_manifiesto_id))";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['codigo_ministerio'];		
  
  }
  
  public function getCodTipoIdentificacionConductorManifiesto($conductor_id,$Conex){
  
    $select = "SELECT codigo_ministerio FROM tipo_identificacion  WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
	FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id))";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['codigo_ministerio'];	    
  
  }

  public function getCodTipoIdentificacionTenedorManifiesto($tenedor_id,$Conex){
  
    $select = "SELECT codigo_ministerio FROM tipo_identificacion  WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id 
	FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id))";
	
   	$result = $this  -> DbFetchAll($select,$Conex,true);
	  
	return $result[0]['codigo_ministerio'];	    
  
  }

   public function vehiculoEsdelaTransportadora($numnitempresatransporte,$placa_id,$Conex){
   
     $select     = "SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id = 
	 (SELECT tercero_id FROM tenedor WHERE tenedor_id = (SELECT tenedor_id FROM vehiculo WHERE placa_id = $placa_id))";
	 
	 $result     = $this -> DbFetchAll($select,$Conex,true);	 	 
	 $nit        = $result[0]['numero_identificacion'].$result[0]['digito_verificacion'];
	 
	 if($nit == $numnitempresatransporte){
	   return true;
	 }else{
	      return false;
	   }	 
   
   }
   
   public function esVehiculoRigido($placa_id,$Conex){
   
     $select        = "SELECT configuracion FROM vehiculo WHERE placa_id = $placa_id";
	 $result        = $this -> DbFetchAll($select,$Conex,true);	 	 
	 
	 $configuracion = $result[0]['configuracion'];	 
	 
	 if(in_array($configuracion,array('50','51','52'))){
	   return true;
	 }else{
	      return false;
	   }
	    
   } 
   
   public function getMotivoAnulacionRemesa($causal_anulacion_id,$Conex){
   
     $select = "SELECT codigo FROM causal_anulacion WHERE causal_anulacion_id = $causal_anulacion_id";
	 $result = $this -> DbFetchAll($select,$Conex,true);	 		 
	 
	 return $result[0]['codigo'];
   
   } 
   
   public function remesaEstaReportada($remesa_id,$Conex){
   
      $select = "SELECT reportado_ministerio2 FROM remesa WHERE remesa_id = $remesa_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);	 		 	  
	  
	  if($result[0]['reportado_ministerio2'] == 1){
	    return true;
	  }else{
	       return false;
	    }
   
   }
   
   public function informacionViajeFueReportada($manifiesto_id,$Conex){
   
      $select = "SELECT reportado_ministerio FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);	 		 	  
	  
	  if($result[0]['reportado_ministerio'] == 1){
	    return true;
	  }else{
	       return false;
	    }   
   
   }
   
   public function manifiestoEstaReportado($manifiesto_id,$Conex){
   
      $select = "SELECT reportado_ministerio2 FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);	 		 	  
	  if($result[0]['reportado_ministerio2'] == 1){
	    return true;
	  }else{
	       return false;
	    }   
     
   
   }
  
  public function setAprobacionAnulacionManifiesto($manifiesto_id,$ingresoid,$Conex){  
  
     $update    = "UPDATE manifiesto SET anulado_ministerio = 1, fecha_anulacion_ministerio = NOW(), anulacion_ministerio = 
				$ingresoid WHERE manifiesto_id = $manifiesto_id";
	 
	 $this -> query($update,$Conex,true);   
  
  }
  
  public function setErrorAnulacionManifiesto($manifiesto_id,$respuesta,$Conex){
  
      $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	   
	  $update = "UPDATE manifiesto SET error_anulando_ministerio = 1, fecha_error_anulando_ministerio = NOW(), 
				ultimo_error_anulando_ministario = '$respuesta' WHERE manifiesto_id = $manifiesto_id";
	 
	  $this -> query($update,$Conex,true);      
  
  }
  
  public function setAprobacionLiberacionRemesa($remesa_id,$ingresoid,$Conex){
  
     $update    = "UPDATE remesa SET liberada_ministerio = 1, fecha_liberacion_ministerio = NOW(), liberacion_ministerio = 
				$ingresoid WHERE remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);      
  
  }
  
  public function setErrorLiberacionRemesa($remesa_id,$respuesta,$Conex){
  
      $respuesta = mysql_real_escape_string(str_replace(',',' ',str_replace("'",'',$respuesta)));
	   
	  $update = "UPDATE remesa SET error_liberando_ministerio = 1, fecha_error_liberando_ministerio = NOW(), 
				ultimo_error_liberando_ministario = '$respuesta' WHERE remesa_id = $remesa_id";
	 
	  $this -> query($update,$Conex,true);      
  
  }
  
  public function remesaEstaAsignadaManifiestoReportado($remesa_id,$Conex){
  
    $select = "SELECT MAX(detalle_despacho_id) AS detalle_despacho_id FROM detalle_despacho WHERE remesa_id = $remesa_id";
    $result = $this -> DbFetchAll($select,$Conex,true);		
	
	$detalle_despacho_id = $result[0]['detalle_despacho_id'];
	
	if(is_numeric($detalle_despacho_id)){
	  
	  $select = "SELECT manifiesto_id FROM detalle_despacho WHERE detalle_despacho_id = $detalle_despacho_id";
      $result = $this -> DbFetchAll($select,$Conex,true);			  
	  
	  $manifiesto_id = $result[0]['manifiesto_id'];
	  
	  if(is_numeric($manifiesto_id)){
	   
	    $select = "SELECT reportado_ministerio3 FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
        $result = $this -> DbFetchAll($select,$Conex,true);			
		
		$reportado_ministerio = $result[0]['reportado_ministerio3'];
		
		if($reportado_ministerio == 1){
		   return true;		
		}else{
 		     return false;
		  }
	  
	  }else{
	      return false;
	    }
	
	}else{
	     return false;
	  }
  
  }
  
   public function getManifiestoIdRemesa($remesa_id,$Conex){
  
    $select = "SELECT MAX(detalle_despacho_id) AS detalle_despacho_id FROM detalle_despacho WHERE remesa_id = $remesa_id";
    $result = $this -> DbFetchAll($select,$Conex,true);		
	
	$detalle_despacho_id = $result[0]['detalle_despacho_id'];
	
	  
    $select = "SELECT manifiesto_id FROM detalle_despacho WHERE detalle_despacho_id = $detalle_despacho_id";
    $result = $this -> DbFetchAll($select,$Conex,true);			  
  
    $manifiesto_id = $result[0]['manifiesto_id'];
	  	   
	return $manifiesto_id;
	
   }
   
  public function getManifiestoRemesa($remesa_id,$Conex){
  
    $select = "SELECT MAX(detalle_despacho_id) AS detalle_despacho_id FROM detalle_despacho WHERE remesa_id = $remesa_id";
    $result = $this -> DbFetchAll($select,$Conex,true);		
	
	$detalle_despacho_id = $result[0]['detalle_despacho_id'];
	
	  
    $select = "SELECT manifiesto_id FROM detalle_despacho WHERE detalle_despacho_id = $detalle_despacho_id";
    $result = $this -> DbFetchAll($select,$Conex,true);			  
  
    $manifiesto_id = $result[0]['manifiesto_id'];
	  	   
	$select = "SELECT manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	$result = $this -> DbFetchAll($select,$Conex,true);			
	
	$manifiesto = $result[0]['manifiesto'];
	
	return manifiesto;
	
  
  } 
  
  public function getCodMunicipioDesbloquea($oficina_id,$Conex){
  
    $select = "SELECT ubicacion_id FROM oficina WHERE oficina_id = $oficina_id";
	$result = $this -> DbFetchAll($select,$Conex,true);				
	
	$ubicacion_id = $result[0]['ubicacion_id'];
	
	return $ubicacion_id;
  
  }
  
    public function selectConductor($conductor_id,$Conex){
	
	  $select = "SELECT t.*,c.* FROM conductor c, tercero t WHERE t.tercero_id = c.tercero_id AND c.conductor_id = $conductor_id";
  	  $result = $this->DbFetchAll($select,$Conex,true);	  
	  
	  return $result;	
	
	}

    public function selectPropietario($tercero_id,$Conex){
	
	  $select = "SELECT * FROM tercero WHERE tercero_id = $tercero_id";
  	  $result = $this->DbFetchAll($select,$Conex,true);	  
	  
	  return $result;	  	
	
	}
	
	public function selectTenedor($tenedor_id,$Conex){
	
	  $select = "SELECT tr.*,tn.* FROM tercero tr, tenedor tn WHERE tr.tercero_id = tn.tercero_id AND tn.tenedor_id = $tenedor_id";
  	  $result = $this->DbFetchAll($select,$Conex,true);	  
	  
	  return $result;	  		  
	
	}
	
	public function selectRemolque($placa_remolque_id,$Conex){
	
	  $select = "SELECT * FROM remolque WHERE placa_remolque_id = $placa_remolque_id";
  	  $result = $this->DbFetchAll($select,$Conex,true);	  
	  
	  return $result;	  
	
	}
	
  public function selectVehiculo($placa_id,$Conex){
  
    $select = "SELECT * FROM vehiculo WHERE placa_id = $placa_id";
  	$result = $this->DbFetchAll($select,$Conex,true);	
	
	return $result;
  
  }
  
  public function selectDataCliente($cliente_id,$Conex){
  
    $select = "SELECT r.*,t.* FROM cliente c, remitente_destinatario r, tercero t WHERE c.cliente_id = r.cliente_id AND r.tipo = 
	'R' AND c.tercero_id = t.tercero_id";
	
  	$result = $this->DbFetchAll($select,$Conex,true);	
	
	return $result;	
  
  }
  
  public function selectDataRemitenteDestinatario($remitente_destinatario_id,$tipo,$Conex){  
  
    $select = "SELECT r.* FROM remitente_destinatario r WHERE r.remitente_destinatario_id = 
	$remitente_destinatario_id AND r.tipo = '$tipo'";
	
  	$result = $this->DbFetchAll($select,$Conex,true);	
	
	return $result;	  
  
  }
  
  public function selectRemesa($remesa_id,$Conex){
  
    $select = "SELECT * FROM remesa WHERE remesa_id = $remesa_id";
  	$result = $this->DbFetchAll($select,$Conex,true);	
	
	return $result;	  	
  
  }	  
  
  public function remitenteDestinatarioEstaReportado($remitente_destinatario_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM remitente_destinatario WHERE remitente_destinatario_id = 
	$remitente_destinatario_id";
	
  	$result = $this->DbFetchAll($select,$Conex,true);	
		
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }
  
  }
  
  public function infoCargaEstaReportada($remesa_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM remesa WHERE remesa_id = $remesa_id";
  	$result = $this->DbFetchAll($select,$Conex,true);	
		
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }	
  
  }
  
  public function selectInfoCarga($remesa_id,$Conex){
  
    $select = "SELECT * FROM remesa WHERE remesa_id = $remesa_id";
  	$result = $this->DbFetchAll($select,$Conex,true);
	
	return $result;	
  
  }
  
  public function selectDataInfoViaje($manifiesto_id,$Conex){
  
    $dataInfoViaje = array();
	
    $select = "SELECT manifiesto,conductor_id,numero_identificacion,placa_id,placa,placa_remolque_id,placa_remolque,origen_id,
	destino_id,(SELECT codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT 
	tipo_identificacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = m.conductor_id))) AS tipo_identificacion_conductor_codigo,valor_flete 
	FROM manifiesto m WHERE manifiesto_id = $manifiesto_id";
	
  	$result = $this->DbFetchAll($select,$Conex,true);	
  
    $dataInfoViaje = $result;
	
    $select = "SELECT numero_remesa,remesa_id FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE 
	manifiesto_id = $manifiesto_id)";
	
  	$result = $this->DbFetchAll($select,$Conex,true);		
	
	$dataInfoViaje[0]['remesas'] = $result;
	
	return $dataInfoViaje;
  
  }
  
  public function vehiculoEstaReportado($placa_id,$Conex){
   
    $select = "SELECT reportado_ministerio FROM vehiculo WHERE placa_id = $placa_id";
  	$result = $this->DbFetchAll($select,$Conex,true);	
		
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }	    
  
  }

  public function remolqueEstaReportado($placa_remolque_id,$Conex){
   
    $select = "SELECT reportado_ministerio FROM remolque WHERE placa_remolque_id = $placa_remolque_id";
  	$result = $this->DbFetchAll($select,$Conex,true);	
		
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }	    
  
  }
  
  public function selectInfoRemesa($remesa_id,$manifiesto_id,$Conex){
  
     $select = "SELECT r.*,m.*,t.* FROM remesa r, manifiesto m, detalle_despacho d,tiempos_clientes_remesas t WHERE 
	 r.remesa_id = $remesa_id AND m.manifiesto_id = $manifiesto_id AND m.manifiesto_id = d.manifiesto_id AND d.remesa_id = 
	 r.remesa_id AND m.manifiesto_id = t.manifiesto_id AND t.cliente_id = r.cliente_id";
	
  	$result = $this->DbFetchAll($select,$Conex,true);	
	
	return $result;	  
  
  }
  
  public function conductorEstaReportado($conductor_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM conductor WHERE conductor_id = $conductor_id";
  	$result = $this->DbFetchAll($select,$Conex,true);	
	
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }	 	
  
  }

}

?>