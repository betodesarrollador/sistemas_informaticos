<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TarifasRutaCubicaje extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("TarifasRutaCubicajeLayoutClass.php");
	require_once("TarifasRutaCubicajeModelClass.php");
	
	$Layout   = new TarifasRutaCubicajeLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TarifasRutaCubicajeModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    		
	
	//// GRID ////
	$Attributes = array(
	  id		=>'TarifasRutaCubicaje',
	  title		=>'Listado de TarifasRutaCubicaje',
	  sortname	=>'origen',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(	
	  array(name=>'tarifa_ruta_cubicaje_id',	index=>'tarifa_ruta_cubicaje_id',	sorttype=>'text',	width=>'100',	align=>'center'),		
	  array(name=>'cliente',	index=>'cliente',	sorttype=>'text',	width=>'310',	align=>'center'),	
	  array(name=>'origen',		index=>'origen',	sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'destino',	index=>'destino',	sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'desde',		index=>'desde',		sorttype=>'text',	width=>'110',	align=>'center', format => 'currency'),
	  array(name=>'hasta',		index=>'hasta',		sorttype=>'text',	width=>'110',	align=>'center', format => 'currency'),	  	  
	  array(name=>'valor',		index=>'valor',		sorttype=>'text',	width=>'110',	align=>'center', format => 'currency')	  	  	  
	);
	  
    $Titles = array(
	                'CONSECUTIVO',
	                'CLIENTE',
					'ORIGEN',
					'DESTINO',
					'DESDE',
					'HASTA',
					'VALOR'
	);
	
	$Layout -> SetGridTarifasRutaCubicaje($Attributes,$Titles,$Cols,$Model -> GetQueryTarifasRutaCubicajeGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickSave(){

  	require_once("TarifasRutaCubicajeModelClass.php");
    $Model = new TarifasRutaCubicajeModel();
	
	$return=$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0 || $return!=''){
	  exit('Ocurrio una inconsistencia '.$return);
	}else{
	    exit('Se ingreso correctamente una nueva Tarifa');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("TarifasRutaCubicajeModelClass.php");
    $Model = new TarifasRutaCubicajeModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Tarifa');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("TarifasRutaCubicajeModelClass.php");
    $Model = new TarifasRutaCubicajeModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la Tarifa');
	}else{
	    exit('Se borro exitosamente la Tarifa');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("TarifasRutaCubicajeModelClass.php");
    $Model = new TarifasRutaCubicajeModel();
			
    $Data                     = array();
	$tarifa_ruta_cubicaje_id  = $_REQUEST['tarifa_ruta_cubicaje_id'];
	 
	if(is_numeric($tarifa_ruta_cubicaje_id)){
	  
	  $Data  = $Model -> selectDatosTarifasRutaCubicajeId($tarifa_ruta_cubicaje_id,$this -> getConex());
	  
	}
	 
    $this -> getArrayJSON($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos TarifasRutaCubicaje cliente
	********************/
	
	$this -> Campos[tarifa_ruta_cubicaje_id] = array(
		name	=>'tarifa_ruta_cubicaje_id',
		id		=>'tarifa_ruta_cubicaje_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[cliente_id] = array(
		name	 => 'cliente_id',
		id	 => 'cliente_id',
		type	 => 'select',
		required => 'yes',
		options  => array(),
		datatype => array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('column'))		
	);
	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_id_hidden')
	);
		
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_id_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('column'))
	);
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'destino_id_hidden')
	);
		
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_id_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('column'))
	);


	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'18',
			presicion=>'3'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('column'))
	);
	

	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'18',
			presicion=>'3'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('column'))
	);
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'18',
			presicion=>'6'),
		transaction=>array(
			table	=>array('tarifa_ruta_cubicaje'),
			type	=>array('column'))
	);
	 	  
	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',		
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'TarifasRutaCubicajeOnSaveOnUpdateonDelete')
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',		
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'TarifasRutaCubicajeOnSaveOnUpdateonDelete')
	);

	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TarifasRutaCubicajeOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TarifasRutaCubicajeOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		suggest=>array(
			name	=>'tarifa_ruta_cubicaje',
			setId	=>'tarifa_ruta_cubicaje_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tarifa_ruta_cubicaje_id = new TarifasRutaCubicaje();

?>