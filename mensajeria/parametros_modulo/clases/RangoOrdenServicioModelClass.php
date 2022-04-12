<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RangoOrdenServicioModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("rango_orden_servicio",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("rango_orden_servicio",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("rango_orden_servicio",$Campos,$Conex,true,false);
  }
	 	
  public function getEmpresas($usuario_id,$Conex){
   
    $select = "SELECT 
	 			e.empresa_id AS value,
	 				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				AS text 
				FROM empresa e,tercero t 
	 			WHERE t.tercero_id = e.tercero_id 
				AND e.empresa_id IN 
					(SELECT empresa_id 
					 FROM oficina 
					 WHERE oficina_id IN 
					 	(SELECT oficina_id 
						 FROM opciones_actividad 
						 WHERE usuario_id = $usuario_id)
					)";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
	return $result;
  }
  
  /*se optiene el disponible inicial del rango de manifiestos*/
  public function getDisponibleRes($Conex){   
    $empresa_id = $this -> requestDataForQuery('empresa_id','integer');	
    $select     = "SELECT * FROM resolucion_habilitacion WHERE empresa_id = $empresa_id"; 				   
	$result     = $this -> DbFetchAll($select,$Conex,false);	
	if(count($result) > 0){		
		$select = "SELECT MAX(rango_orden_servicio_fin) AS rango_orden_servicio_fin FROM rango_orden_servicio WHERE empresa_id = $empresa_id";
		$result = $this -> DbFetchAll($select,$Conex,false);			
		$result[0]['rango_orden_servicio_fin'] += 1;					
	}else{
       $select = "SELECT rango_orden_servicio_ini FROM resolucion_habilitacion WHERE empresa_id = $empresa_id";	 
	   $result = $this -> DbFetchAll($select,$Conex,false);	
	  }
	return $result;
  }

  public function validaAgencia($Conex){   
    $oficina_id  = $this -> requestDataForQuery('oficina_id','integer');
    $select = "SELECT rango_orden_servicio_id FROM rango_orden_servicio WHERE oficina_id=$oficina_id";	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	 
	return count($result) > 0 ? $result[0]['rango_orden_servicio_id'] : 0;
  }

//BUSQUEDA
   public function selectRangoOrdenServicio($Conex){	 
	 $rango_orden_servicio_id = $this -> requestDataForQuery('rango_orden_servicio_id','integer');	 
     $Query = "SELECT r.*, (SELECT r.total_rango_orden_servicio-r.utilizado_rango_orden_servicio) AS saldo_rango_orden_servicio FROM rango_orden_servicio r WHERE rango_orden_servicio_id = $rango_orden_servicio_id";
     $result =  $this -> DbFetchAll($Query,$Conex);   
     return $result;
   }

//// GRID ////
  public function getQueryRangoOrdenServicioGrid(){
	   	   
     $Query = "SELECT 
	 		(SELECT t.razon_social FROM oficina o, empresa e, tercero t WHERE r.oficina_id=o.oficina_id AND o.empresa_id=e.empresa_id AND e.tercero_id=t.tercero_id) AS empresa,
			(SELECT o.nombre FROM oficina o WHERE r.oficina_id=o.oficina_id) AS oficina,
			r.fecha_rango_orden_servicio, r.rango_orden_servicio_ini, r.rango_orden_servicio_fin, r.total_rango_orden_servicio,
			r.utilizado_rango_orden_servicio, (r.total_rango_orden_servicio - r.utilizado_rango_orden_servicio) AS saldo_rango_orden_servicio, r.estado 
			FROM rango_orden_servicio r";   
     return $Query;
   }   
}

?>