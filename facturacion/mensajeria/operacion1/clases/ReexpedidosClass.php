<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Reexpedidos extends Controler{

  public function __construct(){  
	$this -> setCampos();
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("ReexpedidosLayoutClass.php"); 
	require_once("ReexpedidosModelClass.php");
	
    $Layout   = new ReexpedidosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReexpedidosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setAnular($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU   	
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));			
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Reexpedidos',
	  title		=>'Listado de Manifiestos Mensajeria',
	  sortname	=>'reexpedido',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(

	  array(name=>'reexpedido',		index=>'reexpedido',	sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'fecha_rxp',		index=>'fecha_rxp',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'proveedor',		index=>'proveedor',		sorttype=>'text',	width=>'180',	align=>'left'),
	  array(name=>'origen',			index=>'origen',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'destino',		index=>'destino',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',			index=>'estado',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'obser_rxp',		index=>'obser_rxp',		sorttype=>'text',	width=>'100',	align=>'center')  
	);
    $Titles = array('MANIFIESTO','FECHA','PROVEEDOR','ORIGEN','DESTINO','ESTADO','OBSERVACIONES');	
	$Layout -> SetGridReexpedidos($Attributes,$Titles,$Cols,$Model -> getQueryReexpedidosGrid());	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"reexpedido",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

/////
  protected function asignoGuiaReexpedido(){
  
    require_once("ReexpedidosModelClass.php");
	
    $Model         = new ReexpedidosModel();  
	$reexpedido_id = $_REQUEST['reexpedido_id'];
	
	if($Model -> reexpedidoTieneGuias($reexpedido_id,$this -> getConex())){		
	  exit('true');
	}else{
	     exit('false');
	  }  
  }
  
  protected function setDivipolaOrigen(){      
    require_once("ReexpedidosModelClass.php");	
    $Model        = new ReexpedidosModel();
	$ubicacion_id = $_REQUEST['ubicacion_id'];	
	$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());  
    exit("$divipola");  
  }
  
  protected function setDivipolaDestino(){      
    require_once("ReexpedidosModelClass.php");	
    $Model        = new ReexpedidosModel();
	$ubicacion_id = $_REQUEST['ubicacion_id'];	
	$divipola     = $Model -> selectDivipolaUbicacion($ubicacion_id,$this -> getConex());  
    exit("$divipola");  
  }   
/////
  protected function onclickSave(){    
    require_once("ReexpedidosModelClass.php");
	
    $Model                         = new ReexpedidosModel();
	$usuario_id                    = $this -> getUsuarioId();
	$oficina_id                    = $this -> getOficinaId();
	$empresa_id                    = $this -> getEmpresaId();
	$usuarioNombres                = $this -> getUsuarioNombres();
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();
	
    $result = $Model -> Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
       $this -> getArrayJSON($result);
     }	 
  }  

  protected function onclickUpdate(){  
    require_once("ReexpedidosModelClass.php");
	$Model = new ReexpedidosModel();
	$usuario_id                    = $this -> getUsuarioId();
	$oficina_id                    = $this -> getOficinaId();
	$empresa_id                    = $this -> getEmpresaId();
	$usuarioNombres                = $this -> getUsuarioNombres();
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();		
	$Model -> Update($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
  }  
  
  protected function setReexpedido(){     
    require_once("ReexpedidosModelClass.php");
    $Model = new ReexpedidosModel();	
//    $Model                         = new ReexpedidosModel();
	$usuario_id                    = $this -> getUsuarioId();
	$usuarioNombres                = $this -> getUsuarioNombres();	
	$actualizar                    = $this -> requestData('updateReexpedido');	
	if($actualizar == 'true'){
	   $oficina_id           = $this -> requestData('oficina_id');	
	}else{
		$oficina_id                    = $this -> getOficinaId();
	  }

	$empresa_id                    = $this -> getEmpresaId();	
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();		
					
    $Model -> Update($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
      }  
  }  
	  
  protected function onclickDelete(){
  	require_once("ReexpedidosModelClass.php");
    $Model = new ReexpedidosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Reexpedido');
	}
  }
  
  protected function onclickPrint(){  
    require_once("Imp_ReexpedidoClass.php");
    $print = new Imp_Reexpedido($this -> getConex());
    $print -> printOut();  
  }  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("ReexpedidosModelClass.php");
    $Model = new ReexpedidosModel();
	
    $reexpedido_id = $_REQUEST['reexpedido_id'];
	
    $Data =  $Model -> selectReexpedidos($reexpedido_id,$this -> getConex());	
    $this -> getArrayJSON($Data);
}


  protected function onclickCancellation(){  
     require_once("ReexpedidosModelClass.php");
	 
     $Model                 = new ReexpedidosModel(); 
	 $reexpedido_id         = $this -> requestDataForQuery('reexpedido_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($reexpedido_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }	
  }  

  protected function setCampos(){  
	//FORMULARIO
	$this -> Campos[reexpedido_id] = array(
		name	=>'reexpedido_id',
		id		=>'reexpedido_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[reexpedido] = array(
		name	=>'reexpedido',
		id		=>'reexpedido',
		type	=>'text',
		required=>'no',
		size	=>'7',
		readonly=>'readonly',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_rxp] = array(
		name	=>'fecha_rxp',
		id		=>'fecha_rxp',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);	
	
	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		required=>'yes',
		suggest=>array(
			name	=>'mensajero',
			setId	=>'proveedor_hidden')
	);	
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_hidden',
		type	=>'hidden',
		value	=>'1',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'11'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);	
	
	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
