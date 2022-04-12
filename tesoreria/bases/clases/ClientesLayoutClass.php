<?php

require_once("../../../framework/clases/ViewClass.php");

final class ClientesLayout extends View{

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

   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   
   public function setCambioEstado($Permiso){
     $this -> CambiarEstado = $Permiso;   
   }   
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ClientesClass.php","ClientesForm","ClientesForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../tesoreria/bases/css/cliente.css");	 
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
     $this -> TplInclude -> IncludeJs("../../../tesoreria/bases/js/clientes.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TERCEROID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));
  	 $this -> assign("REMITENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente_destinatario_id]));	 
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
	 $this -> assign("URL",			    	$this -> objectsHtml -> GetobjectHtml($this -> fields[url_cliente_factura]));	 
	 $this -> assign("CONTACT",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[contac_cliente_factura]));	 	 

	 $this -> assign("CORRESPON",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[corres_cliente_factura]));	 	 
	 $this -> assign("REGISTROM",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[reg_cliente_factura]));	 	 
	 $this -> assign("CCOMERCIO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[ccomercio_cliente_factura]));	 	 
	 $this -> assign("CAPITAL",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[capital_cliente_factura]));	 	 
	 $this -> assign("DESACTIVIDAD",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[actividad_cliente_factura]));	 	 
	 
	 $this -> assign("REPRELEG",	   		$this -> objectsHtml -> GetobjectHtml($this -> fields[repreleg_cliente_factura]));	
	 $this -> assign("REPRELEGID",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[idrepre_cliente_factura]));	
	 $this -> assign("DIRREPRELEG",	   		$this -> objectsHtml -> GetobjectHtml($this -> fields[dirrepre_cliente_factura]));		
	 $this -> assign("REPUBICACIONID",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[rep_ubicacion_id]));
	 $this -> assign("REPUBICACION",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[ciurepre_cliente_factura]));
	 $this -> assign("RECURSOS",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[recursos_cliente_factura]));	 

	 $this -> assign("CLIENTEID",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	 $this -> assign("REGIMENID",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[regimen_id]));
	 $this -> assign("TIPOCUENTA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_cta_id]));	 
	 $this -> assign("AUTORET_SI",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[autoret_cliente_factura_si]));	 	 
	 $this -> assign("AUTORET_NO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[autoret_cliente_factura_no]));	 	 
	 $this -> assign("AGENTE_SI",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[agente_cliente_si]));	 	 
	 $this -> assign("AGENTE_NO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[agente_cliente_no]));	 	 
	 $this -> assign("NUM_CUENTA",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[numcuenta_cliente_factura]));

	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   
	   
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

    public function SetTiposBanco($TiposBanco){
	  $this -> fields[banco_id]['options'] = $TiposBanco;
      $this -> assign("BANCOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[banco_id]));
    }

   public function setEstado(){
   
     if(!$this -> CambiarEstado) $this -> fields[estado][disabled] = 'true';
	 
     $this -> assign("ESTADO",	$this -> getObjectHtml($this -> fields[estado]));	   	        
   
   }
   
    public function SetGridClientes($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDCLIENTES",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('clientes.tpl');
    }

}

?>