<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class CierresLayout extends View{

   private $fields;
   
   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   }
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }

   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   

   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }

   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("CierresClass.php","Cierres","Cierres");	 	 
	 $Form2 = new Form("ReporteCierresClass.php","ReporteCierres","ReporteCierres");	 	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../css/sweetalert2.min.css"); 	 

     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 

     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		  
     $this -> TplInclude -> IncludeJs("../js/cierres.js");
     $this -> TplInclude -> IncludeJs("../js/jquery-3.3.1.min.js");
     $this -> TplInclude -> IncludeJs("../js/swee talert2.all.min.js");
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("FORM2",		 $Form2 -> FormBegin());
     $this -> assign("FORM2END",	 $Form2 -> FormEnd());	 
	 
     $this -> assign("OFICINAID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
	 	 	 
	  $this -> assign("BUSQUEDA",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));	 
     $this -> assign("DESDE",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));
     $this -> assign("HASTA",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));	 
     $this -> assign("FECHADOC",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_doc]));	 
     $this -> assign("CENTRO",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo]));	 	 
     $this -> assign("CENTROID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));	 	 	 
     $this -> assign("OPTERCERO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_tercero]));	 
	  $this -> assign("OPCENTRO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_centro]));	 
	 $this -> assign("ENCABEZADOREG",  $this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));	 	 
     $this -> assign("GENERAR",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));

	 /***********************
	     Anulacion Registro
	 ***********************/
	 
	 $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_log]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	   	 


	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   

	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

	 if($this -> Imprimir){
       $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
	   $this -> assign("EXPORT",$this -> objectsHtml -> GetobjectHtml($this -> fields[export]));	 	   
	 }
  
	   
   }

//LISTA MENU

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }

    
   public function setDocumentos($documentos){
	 $this -> fields[documentos]['options'] = $documentos;
     $this -> assign("DOCUMENTOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[documentos]));	   
   }	  
 
   public function RenderMain(){
   
        $this -> RenderLayout('cierres.tpl');
	 
   }


}


?>