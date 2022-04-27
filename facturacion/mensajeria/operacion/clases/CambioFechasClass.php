<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CambioFechas extends Controler{

  public function __construct(){
   	parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();

    require_once("CambioFechasLayoutClass.php");    
    require_once("CambioFechasModelClass.php");
	
    $Layout   = new CambioFechasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CambioFechasModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	///LISTA MENU
    $Layout ->  SetEstadoMensajeria   	($Model -> GetEstadoMensajeria 	  ($this -> getConex()));
	
   	$Layout -> RenderMain();    
  }
  
  
  
  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"guia",$this ->Campos);
    print $Data  -> GetData();
  }

  protected function onclickUpdate(){  
    require_once("CambioFechasModelClass.php");
	$Model = new CambioFechasModel();	
	if($_REQUEST['tipo']=='ENCOMIENDA'){	
		$Model -> UpdateEnc($this -> Campos,$this -> getConex());
	}else{
		$Model -> Update($this -> Campos,$this -> getConex());
		
	}
	if($Model -> GetNumError() > 0){
	  exit("false");
	}else{
	   exit("true");
	  }	  
  }
  
	  

  //BUSQUEDA
  protected function onclickFind(){
  	require_once("CambioFechasModelClass.php");
    $Model = new CambioFechasModel();	
	
	if($_REQUEST['tipo']=='MENSAJERIA'){
	    $Data =  $Model -> selectGuia($this -> getConex());	
	}elseif($_REQUEST['tipo']=='ENCOMIENDA'){
	    $Data =  $Model -> selectGuiaEncomienda($this -> getConex());	
	}else{
		exit('No se encuentra Guia');	
	}
    $this -> getArrayJSON($Data);
  }
  
  
  protected function chequear(){  
    require_once("CambioFechasModelClass.php");	
    $Model = new CambioFechasModel();
	$data  = $Model -> chequear($this -> getOficinaId(),$this -> getConex());	
	if(is_array($data)){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
	  }      
  }  
  
  
  protected function setCampos(){
  
	////////// FORMULARIO
	////////// INFORMACION GENERAL
	$this -> Campos[guia_id] = array(
		name	=>'guia_id',
		id	=>'guia_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('primary_key'))
	);

	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id	=>'tipo',
		type	=>'hidden',
		datatype=>array(
			type	=>'text',
			length	=>'20'),
	);
	$this -> Campos[tipo_mostrar] = array(
		name	=>'tipo_mostrar',
		id	=>'tipo_mostrar',
		type	=>'text',
		disabled=>'yes',
		size	=>'12',
		datatype=>array(
			type	=>'text',
			length	=>'20'),
	);


	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id	    =>'oficina_id',
		type	=>'hidden',
		value   => $this -> getOficinaId(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[oficina_id_static] = array(
		name	=>'oficina_id_static',
		id	    =>'oficina_id_static',
		type	=>'hidden',
		value   => $this -> getOficinaId(),
	);		
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id	=>'fecha',
		type	=>'hidden',
		value	=>date("Y-m-d")
	);
	
	$this -> Campos[fecha_guia] = array(
		name	=>'fecha_guia',
		id		=>'fecha_guia',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_envio] = array(
		name	=>'fecha_envio',
		id		=>'fecha_envio',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_puente] = array(
		name	=>'fecha_puente',
		id		=>'fecha_puente',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

	$this -> Campos[fecha_ofc_entrega] = array(
		name	=>'fecha_ofc_entrega',
		id		=>'fecha_ofc_entrega',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);

	$this -> Campos[hora_ent] = array(
		name	=>'hora_ent',
		id		=>'hora_ent',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('entrega_oficina'),
			type	=>array('column'))
	);		

	$this -> Campos[fecha_entrega] = array(
		name	=>'fecha_entrega',
		id		=>'fecha_entrega',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);

	$this -> Campos[hora_entrega] = array(
		name	=>'hora_entrega',
		id		=>'hora_entrega',
		type	=>'text',
		//required=>'yes',
    	datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
	);		
	
	$this -> Campos[estado_mensajeria_id] = array(
		name	=>'estado_mensajeria_id',
		id		=>'estado_mensajeria_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		disabled=>'yes',
//		selected=>array(),
		datatype=>array(type=>'integer')
	);	
	
		$this -> Campos[numero_guia] = array(
		name	=>'numero_guia',
		id		=>'numero_guia',
		type	=>'text',
		required=>'no',
		size	=>'9',
		readonly=>'readonly',
		disabled=>'yes',
		datatype=>array(
			type	=>'alphanum', 
			length	=>'20')
	);
	
	

	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
//		tabindex=>'8',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_hidden')
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'destino_hidden')
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_hidden',
		type	=>'hidden',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);

	
	$this -> Campos[nombre_remitente] = array(
		name	=>'nombre_remitente',
		id		=>'nombre_remitente',
		type	=>'text',
		required=>'no',
		size	=>'20',
		//disabled=>'yes',
		datatype=>array(
			type	=>'text', 
			length	=>'40')
	);
	
	$this -> Campos[nombre_destinatario] = array(
		name	=>'nombre_destinatario',
		id		=>'nombre_destinatario',
		type	=>'text',
		required=>'no',
		size	=>'20',
		//disabled=>'yes',
		datatype=>array(
			type	=>'text', 
			length	=>'40')
	);
	
	$this -> Campos[telefono_remitente] = array(
		name	=>'telefono_remitente',
		id		=>'telefono_remitente',
		type	=>'text',
		required=>'no',
		size	=>'20',
		//disabled=>'yes',
		datatype=>array(
			type	=>'alphanum', 
			length	=>'20')
	);
	
     $this -> Campos[telefono_destinatario] = array(
		name	=>'telefono_destinatario',
		id		=>'telefono_destinatario',
		type	=>'text',
		required=>'no',
		size	=>'20',
		//disabled=>'yes',
		datatype=>array(
			type	=>'alphanum', 
			length	=>'20')
	);
	
	$this -> Campos[direccion_remitente] = array(
		name	=>'direccion_remitente',
		id		=>'direccion_remitente',
		type	=>'text',
		required=>'no',
		size	=>'30',
		//disabled=>'yes',
		datatype=>array(
			type	=>'alphanum', 
			length	=>'30')
	);
	
	$this -> Campos[direccion_destinatario] = array(
		name	=>'direccion_destinatario',
		id		=>'direccion_destinatario',
		type	=>'text',
		required=>'no',
		size	=>'30',
		//disabled=>'yes',
		datatype=>array(
			type	=>'alphanum', 
			length	=>'30')
	);
	
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		value	=>'',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_guia_mensa_enco',
			setId	=>'guia_id',
			onclick	=>'setDataFormWithResponse')
	);

	
//////////BOTONES
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>''
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
}

$CambioFechas = new CambioFechas();

?>