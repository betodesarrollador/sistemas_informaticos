<?php

require_once("../../../framework/clases/ViewClass.php");

final class AnticiposProveedorLayout extends View{

   private $fields;
   private $Imprimir;
    
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }	

   public function setBorrar($Permiso){
	 $this -> Borrar = $Permiso;
   }      

   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   

   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1          = new Form("AnticiposProveedorClass.php","AnticiposProveedorForm","AnticiposProveedorForm");	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/jquery.autocomplete.css");	 

	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jquery.autocomplete.js");	 
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/proveedores/anticipos/js/anticiposproveedor.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",	  $Form1 -> FormBegin());
	 $this -> assign("FORM1END",  $Form1 -> FormEnd());
	
	 $this -> assign("PROVEEDORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields['proveedor_id']));	 
	 $this -> assign("PROVEEDOR",			$this -> objectsHtml -> GetobjectHtml($this -> fields['proveedor']));
 	 $this -> assign("PROVEEDORIDENTIFICACION",		$this -> objectsHtml -> GetobjectHtml($this -> fields['proveedor_nit']));	
	 
	$this -> assign("ENCABEZADOREGISTROID",$this -> objectsHtml -> GetobjectHtml($this -> fields['encabezado_registro_id']));		 
 	 

	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields['borrar']));

	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields['anular']));	   
	 
	 if($this -> Imprimir){
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields['imprimir']));		 
	 } 
	 
     $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields['limpiar']));		 	 

   }   
   
   public function RenderMain(){
	 
	 $this ->RenderLayout('anticiposproveedor.tpl');
   }

}

?>