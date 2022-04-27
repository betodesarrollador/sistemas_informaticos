<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/ControlerClass.php");

final class ChequerasModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	   
    $this -> DbInsertTable("chequeras",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("chequeras",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){ 
   	$this -> DbDeleteTable("chequeras",$Campos,$Conex,true,false);	
  }	
		
   public function ValidateRow($Conex,$Campos){   
	 require_once("../../../framework/clases/ValidateRowClass.php");		
	 $Data = new ValidateRow($Conex,"chequeras",$Campos);	 
	 return $Data -> GetData();
   }   
     
    public function GetQueryChequerasGrid(){
	   	   
   $Query = "SELECT (SELECT nombre_banco FROM banco WHERE banco_id = m.banco_id) AS banco,IF(m.tipo_cuenta = 'AH','AHORROS','CORRIENTE') AS tipo_cuenta,
   m.referencia,(SELECT codigo_puc FROM puc WHERE puc_id = m.puc_id) AS codigo_cuenta,m.rango_ini,m.rango_fin,IF(m.estado = 0,'INACTIVO','ACTIVO') AS estado
   FROM chequeras m";
   
   return $Query;
   }
   
}

?>