<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaToREModel extends Db{

  private $Permisos;  
  

//// GRID ////
  public function getQueryGuiaToREGrid($oficina_id){
	
     $Query = "SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia,r.remitente AS remitente,
			  (SELECT CONCAT_WS(' - ',u1.nombre, u2.nombre) FROM ubicacion u1,ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino,r.destinatario AS destinatario,r.fecha_guia AS fecha 
			  FROM guia r WHERE r.oficina_id = $oficina_id AND (r.estado = 'PD' OR r.estado = 'MF' OR r.estado = 'PC') AND r.planilla = 1 AND r.desbloqueada = 0 
	 	      UNION 
			  SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia, r.remitente AS remitente,
			  (SELECT CONCAT_WS(' - ',u1.nombre, u2.nombre) FROM ubicacion u1,ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino, r.destinatario AS destinatario, r.fecha_guia AS fecha 
			  FROM guia r WHERE r.desbloqueada = 1 AND r.oficina_desbloquea_id = $oficina_id AND (r.estado_mensajeria_id = 1 OR r.estado_mensajeria_id = 2 ) AND r.planilla = 1";
   
     return $Query;
   }   
}

?>