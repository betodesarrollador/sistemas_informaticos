<?php

	require_once("../../../framework/clases/ViewClass.php");

	final class RutasEspecialesLayout extends View{

		private $fields;
		public function setIncludes(){

		 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../facturacion/cliente/css/socio.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 	 
	 
			

			$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
			$this -> TplInclude -> IncludeJs("../../../transporte/bases/js/RutasEspeciales.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");

			$this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
			$this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
		}

		public function SetConvencion($dataEnvio){
			$this -> assign("DETALLES",$dataEnvio);
		}

		public function SetCliente($tercero_id,$cliente){
			$this -> assign("CLIENTEID", $cliente);
			$this -> assign("TERCEROID", $tercero_id);			
		}

		public function SetPeriodo($periodo,$periodo_actual){
			$this -> assign("PERIODOS", $periodo);
			$this -> assign("ACTUAL", $periodo_actual);
		}
		
		public function RenderMain(){
			$this -> RenderLayout('RutasEspeciales.tpl');
		}
	}
?>