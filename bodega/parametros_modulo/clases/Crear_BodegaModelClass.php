<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Crear_BodegaModel extends Db{

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
	  
    $this -> DbInsertTable("wms_bodega",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$usuario_id,$Conex){
	    $fecha_actualiza = date("Y-m-d H:i:s");
		$this->assignValRequest('fecha_actualiza', $fecha_actualiza);
		$this->assignValRequest('usuario_actualiza_id', $usuario_id);
	  
    $this -> DbUpdateTable("wms_bodega",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("wms_bodega",$Campos,$Conex,true,false);
  }
	 	
  public function selectCrearBodega($Conex){

	  $bodega_id = $this -> requestDataForQuery('bodega_id','integer');
   
       $select = "SELECT b.*,
	             REPLACE(REPLACE(REPLACE(FORMAT(b.alto, 2), '.', '@'), ',', '.'), '@', ',') AS alto,
				 REPLACE(REPLACE(REPLACE(FORMAT(b.largo, 2), '.', '@'), ',', '.'), '@', ',') AS largo,
				 REPLACE(REPLACE(REPLACE(FORMAT(b.ancho, 2), '.', '@'), ',', '.'), '@', ',') AS ancho,
				 REPLACE(REPLACE(REPLACE(FORMAT(b.area, 2), '.', '@'), ',', '.'), '@', ',') AS area,
				 REPLACE(REPLACE(REPLACE(FORMAT(b.volumen, 2), '.', '@'), ',', '.'), '@', ',') AS volumen,
	             (SELECT nombre FROM ubicacion WHERE ubicacion_id = b.ubicacion_id)AS ubicacion 
				 FROM wms_bodega b WHERE b.bodega_id=$bodega_id";
	 //echo $select;
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); //echo $select;
	 
	return $result;
  }
	 	
  public function getAseguradora($Conex){
   
    $select = "SELECT 
				aseguradora_id AS value,
				nombre_aseguradora AS text
				FROM aseguradora
				ORDER BY nombre_aseguradora";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
	return $result;
  }
 

//BUSQUEDA


//// GRID ////
  public function getQueryCrear_BodegaGrid(){
	   	   
     $Query ="SELECT 
	         b.bodega_id,
			 b.nombre,
			 b.codigo_bodega,
			 b.latitud,
			 b.longitud,
			 b.area,
			 b.volumen,
			 b.ubicacion_id,
			 (SELECT nombre FROM ubicacion WHERE ubicacion_id = b.ubicacion_id)AS ubicacion,
			 b.direccion,
			 (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u 
			  WHERE t.tercero_id = u.tercero_id AND u.usuario_id = b.usuario_id)AS usuario,
			  b.fecha_registro,
			  (SELECT CONCAT_WS('',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t,usuario u 
			  WHERE t.tercero_id = u.tercero_id AND u.usuario_id = b.usuario_actualiza_id)AS usuario_actualiza,
			  b.fecha_actualiza,
			  (CASE b.estado WHEN 'A' THEN 'ACTIVO' WHEN 'I' THEN 'INACTIVO' END)AS estado
	         FROM wms_bodega b";
   
     return $Query;
   }
   
}



?>