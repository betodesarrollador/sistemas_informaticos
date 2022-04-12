<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class CategoriaExogenaModel extends Db{
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
    $this -> DbInsertTable("categoria_exogena",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("categoria_exogena",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("categoria_exogena",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectCategoriaExogena($Conex){
      $categoria_exogena_id = $this -> requestDataForQuery("categoria_exogena_id","integer");   
      $select   = "SELECT * FROM categoria_exogena WHERE categoria_exogena_id = $categoria_exogena_id";	 
     
      $result   = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryCategoriaExogenaGrid(){
	   	   
     $Query = "SELECT codigo,descripcion,IF(estado = 'I','INACTIVO','ACTIVO') AS estado FROM categoria_exogena ORDER BY codigo ASC";
   
     return $Query;
	 
   }
   
}

?>