<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/ControlerClass.php");

final class TopeModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	   
    $this -> DbInsertTable("tope_reembolso",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("tope_reembolso",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){ 
   	$this -> DbDeleteTable("tope_reembolso",$Campos,$Conex,true,false);	
  }	
		
   public function ValidateRow($Conex,$Campos){   
	 require_once("../../../framework/clases/ValidateRowClass.php");		
	 $Data = new ValidateRow($Conex,"tope_reembolso",$Campos);	 
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
     
    public function GetQueryTopeGrid(){
	   	   
   $Query = "SELECT (SELECT nombre FROM oficina WHERE oficina_id = m.oficina_id) AS oficina,
   p.anio,m.valor,m.porcentaje,fecha_inicio,fecha_final,
   IF(m.estado = 0,'BLOQUEADO','DISPONIBLE') AS estado
   FROM tope_reembolso m, periodo_contable p WHERE m.periodo_contable_id = p.periodo_contable_id";
   
   return $Query;
   }
   
}

?>