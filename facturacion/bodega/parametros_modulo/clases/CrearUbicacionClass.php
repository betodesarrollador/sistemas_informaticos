<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CrearUbicacion extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("CrearUbicacionLayoutClass.php");
    require_once("CrearUbicacionModelClass.php");
	
    $Layout   = new CrearUbicacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CrearUbicacionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

	//LISTA MENU
	$Layout -> SetEstadoProductos($Model -> GetEstadoProductos($this -> getConex()));

    //$Layout -> SetTipoUbicacion($Model -> GetTipoUbicacion($this -> getConex()));


//// GRID ////
	$Attributes = array(

	  id	=>'ubicacion_bodega',		
	  title		=>'Listado de Ubicaciones',
	  sortname	=>'ubicacion_bodega_id',
	  width		=>'1050',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'ubicacion_bodega_id',	index=>'ubicacion_bodega_id',			width=>'50',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',			        width=>'100',	align=>'center'),
	  array(name=>'bodega',			index=>'bodega',					width=>'150',	align=>'center'),	  
	  array(name=>'area',				index=>'area',					width=>'70',	align=>'center'),
	  array(name=>'codigo',				index=>'codigo',					width=>'60',	align=>'center'),
	  array(name=>'usuario',				index=>'usuario',					width=>'120',	align=>'center'),
	  array(name=>'fecha_registro',				index=>'fecha_registro',					width=>'120',	align=>'center'),
	  array(name=>'usuario_actualiza_id',				index=>'usuario_actualiza_id',					width=>'150',	align=>'center'),
	  array(name=>'fecha_actualiza',				index=>'fecha_actualiza',					width=>'120',	align=>'center'),
	  array(name=>'estado',				index=>'estado',					width=>'60',	align=>'center')
	
	);
	  
    $Titles = array('No.',
					'NOMBRE',
					'BODEGA',																	
					'AREA',																	
					'CODIGO',																	
					'USUARIO',																	
					'FECHA REGISTRO',																																		
					'USUARIO ACTUALIZA',																	
					'FECHA ACTUALIZA',																	
					'ESTADO'
	);
		
	$Layout -> SetGridCrearUbicacion($Attributes,$Titles,$Cols,$Model -> getQueryCrearUbicacionGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("CrearUbicacionModelClass.php");
	$Model = new CrearUbicacionModel();
	
	$estado_producto = $_REQUEST['estado_producto'];
    	
    $Model -> Save($estado_producto,$this -> getUsuarioId(),$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la ubicacion.');
	 }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("CrearUbicacionModelClass.php");
    $Model = new CrearUbicacionModel();
	$usuario_actualiza = $this -> getUsuarioId();

	$ubicacion_bodega_id=$_REQUEST['ubicacion_bodega_id'];
	$estado_producto = $_REQUEST['estado_producto'];
    $Model -> Update($estado_producto,$ubicacion_bodega_id,$usuario_actualiza,$this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la ubicacion.');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("CrearUbicacionModelClass.php");
    $Model = new CrearUbicacionModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la ubicacion.');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("CrearUbicacionModelClass.php");
    $Model = new CrearUbicacionModel();
	$Data  = $Model -> selectCrearUbicacion($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[ubicacion_bodega_id] = array(
		name	=>'ubicacion_bodega_id',
		id	    =>'ubicacion_bodega_id',
		type	=>'text',
		Boostrap=>'si',
		disabled=>'true',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);	


	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id	=>'codigo',
		type	=>'text',
		required=>'yes',
		Boostrap=>'si',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);	

	$this -> Campos[area] = array(
		name	=>'area',
		id	=>'area',
		type	=>'text',
		required=>'yes',
		Boostrap=>'si',
		size    =>'35',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);
		

	$this -> Campos[bodega] = array(
			name	=>'bodega',
			id		=>'bodega',
			type	=>'text',
			Boostrap=>'si',
			placeholder=>'Por favor digitar una bodega.',
			size 	=>'30',
			suggest=>array(
				name	=>'busca_bodega',
				setId	=>'bodega_id')
		);
		
		$this -> Campos[bodega_id] = array(
			name	=>'bodega_id',
			id		=>'bodega_id',
			type	=>'hidden',
			value	=>'',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_ubicacion_bodega'),
				type	=>array('column'))
		);

		$this -> Campos[estado_producto] = array(
        name=>'estado_producto',
        id=>'estado_producto',
		type=>'select',
		Boostrap=>'si',
        multiple=>'yes',
        required=>'yes', 
        datatype=>array(
            type=>'text',
            length=>'1'),
	);
	
	$this -> Campos[all_estado] = array(
        name    =>'all_estado',
        id      =>'all_estado',
		type    =>'checkbox',
		Boostrap =>'si',
        onclick =>'all_estados();',
        value   =>'NO'
    ); 

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	=>'usuario_id',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		//size    =>'35',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_actualiza_id] = array(
		name	=>'usuario_actualiza_id',
		id	=>'usuario_actualiza_id',
		type	=>'hidden',
		//size    =>'35',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id	=>'fecha_registro',
		type	=>'hidden',
		//size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	=>'fecha_actualiza',
		type	=>'hidden',
		//size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_ubicacion_bodega'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[usuario_static] = array(
		name	=>'usuario_static',
		id	=>'usuario_static',
		type	=>'hidden',
		value =>$this -> getUsuarioId(),
		//size    =>'35',
		datatype=>array(
			type	=>'integer')
	);	

		
	$this -> Campos[estado] = array(
    name=>'estado',
    id=>'estado',
    type=>'select',
	required=>'yes',
	Boostrap=>'si',
    options	 =>array(array(value => 'A',text => 'ACTIVO'),array(value => 'I', text => 'INACTIVO')),
    datatype=>array(
		type=>'text',
		length=>'11'),
    transaction=>array(
		table=>array('wms_ubicacion_bodega'),
		type=>array('column'))
	);
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'CrearUbicacionOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CrearUbicacionOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CrearUbicacionOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CrearUbicacionOnReset(this.form)'
	);
	
	//busqueda
    	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap=>'si',
		placeholder=>'Debe digitar el nombre o codigo de la ubicacion.',
		//tabindex=>'1',
		suggest=>array(
			name	=>'ubicacion_bodega',
			setId	=>'ubicacion_bodega_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$wms_ubicacion_bodega = new CrearUbicacion();

?>