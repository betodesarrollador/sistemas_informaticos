<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class View_DocumentLayout extends View{

  private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/reset.css");	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
     
   public function setEncabezado($encabezado){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSENCABEZADO",$encabezado[0]);       
   }

   public function setimputaciones($imputaciones){  
     $this -> assign("IMPUTACIONES",$imputaciones);       
   }

   public function setTotal($total){  
     $this -> assign("TOTAL",$total[0]);       
   }
   public function setTotales($totales){  
     $this -> assign("TOTALES", $this -> num2letras($totales[0][total]));       
   }

  
   public function RenderMain(){
     $this -> renderLayout('View_Document.tpl','Documento Contable');	  	     	 
   }

}

?>