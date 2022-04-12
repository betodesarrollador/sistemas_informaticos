<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class TarifasEspecialLayout extends View{

		private $fields;
		private $Guardar;
		private $Actualizar;
		private $Borrar;
		private $Limpiar;

		public function setGuardar($Permiso){
			$this -> Guardar = $Permiso;
		}

		public function setActualizar($Permiso){
			$this -> Actualizar = $Permiso;
		}

		public function setBorrar($Permiso){
			$this -> Borrar = $Permiso;
		}

	   	public function SetDuplicar($Permiso){
  	 		$this -> Duplicar = $Permiso;
   		}   

		public function setLimpiar($Permiso){
			$this -> Limpiar = $Permiso;
		}

		public function setCampos($campos){

			require_once("../../../framework/clases/FormClass.php");

			$Form1      = new Form("TarifasEspecialClass.php","TarifasEspecialForm","TarifasEspecialForm");

			$this -> fields = $campos;

			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jquery.alerts.css");

			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jqueryform.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/general.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/generalterceros.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/ajax-list.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/mensajeria/tarifas/js/tarifasEspecial.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.alerts.js");

			$this	->	assign("CSSSYSTEM",			$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",		$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("FORM1",				$Form1	->	FormBegin());
			$this	->	assign("FORM1END",			$Form1	->	FormEnd());
			$this	->	assign("BUSQUEDA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("TARIFAID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tarifas_especiales_id]));
			$this	->	assign("ORIGENID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[origen_id]));
			$this	->	assign("ORIGEN",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[origen]));
			$this	->	assign("DESTINOID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[destino_id]));
			$this	->	assign("DESTINO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[destino]));			
			$this	->	assign("VALORPRIMERKG",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_primerKg]));
			$this	->	assign("VALORADDKG",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_adicionalkg]));
			
			/* $this -> assign("TIPOSERVICIOID",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id])); */
			


			if($this -> Guardar)
			$this	->	assign("GUARDAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[guardar]));
			//$this -> 	assign("DUPLICAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[duplicar]));

			if($this -> Actualizar)
			$this	->	assign("ACTUALIZAR",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[actualizar]));

			if($this -> Borrar)
			$this	->	assign("BORRAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[borrar]));

			if($this -> Limpiar)
			$this	->	assign("LIMPIAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limpiar]));

		    
		}
        
        public function SetTipoEnvio($TipoEnvio){
			$this	->	fields[tipo_envio_id]['options'] = $TipoEnvio;
			$this	->	assign("TIPOENVIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_envio_id]));
		    }
		
		public function SetTipoServicio($TipoServicio){
			
			$this -> fields[tipo_servicio_mensajeria_id]['options'] = $TipoServicio;
			
			$this -> assign("TIPOSERVICIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id]));
			
		}

		public function SetGridTarifasEspeciales($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid	->	SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this	->	assign("GRIDTARIFASESPECIALES",$TableGrid -> RenderJqGrid());
			$this	->	assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
			$this	->	assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
		}	 

		public function RenderMain(){
			$this ->RenderLayout('tarifasEspecial.tpl');
		}
	}
?>