<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class RegistrarLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }

   public function SetImprimir($Permiso){
	 $this -> Imprimir = $Permiso;
   } 

   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }     
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("RegistrarClass.php","RegistrarForm","RegistrarForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 	
 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/swfobject.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
     $this -> TplInclude -> IncludeJs("../js/Registrar.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("BUSQUEDA1",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda1]));
	 
     $this -> assign("LIQUIDACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_novedad_id]));
	  $this -> assign("CONSECUTIVO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));
     $this -> assign("FECHAINI",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicial]));
     $this -> assign("FECHAFIN",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));
     $this -> assign("CONTRATOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato_id]));	 
     $this -> assign("CONTRATO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contrato]));	 
     $this -> assign("EMPLEADOS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[empleados]));	 	 
     $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	  $this -> assign("USUARIO_ID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
	  $this -> assign("FECHAREG",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));	  
	  $this -> assign("PERIODOLIQUIDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo]));
	  $this -> assign("PERIODICIDAD",		$this -> objectsHtml -> GetobjectHtml($this -> fields[periodicidad]));	 	 
	  $this -> assign("AREAS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[area_laboral]));	 	 
	
	//anulacion
	 $this -> assign("USUARIOANUL_ID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_anulo_id]));
	 $this -> assign("FECHAANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anulacion]));	  
	 $this -> assign("OBS_ANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	 $this -> assign("CAUSALANUL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));
	 
	 $this -> assign("TIPOIMPRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_impresion]));
	 $this -> assign("DESPRENDIBLES",	$this -> objectsHtml -> GetobjectHtml($this -> fields[desprendibles]));
	 

     if($this -> Guardar){
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   $this -> assign("PREVISUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[previsual]));
	 }
     if($this -> Actualizar){
	   //$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
 	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
	 }

	if($this -> Imprimir){
		$this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
		$this -> assign("PRINTOUT",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[print_out]));		
		$this -> assign("PRINTCANCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[print_cancel]));				
	}
	
     if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
	   
     if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	   
	   
	   
   }

//LISTA MENU
	public function SetCosto($centro_de_costo_id){
		$this -> fields[centro_de_costo_id]['options'] = $centro_de_costo_id;
		$this -> assign("CENTRO_DE_COSTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));
	}

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANUL",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   


//// GRID ////
   public function SetGridRegistrar($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery){

     require_once("../../../framework/clases/grid/JqGridClass.php");

     $TableGrid = new JqGrid();
     $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery);
      
      $head = "'<head>".
    
      $TableGrid -> GetJqGridJs()." ".
      
      $TableGrid -> GetJqGridCss()."
      
      </head>";
      
      $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
      
      return "<html>".$head." ".$body."</html>";

   }


   public function RenderMain(){
   
        $this -> RenderLayout('Registrar.tpl');
	 
   }


}


?>