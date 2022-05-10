<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleUnidadesClienteModel extends Db{


  public function getCamposSolicitud($Conex){
  
     $select = "SELECT campos_archivo_solicitud_id AS value,nombre_campo AS text FROM campos_archivo_solicitud ORDER BY orden";
     
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