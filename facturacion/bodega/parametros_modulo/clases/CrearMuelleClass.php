<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CrearMuelle extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("CrearMuelleLayoutClass.php");
    require_once("CrearMuelleModelClass.php");
	
    $Layout   = new CrearMuelleLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CrearMuelleModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU

    //$Layout -> SetTipoUbicacion($Model -> GetTipoUbicacion($this -> getConex()));


//// GRID ////
	$Attributes = array(

	  id	=>'muelle_id',		
	  title		=>'Listado de Muelles',
	  sortname	=>'muelle_id',
	  width		=>'1100',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'muelle_id',	index=>'muelle_id',			width=>'50',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',			        width=>'100',	align=>'center'),
	  array(name=>'bodega',			index=>'bodega',					width=>'150',	align=>'center'),
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
					'CODIGO',																	
					'USUARIO',																	
					'FECHA REGISTRO',																																		
					'USUARIO ACTUALIZA',																	
					'FECHA ACTUALIZA',																	
					'ESTADO'
	);
		
	$Layout -> SetGridCrearMuelle($Attributes,$Titles,$Cols,$Model -> getQueryCrearMuelleGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("CrearMuelleModelClass.php");
    $Model = new CrearMuelleModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la ubicacion.');
	 }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("CrearMuelleModelClass.php");
    $Model = new CrearMuelleModel();
	$usuario_actualiza = $this -> getUsuarioId();
    $Model -> Update($usuario_actualiza,$this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la ubicacion.');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("CrearMuelleModelClass.php");
    $Model = new CrearMuelleModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la ubicacion.');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("CrearMuelleModelClass.php");
    $Model = new CrearMuelleModel();
	$Data  = $Model -> selectCrearMuelle($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[muelle_id] = array(
		name	=>'muelle_id',
		id	    =>'muelle_id',
		type	=>'text',
		disabled=>'true',
		size=>'8',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_muelle'),
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
			table	=>array('wms_muelle'),
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
			table	=>array('wms_muelle'),
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
				table	=>array('wms_muelle'),
				type	=>array('column'))
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
			table	=>array('wms_muelle'),
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
			table	=>array('wms_muelle'),
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
			table	=>array('wms_muelle'),
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
			table	=>array('wms_muelle'),
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
		table=>array('wms_muelle'),
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
			onsuccess=>'CrearMuelleOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CrearMuelleOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CrearMuelleOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CrearMuelleOnReset(this.form)'
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
			name	=>'wms_muelle_bodega',
			setId	=>'muelle_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$wms_muelle = new CrearMuelle();

?>