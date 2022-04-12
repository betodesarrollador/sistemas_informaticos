<?php
require_once("../../../framework/clases/ControlerClass.php");

final class PlantillaTesoreria extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("PlantillaTesoreriaLayoutClass.php");
	require_once("PlantillaTesoreriaModelClass.php");
	
	$Layout   = new PlantillaTesoreriaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PlantillaTesoreriaModel();
	
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
    $Layout -> setFormaPago($Model -> getFormasPago($this -> getConex()));		
	$Layout -> setTipoBienServicioTesoreria($Model -> getTipoBienServicioTesoreria($this -> getOficinaId(),$this -> getConex()));	

	//// GRID ////
	$Attributes = array(
	  id		=>'plantillatesoreria',
	  title		=>'Listado de Egresos',
	  sortname	=>'consecutivo',
	  sortorder =>'DESC',    
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'consecutivo',	            	index=>'consecutivo',	            	sorttype=>'int',	width=>'80',	align=>'left'),	
	  array(name=>'fecha_plantilla_tesoreria',		index=>'fecha_plantilla_tesoreria',		sorttype=>'date',	width=>'100',	align=>'left'),
	  array(name=>'codplantilla_tesoreria',			index=>'codplantilla_tesoreria',		sorttype=>'text',	width=>'110',	align=>'left'),	 
	  array(name=>'concepto_plantilla_tesoreria',	index=>'concepto_plantilla_tesoreria',	sorttype=>'date',	width=>'100',	align=>'left'),
	  array(name=>'proveedor',						index=>'proveedor',						sorttype=>'text',	width=>'150',	align=>'left'),
	  array(name=>'tipo_servicio',					index=>'tipo_servicio',					sorttype=>'text',	width=>'100',	align=>'left'),
  	  array(name=>'valor_plantilla_tesoreria',		index=>'valor_plantilla_tesoreria',		sorttype=>'text',	width=>'100',	align=>'right'),
	  array(name=>'estado_plantilla_tesoreria',		index=>'estado_plantilla_tesoreria',	sorttype=>'text',	width=>'90',	align=>'left')	  
	);
	  
    $Titles = array('EGRESO','FECHA','CODIGO FACTURA','CONCEPTO','PROVEEDOR','TIPO SERVICIO','VALOR','ESTADO');
	
	$Layout -> SetGridPlantillaTesoreria($Attributes,$Titles,$Cols,$Model -> GetQueryPlantillaTesoreriaGrid($this -> getOficinaId()));
	$Layout -> RenderMain();  
  }

  protected function onclickValidateRow(){
	require_once("PlantillaTesoreriaModelClass.php");
    $Model = new PlantillaTesoreriaModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }  

  protected function onclickSave(){
	require_once("PlantillaTesoreriaModelClass.php");
	$Model = new PlantillaTesoreriaModel();
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
  	require_once("PlantillaTesoreriaModelClass.php");
    $Model = new PlantillaTesoreriaModel();
    $Model -> Update($this -> Campos,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Egreso');
	  }	
  }

  protected function onclickCancellation(){  
  	require_once("PlantillaTesoreriaModelClass.php");	
    $Model = new PlantillaTesoreriaModel();	
	$Model -> cancellation($this -> getConex());	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}	
  }

  protected function onclickPrint(){  
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento();
    $print -> printOut($this -> getConex());  
  }

