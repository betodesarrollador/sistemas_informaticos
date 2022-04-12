<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleSeguimiento extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
    
    $this -> noCache();
    	
	require_once("DetalleRemesasDespachoLayoutClass.php");
    require_once("DetalleRemesasDespachoModelClass.php");
		
	$Layout = new DetalleRemesasDespachoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleRemesasDespachoModel();	
		
    $Layout -> setIncludes();
	
	
    $trafico_id = $_REQUEST['trafico_id'];
    
	$Layout -> setRemesa    		 ($Model -> getRemesas($trafico_id,$this -> getConex()));	
	
		
	$Layout -> RenderMain();
    
  }

  

//FORMULARIO
  
  protected function setCampos(){
  
	$this -> Campos[trafico_id] = array(
		name	=>'trafico_id',
		id		=>'trafico_id',
		type	=>'hidden',
//		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[detalle_seg_id] = array(
		name	=>'detalle_seg_id',
		type	=>'hidden',
//		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('primary_key'))
	);

	$this -> Campos[orden_det_ruta] = array(
		name	=>'orden_det_ruta',
		type	=>'hidden',
//		required=>'no',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		type	=>'text',
//		tabindex=>'5',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'ubicacion_id')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		type	=>'hidden',
//		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
		
	$this -> Campos[tiempo_tramo] = array(
		name	=>'tiempo_tramo',
		type	=>'text',
		value	=>'',
//		tabindex=>'6',
	    datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[paso_estimado] = array(
		name	=>'paso_estimado',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
	    datatype=>array(
			type	=>'datetime'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
		
	$this -> Campos[distancia_tramo] = array(
		name	=>'distancia_tramo',
		type	=>'text',
		value	=>'',
//		tabindex=>'6',
	    datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
		
	$this -> Campos[recorrido_acumulado] = array(
		name	=>'recorrido_acumulado',
		type	=>'text',
		value	=>'',
//		tabindex=>'6',
	    datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[FechaHoraSalida] = array(
		name	=>'FechaHoraSalida',
		type	=>'text',
		value	=>'',
//		tabindex=>'7'
		datatype=>array(
			type	=>'alpha_upper')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

new DetalleSeguimiento();

?>