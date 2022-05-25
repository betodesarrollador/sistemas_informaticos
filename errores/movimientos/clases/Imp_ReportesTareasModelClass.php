<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ReportesTareasModel extends Db{

// La funcion getTareas, tiene las consulatas a las tablas actividad_programada,tercero y recibe tres parametros
	public function getTareas($fecha_inicio,$fecha_final,$Conex){
		
	$select = "SELECT * FROM actividad_programada
	INNER JOIN tercero ON tercero.tercero_id = actividad_programada.responsable_id
	WHERE fecha_cierre_real BETWEEN '$fecha_inicio' AND '$fecha_final'";	

	//die($select);

	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
}

}


?>