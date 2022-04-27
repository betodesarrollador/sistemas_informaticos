<?php

 require_once("../../../framework/clases/DbClass.php");

 class ValidacionesDespachoModel extends Db{

	 public function despachoExiste($despachos_urbanos_id,$Conex){
	  
		 $select = "SELECT * FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
		 $result = $this  -> DbFetchAll($select,$Conex);	  
		 
		 if(count($result) > 0){
		   return true;
		 }else{
			   return false;
		   }
	  
	  }
	  
	  public function despachoEsOficinaLegalizar($despachos_urbanos_id,$oficina_id,$Conex){
	  
		$select                = "SELECT * FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
		$result                = $this  -> DbFetchAll($select,$Conex);	  	
		$oficina_manifiesto_id = $result[0]['oficina_id'];  
		
		if($oficina_id == $oficina_manifiesto_id){
		  return true;
		}else{	
			return false;
		  }
	  
	  } 
	  
	  public function despachoEstaManifestado($despachos_urbanos_id,$Conex){
	  
		$select = "SELECT estado FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
		$result = $this  -> DbFetchAll($select,$Conex);	  
		$estado = $result[0]['estado'];
		
		if($estado == 'M'){
		  return true;
		}else{
	
         switch($estado){
		 
		   case "L": exit("El despacho se encuentra liquidado!!!");             break;
		   case "P": exit("El despacho se encuentra en elaboracion!!!");        break;
		   case "A": exit("El despacho se encuentra Anulado!!!");               break;		   		   
		   default : exit("El despacho se encuentra inconsistente : $estado "); break;
		 
		 }	
		 		 
		 exit();

	  }  
	  
	  }
	  
	  public function esDespachoTercerizado($despachos_urbanos_id,$Conex){
	  
		 $select = "SELECT propio FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
		 $result = $this  -> DbFetchAll($select,$Conex);	  
		 $propio = $result[0]['propio'];
		 
		 if($propio == '0'){
		   return true;
		 }else{
			 return false;
		   }
		
	  }
	  
	  public function despachoEstaLegalizado($despachos_urbanos_id,$Conex){
	  
		$select = "SELECT * FROM legalizacion_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
		$result = $this  -> DbFetchAll($select,$Conex);	  
		 
		if(count($result) > 0){
		   return true;
		}else{
			 return false;
		  }	
	  
	  }
	  
  public function despachoTieneAnticipos($despachos_urbanos_id,$Conex){
  
     $select = "SELECT * FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
				
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 	  
	 return count($result) > 0 ? true : false;  
  
  }	  
	  
  public function anticiposGeneroEgreso($despachos_urbanos_id,$Conex){
    
     $select = "SELECT * FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
				
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
  
  public function existeLiquidacionDespachos($despachos_urbanos_id,$Conex){
  
     $select = "SELECT * FROM liquidacion_despacho WHERE fuente_servicio_cod = 'DU' AND despachos_urbanos_id = $despachos_urbanos_id  AND estado_liquidacion!='A'";
     $result = $this  -> DbFetchAll($select,$Conex,true);	    
	 
	 if(count($result) > 0){
	   return true;
	 }else{
	     return false;
	   }
  
  }   	  
  
 }