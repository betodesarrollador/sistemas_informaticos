<?php

	require_once("../../../framework/clases/ViewClass.php");

	final class CorreoNormalClientesLayout extends View{

		private $fields;
		public function setIncludes(){

			$this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/generalDetalle.css");

			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
			$this -> TplInclude -> IncludeJs("/velotax/mensajeria/bases/js/CorreoNormalClientes.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");

			$this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
			$this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
		}

		public function SetTipoEnvio($dataEnvio){
			$this -> assign("DETALLESENVIOS",$dataEnvio);
		}

		public function SetCliente($cliente){
			$this -> assign("CLIENTEID", $cliente);
		}

		public function SetPeriodo($periodo){
			$this -> assign("PERIODOS", $periodo);
		}
		
		public function RenderMain(){
			$this -> RenderLayout('CorreoNormalClientes.tpl');
		}
	}
?>