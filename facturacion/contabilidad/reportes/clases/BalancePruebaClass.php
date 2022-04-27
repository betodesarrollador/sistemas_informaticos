<?php
//Ahora
set_time_limit(0);

require_once("../../../framework/clases/ControlerClass.php");

final class BalancePrueba extends Controler{

  private $reporte;
  private $nivelReporte;
  private $Model;

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
	     
    $this -> noCache();
    
	require_once("BalancePruebaLayoutClass.php");
	require_once("BalancePruebaModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
	
	$Layout              = new BalancePruebaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new BalancePruebaModel();
    $utilidadesContables = new UtilidadesContablesModel();  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU

	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this->getConex()));			
					
	$Layout -> setCuentasPuc($Model -> getCuentasBalance($this -> getConex(),1));	
	$Layout -> setNivelesPuc($utilidadesContables -> getNivelesPuc($this -> getConex()));

	$Layout -> RenderMain();	  
	
	  
  }  
  
	private function setBalancePrueba($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$tercero_id,$opciones_tercero,$nivel){
	
		if($nivel <= $this->nivelReporte){
			$Conex      = $this->getConex(); 
			$empresa_id = $this->getEmpresaId();
			$dataCuenta = $this->Model->getSaldoCuenta($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$tercero_id,$empresa_id,$Conex);  

			if((is_numeric($dataCuenta['saldo_anterior']) && $dataCuenta['saldo_anterior'] != 0) ||
			(is_numeric($dataCuenta['debito']) && $dataCuenta['debito'] != 0) ||
			(is_numeric($dataCuenta['credito']) && $dataCuenta['credito'] != 0)	||
			(is_numeric($dataCuenta['nuevo_saldo']) && $dataCuenta['nuevo_saldo'] != 0)){

				array_push($this->reporte,$dataCuenta);
				
				if($this->Model->esCuentaMovimiento($puc_id,$Conex)){
					if ($opciones_tercero != 'NN' && $opciones_tercero != 'U' ) {
						
						$dataCuenta = $this->Model->getSaldoCuentaTerceros($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Conex);
						//$dataCuenta = $this->Model->getSaldosCuentasTercero($desde,$hasta,$centro_de_costo_id,$puc_id,$Conex);
						
						foreach($dataCuenta as $llave => $valor){
							if(is_array($valor))array_push($this->reporte,$valor);
						}
					}
				}
			}
		}
	}  
	
	
	protected function getCuentas(){
		
	require_once("BalancePruebaModelClass.php");
	$Model  = new BalancePruebaModel();
	
	$return_cuentas = '';
	$all_cuentas    = $this->requestData('all_cuentas');
	$cuentas        = $this->requestData('cuenta');
	$all_subcuentas = $this->requestData('all_subcuentas');
	$subCuentas     = $this->requestData('subCuentas');
	$nivel		    = $this->requestData('nivel');
	$niveles		= $this->requestData('niveles');
	
	if($all_subcuentas == 'U'){ 
	
		$return_cuentas = $subCuentas;
		
	}else{
		
		if($all_cuentas == 'T'){
			
			$cuentas  = $Model->getCuentasBalance($this  -> getConex(),$nivel);
	
			
			$cuentas  =  $Model->getSubCuentasBalance($this->getConex(),$cuentas,$niveles,$nivel);
		
		}else{
			
			$cuentas  =  $Model->getSubCuentasBalance($this->getConex(),$cuentas,$niveles,$nivel);
			
		}
		
		foreach ($cuentas as $items) { $respuesta.=$items['value'].","; }
		
		$return_cuentas =  substr($respuesta, 0,-1);	  
	} 
	
	return $return_cuentas;
		
	}
	
	protected function onclickGenerarBalancePrueba(){

	require_once("BalancePruebaLayoutClass.php");
	require_once("BalancePruebaModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");		

	$Layout              = new BalancePruebaLayout($this -> getTitleTab(),$this -> getTitleForm());
	$this->Model         = new BalancePruebaModel();
	$utilidadesContables = new UtilidadesContablesModel();

	$this->reporte      = array();
	$this->nivelReporte = $this->requestData('nivel');

	$desde              = $this->requestData('desde');
	$hasta              = $this->requestData('hasta');
	$opciones_tercero   = $this->requestData('opciones_tercero');
	$tercerouno		   	= $this->requestData('tercero');
	$tercero_id         = $this->requestData('tercero_id');
	$opciones_centros   = $this->requestData('opciones_centros');	
	$centro_de_costo_id = $this->requestData('centro_de_costo_id');
	$opcierre			= $this->requestData('opciones_cierre');
	$nivel				= $this->requestData('nivel');
	$cuentas 			= $this->getCuentas();
	
	$cuentascomas		= $cuentas;
	
	$cuentas            = explode(',',$cuentas);
	
	$fechaProcesado     = date("Y-m-d");
	$horaProcesado      = date("H:i:s");
	
	if($nivel!=5 && $opciones_tercero=='U') 
	exit("No se puede generar el reporte ya que las cuentas de nivel $nivel no son de movimiento, para ver los movimientos del tercero por favor seleccione las cuentas de nivel 5 ");
	
	$parametros         = $utilidadesContables -> getParametrosReportes($Conex);
	$empresa            = $this -> getEmpresaNombre();
	$nitEmpresa         = $this -> getEmpresaIdentificacion();
	$centrosTxt         = $utilidadesContables -> getSucursalesTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());

    if($nivel!='5' || ($nivel=='5' && $opciones_tercero!='T' )){ 
	   											
		for($i = 0; $i < count($cuentas); $i++){
			$this->setBalancePrueba($opcierre,$cuentas[$i],$desde,$hasta,$centro_de_costo_id,$opciones_centros,$tercero_id,$opciones_tercero,1);
		}
	}else{
		
		$this->reporte = $this->Model->getSaldosCuentas($opcierre,$desde,$hasta,$centro_de_costo_id,$cuentascomas,$this  -> getConex());//nuevo
	}

	$sumdebito  = 0;
	$sumcredito = 0;
	
	$cuentasniv1=$cuentas;
	
	for($j = 0; $j < count($cuentasniv1); $j++){ 
		
		$dat_cuenta=$this->Model->getSaldoCuenta($opcierre,$cuentasniv1[$j],$desde,$hasta,$centro_de_costo_id,$opciones_centros,$tercero_id,$this->getEmpresaId(),$this  -> getConex()); 
		
		$sumdebito	=	$sumdebito + intval($dat_cuenta['debito']);
		$sumcredito	=	$sumcredito+ intval($dat_cuenta['credito']);
		
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
	$Layout -> setVar('opciones_centros',$opciones_centros);	
  	$Layout -> setVar('documentos',$this -> getTiposDocumentoContable($utilidadesContables,$this  -> getConex()));
	$Layout -> setVar('centro_de_costo_id',$centro_de_costo_id);		
	$Layout -> setVar('OPCTERCERO',$opciones_tercero);	
	$Layout -> setVar('TERCEROUNO',$tercerouno);
	$Layout -> setVar('tercero_id',$tercero_id);
    $Layout -> setVar('DESDE',$desde);															
    $Layout -> setVar('HASTA',$hasta);															
    $Layout -> setVar('parametros',$parametros); 
 	$Layout -> setVar('USUARIO',$this -> getUsuarioNombres());
    $Layout -> setVar('FECHA',$fechaProcesado);				  	  	  
    $Layout -> setVar('HORA',$horaProcesado);				  	  	  	  	  
    $Layout -> setVar('DEBITO',$sumdebito);				  	  	  	  	  
    $Layout -> setVar('CREDITO',$sumcredito);		  	  	  
	

	$Layout -> setVar('REPORTE',$this->reporte);	
	
																																															        		
	if($_REQUEST['download'] == 'SI'){
		$Layout -> exportToExcel('BalancePruebaReporteExcel.tpl');
	}else{
		$Layout -> RenderLayout('BalancePruebaReporte.tpl');		
	}
  }  
  
 protected function getTiposDocumentoContable($utilidadesContables,$Conex){
  
    $documentosTxt = null;
	$documentos    = $utilidadesContables -> getDocumentos($Conex);  
  
    for($i = 0; $i < count($documentos); $i++){
	  $documentosTxt .= $documentos[$i]['value'].',';
	}
		
	$documentosTxt = substr($documentosTxt,0,strlen($documentosTxt) -1);
	
	return $documentosTxt;  

  } 
   
  protected function cambiarCuentas(){
	  
	  require_once("BalancePruebaModelClass.php");
	  require_once("BalancePruebaLayoutClass.php");
	  
	  $Model     = new BalancePruebaModel();
	  $Layout    = new BalancePruebaLayout($this -> getTitleTab(),$this -> getTitleForm());
	  $nivel	 = $_REQUEST['nivel'];
	  $opciones  = $Model->getCuentasBalancePrincipal($this  -> getConex(),$nivel);
	  
	  $field = 	array(
			name	 =>'cuentas',
			id		 =>'cuentas',
			type	 =>'select',
			onchange =>'listarSubcuentas(true)',
			options  => $opciones,
			Boostrap =>'si',
			multiple =>'yes',
			size     =>'8',	
			datatype => array(
				type =>'alphanum'
			 )
			 
		 );	
		 
		 print $Layout -> getObjectHtml($field);
	  
	  } 
  
  protected function listarSubcuentas(){
	  
	  
	  require_once("BalancePruebaModelClass.php");
	  require_once("BalancePruebaLayoutClass.php");
	  
	  $Model     = new BalancePruebaModel();
	  $Layout    = new BalancePruebaLayout($this -> getTitleTab(),$this -> getTitleForm());
	  $cuenta	 = $_REQUEST['cuenta'];
	  $niveles	 = $_REQUEST['niveles'];
	  $opciones  = $Model->getSubCuentasBalance($this  -> getConex(),$cuenta,$niveles,$nivel);
	  
	  $field = 	 array(
		name	 =>'subcuentas',
		id		 =>'subcuentas',
		type	 =>'select',
		Boostrap =>'si',
		required =>'yes',
		onchange =>'change_opciones()',
		options  => $opciones,
		multiple =>'yes',
		size     =>'8',		
	    datatype =>array(
			type	=>'integer',
			length	=>'9')
	);
		 
		 print $Layout -> getObjectHtml($field);
	  
	  } 

  
  
  protected function setCampos(){

    /*****************************************
            	 datos sesion
	*****************************************/  

	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		Boostrap =>'si',
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
		Boostrap =>'si',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	

	$this -> Campos[opciones_oficinas] = array(
		name	=>'opciones_oficinas',
		id		=>'opciones_oficinas',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);		

	
	$this -> Campos[opciones_centros] = array(
		name	=>'opciones_centros',
		id		=>'opciones_centros',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);	
	
	
	$this -> Campos[all_subcuentas] = array(
		name	=>'all_subcuentas',
		id		=>'all_subcuentas',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);	
		
	$this -> Campos[all_cuentas] = array(
		name	=>'all_cuentas',
		id		=>'all_cuentas',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);		
	
	$this -> Campos[nivel1] = array(
		name	=>'nivel',
		id		=>'nivel1',
		type	=>'checkbox',
		value   =>'1',
		datatype=>array(type=>'text')
	);			
	$this -> Campos[nivel2] = array(
		name	=>'nivel',
		id		=>'nivel2',
		type	=>'checkbox',
		value   =>'2',
		datatype=>array(type=>'text')
	);			
	$this -> Campos[nivel3] = array(
		name	=>'nivel',
		id		=>'nivel3',
		type	=>'checkbox',
		value   =>'3',
		datatype=>array(type=>'text')
	);			
	$this -> Campos[nivel4] = array(
		name	=>'nivel',
		id		=>'nivel4',
		type	=>'checkbox',
		value   =>'4',
		datatype=>array(type=>'text')
	);			
	$this -> Campos[nivel5] = array(
		name	=>'nivel',
		id		=>'nivel5',
		type	=>'checkbox',
		value   =>'5',
		datatype=>array(type=>'text')
	);			
	
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
	
	$this -> Campos[cuentas] = array(
		name	=>'cuentas',
		id		=>'cuentas',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(),
		multiple=>'yes',
		size    =>'8',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	
		
	$this -> Campos[subcuentas] = array(
		name	=>'subcuentas',
		id		=>'subcuentas',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		onchange =>'change_opciones()',
		options	=>array(),
		multiple=>'yes',
		size    =>'8',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
	
	
	$this -> Campos[reporte] = array(
		name	=>'reporte',
		id		=>'reporte',
		type	=>'select',
		Boostrap =>'si',
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
		Boostrap =>'si',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		onclick =>'onclickGenerarBalancePrueba(this.form)'
	);		
	
    $this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick => 'MovimientosContablesOnReset()'
	);	
	
    $this -> Campos[imprimir] = array(
      name    =>'imprimir',
      id      =>'imprimir',
      type    =>'button',
      value   =>'Imprimir',
	  onclick =>'beforePrint(this.form)'
    );	
	
	$this -> Campos[excelf] = array(
		name	=>'excelf',
		id		=>'excelf',
		type	=>'button',
		value	=>'Excel Con Formato',
		onclick =>'OnclickGenerarExcelFormato(this.form)'
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new BalancePrueba();

?>