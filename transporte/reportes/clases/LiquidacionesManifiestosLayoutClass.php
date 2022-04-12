<?php

require_once("../../../framework/clases/ViewClass.php");

final class LiquidacionesManifiestosLayout extends View{ 
   
   public function SetGridManifiestos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDMANIFIESTOS",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }   

   public function RenderMain(){
	 $this ->RenderLayout('LiquidacionesManifiestos.tpl');
   }

}

?>