<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Contabilizar extends Controler{

	public function __construct(){
		parent::__construct(2);	
	}

	public function Main(){

		$this -> noCache();

		require_once("ContabilizarLayoutClass.php");
		require_once("ContabilizarModelClass.php");

		$Layout	=	new	ContabilizarLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model	=	new	ContabilizarModel();

		$Model	->	SetUsuarioId($this	->	getUsuarioId(),$this	->	getOficinaId());

		$Layout -> setGuardar   	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setBorrar    	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
		$Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setLimpiar   	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

		$Layout -> setCampos($this -> Campos);

		
		$Layout -> RenderMain();
	}

	

	protected function onclickContabilizar(){

		require_once("ContabilizarModelClass.php");
		$Model = new ContabilizarModel();

		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
		$utilidadesContables = new UtilidadesContablesModel(); 	


		$data = $Model -> Contabilizar($this -> getEmpresaId(),$this->getUsuarioId(),$this->getOficinaId(),$this -> getUsuarioNombres(),$this -> getConex());
		exit("$data");
	}


	protected function generateReporte(){

		require_once("ContabilizarModelClass.php");
		require_once("ContabilizarLayoutClass.php");
		$Model	= new ContabilizarModel();
		$Layout	= new ContabilizarLayout();

		$desde = $_REQUEST['desde'];
		$hasta = $_REQUEST['hasta'];

		$Layout -> setCssInclude("../../../framework/css/reset.css");
		$Layout -> setCssInclude("../../../framework/css/general.css");
		$Layout -> setCssInclude("../../../framework/css/generalDetalle.css");
		$Layout -> setCssInclude("../../../framework/css/jquery.alerts.css");

		$Layout -> setJsInclude("../../../framework/js/jquery.js");		
		$Layout -> setJsInclude("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$Layout	-> setJsInclude("../../../framework/js/jqueryform.js");
		$Layout	-> setJsInclude("../../../framework/js/funciones.js");
		$Layout -> setJsInclude("../../../facturacion/contabilizar/js/Contabilizar.js");
		$Layout -> setJsInclude("../../../framework/js/jquery.alerts.js");
		
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		if($_REQUEST['download']!='SI'){
			$data = $Model -> generateReporte($desde,$hasta,$this -> getConex());
		}else{
			$data = $Model -> generateReporteexcel($desde,$hasta,$this -> getConex());
		}

		$Layout -> setVar("DATA",$data);
		$Layout -> setVar("PRINTERS",$_REQUEST['printers']);
		//$Layout -> setVar("ACTIVOS",$data2);
		
		if($_REQUEST['download']=='SI'){
			$ruta  = $this -> arrayToExcel("Contabilizar","Contabilizar",$data,null);
			$this -> ForceDownload($ruta);	
		}else{
			$Layout	-> RenderLayout('DetallesContabilizar.tpl');
		}
	}




	protected function setCampos(){

		//campos formulario


	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
        value   =>'',
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
        value   =>'',
		datatype=>array(
			type	=>'date')
	);	



		//botones

		$this -> Campos[generar] = array(
			name	=>'generar',
			id		=>'generar',
			type	=>'button',
			value	=>'Consultar Pendientes',
			onclick =>'generateReporte(this.form)'
		);

		$this -> Campos[generar_excel] = array(
			name	=>'generar_excel',
			id		=>'generar_excel',
			type	=>'button',
			value	=>'Pendientes Excel',
			onclick =>'generateReporteExcel(this.form)'
		);

		$this -> Campos[contabilizar] = array(
			name	=>'contabilizar',
			id		=>'contabilizar',
			type	=>'button',
			value	=>'Contabilizar',
			onclick =>'window.frames[0].contabilizar(this.form);'
		);

		$this -> Campos[actualizar] = array(
			name	=>'actualizar',
			id		=>'actualizar',
			type	=>'button',
			value	=>'Actualizar',
			disabled=>'disabled',
			onclick =>'OnUpdate(this.form)'
		);

		$this -> Campos[imprimir] = array(
		  name    =>'imprimir',
		  id      =>'imprimir',
		  type    =>'button',
		  value   =>'Imprimir',
		  onclick =>'beforePrint(this.form)'

		);	


		$this -> Campos[borrar] = array(
			name	=>'borrar',
			id		=>'borrar',
			type	=>'button',
			value	=>'Borrar',
			disabled=>'disabled',
			onclick =>'OnDelete(this.form)'
		);

		$this -> Campos[limpiar] = array(
			name	=>'limpiar',
			id		=>'limpiar',
			type	=>'reset',
			value	=>'Limpiar',
			onclick =>'ResetForm(this.form)'
		);

		//busqueda
		
		$this -> SetVarsValidate($this -> Campos);
	}
}
$Contabilizar = new Contabilizar();
?>