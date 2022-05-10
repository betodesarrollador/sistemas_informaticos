<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class ReporteSeguimientoProductoLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos) {

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("ReporteSeguimientoProductoClass.php","ReporteSeguimientoProductoForm","ReporteSeguimientoProductoForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/reportes/css/ReporteSeguimientoProductoResult.css");
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/reportes/js/ReporteSeguimientoProducto.js"); 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");		 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqeffects/jquery.magnifier.js");
	   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.filestyle.js");
	 
     $this -> assign("CSSSYSTEM",	       $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		         $Form1 -> FormBegin());
     $this -> assign("FORM1END",	       $Form1 -> FormEnd());
	   $this -> assign("SERIAL",		       $this -> objectsHtml -> GetobjectHtml($this -> fields[serial]));	
	   $this -> assign("NUMSERIAL",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[num_serial]));	
   	 $this -> assign("CODIGO",           $this -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));  
   	 $this -> assign("CODIGOBARRA",      $this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_barra]));  
	 
     $this -> assign("GENERAR",			     $this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	   $this -> assign("GENERAREXCEL",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));	

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU
    
   public function RenderMain(){   
     $this -> RenderLayout('ReporteSeguimientoProducto.tpl');	 
   }
}

?>