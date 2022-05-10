<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Guia extends Controler{

  public function __construct(){
   	parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();

    require_once("GuiaLayoutClass.php");    
    require_once("GuiaModelClass.php");
	
    $Layout   = new GuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new GuiaModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar     ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular     ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
    $Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
//    $Layout ->  setProductos	   		($Model -> getProductos  	      ($this -> getConex()));
    // $Layout -> 	setRangoDesde      		($Model -> getGuiaNumero		  ($this -> getConex(),$this -> getOficinaId()));
    // $Layout -> 	setRangoHasta      		($Model -> getGuiaNumero		  ($this -> getConex(),$this -> getOficinaId()));
    $Layout ->  setCausalesAnulacion	($Model -> getCausalesAnulacion	  ($this -> getConex()));		
    $Layout ->  SetTipoServicio		  	($Model -> GetTipoServicio   	  ($this -> getConex()));
   // $Layout ->  SetTipoEnvio  		  	($Model -> GetTipoEnvio           ($this -> getConex()));
    $Layout ->  SetFormaPago  		  	($Model -> GetFormaPago       	  ($this -> getConex()));	
    //$Layout ->  SetClaseServicio      	($Model -> GetClaseServicio    	  ($this -> getConex()));
    $Layout ->  SetEstadoMensajeria   	($Model -> GetEstadoMensajeria 	  ($this -> getConex()));
    // $Layout ->  SetMotivoDevolucion   	($Model -> GetMotivoDevolucion    ($this -> getConex()));
    $Layout ->  SetTipoIdentificacion   ($Model -> GetTipoIdentificacion  ($this -> getConex()));
	 $Layout ->  SetTipoMedida   ($Model -> GetTipoMedida  ($this -> getConex()));
	 $Layout -> setClientes($Model -> getClientes($this -> getOficinaId(),$this -> getConex()));    	
///////////////////////
    	
	//// GRID ////
	$Attributes = array(
	  id		=>'GuiaOficinas',
	  title		=>'Listado de Guias',
	  sortname	=>'guia',
	  sortorder =>'ASC',
	  width		=>'auto',
	  height	=>'250',
	  rowList	=>'10,20,30,40,60,80,160,320,640',
	  rowNum	=>'10'	  
	);
	
	$Cols = array(
	  array(name=>'guia',		           index=>'guia',	        sorttype=>'text',	width=>'60',	align=>'center' ),      	  
	  array(name=>'orden_despacho',		   index=>'orden_despacho',	        sorttype=>'text',	width=>'60',	align=>'center' ),      	  
	  
	  array(name=>'fecha_guia',		  	   index=>'fecha_guia',	     	    sorttype=>'text',	width=>'80',	align=>'center'),      	  
	  array(name=>'origen',			       index=>'origen',		            sorttype=>'text',	width=>'120',	align=>'rigth' ),	
	  array(name=>'destino',			   index=>'destino',			    sorttype=>'text',	width=>'120',	align=>'rigth' ),
	  array(name=>'remitente',		       index=>'remitente',		        sorttype=>'text',	width=>'170',	align=>'rigth'), 
	  array(name=>'destinatario',	       index=>'destinatario',	        sorttype=>'text',	width=>'170',	align=>'rigth' ),
	  array(name=>'telefono_destinatario',index=>'telefono_destinatario', sorttype=>'text',	width=>'100',	align=>'rigth' ),
	  
	  array(name=>'direccion_destinatario',index=>'direccion_destinatario', sorttype=>'text',	width=>'170',	align=>'rigth' ),
	  array(name=>'referencia_producto',   index=>'referencia_producto',	sorttype=>'text',	width=>'150',	align=>'rigth' ),
	  array(name=>'cantidad',		       index=>'cantidad',		        sorttype=>'text',	width=>'70',	align=>'center' ),
	  array(name=>'peso',		           index=>'peso',		            sorttype=>'text',	width=>'60',	align=>'center'), 
   	  array(name=>'peso_volumen',	       index=>'peso_volumen',		    sorttype=>'text',	width=>'60',	align=>'center'),	  	  
	  array(name=>'observaciones',	       index=>'observaciones',		    sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'estado',	    		   index=>'estado',		            sorttype=>'text',	width=>'80',	align=>'center')
	 );	
			
    $Titles = array(
	    'Nro. GUIA','DOC. CLIENTE','FECHA','ORIGEN','DESTINO','REMITENTE','DESTINATARIO','TEL DESTINATARIO','DIRECCION DESTINATARIO','DICE CONTENER','CANTIDAD','PESO Kg','PESO Vol.','OBSERVACIONES','ESTADO');
		
	$Layout -> SetGridGuiaOficinas($Attributes,$Titles,$Cols,$Model -> getQueryGuiaOficinasGrid($this -> getOficinaId()));	
	$Layout -> RenderMain();    
  }
  
  
  
  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"guia",$this ->Campos);
    print $Data  -> GetData();
  }


  
  protected function onclickSave(){    
  	require_once("GuiaModelClass.php");
    $Model = new GuiaModel();    
	$resultado= $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getUsuarioId(),$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    print $resultado;
	  }	
  }   

  protected function onclickUpdate(){  
    require_once("GuiaModelClass.php");
	$Model = new GuiaModel();	
	$numero_guia = $_REQUEST['numero_guia'];
	$clase_guia  = $_REQUEST['clase_guia'];	
	if($clase_guia == 'CP' && $Model -> esGuiaPrincipal($numero_guia,$this -> getConex())){	
	  print "<p align='center'>Esta guia es principal para otros complemento ingresados<br>No se puede marcar como guia de complemento!!!</p>";	
	}else{	
		$Model -> Update($this -> Campos,$this -> getConex());	
		if($Model -> GetNumError() > 0){
		  exit("false");
		}else{
		   exit("true");
		  }	  
	  }
  }	
	  
  protected function onclickDelete(){
  	require_once("GuiaModelClass.php");
    $Model = new GuiaModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la guia');
	}
  }

	protected function OnClickAnular(){
		require_once("GuiaModelClass.php");
		$Model = new GuiaModel();
		$guia_id =$_REQUEST['guia_id'];
		$Model -> Anular($guia_id,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio un error anulano.');
		}else{
			exit('Se anulo correctamente la guia');
		}
	}
  
  protected function onclickCancellation(){    
     require_once("GuiaModelClass.php");	 
     $Model  = new GuiaModel(); 
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
  }  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("GuiaModelClass.php");
    $Model = new GuiaModel();	
    $Data =  $Model -> selectGuia($this -> getConex());	
    $this -> getArrayJSON($Data);
  }
  
  protected function onclickPrint(){      
    require_once("Imp_GuiaClass.php");	
    $print   = new Imp_Guia($this -> getConex());  	
    $Guia = $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getEmpresaIdentificacion());  
  }
  
    protected function getDataRemitenteDestinatario(){  
    require_once("GuiaModelClass.php");	
	$remitente_destinatario_id = $_REQUEST['remitente_destinatario_id'];
    $Model = new GuiaModel();
	$data  = $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,$this -> getConex());	
	if(is_array($data)){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
	  }      
  }
  
  
  protected function getGuiaComplemento(){  
  	require_once("GuiaModelClass.php");
    $Model = new GuiaModel();	
	$numero_guia = $_REQUEST['numero_guia'];	
    $Data =  $Model -> selectGuiaComplemento($numero_guia,$this -> getConex());		
	if(count($Data) > 0){
      $this -> getArrayJSON($Data);	
	}else{
        print 'false';
	  }  
  }
  
  protected function validaTipoEnvio(){
    require_once("GuiaModelClass.php");
    $Model = new GuiaModel();
	$tipo_envio_id  = $Model -> validaTipoEnvio($this -> getConex());
	print $tipo_envio_id;
  }  
  
  protected function chequear(){  
    require_once("GuiaModelClass.php");	
    $Model = new GuiaModel();
	$data  = $Model -> chequear($this -> getOficinaId(),$this -> getConex());	
	if(is_array($data)){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
	  }      
  }  
  protected function getOptionsTipoEnvio(){
	  
	require_once("GuiaLayoutClass.php");
	require_once("GuiaModelClass.php");	  
	
	$Layout   = new GuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new GuiaModel();	 
	
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
  }  
  
  protected function getOptionsTipoEnvioSelected(){
	  
	require_once("GuiaLayoutClass.php");
	require_once("GuiaModelClass.php");	  
	
	$Layout   = new GuiaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new GuiaModel();	 
	
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
	
  }    
  
