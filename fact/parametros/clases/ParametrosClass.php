<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Parametros extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ParametrosLayoutClass.php");
	require_once("ParametrosModelClass.php");
	
	$Layout   = new ParametrosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	$Layout -> SetTipofactura     ($Model -> GetTipofactura($this -> getConex()));
	$Layout -> SetTipodocumento   ($Model -> GetTipodocumento($this -> getConex()));
	$Layout -> SetTipooficina     ($Model -> GetTipooficina($this -> getConex()));
	$Layout -> SetFuente          ($Model -> GetFuente($this -> getConex()));
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("ParametrosLayoutClass.php");
	require_once("ParametrosModelClass.php");
	
	$Layout   = new ParametrosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'parametros',
		title		=>'Listado de Parametros',
		sortname	=>'fecha_resolucion_dian',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'fecha_resolucion_dian',	index=>'fecha_resolucion_dian',	sorttype=>'text',	width=>'80',	align=>'center'),
		array(name=>'resolucion_dian',		index=>'resolucion_dian',		sorttype=>'text',	width=>'100',	align=>'left'),
		array(name=>'nombre_tipo_factura',	index=>'nombre_tipo_factura',	sorttype=>'text',	width=>'120',	align=>'left'),	  
		array(name=>'fact_electronica',		index=>'fact_electronica',		sorttype=>'text',	width=>'140',	align=>'left'),	  	  
		array(name=>'nombre_tipo_documento',	index=>'nombre_tipo_documento',	sorttype=>'text',	width=>'190',	align=>'left'),
		array(name=>'nombre_oficina',			index=>'nombre_oficina',		sorttype=>'text',	width=>'130',	align=>'left'),	  
		array(name=>'prefijo',				index=>'prefijo',				sorttype=>'text',	width=>'100',	align=>'left'),
		array(name=>'rango_inicial',			index=>'rango_inicial',			sorttype=>'int',	width=>'100',	align=>'left'),
		array(name=>'rango_final',			index=>'rango_final',			sorttype=>'int',	width=>'100',	align=>'left')
	  );
		
	  $Titles = array('FECHA',
					  'RESOLUCION',
					  'TIPO FACTURA',
					  'RESOL/ELECTRONICA',
					  'DOC. CONTABLE',
					  'OFICNA',
					  'PREFIJO',
					  'RANGO INICIAL',
					  'RANGO FINAL'
	  );
	  
	 $html = $Layout -> SetGridParametros($Attributes,$Titles,$Cols,$Model -> GetQueryParametrosGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ParametrosModelClass.php");
	$Model = new ParametrosModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente');
	  }
	
  }

   protected function getFuentes(){
	  
  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	$parametros_factura_id = $_REQUEST['parametros_factura_id'];
	$data = $Model -> getFuentesFacturacion($parametros_factura_id,$this -> getConex());
	echo json_encode($data);  
	  
  }


  protected function onclickDelete(){

  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar');
	}else{
	    exit('Se borro exitosamente');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	
    $Data                  = array();
	$parametros_factura_id   = $_REQUEST['parametros_factura_id'];
	 
	if(is_numeric($parametros_factura_id)){
	  
	  $Data  = $Model -> selectDatosParametrosId($parametros_factura_id,$this -> getConex());
	  $tokens=$Model -> getTokens($this -> getConex());
	  
	  if($Data[0]['fact_electronica']==1){
		require_once("../../factura/clases/ProcesarVP.php");
	    $FacturaElec = new FacturaElectronica();
		$resultado = $FacturaElec -> sendFactura(7,'',$tokens,array(),array(),array());
		$Data[0]['folios_restantes']=$resultado['foliosRestantes'];
  
	  }
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[parametros_factura_id] = array(
		name	=>'parametros_factura_id',
		id		=>'parametros_factura_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);
	$this -> Campos[tipo_factura_id] = array(
		name	=>'tipo_factura_id',
		id		=>'tipo_factura_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
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
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);

	$this -> Campos[fact_electronica] = array(
		name	=>'fact_electronica',
		id		=>'fact_electronica',
		type	=>'select',
		Boostrap=>'si',
		options	=>array(array(value => '1', text => 'SI'),array(value => '0', text => 'NO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		Boostrap=>'si',
		options	=>array(array(value => '1', text => 'RESOLUCION'),array(value => '0', text => 'HABILITACION')),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametros_factura'),
			type	=>array('column'))
	);

	

	$this -> Campos[folios_restantes] = array(
		name	=>'folios_restantes',
		id		=>'folios_restantes',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'45')
	);

	$this -> Campos[fuente_facturacion_cod] = array(
		name	=>'fuente_facturacion_cod',
		id		=>'fuente_facturacion_cod',
		type	=>'select',
		Boostrap=>'si',
		multiple=>'yes',
		//required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'11')
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
			onsuccess=>'ParametrosOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ParametrosOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'parametros',
			setId	=>'parametros_factura_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$parametros_factura_id = new Parametros();

?>