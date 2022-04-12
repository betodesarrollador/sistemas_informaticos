<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Tarifas extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("TarifasLayoutClass.php");
	require_once("TarifasModelClass.php");
	
	$Layout   = new TarifasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TarifasModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetTipoConfig     ($Model -> GetTipoConfig($this -> getConex()));

	//// GRID ////
	$Attributes = array(
	  id		=>'tarifas',
	  title		=>'Listado de Tarifas',
	  sortname	=>'origen',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'origen',					index=>'origen',				sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'destino',				index=>'destino',				sorttype=>'text',	width=>'110',	align=>'center'),
	  array(name=>'configuracion',			index=>'configuracion',					sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'capacidad_carga',		index=>'capacidad_carga',		sorttype=>'text',	width=>'120',	align=>'center'),	  
	  array(name=>'periodo_proveedor',		index=>'periodo_proveedor',		sorttype=>'text',	width=>'70',	align=>'center'),	  
	  array(name=>'cupo_proveedor',			index=>'cupo_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),
	  array(name=>'cupofin_proveedor',		index=>'cupofin_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),	  
	  
	  array(name=>'cant_proveedor',			index=>'cant_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),
	  array(name=>'cantfin_proveedor',		index=>'cantfin_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),	  
	  
	  array(name=>'tone_proveedor',			index=>'tone_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),
	  array(name=>'tonefin_proveedor',		index=>'tonefin_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),	  
	  array(name=>'vol_proveedor',			index=>'vol_proveedor',			sorttype=>'int',	width=>'110',	align=>'center'),
	  array(name=>'volfin_proveedor',		index=>'volfin_proveedor',		sorttype=>'int',	width=>'110',	align=>'center'),	  
	  array(name=>'ant_proveedor',			index=>'ant_proveedor',			sorttype=>'int',	width=>'70',	align=>'center'),	  
	  array(name=>'antfin_proveedor',		index=>'antfin_proveedor',		sorttype=>'int',	width=>'70',	align=>'center'),
	  array(name=>'antpropio_proveedor',	index=>'antpropio_proveedor',	sorttype=>'int',	width=>'70',	align=>'center'),	  
	  array(name=>'antfinpropio_proveedor',	index=>'antfinpropio_proveedor',sorttype=>'int',	width=>'70',	align=>'center')
	  
	);
	  
    $Titles = array('ORIGEN',
					'DESTINO',
					'TIPO VEHICULO',
					'CAPACIDAD',
					'PERIODO',
					'VALOR CUPO MIN',
					'VALOR CUPO MAX',
					'VALOR CANT MIN',
					'VALOR CANT MAX',					
					'VALOR TON. MIN',
					'VALOR TON. MAX',					
					'VALOR VOL. MIN',
					'VALOR VOL. MAX',
					'% ANT. MIN',
					'% ANT. MAX',
					'ANTICIPO MIN PROPIO',
					'ANTICIPO MAX PROPIO'				
	);
	
	$Layout -> SetGridTarifas($Attributes,$Titles,$Cols,$Model -> GetQueryTarifasGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("TarifasModelClass.php");
    $Model = new TarifasModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("TarifasModelClass.php");
    $Model = new TarifasModel();
	
	$return=$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0 || $return!=''){
	  exit('Ocurrio una inconsistencia '.$return);
	}else{
	    exit('Se ingreso correctamente una nueva Tarifa');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("TarifasModelClass.php");
    $Model = new TarifasModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la Tarifa');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("TarifasModelClass.php");
    $Model = new TarifasModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la Tarifa');
	}else{
	    exit('Se borro exitosamente la Tarifa');
	  }
	
  }

  protected function SetCarga(){

    require_once("TarifasModelClass.php");

    $Model = new TarifasModel();    

    $configuracion = $_REQUEST['configuracion'];

    $data = $Model -> GetCarga($configuracion,$this -> getConex());

    print json_encode($data);

  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("TarifasModelClass.php");
    $Model = new TarifasModel();
	
    $Data                  = array();
	$tarifa_proveedor_id   = $_REQUEST['tarifa_proveedor_id'];
	 
	if(is_numeric($tarifa_proveedor_id)){
	  
	  $Data  = $Model -> selectDatosTarifasId($tarifa_proveedor_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[tarifa_proveedor_id] = array(
		name	=>'tarifa_proveedor_id',
		id		=>'tarifa_proveedor_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('primary_key'))
	);
	
	  
	$this -> Campos[origen_ubicacion] = array(
		name	=>'origen_ubicacion',
		id		=>'origen_ubicacion',
		type	=>'text',
		Boostrap=>'si',
		//tabindex=>'7',
		size	=>20,
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_ubicacion_hidden')
	);
		
	$this -> Campos[origen_ubicacion_id] = array(
		name	=>'origen_ubicacion_id',
		id		=>'origen_ubicacion_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[destino_ubicacion] = array(
		name	=>'destino_ubicacion',
		id		=>'destino_ubicacion',
		type	=>'text',
		Boostrap=>'si',
		size	=>20,	
		//tabindex=>'7',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'destino_ubicacion_hidden')
	);
		
	$this -> Campos[destino_ubicacion_id] = array(
		name	=>'destino_ubicacion_id',
		id		=>'destino_ubicacion_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);


	$this -> Campos[tipo_vehiculo_id] = array(
		name	=>'tipo_vehiculo_id',
		id		=>'tipo_vehiculo_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'4'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
		//onchange	=>'SetCarga()'		
	);
	$this -> Campos[capacidad_carga] = array(
		name	=>'capacidad_carga',
		id		=>'capacidad_carga',
		type	=>'text',
		Boostrap=>'si',
		value	=>'',
		//readonly=>'yes',
		//required=>'yes',
		size	=>10,	
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column')),
	);
	
	$this -> Campos[periodo_proveedor] = array(
		name	=>'periodo_proveedor',
		id		=>'periodo_proveedor',
		type	=>'select',
		Boostrap=>'si',
		options  => array(array(value => date('Y'), text => date('Y'),selected => date('Y')),array(value => date('Y')+1, text => date('Y')+1,selected => date('Y'))),		
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[cupo_proveedor] = array(
		name	=>'cupo_proveedor',
		id		=>'cupo_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size	=>12,
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[cupofin_proveedor] = array(
		name	=>'cupofin_proveedor',
		id		=>'cupofin_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[cant_proveedor] = array(
		name	=>'cant_proveedor',
		id		=>'cant_proveedor',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'10'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[cantfin_proveedor] = array(
		name	=>'cantfin_proveedor',
		id		=>'cantfin_proveedor',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'10'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);

	$this -> Campos[tone_proveedor] = array(
		name	=>'tone_proveedor',
		id		=>'tone_proveedor',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'10'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[tonefin_proveedor] = array(
		name	=>'tonefin_proveedor',
		id		=>'tonefin_proveedor',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'10'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);

	$this -> Campos[vol_proveedor] = array(
		name	=>'vol_proveedor',
		id		=>'vol_proveedor',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[volfin_proveedor] = array(
		name	=>'volfin_proveedor',
		id		=>'volfin_proveedor',
		type	=>'text',
		Boostrap=>'si',
		//required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);

	$this -> Campos[ant_proveedor] = array(
		name	=>'ant_proveedor',
		id		=>'ant_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[antfin_proveedor] = array(
		name	=>'antfin_proveedor',
		id		=>'antfin_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size	=>12,
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);

	$this -> Campos[antpropio_proveedor] = array(
		name	=>'antpropio_proveedor',
		id		=>'antpropio_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size	=>12,		
	 	datatype=>array(
			type	=>'numeric',
			length	=>'10'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[antfinpropio_proveedor] = array(
		name	=>'antfinpropio_proveedor',
		id		=>'antfinpropio_proveedor',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		size	=>12,
	 	datatype=>array(
			type	=>'numeric',
			length	=>'10'),
		transaction=>array(
			table	=>array('tarifa_proveedor'),
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
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		//tabindex=>'20'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		//tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TarifasOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'TarifasOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'tarifas',
			setId	=>'tarifa_proveedor_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tarifa_proveedor_id = new Tarifas();

?>