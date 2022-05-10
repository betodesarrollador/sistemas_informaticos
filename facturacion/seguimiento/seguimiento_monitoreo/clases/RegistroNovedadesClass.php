<?php

require_once("../../../framework/clases/ControlerClass.php");

final class RegistroNovedades extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("RegistroNovedadesLayoutClass.php");
	require_once("RegistroNovedadesModelClass.php");

	
	
	$Layout = new RegistroNovedadesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RegistroNovedadesModel();
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
	$Layout -> SetAnular	($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetNocturno($Model -> GetNocturno($this -> getConex()));
	$Layout -> SetEstadoSeg($Model -> GetEstadoSeg($this -> getConex()));
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
	
	
	$Layout -> RenderMain();
    
  }
  
  protected function set_webservice(){
  
    require_once("RegistroNovedadesModelClass.php");
    $trafico_id = $_REQUEST['trafico_id'];
	$Model = new RegistroNovedadesModel();
    $respuesta   = $Model -> enviar_webservice($trafico_id,$this -> getConex());
	exit("$respuesta");
  
  }
/*
  protected function llegada_webservice(){
  
    require_once("RegistroNovedadesModelClass.php");
    $trafico_id = $_REQUEST['trafico_id'];
	$Model = new RegistroNovedadesModel();
    $respuesta   = $Model -> llegar_webservice($trafico_id,$this -> getConex());
	exit("$respuesta");
  
  }*/
  
  protected function setPuntos(){
  
    require_once("RegistroNovedadesModelClass.php");
    
	$Model = new RegistroNovedadesModel();
    $puntos   = $Model -> getPuntos($this -> getConex());
	exit("$puntos");
  
  }

  protected function ComprobarPuntos(){
  
    require_once("RegistroNovedadesModelClass.php");
    
	$Model = new RegistroNovedadesModel();
    $puntos   = $Model -> getComprobarPuntos($this -> getConex());
	exit("$puntos");
  
  }

  protected function setEstado(){
  
    require_once("RegistroNovedadesModelClass.php");
    
	$Model = new RegistroNovedadesModel();
    $estado   = $Model -> getEstado($this -> getConex());
	exit("$estado");
  
  }

	

  protected function setRemesas(){
  
    require_once("RegistroNovedadesModelClass.php");
    
	$Model = new RegistroNovedadesModel();
    $num_remesas   = $Model -> getRemesas($this -> getConex());
	exit("$num_remesas");
  
  }


  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"trafico",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }

protected function onclickUpdateNota(){

		require_once("RegistroNovedadesModelClass.php");

		$Model = new RegistroNovedadesModel();
		$trafico_id = $_REQUEST['trafico_id'];
		$nota_controlador = $_REQUEST['nota_controlador'];
		$result = $Model -> UpdateNota($nota_controlador,$trafico_id,$this -> getConex());

		if($Model -> GetNumError() > 0){
			exit("false");
		}else{
			exit("true");
		}

	}

  protected function onclickUpdate(){

    require_once("RegistroNovedadesModelClass.php");
	
	$Model = new RegistroNovedadesModel();
	
	$result = $Model -> Update($this -> Campos,$this -> getUsuarioId(),$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
	
  }
	  
  protected function setRuta(){
  	require_once("RegistroNovedadesLayoutClass.php");
    require_once("RegistroNovedadesModelClass.php");
	$Layout = new RegistroNovedadesLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model = new RegistroNovedadesModel();
    $trafico_id = $_REQUEST['trafico_id'];
    $rutas = $Model -> getRutas($trafico_id,$this -> getConex());
    if(!count($rutas) > 0){
	  $rutas = array();
	}

      $field = array(
		name	 =>'ruta_id',
		id		 =>'ruta_id',
		type	 =>'select',
		options  => $rutas,	
		onchange	=>'ComprobarPuntos()',
    	datatype=>array(
			type	=>'integer')
	  );
	  
	  print $Layout -> getObjectHtml($field);

  
  }
 
   protected function selectedRutas(){

	require_once("RegistroNovedadesModelClass.php");
	
    $Model          = new RegistroNovedadesModel();  	
    $trafico_id 	= $_REQUEST['trafico_id'];
	
	$return = $Model -> getSelectedRutas($trafico_id,$this -> getConex());
	
	if(count($return) > 0){
	   $this -> getArrayJSON($return);
	}else{
	    exit('false');
	  }
  
  }


  protected function setDataMap(){
  
    require_once("RegistroNovedadesModelClass.php");
    
	$Model = new RegistroNovedadesModel();
    $map   = $Model -> getDataMap($this -> getConex());
	
	$this -> getArrayJSON($map);
  
  }
  
  
  protected function loadRoute(){
  
    require_once("RegistroNovedadesModelClass.php");
    
	$Model = new RegistroNovedadesModel();
	
	$newRoute = $Model -> createRoute($this -> getConex());
	//$this -> getArrayJSON($newRoute);
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
	
	//print "<pre>";print_r($_REQUEST);print "</pre>";
  }

  protected function onclickPrint(){

    require_once("Imp_PlanRutaClass.php");
    $print = new Imp_PlanRuta();
    $print -> printOut($this -> getConex());
  
  }


protected function onclickCancellation(){
  
   require_once("RegistroNovedadesModelClass.php");
 
    $Model = new RegistroNovedadesModel();
 
 $Model -> cancellation($this -> getUsuarioId(),$this -> getConex());
 
 if(strlen($Model -> GetError()) > 0){
   exit('false');
 }else{
     exit('true');
 }
 
  }
 /* protected function onclickCancellation(){
  
  	require_once("RegistroNovedadesModelClass.php");
	
    $Model = new RegistroNovedadesModel();
	
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }*/

  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("RegistroNovedadesModelClass.php");
    $Model           = new RegistroNovedadesModel();
	$trafico_id 	 = $_REQUEST['trafico_id'];	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($trafico_id,$this -> getConex());
	exit("$Estado");
	  
  } 

