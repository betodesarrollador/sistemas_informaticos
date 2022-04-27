<?php
	require_once("../../../framework/clases/ViewClass.php");

	final class EntregaPruebaLayout extends View{

		private $fields;

		public function setGuardar($Permiso){
			$this -> Guardar = $Permiso;
		}

		public function setActualizar($Permiso){
			$this -> Actualizar = $Permiso;
		}

		public function setAnular($Permiso){
			$this -> Anular = $Permiso;
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
			$Form1 = new Form("EntregaPruebaClass.php","EntregaPruebaForm","EntregaPruebaForm");

			$this -> fields = $campos;

			$this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
			$this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
			$this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/EntregasPrueba.css");

			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
			$this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/EntregaPrueba.js");
			$this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");

			$this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
			$this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
			$this -> assign("FORM1",			$Form1 -> FormBegin());
			$this -> assign("FORM1END",			$Form1 -> FormEnd());
			$this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));

			$this -> assign("FECHASTATIC",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static]));
			$this -> assign("EMPRESAIDSTATIC",	$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id_static]));
			$this -> assign("OFICINAIDSTATIC",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_static]));
			$this -> assign("OFICINAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
			$this -> assign("EMPRESAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));

			$this -> assign("ENTREGAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[entrega_id]));


			$this -> assign("FECHA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ent]));
			$this -> assign("HORA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_ent]));
			$this -> assign("FECHAREG",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));
			
			$this -> assign("PROVEEDOR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));
			$this -> assign("PROVEEDORID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));
			$this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));

			$this -> assign("OBSERVACIONES",	$this -> objectsHtml -> GetobjectHtml($this -> fields[obser_ent]));
			$this -> assign("OBSERVANULACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));

			if($this -> Guardar)
			$this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

			if($this -> Actualizar){
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
			}
			if($this -> Anular)
			$this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));

			if($this -> Borrar)
			$this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

			if($this -> Limpiar)
			$this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

			if($this -> Imprimir)
			$this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));


			$this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
			$this -> assign("USUARIOREGISTRA",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra]));
			$this -> assign("USUARIONUMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra_numero_identificacion]));
		}

		//LISTA MENU
		public function setCausalesAnulacion($causales){
			$this -> fields[causal_anulacion_id]['options'] = $causales;
			$this -> assign("CAUSALANULACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));
		}

		//// GRID ////
		public function SetGridEntrega($Attributes,$Titles,$Cols,$Query){
			require_once("../../../framework/clases/grid/JqGridClass.php");
			$TableGrid = new JqGrid();
			$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
			$this -> assign("GRIDENTREGA",$TableGrid -> RenderJqGrid());
			$this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
			$this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
		}

		public function RenderMain(){
			$this ->RenderLayout('EntregaPrueba.tpl');
		}
	}
?>