<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Asunto extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("AsuntoLayoutClass.php");
	require_once("AsuntoModelClass.php");
	
	$Layout   = new AsuntoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AsuntoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	/*$Layout -> SetTipofactura     ($Model -> GetTipofactura($this -> getConex()));
	$Layout -> SetTipodocumento   ($Model -> GetTipodocumento($this -> getConex()));
	$Layout -> SetTipooficina     ($Model -> GetTipooficina($this -> getConex()));*/
	

	//// GRID ////
	$Attributes = array(
	  id		=>'asunto',
	  title		=>'Listado de Asuntos',
	  sortname	=>'asunto_id',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'asunto_id',				index=>'asunto_id',				sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'descripcion',			index=>'descripcion',			sorttype=>'int',	width=>'100',	align=>'left')
	);
	  
    $Titles = array('No Asunto',
					'DESCRIPCION'
	);
	
	$Layout -> SetGridAsunto($Attributes,$Titles,$Cols,$Model -> GetQueryAsuntoGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("AsuntoModelClass.php");
    $Model = new AsuntoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("AsuntoModelClass.php");
    $Model = new AsuntoModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un Asunto');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("AsuntoModelClass.php");
    $Model = new AsuntoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Asunto');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("AsuntoModelClass.php");
    $Model = new AsuntoModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la Tarifa');
	}else{
	    exit('Se borro exitosamente el Asunto');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("AsuntoModelClass.php");
    $Model = new AsuntoModel();
	
    $Data                  = array();
	$asunto_id   = $_REQUEST['asunto_id'];
	 
	if(is_numeric($asunto_id)){
	  
	  $Data  = $Model -> selectDatosAsuntoId($asunto_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Asunto
	********************/
	
	$this -> Campos[asunto_id] = array(
		name	=>'asunto_id',
		id		=>'asunto_id',
		type	=>'text',
		disabled=>'yes',
		size =>'4',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('asunto'),
			type	=>array('primary_key'))
	);
	
	/*$this -> Campos[resolucion_dian] = array(
		name	=>'resolucion_dian',
		id		=>'resolucion_dian',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);*/
	/*$this -> Campos[fecha_resolucion_dian] = array(
		name	=>'fecha_resolucion_dian',
		id		=>'fecha_resolucion_dian',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);*/
	/*$this -> Campos[prefijo] = array(
		name	=>'prefijo',
		id		=>'prefijo',
		type	=>'text',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);*/
	/*$this -> Campos[tipo_factura_id] = array(
		name	=>'tipo_factura_id',
		id		=>'tipo_factura_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);*/
	
	/*$this -> Campos[rango_inicial] = array(
		name	=>'rango_inicial',
		id		=>'rango_inicial',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);
	$this -> Campos[rango_final] = array(
		name	=>'rango_final',
		id		=>'rango_final',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'45'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);*/

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('asunto'),
			type	=>array('column'))
	);
	/*$this -> Campos[observacion_dos] = array(
		name	=>'observacion_dos',
		id		=>'observacion_dos',
		type	=>'textarea',
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'250'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);*/
	 
	 	  
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
			onsuccess=>'AsuntoOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'AsuntoOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'Asunto',
			setId	=>'asunto_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$asunto_id = new Asunto();

?>