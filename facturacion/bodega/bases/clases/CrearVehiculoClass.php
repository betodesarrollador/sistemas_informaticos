<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CrearVehiculo extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){

      
      $this -> noCache();
      
      require_once("CrearVehiculoLayoutClass.php");
      require_once("CrearVehiculoModelClass.php");
      
      $Layout   = new CrearVehiculoLayout($this -> getTitleTab(),$this -> getTitleForm());
      $Model    = new CrearVehiculoModel();
      
      $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
      
      $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
      $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
      $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
      $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
      
      $Layout -> setCampos($this -> Campos);
      
      
      //LISTA MENU
      $Layout -> SetTipoVehiculo	($Model -> getTipoVehiculo ($this -> getConex())); 
      
      
      //// GRID ////
      $Attributes = array(
	  id		=>'wms_vehiculo_id',
	  title		=>'vehiculo',
	  sortname	=>'wms_vehiculo_id',
	  width		=>'1300',
	  height	=>'250'
	);
	$Cols = array(
        array(name=>'wms_vehiculo_id',            index=>'wms_vehiculo_id',             sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'placa',                      index=>'placa',                       sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'marca_id',                   index=>'marca_id',	                  sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'estado',                     index=>'estado',	                  sorttype=>'text',	width=>'100',	align=>'center'),	  
      array(name=>'nombre_conductor',           index=>'nombre_conductor',	          sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'cedula_conductor',           index=>'cedula_conductor',	          sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'telefono_conductor',         index=>'telefono_conductor',	      sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'telefono_ayudante',          index=>'telefono_ayudante',	          sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tipo_vehiculo_id',           index=>'tipo_vehiculo_id',	          sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'soat',                       index=>'soat',	                      sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tecnomecanica',              index=>'tecnomecanica',	              sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'usuario',                    index=>'usuario',	                  sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'fecha_registro',             index=>'fecha_registro',	          sorttype=>'text',	width=>'160',	align=>'center'),
	  array(name=>'usuario_actualiza',          index=>'usuario_actualiza',	          sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'fecha_actualiza',            index=>'fecha_actualiza',	          sorttype=>'text',	width=>'160',	align=>'center')	  	  	  	  	  
	);
    $Titles = array('CODIGO','PLACA','MARCA','ESTADO','NOMBRE CONDUCTOR','CEDULA CONDUCTOR','TELEFONO CONDUCTOR','TELEFONO AYUDANTE','TIPO VEHICULO','SOAT','TECNOMECANICA','USUARIO REGISTRA','FECHA REGISTRO','USUARIO ACTUALIZA','FECHA ACTUALIZA');
	$Layout -> SetGridCrearVehiculo($Attributes,$Titles,$Cols,$Model -> getQueryCrearVehiculoGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"wms_vehiculo",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("CrearVehiculoModelClass.php");
    $Model = new CrearVehiculoModel();
    $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente el vehiculo');
    }	
  }

  protected function onclickUpdate(){
    require_once("CrearVehiculoModelClass.php");
	$Model = new CrearVehiculoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el vehiculo');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("CrearVehiculoModelClass.php");
    $Model = new CrearVehiculoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el CrearVehiculo');
	}
  }


