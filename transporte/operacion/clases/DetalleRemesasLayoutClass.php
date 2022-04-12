<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleRemesasLayout extends View{

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
   
   public function setDetallesRemesas($detallesSolicitudServicio){
   
     $this -> assign("DETALLES",$detallesSolicitudServicio);
   
   }
   
   public function setIncludes($campos){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/generalDetalle.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/detalle_remesas.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	  	  
     $this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
     $this -> assign("REMESAID",$_REQUEST['remesa_id']);
	 
	 $this -> fields = $campos;	 	 

   }
   
   public function SetNaturaleza($Naturaleza){
     $this -> assign("NATURALEZA",$Naturaleza); 
   }
   
   public function SetTipoEmpaque($TipoEmpaque){
     $this -> assign("UNIDADEMPAQUE",$TipoEmpaque); 
   }
   
   public function SetUnidadMedida($UnidadMedida){
     $this -> assign("UNIDADMEDIDA",$UnidadMedida); 
   }   
  
   public function RenderMain(){

        //$this -> enableDebugging();
   
        $this -> RenderLayout('detalleRemesas.tpl');
	 
   }


}


?>