<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class LibrosAuxiliaresLayout extends View{

   private $fields;
   
   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("LibrosAuxiliaresClass.php","LibrosAuxiliares","LibrosAuxiliares");	 	 
	 $Form2 = new Form("ReporteLibrosAuxiliaresClass.php","ReporteLibrosAuxiliares","ReporteLibrosAuxiliares");	 	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 
     $this -> TplInclude -> IncludeCss("../../../contabilidad/css/LibrosAuxiliares.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 

     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		  
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("FORM2",		 $Form2 -> FormBegin());
     $this -> assign("FORM2END",	 $Form2 -> FormEnd());	 
     $this -> assign("REPORTE",      $this -> objectsHtml -> GetobjectHtml($this -> fields[reporte]));
	 
     $this -> assign("OFICINAID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
     $this -> assign("CENTROSTODOS",   $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_centros]));	 	 
     $this -> assign("DOCUMENTOSTODOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_documentos]));	 	 	 
	 
     $this -> assign("DESDE",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));
     $this -> assign("HASTA",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));	 
     $this -> assign("NIVEL",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[nivel]));	 
     $this -> assign("TERCERO",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));	 	 
     $this -> assign("OPTERCERO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_tercero]));	 	 	 
     $this -> assign("CUENTADESDE",    $this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_desde]));	 	 	 	 	 
     $this -> assign("CUENTAHASTA",    $this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_hasta]));	 	 	 	 	 	 	 
     $this -> assign("CUENTADESDEID",  $this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_desde_id]));	 	 	 	 	 
     $this -> assign("CUENTAHASTAID",  $this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_hasta_id]));	 	 	 	 	 	 	 	 
     $this -> assign("TERCEROID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));	 	 	 	 	 	 	 	 	 
     $this -> assign("GENERAR",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));
	 
	 if($this -> Imprimir){
       $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
	   $this -> assign("EXPORT",$this -> objectsHtml -> GetobjectHtml($this -> fields[export]));	 	   
	 }
  
	   
   }

//LISTA MENU
  
   public function setEmpresas($empresas){
	 $this -> fields[empresa_id]['options'] = $empresas;
     $this -> assign("EMPRESASID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	   
   }
   
   public function setOficinas($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	   
   }
   public function setCentrosCosto($centros){
	 $this -> fields[centro_de_costo_id]['options'] = $centros;
     $this -> assign("CENTROCOSTOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));	   
   }      
    
   public function setDocumentos($documentos){
	 $this -> fields[documentos]['options'] = $documentos;
     $this -> assign("DOCUMENTOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[documentos]));	   
   }	  
 
   public function RenderMain(){
   
        $this -> RenderLayout('librosauxiliares.tpl');
	 
   }


}


?>