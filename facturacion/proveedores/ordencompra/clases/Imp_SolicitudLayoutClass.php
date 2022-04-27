<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_SolicitudLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setSolicitud($solicitud){  
     $this -> assign("FECHA",date("Y-m-d"));   
     $this -> assign("DATOSORDENCOMPRA",$solicitud[0]);       
   }

   public function setitemSolicitud($itemsolicitud){  
     $this -> assign("ITEMORDENCOMPRA",$itemsolicitud);       
   }
   public function setliqSolicitud($liqsolicitud){  
     $this -> assign("LIQORDENCOMPRA",$liqsolicitud);       
   }

   public function set_num_itemSolicitud($num_itemsolicitud){  
     $this -> assign("NUMITEM_ORDENCOMPRA",$num_itemsolicitud[0]);       
   }
   public function set_num_liqSolicitud($num_liqsolicitud){  
     $this -> assign("NUMLIQ_ORDENCOMPRA",$num_liqsolicitud[0]);       
   }

   public function set_val_itemSolicitud($val_itemsolicitud){  
     $this -> assign("VALITEM_ORDENCOMPRA",$val_itemsolicitud[0]);       
   }
   public function set_val_liqSolicitud($val_liqsolicitud){  
     $this -> assign("VALLIQ_ORDENCOMPRA",$val_liqsolicitud[0]);       
   }

   public function set_tot_pucCompra($tot_pucCompra){  
     $this -> assign("TOTPUC_ORDENCOMPRA",$tot_pucCompra[0]);       
   }

   public function set_pucCompra($pucCompra){  
     $this -> assign("PUC_ORDENCOMPRA",$pucCompra);       
   }

  
   public function RenderMain(){
   	  $this ->RenderLayout('Imp_Solicitud.tpl');
      //$this -> exportToPdf('Imp_Solicitud.tpl','ordenCompra');
   	 

   }


}

?>