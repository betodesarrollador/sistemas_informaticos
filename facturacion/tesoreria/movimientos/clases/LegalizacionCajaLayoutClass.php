<?php
require_once("../../../framework/clases/ViewClass.php");

final class LegalizacionCajaLayout extends View{

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
   
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }    
   
   public function setLimpiar($Permiso){
	 $this -> Limpiar = $Permiso;
   }   
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("LegalizacionCajaClass.php","LegalizacionCajaForm","LegalizacionCajaForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	
     $this -> TplInclude -> IncludeCss("../../../tesoreria/movimientos/css/legalizacion.css");

	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");		 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");	 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");	 	 
	 $this -> TplInclude -> IncludeJs("../../../tesoreria/movimientos/js/LegalizacionCaja.js");

	 $this -> assign("CSSSYSTEM",				$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",				$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",					$Form1 -> FormBegin());
	 $this -> assign("FORM1END",				$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("LEGALIZACIONID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[legalizacion_caja_id]));		 	 
	 $this -> assign("ENCABEZADOREGISTROID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));		 	 	 
	 $this -> assign("NUMERODOCUMENTO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_documento]));			
	 $this -> assign("FECHA",					$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_legalizacion]));
	 $this -> assign("FECHASTATIC",				$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static]));	 
	 $this -> assign("TOTALCOSTOSLEGALIZACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[total_costos_legalizacion_caja]));	

	 $this -> assign("OFICINAID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
	 $this -> assign("USUARIO",					$this -> objectsHtml -> GetobjectHtml($this -> fields[elaboro]));	
	 $this -> assign("USUARIOID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));		 
	 $this -> assign("CONCEPTO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
	 $this -> assign("ESTADO",					$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_legalizacion]));	 
	 $this -> assign("ANULUSUARIOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	   
	 $this -> assign("ANULOFICINAID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_oficina_id]));	
	 $this -> assign("FECHALOG",				$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_legalizacion_caja]));	   
	 $this -> assign("OBSERVACIONES",			$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_legalizacion_caja]));	
	 $this -> assign("BANDERA",					$this -> objectsHtml -> GetobjectHtml($this -> fields[bandera]));	
	 $this -> assign("TIPO_DOC",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));	
	 
	 
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   $this -> assign("LEGALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[legalizar]));
	 }
	 
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
   }
   
   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   
   
   public function setUsuarioId($usuario,$oficina){
	 $this -> fields[anul_usuario_id]['value'] = $usuario;
     $this -> assign("ANULUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	 
	 $this -> fields[anul_oficina_id]['value'] = $oficina;
     $this -> assign("ANULOFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_oficina_id]));	
   }  
   
   public function setCostosLegalizacion($costosLegalizacion){
       $this -> assign("COSTOSLEGALIZACION",$costosLegalizacion);       
   }
   
   public function setCentroCosto($CentroCosto){
       $this -> assign("CENTROCOSTO",$CentroCosto);       
   } 
   
    public function SetGridLegalizacion($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDLEGALIZACIONCAJA",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }   

   public function RenderMain(){
	 $this ->RenderLayout('LegalizacionCaja.tpl');
   }

}

?>