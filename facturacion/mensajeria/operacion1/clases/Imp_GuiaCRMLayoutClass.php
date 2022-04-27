<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_GuiaCRMLayout extends View{    
   public function setGuia($Guia,$usuario){
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Imp_Guia.css");      
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Imp_Guia.css","print");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-barcode-2.0.2.js");	           
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/Imp_Guia.js");	    	 
     $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("USUARIO",$usuario);	 		 
	 $Guia[0]['fecha_guia'] = $this -> mesNumericoAtexto( $Guia[0]['fecha_guia'], 'l');								
     $this -> assign("DATOSGUIA",$Guia); 
     $this -> assign("TOTALGUIA",count($Guia));	 	       
   }
   
   public function setOficinas($oficinas){
     $this -> assign("OFICINAS",$oficinas); 	    
   }
  
   public function RenderMain(){  
	  $formato = trim($_REQUEST['formato']);	  
	  if($formato == 'NO'){
        $this -> exportToPdf('Imp_Guiavelotax.tpl',rand());	  		
	  }else{
          $this -> renderLayout('Imp_GuiaCRM.tpl',rand());	  
	    }
    }
}

?>