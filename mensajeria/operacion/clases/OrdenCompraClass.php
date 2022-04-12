<?php

require_once("../../../framework/clases/ControlerClass.php");

final class OrdenCompra extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
	   
    $this -> noCache();
    
	require_once("OrdenCompraLayoutClass.php");
	require_once("OrdenCompraModelClass.php");
	
	$Layout   = new OrdenCompraLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new OrdenCompraModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas		($Model -> getEmpresas		($this -> getUsuarioId(),$this -> getConex()));
   	//$Layout -> SetServiConexo	($Model -> GetServiConexo	($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'OrdenCompra',
	  title		=>'Ordenes de Compra Serv. Complementarios',
	  sortname	=>'orden_compra',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'orden_compra',	index=>'orden_compra',	sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'agencia',		index=>'agencia',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'servi_conex',	index=>'servi_conex',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'fecha',			index=>'fecha',			sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'proveedor',		index=>'proveedor',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'identificacion',	index=>'identificacion',sorttype=>'text',	width=>'150',	align=>'center')
	);
    $Titles = array('ORDEN COMPRA',
					'AGENCIA',
					'SERV. COMPLEMENTARIO',
					'FECHA ORDEN',
					'PROVEEDOR',
					'DOC PROVEEDOR'
	);
	$Layout -> SetGridOrdenCompra($Attributes,$Titles,$Cols,$Model -> getQueryOrdenCompraGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  
  protected function getProveedor(){
	require_once("OrdenCompraModelClass.php");
    $Model     = new OrdenCompraModel();
	$return = $Model -> selectProveedor($this -> getConex());
	
	if(count($return) > 0){
	  print json_encode($return);
	}else{
	    exit('false');
	  }
  }
  
  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"ordencompra_conexo",$this ->Campos);
    print json_encode($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("OrdenCompraModelClass.php");
    $Model = new OrdenCompraModel();
    $Data = $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      print json_encode($Data);
    }	
  }

  protected function onclickUpdate(){
    require_once("OrdenCompraModelClass.php");
	$Model = new OrdenCompraModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("OrdenCompraModelClass.php");
    $Model = new OrdenCompraModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la alerta');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("OrdenCompraModelClass.php");
    $Model = new OrdenCompraModel();
    $Data =  $Model -> selectOrdenCompra($this -> getConex());
	
    print json_encode($Data);
  }
  
  protected function onchangeSetOptionList(){
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$listChild = $this -> requestDataForQuery('listChild','integer');
	
	if( $listChild == 'oficina_id'){
		$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
	}elseif( $listChild == 'servi_conex_id' ){
		$list = new ListaDependiente($this -> getConex(),'servi_conex_id',array(table=>'servicio_conexo',value=>'servi_conex_id',text=>'servi_conex',concat=>''),$this -> Campos);
	}
	
	$list -> getList();
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[ordencompra_id] = array(
		name	=>'ordencompra_id',
		id		=>'ordencompra_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('ordencompra_conexo'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[orden_compra] = array(
		name	=>'orden_compra',
		id		=>'orden_compra',
		type	=>'text',
		size	=>'8',
		readonly=>'readonly',
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('ordencompra_conexo'),
			type	=>array('column'))
	);
	
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		options=> array(),
        setoptionslist => array(childId=>'oficina_id'),
		required=>'yes',
		datatype=>array(
			type	=>'integer')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options  => array(),
        setoptionslist => array(childId=>'servi_conex_id'),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('ordencompra_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[servi_conex_id] = array(
		name	=>'servi_conex_id',
		id		=>'servi_conex_id',
		type	=>'select',
		required=>'yes',
		options	=> array(),
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('ordencompra_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		value	=>date("Y-m-d"),
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('ordencompra_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		required=>'yes',
    	suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_hidden',
			onclick	=>'getProveedor')
	);
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('ordencompra_conexo'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id		=>'numero_identificacion',
		type	=>'text',
		datatype=>array(
			type	=>'text')
	);
	
	$this -> Campos[direccion] = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
    	datatype=>array(
			type	=>'alphanum',
			length	=>'100')
	);
	
	$this -> Campos[telefono] = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
    	datatype=>array(
			type	=>'alphanum',
			length	=>'20')
	);
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'OrdenCompraOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'OrdenCompraOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'OrdenCompraOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'OrdenCompraOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		//value	=>'',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_ordencompra_conex',
			setId	=>'ordencompra_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$OrdenCompra = new OrdenCompra();

?>