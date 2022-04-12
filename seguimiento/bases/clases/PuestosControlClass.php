<?php

require_once("../../../framework/clases/ControlerClass.php");

final class PuestosControl extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("PuestosControlLayoutClass.php");
	require_once("PuestosControlModelClass.php");
	
	$Layout   = new PuestosControlLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PuestosControlModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
   	$Layout -> SetEstadoPuesto($Model -> GetEstadoPuesto($this -> getConex()));
	$Layout -> SetTipoPunto($Model -> GetTipoPunto($this -> getConex()));
	//$Layout -> SetClasificacion($Model -> GetClasificacion($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'PuestosControl',
	  title		=>'Puntos de Referencia',
	  sortname	=>'punto_referencia_id',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'punto_referencia_id',	index=>'punto_referencia_id',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'nombre',					index=>'nombre',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'ubicacion',				index=>'ubicacion',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'tipo',					index=>'tipo',					sorttype=>'text',	width=>'100',	align=>'center'),
	 // array(name=>'clasificacion',			index=>'clasificacion',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'tipopunto',				index=>'tipopunto',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'contacto',				index=>'contacto',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'direccion',				index=>'direccion',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'movil',					index=>'movil',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'avantel',				index=>'avantel',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'correo',					index=>'correo',				sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'x',						index=>'x',						sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'y',						index=>'y',						sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('ID',
					'NOMBRE PUNTO',
					'UBICACION',
					'TIPO',
					//'CLASIFICACION',
					'TIPO PUNTO',
					'CONTACTO',
					'DIRECCION',
					'MOVIL',
					'AVANTEL',
					'CORREO',
					'LATITUD',
					'LONGITUD',
					'ESTADO'
	);
	
	$Layout -> SetGridPuestosControl($Attributes,$Titles,$Cols,$Model -> getQueryPuestosControlGrid());
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"punto_referencia",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("PuestosControlModelClass.php");
    $Model = new PuestosControlModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Guardado correctamente');
    }	
  }

  protected function onclickUpdate(){
    require_once("PuestosControlModelClass.php");
	$Model = new PuestosControlModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Actualizado correctamente');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("PuestosControlModelClass.php");
    $Model = new PuestosControlModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Eliminado correctamente');
	}
  }

  protected function ComprobarNombre(){

    require_once("PuestosControlModelClass.php");
    $Model = new PuestosControlModel();    
    $nombre = $_REQUEST['nombre'];
    $data = $Model -> getComprobarNombre($nombre,$this -> getConex());
    $this -> getArrayJSON($data);

  }

  protected function ComprobarCoordenadas(){

    require_once("PuestosControlModelClass.php");
    $Model = new PuestosControlModel();    
    $x = $_REQUEST['x'];
    $y = $_REQUEST['y'];	
    $data = $Model -> getComprobarCoordenadas($x,$y,$this -> getConex());
    $this -> getArrayJSON($data);

  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("PuestosControlModelClass.php");
    $Model    = new PuestosControlModel();
    $PuestoId = $_REQUEST['punto_referencia_id'];
    $Data     =  $Model -> selectPuestoControl($PuestoId,$this -> getConex());
    $this -> getArrayJSON($Data);
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[punto_referencia_id] = array(
		name	=>'punto_referencia_id',
		id		=>'punto_referencia_id',
		type	=>'text',
		required=>'no',
		readonly=>'yes',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		size	=>'30',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'ubicacion_id')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
		value	=>'',
		size	=>'30',
    	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);

	$this -> Campos[observacion] = array(
		name	=>'observacion',
		id		=>'observacion',
		type	=>'text',
		value	=>'',
		size	=>'30',
    	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_punto_referencia_id] = array(
		name	=>'tipo_punto_referencia_id',
		id		=>'tipo_punto_referencia_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);


/*
$this -> Campos[clasificacion] = array(
		name	=>'clasificacion',
		id		=>'clasificacion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);*/

	$this -> Campos[contacto] = array(
		name	=>'contacto',
		id		=>'contacto',
		type	=>'text',
		value	=>'',
		size	=>'30',
    	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	$this -> Campos[direccion] = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	$this -> Campos[avantel] = array(
		name	=>'avantel',
		id		=>'avantel',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	$this -> Campos[movil] = array(
		name	=>'movil',
		id		=>'movil',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'35'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[correo] = array(
		name	=>'correo',
		id		=>'correo',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'mail',
			length	=>'250'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);

	$this -> Campos[x] = array(
		name	=>'x',
		id		=>'x',
		type	=>'text',
		//required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'50'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	$this -> Campos[y] = array(
		name	=>'y',
		id		=>'y',
		type	=>'text',
		//required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'50'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[imprimir] = array(
		name	=>'imprimir',
		id		=>'imprimir',
		type	=>'select',
		options	=>array(array(value => 0, text => 'NO'),array(value => 1, text => 'SI')),
//		selected=>'0',
		required=>'yes',
		selected=>'0',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);	
	
/*	$this -> Campos[mapear] = array(
		name	=>'mapear',
		id		=>'mapear',
		type	=>'select',
		options	=>array(array(value => 0, text => 'NO'),array(value => 1, text => 'SI')),
//		selected=>'0',
		required=>'yes',
		selected=>'1',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);		*/

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=>array(),
		selected=>'1',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);
	
	

/*	$this -> Campos[tipo_punto] = array(
		name	=>'tipo_punto',
		id		=>'tipo_punto',
		type	=>'select',
		options	=>null,
//		selected=>'0',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('punto_referencia'),
			type	=>array('column'))
	);

	
	*/
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
//		disabled=>'disabled'
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'PuestosControlOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'PuestosControlOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'PuestosControlOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'busqueda_puesto_control',
			setId	=>'punto_referencia_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$PuestosControl = new PuestosControl();

?>