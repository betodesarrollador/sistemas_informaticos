<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class NovedadRemesaModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("novedad_remesa",$Campos,$Conex,true,false);
	
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("novedad_remesa",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("novedad_remesa",$Campos,$Conex,true,false);
  }
 

//BUSQUEDA


//// GRID ////
  public function getQueryNovedadRemesaGrid(){
	   	   
     $Query = "SELECT 
					novedad_rm,
						(IF(novedad_visible_cliente=1,'SI','NO'))  
					AS cliente,
						(IF(estado=1,'Activo','Inactivo'))  
					AS estado
				FROM novedad_remesa";
   
     return $Query;
   }
   
}



?>