<?php

require_once("../../../framework/clases/ViewClass.php");

final class OrganizaImprimirLayout extends View{

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

		$Form1      = new Form("OrganizaImprimirDocumentosClass.php","OrganizaImprimirForm");

		$this -> fields = $campos;

		$this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
		$this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
		$this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
		$this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/OrganizaImprimir.css");	 
		$this -> TplInclude -> IncludeCss("../../../framework/css/jquery.autocomplete.css");	 	 	 

		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.autocomplete.js");		 
		$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/funcionesDetalle.js");	 	 
		$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
		$this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");

		$this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
		$this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	}
}

?>