<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class DetallesParametrosLayout extends View{
   private $fields;
     
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function SetBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setDetalles($detalles){   
     $this -> assign("DETALLES",$detalles);   
   }   
   public function setTipo($tipo){   
     $this -> assign("TIPO",$tipo);   
   }   
   public function setCentro($centro){
   
     $this -> assign("CCOSTO",$centro);
   
   }   
   
   public function setIncludes($campos){
    require_once("../../../framework/clases/FormClass.php");
    $Form1 = new Form("DetallesParametrosClass.php","DetallesParametrosForm","DetallesParametrosForm");
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../css/detallesconceptos.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.min.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("../js/detallesparametros.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.hotkeys.js");	 
     
     $this -> fields = $campos;
     
     $this -> assign("FORM1",			  $Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("ARCHIVOSOLICITUD",    $this -> objectsHtml -> GetobjectHtml($this -> fields[archivo_solicitud]));
	   $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	        $this -> TplInclude -> GetJsInclude());
     $this -> assign("formato_exogena_id",	$_REQUEST['formato_exogena_id']);
     $this -> assign("puc_id",	            $_REQUEST['puc_id']);	 
   }
   public function RenderMain(){
        $this -> RenderLayout('detallesparametros.tpl');
   }
}
?>