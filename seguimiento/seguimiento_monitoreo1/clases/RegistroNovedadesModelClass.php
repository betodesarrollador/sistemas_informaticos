<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
require_once("../../../framework/clases/MailClass.php");

final class RegistroNovedadesModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex,true);
  }
  
  public function UpdateNota($nota,$trafico_id,$Conex){
		$this -> Begin($Conex,true);
			$updatenota="UPDATE trafico SET nota_controlador = '$nota' WHERE trafico_id = $trafico_id";
			$query = $this -> query($updatenota,$Conex,true);
		$this -> Commit($Conex,true);
	}
  
  public function Update($Campos,$usuario_id,$Conex){
	
	$this -> Begin($Conex,true);
	
	$trafico_id 				= $this -> requestDataForQuery('trafico_id','integer');	
	$ruta_id 					= $this -> requestDataForQuery('ruta_id','integer');
	$rutahidden 				= $this -> requestDataForQuery('rutahidden','integer');
	$fecha_inicial_salida 		= $this -> requestDataForQuery('fecha_inicial_salida','date');
	$nota_controlador		    = $this -> requestDataForQuery('nota_controlador','text');
	$hora_inicial_salida 		= $this -> requestDataForQuery('hora_inicial_salida','time');	
	$escolta_recibe				= $this -> requestDataForQuery('escolta_recibe','text');	
	$escolta_entrega			= $this -> requestDataForQuery('escolta_entrega','text');		  
	$apoyo_id_recibe			= $this -> requestDataForQuery('apoyo_id_recibe','integer');	
	$apoyo_id_entrega			= $this -> requestDataForQuery('apoyo_id_entrega','integer');		  
	$t_nocturno					= $this -> requestDataForQuery('t_nocturno','integer');	
	$estado						= $this -> requestDataForQuery('estado','alphanum');
	$hora						= explode(':',$this -> requestData('hora_inicial_salida'));
	$fecha						= explode('-',$this -> requestData('fecha_inicial_salida'));
	$frecuencia					= $this -> requestDataForQuery('frecuencia','integer');
	
    $select           = "SELECT ruta_id FROM trafico WHERE trafico_id = $trafico_id";
    $dataRutaAsignada = $this -> DbFetchAll($select,$Conex,true); 
    $ruta_asignada_id = $dataRutaAsignada[0]['ruta_id'];
	
    if(is_numeric($ruta_id)){
  
	  if($ruta_asignada_id != $ruta_id){
	 
		 $delete = "DELETE FROM detalle_seguimiento WHERE trafico_id = $trafico_id";
		 $result = $this -> query($delete,$Conex,true);
	 
	  }
  
    }	
	
	if(!strlen(trim($_REQUEST['anul_usuario_id'])) > 0){
      $this -> assignValRequest('anul_usuario_id','NULL');	
	}
	
	if(!strlen(trim($_REQUEST['causal_anulacion_id'])) > 0){
      $this -> assignValRequest('causal_anulacion_id','NULL');		
	}	
		
	if($estado == "'R'" || $estado == "'P'" || $estado =="'F'"){
		
		$tipo_despacho = "SELECT despachos_urbanos_id,manifiesto_id,reexpedido_id FROM trafico WHERE trafico_id=$trafico_id";
		$result_tipo   = $this -> DbFetchAll($tipo_despacho,$Conex,true); 
		
		if($result_tipo[0]['despachos_urbanos_id']>0){
			
			$sel_remesas = "(SELECT remesa_id FROM detalle_despacho WHERE despachos_urbanos_id=".$result_tipo[0]['despachos_urbanos_id'].")
							UNION ALL
							(SELECT remesa_paqueteo_id FROM relacion_masivo_paqueteo
							 WHERE remesa_masivo_id IN( SELECT remesa_id FROM detalle_despacho WHERE							 					  despachos_urbanos_id=".$result_tipo[0]['despachos_urbanos_id']."))";
							
			$result_remesas   = $this -> DbFetchAll($sel_remesas,$Conex,true); 
			
			for($i=0;$i<count($result_remesas);$i++){
				
				if($result_remesas[$i]['remesa_id']>0){
				
				$detalle_seguimiento_remesa_id	=	$this	->	DbgetMaxConsecutive("detalle_seguimiento_remesa", "detalle_seg_rem_id", $Conex,false,1);	
				$novedad_id = 70;
				
				$insert_det ="INSERT INTO detalle_seguimiento_remesa (detalle_seg_rem_id,remesa_id,novedad_id,fecha_hora_registro,fecha_hora_suceso,usuario_id) VALUES ($detalle_seguimiento_remesa_id,".$result_remesas[$i]['remesa_id'].",$novedad_id,NOW(),NOW(),$usuario_id) ";	
				
				$this -> query($insert_det,$Conex,true);
				
				$select1 = "SELECT n.reporte_interno, n.reporte_cliente, n.novedad, a.alerta_panico,n.requiere_remesa,n.finaliza_remesa FROM novedad_seguimiento n, alerta_panico a WHERE n.novedad_id=$novedad_id AND a.alerta_id=n.alerta_id ";
	$result1 = $this -> DbFetchAll($select1,$Conex,true);
	
			$select_datos_remesa ="SELECT CONCAT(r.prefijo_tipo,r.prefijo_oficina) as prefijo ,r.numero_remesa,r.cliente_id,
			(SELECT CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)as cliente FROM tercero tr, cliente c WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id)as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino			
			FROM remesa r WHERE r.remesa_id=".$result_remesas[$i]['remesa_id'];
			$result_datos_remesa = $this -> DbFetchAll($select_datos_remesa,$Conex,true);
	
	
		
		  $mail_subject='Novedad: Remesa: '.$result_datos_remesa[0]['prefijo'].''.$result_datos_remesa[0]['numero_remesa'];
		  $mensaje='';
		  $mensaje.='Ciente: '.$result_datos_remesa[0]['cliente'].'<br>';
		  $mensaje.='Origen: '.$result_datos_remesa[0]['origen'].'. Destino:'.$result_datos_remesa[0]['destino'].'<br>';
		  
		  $mensaje.='Alerta:  '.$result1[0][alerta_panico].'<br>';
		  $mensaje.='Novedad:  '.$result1[0][novedad].'<br>';		
		  $mensaje.='Numero Remesa:  '.$result_datos_remesa[0]['prefijo'].''.$result_datos_remesa[0]['numero_remesa'].'<br>';		
		  $mensaje.='Nota : La remesa se encuentra en despacho Urbano';
		
	   if($result1[0][reporte_cliente]==1){
		   $cliente_id=$_REQUEST['cliente_id'];
		  $select_correo  = "SELECT LOWER(cf.correo_cliente_factura_operativa) AS  correo FROM cliente_factura_operativa cf WHERE cf.cliente_id=".$result_datos_remesa[0]['cliente_id'];
		  
		  $result_correo = $this -> DbFetchAll($select_correo,$Conex,true);
		  
			  
		  foreach($result_correo as $item_correo){
				$enviar_mail=new Mail();				  
				$mensaje_exitoso==$enviar_mail->sendMail(trim($item_correo[correo]),$mail_subject,$mensaje);
	
		  }
	   }
				
			}
							
			}
		}else if($result_tipo[0]['manifiestos_id']>0){
			
			
			$sel_remesas = "(SELECT remesa_id FROM detalle_despacho WHERE despachos_urbanos_id=$result_tipo[0]['despachos_urbanos_id'])
							UNION ALL
							(SELECT remesa_paqueteo_id FROM relacion_masivo_paqueteo
							 WHERE remesa_masivo_id =( SELECT remesa_id FROM detalle_despacho WHERE							 					  despachos_urbanos_id=$result_tipo[0]['manifiestos_id']))";
			$result_remesas   = $this -> DbFetchAll($sel_remesas,$Conex,true); 
			
			for($i=0;$i<count($result_remesas);$i++){
				
				$detalle_seguimiento_remesa_id	=	$this	->	DbgetMaxConsecutive("detalle_seguimiento_remesa", "detalle_seg_rem_id", $Conex,false,1);	
				$novedad_id = 72;
				
				$insert_det ="INSERT INTO detalle_seguimiento_remesa (detalle_seg_rem_id,remesa_id,novedad_id,fecha_hora_registro,fecha_hora_suceso,usuario_id) VALUES ($detalle_seguimiento_remesa_id,".$result_remesas[$i]['remesa_id'].",$novedad_id,NOW(),NOW(),$usuario_id) ";	
				$this -> query($insert_det,$Conex,true);
				
				$select1 = "SELECT n.reporte_interno, n.reporte_cliente, n.novedad, a.alerta_panico,n.requiere_remesa,n.finaliza_remesa FROM novedad_seguimiento n, alerta_panico a WHERE n.novedad_id=$novedad_id AND a.alerta_id=n.alerta_id ";
	$result1 = $this -> DbFetchAll($select1,$Conex,true);
	
			$select_datos_remesa ="SELECT CONCAT(r.prefijo_tipo,r.prefijo_oficina) as prefijo ,r.numero_remesa,r.cliente_id,
			(SELECT CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)as cliente FROM tercero tr, cliente c WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id)as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino			
			FROM remesa r WHERE r.remesa_id=".$result_remesas[$i]['remesa_id'];
			$result_datos_remesa = $this -> DbFetchAll($select_datos_remesa,$Conex,true);
	
	
		
		  $mail_subject='Novedad: Remesa: '.$result_datos_remesa[0]['prefijo'].''.$result_datos_remesa[0]['numero_remesa'];
		  $mensaje='';
		  $mensaje.='Ciente: '.$result_datos_remesa[0]['cliente'].'<br>';
		  $mensaje.='Origen: '.$result_datos_remesa[0]['origen'].'. Destino:'.$result_datos_remesa[0]['destino'].'<br>';
		  
		  $mensaje.='Alerta:  '.$result1[0][alerta_panico].'<br>';
		  $mensaje.='Novedad:  '.$result1[0][novedad].'<br>';		
		  $mensaje.='Numero Remesa:  '.$result_datos_remesa[0]['prefijo'].''.$result_datos_remesa[0]['numero_remesa'].'<br>';		
		  $mensaje.='Nota : La remesa se encuentra en despacho Nacional';
		
	   if($result1[0][reporte_cliente]==1){
		   $cliente_id=$_REQUEST['cliente_id'];
		  $select_correo  = "SELECT LOWER(cf.correo_cliente_factura_operativa) AS  correo FROM cliente_factura_operativa cf WHERE cf.cliente_id=$cliente_id";
		  
		  $result_correo = $this -> DbFetchAll($select_correo,$Conex,true);
		  
			  
		  foreach($result_correo as $item_correo){
				$enviar_mail=new Mail();				  
				$mensaje_exitoso==$enviar_mail->sendMail(trim($item_correo[correo]),$mail_subject,$mensaje);
	
		  }
	   }
				
			}
							
		
		
		}
		
		
		
	  $this -> assignValRequest('estado','T');
	}
			
    $this -> DbUpdateTable("trafico",$Campos,$Conex,true,false);
	
	/*
	if($estado=="'F'" ){
		
		$estado_nuevo = 'F';		
		$update       = "UPDATE trafico SET  ruta_id=$ruta_id,
										fecha_inicial_salida=$fecha_inicial_salida,
										hora_inicial_salida=$hora_inicial_salida,
										escolta_recibe=$escolta_recibe,
										escolta_entrega=$escolta_entrega,
										apoyo_id_recibe=$apoyo_id_recibe,
										apoyo_id_entrega=$apoyo_id_entrega,
										t_nocturno=$t_nocturno,
										estado='$estado_nuevo'
					WHERE trafico_id=$trafico_id"; 
		$this -> query($update,$Conex,true);
	}	
	
	if($estado=="'P'" ){
		
		/*$actual=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
		$salida=mktime($hora[0],$hora[1],00,$fecha[1],$fecha[2],$fecha[0]);
		
		if(($t_nocturno==1 && $rutahidden=='') || ($t_nocturno==1 && $rutahidden!='' && $rutahidden!=$ruta_id && $ruta_id>0)){
			$estado_nuevo='N';
		}else{
			$estado_nuevo=$salida>$actual ? 'R' : 'T';
		}
		
		
		$update = "UPDATE trafico SET  	ruta_id=$ruta_id,
										fecha_inicial_salida=$fecha_inicial_salida,
										hora_inicial_salida=$hora_inicial_salida,
										escolta_recibe=$escolta_recibe,
										escolta_entrega=$escolta_entrega,
										apoyo_id_recibe=$apoyo_id_recibe,
										apoyo_id_entrega=$apoyo_id_entrega,
										t_nocturno=$t_nocturno,
										estado='$estado_nuevo'
					WHERE trafico_id=$trafico_id"; 
		$this -> query($update,$Conex,true);
	}

	if($estado=="'R'" ){

		$actual=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
		$salida=mktime($hora[0],$hora[1],00,$fecha[1],$fecha[2],$fecha[0]);
		$estado_nuevo=$salida>$actual ? 'R' : 'T';

		if(($t_nocturno==1 && $rutahidden=='') || ($t_nocturno==1 && $rutahidden!='' && $rutahidden!=$ruta_id && $ruta_id>0)){
			$estado_nuevo='N';
		}else{
			$estado_nuevo=$salida>$actual ? 'R' : 'T';
		}

		$update = "UPDATE trafico SET  	ruta_id=$ruta_id,
										fecha_inicial_salida=$fecha_inicial_salida,
										hora_inicial_salida=$hora_inicial_salida,
										escolta_recibe=$escolta_recibe,
										escolta_entrega=$escolta_entrega,
										apoyo_id_recibe=$apoyo_id_recibe,
										apoyo_id_entrega=$apoyo_id_entrega,
										t_nocturno=$t_nocturno,
										estado='$estado_nuevo'
					WHERE trafico_id=$trafico_id"; 
		$this -> query($update,$Conex,true);
	}

	if($estado=="'T'" ){

		if(($t_nocturno==1 && $rutahidden=='') || ($t_nocturno==1 && $rutahidden!='' && $rutahidden!=$ruta_id && $ruta_id>0)){
			$estado_nuevo='N';
		}else{
			$estado_nuevo='T';
		}
		$update = "UPDATE trafico SET  	ruta_id=$ruta_id,
										escolta_recibe=$escolta_recibe,
										escolta_entrega=$escolta_entrega,
										apoyo_id_recibe=$apoyo_id_recibe,
										apoyo_id_entrega=$apoyo_id_entrega,
										estado='$estado_nuevo'
					WHERE trafico_id=$trafico_id"; 
		$this -> query($update,$Conex,true);
	}
	
	*/
	
	
	
  /*  if($this -> GetNumError() > 0){
      return false;
    }else{   */
	
		if(($t_nocturno==1 && $rutahidden=='NULL') || ($t_nocturno==1 && $rutahidden!='NULL' && $rutahidden!=$ruta_id && $ruta_id>0)){
		
			$trafico_nocturno_id = $this -> DbgetMaxConsecutive("trafico_nocturno","trafico_nocturno_id",$Conex,true,1);
			
			$insert_nocturno="INSERT INTO trafico_nocturno (trafico_nocturno_id,trafico_id,ruta_id,estado) VALUES ($trafico_nocturno_id,$trafico_id,$ruta_id,'PA')";
			$this -> query($insert_nocturno,$Conex,true);
			
			
		}

				
		if(is_numeric($ruta_id) && $ruta_id != $ruta_asignada_id){	
				
			$select_ori = "SELECT d.orden_det_ruta, d.detalle_ruta_id, d.ubicacion_id FROM detalle_ruta d,  trafico t
			WHERE t.trafico_id=$trafico_id AND d.ruta_id=$ruta_id AND d.ubicacion_id=t.origen_id  AND d.punto_referencia_id IS NULL  ";
			$result_ori = $this -> DbFetchAll($select_ori,$Conex,true);

			$select_des = "SELECT d.orden_det_ruta, d.detalle_ruta_id, d.ubicacion_id FROM detalle_ruta d,  trafico t
			WHERE t.trafico_id=$trafico_id AND d.ruta_id=$ruta_id AND d.ubicacion_id=t.destino_id  AND d.punto_referencia_id IS NULL  ";
			$result_des = $this -> DbFetchAll($select_des,$Conex,true);
			
			$id_det_ori=$result_ori[0][detalle_ruta_id];
			$id_det_des=$result_des[0][detalle_ruta_id];

			$origen_id=$result_ori[0][ubicacion_id];
			$destino_id=$result_des[0][ubicacion_id];
			
			
			if($result_ori[0][orden_det_ruta]>$result_des[0][orden_det_ruta]){ 
				$orderby='DESC'; 
				$ord_origen=$result_des[0][orden_det_ruta];
				$ord_destino=$result_ori[0][orden_det_ruta];
			
			}else{ 
				$orderby='ASC'; 
				$ord_origen=$result_ori[0][orden_det_ruta];
				$ord_destino=$result_des[0][orden_det_ruta];
			
			}
			

			$select = "SELECT d.detalle_ruta_id, d.ubicacion_id, d.punto_referencia_id, d.orden_det_ruta,IF(punto_referencia_id IS 
			NULL,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.ubicacion_id),(SELECT nombre FROM punto_referencia 
			WHERE punto_referencia_id=d.punto_referencia_id)) AS nombre,IF(punto_referencia_id IS NULL,(SELECT 
			nombre FROM tipo_ubicacion WHERE tipo_ubicacion_id = (SELECT tipo_ubicacion_id FROM ubicacion WHERE ubicacion_id = 
			d.ubicacion_id)),(SELECT nombre FROM tipo_punto_referencia WHERE tipo_punto_referencia_id = (SELECT 
			tipo_punto_referencia_id FROM punto_referencia WHERE punto_referencia_id = d.punto_referencia_id)))
			AS tipo_punto FROM detalle_ruta d WHERE d.ruta_id=$ruta_id  AND d.orden_det_ruta >=$ord_origen AND  d.orden_det_ruta 
			<=$ord_destino ORDER BY d.orden_det_ruta $orderby  ";
			
			$result = $this -> DbFetchAll($select,$Conex,true); 
			$cont=1;

		/*	$detalle_seg_id 	= $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true,1);
			$insert_ori = "INSERT INTO  detalle_seguimiento (
										detalle_seg_id,
										trafico_id,
										detalle_ruta_id,
										ubicacion_id,
										orden_det_ruta
									)VALUES(
										$detalle_seg_id,
										$trafico_id,
										$id_det_ori,
										$origen_id,
										$cont
									)"; 
			$this -> query($insert_ori,$Conex,true);
			$cont++;*/
			foreach($result as $items){
			
				$punto_referencia_id = $items[punto_referencia_id]!='' ? $items[punto_referencia_id]: 'NULL';				
				$detalle_seg_id 	 = $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true,1);				
				$ubicacion_id        = is_numeric($items[ubicacion_id]) ? $items[ubicacion_id] : 'NULL';
				
				$insert = "INSERT INTO  detalle_seguimiento (
											detalle_seg_id,
											trafico_id,
											detalle_ruta_id,
											ubicacion_id,
											punto_referencia,
											tipo_punto,
											punto_referencia_id,
											orden_det_ruta
										)VALUES(
											$detalle_seg_id,
											$trafico_id,
											$items[detalle_ruta_id],
											$ubicacion_id,
											'$items[nombre]',
											'$items[tipo_punto]',
											$punto_referencia_id,
											$cont
										)"; 
										
				$this -> query($insert,$Conex,true);  
				$cont++;
				
			}

		/*	$detalle_seg_id 	= $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true,1);
			$insert_des = "INSERT INTO  detalle_seguimiento (
										detalle_seg_id,
										trafico_id,
										detalle_ruta_id,
										ubicacion_id,
										orden_det_ruta
									)VALUES(
										$detalle_seg_id,
										$trafico_id,
										$id_det_des,
										$destino_id,
										$cont
									)"; 
			$this -> query($insert_des,$Conex,true);
			$cont++;   */
		}
		
		/*elseif($rutahidden>0 && $ruta_id>0){
			$variable=0;	
		}*/

	//}	
	 
  $this -> Commit($Conex,true);	 

  }

 public function enviar_webservice($trafico_id,$Conex){
	  
	include_once("../../../framework/clases/nusoap/nusoap.php");  
    $select = "SELECT manifiesto_id, despachos_urbanos_id, fecha_inicial_salida, hora_inicial_salida,  	origen_id, destino_id FROM trafico 
	WHERE trafico_id=$trafico_id ";
	$result = $this -> DbFetchAll($select,$Conex,true);

	//$oSoapClient = new soapclient('https://web10.intrared.net/ap/interf/app/faro/wsdl/faro.wsdl', true);
	$oSoapClient = new soapclient('https://avansatgl.intrared.net/ap/interf/app/faro/wsdl/faro.wsdl', true);

	if ($sError = $oSoapClient->getError()) {
	 return "No se pudo realizar la operación [" . $sError . "]";
	 die();
	}

	
	if($result[0]['manifiesto_id']>0){

		$select1 = "SELECT t.manifiesto AS consecutivo,
						t.placa AS cod_placax,
						t.modelo AS num_modelo,
						t.numero_identificacion	AS cod_conduc,
						t.nombre AS nom_conduc,
						(SELECT te.ubicacion_id	FROM conductor c, tercero te WHERE c.conductor_id=t.conductor_id AND te.tercero_id=c.tercero_id) AS ciu_conduc,
						t.telefono_conductor AS tel_conduc,
						(SELECT te.movil	FROM  conductor c, tercero te WHERE  c.conductor_id=t.conductor_id AND te.tercero_id=c.tercero_id) AS mov_conduc,
						t.numero_identificacion_tenedor  AS cod_poseed,
						t.tenedor 	 AS nom_poseed,
						t.observaciones,
						(SELECT te.ubicacion_id	FROM  tenedor c, tercero te WHERE  c.tenedor_id=t.tenedor_id AND te.tercero_id=c.tercero_id) AS ciu_poseed
				FROM manifiesto t WHERE  t.manifiesto_id = ".$result[0]['manifiesto_id']."";
		$datos = $this -> DbFetchAll($select1,$Conex,true);
		
		$aParametros = array('nom_usuari' => 'InterfMulmod','pwd_clavex' => '@v};Rpb0e','cod_tranps'=>'900810385','cod_manifi'=>$datos[0]['consecutivo'],'dat_fechax'=>$result[0]['fecha_inicial_salida'].' '.$result[0]['hora_inicial_salida'],'cod_ciuori'=>$result[0]['origen_id'],
					'cod_ciudes'=>$result[0]['destino_id'],'cod_placax'=>$datos[0]['cod_placax'],'num_modelo'=>$datos[0]['num_modelo'],'cod_marcax'=>'ZZ','cod_lineax'=>'999','cod_colorx'=>'0',
					'cod_conduc'=>$datos[0]['cod_conduc'],'nom_conduc'=>$datos[0]['nom_conduc'],'ciu_conduc'=>$datos[0]['ciu_conduc'],'tel_conduc'=>$datos[0]['tel_conduc'],'mov_conduc'=>$datos[0]['mov_conduc'],
					'obs_coment'=>$datos[0]['observaciones'],'cod_rutax'=>'0','nom_rutaxx'=>'','ind_naturb'=>'1','num_config'=>'0','cod_carroc'=>'0','cod_poseed'=>$datos[0]['cod_poseed'],
					'nom_poseed'=>$datos[0]['nom_poseed'],'ciu_poseed'=>$datos[0]['ciu_poseed'],'cod_agedes'=>'575');

	
	/*}elseif($result[0]['despachos_urbanos_id']>0){

		$select1 = "SELECT t.despacho AS consecutivo,
						t.placa AS cod_placax,
						t.modelo AS num_modelo,
						t.numero_identificacion	AS cod_conduc,
						t.nombre AS nom_conduc,
						(SELECT te.ubicacion_id	FROM conductor c, tercero te WHERE c.conductor_id=t.conductor_id AND te.tercero_id=c.tercero_id) AS ciu_conduc,
						t.telefono_conductor AS tel_conduc,
						(SELECT te.movil	FROM  conductor c, tercero te WHERE  c.conductor_id=t.conductor_id AND te.tercero_id=c.tercero_id) AS mov_conduc,
						t.numero_identificacion_tenedor  AS cod_poseed,
						t.tenedor 	 AS nom_poseed,
						t.observaciones,
						(SELECT te.ubicacion_id	FROM  tenedor c, tercero te WHERE  c.tenedor_id=t.tenedor_id AND te.tercero_id=c.tercero_id) AS ciu_poseed
				FROM despachos_urbanos  t WHERE  t.despachos_urbanos_id = ".$result[0]['despachos_urbanos_id']."";
		$datos = $this -> DbFetchAll($select1,$Conex,true);
		
		$aParametros = array('nom_usuari' => 'InterfRotterdam','pwd_clavex' => 'Rott3rD@m_TooL','cod_tranps'=>'800148973','cod_manifi'=>$datos[0]['consecutivo'],'dat_fechax'=>$result[0]['fecha_inicial_salida'].' '.$result[0]['hora_inicial_salida'],'cod_ciuori'=>$result[0]['origen_id'],
					'cod_ciudes'=>$result[0]['destino_id'],'cod_placax'=>$datos[0]['cod_placax'],'num_modelo'=>$datos[0]['num_modelo'],'cod_marcax'=>'ZZ','cod_lineax'=>'999','cod_colorx'=>'0',
					'cod_conduc'=>$datos[0]['cod_conduc'],'nom_conduc'=>$datos[0]['nom_conduc'],'ciu_conduc'=>$datos[0]['ciu_conduc'],'tel_conduc'=>$datos[0]['tel_conduc'],'mov_conduc'=>$datos[0]['mov_conduc'],

					'obs_coment'=>$datos[0]['observaciones'],'cod_rutax'=>'0','nom_rutaxx'=>'','ind_naturb'=>'0','num_config'=>'0','cod_carroc'=>'0','cod_poseed'=>$datos[0]['cod_poseed'],
					'nom_poseed'=>$datos[0]['nom_poseed'],'ciu_poseed'=>$datos[0]['ciu_poseed'],'cod_agedes'=>'575');

	}*/

		$respuesta   = $oSoapClient->call('setSeguim',$aParametros); 
		
		if ($oSoapClient->fault) { 
		 return 'No se pudo completar la operaci&oacute;n';
		 die();
		} else { 
		
		  $sError = $oSoapClient->getError();
		
		  if ($sError){ 
			return 'Error:'. $sError;
			die();
		  }else{
			   return 'Planilla No '.$datos['consecutivo'].' '.$respuesta;
		  }
		
		} 
  	}else{
		return 'Solo Se reportan Planillas Nacionales (Manifiesto de Carga)';
	}
  }

   public function llegar_webservice($trafico_id,$Conex){
	  
	include_once("../../../framework/clases/nusoap/nusoap.php");  
    $select = "SELECT manifiesto_id, despachos_urbanos_id, fecha_inicial_salida, hora_inicial_salida,  	origen_id, destino_id FROM trafico 
	WHERE trafico_id=$trafico_id ";
	$result = $this -> DbFetchAll($select,$Conex,true);

	$oSoapClient = new soapclient('https://web10.intrared.net/ap/interf/app/faro/wsdl/faro.wsdl', true);

	if ($sError = $oSoapClient->getError()) {
	 return "No se pudo realizar la operación [" . $sError . "]";
	 die();
	}

	
	if($result[0]['manifiesto_id']>0){

		$select1 = "SELECT t.manifiesto AS consecutivo,
						t.placa AS cod_placax,
						(SELECT  CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte) AS fechax FROM detalle_seguimiento ds, novedad_seguimiento ns, trafico tr 
						WHERE tr.manifiesto_id=t.manifiesto_id AND  ds.trafico_id=tr.trafico_id AND ds.borrado=0 AND  ns.novedad_id=ds.novedad_id AND ns.finaliza_recorrido=1 ORDER BY ds.fecha_reporte DESC LIMIT 0,1) AS dat_fechax,

						(SELECT  ds.obser_deta FROM detalle_seguimiento ds, novedad_seguimiento ns, trafico tr 
						WHERE tr.manifiesto_id=t.manifiesto_id AND  ds.trafico_id=tr.trafico_id AND ds.borrado=0 AND  ns.novedad_id=ds.novedad_id AND ns.finaliza_recorrido=1 ORDER BY ds.fecha_reporte DESC LIMIT 0,1) AS obs_llegad
				
				FROM manifiesto t WHERE  t.manifiesto_id = ".$result[0]['manifiesto_id']."";
		$datos = $this -> DbFetchAll($select1,$Conex,true);
		
		$aParametros = array('nom_usuari' => 'InterfRotterdam','pwd_clavex' => 'Rott3rD@m_TooL','cod_tranps'=>'800148973','cod_manifi'=>$datos[0]['consecutivo'],'fec_llegad'=>$datos[0]['dat_fechax'],
						'obs_llegad'=>$datos[0]['obs_llegad'],'num_placax'=>$datos[0]['cod_placax']);

	}elseif($result[0]['despachos_urbanos_id']>0){

		$select1 = "SELECT t.despacho AS consecutivo,
						t.placa AS cod_placax,
						(SELECT  CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte) AS fechax FROM detalle_seguimiento ds, novedad_seguimiento ns, trafico tr 
						WHERE tr.despachos_urbanos_id=t.despachos_urbanos_id AND  ds.trafico_id=tr.trafico_id AND ds.borrado=0 AND  ns.novedad_id=ds.novedad_id AND ns.finaliza_recorrido=1 ORDER BY ds.fecha_reporte DESC LIMIT 0,1) AS dat_fechax,

						(SELECT  ds.obser_deta FROM detalle_seguimiento ds, novedad_seguimiento ns, trafico tr 
						WHERE tr.despachos_urbanos_id=t.despachos_urbanos_id AND  ds.trafico_id=tr.trafico_id AND ds.borrado=0 AND  ns.novedad_id=ds.novedad_id AND ns.finaliza_recorrido=1 ORDER BY ds.fecha_reporte DESC LIMIT 0,1) AS obs_llegad

				FROM despachos_urbanos  t WHERE  t.despachos_urbanos_id = ".$result[0]['despachos_urbanos_id']."";
		$datos = $this -> DbFetchAll($select1,$Conex,true);
		
		
		$aParametros = array('nom_usuari' => 'InterfRotterdam','pwd_clavex' => 'Rott3rD@m_TooL','cod_tranps'=>'800148973','cod_manifi'=>$datos[0]['consecutivo'],'fec_llegad'=>$datos[0]['dat_fechax'],
						'obs_llegad'=>$datos[0]['obs_llegad'],'num_placax'=>$datos[0]['cod_placax']);

	}

	$respuesta   = $oSoapClient->call('setLlegad',$aParametros); 
	
	if ($oSoapClient->fault) { 
	 return 'No se pudo completar la operaci&oacute;n';
	 die();
	} else { 
	
	  $sError = $oSoapClient->getError();
	
	  if ($sError){ 
		return 'Error:'. $sError;
		die();
	  }else{
		   return 'Planilla No '.$datos['consecutivo'].' '.$respuesta;
	  }
	
	} 
	
  }

  public function getRutas($trafico_id,$Conex){
	  
    $select = "SELECT ruta_id AS value,CONCAT_WS(' / ',ruta,pasador_vial) AS text FROM ruta 
	WHERE ruta_id IN (SELECT d.ruta_id FROM detalle_ruta d, trafico t WHERE t.trafico_id=$trafico_id AND d.ubicacion_id=t.origen_id AND punto_referencia_id IS NULL ) 
	AND ruta_id IN (SELECT d.ruta_id FROM detalle_ruta d, trafico t WHERE t.trafico_id=$trafico_id AND d.ubicacion_id=t.destino_id AND punto_referencia_id IS NULL ) ";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
	  
  }

  public function getSelectedRutas($trafico_id,$Conex){
  
    $select = "SELECT ruta_id FROM trafico WHERE trafico_id = $trafico_id";
	$result = $this -> DbFetchAll($select,$Conex,true);
	return $result;  
  
  }

  
  public function getDataMap($Conex){
  
	$trafico_id = $_REQUEST['trafico_id'];
	
	$select = "SELECT IF(ds.punto_referencia_id>0,(SELECT x FROM punto_referencia WHERE punto_referencia_id=ds.punto_referencia_id),(SELECT x FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id)) AS lat, 
					  IF(ds.punto_referencia_id>0,(SELECT y FROM punto_referencia WHERE punto_referencia_id=ds.punto_referencia_id),(SELECT y FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id)) AS lon, 
					  IF(ds.punto_referencia_id>0,(SELECT nombre FROM punto_referencia WHERE punto_referencia_id=ds.punto_referencia_id),(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id))	AS nom 
				FROM  detalle_seguimiento ds
				WHERE ds.trafico_id=$trafico_id
				AND ds.fecha_reporte IS NOT NULL
				ORDER BY ds.orden_det_ruta";
			
	return $this -> DbFetchAll($select,$Conex,true);  
	  
  }
  
  public function createRoute($Conex){
    
	$recorrido_acumulado = 0;//acumulador para el recorrido
	$tiempo_acumulado    = 0;//acumulador para el tiempo
	$orden_det_ruta       = 1;//se iniicaliza el orden para todas las rutas seleccionadas
	
	$trafico_id      	 = $_REQUEST['trafico_id'];
	$ruta_seleccionada   = explode(",",$_REQUEST['ruta_seleccionada_id']);
	
	/**
	* obtenemos la fecha hora de salida
	* para calcular los pasos estimados
	* a partir de esta
	*/
	$qryFechaHora = "SELECT CONCAT_WS(' ', fecha_inicial_salida,hora_inicial_salida) AS salida 
					FROM trafico WHERE trafico_id=$trafico_id";
	$FechaHora    = $this -> DbFetchAll($qryFechaHora,$Conex,true);
	$salida       = $FechaHora[0]['salida'];
	
	/**
	* borramos los detalles de seguimiento antes creados
	* para proceder con la insercion de los nuevos
	*/
	$delete = "DELETE FROM detalle_seguimiento WHERE trafico_id = $trafico_id"; 
	$this -> query($delete,$Conex,true);
		
	for($rs = 0; $rs < count($ruta_seleccionada); $rs++){
	  
	  /**
	  * se optienen todos los detalles
	  * de las rutas seleccionadas
	  */
	  $ruta_seleccionada_id = $ruta_seleccionada[$rs];
	  $select = "SELECT * FROM detalle_ruta d WHERE ruta_id=$ruta_seleccionada_id ORDER BY orden_det_ruta"; 
	  
	  $detalleRuta = $this -> DbFetchAll($select,$Conex,true);
	  /**
	  * por cada detalle_ruta se realiza la nueva insercion
	  */
	  for($dt = 0; $dt < count($detalleRuta); $dt++){
	    
		$ubicacion_id         = $detalleRuta[$dt]['ubicacion_id'];
		$tiempo_tramo         = $detalleRuta[$dt]['tiempo_det_ruta'];
		$distancia_tramo      = $detalleRuta[$dt]['distancia_det_ruta'];
		$recorrido_acumulado += $distancia_tramo;//se acumula
		$tiempo_acumulado    += $tiempo_tramo;//se acumula
		list($fecha_reporte, $hora_reporte) = explode(' ', $detalleRuta[$dt]['paso_estimado']);
		
		/**
		* se optiene el detalle_seg_id para la nueva insercion
		*/
		$detalle_seg_id = $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true);	
		$detalle_seg_id = ($detalle_seg_id + 1);
		
		$insert = "INSERT INTO detalle_seguimiento 
					(detalle_seg_id,seguimiento_id,orden_det_ruta,ubicacion_id,tiempo_tramo,paso_estimado,
					distancia_tramo,recorrido_acumulado,plan_ruta,fecha_reporte,hora_reporte,tiempo_novedad,retraso) 
	           VALUES
			   		($detalle_seg_id,$seguimiento_id,$orden_det_ruta,$ubicacion_id,$tiempo_tramo,DATE_ADD('$salida',INTERVAL $tiempo_acumulado MINUTE),
					$distancia_tramo,$recorrido_acumulado,1,DATE_ADD('$salida',INTERVAL $tiempo_acumulado MINUTE),DATE_ADD('$salida',INTERVAL $tiempo_acumulado MINUTE),0,0)";
	
        $this -> query($insert,$Conex,true);
		
	    $orden_det_ruta++;
	  }
	  
	    
	}//fin del for ruta_seleccionada
  }
  
  public function moveToUrban($Conex){
  
  
     $trafico_id = $this -> requestData('trafico_id');
	 
	 $update = "UPDATE trafico SET urbano = 1 WHERE trafico_id = $trafico_id";
	 
	 $this -> query($update,$Conex,true);
  
  }
 //_---------------------------Regresar a trafico-------------------//
  public function regresarTrafico($Conex){
  
  
     $trafico_id = $this -> requestData('trafico_id');
	 
	 $verificacion="select if ((select datediff(curdate(),(select IF(t.seguimiento_id>0,(SELECT fecha FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT fecha_du FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT fecha_mc FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS fecha
                
                FROM  trafico t
				WHERE t.trafico_id=$trafico_id)) >5),'si','no') as antiguo ";
	 
	 $confirmacion = $this -> DbFetchAll($verificacion,$Conex,true);
	 
	 if ($confirmacion [0]['antiguo']=='no')
	 {
	 
	 $update = "UPDATE trafico SET estado = 'T' WHERE trafico_id = $trafico_id";
	 
	 $this -> query($update,$Conex,true);
	 $mensaje="Regresado a trafico";
	 		 
	 }
	 else
	 {
		 $mensaje="El manifiesto es muy antiguo!!";
	 }
	echo $mensaje;
		 
  }
   //_---------------------------Regresar a trafico-------------------//

 /* public function cancellation($Conex){
	 

	$this -> Begin($Conex,true);

      $trafico_id 				= $this -> requestDataForQuery('trafico_id','integer');
      $causal_anulacion_id  	= $this -> requestDataForQuery('causal_anulacion_id','integer');
      $anul_trafico			   	= $this -> requestDataForQuery('anul_trafico','text');
	  $desc_anul_trafico		= $this -> requestDataForQuery('desc_anul_trafico','text');
	  $anul_usuario_id         	= $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	 
	  $update = "UPDATE trafico SET estado= 'A',
	  				causal_anulacion_id = $causal_anulacion_id,
					anul_trafico=$anul_trafico,
					desc_anul_trafico =$desc_anul_trafico,
					anul_usuario_id=$anul_usuario_id
	  			WHERE trafico_id=$trafico_id";
					
      $this -> query($update,$Conex,true);		  
	
	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex,true);
	  }else{		
      	$this -> Commit($Conex,true);			
	  }  
  }*/
  
    public function cancellation($usuario_id,$Conex){
  

 $this -> Begin($Conex,true);
 

      $trafico_id     = $this -> requestDataForQuery('trafico_id','integer');
      $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');
      $anul_trafico       = "'".date('Y-m-d H:i')."'";
   $desc_anul_trafico  = $this -> requestDataForQuery('desc_anul_trafico','text');
   $anul_usuario_id          = $usuario_id;

   
  
   $update = "UPDATE trafico SET estado= 'A',
       causal_anulacion_id = $causal_anulacion_id,
     anul_trafico=$anul_trafico,
     desc_anul_trafico =$desc_anul_trafico,
     anul_usuario_id=$anul_usuario_id
      WHERE trafico_id=$trafico_id";
     
      $this -> query($update,$Conex,true);    
 
   if(strlen($this -> GetError()) > 0){
    $this -> Rollback($Conex,true);
   }else{  
       $this -> Commit($Conex,true);   
   }  
  }

  public function getCausalesAnulacion($Conex){
		
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;		
  }

  public function selectEstadoEncabezadoRegistro($trafico_id,$Conex){
	  
    $select = "SELECT estado FROM trafico  WHERE trafico_id = $trafico_id";	  
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$estado = $result[0]['estado'];
	
	return $estado;	  
	  
  }
  
  

  public function getEstado($Conex){
  
	$trafico_id = $_REQUEST['trafico_id'];
	
	$select = "SELECT estado,  	fecha_inicial_salida,  	hora_inicial_salida 
				FROM trafico
				WHERE trafico_id=$trafico_id ";
			
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$estado = $result[0]['estado'];
	$hora   =  explode(':',$result[0]['hora_inicial_salida']);
	$fecha  = explode($result[0]['fecha_inicial_salida']);
	
	/*if($estado=='R' && $result[0]['hora_inicial_salida']!='' && $result[0]['fecha_inicial_salida']!=''){
		
		$actual=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
		$salida=mktime($hora[0],$hora[1],00,$fecha[1],$fecha[2],$fecha[0]);
		$estado_nuevo=$salida>$actual ? 'R' : 'T';
		
		if($estado_nuevo=='T'){
			$update="UPDATE trafico SET estado='$estado_nuevo' WHERE trafico_id=$trafico_id";
			$this -> DbFetchAll($update,$Conex,true);

			$select = "SELECT estado,  	fecha_inicial_salida,  	hora_inicial_salida 
						FROM trafico
						WHERE trafico_id=$trafico_id ";
					
			$result = $this -> DbFetchAll($select,$Conex,true); 
			$estado = $result[0]['estado'];

		}
	}*/
	
	
	if($estado=='T'){

		$select  = "SELECT  ns.finaliza_recorrido FROM detalle_seguimiento ds, novedad_seguimiento ns 
		WHERE ds.trafico_id=$trafico_id AND ds.borrado=0 AND  ns.novedad_id=ds.novedad_id AND ns.finaliza_recorrido=1 ORDER BY ds.orden_det_ruta DESC LIMIT 0,1";
		$result = $this -> DbFetchAll($select,$Conex,true);
	
		/*$select_tip  = "SELECT despachos_urbanos_id,manifiesto_id, seguimiento_id,reexpedido_id
		FROM trafico WHERE trafico_id=$trafico_id";
		$result_tip  = $this -> DbFetchAll($select_tip ,$Conex,true);
		
		if($result_tip[0]['despachos_urbanos_id']>0){
			$despachos_urbanos_id=$result_tip[0]['despachos_urbanos_id'];
			$select  = "
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM detalle_despacho d, remesa r WHERE d.despachos_urbanos_id = $despachos_urbanos_id AND r.remesa_id=d.remesa_id AND r.estado!='AN')
			UNION
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$despachos_urbanos_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' ) ORDER BY value ASC ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
		}elseif($result_tip[0]['manifiesto_id']>0){

			$manifiesto_id=$result_tip[0]['manifiesto_id'];
			$select  = "
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM detalle_despacho d, remesa r WHERE d.manifiesto_id = $manifiesto_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
			UNION
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$manifiesto_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' ) ORDER BY value ASC  ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
		}elseif($result_tip[0]['reexpedido_id']>0){

			$reexpedido_id=$result_tip[0]['reexpedido_id'];
			$select  = "
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM detalle_despacho d, remesa r WHERE d.reexpedido_id = $reexpedido_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
			UNION
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.reexpedido_id=".$reexpedido_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' ) ORDER BY value ASC  ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
		}*/
		
		if($result[0][finaliza_recorrido]==1){
			$update = "UPDATE trafico SET estado='F' WHERE trafico_id=$trafico_id";
			$this -> query($update,$Conex,true);
		}

		$select = "SELECT estado 
					FROM trafico
					WHERE trafico_id=$trafico_id ";
				
		$result = $this -> DbFetchAll($select,$Conex,true); 
		$estado = $result[0]['estado'];
	
	}
	
	return $estado;	  
	  
  }
  
   public function getRemesas($Conex){
  
	$trafico_id = $_REQUEST['trafico_id'];
	$detalle_seg_id = $_REQUEST['detalle_seg_id'];
	
	$select = "SELECT IF(t.seguimiento_id>0,0,IF(t.despachos_urbanos_id>0,(SELECT COUNT(*) AS movi FROM detalle_despacho WHERE despachos_urbanos_id=t.despachos_urbanos_id),(SELECT COUNT(*) AS movi FROM detalle_despacho WHERE manifiesto_id=t.manifiesto_id))) AS num_remesas
				FROM trafico t, detalle_seguimiento ds, novedad_seguimiento ns
				WHERE t.trafico_id=$trafico_id AND ds.trafico_id=t.trafico_id AND ds.detalle_seg_id=$detalle_seg_id AND ns.novedad_id=ds.novedad_id AND ns.requiere_remesa=1 ";
			
	$result = $this -> DbFetchAll($select,$Conex,true);

	$num_remesas = $result[0]['num_remesas'];
	return $num_remesas;	

   }

  public function getPuntos($Conex){
  
	$trafico_id = $this -> requestData('trafico_id');
	
	$select = "SELECT COUNT(*) AS puntos 
				FROM detalle_seguimiento 
				WHERE trafico_id=$trafico_id AND punto_referencia_id >0 AND borrado=0 ";
			
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$puntos = $result[0]['puntos'];
	
	return $puntos;	  
	  
  }

  public function getComprobarPuntos($Conex){
  
	$ruta_id = $_REQUEST['ruta_id'];
	
	$select = "SELECT COUNT(*) AS puntos 
				FROM detalle_ruta d, punto_referencia p 
				WHERE d.ruta_id=$ruta_id AND p.punto_referencia_id=d.punto_referencia_id AND p.tipo_punto!=3 AND d.borrado=0 ";
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$puntos = $result[0]['puntos'];
	
	return $puntos;	  
	  
  }

