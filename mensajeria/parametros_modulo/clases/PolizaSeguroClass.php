<?php

require_once("../../../framework/clases/ControlerClass.php");

final class PolizaSeguro extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("PolizaSeguroLayoutClass.php");
    require_once("PolizaSeguroModelClass.php");
	
    $Layout   = new PolizaSeguroLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PolizaSeguroModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas		($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
	$Layout -> setAseguradora	($Model -> getAseguradora($this -> getConex()));
	
	//LISTA MENU

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'PolizaSeguro',
	  title		=>'Poliza',
	  sortname	=>'empresa',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'empresa',index=>'empresa',sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'aseguradora',index=>'aseguradora',sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'numero',index=>'numero',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'fecha_expedicion',index=>'fecha_expedicion',	sorttype=>'text',	width=>'100',	align=>'center'),
	  //array(name=>'fecha_vigencia',index=>'fecha_vigencia',	sorttype=>'text',	width=>'100',	align=>'center'),	  	  
	  array(name=>'fecha_vencimiento',index=>'fecha_vencimiento',	sorttype=>'text',	width=>'100',	align=>'center'),	  	  	  
	  array(name=>'costo_poliza',index=>'costo_poliza',	sorttype=>'text',	width=>'100',	align=>'center'),
	  
	  
	  array(name=>'deducible',index=>'deducible',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'valor_maximo_despacho',index=>'valor_maximo_despacho',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'modelo_minimo_vehiculo',index=>'modelo_minimo_vehiculo',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'hora_inicio_permitida',index=>'hora_inicio_permitida',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'hora_final_permitida',index=>'hora_final_permitida',	sorttype=>'text',	width=>'100',	align=>'center')	  	  	  	  	  
	   	  
	);
    $Titles = array('EMPRESA','ASEGURADORA','NUMERO','FECHA EXP'/*,'FECHA VIG'*/,'FECHA VENC','COSTO'
	,'DEDUCIBLE','VALOR MAXIMO','MODELO MINIMO','HORA INICIO','HORA FINAL');
	$Layout -> SetGridPolizaSeguro($Attributes,$Titles,$Cols,$Model -> getQueryPolizaSeguroGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"poliza_empresa",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("PolizaSeguroModelClass.php");
    $Model = new PolizaSeguroModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la Poliza');
    }	
  }

  protected function onclickUpdate(){
    require_once("PolizaSeguroModelClass.php");
	$Model = new PolizaSeguroModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la Poliza');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("PolizaSeguroModelClass.php");
    $Model = new PolizaSeguroModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Poliza');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("../../../framework/clases/FindRowClass.php");
    $Data1 = new FindRow($this -> getConex(),"poliza_empresa",$this ->Campos);
    $this -> getArrayJSON($Data1 -> GetData());
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[poliza_empresa_id] = array(
		name	=>'poliza_empresa_id',
		id		=>'poliza_empresa_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('primary_key'))
	);
	 
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[aseguradora_id] = array(
		name	=>'aseguradora_id',
		id		=>'aseguradora_id',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_expedicion] = array(
		name	=>'fecha_expedicion',
		id		=>'fecha_expedicion',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_vencimiento] = array(
		name	=>'fecha_vencimiento',
		id		=>'fecha_vencimiento',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero] = array(
		name	=>'numero',
		id		=>'numero',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[costo_poliza] = array(
		name	=>'costo_poliza',
		id		=>'costo_poliza',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	 =>'numeric',
			length	 =>'18',
			precision=>'0'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[deducible] = array(
		name	=>'deducible',
		id		=>'deducible',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	 =>'numeric',
			length	 =>'18',
			precision=>'0'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor_maximo_despacho] = array(
		name	=>'valor_maximo_despacho',
		id		=>'valor_maximo_despacho',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	 =>'numeric',
			length	 =>'18',
			precision=>'0'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[modelo_minimo_vehiculo] = array(
		name	=>'modelo_minimo_vehiculo',
		id		=>'modelo_minimo_vehiculo',
		type	=>'text',
		required=>'yes',
		size    =>'4',
		maxlength=>'4',
    	datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[hora_inicio_permitida] = array(
		name	=>'hora_inicio_permitida',
		id		=>'hora_inicio_permitida',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'time',
			length	=>'20'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[hora_final_permitida] = array(
		name	=>'hora_final_permitida',
		id		=>'hora_final_permitida',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'time',
			length	=>'20'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		required=>'yes',
		options => array(array(value => 'A', text => 'ACTIVA' , selected => 'A'),array(value => 'I',text => 'INACTIVA', selected => 'A')),
    	datatype=>array( type =>'alpha'),
		transaction=>array(
			table	=>array('poliza_empresa'),
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
			onsuccess=>'PolizaSeguroOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'PolizaSeguroOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'PolizaSeguroOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'PolizaSeguroOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_poliza_seguro',
			setId	=>'poliza_empresa_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$PolizaSeguro = new PolizaSeguro();

?>