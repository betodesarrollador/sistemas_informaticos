<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
require_once("../../../framework/clases/MailClass.php");

final class DetalleRemesasDespachoModel extends Db{

  private $Permisos;
  
  
	public function getRemesas($trafico_id,$Conex){

		$select  = "SELECT despachos_urbanos_id,manifiesto_id, seguimiento_id,reexpedido_id
		FROM trafico WHERE trafico_id=$trafico_id";
		$result = $this -> DbFetchAll($select,$Conex,true);

		if($result[0]['despachos_urbanos_id']>0){
			$despachos_urbanos_id=$result[0]['despachos_urbanos_id'];
			$select="
			(SELECT CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa) as numero_remesa,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino,
			r.observaciones,r.fecha_remesa,r.direccion_destinatario,
			(SELECT ns.novedad FROM novedad_seguimiento ns WHERE ns.novedad_id=(SELECT novedad_id FROM detalle_seguimiento_remesa WHERE remesa_id=r.remesa_id ORDER BY fecha_hora_registro DESC LIMIT 1)) as ult_novedad
			FROM detalle_despacho d, remesa r WHERE d.despachos_urbanos_id = $despachos_urbanos_id AND r.remesa_id=d.remesa_id AND r.estado!='AN')
			UNION
			(SELECT CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa) as numero_remesa,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino,
			r.observaciones,r.fecha_remesa,r.direccion_destinatario,
			(SELECT ns.novedad FROM novedad_seguimiento ns WHERE ns.novedad_id=(SELECT novedad_id FROM detalle_seguimiento_remesa WHERE remesa_id=r.remesa_id ORDER BY fecha_hora_registro DESC LIMIT 1)) as ult_novedad
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$despachos_urbanos_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )  
			
			UNION
			(SELECT CONCAT_WS( ' ', 'Orden de cargue: ',oc.consecutivo) as numero_remesa,
			(SELECT oc.cliente) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=oc.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=oc.destino_id)as destino,
			oc.observaciones,oc.fecha,oc.direccion_cargue as direccion_destinatario,
			(SELECT  ' ')  as ult_novedad
			FROM orden_cargue oc WHERE oc.orden_cargue_id IN (SELECT dd.orden_cargue_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$despachos_urbanos_id.")
			)
			
			
			";
			
			
			
			//$select  = "
//			(SELECT r.remesa_id AS value, 
//			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
//			FROM detalle_despacho d, remesa r WHERE d.despachos_urbanos_id = $despachos_urbanos_id AND r.remesa_id=d.remesa_id AND r.estado!='AN')
//			UNION
//			(SELECT r.remesa_id AS value, 
//			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
//			FROM relacion_masivo_paqueteo rr, remesa r  
//			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.despachos_urbanos_id=".$despachos_urbanos_id.") 
//			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )  ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			return $result;
			
		}elseif($result[0]['manifiesto_id']>0){

			$manifiesto_id=$result[0]['manifiesto_id'];
			$select="
			(SELECT CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa) as numero_remesa,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino,
			r.observaciones,r.fecha_remesa,r.direccion_destinatario,
			(SELECT ns.novedad FROM novedad_seguimiento ns WHERE ns.novedad_id=(SELECT novedad_id FROM detalle_seguimiento_remesa WHERE remesa_id=r.remesa_id ORDER BY fecha_hora_registro DESC LIMIT 1)) as ult_novedad
			FROM detalle_despacho d, remesa r WHERE d.manifiesto_id = $manifiesto_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
   			UNION
			(SELECT CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa) as numero_remesa,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino,
			r.observaciones,r.fecha_remesa,r.direccion_destinatario,
			(SELECT ns.novedad FROM novedad_seguimiento ns WHERE ns.novedad_id=(SELECT novedad_id FROM detalle_seguimiento_remesa WHERE remesa_id=r.remesa_id ORDER BY fecha_hora_registro DESC LIMIT 1)) as ult_novedad
			FROM relacion_masivo_paqueteo rr, remesa r  
			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$manifiesto_id.") 
			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )   ";
			
			//$select  = "
//			(SELECT r.remesa_id AS value, 
//			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
//			FROM detalle_despacho d, remesa r WHERE d.manifiesto_id = $manifiesto_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
//			UNION
//			(SELECT r.remesa_id AS value, 
//			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
//			FROM relacion_masivo_paqueteo rr, remesa r  
//			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.manifiesto_id=".$manifiesto_id.") 
//			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )   ";


			$result = $this -> DbFetchAll($select,$Conex,true);
			return $result;

		}elseif($result[0]['reexpedido_id']>0){

			$reexpedido_id=$result[0]['reexpedido_id'];
			$select="
			(SELECT CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa) as numero_remesa,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino,
			(SELECT CONCAT_WS(' ','Guia prov:',r.doc_prov_rxp,' - OBS:',r.observaciones))as observaciones,r.fecha_remesa,
			(SELECT ns.novedad FROM novedad_seguimiento ns WHERE ns.novedad_id=(SELECT novedad_id FROM detalle_seguimiento_remesa WHERE remesa_id=r.remesa_id ORDER BY fecha_hora_registro DESC LIMIT 1)) as ult_novedad
			FROM detalle_despacho d, remesa r WHERE d.reexpedido_id = $reexpedido_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
 			UNION
			(SELECT CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa) as numero_remesa,
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) as cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id)as origen,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id)as destino,
			(SELECT CONCAT_WS(' ','Guia prov:',r.doc_prov_rxp,' - OBS:',r.observaciones))as observaciones,r.fecha_remesa,
			(SELECT ns.novedad FROM novedad_seguimiento ns WHERE ns.novedad_id=(SELECT novedad_id FROM detalle_seguimiento_remesa WHERE remesa_id=r.remesa_id ORDER BY fecha_hora_registro DESC LIMIT 1)) as ult_novedad
			FROM relacion_masivo_paqueteo rr, remesa r  
 			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.reexpedido_id=".$reexpedido_id.") 
 			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )   ";
			
			//$select  = "
//			(SELECT r.remesa_id AS value, 
//			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
//			FROM detalle_despacho d, remesa r WHERE d.reexpedido_id = $reexpedido_id AND r.remesa_id=d.remesa_id AND r.estado!='AN' )  
//			UNION
//			(SELECT r.remesa_id AS value, 
//			CONCAT_WS('',r.prefijo_tipo,r.prefijo_oficina,'-',r.numero_remesa,'. Cliente: ',(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.primer_apellido) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id AND t.tercero_id=c.tercero_id ) ) AS text
//			FROM relacion_masivo_paqueteo rr, remesa r  
//			  WHERE rr.remesa_masivo_id  IN (SELECT dd.remesa_id FROM  detalle_despacho dd WHERE dd.reexpedido_id=".$reexpedido_id.") 
//			  AND  r.remesa_id=rr.remesa_paqueteo_id AND r.estado!='AN' )   ";
			$result = $this -> DbFetchAll($select,$Conex,true);
			return $result;

		}else{
			return array();
		}
	}

	
   
}



?>