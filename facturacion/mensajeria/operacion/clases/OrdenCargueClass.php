<?php

require_once("../../../framework/clases/ControlerClass.php");

final class OrdenCargue extends Controler{

  public function __construct(){
    parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("OrdenCargueLayoutClass.php");
    require_once("OrdenCargueModelClass.php");

    $Layout   = new OrdenCargueLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new OrdenCargueModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);

//LISTA MENU

    $Layout -> SetTiposServicio($Model -> GetTiposServicio($this -> getConex()));
    $Layout -> SetUnidadesVolumen($Model -> getUnidadesVolumen($this -> getConex()));
    $Layout -> SetUnidades($Model -> getUnidades($this -> getConex()));

	//// GRID ////
	$Attributes = array(
	  id=>'OrdenCargue',
	  title=>'Ordenes de Cargue',
	  sortname=>'consecutivo',
	  width=>'auto',
	  height=>'250'
	);
	
	$Cols = array(
	  array(name=>'consecutivo',		index=>'consecutivo',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'solicitud_id',		index=>'solicitud_id',		sorttype=>'text',	width=>'80',	align=>'center'),  
	  array(name=>'fecha',				index=>'fecha',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'cliente',			index=>'cliente',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'contacto',			index=>'contacto',			sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'direccion_cargue',	index=>'direccion_cargue',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'tipo_servicio',		index=>'tipo_servicio',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'origen',				index=>'origen',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',			index=>'destino',			sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'producto',			index=>'producto',			sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'cantidad_cargue',	index=>'cantidad_cargue',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'peso',				index=>'peso',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'unidad_peso',		index=>'unidad_peso',		sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'peso_volumen',		index=>'peso_volumen',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'unidad_volumen',		index=>'unidad_volumen',	sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'placa',				index=>'placa',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tenedor',			index=>'tenedor',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'propietario',		index=>'propietario',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'usuario',			index=>'usuario',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'oficina',			index=>'oficina',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'fecha_ingreso',		index=>'fecha_ingreso',		sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'estado',				index=>'estado',			sorttype=>'text',	width=>'50',	align=>'center')
	);

    $Titles = array('ORDEN CARGUE No','SOLICITUD','FECHA','CLIENTE','CONTACTO','DIRECCION','TIPO SERVICIO','ORIGEN','DESTINO',
                    'PRODUCTO','CANTIDAD','PESO','UNIDAD PESO','VOLUMEN','UNIDAD VOLUMEN','PLACA','TENEDOR','PROPIETARIO','CONDUCTOR','USUARIO','OFICINA','FECHA INGRESO','ESTADO');

    $Layout -> SetGridOrdenCargue($Attributes,$Titles,$Cols,$Model -> getQueryOrdenCargueGrid($this -> getOficinaId()));

    $Layout -> RenderMain();
    
  }


  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"orden_cargue",$this ->Campos);
    print json_encode($Data  -> GetData());
  }

  protected function onclickSave(){
    
    require_once("OrdenCargueModelClass.php");
	
    $Model  = new OrdenCargueModel();
    $result = $Model -> Save($this -> getOficinaId(),$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
       print json_encode($result);
     }
	 
  }

  protected function onclickUpdate(){
    
    require_once("OrdenCargueModelClass.php");
    $Model = new OrdenCargueModel();

    $Model -> Update($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
      }
  
  }
  


