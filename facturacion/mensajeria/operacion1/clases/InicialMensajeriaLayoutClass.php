<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class InicialMensajeriaLayout extends View{

   private $fields;   
   
     public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/MandoTrafico.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css"); 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/InicialMensajeria.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 	
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
	 
   }

//// GRID ////  
  public function SetGridMensajeria($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDMensajeria",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS2",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS2",	$TableGrid -> GetJqGridJs());
   }
      
   public function RenderMain(){   
        $this -> RenderLayout('InicialMensajeria.tpl');	 
   }

}

?>