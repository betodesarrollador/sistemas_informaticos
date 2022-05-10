<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SeguimientoTransitoModel extends Db{

  private $Permisos;
  
  

//// GRID ////
  public function getQuerySeguimientoTransitoGrid(){
	
	$oficinaId = $_REQUEST['OFICINAID'];
		
   $Query = "SELECT CONCAT('<div style=\"background-color:#',			   
(SELECT color_alerta_panico FROM alerta_panico WHERE alerta_id = (SELECT alerta_id FROM novedad_seguimiento WHERE novedad_id = (SELECT novedad_id FROM detalle_seguimiento WHERE detalle_seg_id = (SELECT MAX(detalle_seg_id) FROM detalle_seguimiento WHERE seguimiento_id = s.seguimiento_id))))					   
					   
					   
					   ,'\">&nbsp;</div>') AS link,
				



CONCAT('<a href=\"/roa/seguimiento/seguimiento_monitoreo/clases/RegistroNovedadesClass.php?ACTIVIDADID=64&OFICINAID=$oficinaId&seguimiento_id=',seguimiento_id,'\">',seguimiento_id,'</a>') AS 

seguimiento_id,(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE c.tercero_id=t.tercero_id AND s.cliente_id=c.cliente_id) AS cliente,
				( SELECT  v.placa FROM vehiculo v, servicio_transporte st WHERE v.placa_id=st.placa_id AND st.seguimiento_id=s.seguimiento_id ) AS placa,
				( SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, conductor c, servicio_transporte st WHERE t.tercero_id=c.tercero_id AND c.conductor_id=st.conductor_id AND st.seguimiento_id=s.seguimiento_id ) AS conductor,
				( SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=s.origen_id ) AS origen,
				( SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=s.destino_id ) AS destino,
				( SELECT e.estado_segui FROM estado_seguimiento e WHERE e.estado_segui_id=s.estado_segui_id ) AS estado
				FROM seguimiento s";
   
     return $Query;
   }
   
}



?>