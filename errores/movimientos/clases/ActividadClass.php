<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Actividad extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("ActividadLayoutClass.php");
    require_once("ActividadModelClass.php");
	
    $Layout   = new ActividadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ActividadModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU

    $Layout -> SetFase($Model -> GetFase($this -> getConex()));


//// GRID ////
	$Attributes = array(

	  id	=>'actividad_id',		
	  title		=>'Listado de tipos de Actividad',
	  sortname	=>'nombre',
	  width		=>'1100',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'actividad_id',	    index=>'actividad_id',			width=>'80',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',			    width=>'230',	align=>'center'),
	  array(name=>'estado',				index=>'estado',			    width=>'230',	align=>'center'),
	  array(name=>'fecha_inicial',		index=>'fecha_inicial',			width=>'230',	align=>'center'),
	  array(name=>'fecha_inicial_real',	index=>'fecha_inicial_real',	width=>'80',	align=>'center'),
	  array(name=>'fecha_final',		index=>'fecha_final',			width=>'230',	align=>'center'),
	  array(name=>'fecha_final_real',	index=>'fecha_final_real',	    width=>'230',	align=>'center'),
	  array(name=>'fecha_cierre',		index=>'fecha_cierre',			width=>'230',	align=>'center'),
	  array(name=>'fecha_cierre_real',	index=>'fecha_cierre_real',	    width=>'230',	align=>'center'),


	);
	  
    $Titles = array('CODIGO',
					'NOMBRE',
					'ESTADO',
					'FECHA INICIAL',
					'FECHA INI REAL',
					'FECHA FINAL',
					'FECHA FIN REAL',
					'FECHA CIERRE',
					'FECHA CIERRE REAL'
	);
		
	$Layout -> SetGridActividad($Attributes,$Titles,$Cols,$Model -> getQueryActividadGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"Actividad",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("ActividadModelClass.php");
    $Model = new ActividadModel();
    	
    $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la Actividad');
	 }
	
  }

  protected function getBarrio(){

	require_once("ActividadModelClass.php");
		
    $Model           = new ActividadModel();
    $ubicacion_id = $this->requestData('ubicacion_id');
    $barrio_id = $this->requestData('barrio_id');
    $result         = $Model -> selectBarrio($ubicacion_id,$barrio_id,$this -> getConex());
		
	echo json_encode($result);

  }


  protected function onclickUpdate(){
	  
  	require_once("ActividadModelClass.php");
    $Model = new ActividadModel();
    $actividad_id = $this->requestData('actividad_id');
	
    $Model -> Update($actividad_id,$this -> Campos,$this -> getUsuarioId(),$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Actividad');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("ActividadModelClass.php");
    $Model = new ActividadModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Actividad');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("ActividadModelClass.php");
    $Model = new ActividadModel();
	$Data  = $Model -> selectActividad($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function guardarCierre(){
    
  	require_once("ActividadModelClass.php");
	$Model = new ActividadModel();
	
		$actividad_id = $_REQUEST['actividad_id'];
		$fecha_cierre = date("Y-m-d H:i:s");  
		$fecha_cierre_real = $_REQUEST['fecha_cierre_real'];
		$observacion_cierre = $_REQUEST['observacion_cierre'];
    	
    $Model -> SaveCierre($actividad_id,$fecha_cierre,$fecha_cierre_real,$observacion_cierre,$this -> getUsuarioId(),$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit("¡Tarea cerrada exitosamente!");
	 }
	
  }

  protected function uploadFileAutomatically(){
  
    require_once("ActividadModelClass.php");

    $Model         = new ActividadModel();
	$actividad_id  = $_REQUEST['actividad_id'];
    $ruta          = "../../../archivos/errores/actividades/";
    $archivo       = $_FILES['archivo'];
    $nombreArchivo = "adjunto_tarea_".$actividad_id;    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);

    
    $Model -> setAdjunto($actividad_id,$dir_file,$this -> getConex());      
		

	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}


  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[actividad_id] = array(
		name	=>'actividad_id',
		id	    =>'actividad_id',
		type	=>'text',
		Boostrap => 'si',
		disabled=>'true',
		//required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('actividad_fase'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
			type	=>array('column'))
	);

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id	=>'descripcion',
		type	=>'textarea',
		required=>'yes',
		//size    =>'50',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
			type	=>array('column'))
	);	

	$this -> Campos[archivo] = array(
		name	  =>'archivo',
		id	  =>'archivo',
		type	  =>'upload',
                title     =>'Carga Adjunto',
                parameters=>'actividad_id',
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
			table	=>array('actividad_fase'),
			type	=>array('column'))
	);	


	$this -> Campos[fecha_cierre] = array(
		name	=>'fecha_cierre',
		id	=>'fecha_cierre',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('actividad_fase'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_cierre_id] = array(
		name	=>'usuario_cierre_id',
		id	    =>'usuario_cierre_id',
		type	=>'hidden',
		//disabled=>'true',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('actividad_fase'),
			type	=>array('column'))
	);

		
	$this -> Campos[fase_id] = array(
			name=>'fase_id',
			id=>'fase_id',
			type=>'select',
			Boostrap => 'si',
			required=>'yes',
			options=>array(),
			datatype=>array(
				type=>'integer',
				length=>'11'),
			transaction=>array(
				table=>array('actividad_fase'),
				type=>array('column'))
		);

	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id		=>'fecha_registro',
		type	=>'hidden',
		//required=>'yes',
		transaction=>array(
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
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
			table	=>array('actividad_fase'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_actualiza] = array(
				name	=>'fecha_actualiza',
				id		=>'fecha_actualiza',
				type	=>'hidden',
				//required=>'yes',
				transaction=>array(
					table	=>array('actividad_fase'),
					type	=>array('column'))
			);	

	$this -> Campos[usuario_actualizo_id] = array(
		name	=>'usuario_actualizo_id',
		id	    =>'usuario_actualizo_id',
		type	=>'hidden',
		//disabled=>'true',
		//required=>'no',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('actividad_fase'),
			type	=>array('column'))
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

	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'ActividadOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ActividadOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		Clase   =>'btn btn-danger',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ActividadOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ActividadOnReset(this.form)'
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
		Boostrap => 'si',
		size	=>'85',
		placeholder=>'ESCRIBA EL CODIGO O NOMBRE DE LA ACTIVIDAD',
		//tabindex=>'1',
		suggest=>array(
			name	=>'actividad_fase',
			setId	=>'actividad_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$Actividad = new Actividad();

?>