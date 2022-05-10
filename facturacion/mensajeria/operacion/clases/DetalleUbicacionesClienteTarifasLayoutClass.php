<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleUbicacionesClienteTarifasLayout extends View{

  
   public function setUbicacionesSolicitud($ubicaciones){
      $this -> assign("CAMPOSSOLICITUD",$ubicaciones);     
   }
   
   
   public function setDetallesUbicacionesClienteTarifas($detalleUbicacionesClienteTarifas){      
     $this -> assign("DETALLES",$detalleUbicacionesClienteTarifas);   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/MedidaCliente.css");     
     
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/DetalleUbicacionesClienteTarifas.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());

   }

   public function RenderMain(){
   
       $this -> RenderLayout('DetalleUbicacionesClienteTarifas.tpl');
	 
   }


}


?>