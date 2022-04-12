<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Crear_Bodega extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("Crear_BodegaLayoutClass.php");
    require_once("Crear_BodegaModelClass.php");
	
    $Layout   = new Crear_BodegaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new Crear_BodegaModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	
	$Layout -> setAseguradora	($Model -> getAseguradora($this -> getConex()));
	
	//LISTA MENU

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Crear_Bodega',
	  title		=>'Bodega',
	  sortname	=>'bodega_id',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'bodega_id',         index=>'bodega_id',          sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'nombre',     index=>'nombre',      sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'codigo_bodega',          index=>'codigo_bodega',	        sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'latitud',index=>'latitud',	sorttype=>'text',	width=>'100',	align=>'center'),	  	  
	  array(name=>'longitud',index=>'longitud',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'area',index=>'area',	sorttype=>'text',	width=>'100',	align=>'center'),	
	  array(name=>'volumen',index=>'volumen',	sorttype=>'text',	width=>'100',	align=>'center'),  	  	  
	  array(name=>'ubicacion',     index=>'ubicacion',	    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'usuario',index=>'usuario',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'fecha_registro',index=>'fecha_registro',	sorttype=>'text',	width=>'150',	align=>'center'),
	   array(name=>'usuario_actualiza',index=>'usuario_actualiza',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'fecha_actualiza',index=>'fecha_actualiza',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'estado',index=>'estado',	sorttype=>'text',	width=>'100',	align=>'center')	  	  	  	  	  
	);
    $Titles = array('NUMERO','NOMBRE','CODIGO','LATITUD','LONGITUD','AREA','VOLUMEN','UBICACION','USUARIO REGISTRA','FECHA REGISTRO','USUARIO ACTUALIZA','FECHA ACTUALIZA','ESTADO');
	$Layout -> SetGridCrear_Bodega($Attributes,$Titles,$Cols,$Model -> getQueryCrear_BodegaGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"wms_bodega",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("Crear_BodegaModelClass.php");
    $Model = new Crear_BodegaModel();
    $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente la Bodega');
    }	
  }

  protected function onclickUpdate(){
    require_once("Crear_BodegaModelClass.php");
	$Model = new Crear_BodegaModel();
    $Model -> Update($this -> Campos,$this -> getUsuarioId(),$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la Bodega');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("Crear_BodegaModelClass.php");
    $Model = new Crear_BodegaModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Bodega');
	}
  }


