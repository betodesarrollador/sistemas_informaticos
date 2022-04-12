<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ParametrosExogenaModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosParametrosExogenaId($formato_exogena_id,$Conex){
     $select    = "SELECT f.formato_exogena_id, f.* FROM formato_exogena f WHERE f.formato_exogena_id = $formato_exogena_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;		  
  }  
  
  public function Save($Campos,$Conex){	
      $this -> Begin($Conex);					
	  $formato_exogena_id    = $this -> DbgetMaxConsecutive("formato_exogena","formato_exogena_id",$Conex,true,1);
	
      $this -> assignValRequest('formato_exogena_id',$formato_exogena_id);
      $this -> DbInsertTable("formato_exogena",$Campos,$Conex,true,false);  
	  if(!strlen(trim($this -> GetError())) > 0){
	  	$this -> Commit($Conex);		 
  	  	return $formato_exogena_id;
	  }
  }
  
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("formato_exogena",$Campos,$Conex,true,false);	
  }  
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("formato_exogena",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"formato_exogena",$Campos);
	 return $Data -> GetData();
   }
   public function getQueryParametrosExogenaGrid(){	   	   
     $Query = "SELECT f.resolucion, f.fecha_resolucion, f.ano_gravable, f.tipo_formato, f.version,f.montos_ingresos,f.montos_ingresospj
	 FROM formato_exogena f ORDER BY f.tipo_formato ASC";
     return $Query;	 
   } 
   
}
?>