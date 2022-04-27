<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ParametrosLiquidacion extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("ParametrosLiquidacionLayoutClass.php");
	require_once("ParametrosLiquidacionModelClass.php");
	
	$Layout   = new ParametrosLiquidacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosLiquidacionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	
	$Layout -> SetTiposDocumentoContable($Model -> getTiposDocumentoContable($this -> getConex()));
	$Layout->SetTiposDocumentoContableDescu($Model->getTiposDocumentoContable($this->getConex()));
	$Layout->SetTiposDocumentoContableSobre($Model->getTiposDocumentoContable($this->getConex()));


	//// GRID ////
	$Attributes = array(
	  id		=>'parametros_liquidacion',
	  title		=>'Listado de Parametros Anticipo',
	  sortname	=>'tipo_documento',
	  width		=>'auto',
	  height	=>'250'
	);
	

	$Cols = array(
	  array(name=>'empresa',	            index=>'empresa',               sorttype=>'text',	width=>'270',	align=>'center'),
	  array(name=>'oficina',                index=>'oficina',               sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'tipo_documento',	        index=>'tipo_documento',	    sorttype=>'text',	width=>'200',	align=>'center')	
	);
	  
    $Titles = array('EMPRESA',
					'OFICINA',
					'DOCUMENTO CONTABLE'
	);
	
	$Layout -> SetGridParametrosLiquidacion($Attributes,$Titles,$Cols,$Model -> getQueryParametrosLiquidacionGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"ParametrosLiquidacion",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }
  
  
  protected function onclickSave(){
      
  	require_once("ParametrosLiquidacionModelClass.php");
    $Model = new ParametrosLiquidacionModel();
    
	$oficina_id = $this -> getOficinaId();
	
	$Model -> Save($this -> Campos,$oficina_id,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Parametro Ingresado Exitosamente!!');
	  }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("ParametrosLiquidacionModelClass.php");
    $Model = new ParametrosLiquidacionModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Parametro Actualizado Exitosamente');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("ParametrosLiquidacionModelClass.php");
    $Model = new ParametrosLiquidacionModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
	  
  	require_once("ParametrosLiquidacionModelClass.php");
	
    $Model                  = new ParametrosLiquidacionModel();
	$parametros_liquidacion_id = $_REQUEST['parametros_liquidacion_id'];
			
	$Data  = $Model -> selectParametrosLiquidacion($parametros_liquidacion_id,$this -> getConex());
	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  
  
  protected function setOficinasCliente(){
  
	require_once("ParametrosLiquidacionLayoutClass.php");
	require_once("ParametrosLiquidacionModelClass.php");
	
	$Layout     = new ParametrosLiquidacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model      = new ParametrosLiquidacionModel();
	$empresa_id = $_REQUEST['empresa_id'];
	$oficina_id = $_REQUEST['oficina_id'];
	
	$oficinas = $Model -> selectOficinasEmpresa($empresa_id,$oficina_id,$this -> getConex());
	

	if(!count($oficinas) > 0){
	  $oficinas = array();
	}

      $field = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		options  => $oficinas,
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	  );
	  
	print $Layout -> getObjectHtml($field);
	 
  }

  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[parametros_liquidacion_id] = array(
		name	=>'parametros_liquidacion_id',
		id		=>'parametros_liquidacion_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('primary_key'))
	);

		
	$this -> Campos[empresa_id] = array(
		name	       =>'empresa_id',
		id		       =>'empresa_id',
		type	       =>'select',
		required       =>'yes',
		options        => array(),
        setoptionslist => array(childId=>'oficina_id'),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))		
	);		
	  	
		
	$this -> Campos[oficina_id] = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		disabled =>'true',
		options  => array(),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);	
	
		
	$this -> Campos[tipo_documento_id] = array(
		name	 =>'tipo_documento_id',
		id		 =>'tipo_documento_id',
		type	 =>'select',
		required =>'yes',		
		options  => array(),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);	
	
	$this->Campos[tipo_documento_descu_id] = array(
		name => 'tipo_documento_descu_id',
		id => 'tipo_documento_descu_id',
		type => 'select',
		required => 'yes',
		options => array(),
		transaction => array(
			table => array('parametros_liquidacion'),
			type => array('column')),
	);

	$this->Campos[tipo_documento_sobre_id] = array(
		name => 'tipo_documento_sobre_id',
		id => 'tipo_documento_sobre_id',
		type => 'select',
		required => 'yes',
		options => array(),
		transaction => array(
			table => array('parametros_liquidacion'),
			type => array('column')),
	);
	
		
	$this -> Campos[flete_pactado] = array(
		name	=>'flete_pactado',
		id		=>'flete_pactado',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'flete_pactado_id_hidden'
			)
	);
	
	$this -> Campos[flete_pactado_id] = array(
		name	=>'flete_pactado_id',
		id		=>'flete_pactado_id_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);	

	
	$this ->Campos[naturaleza_flete_pactado] = array(
		name	 =>'naturaleza_flete_pactado',
		id		 =>'naturaleza_flete_pactado',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);		
	
	
	
	
	
	
	
	
	
	
	
	
	$this -> Campos[sobre_flete] = array(
		name	=>'sobre_flete',
		id		=>'sobre_flete',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'sobre_flete_id_hidden'
			)
	);	
			
	$this -> Campos[sobre_flete_id] = array(
		name	=>'sobre_flete_id',
		id		=>'sobre_flete_id_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);	
	
	$this -> Campos[naturaleza_sobre_flete] = array(
		name	 =>'naturaleza_sobre_flete',
		id		 =>'naturaleza_sobre_flete',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);			
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	$this -> Campos[anticipo] = array(
		name	=>'anticipo',
		id		=>'anticipo',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'anticipo_id_hidden'
			)
	);
	
	$this -> Campos[anticipo_id] = array(
		name	=>'anticipo_id',
		id		=>'anticipo_id_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[naturaleza_anticipo] = array(
		name	 =>'naturaleza_anticipo',
		id		 =>'naturaleza_anticipo',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);		
	
	$this -> Campos[saldo_por_pagar] = array(
		name	=>'saldo_por_pagar',
		id		=>'saldo_por_pagar',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'saldo_por_pagar_id_hidden'
			)
	);	
			
	$this -> Campos[saldo_por_pagar_id] = array(
		name	=>'saldo_por_pagar_id',
		id		=>'saldo_por_pagar_id_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);	
	
	$this -> Campos[naturaleza_saldo_por_pagar] = array(
		name	 =>'naturaleza_saldo_por_pagar',
		id		 =>'naturaleza_saldo_por_pagar',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_liquidacion'),
			type	=>array('column'))
	);		

	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'parametrosLiquidacionOnSaveOnUpdateonDelete')
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'parametrosLiquidacionOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'parametrosLiquidacionOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'parametrosLiquidacionOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		placeholder=>'ESCRIBA EL NOMBRE DEL DOCUMENTO CONTABLE',																				
		suggest=>array(
			name	=>'parametros_liquidacion',
			setId	=>'parametros_liquidacion_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$ParametrosLiquidacion = new ParametrosLiquidacion();

?>