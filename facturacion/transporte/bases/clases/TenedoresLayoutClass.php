<?php

require_once("../../../framework/clases/ViewClass.php");

final class TenedoresLayout extends View{

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
   
   public function setCambioEstado($Permiso){
     $this -> CambiarEstado = $Permiso;   
   }   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("TenedoresClass.php","TenedoresForm","TenedoresForm"); 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		   
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");	 	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/bases/js/tenedores.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		   	   
	 
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TENEDORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tenedor_id])); 
     $this -> assign("TERCEROID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id])); 
     $this -> assign("PROVEEDORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id])); 	 	 
     $this -> assign("TIPOPERSONA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id]));
     $this -> assign("TIPOIDENTIFICACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
     $this -> assign("NUMEROIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));
     $this -> assign("DIGITOVERIFICACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[digito_verificacion])); 
     $this -> assign("PRIMERAPELLIDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[primer_apellido]));
     $this -> assign("SEGUNDOAPELLIDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[segundo_apellido]));
     $this -> assign("PRIMERNOMBRE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[primer_nombre]));
     $this -> assign("OTROSNOMBRES",		$this -> objectsHtml -> GetobjectHtml($this -> fields[segundo_nombre]));	 	 	 	 	     
	 $this -> assign("RAZON_SOCIAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[razon_social]));	 	 	 	 	 
	 $this -> assign("SIGLA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[sigla]));	 	 	 	 
     $this -> assign("UBICACION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
     $this -> assign("UBICACIONID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
     $this -> assign("DIRECCIONRESIDENCIA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion]));
     $this -> assign("TELEFONOFIJO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono]));
     $this -> assign("TELEFONOCELULAR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[movil]));
     $this -> assign("TIPOCUENTA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cta_id]));
     $this -> assign("NUMEROCUENTA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[numcuenta_proveedor]));
     $this -> assign("FECHADATACREDITO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_data_tene]));
     $this -> assign("CALIFICACIONDATA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[calificacion_data_tene]));
     $this -> assign("DOCUMENTOS",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[documentos]));	
	 $this -> assign("AUTORRETENEDORRENTA", $this -> objectsHtml -> GetobjectHtml($this -> fields[autoret_proveedor]));	 	 
	 $this -> assign("AUTOCREE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[renta_proveedor]));		  
	 $this -> assign("AUTORRETENEDORICA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[retei_proveedor]));		  
	
	
	$this -> assign("RUT",	        		$this -> objectsHtml -> GetobjectHtml($this -> fields[rut]));	
	$this -> assign("SEGURIDADSOCIAL",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[seguridad_social]));	
	$this -> assign("VENCSEGURIDADSOCIAL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[venc_seguridad_social]));	
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	
	//LISTA MENU   
	
   public function setEstado(){
   
     if(!$this -> CambiarEstado) $this -> fields[estado][disabled] = 'true';
	 
     $this -> assign("ESTADO",	$this -> getObjectHtml($this -> fields[estado]));	   	        
   
   }	
	
   public function SetTiposId($TiposId){
     $this -> fields[tipo_identificacion_id][options] = $TiposId;
	 $this -> assign("TIPOIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
   }
   
   public function SetTiposPersona($TiposPersona){
	 $this -> fields[tipo_persona_id]['options'] = $TiposPersona;
     $this -> assign("TIPOPERSONA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id])); 
   }

   public function SetTipoCuenta($TipoCuenta){
   	 $this -> fields[tipo_cta_id]['options'] = $TipoCuenta;
     $this -> assign("TIPOCUENTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cta_id]));
   }

   public function SetBancos($bancos){
   	 $this -> fields[banco_id]['options'] = $bancos;
     $this -> assign("BANCOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[banco_id]));
   }
   
 
	//// GRID ////  
   public function SetGridTenedores($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDTENEDORES",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('tenedores.tpl');
	 
   }


}


?>