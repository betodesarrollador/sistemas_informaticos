<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaToDUModel extends Db{

  private $Permisos;  
  
  public function Save($Campos,$Conex){
  
   $this -> Begin($Conex);
  
	$despachos_urbanos_id = $this -> requestDataForQuery('despachos_urbanos_id','integer');
	$guia_id          = $this -> requestDataForQuery('guia_id','integer');

    $insert = "INSERT INTO detalle_despacho (despachos_urbanos_id,guia_id) VALUES ($despachos_urbanos_id,$guia_id)";	
    $this -> query($insert,$Conex,true);	
	
	$update = "UPDATE guia SET estado_mensajeria_id = 2 WHERE guia_id = $guia_id";
    $this -> query($update,$Conex,true);		
    $this -> Commit($Conex);   
	return $guia_id;
  }

//// GRID ////
  public function getQueryGuiaToDUGrid($oficina_id){	
	$Query = "(SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link, r.numero_guia	AS guia,
	(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id 
	FROM cliente c WHERE c.cliente_id = r.cliente_id)) AS cliente, (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) 
	AS destino, r.descripcion_producto AS mercancia, r.fecha_guia AS fecha
	FROM guia r WHERE r.desbloqueada = 0 AND r.oficina_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1) 
	UNION ALL (SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') 
	AS link, r.numero_guia AS guia, (SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
	FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente c WHERE c.cliente_id = r.cliente_id))AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino, r.descripcion_producto AS mercancia, r.fecha_guia AS fecha FROM guia r
	WHERE r.desbloqueada AND r.oficina_desbloquea_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1)";   
     return $Query;
   }   
}

?>