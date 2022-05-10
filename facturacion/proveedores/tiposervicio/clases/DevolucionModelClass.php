<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DevolucionModel extends Db{

  private $Permisos;
  
  public function getDevolucion($tipo_bien_servicio_id,$Conex){
	   	
	if(is_numeric($tipo_bien_servicio_id)){
	
	  $select  = "SELECT d.puc_id AS puc_id,
	  				d.devpuc_bien_servicio_id,
	  				(SELECT codigo_puc  FROM puc WHERE puc_id =d.puc_id) AS codigo_puc,  
					(SELECT CONCAT_WS(' - ',codigo_puc,nombre)  FROM puc WHERE puc_id =d.puc_id) AS puc,  
					(SELECT nombre  FROM puc WHERE puc_id =d.puc_id) AS descripcion,  
					d.despuc_bien_servicio,
					d.natu_bien_servicio,
					d.contra_bien_servicio
					FROM devpuc_bien_servicio  d 
					WHERE tipo_bien_servicio_id =$tipo_bien_servicio_id ";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
    
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tipo_bien_servicio_id 	= $this -> requestDataForQuery('tipo_bien_servicio_id','integer');
      $devpuc_bien_servicio_id 	= $this -> DbgetMaxConsecutive("devpuc_bien_servicio","devpuc_bien_servicio_id",$Conex,true,1);
      $puc_id                 	= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio     	= $this -> requestDataForQuery('natu_bien_servicio','alphanum');
      $despuc_bien_servicio    	= $this -> requestDataForQuery('despuc_bien_servicio','alphanum');	  
	  $contra_bien_servicio    	= $this -> requestDataForQuery('contra_bien_servicio','integer');

		$insert = "INSERT INTO devpuc_bien_servicio 
	            (devpuc_bien_servicio_id,tipo_bien_servicio_id,puc_id,despuc_bien_servicio,natu_bien_servicio,contra_bien_servicio) 
	            VALUES  
				($devpuc_bien_servicio_id,$tipo_bien_servicio_id,$puc_id,$despuc_bien_servicio,$natu_bien_servicio,$contra_bien_servicio)";

	
      $this -> query($insert,$Conex);
	
	$this -> Commit($Conex);
	
	return $devpuc_bien_servicio_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $devpuc_bien_servicio_id 	= $this -> requestDataForQuery('devpuc_bien_servicio_id','integer');
      $puc_id                 	= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio       = $this -> requestDataForQuery('natu_bien_servicio','alphanum');
      $despuc_bien_servicio    	= $this -> requestDataForQuery('despuc_bien_servicio','alphanum');
	  $contra_bien_servicio    	= $this -> requestDataForQuery('contra_bien_servicio','integer');
	
      $update = "UPDATE devpuc_bien_servicio SET puc_id = $puc_id, despuc_bien_servicio=$despuc_bien_servicio,natu_bien_servicio = $natu_bien_servicio,contra_bien_servicio = $contra_bien_servicio 
	  WHERE devpuc_bien_servicio_id = $devpuc_bien_servicio_id";
	
      $this -> query($update,$Conex);
	
	$this -> Commit($Conex);

  }

  public function Delete($Campos,$Conex){

    $devpuc_bien_servicio_id = $_REQUEST['devpuc_bien_servicio_id'];
	
    $insert = "DELETE FROM devpuc_bien_servicio WHERE devpuc_bien_servicio_id = $devpuc_bien_servicio_id";
    $this -> query($insert,$Conex);	

  }
  
}



?>