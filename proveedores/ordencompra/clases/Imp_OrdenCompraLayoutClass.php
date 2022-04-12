<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_OrdenCompraLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setOrdenCompra($ordencompra){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSORDENCOMPRA",$ordencompra[0]);       
   }

   public function setitemOrdenCompra($itemordencompra){  
     $this -> assign("ITEMORDENCOMPRA",$itemordencompra);       
   }
   public function setliqOrdenCompra($liqordencompra){  
     $this -> assign("LIQORDENCOMPRA",$liqordencompra);       
   }

   public function set_num_itemOrdenCompra($num_itemordencompra){  
     $this -> assign("NUMITEM_ORDENCOMPRA",$num_itemordencompra[0]);       
   }
   public function set_num_liqOrdenCompra($num_liqordencompra){  
     $this -> assign("NUMLIQ_ORDENCOMPRA",$num_liqordencompra[0]);       
   }

   public function set_val_itemOrdenCompra($val_itemordencompra){  
     $this -> assign("VALITEM_ORDENCOMPRA",$val_itemordencompra[0]);       
   }
   public function set_val_liqOrdenCompra($val_liqordencompra){  
     $this -> assign("VALLIQ_ORDENCOMPRA",$val_liqordencompra[0]);       
   }

   public function set_tot_pucCompra($tot_pucCompra){  
     $this -> assign("TOTPUC_ORDENCOMPRA",$tot_pucCompra[0]);       
   }

   public function set_pucCompra($pucCompra){  
     $this -> assign("PUC_ORDENCOMPRA",$pucCompra);       
   }

  
   public function RenderMain(){
   	  $this ->RenderLayout('Imp_OrdenCompra.tpl');
      //$this -> exportToPdf('Imp_OrdenCompra.tpl','ordenCompra');
   	 

   }


}

?>