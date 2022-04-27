<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleCamposArchivoTarifasModel extends Db{


  public function getCamposSolicitud($Conex){
  
     $select = "SELECT * FROM campos_archivo_solicitud WHERE archivo_tarifas = 1 ORDER BY orden";
     
     $result = $this -> DbFetchAll($select,$Conex,true);
	      
     return $result;	  
  
  }
  
  public function getDetallesCamposArchivoTarifas($cliente_id,$Conex){
  	
	if(is_numeric($cliente_id)){
	
	  $select  = "SELECT * FROM campos_archivo_tarifas WHERE cliente_id = $cliente_id ORDER BY nombre_campo ASC";	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	  
	return $result;
  }
   
}

?>