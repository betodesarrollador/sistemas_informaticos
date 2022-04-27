<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_DespachoLayout extends View{

   private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/bases/css/Imp_Manifiesto.css");	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
  
   
   public function setDespacho($despacho){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSMANIFIESTO",$despacho[0]);       
     $this -> assign("SALDOPAGARLETRAS",strtoupper($this -> num2letras($despacho[0]['valor_flete'])));       	 
   }

   public function setRemesas($remesas){   
     $this -> assign("DATOSREMESAS",$remesas);
     $this -> assign("DATOSREMESASANEXO",$remesas);   
     $this -> assign("TOTALREMESAS",(count($remesas) - 3));   	    	 
   }
      
   public function setImpuestos($impuestos){
	 $this -> assign("IMPUESTOS",$impuestos);	       
   }
  
   public function RenderMain(){
   	 
      //$this -> exportToPdf('Imp_Despacho.tpl','despachoUrbano');
	  
       $this -> renderLayout('Imp_Despacho.tpl','despachoUrbano');
   	 
   }


}

?>