<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_SolicitudLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Imp_Solicitud.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setOrdenCargue($ordencargue){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSORDENCARGUE",$ordencargue[0]);       
   }

  
   public function RenderMain(){
	   
      $this -> RenderLayout('Imp_Solicitud.tpl');
   	 
      //$this -> exportToPdf('Imp_Solicitud.tpl','ordenCargue');

   }


}

?>