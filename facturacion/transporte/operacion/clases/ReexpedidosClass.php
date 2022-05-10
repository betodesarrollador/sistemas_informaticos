<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Reexpedidos extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("ReexpedidosLayoutClass.php");
	require_once("ReexpedidosModelClass.php");
	
	$Layout   = new ReexpedidosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReexpedidosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	
    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Reexpedidos',
	  title		=>'Listado de Reexpedidos',
	  sortname	=>'numero_remesa',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'numero_remesa',	index=>'numero_remesa',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'reexpedido',		index=>'reexpedido',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'fecha_rxp',		index=>'fecha_rxp',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'proveedor',		index=>'proveedor',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'origen',			index=>'origen',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',		index=>'destino',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'guia_rxp',		index=>'guia_rxp',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'valor_rxp',		index=>'valor_rxp',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'obser_rxp',		index=>'obser_rxp',		sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('REMESA',
					'REEXPEDIDO',
					'FECHA',
					'PROVEEDOR',
					'ORIGEN',
					'DESTINO',
					'GUIA PROVEEDOR',
					'VALOR',
					'OBSERVACIONES'
	);
	
	$Layout -> SetGridReexpedidos($Attributes,$Titles,$Cols,$Model -> getQueryReexpedidosGrid());
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"reexpedido",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }


  protected function onclickSave(){
  
    require_once("ReexpedidosModelClass.php");
    $Model = new ReexpedidosModel();
	
	$result = $Model -> Save($this -> Campos,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
       $this -> getArrayJSON($result);
	 }
  }


  protected function onclickUpdate(){
  
    require_once("ReexpedidosModelClass.php");
	$Model = new ReexpedidosModel();
	
	$Model -> Update($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
  }
  
	  
  protected function onclickDelete(){
  	require_once("ReexpedidosModelClass.php");
    $Model = new ReexpedidosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Reexpedido');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("ReexpedidosModelClass.php");
    $Model = new ReexpedidosModel();
	
    $reexpedido_id = $_REQUEST['reexpedido_id'];
	
    $Data =  $Model -> selectReexpedidos($reexpedido_id,$this -> getConex());
	
    $this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//FORMULARIO
	$this -> Campos[reexpedido_id] = array(
		name	=>'reexpedido_id',
		id		=>'reexpedido_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[reexpedido] = array(
		name	=>'reexpedido',
		id		=>'reexpedido',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_remesa] = array(
		name	=>'numero_remesa',
		id		=>'numero_remesa',
		type	=>'text',
		required=>'no',
		size	=>'7',
		suggest=>array(
			name	=>'remesa',
			setId	=>'remesa_hidden')
	);
	
	$this -> Campos[remesa_id] = array(
		name	=>'remesa_id',
		id		=>'remesa_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_rxp] = array(
		name	=>'fecha_rxp',
		id		=>'fecha_rxp',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		value	=>'',
//		tabindex=>'4',
    	suggest=>array(
			name	=>'tercero',
			setId	=>'proveedor_hidden')
	);
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_hidden',
		type	=>'hidden',
		value	=>'1',
		datatype=>array(
			type	=>'numeric',
			length	=>'11'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
//		tabindex=>'8',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'origen_hidden')
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
//		tabindex=>'13',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'destino_hidden')
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[guia_rxp] = array(
		name	=>'guia_rxp',
		id		=>'guia_rxp',
		type	=>'text',
//		tabindex=>'34',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[valor_rxp] = array(
		name	=>'valor_rxp',
		id		=>'valor_rxp',
		type	=>'text',
//		tabindex=>'27',
		datatype=>array(
			type	=>'numeric',
			length	=>'12'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[obser_rxp] = array(
		name	=>'obser_rxp',
		id		=>'obser_rxp',
		type	=>'text',
//		tabindex=>'35',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	
	
	
	
	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'ReexpedidosOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ReexpedidosOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ReexpedidosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		disabled=>'disabled',
		onclick =>'ReexpedidosOnReset()'
	);
	
	//BUSQUEDA
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_reexpedido',
			setId	=>'reexpedido_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$Reexpedidos = new Reexpedidos();

?>