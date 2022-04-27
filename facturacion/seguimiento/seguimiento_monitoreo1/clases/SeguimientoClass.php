<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Seguimiento extends Controler{

  public function __construct(){
    parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("SeguimientoLayoutClass.php");
    require_once("SeguimientoModelClass.php");

    $Layout   = new SeguimientoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new SeguimientoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);

//LISTA MENU
	$Layout -> SetEstadoSeg($Model -> GetEstadoSeg($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));

	//// GRID ////
	$Attributes = array(
	  id=>'Seguimiento',
	  title=>'Ordenes de seguimiento a Terceros',
	  sortname=>'seguimiento_id',
	  width=>'auto',
	  height=>'250'
	);
	
	$Cols = array(
	  array(name=>'seguimiento_id',			index=>'seguimiento_id',		sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'fecha',					index=>'fecha',					sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'fecha_ingreso',			index=>'fecha_ingreso',			sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'tipo',					index=>'tipo',					sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'cliente',				index=>'cliente',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'cliente_nit',			index=>'cliente_nit',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'direccion_cargue',		index=>'direccion_cargue',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'cliente_tel',			index=>'cliente_tel',			sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'origen',					index=>'origen',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',				index=>'destino',				sorttype=>'text',	width=>'50',	align=>'center'),
      array(name=>'placa',					index=>'placa',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'marca',					index=>'marca',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'color',					index=>'color',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'nombre',					index=>'nombre',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'telefono_conductor',		index=>'oficina',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'ciudad_conductor',		index=>'ciudad_conductor',		sorttype=>'text',	width=>'100',	align=>'center')
	);

    $Titles = array('SEGUIMIENTO No','FECHA','FECHA INGRESO','TIPO','ESTADO','CLIENTE','CLIENTE NIT','DIRECCION','TELEFONO','ORIGEN','DESTINO',
                    'PLACA','MARCA','COLOR','CONDUCTOR','TELEFONO','CIUDAD');

    $Layout -> SetGridSeguimiento($Attributes,$Titles,$Cols,$Model -> getQuerySeguimientoGrid($this -> getOficinaId()));

    $Layout -> RenderMain();
    
  }


  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"seguimiento",$this ->Campos);
    print $Data -> GetData();
  }

  protected function onclickSave(){
    
    require_once("SeguimientoModelClass.php");
	
    $Model  = new SeguimientoModel();
    $result = $Model -> Save($this -> getOficinaId(),$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
     exit("false");
    }else{
	  $this -> getArrayJSON($result);
      
    }
	 
  }

  protected function onclickUpdate(){
    
    require_once("SeguimientoModelClass.php");
    $Model = new SeguimientoModel();

    $Model -> Update($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
      }
  
  }
  