//LISTA MENU
  public function GetEstadoSeg($Conex){
	$opciones = array ( 0 => array ( 'value' => 'P', 'text' => 'PENDIENTE RUTA' ), 1 => array ( 'value' => 'R', 'text' => 'CON RUTA' ), 2 => array ( 'value' => 'T', 'text' => 'TRANSITO' ), 3 => array ( 'value' => 'F', 'text' => 'FINALIZADO' ), 4 => array ( 'value' => 'N', 'text' => 'APROBAR NOCTURNO' ), 5 => array ( 'value' => 'A', 'text' => 'ANULADO' ) );
	return  $opciones;
  }
  
  public function GetNocturno($Conex){
	$opciones = array ( 0 => array ( 'value' => '0', 'text' => 'NO' ), 1 => array ( 'value' => '1', 'text' => 'SI' ) );
	return  $opciones;
  }
  
 /*
				IF(t.seguimiento_id>0,(SELECT cliente FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),
				IF(t.despachos_urbanos_id>0,IF((SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC )IS NULL,  (SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',oc.cliente,'Orden de cargue ', oc.consecutivo)) AS clients
FROM orden_cargue oc, detalle_despacho dd
WHERE oc.orden_cargue_id = dd.orden_cargue_id
AND dd.despachos_urbanos_id =t.despachos_urbanos_id ),(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC )),
																		   
																		  IF(t.manifiesto_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC),(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.reexpedido_id=t.reexpedido_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC)))) AS clientes,*/

