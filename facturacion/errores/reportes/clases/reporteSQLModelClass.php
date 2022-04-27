<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteSQLModel extends Db{

	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}    
	


	public function selectInformacion($consul_fecha_inicio,$consul_fecha_final,$consul_usuario_id,$consul_cliente_id,$Conex){


		$select = "SELECT l.query, l.db, l.resultado,(SELECT CONCAT_WS(' ',t.numero_identificacion,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u WHERE u.usuario_id = l.usuario_id AND t.tercero_id=u.tercero_id) AS desarrollador, l.fecha FROM log_registros_sql l WHERE log_registros_sql_id > 0 $consul_fecha_inicio $consul_fecha_final $consul_usuario_id $consul_cliente_id ";

		$data      = $this -> DbFetchAll($select,$Conex,true);

		return  $data;

	}       

}

?>