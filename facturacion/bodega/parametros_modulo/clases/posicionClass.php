<?php

require_once("../../../framework/clases/ControlerClass.php");

final class posicion extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("posicionLayoutClass.php");
    require_once("posicionModelClass.php");
	
    $Layout   = new posicionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new posicionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU


//// GRID ////
	$Attributes = array(

	  id	    =>'wms_posicion',		
	  title		=>'Listado de posiciones',
	  sortname	=>'codigo',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'codigo',	            index=>'posicion_id',			 width=>'60',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',			     width=>'230',	align=>'center'),	  
	  array(name=>'estado',				index=>'estado',			     width=>'120',	align=>'center'),
	  array(name=>'ubicacion',	        index=>'ubicacion',			     width=>'160',	align=>'center'),
	  array(name=>'usuario_registra',	index=>'usuario_registra',	     width=>'180',	align=>'center'),	  
	  array(name=>'fecha_registro',	    index=>'fecha_registro',		 width=>'120',	align=>'center'),
	  array(name=>'usuario_actualiza',  index=>'usuario_actualiza',		 width=>'180',	align=>'center'),
	  array(name=>'fecha_actualiza',	index=>'fecha_actualiza',	     width=>'120',	align=>'center')
	
	);
	  
    $Titles = array('CODIGO',
					'NOMBRE',
					'ESTADO',																	
					'UBICACION',
					'USUARIO REGISTRA',
					'FECHA REGISTRO',
					'USUARIO ACTUALIZA',																	
					'FECHA ACTUALIZA'
	);
		
	$Layout -> SetGridposicion($Attributes,$Titles,$Cols,$Model -> getQueryposicionGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("posicionModelClass.php");
    $Model = new posicionModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la posicion');
	 }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("posicionModelClass.php");
    $Model = new posicionModel();
	
    $Model -> Update($this -> Campos,$this -> getConex(),$this -> getUsuarioId());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la posicion');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("posicionModelClass.php");
    $Model = new posicionModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la posicion');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("posicionModelClass.php");
    $Model = new posicionModel();
	$Data  = $Model -> selectposicion($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[posicion_id] = array(
		name	=>'posicion_id',
		id	    =>'posicion_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_posicion'),
			type	=>array('primary_key'))
	);

	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id	    =>'codigo',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'true',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_posicion'))
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		required=>'yes',
		size    =>'35',
		Boostrap =>'si',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_posicion'),
			type	=>array('column'))
	);	


	$this -> Campos[estado] = array(
    name=>'estado',
    id=>'estado',
    type=>'select',
	required=>'yes',
	Boostrap =>'si',
    options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
    datatype=>array(
		type=>'text',
		length=>'11'),
    transaction=>array(
		table=>array('wms_posicion'),
		type=>array('column'))
	);
	
	$this -> Campos[ubicacion_bodega] = array(
			name	=>'ubicacion_bodega',
			id		=>'ubicacion_bodega',
			type	=>'text',
			size    =>'35',
			Boostrap =>'si',
			suggest=>array(
				name	=>'ubicacion_bodega',
				setId	=>'ubicacion_bodega_id')
		);
		
		$this -> Campos[ubicacion_bodega_id] = array(
			name	=>'ubicacion_bodega_id',
			id		=>'ubicacion_bodega_id',
			type	=>'hidden',
			value	=>'',
			required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_posicion'),
				type	=>array('column'))
		);

		$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id   	=>'usuario_id',
		value   => $this -> getUsuarioId(),
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_posicion'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_id_static] = array(
		name	=>'usuario_id_static',
		id   	=>'usuario_id_static',
		value   => $this -> getUsuarioId(),
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric')
	);	

	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id	    =>'fecha_registro',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_posicion'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_actualiza_id] = array(
		name	=>'usuario_actualiza_id',
		id	    =>'usuario_actualiza_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_posicion'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	    =>'fecha_actualiza',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_posicion'),
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
			onsuccess=>'posicionOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'posicionOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'posicionOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'posicionOnReset(this.form)'
	);
	
	//busqueda
    	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder=>'Ingrese el código o nombre de la Posición',
		//tabindex=>'1',
		suggest=>array(
			name	=>'wms_posicion',
			setId	=>'posicion_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$wms_posicion = new posicion();

?>