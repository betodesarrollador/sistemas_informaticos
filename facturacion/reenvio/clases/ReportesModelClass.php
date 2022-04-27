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
	$opciones=array(0 => array ( 'value' => 'TF', 'text' => 'TODAS FACTURAS' ), 
					1 => array ( 'value' => 'SR', 'text' => 'SIN ACUSE DE RECIBO'), 
					2 => array ( 'value' => 'SA', 'text' => 'SIN APROBACION DIAN'), 
					3 => array ( 'value' => 'CR', 'text' => 'CON ACUSE DE RECIBO'),
					4 => array ( 'value' => 'CA', 'text' => 'CON APROBACION DIAN'));
	return $opciones;
   }

   public function GetSi_Pro($Conex){
	$opciones=array(0 => array ( 'value' => '1', 'text' => 'UNO' ), 1 => array ( 'value' => 'ALL', 'text' => 'TODOS') );
	return $opciones;
   }

}

?>