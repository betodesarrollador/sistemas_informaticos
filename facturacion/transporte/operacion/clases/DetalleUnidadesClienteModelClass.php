<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleUnidadesClienteModel extends Db{


  public function getCamposSolicitud($Conex){
  
     $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE tipo_unidad_medida_id = 11 OR ministerio = 1  ORDER BY medida ASC";
     
     $result = $this -> DbFetchAll($select,$Conex,true);
     
     return $result;	  
  
  }
  
  public function getDetallesCamposArchivoCliente($cliente_id,$Conex){
  	
	if(is_numeric($cliente_id)){
	
	  $select  = "SELECT * FROM medida_cliente WHERE cliente_id = $cliente_id ORDER BY medida ASC";	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  if(count($result) == 0){
	  
	    $select = "SELECT * FROM medida WHERE tipo_unidad_medida_id = 11 OR ministerio = 1  ORDER BY medida ASC";
	    $result = $this -> DbFetchAll($select,$Conex,true);
	    
	    $medida_cliente_id = $this -> DbgetMaxConsecutive("medida_cliente","medida_cliente_id",$Conex,false,1);
	    
	    for($i = 0; $i < count($result); $i++){	    
	    
	      $medida_id = $result[$i]['medida_id'];
	          
	      $insert = "INSERT INTO medida_cliente (medida_cliente_id,cliente_id,medida_id,medida) VALUES ($medida_cliente_id,$cliente_id,$medida_id,(SELECT medida FROM medida WHERE medida_id = $medida_id)) ";
	      
             $this -> query($insert,$Conex,true);

             if($this -> GetNumError() > 0){
               return false;
             }	      
	    
	      $medida_cliente_id++;
	    }
	    
	  $select = "SELECT * FROM medida WHERE tipo_unidad_medida_id = 11 OR ministerio = 1  ORDER BY medida ASC";
	  $result = $this -> DbFetchAll($select,$Conex,true);	    
	  
	  }
	  
	}else{
   	    $result = array();
	  }
	  
	return $result;
  }
  
 

   
}



?>