<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Legalizar extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("LegalizarLayoutClass.php");
    require_once("LegalizarModelClass.php");
	
    $Layout   = new LegalizarLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LegalizarModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
	$Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	$Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU


//// GRID ////
	$Attributes = array(

	  id	    =>'wms_recepcion',		
	  title		=>'Listado de Legalizaciones',
	  sortname	=>'recepcion_id',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'recepcion_id',	    index=>'recepcion_id',		 width=>'60',	align=>'center'),
	  array(name=>'fecha',				index=>'fecha',			     width=>'230',	align=>'center'),	  
	  array(name=>'estado',				index=>'estado',			 width=>'120',	align=>'center'),
	  array(name=>'placa',	            index=>'placa',			     width=>'160',	align=>'center'),
	  array(name=>'usuario_registra',	index=>'usuario_registra',	     width=>'180',	align=>'center'),	  
	  array(name=>'fecha_registro',	    index=>'fecha_registro',		 width=>'120',	align=>'center'),
	  array(name=>'usuario_actualiza',  index=>'usuario_actualiza',		 width=>'180',	align=>'center'),
	  array(name=>'fecha_actualiza',	index=>'fecha_actualiza',	     width=>'120',	align=>'center')
	
	);
	  
    $Titles = array('CODIGO',
					'FECHA',
					'ESTADO',																	
					'PLACA',
					'USUARIO REGISTRA',
					'FECHA REGISTRO',
					'USUARIO ACTUALIZA',																	
					'FECHA ACTUALIZA'
	);
		
	$Layout -> SetGridLegalizar($Attributes,$Titles,$Cols,$Model -> getQueryLegalizarGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("LegalizarModelClass.php");
    $Model = new LegalizarModel();
    	
    $return = $Model -> Save($this -> Campos,$this -> getConex(),$this -> getUsuarioId());

    if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return);	 
	}
	
  }


  protected function onclickUpdate(){
	  
  	require_once("LegalizarModelClass.php");
    $Model = new LegalizarModel();
	
    $return = $Model -> Update($this -> Campos,$this -> getConex(),$this -> getUsuarioId());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return); 
	}
	  
  }

  protected function onclickAnular(){
	  
  	require_once("LegalizarModelClass.php");
	$Model = new LegalizarModel();

    $return = $Model -> Cancellation($this -> getUsuarioId(),$this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	    exit("true");
	}
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("LegalizarModelClass.php");
	$Model = new LegalizarModel();
	
	$recepcion_id = $_REQUEST['recepcion_id'];
	$return = $Model -> Delete($recepcion_id,$this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
		exit("Error : ".$Model -> GetError());
	}else{
	   print json_encode($return); 
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("LegalizarModelClass.php");
    $Model = new LegalizarModel();
	$Data  = $Model -> selectLegalizar($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[recepcion_id] = array(
		name	=>'recepcion_id',
		id	    =>'recepcion_id',
		type	=>'text',
		readonly => 'yes',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_recepcion'),
			type	=>array('primary_key'))
	);

/* 	$this -> Campos[fecha] = array(
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
			table	=>array('wms_recepcion'),
			type	=>array('column'))
	); */

	$this -> Campos[fecha] = array(
			name	=>'fecha',
			id		=>'fecha',
			type	=>'text',
			size 	=>'auto',
			value 	=>date('Y-m-d H:i:s'),
			Boostrap=>'si',
			datatype=>array(type=>'text'),
			transaction=>array(
				table	=>array('wms_recepcion'),
				type	=>array('column'))
		);


	
	$this -> Campos[enturnamiento_id] = array(
		name	=>'enturnamiento_id',
		id	=>'enturnamiento_id',
		type	=>'hidden',
		//required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('wms_recepcion'),
			type	=>array('column'))
	);
	
	$this -> Campos[placa] = array(
		name	=>'placa',
		id	=>'placa',
		type	=>'text',
		Boostrap => 'si',
		required=>'yes',
		size    =>'10',
		placeholder =>'Digite placa enturnada',
		suggest=>array(
				name	=>'wms_vehiculo_enturnado',
				setId	=>'enturnamiento_id')
	);	

	$this -> Campos[estado] = array(
    name=>'estado',
    id=>'estado',
	type=>'select',
	disabled => 'yes',
	required=>'yes',
	Boostrap =>'si',
    options	 =>array(array(value => 'P',text => 'PENDIENTE', selected=>'P'),array(value => 'L', text => 'LEGALIZADA'),array(value => 'I',text => 'INGRESADA'),array(value => 'A',text => 'ANULADA')),
    datatype=>array(
		type=>'text',
		length=>'11'),
    transaction=>array(
		table=>array('wms_recepcion'),
		type=>array('column'))
	);
	

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id   	=>'usuario_id',
		value   => $this -> getUsuarioId(),
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_recepcion'),
			type	=>array('column'))
	);	


	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id	    =>'fecha_registro',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_recepcion'),
			type	=>array('column'))
	);	

	$this -> Campos[usuario_actualiza_id] = array(
		name	=>'usuario_actualiza_id',
		id	    =>'usuario_actualiza_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('wms_recepcion'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_actualiza] = array(
		name	=>'fecha_actualiza',
		id	    =>'fecha_actualiza',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('wms_recepcion'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_anulacion] = array(
		name	=>'fecha_anulacion',
		id		=>'fecha_anulacion',
		type	=>'text',
		Boostrap =>'si',
		//required=>'yes',
		size =>'20',
    	datatype=>array(
			type	=>'date',
			length  =>'20'),
		transaction=>array(
			table	=>array('wms_recepcion'),
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
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
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
			onsuccess=>'LegalizarOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'LegalizarOnReset(this.form)'
	);
	
	//busqueda
    	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap =>'si',
		placeholder=>'Debe digitar el codigo de la legalización ó la placa del vehiculo.',
		//tabindex=>'1',
		suggest=>array(
			name	=>'wms_recepcion',
			setId	=>'recepcion_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$wms_recepcion = new Legalizar();

?>