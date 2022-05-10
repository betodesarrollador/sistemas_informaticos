<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Impuestos extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();
	require_once("ImpuestosLayoutClass.php");
	require_once("ImpuestosModelClass.php");
	
	$Layout   = new ImpuestosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ImpuestosModel();
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));		
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("ImpuestosLayoutClass.php");
	require_once("ImpuestosModelClass.php");
	
	$Layout   = new ImpuestosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ImpuestosModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'impuesto',
		title		=>'Listado de Impuestos',
		sortname	=>'nombre',
		width		=>'auto',
		height	=>'250'
	  );
	  
	  $Cols = array(
	  
		array(name=>'puc_id',	                index=>'puc_id',                sorttype=>'text',	width=>'80',	align=>'center'),
		array(name=>'nombre',	                index=>'nombre',	            sorttype=>'text',	width=>'250',	align=>'center'),
		array(name=>'exentos',	            index=>'exentos',	            sorttype=>'text',	width=>'200',	align=>'left'),
		array(name=>'subcodigo',	            index=>'subcodigo',	            sorttype=>'text',	width=>'200',	align=>'left'),
		array(name=>'naturaleza',		        index=>'naturaleza',		    sorttype=>'text',	width=>'150',	align=>'center'),	
		array(name=>'estado',		            index=>'estado',		        sorttype=>'text',	width=>'50',	align=>'center')//,  
	  
	  );
		
	  $Titles = array('CODIGO',
					  'NOMBRE',
					  'TIPO IMPUESTO',
					  'SUBCODIGO',					
					  'NATURALEZA',		
					  'ESTADO'
	  );
	  
	 $html = $Layout -> SetGridImpuestos($Attributes,$Titles,$Cols,$Model -> getQueryImpuestosGrid());
	 
	 print $html;
	  
  }
  
  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"Impuestos",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }
  
  
  protected function onclickSave(){
    
  	require_once("ImpuestosModelClass.php");
    $Model = new ImpuestosModel();
    
	$result = $Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit("$result");
	  }
	
  }

  protected function onclickUpdate(){
	  
  	require_once("ImpuestosModelClass.php");
    $Model = new ImpuestosModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Impuesto');
	  }
	  
  }
  
  
  protected function onclickDelete(){
  	require_once("ImpuestosModelClass.php");
    $Model = new ImpuestosModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
	  
  	require_once("ImpuestosModelClass.php");
	
    $Model      = new ImpuestosModel();
	$impuestoId = $_REQUEST['impuesto_id'];
	
	$Data  = $Model -> selectImpuestos($impuestoId,$this -> getConex());
	
	$this -> getArrayJSON($Data);
  }
  
  protected function findImpuesto(){
  
  	require_once("ImpuestosModelClass.php");
	
    $Model  = new ImpuestosModel();		
    $puc_id = $_REQUEST['puc_id'];		
	$data   = $Model -> selectImpuestoPuc($puc_id,$this -> getConex());	
		
	if(count($data) > 0){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
      }
  
  }
  
  protected function onchangeSetOptionList(){
	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
    $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
                                   'nombre',concat=>' ',order=>'nombre'),$this -> Campos);		
	
	$list -> getList();
	  
  } 
  
  protected function getOficinasImpuesto(){
  	require_once("ImpuestosModelClass.php");
	
    $Model       = new ImpuestosModel();		
	$impuesto_id = $_REQUEST['impuesto_id'];
	$data        = $Model -> selectOficinasImpuesto($impuesto_id,$this -> getConex());
  
    $this -> getArrayJSON($data);
  
  }  
  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[impuesto_id] = array(
		name	=>'impuesto_id',
		id		=>'impuesto_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[empresa_id] = array(
		name	       =>'empresa_id',
		id		       =>'empresa_id',
		type	       =>'select',
		Boostrap=>'si',
		required       =>'yes',
		options        => array(),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column')),
        setoptionslist=>array(childId=>'oficina_id')				
	);		
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		multiple=>'yes',
		options	=>array(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9'),
		transaction=>array(
			table	=>array('impuesto_oficina'),
			type	=>array('column'))
	);	
	
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		Boostrap=>'si',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_hidden',
			form    =>'0',
			onclick =>'findImpuesto'
			)		
	);		
	  
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);	  

	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		Boostrap=>'si',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'ubicacion_id',
			)		
	);		
	  
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);	  
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',		
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);
	
	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',		
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);		
	$this -> Campos[exentos] = array(
		name	=>'exentos',
		id		=>'exentos',
		type	=>'select',
        Boostrap=>'si',
		options => array(
						 array(value => 'RT', text => 'RENTA (Autorretenedores RENTA)', selected => 'NN'),
						 array(value => 'IC', text => 'ICA (Autorretenedores ICA)',selected => 'NN'),
						 array(value => 'IV', text => 'IVA',selected => 'NN'),
						 array(value => 'RIV', text => 'RETEIVA',selected => 'NN'),
						 array(value => 'RIC', text => 'RETEICA',selected => 'NN')),

		//options => array(array(value => 'RT', text => 'Autorretenedores RENTA', selected => 'NN'),array(value => 'IC', text => 'Autorretenedores ICA',selected => 'NN'),array(value => 'AI',text => 'RteIva',selected => 'NN')),
		required=>'yes',		
		datatype=>array(
			type	=>'alpha',
			length	=>'3'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);	

	$this -> Campos[subcodigo] = array(
		name	=>'subcodigo',
		id		=>'subcodigo',
		type	=>'select',
		Boostrap=>'si',
		disabled=>'yes',
		options => array(
						 array(value => '3',text => 'Compras',selected => 'NULL'),
						 array(value => '5', text => 'Honorarios', selected => 'NULL'),
						 array(value => '6', text => 'Servicios Generales',selected => 'NULL'),
						 array(value => '7', text => 'Transporte Carga',selected => 'NULL'),
						 array(value => '21', text => 'Otras Retenciones',selected => 'NULL')),
		//required=>'yes',		
		datatype=>array(
			type	=>'alpha',
			length	=>'3'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);		

	$this -> Campos[naturaleza] = array(
		name	=>'naturaleza',
		id		=>'naturaleza',
		type	=>'select',
		Boostrap=>'si',
		options	=>array(array(value=>'D',text=>'DEBITO',selected=>'D'),array(value=>'C',text=>'CREDITO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);	
			
	 	
	$this -> Campos[ayuda] = array(
		name	=>'ayuda',
		id		=>'ayuda',
		type	=>'textarea',
	 	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);
	
	$this -> Campos[para_terceros] = array(
		name	=>'para_terceros',
		id		=>'para_terceros',
		type	=>'select',
		Boostrap=>'si',
		options	=>array(array(value=>'0',text=>'NO',selected=>'0'),array(value=>'1',text=>'SI')),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('impuesto'),
			type	=>array('column'))
	);	 
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap=>'si',
		options	=>array(array(value=>'A',text=>'ACTIVO',selected=>'A'),array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('impuesto'),
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
			onsuccess=>'ImpuestoOnSave')		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ImpuestoOnUpdate')		
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ImpuestoOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ImpuestoOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		placeholder=>'ESCRIBA EL C&Oacute;DIGO CONTABLE O EL NOMBRE DEL IMPUESTO',												
		suggest=>array(
			name	=>'impuesto',
			setId	=>'impuesto_id',
			onclick	=>'LlenarFormImpuesto')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}
$Impuestos = new Impuestos();
?>