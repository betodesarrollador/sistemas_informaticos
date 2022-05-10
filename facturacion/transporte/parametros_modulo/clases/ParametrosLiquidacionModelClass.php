<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosLiquidacionModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$oficina_id,$Conex){	    
	$this -> DbInsertTable("parametros_liquidacion",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){	
    $this -> DbUpdateTable("parametros_liquidacion",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){  
  	$this -> DbDeleteTable("parametros_liquidacion",$Campos,$Conex,true,false);	
  }	
			 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }			
   
     public function getTiposDocumentoContable($Conex){
	  
	$select = "SELECT tipo_documento_id AS value,CONCAT(codigo,'-',nombre) AS text FROM tipo_de_documento ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }
	  
  
   public function selectParametrosLiquidacion($parametros_liquidacion_id,$Conex){
	   	   	  
	$dataParametros = array();
    				
    $select = "SELECT p.*, (SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.flete_pactado_id) AS flete_pactado,(SELECT CONCAT(codigo_puc,' - ',nombre) 
	FROM puc WHERE puc_id = p.sobre_flete_id) AS sobre_flete,
	(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = p.anticipo_id) AS anticipo, (SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE 
	puc_id = p.saldo_por_pagar_id) AS saldo_por_pagar FROM parametros_liquidacion p WHERE parametros_liquidacion_id = $parametros_liquidacion_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
    return $result; 
		   
   }
   
   public function selectOficinasEmpresa($empresa_id,$oficina_id,$Conex){
   
     $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
   
     return $result;
   
   }
   
   public function getQueryParametrosLiquidacionGrid(){
	   	   
     $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,(SELECT nombre FROM oficina WHERE oficina_id = p.oficina_id) AS oficina,(SELECT nombre FROM tipo_de_documento  WHERE tipo_documento_id = p.tipo_documento_id) AS tipo_documento FROM parametros_liquidacion p ORDER BY tipo_documento";
   
     return $Query;
   }
   

}





?>