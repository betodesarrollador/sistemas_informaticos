<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_RemesaMasivoLayout extends View{
 
   
   public function setRemesasMasivo($Remesas,$usuario){

     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Imp_RemesasMasivo.css");      
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Imp_RemesasMasivo.css","print");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-barcode-2.0.2.js");	           
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/Imp_RemesaMasivo.js");	      
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("FECHA",date("Y-m-d"));
     $this -> assign("USUARIO",$usuario);	 	 
	 
     $this -> assign("DATOSREMESAS",$Remesas); 
	 
	 $numCodBar = str_pad($Remesas[0]['numero_remesa'],8,"0", STR_PAD_LEFT);
	 
     $this -> assign("REMESACODBAR",$numCodBar); 	 
	       
   }

  
   public function RenderMain(){

	  $formato = trim($_REQUEST['formato']);
	  

      $this -> renderLayout('Imp_RemesaMasivo.tpl',rand());	  
	    	  

   }


}

?>