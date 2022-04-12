<?php
require_once("../../../framework/clases/ControlerClass.php");

final class AutorizaPago extends Controler{

	public function __construct(){
		parent::__construct(2);	
	}

	public function Main(){

		$this -> noCache();

		require_once("AutorizaPagoLayoutClass.php");
		require_once("AutorizaPagoModelClass.php");

		$Layout	=	new	AutorizaPagoLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model	=	new	AutorizaPagoModel();

		$Model	->	SetUsuarioId($this	->	getUsuarioId(),$this	->	getOficinaId());

		$Layout -> setGuardar   	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
		$Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
		$Layout -> setBorrar    	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
		$Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setLimpiar   	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

		$Layout -> setCampos($this -> Campos);

		
		$Layout -> RenderMain();
	}

	
	protected function onclickPrint(){
		require_once("AutorizaPagoClass.php");
		$print = new AutorizaPagoClass($this -> getConex());
		$print -> printOut();
	 }

	protected function onclickContabilizar(){

		require_once("AutorizaPagoModelClass.php");
		$Model = new AutorizaPagoModel();

		include_once("UtilidadesContablesModelClass.php");
		$utilidadesContables = new UtilidadesContablesModel(); 	


		$data = $Model -> Contabilizar($this -> getEmpresaId(),$this->getUsuarioId(),$this->getOficinaId(),$this -> getUsuarioNombres(),$this -> getConex());
		exit("$data");
	}


	protected function generateReporte(){

		require_once("AutorizaPagoModelClass.php");
		require_once("AutorizaPagoLayoutClass.php");
		$Model	= new AutorizaPagoModel();
		$Layout	= new AutorizaPagoLayout();

		$desde = $_REQUEST['desde'];
		$hasta = $_REQUEST['hasta'];
		$proveedor_id = $_REQUEST['proveedor_id'];
		
		if($proveedor_id>0){
			$consulta_proveedor = " AND proveedor_id =".$proveedor_id;
		}else{
			$consulta_proveedor = '';
		}
			
		$Layout -> setCssInclude("/rotterdan/framework/css/reset.css");
		$Layout -> setCssInclude("/rotterdan/framework/css/general.css");
		$Layout -> setCssInclude("/rotterdan/framework/css/generalDetalle.css");
		$Layout -> setCssInclude("/rotterdan/framework/css/jquery.alerts.css");

		$Layout -> setJsInclude("/rotterdan/framework/js/jquery.js");		
		$Layout -> setJsInclude("/rotterdan/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$Layout	-> setJsInclude("/rotterdan/framework/js/jqueryform.js");
		$Layout	-> setJsInclude("/rotterdan/framework/js/funciones.js");
		$Layout -> setJsInclude("/rotterdan/proveedores/pago/js/AutorizaPago.js");
		$Layout -> setJsInclude("/rotterdan/framework/js/jquery.alerts.js");
		
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());

		$Layout -> assign("DESDE",$desde);
		$Layout -> assign("HASTA",$hasta);

		if($_REQUEST['download']!='SI'){
			$data = $Model -> generateReporte($desde,$hasta,$consulta_proveedor,$this -> getConex());
		}else{
			$data = $Model -> generateReporteexcel($desde,$hasta,$consulta_proveedor,$this -> getConex());
		}

		$Layout -> setVar("DATA",$data);
		$Layout -> setVar("PRINTERS",$_REQUEST['printers']);
		//$Layout -> setVar("ACTIVOS",$data2);
		
		if($_REQUEST['download']=='SI'){
			$ruta  = $this -> arrayToExcel("AutorizaPago","AutorizaPago",$data,null);
			$this -> ForceDownload($ruta);	
		}else{
			$Layout	-> RenderLayout('DetallesAutorizaPago.tpl');
		}
	}

	protected function generateReporte1(){

		require_once("AutorizaPagoModelClass.php");
		require_once("AutorizaPagoLayoutClass.php");
		$Model	= new AutorizaPagoModel();
		$Layout	= new AutorizaPagoLayout();

		$desde = $_REQUEST['desde'];
		$hasta = $_REQUEST['hasta'];
		$proveedor_id = $_REQUEST['proveedor_id'];
		
		if($proveedor_id>0){
			$consulta_proveedor = " AND proveedor_id =".$proveedor_id;
		}else{
			$consulta_proveedor = '';
		}
		
		$Layout -> setCssInclude("/rotterdan/framework/css/reset.css");
		$Layout -> setCssInclude("/rotterdan/framework/css/general.css");
		$Layout -> setCssInclude("/rotterdan/framework/css/generalDetalle.css");
		$Layout -> setCssInclude("/rotterdan/framework/css/jquery.alerts.css");

		$Layout -> setJsInclude("/rotterdan/framework/js/jquery.js");		
		$Layout -> setJsInclude("/rotterdan/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
		$Layout	-> setJsInclude("/rotterdan/framework/js/jqueryform.js");
		$Layout	-> setJsInclude("/rotterdan/framework/js/funciones.js");
		$Layout -> setJsInclude("/rotterdan/proveedores/pago/js/AutorizaPago.js");
		$Layout -> setJsInclude("/rotterdan/framework/js/jquery.alerts.js");
		
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		
		$Layout -> assign("DESDE",$desde);
		$Layout -> assign("HASTA",$hasta);

		//$data = $Model -> generateReporte1($desde,$hasta,$consulta_proveedor,$this -> getConex());
		$data = $Model -> generateReporte1($desde,$hasta,$consulta_proveedor,$this -> getConex());


		$Layout -> setVar("DATA",$data);
		$Layout -> setVar("PRINTERS",$_REQUEST['printers']);
		//$Layout -> setVar("ACTIVOS",$data2);
		
		if($_REQUEST['download']=='SI'){
			$ruta  = $this -> arrayToExcel("AutorizaPago","AutorizaPago",$data,null);
			$this -> ForceDownload($ruta);	
		}else{
			$Layout	-> RenderLayout('DetallesAutorizaPago1.tpl');
		}
		
		
	}


	//BUSQUEDA
	protected function onclickFind(){
		require_once("AutorizaPagoModelClass.php");
		$Model = new AutorizaPagoModel();

		$activo_id = $this -> requestDataForQuery("activo_id");
		$Data  = $Model -> selectDatos($activo_id,$this -> getConex());
		$this -> getArrayJSON($Data);
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
		
		$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_hidden',
		type	=>'hidden',
		value	=>'',
		//required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		suggest=>array(
			name	=>'proveedor',
			setId	=>'proveedor_hidden')
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
			value	=>'Autorizar Facturas',
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
		  value   =>'Imprimir Autorizados',
		  onclick =>'beforePrint(this.form)'

		);	

		$this -> Campos[imprimir1] = array(
		  name    =>'imprimir1',
		  id      =>'imprimir1',
		  type    =>'button',
		  value   =>'Imprimir Pendientes',
		  onclick =>'beforePrint1(this.form)'

		);	
		
		$this -> Campos[imprimir2] = array(
		  name    =>'imprimir2',
		  id      =>'imprimir2',
		  type    =>'button',
		  value   =>'Autorizados Excel',
		  onclick =>'generateReporteExcelAutorizados(this.form)'

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
			type	=>'button',
			value	=>'Limpiar',
			//tabindex=>'22',
			onclick	=>'ResetForm(this.form)'
		);

		//busqueda
		
		$this -> SetVarsValidate($this -> Campos);
	}
}
$AutorizaPago = new AutorizaPago();
?>