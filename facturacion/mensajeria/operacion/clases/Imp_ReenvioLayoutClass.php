<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ReenvioLayout extends View{
 
   
   public function setReenvio($Reenvio,$usuario){

     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Reexpedido.css");      
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Reexpedido.css","print");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-barcode-2.0.2.js");	           
      
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("FECHA",date("Y-m-d"));
     $this -> assign("USUARIO",$usuario);	 	 
	 
     $this -> assign("DATOSREENVIO",$Reenvio);  
	       
   }

  public function setDetalle($Reenvio,$usuario){
	   $this -> assign("DETALLES",$Reenvio);  
	  
  }
   public function RenderMain(){

      $this -> renderLayout('Imp_Reenvio.tpl');	  
	    	  

   }


}

?>