//BUSQUEDA
  protected function onclickFind(){	
	require_once("PlantillaTesoreriaModelClass.php");
    $Model = new PlantillaTesoreriaModel();	
	$plantilla_tesoreria_id = $_REQUEST['plantilla_tesoreria_id'];	 
    $Data = $Model -> selectDatosPlantillaTesoreriaId($plantilla_tesoreria_id,$this -> getConex());
	$this -> getArrayJSON($Data);	
  }
 
  protected function getEstadoEncabezadoRegistro($Conex=''){	  
  	require_once("PlantillaTesoreriaModelClass.php");
    $Model           = new PlantillaTesoreriaModel();
	$plantilla_tesoreria_id = $_REQUEST['plantilla_tesoreria_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($plantilla_tesoreria_id,$this -> getConex());
	exit("$Estado");	  
  } 

  protected function getmaneja_cheque($Conex){	  
  	require_once("PlantillaTesoreriaModelClass.php");
    $Model           = new PlantillaTesoreriaModel();
	$tipo_bien_servicio_teso_id = $_REQUEST['tipo_bien_servicio_teso_id'];	
	$Estado = $Model -> selectmanejacheque($tipo_bien_servicio_teso_id,$this -> getConex());
	exit("$Estado");	  
  } 

  protected function getTotalDebitoCredito(){	  
  	require_once("PlantillaTesoreriaModelClass.php");
    $Model = new PlantillaTesoreriaModel();
	$plantilla_tesoreria_id = $_REQUEST['plantilla_tesoreria_id'];
	$data = $Model -> getTotalDebitoCredito($plantilla_tesoreria_id,$this -> getConex());
	print json_encode($data);  	  
  }
  
  protected function setDataProveedor(){
    require_once("PlantillaTesoreriaModelClass.php");
    $Model = new PlantillaTesoreriaModel();    
    $proveedor_id = $_REQUEST['proveedor_id'];
    $data = $Model -> getDataProveedor($proveedor_id,$this -> getConex());
    $this -> getArrayJSON($data);
  }  
  
  protected function getContabilizar(){	
  	require_once("PlantillaTesoreriaModelClass.php");
    $Model = new PlantillaTesoreriaModel();
	$plantilla_tesoreria_id 	 = $_REQUEST['plantilla_tesoreria_id'];
	$fecha_plantilla_tesoreria = $_REQUEST['fecha_plantilla_tesoreria'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_plantilla_tesoreria,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($plantilla_tesoreria_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
		if($return==true){
			exit("true");
		}else{
			exit("Error : ".$Model -> GetError());
		}			
	}else{			 
		if(!$mesContable && !$periodoContable){
			exit("No se permite Contabilizar en el periodo y mes seleccionado");
		}elseif(!$mesContable){
 		    exit("No se permite Contabilizar en el mes seleccionado");				 
		}else if(!$periodoContable){
		    exit("No se permite Contabilizar en el periodo seleccionado");				   
		}
	 }	  
  }

  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/	
	$this -> Campos[plantilla_tesoreria_id] = array(
		name	=>'plantilla_tesoreria_id',
		id		=>'plantilla_tesoreria_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('primary_key'))
	);

	$this -> Campos[numero_soporte] = array(
		name	=>'numero_soporte',
		id		=>'numero_soporte',
		type	=>'text',
		readonly=>'yes'
	);

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden'
	);
	
	$this -> Campos[tipo_bien_servicio_teso_id] = array(
		name	=>'tipo_bien_servicio_teso_id',
		id		=>'tipo_bien_servicio_teso_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);	
	
	$this -> Campos[codplantilla_tesoreria] = array(       // NUMERO FACTURA O RECIBO DEL PROVEEDOR O CHEQUE
		name	=>'codplantilla_tesoreria',
		id		=>'codplantilla_tesoreria',
		type	=>'text',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))		
	);	
	$this -> Campos[forma_pago_id] = array(
		name	=>'forma_pago_id',
		id		=>'forma_pago_id',
		type	=>'select',
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);		
	
	$this -> Campos[cheques] = array(
		name	=>'cheques',
		id		=>'cheques',
		type	=>'text',
		readonly=>'yes',
		size    => '48',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column')),
		onclick =>'cargardiv()'
	);

	$this -> Campos[cheques_ids] = array(
		name	=>'cheques_ids',
		id		=>'cheques_ids',
		type	=>'hidden',
		datatype=>array(
			type	=>'alphanum',
			length	=>'350'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);

	$this -> Campos[valor_plantilla_tesoreria] = array(
		name	=>'valor_plantilla_tesoreria',
		id		=>'valor_plantilla_tesoreria',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))		
	);
	
	$this -> Campos[concepto_plantilla_tesoreria] = array(
		name	=>'concepto_plantilla_tesoreria',
		id		=>'concepto_plantilla_tesoreria',
		type	=>'text',
		required=>'yes',
		size	=>65,
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))		
	);	
	
	$this -> Campos[fecha_plantilla_tesoreria] = array(
		name	=>'fecha_plantilla_tesoreria',
		id		=>'fecha_plantilla_tesoreria',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);
	
	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		suggest=>array(
			name	=>'proveedor_teso',
			setId	=>'proveedor_id',
			onclick => 'setDataProveedor')
	);	
		
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);	

	$this -> Campos[proveedor_nit] = array(
		name	=>'proveedor_nit',
		id		=>'proveedor_nit',
		type	=>'text',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);	
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);

	$this -> Campos[estado_plantilla_tesoreria] = array(
		name	=>'estado_plantilla_tesoreria',
		id		=>'estado_plantilla_tesoreria',
		type	=>'select',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'EDICION'),array(value => 'I', text => 'ANULADA'),array(value => 'C', text => 'CONTABILIZADA')),
		selected=>'A',		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('factura'),
			type	=>array('column'))
		
	);
	
	/*****************************************
	        Campos Anulacion Registro
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
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
	);

	$this -> Campos[anul_plantilla_tesoreria] = array(
		name	=>'anul_plantilla_tesoreria',
		id		=>'anul_plantilla_tesoreria',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);		
	
	$this -> Campos[desc_anul_plantilla_tesoreria] = array(
		name	=>'desc_anul_plantilla_tesoreria',
		id		=>'desc_anul_plantilla_tesoreria',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);	

	$this -> Campos[ingreso_plantilla_tesoreria] = array(
		name	=>'ingreso_plantilla_tesoreria',
		id		=>'ingreso_plantilla_tesoreria',
		type	=>'hidden',
		value	=>date("Y-m-d h:i:s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('plantilla_tesoreria'),
			type	=>array('column'))
	);

    /**********************************
 	             Botones
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
	
	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
	    property=>array(
			name	=>'delete_ajax',
			onsuccess=>'PlantillaTesoreriaOnDelete')
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
		onclick	=>'PlantillaTesoreriaOnReset()'
	);
	 
   	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		tabindex=>'16',
		onclick =>'OnclickContabilizar()'
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
      title       => 'Impresion Documento Contable',
      width       => '800',
      height      => '600'
    ));

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'plantilla_tesoreria',
			setId	=>'plantilla_tesoreria_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$plantilla_tesoreria_id = new PlantillaTesoreria();

?>