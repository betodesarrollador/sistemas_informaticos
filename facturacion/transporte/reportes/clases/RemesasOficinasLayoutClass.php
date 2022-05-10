<?php

require_once("../../../framework/clases/ViewClass.php");

final class RemesasOficinasLayout extends View{

 //// GRID ////
  public function SetGridRemesasOficinas($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery){  	
  
	require_once("../../../framework/clases/grid/JqGridClass.php");
	$TableGrid = new JqGrid();
		
	$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery);
	
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	
    $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");	

    $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());	
    $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());	
	$this -> assign("GRIDREMESAS",	$TableGrid -> RenderJqGrid());
	$this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
	$this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());   
	
  }

   public function RenderMain(){
        $this -> RenderLayout('RemesasOficinas.tpl');
   }


}


?>