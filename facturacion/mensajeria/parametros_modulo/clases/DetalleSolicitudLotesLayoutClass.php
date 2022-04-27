<?php

require_once("../../../framework/clases/ViewClass.php");

final class DetalleSolicitudLotesLayout extends View{

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
   
   public function setDetalleSolicitudLotes($detalles){
     $this -> assign("DETALLE",$detalles);
   }
   
   public function setAutoSugerente($autoSugerente){
     $this -> assign("AUTOSUGERENTE",$autoSugerente);
   }
   
   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/parametros_modulo/css/DetalleSolicitudLotes.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.autocomplete.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.autocomplete.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/parametros_modulo/js/DetalleSolicitudLotes.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("CAMPOID",			$_REQUEST['campo_archivo_solicitud_id']);

   }

   public function RenderMain(){
     $this -> RenderLayout('DetalleSolicitudLotes.tpl');	 
   }


}

?>