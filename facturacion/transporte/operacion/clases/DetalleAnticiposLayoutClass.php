<?php

	require_once("../../../framework/clases/ViewClass.php");

	final class DetalleAnticiposLayout extends View{

		private $fields;
		public function setIncludes(){

			$this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
			$this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
			$this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
			$this -> TplInclude -> IncludeCss("../../../framework/css/generalDetalle.css");
			$this -> TplInclude -> IncludeCss("../../../framework/css/detalle_anticipos_manifiesto.css");

			$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
			$this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/detalle_anticipos.js");
			$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");

			$this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
			$this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
		}

		public function setDataManifiesto($dataManifiesto){
			$this -> assign("DATASERVICIO",$dataManifiesto);
		}

		public function setDataDespacho($dataDespacho){
			$this -> assign("DATASERVICIO",$dataDespacho);
		}   

		public function setDataDescuento($dataDescuento){
			$this -> assign("TIPODESCUENTO",$dataDescuento);
		}   

		public function setAnticipos($anticipos){
			$this -> assign("ANTICIPOS",$anticipos);
		}

		public function setAnticiposDespacho($anticipos){
			$this -> assign("ANTICIPOSDESPACHO",$anticipos);
		}   

		public function setFormasPago($formas_pago){
			$this -> assign("FORMASPAGO",$formas_pago);
		}

		public function RenderMain(){
			//$this -> enableDebugging();   
			$this -> RenderLayout('detalle_anticipos.tpl');
		}
	}
?>