<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParamDetImpresionModel extends Db{

  private $Permisos;
  
  public function getParamDetImpresion($tipo_bien_servicio_factura_id,$Conex){
	   	
	if(is_numeric($tipo_bien_servicio_factura_id)){
	
	  $select  = "SELECT c.puc_id AS puc_id,
	  				c.codpuc_bien_servicio_factura_id,
	  				(SELECT codigo_puc  FROM puc WHERE puc_id =c.puc_id) AS codigo_puc,  
					(SELECT CONCAT_WS(' - ',codigo_puc,nombre)  FROM puc WHERE puc_id =c.puc_id) AS puc,  
					(SELECT nombre  FROM puc WHERE puc_id =c.puc_id) AS descripcion,  
					c.despuc_bien_servicio_factura,
					c.natu_bien_servicio_factura,
					c.contra_bien_servicio_factura,
					c.tercero_bien_servicio_factura,
					c.ret_tercero_bien_servicio_factura,
					c.reteica_bien_servicio_factura,
					c.aplica_ingreso,
					c.activo
					FROM codpuc_bien_servicio_factura  c 
					WHERE tipo_bien_servicio_factura_id =$tipo_bien_servicio_factura_id ORDER BY  c.contra_bien_servicio_factura ASC ";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
  
    
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tipo_bien_servicio_factura_id 	= $this -> requestDataForQuery('tipo_bien_servicio_factura_id','integer');
      $codpuc_bien_servicio_factura_id 	= $this -> DbgetMaxConsecutive("codpuc_bien_servicio_factura","codpuc_bien_servicio_factura_id",$Conex,true,1);
      $puc_id                 			= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio_factura     	= $this -> requestDataForQuery('natu_bien_servicio_factura','alphanum');
      $despuc_bien_servicio_factura    	= $this -> requestDataForQuery('despuc_bien_servicio_factura','alphanum');	  
	  $contra_bien_servicio_factura    	= $this -> requestDataForQuery('contra_bien_servicio_factura','integer');
	  $tercero_bien_servicio_factura   	= $this -> requestDataForQuery('tercero_bien_servicio_factura','integer');
	  $ret_tercero_bien_servicio_factura= $this -> requestDataForQuery('ret_tercero_bien_servicio_factura','integer');
	  $reteica_bien_servicio_factura	= $this -> requestDataForQuery('reteica_bien_servicio_factura','integer');
	  $aplica_ingreso	= $this -> requestDataForQuery('aplica_ingreso','integer');

		$insert = "INSERT INTO codpuc_bien_servicio_factura 
	            (codpuc_bien_servicio_factura_id ,tipo_bien_servicio_factura_id,puc_id,despuc_bien_servicio_factura,natu_bien_servicio_factura,contra_bien_servicio_factura,tercero_bien_servicio_factura,ret_tercero_bien_servicio_factura,reteica_bien_servicio_factura,aplica_ingreso,activo) 
	            VALUES  
				($codpuc_bien_servicio_factura_id,$tipo_bien_servicio_factura_id,$puc_id,$despuc_bien_servicio_factura,$natu_bien_servicio_factura,$contra_bien_servicio_factura,$tercero_bien_servicio_factura,$ret_tercero_bien_servicio_factura,$reteica_bien_servicio_factura,$aplica_ingreso,1)";

	
      $this -> query($insert,$Conex);
	
	$this -> Commit($Conex);
	
	return $codpuc_bien_servicio_factura_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $codpuc_bien_servicio_factura_id 	= $this -> requestDataForQuery('codpuc_bien_servicio_factura_id','integer');
      $puc_id                 			= $this -> requestDataForQuery('puc_id','integer');	  
      $natu_bien_servicio_factura       = $this -> requestDataForQuery('natu_bien_servicio_factura','alphanum');
      $despuc_bien_servicio_factura     = $this -> requestDataForQuery('despuc_bien_servicio_factura','alphanum');
	  $contra_bien_servicio_factura     = $this -> requestDataForQuery('contra_bien_servicio_factura','integer');
	  $tercero_bien_servicio_factura   	= $this -> requestDataForQuery('tercero_bien_servicio_factura','integer');	  
 	  $ret_tercero_bien_servicio_factura= $this -> requestDataForQuery('ret_tercero_bien_servicio_factura','integer');
	  $reteica_bien_servicio_factura	= $this -> requestDataForQuery('reteica_bien_servicio_factura','integer');
	  $aplica_ingreso	= $this -> requestDataForQuery('aplica_ingreso','integer');
	
      $update = "UPDATE codpuc_bien_servicio_factura SET puc_id = $puc_id, despuc_bien_servicio_factura=$despuc_bien_servicio_factura,
	  natu_bien_servicio_factura = $natu_bien_servicio_factura,contra_bien_servicio_factura = $contra_bien_servicio_factura,tercero_bien_servicio_factura = $tercero_bien_servicio_factura,ret_tercero_bien_servicio_factura=$ret_tercero_bien_servicio_factura, 
	  reteica_bien_servicio_factura=$reteica_bien_servicio_factura , aplica_ingreso=$aplica_ingreso
	  WHERE codpuc_bien_servicio_factura_id = $codpuc_bien_servicio_factura_id";
	
      $this -> query($update,$Conex);
	
	$this -> Commit($Conex);

  }

  public function Delete($Campos,$Conex){

    $codpuc_bien_servicio_factura_id = $_REQUEST['codpuc_bien_servicio_factura_id'];
	
    $insert = "UPDATE codpuc_bien_servicio_factura SET activo=0 WHERE codpuc_bien_servicio_factura_id = $codpuc_bien_servicio_factura_id";
    $this -> query($insert,$Conex);	

  }

  public function activar($Campos,$Conex){

    $codpuc_bien_servicio_factura_id = $_REQUEST['codpuc_bien_servicio_factura_id'];
	
    $insert = "UPDATE codpuc_bien_servicio_factura SET activo=1 WHERE codpuc_bien_servicio_factura_id = $codpuc_bien_servicio_factura_id";
    $this -> query($insert,$Conex);	

  }

}



?>