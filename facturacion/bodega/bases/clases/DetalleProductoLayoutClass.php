<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleProductoLayout extends View{

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
   
   public function setDetallesSalarios($DetallesSalarios){   
     $this -> assign("DETALLES",$DetallesSalarios);   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery-ui2.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery-ui.css");
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");
	   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/bases/js/DetalleProducto.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/colResizable-1.3.min.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery-ui.js");

	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
     $this -> assign("PRODUCTOID",$this -> requestData('producto_id'));	 

   }

   public function RenderMain(){

        //$this -> enableDebugging();
   
        $this -> RenderLayout('DetalleProducto.tpl');
	 
   }


}


?>