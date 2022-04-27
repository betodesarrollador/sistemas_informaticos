<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PeriodosUIAFModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
   
    $this -> DbInsertTable("periodo_uiaf",$Campos,$Conex,true,false);
	
  }
	
  public function Update($Campos,$Conex){	

    $this -> DbUpdateTable("periodo_uiaf",$Campos,$Conex,true,false);

  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("periodo_uiaf",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"periodo_uiaf",$Campos);
	 
	 return $Data -> GetData();
   }
   
	 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
     
    public function GetQueryPeriodo(){
	   	   
   $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id 
   = p.empresa_id)) AS empresa,anio,numero,desde,hasta,mostrar,IF(estado = 'P','PENDIENTE','BLOQUEADO') AS estado FROM periodo_uiaf p 
   ORDER BY anio,numero";
   
   return $Query;
   }
   
   
 
}





?>