//BUSQUEDA
  protected function onclickFind(){
  
    require_once("OrdenCargueModelClass.php");
    $Model = new OrdenCargueModel();

    $orden_cargue_id = $_REQUEST['orden_cargue_id'];

    $Data =  $Model -> selectorden_cargue($orden_cargue_id,$this -> getConex());

    print json_encode($Data);

  }

  
  protected function onclickPrint(){
  
    require_once("Imp_OrdenCargueClass.php");

    $print = new Imp_OrdenCargue($this -> getConex());

    $print -> printOut();
  
  }
  
  protected function onclickCancellation(){
  
  	require_once("OrdenCargueModelClass.php");
    $Model = new OrdenCargueModel();
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }
  
  protected function setDataVehiculo(){
  
    require_once("OrdenCargueModelClass.php");
    $Model = new OrdenCargueModel();
  
    $placa_id = $_REQUEST['placa_id'];
    $data     = $Model -> selectVehiculo($placa_id,$this -> getConex());

    print json_encode($data);
  
  }
  
  protected function setDataConductor(){
  
    require_once("OrdenCargueModelClass.php");
	
    $Model        = new OrdenCargueModel();  
    $conductor_id = $_REQUEST['conductor_id'];
    $data         = $Model -> selectConductor($conductor_id,$this -> getConex()); 

    print json_encode($data); 
  
  }
  
  protected function setDataTitular(){
  
    require_once("OrdenCargueModelClass.php");
	
    $Model       = new OrdenCargueModel();  
    $tenedor_id  = $_REQUEST['tenedor_id'];
    $data        = $Model -> selectDataTitular($tenedor_id,$this -> getConex()); 

    print json_encode($data); 
  
  
  }
  
  protected function setDataCliente(){

    require_once("OrdenCargueModelClass.php");
    $Model = new OrdenCargueModel();    
    $cliente_id = $_REQUEST['cliente_id'];
    $data = $Model -> getDataCliente($cliente_id,$this -> getConex());
    print json_encode($data);

  }

  protected function SetDataSolicitud(){

    require_once("OrdenCargueModelClass.php");
    $Model = new OrdenCargueModel();    
    $detalle_ss_id = $_REQUEST['detalle_ss_id'];
    $data = $Model -> getDataSolicitud($detalle_ss_id,$this -> getConex());
    print json_encode($data);

  }

  protected function setContactos(){

	require_once("OrdenCargueLayoutClass.php");
	require_once("OrdenCargueModelClass.php");
	
	$Layout = new OrdenCargueLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new OrdenCargueModel();
		
	$cliente_id   = $_REQUEST['cliente_id'];
	$orden_cargue_id = $_REQUEST['orden_cargue_id'];
	
	$contactos  = $Model -> getContactos($cliente_id,$orden_cargue_id,$this -> getConex());
		
    if(!count($contactos) > 0){
	  $contactos = array();
	}
	
        $field = 	array(
		name	 =>'contacto_id',
		id		 =>'contacto_id',
		type	 =>'select',
		options  => $contactos,		
		selected =>'NULL',
		datatype => array(
			type	=>'alphanum'
		 ),
		transaction=>array(
			table	=>array('orden_cargue'),
			type	=>array('column'))		 
	 );	
	 
	 print $Layout -> getObjectHtml($field);

  }
  

  

  protected function setCampos(){
      
    //FORMULARIO
    $this -> Campos[orden_cargue_id] = array(
    name=>'orden_cargue_id',
    id=>'orden_cargue_id',
    type=>'hidden',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('primary_key'))
    );

    $this -> Campos[consecutivo] = array(
    name=>'consecutivo',
    id=>'consecutivo',
    type=>'text',
	readonly=>'yes',
    datatype=>array(
    type=>'integer',
    length=>'11'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[detalle_ss_id] = array(
    name=>'detalle_ss_id',
    id=>'detalle_ss_id',
    type=>'hidden',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );

    $this -> Campos[detalle_solicitud] = array(
    name=>'detalle_solicitud',
    id=>'detalle_solicitud',
    type=>'text',
    datatype=>array(
    type=>'text',
    length=>'250'),
    suggest=>array(
		name=>'busca_solicitud_servicio_producto',
		setId=>'detalle_ss_id',
		onclick=>'SetDataSolicitud'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );

    $this -> Campos[estado] = array(
    name=>'estado',
    id=>'estado',
    type=>'hidden',
    datatype=>array(
    type=>'text',
    length=>'1'),
	value=>'E',
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );

    $this -> Campos[fecha] = array(
    name=>'fecha',
    id=>'fecha',
    type=>'text',
	required=>'yes',
    datatype=>array(
		type=>'date',
		length=>'10'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );


    $this -> Campos[oficina_id_static] = array(
    name=>'oficina_id_static',
    id=>'oficina_id_static',
    type=>'hidden',
    value   => $this -> getOficinaId(),
    datatype=>array(
    type=>'integer')
    );

    $this -> Campos[usuario_id_static] = array(
    name=>'usuario_id_static',
    id=>'usuario_id_static',
    type=>'hidden',
    value   => $this -> getUsuarioId(),
    datatype=>array(
    type=>'integer')
    );

    $this -> Campos[fecha_ingreso_static] = array(
    name=>'fecha_ingreso_static',
    id=>'fecha_ingreso_static',
    type=>'hidden',
    value   => date('Y-m-d H:i:s'),
    datatype=>array(
    type=>'text')
    );

    $this -> Campos[fecha_ingreso] = array(
    name=>'fecha_ingreso',
    id=>'fecha_ingreso',
    type=>'hidden',
    value   => date('Y-m-d H:i:s'),
    datatype=>array(
    type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
	
    );


    $this -> Campos[usuario_id] = array(
    name=>'usuario_id',
    id=>'usuario_id',
    type=>'hidden',
    value   => $this -> getUsuarioId(),
    datatype=>array(
    type=>'integer'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    ); 

    $this -> Campos[oficina_id] = array(
    name=>'oficina_id',
    id=>'oficina_id',
    type=>'hidden',
    value   => $this -> getOficinaId(),
    datatype=>array(
    type=>'integer'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    ); 

    $this -> Campos[cliente] = array(
    name=>'cliente',
    id=>'cliente',
    type=>'text',
    suggest=>array(
		name=>'cliente_disponible',
		setId=>'cliente_hidden',
		onclick => 'setDataCliente'),
    datatype=>array(
	    type=>'text',
		length=>250),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
	
    ); 

    $this -> Campos[cliente_id] = array(
    name=>'cliente_id',
    id=>'cliente_hidden',
    type=>'hidden',
	required=>'yes',
    datatype=>array(
	    type=>'integer',
		length=>250),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
	
    ); 

    $this -> Campos[cliente_nit] = array(
    name=>'cliente_nit',
    id=>'cliente_nit',
    type=>'text',
	readonly=>'yes',
    datatype=>array(
	    type=>'text',
		length=>100),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
	
    ); 

    $this -> Campos[cliente_tel] = array(
    name	=>'cliente_tel',
    id		=>'cliente_tel',
    type	=>'text',
	readonly=>'yes',
    datatype=>array(
	    type=>'text',
		length=>20),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
	
    ); 

    $this -> Campos[direccion_cargue] = array(
    name	=>'direccion_cargue',
    id		=>'direccion_cargue',
    type	=>'text',
	required=>'yes',
    datatype=>array(
	    type=>'text',
		length=>20),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
	
    ); 

    $this -> Campos[contacto_id] = array(
    name=>'contacto_id',
    id=>'contacto_id',
    type=>'select',
    options=>array(),
    datatype=>array(
		type=>'integer',
		length=>'11'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );


    $this -> Campos[tipo_servicio_id] = array(
    name=>'tipo_servicio_id',
    id=>'tipo_servicio_id',
    type=>'select',
    required=>'yes',
    options=>array(),
    datatype=>array(
		type=>'integer',
		length=>'11'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );

	$this -> Campos[hora] = array(
		name	=>'hora',
		id		=>'hora',
		type	=>'text',
		value	=>'',
		size	=>'2',
		required=>'yes',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('orden_cargue'),
			type	=>array('column'))
	);


    $this -> Campos[origen] = array(
    name=>'origen',
    id=>'origen',
    type=>'text',
	size=>16,
    suggest=>array(
    name=>'ciudad',
    setId=>'origen_hidden')
    ); 

    $this -> Campos[origen_id] = array(
    name=>'origen_id',
    id=>'origen_hidden',
    type=>'hidden',
    required=>'yes',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );
	
	$this -> Campos[remitente] = array(
		name	=>'remitente',
		id	=>'remitente',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'remitente_disponible',
			setId	=>'remitente_hidden'
		),
        transaction=>array(
          table=>array('orden_cargue'),
          type=>array('column')
		)
	);
	
	$this -> Campos[remitente_id] = array(
		name    =>'remitente_id',
		id	    =>'remitente_hidden',
		type	=>'hidden',
		//required=>'yes',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('orden_cargue'),
			type	=>array('column'))
	);	

    $this -> Campos[destino] = array(
    name=>'destino',
    id=>'destino',
    type=>'text',
	size=>16,
    suggest=>array(
    name=>'ciudad',
    setId=>'destino_hidden')
    );

    $this -> Campos[destino_id] = array(
    name=>'destino_id',
    id      =>'destino_hidden',
    type=>'hidden',
    required=>'yes',
    value=>'',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

	$this -> Campos[destinatario] = array(
		name	=>'destinatario',
		id		=>'destinatario',
		type	=>'text',
		value	=>'',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'destinatario_disponible',
			setId	=>'destinatario_hidden'),
        transaction=>array(
          table=>array('orden_cargue'),
          type=>array('column')
		)
	);
	
	$this -> Campos[destinatario_id] = array(
		name	=>'destinatario_id',
		id		=>'destinatario_hidden',
		type	=>'hidden',
		//required=>'yes',
		value	=>'',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('orden_cargue'),
			type	=>array('column'))
	);	

    $this -> Campos[producto] = array(
    name=>'producto',
    id=>'producto',
    type=>'text',
	size=>30,
	required=>'yes',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column')),	
    suggest=>array(
     name=>'producto',
     setId=>'producto_id_hidden'
    ),	
	
    ); 
	
    $this -> Campos[producto_id] = array(
    name =>'producto_id',
    id   =>'producto_id_hidden',
    type =>'hidden',
    datatype   =>array(type => 'integer'),	
    transaction=>array(
      table=>array('orden_cargue'),
      type=>array('column')
	)
	
    ); 	

    $this -> Campos[cantidad_cargue] = array(
    name=>'cantidad_cargue',
    id=>'cantidad_cargue',
    type=>'text',
	size=>16,
	required=>'yes',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
	
    ); 

    $this -> Campos[peso] = array(
    name=>'peso',
    id=>'peso',
    type=>'text',
	size=>16,
    datatype=>array(type => 'integer'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))

    ); 

    $this -> Campos[peso_volumen] = array(
    name=>'peso_volumen',
    id=>'peso_volumen',
    type=>'text',
	size=>16,
    datatype=>array(
		type=>'numeric',
		length=>'18',
		presicion=>'3'	
    ),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
	
    ); 

    $this -> Campos[unidad_peso_id] = array(
    name=>'unidad_peso_id',
    id=>'unidad_peso_id',
    type=>'select',
    options=>array(),
    datatype=>array(
		type=>'integer',
		length=>'11'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );
	
    $this -> Campos[unidad_volumen_id] = array(
    name=>'unidad_volumen_id',
    id=>'unidad_volumen_id',
    type=>'select',
    options=>array(),
    datatype=>array(
		type=>'integer',
		length=>'11'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );
	
    $this -> Campos[observaciones] = array(
    name =>'observaciones',
    id   =>'observaciones',
    type =>'textarea',
    datatype=>array(type=>'text'),
    transaction=>array(
		table=>array('orden_cargue'),
		type=>array('column'))
    );	


    //vehiculo
    $this -> Campos[placa] = array(
    name=>'placa',
    id=>'placa',
    type=>'text',
    value=>'',
    size=>'7',
    suggest=>array(
    name=>'vehiculo_disponible',
    setId=>'placa_hidden',
    onclick => 'setDataVehiculo'
    ),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[marca] = array(
    name=>'marca',
    id=>'marca',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[linea] = array(
    name=>'linea',
    id=>'linea',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[modelo] = array(
    name=>'modelo',
    id=>'modelo',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[modelo_repotenciado] = array(
    name=>'modelo_repotenciado',
    id=>'modelo_repotenciado',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[serie] = array(
    name=>'serie',
    id=>'serie',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[color] = array(
    name=>'color',
    id=>'color',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[carroceria] = array(
    name=>'carroceria',
    id=>'carroceria',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[registro_nacional_carga] = array(
    name=>'registro_nacional_carga',
    id=>'registro_nacional_carga',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[configuracion] = array(
    name=>'configuracion',
    id=>'configuracion',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[peso_vacio] = array(
    name=>'peso_vacio',
    id=>'peso_vacio',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[numero_soat] = array(
    name=>'numero_soat',
    id=>'numero_soat',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[nombre_aseguradora] = array(
    name=>'nombre_aseguradora',
    id=>'nombre_aseguradora',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[vencimiento_soat] = array(
    name=>'vencimiento_soat',
    id=>'vencimiento_soat',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );



    $this -> Campos[placa_id] = array(
    name=>'placa_id',
    id=>'placa_hidden',
    type=>'hidden',
    required=>'yes',
    datatype=>array(
    type=>'integer',
    length=>'11'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );
	
	$this -> Campos[remolque] = array(
      name  => 'remolque',
      id    => 'remolque',
      type  => 'hidden',
      value => '0'
    );


    //remolque
    $this -> Campos[placa_remolque] = array(
    name=>'placa_remolque',
    id=>'placa_remolque',
    type=>'text',
    value=>'',
    size=>'7',
    suggest=>array(
    name=>'remolque_disponible',
    setId=>'placa_remolque_hidden'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[placa_remolque_id] = array(
    name=>'placa_remolque_id',
    id=>'placa_remolque_hidden',
    type=>'hidden',
    datatype=>array(
    type=>'integer',
    length=>'11'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[propietario] = array(
    name=>'propietario',
    id=>'propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type =>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[numero_identificacion_propietario] = array(
    name=>'numero_identificacion_propietario',
    id=>'numero_identificacion_propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[direccion_propietario] = array(
    name=>'direccion_propietario',
    id=>'direccion_propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[telefono_propietario] = array(
    name=>'telefono_propietario',
    id=>'telefono_propietario',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_propietario] = array(
    name=>'ciudad_propietario',
    id=>'ciudad_propietario',
    readonly=>'true',
    type=>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[tenedor] = array(
    name=>'tenedor',
    id=>'tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );
	
    $this -> Campos[tenedor_id] = array(
    name=>'tenedor_id',
    id=>'tenedor_id',
    type=>'hidden',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );	

    $this -> Campos[numero_identificacion_tenedor] = array(
    name=>'numero_identificacion_tenedor',
    id=>'numero_identificacion_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[direccion_tenedor] = array(
    name=>'direccion_tenedor',
    id=>'direccion_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[telefono_tenedor] = array(
    name=>'telefono_tenedor',
    id=>'telefono_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_tenedor] = array(
    name=>'ciudad_tenedor',
    id=>'ciudad_tenedor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );




    //conductor
    $this -> Campos[conductor_id] = array(
    name=>'conductor_id',
    id=>'conductor_hidden',
    type=>'hidden',
    value=>'',
    required=>'yes',
    datatype=>array(
    type=>'numeric',
    length=>'20'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[numero_identificacion] = array(
    name=>'numero_identificacion',
    id=>'numero_identificacion',
    readonly=>'true',
    type=>'text',
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[nombre] = array(
    name=>'nombre',
    id=>'nombre',
    type=>'text',
    suggest=>array(
    name=>'conductor_disponible',
    setId=>'conductor_hidden',
    onclick=>'separaNombre'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[direccion_conductor] = array(
    name=>'direccion_conductor',
    id=>'direccion_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[categoria_licencia_conductor] = array(
    name=>'categoria_licencia_conductor',
    id=>'categoria_licencia_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );
	
    $this -> Campos[numero_licencia_cond] = array(
    name=>'numero_licencia_cond',
    id=>'numero_licencia_cond',
    type=>'text',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );	
	

    $this -> Campos[telefono_conductor] = array(
    name=>'telefono_conductor',
    id=>'telefono_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_conductor] = array(
    name=>'ciudad_conductor',
    id=>'ciudad_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('orden_cargue'),
    type=>array('column'))
    );
	

	/*****************************************
	        Campos Anulacion Registro
	*****************************************/
	

	/*****************************************
	        Campos Anulacion Registro
	*****************************************/
	

	$this -> Campos[anul_usuario_id] = array(
		name	=>'anul_usuario_id',
		id		=>'anul_usuario_id',
		type	=>'hidden',
		value   => $this -> getUsuarioId(),
		datatype=>array(
			type	=>'integer')
	);		

	$this -> Campos[anul_orden_cargue] = array(
		name	=>'anul_orden_cargue',
		id		=>'anul_orden_cargue',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text')
	);	
	
	
	$this -> Campos[desc_anul_orden_cargue] = array(
		name	=>'desc_anul_orden_cargue',
		id		=>'desc_anul_orden_cargue',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text')
	);	

    //BOTONES
    $this -> Campos[guardar] = array(
    name=>'guardar',
    id=>'guardar',
    type=>'button',
    value=>'Guardar'
    );
    
    $this -> Campos[actualizar] = array(
    name=>'actualizar',
    id=>'actualizar',
    type=>'button',
    value=>'Actualizar',
    disabled=>'disabled'
	
    );

    $this -> Campos[anular] = array(
    name=>'anular',
    id=>'anular',
    type=>'button',
    value=>'Anular',
	onclick =>'onclickCancellation(this.form)'
    );

    $this -> Campos[limpiar] = array(
    name=>'limpiar',
    id=>'limpiar',
    type=>'reset',
    value=>'Limpiar',
    onclick => 'OrdenCargueOnReset()'
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
      title       => 'Impresion Orden de Cargue',
      width       => '800',
      height      => '600'
    )

    );

    //BUSQUEDA
      $this -> Campos[busqueda] = array(
    name=>'busqueda',
    id=>'busqueda',
    type=>'text',
    size=>'85',
    value=>'',
    suggest=>array(
    name=>'busca_orden_cargue',
    setId=>'orden_cargue_id',
    onclick=>'setDataFormWithResponse')
    );




  $this -> SetVarsValidate($this -> Campos);
  }


}

$OrdenCargue = new OrdenCargue();

?>