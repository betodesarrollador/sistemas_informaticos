<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_DTALayout extends View{

   private $fields;
   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Imp_DTA.css");	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
  
   
   public function setDTA($dta){  
     $this -> assign("DTA",$dta[0]);
     $this -> assign("FECHA",date("Y-m-d"));	 	    
   }
      
  
   public function RenderMain(){
   	 
      //$this -> exportToPdf('Imp_DTA.tpl','DTA');
	  
	  $this -> exportToWord('Imp_DTA.tpl','DTA');
	  	  
//      $this -> renderLayout('Imp_DTA.tpl','DTA Manifiesto');
   	 
   }


}

?>