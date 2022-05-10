<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Resolucion extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ResolucionLayoutClass.php");
	require_once("ResolucionModelClass.php");
	
	$Layout   = new ResolucionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ResolucionModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	$Layout -> SetTipodocumento   ($Model -> GetTipodocumento($this -> getConex()));
	$Layout -> SetTipooficina     ($Model -> GetTipooficina($this -> getConex()));
	

	//// GRID ////
	$Attributes = array(
	  id		=>'parametros',
	  title		=>'Listado de Resolucion',
	  sortname	=>'fecha_resolucion_dian',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'fecha_resolucion_dian',	index=>'fecha_resolucion_dian',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'resolucion_dian',		index=>'resolucion_dian',		sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'nombre_tipo_documento',	index=>'nombre_tipo_documento',	sorttype=>'text',	width=>'190',	align=>'left'),
	  array(name=>'nombre_oficina',			index=>'nombre_oficina',		sorttype=>'text',	width=>'130',	align=>'left'),	  
	  array(name=>'prefijo',				index=>'prefijo',				sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'rango_inicial',			index=>'rango_inicial',			sorttype=>'int',	width=>'100',	align=>'left'),
	  array(name=>'rango_final',			index=>'rango_final',			sorttype=>'int',	width=>'100',	align=>'left')
	);
	  
    $Titles = array('FECHA',
					'RESOLUCION',
					'DOC. CONTABLE',
					'OFICNA',
					'PREFIJO',
					'RANGO INICIAL',
					'RANGO FINAL'
	);
	
	$Layout -> SetGridResolucion($Attributes,$Titles,$Cols,$Model -> GetQueryResolucionGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ResolucionModelClass.php");
    $Model = new ResolucionModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ResolucionModelClass.php");
    $Model = new ResolucionModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ResolucionModelClass.php");
    $Model = new ResolucionModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("ResolucionModelClass.php");
    $Model = new ResolucionModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar');
	}else{
	    exit('Se borro exitosamente');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ResolucionModelClass.php");
    $Model = new ResolucionModel();
	
    $Data                  = array();
	$parametros_equivalente_id   = $_REQUEST['parametros_equivalente_id'];
	 
	if(is_numeric($parametros_equivalente_id)){
	  
	  $Data  = $Model -> selectDatosResolucionId($parametros_equivalente_id,$this -> getConex());
	  
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[parametros_equivalente_id] = array(
		name	=>'parametros_equivalente_id',
		id		=>'parametros_equivalente_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[resolucion_dian] = array(
		name	=>'resolucion_dian',
		id		=>'resolucion_dian',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);
	$this -> Campos[fecha_resolucion_dian] = array(
		name	=>'fecha_resolucion_dian',
		id		=>'fecha_resolucion_dian',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_vencimiento_resolucion_dian] = array(
		name	=>'fecha_vencimiento_resolucion_dian',
		id		=>'fecha_vencimiento_resolucion_dian',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);
	
	$this -> Campos[prefijo] = array(
		name	=>'prefijo',
		id		=>'prefijo',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_inicial] = array(
		name	=>'rango_inicial',
		id		=>'rango_inicial',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);
	$this -> Campos[rango_final] = array(
		name	=>'rango_final',
		id		=>'rango_final',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);

	$this -> Campos[observacion_uno] = array(
		name	=>'observacion_uno',
		id		=>'observacion_uno',
		type	=>'textarea',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'250'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
			type	=>array('column'))
	);
	$this -> Campos[observacion_dos] = array(
		name	=>'observacion_dos',
		id		=>'observacion_dos',
		type	=>'textarea',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'250'),
		transaction=>array(
			table	=>array('parametros_equivalente'),
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
			onsuccess=>'ResolucionOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ResolucionOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'parametros_equivalente',
			setId	=>'parametros_equivalente_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$parametros_factura_id = new Resolucion();

?>