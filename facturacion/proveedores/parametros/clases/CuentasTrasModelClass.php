<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CuentasTrasModel extends Db{

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
    $this -> DbInsertTable("cuenta_traslado",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("cuenta_traslado",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("cuenta_traslado",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectCuentasTras($Conex){
      
      $cuenta_traslado_id = $this -> requestDataForQuery('cuenta_traslado_id','integer');
      $select         = "SELECT * FROM cuenta_traslado WHERE cuenta_traslado_id = $cuenta_traslado_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryCuentasTrasGrid(){
	   	   
     $Query = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id=c.puc_id) AS codigo,
	 		  c.descripcion,c.descripcion_corta,
			  (SELECT nombre FROM oficina WHERE oficina_id=c.oficina_id) AS oficina,
			  IF(c.estado = 'A','ACTIVA','INACTIVA') AS estado 
			FROM cuenta_traslado c ORDER BY c.estado, descripcion ASC";
   
     return $Query;
	 
   }
   
	public function getOficina($Conex){
		
		$select = "SELECT oficina_id AS value,nombre AS text FROM oficina ";
		$result = $this -> DbFetchAll($select,$Conex);
		
		return $result;
		
	}

}


?>