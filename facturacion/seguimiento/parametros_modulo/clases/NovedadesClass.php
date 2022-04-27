<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Novedades extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("NovedadesLayoutClass.php");
	require_once("NovedadesModelClass.php");
	
	$Layout   = new NovedadesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new NovedadesModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetAlertasPanico($Model -> GetAlertasPanico ($this -> getConex()));
   	$Layout -> SetDetiene	   ($Model -> GetDetiene	   ($this -> getConex()));
	$Layout -> SetReporte	   ($Model -> GetReporte	   ($this -> getConex()));
	$Layout -> SetReportecliente($Model -> GetReporteCLiente($this -> getConex()));
   	$Layout -> SetEstadoNovedad($Model -> GetEstadoNovedad ($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Novedades',
	  title		=>'Novedades en el seguimiento',
	  sortname	=>'novedad',
	  width		=>'auto',
	  height	=>250
	);
	$Cols = array(
	  array(name=>'color',					    index=>'color',					    sorttype=>'text',	width=>'20',	align=>'center'),				  
	  array(name=>'novedad',					index=>'novedad',					sorttype=>'text',	width=>'130',	align=>'center'),
	  array(name=>'alerta_panico',				index=>'alerta_panico',				sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'finaliza_recorrido',			index=>'finaliza_recorrido',		sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'detiene_recorrido_novedad',	index=>'detiene_recorrido_novedad',	sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'tiempo_detenido_novedad',	index=>'tiempo_detenido_novedad',	sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'reporte_cliente',			index=>'reporte_cliente',			sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'reporte_interno',			index=>'reporte_interno',			sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'finaliza_remesa',			index=>'finaliza_remesa',			sorttype=>'text',	width=>'110',	align=>'center'),
  	  array(name=>'requiere_remesa',			index=>'requiere_remesa',			sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'estado_novedad',				index=>'estado_novedad',			sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('&nbsp;',
					'NOVEDAD',
					'ALERTA PANICO',
					'FINALIZA RECORRIDO',
					'DETIENE RECORRIDO',
					'TIEMPO DETENIDO (m)',
					'REPORTE CLIENTE',
					'REPORTE INTERNO',
					'FINALIZA REMESA',
					'REQUIERE REMESA',
					'ESTADO NOVEDAD'
	);
	
	$Layout -> SetGridNovedades($Attributes,$Titles,$Cols,$Model -> getQueryNovedadesGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"novedad_seguimiento",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("NovedadesModelClass.php");
    $Model = new NovedadesModel();
    $return =$Model -> Save($this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
  		exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}else{
		    exit('false');
		  }
	}	
  }

  protected function onclickUpdate(){
    require_once("NovedadesModelClass.php");
	$Model = new NovedadesModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente la novedad');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("NovedadesModelClass.php");
    $Model = new NovedadesModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la novedad');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
    require_once("../../../framework/clases/FindRowClass.php");
    $Data1 = new FindRow($this -> getConex(),"novedad_seguimiento",$this ->Campos);
    $this -> getArrayJSON($Data1 -> GetData());
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[novedad_id] = array(
		name	=>'novedad_id',
		id		=>'novedad_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[novedad] = array(
		name	=>'novedad',
		id		=>'novedad',
		type	=>'text',
		required=>'yes',
		value	=>'',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[alerta_id] = array(
		name	=>'alerta_id',
		id		=>'alerta_id',
		type	=>'select',
		options	=>null,
		selected=>'0',
    	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[detiene_recorrido_novedad] = array(
		name	=>'detiene_recorrido_novedad',
		id		=>'detiene_recorrido_novedad',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[requiere_remesa] = array(
		name	=>'requiere_remesa',
		id		=>'requiere_remesa',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[finaliza_recorrido] = array(
		name	=>'finaliza_recorrido',
		id		=>'finaliza_recorrido',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[finaliza_remesa] = array(
		name	=>'finaliza_remesa',
		id		=>'finaliza_remesa',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[tiempo_detenido_novedad] = array(
		name	=>'tiempo_detenido_novedad',
		id		=>'tiempo_detenido_novedad',
		type	=>'text',
		size	=>'7',
		value	=>'',
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[reporte_cliente] = array(
		name	=>'reporte_cliente',
		id		=>'reporte_cliente',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[reporte_interno] = array(
		name	=>'reporte_interno',
		id		=>'reporte_interno',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
			type	=>array('column'))
	);

	$this -> Campos[estado_novedad] = array(
		name	=>'estado_novedad',
		id		=>'estado_novedad',
		type	=>'select',
		options	=>null,
		selected=>'1',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('novedad_seguimiento'),
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
			onsuccess=>'NovedadesOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'NovedadesOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'NovedadesOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		type	=>'reset',
		name	=>'limpiar',
		id		=>'limpiar',
		value	=>'Limpiar',
		onclick	=>'NovedadesOnReset()'
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
			name	=>'busqueda_novedad_seguimiento',
			setId	=>'novedad_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$Novedades = new Novedades();

?>