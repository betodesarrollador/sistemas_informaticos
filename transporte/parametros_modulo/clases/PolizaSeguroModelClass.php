<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PolizaSeguroModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("poliza_empresa",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("poliza_empresa",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("poliza_empresa",$Campos,$Conex,true,false);
  }
	 	
  public function getEmpresas($usuario_id,$Conex){
   
    $select = "SELECT 
	 			e.empresa_id AS value,
	 				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				AS text 
				FROM empresa e,tercero t 
	 			WHERE t.tercero_id = e.tercero_id 
				AND e.empresa_id IN 
					(SELECT empresa_id 
					 FROM oficina 
					 WHERE oficina_id IN 
					 	(SELECT oficina_id 
						 FROM opciones_actividad 
						 WHERE usuario_id = $usuario_id)
					)";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
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
  public function getQueryPolizaSeguroGrid(){
	   	   
     $Query ="SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = p.aseguradora_id) AS aseguradora,numero,fecha_expedicion,/*fecha_vigencia,*/fecha_vencimiento,costo_poliza,deducible,valor_maximo_despacho,modelo_minimo_vehiculo,hora_inicio_permitida,hora_final_permitida  FROM poliza_empresa p";
   
     return $Query;
   }
   
}



?>