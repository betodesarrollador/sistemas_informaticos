<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class ParametrosGuiaCRMLayout extends View{

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

		public function setCampos($campos){

			require_once("../../../framework/clases/FormClass.php");
			$Form1      = new Form("ParametrosGuiaCRMClass.php","ParametrosGuiaCRMForm","ParametrosGuiaCRMForm");
			$this -> fields = $campos;
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
			//	 $this -> TplInclude -> IncludeCss("/velotax/seguimiento/parametros_modulo/css/ParametrosGuiaCRM.css");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/iColorPicker.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
			$this -> TplInclude -> IncludeJs("/velotax/mensajeria/parametros_modulo/js/ParametrosGuiaCRM.js");

			$this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
			$this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
			$this -> assign("FORM1",		$Form1 -> FormBegin());
			$this -> assign("FORM1END",		$Form1 -> FormEnd());
			$this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
			$this -> assign("PARAMETROID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_guia_crm_id]));
			$this -> assign("AGENCIA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
			$this -> assign("PREFIJO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[prefijo]));
			$this -> assign("FECHA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_rango_guia]));
			$this -> assign("INICIAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_guia_crm_ini]));
			$this -> assign("DISPOINICIAL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[inicio_disponible_res]));
			$this -> assign("TOTAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[total_rango_guia]));
			$this -> assign("FINAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_guia_crm_fin]));
			$this -> assign("UTILIZADO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[utilizado_rango_guia_crm]));
			$this -> assign("SALDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_rango_guia]));
			$this -> assign("RESOLUCION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_resolucion]));
			$this -> assign("ESTADO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
			$this -> assign("TIPO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));			
			$this -> assign("PUC1",			$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_puc1]));
			$this -> assign("PUC2",			$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_puc2]));
			$this -> assign("PUC3",			$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_puc3]));
			$this -> assign("PUC4",			$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_puc4]));			
			$this -> assign("PUCID1",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc1]));
			$this -> assign("PUCID2",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc2]));
			$this -> assign("PUCID3",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_costo]));
			$this -> assign("PUCID4",		$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_banco]));			

			$this -> assign("TERCEROID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));			
			$this -> assign("TERCERO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));			

			if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));

			if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
		}

		public function setServicio($servicio){
			$this->fields[tipo_bien_servicio_factura_id]['options'] = $servicio;
			$this->assign("TIPOSERVICIO",$this->objectsHtml->GetobjectHtml($this->fields[tipo_bien_servicio_factura_id]));
		}

		public function setCRM($CRM){
			$this->fields[oficina_id]['options'] = $CRM;
			$this->assign("CRM",$this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
		}

		//// GRID ////
		public function SetGridRangoGuia($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this -> assign("GRIDRANGOGUIA",	$TableGrid -> RenderJqGrid());
			$this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
			$this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
		}

		public function RenderMain(){
			$this -> RenderLayout('ParametrosGuiaCRM.tpl');
		}
	}
?>