<?php
require_once("../../../framework/clases/ViewClass.php");  

final class InicialManifiestosLayout extends View{

   private $fields;   
   
     public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/MandoTrafico.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css"); 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	   $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/InicialManifiestos.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 	
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
	 
   }

//// GRID ////  
  public function SetGridManifiestos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDManifiestos",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS2",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS2",	$TableGrid -> GetJqGridJs());
   }
   
 public function SetGridManifiestos1($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDManifiestos1",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS1",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS1",	$TableGrid -> GetJqGridJs());
   } 

    public function SetGridVencimientoManipulacionAlimentos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDVencimientoManipulacionAlimentos",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS6",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS6",	$TableGrid -> GetJqGridJs());
   }
   
   public function RenderMain(){   
        $this -> RenderLayout('InicialManifiestos.tpl');	 
   }

}

?>