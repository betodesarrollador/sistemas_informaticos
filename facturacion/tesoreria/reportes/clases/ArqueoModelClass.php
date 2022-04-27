<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ArqueoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
   public function GetOficina($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,
	$ErrDb = false);
   }
   
   public function Get_estado($Conex){
	$opciones=array(0 => array ( 'value' => 'E', 'text' => 'EDICION' ), 1 => array ( 'value' => 'A', 'text' => 'ANULADO' ), 2 => array ( 'value' => 'C', 'text' => 'CERRADO' ), 3 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

}

?>