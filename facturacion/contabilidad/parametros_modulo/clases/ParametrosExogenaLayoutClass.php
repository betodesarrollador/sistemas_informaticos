<?php
require_once("../../../framework/clases/ViewClass.php");
final class ParametrosExogenaLayout extends View{
   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
   
   public function SetBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }      
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){
     require_once("../../../framework/clases/FormClass.php");	 
	 $Form1      = new Form("ParametrosExogenaClass.php","ParametrosExogenaForm","ParametrosExogenaForm");	 
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
	 $this -> TplInclude -> IncludeCss("../css/conceptosexogena.css");	 
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/parametrosexogena.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("FORMATOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[formato_exogena_id]));
	 $this -> assign("RESOLUCION",$this -> objectsHtml -> GetobjectHtml($this -> fields[resolucion]));
	 $this -> assign("FECHA",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_resolucion]));	
	 $this -> assign("ANO",$this -> objectsHtml -> GetobjectHtml($this -> fields[ano_gravable]));
	 $this -> assign("NIT_EXTRAN",$this -> objectsHtml -> GetobjectHtml($this -> fields[nit_extranjeros]));
	 $this -> assign("TIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_formato]));	
	 $this -> assign("MONTOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[montos_ingresos]));
	 $this -> assign("MONTOSPJ",$this -> objectsHtml -> GetobjectHtml($this -> fields[montos_ingresospj]));
	 $this -> assign("VERSION",$this -> objectsHtml -> GetobjectHtml($this -> fields[version]));
	 $this -> assign("CUANMIN",$this -> objectsHtml -> GetobjectHtml($this -> fields[cuantia_minima]));	
	 $this -> assign("CUANMEN",$this -> objectsHtml -> GetobjectHtml($this -> fields[cuantias_menores]));
	 $this -> assign("TIPDOC",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_doc]));	
	 $this -> assign("TERCERO",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_tercero]));		  		 	 
	 $this -> assign("TIPOF",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));		  		 	 
	 $this -> assign("NOMBRE_FORMATO",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_formato]));		  		 	 
	 
	 $this -> assign("TIPO_N",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_formato_n]));		  		 	 
	 $this -> assign("VERSION_N",$this -> objectsHtml -> GetobjectHtml($this -> fields[version_n]));		  		 	 
	 $this -> assign("RESOL_N",$this -> objectsHtml -> GetobjectHtml($this -> fields[resolucion_n]));		  		 	 
	 $this -> assign("CUANMIN_N",$this -> objectsHtml -> GetobjectHtml($this -> fields[cuantia_minima_n]));		  		 	 
	 $this -> assign("FECHA_N",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_resolucion_n]));		  		 	 
	 $this -> assign("ANO_N",$this -> objectsHtml -> GetobjectHtml($this -> fields[ano_gravable_n]));	
	 $this -> assign("GENERAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	  		 	 

     if($this -> Guardar){
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   $this -> 	assign("DUPLICAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[duplicar]));			
	   
	 }
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
   public function setFormato($formatos){
	 $this -> fields[formato_base]['options'] = $formatos;
     $this -> assign("FORMABASE",$this -> objectsHtml -> GetobjectHtml($this -> fields[formato_base]));	   
   }
         
   public function SetGridParametrosExogena($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $head = "'<head>".
	 
	 $TableGrid -> GetJqGridJs()." ".
	 
	 $TableGrid -> GetJqGridCss()."
	 
	 </head>";
	 
	 $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
	 
	 return "<html>".$head." ".$body."</html>";
   }	
     
    public function RenderMain(){
      $this ->RenderLayout('parametrosexogena.tpl');
    }
}
?>