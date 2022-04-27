<?php
require_once("../../../framework/clases/ViewClass.php");

final class ArqueoCajaLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }    
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("ArqueoCajaClass.php","ArqueoCajaForm","ArqueoCajaForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../tesoreria/movimientos/css/arqueocaja.css");	 
	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../tesoreria/movimientos/js/arqueocaja.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("ARQUEOCAJAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[arqueo_caja_id]));
     $this -> assign("CONSECUTIVO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));
	 
	 $this -> assign("FECHA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_arqueo]));
	 $this -> assign("OFICINAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
	 $this -> assign("EFECTIVO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[total_efectivo]));
	 $this -> assign("TOT_CHEQUE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[total_cheque]));	 
	 $this -> assign("TOT_CAJA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[total_caja]));	 
	 $this -> assign("SAL_AUXILIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_auxiliar]));
	 $this -> assign("DIFERENCIA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[diferencia]));
	 $this -> assign("CHEQUES1",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cheques]));

	 $this -> assign("ESTADO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_arqueo]));

	 $this -> assign("FECHALOG",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anul]));	   
	 $this -> assign("OBSERVACIONES",	$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_arqueo]));	 

     if($this -> Guardar){
	   $this -> assign("GUARDAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 }
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   $this -> assign("CERRAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cerrar]));
	   
	 }
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
    }

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }

   public function setParametros($parametros){
	 $this -> fields[puc_id]['value'] = $parametros[0][puc_id];
     $this -> assign("PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));	  	   

	 $this -> fields[ini_puc_id]['value'] = $parametros[0][ini_puc_id];
     $this -> assign("INIPUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ini_puc_id]));	  	   

	 $this -> fields[ini2_puc_id]['value'] = $parametros[0][ini2_puc_id];
     $this -> assign("INI2PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ini2_puc_id]));	  	   

	 $this -> fields[ini3_puc_id]['value'] = $parametros[0][ini3_puc_id];
     $this -> assign("INI3PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ini3_puc_id]));	  	   

	 $this -> fields[ini4_puc_id]['value'] = $parametros[0][ini4_puc_id];
     $this -> assign("INI4PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ini4_puc_id]));	
	 
	 $this -> fields[ini5_puc_id]['value'] = $parametros[0][ini5_puc_id];
     $this -> assign("INI5PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ini5_puc_id]));	  	   

	 $this -> fields[ini6_puc_id]['value'] = $parametros[0][ini6_puc_id];
     $this -> assign("INI6PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ini6_puc_id]));	  	   

	 $this -> fields[centro_costo]['value'] = $parametros[0][centro_costo];
     $this -> assign("CENTROCOSTOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_costo]));	  	   


   }

   public function setDocumentos($documentos){
	 $this -> fields[documentos]['value'] = $documentos[0][documentos];
     $this -> assign("DOCUMENTOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[documentos]));	  	   

   }

   public function setParametrosCaja($ParametrosCaja){
	 $this -> fields[parametros_legalizacion_arqueo_id]['options'] = $ParametrosCaja;
     $this -> assign("PARAMETROSLEGALIZACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[parametros_legalizacion_arqueo_id]));	  	   
   }	   

   public function setMonedas($monedas){
	 $this -> assign("MONEDAS",$monedas);	 

   }

 	public function setBilletes($billetes){
	 $this -> assign("BILLETES",$billetes);	 

   }

 	public function setCheques($cheques){
	 $this -> assign("CHEQUES",$cheques);	 

   }

 	public function setValCheques($valcheques){
	 $this -> fields[total_cheque]['value'] = $valcheques>0?$valcheques:0;
     $this -> assign("TOT_CHEQUE",$this -> objectsHtml -> GetobjectHtml($this -> fields[total_cheque]));	  	   

   }

   public function setCentros($centros){
	 $this -> fields[centro_de_costo_id]['value'] = $centros[0][centro_de_costo_id];
     $this -> assign("CENTROCOSTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));	  	   


   }


   public function setUsuarioId($usuario,$anuloficina){
	 $this -> fields[usuario_id]['value'] = $usuario;
     $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	  
	 $this -> fields[anul_usuario_id]['value'] = $usuario;
     $this -> assign("ANULUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	  
	 $this -> fields[anul_oficina_id]['value'] = $anuloficina;
     $this -> assign("ANULOFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_oficina_id]));	  
   }   

    public function SetGridArqueoCaja($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDARQUEOCAJA",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('arqueocaja.tpl');
    }

}

?>