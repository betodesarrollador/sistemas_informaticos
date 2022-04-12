<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteInformeModel extends Db{

	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}    
	


	public function selectInformacion($fecha_inicio,$fecha_final,$consul_usuario_id,$Conex){

		$novedad = "(SELECT GROUP_CONCAT(n.nombre) FROM novedad_informe_diario n,detalle_novedades_informe d WHERE d.novedad_informe_diario_id = n.novedad_informe_diario_id AND d.informe_id = i.informe_id)";

		$select = "SELECT i.quehicehoy,i.dotomorrow,IF($novedad IS NULL ,i.novedades,$novedad) AS novedades ,i.fecha_registro, i.usuario AS desarrollador  FROM informe_diario i WHERE DATE(i.fecha_registro)>= '$fecha_inicio' AND DATE(i.fecha_registro)<= '$fecha_final' $consul_usuario_id ORDER BY `desarrollador` DESC"; 

		$data      = $this -> DbFetchAll($select,$Conex,true);

		return  $data;

	}       

}

?>