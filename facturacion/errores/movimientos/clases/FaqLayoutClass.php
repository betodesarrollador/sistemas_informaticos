<?php

require_once("../../../framework/clases/ViewClass.php");

final class FaqLayout extends View{

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
	 
     $Form1      = new Form("FaqClass.php","FaqForm","FaqForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../errores/movimientos/js/Faq.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("ERRORES_ID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[errores_id]));
     //$this -> assign("ASUNTO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[asunto_id]));	 
     $this -> assign("FECHAERROR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ingreso_error]));
	 $this -> assign("FECHASOLUCION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_solucion]));	 
     $this -> assign("CLIENTE_ID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	 $this -> assign("CLIENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
     //$this -> assign("USUARIOMOD",			$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_modifica]));
	 //$this -> assign("USUARIO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario]));
	 //$this -> assign("USUARIO_ID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
	 $this -> assign("DESCRIPCION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
	 $this -> assign("SOLUCION",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[solucion]));
	 $this -> assign("ESTADO",	    		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
    public function setModulo($Tiposdocumento){
      $this -> fields[modulos_codigo]['options'] = $Tiposdocumento;
      $this -> assign("MODULOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[modulos_codigo]));
    }

	public function setAsunto($asunto){
      $this -> fields[asunto_id]['options'] = $asunto;
      $this -> assign("ASUNTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[asunto_id]));
    }

	   public function setUsuarioId($usuario,$oficina){	  
	 $this -> fields[usuario_id]['value'] = $usuario;
     $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	 	 
	 
   }  
   
      public function setUsuarioMod($usuario,$oficina){	  
	 $this -> fields[usuario_modifica]['value'] = $usuario;
     $this -> assign("USUARIOMOD",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_modifica]));	 
	 
   }  

   /* public function SetTipooficina($Tiposoficina){
      $this -> fields[oficina_id]['options'] = $Tiposoficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }*/

   
    public function SetGridFaq($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDFaq",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('Faq.tpl');
    }

}

?>