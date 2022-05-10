<?php

require_once("../../../framework/clases/ViewClass.php");

final class GuiaToDULayout extends View{
   private $fields;   
   public function setIncludes(){	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/GuiaToDU.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
   }
   
   public function setCampos($campos){	   
     require_once("../../../framework/clases/FormClass.php");	   
  	 $this -> fields = $campos;	 
	 $this -> assign("DESPACHAR", $this -> getObjectHtml($this -> fields[despachar]));
	 $this -> assign("DESPACHOID", $_REQUEST['despachos_urbanos_id']);
   }

//// GRID ////
   public function SetGridGuiaToDU($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDGuiaToDU",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }

   public function RenderMain(){   
        $this -> RenderLayout('GuiaToDU.tpl');
	 }
}

?>