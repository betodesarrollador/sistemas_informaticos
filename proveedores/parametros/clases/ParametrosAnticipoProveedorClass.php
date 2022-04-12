<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ParametrosAnticipoProveedor extends Controler{
	
  public function __construct(){
	parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("ParametrosAnticipoProveedorLayoutClass.php");
	require_once("ParametrosAnticipoProveedorModelClass.php");
	
	$Layout   = new ParametrosAnticipoProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosAnticipoProveedorModel();

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
	  id		=>'parametros_anticipo_proveedor',
	  title		=>'Listado de Parametros Anticipo',
	  sortname	=>'nombre',
	  width		=>'auto',
	  height	=>'250'
	);
	

	$Cols = array(

	  array(name=>'empresa',	            index=>'empresa',               sorttype=>'text',	width=>'270',	align=>'center'),
	  array(name=>'oficina',                index=>'oficina',               sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'tipo_documento',	        index=>'tipo_documento',	    sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'puc',	                index=>'puc',	                sorttype=>'text',	width=>'150',	align=>'center'),	  
	  array(name=>'nombre',		            index=>'nombre',		        sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'naturaleza',			    index=>'naturaleza',		    sorttype=>'text',	width=>'150',	align=>'center')
	
	);
	  
    $Titles = array('EMPRESA',
					'OFICINA',
					'DOCUMENTO CONTABLE',
					'CODIGO CONTABLE',
					'NOMBRE',
					'NATUALEZA'
	);
	
	$Layout -> SetGridParametrosAnticipoProveedor($Attributes,$Titles,$Cols,$Model -> getQueryParametrosAnticipoProveedorGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"ParametrosAnticipoProveedor",$this ->Campos);	 
	 $this -> getArrayJSON($Data  -> GetData());
  }
  
  
  protected function onclickSave(){
    
  	require_once("ParametrosAnticipoProveedorModelClass.php");
    $Model = new ParametrosAnticipoProveedorModel();
    
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo ParametrosAnticipoProveedor');
	  }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("ParametrosAnticipoProveedorModelClass.php");
    $Model = new ParametrosAnticipoProveedorModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Impuesto');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("ParametrosAnticipoProveedorModelClass.php");
    $Model = new ParametrosAnticipoProveedorModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Impuesto');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
	  
  	require_once("ParametrosAnticipoProveedorModelClass.php");
	
    $Model                  = new ParametrosAnticipoProveedorModel();
	$parametros_anticipo_proveedor_id = $_REQUEST['parametros_anticipo_proveedor_id'];
			
	$Data  = $Model -> selectParametrosAnticipoProveedor($parametros_anticipo_proveedor_id,$this -> getConex());
	
	$this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
  	  
    require_once("../../../framework/clases/ListaDependiente.php");
	
	$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		
	$list -> getList();
	  
  }  

  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[parametros_anticipo_proveedor_id] = array(
		name	=>'parametros_anticipo_proveedor_id',
		id		=>'parametros_anticipo_proveedor_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_anticipo_proveedor'),
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
			table	=>array('parametros_anticipo_proveedor'),
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
			table	=>array('parametros_anticipo_proveedor'),
			type	=>array('column'))
	);	
	
		
	$this -> Campos[tipo_documento_id] = array(
		name	 =>'tipo_documento_id',
		id		 =>'tipo_documento_id',
		type	 =>'select',
		required =>'yes',		
		options  => array(),
		transaction=>array(
			table	=>array('parametros_anticipo_proveedor'),
			type	=>array('column'))
	);		
		
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			form    =>'0',
			setId	=>'puc_id_hidden',
			onclick =>'setNombreCuenta'
			)
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('parametros_anticipo_proveedor'),
			type	=>array('column'))
	);	

	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('parametros_anticipo_proveedor'),
			type	=>array('column'))
			
	);	
	
	$this -> Campos[naturaleza] = array(
		name	 =>'naturaleza',
		id		 =>'naturaleza',
		type	 =>'select',		
		required =>'yes',
		datatype=>array(
			type	=>'text'),	
		options  => array(array(value => 'D', text => 'DEBITO'),array(value => 'C', text => 'CREDITO')),
		transaction=>array(
			table	=>array('parametros_anticipo_proveedor'),
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
			onsuccess=>'parametrosAnticipoOnSaveOnUpdateonDelete')		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'parametrosAnticipoOnSaveOnUpdateonDelete')		
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'parametrosAnticipoOnSaveOnUpdateonDelete')
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
		size	=>'85',
		suggest=>array(
			name	=>'parametros_anticipo_proveedor',
			setId	=>'parametros_anticipo_proveedor_id',
			onclick	=>'LlenarFormparametrosAnticipo')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$ParametrosAnticipoProveedor = new ParametrosAnticipoProveedor();

?>