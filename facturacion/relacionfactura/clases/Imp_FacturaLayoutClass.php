<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_FacturaLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }

 
   public function setFactura($factura){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSORDENFACTURA",$factura[0]);       
   }

   public function setitemFactura($itemfactura){  
     $this -> assign("ITEMORDENFACTURA",$itemfactura);       
   }

   public function setImputacionesContables($imputaciones){  
     $this -> assign("DETALLES",$imputaciones);       
   }


   public function set_pucFactura($pucFactura){  
     $this -> assign("PUC_ORDENFACTURA",$pucFactura);       
   }

   public function set_valor_letras($valor){  
     $this -> assign("VALORLETRAS",$this -> num2letras($valor[0][valor]));       
   }
   public function set_valor_letras_deta($valor){  
     $this -> assign("VALORLETRAS1",$this -> num2letras($valor[0][valor]));       
   }

  
   public function RenderMain(){
   	   if($_REQUEST['tipo_impre']=='F'){ 
   	   	$this ->RenderLayout('Imp_Factura_formato.tpl');
	   }else{
   	   	$this ->RenderLayout('Imp_Factura.tpl');		   
	   }
      //$this -> exportToPdf('Imp_Factura.tpl','Factura');
   	 

   }


}

?>