//////////
  protected function CalcularTarifa(){  
    require_once("GuiaModelClass.php");	
    $Model  = new GuiaModel();    
	//$tipo_envio_id=$_REQUEST['tipo_envio_id'];
	$tipo_servicio_mensajeria_id=$_REQUEST['tipo_servicio_mensajeria_id'];
	$cliente_id=$_REQUEST['cliente_id'];
	$origen_id=$_REQUEST['origen_id'];
	$destino_id=$_REQUEST['destino_id'];
	$peso=$_REQUEST['peso']/1000;
	
	$peso_volumen=$_REQUEST['peso_volumen'];
	
	if($peso>=$peso_volumen){
		$pesoreal=$peso; 
	}else{
		$pesoreal=$peso_volumen; 
	}

	$peso_adicional=$pesoreal-1;
	$valor=$_REQUEST['valor'];
	$valor_otros=$_REQUEST['valor_otros']>0?$_REQUEST['valor_otros']:'0';
	$total=0;
	
	if($origen_id==$destino_id){ 
		$tipo_envio_id=2;
	}else{
		$tipo_envio_id=$Model -> getTipoEnvio1($destino_id,$this -> getConex());
	}
	if($tipo_envio_id=='' || $tipo_envio_id=='NULL' || $tipo_envio_id==NULL || $tipo_envio_id=='null') exit('El destino no tiene asociado el tipo de envio');
	
	$tabla_esc = $Model -> getTabla($tipo_servicio_mensajeria_id,$this -> getConex());
	
	if($tabla_esc[0]['tabla']=='tarifas_mensajeria'){
		$resultado = $Model -> getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,date('Y'),$this -> getConex(),$this -> getOficinaId());
		if(!count($resultado)>0){
			$resultado = $Model -> getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,date('Y'),$this -> getConex(),$this -> getOficinaId());	
		}
    }else{
		$resultado = $Model -> getCalcularTarifaMasivoCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,date('Y'),$this -> getConex(),$this -> getOficinaId());	
		if(!count($resultado)>0){
			$resultado = $Model -> getCalcularTarifaMasivo($tipo_servicio_mensajeria_id,$tabla_esc[0]['tabla'],$tipo_envio_id,date('Y'),$this -> getConex(),$this -> getOficinaId());	
		}
		
	}
	if(!count($resultado)>0){ exit('No existe Tarifas configuradas, Por favor verifique');	}
	
	$valor_decla=($valor*$resultado[0][porcentaje_seguro])/100;

	//$manejo = $Model -> getCalcularCosto($destino_id,date('Y'),$this -> getConex(),$this -> getOficinaId());
	$manejo = 0;
	if($tabla_esc[0]['tabla']=='tarifas_mensajeria'){

		if($pesoreal<1){
			$valorinicial=$resultado[0]['vr_kg_inicial_min'];
			
		}else{
			$valorinicial=$resultado[0]['vr_kg_inicial_max'];
		}
	
		$valorkilo_adi=$resultado[0]['vr_kg_adicional_min'];
		
		if($pesoreal<1){
			$valor_kilos_adi=0;
		}else{
			$peso_adicional = ceil($peso_adicional);
			$valor_kilos_adi=$valorkilo_adi*$peso_adicional;
		}
		$valorinicial= $valorinicial+$valor_kilos_adi;
		$total=$valor_decla+$valorinicial+$manejo+$valor_otros;
	}else{
		$valorinicial=$resultado[0]['valor_min'];
		$total=$valor_decla+$valorinicial+$manejo+$valor_otros;
	}
	$Data= array(total=>$total,valor_flete=>$valorinicial,valor_declarado=>$valor_decla,valor_manejo=>$manejo,tipo_envio_id=>$tipo_envio_id);
	$this -> getArrayJSON($Data);
	
  }      
  
  protected function setCampos(){
  
////////// FORMULARIO
////////////////////////////////
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
	
		$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		value   => '',
		datatype=>array(
		type	=>'integer'),
		transaction=>array(
		table	=>array('guia'),
		type	=>array('column'))
		);		

	$this -> Campos[tipo_servicio_mensajeria_id] = array(
		name	=>'tipo_servicio_mensajeria_id',
		id	=>'tipo_servicio_mensajeria_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_envio_id] = array(
		name => 'tipo_envio_id',
		id => 'tipo_envio_id',
		type => 'select',
		options	=> array(),
		disabled=>'disabled',
		required => 'yes',		
		datatype => array(type=>'integer'),
		transaction => array(table =>array('guia'), type =>array('column'))
	);	
	
	$this -> Campos[forma_pago_mensajeria_id] = array(
		name	=>'forma_pago_mensajeria_id',
		id	=>'forma_pago_mensajeria_id',
		type	=>'select',
		options	=>array(),
		selected =>2,
		disabled=>'yes',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[estado_mensajeria_id] = array(
		name	=>'estado_mensajeria_id',
		id		=>'estado_mensajeria_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		disabled=>'yes',
		selected=>1,
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	/*
	$this -> Campos[clase_servicio_mensajeria_id] = array(
		name	=>'clase_servicio_mensajeria_id',
		id	=>'clase_servicio_mensajeria_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);*/		
	
	
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
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

	$this -> Campos[numero_guia] = array(
		name	=>'numero_guia',
		id		=>'numero_guia',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum', 
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);

	
	$this -> Campos[solicitud_id] = array(
		name	=>'solicitud_id',
		id	=>'solicitud_id',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id	=>'tipo_identificacion_id',
		type	=>'select',
		options	=>array(),
		//required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

	$this -> Campos[medida_id] = array(
		name	=>'medida_id',
		id	=>'medida_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	

////////// OBSERVACIONES
	$this -> Campos[fecha_entrega] = array(
		name	=>'fecha_entrega',
		id		=>'fecha_entrega',
		type	=>'text',
		required=>'no',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	


////////// REMITENTE
	$this -> Campos[remitente] = array(
		name	=>'remitente',
		id	=>'remitente',
		type	=>'text',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column')),
		suggest=>array(
			name	=>'remitente_disponible',
			vars	=>2,
			setId	=>'remitente_hidden',
			onclick =>'setDataRemitente')
	);
	
	$this -> Campos[remitente_id] = array(
		name    =>'remitente_id',
		id	    =>'remitente_hidden',
		type	=>'hidden',
		//required=>'yes',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[doc_remitente] = array(
		name	=>'doc_remitente',
		id		=>'doc_remitente',
		type	=>'text',
		//required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_remitente_id] = array(
		name	=>'tipo_identificacion_remitente_id',
		id		=>'tipo_identificacion_remitente_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[origen] = array(
		name	 =>'origen',
		id	     =>'origen',
		type	 =>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_hidden',
			vars	=>3,
			onclick =>'setObservaciones')
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_hidden',
		type	=>'hidden',
		required=>'yes',
		value=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[direccion_remitente] = array(
		name	=>'direccion_remitente',
		id		=>'direccion_remitente',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_remitente] = array(
		name	=>'telefono_remitente',
		id		=>'telefono_remitente',
		type	=>'text',
		value	=>'',	
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	// $this -> Campos[correo_remitente] = array(
	// 	name	=>'correo_remitente',
	// 	id		=>'correo_remitente',
	// 	type	=>'text',
	// 	value	=>'',
	// 	datatype=>array(
	// 		type	=>'alpha_upper',
	// 		length	=>'20'),
	// 	transaction=>array(
	// 		table	=>array('guia'),
	// 		type	=>array('column'))		
	// );		

////////// DESTINATARIO	
	$this -> Campos[destinatario] = array(
		name	=>'destinatario',
		id		=>'destinatario',
		type	=>'text',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column')),
		suggest=>array(
			name	=>'destinatario_disponible',
			vars	=>2,
			setId	=>'destinatario_hidden',
			onclick =>'setDataDestinatario')
	);
	
	$this -> Campos[destinatario_id] = array(
		name	=>'destinatario_id',
		id		=>'destinatario_hidden',
		type	=>'hidden',
		//required=>'yes',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[doc_destinatario] = array(
		name	=>'doc_destinatario',
		id		=>'doc_destinatario',
		type	=>'text',
		value	=>'',
		//required =>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'12'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_destinatario_id] = array(
		name	=>'tipo_identificacion_destinatario_id',
		id		=>'tipo_identificacion_destinatario_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			vars	=>3,
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
			table	=>array('guia'),
			type	=>array('column'))
	);		
		
	$this -> Campos[direccion_destinatario] = array(
		name	=>'direccion_destinatario',
		id		=>'direccion_destinatario',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[telefono_destinatario] = array(
		name	=>'telefono_destinatario',
		id		=>'telefono_destinatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))		
	);
	
	// $this -> Campos[correo_destinatario] = array(
	// 	name	=>'correo_destinatario',
	// 	id		=>'correo_destinatario',
	// 	type	=>'text',
	// 	value	=>'',
	// 	datatype=>array(
	// 		type	=>'alpha_upper',
	// 		length	=>'20'),
	// 	transaction=>array(
	// 		table	=>array('guia'),
	// 		type	=>array('column'))		
	// );	

	$this -> Campos[quienrecibe] = array(
		name	=>'quienrecibe',
		id		=>'quienrecibe',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))		
	);	
	
////////// PRODUCTO		
	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		id		=>'cantidad',
		type	=>'text',
		required=>'yes',
		value	=>'',
		size 	=>2,
		datatype=>array(
			type	=>'numeric',
			length	=>'11'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso] = array(
		name	=>'peso',
		id		=>'peso',
		type	=>'text',
		value	=>'',
		size	=>3,
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'4'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		id	=>'peso_volumen',
		type	=>'text',
		value	=>'',
		size 	=>2,
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);


    $this -> Campos[guia_cliente] = array(
		name	=>'guia_cliente',
		id	    =>'guia_cliente',
		type	=>'text',
		value 	=>'',
		size=> 20,
		datatype=>array(
			type	=>'text',
			length 	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);

	$this -> Campos[largo] = array(
		name	=>'largo',
		id		=>'largo',
		type	=>'text',
		value	=>'',
		size 	=>2,
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[ancho] = array(
		name	=>'ancho',
		id		=>'ancho',
		type	=>'text',
		value	=>'',
		size 	=>2,
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[alto] = array(
		name	=>'alto',
		id		=>'alto',
		type	=>'text',
		value	=>'',
		size 	=>2,
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id	    =>'observaciones',
		type	=>'text',
		value 	=>'',
		datatype=>array(
			type	=>'text',
			length 	=>'35'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id	=>'valor',
		type	=>'text',
		size	=>'11',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'14',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
		

////////// PARA IMP. FLETE
	$this -> Campos[valor_flete] = array(
		name	=>'valor_flete',
		id	    =>'valor_flete',
		type	=>'text',
		value	=>'',
		readonly=>'yes',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);			

	$this -> Campos[valor_seguro] = array(
		name	=>'valor_seguro',
		id	    =>'valor_seguro',
		type	=>'text',
		value	=>'',
		readonly=>'yes',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);			

	$this -> Campos[valor_otros] = array(
		name	=>'valor_otros',
		id	    =>'valor_otros',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);			

	$this -> Campos[valor_total] = array(
		name	=>'valor_total',
		id	    =>'valor_total',
		type	=>'text',
		value	=>'',
		readonly=>'yes',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[valor_manejo] = array(
		name	=>'valor_manejo',
		id	    =>'valor_manejo',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', presicion => '0'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[cliente_id] = array(
		name	 => 'cliente_id',
		id	 => 'cliente_id',
		type	 => 'select',
		required => 'yes',
		options  => array(),
		datatype => array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
		
	);

////////////////////////////////


	
/*	$this -> Campos[numero_guia_padre] = array(
		name	=>'numero_guia_padre',
		id	    =>'numero_guia_padre',
		type	=>'text',
        value   =>'',
		size    =>'10',
		disabled => 'true',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);		*/	
	
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		id		=>'descripcion_producto',
		required=>'yes',
		type=>'text',
		size=> 19,
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	// $this -> Campos[referencia_producto] = array(
	// 	name	=>'referencia_producto',
	// 	id		=>'referencia_producto',
	// 	type	=>'hidden',
	// 	required=>'yes',
	// 	datatype=>array(type=>'text'),
	// 	transaction=>array(
	// 		table	=>array('guia'),
	// 		type	=>array('column'))
	// );	

////////// FIN PARA IMPRESION DE FLETE
	$this -> Campos[guias] = array(
		name	=>'guias',
		id		=>'guias',
		type	=>'text'
	);

	$this -> Campos[rango_desde] = array(
		name	=>'rango_desde',
		id		=>'rango_desde',
		type	=>'text',
		size	=>15,		
		// options	=> array(),
		datatype=>array(type =>'integer')
	);
	
	$this -> Campos[rango_hasta] = array(
		name	=>'rango_hasta',
		id		=>'rango_hasta',
		type	=>'text',
		size	=>15,
		// options	=> array(),
		datatype=>array(type =>'integer')
	);	

	$this -> Campos[orden_servicio] = array(
		name	=>'orden_servicio',
		id		=>'orden_servicio',
		type	=>'text',
		size	=>15,
		//options	=> array(),
		datatype=>array(type =>'integer')
	);	

	$this -> Campos[fecha_guia_crea] = array(
		name	=>'fecha_guia_crea',
		id		=>'fecha_guia_crea',
		type	=>'text',
		size	=>15,
		//options	=> array(),
		datatype=>array(type =>'date')
	);	
	
	$this -> Campos[cartaporte] = array(
		name	=>'cartaporte',
		id		=>'cartaporte',
		type	=>'select',
		options	=> array(
					array(value => '1', text => 'SI', selected => '0'),
					array(value => '0', text => 'NO')),
		datatype=>array(type =>'integer')
	);	

	$this -> Campos[formato] = array(
		name	=>'formato',
		id		=>'formato',
		type	=>'select',
		options	=> array(
					array(value => 'SI', text => 'Impresion Guia', selected => 'SI'),
					array(value => 'NO', text => 'Impresion Masivo', selected => 'SI'),
					array(value => 'MT', text => 'Impresion Min Tic', selected => 'SI'),
					array(value => 'RT', text => 'Impresion Rotulos', selected => 'SI'),
					array(value => 'IS', text => 'Impresion Sencilla', selected => 'SI')),
		datatype=>array(type =>'integer')
	);			

	$this -> Campos[foto_guia] = array(
    name  =>'foto_guia',
    id    =>'foto_guia',
    type  =>'file',
	path	=>'/velotax/imagenes/transporte/guia/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('guia'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'guia',
			text	=>'_foto_guia'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );	

	$this -> Campos[foto_cumplido] = array(
    name  =>'foto_cumplido',
    id    =>'foto_cumplido',
    type  =>'file',
	path	=>'/velotax/imagenes/transporte/guia/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('guia'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'guia',
			text	=>'_foto_cumplido'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );	

   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		placeholder=>'ESCRIBA EL CONSECUTIVO DE LA GUIA',								
		value	=>'',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_guian',
			setId	=>'guia_id',
			onclick	=>'setDataFormWithResponse')
	);

//////////ANULACION	
	$this -> Campos[causal_anulacion_id] = array(
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
	);
	
//////////BOTONES
	/*$this -> Campos[importSolcitud] = array(
		name	=>'importSolcitud',
		id		=>'importSolcitud',
		type	=>'button',
		value	=>'Importar Solicitud'
	);*/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled'
	);
	
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		disabled=>'true',
		onclick =>'divAnular()'
	);

   	$this -> Campos[anula] = array(
		name	=>'anula',
		id		=>'anula',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation()'
	);	
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'GuiaOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'GuiaOnReset()'
	);	
	
   	$this -> Campos[imprimir] = array(
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
	);
	
   	$this -> Campos[print_out] = array(
		name	   =>'print_out',
		id		   =>'print_out',
		type	   =>'button',
		value	   =>'OK'
	);	
	
   	$this -> Campos[print_cancel] = array(
		name	   =>'print_cancel',
		id		   =>'print_cancel',
		type	   =>'button',
		value	   =>'CANCEL'
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
}

$guia = new Guia();

?>