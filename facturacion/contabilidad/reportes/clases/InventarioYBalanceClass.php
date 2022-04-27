<?php
set_time_limit(0);
require_once("../../../framework/clases/ControlerClass.php");
final class InventarioYBalance extends Controler{
  private $reporte;
  private $nivelReporte;
  private $Model;
  public function __construct(){
	parent::__construct(3);    
  }
  public function Main(){
	     
    $this -> noCache();
    
	require_once("InventarioYBalanceLayoutClass.php");
	require_once("InventarioYBalanceModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
	
	$Layout              = new InventarioYBalanceLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new InventarioYBalanceModel();
    $utilidadesContables = new UtilidadesContablesModel();  
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this->getConex()));			
	$Layout -> setNivelesPuc($utilidadesContables -> getNivelesPuc($this -> getConex()));				
	$Layout -> setCuentasPuc($Model -> getCuentasBalance($this -> getConex()));						
	$Layout -> RenderMain();	  
	  
  }  
  
	private function setInventarioYBalance($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$opciones_tercero,$opciones_centros,$nivel){
		
		
		if($nivel <= $this->nivelReporte){

			$Conex      = $this->getConex(); 
			$empresa_id = $this->getEmpresaId();

			$dataCuenta = $this->Model->getSaldoCuenta($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$empresa_id,$Conex);  
			
			if((is_numeric($dataCuenta['saldo_anterior']) && $dataCuenta['saldo_anterior'] != 0) ||
			(is_numeric($dataCuenta['debito']) && $dataCuenta['debito'] != 0) ||
			(is_numeric($dataCuenta['credito']) && $dataCuenta['credito'] != 0)	||
			(is_numeric($dataCuenta['nuevo_saldo']) && $dataCuenta['nuevo_saldo'] != 0)){
				array_push($this->reporte,$dataCuenta);
				
				if($this->Model->esCuentaMovimiento($puc_id,$Conex)){
                 
					if ($opciones_tercero != 'NN') {

						$dataCuenta = $this->Model->getSaldoCuentaTerceros($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Conex);
						
						foreach($dataCuenta as $llave => $valor){
							if(is_array($valor))array_push($this->reporte,$valor);
						}
					}

				}else{
					$sub_cuentas = $this->Model->selectSubCuentas($puc_id,$Conex);
					$nivel++;

					for($i = 0; $i < count($sub_cuentas); $i++){
						$this->setInventarioYBalance($opcierre,$sub_cuentas[$i]['puc_id'],$desde,$hasta,$centro_de_costo_id,$tercero_id,$opciones_tercero,$opciones_centros,$nivel); 
					}

				}
			}
		}
	}
  

	
	protected function onclickGenerarInventarioYBalance(){
	require_once("InventarioYBalanceLayoutClass.php");
	require_once("InventarioYBalanceModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");

	$Layout 				= new InventarioYBalanceLayout($this -> getTitleTab(),$this -> getTitleForm());
	$this->Model 			= new InventarioYBalanceModel();
	$utilidadesContables 	= new UtilidadesContablesModel();

	$this->reporte 		= array();
	$this->nivelReporte = $this->requestData('nivel');

	$Conex 				= $this -> getConex();
	$desde 				= $this->requestData('desde');
	$hasta 				= $this->requestData('hasta');
	$opciones_tercero 	= $this->requestData('opciones_tercero');
	$tercero_id 		= $this->requestData('tercero_id');
	$opciones_centros 	= $this->requestData('opciones_centros');	
	$opcierre			= $this->requestData('opciones_cierre');	
	$centro_de_costo_id = $this->requestData('centro_de_costo_id');
	$opciones_cuentas 	= $this->requestData('opciones_cuentas');

	$cuentas 			= explode(',',$this->requestData('cuentas'));

	$fechaProcesado 	= date("Y-m-d");
	$horaProcesado  	= date("H:i:s");

	$parametros 		= $utilidadesContables -> getParametrosReportes($Conex);
	$empresa 			= $this -> getEmpresaNombre();
	$nitEmpresa 		= $this -> getEmpresaIdentificacion();
	$centrosTxt 		= $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$Conex);
		
	for($i = 0; $i < count($cuentas); $i++){
		$this->setInventarioYBalance($opcierre,$cuentas[$i],$desde,$hasta,$centro_de_costo_id,$tercero_id,$opciones_tercero,$opciones_centros,1);
	}
    
	$cuentasniv1=$this->Model->getCuentasBalance($Conex);
	$sumdebito=0;
	$sumcredito=0;
	
	for($j = 0; $j < count($cuentasniv1); $j++){
		$dat_cuenta=$this->Model->getSaldoCuenta($opcierre,$cuentasniv1[$j][value],$desde,$hasta,$centro_de_costo_id,$tercero_id,$this->getEmpresaId(),$Conex);
		$sumdebito=$sumdebito+$dat_cuenta['debito'];
		$sumcredito=$sumcredito+$dat_cuenta['credito'];
	}
	
	$Layout -> setCssInclude("../../../framework/css/reset.css");			
	$Layout -> setCssInclude("../css/reportes.css");						
	$Layout -> setCssInclude("../css/reportes.css","print");
	$Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
	$Layout -> setJsInclude("../../../framework/js/funciones.js");
	$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
	$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());				
	$Layout -> setVar('NIVEL',$nivel);		
	$Layout -> setVar('EMPRESA',$empresa);	
	$Layout -> setVar('NIT',$nitEmpresa);	
	$Layout -> setVar('CENTROS',$centrosTxt);
	$Layout -> setVar('DESDE',$desde);
	$Layout -> setVar('HASTA',$hasta);
	$Layout -> setVar('parametros',$parametros);
	$Layout -> setVar('USUARIO',$this -> getUsuarioNombres());
	$Layout -> setVar('FECHA',$fechaProcesado);
	$Layout -> setVar('HORA',$horaProcesado);
	$Layout -> setVar('DEBITO',$sumdebito);
	$Layout -> setVar('CREDITO',$sumcredito);

	$Layout -> setVar('REPORTE',$this->reporte);

	$download = $_REQUEST['download'];

	if($download == 'true'){
		$Layout -> exportToExcel('InventarioYBalanceReporte.tpl');   
	}else{
	    $Layout -> RenderLayout('InventarioYBalanceReporte.tpl');
	}

	
  }  
  protected function onclickPrint(){}  
  
  protected function onclickExport(){}
  
  protected function setCampos(){
    /*****************************************
            	 datos sesion
	*****************************************/  
	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	
	
	$this -> Campos[opciones_centros] = array(
		name	=>'opciones_centros',
		id		=>'opciones_centros',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);	
	
	$this -> Campos[opciones_cuentas] = array(
		name	=>'opciones_cuentas',
		id		=>'opciones_cuentas',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);		
		
	
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
	
	
	$this -> Campos[reporte] = array(
		name	=>'reporte',
		id		=>'reporte',
		type	=>'select',
		required=>'yes',
		size    =>'3',
        options =>array(array(value=>'O',text=>'OFICINA'),array(value=>'C',text=>'CENTRO COSTO')),
		selected=>'C',
		datatype=>array(
			type	=>'alpha')
	);
	
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'text',
		required=>'yes',
		size    =>'3',
        value   =>4,
		datatype=>array(
			type	=>'integer')
	);	
	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		required=>'yes',
		options =>array(array(value=>'NN',text=>'NINGUNO'),array(value=>'T',text=>'TODOS'),array(value=>'U',text=>'UNO')),
		selected=>'U',		
		datatype=>array(
			type	=>'alpha')
	);
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_hidden')
	);
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'numeric')
	);
	
	$this -> Campos[documentos] = array(
		name	=>'documentos',
		id		=>'documentos',
		type	=>'select',
		size    =>'3',
		multiple=>'yes',
        required=>'yes',		
		selected=>'NULL',
        options =>array(),
		datatype=>array(
			type	=>'integer')
	);	
	
	$this -> Campos[opciones_documentos] = array(
		name	=>'opciones_documentos',
		id		=>'opciones_documentos',
		type	=>'checkbox',
		value   =>'U',
		datatype=>array(type=>'text')
	);					
			
	$this -> Campos[cuenta_desde] = array(
		name	=>'cuenta_desde',
		id		=>'cuenta_desde',
		type	=>'text',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'cuenta_desde_hidden',
			onclick =>'setCuentaHasta')		
			
	);	
	
	$this -> Campos[cuenta_desde_id] = array(
		name	=>'cuenta_desde_id',
		id		=>'cuenta_desde_hidden',
		type	=>'hidden',
		required=>'yes'			
	);				
	
	$this -> Campos[cuenta_hasta] = array(
		name	=>'cuenta_hasta',
		id		=>'cuenta_hasta',
		type	=>'text',	
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'cuenta_hasta_hidden')		
	);	
	
	$this -> Campos[cuenta_hasta_id] = array(
		name	=>'cuenta_hasta_id',
		id		=>'cuenta_hasta_hidden',
		type	=>'hidden',	
		required=>'yes'							
	);				

	$this -> Campos[opciones_cierre] = array(
		name	=>'opciones_cierre',
		id		=>'opciones_cierre',
		type	=>'select',
		required=>'yes',
		size    =>'3',
        options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO')),
        selected=>'N',		
		datatype=>array(type=>'alpha')
	);			
	
	
	//botones
	
	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'onclickGenerarInventarioYBalance(this.form)'
	);		
	$this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'button',
		value   =>'Imprimir',
		onclick =>'beforePrint(this.form)'
	);	
	$this -> Campos[excel] = array(
	  name   =>'excel',
	  id   =>'excel',
	  type   =>'button',
	  value   =>'Descargar Excel',
	  onclick =>'descargarexcel(this.form)'
	);	
	
	$this -> SetVarsValidate($this -> Campos);
	}
	
}
$InventarioYBalance = new InventarioYBalance();
?>