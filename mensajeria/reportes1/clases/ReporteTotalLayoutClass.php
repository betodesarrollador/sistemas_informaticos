<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class ReporteTotalLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("ReporteTotalClass.php","ReporteTotalForm","ReporteTotalForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/reportes.css");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/reportes/js/ReporteTotal.js"); 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");		 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
	 
     $this -> assign("CSSSYSTEM",	    $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	    $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		    $Form1 -> FormBegin());
     $this -> assign("FORM1END",	    $Form1 -> FormEnd());    
	 $this -> assign("CLIENTE",        	$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));  
     $this -> assign("CLIENTEID",      	$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
     $this -> assign("DESDE",          	$this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));       
     $this -> assign("HASTA",          	$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));     
	 
	 $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	 $this -> assign("GENERAREXCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));	
	 $this -> assign("EXCELFORMATO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[excel_formato]));
	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU

    public function setCliente($datos){
	  $this -> fields[cliente_id]['value'] = $datos[0]['cliente_id'];
      $this -> assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));

	  $this -> fields[cliente]['value'] = $datos[0]['cliente'];
      $this -> assign("CLIENTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));

    }

    public function SetSi_Cli($Si_cli){
	  $this -> fields[si_cliente]['options'] = $Si_cli;
      $this -> assign("SI_CLI",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_cliente]));
    }
	
   public function RenderMain(){   
     $this -> RenderLayout('ReporteTotal.tpl');	 
   }
}

?>