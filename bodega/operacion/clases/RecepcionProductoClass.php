<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RecepcionProducto extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("RecepcionProductoLayoutClass.php");
    require_once("RecepcionProductoModelClass.php");
	
    $Layout   = new RecepcionProductoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RecepcionProductoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	$Layout -> setSalida    ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU


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
    
  	require_once("RecepcionProductoModelClass.php");
    $Model = new RecepcionProductoModel();
    
    $this -> upload_max_filesize("2048M");
    
    $archivoPOST     = $_FILES['archivo'];
    $rutaAlmacenar   = "../../../archivos/general/";
    $dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"archivoProductos");   
    $camposArchivo   = $this -> excelToArray($dir_file,'ALL');
    $enturnamiento_id = $_REQUEST['enturnamiento_id'];
    
    $return = $Model -> Save($enturnamiento_id,$camposArchivo,$this -> Campos,$this -> getConex());
    
    if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return);	 
	}
	
  }


  protected function onclickUpdate(){
	  
  	require_once("RecepcionProductoModelClass.php");
	$Model = new RecepcionProductoModel();
	
	$wms_vehiculo_id = $_REQUEST['wms_vehiculo_id'];
	$placa = $_REQUEST['placa'];
	

    $return = $Model -> Update($placa,$this -> getUsuarioId(),$wms_vehiculo_id,$this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return); 
	}
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("RecepcionProductoModelClass.php");
    $Model = new RecepcionProductoModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Enturnamiento');
	  }
  }

  protected function onclickSalida(){
	  
  	require_once("RecepcionProductoModelClass.php");
	$Model = new RecepcionProductoModel();

    $return = $Model -> Salida($this -> getUsuarioId(),$this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	    exit("true");
	}
	  
  }



//BUSQUEDA
  protected function onclickFind(){
  	require_once("RecepcionProductoModelClass.php");
    $Model = new RecepcionProductoModel();
	$Data  = $Model -> selectEnturnamiento($this -> getConex());
	$this -> getArrayJSON($Data);
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

	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
        type	=>'text',
        readonly =>'yes',
		Boostrap =>'si',
		required=>'yes',
		size =>'20',
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
        readonly =>'yes',
		Boostrap => 'si',
		required=>'yes',
		size    =>'15',
		text_uppercase =>'si',
		suggest=>array(
				name	=>'wms_vehiculo',
				setId	=>'wms_vehiculo_id')
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
            readonly =>'yes',
			Boostrap => 'si',
			size    =>'35',
			suggest=>array(
				name	=>'muelle_bodega',
				setId	=>'muelle_id')
		);


	$this -> Campos[estado] = array(
			name=>'estado',
			id=>'estado',
			type=>'select',
			required=>'yes',
            Boostrap =>'si',
			options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE'),array(value => 'L', text => 'LEGALIZADA'),array(value => 'A', text => 'ANULADA')),
			datatype=>array(
				type=>'text',
				length=>'11'),
			transaction=>array(
				table=>array('wms_enturnamiento'),
				type=>array('column'))
	);

	$this -> Campos[fecha_salida_turno] = array(
		name	=>'fecha_salida_turno',
		id		=>'fecha_salida_turno',
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

	$this -> Campos[usuario_salida_id] = array(
		name	=>'usuario_salida_id',
		id   	=>'usuario_salida_id',
		value   => $this -> getUsuarioId(),
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric')
	);	

	$this -> Campos[observacion_salida] = array(
		name	=>'observacion_salida',
		id		=>'observacion_salida',
		type	=>'textarea',
		//Boostrap =>'si',
		value	=>'',
		//required=>'yes',
    	datatype=>array(
			type	=>'text')
    );
    
    $this -> Campos[archivo]  = array(
		name	=>'archivo',
		id		=>'archivo',
		type	=>'file',
		required=>'yes',
        title     =>'Carga de Archivos Productos',
	);


	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar Archivo',
	
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
	);

	$this -> Campos[salida] = array(
		name	=>'salida',
		id		=>'salida',
		type	=>'button',
		value	=>'Salida',
		onclick => 'onclickSalir(this.form)'
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
		placeholder=>'Por favor digite la placa del vehiculo enturnado ó el codigo del enturnamiento',
		//tabindex=>'1',
		suggest=>array(
			name	=>'wms_enturnamiento',
			setId	=>'enturnamiento_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$wms_enturnamiento = new RecepcionProducto();

?>