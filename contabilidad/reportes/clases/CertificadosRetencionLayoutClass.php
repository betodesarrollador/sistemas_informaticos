<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class CertificadosRetencionLayout extends View{

   private $fields;
   
   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("CertificadosRetencionClass.php","CertificadosRetencion","CertificadosRetencion");	 	 
	 $Form2 = new Form("ReporteCertificadosRetencionClass.php","ReporteCertificadosRetencion","ReporteCertificadosRetencion");	 	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 
     $this -> TplInclude -> IncludeCss("../css/CertificadosRetencion.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 

     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		  
     $this -> TplInclude -> IncludeJs("../js/CertificadosRetencion.js");
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("FORM2",		 $Form2 -> FormBegin());
     $this -> assign("FORM2END",	 $Form2 -> FormEnd());	 
     $this -> assign("BUSQUEDA",	 	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));	 	 	 
     $this -> assign("PUCID",$this -> objectsHtml->GetobjectHtml($this->fields[puc_id])); 	     
	 $this -> assign("DOCUMENTOSTODOS",$this -> objectsHtml->GetobjectHtml($this->fields[opciones_certificados])); 
	 $this -> assign("CERTIF_TER",$this -> objectsHtml->GetobjectHtml($this->fields[certificados_tercero_id])); 	 	 	 	 
     $this -> assign("DESDE",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));
     $this -> assign("HASTA",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));	 
     $this -> assign("TERCERO",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));	 	 
     $this -> assign("OPTERCERO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_tercero]));  	 	 	 	 	 	 
     $this -> assign("TERCEROID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));	 	   	     $this -> assign("GENERAR",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));
	 
	 if($this -> Imprimir){
       $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 	 	   
	 }
  
	   
   }

//LISTA MENU
      
   public function setCertificados($documentos){
	 $this -> fields[certificados_id]['options'] = $documentos;
     $this -> assign("DOCUMENTOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[certificados_id]));	   
   }	  
 
   public function RenderMain(){
   
        $this -> RenderLayout('CertificadosRetencion.tpl');
	 
   }


}


?>