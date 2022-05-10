<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_LiquidacionLayout extends View{

  private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");	 
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css",'print');	 	 
	 $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Liquidacion.css");	 	 
	 $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Imp_Liquidacion.css",'print');	 	 	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
     
   public function setEncabezado($encabezado){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSENCABEZADO",$encabezado[0]);       
     $this -> assign("TOTALES", $this -> num2letras($encabezado[0]['saldo_por_pagar']));       	 	 
   }

   public function setimputaciones($imputaciones){  
     $this -> assign("IMPUTACIONES",$imputaciones);       
   }

   public function setTotal($total){  
     $this -> assign("TOTAL",$total[0]);       
   }
  
   public function RenderMain(){
     $this -> renderLayout('Imp_Liquidacion.tpl','Documento Contable');	  	     	 
   }

}

?>