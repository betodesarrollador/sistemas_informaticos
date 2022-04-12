<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ComercialModel extends Db{

  private $Permisos;
  
  public function getComerciales($tercero_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($tercero_id)){

	  //$select  = "SELECT cl.comercial_id,(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido))as comercial FROM comercial co, cliente cl, tercero te WHERE cl.tercero_id=$tercero_id AND cl.comercial_id=co.comercial_id AND co.tercero_id=te.tercero_id";
	  
	  
	$select  = "SELECT * FROM comerciales_cliente WHERE cliente_id=(SELECT c.cliente_id FROM cliente c WHERE c.tercero_id= $tercero_id)";
	$result = $this -> DbFetchAll($select,$Conex);
	
	if(count($result)>0){
	
		return $result;
	}
	
	$select = "SELECT cl.comercial_id,(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido))as comercial FROM comercial co, cliente cl, tercero te WHERE cl.tercero_id=$tercero_id AND cl.comercial_id=co.comercial_id AND co.tercero_id=te.tercero_id
	";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  if(count($result)>0){
		
		return $result;
	}
	  
	}else{
   	    $result = array();
	 }
	
	
  
  }
  
  public function getComercial($Conex){
  
	
	  $select  = " SELECT co.comercial_id AS value,(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido)) AS text FROM comercial co, tercero te WHERE  te.tercero_id=co.tercero_id ORDER BY comercial_id DESC";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	
	  return $result;
  }
  public function getAgencia($Conex){
  
	
	  $select  = " SELECT oficina_id AS value, nombre AS text FROM oficina ORDER BY nombre ASC";
	  
	  $result = $this -> DbFetchAll($select,$Conex,true);
	
	  return $result;
  }
  
  public function Save($Campos,$Conex){
	
	
	$this -> Begin($Conex);
	
	$tercero_id 				= $this -> requestDataForQuery('tercero_id','integer');
	$comerciales_cliente_id   = $this -> DbgetMaxConsecutive("comerciales_cliente","comerciales_cliente_id",$Conex,true,1);
	$comercial_id     		= $this -> requestDataForQuery('comercial_id','integer');
	$oficina_id         		= $this -> requestDataForQuery('oficina_id','integer');	 
	$porcentaje_fijo         		= $this -> requestDataForQuery('porcentaje_fijo','integer');	  
	$tipo_variable         		= $this -> requestDataForQuery('tipo_variable','integer');
	$tipo_recaudo            	= $this -> requestDataForQuery('tipo_recaudo','integer');
	
	$cli = $this -> DbFetchAll("SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id",$Conex,true);
	$cliente_id   = $cli [0]['cliente_id'];
	
  

     		$insert = "INSERT INTO comerciales_cliente  
	            (comerciales_cliente_id,cliente_id,comercial_id,oficina_id,tipo_recaudo,porcentaje_fijo,tipo_variable) 
	            VALUES  
				($comerciales_cliente_id,$cliente_id,$comercial_id,$oficina_id,'$tipo_recaudo',$porcentaje_fijo,'$tipo_variable')";
		
		
      $this -> query($insert,$Conex);
	  
	  		$update ="UPDATE cliente SET comercial_id= $comercial_id WHERE tercero_id=$tercero_id";
			$this -> query($update,$Conex);
			
	  $this -> Commit($Conex);
	  
	return $comerciales_cliente_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

	$tercero_id 				= $this -> requestDataForQuery('tercero_id','integer');
	$comerciales_cliente_id  	= $this -> requestDataForQuery('comerciales_cliente_id','integer');
	$comercial_id     			= $this -> requestDataForQuery('comercial_id','integer');
	$oficina_id         		= $this -> requestDataForQuery('oficina_id','integer');	  
	$tipo_recaudo            	= $this -> requestDataForQuery('tipo_recaudo','integer');
	$porcentaje_fijo         	= $this -> requestDataForQuery('porcentaje_fijo','integer');
	$tipo_variable         		= $this -> requestDataForQuery('tipo_variable','integer');
	
	
	
	$cli = $this -> DbFetchAll("SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id",$Conex,true);
	$cliente_id   = $cli [0]['cliente_id'];

      $update = "UPDATE comerciales_cliente SET 
	  			comerciales_cliente_id=$comerciales_cliente_id,
				cliente_id=$cliente_id,
				comercial_id=$comercial_id,
				oficina_id=$oficina_id,
				tipo_recaudo='$tipo_recaudo',
				porcentaje_fijo=$porcentaje_fijo,
				tipo_variable='$tipo_variable'
	  				WHERE  comerciales_cliente_id = $comerciales_cliente_id";

    $this -> query($update,$Conex);
	
	$update ="UPDATE cliente SET comercial_id= $comercial_id WHERE tercero_id=$tercero_id";
	
			$this -> query($update,$Conex);
	$this -> Commit($Conex);
	return $comerciales_cliente_id;
  }

  public function Delete($Campos,$Conex){

    $comerciales_cliente_id = $_REQUEST['comerciales_cliente_id'];
	
    $insert = "DELETE FROM comerciales_cliente WHERE comerciales_cliente_id = $comerciales_cliente_id";
	
    $this -> query($insert,$Conex);	

  }

}
?>