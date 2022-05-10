<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PersonalizadoModel extends Db{
		
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

   public function GetTipo($Conex){
	$opciones=array(0 => array ( 'value' => 'F', 'text' => 'Finalizados' ), 1 => array ( 'value' => 'A', 'text' => 'Anulados'), 2 => array ( 'value' => 'T', 'text' => 'En Transito'), 3 => array ( 'value' => 'ALL', 'text' => 'Todos los estados') );
	return $opciones;
   }


   public function GetTipo_nov($Conex){
	return $this -> DbFetchAll("SELECT 'NULL' AS value,'TODAS LAS NOVEDADES' AS text FROM novedad_seguimiento UNION SELECT novedad_id AS value,novedad AS text FROM novedad_seguimiento",$Conex,
	$ErrDb = false);
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }
}

?>