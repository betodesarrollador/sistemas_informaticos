<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
require_once("../../../framework/clases/MailClass.php");

final class DetalleSeguimientoModel extends Db{

  private $Permisos;
  
  public function getDetallesSeguimiento($Conex){
  
    $trafico_id = $_REQUEST['trafico_id'];
	
	if(is_numeric($trafico_id)){
	
	 /* $select  = "SELECT d.*,(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_seguimiento_remesa ds, remesa r WHERE 
	  ds.detalle_seg_id=d.detalle_seg_id AND r.remesa_id=ds.remesa_id AND ds.borrado=0 ) AS remesas 
	  FROM detalle_seguimiento d WHERE trafico_id = $trafico_id ORDER BY d.fecha_reporte ASC,d.hora_reporte ASC, d.orden_det_ruta ASC";
	  
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  */
	  
	  $select  = "SELECT d.*,
	  (SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_seguimiento_remesa ds, remesa r WHERE ds.detalle_seg_id=d.detalle_seg_id AND r.remesa_id=ds.remesa_id AND ds.borrado=0 ) AS remesas,
	  (SELECT ds.remesa_id FROM detalle_seguimiento_remesa ds WHERE   ds.detalle_seg_id=d.detalle_seg_id AND ds.borrado=0 LIMIT 1 ) AS remesa_id,
	  (SELECT ds.causal_devolucion_paqueteo_id FROM detalle_seguimiento_remesa ds WHERE   ds.detalle_seg_id=d.detalle_seg_id AND ds.borrado=0 ORDER BY detalle_seg_rem_id DESC LIMIT 1 ) AS causal_devolucion_paqueteo_id, 	  	  
	  (SELECT estado FROM trafico WHERE trafico_id=$trafico_id) AS estado_trafico
	  FROM detalle_seguimiento d WHERE trafico_id = $trafico_id AND d.borrado=0 AND d.fecha_hora_registro IS NOT NULL ORDER BY   d.fecha_hora_registro  ASC ";
	  
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  if(count($result)==0) $result=array();

	  $select1  = "SELECT d.*,(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_seguimiento_remesa ds, remesa r WHERE 
	  ds.detalle_seg_id=d.detalle_seg_id AND r.remesa_id=ds.remesa_id AND ds.borrado=0 ) AS remesas, 
	
	  (SELECT ds.remesa_id FROM detalle_seguimiento_remesa ds WHERE   ds.detalle_seg_id=d.detalle_seg_id AND ds.borrado=0 LIMIT 1 ) AS remesa_id, 	  
	  (SELECT ds.causal_devolucion_paqueteo_id FROM detalle_seguimiento_remesa ds WHERE   ds.detalle_seg_id=d.detalle_seg_id AND ds.borrado=0  ORDER BY detalle_seg_rem_id DESC LIMIT 1 ) AS causal_devolucion_paqueteo_id, 	  	  
	  (SELECT estado FROM trafico WHERE trafico_id=$trafico_id) AS estado_trafico
	  FROM detalle_seguimiento d 
	  WHERE trafico_id = $trafico_id AND  d.fecha_hora_registro IS NULL AND d.orden_det_ruta IS NOT NULL 
	  AND d.detalle_ruta_id NOT IN 
	    (SELECT detalle_ruta_id FROM detalle_seguimiento WHERE detalle_ruta_id BETWEEN (SELECT MIN(detalle_ruta_id) FROM detalle_seguimiento WHERE trafico_id = $trafico_id AND fecha_hora_registro IS NOT   NULL) 
	  AND (SELECT MAX(detalle_ruta_id) FROM detalle_seguimiento WHERE trafico_id = $trafico_id AND fecha_hora_registro IS NOT  NULL))
	 AND d.borrado=0
	 AND d.detalle_ruta_id NOT IN 
	    (SELECT detalle_ruta_id FROM detalle_seguimiento WHERE detalle_ruta_id < (SELECT MIN(detalle_ruta_id) FROM detalle_seguimiento WHERE trafico_id = $trafico_id AND fecha_hora_registro IS NOT   NULL))		
	  ORDER BY   d.orden_det_ruta  ASC ";
	  $result1 =array();
	  $result1 = $this -> DbFetchAll($select1,$Conex,true);
	  if(count($result1)>0){
		  $result=array_merge($result,$result1);
	  }

	  
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
  
  public function getFechaHoraSalida($Conex){
  
    $trafico_id = $_REQUEST['trafico_id'];
	
	if(is_numeric($trafico_id)){
	
	  $select  = "SELECT fecha_inicial_salida,hora_inicial_salida
	  FROM trafico
	  WHERE trafico_id = $trafico_id";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  }
  public function getNovedad($Conex){
  
	
	  $select  = "SELECT novedad_id AS value, novedad AS text
	  FROM novedad_seguimiento WHERE  	estado_novedad=1 order by novedad asc";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	
	  return $result;
  }

	public function comprobar_fecha_hora($det_seg_id,$Conex){
	
		$select="SELECT fecha_reporte, hora_reporte FROM detalle_seguimiento WHERE detalle_seg_id=$det_seg_id";
		$result = $this -> DbFetchAll($select,$Conex,true);
			//echo $select;
	  return $result;
	}

   public function finalizo_remesas($trafico_id,$Conex){
	   
	   $respuesta = "";
	   $select_tip  = "SELECT despachos_urbanos_id,manifiesto_id, seguimiento_id,reexpedido_id
		FROM trafico WHERE trafico_id=$trafico_id";
		$result_tip  = $this -> DbFetchAll($select_tip ,$Conex,true);
		
		if($result_tip[0]['despachos_urbanos_id']>0){
			$despachos_urbanos_id=$result_tip[0]['despachos_urbanos_id'];
			$select  = "
			(SELECT r.remesa_id 
			FROM detalle_despacho d, remesa r WHERE d.despachos_urbanos_id = $despachos_urbanos_id AND r.remesa_id=d.remesa_id AND r.estado!='AN')
			UNION
			(SELECT r.remesa_id 
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$despachos_urbanos_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' ) ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
		}elseif($result_tip[0]['manifiesto_id']>0){

			$manifiesto_id=$result_tip[0]['manifiesto_id'];
			$select  = "
			(SELECT r.remesa_id 
			FROM detalle_despacho d, remesa r WHERE d.manifiesto_id = $manifiesto_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
			UNION
			(SELECT r.remesa_id
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$manifiesto_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )  ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
		}elseif($result_tip[0]['reexpedido_id']>0){

			$reexpedido_id=$result_tip[0]['reexpedido_id'];
			$select  = "
			(SELECT r.remesa_id 
			FROM detalle_despacho d, remesa r WHERE d.reexpedido_id = $reexpedido_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
			UNION
			(SELECT r.remesa_id  
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.reexpedido_id=".$reexpedido_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' ) ORDER BY value ASC  ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			
		}
   			
		for ($i=0;$i<count($result);$i++){
			
			$select_finalizadas = "SELECT dsr.detalle_seg_rem_id FROM detalle_seguimiento_remesa dsr,novedad_seguimiento ns WHERE dsr.remesa_id=".$result[$i]['remesa_id']." AND dsr.novedad_id=ns.novedad_id AND ns.finaliza_remesa=1";
			$result_finalizadas = $this -> DbFetchAll($select_finalizadas,$Conex,true);
			
			if(!count($result_finalizadas)>0){
				
				return false;
			}else{
				$respuesta = "true";
			}
			
		}
		
		if($respuesta == "true"){
			return true;
		}
   		
   
   }

  public function Gettipo_novedad($novedad_id,$Conex){
  
	
	  $select  = "SELECT requiere_remesa,finaliza_remesa,devolucion
	  FROM novedad_seguimiento WHERE  	novedad_id=$novedad_id ";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	
	  return $result;
  }

	public function getCausal($Conex){

		$select  = "SELECT causal_devolucion_paqueteo_id AS value,  nombre_causal AS text
		FROM causal_devolucion_paqueteo";
		$result = $this -> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function getCausal_Finaliza($Conex){

		$select  = "SELECT causal_devolucion_paqueteo_id AS value,  nombre_causal AS text
		FROM causal_devolucion_paqueteo WHERE finaliza_entrega=1";
		$result = $this -> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function getCausal_NoFinaliza($Conex){

		$select  = "SELECT causal_devolucion_paqueteo_id AS value,  nombre_causal AS text
		FROM causal_devolucion_paqueteo WHERE finaliza_entrega=0 ";
		$result = $this -> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function getRemesas($trafico_id,$Conex){

		$select  = "SELECT despachos_urbanos_id,manifiesto_id, seguimiento_id,reexpedido_id
		FROM trafico WHERE trafico_id=$trafico_id";
		$result = $this -> DbFetchAll($select,$Conex,true);

		if($result[0]['despachos_urbanos_id']>0){
			$despachos_urbanos_id=$result[0]['despachos_urbanos_id'];
			$select  = "
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM detalle_despacho d, remesa r WHERE d.despachos_urbanos_id = $despachos_urbanos_id AND r.remesa_id=d.remesa_id AND r.estado!='AN')
			UNION ALL
			(SELECT r.remesa_id AS value, 
			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.sigla,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$despachos_urbanos_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )
			UNION ALL
			(SELECT oc.orden_cargue_id AS value,
			 (SELECT CONCAT_WS( ' ', 'Orden de cargue: ',oc.consecutivo,' Cliente: ',oc.cliente)) as text
			 FROM orden_cargue oc WHERE oc.orden_cargue_id IN (SELECT dd.orden_cargue_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=$despachos_urbanos_id)
			 )
			
			
			ORDER BY value ASC ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			return $result;
			
		}elseif($result[0]['manifiesto_id']>0){

			$manifiesto_id=$result[0]['manifiesto_id'];
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
			return $result;

		}elseif($result[0]['reexpedido_id']>0){

			$reexpedido_id=$result[0]['reexpedido_id'];
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
			return $result;

		}else{
			return array();
		}
	}

	


  public function Save($Campos,$usuario_id,$usuarioNombres,$Conex){
	 // echo "save";
	$consul_remesa="";
    $trafico_id      	 = $this -> requestDataForQuery('trafico_id','integer');
    $detalle_seg_id      = $this -> requestDataForQuery('detalle_seg_id','integer');
	$orden_det_ruta       = $this -> requestDataForQuery('orden_det_ruta','integer');
    $novedad_id       	 = $this -> requestDataForQuery('novedad_id','integer');
	$ubicacion_id        = $this -> requestDataForQuery('ubicacion_id','integer');
	$punto_referencia 	 = $this -> requestDataForQuery('punto_referencia','text');
	$tipo_punto      	 = $this -> requestDataForQuery('tipo_punto','text');	
	$punto_referencia_id = $this -> requestDataForQuery('punto_referencia_id','integer');
    //$fecha_reporte       = $this -> requestDataForQuery('fecha_reporte','date');
    //$hora_reporte        = $this -> requestDataForQuery('hora_reporte','time');
	
	$remesa_id = $this -> requestDataForQuery('remesa_id','integer');
	$causal_devolucion_paqueteo_id = $this -> requestDataForQuery('causal_devolucion_id','integer');
	
    $fecha_reporte       = "'".$this -> getFechaDb($Conex)."'";
    $hora_reporte        = "'".$this -> getHoraDb($Conex)."'";
	$fecha_hora_suceso	= "'".$this -> getFechaDb($Conex)." ".$this -> getHoraDb($Conex)."'";


    $obser_deta       	 = $this -> requestDataForQuery('obser_deta','text');
    $recorrido_acumulado = 0;
	$fecha_hora_registro = $this -> getFechaHoraDb($Conex);
	
			
	$select  = "SELECT TIMEDIFF(CONCAT_WS(' ',$fecha_reporte,$hora_reporte),
			CONCAT_WS(' ',t.fecha_inicial_salida, t.hora_inicial_salida)) AS diferencia													
	FROM trafico t WHERE t.trafico_id=$trafico_id";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
    $tiempo_tramo     	 = $result[0][diferencia];

	
    $detalle_seg_id = $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true,1);	


	$select  = "SELECT n.reporte_interno, n.reporte_cliente, n.novedad, a.alerta_panico,n.requiere_remesa,n.finaliza_remesa,
	(SELECT nombre_causal FROM causal_devolucion_paqueteo WHERE causal_devolucion_paqueteo_id=$causal_devolucion_paqueteo_id) AS nombre_causal
	FROM novedad_seguimiento n, alerta_panico a WHERE n.novedad_id=$novedad_id AND a.alerta_id=n.alerta_id ";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	$compl_causal= "";
	if($causal_devolucion_paqueteo_id>0){
		$compl_causal= "Causal: ".$result[0]['nombre_causal'].'<br>';
	}


	if($result[0]['requiere_remesa']==1 && (!$remesa_id>0 ||  $remesa_id=='NULL')) exit('Esta novedad Requiere que seleccione una Remesa');
	if($result[0]['requiere_remesa']==1 && $result[0]['finaliza_remesa']==1 && (!$causal_devolucion_paqueteo_id>0 || $causal_devolucion_paqueteo_id=='NULL')) exit('Esta novedad Requiere que seleccione una Causal');

    //valida si no esta finalizado en otro detalle seguimiento
	if($result[0]['requiere_remesa']==1 ){
		$select_com  = "SELECT dsr.remesa_id
		FROM detalle_seguimiento_remesa dsr, novedad_seguimiento ns 
			   WHERE dsr.remesa_id=$remesa_id AND  dsr.borrado=0  AND ns.novedad_id=dsr.novedad_id AND ns.finaliza_remesa=1 ";
		$result_com = $this -> DbFetchAll($select_com,$Conex,true);
		
		if($result_com[0]['remesa_id']>0) exit('Esta Remesa ya fue finalizada Anteriormente');
		
	}
    //fin valida si no esta finalizado en otro detalle seguimiento
	
    $insert = "INSERT INTO detalle_seguimiento 
					(detalle_seg_id,trafico_id,ubicacion_id,punto_referencia,tipo_punto,punto_referencia_id,orden_det_ruta,novedad_id,fecha_reporte,hora_reporte,obser_deta,tiempo_tramo,
					recorrido_acumulado,fecha_hora_registro,usuario_id,usuario) 
	           VALUES 
			   		($detalle_seg_id,$trafico_id,$ubicacion_id,$punto_referencia,$tipo_punto,$punto_referencia_id,$orden_det_ruta,$novedad_id,$fecha_reporte,$hora_reporte,$obser_deta,'$tiempo_tramo',
			   		$recorrido_acumulado,'$fecha_hora_registro',$usuario_id,'$usuarioNombres')";

	$this -> query($insert,$Conex,true);
	
	//ingresa un detalle en seguimiento de remesa si requiere la novedad
	if($result[0]['requiere_remesa']==1 ){
		$detalle_seg_rem_id = $this -> DbgetMaxConsecutive("detalle_seguimiento_remesa","detalle_seg_rem_id",$Conex,true,1);
		$insert1 = "INSERT INTO detalle_seguimiento_remesa 
						(detalle_seg_rem_id,detalle_seg_id,remesa_id,usuario_id,fecha_hora_registro,fecha_hora_suceso,obser_deta,novedad_id,causal_devolucion_paqueteo_id) 
				   VALUES 
						($detalle_seg_rem_id,$detalle_seg_id,$remesa_id,$usuario_id,'$fecha_hora_registro',$fecha_hora_suceso,$obser_deta,$novedad_id,$causal_devolucion_paqueteo_id)";
	
		$this -> query($insert1,$Conex,true);

		if ($novedad_id>0) {
			$update = "UPDATE remesa SET
						novedad_id=$novedad_id
						WHERE remesa_id = $remesa_id";
			$this -> query($update,$Conex,true);
		} 
		
		if($causal_devolucion_paqueteo_id>0){
			$update = "UPDATE remesa SET
						causal_devolucion_paqueteo_id=$causal_devolucion_paqueteo_id
						WHERE remesa_id = $remesa_id";
			$this -> query($update,$Conex,true);
		}

	}
	//fin ingresa un detalle en seguimiento de remesa si requiere la novedad
	
	if($result[0][reporte_interno]==1 || $result[0][reporte_cliente]==1){

	  $select_tra  = "SELECT 				
			IF(t.seguimiento_id>0,(SELECT CONCAT('Seguimiento a Terceros ',seguimiento_id) AS numero FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
			IF(t.despachos_urbanos_id>0,(SELECT CONCAT('Despacho Urbano ',despacho) AS numero FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
			IF (t.manifiesto_id>0,(SELECT CONCAT('Manifiesto de Carga ',manifiesto) AS numero  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ), (SELECT CONCAT('Envio  ',reexpedido) AS numero  FROM reexpedido WHERE reexpedido_id=t.reexpedido_id ) )
			
			)) AS numero,

			IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
			IF(t.despachos_urbanos_id>0,(SELECT placa FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
			IF (t.manifiesto_id>0,(SELECT placa  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ), (SELECT 'N/A')))) AS placa,

			IF(t.seguimiento_id>0,(SELECT nombre FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
			IF(t.despachos_urbanos_id>0,(SELECT nombre FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
			IF (t.manifiesto_id>0,(SELECT nombre  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ), (SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS nom FROM tercero WHERE tercero_id=(SELECT tercero_id FROM proveedor WHERE proveedor_id=(SELECT proveedor_id FROM reexpedido WHERE reexpedido_id=t.reexpedido_id))))
								   
								   )) AS nombre,

			IF(t.seguimiento_id>0,'N/A',
			IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_despacho dd, remesa r WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND r.estado!='AN'),
			IF (t.manifiesto_id>0,(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id AND r.estado!='AN'),(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_despacho dd, remesa r WHERE dd.reexpedido_id=t.reexpedido_id AND r.remesa_id=dd.remesa_id AND r.estado!='AN') ) )) AS remesas,

			IF(t.seguimiento_id>0,'N/A',
			IF(t.despachos_urbanos_id>0,(SELECT numero_contenedor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
			IF (t.manifiesto_id>0,(SELECT numero_contenedor  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ), (SELECT 'N/A')))) AS  numero_contenedor,

			IF(t.seguimiento_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) FROM  seguimiento s WHERE s.seguimiento_id=t.seguimiento_id ),
			IF(t.despachos_urbanos_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) FROM  despachos_urbanos d WHERE d.despachos_urbanos_id=t.despachos_urbanos_id ),
			IF (t.manifiesto_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=m.origen_id)  FROM manifiesto m WHERE m.manifiesto_id=t.manifiesto_id ), (SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=m.origen_id)  FROM reexpedido m WHERE m.reexpedido_id=t.reexpedido_id )))) AS  origen,

			IF(t.seguimiento_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) FROM  seguimiento s WHERE s.seguimiento_id=t.seguimiento_id ),
			IF(t.despachos_urbanos_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) FROM  despachos_urbanos d WHERE d.despachos_urbanos_id=t.despachos_urbanos_id ),
			IF (t.manifiesto_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=m.destino_id)  FROM manifiesto m WHERE m.manifiesto_id=t.manifiesto_id ), (SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=m.destino_id)  FROM reexpedido m WHERE m.reexpedido_id=t.reexpedido_id )  ))) AS  destino,

			IF(t.seguimiento_id>0,(SELECT cliente FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),
			IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC ),
			IF (t.manifiesto_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa, '- Producto',r.descripcion_producto)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC),
			(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.reexpedido_id=t.reexpedido_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC))
			)) AS clientes

	  FROM trafico t WHERE t.trafico_id=$trafico_id ";
	  $result_tra = $this -> DbFetchAll($select_tra,$Conex,true);
	//echo $select_tra;
	  if($result[0]['requiere_remesa']==1 && $remesa_id>0){
			$consul_remesa = "AND r.remesa_id=$remesa_id";
			$select_rem  = "SELECT r.remesa_id, r.numero_remesa, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
				r.remitente, r.destinatario,r.direccion_remitente,r.direccion_destinatario
			
			FROM remesa r   WHERE r.remesa_id=$remesa_id";
			$result_rem = $this -> DbFetchAll($select_rem,$Conex,true);
						//MENSAJE1
			$mail_subject='Novedad Remesa '.$result_rem[0]['prefijo_tipo'].$result_rem[0]['prefijo_oficina'].$result_rem[0]['numero_remesa'];
			$mensaje='';
			$mensaje.='Origen: '.$result_rem[0]['origen'].'. Destino:'.$result_rem[0]['destino'].'<br>';	  
			$mensaje.='Remitente: '.$result_rem[0]['remitente'].'. Destinatario:'.$result_rem[0]['destinatario'].'<br>';	  			
			$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
			$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
			$mensaje.='Remesa: '.$result_rem[0]['prefijo_tipo'].''.$result_rem[0]['prefijo_oficina'].'-'.$result_rem[0]['numero_remesa'].' Producto: '.$result_rem[0]['descripcion_producto'].'<br>';
			$mensaje.='Cliente: '.$result_tra[0]['cliente'].'<br>';	  
			$mensaje.='Remision Cliente: '.$result_rem[0]['orden_despacho'].'<br>';	 
			$mensaje.='Fecha remesa: '.$result_rem[0]['fecha_remesa'].'<br>';	
			$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
			$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
			$mensaje.='Lugar: '.$punto_referencia.'<br>';	
			$mensaje.=$compl_causal;			
			$mensaje.=$result_tra[0][numero].'<br>';		
			$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
			$mensaje.='Hora: '.$hora_reporte.'<br>';	
			$mensaje.='Observacion: '.$obser_deta.'<br>';	
			
			$mensaje.='1';	
			
	  }else{
		  
		  //Mensaje 2
		  $mail_subject='Novedad '.$result_tra[0][numero];
		  $mensaje='';
		  $mensaje.='Origen: '.$result_tra[0][origen].'. Destino:'.$result_tra[0][destino].'<br>';	  
		  $mensaje.='Placa: '.$result_tra[0][placa].'<br>';
		  $mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
		  $mensaje.='Remesas: '.$result_tra[0][remesas].'<br>';
		  $mensaje.='Clientes-Remesas: '.$result_tra[0][clientes].'<br>';	  
		  $mensaje.='Contenedor: '.$result_tra[0][numero_contenedor].'<br>';
		  
		
		  $mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
		  $mensaje.='Novedad: '.$result[0][novedad].'<br>';	
		  $mensaje.='Lugar: '.$punto_referencia.'<br>';	
		  $mensaje.=$result_tra[0][numero].'<br>';		
		  $mensaje.='Fecha: '.$fecha_reporte.'<br>';		
		  $mensaje.='Hora: '.$hora_reporte.'<br>';	
		  $mensaje.='Observacion: '.$obser_deta.'<br>';	
		  
		  $mensaje.='2';
		  
		  
	  }
	  if($result[0][reporte_cliente]==1){
		  if($result_tra[0][seguimiento_id]>0){
			  $select_cliente  = "SELECT 
			  IF(t.seguimiento_id>0,
				(SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM seguimiento s,  cliente_factura_operativa cf WHERE s.seguimiento_id=t.seguimiento_id AND cf.cliente_id=s.cliente_id),
				IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM detalle_despacho d, remesa r, cliente_factura_operativa cf WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=d.remesa_id AND cf.cliente_id=r.cliente_id AND r.remesa_id NOT IN (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1 )  ),
				
				IF(t.manifiesto_id,(SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM detalle_despacho d, remesa r, cliente_factura_operativa cf WHERE d.manifiesto_id=t.manifiesto_id AND r.remesa_id=d.remesa_id AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)),
																																																																							  (SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM detalle_despacho d, remesa r, cliente_factura_operativa cf WHERE  r.remesa_id=d.remesa_id AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1))))) AS	  correo
	
			  FROM trafico t  WHERE t.trafico_id=$trafico_id ";
			  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
			  
			  $correos_cliente=explode(',',$result_cliente[0][correo]);
				  
			  foreach($correos_cliente as $item_cliente){
				  
				  
					//Mensaje 3
					$mensaje='';
					$mensaje.='Origen: '.$result_tra[0][origen].'. Destino:'.$result_tra[0][destino].'<br>';	  
					$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
					$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
					
					
					$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
					$mensaje.='Novedad: '.$result[0][novedad].'<br>';		
					$mensaje.=$result_tra[0][numero].'<br>';		
					$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
					$mensaje.='Hora: '.$hora_reporte.'<br>';	
					$mensaje.='Observacion: '.$obser_deta.'<br>';	
					
					$mensaje.='3';
					$enviar_mail=new Mail();				  
					$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
		
			  }
		  }elseif($result_tra[0][despachos_urbanos_id]>0){
			  $select_cliente  = "SELECT 
				LOWER(cf.correo_cliente_factura_operativa) AS  correo,
				r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
				r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
				
	
			  FROM  detalle_despacho dd, remesa r, cliente_factura_operativa cf  
			  WHERE dd.despachos_urbanos_id=".$result_tra[0][despachos_urbanos_id]." AND  r.remesa_id=dd.remesa_id AND r.estado!='AN' $consul_remesa
			  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
			  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
			   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
			  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
			  
				  
			  for($i=0; $i<count($result_cliente);$i++){
				  
				  
					$item_cliente=$result_cliente[$i][correo];
					//MEnsaje 4
					$mensaje='';
					$mensaje.='Origen: '.$result_cliente[$i][origen].'. Destino:'.$result_cliente[$i][destino].'<br>';	
					$mensaje.='Remitente: '.$result_cliente[$i]['remitente'].'. Destinatario:'.$result_cliente[$i]['destinatario'].'<br>';						
					$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
					$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
					$mensaje.='Cliente: '.$result_cliente[$i][cliente].'<br>';
					 
					//$mensaje.='Remesa: '.$result_cliente[$i][numero_remesa].' Producto: '.$result_cliente[$i][descripcion_producto].'<br>';
					$mensaje.='Remesa: '.$result_cliente[$i]['prefijo_tipo'].''.$result_cliente[$i]['prefijo_oficina'].'-'.$result_cliente[$i]['numero_remesa'].' Producto: '.$result_cliente[$i]['descripcion_producto'].'<br>';
					
					$mensaje.='Remision Cliente: '.$result_cliente[$i]['orden_despacho'].'<br>';
					$mensaje.='Fecha remesa: '.$result_cliente[$i]['fecha_remesa'].'<br>';	
					
					$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
					$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
					$mensaje.='Lugar: '.$punto_referencia.'<br>';	
					$mensaje.=$compl_causal;					
					$mensaje.=$result_tra[0][numero].'<br>';		
					$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
					$mensaje.='Hora: '.$hora_reporte.'<br>';	
					$mensaje.='Observacion: '.$obser_deta.'<br>';


					$mensaje.='4';
					
					$enviar_mail=new Mail();				  
					$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
		
			  }
			//parte para enviar a remesas paqueteo relacionadas a una remesa masivo Y un despacho
			  $select_cliente1  = "SELECT 
				LOWER(cf.correo_cliente_factura_operativa) AS  correo,
				r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
				r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
	
			  FROM relacion_masivo_paqueteo rr, remesa r, cliente_factura_operativa cf  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$result_tra[0][despachos_urbanos_id].") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' $consul_remesa
			  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
			  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
			   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
			  $result_cliente1 = $this -> DbFetchAll($select_cliente1,$Conex,true);
			  if(0<count($result_cliente1)){
				  
				  for($i=0; $i<count($result_cliente1);$i++){
					  
					  //mensaje 5
						$item_cliente=$result_cliente1[$i]['correo'];
						$mensaje='';
						$mensaje.='Origen: '.$result_cliente1[$i]['origen'].'. Destino:'.$result_cliente1[$i]['destino'].'<br>';	  
						$mensaje.='Remitente: '.$result_cliente1[$i]['remitente'].'. Destinatario:'.$result_cliente1[$i]['destinatario'].'<br>';								
						$mensaje.='Placa: '.$result_tra[0]['placa'].'<br>';
						$mensaje.='Conductor: '.$result_tra[0]['nombre'].'<br>';
						$mensaje.='Cliente: '.$result_cliente1[$i]['cliente'].'<br>';	
						
						//$mensaje.='Remesa: '.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
						$mensaje.='Remesa: '.$result_cliente1[$i]['prefijo_tipo'].''.$result_cliente1[$i]['prefijo_oficina'].'-'.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
						
						$mensaje.='Remision Cliente: '.$result_cliente1[$i]['orden_despacho'].'<br>';
						$mensaje.='Fecha remesa: '.$result_cliente1[$i]['fecha_remesa'].'<br>';	
						
						$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
						$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
						$mensaje.='Lugar: '.$punto_referencia.'<br>';	
						$mensaje.=$compl_causal;						
						$mensaje.=$result_tra[0][numero].'<br>';		
						$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
						$mensaje.='Hora: '.$hora_reporte.'<br>';	
						$mensaje.='Observacion: '.$obser_deta.'<br>';	
						$mensaje.='5';
						$enviar_mail=new Mail();				  
						$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
			
				  }
			  }
  			//fin parte para enviar a remesas paqueteo relacionadas a una remesa despacho
			  
		  }elseif($result_tra[0][manifiesto_id]>0){
			  $select_cliente  = "SELECT 
				LOWER(cf.correo_cliente_factura_operativa) AS  correo,
				r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
				r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,			
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
	
			  FROM  detalle_despacho dd, remesa r, cliente_factura_operativa cf  
			  WHERE dd.manifiesto_id=".$result_tra[0][manifiesto_id]." AND  r.remesa_id=dd.remesa_id AND r.estado!='AN' $consul_remesa
			  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
			  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
			   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
			  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
			  //echo $select_cliente;
				  
			  for($i=0; $i<count($result_cliente);$i++){
				  
				  //mensaje 6
					
					$item_cliente=$result_cliente[$i][correo];
					$mensaje='';
					$mensaje.='Origen: '.$result_cliente[$i][origen].'. Destino:'.$result_cliente[$i][destino].'<br>';	
					$mensaje.='Remitente: '.$result_cliente[$i]['remitente'].'. Destinatario:'.$result_cliente[$i]['destinatario'].'<br>';						
					$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
					$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
					$mensaje.='Cliente: '.$result_cliente[$i][cliente].'<br>';					
					//$mensaje.='Remesa: '.$result_cliente[$i][numero_remesa].' Producto: '.$result_cliente[$i][descripcion_producto].'<br>';
					$mensaje.='Remesa: '.$result_cliente[$i]['prefijo_tipo'].''.$result_cliente[$i]['prefijo_oficina'].'-'.$result_cliente[$i]['numero_remesa'].' Producto: '.$result_cliente[$i]['descripcion_producto'].'<br>';
					
					
					$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
					$mensaje.='Novedad: '.$result[0][novedad].'<br>';
					$mensaje.='Lugar: '.$punto_referencia.'<br>';	
					$mensaje.=$compl_causal;					
					$mensaje.=$result_tra[0][numero].'<br>';		
					$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
					$mensaje.='Hora: '.$hora_reporte.'<br>';	
					$mensaje.='Observacion: '.$obser_deta.'<br>';	
					$mensaje.='6';
					$enviar_mail=new Mail();				  
					$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
					//echo $item_cliente." --- ".$mail_subject;
		
			  }
			//parte para enviar a remesas paqueteo relacionadas a una remesa masivo Y un manifiesto
			  $select_cliente1  = "SELECT 
				LOWER(cf.correo_cliente_factura_operativa) AS  correo,
				r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
				r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
	
			  FROM relacion_masivo_paqueteo rr, remesa r, cliente_factura_operativa cf  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$result_tra[0][manifiesto_id].") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' $consul_remesa
			  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
			  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
			   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
			  $result_cliente1 = $this -> DbFetchAll($select_cliente1,$Conex,true);
			  if(0<count($result_cliente1)){
				  
				  for($i=0; $i<count($result_cliente1);$i++){
					  
					  
						$item_cliente=$result_cliente1[$i]['correo'];
						//Mensaje 7
						$mensaje='';
						$mensaje.='Origen: '.$result_cliente1[$i]['origen'].'. Destino:'.$result_cliente1[$i]['destino'].'<br>';	  
						$mensaje.='Remitente: '.$result_cliente1[$i]['remitente'].'. Destinatario:'.$result_cliente1[$i]['destinatario'].'<br>';								
						$mensaje.='Placa: '.$result_tra[0]['placa'].'<br>';
						$mensaje.='Conductor: '.$result_tra[0]['nombre'].'<br>';
						$mensaje.='Cliente: '.$result_cliente1[$i]['cliente'].'<br>';	
						 
						//$mensaje.='Remesa: '.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
						$mensaje.='Remesa: '.$result_cliente1[$i]['prefijo_tipo'].''.$result_cliente1[$i]['prefijo_oficina'].'-'.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
						
						$mensaje.='Remision Cliente: '.$result_cliente1[$i]['orden_despacho'].'<br>';
						$mensaje.='Fecha remesa: '.$result_cliente1[$i]['fecha_remesa'].'<br>';	
						
						$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
						$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
						$mensaje.='Lugar: '.$punto_referencia.'<br>';	
						$mensaje.=$compl_causal;						
						$mensaje.=$result_tra[0][numero].'<br>';		
						$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
						$mensaje.='Hora: '.$hora_reporte.'<br>';	
						$mensaje.='Observacion: '.$obser_deta.'<br>';	
						$mensaje.='7';
						
						$enviar_mail=new Mail();				  
						$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
			
				  }
			  }
  			//fin parte para enviar a remesas paqueteo relacionadas a una remesa masivo

		  }
		  //  --------- REEXPEDIDOS INICIO -------------------------
		  
		  elseif($result_tra[0][reexpedido_id]>0){
			  $select_cliente  = "SELECT 
				LOWER(cf.correo_cliente_factura_operativa) AS  correo,
			  
				r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
				r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,			
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
	
			  FROM  detalle_despacho dd, remesa r, cliente_factura_operativa cf  
			  WHERE dd.reexpedido_id=".$result_tra[0][reexpedido_id]." AND  r.remesa_id=dd.remesa_id AND r.estado!='AN' $consul_remesa
			  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
			  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
			   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
			  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
			  
				  
			  for($i=0; $i<count($result_cliente);$i++){
				  
				  
					$item_cliente=$result_cliente[$i][correo];
					//Mensaje 8
					$mensaje='';
					$mensaje.='Origen: '.$result_cliente[$i][origen].'. Destino:'.$result_cliente[$i][destino].'<br>';	
					$mensaje.='Remitente: '.$result_cliente[$i]['remitente'].'. Destinatario:'.$result_cliente[$i]['destinatario'].'<br>';						
					$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
					$mensaje.='Conductor: N/A <br>';
					$mensaje.='Cliente: '.$result_cliente[$i][cliente].'<br>';	
					
					//$mensaje.='Remesa: '.$result_cliente[$i][numero_remesa].' Producto: '.$result_cliente[$i][descripcion_producto].'<br>';
					$mensaje.='Remesa: '.$result_cliente[$i]['prefijo_tipo'].''.$result_cliente[$i]['prefijo_oficina'].'-'.$result_cliente[$i]['numero_remesa'].' Producto: '.$result_cliente[$i]['descripcion_producto'].'<br>';
					
					$mensaje.='Remision Cliente: '.$result_cliente[$i]['orden_despacho'].'<br>';
					$mensaje.='Fecha remesa: '.$result_cliente[$i]['fecha_remesa'].'<br>';	
					
					$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
					$mensaje.='Novedad: '.$result[0][novedad].'<br>';
					$mensaje.='Lugar: '.$punto_referencia.'<br>';	
					$mensaje.=$compl_causal;					
					$mensaje.=$result_tra[0][numero].'<br>';		
					$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
					$mensaje.='Hora: '.$hora_reporte.'<br>';	
					$mensaje.='Observacion: '.$obser_deta.'<br>';	
					$mensaje.='8';
					$enviar_mail=new Mail();				  
					$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
		
			  }
			//parte para enviar a remesas paqueteo relacionadas a una remesa masivo Y un manifiesto
			  $select_cliente1  = "SELECT 
				LOWER(cf.correo_cliente_factura_operativa) AS  correo,
				r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
				r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
	
			  FROM relacion_masivo_paqueteo rr, remesa r, cliente_factura_operativa cf  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$result_tra[0][reexpedido_id].") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' $consul_remesa
			  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
			  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
			   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
			  $result_cliente1 = $this -> DbFetchAll($select_cliente1,$Conex,true);
			  if(0<count($result_cliente1)){
				  
				  for($i=0; $i<count($result_cliente1);$i++){
					  
					  //Mensaje 9 
						$item_cliente=$result_cliente1[$i]['correo'];
						$mensaje='';
						$mensaje.='Origen: '.$result_cliente1[$i]['origen'].'. Destino:'.$result_cliente1[$i]['destino'].'<br>';	  
						$mensaje.='Remitente: '.$result_cliente1[$i]['remitente'].'. Destinatario:'.$result_cliente1[$i]['destinatario'].'<br>';								
						$mensaje.='Placa: '.$result_tra[0]['placa'].'<br>';
						$mensaje.='Conductor: N/A <br>';
						$mensaje.='Cliente: '.$result_cliente1[$i]['cliente'].'<br>';
						 
						//$mensaje.='Remesa: '.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
						$mensaje.='Remesa: '.$result_cliente1[$i]['prefijo_tipo'].''.$result_cliente1[$i]['prefijo_oficina'].'-'.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
						
						$mensaje.='Remision Cliente: '.$result_cliente1[$i]['orden_despacho'].'<br>';	
						$mensaje.='Fecha remesa: '.$result_cliente1[$i]['fecha_remesa'].'<br>';	
						
						
						$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
						$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
						$mensaje.='Lugar: '.$punto_referencia.'<br>';	
						$mensaje.=$compl_causal;						
						$mensaje.=$result_tra[0][numero].'<br>';		
						$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
						$mensaje.='Hora: '.$hora_reporte.'<br>';	
						$mensaje.='Observacion: '.$obser_deta.'<br>';	
						$mensaje.='9';
						$enviar_mail=new Mail();				  
						$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
			
				  }
			  }
  			//fin parte para enviar a remesas paqueteo relacionadas a una remesa masivo

		  }
		  
	  //  --------- REEXPEDIDOS  FIN ------------------------
	  }

	  if($result[0][reporte_interno]==1){
		  $select_correo  = "SELECT LOWER(correo) AS correo
		  FROM reporte_novedad WHERE novedad_id=$novedad_id";
		  $result_correo = $this -> DbFetchAll($select_correo,$Conex,true);
		  
			  
		  foreach($result_correo as $item_correo){
				$enviar_mail=new Mail();				  
				$mensaje_exitoso==$enviar_mail->sendMail(trim($item_correo[correo]),$mail_subject,$mensaje);
	
		  }
	  }
	
	  
	
	}
	return array(detalle_seg_id => $detalle_seg_id, fecha_reporte => str_replace("'","",$fecha_reporte), hora_reporte => str_replace("'","",$hora_reporte));

	//return $detalle_seg_id;

  }

  public function SaveNew($Campos,$Conex){

    $trafico_id        = $this -> requestDataForQuery('trafico_id','integer');
    $orden_det_ruta    = $this -> requestDataForQuery('orden_det_ruta','integer');
    $detalle_seg_id    = $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true,1);	
	$fecha_reporte     = $this -> getFechaDb($Conex);
	$hora_reporte      = $this -> getHoraDb($Conex);

    $insert = "INSERT INTO detalle_seguimiento 
					(detalle_seg_id,trafico_id,orden_det_ruta,fecha_reporte,hora_reporte) 
	           VALUES 
			   		($detalle_seg_id,$trafico_id,$orden_det_ruta,'$fecha_reporte','$hora_reporte')";
	
    $this -> query($insert,$Conex,true);
	
	return array(array(detalle_seg_id => $detalle_seg_id, fecha_reporte => $fecha_reporte, hora_reporte => $hora_reporte));

  }

  public function Update($Campos,$usuario_id,$usuarioNombres,$Conex){
	 
	$consul_remesa="";
    $trafico_id      	 = $this -> requestDataForQuery('trafico_id','integer');
    $detalle_seg_id      = $this -> requestDataForQuery('detalle_seg_id','integer');
    $novedad_id       	 = $this -> requestDataForQuery('novedad_id','integer');
   	$ubicacion_id        = $this -> requestDataForQuery('ubicacion_id','integer');
	$orden_det_ruta      = $this -> requestDataForQuery('orden_det_ruta','integer');
	$punto_referencia 	 = $this -> requestDataForQuery('punto_referencia','text');
	$tipo_punto          = $this -> requestDataForQuery('tipo_punto','text');
	$punto_referencia_id = $this -> requestDataForQuery('punto_referencia_id','integer');
    //$fecha_reporte       = $this -> requestDataForQuery('fecha_reporte','date');
    //$hora_reporte        = $this -> requestDataForQuery('hora_reporte','time');

	$remesa_id = $this -> requestDataForQuery('remesa_id','integer');
	$causal_devolucion_paqueteo_id = $this -> requestDataForQuery('causal_devolucion_id','integer');

    $fecha_reporte       = "'".$this -> getFechaDb($Conex)."'";
    $hora_reporte        = "'".$this -> getHoraDb($Conex)."'";
	$fecha_hora_suceso	= "'".$this -> getFechaDb($Conex)." ".$this -> getHoraDb($Conex)."'";

    $obser_deta       	 = $this -> requestDataForQuery('obser_deta','text');
    $recorrido_acumulado = 0;
	$fecha_hora_registro = $this -> getFechaHoraDb($Conex);

	$select  = "SELECT TIMEDIFF(CONCAT_WS(' ',$fecha_reporte,$hora_reporte),
			CONCAT_WS(' ',t.fecha_inicial_salida, t.hora_inicial_salida)) AS diferencia													
	FROM trafico t WHERE t.trafico_id=$trafico_id";
	//echo $select;
	$result = $this -> DbFetchAll($select,$Conex,true);
	
    $tiempo_tramo = $result[0][diferencia];

	$select  = "SELECT n.reporte_interno, n.reporte_cliente, n.novedad, a.alerta_panico,n.requiere_remesa,n.finaliza_remesa,
	(SELECT nombre_causal FROM causal_devolucion_paqueteo WHERE causal_devolucion_paqueteo_id=$causal_devolucion_paqueteo_id) AS nombre_causal
	FROM novedad_seguimiento n, alerta_panico a WHERE n.novedad_id=$novedad_id AND a.alerta_id=n.alerta_id ";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	$compl_causal= "";
	if($causal_devolucion_paqueteo_id>0){
		$compl_causal= "Causal: ".$result[0]['nombre_causal'].'<br>';
	}

	if($result[0]['requiere_remesa']==1 &&  (!$remesa_id>0 ||  $remesa_id=='NULL')) exit('Esta novedad Requiere que seleccione una Remesa');
	if($result[0]['requiere_remesa']==1 && $result[0]['finaliza_remesa']==1 && (!$causal_devolucion_paqueteo_id>0 || $causal_devolucion_paqueteo_id=='NULL')) exit('Esta novedad Requiere que seleccione una Causal');

    //valida si no esta finalizado en otro detalle seguimiento
	if($result[0]['requiere_remesa']==1 ){
		$select_com  = "SELECT dsr.remesa_id
		FROM detalle_seguimiento_remesa dsr, novedad_seguimiento ns 
			   WHERE dsr.remesa_id=$remesa_id AND  dsr.borrado=0  AND ns.novedad_id=dsr.novedad_id AND ns.finaliza_remesa=1 ";
		$result_com = $this -> DbFetchAll($select_com,$Conex,true);
		
		if($result_com[0]['remesa_id']>0) exit('Esta Remesa ya fue finalizada Anteriormente');
		
	}
    //fin valida si no esta finalizado en otro detalle seguimiento

    $insert = "UPDATE detalle_seguimiento 
				SET novedad_id=$novedad_id,orden_det_ruta=$orden_det_ruta,punto_referencia=$punto_referencia,tipo_punto=$tipo_punto,
					punto_referencia_id=$punto_referencia_id,ubicacion_id=$ubicacion_id,
					fecha_reporte=$fecha_reporte, hora_reporte=$hora_reporte, obser_deta=$obser_deta,
					tiempo_tramo='$tiempo_tramo', recorrido_acumulado=$recorrido_acumulado,
					fecha_hora_registro='$fecha_hora_registro',usuario_id=$usuario_id,usuario='$usuarioNombres'
				WHERE detalle_seg_id = $detalle_seg_id";
	
    $this -> query($insert,$Conex,true);
	
	//ingresa un detalle en seguimiento de remesa si requiere la novedad
	if($result[0]['requiere_remesa']==1 ){
		$detalle_seg_rem_id = $this -> DbgetMaxConsecutive("detalle_seguimiento_remesa","detalle_seg_rem_id",$Conex,true,1);
		$insert1 = "INSERT INTO detalle_seguimiento_remesa 
						(detalle_seg_rem_id,detalle_seg_id,remesa_id,usuario_id,fecha_hora_registro,fecha_hora_suceso,obser_deta,novedad_id,causal_devolucion_paqueteo_id) 
				   VALUES 
						($detalle_seg_rem_id,$detalle_seg_id,$remesa_id,$usuario_id,'$fecha_hora_registro',$fecha_hora_suceso,$obser_deta,$novedad_id,$causal_devolucion_paqueteo_id)";
	
		$this -> query($insert1,$Conex,true);

		if ($novedad_id>0) {
			$update = "UPDATE remesa SET
						novedad_id=$novedad_id
						WHERE remesa_id = $remesa_id";
			$this -> query($update,$Conex,true);
		} 
		
		if($causal_devolucion_paqueteo_id>0){
			$update = "UPDATE remesa SET
						causal_devolucion_paqueteo_id=$causal_devolucion_paqueteo_id
						WHERE remesa_id = $remesa_id";
			$this -> query($update,$Conex,true);
		}

	}
	//fin ingresa un detalle en seguimiento de remesa si requiere la novedad

	
	  
	  if($result[0][reporte_interno]==1 || $result[0][reporte_cliente]==1){

		  $select_tra  = "SELECT t.seguimiento_id,t.despachos_urbanos_id,t.manifiesto_id,				
				IF(t.seguimiento_id>0,(SELECT CONCAT('Seguimiento a Terceros ',seguimiento_id) AS numero FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT CONCAT('Despacho Urbano ',despacho) AS numero FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT CONCAT('Manifiesto de Carga ',manifiesto) AS numero  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS numero,
	
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT placa FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT placa  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS placa,
	
				IF(t.seguimiento_id>0,(SELECT nombre FROM seguimiento WHERE seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT nombre FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT nombre  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS nombre,
	
				IF(t.seguimiento_id>0,'N/A',
				IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_despacho dd, remesa r WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND r.estado!='AN'),
				(SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id AND r.estado!='AN') )) AS remesas,
	
				IF(t.seguimiento_id>0,'N/A',
				IF(t.despachos_urbanos_id>0,(SELECT numero_contenedor FROM  despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT numero_contenedor  FROM manifiesto WHERE manifiesto_id=t.manifiesto_id ))) AS  numero_contenedor,
				
				IF(t.seguimiento_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) FROM  seguimiento s WHERE s.seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) FROM  despachos_urbanos d WHERE d.despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=m.origen_id)  FROM manifiesto m WHERE m.manifiesto_id=t.manifiesto_id ))) AS  origen,
	
				IF(t.seguimiento_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) FROM  seguimiento s WHERE s.seguimiento_id=t.seguimiento_id ),
				IF(t.despachos_urbanos_id>0,(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) FROM  despachos_urbanos d WHERE d.despachos_urbanos_id=t.despachos_urbanos_id ),
				(SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=m.destino_id)  FROM manifiesto m WHERE m.manifiesto_id=t.manifiesto_id ))) AS  destino,

				IF(t.seguimiento_id>0,(SELECT cliente FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),
				IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC ),
				(SELECT GROUP_CONCAT(CONCAT_WS(' ',' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social,'- Remesa',r.numero_remesa, '- Producto',r.descripcion_producto)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC))) AS clientes

				
		  FROM trafico t WHERE t.trafico_id=$trafico_id ";
		  $result_tra = $this -> DbFetchAll($select_tra,$Conex,true);
		  

		  
		  if($result[0]['requiere_remesa']==1 && $remesa_id>0){		
			$consul_remesa = "AND r.remesa_id=$remesa_id";
			$select_rem  = "SELECT r.remesa_id, r.numero_remesa, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.orden_despacho,r.fecha_remesa,
				(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
				FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
				r.remitente, r.destinatario,r.direccion_remitente,r.direccion_destinatario
			
			FROM remesa r   WHERE r.remesa_id=$remesa_id";
			
			$result_rem = $this -> DbFetchAll($select_rem,$Conex,true);
			
			//MEnsaje 10
			$mail_subject='Novedad Remesa '.$result_rem[0]['prefijo_tipo'].$result_rem[0]['prefijo_oficina'].$result_rem[0]['numero_remesa'];
			$mensaje='';
			$mensaje.='Origen: '.$result_rem[0]['origen'].'. Destino:'.$result_rem[0]['destino'].'<br>';	  
			$mensaje.='Remitente: '.$result_rem[0]['remitente'].'. Destinatario:'.$result_rem[0]['destinatario'].'<br>';	  			
			$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
			$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
			$mensaje.='Remesa: '.$result_rem[0]['prefijo_tipo'].''.$result_rem[0]['prefijo_oficina'].'-'.$result_rem[0]['numero_remesa'].' Producto: '.$result_rem[0]['descripcion_producto'].'<br>';
			$mensaje.='Cliente: '.$result_tra[0]['cliente'].'<br>';
			
			$mensaje.='Remision Cliente: '.$result_rem[0]['orden_despacho'].'<br>';
			$mensaje.='Fecha Remesa: '.$result_rem[0]['fecha_remesa'].'<br>';
			
			$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
			$mensaje.='Novedad: '.$result[0][novedad].'<br>';
			$mensaje.='Lugar: '.$punto_referencia.'<br>';	
			$mensaje.=$compl_causal;			
			$mensaje.=$result_tra[0][numero].'<br>';		
			$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
			$mensaje.='Hora: '.$hora_reporte.'<br>';	
			$mensaje.='Observacion: '.$obser_deta.'<br>';
			$mensaje.='10';
			
		  }else{
			  //MEnsaje 11
			  $mail_subject='Novedad '.$result_tra[0][numero];
			  $mensaje='';
			  $mensaje.='Origen: '.$result_tra[0][origen].'. Destino:'.$result_tra[0][destino].'<br>';		  
			  $mensaje.='Placa: '.$result_tra[0][placa].'<br>';
			  $mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
			  $mensaje.='Remesas: '.$result_tra[0][remesas].'<br>';
			  $mensaje.='Clientes-Remesas: '.$result_tra[0][clientes].'<br>';
			  $mensaje.='Contenedor: '.$result_tra[0][numero_contenedor].'<br>';
			  
			  $mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
			  $mensaje.='Novedad: '.$result[0][novedad].'<br>';	
			  $mensaje.='Lugar: '.$punto_referencia.'<br>';	
			  $mensaje.=$result_tra[0][numero].'<br>';		
			  $mensaje.='Fecha: '.$fecha_reporte.'<br>';		
			  $mensaje.='Hora: '.$hora_reporte.'<br>';	
			  $mensaje.='Observacion: '.$obser_deta.'<br>';	
			  $mensaje.='11';
			
		  }
		  
		   if($result[0]['reporte_cliente']==1){
		  
			  if($result_tra[0][seguimiento_id]>0){
				  $select_cliente  = "SELECT 
				  IF(t.seguimiento_id>0,
					(SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM seguimiento s,  cliente_factura_operativa cf WHERE s.seguimiento_id=t.seguimiento_id AND cf.cliente_id=s.cliente_id),
					IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM detalle_despacho d, remesa r, cliente_factura_operativa cf WHERE d.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=d.remesa_id AND cf.cliente_id=r.cliente_id AND r.remesa_id NOT IN (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1 )  ),
					(SELECT GROUP_CONCAT(LOWER(cf.correo_cliente_factura_operativa)) FROM detalle_despacho d, remesa r, cliente_factura_operativa cf WHERE d.manifiesto_id=t.manifiesto_id AND r.remesa_id=d.remesa_id AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)))) AS	  correo
		
				  FROM trafico t  WHERE t.trafico_id=$trafico_id ";
				  
				  
				  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
				  
				  $correos_cliente=explode(',',$result_cliente[0][correo]);
					  
				  foreach($correos_cliente as $item_cliente){
					  
					  
		//MENsaje 12
						$mensaje='';
						$mensaje.='Origen: '.$result_tra[0][origen].'. Destino:'.$result_tra[0][destino].'<br>';	  
						$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
						$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';

						
						$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
						$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
						$mensaje.='Lugar: '.$punto_referencia.'<br>';	
						$mensaje.=$result_tra[0][numero].'<br>';		
						$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
						$mensaje.='Hora: '.$hora_reporte.'<br>';	
						$mensaje.='Observacion: '.$obser_deta.'<br>';	
						$mensaje.='12';
						$enviar_mail=new Mail();				  
						$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
			
				  }
			  }elseif($result_tra[0][despachos_urbanos_id]>0){
				  $select_cliente  = "SELECT 
					LOWER(cf.correo_cliente_factura_operativa) AS  correo,
					r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
					r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
					(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
					FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
					
		
				  FROM  detalle_despacho dd, remesa r, cliente_factura_operativa cf  
				  WHERE dd.despachos_urbanos_id=".$result_tra[0][despachos_urbanos_id]." AND  r.remesa_id=dd.remesa_id AND r.estado!='AN' 
				  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
				  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
				   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
				  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
				  
					  
				  for($i=0; $i<count($result_cliente);$i++){
					  
					  //Mensaje13
						$item_cliente=$result_cliente[$i][correo];
						$mensaje='';
						$mensaje.='Origen: '.$result_cliente[$i][origen].'. Destino:'.$result_cliente[$i][destino].'<br>';
						$mensaje.='Remitente: '.$result_cliente[$i]['remitente'].'. Destinatario:'.$result_cliente[$i]['destinatario'].'<br>';
						$mensaje.='Placa: '.$result_tra[0][placa].'<br>';
						$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
						$mensaje.='Cliente: '.$result_cliente[$i][cliente].'<br>';
						$mensaje.='Remesa: '.$result_cliente[$i]['prefijo_tipo'].''.$result_cliente[$i]['prefijo_oficina'].'-'.$result_cliente[$i]['numero_remesa'].' Producto: '.$result_cliente[$i]['descripcion_producto'].'<br>';
						
						$mensaje.='Remision Cliente: '.$result_cliente[$i]['orden_despacho'].'<br>';
						$mensaje.='Fecha Remesa: '.$result_cliente[$i]['fecha_remesa'].'<br>';
						
						$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
						$mensaje.='Novedad: '.$result[0][novedad].'<br>';
						$mensaje.='Lugar: '.$punto_referencia.'<br>';	
						$mensaje.=$compl_causal;						
						$mensaje.=$result_tra[0][numero].'<br>';		
						$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
						$mensaje.='Hora: '.$hora_reporte.'<br>';	
						$mensaje.='Observacion: '.$obser_deta.'<br>';
						$mensaje.='13';
						$enviar_mail=new Mail();				  
						$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
			
				  }
				//parte para enviar a remesas paqueteo relacionadas a una remesa masivo Y un despacho
				  $select_cliente1  = "SELECT 
					LOWER(cf.correo_cliente_factura_operativa) AS  correo,
					r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
					r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
					(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
					FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
		
				  FROM relacion_masivo_paqueteo rr, remesa r, cliente_factura_operativa cf  
				  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$result_tra[0][despachos_urbanos_id].") 
				  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' $consul_remesa
				  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
				  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
				   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
				  $result_cliente1 = $this -> DbFetchAll($select_cliente1,$Conex,true);
				  if(0<count($result_cliente1)){
					  
					  for($i=0; $i<count($result_cliente1);$i++){
						  
						  //MEnsaje 14
						  
							$item_cliente=$result_cliente1[$i]['correo'];
							$mensaje='';
							$mensaje.='Origen: '.$result_cliente1[$i]['origen'].'. Destino:'.$result_cliente1[$i]['destino'].'<br>';	  
							$mensaje.='Remitente: '.$result_cliente1[$i]['remitente'].'. Destinatario:'.$result_cliente1[$i]['destinatario'].'<br>';								
							$mensaje.='Placa: '.$result_tra[0]['placa'].'<br>';
							$mensaje.='Conductor: '.$result_tra[0]['nombre'].'<br>';
							$mensaje.='Cliente: '.$result_cliente1[$i]['cliente'].'<br>';					
							//$mensaje.='Remesa: '.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
							$mensaje.='Remesa: '.$result_cliente1[$i]['prefijo_tipo'].''.$result_cliente1[$i]['prefijo_oficina'].'-'.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
							
							$mensaje.='Remision Cliente: '.$result_cliente1[$i]['orden_despacho'].'<br>';
							$mensaje.='Fecha Remesa: '.$result_cliente1[$i]['fecha_remesa'].'<br>';
							
							$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
							$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
							$mensaje.='Lugar: '.$punto_referencia.'<br>';	
							$mensaje.=$compl_causal;						
							$mensaje.=$result_tra[0][numero].'<br>';		
							$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
							$mensaje.='Hora: '.$hora_reporte.'<br>';	
							$mensaje.='Observacion: '.$obser_deta.'<br>';	
							$mensaje.='14';
							$enviar_mail=new Mail();				  
							$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
				
					  }
				  }
				//fin parte para enviar a remesas paqueteo relacionadas a una remesa despacho
				  
				  
			  }elseif($result_tra[0][manifiesto_id]>0){
				  $select_cliente  = "SELECT 
					LOWER(cf.correo_cliente_factura_operativa) AS  correo,
					r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
					r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
					(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
					FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
					
				  FROM  detalle_despacho dd, remesa r, cliente_factura_operativa cf  
				  WHERE dd.manifiesto_id=".$result_tra[0][manifiesto_id]." AND r.remesa_id=dd.remesa_id AND r.estado!='AN' $consul_remesa
				  AND cf.cliente_id=r.cliente_id AND r.remesa_id NOT IN 
				  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
				   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
				  
				  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex,true);
				 //echo $select_cliente."mensaje 15";
					  
				  for($i=0; $i<count($result_cliente);$i++){
					  
					  //MENsaje 15
						$item_cliente=trim($result_cliente[$i][correo]);
						$mensaje='';
						$mensaje.='Origen: '.$result_cliente[$i]['origen'].'. Destino:'.$result_cliente[$i]['destino'].'<br>';	
						$mensaje.='Remitente: '.$result_cliente[$i]['remitente'].'. Destinatario:'.$result_cliente[$i]['destinatario'].'<br>';	  									
						$mensaje.='Placa: '.$result_tra[0]['placa'].'<br>';
						$mensaje.='Conductor: '.$result_tra[0][nombre].'<br>';
						$mensaje.='Cliente: '.$result_cliente[$i][cliente].'<br>';						
						//$mensaje.='Remesa: '.$result_cliente[$i][numero_remesa].' Producto: '.$result_cliente[$i][descripcion_producto].'<br>';
						$mensaje.='Remesa: '.$result_cliente[$i]['prefijo_tipo'].''.$result_cliente[$i]['prefijo_oficina'].'-'.$result_cliente[$i]['numero_remesa'].' Producto: '.$result_cliente[$i]['descripcion_producto'].'<br>';
						
						$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
						$mensaje.='Novedad: '.$result[0][novedad].'<br>';
						$mensaje.='Lugar: '.$punto_referencia.'<br>';	
						$mensaje.=$compl_causal;						
						$mensaje.=$result_tra[0][numero].'<br>';		
						$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
						$mensaje.='Hora: '.$hora_reporte.'<br>';	
						$mensaje.='Observacion: '.$obser_deta.'<br>';	
						$mensaje.='15';
						$enviar_mail=new Mail();				  
						$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje);
			 			//	echo $item_cliente." --15-- ".$mail_subject;
				  }

				//parte para enviar a remesas paqueteo relacionadas a una remesa masivo
				  $select_cliente1  = "SELECT 
					LOWER(cf.correo_cliente_factura_operativa) AS  correo,
					r.numero_remesa,r.descripcion_producto, r.prefijo_tipo,r.prefijo_oficina,r.descripcion_producto,r.remitente, 
					r.destinatario,r.direccion_remitente,r.direccion_destinatario,r.orden_despacho,r.fecha_remesa,
					(SELECT CONCAT_WS(' ',tr.razon_social,tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido) 
					FROM tercero tr, cliente c 	WHERE c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino				
		
				  FROM relacion_masivo_paqueteo rr, remesa r, cliente_factura_operativa cf  
				  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$result_tra[0][manifiesto_id].") 
				  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' $consul_remesa
				  AND cf.cliente_id=r.cliente_id  AND r.remesa_id NOT IN 
				  (SELECT dsr.remesa_id FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds, novedad_seguimiento ns 
				   WHERE dsr.borrado=0 AND ds.detalle_seg_id=dsr.detalle_seg_id AND ds.borrado=0 AND ns.novedad_id=ds.novedad_id AND ns.finaliza_remesa=1)" ;
				  $result_cliente1 = $this -> DbFetchAll($select_cliente1,$Conex,true);
				  if(0<count($result_cliente1)){
					  
					  for($i=0; $i<count($result_cliente1);$i++){
						  //Mensaje 16
							$item_cliente=$result_cliente1[$i]['correo'];
							$mensaje='';
							$mensaje.='Origen: '.$result_cliente1[$i]['origen'].'. Destino:'.$result_cliente1[$i]['destino'].'<br>';	
						    $mensaje.='Remitente: '.$result_cliente1[$i]['remitente'].'. Destinatario:'.$result_cliente1[$i]['destinatario'].'<br>';	  									
							
							$mensaje.='Placa: '.$result_tra[0]['placa'].'<br>';
							$mensaje.='Conductor: '.$result_tra[0]['nombre'].'<br>';
							$mensaje.='Cliente: '.$result_cliente1[$i]['cliente'].'<br>';					
							//$mensaje.='Remesa: '.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
							$mensaje.='Remesa: '.$result_cliente1[$i]['prefijo_tipo'].''.$result_cliente1[$i]['prefijo_oficina'].'-'.$result_cliente1[$i]['numero_remesa'].' Producto: '.$result_cliente1[$i]['descripcion_producto'].'<br>';
							
							$mensaje.='Remision Cliente: '.$result_cliente1[$i]['orden_despacho'].'<br>';
							$mensaje.='Fecha Remesa: '.$result_cliente1[$i]['fecha_remesa'].'<br>';
							
							$mensaje.='Alerta: '.$result[0][alerta_panico].'<br>';
							$mensaje.='Novedad: '.$result[0][novedad].'<br>';	
							$mensaje.='Lugar: '.$punto_referencia.'<br>';	
							$mensaje.=$compl_causal;
							$mensaje.=$result_tra[0][numero].'<br>';		
							$mensaje.='Fecha: '.$fecha_reporte.'<br>';		
							$mensaje.='Hora: '.$hora_reporte.'<br>';	
							$mensaje.='Observacion: '.$obser_deta.'<br>';	
							$mensaje.='16';
							$enviar_mail=new Mail();				  
							$enviar_mail->sendMail(trim($item_cliente),$mail_subject,$mensaje); 
				
					  }
				  }
				//fin parte para enviar a remesas paqueteo relacionadas a una remesa masivo

				  
				  
			  }
		  }

		  if($result[0]['reporte_interno']==1){
			  $select_correo  = "SELECT LOWER(correo) AS correo
			  FROM reporte_novedad WHERE novedad_id=$novedad_id";
			  $result_correo = $this -> DbFetchAll($select_correo,$Conex,true);
			  
			  foreach($result_correo as $item_correo){
					$enviar_mail=new Mail();				  
					$enviar_mail->sendMail(trim($item_correo[correo]),$mail_subject,$mensaje);
	
			  }
		  }

		
	  }

   	return array(fecha_reporte => str_replace("'","",$fecha_reporte), hora_reporte => str_replace("'","",$hora_reporte));

  }

  public function UpdateNew($Campos,$Conex){
  
    $detalle_seg_id      = $this -> requestDataForQuery('detalle_seg_id','integer');
	$orden_det_ruta       = $this -> requestDataForQuery('orden_det_ruta','integer');
	

    $update = "UPDATE detalle_seguimiento 
				SET orden_det_ruta=$orden_det_ruta
				WHERE detalle_seg_id = $detalle_seg_id";
	
    $this -> query($update,$Conex,true);

  }

  public function Delete($Campos,$Conex){

    $detalle_seg_id = $this -> requestData('detalle_seg_id');

    $this -> Begin($Conex);

	$delete = "UPDATE detalle_seguimiento_remesa SET borrado=1 WHERE detalle_seg_id = $detalle_seg_id";
	$this -> query($delete,$Conex,true);	
     
	/* $delete = "DELETE FROM detalle_seguimiento_remesa WHERE detalle_seg_id = $detalle_seg_id ";
     $this -> query($delete,$Conex,true);	*/
	
	$delete = "UPDATE detalle_seguimiento  SET borrado=1 WHERE detalle_seg_id = $detalle_seg_id";
	$this -> query($delete,$Conex,true);	
	
     /*$delete = "DELETE FROM detalle_seguimiento WHERE detalle_seg_id = $detalle_seg_id ";
     $this -> query($delete,$Conex,true);	*/
	
	$this -> Commit($Conex);

  }
  
  public function getHoraDb($Conex){
  
    $select = "SELECT CURTIME() AS hora";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return 	$result[0]['hora'];
  
  }
  
  public function getFechaDb($Conex){
  
    $select = "SELECT CURDATE() AS fecha";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return 	$result[0]['fecha'];  
  
  }
  
  public function getFechaHoraDb($Conex){
  
    $select = "SELECT NOW() AS fecha_hora";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return 	$result[0]['fecha_hora'];      
  
  }
  
   
}



?>