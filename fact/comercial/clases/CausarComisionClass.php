<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CausarComision extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("CausarComisionLayoutClass.php");
	require_once("CausarComisionModelClass.php");
	
	$Layout   = new CausarComisionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CausarComisionModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));


	//// GRID ////
	$Attributes = array(
	  id		=>'CausarComision',
	  title		=>'Listado de Causaciones',
	  sortname	=>'consecutivo',
	  sortorder =>'DESC',    
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'consecutivo',	            index=>'consecutivo',	            sorttype=>'int',	width=>'50',	align=>'left'),	
	  array(name=>'ingreso_factura_proveedor',	index=>'ingreso_factura_proveedor',	sorttype=>'date',	width=>'120',	align=>'left'),
	  array(name=>'orden_compra_id',			index=>'orden_compra_id',			sorttype=>'int',	width=>'90',	align=>'left'),
	  array(name=>'codfactura_proveedor',		index=>'codfactura_proveedor',		sorttype=>'text',	width=>'120',	align=>'left'),	 
	  array(name=>'num_ref',					index=>'num_ref',					sorttype=>'text',	width=>'140',	align=>'left'),	  
	  array(name=>'proveedor',					index=>'proveedor',					sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'fuente_nombre',				index=>'fuente_nombre',				sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'tipo_servicio',				index=>'tipo_servicio',				sorttype=>'text',	width=>'140',	align=>'left'),
	  array(name=>'fecha_factura_proveedor',	index=>'fecha_factura_proveedor',	sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'vence_factura_proveedor',	index=>'vence_factura_proveedor',	sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'estado_factura_proveedor',	index=>'estado_factura_proveedor',	sorttype=>'text',	width=>'100',	align=>'left')	  
	);
	  
    $Titles = array(
	                'CAUSACION',
	                'FECHA INGRESO',
					'ORDEN No',
					'CODIGO FACTURA',
					'DESPACHO/MANIFIESTO',
					'PROVEEDOR',
					'FUENTE',					
					'TIPO SERVICIO',
					'FECHA FACTURA',
					'VENC. FACTURA',
					'ESTADO'
	);
	
	$Layout -> SetGridCausarComision($Attributes,$Titles,$Cols,$Model -> GetQueryCausarComisionGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

	require_once("CausarComisionModelClass.php");
	$Model = new CausarComisionModel();
    if($_REQUEST['proveedor_id']==''){
        $proveedor_id =  $Model -> SaveProveedor($this -> getUsuarioId(),$_REQUEST['comercial_id'],$this -> getConex());
        $_REQUEST['proveedor_id'] = $proveedor_id;
    }  

	$return = $Model -> Save($this -> getUsuarioId(),$this -> getOficinaId(),$this -> Campos,$this -> getConex());
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
 
  	require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Causacion');
	  }
	
  }

  protected function onclickCancellation(){
  
  	require_once("CausarComisionModelClass.php");
	
    $Model = new CausarComisionModel();
	
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
	
	require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();
	
    $Data                 = array();
	$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];
	 
	if(is_numeric($factura_proveedor_id)){
	  
	  $Data  = $Model -> selectDatosCausarComisionId($factura_proveedor_id,$this -> getConex());
	  
	} 
    $this -> getArrayJSON($Data);
	
  }

  protected function setDataComercial(){

    require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();    
    $comercial_id = $_REQUEST['comercial_id'];
    $data = $Model -> getDataComercial($comercial_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function setSolicitud(){
      require_once("CausarComisionModelClass.php");
      $Model = new CausarComisionModel();    
      $concepto_item = $_REQUEST['concepto_item'];
      $estado_factura_proveedor = $_REQUEST['estado_factura_proveedor'];
      if($estado_factura_proveedor!='A') exit('No se puede adicionar items a un registro diferente a estado Activo!');
      if($concepto_item=='') exit('Por favor seleccione minimo una Comisi&oacute;n Liquidada!');
      $data = $Model -> getDataComisionesSel(substr($concepto_item, 0, -1),$this -> getConex());
      $this -> getArrayJSON($data);
      
  }
    
  protected function setDataFactura(){

    require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();    
    $factura_proveedor_id = $_REQUEST['factura_proveedor_id'];
    $data = $Model -> getDataFactura($factura_proveedor_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }
  
  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("CausarComisionModelClass.php");
    $Model           = new CausarComisionModel();
	$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($factura_proveedor_id,$this -> getConex());
	exit("$Estado");
	  
  } 

  protected function getTotalDebitoCredito(){
	  
  	require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();
	$factura_proveedor_id = $_REQUEST['factura_proveedor_id'];
	$data = $Model -> getTotalDebitoCredito($factura_proveedor_id,$this -> getConex());
	print json_encode($data);  
	  
  }
  protected function getContabilizar(){
	
  	require_once("CausarComisionModelClass.php");
    $Model = new CausarComisionModel();
	$factura_proveedor_id 	 = $_REQUEST['factura_proveedor_id'];
	$fecha_factura_proveedor = $_REQUEST['fecha_factura_proveedor'];
	$empresa_id = $this -> getEmpresaId(); 
	$oficina_id = $this -> getOficinaId();	
	$usuario_id = $this -> getUsuarioId();		
	
	
    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_factura_proveedor,$this -> getConex());
    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){
		$return=$Model -> getContabilizarReg($factura_proveedor_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$this -> getConex());
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
	  Campos CausarComision
	********************/
	
	$this -> Campos[factura_proveedor_id] = array(
		name	=>'factura_proveedor_id',
		id		=>'factura_proveedor_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('primary_key'))
	);


	$this -> Campos[numero_soporte] = array(
		name	=>'numero_soporte',
		id		=>'numero_soporte',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes'
	);

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden'
	);

	$this -> Campos[fuente_servicio_cod] = array(
		name	=>'fuente_servicio_cod',
		id		=>'fuente_servicio_cod',
		type	=>'hidden',
		value	=>'CO',
		//required=>'yes',
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
		
	);
	$this -> Campos[fuente_servicio] = array(
		name	=>'fuente_servicio',
		id		=>'fuente_servicio',
		type	=>'text',
		Boostrap=>'si',
		value	=>'Comisiones',
		//required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'2')
		
		
	);

	  
	$this -> Campos[comercial] = array(
		name	=>'comercial',
		id		=>'comercial',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		suggest=>array(
			name	=>'comercial',
			setId	=>'comercial_id',
			onclick => 'setDataComercial')
	);

	$this -> Campos[comercial_id] = array(
		name	=>'comercial_id',
		id		=>'comercial_id',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20')
		
	);

	$this -> Campos[proveedor_nit] = array(
		name	=>'proveedor_nit',
		id		=>'proveedor_nit',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);


	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
	);
      

	$this -> Campos[concepto_factura_proveedor] = array(
		name	=>'concepto_factura_proveedor',
		id		=>'concepto_factura_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		//size	=>100,
	 	datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[concepto_item] = array(
		name	=>'concepto_item',
		id		=>'concepto_item',
		type	=>'hidden',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250')
	);
      

	$this -> Campos[fecha_factura_proveedor] = array(
		name	=>'fecha_factura_proveedor',
		id		=>'fecha_factura_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[vence_factura_proveedor] = array(
		name	=>'vence_factura_proveedor',
		id		=>'vence_factura_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('factura_proveedor'),
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
			table	=>array('factura_proveedor'),
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
			table	=>array('factura_proveedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[ingreso_factura_proveedor] = array(
		name	=>'ingreso_factura_proveedor',
		id		=>'ingreso_factura_proveedor',
		type	=>'hidden',
		value	=>date("Y-m-d h:i:s"),
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		readonly=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20')
	);
	
	$this -> Campos[estado_factura_proveedor] = array(
		name	=>'estado_factura_proveedor',
		id		=>'estado_factura_proveedor',
		type	=>'select',
		Boostrap=>'si',
		disabled=>'yes',
		options => array(array(value => 'A', text => 'ACTIVO'),array(value => 'I', text => 'ANULADA'),array(value => 'C', text => 'CAUSADA')),
		selected=>'A',		
		datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
		
	);

	$this -> Campos[numero_pagos] = array(
		name	=>'numero_pagos',
		id		=>'numero_pagos',
		type	=>'hidden',
		value	=>'',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
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
			table	=>array('factura_proveedor'),
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

	$this -> Campos[anul_factura_proveedor] = array(
		name	=>'anul_factura_proveedor',
		id		=>'anul_factura_proveedor',
		type	=>'text',
		Boostrap=>'si',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('factura_proveedor'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[desc_anul_factura_proveedor] = array(
		name	=>'desc_anul_factura_proveedor',
		id		=>'desc_anul_factura_proveedor',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('factura_proveedor'),
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
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
		//tabindex=>'20'
	);
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		tabindex=>'14',
		onclick =>'onclickCancellation(this.form)'
	);	
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'CausarComisionOnReset()'
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
		Boostrap=>'si',
		size	=>'85',
		placeholder =>'Por Favor Digite El numero de la Causación',
		//tabindex=>'1',
		suggest=>array(
			name	=>'CausarComision',
			setId	=>'factura_proveedor_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$factura_proveedor_id = new CausarComision();

?>