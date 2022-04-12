<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PuestosControlModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("puesto_control",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("puesto_control",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("puesto_control",$Campos,$Conex,true,false);
  }


//LISTA MENU
  public function GetEstadoPuesto($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'ACTIVO' ), 1 => array ( 'value' => '0', 'text' => 'INACTIVO' ) );
	return  $opciones;
  }
 

//BUSQUEDA
  public function selectPuestoControl($PuestoId,$Conex){
	return $this -> DbFetchAll("SELECT pc.*, u.nombre AS ubicacion 
							   FROM puesto_control pc, ubicacion u
							   WHERE pc.ubicacion_id=u.ubicacion_id
							   AND pc.puesto_control_id=$PuestoId",$Conex,$ErrDb = false);
  }


//// GRID ////
  public function getQueryPuestosControlGrid(){
	   	   
     $Query = "SELECT pc.puesto_control_id,u.nombre AS ubicacion,pc.puesto_control,
	 			pc.responsable_puesto_control,pc.direccion_puesto_control,
				pc.telefono_puesto_control,pc.telefono2_puesto_control,
				pc.movil_puesto_control,pc.movil2_puesto_control,
				pc.email_puesto_control,
				IF(pc.estado_puesto_control=1,'ACTIVO','INACTIVO') AS estado_puesto_control
				FROM puesto_control pc, ubicacion u
				WHERE pc.ubicacion_id=u.ubicacion_id";
   
     return $Query;
   }
   
}



?>