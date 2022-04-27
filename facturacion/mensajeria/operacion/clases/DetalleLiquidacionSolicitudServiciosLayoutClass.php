<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class DetalleLiquidacionSolicitudServiciosLayout extends View{

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

		public function setDetallesSolicitudServicios($detallesSolicitudServicio){
			$this -> assign("DETALLES",$detallesSolicitudServicio);
		}

		public function setIncludes(){
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/DatosBasicos.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/generalDetalle.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jquery.alerts.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jquery.autocomplete.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/reset.css");

			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/ajax-list.js");
			// $this	->	TplInclude	->	IncludeJs("/velotax/framework/js/colResizable-1.3.min.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/general.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.alerts.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/jquery.autocomplete.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/funcionesDetalle.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/framework/js/funciones.js");
			$this	->	TplInclude	->	IncludeJs("/velotax/mensajeria/operacion/js/DetalleLiquidacionSolicitudServicios.js");

			$this -> assign("CSSSYSTEM",  $this -> TplInclude -> GetCssInclude());
			$this -> assign("JAVASCRIPT", $this -> TplInclude -> GetJsInclude());
			$this -> assign("SOLICITUDID",$_REQUEST['solicitud_id']);
		}

		public function RenderMain(){
			$this -> RenderLayout('DetalleLiquidacionSolicitudServicios.tpl');
		}
	}
?>