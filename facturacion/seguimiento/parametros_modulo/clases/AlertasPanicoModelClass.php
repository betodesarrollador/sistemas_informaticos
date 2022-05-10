<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AlertasPanicoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("alerta_panico",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("alerta_panico",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("alerta_panico",$Campos,$Conex,true,false);
  }
 

//BUSQUEDA


//// GRID ////
  public function getQueryAlertasPanicoGrid(){
	   	   
     $Query = "SELECT alerta_id,alerta_panico,CONCAT('<div style=\"background:',color_alerta_panico,'\">&nbsp;</div>') AS 
	 color_alerta_panico FROM alerta_panico";
   
     return $Query;
   }
   
}



?>