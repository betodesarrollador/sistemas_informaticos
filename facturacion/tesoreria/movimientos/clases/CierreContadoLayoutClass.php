<?php

	require_once("../../../framework/clases/ViewClass.php");

	final class CierreContadoLayout extends View{

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

			$Form1	= new Form("CierreContadoClass.php","CierreContadoForm","CierreContadoForm");

			$this -> fields = $campos;

			$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/DatosBasicos.css");
			$this	->	TplInclude	->	IncludeCss("../css/Liquidacion.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
			//$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/funcionesDetalle.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
			$this	->	TplInclude	->	IncludeJs("../js/CierreContado.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 			

			$this	->	assign("FORM1",				$Form1	->	FormBegin());
			$this	->	assign("FORM1END",			$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",			$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",		$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[busqueda]));
			$this	->	assign("LIQUIDACIONID",		$this	->	objectsHtml	->	GetobjectHtml($this -> fields[cierre_contado_id]));			
			$this	->	assign("ENCABEZADOID",		$this	->	objectsHtml	->	GetobjectHtml($this -> fields[encabezado_registro_id]));			
			$this	->	assign("CONSECUTIVO",		$this	->	objectsHtml	->	GetobjectHtml($this -> fields[consecutivo]));	
			$this	->	assign("OFICINAID",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[oficina_id]));	
			$this	->	assign("USUARIOID",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[usuario_id]));	
			
			$this	->	assign("DESDE",				$this	->	objectsHtml	->	GetobjectHtml($this -> fields[fecha_inicial]));
			$this	->	assign("HASTA",				$this	->	objectsHtml	->	GetobjectHtml($this -> fields[fecha_final]));
			$this	->	assign("FECHA_REG",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[fecha_registro]));
			$this	->	assign("VALOR",				$this	->	objectsHtml	->	GetobjectHtml($this -> fields[valor]));
			$this	->	assign("OBSERVANULACION",	$this	->	objectsHtml	->	GetobjectHtml($this -> fields[observacion_anulacion]));

			$this	->	assign("IMPORTARSOLICITUD",	$this	->	objectsHtml	->	GetobjectHtml($this -> fields[importSolicitud]));

			if($this -> Guardar){
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
				$this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));
			}
			if($this -> Anular){
				$this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
			}
			if($this -> Imprimir)
				$this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

		public function SetTiposPago($TiposPago){
		  $this -> fields[cuenta_tipo_pago_id]['options'] = $TiposPago;
		  $this -> assign("PAGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[cuenta_tipo_pago_id]));
		}

		public function SetDocumento($IdDocumento){
		  $this -> fields[tipo_documento_id]['options'] = $IdDocumento;
		  $this -> assign("DOCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
		}

		public function setEstado($opciones){
			$this -> fields[estado]['options'] = $opciones;
			$this	->	assign("ESTADO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
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
			$this ->RenderLayout('CierreContado.tpl');
		}
	}
?>