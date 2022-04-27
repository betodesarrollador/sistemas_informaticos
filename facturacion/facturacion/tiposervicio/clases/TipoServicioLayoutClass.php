<?php

require_once("../../../framework/clases/ViewClass.php");

final class TipoServicioLayout extends View{

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
	 
     $Form1      = new Form("TipoServicioClass.php","TipoServicioForm","TipoServicioForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../facturacion/tiposervicio/css/tiposervicio.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/bootstrap1.css");
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
     $this -> TplInclude -> IncludeJs("../../../facturacion/tiposervicio/js/tiposervicio.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("BIENID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_factura_id]));
     $this -> assign("NOMBREBIEN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_bien_servicio_factura]));
     $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	
     $this -> assign("REPORTACAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[reporta_cartera]));

     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
    public function SetFuente($IdFuente){
	  $this -> fields[fuente_facturacion_cod]['options'] = $IdFuente;
      $this -> assign("FUENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[fuente_facturacion_cod]));
    }
    public function SetDocumento($IdDocumento){
	  $this -> fields[tipo_documento_id]['options'] = $IdDocumento;
	  $this -> fields[tipo_documento_dev_id]['options'] = $IdDocumento;
      $this -> assign("DOCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
	  $this -> assign("DOCDEVID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_dev_id]));
    }
    public function SetAgencia($IdAgencia){
	  $this -> fields[agencia]['options'] = $IdAgencia;
      $this -> assign("AGENCIAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[agencia]));
    }
   
    public function SetGridTipoServicio($Attributes,$Titles,$Cols,$Query){
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
      $this ->RenderLayout('tiposervicio.tpl');
    }

}

?>