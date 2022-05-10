<?php
require_once("../../../framework/clases/ControlerClass.php");

final class LegalizacionCaja extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("LegalizacionCajaLayoutClass.php");
	require_once("LegalizacionCajaModelClass.php");
	
	$Layout   = new LegalizacionCajaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LegalizacionCajaModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	$Layout -> SetAnular	 ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);	
	
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCostosLegalizacion($Model -> selectCostosDeLegalizacion($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));
	$Layout -> setCentroCosto($Model -> selectCentroCosto($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
  
	//// GRID ////
	$Attributes = array(
	  id		=>'legalizacioncaja',
	  title		=>'Listado de Legalizaciones',
	  sortname	=>'consecutivo',
	  sortorder =>'ASC',    
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'consecutivo',	        		index=>'consecutivo',	        		sorttype=>'int',	width=>'120',	align=>'center'),	
	  array(name=>'fecha_legalizacion',				index=>'fecha_legalizacion',			sorttype=>'date',	width=>'140',	align=>'center'),
	  array(name=>'oficina',						index=>'oficina',						sorttype=>'text',	width=>'140',	align=>'left'),	 
	  array(name=>'descripcion',					index=>'descripcion',					sorttype=>'date',	width=>'150',	align=>'left'),
	  array(name=>'estado_legalizacion',			index=>'estado_legalizacion',			sorttype=>'text',	width=>'120',	align=>'center')	  
	);
	  
    $Titles = array('CONSECUTIVO','FECHA LEGALIZACION','OFICINA','CONCEPTO','ESTADO');
	
	$Layout -> SetGridLegalizacion($Attributes,$Titles,$Cols,$Model -> GetQueryLegalizacionGrid($this -> getOficinaId()));
	$Layout -> RenderMain();  
  }  
  
  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"LegalizacionCaja",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }  
  
  protected function onclickSave(){
     
  	require_once("LegalizacionCajaModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
		
    $Model               = new LegalizacionCajaModel();
	$UtilidadesContables = new UtilidadesContablesModel();	
    
	$empresa_id             = $this -> getEmpresaId();
	$oficina_id             = $this -> getOficinaId();	
	$fecha                  = $this -> requestData('fecha_legalizacion');
	   
	if($UtilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$fecha,$this -> getConex())){					
		if($UtilidadesContables-> periodoContableEstaHabilitado($this -> getEmpresaId(),$fecha,$this -> getConex())){				   
			$response = $Model -> Save($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),
			$this -> getConex());
					
				if($Model -> GetNumError() > 0){
					exit('Ocurrio una inconsistencia');
				}else{
					 exit('true');
				 }						  
					  }else{
					       exit("<div align='center'>El periodo contable correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del periodo para realizar el registro</b>!!!</div>");					  
					    }						
					 }else{
					    exit("<div align='center'>El mes correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del mes para realizar el registro</b>!!!</div>");
					  }		
			     }	

  protected function onclickUpdate(){
     
  	require_once("LegalizacionCajaModelClass.php");
    require_once("UtilidadesContablesModelClass.php");
		
    $Model               = new LegalizacionCajaModel();
	$UtilidadesContables = new UtilidadesContablesModel();	
    
	$empresa_id             = $this -> getEmpresaId();
	$oficina_id             = $this -> getOficinaId();
	$fecha                  = $this -> requestData('fecha_legalizacion');
		
	if($UtilidadesContables -> mesContableEstaHabilitado($this -> getOficinaId(),$fecha,$this -> getConex())){					
	  if($UtilidadesContables-> periodoContableEstaHabilitado($this -> getEmpresaId(),$fecha,$this -> getConex())){			   

		$response = $Model -> Update($this -> Campos,$empresa_id,$oficina_id,$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
		if($Model -> GetNumError() > 0){
		  exit('Ocurrio una inconsistencia');
		}else{
		   exit('true');
		  }	
	  
	  }else{
		   exit("<div align='center'>El periodo contable correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del periodo para realizar el registro</b>!!!</div>");					  
		}
		
	 }else{
		exit("<div align='center'>El mes correspondiente a la fecha, se encuentra cerrado contablemente,<br><br><b>Por favor solicite la apertura del mes para realizar el registro</b>!!!</div>");
	  }
  }
  
  protected function OnclickLegalizar(){
  	require_once("LegalizacionCajaModelClass.php");
    $Model = new LegalizacionCajaModel();	
	$response = $Model -> legalizar($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getUsuarioNombres(),$this -> getUsuarioId(),$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}elseif(isset($response[error])){
		exit($response[error]);
	}else{
	     exit('true');
	  }    
  }
    
  protected function onclickDelete(){
  	require_once("LegalizacionCajaModelClass.php");
    $Model = new LegalizacionCajaModel();	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }
  
  protected function onclickCancellation(){  
  	require_once("LegalizacionCajaModelClass.php");	
    $Model = new LegalizacionCajaModel();
	$legalizacion_caja_id			=	$this -> requestData('legalizacion_caja_id');	
	$Model -> cancellation($legalizacion_caja_id,$this -> getConex());
		if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }
	
  } 
  
  protected function validaciontope(){  
  	require_once("LegalizacionCajaModelClass.php");	
    $Model = new LegalizacionCajaModel();	
	$legalizacion_caja_id			=	$this -> requestData('legalizacion_caja_id');
	$fecha_legalizacion				=	$this -> requestData('fecha_legalizacion');
	$total_costos_legalizacion_caja	=	$this -> requestData('total_costos_legalizacion_caja');
	$oficina_id						=	$this -> requestData('oficina_id');	
	$respuesta = $Model -> tope($legalizacion_caja_id,$fecha_legalizacion,$total_costos_legalizacion_caja,$oficina_id,$this -> getConex());	
	exit ($respuesta);
  }   
  
  protected function getEstadoEncabezadoRegistro($Conex=''){	  
  	require_once("LegalizacionCajaModelClass.php");
    $Model           = new LegalizacionCajaModel();
	$legalizacion_caja_id = $_REQUEST['legalizacion_caja_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($legalizacion_caja_id,$this -> getConex());
	exit("$Estado");	  
  }   

//BUSQUEDA
  protected function onclickFind(){  
  	require_once("LegalizacionCajaModelClass.php");	
    $Model	=	new LegalizacionCajaModel();
	$legalizacion_caja_id	=	$this -> requestData('legalizacion_caja_id');			
	$Data	=	$Model -> selectLegalizacionCaja($legalizacion_caja_id,$this -> getConex());	
	$this -> getArrayJSON($Data);
  }

  protected function onclickPrint(){    
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento();
    $print -> printOut($this -> getConex());     
  }

  protected function setCampos(){
  
	//CAMPOS	
	$this -> Campos[legalizacion_caja_id] = array(
		name	=>'legalizacion_caja_id',
		id		=>'legalizacion_caja_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);	

	$this -> Campos[numero_documento] = array(
		name	       =>'numero_documento',
		id	           =>'numero_documento',
		type	       =>'text',
	 	datatype=>array(
			type=>'integer')/*,
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column')),*/
	);		

	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);	
	$this -> Campos[descripcion] = array(
		name	   =>'descripcion',
		id	       =>'descripcion',
		type	   =>'text',
		size       =>'35',
		value      =>'LEGALIZACION CAJA: ',
	 	datatype=>array(
			type	=>'text'),		
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);				
	  	
	$this -> Campos[fecha_static] = array(
		name	=>'fecha_static',
		id		=>'fecha_static',
		type	=>'hidden',
		value	=>date("Y-m-d"),
    	datatype=>array(type=>'text')
	);		
		
	$this -> Campos[fecha_legalizacion] = array(
		name	=>'fecha_legalizacion',
		id		=>'fecha_legalizacion',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);
	
	$this -> Campos[total_costos_legalizacion_caja] = array(
		name	=>'total_costos_legalizacion_caja',
		id		=>'total_costos_legalizacion_caja',
		type	=>'text',
		datatype=>array(
			type=>'numeric'),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);	
	
	$this -> Campos[elaboro] = array(
		name	=>'elaboro',
		id	=>'elaboro',
		type	=>'hidden',
		datatype=>array(type=>'text'),
		value  => $this -> getUsuarioNombres(),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);	
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id	    =>'oficina_id',
		type	=>'hidden',
		datatype=>array(type=>'integer'),
		value  => $this -> getOficinaId(),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);		
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		datatype=>array(type=>'integer'),
		value  => $this -> getUsuarioId(),
		transaction=>array(
			table	=>array('legalizacion_caja'),
			type	=>array('column'))
	);	

	$this -> Campos[bandera] = array(
		name	=>'bandera',
		id	    =>'bandera',
		type	=>'hidden',
		value  => 'NO'
	);	

    $this -> Campos[estado_legalizacion] = array(
    name    =>'estado_legalizacion',
    id      =>'estado_legalizacion',
    type    =>'select',
	disabled => 'yes',
	options =>array(array(value => 'E', text => 'EDICION', selected => 'E'),array(value => 'C', text => 'LEGALIZADO', selected => 'E'), 
	                array(value => 'A', text => 'ANULADO', selected => 'E')),
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('legalizacion_caja'),
    type=>array('column'))
    );		
	/*****************************************
	        Campos Anulacion Registro
	*****************************************/	

	$this -> Campos[anul_usuario_id] = array(
		name	=>'anul_usuario_id',
		id		=>'anul_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer')
	);		

	$this -> Campos[anul_oficina_id] = array(
		name	=>'anul_oficina_id',
		id		=>'anul_oficina_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);

	$this -> Campos[anul_legalizacion_caja] = array(
		name	=>'anul_legalizacion_caja',
		id		=>'anul_legalizacion_caja',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text')
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
	
	$this -> Campos[desc_anul_legalizacion_caja] = array(
		name	=>'desc_anul_legalizacion_caja',
		id		=>'desc_anul_legalizacion_caja',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text')
	);	

	//	BOTONES
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
		//onclick =>'legalizacionCajaOnSaveOnUpdateonDelete(this.form)'		
	);
	
 	$this -> Campos[legalizar] = array(
		name	=>'legalizar',
		id		=>'legalizar',
		type	=>'button',
		value	=>'Legalizar',
		disabled=>'disabled',
		onclick =>'OnclickLegalizar(this.form)'
	);	
	
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation(this.form)'
	);		
	 
      $this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'print',
		disabled=>'disabled',
		value   =>'Imprimir',
		id_prin	=>'encabezado_registro_id',
		displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion LegalizacionCaja',
		  width       => '900',
		  height      => '600'
		)
    );
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'legalizacionCajaOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'legalizacion_caja',
			setId	=>'legalizacion_caja_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
  }
  
}

$LegalizacionCaja = new LegalizacionCaja();

?>