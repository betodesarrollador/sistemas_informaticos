<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class SolicitudServiciosLayout extends View{

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
   
   public function setImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("SolicitudServiciosClass.php","SolicitudServiciosForm","SolicitudServiciosForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/solicitud_servicios.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
 
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
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/SolicitudServicios.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("SOLICITUDID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[solicitud_id]));
     $this -> assign("TIPOSERVICIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_id]));
     $this -> assign("TIPOLIQ",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_liquidacion]));
     $this -> assign("PAQUETEO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[paqueteo]));
     $this -> assign("FECHASOLICITUD",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ss]));
     $this -> assign("FECHASSFINAL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ss_final]));
     $this -> assign("FECHASTATIC",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ss_static]));	 
     $this -> assign("CLIENTEID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 
     $this -> assign("OFICINAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 	  	
     $this -> assign("CONTACTOID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[contacto_id]));
     $this -> assign("FECHARECOGIDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_recogida_ss]));
     $this -> assign("HORARECOGIDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_recogida_ss]));
     $this -> assign("FECHAENTREGA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega_ss]));
     $this -> assign("HORAENTREGA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_entrega_ss]));
     $this -> assign("ARCHIVOSOLICITUD",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo_solicitud]));
     $this -> assign("VALORFACTURAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_facturar]));
     $this -> assign("VALORCOSTO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_costo]));
	 
	 $this -> assign("OBSERVACIONES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));

     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
     if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
     if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
     if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

   public function SetHistorico($historico){

      $this -> assign("ARRAY_HISTORICO",$historico); 
	  $this -> assign("HISTORICO",'SI'); 

   }

//LISTA MENU

   public function setClientes($clientes){

     $this -> fields[cliente_id][options] = $clientes;
     $this->assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	   
   }

   public function SetTipoServicio($TipoServicio){
     $this -> fields[tipo_servicio_id][options] = $TipoServicio;
     $this->assign("TIPOSERVICIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_id]));
   }
   
   public function SetNaturaleza($Naturaleza){
	 $this -> fields[naturaleza_id]['options'] = $Naturaleza;
     $this -> assign("NATURALEZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_id])); 
   }
   
   public function SetTipoEmpaque($TipoEmpaque){
	 $this -> fields[empaque_id]['options'] = $TipoEmpaque;
     $this -> assign("UNIDADEMPAQUE",$this -> objectsHtml -> GetobjectHtml($this -> fields[empaque_id])); 
   }
   
   public function SetUnidadMedida($UnidadMedida){
	 $this -> fields[medida_id]['options'] = $UnidadMedida;
     $this -> assign("UNIDADMEDIDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[medida_id])); 
   }
   
   public function setOficinas($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));      
   }   


//// GRID ////
   public function SetGridSolicitudServicios($Attributes,$Titles,$Cols,$Query,$SubAttributes='',$SubTitles='',$SubCols='',$SubQuery=''){

     require_once("../../../framework/clases/grid/JqGridClass.php");

     $TableGrid = new JqGrid();
     $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query, 
							 $SubAttributes,$SubTitles,$SubCols,$SubQuery);
     $this -> assign("GRIDSOLICITUDSERVICIOS",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());

   }


   public function RenderMain(){
   
        $this -> RenderLayout('SolicitudServicios.tpl');
	 
   }


}


?>