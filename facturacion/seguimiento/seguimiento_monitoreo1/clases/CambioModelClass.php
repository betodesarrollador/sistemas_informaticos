<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CambioModel extends Db{

  private $Permisos;
  
  
  public function getRutas($trafico_id,$Conex){
	  
    $select = "SELECT ruta_id AS value,CONCAT_WS(' / ',ruta,pasador_vial) AS text FROM ruta 
	WHERE  ruta_id IN (SELECT ruta_id FROM detalle_ruta ) AND  ruta_id NOT IN (SELECT IF(ruta_id IS NULL,0,ruta_id) AS ruta_id FROM trafico WHERE trafico_id=$trafico_id) ORDER BY ruta ASC";
	$result = $this -> DbFetchAll($select,$Conex);
	return $result;
	  
  }

  public function getOrden($Conex){
	$opciones = array ( 0 => array ( 'value' => 'ASC', 'text' => 'ASCENDENTE' ), 1 => array ( 'value' => 'DESC', 'text' => 'DESCENDENTE' ) );
	return  $opciones;
  }
  

}


?>