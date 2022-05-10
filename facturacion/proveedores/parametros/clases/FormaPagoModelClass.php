<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class FormaPagoModel extends Db{

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
    $this -> DbInsertTable("forma_pago",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("forma_pago",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("forma_pago",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectFormaPago($Conex){
      
      $forma_pago_id = $this -> requestDataForQuery('forma_pago_id','integer');
      $select         = "SELECT * FROM forma_pago WHERE forma_pago_id = $forma_pago_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryFormaPagoGrid(){
	   	   
     $Query = "SELECT codigo,nombre,IF(estado = 1,'SI','NO') AS requiere_soporte,IF(estado = 1,'ACTIVA','INACTIVA') AS estado FROM forma_pago ORDER BY nombre ASC";
   
     return $Query;
	 
   }
   

}


?>