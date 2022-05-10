<?php

 require_once("../../../framework/clases/DbClass.php");

 class ValidacionesOrdenModel extends Db{
 
  public function ordenExiste($seguimiento_id,$Conex){
  
     $select = "SELECT * FROM seguimiento WHERE seguimiento_id = $seguimiento_id";
 	 $result = $this  -> DbFetchAll($select,$Conex);	  
	 
	 if(count($result) > 0){
	   return true;
	 }else{
	       return false;
	   }
  
  }
  
  public function ordenEsOficinaLegalizar($seguimiento_id,$oficina_id,$Conex){
  
    $select                = "SELECT * FROM seguimiento WHERE seguimiento_id = $seguimiento_id";
 	$result                = $this  -> DbFetchAll($select,$Conex);	  	
	$oficina_seguimiento_id = $result[0]['oficina_id'];  
	
	if($oficina_id == $oficina_seguimiento_id){
	  return true;
	}else{	
	    return false;
	  }
  
  } 
  
  public function ordenEstaManifestado($seguimiento_id,$Conex){
  
    $select = "SELECT estado FROM seguimiento WHERE seguimiento_id = $seguimiento_id";
 	$result = $this  -> DbFetchAll($select,$Conex);	  
	$estado = $result[0]['estado'];
	
	if($estado == 'P'){
	  return true;
	}else{
	
         switch($estado){
		 
		   case "L": exit("El orden se encuentra liquidado!!!");             break;
//		   case "P": exit("El orden se encuentra en elaboracion!!!");        break;
		   case "A": exit("El orden se encuentra Anulado!!!");               break;		   		   
		   default : exit("El orden se encuentra inconsistente : $estado "); break;	   
		 
		 }	
		 		 
		 exit();

	  }   
  
  }
  
  public function esViajeTercerizado($seguimiento_id,$Conex){
  
     $select = "SELECT propio FROM seguimiento WHERE seguimiento_id = $seguimiento_id";
  	 $result = $this  -> DbFetchAll($select,$Conex);	  
	 $propio = $result[0]['propio'];
	 
	 if($propio == '0'){
	   return true;
	 }else{
	     return false;
	   }
	
  } 
  
  public function ordenTieneAnticipos($seguimiento_id,$Conex){
  
     $select = "SELECT * FROM anticipos_particular WHERE seguimiento_id = $seguimiento_id";
				
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 	  
	 return count($result) > 0 ? true : false;  
  
  }
  
  public function anticiposGeneroEgreso($seguimiento_id,$Conex){
    
     $select = "SELECT * FROM anticipos_particular WHERE seguimiento_id = $seguimiento_id";
				
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 	 
	 for($i = 0; $i < count($result); $i++){
	 
	  if($result[$i]['valor'] > 0){
	 
	    $encabezado_registro_id = $result[$i]['encabezado_registro_id'];				
	 
	    if(!is_numeric($encabezado_registro_id)){
	      return false;
	    }
	   	  
	   } 
	 
	 }
	 
	 return true;
	 
  }  
  
  public function ordenEstaLegalizado($seguimiento_id,$Conex){
  
    $select = "SELECT * FROM legalizacion_orden WHERE seguimiento_id = $seguimiento_id";
  	$result = $this  -> DbFetchAll($select,$Conex);	  
	 
	if(count($result) > 0){
	   return true;
	}else{
	     return false;
	  }	
  
  }
   
  public function getCentroCostoId($oficina_id,$Conex){
  
     $select = "SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id = $oficina_id";
     $result = $this -> DbFetchAll($select,$Conex);	 	 
	 
	 if(count($result) > 0){
	   return $result[0]['centro_de_costo_id'];
	 }else{
	       return null;
	    }
  
  }
  
    
 
 }

?>