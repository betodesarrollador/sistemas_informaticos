<?php

	require_once("../../../framework/clases/ViewClass.php");

	final class LiquidacionGuiasClienteLayout extends View{

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

			$Form1	= new Form("LiquidacionGuiasClienteClass.php","LiquidacionGuiasClienteForm","LiquidacionGuiasClienteForm");

			$this -> fields = $campos;

			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/reset.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/general.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/jquery.alerts.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/framework/css/DatosBasicos.css");
			$this	->	TplInclude	->	IncludeCss("/velotax/mensajria/operacion/css/liquidacion.css");
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
			$this	->	TplInclude	->	IncludeJs("/velotax/mensajeria/operacion/js/LiquidacionGuiasCliente.js");

			$this	->	assign("FORM1",				$Form1	->	FormBegin());
			$this	->	assign("FORM1END",			$Form1	->	FormEnd());
			$this	->	assign("CSSSYSTEM",			$this	->	TplInclude	->	GetCssInclude());
			$this	->	assign("JAVASCRIPT",		$this	->	TplInclude	->	GetJsInclude());
			$this	->	assign("BUSQUEDA",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[busqueda]));
			$this	->	assign("LIQUIDACIONID",		$this	->	objectsHtml	->	GetobjectHtml($this -> fields[liquidacion_guias_cliente_id]));			
			$this	->	assign("CONSECUTIVO",		$this	->	objectsHtml	->	GetobjectHtml($this -> fields[consecutivo]));	
			$this	->	assign("OFICINAID",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[oficina_id]));	
			$this	->	assign("USUARIOID",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[usuario_id]));	
			
			$this	->	assign("CLIENTE",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[cliente]));
			$this	->	assign("CLIENTEID",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[cliente_id]));
			$this	->	assign("DESDE",				$this	->	objectsHtml	->	GetobjectHtml($this -> fields[fecha_inicial]));
			$this	->	assign("HASTA",				$this	->	objectsHtml	->	GetobjectHtml($this -> fields[fecha_final]));
			$this	->	assign("FECHA_REG",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[fecha_registro]));
			$this	->	assign("GUIASID",			$this	->	objectsHtml	->	GetobjectHtml($this -> fields[guias_id]));
			$this	->	assign("VALOR",				$this	->	objectsHtml	->	GetobjectHtml($this -> fields[valor]));
			$this	->	assign("OBSERVANULACION",	$this	->	objectsHtml	->	GetobjectHtml($this -> fields[observacion_anulacion]));
			$this	->	assign("UltimaLiquidacion",	$this	->	objectsHtml	->	GetobjectHtml($this -> fields[UltimaLiquidacion]));

			$this	->	assign("IMPORTARSOLICITUD",	$this	->	objectsHtml	->	GetobjectHtml($this -> fields[importSolicitud]));

			if($this -> Guardar)
				$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
			if($this -> Anular)
				$this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));

			if($this -> Imprimir)
				$this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));

			if($this -> Limpiar)
				$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}
	   public function setOficinas($oficinas){
		 $this -> fields[oficina_id1]['options'] = $oficinas;
		 $this -> assign("OFICINAID1",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id1]));      
	   }   

		public function setEstado($opciones){
			$this -> fields[estado]['options'] = $opciones;
			$this	->	assign("ESTADO",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[estado]));
		}

		public function RenderMain(){
			$this ->RenderLayout('LiquidacionGuiasCliente.tpl');
		}
	}
?>