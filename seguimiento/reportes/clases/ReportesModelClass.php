<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportesModel extends Db{

  private $Permisos;
  

 public function setDetalles($Conex){
  
	  $select  = "SELECT *
	  FROM parametros_reporte_trafico   
	  WHERE estado = 'A' AND (dias='TD' OR (dias='LV' AND DAYOFWEEK(CURDATE())>1 AND DAYOFWEEK(CURDATE())<7 ) OR (dias='LS' AND DAYOFWEEK(CURDATE())>1 AND DAYOFWEEK(CURDATE())<8) )
		 AND (horas='CH' OR (horas='C2' AND (HOUR(CURTIME()) % 2)=0) OR  (horas='C3' AND (HOUR(CURTIME()) % 3)=0) OR  (horas='C4' AND (HOUR(CURTIME()) % 4)=0) OR  (horas='C8' AND (HOUR(CURTIME()) % 8)=0))";

	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }

 public function setDetallesCliente($cliente_id,$Conex){
  
	  $select  = "SELECT *
	  FROM parametros_reporte_trafico   
	  WHERE cliente_id=$cliente_id AND estado = 'A' AND (dias='TD' OR (dias='LV' AND DAYOFWEEK(CURDATE())>1 AND DAYOFWEEK(CURDATE())<7 ) OR (dias='LS' AND DAYOFWEEK(CURDATE())>1 AND DAYOFWEEK(CURDATE())<8) )
		 AND (horas='CH' OR (horas='C2' AND (HOUR(CURTIME()) % 2)=0) OR  (horas='C3' AND (HOUR(CURTIME()) % 3)=0) OR  (horas='C4' AND (HOUR(CURTIME()) % 4)=0) OR  (horas='C8' AND (HOUR(CURTIME()) % 8)=0))";
	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }


 public function getRegistros_man($cliente_id,$fecha_reg,$desde,$hasta,$remesa_id,$Conex){
  
	  $select  = "(SELECT DISTINCT ds.hora_reporte,ds.punto_referencia,
	  ds.fecha_reporte,
	  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id ) AS novedad,
	  ds.obser_deta
	  FROM trafico t, detalle_seguimiento ds, manifiesto m
	  WHERE  m.manifiesto_id IN (SELECT dd.manifiesto_id FROM remesa r, detalle_despacho dd WHERE r.cliente_id=$cliente_id AND (dd.remesa_id=$remesa_id OR dd.remesa_id IN (SELECT rm.remesa_masivo_id FROM relacion_masivo_paqueteo rm WHERE rm.remesa_paqueteo_id=$remesa_id)))  
	  AND ds.novedad_id NOT IN(15,4,6)
	  AND t.manifiesto_id=m.manifiesto_id AND ds.trafico_id=t.trafico_id  )
	  UNION ALL
	  (SELECT DISTINCT (SELECT TIME(dsr.fecha_hora_registro))as hora_reporte,ds.punto_referencia, (SELECT DATE(dsr.fecha_hora_registro))as fecha_reporte, 
	   (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=dsr.novedad_id ) AS novedad,
	   dsr.obser_deta
	   FROM detalle_seguimiento ds, detalle_seguimiento_remesa dsr 
	   WHERE ds.detalle_seg_id = dsr.detalle_seg_id AND dsr.remesa_id=$remesa_id
	   )
	  UNION ALL
	  (SELECT DISTINCT ds.hora_reporte,ds.punto_referencia,
	  ds.fecha_reporte,
	  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id ) AS novedad,
	  ds.obser_deta
	  FROM trafico t, detalle_seguimiento ds, reexpedido m
	  WHERE  m.reexpedido_id IN (SELECT dd.reexpedido_id FROM remesa r, detalle_despacho dd WHERE r.cliente_id=$cliente_id AND dd.remesa_id=$remesa_id  )  
	  AND ds.novedad_id NOT IN(15,4,6)
	  AND t.reexpedido_id=m.reexpedido_id AND ds.trafico_id=t.trafico_id  )
	  
	  ";
	 // echo $select;
	 
	 //AND ds.hora_reporte BETWEEN '$desde' AND '$hasta'
	  
	  
	 // $select  = "SELECT m.placa,m.manifiesto,
