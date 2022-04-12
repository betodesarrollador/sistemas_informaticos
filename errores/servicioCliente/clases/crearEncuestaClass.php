<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CrearEncuesta extends Controler{
	public function __construct(){
		
		parent::__construct(2);	
	}
	
	public function Main(){
		
	$this -> noCache();
		
	require_once("crearEncuestaLayoutClass.php");
    require_once("crearEncuestaModelClass.php");
	
	echo('test1<br>');
    $Layout   = new crearEncuestaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new crearEncuestaModel();
	echo('test2<br>');
    
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	echo('test3<br>');
	
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
	echo('test4<br>');
    $Layout -> setCampos($this -> Campos);	
	echo('test5<br>');
	
	$Layout -> RenderMain();
	echo('test7<br>');
	
}




protected function setCampos() {
	  echo('test6<br>');
	  
	  /*
  
	//campos formulario
	$this -> Campos[actividad_programada_id] = array(
		name	=>'actividad_programada_id',
		id	    =>'actividad_programada_id',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'true',
		//required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('primary_key'))
	);

	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		Boostrap =>'si',
		size	=>40,
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_hidden')
	);

	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_hidden',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);

	$this -> Campos[responsable] = array(
		name	=>'responsable',
		id		=>'responsable',
		type	=>'text',
		required =>'yes',
		Boostrap =>'si',
		size	=>40,
		suggest=>array(
			name	=>'usuario',
			setId	=>'responsable_hidden')
	);

	$this -> Campos[responsable_id] = array(
		name	=>'responsable_id',
		id		=>'responsable_hidden',
		type	=>'hidden',	
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id	=>'descripcion',
		type	=>'textarea',
		required=>'yes',
		//size    =>'20',
		cols=>'150',
		rows=>'5',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_inicial] = array(
		name	=>'fecha_inicial',
		id	=>'fecha_inicial',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id	=>'fecha_final',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_inicial_real] = array(
		name	=>'fecha_inicial_real',
		id	=>'fecha_inicial_real',
		type	=>'text',
		Boostrap =>'si',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_final_real] = array(
		name	=>'fecha_final_real',
		id	=>'fecha_final_real',
		type	=>'text',
		Boostrap =>'si',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[archivo] = array(
		name	  =>'archivo',
		id	  =>'archivo',
		type	  =>'upload',
                title     =>'Carga Adjunto',
                parameters=>'actividad_programada_id',
                beforesend=>'validaSeleccionTarea',
                onsuccess =>'onSendFile'
	);

	$this -> Campos[prioridad] = array(
		name	=>'prioridad',
		id		=>'prioridad',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'ALTA',selected=>'1'),array(value=>'2',text=>'MEDIA'),array(value=>'3',text=>'BAJA')),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	
	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id		=>'fecha_registro',
		type	=>'hidden',
		//required=>'yes',
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);

    $this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(array(value=>'1',text=>'ACTIVO',selected=>'1'),array(value=>'0',text=>'INACTIVO'),array(value=>'2',text=>'CERRADO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		//disabled=>'true',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_actualiza] = array(
				name	=>'fecha_actualiza',
				id		=>'fecha_actualiza',
				type	=>'hidden',
				//required=>'yes',
				transaction=>array(
					table	=>array('actividad_programada'),
					type	=>array('column'))
			);	

	$this -> Campos[usuario_actualiza_id] = array(
		name	=>'usuario_actualiza_id',
		id	    =>'usuario_actualiza_id',
		type	=>'hidden',
		//disabled=>'true',
		//required=>'no',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('actividad_programada'),
			type	=>array('column'))
	);

		$this -> Campos[fecha_cierre] = array(
		name	=>'fecha_cierre',
		id	=>'fecha_cierre',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date')
	);	

	$this -> Campos[fecha_cierre_real] = array(
		name	=>'fecha_cierre_real',
		id	=>'fecha_cierre_real',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date')
	);	

	$this -> Campos[observacion_cierre] = array(
		name	=>'observacion_cierre',
		id	=>'observacion_cierre',
		type	=>'textarea',
		//size    =>'20',
		datatype=>array(
			type	=>'text')
	);	

	$this -> Campos[usuario_cierre_id] = array(
		name	=>'usuario_cierre_id',
		id	    =>'usuario_cierre_id',
		type	=>'hidden',
		//disabled=>'true',
	 	datatype=>array(
			type	=>'integer')
	);

	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'TareaOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'TareaOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		Clase   =>'btn btn-danger',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TareaOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TareaOnReset(this.form)'
	);

	$this -> Campos[cerrar] = array(
		name	=>'cerrar',
		id		=>'cerrar',
		type	=>'button',
		value	=>'Cerrar',
		Clase   =>'btn btn-success',
		tabindex=>'14',
		onclick =>'Cierre(this.form)'
	);
	
	//busqueda
    	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder=>'ESCRIBA EL CODIGO O NOMBRE DE LA TAREA',
		//tabindex=>'1',
		suggest=>array(
			name	=>'actividad_programada',
			setId	=>'actividad_programada_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
	*/
  } 


}

$CrearEncuesta = new CrearEncuesta();

?>