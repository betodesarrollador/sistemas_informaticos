<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class DetalleFormaPagoLayout extends View{
   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setDetallesFormaPago($DetallesFormaPago){   
     $this -> assign("DETALLES",$DetallesFormaPago);   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
	 
	      $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
	 
	 
	 
     $this -> TplInclude -> IncludeJs("../js/DetalleFormaPago.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/colResizable-1.3.min.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORMAPAGOID",$this -> requestData('forma_pago_id'));	 
   }
   public function setBancos($bancos){
      $this -> assign("BANCOS",$bancos);     
   }
   public function RenderMain(){
        //$this -> enableDebugging();
   
        $this -> RenderLayout('DetalleFormaPago.tpl');
	 
   }

}

?>