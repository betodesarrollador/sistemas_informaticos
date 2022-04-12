<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Enturnamiento extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("EnturnamientoLayoutClass.php");
    require_once("EnturnamientoModelClass.php");
	
    $Layout   = new EnturnamientoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EnturnamientoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	$Layout -> setAnular    ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU
    $Layout -> SetTipoVehiculo	($Model -> getTipoVehiculo ($this -> getConex()));

//// GRID ////
	$Attributes = array(

	  id	    =>'wms_enturnamiento',		
	  title		=>'Listado de Enturnamientos',
	  sortname	=>'enturnamiento_id',
	  width		=>'850',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'enturnamiento_id',   index=>'enturnamiento_id',		 width=>'60',	align=>'center'),
	  array(name=>'fecha',				index=>'fecha',			         width=>'100',	align=>'center'),	  
	  array(name=>'vehiculo',		    index=>'vehiculo',			     width=>'100',	align=>'center'),
	  array(name=>'estado',	            index=>'estado',			     width=>'100',	align=>'center'),
	  array(name=>'muelle',	            index=>'muelle',	             width=>'150',	align=>'center'),	  
	  array(name=>'fecha_salida_turno',	index=>'fecha_salida_turno',     width=>'100',	align=>'center'),
	  array(name=>'fecha_registro',     index=>'fecha_registro',		 width=>'100',	align=>'center'),
	  array(name=>'fecha_actualiza',	index=>'fecha_actualiza',	     width=>'100',	align=>'center')
	
	);
	  
    $Titles = array('CODIGO',
					'FECHA',
					'VEHICULO',																	
					'ESTADO',
					'MUELLE',
					'FECHA SALIDA TURNO',
					'FECHA REGISTRO',																	
					'FECHA ACTUALIZA'
	);
		
	$Layout -> SetGridEnturnamiento($Attributes,$Titles,$Cols,$Model -> getQueryEnturnamientoGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("EnturnamientoModelClass.php");
	$Model = new EnturnamientoModel();
	
	$wms_vehiculo_id = $_REQUEST['wms_vehiculo_id'];
	$placa = $_REQUEST['placa'];
	$marca_id = $_REQUEST['marca_id'];
	$tipo_vehiculo_id = $_REQUEST['tipo_vehiculo_id'];
	$color_id = $_REQUEST['color_id'];
	$soat = $_REQUEST['soat'];
	$tecnomecanica = $_REQUEST['tecnomecanica'];
	$nombre_conductor = $_REQUEST['nombre_conductor'];
	$cedula_conductor = $_REQUEST['cedula_conductor'];
	$telefono_conductor = $_REQUEST['telefono_conductor'];
	$telefono_ayudante = $_REQUEST['telefono_ayudante'];

    $return = $Model -> Save($placa,$this -> getUsuarioId(),$wms_vehiculo_id,$this -> Campos,$this -> getConex());

    if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return); 
	}
	
  }


  protected function onclickUpdate(){
	  
  	require_once("EnturnamientoModelClass.php");
	$Model = new EnturnamientoModel();
	
	$wms_vehiculo_id = $_REQUEST['wms_vehiculo_id'];
	$placa = $_REQUEST['placa'];
	$marca_id = $_REQUEST['marca_id'];
	$tipo_vehiculo_id = $_REQUEST['tipo_vehiculo_id'];
	$color_id = $_REQUEST['color_id'];
	$soat = $_REQUEST['soat'];
	$tecnomecanica = $_REQUEST['tecnomecanica'];
	$nombre_conductor = $_REQUEST['nombre_conductor'];
	$cedula_conductor = $_REQUEST['cedula_conductor'];
	$telefono_conductor = $_REQUEST['telefono_conductor'];
	$telefono_ayudante = $_REQUEST['telefono_ayudante'];
	
    $return = $Model -> Update($placa,$this -> getUsuarioId(),$wms_vehiculo_id,$this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return); 
	}
	  
  }

  
  
  protected function onclickDelete(){

  	require_once("EnturnamientoModelClass.php");
    $Model = new EnturnamientoModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Enturnamiento');
	  }
  }

  protected function onclickAnular(){
	  
  	require_once("EnturnamientoModelClass.php");
	$Model = new EnturnamientoModel();

    $return = $Model -> Cancellation($this -> getUsuarioId(),$this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	    exit("true");
	}
	  
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("EnturnamientoModelClass.php");
    $Model = new EnturnamientoModel();
	$Data  = $Model -> selectEnturnamiento($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setDataVehiculo(){

    require_once("EnturnamientoModelClass.php");
    $Model = new EnturnamientoModel();

    $wms_vehiculo_id = $_REQUEST['wms_vehiculo_id'];
    $data     = $Model -> selectVehiculo($wms_vehiculo_id,$this -> getConex());
    
    print json_encode($data);

}

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[enturnamiento_id] = array(
		name	=>'enturnamiento_id',
		id	    =>'enturnamiento_id',
		type	=>'text',
		readonly =>'yes',
		Boostrap => 'si',
		size =>'15',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('primary_key'))
	);

	/* $this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size =>'20',
    	datatype=>array(
			type	=>'date',
			length  =>'20'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	); */

	$this -> Campos[fecha] = array(
			name	=>'fecha',
			id		=>'fecha',
			type	=>'text',
			size 	=>'auto',
			required=>'yes',
			value 	=>date('Y-m-d H:i:s'),
			Boostrap=>'si',
			datatype=>array(
			type	=>'date',
			length  =>'20'),
			transaction=>array(
				table	=>array('wms_enturnamiento'),
				type	=>array('column'))
		);
	
	$this -> Campos[wms_vehiculo_id] = array(
		name	=>'wms_vehiculo_id',
		id	=>'wms_vehiculo_id',
		type	=>'hidden',
		//required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('wms_vehiculo'),
			type	=>array('column'))
	);	

	$this -> Campos[wms_vehiculo_id] = array(
		name	=>'wms_vehiculo_id',
		id	=>'wms_vehiculo_id',
		type	=>'hidden',
		//required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);	

	$this -> Campos[placa] = array(
		name	=>'placa',
		id	=>'placa',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
		size    =>'15',
		text_uppercase =>'si',
		suggest=>array(
				name	=>'wms_vehiculo',
				setId	=>'wms_vehiculo_id',
			    onclick => 'setDataVehiculo')
	);	
	
	$this -> Campos[muelle_id] = array(
			name	=>'muelle_id',
			id		=>'muelle_id',
			type	=>'hidden',
			value	=>'',
			//required=>'yes',
			datatype=>array(
				type	=>'integer',
				length	=>'20'),
			transaction=>array(
				table	=>array('wms_enturnamiento'),
				type	=>array('column'))
		);

	$this -> Campos[muelle] = array(
			name	=>'muelle',
			id		=>'muelle',
			type	=>'text',
			Boostrap => 'si',
			size    =>'35',
			suggest=>array(
				name	=>'wms_muelle_bodega',
				setId	=>'muelle_id')
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
				table=>array('wms_enturnamiento'),
				type=>array('column'))
	);

	$this -> Campos[fecha_anula_turno] = array(
		name	=>'fecha_anula_turno',
		id		=>'fecha_anula_turno',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		size =>'20',
    	datatype=>array(
			type	=>'date',
			length  =>'20'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
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
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id	    =>'fecha_registro',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_actualiza_id] = array(
			name	=>'usuario_actualiza_id',
			id	    =>'usuario_actualiza_id',
			type	=>'hidden',
			datatype=>array(
				type	=>'numeric'),
			transaction=>array(
				table	=>array('wms_enturnamiento'),
				type	=>array('column'))
		);

	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	    =>'fecha_actualiza',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_enturnamiento'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_anula_id] = array(
		name	=>'usuario_anula_id',
		id   	=>'usuario_anula_id',
		value   => $this -> getUsuarioId(),
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric')
	);	

	$this -> Campos[observacion_anulacion] = array(
		name	=>'observacion_anulacion',
		id		=>'observacion_anulacion',
		type	=>'textarea',
		//Boostrap =>'si',
		value	=>'',
		//required=>'yes',
    	datatype=>array(
			type	=>'text')
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
				length	=>'20')
	);

	$this -> Campos[nombre_conductor] = array(
		name	=>'nombre_conductor',
		id	=>'nombre_conductor',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'text',
			length	=>'30')
	);	

	$this -> Campos[cedula_conductor] = array(
		name	=>'cedula_conductor',
		id	=>'cedula_conductor',
		type	=>'text',
		//required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);	

	$this -> Campos[telefono_conductor] = array(
		name	=>'telefono_conductor',
		id	=>'telefono_conductor',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
			length	=>'11')
	);	

	$this -> Campos[telefono_ayudante] = array(
		name	=>'telefono_ayudante',
		id	=>'telefono_ayudante',
		type	=>'text',
		//required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
			length	=>'11')
	);	

	$this -> Campos[soat] = array(
		name	=>'soat',
		id	=>'soat',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);	

	$this -> Campos[tecnomecanica] = array(
		name	=>'tecnomecanica',
		id	=>'tecnomecanica',
		type	=>'text',
		required=>'yes',
		Boostrap => 'si',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);	

	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
	
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
	);

	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick => 'onclickAnular(this.form)'
	);

	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'EnturnamientoOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'EnturnamientoOnReset(this.form)'
	);
	
	//busqueda
    	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder=>'Debe digitar la placa del vehiculo Enturnado.',
		//tabindex=>'1',
		suggest=>array(
			name	=>'wms_enturnamiento',
			setId	=>'enturnamiento_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$wms_enturnamiento = new Enturnamiento();

?>