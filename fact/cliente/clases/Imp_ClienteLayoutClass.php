<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ClienteLayout extends View{

   private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
  
   
   public function setCliente($cliente){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSCLIENTE",$cliente[0]);       
    	 
   }

   public function setLegal($legal){   
     $this -> assign("DATOSLEGAL",$legal);
   }
      
   public function setOperativa($operativas){
	 $this -> assign("OPERATIVAS",$operativas);	       
   }
  
   public function RenderMain(){
   	 
   	$this -> exportToPdf('Imp_Cliente.tpl','Cliente');
   }


}

?>