//BUSQUEDA

  protected function onclickFind(){
  	require_once("Crear_BodegaModelClass.php");
	$Model = new Crear_BodegaModel();
	
	$Data  = $Model -> selectCrearBodega($this -> getConex());
	echo json_encode($Data);
  }



  protected function setCampos(){
		//campos formulario
	$this->Campos[bodega_id]=array(
		name =>'bodega_id',
		id => 'bodega_id',
		type => 'hidden',
		datatype => array(
			type=> 'autoincrement',
			length =>'20'
		),
	transaction =>array(
		table => array('wms_bodega'),
		type  => array('primary_key')
		)	
	);


	$this->Campos[nombre] = array(
		name	=> 'nombre',
		id		=> 'nombre',
		type	=> 'text',
		Boostrap => 'si',
		datatype => array(
			type	=> 'text',
			length	=> '20'
		),
		transaction => array(
			table	=> array('wms_bodega'),
			type	=> array('column')
			)
	);

		$this->Campos[codigo_bodega] = array(
			name	=> 'codigo_bodega',
			id		=> 'codigo_bodega',
			type	=> 'text',
			Boostrap => 'si',
			datatype => array(
				type	=> 'text',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);

		$this->Campos[latitud] = array(
			name	=> 'latitud',
			id		=> 'latitud',
			type	=> 'text',
			Boostrap => 'si',
			datatype => array(
				type	=> 'text',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);

		$this->Campos[longitud] = array(
			name	=> 'longitud',
			id		=> 'longitud',
			type	=> 'text',
			Boostrap => 'si',
			datatype => array(
				type	=> 'text',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);

		$this->Campos[ubicacion] = array(
			name	=> 'ubicacion',
			id		=> 'ubicacion',
			type	=> 'text',
			Boostrap => 'si',
			suggest => array(
				name	=> 'ciudad',
				setId	=> 'ubicacion_id'
			)
		);

		$this->Campos[ubicacion_id] = array(
			name	=> 'ubicacion_id',
			id		=> 'ubicacion_id',
			type	=> 'hidden',
			value	=> '',
			required => 'yes',
			datatype => array(
				type	=> 'integer',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);

		$this->Campos[estado] = array(
			name	=> 'estado',
			id		=> 'estado',
			type	=> 'select',
			required => 'yes',
			Boostrap => 'si',
			options => array(array(value => 'A', text => 'ACTIVA', selected => 'A'), array(value => 'I', text => 'INACTIVA', selected => 'A')),
			datatype => array(type => 'alpha'),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);

		$this->Campos[alto] = array(
		name	=> 'alto',
		id		=> 'alto',
		type	=> 'text',
		required => 'yes',
		Boostrap => 'si',
		size => 5,
		datatype => array(
				type	=>'numeric',
				length	=>'3',
				presicion=>2),
		transaction => array(
			table	=> array('wms_bodega'),
			type	=> array('column')
			)
	);

	$this->Campos[largo] = array(
		name	=> 'largo',
		id		=> 'largo',
		type	=> 'text',
		required => 'yes',
		Boostrap => 'si',
		size => 5,
		datatype => array(
				type	=>'numeric',
				length	=>'3',
				presicion=>2),
		transaction => array(
			table	=> array('wms_bodega'),
			type	=> array('column')
			)
	);

	$this->Campos[ancho] = array(
		name	=> 'ancho',
		id		=> 'ancho',
		type	=> 'text',
		required => 'yes',
		Boostrap => 'si',
		size => 5,
		datatype => array(
				type	=>'numeric',
				length	=>'3',
				presicion=>2),
		transaction => array(
			table	=> array('wms_bodega'),
			type	=> array('column')
			)
	);

	$this->Campos[area] = array(
		name	=> 'area',
		id		=> 'area',
		type	=> 'text',
		required =>'yes',
		readonly => 'yes',
		Boostrap => 'si',
		size => 5,
		datatype => array(
				type	=>'numeric',
				length	=>'3',
				presicion=>3),
		transaction => array(
			table	=> array('wms_bodega'),
			type	=> array('column')
			)
	);

	$this->Campos[volumen] = array(
		name	=> 'volumen',
		id		=> 'volumen',
		type	=> 'text',
		required =>'yes',
		readonly => 'yes',
		Boostrap => 'si',
		size => 5,
		datatype => array(
				type	=>'numeric',
				length	=>'3',
				presicion=>3),
		transaction => array(
			table	=> array('wms_bodega'),
			type	=> array('column')
			)
	);

	

	

		$this->Campos[fecha_registro] = array(
			name => 'fecha_registro',
			id => 'fecha_registro',
			type => 'hidden',
			value => '',
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			),
			datatype => array(
				type => 'text',
				length => '10'
			)
		);

		$this->Campos[fecha_actualiza] = array(
			name => 'fecha_actualiza',
			id => 'fecha_actualiza',
			type => 'hidden',
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			),
			datatype => array(
				type => 'text',
				length => '10'
			)
		);

		$this->Campos[usuario_id] = array(
			name	=> 'usuario_id',
			id		=> 'usuario_id',
			type	=> 'hidden',
			datatype => array(
				type	=> 'autoincrement',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);

		$this->Campos[usuario_actualiza_id] = array(
			name	=> 'usuario_actualiza_id',
			id		=> 'usuario_actualiza_id',
			type	=> 'hidden',
			datatype => array(
				type	=> 'autoincrement',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_bodega'),
				type	=> array('column')
			)
		);	  




	$this -> Campos[poliza_empresa_id] = array(
		name	=>'poliza_empresa_id',
		id		=>'poliza_empresa_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('primary_key'))
	);
	 
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[aseguradora_id] = array(
		name	=>'aseguradora_id',
		id		=>'aseguradora_id',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_expedicion] = array(
		name	=>'fecha_expedicion',
		id		=>'fecha_expedicion',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_vencimiento] = array(
		name	=>'fecha_vencimiento',
		id		=>'fecha_vencimiento',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero] = array(
		name	=>'numero',
		id		=>'numero',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[costo_poliza] = array(
		name	=>'costo_poliza',
		id		=>'costo_poliza',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	 =>'numeric',
			length	 =>'18',
			precision=>'0'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);
	
	$this -> Campos[deducible] = array(
		name	=>'deducible',
		id		=>'deducible',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	 =>'numeric',
			length	 =>'18',
			precision=>'0'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor_maximo_despacho] = array(
		name	=>'valor_maximo_despacho',
		id		=>'valor_maximo_despacho',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	 =>'numeric',
			length	 =>'18',
			precision=>'0'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[modelo_minimo_vehiculo] = array(
		name	=>'modelo_minimo_vehiculo',
		id		=>'modelo_minimo_vehiculo',
		type	=>'text',
		required=>'yes',
		size    =>'4',
		maxlength=>'4',
    	datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[hora_inicio_permitida] = array(
		name	=>'hora_inicio_permitida',
		id		=>'hora_inicio_permitida',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'time',
			length	=>'20'),
		transaction=>array(
			table	=>array('poliza_empresa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[hora_final_permitida] = array(
		name	=>'hora_final_permitida',
		id		=>'hora_final_permitida',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'time',
			length	=>'20'),
		transaction=>array(
			table	=>array('poliza_empresa'),
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
			onsuccess=>'Crear_BodegaOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'Crear_BodegaOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'Crear_BodegaOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'Crear_BodegaOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap => 'si',
		placeholder=>'Escriba el nombre de la Bodega, ó Codigo de la Bodega',						
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_bodega',
			setId	=>'bodega_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$Crear_Bodega = new Crear_Bodega();

?>