<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ConceptoExogenaModel extends Db{
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
      $this -> DbInsertTable("concepto_exogena",$Campos,$Conex,true,false);
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("concepto_exogena",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("concepto_exogena",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"concepto_exogena",$Campos);
	 
	 return $Data -> GetData();
   }
   
   public function selectConceptoExogena($ConceptoExogenaId,$Conex){
	   
	   $select = "SELECT c.* FROM concepto_exogena c WHERE c.concepto_exogena_id = $ConceptoExogenaId";
	   
	   $result = $this -> DbFetchAll($select,$Conex);
	   
	   return $result;
	   
   }
   
    public function GetQueryEmpresasGrid(){
	   	   
   $Query = "SELECT c.codigo,c.nombre,c.descripcion,(CASE c.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado FROM concepto_exogena c";
   
   return $Query;
   }
   
   
 
}


?>