//BUSQUEDA
  protected function onclickFind(){
  
    require_once("SeguimientoModelClass.php");
    $Model = new SeguimientoModel();

    $seguimiento_id = $_REQUEST['seguimiento_id'];

    $Data =  $Model -> selectseguimiento($seguimiento_id,$this -> getConex());

    print json_encode($Data);

  }

  
  protected function onclickPrint(){
  
    require_once("Imp_OrdenSeguimientoClass.php");

    $print = new Imp_OrdenSeguimiento();

    $print -> printOut($this -> getConex());
  
  }
  
  protected function onclickCancellation(){
  
  	require_once("SeguimientoModelClass.php");
    $Model = new SeguimientoModel();
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }
  
  protected function setDataVehiculo(){
  
    require_once("SeguimientoModelClass.php");
    $Model = new SeguimientoModel();
  
    $placa_id = $_REQUEST['placa_id'];
    $data     = $Model -> selectVehiculo($placa_id,$this -> getConex());

     $this -> getArrayJSON($data);
  
  }
  
  protected function setDataConductor(){
  
    require_once("SeguimientoModelClass.php");
	
    $Model        = new SeguimientoModel();  
    $conductor_id = $_REQUEST['conductor_id'];
    $data         = $Model -> selectConductor($conductor_id,$this -> getConex()); 

     $this -> getArrayJSON($data); 
  
  }
  
   protected function ComprobarTrafico(){
  
    require_once("SeguimientoModelClass.php");
    
	$Model = new SeguimientoModel();
    $estado   = $Model -> getComprobarTrafico($this -> getConex());
	exit("$estado");
  
  }

 
  protected function setDataCliente(){

    require_once("SeguimientoModelClass.php");
    $Model = new SeguimientoModel();    
    $cliente_id = $_REQUEST['cliente_id'];
    $data = $Model -> getDataCliente($cliente_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }


  protected function setContactos(){

	require_once("SeguimientoLayoutClass.php");
	require_once("SeguimientoModelClass.php");
	
	$Layout = new SeguimientoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new SeguimientoModel();
	
	$cliente_id = $_REQUEST['cliente_id'];
	$contactos  = $Model -> getContactos($cliente_id,$this -> getConex());
	
    if(!count($contactos) > 0){
	  $contactos = array();
	}

      $field = array(
		name	 =>'contacto_id',
		id		 =>'contacto_id',
		type	 =>'select',
		multiple => 'multiple',
		size     => '4',
		options  => $contactos,		
		datatype => array(
			type	=>'alphanum'
		)
	  );
	  
	  print $Layout -> getObjectHtml($field);

  }
  
  protected function selectedContactos(){

	require_once("SeguimientoModelClass.php");
	
    $Model          = new SeguimientoModel();  	
    $seguimiento_id = $_REQUEST['seguimiento_id'];
	
	$return = $Model -> SelectContactosSeguimiento($seguimiento_id,$this -> getConex());
	
	if(count($return) > 0){
	   $this -> getArrayJSON($return);
	}else{
	    exit('false');
	  }
  
  }
  

  

  protected function setCampos(){
      
    //FORMULARIO
    $this -> Campos[seguimiento_id] = array(
    name=>'seguimiento_id',
    id=>'seguimiento_id',
    type=>'text',
	readonly=>'yes',
    datatype=>array(
    type=>'integer',
    length=>'20'),
    transaction=>array(
    table=>array('seguimiento','contacto_seguimiento','servicio_transporte'),
    type=>array('primary_key','column','column'))
    );

	$this -> Campos[servicio_transporte_id] = array(
		name	=>'servicio_transporte_id',
		id		=>'servicio_transporte_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('servicio_transporte'),
			type	=>array('primary_key'))
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
    table=>array('seguimiento'),
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
    table=>array('seguimiento'),
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
    table=>array('seguimiento'),
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
    table=>array('seguimiento'),
    type=>array('column'))
    ); 

    $this -> Campos[cliente] = array(
    name=>'cliente',
    id=>'cliente',
    type=>'text',
    suggest=>array(
		name=>'cliente',
		setId=>'cliente_hidden',
		onclick => 'setDataCliente'),
    datatype=>array(
	    type=>'text',
		length=>250),
    transaction=>array(
		table=>array('seguimiento'),
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
		table=>array('seguimiento'),
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
		table=>array('seguimiento'),
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
		table=>array('seguimiento'),
		type=>array('column'))
	
    ); 

    $this -> Campos[cliente_movil] = array(
    name	=>'cliente_movil',
    id		=>'cliente_movil',
    type	=>'text',
	readonly=>'yes',
    datatype=>array(
	    type=>'text',
		length=>20),
    transaction=>array(
		table=>array('seguimiento'),
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
    table=>array('seguimiento'),
    type=>array('column'))
	
    ); 

	$this -> Campos[contacto_id] = array(
		name	 =>'contacto_id',
		id		 =>'contacto_id',
		type	 =>'select',
		multiple => 'multiple',
		size     => '4',
		disabled => 'disabled',
		options  => array(),		
		selected =>'NULL',
		datatype => array(
			type	=>'alphanum'
		 )
	);	




    $this -> Campos[origen] = array(
    name=>'origen',
    id=>'origen',
    type=>'text',
	size=>18,
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
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[destino] = array(
    name=>'destino',
    id=>'destino',
    type=>'text',
	size=>18,
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
    table=>array('seguimiento'),
    type=>array('column'))
    );


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
		required=>'yes',
    	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('seguimiento'),
			type	=>array('column'))
	);

    $this -> Campos[estado] = array(
    name=>'estado',
    id=>'estado',
    type=>'hidden',
    value=>'P',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

	$this -> Campos[estado_select] = array(
		name	=>'estado_select',
		id		=>'estado_select',
		type	=>'select',
		selected=>'P',
		disabled=>'yes',
		required=>'yes',
    	datatype=>array(
			type	=>'alphanum',
			length	=>'1')
	);


    //vehiculo
    $this -> Campos[placa] = array(
    name=>'placa',
    id=>'placa',
    type=>'text',
    value=>'',
    size=>'7',
    suggest=>array(
    name=>'vehiculo',
    setId=>'placa_hidden',
    onclick => 'setDataVehiculo'
    ),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[marca] = array(
    name=>'marca',
    id=>'marca',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[linea] = array(
    name=>'linea',
    id=>'linea',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[modelo] = array(
    name=>'modelo',
    id=>'modelo',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[modelo_repotenciado] = array(
    name=>'modelo_repotenciado',
    id=>'modelo_repotenciado',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[serie] = array(
    name=>'serie',
    id=>'serie',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[color] = array(
    name=>'color',
    id=>'color',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[carroceria] = array(
    name=>'carroceria',
    id=>'carroceria',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[registro_nacional_carga] = array(
    name=>'registro_nacional_carga',
    id=>'registro_nacional_carga',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[configuracion] = array(
    name=>'configuracion',
    id=>'configuracion',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[peso_vacio] = array(
    name=>'peso_vacio',
    id=>'peso_vacio',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[numero_soat] = array(
    name=>'numero_soat',
    id=>'numero_soat',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[nombre_aseguradora] = array(
    name=>'nombre_aseguradora',
    id=>'nombre_aseguradora',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[vencimiento_soat] = array(
    name=>'vencimiento_soat',
    id=>'vencimiento_soat',
    type=>'text',
    readonly=>'true',
    value=>'',
    transaction=>array(
    table=>array('seguimiento'),
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
    table=>array('seguimiento','servicio_transporte'),
    type=>array('column','column'))
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
    name=>'remolque',
    setId=>'placa_remolque_hidden'),
    transaction=>array(
    table=>array('seguimiento'),
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
    table=>array('seguimiento','servicio_transporte'),
    type=>array('column','column'))
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
    table=>array('seguimiento','servicio_transporte'),
    type=>array('column','column'))
    );

    $this -> Campos[numero_identificacion] = array(
    name=>'numero_identificacion',
    id=>'numero_identificacion',
    readonly=>'true',
    type=>'text',
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[nombre] = array(
    name=>'nombre',
    id=>'nombre',
    type=>'text',
    suggest=>array(
    name=>'conductor',
    setId=>'conductor_hidden',
    onclick=>'separaNombre'),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[direccion_conductor] = array(
    name=>'direccion_conductor',
    id=>'direccion_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[categoria_licencia_conductor] = array(
    name=>'categoria_licencia_conductor',
    id=>'categoria_licencia_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[telefono_conductor] = array(
    name=>'telefono_conductor',
    id=>'telefono_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[movil_conductor] = array(
    name=>'movil_conductor',
    id=>'movil_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[correo_conductor] = array(
    name=>'correo_conductor',
    id=>'correo_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('seguimiento'),
    type=>array('column'))
    );

    $this -> Campos[ciudad_conductor] = array(
    name=>'ciudad_conductor',
    id=>'ciudad_conductor',
    type=>'text',
    readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('seguimiento'),
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

	$this -> Campos[anul_seguimiento] = array(
		name	=>'anul_seguimiento',
		id		=>'anul_seguimiento',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		readonly=>'yes',
		datatype=>array(
			type	=>'text')
	);	
	
	
	$this -> Campos[desc_anul_seguimiento] = array(
		name	=>'desc_anul_seguimiento',
		id		=>'desc_anul_seguimiento',
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
    onclick => 'SeguimientoOnReset()'
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
    name=>'seguimiento',
    setId=>'seguimiento_id',
    onclick=>'setDataFormWithResponse')
    );

  $this -> SetVarsValidate($this -> Campos);
  }


}

$Seguimiento = new Seguimiento();

?>