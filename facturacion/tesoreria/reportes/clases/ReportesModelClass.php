<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReportesModel extends Db{
		
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
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes' ),1 => array ( 'value' => 'RF', 'text' => 'Relacion Facturas' ), 2 => array ( 'value' => 'EC', 'text' => 'Estado Cartera'), 3 => array ( 'value' => 'PE', 'text' => 'Cartera Por Edades') );
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

}

?>