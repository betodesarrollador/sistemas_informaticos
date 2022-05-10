<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AnticiposModel extends Db{

  
  public function despachoExiste($despacho,$Conex){
  
     $select = "SELECT * FROM despachos_urbanos WHERE TRIM(despacho) = TRIM('$despacho')";
	 $result = $this -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){
	  return $result[0]['despachos_urbanos_id'];
	 }else{
	      return false;
	   }
  
  
  }  
  
  public function manifiestoTieneAnticipos($manifiesto_id,$Conex){
  
    $select = "SELECT * FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	$result = $this -> DbFetchAll($select,$Conex);
	 
	if(count($result) > 0){
	  return true;
	}else{
	     return false;
	  }  
  
  }
  
  
  public function despachoTieneAnticipos($despachos_urbanos_id,$Conex){
  
    $select = "SELECT * FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
	$result = $this -> DbFetchAll($select,$Conex);
	 
	if(count($result) > 0){
	  return true;
	}else{
	     return false;
	  }    
  
  }
  


}

?>