<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosAnticipoProveedorModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
  
    $this -> DbInsertTable("parametros_anticipo_proveedor",$Campos,$Conex,true,false);
	
  }
	
  public function Update($Campos,$Conex){	
		
    $this -> DbUpdateTable("parametros_anticipo_proveedor",$Campos,$Conex,true,false);

  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("parametros_anticipo_proveedor",$Campos,$Conex,true,false);
	
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
	  
	$select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }
	   
   public function selectParametrosAnticipoProveedor($parametros_anticipo_proveedor_id,$Conex){
	   	   
     $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,(SELECT nombre FROM oficina WHERE oficina_id = p.oficina_id) AS oficina,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = p.tipo_documento_id) AS tipo_documento,(SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS puc,p.* FROM parametros_anticipo_proveedor p WHERE parametros_anticipo_proveedor_id = $parametros_anticipo_proveedor_id";

     $result =  $this -> DbFetchAll($Query,$Conex);
   
     return $result;
   }
   
   public function getQueryParametrosAnticipoProveedorGrid(){
	   	   
     $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,(SELECT nombre FROM oficina WHERE oficina_id = p.oficina_id) AS oficina,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = p.tipo_documento_id) AS tipo_documento,(SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS puc,p.nombre,p.naturaleza FROM parametros_anticipo_proveedor p ORDER BY parametros_anticipo_proveedor_id";
   
     return $Query;
   }
   

}





?>