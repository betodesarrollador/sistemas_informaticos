<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_DevolucionLayout extends View{
 
   
   public function setDevolucion($Devolucion,$usuario){

     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Reexpedido.css");      
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Reexpedido.css","print");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-barcode-2.0.2.js");	           
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/Imp_Devolucion.js");	      
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("FECHA",date("Y-m-d"));
     $this -> assign("USUARIO",$usuario);	 	 
	 
     $this -> assign("DATOSDEVOLUCION",$Devolucion);  
	       
   }

  public function setDetalle($Devolucion,$usuario){
	   $this -> assign("DETALLES",$Devolucion);  
	  
  }
   public function RenderMain(){

      $this -> renderLayout('Imp_Devolucion.tpl');	  
	    	  

   }


}

?>