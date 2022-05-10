<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DevolucionModel extends Db{

  private $Permisos;
  
  public function getDevolucion($tipo_bien_servicio_factura_id,$Conex){
	   	
	if(is_numeric($tipo_bien_servicio_factura_id)){
	
	  $select  = "SELECT d.puc_id AS puc_id,
	  				d.devpuc_bien_servicio_factura_id,
	  				(SELECT codigo_puc  FROM puc WHERE puc_id =d.puc_id) AS codigo_puc,  
					(SELECT CONCAT_WS(' - ',codigo_puc,nombre)  FROM puc WHERE puc_id =d.puc_id) AS puc,  
					(SELECT nombre  FROM puc WHERE puc_id =d.puc_id) AS descripcion,  
					d.despuc_bien_servicio_factura,
					d.natu_bien_servicio_factura,
					d.contra_bien_servicio_factura,
					d.tercero_bien_servicio_factura,
					d.ret_tercero_bien_servicio_factura,
					d.reteica_bien_servicio_factura,
					d.aplica_ingreso,
					d.aplica_tenedor,
					d.activo
					FROM devpuc_bien_servicio_factura  d 
					WHERE tipo_bien_servicio_factura_id =$tipo_bien_servicio_factura_id ORDER BY  d.contra_bien_servicio_factura ASC ";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
    
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tipo_bien_servicio_factura_id 	= $this -> requestDataForQuery('tipo_bien_servicio_factura_id','integer');
      $devpuc_bien_servicio_factura_id 	= $this -> DbgetMaxConsecutive("devpuc_bien_servicio_factura","devpuc_bien_servicio_factura_id",$Conex,true,1);
      $puc_id                 	= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio_factura     	= $this -> requestDataForQuery('natu_bien_servicio_factura','alphanum');
      $despuc_bien_servicio_factura    	= $this -> requestDataForQuery('despuc_bien_servicio_factura','alphanum');	  
	  $contra_bien_servicio_factura    	= $this -> requestDataForQuery('contra_bien_servicio_factura','integer');
      $tercero_bien_servicio_factura   	= $this -> requestDataForQuery('tercero_bien_servicio_factura','integer');
	  $ret_tercero_bien_servicio_factura= $this -> requestDataForQuery('ret_tercero_bien_servicio_factura','integer');
	  $reteica_bien_servicio_factura	= $this -> requestDataForQuery('reteica_bien_servicio_factura','integer');
	  $aplica_ingreso	= $this -> requestDataForQuery('aplica_ingreso','integer');
	  $aplica_tenedor	= $this -> requestDataForQuery('aplica_tenedor','integer');

		$insert = "INSERT INTO devpuc_bien_servicio_factura 
	            (devpuc_bien_servicio_factura_id,tipo_bien_servicio_factura_id,puc_id,despuc_bien_servicio_factura,natu_bien_servicio_factura,contra_bien_servicio_factura,tercero_bien_servicio_factura,ret_tercero_bien_servicio_factura,reteica_bien_servicio_factura,aplica_ingreso,aplica_tenedor,activo) 
	            VALUES  
				($devpuc_bien_servicio_factura_id,$tipo_bien_servicio_factura_id,$puc_id,$despuc_bien_servicio_factura,$natu_bien_servicio_factura,$contra_bien_servicio_factura,$tercero_bien_servicio_factura,$ret_tercero_bien_servicio_factura,$reteica_bien_servicio_factura,$aplica_ingreso,$aplica_tenedor,1)";
//echo $insert;
	
      $this -> query($insert,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $devpuc_bien_servicio_factura_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $devpuc_bien_servicio_factura_id 	= $this -> requestDataForQuery('devpuc_bien_servicio_factura_id','integer');
      $puc_id                 	= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio_factura       = $this -> requestDataForQuery('natu_bien_servicio_factura','alphanum');
      $despuc_bien_servicio_factura    	= $this -> requestDataForQuery('despuc_bien_servicio_factura','alphanum');
	  $contra_bien_servicio_factura    	= $this -> requestDataForQuery('contra_bien_servicio_factura','integer');
	  $tercero_bien_servicio_factura   	= $this -> requestDataForQuery('tercero_bien_servicio_factura','integer');	  
 	  $ret_tercero_bien_servicio_factura= $this -> requestDataForQuery('ret_tercero_bien_servicio_factura','integer');
	  $reteica_bien_servicio_factura	= $this -> requestDataForQuery('reteica_bien_servicio_factura','integer');
	  $aplica_ingreso	= $this -> requestDataForQuery('aplica_ingreso','integer');
	  $aplica_tenedor	= $this -> requestDataForQuery('aplica_tenedor','integer');

       $update = "UPDATE devpuc_bien_servicio_factura SET puc_id = $puc_id, despuc_bien_servicio_factura=$despuc_bien_servicio_factura,
	  natu_bien_servicio_factura = $natu_bien_servicio_factura,contra_bien_servicio_factura = $contra_bien_servicio_factura,tercero_bien_servicio_factura = $tercero_bien_servicio_factura,ret_tercero_bien_servicio_factura=$ret_tercero_bien_servicio_factura, 
	  reteica_bien_servicio_factura=$reteica_bien_servicio_factura , aplica_ingreso=$aplica_ingreso, aplica_tenedor=$aplica_tenedor
	  WHERE devpuc_bien_servicio_factura_id = $devpuc_bien_servicio_factura_id";
	
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);

  }

  public function Delete($Campos,$Conex){

    $devpuc_bien_servicio_factura_id = $_REQUEST['devpuc_bien_servicio_factura_id'];
	
    $insert = "DELETE FROM devpuc_bien_servicio_factura WHERE devpuc_bien_servicio_factura_id = $devpuc_bien_servicio_factura_id";
    $this -> query($insert,$Conex,true);	

  }

  public function activar($Campos,$Conex){

    $devpuc_bien_servicio_factura_id = $_REQUEST['devpuc_bien_servicio_factura_id'];
	
    $insert = "UPDATE devpuc_bien_servicio_factura SET activo=1 WHERE devpuc_bien_servicio_factura_id = $devpuc_bien_servicio_factura_id";
    $this -> query($insert,$Conex,true);	

  }
  
}



?>