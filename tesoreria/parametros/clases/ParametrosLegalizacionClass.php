<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ParametrosLegalizacion extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){  
    $this -> noCache();

	require_once("ParametrosLegalizacionLayoutClass.php");
	require_once("ParametrosLegalizacionModelClass.php");
	
	$Layout   = new ParametrosLegalizacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosLegalizacionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	
	$Layout -> SetTiposDocumentoContable($Model -> getTiposDocumentoContable($this -> getConex()));

	//// GRID ////
	$Attributes = array(
	  id		=>'parametros_legalizacion',
	  title		=>'Listado de Parametros',
	  sortname	=>'tipo_documento',
	  width		=>'auto',
	  height	=>'250'
	);	

	$Cols = array(
	  array(name=>'empresa',	            index=>'empresa',               sorttype=>'text',	width=>'270',	align=>'center'),
	  array(name=>'oficina',                index=>'oficina',               sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'tipo_documento',	        index=>'tipo_documento',	    sorttype=>'text',	width=>'200',	align=>'center')	
	);
	  
    $Titles = array('EMPRESA','OFICINA','DOCUMENTO CONTABLE'
	);
	
	$Layout -> SetGridParametrosLegalizacion($Attributes,$Titles,$Cols,$Model -> getQueryParametrosLegalizacionGrid());
	$Layout -> RenderMain();  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"ParametrosLegalizacion",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }  
  
  protected function onclickSave(){      
  	require_once("ParametrosLegalizacionModelClass.php");
    $Model = new ParametrosLegalizacionModel();    
	$oficina_id = $this -> getOficinaId();	
	$Model -> Save($this -> Campos,$oficina_id,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }	
  }

  protected function onclickUpdate(){	  
  	require_once("ParametrosLegalizacionModelClass.php");
    $Model = new ParametrosLegalizacionModel();	
    $Model -> Update($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }	  
  }  
  
  protected function onclickDelete(){
  	require_once("ParametrosLegalizacionModelClass.php");
    $Model = new ParametrosLegalizacionModel();	
	$Model -> Delete($this -> Campos,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){	  
  	require_once("ParametrosLegalizacionModelClass.php");	
    $Model                  = new ParametrosLegalizacionModel();
	$parametros_legalizacion_caja_id = $_REQUEST['parametros_legalizacion_caja_id'];			
	$Data  = $Model -> selectParametrosLegalizacion($parametros_legalizacion_caja_id,$this -> getConex());	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){  	  
    require_once("../../../framework/clases/ListaDependiente.php");	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);		
	$list -> getList();	  
  }  
  
  protected function setOficinasCliente(){  
	require_once("ParametrosLegalizacionLayoutClass.php");
	require_once("ParametrosLegalizacionModelClass.php");	
	$Layout     = new ParametrosLegalizacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model      = new ParametrosLegalizacionModel();
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
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))
	  );
	  
	print $Layout -> getObjectHtml($field);
	 
  }

  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[parametros_legalizacion_caja_id] = array(
		name	=>'parametros_legalizacion_caja_id',
		id		=>'parametros_legalizacion_caja_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('primary_key'))
	);

		
	$this -> Campos[empresa_id] = array(
		name	       =>'empresa_id',
		id		       =>'empresa_id',
		type	       =>'select',
		required       =>'yes',
		datatype=>array(
			type	=>'integer'),		
		options        => array(),
        setoptionslist => array(childId=>'oficina_id'),
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))		
	);		
	  	
		
	$this -> Campos[oficina_id] = array(
		name	 =>'oficina_id',
		id		 =>'oficina_id',
		type	 =>'select',
		required =>'yes',		
		disabled =>'true',
		options  => array(),
		datatype=>array(
			type	=>'integer'),		
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))
	);	
	
		
	$this -> Campos[tipo_documento_id] = array(
		name	 =>'tipo_documento_id',
		id		 =>'tipo_documento_id',
		type	 =>'select',
		required =>'yes',	
		datatype=>array(
			type	=>'integer'),		
		options  => array(),
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))
	);		
		
	$this -> Campos[contrapartida] = array(
		name	=>'contrapartida',
		id		=>'contrapartida',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'contrapartida_id_hidden',
			onclick =>'setNombreCuentaContrapartida'
			)
	);
	
	$this -> Campos[contrapartida_id] = array(
		name	=>'contrapartida_id',
		id		=>'contrapartida_id_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))
	);	

	$this -> Campos[nombre_contrapartida] = array(
		name	=>'nombre_contrapartida',
		id		=>'nombre_contrapartida',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))
			
	);	
	
	$this ->Campos[naturaleza_contrapartida] = array(
		name	 =>'naturaleza_contrapartida',
		id		 =>'naturaleza_contrapartida',
		type	 =>'select',		
		required =>'yes',		
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_legalizacion_caja'),
			type	=>array('column'))
	);			

	//botones
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
			onsuccess=>'parametrosLegalizacionOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'parametrosLegalizacionOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'parametros_legalizacion_caja',
			setId	=>'parametros_legalizacion_caja_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
  }

}

$ParametrosLegalizacion = new ParametrosLegalizacion();

?>