//BUSQUEDA
  public function selectRegistroNovedades($trafico_id,$Conex){
    
   $select = "SELECT 
   				t.trafico_id,
				
				
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,
				
				
				IF(t.seguimiento_id>0,(SELECT o.nombre FROM seguimiento s, oficina o WHERE s.seguimiento_id=t.seguimiento_id AND o.oficina_id=s.oficina_id),
				IF(t.despachos_urbanos_id>0,(SELECT o.nombre FROM  despachos_urbanos s, oficina o WHERE s.despachos_urbanos_id=t.despachos_urbanos_id AND o.oficina_id=s.oficina_id),
				IF(t.manifiesto_id>0,(SELECT o.nombre FROM manifiesto s, oficina o WHERE s.manifiesto_id=t.manifiesto_id AND o.oficina_id=s.oficina_id),
						
	(SELECT o.nombre FROM oficina o WHERE  o.oficina_id=(SELECT r.oficina_id FROM reexpedido r WHERE r.reexpedido_id = t.reexpedido_id))
									  
									  ))) AS agencia,
				
				
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT placa FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),(SELECT placa FROM orden_cargue WHERE orden_cargue_id=t.orden_cargue_id)))) AS placa,
				
				IF(t.seguimiento_id>0,(SELECT observaciones FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT observaciones FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				IF(t.manifiesto_id>0,(SELECT observaciones FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),(SELECT observaciones FROM orden_cargue WHERE orden_cargue_id=t.orden_cargue_id)))) AS clientes,
				
				IF(t.seguimiento_id>0,(SELECT marca FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT marca FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				IF(t.manifiesto_id>0,(SELECT marca FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),(SELECT marca FROM orden_cargue WHERE orden_cargue_id=t.orden_cargue_id)))) AS marca,
				
				IF(t.seguimiento_id>0,(SELECT categoria_licencia_conductor FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT categoria_licencia_conductor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				IF(t.manifiesto_id>0,(SELECT categoria_licencia_conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),(SELECT categoria_licencia_conductor  FROM orden_cargue WHERE orden_cargue_id=t.orden_cargue_id)))) AS categoria,
				
				IF(t.seguimiento_id>0,(SELECT v.link_monitoreo_satelital FROM seguimiento s, vehiculo v WHERE s.seguimiento_id=t.seguimiento_id AND v.placa_id=s.placa_id ),
				IF(t.despachos_urbanos_id>0,(SELECT v.link_monitoreo_satelital FROM  despachos_urbanos d, vehiculo v WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND v.placa_id=d.placa_id),
				(SELECT v.link_monitoreo_satelital FROM manifiesto m, vehiculo v  WHERE m.manifiesto_id=t.manifiesto_id   AND v.placa_id=m.placa_id ))) AS link_gps,
				IF(t.seguimiento_id>0,(SELECT v.usuario FROM seguimiento s, vehiculo v WHERE s.seguimiento_id=t.seguimiento_id AND v.placa_id=s.placa_id ),
				IF(t.despachos_urbanos_id>0,(SELECT v.usuario FROM  despachos_urbanos d, vehiculo v WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND v.placa_id=d.placa_id),
				(SELECT v.usuario FROM manifiesto m, vehiculo v  WHERE m.manifiesto_id=t.manifiesto_id   AND v.placa_id=m.placa_id ))) AS usuario_gps,
				IF(t.seguimiento_id>0,(SELECT v.password FROM seguimiento s, vehiculo v WHERE s.seguimiento_id=t.seguimiento_id AND v.placa_id=s.placa_id ),
				IF(t.despachos_urbanos_id>0,(SELECT v.password FROM  despachos_urbanos d, vehiculo v WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND v.placa_id=d.placa_id),
				(SELECT v.password FROM manifiesto m, vehiculo v  WHERE m.manifiesto_id=t.manifiesto_id   AND v.placa_id=m.placa_id ))) AS clave_gps,
				IF(t.seguimiento_id>0,(SELECT categoria_licencia_conductor FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT categoria_licencia_conductor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT categoria_licencia_conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS categoria,
				IF(t.seguimiento_id>0,(SELECT color FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT color FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				(SELECT color FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS color,
				
				IF(t.seguimiento_id>0,(SELECT nombre FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT nombre FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
				IF(t.manifiesto_id>0,(SELECT nombre FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),
									  
				(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS nom FROM tercero WHERE tercero_id=(SELECT tercero_id FROM proveedor WHERE proveedor_id=(SELECT proveedor_id FROM reexpedido WHERE reexpedido_id=t.reexpedido_id)))))) AS conduct,
				
				IF(t.seguimiento_id>0,(SELECT movil_conductor FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT te.movil FROM  despachos_urbanos d, conductor c, tercero te WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND c.conductor_id=d.conductor_id AND te.tercero_id=c.tercero_id),
				
				IF(t.manifiesto_id>0,(SELECT te.movil FROM manifiesto m, conductor c, tercero te  WHERE m.manifiesto_id=t.manifiesto_id AND c.conductor_id=m.conductor_id AND te.tercero_id=c.tercero_id),
				
				(SELECT CONCAT_WS(' - ',telefono,movil) AS num FROM tercero WHERE tercero_id=(SELECT tercero_id FROM proveedor WHERE proveedor_id=(SELECT proveedor_id FROM reexpedido WHERE reexpedido_id=t.reexpedido_id)))))) AS celular,
				
				IF(t.seguimiento_id>0,(SELECT fecha FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT fecha_du FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
											 
				IF(t.manifiesto_id>0,(SELECT fecha_mc FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),(SELECT fecha_rxp FROM reexpedido WHERE reexpedido_id=t.reexpedido_id )))) AS fecha,
				
				IF(t.seguimiento_id>0,(SELECT CONCAT('ST No ',seguimiento_id) AS numero FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT CONCAT('DU No ',despacho) AS numero FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				IF(t.manifiesto_id>0,(SELECT CONCAT('MC No ',manifiesto) AS numero  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),
				(SELECT CONCAT('RX No ',reexpedido) AS numero  FROM reexpedido WHERE reexpedido_id=t.reexpedido_id )))) AS numero,
				
				
				t.estado AS estado,
				t.estado AS estadohidden,
				t.ruta_id AS rutahidden,
				t.t_nocturno,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,
				t.escolta_recibe,
				t.escolta_entrega,
				t.nota_controlador,
				t.frecuencia,

				IF(t.manifiesto_id>0,(SELECT aprobacion_ministerio2 FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),'N/A') AS aprobacion_min,
				IF(t.manifiesto_id>0,(SELECT fecha_ultimo_reporte2 FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ),'N/A') AS fecha_aprob_min

   				FROM  trafico t
				WHERE t.trafico_id=$trafico_id";	
				
				
				
	$result = $this -> DbFetchAll($select,$Conex,true);
		
	return $result;
	
  }
  
  
   
}
?>