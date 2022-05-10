<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleMonitoreo extends Controler{

  public function __construct(){
//  print "<pre>"; print_r($_REQUEST); print "</pre>"; exit();
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    	
	require_once("DetalleMonitoreoLayoutClass.php");
    require_once("DetalleMonitoreoModelClass.php");
		
	$Layout = new DetalleMonitoreoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleMonitoreoModel();	
	
    $Layout -> setIncludes();
    $Layout -> setDetallesSeguimiento($Model -> getDetallesSeguimiento($this -> getConex()));
    $Layout -> setFechaHoraSalida    ($Model -> getFechaHoraSalida    ($this -> getConex()));	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"seguimiento",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetalleMonitoreoModelClass.php");
	
    $Model = new DetalleMonitoreoModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
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

    require_once("DetalleMonitoreoModelClass.php");
	
    $Model = new DetalleMonitoreoModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }
	
  }
	  
  protected function onclickDelete(){
  
    require_once("DetalleMonitoreoModelClass.php");
	
    $Model = new DetalleMonitoreoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }


//FORMULARIO
  
  protected function setCampos(){
  
	$this -> Campos[seguimiento_id] = array(
		name	=>'seguimiento_id',
		id		=>'seguimiento_id',
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

	$this -> Campos[orden_det_seg] = array(
		name	=>'orden_det_seg',
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
		
	$this -> Campos[paso_estimado] = array(
		name	=>'paso_estimado',
		type	=>'text',
		value	=>'',
//		tabindex=>'6',
	    datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_reporte] = array(
		name	=>'fecha_reporte',
		type	=>'text',
		value	=>'',
//		tabindex=>'7',
	    datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
		
	$this -> Campos[hora_reporte] = array(
		name	=>'hora_reporte',
		type	=>'text',
		value	=>'',
//		tabindex=>'6',
	    datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('detalle_seguimiento'),
			type	=>array('column'))
	);
	
	$this -> Campos[novedad] = array(
		name	=>'novedad',
		type	=>'text',
//		tabindex=>'5',
		suggest=>array(
			name	=>'novedad',
			setId	=>'novedad_id')
	);
		
	$this -> Campos[novedad_id] = array(
		name	=>'novedad_id',
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
		
	$this -> Campos[tiempo_novedad] = array(
		name	=>'tiempo_novedad',
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
		
	$this -> Campos[retraso] = array(
		name	=>'retraso',
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
	
	$this -> Campos[obser_deta] = array(
		name	=>'obser_deta',
		type	=>'text',
		value	=>'',
//		tabindex=>'7'
		datatype=>array(
			type	=>'alpha_upper')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
	
}

$DetalleMonitoreo = new DetalleMonitoreo();

?>