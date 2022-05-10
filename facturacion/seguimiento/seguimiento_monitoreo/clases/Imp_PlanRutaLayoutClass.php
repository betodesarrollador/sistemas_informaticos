<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_PlanRutaLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
	  $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/Imp_PlanRuta.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/Imp_PlanRuta.css","print");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setTrafico($Trafico){
   
     $this -> assign("TRAFICO",$Trafico[0]);
   }

   public function setDetalles($Detalles){

     $this -> assign("DETALLES",$Detalles);
   }

  
   public function RenderMain(){ 
        $this -> RenderLayout('Imp_PlanRuta.tpl');
   }


}

?>