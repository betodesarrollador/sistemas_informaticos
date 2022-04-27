<?php
require_once("../../../framework/clases/ViewClass.php");

final class RelacionFacturaLayout extends View{

	private $fields;
	private $Guardar;
	private $Actualizar;
	private $Limpiar;

	public function setGuardar($Permiso){
		$this	->	Guardar = $Permiso;
	}

	public function setActualizar($Permiso){
		$this	->	Actualizar = $Permiso;
	}

   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   }

	public function setLimpiar($Permiso){
		$this	->	Limpiar = $Permiso;
	}

	public function setCampos($campos){
		require_once("../../../framework/clases/FormClass.php");

		$Form1	=	new Form("RelacionFacturaClass.php","RelacionFacturaForm","RelacionFacturaForm");
		$this	->	fields		=	$campos;
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
		$this	->	TplInclude	->	IncludeJs("../../../facturacion/relacionfactura/js/RelacionFactura.js");
		$this	->	TplInclude	->	IncludeJs("../../../facturacion/relacionfactura/js/DetallesRelacionFactura.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

		$this	->	assign("CSSSYSTEM",				$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",			$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("FORM1",					$Form1	->	FormBegin());
		$this	->	assign("FORM1END",				$Form1	->	FormEnd());
		$this	->	assign("BUSQUEDA",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("SOLICITUDID",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[remesa_id]));
		$this 	->  assign("DESDE",					$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_inicio]));	
		$this 	->  assign("SOLICITUD",				$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[solicitud_id]));	
		$this 	->  assign("NUMEROREMESAS",			$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[numero_remesas]));	
		$this	->  assign("HASTA",					$this 	-> 	objectsHtml -> 	GetobjectHtml($this ->  fields[fecha_final]));

		if($this ->	Guardar)
		$this	->	assign("GUARDAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[guardar]));
		$this	->	assign("GENERAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[generar]));
		$this	->	assign("GENERAREXCEL",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[generar_excel]));

		if($this ->	Actualizar){
			$this	->	assign("RENOVAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[renovar]));
			$this	->	assign("FINALIZAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[finalizar]));
			$this	->	assign("CONTABILIZAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contabilizar]));
		}

		 if($this -> Imprimir)
		   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 

		if($this ->	Limpiar)
		$this	->	assign("LIMPIAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limpiar]));
		}


	public function RenderMain(){
		$this	->	RenderLayout('RelacionFactura.tpl');
	}
}
?>