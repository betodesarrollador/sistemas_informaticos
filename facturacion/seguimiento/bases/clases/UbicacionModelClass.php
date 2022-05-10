<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class UbicacionModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("ubicacion",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("ubicacion",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("ubicacion",$Campos,$Conex,true,false);
  }
 

//BUSQUEDA
  public function selectUbicacion($UbicacionId,$Conex){
	return $this -> DbFetchAll("SELECT u1.ubicacion_id, u1.x, u1.y, u1.nombre, u2.nombre AS depto, u3.nombre AS pais
								FROM ubicacion u1
								LEFT JOIN ubicacion u2 ON u1.ubi_ubicacion_id=u2.ubicacion_id
								LEFT JOIN ubicacion u3 ON u2.ubi_ubicacion_id=u3.ubicacion_id
								WHERE u1.ubicacion_id=$UbicacionId
								AND u1.tipo_ubicacion_id=3"
							   ,$Conex,$ErrDb = false);
  }


//// GRID ////
  public function getQueryUbicacionGrid(){
	   	   
     $Query = "SELECT u1.ubicacion_id, u1.nombre, u2.nombre AS depto, u3.nombre AS pais, u1.x, u1.y
				FROM ubicacion u1
				LEFT JOIN ubicacion u2 ON u1.ubi_ubicacion_id=u2.ubicacion_id
				LEFT JOIN ubicacion u3 ON u2.ubi_ubicacion_id=u3.ubicacion_id
				WHERE u1.tipo_ubicacion_id=3";
   
     return $Query;
   }
   
}



?>