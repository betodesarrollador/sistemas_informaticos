<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_RemesaLayout extends View{
    
   public function setRemesas($Remesas,$usuario){

     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Remesas.css");      
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Remesas.css","print");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-barcode-2.0.2.js");	           
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/Imp_Remesa.js");	      
	 
     $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("USUARIO",$usuario);	 	
	 
	 $Remesas[0]['fecha_remesa'] = $this -> mesNumericoAtexto( $Remesas[0]['fecha_remesa'], 'l');
								
     $this -> assign("DATOSREMESAS",$Remesas); 
     $this -> assign("TOTALREMESAS",count($Remesas)); 	 
	 	       
   }
   
   public function setOficinas($oficinas){
     $this -> assign("OFICINAS",$oficinas); 	    
   }
  
   public function RenderMain(){
  
	  $formato = trim($_REQUEST['formato']);
	  
	  if($formato == 'NO'){
        $this -> exportToPdf('Imp_Remesavelotax.tpl',rand());	  		
	  }else{
          $this -> renderLayout('Imp_Remesa.tpl',rand());	  
	    }
	  

   }


}

?>