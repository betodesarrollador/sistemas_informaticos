<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class MandoTraficoModel extends Db{

  private $Permisos;
  
  
//// GRID ////

  public function getQueryMandoTraficoGrid(){
	
		$Query = "SELECT (SELECT  
	 CONCAT_WS('',IF(TIMESTAMPDIFF(MINUTE,DATE_ADD(IF(CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte)!='', CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte), CONCAT_WS(' ',t.fecha_inicial_salida, t.hora_inicial_salida)),INTERVAL t.frecuencia MINUTE),NOW())>30,'<div class=\"pendiente\" >',IF( TIMESTAMPDIFF(MINUTE,DATE_ADD(IF(CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte)!='', CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte), CONCAT_WS(' ',t.fecha_inicial_salida, t.hora_inicial_salida)),INTERVAL t.frecuencia MINUTE),NOW())<0 ,'<div class=\"transito\">','<div class=\"conruta\"')), '&nbsp;','</div>')  
	FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id  AND ds.fecha_reporte IS NOT NULL  ORDER BY CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte) DESC LIMIT 1) AS indicador ,
		
		CONCAT('<a  href=\"javascript:popPup(\'/roa/seguimiento/seguimiento_monitoreo/clases/RegistroNovedadesClass.php?trafico_id=',t.trafico_id,'\',\'Trafico\',\'1250\',\'700\');\">','VER','</a>') AS placa,
		
	(SELECT CONCAT_WS('','<div title=\"Observaciones: ','\">','REX No ',reexpedido,'</div>') AS mani FROM reexpedido WHERE reexpedido_id=t.reexpedido_id) AS trafico_id,
	
	CASE t.estado WHEN 'P' THEN '<div class=\"pendiente\">PENDIENTE RUTA</div>' WHEN 'R' THEN '<div class=\"conruta\">CON RUTA</div>' WHEN 'T' THEN '<div class=\"transito\">EN TRANSITO</div>' WHEN 'A' THEN 'ANULADO' WHEN 'N' THEN '<div class=\"pendiente\">APROBACION NOCTURNO</div>' ELSE 'FINALIZADO' END AS estado,
	
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
	
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,
	
	(SELECT GROUP_CONCAT(CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.reexpedido_id=t.reexpedido_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC) AS clientes,
	
	(SELECT CONCAT('<div title=\"',COALESCE(ds.obser_deta,' '),'\" style=\"background:',ap.color_alerta_panico,';\">',ns.novedad,'</div>') AS ult_ev  FROM detalle_seguimiento ds,  novedad_seguimiento ns, alerta_panico ap WHERE ds.trafico_id=t.trafico_id AND ns.novedad_id=ds.novedad_id AND ap.alerta_id=ns.alerta_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_evento,
	
	(SELECT CONCAT('<div title=\"',COALESCE(ds.obser_deta,' '),'\">',ds.punto_referencia,' ',ds.fecha_reporte,' ',ds.hora_reporte,'</div>') AS ult_pun  FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND ds.fecha_reporte IS NOT NULL ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_punto,
	
	
	
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) AS nom FROM tercero WHERE tercero_id=(SELECT tercero_id FROM proveedor WHERE proveedor_id=(SELECT proveedor_id FROM reexpedido WHERE reexpedido_id=t.reexpedido_id)))  AS conductor,
	
	(SELECT CONCAT('<div title=\"Movil: ',cel_apoyo,'\">',t.escolta_recibe,'</div>') AS escolta_inicia FROM apoyo  WHERE apoyo_id=t.apoyo_id_recibe ) AS escolta_inicia,
	
	(SELECT CONCAT('<div title=\"Movil: ',cel_apoyo,'\">',t.escolta_entrega,'</div>') AS escolta_fin FROM apoyo  WHERE apoyo_id=t.apoyo_id_entrega ) AS escolta_fin,
	
	(SELECT ds.obser_deta FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_obse	
	
	FROM trafico t WHERE t.urbano != 1 AND t.estado!='F' AND t.estado!='A' AND t.reexpedido_id>0 AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND t.manifiesto_id IS NULL  ORDER BY (SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) ASC";
   
   
   	
	
     return $Query;
   }

   
}



?>