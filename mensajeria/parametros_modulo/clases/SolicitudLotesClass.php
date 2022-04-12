<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicitudLotes extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
	   
    $this -> noCache();
    
	require_once("SolicitudLotesLayoutClass.php");
	require_once("SolicitudLotesModelClass.php");
	
	$Layout   = new SolicitudLotesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new SolicitudLotesModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setCliente		($Model -> getCliente		($this -> getConex()));
   	$Layout -> SetColSolicitud	($Model -> getColSolicitud	($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'SolicitudLotes',
	  title		=>'Configuracion Archivo Solicitud de Servicio por Lotes',
	  sortname	=>'cliente',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'cliente',			index=>'orden_compra',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'etiqueta_columna',	index=>'etiqueta_columna',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'campo_archivo',		index=>'campo_archivo',		sorttype=>'text',	width=>'150',	align=>'center')
	);
    $Titles = array('CLIENTE',
					'CAMPO SOLICITUD',
					'COLUMNA ARCHIVO'
	);
	$Layout -> SetGridSolicitudLotes($Attributes,$Titles,$Cols,$Model -> getQuerySolicitudLotesGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  
  protected function onclickSave(){
    require_once("SolicitudLotesModelClass.php");
    $Model = new SolicitudLotesModel();
    $Data = $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      $this -> getArrayJSON($Data);
    }	
  }

  protected function onclickUpdate(){
    require_once("SolicitudLotesModelClass.php");
	$Model = new SolicitudLotesModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la alerta');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("SolicitudLotesModelClass.php");
    $Model = new SolicitudLotesModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la alerta');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("SolicitudLotesModelClass.php");
    $Model = new SolicitudLotesModel();
    $Data =  $Model -> selectSolicitudLotes($this -> getConex());
	
    $this -> getArrayJSON($Data);
  }
  



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[campo_archivo_solicitud_id] = array(
		name	=>'campo_archivo_solicitud_id',
		id		=>'campo_archivo_solicitud_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('campo_archivo_detalle_solicitud'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('campo_archivo_detalle_solicitud'),
			type	=>array('column'))
	);
	
	$this -> Campos[campo_solicitud_id] = array(
		name	=>'campo_solicitud_id',
		id		=>'campo_solicitud_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('campo_archivo_detalle_solicitud'),
			type	=>array('column'))
	);
	
	$this -> Campos[campo_archivo] = array(
		name	=>'campo_archivo',
		id		=>'campo_archivo',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('campo_archivo_detalle_solicitud'),
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
			onsuccess=>'SolicitudLotesOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'SolicitudLotesOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'SolicitudLotesOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'SolicitudLotesOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		//value	=>'',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_solicitud_lotes',
			setId	=>'campo_archivo_solicitud_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$SolicitudLotes = new SolicitudLotes();

?>