//		tabindex=>'8',
		suggest=>array(
			name	=>'ubicacion',
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
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[obser_rxp] = array(
		name	=>'obser_rxp',
		id		=>'obser_rxp',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('reexpedido'),
			type	=>array('column'))
	);
	
	$this -> Campos[valor_prov_rxp] = array(
		name	=>'valor_prov_rxp',
		id		=>'valor_prov_rxp',
		type	=>'text',
		datatype=>array(
			type	=>'numeric',
			length	=>'12')
	);
	
	$this -> Campos[doc_prov_rxp] = array(
		name	=>'doc_prov_rxp',
		id		=>'doc_prov_rxp',
		type	=>'text',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20')
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
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );			
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );		
	
    $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );	
	
    $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );		
	
    $this -> Campos[empresa_id_static] = array(
    name=>'empresa_id_static',
    id=>'empresa_id_static',
    type=>'hidden',
    value   => $this -> getEmpresaId(),
    datatype=>array(
    type=>'integer')
    ); 

    $this -> Campos[oficina_id_static] = array(
    name=>'oficina_id_static',
    id=>'oficina_id_static',
    type=>'hidden',
    value   => $this -> getOficinaId(),
    datatype=>array(
    type=>'integer')
    );

    $this -> Campos[empresa_id] = array(
    name=>'empresa_id',
    id=>'empresa_id',
    type=>'hidden',
    value   => $this -> getEmpresaId(),
    datatype=>array(
    type=>'integer'),
    transaction=>array(
    table=>array('reexpedido'),
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
    table=>array('reexpedido'),
    type=>array('column'))
    ); 
	
    $this -> Campos[updateReexpedido] = array(
    name=>'updateReexpedido',
    id=>'updateReexpedido',
    type=>'hidden',
	value =>'false'
    );	

    $this -> Campos[fecha_static] = array(
    name=>'fecha_static',
    id=>'fecha_static',
    type=>'hidden',
    value   => date("Y-m-d")
    );	
	
    $this -> Campos[estado] = array(
    name    =>'estado',
    id      =>'estado',
    type    =>'select',
	disabled => 'yes',
	options =>array(array(value => 'P', text => 'PENDIENTE', selected => 'M'), array(value => 'M', text => 'MANIFESTADO' , selected => 'M'), 
	array(value => 'L', text => 'LEGALIZADO', selected => 'M'),array(value=>'A',text=>'ANULADO',selected=>'M')),
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reexpedido'),
    type=>array('column'))
    );			
	//BOTONES
    $this -> Campos[guardar] = array(
    name=>'guardar',
    id=>'guardar',
    type=>'button',
    value=>'Continuar'
    );	

    $this -> Campos[actualizar] = array(
    name=>'actualizar',
    id=>'actualizar',
    type=>'button',
    value=>'Actualizar',
    disabled=>'disabled'
    );
	


   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
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
			onsuccess=>'ReexpedidosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		disabled=>'disabled',
		onclick =>'ReexpedidosOnReset(this.form)'
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
      title       => 'Impresion Reexpedido',
      width       => '900',
      height      => '600'
    )
    );

    $this -> Campos[excel] = array(
    name   =>'excel',
    id   =>'excel',
    type   =>'button',
	disabled=>'disabled',
    value   =>'Formato Excel',
	onclick =>'Descargar_excel(this.form)'
	
    );

    $this -> Campos[despachar] = array(
    name=>'despachar',
    id=>'despachar',
    type=>'button',
    value=>'Despachar'
    );
	
    $this -> Campos[importGuia] = array(
    name=>'importGuia',
    id=>'importGuia',
	disabled=>'yes',
    type=>'button',
    value=>'Seleccionar Guias'
    );	
	
	//BUSQUEDA
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'busca_reexpedido',
			setId	=>'reexpedido_id',
			onclick	=>'setDataFormWithResponse')
	);
	
  $this -> SetVarsValidate($this -> Campos);
  }
}

$Reexpedidos = new Reexpedidos();

?>