<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CrearVehiculoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

    public function getTipoVehiculo($Conex){

    $select = "SELECT tipo_vehiculo_id AS value,descripcion AS text FROM tipo_vehiculo ORDER BY descripcion";
    $result = $this -> DbFetchAll($select,$Conex,true); 
    return $result;
  }
  
  public function Save($Campos,$usuario_id,$Conex){

		$fecha_registro = date("Y-m-d H:i:s");
		$fecha_actualiza = date("Y-m-d H:i:s");
		$this->assignValRequest('fecha_registro', $fecha_registro);
		$this->assignValRequest('fecha_actualiza', $fecha_actualiza);
		$this->assignValRequest('usuario_id', $usuario_id);
		$this->assignValRequest('usuario_actualiza_id', $usuario_id);
	  
    $this -> DbInsertTable("wms_vehiculo",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("wms_vehiculo",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("wms_vehiculo",$Campos,$Conex,true,false);
  }

  public function selectVehiculo($Conex){

	  $wms_vehiculo_id = $this -> requestDataForQuery('wms_vehiculo_id','integer');
   
       $select = "SELECT v.*,
	             (SELECT color FROM color WHERE color_id = v.color_id)AS color,
	             (SELECT marca FROM marca WHERE marca_id = v.marca_id)AS marca 
				 FROM wms_vehiculo v WHERE v.wms_vehiculo_id=$wms_vehiculo_id";
	 //echo $select;
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); //echo $select;
	 
	return $result;
  }
	 	
 

//BUSQUEDA


//// GRID ////
  public function getQueryCrearVehiculoGrid(){
	   	   
     $Query ="SELECT 
	         v.wms_vehiculo_id,
             v.placa,
			 v.marca_id,
             (CASE v.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO' END)AS estado,
             v.nombre_conductor,
             v.telefono_conductor,
             v.telefono_ayudante,
             v.tipo_vehiculo_id,
             v.color_id,
             v.soat,
             v.tecnomecanica,
			 (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u 
			  WHERE t.tercero_id = u.tercero_id AND u.usuario_id = v.usuario_id)AS usuario,
			  v.fecha_registro,
			  (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u 
			  WHERE t.tercero_id = u.tercero_id AND u.usuario_id = v.usuario_actualiza_id)AS usuario_actualiza,
			  v.fecha_actualiza
	         FROM wms_vehiculo v";
   
     return $Query;
   }
   
}



?>