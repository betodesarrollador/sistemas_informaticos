<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicitudLotesModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	
	$campo_archivo_solicitud_id = $this -> DbgetMaxConsecutive("campo_archivo_detalle_solicitud","campo_archivo_solicitud_id",$Conex,false,1);
	
	$this -> assignValRequest('campo_archivo_solicitud_id',$campo_archivo_solicitud_id);
	
    $this -> DbInsertTable("campo_archivo_detalle_solicitud",$Campos,$Conex,true,false);
	
	return array(
				array(campo_archivo_solicitud_id=>$campo_archivo_solicitud_id)
			);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("campo_archivo_detalle_solicitud",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
	$this -> Begin($Conex);
		
		$campo_archivo_solicitud_id  = $this -> requestDataForQuery('campo_archivo_solicitud_id','integer');
		
		$delete = "DELETE FROM relacion_archivo_detalle_solicitud WHERE campo_archivo_solicitud_id=$campo_archivo_solicitud_id; ";
		
		$this -> query($delete,$Conex);
		
		$this -> DbDeleteTable("campo_archivo_detalle_solicitud",$Campos,$Conex,true,false);
		
	$this -> Commit($Conex);
  }


//LISTA MENU 	
  public function getCliente($Conex){
   
    $select = "SELECT 
	 			c.cliente_id AS value,
	 				CONCAT_WS(' ',UPPER(t.primer_nombre),UPPER(t.segundo_nombre),UPPER(t.primer_apellido),UPPER(t.segundo_apellido),UPPER(t.razon_social)) 
				AS text 
				FROM tercero t, cliente c 
	 			WHERE t.tercero_id=c.tercero_id
				AND c.estado_cliente_id=1";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
	return $result;
  }
  
  public function getColSolicitud($Conex){
	return $this -> DbFetchAll("SELECT campo_solicitud_id AS value, etiqueta_columna_det_solicitud AS text FROM campo_detalle_solicitud",$Conex,$ErrDb = false);
  }
	
  
 

//BUSQUEDA
  public function selectSolicitudLotes($Conex){
    
	$campo_archivo_solicitud_id = $this -> requestDataForQuery('campo_archivo_solicitud_id','integer');
	
    $select = "SELECT 
					*
				FROM campo_archivo_detalle_solicitud ca 
				WHERE ca.campo_archivo_solicitud_id=$campo_archivo_solicitud_id";

	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
  


//// GRID ////
  public function getQuerySolicitudLotesGrid(){
	   	   
     $Query = "SELECT 
						CONCAT_WS(' ',UPPER(t.primer_nombre),UPPER(t.segundo_nombre),UPPER(t.primer_apellido),UPPER(t.segundo_apellido),UPPER(t.razon_social)) 
					AS cliente,
					cd.etiqueta_columna_det_solicitud AS etiqueta_columna,
					ca.campo_archivo
				FROM campo_archivo_detalle_solicitud ca, campo_detalle_solicitud cd, cliente c, tercero t 
				WHERE ca.campo_solicitud_id=cd.campo_solicitud_id
				AND ca.cliente_id=c.cliente_id
				AND c.tercero_id=t.tercero_id";
   
     return $Query;
   }
   
}



?>