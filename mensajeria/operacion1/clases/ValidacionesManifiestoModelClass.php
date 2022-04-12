<?php

 require_once("../../../framework/clases/DbClass.php");

 class ValidacionesManifiestoModel extends Db{
 
  public function manifiestoExiste($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
 	 $result = $this  -> DbFetchAll($select,$Conex);	  
	 
	 if(count($result) > 0){
	   return true;
	 }else{
	       return false;
	   }
  
  }
  
  public function manifiestoEsOficinaLegalizar($manifiesto_id,$oficina_id,$Conex){
  
    $select                = "SELECT * FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
 	$result                = $this  -> DbFetchAll($select,$Conex);	  	
	$oficina_manifiesto_id = $result[0]['oficina_id'];  
	
	if($oficina_id == $oficina_manifiesto_id){
	  return true;
	}else{	
	    return false;
	  }
  
  } 
  
  public function manifiestoEstaManifestado($manifiesto_id,$Conex){
  
    $select = "SELECT estado FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
 	$result = $this  -> DbFetchAll($select,$Conex);	  
	$estado = $result[0]['estado'];
	
	if($estado == 'M'){
	  return true;
	}else{
	
         switch($estado){
		 
		   case "L": exit("El manifiesto se encuentra liquidado!!!");             break;
		   case "P": exit("El manifiesto se encuentra en elaboracion!!!");        break;
		   case "A": exit("El manifiesto se encuentra Anulado!!!");               break;		   		   
		   default : exit("El manifiesto se encuentra inconsistente : $estado "); break;	   
		 
		 }	
		 		 
		 exit();

	  }   
  
  }
  
  public function esViajeTercerizado($manifiesto_id,$Conex){
  
     $select = "SELECT propio FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
  	 $result = $this  -> DbFetchAll($select,$Conex);	  
	 $propio = $result[0]['propio'];
	 
	 if($propio == '0'){
	   return true;
	 }else{
	     return false;
	   }
	
  } 
  
  public function manifiestoTieneAnticipos($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
				
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 	  
	 return count($result) > 0 ? true : false;  
  
  }
  
  public function anticiposGeneroEgreso($manifiesto_id,$Conex){
    
     $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
				
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
  
  public function manifiestoEstaLegalizado($manifiesto_id,$Conex){
  
    $select = "SELECT * FROM legalizacion_manifiesto WHERE manifiesto_id = $manifiesto_id";
  	$result = $this  -> DbFetchAll($select,$Conex);	  
	 
	if(count($result) > 0){
	   return true;
	}else{
	     return false;
	  }	
  
  }
  
  public function manifiestoEstaLiquidado($manifiesto_id,$Conex){
  
    $select = "SELECT * FROM liquidacion_despacho WHERE manifiesto_id = $manifiesto_id AND fuente_servicio_cod = 'MC' 
	AND estado_liquidacion = 'L'";
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