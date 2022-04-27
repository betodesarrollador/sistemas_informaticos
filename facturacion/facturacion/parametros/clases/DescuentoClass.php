<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Descuento extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("DescuentoLayoutClass.php");
	require_once("DescuentoModelClass.php");
	
	$Layout   = new DescuentoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DescuentoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	$Layout -> SetTipooficina     ($Model -> GetTipooficina($this -> getConex()));
	$Layout -> SetEstado     	  ($Model -> GetEstado($this -> getConex()));
	$Layout -> SetNaturaleza      ($Model -> GetNaturaleza($this -> getConex()));
	
	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("DescuentoLayoutClass.php");
	require_once("DescuentoModelClass.php");
	
	$Layout   = new DescuentoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DescuentoModel();
	  
	 //// GRID ////
	$Attributes = array(
		id		=>'descuento',
		title		=>'Listado de Descuentos',
		sortname	=>'oficina_id',
		width		=>'auto',
		height	=>'250'
	  );
  
	  $Cols = array(
	  
		array(name=>'oficina_id',		index=>'oficina_id',	sorttype=>'text',	width=>'100',	align=>'left'),
		array(name=>'puc',			index=>'puc',			sorttype=>'text',	width=>'150',	align=>'left'),
		array(name=>'naturaleza',		index=>'naturaleza',	sorttype=>'text',	width=>'80',	align=>'left'),	  
		array(name=>'nombre',			index=>'nombre',		sorttype=>'text',	width=>'150',	align=>'left'),
		array(name=>'estado',			index=>'estado',		sorttype=>'text',	width=>'80',	align=>'left')	  
	  );
		
	  $Titles = array('OFICINA',
					  'CODIGO PUC',
					  'NATURALEZA',
					  'NOMBRE DESCUENTO',
					  'ESTADO'
	  );
	  
	 $html = $Layout -> SetGridDescuento($Attributes,$Titles,$Cols,$Model -> GetQueryDescuentoGrid()); 
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("DescuentoModelClass.php");
    $Model = new DescuentoModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("DescuentoModelClass.php");
    $Model = new DescuentoModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente el Descuento');
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("DescuentoModelClass.php");
    $Model = new DescuentoModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Descuento');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("DescuentoModelClass.php");
    $Model = new DescuentoModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar el Descuento');
	}else{
	    exit('Se borro exitosamente el Descuento');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("DescuentoModelClass.php");
    $Model = new DescuentoModel();
	
    $Data                  = array();
	$parametros_descuento_factura_id   = $_REQUEST['parametros_descuento_factura_id'];
	 
	if(is_numeric($parametros_descuento_factura_id)){
	  
	  $Data  = $Model -> selectDatosDescuentoId($parametros_descuento_factura_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/
	
	$this -> Campos[parametros_descuento_factura_id] = array(
		name	=>'parametros_descuento_factura_id',
		id		=>'parametros_descuento_factura_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('parametros_descuento_factura'),
			type	=>array('primary_key'))
	);
	
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'hidden',
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('parametros_descuento_factura'),
			type	=>array('column'))
	);
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_id')
	);
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('parametros_descuento_factura'),
			type	=>array('column'))
	);


	$this -> Campos[naturaleza] = array(
		name	=>'naturaleza',
		id		=>'naturaleza',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametros_descuento_factura'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_descuento_factura'),
			type	=>array('column'))
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametros_descuento_factura'),
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
			onsuccess=>'DescuentoOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'DescuentoOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap =>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'parametros_descuento_factura',
			setId	=>'parametros_descuento_factura_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$descuento_factura_id = new Descuento();

?>