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
	$Layout -> SetTipoCarroceria     ($Model -> GetTipoCarroceria($this -> getConex()));

	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("TarifasLayoutClass.php");
	require_once("TarifasModelClass.php");
	
	$Layout   = new TarifasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TarifasModel();
	  
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
		array(name=>'carroceria',				index=>'carroceria',			sorttype=>'text',	width=>'120',	align=>'center'),
		array(name=>'periodo_cliente',		index=>'periodo_cliente',		sorttype=>'text',	width=>'70',	align=>'center'),	  
		array(name=>'cupo_cliente',			index=>'cupo_cliente',		sorttype=>'int',	width=>'110',	align=>'center'),
		array(name=>'cupofin_cliente',		index=>'cupofin_cliente',		sorttype=>'int',	width=>'110',	align=>'center'),	  
		array(name=>'tone_cliente',			index=>'tone_cliente',		sorttype=>'int',	width=>'110',	align=>'center'),
		array(name=>'tonefin_cliente',		index=>'tonefin_cliente',		sorttype=>'int',	width=>'110',	align=>'center'),	  
		array(name=>'vol_cliente',			index=>'vol_cliente',			sorttype=>'int',	width=>'110',	align=>'center'),
		array(name=>'volfin_cliente',		index=>'volfin_cliente',		sorttype=>'int',	width=>'110',	align=>'center')	  
	  );
		
	  $Titles = array('ORIGEN',
					  'DESTINO',
					  'VEHICULO',
					  'PERIODO',
					  'VALOR CUPO INI',
					  'VALOR CUPO FIN',					
					  'VALOR TON. INI',
					  'VALOR TON. FIN',					
					  'VALOR VOL. INI',
					  'VALOR VOL. FIN'					
	  );
	  
	 $html = $Layout -> SetGridTarifas($Attributes,$Titles,$Cols,$Model -> GetQueryTarifasGrid());
	 
	 print $html;
	  
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


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("TarifasModelClass.php");
    $Model = new TarifasModel();
	
    $Data                  = array();
	$tarifa_cliente_id   = $_REQUEST['tarifa_cliente_id'];
	 
	if(is_numeric($tarifa_cliente_id)){
	  
	  $Data  = $Model -> selectDatosTarifasId($tarifa_cliente_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas cliente
	********************/
	
	$this -> Campos[tarifa_cliente_id] = array(
		name	=>'tarifa_cliente_id',
		id		=>'tarifa_cliente_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('primary_key'))
	);
	
	  
	$this -> Campos[origen_ubicacion] = array(
		name	=>'origen_ubicacion',
		id		=>'origen_ubicacion',
		type	=>'text',
		Boostrap=>'si',
		//tabindex=>'7',
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
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	$this -> Campos[destino_ubicacion] = array(
		name	=>'destino_ubicacion',
		id		=>'destino_ubicacion',
		type	=>'text',
		Boostrap=>'si',
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
			table	=>array('tarifa_cliente'),
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
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	$this -> Campos[periodo_cliente] = array(
		name	=>'periodo_cliente',
		id		=>'periodo_cliente',
		type	=>'select',
		Boostrap=>'si',
		options  => array(array(value => date('Y'), text => date('Y'),selected => date('Y')),array(value => date('Y')+1, text => date('Y')+1,selected => date('Y'))),		
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	
	$this -> Campos[cupo_cliente] = array(
		name	=>'cupo_cliente',
		id		=>'cupo_cliente',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	$this -> Campos[cupofin_cliente] = array(
		name	=>'cupofin_cliente',
		id		=>'cupofin_cliente',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	
	$this -> Campos[tone_cliente] = array(
		name	=>'tone_cliente',
		id		=>'tone_cliente',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	$this -> Campos[tonefin_cliente] = array(
		name	=>'tonefin_cliente',
		id		=>'tonefin_cliente',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	
	$this -> Campos[vol_cliente] = array(
		name	=>'vol_cliente',
		id		=>'vol_cliente',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
			type	=>array('column'))
	);
	$this -> Campos[volfin_cliente] = array(
		name	=>'volfin_cliente',
		id		=>'volfin_cliente',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tarifa_cliente'),
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
			name	=>'tarifascliente',
			setId	=>'tarifa_cliente_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tarifa_cliente_id = new Tarifas();

?>