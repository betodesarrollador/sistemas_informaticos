<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleUnidadesVolumenClienteLayout extends View{

  
   public function setCamposSolicitud($campos){
      $this -> assign("CAMPOSSOLICITUD",$campos);     
   }
   
   
   public function setDetallesCamposArchivoCliente($setallesCamposArchivoCliente){   
     $this -> assign("DETALLES",$setallesCamposArchivoCliente);   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/DetalleUnidadesVolumenCliente.css");     
     
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/DetalleUnidadesVolumenCliente.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());

   }

   public function RenderMain(){

        //$this -> enableDebugging();
   
        $this -> RenderLayout('DetalleUnidadesVolumenCliente.tpl');
	 
   }


}


?>