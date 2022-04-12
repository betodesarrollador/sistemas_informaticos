<?php

require_once("../../../framework/clases/ViewClass.php");

final class ConsolidadoDespachosLayout extends View{
  
   public function SetGridManifiestos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css"); 	 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery-ui-1.8.1.custom.min.js");	 	 
	 
     $this -> assign("GRIDMANIFIESTOS",$TableGrid -> RenderJqGrid());
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());	 
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }   

   public function RenderMain(){   
	 $this ->RenderLayout('ConsolidadoDespachos.tpl');
   }

}

?>