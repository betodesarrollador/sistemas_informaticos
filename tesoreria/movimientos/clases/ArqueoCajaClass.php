<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ArqueoCaja extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ArqueoCajaLayoutClass.php");
	require_once("ArqueoCajaModelClass.php");
	
	$Layout   = new ArqueoCajaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ArqueoCajaModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir	($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	
	//LISTA MENU	
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));	
	
	$Layout -> setParametros($Model -> getParametros($this -> getOficinaId(),$this -> getConex()));	
	$Layout -> setDocumentos($Model -> getDocumentos($this -> getConex()));	
	$Layout -> setCentros($Model -> getCentros($this -> getOficinaId(),$this -> getConex()));	
	
	$Layout -> setMonedas($Model -> getMonedas($this -> getConex()));	
	$Layout -> setBilletes($Model -> getBilletes($this -> getConex()));	
	$Layout -> setParametrosCaja($Model -> getParametrosCaja($this -> getOficinaId(),$this -> getConex()));	

	//$Layout -> setCheques($Model -> getCheques(date('Y-m-d'),$this -> getOficinaId(),$this -> getConex()));
	//$Layout -> setValCheques($Model -> getValCheques(date('Y-m-d'),$this -> getOficinaId(),$this -> getConex()));



	//// GRID ////
	$Attributes = array(
	  id		=>'arqueocaja',
	  title		=>'Historial Arqueos de Caja',
	  sortname	=>'consecutivo',
	  sortorder =>'DESC',    
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'consecutivo',	    index=>'consecutivo',	sorttype=>'int',	width=>'80',	align=>'left'),	
	  array(name=>'fecha_arqueo',		index=>'fecha_arqueo',	sorttype=>'date',	width=>'100',	align=>'left'),
	  array(name=>'total_efectivo',		index=>'total_efectivo',sorttype=>'text',	width=>'120',	align=>'left'),	 
	  array(name=>'total_cheque',		index=>'total_cheque',	sorttype=>'date',	width=>'120',	align=>'left'),
	  array(name=>'total_caja',			index=>'total_caja',	sorttype=>'text',	width=>'150',	align=>'left'),
	  array(name=>'saldo_auxiliar',		index=>'saldo_auxiliar',sorttype=>'text',	width=>'120',	align=>'left'),
	  array(name=>'diferencia',			index=>'diferencia',	sorttype=>'text',	width=>'120',	align=>'left'),	  
	  array(name=>'estado',				index=>'estado',		sorttype=>'text',	width=>'90',	align=>'left')	  
	);
	  
    $Titles = array('CONSECUTIVO','FECHA','TOTAL EFECTIVO','TOTAL CHEQUE','TOTAL CAJA','SALDO AUX','DIFERENCIA','ESTADO');
	
	$Layout -> SetGridArqueoCaja($Attributes,$Titles,$Cols,$Model -> GetQueryArqueoCajaGrid($this -> getOficinaId()));
	$Layout -> RenderMain();  
  }

  protected function onclickValidateRow(){
	require_once("ArqueoCajaModelClass.php");
    $Model = new ArqueoCajaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }  

  protected function onclickSave(){
	require_once("ArqueoCajaModelClass.php");
	$Model = new ArqueoCajaModel();
	$return = $Model -> Save($this -> Campos,$this -> getConex(),$this -> getUsuarioId(),$this -> getOficinaId());
	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
		if(is_numeric($return)){
			exit("$return");
	  	}else{
	  		exit('false');
		}
	 }
  }

  protected function onclickUpdate(){ 
  	require_once("ArqueoCajaModelClass.php");
    $Model = new ArqueoCajaModel();
    $Model -> Update($this -> Campos,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Arqueo');
	  }	
  }

  protected function onclickCancellation(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();	
	$Model -> cancellation($this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}	
  }

  protected function onclickPrint(){  
    require_once("Imp_ArqueoClass.php");
    $print = new Imp_Arqueo();
    $print -> printOut($this -> getConex());  
  }

