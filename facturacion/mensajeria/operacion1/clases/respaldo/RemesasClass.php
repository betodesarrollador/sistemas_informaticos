<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Remesas extends Controler{

  public function __construct(){
   	parent::__construct(3);    
  }

  public function Main(){
    
    $this -> noCache();
    
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout   = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new RemesasModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar    ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar     ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular     ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));		
    $Layout -> setLimpiar    ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir   ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout ->  setProductos	   ($Model -> getProductos    ($this -> getConex()));
    $Layout -> 	setRangoDesde      ($Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()));
    $Layout -> 	setRangoHasta      ($Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()));
    $Layout ->  setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));	
	
///////////////////////

    $Layout ->  SetTipoServicio		  	($Model -> GetTipoServicio      ($this -> getConex()));
    $Layout ->  SetTipoEnvio  		  	($Model -> GetTipoEnvio         ($this -> getConex()));
    $Layout ->  SetFormaPago  		  	($Model -> GetFormaPago         ($this -> getConex()));	
    $Layout ->  SetClaseServicio      	($Model -> GetClaseServicio     ($this -> getConex()));
    $Layout ->  SetEstadoMensajeria   	($Model -> GetEstadoMensajeria  ($this -> getConex()));
    $Layout ->  SetMotivoDevolucion   	($Model -> GetMotivoDevolucion  ($this -> getConex()));
    $Layout ->  SetTipoIdentificacion   ($Model -> GetTipoIdentificacion  ($this -> getConex()));

