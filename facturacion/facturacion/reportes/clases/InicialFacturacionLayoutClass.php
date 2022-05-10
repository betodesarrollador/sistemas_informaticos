<?php
require_once("../../../framework/clases/ViewClass.php");  

final class InicialFacturacionLayout extends View{

   private $fields;   
   
    public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("InicialFacturacionClass.php","InicialFacturacionForm","InicialFacturacionForm");
	 
	   $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../facturacion/reportes/css/Reporte.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.min.css"); 
      $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/font-awesome-4.7.0/css/font-awesome.min.css");    
     $this -> TplInclude -> IncludeCss("../../../facturacion/reportes/css/InicialFacturacion.css"); 
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	   $this -> TplInclude -> IncludeJs("../../../facturacion/reportes/js/InicialFacturacion.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	
     $this -> TplInclude -> IncludeCss("../../../framework/js/bootstrap.min.js"); 	
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     
      $this -> assign("FACTURADO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[facturado]));	
	    $this -> assign("SALDO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo]));		 
	    $this -> assign("PAGADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[pagado]));
	 
   }

   public function setValorFacturado($valor_facturado){
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
   }


   
   public function RenderMain(){   
        $this -> RenderLayout('InicialFacturacion.tpl');	 
   }

}

?>