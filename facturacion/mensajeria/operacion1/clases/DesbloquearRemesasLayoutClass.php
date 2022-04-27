<?php

require_once("../../../framework/clases/ViewClass.php");

final class DesbloquearRemesasLayout extends View{

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
	 
	 $Form1 = new Form("DesbloquearRemesasClass.php","DesbloquearRemesasForm","DesbloquearRemesasForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Remesas.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/DesbloquearRemesas.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("SOLICITUDID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[solicitud_id]));	 
     $this -> assign("REMESAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[remesa_id]));
     $this -> assign("OFICINAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
	 
	 
     $this -> assign("OFICINADESBLOQUEAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_desbloquea_id]));	 
     $this -> assign("DESBLOQUEADA",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[desbloqueada]));	 	 	 
	 
     $this -> assign("OFICINAIDSTATIC",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_static]));	 	 
     $this -> assign("NUMEROREMESA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_remesa]));
     $this -> assign("TIPOREMESA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_remesa_id]));
     $this -> assign("FECHA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
     $this -> assign("FECHAREMESA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_remesa]));
     $this -> assign("CLIENTE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
     $this -> assign("CLIENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
     

     $this -> assign("PROPIETARIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[propietario_mercancia]));
     $this -> assign("PROPIETARIOTXT",	$this -> objectsHtml -> GetobjectHtml($this -> fields[propietario_mercancia_txt]));     
     $this -> assign("PROPIETARIOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[propietario_mercancia_id]));
     $this -> assign("TIPOIDENTIFICACIONPROPIETARIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_propietario_mercancia]));
     $this -> assign("NUMEROIDENTIFICACIONPROPIETARIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_propietario_mercancia]));     
     $this -> assign("COMPLEMENTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[complemento]));     
     $this -> assign("CONTROL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[control]));     	 	 
     $this -> assign("NUMEROREMESAPADRE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_remesa_padre]));     	 
	 
	      
     $this -> assign("CONTACTOS",      $this -> objectsHtml -> GetobjectHtml($this -> fields[contacto_id]));	 
     $this -> assign("AMPARADAPOR",      $this -> objectsHtml -> GetobjectHtml($this -> fields[amparada_por]));	 
     $this -> assign("NUMEROPOLIZA",      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_poliza]));	 	 	 	  	 
     $this -> assign("ORIGEN",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
     $this -> assign("ORIGENID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
     $this -> assign("REMITENTE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente]));
     $this -> assign("REMITENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente_id]));	 
     $this -> assign("DOCUMENTOREMITENTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[doc_remitente]));
     $this -> assign("TIPOIDENTIFICACIONREMITENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_remitente_id]));	 	
	 $this -> assign("ORDENDESPACHO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[orden_despacho]));	 	 
	 
	 
     $this -> assign("DIRECCIONORIGEN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_remitente]));
     $this -> assign("TELEFONOORIGEN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_remitente]));	 
     $this -> assign("DESTINO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
     $this -> assign("DESTINATARIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[destinatario]));
     $this -> assign("DESTINATARIOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[destinatario_id]));	 
     $this -> assign("DOCUMENTODESTINATARIO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[doc_destinatario]));
     $this -> assign("TIPOIDENTIFICACIONDESTINATARIOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_destinatario_id]));	 
     $this -> assign("DIRECCIONDESTINO",$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_destinatario]));
     $this -> assign("TELEFONODESTINO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_destinatario]));	 

     $this -> assign("PRODUCTOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));
     $this -> assign("CODIGO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[producto]));
     $this -> assign("PRODUCTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion_producto]));
     $this -> assign("NATURALEZA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_id]));
     $this -> assign("UNIDADEMPAQUE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[empaque_id]));
     $this -> assign("UNIDADMEDIDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[medida_id]));
     $this -> assign("CANTIDAD",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cantidad]));
     $this -> assign("PESONETO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[peso]));
     $this -> assign("PESOVOLUMEN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[peso_volumen]));     
     $this -> assign("VALORDECLARADO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));	 	 
     $this -> assign("OBSERVACIONES",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	 	 
 

     $this -> assign("HOJATIEMPOSID",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[hoja_de_tiempos_id]));
     $this -> assign("HORASPACTADASCARGUE",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[horas_pactadas_cargue]));
     $this -> assign("FECHALLEGADALUGARCARGUE", $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_llegada_lugar_cargue]));
     $this -> assign("HORALLEGADALUGARCARGUE",	$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_llegada_lugar_cargue]));
     $this -> assign("FECHASALIDALUGARCARGUE",  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_salida_lugar_cargue]));
     $this -> assign("HORASALIDALUGARCARGUE",   $this -> objectsHtml -> GetobjectHtml($this -> fields[hora_salida_lugar_cargue]));
	 
	 
    $this -> assign("CONDUCTORENTREGAHOJARUTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_cargue]));	 
    $this -> assign("CONDUCTORCARGUEID",       $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_cargue_id]));	 
	
	
     $this -> assign("ENTREGAHOJARUTA",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[entrega]));
     $this -> assign("CEDULAENTREGAHOJARUTA",   $this -> objectsHtml -> GetobjectHtml($this -> fields[cedula_entrega]));
     $this -> assign("HORASPACTADASDESCARGUE",  $this -> objectsHtml -> GetobjectHtml($this -> fields[horas_pactadas_descargue]));
     $this -> assign("FECHALLEGADADESCARGUE",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_llegada_lugar_descargue]));
     $this -> assign("HORALLEGADADESCARGUE",    $this -> objectsHtml -> GetobjectHtml($this -> fields[hora_llegada_lugar_descargue]));
     $this -> assign("FECHASALIDADESCARGUE",    $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_salida_lugar_descargue]));
     $this -> assign("HORASALIDADESCARGUE",     $this -> objectsHtml -> GetobjectHtml($this -> fields[hora_salida_lugar_descargue]));
     $this -> assign("CONDUCTORRECIBEHOJARUTA", $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_descargue]));
     $this -> assign("CONDUCTORRECIBEHOJARUTAID", $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_descargue_id]));
     $this -> assign("RECIBEHOJARUTA",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[recibe]));
     $this -> assign("CEDULARECIBEHOJARUTA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cedula_recibe]));
     $this -> assign("ESTADO",	                $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	 	 
     $this -> assign("FORMATO",	                $this -> objectsHtml -> GetobjectHtml($this -> fields[formato]));	
     $this -> assign("OBSERVANULACION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));		 	 

	   $this -> assign("IMPORTARSOLICITUD",$this -> objectsHtml -> GetobjectHtml($this -> fields[importSolcitud]));	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
     if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

     if($this -> Imprimir){	   
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   	   
	   $this -> assign("PRINTOUT",$this -> objectsHtml -> GetobjectHtml($this -> fields[print_out]));	   
	   $this -> assign("PRINTCANCEL",$this -> objectsHtml -> GetobjectHtml($this -> fields[print_cancel]));	   	   	   
	 }
	   
	   
	   
	   
   }

//LISTA MENU
   public function SetTiposRemesa($TiposRemesa){
     $this -> fields[tipo_remesa_id][options] = $TiposRemesa;
	 $this -> assign("TIPOREMESA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_remesa_id]));
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
   
   public function setRangoDesde($rangoDesde){
	 $this -> fields[rango_desde]['options'] = $rangoDesde;
     $this -> assign("RANGODESDE",$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_desde]));    
   }
   
   public function setRangoHasta($rangoHasta){
	 $this -> fields[rango_hasta]['options'] = $rangoHasta;
     $this -> assign("RANGOHASTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_hasta]));    
   }   

   public function setDataSeguroPoliza($dataSeguroPoliza){
   	   
	 $this -> fields[aseguradora_id_static]['value']   = $dataSeguroPoliza[0]['aseguradora_id'];
     $this -> assign("ASEGURADORAIDSTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[aseguradora_id_static]));    
	 
	 $this -> fields[numero_poliza]['value']        = $dataSeguroPoliza[0]['numero_poliza'];
     $this -> assign("NUMEROPOLIZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_poliza]));    
	 
	 $this -> fields[numero_poliza_static]['value'] = $dataSeguroPoliza[0]['numero_poliza'];
     $this -> assign("NUMEROPOLIZASTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_poliza_static]));       
   
   }

   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }   
   
   public function setAseguradoras($aseguradoras){
	 $this -> fields[aseguradora_id]['options'] = $aseguradoras;
     $this -> assign("ASEGURADORAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[aseguradora_id]));          
   }

//// GRID ////
  public function SetGridDesbloquearRemesas($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery){  	
  
	require_once("../../../framework/clases/grid/JqGridClass.php");
	$TableGrid = new JqGrid();
		
	$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query,$SubAttributes,$SubTitles,$SubCols,$SubQuery);
	
	$this -> assign("GRIDDesbloquearRemesas",	$TableGrid -> RenderJqGrid());
	$this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
	$this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());   
	
  }

   public function RenderMain(){
        $this -> RenderLayout('DesbloquearRemesas.tpl');
   }


}


?>