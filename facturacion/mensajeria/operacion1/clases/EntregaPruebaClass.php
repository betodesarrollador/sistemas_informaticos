<?php
require_once("../../../framework/clases/ControlerClass.php");

final class EntregaPrueba extends Controler{

  public function __construct(){  
	$this -> setCampos();
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("EntregaPruebaLayoutClass.php"); 
	require_once("EntregaPruebaModelClass.php");
	
    $Layout   = new EntregaPruebaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EntregaPruebaModel();
    
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
	  id		=>'Entrega',
	  title		=>'Listado de Entregas Mensajeria',
	  sortname	=>'fecha_ent',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(

	  array(name=>'fecha_ent',		index=>'fecha_ent',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'proveedor',		index=>'proveedor',		sorttype=>'text',	width=>'250',	align=>'left'),
	  array(name=>'estado',			index=>'estado',			sorttype=>'text',	width=>'100',	align=>'left'),	  	  
	  array(name=>'obser_ent',		index=>'obser_ent',		sorttype=>'text',	width=>'100',	align=>'center')  
	);
    $Titles = array('FECHA','PROVEEDOR','ESTADO','OBSERVACIONES');	
	$Layout -> SetGridEntrega($Attributes,$Titles,$Cols,$Model -> getQueryEntregaGrid());	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"entrega",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

/////
  protected function asignoGuiaEntrega(){
  
    require_once("EntregaPruebaModelClass.php");
	
    $Model         = new EntregaPruebaModel();  
	$entrega_id = $_REQUEST['entrega_id'];
	
	if($Model -> entregaTieneGuias($entrega_id,$this -> getConex())){		
	  exit('true');
	}else{
	     exit('false');
	  }  
  }
  
  protected function onclickSave(){    
    require_once("EntregaPruebaModelClass.php");
	
    $Model                         = new EntregaPruebaModel();
	$usuario_id                    = $this -> getUsuarioId();
	$oficina_id                    = $this -> getOficinaId();
	$empresa_id                    = $this -> getEmpresaId();
	$usuarioNombres                = $this -> getUsuarioNombres();
	$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();
	
    $result = $Model -> Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit('false');
    }else{
       print $result;
    }	 
  }  

