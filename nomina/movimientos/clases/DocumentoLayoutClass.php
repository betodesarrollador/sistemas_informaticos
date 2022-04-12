<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class DocumentoLayout extends View{

		private $fields;

		public function SetGuardar($Permiso){
			$this -> Guardar = $Permiso;
		}

		public function SetActualizar($Permiso){
			$this -> Actualizar = $Permiso;
		}
		
		 public function SetImprimir($Permiso){
		 $this -> Imprimir = $Permiso;
		}

		public function SetBorrar($Permiso){
			$this -> Borrar = $Permiso;
		}

		public function SetLimpiar($Permiso){
			$this -> Limpiar = $Permiso;
		}

		public function SetCampos($campos){

			require_once("../../../framework/clases/FormClass.php");
			$Form1      = new Form("DocumentoClass.php","DocumentoForm","DocumentoForm");
			$this	->	fields	=	$campos;

			$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 

			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajaxupload.3.6.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/general.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
			$this	->	TplInclude	->	IncludeJs("../js/Documento.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
			$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

			$this	->	assign("FORM1",						$Form1	->	FormBegin());
			$this	->	assign("FORM1END",					$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",					$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",				$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("DOCUMENTO_LABORAL",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[documento_laboral_id]));
			$this	->	assign("FECHA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[fecha]));		
			$this	->	assign("CONTRATO_ID",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato_id]));
			$this	->	assign("CONTRATO",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contrato]));
				

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar)
				$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
				
			if($this -> Imprimir)
			$this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	

			if($this -> Borrar)
				$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

		public function SetDoc($tipo_documento_laboral_id){
			$this -> fields[tipo_documento_laboral_id]['options'] = $tipo_documento_laboral_id;
			$this -> assign("TIPODOCUMENTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_laboral_id]));
		}

		public function SetGridContrato($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
			
			$head = "'<head>".
	 
			$TableGrid -> GetJqGridJs()." ".
			
			$TableGrid -> GetJqGridCss()."
			
			</head>";
			
			$body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
			
			return "<html>".$head." ".$body."</html>";
		}

		public function RenderMain(){
			$this ->RenderLayout('Documento.tpl');
		}
	}
?>