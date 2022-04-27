<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteRendimientoModel extends Db{

	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}    
	


	public function selectInformacion($consul_fecha_inicio,$consul_fecha_final,$consul_usuario_id,$Conex){

		$select = "SELECT ap.actividad_programada_id,ap.nombre,ap.fecha_inicial, ap.fecha_final, ap.fecha_cierre_real, (SELECT DATEDIFF(ap.fecha_final,ap.fecha_inicial)) AS dias_permitidos,ap.fecha_cierre,
		IF((SELECT DATEDIFF(ap.fecha_cierre_real,ap.fecha_final)) < 0,0,(SELECT DATEDIFF(ap.fecha_cierre_real,ap.fecha_final)))  AS dias_retraso, 
		(SELECT CONCAT_WS(' ',t.numero_identificacion,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u WHERE t.tercero_id = ap.responsable_id AND t.tercero_id=u.tercero_id) AS desarrollador  FROM actividad_programada ap WHERE ap.estado = 2 $consul_fecha_inicio $consul_fecha_final $consul_usuario_id ORDER BY `desarrollador` DESC"; 

		$data      = $this -> DbFetchAll($select,$Conex,true);

		return  $data;

	}       

}

?>