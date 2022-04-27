<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class OrdenCargueToRemesaModel extends Db{

  private $Permisos;
  private $remesa_id;
  private $datalle_remesa_id;
  
  
  public function SelectOrdenCargue($orden_cargue_id,$Conex){

    $arrayOrdenCargue = array();       
	
    $select = "SELECT o.orden_cargue_id,o.consecutivo AS orden,o.cliente_id,o.contacto_id,
   (SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) 
	FROM tercero WHERE tercero_id  = (SELECT tercero_id FROM cliente WHERE cliente_id = o.cliente_id)) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id = o.origen_id) 
	AS origen,o.origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = o.destino_id) AS  
	destino,o.destino_id,o.remitente_id,o.remitente,(SELECT numero_identificacion FROM remitente_destinatario WHERE remitente_destinatario_id = o.remitente_id) AS doc_remitente, 
	(SELECT tipo_identificacion_id FROM remitente_destinatario WHERE remitente_destinatario_id = o.remitente_id) AS tipo_identificacion_remitente_id, (SELECT direccion FROM 
	remitente_destinatario WHERE remitente_destinatario_id = o.remitente_id) AS direccion_remitente, (SELECT telefono FROM remitente_destinatario WHERE remitente_destinatario_id = 
	o.remitente_id) AS telefono_remitente, o.destinatario_id,o.destinatario,(SELECT tipo_identificacion_id FROM remitente_destinatario WHERE remitente_destinatario_id = 
	o.destinatario_id) AS tipo_identificacion_destinatario_id, (SELECT numero_identificacion FROM remitente_destinatario WHERE remitente_destinatario_id = o.destinatario_id) AS 
	doc_destinatario,(SELECT direccion FROM remitente_destinatario WHERE remitente_destinatario_id = o.destinatario_id) AS direccion_destinatario, (SELECT telefono FROM 
	remitente_destinatario WHERE remitente_destinatario_id = o.destinatario_id) AS telefono_destinatario,o.cantidad_cargue AS cantidad,o.peso,o.peso_volumen,o.producto_id,
	(SELECT codigo FROM producto WHERE producto_id = o.producto_id) AS producto,(SELECT producto_empresa FROM producto WHERE producto_id = o.producto_id) AS descripcion_producto FROM orden_cargue o WHERE o.orden_cargue_id = $orden_cargue_id";	

    $result = $this -> DbFetchAll($select,$Conex,false);

    $arrayOrdenCargue[0]['orden_cargue'] = $result;

    return $arrayOrdenCargue;  
  
  }

//// GRID ////
  public function getQueryOrdenCargueToRemesaGrid($oficina_id){
			
    $Query = "SELECT CONCAT('<input type=\"checkbox\" onClick=\"checkRow(this);\" value=\"',o.orden_cargue_id,'\" />') 
			 AS link,(SELECT concat_ws(' ',sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE 
			 tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = o.cliente_id)) AS cliente,(SELECT numero_identificacion  FROM tercero WHERE tercero_id = 
			 (SELECT tercero_id FROM cliente WHERE cliente_id = o.cliente_id)) 
			 AS  nit,o.consecutivo AS orden,(SELECT nombre FROM ubicacion WHERE ubicacion_id = o.origen_id) AS origen_id,
			 (SELECT nombre FROM ubicacion WHERE ubicacion_id = o.destino_id) AS destino_id,remitente,destinatario,producto,cantidad_cargue AS cantidad,peso,peso_volumen 
			 FROM  orden_cargue o WHERE o.oficina_id = $oficina_id AND o.estado = 'E' ORDER BY o.consecutivo DESC LIMIT 0,40";
   
     return $Query;
   }
   
}

?>