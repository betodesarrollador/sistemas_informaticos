<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InicialMensajeriaModel extends Db{

  private $Permisos;  

  public function getQueryMensajeriaGrid($oficina_id){
	   	   
     $Query = "SELECT 'MENSAJERIA' AS mensajeria,
	IF(DATEDIFF(NOW(),CONCAT_WS(' ',g.fecha_guia,g.hora_guia))>2,CONCAT('<div class=\"pendiente\">',g.numero_guia,'</div>'),g.numero_guia) AS numero_guia,
	 g.fecha_guia,	 
	 g.remitente,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id=g.origen_id)AS origen,g.destinatario,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id=g.destino_id)AS destino,	
	 (SELECT nombre FROM oficina WHERE oficina_id=g.oficina_id)As oficina,
	 (SELECT nombre_estado FROM estado_mensajeria WHERE g.estado_mensajeria_id=estado_mensajeria_id)AS estado
	 FROM guia g WHERE g.estado_mensajeria_id NOT IN (6,7,8) AND (g.destino_id = (SELECT o.ubicacion_id FROM oficina o WHERE o.oficina_id=$oficina_id) OR g.oficina_id=$oficina_id)
	  UNION ALL 

	  SELECT 'ENCOMIENDA' AS mensajeria,
	IF(DATEDIFF(NOW(),CONCAT_WS(' ',g.fecha_guia,g.hora_guia))>2,CONCAT('<div class=\"pendiente\">',g.numero_guia,'</div>'),g.numero_guia) AS numero_guia,
	 g.fecha_guia,	 
	 g.remitente,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id=g.origen_id)AS origen,g.destinatario,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id=g.destino_id)AS destino,	
	 (SELECT nombre FROM oficina WHERE oficina_id=g.oficina_id)As oficina,
	 (SELECT nombre_estado FROM estado_mensajeria WHERE g.estado_mensajeria_id=estado_mensajeria_id)AS estado
	 FROM guia_encomienda g WHERE g.estado_mensajeria_id NOT IN (6,7,8) AND (g.destino_id = (SELECT o.ubicacion_id FROM oficina o WHERE o.oficina_id=$oficina_id) OR g.oficina_id=$oficina_id)

	  ORDER BY numero_guia ASC LIMIT 0,1000


	 "; //echo $Query;
   
     return $Query;
   }   
      
}

?>