<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetallesLayout extends View{

   private $fields;

   public function setReporteUlt($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporte1($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   

   public function setReporte2($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte3($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte4($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte5($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte6($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte7($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte8($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte9($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte10($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte11($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte12($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte13($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte14($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte15($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   
   public function setReporte16($detalles){
     $this -> assign("DETALLES",$detalles);	  
   }   



   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/reportes/css/detalles.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		 	 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		   	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.hotkeys.js");	 
	  	  
     $this -> assign("CSSSYSTEM",	          $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	          $this -> TplInclude -> GetJsInclude());
     $this -> assign("tipo",  				  $_REQUEST['tipo']);	 
     $this -> assign("tipo_nov",  			  $_REQUEST['tipo_nov']);	 
	 $this -> assign("desde",  				  $_REQUEST['desde']);	 
	 $this -> assign("hasta",  				  $_REQUEST['hasta']);	 
	 $this -> assign("desde_h",  			  $_REQUEST['desde_h']);	 
	 $this -> assign("hasta_h",  			  $_REQUEST['hasta_h']);	 
	 $this -> assign("cliente",  			  $_REQUEST['cliente']);	 
	 $this -> assign("placa",  			  	  $_REQUEST['placa']);	 
	 $this -> assign("si_cliente", 			  $_REQUEST['si_cliente']);	 
	 $this -> assign("si_placa",  		  	  $_REQUEST['si_placa']);	 
	 $this -> assign("cliente_id",  		  $_REQUEST['cliente_id']);	 
	 $this -> assign("placa_id",  		  	  $_REQUEST['placa_id']);	
	 $this -> assign("all_oficina",  	  	  $_REQUEST['all_oficina']);
	 $this -> assign("opciones_conductor", 	  $_REQUEST['opciones_conductor']);
     $this -> assign("conductor",  	  	  	  $_REQUEST['conductor']);
     $this -> assign("conductor_id",  	  	  $_REQUEST['conductor_id']);

   }


   public function RenderMain(){
   
      $this -> RenderLayout('detalles.tpl');
	 
   }
   

}


?>