///////////////////////
    	
	//// GRID ////
	$Attributes = array(
	  id		=>'RemesasOficinas',
	  title		=>'Listado de Guias',
	  sortname	=>'numero_remesa',
	  sortorder =>'DESC',
	  rowId		=>'guia_id',
	  width		=>'auto',
	  height	=>'250',
	  rowList	=>'10,20,30,40,60,80,160,320,640',
	  rowNum	=>'10'
	  
	);
	
	$Cols = array(

	  array(name=>'planilla',		       index=>'planilla',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'), 	
	  array(name=>'placa',		           index=>'placa',	                sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  
	  array(name=>'conductor',		       index=>'conductor',	            sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  	  
	  array(name=>'fecha_planilla',		   index=>'fecha_planilla',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  	  
	  array(name=>'numero_guia',		   index=>'numero_guia',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      
	  array(name=>'fecha_guia',		   index=>'fecha_guia',	        sorttype=>'text',	width=>'80',	align=>'center' , format => 'none'),      	  
	  array(name=>'cliente',			   index=>'cliente',		        sorttype=>'text',	width=>'200',	align=>'center' , format => 'none'),	
	  array(name=>'origen',				   index=>'origen',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'remitente',		       index=>'remitente',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'), 
	  array(name=>'destino',			   index=>'destino',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'destinatario',	       index=>'destinatario',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),  
	  array(name=>'orden_despacho'        ,index=>'orden_despacho',	        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'referencia_producto'   ,index=>'referencia_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'cantidad',		       index=>'cantidad',		        sorttype=>'text',	width=>'100',	align=>'center' ),
	  array(name=>'codigo',				   index=>'codigo',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'descripcion_producto',  index=>'descripcion_producto',	sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'naturaleza',			   index=>'naturaleza',		        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'empaque',			   index=>'empaque',			    sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'medida',				   index=>'medida',			        sorttype=>'text',	width=>'100',	align=>'center' , format => 'none'),
	  array(name=>'peso_volumen',	       index=>'tipo_remesa',		    sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'peso',		           index=>'peso',		            sorttype=>'text',	width=>'100',	align=>'center' ) 	  
	);
			
    $Titles = array(
	    'PLANILLA',
		'PLACA',
		'CONDCUTOR',
		'FECHA PLANILLA',
		'GUIA',
		'FECHA GUIA',
		'CLIENTE',					
		'ORIGEN',
		'REMITENTE',
		'DESTINO',
		'DESTINATARIO',
		'ORDEN DESPACHO',
		'REFERENCIA',				
		'CANTIDAD',		
		'COD PRODUCTO',
		'DESCR PRODUCTO',
		'NATURALEZA',
		'EMPAQUE',
		'MEDIDA',
		'PESO VOLUMEN',
		'PESO NETO'
	);
		
	$Layout -> SetGridRemesasOficinas($Attributes,$Titles,$Cols,$Model -> getQueryRemesasOficinasGrid($this -> getOficinaId()),$SubAttributes,$SubTitles,$SubCols,null);	
	$Layout -> RenderMain();    
  }
  
  protected function setContactos(){

    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");
	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();
	
    $contacto_id = $_REQUEST['contacto_id'];
    $contactos   = $Model -> getContactos($contacto_id,$this -> getConex());
	
    if(!count($contactos) > 0){
	  $contactos = array();
	}

    $field = array(
	  name	 =>'contacto_id',
	  id	 =>'contacto_id',
	  type	 =>'select',
	  options  => $contactos,		
	  datatype => array(
		type	=>'integer'
	  ),
	  transaction=>array(
		table	=>array('guia'),
		type	=>array('column'))
   );
	  
	print $Layout -> getObjectHtml($field);
  }
  
  protected function selectedContactos(){
	require_once("RemesasModelClass.php");
    $Model     = new RemesasModel();	
	$return = $Model -> SelectContactosRemesa($this -> getConex());	
	if(count($return) > 0){
	  $this -> getArrayJSON($return);
	}else{
	    exit('false');
	  }
  }
  
  protected function updateRangoDesde(){  
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();    
	$field[rango_desde] = array(
		name	=>'rango_desde',
		id		=>'rango_desde',
		type	=>'select',
		options	=> $Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()),
		datatype=>array(type =>'integer')
	); 			
	print $Layout -> getObjectHtml($field[rango_desde]);	  
  }  
  
  protected function updateRangoHasta(){  
    require_once("RemesasLayoutClass.php");
    require_once("RemesasModelClass.php");	
    $Layout = new RemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new RemesasModel();    
	$field[rango_hasta] = array(
		name	=>'rango_hasta',
		id		=>'rango_hasta',
		type	=>'select',
		options	=> $Model -> getRemesasNumero($this -> getConex(),$this -> getOficinaId()),
		datatype=>array(type =>'integer')
	); 			
	print $Layout -> getObjectHtml($field[rango_hasta]);  
  }  

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"remesa",$this ->Campos);
    print $Data  -> GetData();
  }

  protected function onclickSave(){    
    require_once("RemesasModelClass.php");
    $Model = new RemesasModel();		
    $valor             = $_REQUEST['valor'];
    $valorMaximoPoliza = $Model -> validaValorMaximoPoliza($this -> getEmpresaId(),$valor,$this -> getConex());	
    if($valorMaximoPoliza == null){    
      print 'No existe una poliza activa para la empresa<br>No se permite remesar !!!';    
    }else{    
      //if($valorMaximoPoliza > $valor){
	$result = $Model -> Save($this -> Campos,$this -> getOficinaId(),$this -> getConex());	    
	if($Model -> GetNumError() > 0){
	  exit('false');
	}else{
	  print $result;
	    }	     
     }	
  }

  protected function onclickUpdate(){  
    require_once("RemesasModelClass.php");
	$Model = new RemesasModel();	
	$numero_remesa = $_REQUEST['numero_remesa'];
	$clase_remesa  = $_REQUEST['clase_remesa'];	
	if($clase_remesa == 'CP' && $Model -> esRemesaPrincipal($numero_remesa,$this -> getConex())){	
	  print "<p align='center'>Esta remesa es principal para otros complemento ingresados<br>No se puede marcar como remesa de complemento!!!</p>";	
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
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la remesa');
	}
  }
  
  protected function onclickCancellation(){
    
     require_once("RemesasModelClass.php");
	 
     $Model                 = new RemesasModel(); 
	 $remesa_id             = $this -> requestDataForQuery('remesa_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($remesa_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }
	
  }  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();
	
    $Data =  $Model -> selectRemesa($this -> getConex());
	
    $this -> getArrayJSON($Data);
  }
  
  protected function onclickPrint(){      
    require_once("Imp_RemesaClass.php");	
    $print   = new Imp_Remesa($this -> getConex());  	
    $Remesas = $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getOficinaId(),$this -> getEmpresaIdentificacion());  
  }
  
  protected function getDataClienteRemitente(){            
  	require_once("RemesasModelClass.php");	
        $Model      = new RemesasModel();
	$cliente_id = $_REQUEST['cliente_id'];	
	$data       = $Model -> selectDataClienteRemitente($cliente_id,$this -> getConex());	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{	
	    if(count($data) > 0){
	      $this -> getArrayJSON($data);
		}else{
		    print 'false';
		  }
	 }  
  } 
  
    protected function getDataRemitenteDestinatario(){  
    require_once("DetalleSolicitudServiciosModelClass.php");	
	$remitente_destinatario_id = $_REQUEST['remitente_destinatario_id'];
    $Model = new DetalleSolicitudServiciosModel();
	$data  = $Model -> selectDataRemitenteDestinatario($remitente_destinatario_id,$this -> getConex());	
	if(is_array($data)){
	  $this -> getArrayJSON($data);
	}else{
	    print 'false';
	  }      
  }
  
  protected function getDataPropietario(){  
  	require_once("RemesasModelClass.php");	
    $Model      = new RemesasModel();
	$tercero_id = $_REQUEST['tercero_id'];	
	$data       = $Model -> selectDataPropietario($tercero_id,$this -> getConex());	
	$this -> getArrayJSON($data);  
  }
  
  protected function getDataClientePropietario(){  
  	require_once("RemesasModelClass.php");	
    $Model      = new RemesasModel();
	$cliente_id = $_REQUEST['cliente_id'];	
	$data       = $Model -> selectDataPropietarioCliente($cliente_id,$this -> getConex());	
	$this -> getArrayJSON($data);     
  }
  
  protected function getRemesaComplemento(){  
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();	
	$numero_remesa = $_REQUEST['numero_remesa'];	
    $Data =  $Model -> selectRemesaComplemento($numero_remesa,$this -> getConex());		
	if(count($Data) > 0){
      $this -> getArrayJSON($Data);	
	}else{
        print 'false';
	  }  
  }
  
  protected function reloadListProductos(){  
  	require_once("RemesasModelClass.php");
    $Model = new RemesasModel();		
	$opciones = $Model -> getProductos($this -> getConex()); 		
	$this -> getArrayJSON($opciones);  
  }
  
  protected function setCampos(){
  
//FORMULARIO
////////////////////////////////
//// INFORMACION GENERAL
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
		name	=>'tipo_envio_id',
		id	=>'tipo_envio_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[forma_pago_mensajeria_id] = array(
		name	=>'forma_pago_mensajeria_id',
		id	=>'forma_pago_mensajeria_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
	$this -> Campos[estado_mensajeria_id] = array(
		name	=>'estado_mensajeria_id',
		id	=>'estado_mensajeria_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
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
	);		
	
	$this -> Campos[motivo_devolucion_id] = array(
		name	=>'motivo_devolucion_id',
		id		=>'motivo_devolucion_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
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

	$this -> Campos[planilla] = array(
		name	=>'planilla',
		id	    =>'planilla',
		type	=>'select',
		options	=>array(array(value => '1', text => 'SI'),array(value => '0', text => 'NO')),
		selected=>1,
		required=>'yes',
		datatype=>array(type=>'integer'),
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
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	
	
//// OBSERVACIONES
	$this -> Campos[fecha_entrega] = array(
		name	=>'fecha_entrega',
		id		=>'fecha_entrega',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

    $this -> Campos[observaciones2] = array(
		name	=>'observaciones2',
		id	    =>'observaciones2',
		type	=>'textarea',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

//// REMITENTE
	$this -> Campos[remitente] = array(
		name	=>'remitente',
		id	=>'remitente',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column')),
		suggest=>array(
			name	=>'remitente_disponible',
			setId	=>'remitente_hidden',
			onclick =>'setDataRemitente')
	);
	
	$this -> Campos[remitente_id] = array(
		name    =>'remitente_id',
		id	    =>'remitente_hidden',
		type	=>'hidden',
		required=>'yes',
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
		required=>'yes',
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
			table	=>array('remesa'),
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
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[correo_remitente] = array(
		name	=>'correo_remitente',
		id		=>'correo_remitente',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))		
	);		

//// DESTINATARIO	
	$this -> Campos[destinatario] = array(
		name	=>'destinatario',
		id		=>'destinatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column')),
		suggest=>array(
			name	=>'destinatario_disponible',
			setId	=>'destinatario_hidden',
			onclick =>'setDataDestinatario')
	);
	
	$this -> Campos[destinatario_id] = array(
		name	=>'destinatario_id',
		id		=>'destinatario_hidden',
		type	=>'hidden',
		required=>'yes',
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
		required =>'yes',
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
			name	=>'ubicacion',
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
	
	$this -> Campos[correo_destinatario] = array(
		name	=>'correo_destinatario',
		id		=>'correo_destinatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))		
	);	

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
	
//// PRODUCTO		
	$this -> Campos[cantidad] = array(
		name	=>'cantidad',
		id		=>'cantidad',
		type	=>'text',
		required=>'yes',
		value	=>'',
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
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[peso_volumen] = array(
		name	=>'peso_volumen',
		id	=>'peso_volumen',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'numeric',
			length	=>'12',
			precision=>'2'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

	$this -> Campos[largo] = array(
		name	=>'largo',
		id		=>'largo',
		type	=>'text',
		value	=>'',
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
		type	=>'textarea',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('guia'),
			type	=>array('column'))
	);	

//// PARA IMP. FLETE
	$this -> Campos[valor_flete] = array(
		name	=>'valor_flete',
		id	    =>'valor_flete',
		type	=>'text',
		value	=>'',
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
////////////////////////////////

/*    $this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		size     =>'35',
		suggest=>array(
			name	=>'cliente_disponible',
			setId	=>'cliente_hidden',
			onclick =>'getDataClienteRemitente'
			)
	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id	=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);*/
	
/*	$this -> Campos[numero_remesa_padre] = array(
		name	=>'numero_remesa_padre',
		id	    =>'numero_remesa_padre',
		type	=>'text',
        value   =>'',
		size    =>'10',
		disabled => 'true',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);		*/	
	
	$this -> Campos[contacto_id] = array(
		name	 =>'contacto_id',
		id	 =>'contacto_id',
		type	 =>'select',
		options  => array(),		
		datatype => array(
			type	=>'integer'
		 ),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id	    =>'producto_id',
		type	=>'select',
		required=>'yes',
		options =>array(),
		datatype=>array(type =>'integer'),
		onchange   =>'separaCodigoDescripcion()',
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	$this -> Campos[descripcion_producto] = array(
		name	=>'descripcion_producto',
		id		=>'descripcion_producto',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[peso_volumen_detalle] = array(
		name	=>'peso_volumen_detalle',
		id		=>'peso_volumen_detalle',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'numeric', precision=>'3')
	);		
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id	=>'valor',
		type	=>'text',
		size	=>'20',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'18',
			precision=>'2'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);

	
	
	//fin para impresion flete
	$this -> Campos[rango_desde] = array(
		name	=>'rango_desde',
		id		=>'rango_desde',
		type	=>'select',
		options	=> array(),
		datatype=>array(type =>'integer')
	);
	
	$this -> Campos[rango_hasta] = array(
		name	=>'rango_hasta',
		id		=>'rango_hasta',
		type	=>'select',
		options	=> array(),
		datatype=>array(type =>'integer')
	);	
		
	$this -> Campos[formato] = array(
		name	=>'formato',
		id		=>'formato',
		type	=>'select',
		options	=> array(array(value => 'SI', text => 'SI', selected => 'SI'),array(value => 'NO', text => 'NO', selected => 'SI')),
		datatype=>array(type =>'integer')
	);			
				
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		value	=>'',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_remesa_paqueteo',
			setId	=>'remesa_id',
			onclick	=>'setDataFormWithResponse')
	);
  
    $this -> Campos[hoja_de_tiempos_id] = array(
		name	=>'hoja_de_tiempos_id',
		id	    =>'hoja_de_tiempos_id',
		type	=>'hidden',
		datatype=>array(type =>'autoincrement'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('primary_key'))
	);
	
    $this -> Campos[horas_pactadas_cargue] = array(
		name	=>'horas_pactadas_cargue',
		id	    =>'horas_pactadas_cargue',
		type	=>'text',
		value   => '12',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
    $this -> Campos[fecha_llegada_lugar_cargue] = array(
		name	=>'fecha_llegada_lugar_cargue',
		id	    =>'fecha_llegada_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);
	
    $this -> Campos[hora_llegada_lugar_cargue] = array(
		name	=>'hora_llegada_lugar_cargue',
		id	    =>'hora_llegada_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[fecha_salida_lugar_cargue] = array(
		name	=>'fecha_salida_lugar_cargue',
		id	    =>'fecha_salida_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[hora_salida_lugar_cargue] = array(
		name	=>'hora_salida_lugar_cargue',
		id	    =>'hora_salida_lugar_cargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
			
    $this -> Campos[conductor_cargue] = array(
		name	 =>'conductor_cargue',
		id	     =>'conductor_cargue',
		type	 =>'text',
		size     =>'35',		
		datatype=>array( type =>'text'),
		suggest=>array(
			name	=>'conductor_disponible',
			setId	=>'conductor_cargue_hidden'
			)
		
	);		
	
    $this -> Campos[conductor_cargue_id] = array(
		name	=>'conductor_cargue_id',
		id	    =>'conductor_cargue_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);				

    $this -> Campos[entrega] = array(
		name	=>'entrega',
		id	    =>'entrega',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);				
  
    $this -> Campos[cedula_entrega] = array(
		name	=>'cedula_entrega',
		id	    =>'cedula_entrega',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);				  
  
    $this -> Campos[horas_pactadas_descargue] = array(
		name	=>'horas_pactadas_descargue',
		id	    =>'horas_pactadas_descargue',
		type	=>'text',
		value   => '12',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);
	
    $this -> Campos[fecha_llegada_lugar_descargue] = array(
		name	=>'fecha_llegada_lugar_descargue',
		id	    =>'fecha_llegada_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
    $this -> Campos[hora_llegada_lugar_descargue] = array(
		name	=>'hora_llegada_lugar_descargue',
		id	    =>'hora_llegada_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
    $this -> Campos[fecha_salida_lugar_descargue] = array(
		name	=>'fecha_salida_lugar_descargue',
		id	    =>'fecha_salida_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);
	
    $this -> Campos[hora_salida_lugar_descargue] = array(
		name	=>'hora_salida_lugar_descargue',
		id	    =>'hora_salida_lugar_descargue',
		type	=>'text',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	
	
	
    $this -> Campos[conductor_descargue] = array(
		name	 =>'conductor_descargue',
		id	     =>'conductor_descargue',
		type	 =>'text',
		size     =>'35',		
		datatype=>array( type =>'text'),
		suggest=>array(
			name	=>'conductor_disponible',
			setId	=>'conductor_descargue_hidden'
			)
		
	);		
	
    $this -> Campos[conductor_descargue_id] = array(
		name	=>'conductor_descargue_id',
		id	    =>'conductor_descargue_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
    $this -> Campos[recibe] = array(
		name	=>'recibe',
		id	    =>'recibe',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);	

	
    $this -> Campos[cedula_recibe] = array(
		name	=>'cedula_recibe',
		id	    =>'cedula_recibe',
		type	=>'text',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('hoja_de_tiempos'),
			type	=>array('column'))
	);		
	
   /* $this -> Campos[estado] = array(
    name    =>'estado',
    id      =>'estado',
    type    =>'select',
	disabled => 'no',
	options =>array(array(value => 'RE', text => 'RECIBIDO', selected => 'RE'),array(value => 'BO', text => 'BODEGA ORIGEN', selected => 'RE'), 
	array(value => 'BD', text => 'BOFEGA DESTINO' , selected => 'RE'), array(value=>'TR',text=>'TRANSITO',selected=>'RE'),
	array(value => 'ZO', text => 'ZONIFICACION', selected => 'RE'),array(value => 'EN', text => 'ENTREGADO', selected => 'RE'),
	array(value => 'DV', text => 'DEVUELTO', selected => 'RE'),array(value => 'AN', text => 'ANULADO', selected => 'RE')),
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('remesa'),
    type=>array('column'))
    );	*/	
	
		$this -> Campos[estado] = array(
		name	=>'estado',
		id	    =>'estado',
		type	=>'select',
		options =>array(array(value => 'RE', text => 'RECIBIDO'),array(value => 'BO', text => 'BODEGA ORIGEN'), 
	array(value => 'BD', text => 'BODEGA DESTINO'), array(value=>'TR',text=>'TRANSITO'),
	array(value => 'DI', text => 'DISTRIBUCION'),array(value => 'ZO', text => 'ZONIFICACION'),array(value => 'EN', text => 'ENTREGADO'),
	array(value => 'DV', text => 'DEVUELTO'),array(value => 'AN', text => 'ANULADO')),
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('remesa'),
			type	=>array('column'))
	);	
	
	
		//ANULACION
	
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
	
	//BOTONES


	$this -> Campos[importSolcitud] = array(
		name	=>'importSolcitud',
		id		=>'importSolcitud',
		type	=>'button',
		value	=>'Importar Solicitud'
	);	
	
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
		onclick =>'onclickCancellation(this.form)'
	);	
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'RemesasOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'RemesasOnReset()'
	);
	
	
   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	    displayoptions => array(
                  form        => 0,
                  beforeprint => 'beforePrint',
		  title       => 'Impresion Remesas Carga',
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

$remesas = new Remesas();

?>