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
	
   /* $Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));*/
    $Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    /*$Layout -> setBorrar     ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular     ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
    $Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	*/
	
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


  
  /*protected function onclickSave(){    
  	require_once("CambioFechasModelClass.php");
    $Model = new CambioFechasModel();    
	$resultado= $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    print $resultado;
	  }	
  } */  

  protected function onclickUpdate(){  
    require_once("CambioFechasModelClass.php");
	$Model = new CambioFechasModel();	
	
		$Model -> Update($this -> Campos,$this -> getConex());	
		if($Model -> GetNumError() > 0){
		  exit("false");
		}else{
		   exit("true");
		  }	  
	  }
  
	  
 /* protected function onclickDelete(){
  	require_once("CambioFechasModelClass.php");
    $Model = new CambioFechasModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la guia');
	}
  }

	protected function OnClickAnular(){
		require_once("CambioFechasModelClass.php");
		$Model = new CambioFechasModel();
		$guia_id =$_REQUEST['guia_id'];
		$Model -> Anular($guia_id,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio un error anulano.');
		}else{
			exit('Se anulo correctamente la guia');
		}
	}
  
  protected function onclickCancellation(){    
     require_once("CambioFechasModelClass.php");	 
     $Model  = new CambioFechasModel(); 
	 $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();	
	 $Model -> cancellation($guia_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }
  }*/  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("CambioFechasModelClass.php");
    $Model = new CambioFechasModel();	
    $Data =  $Model -> selectGuia($this -> getConex());	
    $this -> getArrayJSON($Data);
  }
  
  /*protected function onclickPrint(){      
    require_once("Imp_GuiaClass.php");	
    $print   = new Imp_Guia($this -> getConex());  	
    $Guia = $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getEmpresaIdentificacion());  
  }*/
  
  
  /*protected function validaTipoEnvio(){
    require_once("CambioFechasModelClass.php");
    $Model = new CambioFechasModel();
	$tipo_envio_id  = $Model -> validaTipoEnvio($this -> getConex());
	print $tipo_envio_id;
  }*/
  
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
  /*protected function getOptionsTipoEnvio(){
	  
	require_once("CambioFechasLayoutClass.php");
	require_once("CambioFechasModelClass.php");	  
	
	$Layout   = new CambioFechasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CambioFechasModel();	 
	
    $TipoServicioId = $_REQUEST['tipo_servicio_mensajeria_id'];
	$TipoEnvio	    = $Model -> selectTipoEnvio($TipoServicioId,$this -> getConex());
	
	$field[tipo_envio_id] = array(
		name	=>'tipo_envio_id',
		id		=>'tipo_envio_id',
		type	=>'select',
		required	=>'yes',
		options	=>$TipoEnvio,
		//tabindex=>'2',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);		
	print $Layout -> getObjectHtml($field[tipo_envio_id]);	
  }  */
  
  /*protected function getOptionsTipoEnvioSelected(){
	  
	require_once("CambioFechasLayoutClass.php");
	require_once("CambioFechasModelClass.php");	  
	
	$Layout   = new CambioFechasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CambioFechasModel();	 
	
    $TipoServicioId = $_REQUEST['tipo_servicio_mensajeria_id'];
	$TipoEnvioId = $_REQUEST['tipo_envio_id'];
	$TipoEnvio  = $Model -> selectTipoEnvioSelected($TipoServicioId,$TipoEnvioId,$this -> getConex());
	
	$field[tipo_envio_id] = array(
		name	=>'tipo_envio_id',
		id		=>'tipo_envio_id',
		type	=>'select',
		required	=>'yes',
		options	=>$Oficinas,
		//tabindex=>'2',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
		
	print $Layout -> getObjectHtml($field[tipo_envio_id]);
	
  }  */  
  
//////////
  
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
		size	=>'7',
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
			name	=>'busca_guia_paqueteo',
			setId	=>'guia_id',
			onclick	=>'setDataFormWithResponse')
	);

//////////ANULACION	
	/*$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer')
	);		
	
	$this -> Campos[observacion_anulacion] = array(
		name	=>'observacion_anulacion',
		id		=>'observacion_anulacion',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
 		datatype=>array(
			type	=>'text')
	);*/
	
//////////BOTONES
	
	/*$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);*/
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>''
	);
	
   	/*¨$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		disabled=>'true',
		onclick =>'divAnular()'
	);*/

   	/*$this -> Campos[anula] = array(
		name	=>'anula',
		id		=>'anula',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation()'
	);	*/
	
  	/*$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'GuiaOnDelete')
	);*/
	
   	/*$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'GuiaOnReset()'
	);	*/
	
   	/*$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	    displayoptions => array(
			form        => 0,
			beforeprint => 'beforePrint',
		  title       => 'Impresion Guia Carga',
		  width       => '700',
		  height      => '600'
		)
	);*/
	
   	/*$this -> Campos[print_out] = array(
		name	   =>'print_out',
		id		   =>'print_out',
		type	   =>'button',
		value	   =>'OK'
	);*/	
	
   	/*$this -> Campos[print_cancel] = array(
		name	   =>'print_cancel',
		id		   =>'print_cancel',
		type	   =>'button',
		value	   =>'CANCEL'
	);*/
	
	$this -> SetVarsValidate($this -> Campos);
  }
}

$CambioFechas = new CambioFechas();

?>