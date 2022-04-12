<?php
require_once("../../../framework/clases/ViewClass.php");  

final class PanelSoporteLayout extends View{

   private $fields;   
   
    public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("PanelSoporteClass.php","PanelSoporteForm","PanelSoporteForm");
	 
	   $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../facturacion/reportes/css/Reporte.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/bootstrap-4.0.0/dist/css/bootstrap.min.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/bootstrap-4.0.0/dist/css/bootstrap.css");
     $this -> TplInclude -> IncludeCss("../../../framework/sweetalert2/dist/sweetalert2.min.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/font-awesome-4.7.0/css/font-awesome.min.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/DataTables/css/dataTables.bootstrap4.min.css");
     $this -> TplInclude -> IncludeCss("../../../framework/DataTables/css/responsive.dataTables.min.css"); 
     

     $this -> TplInclude -> IncludeCss("../../../errores/movimientos/css/PanelSoporte.css"); 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/jquery/jquery-3.5.1.min.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	  $this -> TplInclude -> IncludeJs("../../../errores/movimientos/js/PanelSoporte.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/bootstrap-4.0.0/dist/js/bootstrap.min.js");
     $this -> TplInclude -> IncludeJs("../../../framework/sweetalert2/dist/sweetalert2.min.js");  
     $this -> TplInclude -> IncludeJs("../../../framework/DataTables/js/jquery.dataTables.min.js");
     $this -> TplInclude -> IncludeJs("../../../framework/DataTables/js/dataTables.bootstrap4.min.js");
     $this -> TplInclude -> IncludeJs("../../../framework/DataTables/datatables.js");
     $this -> TplInclude -> IncludeJs("../../../framework/DataTables/js/dataTables.responsive.min.js");	
     
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     
      $this -> assign("CLIENTE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	
	    $this -> assign("PROYECTO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[proyecto]));		 
	   
	 
   }

/*    public function setValorFacturado($valor_facturado){
      $this -> fields[facturado]['value'] = $valor_facturado;
      $this -> assign("FACTURADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[facturado]));	
   }

   public function setValorSaldo($valor_saldo){
      $this -> fields[saldo]['value'] = $valor_saldo;
      $this -> assign("SALDO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo]));	
   }

   public function setValorPagado($valor_pagado){
      $this -> fields[pagado]['value'] = $valor_pagado;
      $this -> assign("PAGADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[pagado]));	
   } */


   
   public function RenderMain(){   
        $this -> RenderLayout('PanelSoporte.tpl');	 
   }

}

?>