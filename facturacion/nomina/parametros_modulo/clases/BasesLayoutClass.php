<?php
require_once("../../../framework/clases/ViewClass.php");

final class BasesLayout extends View{

	private $fields;

	public function SetGuardar($Permiso){
		$this -> Guardar = $Permiso;
	}

	public function SetActualizar($Permiso){
		$this -> Actualizar = $Permiso;
	}

	public function SetBorrar($Permiso){
		$this -> Borrar = $Permiso;
	}

	public function SetLimpiar($Permiso){
		$this -> Limpiar = $Permiso;
	}

	public function SetCampos($campos){

		require_once("../../../framework/clases/FormClass.php");
		$Form1      = new Form("BasesClass.php","BasesForm","BasesForm");
		$this	->	fields	=	$campos;

		$this	->	TplInclude	->	IncludeCss("../../../framework/css/ajax-dynamic-list.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/reset.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/general.css");
		$this	->	TplInclude	->	IncludeCss("../../../framework/css/jquery.alerts.css");
	   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");		 

		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajaxupload.3.6.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqueryform.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/funciones.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/general.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-list.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/ajax-dynamic-list.js");
		$this	->	TplInclude	->	IncludeJs("../js/bases.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
		$this	->	TplInclude	->	IncludeJs("../../../framework/js/jquery.filestyle.js");

		$this	->	assign("FORM1",			$Form1	->	FormBegin());
		$this	->	assign("FORM1END",		$Form1	->	FormEnd());
		$this	->	assign("CSSSYSTEM",		$this	->	TplInclude	->	GetCssInclude());
		$this	->	assign("JAVASCRIPT",	$this	->	TplInclude	->	GetJsInclude());
		$this	->	assign("BUSQUEDA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[busqueda]));
		$this	->	assign("BASEID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[id_datos]));
		$this	->	assign("SALARIO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[salrio]));
		$this	->	assign("LIMSUB",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limite_subsidio]));
		$this	->	assign("NOSALARIAL",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[nossalarial]));
		
		$this	->	assign("PUCADMONSALID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_sal_id]));
		$this	->	assign("PUCADMONSAL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_sal]));
		$this	->	assign("PUCVENTASSALID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_sal_id]));
		$this	->	assign("PUCVENTASSAL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_sal]));
		$this	->	assign("PUCPRODUCCSALID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_sal_id]));
		$this	->	assign("PUCPRODUCCSAL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_sal]));
		$this	->	assign("PUCCONTRASALID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_sal_id]));
		$this	->	assign("PUCCONTRASAL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_sal]));

		$this	->	assign("PUCADMONNOSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_nos_id]));
		$this	->	assign("PUCADMONNOS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_nos]));
		$this	->	assign("PUCVENTASNOSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_nos_id]));
		$this	->	assign("PUCVENTASNOS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_nos]));
		$this	->	assign("PUCPRODUCCNOSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_nos_id]));
		$this	->	assign("PUCPRODUCCNOS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_nos]));
		$this	->	assign("PUCCONTRANOSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_nos_id]));
		$this	->	assign("PUCCONTRANOS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_nos]));

		$this	->	assign("PUCADMONTRANSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_trans_id]));
		$this	->	assign("PUCADMONTRANS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_trans]));
		$this	->	assign("PUCVENTASTRANSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_trans_id]));
		$this	->	assign("PUCVENTASTRANS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_trans]));
		$this	->	assign("PUCPRODUCCTRANSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_trans_id]));
		$this	->	assign("PUCPRODUCCTRANS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_trans]));
		$this	->	assign("PUCCONTRATRANSID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_trans_id]));
		$this	->	assign("PUCCONTRATRANS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_trans]));

		$this	->	assign("PUCADMONSALUDID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_salud_id]));
		$this	->	assign("PUCADMONSALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_salud]));
		$this	->	assign("PUCVENTASSALUDID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_salud_id]));
		$this	->	assign("PUCVENTASSALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_salud]));
		$this	->	assign("PUCPRODUCCSALUDID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_salud_id]));
		$this	->	assign("PUCPRODUCCSALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_salud]));
		$this	->	assign("PUCCONTRASALUDID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_salud_id]));
		$this	->	assign("PUCCONTRASALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_salud]));


		$this	->	assign("PUCADMONPENSIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_pension_id]));
		$this	->	assign("PUCADMONPENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_pension]));
		$this	->	assign("PUCVENTASPENSIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_pension_id]));
		$this	->	assign("PUCVENTASPENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_pension]));
		$this	->	assign("PUCPRODUCCPENSIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_pension_id]));
		$this	->	assign("PUCPRODUCCPENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_pension]));
		$this	->	assign("PUCCONTRAPENSIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_pension_id]));
		$this	->	assign("PUCCONTRAPENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_pension]));

		$this	->	assign("PUCADMONCAJAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_caja_id]));
		$this	->	assign("PUCADMONCAJA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_caja]));
		$this	->	assign("PUCVENTASCAJAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_caja_id]));
		$this	->	assign("PUCVENTASCAJA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_caja]));
		$this	->	assign("PUCPRODUCCCAJAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_caja_id]));
		$this	->	assign("PUCPRODUCCCAJA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_caja]));
		$this	->	assign("PUCCONTRACAJAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_caja_id]));
		$this	->	assign("PUCCONTRACAJA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_caja]));

		$this	->	assign("PUCADMONICBFID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_icbf_id]));
		$this	->	assign("PUCADMONICBF",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_icbf]));
		$this	->	assign("PUCVENTASICBFID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_icbf_id]));
		$this	->	assign("PUCVENTASICBF",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_icbf]));
		$this	->	assign("PUCPRODUCCICBFID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_icbf_id]));
		$this	->	assign("PUCPRODUCCICBF",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_icbf]));
		$this	->	assign("PUCCONTRAICBFID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_icbf_id]));
		$this	->	assign("PUCCONTRAICBF",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_icbf]));

		$this	->	assign("PUCADMONSENAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_sena_id]));
		$this	->	assign("PUCADMONSENA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_sena]));
		$this	->	assign("PUCVENTASSENAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_sena_id]));
		$this	->	assign("PUCVENTASSENA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_sena]));
		$this	->	assign("PUCPRODUCCSENAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_sena_id]));
		$this	->	assign("PUCPRODUCCSENA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_sena]));
		$this	->	assign("PUCCONTRASENAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_sena_id]));
		$this	->	assign("PUCCONTRASENA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_sena]));


		$this	->	assign("PUCADMONVACAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_vaca_id]));
		$this	->	assign("PUCADMONVACA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_vaca]));
		$this	->	assign("PUCVENTASVACAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_vaca_id]));
		$this	->	assign("PUCVENTASVACA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_vaca]));
		$this	->	assign("PUCPRODUCCVACAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_vaca_id]));
		$this	->	assign("PUCPRODUCCVACA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_vaca]));
		$this	->	assign("PUCCONTRAVACAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_vaca_id]));
		$this	->	assign("PUCCONTRAVACA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_vaca]));


		$this	->	assign("PUCADMONPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_prima_id]));
		$this	->	assign("PUCADMONPRIMA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_prima]));
		$this	->	assign("PUCVENTASPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_prima_id]));
		$this	->	assign("PUCVENTASPRIMA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_prima]));
		$this	->	assign("PUCPRODUCCPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_prima_id]));
		$this	->	assign("PUCPRODUCCPRIMA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_prima]));
		$this	->	assign("PUCCONTRAPRIMAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_prima_id]));
		$this	->	assign("PUCCONTRAPRIMA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_prima]));

		$this	->	assign("PUCADMONCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_cesan_id]));
		$this	->	assign("PUCADMONCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_cesan]));
		$this	->	assign("PUCVENTASCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_cesan_id]));
		$this	->	assign("PUCVENTASCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_cesan]));
		$this	->	assign("PUCPRODUCCCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_cesan_id]));
		$this	->	assign("PUCPRODUCCCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_cesan]));
		$this	->	assign("PUCCONTRACESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_cesan_id]));
		$this	->	assign("PUCCONTRACESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_cesan]));

		$this	->	assign("PUCADMONINCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_incesan_id]));
		$this	->	assign("PUCADMONINCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_incesan]));
		$this	->	assign("PUCVENTASINCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_incesan_id]));
		$this	->	assign("PUCVENTASINCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_incesan]));
		$this	->	assign("PUCPRODUCCINCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_incesan_id]));
		$this	->	assign("PUCPRODUCCINCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_incesan]));
		$this	->	assign("PUCCONTRAINCESANID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_incesan_id]));
		$this	->	assign("PUCCONTRAINCESAN",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_incesan]));


		$this	->	assign("PUCADMONARLID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_arl_id]));
		$this	->	assign("PUCADMONARL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_arl]));
		$this	->	assign("PUCVENTASARLID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_arl_id]));
		$this	->	assign("PUCVENTASARL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_arl]));
		$this	->	assign("PUCPRODUCCARLID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_arl_id]));
		$this	->	assign("PUCPRODUCCARL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_arl]));
		$this	->	assign("PUCCONTRAARLID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_arl_id]));
		$this	->	assign("PUCCONTRAARL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_arl]));


		$this	->	assign("PUCADMONEXTRADIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_extradiu_id]));
		$this	->	assign("PUCADMONEXTRADIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_extradiu]));
		$this	->	assign("PUCVENTASEXTRADIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_extradiu_id]));
		$this	->	assign("PUCVENTASEXTRADIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_extradiu]));
		$this	->	assign("PUCPRODUCCEXTRADIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_extradiu_id]));
		$this	->	assign("PUCPRODUCCEXTRADIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_extradiu]));
		$this	->	assign("PUCCONTRAEXTRADIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_extradiu_id]));
		$this	->	assign("PUCCONTRAEXTRADIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_extradiu]));

		$this	->	assign("PUCADMONEXTRANOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_extranoc_id]));
		$this	->	assign("PUCADMONEXTRANOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_extranoc]));
		$this	->	assign("PUCVENTASEXTRANOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_extranoc_id]));
		$this	->	assign("PUCVENTASEXTRANOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_extranoc]));
		$this	->	assign("PUCPRODUCCEXTRANOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_extranoc_id]));
		$this	->	assign("PUCPRODUCCEXTRANOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_extranoc]));
		$this	->	assign("PUCCONTRAEXTRANOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_extranoc_id]));
		$this	->	assign("PUCCONTRAEXTRANOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_extranoc]));



		$this	->	assign("PUCADMONFESDIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_fesdiu_id]));
		$this	->	assign("PUCADMONFESDIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_fesdiu]));
		$this	->	assign("PUCVENTASFESDIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_fesdiu_id]));
		$this	->	assign("PUCVENTASFESDIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_fesdiu]));
		$this	->	assign("PUCPRODUCCFESDIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_fesdiu_id]));
		$this	->	assign("PUCPRODUCCFESDIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_fesdiu]));
		$this	->	assign("PUCCONTRAFESDIUID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_fesdiu_id]));
		$this	->	assign("PUCCONTRAFESDIU",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_fesdiu]));

		$this	->	assign("PUCADMONFESNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_fesnoc_id]));
		$this	->	assign("PUCADMONFESNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_fesnoc]));
		$this	->	assign("PUCVENTASFESNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_fesnoc_id]));
		$this	->	assign("PUCVENTASFESNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_fesnoc]));
		$this	->	assign("PUCPRODUCCFESNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_fesnoc_id]));
		$this	->	assign("PUCPRODUCCFESNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_fesnoc]));
		$this	->	assign("PUCCONTRAFESNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_fesnoc_id]));
		$this	->	assign("PUCCONTRAFESNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_fesnoc]));

		$this	->	assign("PUCADMONRECNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_recnoc_id]));
		$this	->	assign("PUCADMONRECNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_recnoc]));
		$this	->	assign("PUCVENTASRECNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_recnoc_id]));
		$this	->	assign("PUCVENTASRECNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_recnoc]));
		$this	->	assign("PUCPRODUCCRECNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_recnoc_id]));
		$this	->	assign("PUCPRODUCCRECNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_recnoc]));
		$this	->	assign("PUCCONTRARECNOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_recnoc_id]));
		$this	->	assign("PUCCONTRARECNOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_recnoc]));
		
		
		$this	->	assign("PUCADMONRECDOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_recdoc_id]));
		$this	->	assign("PUCADMONRECDOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_recdoc]));
		$this	->	assign("PUCVENTASRECDOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_recdoc_id]));
		$this	->	assign("PUCVENTASRECDOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_recdoc]));
		$this	->	assign("PUCPRODUCCRECDOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_recdoc_id]));
		$this	->	assign("PUCPRODUCCRECDOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_recdoc]));
		$this	->	assign("PUCCONTRARECDOCID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_recdoc_id]));
		$this	->	assign("PUCCONTRARECDOC",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_recdoc]));


		$this	->	assign("PUCADMONINDEMID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_indem_id]));
		$this	->	assign("PUCADMONINDEM",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_admon_indem]));
		$this	->	assign("PUCVENTASINDEMID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_indem_id]));
		$this	->	assign("PUCVENTASINDEM",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_ventas_indem]));
		$this	->	assign("PUCPRODUCCINDEMID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_indem_id]));
		$this	->	assign("PUCPRODUCCINDEM",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_produ_indem]));
		$this	->	assign("PUCCONTRAINDEMID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_indem_id]));
		$this	->	assign("PUCCONTRAINDEM",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_indem]));

		$this	->	assign("SUBTRANSPORTE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sub_transporte]));
		$this	->	assign("DIASLAB",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[dias_lab]));
		$this	->	assign("DIASLABMES",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[dias_lab_mes]));
		$this	->	assign("HORASDIA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_dia]));
		$this	->	assign("HORASLABDIA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[horas_lab_dia]));
		$this	->	assign("DESCEMPLESALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_emple_salud]));
		$this	->	assign("DESCEMPLEPENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_emple_pension]));
		$this	->	assign("DESCEMPRESALUD",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_salud]));
		$this	->	assign("DESCEMPREPENSION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_pens]));
		$this	->	assign("DESCESANTIAS",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_cesantias]));
		$this	->	assign("DESCESANTIASINT",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_int_cesantias]));
		$this	->	assign("DESCEMPREVACACIONES",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_vacaciones]));
		$this	->	assign("DESCPRIMASERV",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_prima_serv]));
		$this	->	assign("DESCAJACOMP",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_caja_comp]));
		$this	->	assign("DESCICBF",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_icbf]));
		$this	->	assign("DESCSENA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_empre_sena]));
		$this	->	assign("HORACORRIENTE",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_hr_corriente]));
		$this	->	assign("HORAEXTRADIURNA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_hr_ext_diurna]));
		$this	->	assign("HORAEXTRANOCTURNA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_hr_ext_nocturna]));
		$this	->	assign("HORAFESTDIURNA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_hr_ext_festiva_diurna]));
		$this	->	assign("HORAFESTNOCTURNA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_hr_ext_festiva_nocturna]));
		$this	->	assign("HORARECNOCTURNA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_recargo_nocturna]));
		$this	->	assign("HORARECDOMINICAL",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[val_recargo_dominical]));


		$this	->	assign("TERCEROICBFID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tercero_icbf_id]));
		$this	->	assign("TERCEROICBF",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tercero_icbf]));
		$this	->	assign("TERCEROSENAID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tercero_sena_id]));
		$this	->	assign("TERCEROSENA",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[tercero_sena]));


		$this	->	assign("DIASINDEM",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[dias_anio_indem]));
		$this	->	assign("DIAS2INDEM",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[dias_2anio_indem]));



		$this	->	assign("DESC_FONDO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[desc_emple_fonpension]));
		$this	->	assign("PUCCONTRAFONDPENID",$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_fonpension_id]));
		$this	->	assign("PUCCONTRAFONDPEN",	$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_fonpension]));
		$this	->	assign("LIMITEFONDO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[limite_fondo]));
		$this	->	assign("PUCRETENCIONID",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_retencion_id]));
		$this	->	assign("PUCRETENCION",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[puc_contra_retencion]));
		// $this	->	assign("PERIODONUEVO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[periodo_contable_nuevo]));
		$this	->	assign("SALARIONUEVO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[salario_nuevo]));
		$this	->	assign("SUBSIDIONUEVO",		$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[sub_nuevo]));

		if($this -> Guardar)
			$this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

		if($this -> Actualizar)
			$this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   		$this -> assign("DUPLICAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[duplicar]));

		if($this -> Borrar)
			$this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));

		if($this -> Limpiar)
			$this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	}

	public function SetPeriodoContable($periodo_contable_id){
		$this -> fields[periodo_contable_id]['options'] = $periodo_contable_id;
		$this -> assign("PERIODOCONTABLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_contable_id]));
	}

	public function SetPeriodoContableNuevo($periodo_contable_nuevo){
		$this -> fields[periodo_contable_nuevo]['options'] = $periodo_contable_nuevo;
		$this -> assign("PERIODONUEVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_contable_nuevo]));
	}

   public function SetTiposDocumentoContable($DocumentosContables){
	 $this -> fields[tipo_documento_id]['options'] = $DocumentosContables;
	 $this -> assign("DOCUMENTOCONTABLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));	 
   }


	public function SetGridBases($Attributes,$Titles,$Cols,$Query){
		require_once("../../../framework/clases/grid/JqGridClass.php");
		$TableGrid = new JqGrid();
		$TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
		
		$head = "'<head>".
	 
		$TableGrid -> GetJqGridJs()." ".
		
		$TableGrid -> GetJqGridCss()."
		
		</head>";
		
		$body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
		
		return "<html>".$head." ".$body."</html>";
	}

	public function RenderMain(){
		$this ->RenderLayout('bases.tpl');
	}
}
?>