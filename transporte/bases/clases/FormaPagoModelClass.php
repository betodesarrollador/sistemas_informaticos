<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AseguradorasModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
    $this -> DbInsertTable("aseguradora",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("aseguradora",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("aseguradora",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectAseguradoras($Conex){
      
      $aseguradora_id = $this -> requestDataForQuery('aseguradora_id','integer');
      $select         = "SELECT * FROM aseguradora WHERE aseguradora_id = $aseguradora_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryAseguradorasGrid(){
	   	   
     $Query = "SELECT nit_aseguradora,digito_verificacion,nombre_aseguradora,IF(estado = 1,'SI','NO') AS estado FROM aseguradora 
	 ORDER BY nombre_aseguradora ASC";
   
     return $Query;
	 
   }
   

}


?>