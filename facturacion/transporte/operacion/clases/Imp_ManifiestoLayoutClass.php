<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ManifiestoLayout extends View{

   private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Imp_Manifiesto.css");	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
  
   
   public function setManifiesto($manifiesto){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSMANIFIESTO",$manifiesto[0]);       
     $this -> assign("SALDOPAGARLETRAS",strtoupper($this -> num2letras($manifiesto[0]['valor_flete'])));       	 
   }

   public function setRemesas($remesas){   
     $this -> assign("DATOSREMESAS",$remesas);
     $this -> assign("DATOSREMESASANEXO",$remesas);   
     $this -> assign("TOTALREMESAS",(count($remesas) - 3));   	    	 
   }
   
   public function setTrafico($Trafico){
   
     $this -> assign("TRAFICO",$Trafico[0]);
   }
      
   public function setCodigoQR($codigoQR){
   
     $this -> assign("CODIGOQR",$codigoQR);
   }

   public function setDetalles($Detalles){

     $this -> assign("DETALLES",$Detalles);
   }   
   
   public function setHojadeTiempos($hojadetiempos){
	 $this -> assign("HOJADETIEMPOS",$hojadetiempos);
     $this -> assign("HOJADETIEMPOSASANEXO",$hojadetiempos);   
     $this -> assign("TOTALHOJADETIEMPOS",(count($hojadetiempos) - 2));  	 	             
   }

   public function setTiemposCargue($tiemposcargue){
	 $this -> assign("TIEMPOSCARGUE",$tiemposcargue);
     $this -> assign("TIEMPOSCARGUEANEXO",$tiemposcargue);   
     $this -> assign("TOTALTIEMPOSCARGUE",(count($tiemposcargue) - 2));  	 	             
   }

   public function setImpuestos($impuestos){
	 $this -> assign("IMPUESTOS",$impuestos);	       
   }
  
   public function RenderMain(){
   	 
      //$this -> exportToPdf('Imp_ManifiestoCarga.tpl','manifiestoCarga');
	  
      $this -> renderLayout('Imp_ManifiestoCarga.tpl','manifiestoCarga');
   	 
   }


}

?>