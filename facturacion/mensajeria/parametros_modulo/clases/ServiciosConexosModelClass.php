<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ServiciosConexosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("servicio_conexo",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("servicio_conexo",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("servicio_conexo",$Campos,$Conex,true,false);
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
 

//BUSQUEDA
   public function selectServiciosConexos($Conex){
	 
	 $servi_conex_id = $this -> requestDataForQuery('servi_conex_id','integer');
	 
     $Query = "SELECT s.*, o.*, 
	 				(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
					 FROM puc 
					 WHERE puc_id=s.puc_ingreso_id)
				AS puc_ingreso, 
	 				(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
					 FROM puc 
					 WHERE puc_id=s.puc_cxc_id)
				AS puc_cxc,
	 				(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
					 FROM puc 
					 WHERE puc_id=s.puc_costo_id)
				AS puc_costo,
	 				(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
					 FROM puc 
					 WHERE puc_id=s.puc_cxp_id)
				AS puc_cxp
	 			FROM servicio_conexo s, oficina o 
				WHERE s.oficina_id=o.oficina_id
				AND s.servi_conex_id=$servi_conex_id";

     $result =  $this -> DbFetchAll($Query,$Conex);
   
     return $result;
   }


//// GRID ////
  public function getQueryServiciosConexosGrid(){
	   	   
     $Query = "SELECT 
					servi_conex,
						(SELECT o.nombre 
						 FROM oficina o 
						 WHERE s.oficina_id=o.oficina_id) 
					AS agencia,
						(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
						 FROM puc 
						 WHERE puc_id=s.puc_ingreso_id) 
					AS ctaingreso,
						(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
						 FROM puc 
						 WHERE puc_id=s.puc_cxc_id) 
					AS ctacxc,
						(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
						 FROM puc 
						 WHERE puc_id=s.puc_costo_id) 
					AS ctacosto,
						(SELECT CONCAT_WS(' - ',codigo_puc,nombre) 
						 FROM puc 
						 WHERE puc_id=s.puc_cxp_id) 
					AS ctacxp,
					estado
				FROM servicio_conexo s";
   
     return $Query;
   }
   
}



?>