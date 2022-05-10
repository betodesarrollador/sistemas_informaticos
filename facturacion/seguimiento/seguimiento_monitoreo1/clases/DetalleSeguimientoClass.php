<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleSeguimiento extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
    
    $this -> noCache();
    	
	require_once("DetalleSeguimientoLayoutClass.php");
    require_once("DetalleSeguimientoModelClass.php");
		
	$Layout = new DetalleSeguimientoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleSeguimientoModel();	
		
    $Layout -> setIncludes();
	
	$fechaDb = $Model -> getFechaDb($this -> getConex());
	$horaDb  = $Model -> getHoraDb($this -> getConex());
    $trafico_id = $_REQUEST['trafico_id'];
    $Layout -> setDetallesSeguimiento($Model -> getDetallesSeguimiento($this -> getConex()));
    $Layout -> setFechaHoraSalida    ($fechaDb,$horaDb,$Model -> getFechaHoraSalida($this -> getConex()));	
	$Layout -> setNovedad    		 ($Model -> getNovedad($this -> getConex()));	
	$Layout -> setCausal    		 ($Model -> getCausal($this -> getConex()));	

	
	$Layout -> setRemesa    		 ($Model -> getRemesas($trafico_id,$this -> getConex()));	
	
		
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"seguimiento",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

  protected function onclickSave(){
  
    require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();

	$usuarioNombres     = $this -> getUsuarioNombres();

    $return = $Model -> Save($this -> Campos,$this -> getUsuarioId(),$usuarioNombres,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        if(is_array($return)){
		  print json_encode($return);
		}else{
		    exit('false');
		  }
	  }	

  }

  protected function onclickSaveNew(){
  
    require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();
	
    $return = $Model -> SaveNew($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
 
         print json_encode($return);
 
	  }	

  }

  protected function onclickUpdate(){

    require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();
	$usuarioNombres     = $this -> getUsuarioNombres();
	
    $return = $Model -> Update($this -> Campos,$this -> getUsuarioId(),$usuarioNombres,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
      
	  print json_encode($return);
	  
	}	

  }

  protected function onclickUpdateNew(){

    require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();
	
    $Model -> UpdateNew($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
      exit("true");
	  
	}	

  }

  protected function onclickDelete(){
  
    require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }
	protected function comprobacion_fecha_hora(){
		
		
		require_once("DetalleSeguimientoModelClass.php");
		
		$Model = new DetalleSeguimientoModel();
		
		$det_seg_id=$_REQUEST['det_seg_id'];
		
		 $return= $Model -> comprobar_fecha_hora($det_seg_id,$this -> getConex());
		
		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
			print json_encode($return);
		
		}
	}


  protected function comprobar_finalizacion(){
	
	require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();
	$trafico_id=$_REQUEST['trafico_id'];
	
	$respuesta = $Model -> finalizo_remesas($trafico_id,$this -> getConex());
	 if($respuesta=="true"){
		  exit("true");
	 }else {
		  exit("false");
	 }
	
	  
  }

  protected function comprobar_novedad(){

    require_once("DetalleSeguimientoModelClass.php");
	
    $Model = new DetalleSeguimientoModel();
	$novedad_id=$_REQUEST['novedad_id'];
    $return= $Model -> Gettipo_novedad($novedad_id,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
      print json_encode($return);
	  
	}	

  }
  protected function getTipoCausal(){
  
    require_once("DetalleSeguimientoLayoutClass.php");
    require_once("DetalleSeguimientoModelClass.php");
	
    $Layout = new DetalleSeguimientoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleSeguimientoModel();  
	
	$finaliza = $_REQUEST['finaliza'];
	$devolucion = $_REQUEST['devolucion'];
	if($finaliza==1){
		$data           = $Model -> getCausal_Finaliza($this -> getConex());
	}elseif($devolucion==1){
		$data           = $Model -> getCausal_NoFinaliza($this -> getConex());
		
	}else{
		$data=array();
	}
	
	$field = array(
		name	=>'causal_devolucion_id',
		id		=>'causal_devolucion_id',
		type	=>'select',
		options	=> $data,
		style	=>'width:160px;',
		//required=>'yes',
		datatype=>array(type=>'integer')
	);    
	
	print $Layout -> getObjectHtml($field);
  
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