//BUSQUEDA

  protected function onclickFind(){
  	require_once("CrearVehiculoModelClass.php");
	$Model = new CrearVehiculoModel();
	
	$Data  = $Model -> selectVehiculo($this -> getConex());
	echo json_encode($Data);
  }



  protected function setCampos(){
		//campos formulario
	$this->Campos[wms_vehiculo_id]=array(
		name =>'wms_vehiculo_id',
		id => 'wms_vehiculo_id',
		type => 'hidden',
		datatype => array(
			type=> 'autoincrement',
			length =>'20'
		),
	transaction =>array(
		table => array('wms_vehiculo'),
		type  => array('primary_key')
		)	
	);


	$this -> Campos[placa] = array(
		name	=>'placa',
		id	=>'placa',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
		size    =>'15',
        text_uppercase =>'si',
        transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
    );
    	
        $this -> Campos[marca] = array(
			name	=>'marca',
			id		=>'marca',
			type	=>'text',
			value	=>'',
			Boostrap =>'si',
			suggest=>array(
				name	=>'marca_vehiculo',
				setId	=>'marca_id')
        );
        
        $this -> Campos[marca_id] = array(
			name	=>'marca_id',
			id	=>'marca_id',
			type	=>'hidden',
			//required=>'yes',
			value	=>'',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
        );
        
       $this -> Campos[tipo_vehiculo_id] = array(
			name	=>'tipo_vehiculo_id',
			id		=>'tipo_vehiculo_id',
			type	=>'select',
			Boostrap =>'si',
			//required=>'yes',
			options	=>array(),
			selected=>'0',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
        );
        
        $this -> Campos[color] = array(
			name	=>'color',
			id		=>'color',
			type	=>'text',
			required =>'yes',
			Boostrap => 'si',
			size    =>'15',
			suggest=>array(
				name	=>'color_vehiculo',
				setId	=>'color_id')
        );
        
    $this -> Campos[color_id] = array(
			name	=>'color_id',
			id		=>'color_id',
			type	=>'hidden',
			value	=>'',
			//required=>'yes',
			datatype=>array(
				type	=>'integer',
                length	=>'20'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
	);

	$this -> Campos[nombre_conductor] = array(
		name	=>'nombre_conductor',
		id	=>'nombre_conductor',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'text',
            length	=>'30'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
    );
    
   $this -> Campos[cedula_conductor] = array(
		name	=>'cedula_conductor',
		id	=>'cedula_conductor',
		type	=>'text',
		//required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
            length	=>'20'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
	);	

	$this -> Campos[telefono_conductor] = array(
		name	=>'telefono_conductor',
		id	=>'telefono_conductor',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
            length	=>'11'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
	);	
$this -> Campos[telefono_ayudante] = array(
		name	=>'telefono_ayudante',
		id	=>'telefono_ayudante',
		type	=>'text',
		//required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
            length	=>'11'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
	);	

	$this -> Campos[soat] = array(
		name	=>'soat',
		id	=>'soat',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
            length	=>'20'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
    );	
    
    $this -> Campos[tecnomecanica] = array(
		name	=>'tecnomecanica',
		id	=>'tecnomecanica',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
            length	=>'20'),
            transaction=>array(
				table	=>array('wms_vehiculo'),
				type	=>array('column'))
    );	
    
    $this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
        required =>'yes',
        Boostrap => 'si',
		options	 =>array(array(value => 'I',text => 'INACTIVO'),array(value => 'A', text => 'ACTIVO')),
        selected => 'A',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('wms_vehiculo'),
			type	=>array('column'))
    );	
    
    $this -> Campos[imagen] = array(
		name	=>'imagen',
		id		=>'imagen',
		type	=>'file',
		value	=>'',
		path	=>'sistemas_informaticos/imagenes/bodega/vehiculos/',
		size	=>'70',
        Boostrap=>'si',	
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('wms_vehiculo'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'nombre',
			text	=>'_foto'),
		settings => array(
		  width  => '400',
		  height => '420'
		)
	);

		$this-> Campos[fecha_registro] = array(
			name => 'fecha_registro',
			id => 'fecha_registro',
			type => 'hidden',
			value => '',
			transaction => array(
				table	=> array('wms_vehiculo'),
				type	=> array('column')
			),
			datatype => array(
				type => 'text',
				length => '10'
			)
		);

		$this-> Campos[fecha_actualiza] = array(
			name => 'fecha_actualiza',
			id => 'fecha_actualiza',
			type => 'hidden',
			transaction => array(
				table	=> array('wms_vehiculo'),
				type	=> array('column')
			),
			datatype => array(
				type => 'text',
				length => '10'
			)
		);

		$this-> Campos[usuario_id] = array(
			name	=> 'usuario_id',
			id		=> 'usuario_id',
			type	=> 'hidden',
			datatype => array(
				type	=> 'autoincrement',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_vehiculo'),
				type	=> array('column')
			)
		);

		$this-> Campos[usuario_actualiza_id] = array(
			name	=> 'usuario_actualiza_id',
			id		=> 'usuario_actualiza_id',
			type	=> 'hidden',
			datatype => array(
				type	=> 'autoincrement',
				length	=> '20'
			),
			transaction => array(
				table	=> array('wms_vehiculo'),
				type	=> array('column')
			)
		);
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'CrearVehiculoOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CrearVehiculoOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CrearVehiculoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CrearVehiculoOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'60',
		Boostrap => 'si',
		placeholder=>'Por favor digite la placa',						
		//tabindex=>'1',
		suggest=>array(
			name	=>'wms_vehiculo',
			setId	=>'wms_vehiculo_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$CrearVehiculo = new CrearVehiculo();

?>