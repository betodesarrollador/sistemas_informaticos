<?php

	require_once("../../../framework/clases/ViewClass.php");

	final class LiquidacionPorOrdenServicioLayout extends View{

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

		public function setImprimir($Permiso){
			$this -> Imprimir = $Permiso;
		}

		public function setCampos($campos){

			require_once("../../../framework/clases/FormClass.php");

			$Form1	= new Form("LiquidacionPorOrdenServicioClass.php","LiquidacionPorOrdenServicioForm","LiquidacionPorOrdenServicioForm");

			$this -> fields = $campos;

			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jquery.alerts.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/DatosBasicos.css");
			// $this	->	TplInclude	->	IncludeCss("/velotax/mensajria/operacion/css/liquidacion.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jqueryform.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/ajax-list.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/funcionesDetalle.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.alerts.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/mensajeria/operacion/js/LiquidacionPorOrdenServicio.js");

			$this	->	assign("FORM1",				$Form1	->	FormBegin());
			$this	->	assign("FORM1END",			$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",			$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",		$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",			$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[busqueda]));
			$this	->	assign("CLIENTE",			$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[cliente]));
			$this	->	assign("LIQUIDACIONID",		$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[liquidacion_id]));
			$this	->	assign("OBSERVACIONANULA",	$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[observacion_anulacion]));
			$this	->	assign("CLIENTEID",			$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[cliente_id]));
			$this	->	assign("DESDE",				$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[fecha_inicial]));
			$this	->	assign("HASTA",				$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[fecha_final]));
			$this	->	assign("FECHALIQUIDACION",	$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[fecha_liquidacion]));
			$this	->	assign("IMPORTARSOLICITUD",	$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[importSolicitud]));
			$this	->	assign("ANULAR",			$this	->	objectsHtml	->	GetobjectHtml($this ->	fields[anular]));
			$this	->	assign("CONSECUTIVO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[consecutivo]));
			$this	->	assign("USUARIO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[usuario_id]));
			$this	->	assign("OFICINA",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[oficina_id]));

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
			
			if($this -> Imprimir)
				$this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

		public function setEstado($opciones){
			$this -> fields[estado]['options'] = $opciones;
			$this	->	assign("ESTADO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
		}

		// public function setConsecutivo($value){
		// 	$this -> fields[consecutivo]['value'] = $value;
		// }


		public function RenderMain(){
			$this ->RenderLayout('LiquidacionPorOrdenServicio.tpl');
		}
	}
?>