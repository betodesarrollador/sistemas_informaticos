<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_PlanRutaModel extends Db{
  
  public function getTrafico($Conex){
  
    $trafico_id = $_REQUEST[trafico_id];
	
	if(is_numeric($trafico_id)){

	  $select  = "SELECT
	  					IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
						IF(t.seguimiento_id>0,(SELECT configuracion FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT configuracion FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT configuracion FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS configuracion,
						IF(t.seguimiento_id>0,(SELECT marca FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT marca FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT marca FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS marca_vehiculo,	
						IF(t.seguimiento_id>0,(SELECT linea FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT linea FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT linea FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS linea_vehiculo,
						IF(t.seguimiento_id>0,(SELECT color FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT color FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT color FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS color_vehiculo,
						IF(t.seguimiento_id>0,(SELECT carroceria FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT carroceria FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT carroceria FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS cceria_vehiculo,						
						IF(t.seguimiento_id>0,(SELECT nombre FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT conductor FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT conductor FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS conductor,
						IF(t.seguimiento_id>0,(SELECT numero_identificacion FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT numero_identificacion FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT numero_identificacion FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS conductor_doc,
						IF(t.seguimiento_id>0,'Despacho Particular',IF(t.manifiesto_id>0,'Manifiesto de Carga','Despacho Urbano')) AS tipo_doc,
						IF(t.seguimiento_id>0,(SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos  WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS num_doc,
						t.fecha_inicial_salida,
						t.hora_inicial_salida,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino
	  				FROM trafico t
					WHERE t.trafico_id=$trafico_id ";

	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
		
   	    $result = array();
	}
	return $result;
  }
  
  
  public function getDetalles($Conex){
  
   $trafico_id = $_REQUEST[trafico_id];
	
	if(is_numeric($trafico_id)){

	  $select  = "SELECT p.nombre,
	  				p.direccion,
					LOWER(p.observacion) AS  observacion,
					tp.nombre AS tipo_ref,
	  				tp.nombre AS tipo_punto
	  				FROM  detalle_seguimiento d, punto_referencia p, tipo_punto_referencia tp
					WHERE d.trafico_id=$trafico_id AND p.punto_referencia_id=d.punto_referencia_id AND 
					tp.tipo_punto_referencia_id=p.tipo_punto_referencia_id  ORDER BY d.orden_det_ruta ASC ";

	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	}
	return $result;
  }
  
   
}



?>