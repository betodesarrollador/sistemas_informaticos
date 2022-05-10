<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class reporteHistoricoLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("reporteHistoricoClass.php","reporteHistoricoForm","reporteHistoricoForm");
	 
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
     $this -> TplInclude -> IncludeJs("../../../transporte/reportes/js/ReporteHistorico.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");		 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");	 
	 
     $this -> assign("CSSSYSTEM",	     $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		     $Form1 -> FormBegin());
     $this -> assign("FORM1END",	     $Form1 -> FormEnd());
     $this -> assign("OFICINA",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 		 
	 $this -> assign("DESDE",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
	 $this -> assign("HASTA",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));		 
	 $this -> assign("CLIENTE",		     $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	
	 $this -> assign("CLIENTEID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	 $this -> assign("VEHICULO",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[vehiculo]));	
	 $this -> assign("VEHICULOID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[vehiculo_id]));	 
	 $this -> assign("CONDUCTOR",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor]));	
	 $this -> assign("CONDUCTORID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));
	 $this -> assign("TENEDOR",		     $this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor]));	
	 $this -> assign("TENEDORID",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor_id]));		 
 	 $this -> assign("ALLOFFICE",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));
	 
	 $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU

/*   public function setOficinas($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));      
   }*/
   
    public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }
    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_vehiculo]['options'] = $Si_pro;
      $this -> assign("SI_VEH",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_vehiculo]));
    }
    public function SetSi_Pro2($Si_pro2){
	  $this -> fields[si_conductor]['options'] = $Si_pro2;
      $this -> assign("SI_CON",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_conductor]));
    }
    public function SetSi_Pro3($Si_pro3){
	  $this -> fields[si_tenedor]['options'] = $Si_pro3;
      $this -> assign("SI_TEN",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_tenedor]));
    }
    public function SetSi_Pro4($Si_pro4){
	  $this -> fields[si_cliente]['options'] = $Si_pro4;
      $this -> assign("SI_CLI",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_cliente]));
    }	
   public function RenderMain(){   
     $this -> RenderLayout('ReporteHistorico.tpl');	 
   }
}

?>