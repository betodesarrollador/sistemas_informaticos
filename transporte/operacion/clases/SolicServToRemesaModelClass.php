<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicServToRemesaModel extends Db{

  private $Permisos;
  private $remesa_id;
  private $datalle_remesa_id;
  
  
  public function SelectSolicitud($detalles_ss_id,$solicitud_id,$Conex){

    $arraySolicitud = array();
    $detalle_ss_id  = explode(",",$detalles_ss_id); 
    $detalle_ss_id  = $detalle_ss_id[0];
       
    $select = "SELECT s.solicitud_id,d.orden_despacho,s.cliente_id,s.contacto_id,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
	1 as tipo_remesa_id,0 as empaque_id,39 AS medida_id,
	s.fecha_ss AS fecha_recogida_ss,
	s.hora_recogida_ss,

(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  propietario_mercancia,	

(SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id =  (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id))) AS  tipo_identificacion_propietario_mercancia,	

(SELECT numero_identificacion FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  numero_identificacion_propietario_mercancia,	




	
(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id  = ( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  propietario_mercancia_txt,

( SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id) AS  propietario_mercancia_id,
	
	
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.origen_id) AS origen,d.origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.destino_id) AS destino,d.destino_id,d.remitente_id,d.remitente,d.doc_remitente,d.tipo_identificacion_remitente_id,d.direccion_remitente,d.telefono_remitente,d.destinatario_id,d.destinatario,d.doc_destinatario,d.tipo_identificacion_destinatario_id,d.direccion_destinatario,d.telefono_destinatario,(SELECT SUM(cantidad) FROM detalle_solicitud_servicio WHERE solicitud_id = s.solicitud_id) AS cantidad,(SELECT SUM(peso) FROM detalle_solicitud_servicio WHERE solicitud_id = s.solicitud_id) AS peso,(SELECT SUM(peso_volumen) FROM detalle_solicitud_servicio WHERE solicitud_id = s.solicitud_id) AS peso_volumen,(SELECT SUM(valor_unidad) FROM detalle_solicitud_servicio WHERE solicitud_id = s.solicitud_id) AS valor, d.observaciones,d.unidad_peso_id,
	d.producto_id,
	(SELECT CONCAT_WS('-', codigo,CONVERT(producto USING latin1))as val FROM producto p WHERE p.producto_id=d.producto_id)as producto,
	(SELECT CONCAT_WS('-', codigo,CONVERT(producto USING latin1))as val FROM producto p WHERE p.producto_id=d.producto_id)as descripcion_producto
	
	FROM solicitud_servicio s,detalle_solicitud_servicio d WHERE s.solicitud_id = $solicitud_id AND s.solicitud_id = d.solicitud_id AND detalle_ss_id = $detalle_ss_id";
	//echo($select);
    $result = $this -> DbFetchAll($select,$Conex,true);

    $arraySolicitud[0]['solicitud'] = $result;

    $select = "SELECT detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto_detalle,cantidad AS cantidad_detalle,peso AS peso_detalle,valor_unidad AS valor_detalle,peso_volumen AS peso_volumen_detalle,orden_despacho AS guia_cliente,observaciones FROM detalle_solicitud_servicio WHERE solicitud_id = $solicitud_id AND detalle_ss_id IN ($detalles_ss_id) ORDER BY detalle_ss_id ASC ";

    $result = $this -> DbFetchAll($select,$Conex,false);

    $arraySolicitud[0]['detalle_solicitud'] = $result;

    return $arraySolicitud;  
  
  }

//// GRID ////
  public function getQuerySolicServToRemesaGrid($oficina_id){
	
//	$oficinaId = $_REQUEST['OFICINAID'];
		
    $Query = "SELECT CONCAT('<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',d.detalle_ss_id,'\" />') 
			 AS link,(SELECT concat_ws(' ',sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE 
			 tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = (SELECT cliente_id FROM solicitud_servicio WHERE 
			 solicitud_id = d.solicitud_id))) AS cliente,(SELECT numero_identificacion  FROM tercero WHERE tercero_id = 
			 (SELECT tercero_id FROM cliente WHERE cliente_id = (SELECT cliente_id FROM solicitud_servicio WHERE solicitud_id = d.solicitud_id))) 
			 AS  nit,d.solicitud_id AS solicitud,orden_despacho,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.origen_id) AS origen_id,
			 (SELECT nombre FROM ubicacion WHERE ubicacion_id = d.destino_id) AS destino_id,remitente,doc_remitente,destinatario,
			 doc_destinatario,referencia_producto,descripcion_producto,cantidad,peso,peso_volumen,valor_unidad FROM 
			 solicitud_servicio s,detalle_solicitud_servicio d WHERE s.oficina_id = $oficina_id AND s.solicitud_id = d.solicitud_id AND 
			 d.detalle_ss_id AND d.estado = 'D'";
   
     return $Query;
   }
   
}

?>