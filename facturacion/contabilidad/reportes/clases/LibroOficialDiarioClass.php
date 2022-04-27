<?php
require_once("../../../framework/clases/ControlerClass.php");
final class LibroOficialDiario extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
	     
    $this -> noCache();
    
	require_once("LibroOficialDiarioLayoutClass.php");
	require_once("LibroOficialDiarioModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new LibroOficialDiarioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LibroOficialDiarioModel();
    $utilidadesContables = new UtilidadesContablesModel(); 	
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this -> getConex()));		
	$Layout -> setNivelesPuc($utilidadesContables -> getNivelesPuc($this -> getConex()));			
			
	$Layout -> RenderMain();	  
	  
  }
  
  protected function getEmpresas(){
  
	require_once("LibroOficialDiarioLayoutClass.php");
	require_once("LibroOficialDiarioModelClass.php");
	
	$Layout  = new LibroOficialDiarioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model   = new LibroOficialDiarioModel();	
	$reporte = trim($_REQUEST['reporte']);
	
	if($reporte == 'E'){
  	  $field[empresa_id] = array(
		  name	=>'empresa_id',
		  id		=>'empresa_id',
		  type	=>'select',
		  required=>'yes',
		  options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		  tabindex=>'2',
	      datatype=>array(
			 type	=>'integer',
			  length	=>'9')
	  );
	  
	}else if($reporte == 'O'){
	
	  $field[empresa_id] = array(
		  name	=>'empresa_id',
		  id		=>'empresa_id',
		  type	=>'select',
		  required=>'yes',
		  options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		  tabindex=>'2',
	      datatype=>array(
			  type	=>'integer',
			  length	=>'9'),
          setoptionslist=>array(childId=>'oficina_id')
	  );	
	  
	 }else if($reporte == 'C'){
	 
	     $field[empresa_id] = array(
		   name	=>'empresa_id',
		   id		=>'empresa_id',
		   type	=>'select',
		   required=>'yes',
		   options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		   tabindex=>'2',
	       datatype=>array(
			  type	=>'integer',
			  length	=>'9'),
          setoptionslist=>array(childId=>'centro_de_costo')
	     );	 
	 
	   }
	
	print $Layout -> getObjectHtml($field[empresa_id]);
  
  }
  
	private function setBalancePrueba($puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$nivel){
		if($nivel <= $this->nivelReporte){
			$Conex      = $this->getConex(); 
			$empresa_id = $this->getEmpresaId();
			$dataCuenta = $this->Model->getSaldoCuenta($puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$empresa_id,$Conex);  
			if((is_numeric($dataCuenta['debito']) && $dataCuenta['debito'] != 0) ||	(is_numeric($dataCuenta['credito']) && $dataCuenta['credito'] != 0)){
				array_push($this->reporte,$dataCuenta); 
				if($this->Model->esCuentaMovimiento($puc_id,$Conex)){
					$dataCuenta = $this->Model->getSaldoCuentaTerceros($puc_id,$desde,$hasta,$centro_de_costo_id,$empresa_id,$Conex);  			 
					foreach($dataCuenta as $llave => $valor){
						if(is_array($valor))array_push($this->reporte,$valor);
					}
				}else{
					$sub_cuentas = $this->Model->selectSubCuentas($puc_id,$Conex);
					$nivel++;
					for($i = 0; $i < count($sub_cuentas); $i++){
						$this->setBalancePrueba($sub_cuentas[$i]['puc_id'],$desde,$hasta,$centro_de_costo_id,$tercero_id,$nivel); 
					}
				}
			}
		}
	} 
   
  protected function onchangeSetOptionList(){
  
   
	require_once("LibroOficialDiarioModelClass.php");
    require_once("../../../framework/clases/ListaDependiente.php");
		
    $Model     = new LibroOficialDiarioModel();  
    $listChild = $_REQUEST['listChild'];
	
	if($listChild == 'oficina_id'){
  	  $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
                                   'codigo_centro,nombre',concat=>'-',order=>'codigo_centro,nombre'),$this -> Campos,
								   $Model -> getConditionOficina($this -> getUsuarioId()));		
    }else{
  	     $list = new ListaDependiente($this -> getConex(),'centro_de_costo_id',array(table=>'centro_de_costo',value=>'centro_de_costo_id',text=>
                                   'codigo,nombre',concat=>'-',order=>'codigo,nombre'),$this -> Campos,
								   $Model -> getConditionCentroCosto($this -> getUsuarioId()));			
	  }
	
	$list -> getList();
	  
  }   
  
	protected function onclickGenerarBalance(){
    
		require_once("LibroOficialDiarioLayoutClass.php");
		require_once("LibroOficialDiarioModelClass.php");
	    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
			
		
		$Layout              = new LibroOficialDiarioLayout($this -> getTitleTab(),$this -> getTitleForm());
	    $this ->Model        = new LibroOficialDiarioModel();	
		$utilidadesContables = new UtilidadesContablesModel();
		$download           = $this -> requestData('download');
	    $empresa_id         = $this -> getEmpresaId();
	    $opciones_centros   = $this -> requestData('opciones_centros');
	    $opcierre 			= $this -> requestData('opciones_cierre');
	    $desde              = $this -> requestData('desde'); 
	    $hasta              = $this -> requestData('hasta');
	    $centro_de_costo_id = $this -> requestData('centro_de_costo_id');
	    $oficina_id         = $this -> requestData('oficina_id');
	    $tercero_id			= 'NULL';
	    $opciones_tercero   = $this -> requestData('opciones_tercero');
	    $nivel              = $this -> requestData('nivel');
		
	    $this->reporte        = array();
	    $Conex              = $this  -> getConex();	
		
		// $parametros         = $utilidadesContables -> getParametrosReportes($Conex);
		$empresa            = $this -> getEmpresaNombre();
		$nitEmpresa         = $this -> getEmpresaIdentificacion();
		$centrosTxt         = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
		$cuentasniv=$this->Model->getCuentasBalance($nivel,$Conex);
		$sumdebito=0;
		$sumcredito=0;
		for($j = 0; $j < count($cuentasniv); $j++){
			$dat_cuenta=$this->Model->getSaldoCuenta($opcierre,$cuentasniv[$j][value],$desde,$hasta,$centro_de_costo_id,$tercero_id,$this->getEmpresaId(),$Conex); 
			for($l=0;$l<count($dat_cuenta);$l++){
				$sumdebito=$sumdebito+$dat_cuenta[$l]['debito'];
				$sumcredito=$sumcredito+$dat_cuenta[$l]['credito'];
				$dat_cuenta[$l]['codigo_puc']=$cuentasniv[$j][text];
			}
			$this->reporte[$j]= $dat_cuenta;
		}
		
	$arrayReporte = $this ->reporte;
    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/reportes.css");						
    $Layout -> setCssInclude("../css/reportes.css","print");	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
    $Layout -> setVar('NIVEL',$nivel);		
    $Layout -> setVar('EMPRESA',$empresa);	
    $Layout -> setVar('NIT',$nitEmpresa);	
    $Layout -> setVar('CENTROS',$centrosTxt);													
    $Layout -> setVar('HASTA',$hasta);															
    $Layout -> setVar('DESDE',$desde);															
    $Layout -> setVar('parametros',$parametros);									
    $Layout -> setVar('TDEBITO',$sumdebito);			
    $Layout -> setVar('TCREDITO',$sumcredito);			
    $Layout -> setVar('arrayResult',$arrayReporte);    
    if($download == 'true'){
    	$Layout -> exportToExcel('LibroOficialDiarioReporte.tpl');   
 	}else{   
   		$Layout -> RenderLayout('LibroOficialDiarioReporte.tpl');
	}
  }  
    
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
		type	=>'select',
		selected=>'1',
		required=>'yes',
		size    =>'3',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		required=>'yes',
		size    =>'3',
        options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO')),
        selected=>'N',		
		datatype=>array(type=>'alpha')
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
		onclick =>'onclickGenerarBalance(this.form)'
	);		
	
    $this -> Campos[imprimir] = array(
      name    =>'imprimir',
      id      =>'imprimir',
      type    =>'button',
      value   =>'Imprimir',
	  onclick =>'beforePrint(this.form)'
    );	
	$this -> Campos[descargar] = array(
	  name   =>'descargar',
	  id   =>'descargar',
	  type   =>'button',
	  value   =>'Descargar Excel',
	  onclick =>'descargarexcel(this.form)'
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}
$MovimientosContables = new LibroOficialDiario();
?>