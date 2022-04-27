<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class ReportesLayout extends View{

   private $fields;
   
   
     public function setIncludes(){

	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");	
 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 	
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
	 
   }



//// GRID ////  
   public function SetGridReportes($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDReportes",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Historial.tpl');
	 
   }


}


?>