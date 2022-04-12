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
	 $this -> TplInclude -> IncludeCss("../../../tesoreria/bases/css/tiposervicio.css");	 
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../tesoreria/bases/js/tiposervicio.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("BIENID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_bien_servicio_teso_id]));
     $this -> assign("NOMBREBIEN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_bien_servicio_teso]));	
  	 $this -> assign("VALORMANUAL",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_manual]));	
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
    public function SetDocumento($IdDocumento){
	  $this -> fields[tipo_documento_id]['options'] = $IdDocumento;
      $this -> assign("DOCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
    }
    public function SetAgencia($IdAgencia){
	  $this -> fields[agencia]['options'] = $IdAgencia;
      $this -> assign("AGENCIAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[agencia]));
    }

    public function SetManual($manual){
	  $this -> fields[valor_manual]['options'] = $manual;
      $this -> assign("VALORMANUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_manual]));

	  $this -> fields[puc_manual]['options'] = $manual;
      $this -> assign("PUCMANUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_manual]));
	  
	  $this -> fields[tercero_manual]['options'] = $manual;
      $this -> assign("TERCEROMANUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_manual]));	
	  
	  $this -> fields[centro_manual]['options'] = $manual;
      $this -> assign("CENTROMANUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_manual]));	  

	  $this -> fields[maneja_cheque]['options'] = $manual;
      $this -> assign("MANCHEQUE",$this -> objectsHtml -> GetobjectHtml($this -> fields[maneja_cheque]));	  

	}

    public function SetGridTipoServicio($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDTIPOSERVICIO",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('tiposervicio.tpl');
    }
}

?>