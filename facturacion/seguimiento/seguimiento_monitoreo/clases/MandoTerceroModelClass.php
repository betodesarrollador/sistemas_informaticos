<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class MandoTraficoModel extends Db{

  private $Permisos;
  
  
//// GRID ////

  public function getQueryMandoTraficoGrid(){
	
		
	$Query = "SELECT 

	IF(
	   (SELECT COUNT(*) AS reg  FROM detalle_seguimiento WHERE trafico_id=t.trafico_id AND fecha_reporte IS NOT NULL )>0,
	 (SELECT IF(TIMESTAMPDIFF(MINUTE,CONCAT_WS(' ',ds.fecha_reporte,ds.hora_reporte),NOW())<(SELECT MIN(p.tiempo_verde) FROM  parametros_reporte_trafico p, seguimiento s   WHERE s.seguimiento_id=t.seguimiento_id AND p.cliente_id=s.cliente_id),'<div class=\"transito\">&nbsp;</div>' ,IF(TIMESTAMPDIFF(MINUTE,CONCAT_WS(' ',ds.fecha_reporte,ds.hora_reporte),NOW())<(SELECT MIN(p.tiempo_amarillo) FROM  parametros_reporte_trafico p, seguimiento s   WHERE s.seguimiento_id=t.seguimiento_id AND p.cliente_id=s.cliente_id),'<div class=\"amarillosem\">&nbsp;</div>',IF((SELECT COUNT(*) FROM  parametros_reporte_trafico p, seguimiento s   WHERE s.seguimiento_id=t.seguimiento_id AND p.cliente_id=s.cliente_id )>0,'<div class=\"pendiente\">&nbsp;</div>','<div>&nbsp;</div>'))  )  AS indic  FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND ds.fecha_reporte IS NOT NULL ORDER BY ds.orden_det_ruta DESC LIMIT 0,1),
	 IF(TIMESTAMPDIFF(MINUTE,CONCAT_WS(' ',t.fecha_inicial_salida,t.hora_inicial_salida),NOW())<(SELECT MIN(p.tiempo_verde) FROM  parametros_reporte_trafico p, seguimiento s   WHERE s.seguimiento_id=t.seguimiento_id AND p.cliente_id=s.cliente_id),'<div class=\"transito\">&nbsp;</div>',IF(TIMESTAMPDIFF(MINUTE,CONCAT_WS(' ',t.fecha_inicial_salida,t.hora_inicial_salida),NOW())<(SELECT MIN(p.tiempo_amarillo) FROM  parametros_reporte_trafico p, seguimiento s   WHERE s.seguimiento_id=t.seguimiento_id AND p.cliente_id=s.cliente_id),'<div class=\"amarillosem\">&nbsp;</div>',IF((SELECT COUNT(*) FROM  parametros_reporte_trafico p, seguimiento s   WHERE s.seguimiento_id=t.seguimiento_id AND p.cliente_id=s.cliente_id )>0,'<div class=\"pendiente\">&nbsp;</div>','<div>&nbsp;</div>')))   
																							 ) AS indicador,

	CONCAT('<a href=\"javascript:popPup(\'/roa/seguimiento/seguimiento_monitoreo/clases/RegistroNovedadesClass.php?trafico_id=',t.trafico_id,'\',\'Trafico\',\'1250\',\'700\');\">',
	(SELECT s.placa FROM seguimiento s, oficina o WHERE s.seguimiento_id=t.seguimiento_id AND o.oficina_id=s.oficina_id),'</a>') AS placa,
	CONCAT('ST No ',seguimiento_id) AS trafico_id,
	CASE t.estado WHEN 'P' THEN '<div class=\"pendiente\">PENDIENTE RUTA</div>' WHEN 'R' THEN '<div class=\"conruta\">CON RUTA</div>' WHEN 'T' THEN '<div class=\"transito\">EN TRANSITO</div>' WHEN 'A' THEN 'ANULADO' WHEN 'N' THEN '<div class=\"pendiente\">APROBACION NOCTURNO</div>' ELSE 'FINALIZADO' END AS estado,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,
	(SELECT cliente FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS clientes,
	(SELECT CONCAT('<div title=\"',ds.obser_deta,'\" style=\"background:',ap.color_alerta_panico,';\">',ns.novedad,'</div>') AS ult_ev  FROM detalle_seguimiento ds,  novedad_seguimiento ns, alerta_panico ap WHERE ds.trafico_id=t.trafico_id AND ns.novedad_id=ds.novedad_id AND ap.alerta_id=ns.alerta_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_evento,
	(SELECT CONCAT('<div>',u.nombre,'-',ds.punto_referencia,' ',ds.fecha_reporte,' ',ds.hora_reporte,'</div>') AS ult_pun  FROM detalle_seguimiento ds,  ubicacion u WHERE ds.trafico_id=t.trafico_id AND u.ubicacion_id=ds.ubicacion_id AND ds.fecha_reporte IS NOT NULL ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_punto,
	(SELECT CONCAT('<div title=\"Movil ',s.movil_conductor,'\">',s.nombre,'</div>') AS nombre FROM seguimiento s, oficina o WHERE s.seguimiento_id=t.seguimiento_id AND o.oficina_id=s.oficina_id) AS conductor,
	(SELECT CONCAT('<div title=\"Movil: ',cel_apoyo,'\">',t.escolta_recibe,'</div>') AS escolta_inicia FROM apoyo  WHERE apoyo_id=t.apoyo_id_recibe ) AS escolta_inicia,
	(SELECT CONCAT('<div title=\"Movil: ',cel_apoyo,'\">',t.escolta_entrega,'</div>') AS escolta_fin FROM apoyo  WHERE apoyo_id=t.apoyo_id_entrega ) AS escolta_fin,
	(SELECT ds.obser_deta FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_obse		
	FROM trafico t WHERE  t.estado!='F' AND t.estado!='A' AND t.seguimiento_id>0 AND  t.despachos_urbanos_id IS NULL AND t.manifiesto_id IS NULL ORDER BY (SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id)   ASC";
   
     return $Query;
   }

   
}



?>