<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleCamposArchivoClienteModel extends Db{


  public function getCamposSolicitud($Conex){
  
     $select = "SELECT * FROM campos_archivo_solicitud WHERE archivo_solicitud = 1 ORDER BY orden";
     
     $result = $this -> DbFetchAll($select,$Conex,true);
     
     return $result;	  
  
  }
  
  public function getDetallesCamposArchivoCliente($cliente_id,$Conex){
  	
	if(is_numeric($cliente_id)){
	
	  $select  = "SELECT * FROM campos_archivo_cliente WHERE cliente_id = $cliente_id ORDER BY nombre_campo ASC";	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	  
	return $result;
  }
  
 

   
}



?>