<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DirectoriosApoyoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("apoyo",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("apoyo",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("apoyo",$Campos,$Conex,true,false);
  }
 
  public function GetTipoApoyo($Conex){

		return $this -> DbFetchAll("SELECT tipo_apoyo_id AS value, nombre_apoyo  AS text
								   FROM tipo_apoyo",$Conex,$ErrDb = false);
  }

//BUSQUEDA
  public function selectDirectoriosApoyo($ApoyoId,$Conex){
	return $this -> DbFetchAll("SELECT a.*, u.nombre AS ubicacion 
							   FROM apoyo a, ubicacion u
								WHERE a.ubicacion_id=u.ubicacion_id
								AND a.apoyo_id=$ApoyoId",$Conex,$ErrDb = false);
  }


//// GRID ////
  public function getQueryDirectoriosApoyoGrid(){
	   	   
     $Query = "SELECT a.apoyo_id,
	 			(SELECT nombre_apoyo FROM tipo_apoyo WHERE tipo_apoyo_id=a.tipo_apoyo_id) AS tipo_apoyo,
				u.nombre AS ubicacion,
				a.apoyo,a.contacto_apoyo,
	 			a.tel_apoyo,a.cel_apoyo, a.dir_apoyo,a.placa_apoyo
				FROM apoyo a, ubicacion u
				WHERE a.ubicacion_id=u.ubicacion_id";
   
     return $Query;
   }
   
}



?>