<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class reporteDocumentosLayout extends View{
   private $fields;
  public function setGuardar($Permiso){
  $this -> Guardar = $Permiso;
  }
  public function setActualizar($Permiso){
  $this -> Actualizar = $Permiso;
  }
  public function setBorrar($Permiso){
  $this -> Borrar = $Permiso;
  }
  public function setLimpiar($Permiso){
  $this -> Limpiar = $Permiso;
  }
  public function SetAnular($Permiso){
  $this -> Anular = $Permiso;
  }   
  public function SetImprimir($Permiso){
  $this -> Imprimir = $Permiso;
  }   
   
   public function setCampos($campos){
     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("reporteDocumentosClass.php","reporteDocumentos","reporteDocumentos");
     $Form2 = new Form("reporteDocumentosResultadoClass.php","reporteDocumentosResultado","reporteDocumentosResultado");
	 $this -> fields = $campos; 
		  
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../css/reportes.css");
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/reporteDocumentos.js"); 
     $this -> TplInclude -> IncludeJs("../js/detalles.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");		 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
	 
     $this -> assign("CSSSYSTEM",	     $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		     $Form1 -> FormBegin());
     $this -> assign("FORM1END",	    $Form1 -> FormEnd());
     $this -> assign("FORM2",         $Form2 -> FormBegin());
     $this -> assign("FORM2END",      $Form2 -> FormEnd());
	   $this -> assign("TRAZABILIDAD",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[trazabilidad_id]));	 
	   $this -> assign("DESDE",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
	   $this -> assign("HASTA",			 $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));		 
	   $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));
     $this -> assign("IMPRIMIR",      $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	   $this -> assign("EXCEL",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[excel]));
   }
//LISTA MENU
   	
    public function SetEstado($trazabilidad){
	  $this -> fields[trazabilidad_id]['options'] = $trazabilidad;
      $this -> assign("TRAZABILIDAD",$this -> objectsHtml -> GetobjectHtml($this -> fields[trazabilidad_id]));
    }
	
    public function RenderMain(){   
     $this -> RenderLayout('reporteDocumentos.tpl');	 
    }   
}
?>