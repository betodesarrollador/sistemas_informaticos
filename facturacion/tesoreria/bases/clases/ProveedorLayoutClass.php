<?php
require_once("../../../framework/clases/ViewClass.php");

final class ProveedorLayout extends View{

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
	 
     $Form1      = new Form("ProveedorClass.php","ProveedoresForm","ProveedoresForm");
	 
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
	 $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../tesoreria/bases/js/proveedores.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TERCEROID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));
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
 	 $this -> assign("DIRECCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion]));
 	 $this -> assign("TELEFONO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono]));
	 $this -> assign("MOVIL",				$this -> objectsHtml -> GetobjectHtml($this -> fields[movil]));
 	 $this -> assign("TELEFAX",				$this -> objectsHtml -> GetobjectHtml($this -> fields[telefax]));
 	 $this -> assign("APARTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[apartado]));
	 $this -> assign("EMAIL",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[email]));
	 $this -> assign("URL",			    	$this -> objectsHtml -> GetobjectHtml($this -> fields[url_proveedor]));	 
	 $this -> assign("CONTACT",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[contac_proveedor]));	 	 
	 $this -> assign("PROVEEDORID",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));
	 $this -> assign("REGIMENID",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[regimen_id]));
	 $this -> assign("TIPOCUENTA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cta_id]));	 
	 $this -> assign("AUTORET_SI",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[autoret_proveedor_si]));	 	 
	 $this -> assign("AUTORET_NO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[autoret_proveedor_no]));	 	 
	 $this -> assign("AGENTE_SI",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[agente_proveedor_si]));	 	 
	 $this -> assign("AGENTE_NO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[agente_proveedor_no]));	 	 
	 
	 $this -> assign("RENTA_SI",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[renta_proveedor_si]));	 	 
	 $this -> assign("RENTA_NO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[renta_proveedor_no]));	 	 

	 $this -> assign("NUM_CUENTA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[numcuenta_proveedor]));
	 $this -> assign("BANCOID",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[banco_id]));	 
	 $this -> assign("BANCO",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[banco]));	 
	 $this -> assign("ACTIVO",              $this -> objectsHtml -> GetobjectHtml($this -> fields[activo]));
	 $this -> assign("INACTIVO",            $this -> objectsHtml -> GetobjectHtml($this -> fields[inactivo]));		 
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
   
    public function SetTiposId($TiposId){
      $this -> fields[tipo_identificacion_id]['options'] = $TiposId;
      $this -> assign("TIPOIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_identificacion_id]));
    }
   
    public function SetTiposPersona($TiposPersona){
	  $this -> fields[tipo_persona_id]['options'] = $TiposPersona;
      $this -> assign("TIPOPERSONA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_persona_id]));
    }

    public function SetTiposRegimen($TiposRegimen){
	  $this -> fields[regimen_id]['options'] = $TiposRegimen;
      $this -> assign("REGIMENID",$this -> objectsHtml -> GetobjectHtml($this -> fields[regimen_id]));
    }
    public function SetTiposCuenta($TiposCuenta){
	  $this -> fields[tipo_cta_id]['options'] = $TiposCuenta;
      $this -> assign("TIPOCUENTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cta_id]));
    }

   
    public function SetGridProveedores($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPROVEEDORES",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('proveedores.tpl');
    }

}

?>