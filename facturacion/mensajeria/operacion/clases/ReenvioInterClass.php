<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ReenvioInter extends Controler{

  public function __construct(){  
	$this -> setCampos();
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("ReenvioInterLayoutClass.php"); 
	require_once("ReenvioInterModelClass.php");
	
    $Layout   = new ReenvioInterLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReenvioInterModel();
    
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
	  id		=>'ReenvioInter',
	  title		=>'Listado de Reenvios Mensajeria',
	  sortname	=>'fecha_ree',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(

	  array(name=>'fecha_ree',		index=>'fecha_ree',		sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'estado',			index=>'estado',		sorttype=>'text',	width=>'100',	align=>'left'),	  
	  array(name=>'obser_ree',		index=>'obser_ree',		sorttype=>'text',	width=>'100',	align=>'center')  
	);
    $Titles = array('FECHA','ESTADO','OBSERVACIONES');	
	$Layout -> SetGridReenvioInter($Attributes,$Titles,$Cols,$Model -> getQueryReenvioInterGrid());	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"reenvio",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

/////
  protected function asignoGuiaReenvio(){
  
    require_once("ReenvioInterModelClass.php");
	
    $Model         = new ReenvioInterModel();  
	$reenvio_id = $_REQUEST['reenvio_id'];
	
	if($Model -> reenvioTieneGuias($reenvio_id,$this -> getConex())){		
	  exit('true');
	}else{
	     exit('false');
	  }  
  }
  
  protected function onclickSave(){    
    require_once("ReenvioInterModelClass.php");
	
    $Model                         = new ReenvioInterModel();
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
    require_once("ReenvioInterModelClass.php");
	$Model = new ReenvioInterModel();
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
  
	  
  protected function onclickDelete(){
  	require_once("ReenvioInterModelClass.php");
    $Model = new ReenvioInterModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Reenvio');
	}
  }
  
  protected function onclickPrint(){  
    require_once("Imp_ReenvioInterClass.php");
    $print = new Imp_ReenvioInter($this -> getConex());
    $print -> printOut();  
  }  

//BUSQUEDA
  protected function onclickFind(){
  	require_once("ReenvioInterModelClass.php");
    $Model = new ReenvioInterModel();
	
    $reenvio_id = $_REQUEST['reenvio_id'];
	
    $Data =  $Model -> selectReenvioInter($reenvio_id,$this -> getConex());	
    $this -> getArrayJSON($Data);
}

 protected function setLeerCodigobar() {
 	require_once("ReenvioInterModelClass.php");
 	$Model= new ReenvioInterModel();

 	$guia = $_REQUEST['guia'];

 	$Data = $Model -> setLeerCodigobar($guia, $this -> getConex());
	if($Data[0]['numero_guia']>0){
	 	$this -> getArrayJSON($Data);
	}else{
		return false;	
	}
 } 

  protected function onclickCancellation(){  
     require_once("ReenvioInterModelClass.php");
	 
     $Model                 = new ReenvioInterModel(); 
	 $reenvio_id         = $this -> requestDataForQuery('reenvio_id','integer');
	 $causal_anulacion_id   = $this -> requestDataForQuery('causal_anulacion_id','integer');	 
	 $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');
	 $usuario_anulo_id      = $this -> getUsuarioId();
	
	 $Model -> cancellation($reenvio_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$this -> getConex());
	
	 if(strlen($Model -> GetError()) > 0){
	  exit('false');
	 }else{
	    exit('true');
	  }	
  }  

  protected function setCampos(){  
	//FORMULARIO
	$this -> Campos[reenvio_id] = array(
		name	=>'reenvio_id',
		id		=>'reenvio_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('reenvio'),
			type	=>array('primary_key'))
	);
	
	
	$this -> Campos[fecha_ree] = array(
		name	=>'fecha_ree',
		id		=>'fecha_ree',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('reenvio'),
			type	=>array('column'))
	);	
	
	
	$this -> Campos[obser_ree] = array(
		name	=>'obser_ree',
		id		=>'obser_ree',
		type	=>'text',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('reenvio'),
			type	=>array('column'))
	);

    
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		required=>'yes',
		disabled=>'yes',
		options =>array(array(value => 'R', text => 'REENVIADO', selected => 'R'), array(value => 'A', text => 'ANULADO' , selected => 'R')),
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
    table=>array('reenvio'),
    type=>array('column'))
    );			
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('reenvio'),
    type=>array('column'))
    );		
	
    $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reenvio'),
    type=>array('column'))
    );	
	
    $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('reenvio'),
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
    table=>array('reenvio'),
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
    table=>array('reenvio'),
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
			onsuccess=>'ReenvioInterOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'ReenvioInterOnReset()'
	);
	
    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
    value   =>'Imprimir',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Reenvio',
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
			name	=>'busca_reenvio',
			setId	=>'reenvio_id',
			onclick	=>'setDataFormWithResponse')
	);
	
  $this -> SetVarsValidate($this -> Campos);
  }
}

$ReenvioInter = new ReenvioInter();

?>