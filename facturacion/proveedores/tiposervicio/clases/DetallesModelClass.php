<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getDetalles($tipo_bien_servicio_id,$Conex){
	   	
	if(is_numeric($tipo_bien_servicio_id)){
	
	  $select  = "SELECT c.puc_id AS puc_id,
	  				c.codpuc_bien_servicio_id,
	  				(SELECT codigo_puc  FROM puc WHERE puc_id =c.puc_id) AS codigo_puc,  
					(SELECT CONCAT_WS(' - ',codigo_puc,nombre)  FROM puc WHERE puc_id =c.puc_id) AS puc,  
					(SELECT nombre  FROM puc WHERE puc_id =c.puc_id) AS descripcion,  
					c.despuc_bien_servicio,
					c.natu_bien_servicio,
					c.contra_bien_servicio
					FROM codpuc_bien_servicio c 
					WHERE tipo_bien_servicio_id =$tipo_bien_servicio_id ";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
   public function selectCuentaPuc($puc_id,$Conex){
	  
	 $select   = "SELECT contrapartida FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex,true);
	 
	 $contrapartida      = $requires[0]['contrapartida']      == 1 ? 'true' : 'false';
	  
	  $requieresCuenta=array(contrapartida=>$contrapartida);
	  
	  return $requieresCuenta;	 
      
	  
  }
    
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tipo_bien_servicio_id 	= $this -> requestDataForQuery('tipo_bien_servicio_id','integer');
      $codpuc_bien_servicio_id 	= $this -> DbgetMaxConsecutive("codpuc_bien_servicio","codpuc_bien_servicio_id",$Conex,true,1);
      $puc_id                 	= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio     	= $this -> requestDataForQuery('natu_bien_servicio','alphanum');
      $despuc_bien_servicio    	= $this -> requestDataForQuery('despuc_bien_servicio','alphanum');	  
	  $contra_bien_servicio    	= $this -> requestDataForQuery('contra_bien_servicio','integer');

		$insert = "INSERT INTO codpuc_bien_servicio 
	            (codpuc_bien_servicio_id ,tipo_bien_servicio_id,puc_id,despuc_bien_servicio,natu_bien_servicio,contra_bien_servicio) 
	            VALUES  
				($codpuc_bien_servicio_id,$tipo_bien_servicio_id,$puc_id,$despuc_bien_servicio,$natu_bien_servicio,$contra_bien_servicio)";

	
      $this -> query($insert,$Conex);
	
	$this -> Commit($Conex);
	
	return $codpuc_bien_servicio_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $codpuc_bien_servicio_id 	= $this -> requestDataForQuery('codpuc_bien_servicio_id','integer');
      $puc_id                 	= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio       = $this -> requestDataForQuery('natu_bien_servicio','alphanum');
      $despuc_bien_servicio    	= $this -> requestDataForQuery('despuc_bien_servicio','alphanum');
	  $contra_bien_servicio    	= $this -> requestDataForQuery('contra_bien_servicio','integer');
	
      $update = "UPDATE codpuc_bien_servicio SET puc_id = $puc_id, despuc_bien_servicio=$despuc_bien_servicio,natu_bien_servicio = $natu_bien_servicio,contra_bien_servicio = $contra_bien_servicio 
	  WHERE codpuc_bien_servicio_id = $codpuc_bien_servicio_id";
	
      $this -> query($update,$Conex);
	
	$this -> Commit($Conex);

  }

  public function Delete($Campos,$Conex){

    $codpuc_bien_servicio_id = $_REQUEST['codpuc_bien_servicio_id'];
	
    $insert = "DELETE FROM codpuc_bien_servicio WHERE codpuc_bien_servicio_id = $codpuc_bien_servicio_id";
    $this -> query($insert,$Conex);	

  }
  
}



?>