//BUSQUEDA
  protected function onclickFind(){	
	require_once("ArqueoCajaModelClass.php");
    $Model = new ArqueoCajaModel();	
    $Data = array();
	$arqueo_caja_id = $_REQUEST['arqueo_caja_id'];	 
	if(is_numeric($arqueo_caja_id)){	  
	  $Data  = $Model -> selectDatosArqueoCajaId($arqueo_caja_id,$this -> getConex());	  
	} 
    $this -> getArrayJSON($Data);	
  }

  protected function onclickCheques(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();	
	$fecha=$_REQUEST['fecha'];
	$resultcheques=$Model -> getCheques($fecha,$this -> getOficinaId(),$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit($resultcheques);
	}	
  }


  protected function onclickChequesVal(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$fecha=$_REQUEST['fecha'];
	$resultvalcheques=$Model -> getValCheques($fecha,$this -> getOficinaId(),$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit($resultvalcheques);
	}	
  }

  protected function onclickconsecutivo(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$arqueo_caja_id=$_REQUEST['arqueo_caja_id'];
	$resultconsecutivo=$Model -> getConsecutivo($arqueo_caja_id,$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit($resultconsecutivo);
	}	
  }

  protected function onclickComprobar(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$fecha=$_REQUEST['fecha'];
	$parametros_legalizacion_arqueo_id=$_REQUEST['parametros_legalizacion_arqueo_id'];
	$resultcomprobar=$Model -> getComprobar($parametros_legalizacion_arqueo_id,$fecha,$this -> getOficinaId(),$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit($resultcomprobar);
	}	
  }

  protected function setDocumentos(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$documentos=$Model -> getDocumentos1($this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit($documentos);
	}	
  }

  protected function setMonedas(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$monedas=$Model -> getMonedas($this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
		$this -> getArrayJSON($monedas);
		
	}	
  }
  protected function setBilletes(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$billetes=$Model -> getBilletes($this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
		$this -> getArrayJSON($billetes);
	}	
  }

  protected function setMonedasarqueo(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$arqueo_caja_id= $_REQUEST[arqueo_caja_id];	
	$monedas=$Model -> getMonedasArqueo($arqueo_caja_id,$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
		$this -> getArrayJSON($monedas);
		
	}	
  }
  protected function setBilletesarqueo(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$arqueo_caja_id= $_REQUEST[arqueo_caja_id];
	$billetes=$Model -> getBilletesArqueo($arqueo_caja_id,$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
		$this -> getArrayJSON($billetes);
	}	
  }

  protected function setCuentas(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$parametros_legalizacion_arqueo_id= $_REQUEST[parametros_legalizacion_arqueo_id];	
	$monedas=$Model -> getParametrosCaja1($parametros_legalizacion_arqueo_id,$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
		$this -> getArrayJSON($monedas);
		
	}	
  }

  protected function onclickCerrar(){  
  	require_once("ArqueoCajaModelClass.php");	
    $Model = new ArqueoCajaModel();
	$arqueo_caja_id= $_REQUEST[arqueo_caja_id];
	$Model -> getCerrar($arqueo_caja_id,$this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
		 exit('true');
	}	
  }


  protected function SetCampos(){
  
    /********************
	  	    CAMPOS
	********************/	
	$this -> Campos[arqueo_caja_id] = array(
		name	=>'arqueo_caja_id',
		id		=>'arqueo_caja_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('primary_key'))
	);

	$this -> Campos[consecutivo] = array(
		name	=>'consecutivo',
		id		=>'consecutivo',
		type	=>'text',
		readonly=>'yes',
		size	=>8,
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'hidden',
		value	=>$this -> getOficinaId(),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this ->Campos[parametros_legalizacion_arqueo_id] = array(
		name	 =>'parametros_legalizacion_arqueo_id',
		id		 =>'parametros_legalizacion_arqueo_id',
		type	 =>'select',		
		required =>'yes',
		onchange =>'validar_caja();',
		options  => array(),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);			

	$this -> Campos[cheques] = array(
		name	=>'cheques',
		id		=>'cheques',
		readonly=>'yes',
		rows	=>8,
		type	=>'textarea',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[ini_puc_id] = array(
		name	=>'ini_puc_id',
		id		=>'ini_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[ini2_puc_id] = array(
		name	=>'ini2_puc_id',
		id		=>'ini2_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[ini3_puc_id] = array(
		name	=>'ini3_puc_id',
		id		=>'ini3_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[ini4_puc_id] = array(
		name	=>'ini4_puc_id',
		id		=>'ini4_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[ini5_puc_id] = array(
		name	=>'ini5_puc_id',
		id		=>'ini5_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[ini6_puc_id] = array(
		name	=>'ini6_puc_id',
		id		=>'ini6_puc_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);

	$this -> Campos[centro_costo] = array(
		name	=>'centro_costo',
		id		=>'centro_costo',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
		
	);


	$this -> Campos[documentos] = array(
		name	=>'documentos',
		id		=>'documentos',
		type	=>'hidden',
		datatype=>array(
			type	=>'text')
	);

	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'text')
	);


	$this -> Campos[fecha_arqueo] = array(
		name	=>'fecha_arqueo',
		id		=>'fecha_arqueo',
		type	=>'text',
		required=>'yes',
		onchange=>'OnclickGenerar(this.form)',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[total_efectivo] = array(
		name	=>'total_efectivo',
		id		=>'total_efectivo',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[total_cheque] = array(
		name	=>'total_cheque',
		id		=>'total_cheque',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[total_caja] = array(
		name	=>'total_caja',
		id		=>'total_caja',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[saldo_auxiliar] = array(
		name	=>'saldo_auxiliar',
		id		=>'saldo_auxiliar',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[diferencia] = array(
		name	=>'diferencia',
		id		=>'diferencia',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);
	

	$this ->Campos[estado_arqueo] = array(
		name	 =>'estado_arqueo',
		id		 =>'estado_arqueo',
		type	 =>'select',		
		required =>'yes',
		disabled =>'yes',
		options  => array(array(value => 'A', text => 'ANULADO',selected=>'E'),array(value => 'C', text => 'CERRADO',selected=>'E'),array(value => 'E', text => 'EN EDICION',selected=>'E')),
		transaction=>array(
			table	=>array('arqueo_caja'),
			type	=>array('column'))
	);			

	/*****************************************
	      			ANULACION
	*****************************************/	
	$this -> Campos[anul_usuario_id] = array(
		name	=>'anul_usuario_id',
		id		=>'anul_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);		

	$this -> Campos[anul_oficina_id] = array(
		name	=>'anul_oficina_id',
		id		=>'anul_oficina_id',
		type	=>'hidden',
		value	=>$this -> getOficinaId(),
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);		
	
	$this -> Campos[desc_anul_arqueo] = array(
		name	=>'desc_anul_arqueo',
		id		=>'desc_anul_arqueo',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text')
	);	

	$this -> Campos[fecha_anul] = array(
		name	=>'fecha_anul',
		id		=>'fecha_anul',
		type	=>'hidden',
		value	=>date("Y-m-d h:i:s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);

    /**********************************
 	             BOTONES
	**********************************/	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
	);

 	$this -> Campos[cerrar] = array(
		name	=>'cerrar',
		id		=>'cerrar',
		type	=>'button',
		value	=>'Cerrar',
		disabled=>'disabled',
		onclick =>'onclickCerrar(this.form)'
	);

   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation(this.form)'
	);	
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ArqueoCajaOnReset(this.form)'
	);
	 

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Arqueo',
      width       => '800',
      height      => '600'
    ));

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'arqueo_caja',
			setId	=>'arqueo_caja_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$arqueo_caja_id = new ArqueoCaja();

?>