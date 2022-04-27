<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TablaImpuestos extends Controler{

  public function __construct(){
  	parent::__construct(3);  
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("TablaImpuestosLayoutClass.php");
    require_once("TablaImpuestosModelClass.php");
	
    $Layout   = new TablaImpuestosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TablaImpuestosModel();
	    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
//	$Layout -> setBases($Model -> getBases($this -> getUsuarioId(),$this -> getConex()));	
    $Layout -> setImpuestos($Model -> getImpuestos($this -> getEmpresaId(),$this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'TablaImpuestos',
	  title		=>'Tabla de Impuestos',
	  sortname	=>'impuesto',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'impuesto',	     index=>'impuesto',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'puc',		     index=>'puc',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'agencia',	     index=>'agencia',	sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'base',	     index=>'base',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'base_impuesto_id',	     index=>'base_impuesto_id',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'orden',	     index=>'orden',	sorttype=>'text',	width=>'100',	align=>'center'),	  	  	  
	  array(name=>'visible_en_impresion',index=>'visible_en_impresion',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',		     index=>'estado',	sorttype=>'text',	width=>'50',	align=>'center')
	);
    $Titles = array('IMPUESTO',
					'CODIGO CONTABLE',
					'AGENCIA',
					'BASE',
					'IMPUESTO BASE',
					'ORDEN',
                    'VISIBLE IMP',
					'ESTADO'
	);
	$Layout -> SetGridTablaImpuestos($Attributes,$Titles,$Cols,$Model -> getQueryTablaImpuestosGrid());
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"tabla_impuestos",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("TablaImpuestosModelClass.php");
	$Model = new TablaImpuestosModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente el descuento');
    }	
  }

  protected function onclickUpdate(){  
    require_once("TablaImpuestosModelClass.php");
	$Model = new TablaImpuestosModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el descuento');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("TablaImpuestosModelClass.php");
    $Model = new TablaImpuestosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el descuento');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("TablaImpuestosModelClass.php");
    $Model = new TablaImpuestosModel();
	$Data  = $Model -> selectTablaImpuestos($this -> getConex());
    $this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
    require_once("../../../framework/clases/ListaDependiente.php");
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
	$list -> getList();
  }

  protected function getOficinasImpuesto(){

  	require_once("TablaImpuestosModelClass.php");
	
    $Model       = new TablaImpuestosModel();		
	$tabla_impuestos_id = $_REQUEST['tabla_impuestos_id'];
	//echo("tabla impuesto id : ".$tabla_impuestos_id);
	$data        = $Model -> selectOficinasImpuesto($tabla_impuestos_id,$this -> getConex());
  
    $this -> getArrayJSON($data);
  
  }
  

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[tabla_impuestos_id] = array(
		name	=>'tabla_impuestos_id',
		id		=>'tabla_impuestos_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('primary_key'))
	);
		
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		options=> array(),
        setoptionslist => array(childId=>'oficina_id'),
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
		multiple=>'yes',
    	datatype=>array(
			type	=>'integer')
	);
	
	$this -> Campos[impuesto_id] = array(
		name	=>'impuesto_id',
		id		=>'impuesto_id',
		type	=>'select',
		required=>'yes',
		options =>array(),
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);
		
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);
	
	$this -> Campos[base] = array(
		name	=>'base',
		id		=>'base',
		type	=>'select',
		options => array(array(value => 'F', text => 'Valor del Flete',selected => 'F'),array(value => 'I', text => 'Impuesto', selected => 'F')),
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);	
	
	$this -> Campos[base_impuesto_id] = array(
		name	=>'base_impuesto_id',
		id		=>'base_impuesto_id',
		type	=>'select',
		options => array(),
		disabled=>'disabled',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);		
	

	$this -> Campos[visible_en_impresion] = array(
		name	=>'visible_en_impresion',
		id	=>'visible_en_impresion',
		type	=>'select',
		options => array(
				array(value=>1,text=>'SI',selected => 1),
				array(value=>0,text=>'NO',selected => 1)),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);
	
	$this -> Campos[orden] = array(
		name	=>'orden',
		id	    =>'orden',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);	

	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options => array(
				array(value=>'A',text=>'Activo'),
				array(value=>'I',text=>'Inactivo')),
		required=>'yes',
    	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);
	
	$this -> Campos[rte] = array(
		name	=>'rte',
		id		=>'rte',
		type	=>'select',
		options =>array(array(value => 0, text => 'NO'),array(value => 1, text => 'SI')),
		selected=>0,
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
			type	=>array('column'))
	);
	 
	$this -> Campos[ica] = array(
		name	=>'ica',
		id		=>'ica',
		type	=>'select',	
		options =>array(array(value => 0, text => 'NO'),array(value => 1, text => 'SI')),
		selected=>0,		
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('tabla_impuestos'),
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
			onsuccess=>'TablaImpuestosOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'TablaImpuestosOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TablaImpuestosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TablaImpuestosOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		placeholder=>'ESCRIBA EL NOMBRE DEL IMPUESTO',						
		//tabindex=>'1',
		suggest=>array(
			name	=>'tabla_impuestos',
			setId	=>'descuento_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$TablaImpuestos = new TablaImpuestos();

?>