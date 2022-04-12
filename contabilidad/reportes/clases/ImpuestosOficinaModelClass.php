<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ImpuestosOficinaModel extends Db{
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
  
    $this -> DbInsertTable("impuesto_oficina",$Campos,$Conex,true,false);
	
  }
	
  public function Update($Campos,$Conex){	
		
    $this -> DbUpdateTable("impuesto_oficina",$Campos,$Conex,true,false);
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("impuesto_oficina",$Campos,$Conex,true,false);
	
  }	
			 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }				
				
  public function getActividadesEconomicas($Conex){
	  
	$select = "SELECT actividad_economica_id AS value,nombre AS text FROM actividad_economica ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }
	
   public function getTiposUbicacion($Conex){
	   
	$select = "SELECT tipo_ubicacion_id AS value,nombre AS text FROM tipo_ubicacion ORDER BY nombre ASC";
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;
	
   }
   
   public function selectImpuestosOficina($impuestoId,$Conex){
	   	   
   $Query = "SELECT io.impuesto_oficina_id,io.empresa_id,io.oficina_id,i.impuesto_id,(SELECT nombre FROM puc WHERE puc_id = i.puc_id) AS puc,i.puc_id,i.nombre,i.descripcion,i.tipo_ubicacion_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = i.ubicacion_id) AS ubicacion,i.ubicacion_id,io.porcentaje,i.formula,i.naturaleza,io.estado,i.actividad_economica_id FROM impuesto i,impuesto_oficina io WHERE io.impuesto_id = i.impuesto_id AND io.impuesto_oficina_id = $impuestoId";
     $result =  $this -> DbFetchAll($Query,$Conex);
   
     return $result;
   }
   
   public function getQueryImpuestosOficinaGrid(){
	   	   
     $Query = "SELECT t.razon_social,o.nombre AS oficina,(SELECT nombre FROM puc WHERE puc_id = i.puc_id) AS puc_id,i.nombre,i.descripcion,(SELECT nombre FROM tipo_ubicacion WHERE tipo_ubicacion_id = i.tipo_ubicacion_id) AS tipo_ubicacion_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = i.ubicacion_id) AS ubicacion_id,i.porcentaje,i.formula,i.naturaleza,io.estado,(SELECT nombre FROM actividad_economica WHERE actividad_economica_id = i.actividad_economica_id) AS actividad_economica_id FROM impuesto i, impuesto_oficina io,empresa e,oficina o,tercero t WHERE i.impuesto_id = io.impuesto_id AND io.empresa_id = e.empresa_id AND e.tercero_id = t.tercero_id AND io.oficina_id = o.oficina_id";
   
     return $Query;
   }
   
}


?>