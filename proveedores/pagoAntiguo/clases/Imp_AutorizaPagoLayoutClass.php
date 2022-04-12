<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_AutorizaPagoLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("/rotterdan/framework/css/reset.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setOrdenCompra($ordencompra){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSORDENCOMPRA",$ordencompra[0]);       
   }
  
   public function RenderMain(){
   	  $this ->RenderLayout('Imp_AutorizaPago.tpl');
      //$this -> exportToPdf('Imp_AutorizaPago.tpl','ordenCompra');
   	 

   }


}

?>