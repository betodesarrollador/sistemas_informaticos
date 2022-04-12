<?php
require_once("../../../framework/clases/ViewClass.php");

final class AutorizaPagoLayout extends View{

	private $fields;
	private $Guardar;
	private $Actualizar;
	private $Borrar;
	private $Limpiar;

	public function setGuardar($Permiso){
		$this	->	Guardar = $Permiso;
	}

	public function setActualizar($Permiso){
		$this	->	Actualizar = $Permiso;
	}

	public function setBorrar($Permiso){
		$this	->	Borrar = $Permiso;
	}

   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   }

	public function setLimpiar($Permiso){
		$this	->	Limpiar = $Permiso;
	}

	public function setCampos($campos){
		require_once("../../../framework/clases/FormClass.php");

		$Form1	=	new Form("AutorizaPagoClass.php","AutorizaPagoForm","AutorizaPagoForm");
		$this	->	fields		=	$campos;
		$this	->	TplInclude	->	IncludeCss("/rotterdan/framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("/rotterdan/framework/css/reset.css");
		$this	->	TplInclude	->	IncludeCss("/rotterdan/framework/css/general.css");
		$this	->	TplInclude	->	IncludeCss("/rotterdan/framework/css/jquery.alerts.css");
		$this	->	TplInclude	->	IncludeCss("/rotterdan/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/jquery.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/jqueryform.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/funciones.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/ajax-list.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/ajax-dynamic-list.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/proveedores/pago/js/AutorizaPago.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/jquery.alerts.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("/rotterdan/framework/js/jquery.filestyle.js");

		$this	->	assign("CSSSYSTEM",				$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",			$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("FORM1",					$Form1	->	FormBegin());
		$this	->	assign("FORM1END",				$Form1	->	FormEnd());
		$this	->	assign("DESDE",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desde]));
		$this	->	assign("HASTA",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[hasta]));

		$this	->	assign("PROVEEDOR",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[proveedor]));
		$this	->	assign("PROVEEDORID",					$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[proveedor_id]));

		
		if($this ->	Guardar)
		$this	->	assign("GENERAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[generar]));
		$this	->	assign("GENERAREXCEL",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[generar_excel]));
		$this	->	assign("GENERAREXCEL2",			$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[imprimir2]));

		if($this ->	Actualizar){
			$this	->	assign("ACTUALIZAR",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[actualizar]));
			$this	->	assign("CONTABILIZAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[contabilizar]));
		}
		if($this ->	Borrar)
		$this	->	assign("BORRAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[borrar]));

		 if($this -> Imprimir)
		   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
		   $this -> assign("IMPRIMIR1",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir1]));	 
		   

		if($this ->	Limpiar)
		$this	->	assign("LIMPIAR",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limpiar]));
	}


	public function RenderMain(){
		$this	->	RenderLayout('AutorizaPago.tpl');
	}
}
?>