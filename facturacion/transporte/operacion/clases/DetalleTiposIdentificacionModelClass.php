<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleTiposIdentificacionModel extends Db{


  public function getTiposIdentificacion($Conex){
  
     $select = "SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion  ORDER BY nombre ASC";
     
     $result = $this -> DbFetchAll($select,$Conex,true);
     
     return $result;	  
  
  }
  
  public function getDetallesTiposIdentificacion($cliente_id,$Conex){
    	
	  $select  = "SELECT * FROM tipo_identificacion_cliente WHERE cliente_id = $cliente_id ORDER BY nombre ASC";	
	  $result = $this -> DbFetchAll($select,$Conex,true);    
	  
	  if(count($result) == 0){
	  
	   $this -> Begin($Conex);
	  
	     $select = "SELECT * FROM tipo_identificacion ORDER BY nombre";
         $result = $this -> DbFetchAll($select,$Conex,true);
		 
         $tipo_identificacion_cliente_id = $this -> DbgetMaxConsecutive("tipo_identificacion_cliente",
		 "tipo_identificacion_cliente_id",$Conex,false,1);
					       	 
		 for($i = 0; $i < count($result); $i++){
		 
		   $tipo_identificacion_id = $result[$i]['tipo_identificacion_id'];
		   $nombre                 = $result[$i]['nombre'];
		   
		   $insert = "INSERT INTO tipo_identificacion_cliente 
		   (tipo_identificacion_cliente_id,cliente_id,nombre,tipo_identificacion_id) VALUES 
		   ($tipo_identificacion_cliente_id,$cliente_id,'$nombre',$tipo_identificacion_id)";
		 
		   $this -> query($insert,$Conex);
		 
		   $tipo_identificacion_cliente_id++;
		 }
		 
		 $this -> Commit($Conex);
	  
    	 $select  = "SELECT * FROM tipo_identificacion_cliente WHERE cliente_id = $cliente_id ORDER BY nombre ASC";	
	     $result = $this -> DbFetchAll($select,$Conex,true);  	  
	  
	  }
	  
	  return $result;
  }
  
  public function saveDetalleTiposIdentificacion($cliente_id,$camposArchivo,$Conex){
  
     $this -> Begin($Conex);
     
          
       for($i = 1; $i <= count($camposArchivo); $i++){
       
         $tipo_identificacion_cliente_id   = $camposArchivo[$i]['tipo_identificacion_cliente_id'];
         $tipos_identificacion_cliente_id .= "$tipo_identificacion_cliente_id,";         
         $nombre                           = $camposArchivo[$i]['nombre'];
         $tipo_identificacion_id           = $camposArchivo[$i]['tipo_identificacion_id'];
         
         $update = "UPDATE tipo_identificacion_cliente SET nombre = '$nombre',tipo_identificacion_id = $tipo_identificacion_id 
		 WHERE tipo_identificacion_cliente_id = $tipo_identificacion_cliente_id;";

         $this -> query($update,$Conex,true);

         if($this -> GetNumError() > 0){
           return false;
         }     
       
       }
       
       $tipos_identificacion_cliente_id = substr($tipos_identificacion_cliente_id,0,strlen($tipos_identificacion_cliente_id) - 1);
       
       $delete = "DELETE FROM tipo_identificacion_cliente WHERE cliente_id = $cliente_id AND tipo_identificacion_cliente_id NOT 
	   IN ($tipos_identificacion_cliente_id);";
       
       $this -> query($delete,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }     
     
     
     $this -> Commit($Conex);
  
     return true;
  }
  
   
}

?>