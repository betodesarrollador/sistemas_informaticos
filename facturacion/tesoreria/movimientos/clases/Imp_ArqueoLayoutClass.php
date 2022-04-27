<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ArqueoLayout extends View{

  private $fields;

   
   public function setIncludes(){   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css",'print');	 	 
	 $this -> TplInclude -> IncludeCss("../../../tesoreria/movimientos/css/Imp_Arqueo.css");	 	 
	 $this -> TplInclude -> IncludeCss("../../../tesoreria/movimientos/css/Imp_Arqueo.css",'print');	 	 	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());	 
   }
     
   public function setEncabezado($encabezado){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSENCABEZADO",$encabezado[0]);       
   }

   public function setMonedas($monedas){  
     $this -> assign("MONEDAS",$monedas);       
   }

   public function setBilletes($billetes){  
     $this -> assign("BILLETES",$billetes);       
   }
   public function setReporte($reporte){  
     $this -> assign("REPORTE",$reporte);       
   }

  
   public function RenderMain(){
     $this -> renderLayout('Imp_Arqueo.tpl','Arqueo');	  	     	 
   }

}

?>