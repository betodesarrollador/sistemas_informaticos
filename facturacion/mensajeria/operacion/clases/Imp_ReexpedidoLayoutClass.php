<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ReexpedidoLayout extends View{
 
   
   public function setReexpedido($Reexpedido,$usuario){

     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Imp_Reexpedido.css");      
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Imp_Reexpedido.css","print");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/printer.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-1.4.4.min.js");	                
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-barcode-2.0.2.js");	           
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/Imp_Reexpedido.js");	      
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	  	  
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());	 
     $this -> assign("FECHA",date("Y-m-d"));
     $this -> assign("USUARIO",$usuario);	 	 
	 
     $this -> assign("DATOSREXPEDIDO",$Reexpedido);  
	       
   }

  public function setDetalle($Reexpedido,$usuario){
	   $this -> assign("DETALLES",$Reexpedido);  
	  
  }

  public function setDetalle1($Reexpedido,$usuario){
	   $this -> assign("DETALLES1",$Reexpedido);  
	  
  }

  public function setDetalle2($Reexpedido,$usuario){
	   $this -> assign("DETALLES2",$Reexpedido);  
	  
  }

   public function RenderExcel(){

      $this -> exportToExcel('Imp_Reexpedido.tpl','man');	  
	    	  

   }
  
   public function RenderMain(){
	   
	    if($_REQUEST['tipo_impre']=='F'){ 
   	   	$this ->RenderLayout('Imp_Reexpedido.tpl');
	   }else{
   	   	$this ->RenderLayout('Imp_Reexpedido1.tpl');		   
	   }

      //$this -> renderLayout('Imp_Reexpedido.tpl');	  
	    	  

   }


}

?>