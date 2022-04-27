<?php



require_once("../../../framework/clases/ViewClass.php"); 



final class MovimientosContablesAnuladosLayout extends View{



   private $fields;

     

     

   

   public function setIncludes(){

	 

     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");

     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");

     $this -> TplInclude -> IncludeCss("../../../seguimiento/seguimiento_monitoreo/css/seguimiento_transito.css");

	 

     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");

     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");

     $this -> TplInclude -> IncludeJs("../../../seguimiento/seguimiento_monitoreo/js/MovimientosContablesAnulados.js");	 

	  	  

	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());

     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());



   }





//// GRID ////  

   public function SetGridMovimientosContablesAnulados($Attributes,$Titles,$Cols,$Query){

     require_once("../../../framework/clases/grid/JqGridClass.php");

	 $TableGrid = new JqGrid();

 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);

     $this -> assign("GRIDSeguimiento",	$TableGrid -> RenderJqGrid());

     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());

     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());

   }



   public function RenderMain(){

   

        $this -> RenderLayout('movimientoscontablesanulados.tpl');

	 

   }





}





?>