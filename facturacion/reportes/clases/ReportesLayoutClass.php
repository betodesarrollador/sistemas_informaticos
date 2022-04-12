<?php

require_once("../../../framework/clases/ViewClass.php");

final class ReportesLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   
  
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ReportesClass.php","ReportesForm","ReportesForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../facturacion/reportes/css/Reporte.css");	
	 $this -> TplInclude ->  IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude ->  IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../facturacion/reportes/js/Reporte.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());

	 $this -> assign("OFICINA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	
   $this -> assign("TIPO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
   $this -> assign("SALDO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo]));
   $this -> assign("SALDOS",			$this -> objectsHtml -> GetobjectHtml($this -> fields[saldos]));		 
	 $this -> assign("DESDE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
   $this -> assign("HASTA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));
   $this -> assign("FECHACORTE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_corte]));		 	  
	 $this -> assign("CLIENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	
	 $this -> assign("CLIENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
 	 $this -> assign("ALLOFFICE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));

     $this -> assign("GENERAR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	 $this -> assign("DESCARGAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descargar]));	
   $this -> assign("EXCEL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));	
   
   //Agregado filtro para comerciales
	$this -> assign("COMERCIAL",				$this -> objectsHtml -> GetobjectHtml($this -> fields[comercial]));	
	 $this -> assign("COMERCIALID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[comercial_id]));
	//Agregado filtro para comerciales


	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",        	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   
     $this -> assign("ENVIAR",		        $this -> objectsHtml -> GetobjectHtml($this -> fields[enviar]));
    }


    public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }

    public function SetTipo($tipos){
	  $this -> fields[tipo]['options'] = $tipos;
      $this -> assign("TIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
    }
    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_cliente]['options'] = $Si_pro;
      $this -> assign("SI_CLI",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_cliente]));
    }

    	//Agregado filtro para comerciales
	public function SetSi_Com($Si_com){
	  $this -> fields[si_comercial]['options'] = $Si_com;
      $this -> assign("SI_COM",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_comercial]));
    }
//Agregado filtro para comerciales


    public function RenderMain(){
      $this ->RenderLayout('Reporte.tpl');
    }

}

?>