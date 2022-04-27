<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_GuiaMasivoLayout extends View{ 
   
   public function setGuiaMasivo($Guia,$usuario){

     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_GuiaMasivo.css");      
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Imp_GuiaMasivo.css","print");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-barcode-2.0.2.js");	           
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/Imp_GuiaMasivo.js");	      
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("FECHA",date("Y-m-d"));
     $this -> assign("USUARIO",$usuario);	 	 
	 
     $this -> assign("DATOSGUIA",$Guia); 
	 
	 $numCodBar = str_pad($Guia[0]['numero_guia'],8,"0", STR_PAD_LEFT);
	 
     $this -> assign("GUIACODBAR",$numCodBar); 	 	       
   }
  
   public function RenderMain(){
	  $formato = trim($_REQUEST['formato']);
      $this -> renderLayout('Imp_GuiaMasivo.tpl',rand());	
   }
}

?>