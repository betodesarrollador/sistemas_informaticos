<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class estadoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$usuario_id,$Conex){

		$fecha_registro = date("Y-m-d H:i:s");
		$fecha_actualiza = date("Y-m-d H:i:s");
		$this->assignValRequest('fecha_registro', $fecha_registro);
		$this->assignValRequest('fecha_actualiza', $fecha_actualiza);
		$this->assignValRequest('usuario_id', $usuario_id);
		$this->assignValRequest('usuario_actualiza_id', $usuario_id);
	  
    $this -> DbInsertTable("wms_estado_producto",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("wms_estado_producto",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("wms_estado_producto",$Campos,$Conex,true,false);
  }
	 	
 

//BUSQUEDA


//// GRID ////
  public function getQueryestadoGrid(){
	   	   
     $Query ="SELECT 
	         e.estado_producto_id,
			 e.nombre,
			 e.codigo,
			 e.descripcion,
			 (CASE e.estado WHEN 'A' THEN 'ACTIVO' END)AS estado,
			 (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u 
			  WHERE t.tercero_id = u.tercero_id AND u.usuario_id = e.usuario_id)AS usuario,
			  e.fecha_registro,
			  (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u 
			  WHERE t.tercero_id = u.tercero_id AND u.usuario_id = e.usuario_actualiza_id)AS usuario_actualiza,
			  e.fecha_actualiza
	         FROM wms_estado_producto e";
   
     return $Query;
   }
   
}



?>