<?php

require_once("../../../framework/clases/ControlerClass.php");

final class LiquidarRemesas extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){
  
	$this -> Campos[manifiesto_despacho] = array(
		name     =>'manifiesto_despacho',
		id	     =>'manifiesto_despacho',
		type     =>'text',
		required =>'yes',
		size     =>'30',
	 	datatype=>array(type=>'integer'),
		suggest=>array(
			name	=>'manifiestos_despachos_liquidar',
			setId	=>'manifiesto_despacho_id',
			onclick =>'getDataManifiestoDespacho'
			)
	);	
	
	$this -> Campos[manifiesto_despacho_id] = array(
		name     =>'manifiesto_despacho_id',
		id	     =>'manifiesto_despacho_id',
		type     =>'hidden',
	 	datatype=>array(type=>'integer')
	);
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text'
	);			  

	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text'
	);
  
	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text'
	);  
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text'
	);  	
	
	$this -> Campos[tipo_liquidacion] = array(
		name	=>'tipo_liquidacion',
		id	    =>'tipo_liquidacion',
		type	=>'select',
		options=>array(array(value => 'P', text => 'Peso'),array(value => 'V', text => 'Volumen'),array(value =>'C',text => 'Cupo')),
		datatype=>array(type=>'alpha'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[valor_facturar] = array(
		name	=>'valor_facturar',
		id	    =>'valor_facturar',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
	
	$this -> Campos[valor_unidad_facturar] = array(
		name	=>'valor_unidad_facturar',
		id	    =>'valor_unidad_facturar',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		
		
  
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("LiquidarRemesasLayoutClass.php");
    require_once("LiquidarRemesasModelClass.php");
	
    $Layout   = new LiquidarRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LiquidarRemesasModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setCampos($this -> Campos);	
	
	$Layout -> RenderMain();
    
  }
  
//BUSQUEDA
  protected function onclickFind(){

    require_once("LiquidarRemesasModelClass.php");

    $Model     = new LiquidarRemesasModel();
    $Solicitud = $_REQUEST['solicitud_id'];
    $Data      =  $Model -> selectSolicitud($Solicitud,$this -> getConex());

    $this -> getArrayJSON($Data);	

  }
	
  protected function getDataManifiestoDespacho(){
  
    require_once("LiquidarRemesasModelClass.php");

    $Model                  = new LiquidarRemesasModel();  
	$tipo                   = $this -> requestData('tipo');
	$manifiesto_despacho_id = $this -> requestData('manifiesto_despacho_id'); 	 
	
    $Data  = $Model -> selectDataManifiestoDespacho($tipo,$manifiesto_despacho_id,$this -> getConex());
	
    $this -> getArrayJSON($Data);	
  
  }	
	
}

new LiquidarRemesas();

?>