	protected function onclickUpdate(){

		require_once("EntregaPruebaModelClass.php");
		$Model = new EntregaPruebaModel();

		$Model -> Update($this -> getConex());

		if($Model -> GetNumError() > 0){
			exit("false");
		}else{
			exit("true");
		}
	}  
  
	  
  protected function onclickDelete(){
  	require_once("EntregaPruebaModelClass.php");
    $Model = new EntregaPruebaModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Entrega');
	}
  }
  
  protected function onclickPrint(){  
    require_once("Imp_EntregaClass.php");
    $print = new Imp_Entrega($this -> getConex());
    $print -> printOut();  
  }  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("EntregaPruebaModelClass.php");
    $Model = new EntregaPruebaModel();
	
    $entrega_id = $_REQUEST['entrega_id'];
	
    $Data =  $Model -> selectEntrega($entrega_id,$this -> getConex());	
    $this -> getArrayJSON($Data);
}

 protected function setLeerCodigobar() {
 	require_once("EntregaPruebaModelClass.php");
 	$Model= new EntregaPruebaModel();

 	$guia = $_REQUEST['guia'];
	$fecha_ent = $_REQUEST['fecha_ent'];
	$hora_ent = $_REQUEST['hora_ent'];

	$obser_ent = $_REQUEST['obser_ent'];
 //    $proveedor_id = $_REQUEST['proveedor_id'];
	// $entrega_id = $_REQUEST['entrega_id'];

	$oficina_id  = $this -> getOficinaId();
 	$Data = $Model -> setLeerCodigobar($guia,$oficina_id,$this -> getConex());
 	$Data1 = $Model -> setLeerCodigobar1($guia, $this -> getConex());
 	$Data2 = $Model -> setLeerCodigobar2($guia, $this -> getConex());	
	
	$destino_id = $Data[0]['destino_id'];
	$ciudad_oficina = $Data[0]['ciudad_oficina'];
	$nombre_destino = $Data[0]['nombre_destino'];
	$ubicacion_oficina = $Data[0]['ubicacion_oficina'];
 	

	//echo $ciudad_oficina.'oficina ciudad'.$destino_id.'ciudad destino';
	if(!count($Data)>0){ 
	
		exit("No hay resultados");
		
		}
		
	if($ciudad_oficina!=$destino_id){
			exit(' La guia numero '.$guia.'. tiene como destino la ciudad de '.$nombre_destino.'. Por favor ingrese por una oficina de la ciudad de '.$nombre_destino.'.');
		}


	 
	
	if($Data[0][proveedor_id]>0){
		$proveedor = $Data[0][proveedor];
 		$proveedor_id = $Data[0][proveedor_id];
	}elseif($Data1[0][proveedor_id]>0){
 		$proveedor = $Data1[0][proveedor];
 		$proveedor_id = $Data1[0][proveedor_id];
	}else{
		$proveedor = $Data2[0][proveedor];
 		$proveedor_id = $Data2[0][proveedor_id];
	}
	
 	// $estado = $Model -> getEstadoReex($entrega_id, $this -> getConex());	
	// $estadodis = $Model -> getEstadoDisReex($entrega_id, $this -> getConex());	
	// if($estado!='A'  && $estadodis==0){
	if($Data[0]['numero_guia']!=NULL && $Data[0]['numero_guia']!='NULL' && $Data[0]['numero_guia']!=''){
		if($Data[0][estado_mensajeria_id]==10){
			$usuario_id                    = $this -> getUsuarioId();
			$oficina_id                    = $this -> getOficinaId();
			$empresa_id                    = $this -> getEmpresaId();
			$usuarioNombres                = $this -> getUsuarioNombres();
			$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();
			$Model -> Save($obser_ent,$fecha_ent,$hora_ent,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Data[0][guia_id],$proveedor,$proveedor_id,$this -> Campos,$this -> getConex());
		}
		$this -> getArrayJSON($Data);
	}elseif($Data1[0]['numero_guia']!=NULL && $Data1[0]['numero_guia']!='NULL' && $Data1[0]['numero_guia']!=''){		
		if($Data[0][estado_mensajeria_id]==10){
			$usuario_id                    = $this -> getUsuarioId();
			$oficina_id                    = $this -> getOficinaId();
			$empresa_id                    = $this -> getEmpresaId();
			$usuarioNombres                = $this -> getUsuarioNombres();
			$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();
			$Model -> SaveInter($obser_dev,$fecha_dev,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Data1[0][guia_interconexion_id],$proveedor,$proveedor_id,$this -> Campos,$this -> getConex());
			$this -> getArrayJSON($Data1);			
		}		
	}elseif($Data2[0]['numero_guia']!=NULL && $Data2[0]['numero_guia']!='NULL' && $Data2[0]['numero_guia']!=''){
		if($Data2[0][estado_mensajeria_id]==10){
			$usuario_id                    = $this -> getUsuarioId();
			$oficina_id                    = $this -> getOficinaId();
			$empresa_id                    = $this -> getEmpresaId();
			$usuarioNombres                = $this -> getUsuarioNombres();
			$usuario_numero_identificacion = $this -> getUsuarioIdentificacion();
			$Model -> SaveEncomienda($obser_ent,$fecha_ent,$hora_ent,$usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Data2[0][guia_encomienda_id],$proveedor,$proveedor_id,$this -> Campos,$this -> getConex());
		}
		$this -> getArrayJSON($Data2);
	}else{
		exit('No ha sido creada la guia '.$guia.'');	
	}
	// }elseif($estado=='A'){
	// 	exit('No se Puede adicionar Guias a Esta Entrega,<br>ya que esta Anulada');
	// }elseif($estadodis>0){
	// 	exit('No se Puede adicionar Guias a Esta Entrega,<br>ya que una de las guias Relacionadas a esta entrega ha cambiado de estado');
		
	// }
}


  protected function onclickCancellation(){  
     require_once("EntregaPruebaModelClass.php");
	 
     $Model                 = new EntregaPruebaModel(); 
	 $entrega_id         = $this -> requestDataForQuery('entrega_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($entrega_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }	
  }  


  protected function setCampos(){  
	//FORMULARIO
	$this -> Campos[entrega_id] = array(
		name	=>'entrega_id',
		id		=>'entrega_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('primary_key'))
	);

	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id		=>'fecha_registro',
		type	=>'hidden',
		//required=>'yes',
		value	=>date("Y-m-d H:i:s"),
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
	);	

	
	$this -> Campos[fecha_ent] = array(
		name	=>'fecha_ent',
		id		=>'fecha_ent',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
	);	

	$this -> Campos[hora_ent] = array(
		name	=>'hora_ent',
		id		=>'hora_ent',
		type	=>'text',
		required=>'yes',
		readonly=>'yes',
		value	=>date("H:i:s"),
    	datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
	);	

	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'hidden',
		// required=>'yes',
		// suggest=>array(
		// 	name	=>'mensajero',
		// 	setId	=>'proveedor_id'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
		
	);	
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		value	=>'',
		// required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'11'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
	);	

	
	$this -> Campos[obser_ent] = array(
		name	=>'obser_ent',
		id		=>'obser_ent',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('entrega'),
			type	=>array('column'))
	);

    
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		required=>'yes',
		disabled=>'yes',
		options =>array(array(value => 'E', text => 'ENTREGADO', selected => 'E'), array(value => 'A', text => 'ANULADO' , selected => 'E')),
		datatype=>array(
			type	=>'alpha_upper')
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
    table=>array('entrega'),
    type=>array('column'))
    );			
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('entrega'),
    type=>array('column'))
    );		
	
    $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('entrega'),
    type=>array('column'))
    );	
	
    $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('entrega'),
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
    table=>array('entrega'),
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
    table=>array('entrega'),
    type=>array('column'))
    ); 
	

    $this -> Campos[fecha_static] = array(
    name=>'fecha_static',
    id=>'fecha_static',
    type=>'hidden',
    value   => date("Y-m-d")
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
			onsuccess=>'EntregaOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'EntregaOnReset()'
	);
	
    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
    value   =>'Imprimir',
	id_prin =>'entrega_id',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Entrega',
      width       => '900',
      height      => '600'
    )
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
			name	=>'busca_entrega',
			setId	=>'entrega_id',
			onclick	=>'setDataFormWithResponse')
	);
	
  $this -> SetVarsValidate($this -> Campos);
  }
}

$EntregaPrueba = new EntregaPrueba();

?>