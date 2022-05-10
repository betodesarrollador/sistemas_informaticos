<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ImpuestosOficina extends Controler{
	
  public function __construct(){
	$this -> setCampos();
	parent::__construct(2);
	
  }
  	
  public function Main(){
  
    $this -> noCache();
	require_once("ImpuestosOficinaLayoutClass.php");
	require_once("ImpuestosOficinaModelClass.php");
	
	$Layout   = new ImpuestosOficinaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ImpuestosOficinaModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	
	$Layout -> SetActividadesEconomicas($Model -> getActividadesEconomicas($this -> getConex()));
   	$Layout -> SetTiposUbicacion($Model -> getTiposUbicacion($this -> getConex()));
	//// GRID ////
	$Attributes = array(
	  id		=>'impuesto_oficina',
	  title		=>'Listado de Impuestos Oficina',
	  sortname	=>'nombre',
	  width		=>'auto',
	  height	=>'250'
	);
	
	$Cols = array(
	  array(name=>'razon_social',	        index=>'razon_social',          sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'oficina',                index=>'oficina',               sorttype=>'text',	width=>'80',	align=>'center'),	
	  array(name=>'puc_id',	                index=>'puc_id',                sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'nombre',	                index=>'nombre',	            sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'descripcion',	        index=>'descripcion',	        sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'tipo_ubicacion_id',		index=>'tipo_ubicacion_id',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'ubicacion_id',			index=>'ubicacion_id',		    sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'porcentaje',		        index=>'porcentaje',		    sorttype=>'int',	width=>'150',	align=>'center'),
	  array(name=>'formula',		        index=>'formula',		        sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'naturaleza',		        index=>'naturaleza',		    sorttype=>'text',	width=>'150',	align=>'center'),	
	  array(name=>'estado',		            index=>'estado',		        sorttype=>'text',	width=>'50',	align=>'center'),  
  	  array(name=>'actividad_economica_id', index=>'actividad_economica_id',sorttype=>'text',	width=>'150',	align=>'center')
	
	);
	  
    $Titles = array('EMPRESA',
					'OFICINA',
					'CODIGO',
					'NOMBRE',
					'DESCRIPCION',
					'APLICA',
					'UBICACION',
					'PORCENTAJE',
					'FORMULA',
                    'NATURALEZA',	
					'ESTADO',
					'ACTIVIDAD ECONOMICA'
	);
	
	$Layout -> SetGridImpuestosOficina($Attributes,$Titles,$Cols,$Model -> getQueryImpuestosOficinaGrid());
	$Layout -> RenderMain();
  
  }
  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"ImpuestosOficina",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }
  
  
  protected function onclickSave(){
    
  	require_once("ImpuestosOficinaModelClass.php");
    $Model = new ImpuestosOficinaModel();
    
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo ImpuestosOficina');
	  }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("ImpuestosOficinaModelClass.php");
    $Model = new ImpuestosOficinaModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Impuesto');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("ImpuestosOficinaModelClass.php");
    $Model = new ImpuestosOficinaModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
	  
  	require_once("ImpuestosOficinaModelClass.php");
	
    $Model      = new ImpuestosOficinaModel();
	$impuestoId = $_REQUEST['impuesto_oficina_id'];
			
	$Data  = $Model -> selectImpuestosOficina($impuestoId,$this -> getConex());
	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
	
	$list -> getList();
	  
  }  
  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[impuesto_oficina_id] = array(
		name	=>'impuesto_oficina_id',
		id		=>'impuesto_oficina_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[impuesto_id] = array(
		name	=>'impuesto_id',
		id		=>'impuesto_id',
		type	=>'hidden',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('column'))
	);
	
	$this -> Campos[empresa_id] = array(
		name	       =>'empresa_id',
		id		       =>'empresa_id',
		type	       =>'select',
		tabindex       =>'1',
		required       =>'yes',
		options        => array(),
        setoptionslist => array(childId=>'oficina_id'),
		transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('column'))		
	);		
	  	
		
	$this -> Campos[oficina_id] = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		tabindex =>'2',
		required =>'yes',		
		disabled =>'true',
		options  => array(),
		transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('column'))
	);	
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
		tabindex=>'3',
		datatype=>array(
			type	=>'alphanum_space',
			length	=>'100'),
		suggest=>array(
			name	=>'impuesto',
			form    =>'0',
			onclick	=>'setFormImpuesto'
			)
	);
		
	
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		tabindex=>'4',
		readonly=>'yes'		
	);		
	  
	
	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'text',
		readonly=>'yes',		
		tabindex=>'5',
		datatype=>array(
			type	=>'alphanum_space',
			length	=>'100')
	);		
	  
	$this -> Campos[tipo_ubicacion_id] = array(
		name	=>'tipo_ubicacion_id',
		id		=>'tipo_ubicacion_id',
		type	=>'select',
		options	=>array(),
		disabled=>'disabled',				
		tabindex=>'6',
	 	datatype=>array(
			type	=>'integer')
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		tabindex=>'7',
		readonly=>'yes'		
	);
		
	  		 
	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		id		=>'porcentaje',
		type	=>'text',
		required=>'yes',		
		tabindex=>'8',
		datatype=>array(
			type	  =>'numeric',
			length	  =>'15',
			presition =>'5'),
	 	transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('column'))
	);
	 
    $this -> Campos[formula] = array(
		type=>'textarea',
		readonly=>'yes',		
		datatype=>array(
			type=>'text',
			length=>'100'),
		name=>'formula',
		id=>'formula',
		tabindex=>'9'
	);
	
	$this -> Campos[naturaleza] = array(
		name	=>'naturaleza',
		id		=>'naturaleza',
		type	=>'select',
		disabled=>'disabled',				
		options	=>array(array(value=>'D',text=>'DEBITO',selected=>'D'),array(value=>'C',text=>'CREDITO')),
		tabindex=>'10',
	 	datatype=>array(
			type	=>'alphanum')
	);	
	
	$this -> Campos[actividad_economica_id] = array(
		name	=>'actividad_economica_id',
		id		=>'actividad_economica_id',
		type	=>'select',
		options	=>array(),
		tabindex=>'11',
		disabled=>'disabled',				
	 	datatype=>array(
			type	=>'integer',
			length	=>'1')
	);	
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=>array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
		tabindex=>'9',
	 	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('column'))
	);		
	 
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		tabindex=>'12',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'ImpuestoOnSaveOnUpdateonDelete')		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		tabindex=>'13',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ImpuestoOnSaveOnUpdateonDelete')		
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		tabindex=>'14',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ImpuestoOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		tabindex=>'15',
		onclick	=>'ImpuestoOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'impuesto_oficina',
			setId	=>'impuesto_oficina_id',
			onclick	=>'LlenarFormImpuesto')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
$ImpuestosOficina = new ImpuestosOficina();
?>