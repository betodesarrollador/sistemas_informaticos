<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleReexpedidosLayout extends View{

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
   
   public function setDetallesReexpedido($detalles){   
     $this -> assign("DETALLES",$detalles);   
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/DetalleManifiestos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
	  $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/DetalleReexpedidos.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	  	  
	 $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("DESPACHOID",	$_REQUEST['reexpedido_id']);
//	 $this -> assign("GUIARXP",     $this -> requestData('doc_prov_rxp'));
//	 $this -> assign("VALORRXP",    $this -> requestData('valor_prov_rxp')); 	 
  }

   public function RenderMain(){
   
        $this -> RenderLayout('DetalleReexpedidos.tpl');
	 
   }
}

?>