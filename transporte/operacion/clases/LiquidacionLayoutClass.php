<?php

require_once("../../../framework/clases/ViewClass.php");

final class LiquidacionLayout extends View{

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
   
     public function setAnular($Permiso){
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
	 
	 $Form1      = new Form("LiquidacionClass.php","LiquidacionForm","LiquidacionForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");	 
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/Liquidacion.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 
 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery-ui-1.8.1.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");		 
	 $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/liquidacion.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 	 
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("LIQUIDACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[liquidacion_despacho_id]));	
	 $this -> assign("ENCABEZADOREGISTROID",$this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));		 	 	 
	 $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_liquidacion]));		 	 	 	 
	 $this -> assign("MANIFIESTOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto_id]));		
 	 $this -> assign("MANIFIESTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto]));			
	 $this -> assign("FECHASTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static]));	 
	 $this -> assign("FECHA",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
	 $this -> assign("VENCIMIENTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[vencimiento]));	 
	 $this -> assign("TENEDOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor]));	 
	 $this -> assign("TENEDORID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor_id]));	 	 
	 $this -> assign("PLACA",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));	 	 
	 $this -> assign("PLACAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	 	 	 
	 $this -> assign("ORIGEN",$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));	 	 	 
	 $this -> assign("ORIGENID",$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));	 	 	
	 $this -> assign("DESTINO",$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));	 	 	 
	 $this -> assign("DESTINOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));	 	 	
	 $this -> assign("TOTALANTICIPOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[total_anticipos]));	 	
	 $this -> assign("TOTALCOSTOSVIAJE",$this -> objectsHtml -> GetobjectHtml($this -> fields[total_costos_viaje]));	
	 $this -> assign("DIFERENCIA",$this -> objectsHtml -> GetobjectHtml($this -> fields[diferencia]));		 
	 $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));		 	
	 $this -> assign("USUARIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[elaboro]));	 	
	 $this -> assign("CONCEPTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));
	 $this -> assign("OBSERVANULACION",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
	 $this -> assign("AUTORIZAPAGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[autoriza_pago]));
	 
	 
	 $this -> assign("VALORFLETE",$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_flete]));
	 $this -> assign("VALORSOBREFLETE",$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_sobre_flete]));	 	 
	 $this -> assign("OBSERVACIONSOBREFLETE",$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_sobre_flete]));	 
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	 	 	 	 	 	 
	 
	 $this -> assign("VALORNETO",$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_neto_pagar]));
	 $this -> assign("SALDOPAGAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_por_pagar]));	 	 	 	 		 

	 $this -> assign("CANT_GAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[cantidad_galon]));
	 $this -> assign("CANT_PESO",$this -> objectsHtml -> GetobjectHtml($this -> fields[cantidad_peso]));
	 $this -> assign("CANT_VOL",$this -> objectsHtml -> GetobjectHtml($this -> fields[cantidad_volu]));
	 
	 $this -> assign("VALOR_GAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_galon]));
     $this -> assign("FECHAENTREGA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega_mcia_mc]));
	 $this -> assign("FECHAESTIMADASALIDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_estimada_salida]));


	
	 if($this -> Guardar){
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	    $this -> assign("REPORTAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[reportar]));
	 }
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	  
	 }
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	 $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
   }
   
   public function setOficinas($oficinas){

     $this -> fields[oficina_id][options] = $oficinas;
     $this->assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
	   
   }  
   
        public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   } 
   
   public function SetGridManifiestos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDMANIFIESTOS",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }   

   public function RenderMain(){
	 $this ->RenderLayout('liquidacion.tpl');
   }

}

?>