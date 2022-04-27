<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Rutas extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("RutasLayoutClass.php");
	require_once("RutasModelClass.php");
	
	$Layout = new RutasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RutasModel();
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
   	$Layout -> SetEstadoRuta($Model -> GetEstadoRuta($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Rutas',
	  title		=>'Rutas',
	  sortname	=>'ruta',
	  width		=>'auto',
	  height	=>250
	);
	$Cols = array(
	  array(name=>'ruta',				index=>'ruta',				sorttype=>'text',	width=>'180',	align=>'center'),
	  array(name=>'origen',				index=>'origen',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',			index=>'destino',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'pasador_vial',		index=>'pasador_vial',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'distancia',			index=>'distancia',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'puntos',				index=>'puntos',			sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'estado_ruta',		index=>'estado_ruta',		sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('RUTA',
					'ORIGEN',
					'DESTINO',
					'PASADOR VIAL',
					'DISTANCIA (Km)',
					'No PUNTOS',
					'ESTADO RUTA'
	);
	
	$Layout -> SetGridRutas($Attributes,$Titles,$Cols,$Model -> getQueryRutasGrid());
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("RutasModelClass.php");
    $Model = new RutasModel();
	
    $return = $Model -> Save($this -> getConex());
	
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
    require_once("RutasModelClass.php");
	$Model = new RutasModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
      exit('true');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("RutasModelClass.php");
    $Model = new RutasModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la ruta');
	}
  }
  
  protected function setDataMap(){
  
    require_once("RutasModelClass.php");
    
	$Model = new RutasModel();
    $map   = $Model -> getDataMap($this -> getConex());
	
	$this -> getArrayJSON($map);
  
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("RutasModelClass.php");
    $Model = new RutasModel();
    $RutaId = $_REQUEST['ruta_id'];
    $Data =  $Model -> selectRutas($RutaId,$this -> getConex());
    $this -> getArrayJSON($Data);
  }



  protected function setCampos(){
  
	$this -> Campos[ruta_id] = array(
		name	=>'ruta_id',
		id		=>'ruta_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('ruta','detalle_ruta'),
			type	=>array('primary_key','column'))
	);
	
	$this -> Campos[ruta] = array(
		name	=>'ruta',
		id		=>'ruta',
		type	=>'text',
		required=>'yes',
		value	=>'',
		size	=>'67',
	    datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('ruta'),
			type	=>array('column'))
	);

	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		id		=>'cantidad',
		type	=>'hidden',
		value	=>'',
	    datatype=>array(
			type	=>'integer',
			length	=>'3')
	);

	$this -> Campos[pasador_vial] = array(
		name	=>'pasador_vial',
		id		=>'pasador_vial',
		type	=>'text',
		required=>'yes',
		value	=>'',
	    datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('ruta'),
			type	=>array('column'))
	);

	$this -> Campos[distancia] = array(
		name	=>'distancia',
		id		=>'distancia',
		type	=>'text',
		//required=>'yes',
		value	=>'',
	    datatype=>array(
			type	=>'numeric',
			length	=>'15'),
		transaction=>array(
			table	=>array('ruta'),
			type	=>array('column'))
	);

	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'origen_id')
	);
		
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('ruta'),
			type	=>array('column'))
	);
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'destino_id')
	);
		
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_id',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('ruta'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado_ruta] = array(
		name	=> 'estado_ruta',
		id		=> 'estado_ruta',
		type	=> 'select',
		options	=> array(),
//		selected=>'0',
		required=> 'yes',
		selected=>'1',
    	datatype=> array(type=>'integer'),
		transaction=>array(
			table	=>array('ruta'),
			type	=>array('column'))
	);
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'RutasOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'RutasOnUpdate')
		
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
	    property=>array(
			name	=>'delete_ajax',
			onsuccess=>'RutasOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick => 'rutasOnReset()'
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
			name	=>'busqueda_ruta',
			setId	=>'ruta_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new Rutas();

?>