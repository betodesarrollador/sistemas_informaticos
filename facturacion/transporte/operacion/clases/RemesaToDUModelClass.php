<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemesaToDUModel extends Db{

  private $Permisos;
  
  
  public function Save($Campos,$Conex){
  
   $this -> Begin($Conex);
  
	$despachos_urbanos_id = $this -> requestDataForQuery('despachos_urbanos_id','integer');
	$remesa_id          = $this -> requestDataForQuery('remesa_id','integer');

    $insert = "INSERT INTO detalle_despacho (despachos_urbanos_id,remesa_id) VALUES ($despachos_urbanos_id,$remesa_id)";	
    $this -> query($insert,$Conex,true);	
	
	$update = "UPDATE remesa SET estado = 'PC' WHERE remesa_id = $remesa_id";
    $this -> query($update,$Conex,true);	
	
   $this -> Commit($Conex);
   
	return $remesa_id;

  }

//// GRID ////
  public function getQueryRemesaToDUGrid($oficina_id){
	
    $Query = "(SELECT 
				CONCAT('<input type=\"checkbox\" value=\"',r.remesa_id,'\" />') 
				AS link,
				r.numero_remesa	AS remesa,
				(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
					FROM tercero 
					WHERE tercero_id = (SELECT tercero_id 
										FROM cliente c 
										WHERE c.cliente_id = r.cliente_id)
				) 
				AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) 
				AS destino,
				r.descripcion_producto AS mercancia,
				r.fecha_remesa 	AS fecha
				
			FROM remesa r
			WHERE r.desbloqueada = 0 AND r.oficina_id = $oficina_id AND r.estado = 'PD' AND r.planilla = 1) UNION ALL (SELECT 
				CONCAT('<input type=\"checkbox\" value=\"',r.remesa_id,'\" />') 
				AS link,
				r.numero_remesa	AS remesa,
				(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
					FROM tercero 
					WHERE tercero_id = (SELECT tercero_id 
										FROM cliente c 
										WHERE c.cliente_id = r.cliente_id)
				) 
				AS cliente,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) 
				AS destino,
				r.descripcion_producto AS mercancia,
				r.fecha_remesa 	AS fecha
				
			FROM remesa r
			WHERE r.desbloqueada AND r.oficina_desbloquea_id = $oficina_id AND r.estado = 'PD' AND r.planilla = 1)";
   
     return $Query;
   }
   
}

?>