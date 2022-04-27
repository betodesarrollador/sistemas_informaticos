<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class TarifasMasivoLayout extends View{

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

			$Form1      = new Form("TarifasMasivoClass.php","TarifasMasivoForm","TarifasMasivoForm");

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
			$this	->	TplInclude	->	IncludeJs("/velotax/mensajeria/tarifas/js/tarifasMasivo.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.alerts.js");

			$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("FORM1",			$Form1	->	FormBegin());
			$this	->	assign("FORM1END",		$Form1	->	FormEnd());
			$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
			$this	->	assign("TARIFAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tarifas_masivo_id]));
			$this	->	assign("VRMINDEC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[vr_min_declarado]));
			$this	->	assign("PORCSEG",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[porcentaje_seguro]));
			$this	->	assign("RANGOINICIAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[rango_inicial]));
			$this	->	assign("RANGOFINAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[rango_final]));
			$this	->	assign("VRRANGOMIN",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_min]));
			$this	->	assign("VRRANGOMAX",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[valor_max]));

			if($this -> Guardar){
			$this	->	assign("GUARDAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[guardar]));
			$this -> 	assign("DUPLICAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[duplicar]));			
			}
			if($this -> Actualizar)
			$this	->	assign("ACTUALIZAR",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[actualizar]));

			if($this -> Borrar)
			$this	->	assign("BORRAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[borrar]));

			if($this -> Limpiar)
			$this	->	assign("LIMPIAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limpiar]));
		}

		public function SetTipoMensajeria($TipoMensajeria){
			$this	->	fields[tipo_servicio_mensajeria_id]['options'] = $TipoMensajeria;
			$this	->	assign("TIPOMENSAJERIAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id]));
		}

		public function SetTipoEnvio($TipoEnvio){
			$this	->	fields[tipo_envio_id]['options'] = $TipoEnvio;
			$this	->	assign("TIPOENVIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_envio_id]));
		}

		public function SetPeriodo($Periodo){
			$this	->	fields[periodo]['options'] = $Periodo;
			$this	->	assign("PERIODO",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo]));
			$this	->	fields[periodo_final]['options'] = $Periodo;
			$this	->	assign("PERIODOFIN",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_final]));			
		}

		public function SetGridTarifasMasivo($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid	->	SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this	->	assign("GRIDTARIFASMASIVO",$TableGrid -> RenderJqGrid());
			$this	->	assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
			$this	->	assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
		}	 

		public function RenderMain(){
			$this ->RenderLayout('tarifasMasivo.tpl');
		}
	}
?>