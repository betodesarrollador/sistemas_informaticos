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
    $this -> DbInsertTable("punto_referencia",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("punto_referencia",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("punto_referencia",$Campos,$Conex,true,false);
  }


//LISTA MENU
  public function GetEstadoPuesto($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'ACTIVO' ), 1 => array ( 'value' => '0', 'text' => 'INACTIVO' ) );
	return  $opciones;
  }

  public function GetClasificacion($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'PUNTO FISICO' ), 1 => array ( 'value' => '2', 'text' => 'PUNTO VIRTUAL' ), 2 => array ( 'value' => '3', 'text' => 'PUNTO REFERENCIA' ) );
	return  $opciones;
  }

  public function GetTipoPunto($Conex){

		return $this -> DbFetchAll("SELECT tipo_punto_referencia_id AS value, nombre  AS text
								   FROM tipo_punto_referencia",$Conex,$ErrDb = false);
  }


  public function getComprobarNombre($nombre,$Conex){

     $select = "SELECT punto_referencia_id
	 			FROM punto_referencia  
				WHERE nombre = '$nombre' ";

     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  

  public function getComprobarCoordenadas($x,$y,$Conex){

     $select = "SELECT punto_referencia_id
	 			FROM punto_referencia  
				WHERE x = '$x' AND y='$y' ";

     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  


//BUSQUEDA
  public function selectPuestoControl($PuestoId,$Conex){
  
    $select = "SELECT pc.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = pc.ubicacion_id) AS ubicacion FROM 
	           punto_referencia pc WHERE pc.punto_referencia_id=$PuestoId";
  
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
							   
  }


//// GRID ////
  public function getQueryPuestosControlGrid(){
	   	   
     $Query = "SELECT pc.punto_referencia_id,pc.nombre,(SELECT nombre FROM ubicacion WHERE ubicacion_id = pc.ubicacion_id) 
	           AS ubicacion,(SELECT nombre FROM  tipo_punto_referencia WHERE tipo_punto_referencia_id=pc.tipo_punto_referencia_id) 
			   AS tipo,pc.clasificacion,CASE pc.tipo_punto WHEN 1 THEN 'FISICO' WHEN 2 THEN 'VIRTUAL' ELSE 'REFERENCIA' END 
			   AS tipopunto,pc.contacto,pc.direccion,pc.movil,pc.avantel,pc.correo,pc.x,pc.y,IF(pc.estado=1,'ACTIVO','INACTIVO') 
			   AS estado FROM punto_referencia pc";

   
     return $Query;
	 
   }
   
}



?>