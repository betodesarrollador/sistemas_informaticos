<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class MandoTraficoModel extends Db{

  private $Permisos;
  
  
//// GRID ////

  public function getQueryMandoTraficoGrid(){
	
		
	$Query = "SELECT 
	(SELECT  
	 CONCAT_WS('',IF(TIMESTAMPDIFF(MINUTE,DATE_ADD(IF(CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte)!='', CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte), CONCAT_WS(' ',t.fecha_inicial_salida, t.hora_inicial_salida)),INTERVAL t.frecuencia MINUTE),NOW())>30,'<div class=\"pendiente\" >',IF( TIMESTAMPDIFF(MINUTE,DATE_ADD(IF(CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte)!='', CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte), CONCAT_WS(' ',t.fecha_inicial_salida, t.hora_inicial_salida)),INTERVAL t.frecuencia MINUTE),NOW())<0 ,'<div class=\"transito\">','<div class=\"conruta\"')), '&nbsp;','</div>')  
	FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id  AND ds.fecha_reporte IS NOT NULL  ORDER BY CONCAT_WS(' ',ds.fecha_reporte, ds.hora_reporte) DESC LIMIT 1) AS indicador ,
	
	CONCAT('<a href=\"javascript:popPup(\'/roa/seguimiento/seguimiento_monitoreo/clases/RegistroNovedadesClass.php?trafico_id=',t.trafico_id,'\',\'Trafico\',\'1250\',\'700\');\">',
										
	IF(t.seguimiento_id>0,(SELECT s.placa FROM seguimiento s, oficina o WHERE s.seguimiento_id=t.seguimiento_id AND o.oficina_id=s.oficina_id),
						   
	IF(t.despachos_urbanos_id>0,(SELECT s.placa FROM  despachos_urbanos s, oficina o WHERE s.despachos_urbanos_id=t.despachos_urbanos_id AND o.oficina_id=s.oficina_id),
								 
	IF(t.manifiesto_id>0,(SELECT s.placa FROM manifiesto s, oficina o WHERE s.manifiesto_id=t.manifiesto_id AND o.oficina_id=s.oficina_id),
						  
						  'VER') ))
	
	,'</a>') AS placa,
	
	IF(t.seguimiento_id>0,CONCAT('ST No ',seguimiento_id),
								 
	IF(t.despachos_urbanos_id>0,(SELECT CONCAT_WS('','<div title=\"Observaciones: ',observaciones,'- Fecha Estimada Salida:',fecha_estimada_salida,'- Hora Estimada Salida:',hora_estimada_salida,'\">','DU No ',despacho,'</div>') AS despa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id),
	
	IF(t.manifiesto_id>0,(SELECT CONCAT_WS('','<div title=\"Observaciones: ',observaciones,'- Fecha Estimada Salida:',fecha_estimada_salida,'- Hora Estimada Salida:',hora_estimada_salida,'\">','MC No ',manifiesto,'</div>') AS mani FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),
										(SELECT CONCAT_WS('','<div title=\"Observaciones: ','\">','REX No ',reexpedido,'</div>') AS mani FROM reexpedido WHERE reexpedido_id=t.reexpedido_id)   )
											  
	 )) AS trafico_id,
	
	
	CASE t.estado WHEN 'P' THEN '<div class=\"pendiente\">PENDIENTE RUTA</div>' WHEN 'R' THEN '<div class=\"conruta\">CON RUTA</div>' WHEN 'T' THEN '<div class=\"transito\">EN TRANSITO</div>' WHEN 'A' THEN 'ANULADO' WHEN 'N' THEN '<div class=\"pendiente\">APROBACION NOCTURNO</div>' ELSE 'FINALIZADO' END AS estado,
		
		IF(t.despachos_urbanos_id>0,(SELECT s.fecha_du FROM despachos_urbanos s WHERE s.despachos_urbanos_id=t.despachos_urbanos_id),
	IF(t.manifiesto_id>0,(SELECT s.fecha_mc FROM manifiesto s WHERE s.manifiesto_id=t.manifiesto_id),(SELECT s.fecha_rxp FROM reexpedido s WHERE s.reexpedido_id=t.reexpedido_id)) )AS fecha,
		
		
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,
	
	
	IF(t.despachos_urbanos_id>0, (SELECT SUM(r.valor) FROM remesa r, detalle_despacho dd WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id ),IF((SELECT SUM(r.valor) FROM remesa r, detalle_despacho dd WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id )>10,(SELECT SUM(r.valor) FROM remesa r, detalle_despacho dd WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id ) , (SELECT SUM(r.valor) FROM remesa r, detalle_despacho dd , relacion_masivo_paqueteo rm WHERE dd.manifiesto_id=t.manifiesto_id AND dd.remesa_id = rm.remesa_masivo_id AND rm.remesa_paqueteo_id = r.remesa_id))
        
        )  AS valor_declarado,
	
		(SELECT CONCAT('<div title=\"',COALESCE(ds.obser_deta,' '),'\" style=\"background:',ap.color_alerta_panico,';\">',ns.novedad,'</div>') AS ult_ev  FROM detalle_seguimiento ds,  novedad_seguimiento ns, alerta_panico ap WHERE ds.trafico_id=t.trafico_id AND ns.novedad_id=ds.novedad_id AND ap.alerta_id=ns.alerta_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_evento,
	(SELECT CONCAT('<div>',u.nombre,'-',COALESCE(ds.obser_deta,' '),' ',ds.fecha_reporte,' ',ds.hora_reporte,'</div>') AS ult_pun  FROM detalle_seguimiento ds,  ubicacion u WHERE ds.trafico_id=t.trafico_id AND u.ubicacion_id=ds.ubicacion_id AND ds.fecha_reporte IS NOT NULL ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_punto,
	
	
	
	IF(t.seguimiento_id>0,(SELECT cliente FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),
	IF(t.despachos_urbanos_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.despachos_urbanos_id=t.despachos_urbanos_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC ),
															   
	IF(t.manifiesto_id>0,(SELECT GROUP_CONCAT(CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social)) AS clients FROM detalle_despacho dd, remesa r, cliente c, tercero tr WHERE dd.manifiesto_id=t.manifiesto_id AND r.remesa_id=dd.remesa_id AND c.cliente_id=r.cliente_id AND tr.tercero_id=c.tercero_id ORDER by r.orden_de_la_entrega ASC), 
        
        (SELECT remitente from orden_cargue ore WHERE ore.orden_cargue_id=t.orden_cargue_id AND orden_cargue_id NOT IN (SELECT dd.orden_cargue_id FROM detalle_despacho dd))) )) AS clientes,
	
		
	
	
	
	
	
	
	

	IF(t.seguimiento_id>0,(SELECT CONCAT('<div title=\"Movil ',s.movil_conductor,'\">',s.nombre,'</div>') AS nombre FROM seguimiento s, oficina o WHERE s.seguimiento_id=t.seguimiento_id AND o.oficina_id=s.oficina_id),
	IF(t.despachos_urbanos_id>0,(SELECT CONCAT('<div title=\"Movil ',tr.movil,'\">',s.nombre,'</div>') AS nombre FROM  despachos_urbanos s, conductor c, tercero tr, oficina o WHERE s.despachos_urbanos_id=t.despachos_urbanos_id AND o.oficina_id=s.oficina_id AND c.conductor_id=s.conductor_id AND tr.tercero_id=c.tercero_id),
	(SELECT CONCAT('<div title=\"Movil ',tr.movil,'\">',s.nombre,'</div>') AS nombre FROM manifiesto s, conductor c, tercero tr, oficina o WHERE s.manifiesto_id=t.manifiesto_id AND o.oficina_id=s.oficina_id AND c.conductor_id=s.conductor_id AND tr.tercero_id=c.tercero_id))) AS conductor,
	
	
	(SELECT CONCAT('<div title=\"Movil: ',cel_apoyo,'\">',t.escolta_recibe,'</div>') AS escolta_inicia FROM apoyo  WHERE apoyo_id=t.apoyo_id_recibe ) AS escolta_inicia,
	(SELECT CONCAT('<div title=\"Movil: ',cel_apoyo,'\">',t.escolta_entrega,'</div>') AS escolta_fin FROM apoyo  WHERE apoyo_id=t.apoyo_id_entrega ) AS escolta_fin,
	(SELECT ds.obser_deta FROM detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.orden_det_ruta DESC LIMIT 0,1) AS ult_obse	
	
	FROM trafico t WHERE t.estado!='F' AND t.estado!='A'   ORDER BY fecha DESC";
   
     return $Query;
   }

   
}



?>