//	  (SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM remesa r, detalle_seguimiento_remesa dsr WHERE dsr.detalle_seg_id=ds.detalle_seg_id AND r.remesa_id=dsr.remesa_id AND r.cliente_id=$cliente_id) AS numero_remesa,
//	  ds.fecha_reporte,ds.hora_reporte,
//	  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
//	  ds.obser_deta
//	  FROM trafico t, detalle_seguimiento ds, manifiesto m
//	  WHERE  m.manifiesto_id IN (SELECT dd.manifiesto_id FROM remesa r, detalle_despacho dd WHERE r.cliente_id=$cliente_id AND dd.remesa_id=r.remesa_id  )  
//	  AND t.manifiesto_id=m.manifiesto_id AND ds.trafico_id=t.trafico_id AND ds.fecha_reporte='$fecha_reg' AND ds.hora_reporte BETWEEN '$desde' AND '$hasta' ";

	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }
  
  public function getRegistros_rem($cliente_id,$fecha_reg,$desde,$hasta,$Conex){
	  
	  $select ="SELECT DISTINCT r.numero_remesa,r.remesa_id,(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS clien FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) AS cliente,
	  r.orden_despacho,
	  (SELECT t.numero_identificacion FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) AS documento_cliente,
	  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) as origen,
	  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) as destino,
	  r.destinatario
	  

	  
	  FROM remesa r, detalle_seguimiento ds, detalle_seguimiento_remesa dsr WHERE dsr.detalle_seg_id=ds.detalle_seg_id AND r.remesa_id=dsr.remesa_id AND r.cliente_id=$cliente_id  AND ds.fecha_reporte='$fecha_reg'";
	  
	  //AND ds.hora_reporte BETWEEN '$desde' AND '$hasta'
	  
	 //echo $select;
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
	  
  }

 public function getRegistros_des($cliente_id,$fecha_reg,$desde,$hasta,$Conex){
	 
	   $select  = "(SELECT ds.punto_referencia,
	  ds.fecha_reporte,ds.hora_reporte,
	  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id ) AS novedad,
	  ds.obser_deta
	  FROM trafico t, detalle_seguimiento ds, despachos_urbanos m
	  WHERE  m.despachos_urbanos_id IN (SELECT dd.despachos_urbanos_id FROM remesa r, detalle_despacho dd WHERE r.cliente_id=$cliente_id AND dd.remesa_id=$remesa_id  )  
	  AND ds.novedad_id NOT IN(15,4,6)
	  AND t.despachos_urbanos_id=m.despachos_urbanos_id AND ds.trafico_id=t.trafico_id AND ds.fecha_reporte='$fecha_reg' AND ds.hora_reporte BETWEEN '$desde' AND '$hasta' )
	  UNION ALL
	  (SELECT ds.punto_referencia, (SELECT DATE(dsr.fecha_hora_registro))as fecha_reporte, (SELECT TIME(dsr.fecha_hora_registro))as hora_reporte,
	   (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=dsr.novedad_id ) AS novedad,
	   dsr.obser_deta
	   FROM detalle_seguimiento ds, detalle_seguimiento_remesa dsr 
	   WHERE dsr.remesa_id=$remesa_id AND ds.detalle_seg_id = dsr.detalle_seg_id
	   )
	  
	  ";
  
	 /* $select  = "SELECT m.placa,m.despacho,
	  (SELECT GROUP_CONCAT(r.numero_remesa) AS remesas FROM remesa r, detalle_seguimiento_remesa dsr WHERE dsr.detalle_seg_id=ds.detalle_seg_id AND r.remesa_id=dsr.remesa_id AND r.cliente_id=$cliente_id) AS numero_remesa,
	  ds.fecha_reporte,ds.hora_reporte,
	  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
	  ds.obser_deta
	  FROM trafico t, detalle_seguimiento ds, despachos_urbanos  m
	  WHERE   m.despachos_urbanos_id IN (SELECT dd.despachos_urbanos_id FROM remesa r, detalle_despacho dd WHERE r.cliente_id=$cliente_id AND dd.remesa_id=r.remesa_id )  
	  AND t.despachos_urbanos_id=m.despachos_urbanos_id AND ds.trafico_id=t.trafico_id AND ds.fecha_reporte='$fecha_reg' AND ds.hora_reporte BETWEEN '$desde' AND '$hasta' ";*/

	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }

 public function getRegistros_seg($cliente_id,$fecha_reg,$desde,$hasta,$Conex){
  
	  $select  = "SELECT m.placa,s.seguimiento_id,ds.fecha_reporte,ds.hora_reporte,
	  (SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
	  ds.obser_deta
	  FROM trafico t, detalle_seguimiento ds, seguimiento s
	  WHERE  s.cliente_id=$cliente_id AND t.seguimiento_id=s.seguimiento_id AND ds.trafico_id=t.trafico_id AND ds.fecha_reporte='$fecha_reg' AND ds.hora_reporte BETWEEN '$desde' AND '$hasta' ";

	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }

 public function comprobar_archivo($cliente_id,$fecha_reg,$hasta,$desde,$Conex){
  
	  $select  = "SELECT *
	  FROM reporte_historial_novedad  WHERE  cliente_id=$cliente_id AND fecha='$fecha_reg' AND hora='$hasta' ";
//echo $select;
	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }
 public function getcorreos_cliente($cliente_id,$Conex){
  
	  $select  = "SELECT LOWER(correo_cliente_factura_operativa) AS correo
	  FROM cliente_factura_operativa  WHERE  cliente_id=$cliente_id ";

	$result = $this -> DbFetchAll($select,$Conex);
	  
	return $result;
  
  }

  public function Save($cliente_id,$minuto,$horas,$dias,$fecha_reg,$hasta,$fecha_registro,$sarchivo,$comodin,$enviado,$Conex){
	  
	$reporte_historial_nov_id 	 = $this -> DbgetMaxConsecutive("reporte_historial_novedad","reporte_historial_nov_id",$Conex,true,1);

    $insert = "INSERT INTO reporte_historial_novedad (reporte_historial_nov_id,cliente_id,minuto,horas,dias,fecha,hora,fecha_registro,archivo,con_registros,enviado) 
	           VALUES ($reporte_historial_nov_id,$cliente_id,'$minuto','$horas','$dias','$fecha_reg','$hasta','$fecha_registro','$sarchivo',$comodin,$enviado)";
	
    $this -> query($insert,$Conex);

	if(!strlen(trim($this -> GetError())) > 0){
		return $reporte_historial_nov_id; 
	}
  }

  public function Update($reporte_historial_nov_id,$Conex){

    $update = "UPDATE reporte_historial_novedad SET enviado=1 WHERE reporte_historial_nov_id=$reporte_historial_nov_id ";
    $this -> query($update,$Conex);

  }
  
  

//// GRID ////

  public function getQueryReportesGrid(){
	
		
	$Query = "SELECT 
		CURDATE() AS fecha,
		
		CASE  p.minuto WHEN 'UV' THEN ADDTIME(CONCAT_WS(':',HOUR(CURTIME()),'00','00'),'01:00:00') WHEN 'CQ' THEN ADDTIME(CONCAT_WS(':',CASE FLOOR(MINUTE(CURTIME())/15) WHEN '1' THEN CONCAT_WS(':',HOUR(CURTIME()),'15') WHEN '2' THEN CONCAT_WS(':',HOUR(CURTIME()),'30') WHEN '3' THEN CONCAT_WS(':',HOUR(CURTIME()),'45') ELSE CONCAT_WS(':',HOUR(CURTIME()),'00') END,'00'),'00:15:00') ELSE ADDTIME(CONCAT_WS(':',HOUR(CURTIME()),CASE ROUND(MINUTE(CURTIME())/30,0) WHEN '0' THEN '00' ELSE '30' END,'00'),'00:30:00') END AS hora, 
		
	  	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS clien FROM cliente c, tercero t WHERE c.cliente_id=p.cliente_id AND t.tercero_id=c.tercero_id ) AS cliente,
		CASE p.minuto WHEN 'UV' THEN 'UNA VEZ CADA HORA' WHEN 'CQ' THEN 'CADA QUINCE MINUTOS' ELSE 'CADA TREINTA MINUTOS' END AS minuto,
		CASE p.horas WHEN 'CH' THEN 'CADA HORA' WHEN 'C2' THEN 'CADA DOS HORAS' WHEN 'C3' THEN 'CADA TRES HORAS' WHEN 'C4' THEN 'CADA CUATRO HORAS' ELSE 'CADA OCHO HORAS' END AS horas,
		CASE p.dias WHEN 'TD' THEN 'TODOS LOS DIAS' WHEN 'LV' THEN 'LUNES A VIERNES'  ELSE 'LUNES A SABADO' END AS dias,
		CONCAT('<img src=\"../media/images/MenuArbol/appicondoc.png\" onclick=\"generar(',p.cliente_id,',','\'',CURDATE(),'\'',',','\'',CASE  p.minuto WHEN 'UV' THEN CONCAT_WS(':',HOUR(CURTIME()),'00','00') WHEN 'CQ' THEN CONCAT_WS(':',CASE FLOOR(MINUTE(CURTIME())/15) WHEN '1' THEN CONCAT_WS(':',HOUR(CURTIME()),'15') WHEN '2' THEN CONCAT_WS(':',HOUR(CURTIME()),'30') WHEN '3' THEN CONCAT_WS(':',HOUR(CURTIME()),'45') ELSE CONCAT_WS(':',HOUR(CURTIME()),'00') END,'00') ELSE CONCAT_WS(':',HOUR(CURTIME()),CASE ROUND(MINUTE(CURTIME())/30,0) WHEN '0' THEN '00' ELSE '30' END,'00') END,'\'',',','\'',CASE  p.minuto WHEN 'UV' THEN ADDTIME(CONCAT_WS(':',HOUR(CURTIME()),'00','00'),'01:00:00') WHEN 'CQ' THEN ADDTIME(CONCAT_WS(':',CASE FLOOR(MINUTE(CURTIME())/15) WHEN '1' THEN CONCAT_WS(':',HOUR(CURTIME()),'15') WHEN '2' THEN CONCAT_WS(':',HOUR(CURTIME()),'30') WHEN '3' THEN CONCAT_WS(':',HOUR(CURTIME()),'45') ELSE CONCAT_WS(':',HOUR(CURTIME()),'00') END,'00'),'00:15:00') ELSE ADDTIME(CONCAT_WS(':',HOUR(CURTIME()),
		CASE ROUND(MINUTE(CURTIME())/30,0) WHEN '0' THEN '00' ELSE '30' END,'00'),'00:30:00') END,'\'',');\" title=\"Generar Archivo\" />') AS archivo,
		CONCAT('<img src=\"../media/images/MenuArbol/correo.jpg\" onclick=\"enviar(',p.cliente_id,',','\'',CURDATE(),'\'',',','\'',CASE  p.minuto WHEN 'UV' THEN CONCAT_WS(':',HOUR(CURTIME()),'00','00') WHEN 'CQ' THEN CONCAT_WS(':',CASE FLOOR(MINUTE(CURTIME())/15) WHEN '1' THEN CONCAT_WS(':',HOUR(CURTIME()),'15') WHEN '2' THEN CONCAT_WS(':',HOUR(CURTIME()),'30') WHEN '3' THEN CONCAT_WS(':',HOUR(CURTIME()),'45') ELSE CONCAT_WS(':',HOUR(CURTIME()),'00') END,'00') ELSE CONCAT_WS(':',HOUR(CURTIME()),CASE ROUND(MINUTE(CURTIME())/30,0) WHEN '0' THEN '00' ELSE '30' END,'00') END,'\'',',','\'',CASE  p.minuto WHEN 'UV' THEN ADDTIME(CONCAT_WS(':',HOUR(CURTIME()),'00','00'),'01:00:00') WHEN 'CQ' THEN ADDTIME(CONCAT_WS(':',CASE FLOOR(MINUTE(CURTIME())/15) WHEN '1' THEN CONCAT_WS(':',HOUR(CURTIME()),'15') WHEN '2' THEN CONCAT_WS(':',HOUR(CURTIME()),'30') WHEN '3' THEN CONCAT_WS(':',HOUR(CURTIME()),'45') ELSE CONCAT_WS(':',HOUR(CURTIME()),'00') END,'00'),'00:15:00') ELSE ADDTIME(CONCAT_WS(':',HOUR(CURTIME()),
		CASE ROUND(MINUTE(CURTIME())/30,0) WHEN '0' THEN '00' ELSE '30' END,'00'),'00:30:00') END,'\'',');\" title=\"Enviar Archivo\" />') AS enviar
	  FROM parametros_reporte_trafico p  
	  WHERE p.estado = 'A' AND (p.dias='TD' OR (p.dias='LV' AND DAYOFWEEK(CURDATE())>1 AND DAYOFWEEK(CURDATE())<7 ) OR (p.dias='LS' AND DAYOFWEEK(CURDATE())>1 AND DAYOFWEEK(CURDATE())<8) )
		 AND (p.horas='CH' OR (p.horas='C2' AND (HOUR(CURTIME()) % 2)=0) OR  (p.horas='C3' AND (HOUR(CURTIME()) % 3)=0) OR  (p.horas='C4' AND (HOUR(CURTIME()) % 4)=0) OR  (p.horas='C8' AND (HOUR(CURTIME()) % 8)=0)) ORDER BY fecha DESC";
   
     return $Query;
   }

   
}



?>