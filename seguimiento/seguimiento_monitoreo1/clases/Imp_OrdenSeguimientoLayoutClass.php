<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_OrdenSeguimientoLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/Imp_OrdenSeguimiento.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setOrdenSeguimiento($OrdenSeguimiento){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSORDENSEGUIMIENTO",$OrdenSeguimiento[0]);       
   }
   public function setContactos($Contactos){  
     $this -> assign("CONTACTOS",$Contactos);       
   }

  
   public function RenderMain(){
	   
      $this -> RenderLayout('Imp_OrdenSeguimiento.tpl');
   	 

   }


}

?>