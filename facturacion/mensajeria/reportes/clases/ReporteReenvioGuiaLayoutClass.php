<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class ReporteReenvioGuiaLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("ReporteReenvioGuiaClass.php","ReporteReenvioGuiaForm","ReporteReenvioGuiaForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/reportes.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/detalles.css");
     
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");    
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");  
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");         
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/reportes/js/ReporteReenvioGuia.js"); 
	 
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		   $Form1 -> FormBegin());
     $this -> assign("FORM1END",	   $Form1 -> FormEnd());    
     $this -> assign("ORIGEN",         $this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));     
     $this -> assign("ORIGENID",       $this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));     
     $this -> assign("DESTINO",        $this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));    
     $this -> assign("ALLESTADO",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[all_estado]));
     $this -> assign("ALLOFICINA",     $this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));
     $this -> assign("GUIAID",         $this -> objectsHtml -> GetobjectHtml($this -> fields[guia_id]));
     $this -> assign("ALLGUIA",        $this -> objectsHtml -> GetobjectHtml($this -> fields[allguia]));
     $this -> assign("REEXPEDIDO",     $this -> objectsHtml -> GetobjectHtml($this -> fields[reexpedido]));
     $this -> assign("ALLREEXPEDIDO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[allreexpedido]));
     $this -> assign("CONSOLIDADOREX", $this -> objectsHtml -> GetobjectHtml($this -> fields[consolidado]));
     $this -> assign("MENSAJERO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[mensajero]));  
     $this -> assign("MENSAJEROID",    $this -> objectsHtml -> GetobjectHtml($this -> fields[mensajero_id]));
     $this -> assign("DESDE",          $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));       
     $this -> assign("HASTA",          $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));
	 
	 $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	 $this -> assign("GENERAREXCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));	

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU
    public function SetOficina($oficina){
        $this -> fields[oficina_id]['options'] = $oficina;
        $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }
    public function SetSi_Me($Si_Me){
	  $this -> fields[si_mensajero]['options'] = $Si_Me;
      $this -> assign("SI_ME",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_mensajero]));
    }

    public function SetEstado($estado){
    $this -> fields[estado_id]['options'] = $estado;
      $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_id])); 
    }
   public function RenderMain(){   
     $this -> RenderLayout('ReporteReenvioGuia.tpl');	 
   }
}

?>