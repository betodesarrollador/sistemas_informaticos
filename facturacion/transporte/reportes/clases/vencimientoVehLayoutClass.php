<?php
require_once("../../../framework/clases/ViewClass.php");

final class vencimientoVehLayout extends View{

  
  private $fields;
  
  
  public function setIncludes(){

  
    $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
    $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
    $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
    $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		   
    
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");	 	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/reportes/js/vencimientoVeh.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	   
	 
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());

   }
	
	//// GRID ////  
   public function SetGridVencimiento($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
     $TableGrid = new JqGrid();
     $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDVENCIMIENTO",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
    }
    
    
    public function RenderMain(){
      
        $this -> RenderLayout('vencimientoVeh.tpl');
	 
   }


}


?>