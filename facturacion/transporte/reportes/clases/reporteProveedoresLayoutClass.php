<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class reporteProveedoresLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("reporteProveedoresClass.php","reporteProveedoresForm","reporteProveedoresForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/reportes/css/reportes.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/reportes/js/ReporteProveedores.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
	 
     $this -> assign("CSSSYSTEM",	     $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		     $Form1 -> FormBegin());
     $this -> assign("FORM1END",	     $Form1 -> FormEnd());
     $this -> assign("OFICINA",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	
	 $this -> assign("TIPO",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));		 
	 $this -> assign("DESDE",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
	 $this -> assign("HASTA",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));		
	 $this -> assign("VEHICULO",       	 $this -> objectsHtml -> GetobjectHtml($this -> fields[vehiculo]));	            // 25/06/2013
     $this -> assign("VEHICULOID",     	 $this -> objectsHtml -> GetobjectHtml($this -> fields[vehiculo_id]));	        // 25/06/2013	 
	 $this -> assign("TENEDOR",		     $this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor]));	
	 $this -> assign("TENEDORID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor_id]));
 	 $this -> assign("ALLOFFICE",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));
	 $this -> assign("ALLDOCUMENTO",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[all_documento]));
	 $this -> assign("ESTADO",		 	 $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	 
	 
	 $this -> assign("CONCORTE",		 	 $this -> objectsHtml -> GetobjectHtml($this -> fields[con_corte]));	 
	 
	 $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	 $this -> assign("DESCARGAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[descargar]));
	 

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU
   
    public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }
    public function SetTipo($tipos){
	  $this -> fields[tipo]['options'] = $tipos;
      $this -> assign("TIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
    }
    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_tenedor]['options'] = $Si_pro;
      $this -> assign("SI_TEN",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_tenedor]));
    }
	public function SetSi_Pro2($Si_pro2){
	  $this -> fields[si_vehiculo]['options'] = $Si_pro2;
      $this -> assign("SI_VEH",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_vehiculo]));
    }
   public function RenderMain(){   
     $this -> RenderLayout('ReporteProveedores.tpl');	 
   }
}

?>