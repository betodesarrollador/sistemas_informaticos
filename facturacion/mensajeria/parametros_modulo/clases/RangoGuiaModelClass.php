<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RangoGuiaModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("rango_guia",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("rango_guia",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("rango_guia",$Campos,$Conex,true,false);
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
		$select = "SELECT MAX(rango_guia_fin) AS rango_guia_fin FROM rango_guia WHERE empresa_id = $empresa_id";
		$result = $this -> DbFetchAll($select,$Conex,false);			
		$result[0]['rango_guia_fin'] += 1;					
	}else{
       $select = "SELECT rango_guia_ini FROM resolucion_habilitacion WHERE empresa_id = $empresa_id";	 
	   $result = $this -> DbFetchAll($select,$Conex,false);	
	  }
	return $result;
  }

  public function validaAgencia($Conex){   
    $oficina_id  = $this -> requestDataForQuery('oficina_id','integer');
    $select = "SELECT rango_guia_id FROM rango_guia WHERE oficina_id=$oficina_id";	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	 
	return count($result) > 0 ? $result[0]['rango_guia_id'] : 0;
  }

//BUSQUEDA
   public function selectRangoGuia($Conex){	 
	 $rango_guia_id = $this -> requestDataForQuery('rango_guia_id','integer');	 
     $Query = "SELECT r.*, (SELECT r.total_rango_guia-r.utilizado_rango_guia) AS saldo_rango_guia FROM rango_guia r WHERE rango_guia_id = $rango_guia_id";
     $result =  $this -> DbFetchAll($Query,$Conex);   
     return $result;
   }

//// GRID ////
  public function getQueryRangoGuiaGrid(){
	   	   
     $Query = "SELECT 
	 		(SELECT t.razon_social FROM oficina o, empresa e, tercero t WHERE r.oficina_id=o.oficina_id AND o.empresa_id=e.empresa_id AND e.tercero_id=t.tercero_id) AS empresa,
			(SELECT o.nombre FROM oficina o WHERE r.oficina_id=o.oficina_id) AS oficina,r.prefijo,
			r.fecha_rango_guia, r.rango_guia_ini, r.rango_guia_fin, r.total_rango_guia,
			r.utilizado_rango_guia, (r.total_rango_guia - r.utilizado_rango_guia) AS saldo_rango_guia, r.estado 
			FROM rango_guia r";   
     return $Query;
   }   
}

?>