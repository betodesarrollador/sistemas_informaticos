<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CrearCiudadModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
   
    $this -> DbInsertTable("ubicacion",$Campos,$Conex,true,false);
	
  }
	
  public function Update($Campos,$Conex){	

    $this -> DbUpdateTable("ubicacion",$Campos,$Conex,true,false);

  }
			
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"ubicacion",$Campos);
	 
	 return $Data -> GetData();
   }
   
	 	     
    public function GetQueryPeriodo(){
	   	   
   $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id 
   = p.empresa_id)) AS empresa,anio,numero,desde,hasta,mostrar,IF(estado = 'P','PENDIENTE','BLOQUEADO') AS estado FROM periodo_uiaf p 
   ORDER BY anio,numero";
   
   return $Query;
   }
   
   
 
}





?>