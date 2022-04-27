<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/ControlerClass.php");

final class TipoDineroModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	   
    $this -> DbInsertTable("tipo_dinero",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("tipo_dinero",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){ 
   	$this -> DbDeleteTable("tipo_dinero",$Campos,$Conex,true,false);	
  }	
		
   public function ValidateRow($Conex,$Campos){   
	 require_once("../../../framework/clases/ValidateRowClass.php");		
	 $Data = new ValidateRow($Conex,"tipo_dinero",$Campos);	 
	 return $Data -> GetData();
   }   
     
    public function GetQueryTipoDineroGrid(){
	   	   
   $Query = "SELECT IF(m.tipo = 'B','BILLETE','MONEDA') AS tipo,
   m.nombre_dinero,m.valor_dinero,IF(m.estado_dinero = 'I','INACTIVO','ACTIVO') AS estado_dinero
   FROM tipo_dinero m";
   
   return $Query;
   }
   
}

?>