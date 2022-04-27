<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DetalleImpuestosModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){

     	$impuesto_periodo_contable_id  = $this -> DbgetMaxConsecutive("impuesto_periodo_contable","impuesto_periodo_contable_id",$Conex,true,true);
		$periodo_contable_id           = $_REQUEST['periodo_contable_id'];
		$impuesto_id                   = $_REQUEST['impuesto_id'];
		$porcentaje                    = $_REQUEST['porcentaje'];
		$formula                       = $_REQUEST['formula'];
		$monto                         = $_REQUEST['monto'];
		
		$insert = "INSERT INTO impuesto_periodo_contable (impuesto_periodo_contable_id,periodo_contable_id,impuesto_id,porcentaje,formula,monto) 
		VALUES ($impuesto_periodo_contable_id,$periodo_contable_id,$impuesto_id,$porcentaje,'$formula',$monto)";
		
		$result = $this -> query($insert,$Conex);
		
		return $impuesto_periodo_contable_id;

  }
  public function Update($Campos,$Conex){
  
     	$impuesto_periodo_contable_id  = $_REQUEST['impuesto_periodo_contable_id'];
		$periodo_contable_id           = $_REQUEST['periodo_contable_id'];
		$impuesto_id                   = $_REQUEST['impuesto_id'];
		$porcentaje                    = $_REQUEST['porcentaje'];
		$formula                       = $_REQUEST['formula'];
		$monto                         = $_REQUEST['monto'];
		
		$update = "UPDATE impuesto_periodo_contable SET periodo_contable_id = $periodo_contable_id,impuesto_id = $impuesto_id,
		porcentaje = $porcentaje,formula = '$formula',monto = $monto WHERE impuesto_periodo_contable_id = $impuesto_periodo_contable_id";
		
		$result = $this -> query($update,$Conex);
		
  }
  public function Delete($Campos,$Conex){
	 
  	$this -> DbDeleteTable("impuesto_periodo_contable",$Campos,$Conex,true,false);
  
  }
    
  public function getPeriodosContables($Conex){
  
    $select = "SELECT periodo_contable_id AS value,anio AS text FROM periodo_contable ORDER BY anio ASC";
    $result = $this -> DbFetchAll($select,$Conex);
    return $result;	
  
  }
  
  public function getDetallesImpuesto($Conex){
  
	$impuesto_id = $this -> requestDataForQuery('impuesto_id','integer');
	
	if(is_numeric($impuesto_id)){
	
		$select  = "SELECT * FROM  impuesto_periodo_contable WHERE impuesto_id = $impuesto_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>