//BUSQUEDA
  protected function onclickFind(){
  
  	require_once("RegistroNovedadesModelClass.php");
    $Model = new RegistroNovedadesModel();
	
    $trafico_id = $_REQUEST['trafico_id'];
	
    $Data = $Model -> selectRegistroNovedades($trafico_id,$this -> getConex());
	
    $this -> getArrayJSON($Data);
	
  }
  
  protected function onclickMoveToUrban(){
  
  	require_once("RegistroNovedadesModelClass.php");
	
    $Model = new RegistroNovedadesModel();
	
	$Model -> moveToUrban($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
  
  }

//-----------------------Regresar a trafico-------------------------//

protected function onclickRegresarTrafico(){
  
  	require_once("RegistroNovedadesModelClass.php");
	
    $Model = new RegistroNovedadesModel();
	
	$Model -> regresarTrafico($this -> getConex());
	
  
  }
//-----------------------Regresar a trafico-------------------------//


  protected function setCampos(){
	  
	  
	
	$this -> Campos[trafico_id] = array(
		name	=>'trafico_id',
		id		=>'trafico_id',
		type	=>'hidden',
		value => $this -> requestData('trafico_id'),
		required=>'no',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('primary_key'))
	);	  
  
	$this -> Campos[numero] = array(
		name	=>'numero',
		id		=>'numero',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'200')
	);

	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'10')
	);

	$this -> Campos[agencia] = array(
		name	=>'agencia',
		id		=>'agencia',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'100')
	);

	$this -> Campos[aprobacion_min] = array(
		name	=>'aprobacion_min',
		id		=>'aprobacion_min',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'200')
	);

	$this -> Campos[fecha_aprob_min] = array(
		name	=>'fecha_aprob_min',
		id		=>'fecha_aprob_min',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'10')
	);

	$this -> Campos[clientes] = array(
		name	=>'clientes',
		id		=>'clientes',
		type	=>'textarea',
		//required=>'yes',
		readonly=>'yes',
		cols	=>'110',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);
	
	$this -> Campos[nota_controlador] = array(
		name	=>'nota_controlador',
		id		=>'nota_controlador',
		type	=>'textarea',
		cols	=>'110',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);


	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
		//required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'alphanum',
			length	=>'10')
	);


	$this -> Campos[marca] = array(
		name	=>'marca',
		id		=>'marca',
		type	=>'text',
		//required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);
	$this -> Campos[color] = array(
		name	=>'color',
		id		=>'color',
		type	=>'text',
		//required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'200')
	);

	$this -> Campos[link_gps] = array(
		name	=>'link_gps',
		id		=>'link_gps',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[usuario_gps] = array(
		name	=>'usuario_gps',
		id		=>'usuario_gps',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[clave_gps] = array(
		name	=>'clave_gps',
		id		=>'clave_gps',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);


	$this -> Campos[conduct] = array(
		name	=>'conduct',
		id		=>'conduct',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[celular] = array(
		name	=>'celular',
		id		=>'celular',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[categoria] = array(
		name	=>'categoria',
		id		=>'categoria',
		type	=>'text',
		//required=>'yes',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'20')
	);

	$this -> Campos[escolta_recibe] = array(
		name	=>'escolta_recibe',
		id		=>'escolta_recibe',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column')),
		suggest=>array(
			name	=>'escolta',
			setId	=>'apoyo_id_recibe')
		
		
	);

	$this -> Campos[apoyo_id_recibe] = array(
		name	=>'apoyo_id_recibe',
		id		=>'apoyo_id_recibe',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
	);

	$this -> Campos[escolta_entrega] = array(
		name	=>'escolta_entrega',
		id		=>'escolta_entrega',
		type	=>'text',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column')),
		suggest=>array(
			name	=>'escolta',
			setId	=>'apoyo_id_entrega')
		
	);

	$this -> Campos[apoyo_id_entrega] = array(
		name	=>'apoyo_id_entrega',
		id		=>'apoyo_id_entrega',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
	);


	$this -> Campos[t_nocturno] = array(
		name	=>'t_nocturno',
		id		=>'t_nocturno',
		options	=>null,
		type	=>'select',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
		
	);

	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		
	);

	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		readonly=>'yes',
		required=>'yes',		
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		
	);

	$this -> Campos[rutahidden] = array(
		name	=>'rutahidden',
		id		=>'rutahidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer')
	);

	$this -> Campos[ruta_id] = array(
		name	=>'ruta_id',
		id		=>'ruta_id',
		type	=>'select',
		options	=>array(),
		required=>'no',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
	);	


	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		options	=>array(),
		type	=>'select',
		datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
		
	);
	
	$this -> Campos[estadohidden] = array(
		name	=>'estadohidden',
		id		=>'estadohidden',
		type	=>'hidden',
		datatype=>array(type=>'text')
		
	);	

	$this -> Campos[fecha_inicial_salida] = array(
		name	=>'fecha_inicial_salida',
		id		=>'fecha_inicial_salida',
		type	=>'text',
		//required=>'yes',
		value=>date('Y-m-d'),
		datatype=>array(
			type=>'date',
			length=>'10'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
	);
	$this -> Campos[hora_inicial_salida] = array(
		name	=>'hora_inicial_salida',
		id		=>'hora_inicial_salida',
		type	=>'text',
		//required=>'yes',
		datatype=>array(
			type	=>'time',
			length	=>'12'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
		
	);

	$this -> Campos[frecuencia]  = array(
		name	=>'frecuencia',
		id		=>'frecuencia',
		type	=>'select',
		options	=> array(array(value=>'15',text=>'15 Minutos'),array(value=>'30',text=>'30 Minutos'),array(value=>'45',text=>'45 Minutos')
				  ,array(value=>'60',text=>'60 Minutos'),array(value=>'90',text=>'90 Minutos'),array(value=>'120',text=>'120 Minutos')),
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
	);

	/*****************************************
	        Campos Anulacion Registro
	*****************************************/
	

	$this -> Campos[anul_usuario_id] = array(
		name	=>'anul_usuario_id',
		id		=>'anul_usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer')/*,
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))*/
	);		


	$this -> Campos[anul_trafico] = array(
		name	=>'anul_trafico',
		id		=>'anul_trafico',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text')/*,
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))*/
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer')/*,
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))*/
	);		
	
	
	$this -> Campos[desc_anul_trafico] = array(
		name	=>'desc_anul_trafico',
		id		=>'desc_anul_trafico',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text')/*,
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))*/
	);	

	//botones

 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Trafico',
		'disabled'=>'disabled'
	);
	
		$this -> Campos[guardar_nota] = array(
		name	=>'guardar_nota',
		id		=>'guardar_nota',
		type	=>'button',
		value	=>'Guardar nota',
		'disabled'=>'disabled',
		onclick=>'guardarNota(this.form)'
	);
	
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		'disabled'=>'disabled',
		onclick => 'RegistroNovedadesOnReset()'
	);

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Plan de Ruta',
      width       => '1150',
      height      => '600'
    )

    );

   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		tabindex=>'14',
		onclick =>'onclickCancellation(this.form)'
	);	
	
   	$this -> Campos[mover_a_urbano] = array(
		name	=>'mover_a_urbano',
		id		=>'mover_a_urbano',
		type	=>'button',
		value	=>'Pasar a Urbano',
		tabindex=>'14',
		onclick =>'onclickMoveToUrban(this.form)'
	);		
	
	//-----------------------Regresar a trafico-------------------------//
	$this -> Campos[regresar_trafico] = array(
		name	=>'regresar_trafico',
		id		=>'regresar_trafico',
		type	=>'button',
		value	=>'Regresar a Trafico',
		tabindex=>'14',
		onclick =>'onclickRegresarTrafico(this.form)'
		
	);	
//-----------------------Regresar a trafico-------------------------//
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
//		tabindex=>'1',
		suggest=>array(
			name	=>'trafico',
			setId	=>'trafico_id',
			onclick	=>'setDataFormWithResponse')
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new RegistroNovedades();

?>