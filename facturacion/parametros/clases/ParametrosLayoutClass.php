<?php

require_once("../../../framework/clases/ViewClass.php");

final class ParametrosLayout extends View{

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
	 
     $Form1      = new Form("ParametrosClass.php","parametrosForm","ParametrosForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
	
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../facturacion/parametros/js/parametros.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("PARAMEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[parametros_factura_id]));
     $this -> assign("RESOLUCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[resolucion_dian]));	 
     $this -> assign("FECHARES",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_resolucion_dian]));
     $this -> assign("FECHAVENRES",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_vencimiento_resolucion_dian]));
	 $this -> assign("PREFIJO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[prefijo]));	 
     $this -> assign("TIPOFACT",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_factura_id]));
     $this -> assign("RANGOINICIAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_inicial]));
	 $this -> assign("RANGOFINAL",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_final]));
	 $this -> assign("OBSERUNO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_uno]));
	 $this -> assign("OBSERDOS",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_dos]));
   $this -> assign("FACTELECT",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[fact_electronica]));
   	 $this -> assign("TIPO",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
	 $this -> assign("FOLIOSREST",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[folios_restantes]));
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
    public function SetTipofactura($Tiposfactura){
      $this -> fields[tipo_factura_id]['options'] = $Tiposfactura;
      $this -> assign("TIPOFACT",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_factura_id]));
    }
    public function SetTipodocumento($Tiposdocumento){
      $this -> fields[tipo_documento_id]['options'] = $Tiposdocumento;
      $this -> assign("TIPODOC",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
    }

    public function SetTipooficina($Tiposoficina){
      $this -> fields[oficina_id]['options'] = $Tiposoficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }

     public function SetFuente($IdFuente){
	  $this -> fields[fuente_facturacion_cod]['options'] = $IdFuente;
      $this -> assign("FUENTEFACTURACIONCOD",$this -> objectsHtml -> GetobjectHtml($this -> fields[fuente_facturacion_cod]));
    }

   
    public function SetGridParametros($Attributes,$Titles,$Cols,$Query){
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
      $this ->RenderLayout('parametros.tpl');
    }

}

?>