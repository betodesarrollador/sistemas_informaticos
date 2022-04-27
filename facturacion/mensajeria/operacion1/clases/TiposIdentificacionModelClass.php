<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TiposIdentificacionModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
//LISTA MENU

  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'  
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }

   
}



?>