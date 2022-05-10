<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicComisionesModel extends Db{

  private $Permisos;

 

//// GRID ////
  public function getQuerySolicComisionesGrid($comercial_id){
	

	$Query = "SELECT 
            CONCAT_WS('','<input type=\"checkbox\"  value=\"',o.comisiones_id,'\" name=\"check\"/>') AS link,
            o.fecha_inicio, o.fecha_final,
            CONCAT_WS(' ',t.numero_identificacion,'-',t.razon_social, t.primer_nombre, t.primer_apellido) AS cliente, 
            o.valor_neto_pagar, IF(o.tipo_liquidacion='R','RECAUDO','VENTA') AS tipo
			FROM comisiones o, cliente c, tercero t
			WHERE o.comercial_id=$comercial_id AND  o.estado='L' 
            AND c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id"; 

	return $Query;
   }
   
}



?>