<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CierreDTA extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("CierreDTALayoutClass.php");
    require_once("CierreDTAModelClass.php");
	
    $Layout   = new CierreDTALayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CierreDTAModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setAnular    ($Model -> getPermiso($this -> getActividadId(),'ANULAR',$this -> getConex()));	
    $Layout -> setImprimir  ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);	
	
	$Layout -> setZonasFrancas($Model -> getZonasFrancas($this -> getConex()));	

	//// GRID ////
	$Attributes = array(
	  id		=>'dta',
	  title		=>'Listado DTA',
	  sortname	=>'cliente,numero_formulario',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	  array(name=>'cliente',index=>'cliente',sorttype=>'text',	width=>'250',	align=>'center'),	
	  array(name=>'numero_formulario',index=>'numero_formulario',sorttype=>'text',	width=>'120',	align=>'center'),
	  array(name=>'estado_dta',	index=>'estado_dta',sorttype=>'int',width=>'70',	align=>'center'),
	  array(name=>'fecha_consignacion',index=>'fecha_consignacion',sorttype=>'int',	width=>'110',	align=>'center'),
	  array(name=>'fecha_entrega_dta',index=>'fecha_entrega_dta',sorttype=>'text',	width=>'110',	align=>'left'),
	  array(name=>'numero_contenedor_dta',index=>'numero_contenedor_dta',sorttype=>'text',	width=>'115',	align=>'left'),
	  array(name=>'naviera',index=>'naviera',sorttype=>'text',	width=>'100',align=>'left'),	      
	  array(name=>'tara',index=>'tara',sorttype=>'left',width=>'50',align=>'center'),	  	  
	  array(name=>'tipo',index=>'tipo',sorttype=>'text',width=>'50',align=>'center'),	  
	  array(name=>'zonas_francas_id',index=>'zonas_francas_id',sorttype=>'text',	width=>'100',	align=>'center'),	  
	  array(name=>'numero_precinto',index=>'numero_precinto',sorttype=>'text',	width=>'100',	align=>'center'),	  	  
	  array(name=>'codigo',index=>'codigo',sorttype=>'text',width=>'100',	align=>'center'),	  	  	
	  array(name=>'producto',index=>'producto',sorttype=>'text',width=>'100',	align=>'center'),	  	  		  
	  array(name=>'peso',index=>'peso',sorttype=>'text',width=>'100',	align=>'center'),	  	  		  	  
	  array(name=>'responsable_dian',index=>'responsable_dian',sorttype=>'text',	width=>'100',	align=>'center'),	  	  		  	  	  	      
	  array(name=>'responsable_empresa',index=>'responsable_empresa',sorttype=>'text',	width=>'100',	align=>'center'),	  	  		  	  	  	  
	  array(name=>'observaciones_dta',index=>'observaciones_dta',sorttype=>'text',	width=>'100',	align=>'center'),	  	  		  	  	  	  	      
	  array(name=>'fecha_cierre',index=>'fecha_cierre',sorttype=>'text',	width=>'100',	align=>'center'),	  	  		  	  	  	  	  	  
	  array(name=>'responsable_dian_entrega',index=>'responsable_dian_entrega',sorttype=>'text',	width=>'100',	align=>'center'),	  	  		  	  
	  array(name=>'responsable_empresa_entrega',index=>'responsable_empresa_entrega',sorttype=>'text',	width=>'100',	align=>'center'),	  	  	  
	  array(name=>'novedades',index=>'novedades',sorttype=>'text',	width=>'100',	align=>'center')	  	  		  	  	  	  	  	  	  	  	  
	);
	
	  
    $Titles = array('CLIENTE','N. FORMULARIO','ESTADO','FECHA CONSIGNACION','FECHA ENTREGA','CONTENEDOR','NAVIERA','TARA','TIPO','ZONA FRANCA',  
	'PRECINTO','CODIGO','PRODUCTO','PESO','RESPONSABLE DIAN','RESPONSABLE EMPRESA','OBSERVACIONES','FECHA CIERRE','RESPONSABLE DIAN ENTREGA',
	'RESPONSABLE EMPRESA ENTREGA','NOVEDADES'
	);
	
	$Layout -> SetGridCierreDTA($Attributes,$Titles,$Cols,$Model -> getQueryCierreDTAGrid());
	$Layout -> RenderMain();
  
  }

  protected function setDTA(){
  
  	require_once("CierreDTAModelClass.php");
    $Model = new CierreDTAModel();
	
	$busqueda  = $_REQUEST['busqueda'];
	$valor     = $_REQUEST['valor'];
	
	$dta = $Model -> selectCierreDTA($busqueda,$valor,$this -> getConex());
	
	if(count($dta) > 0){
	  $this -> getArrayJSON($dta);	
	}else{
	    exit("No existe DTA");
	 }
  
  }  
  
  protected function onclickUpdate(){
	  
  	require_once("CierreDTAModelClass.php");
    $Model = new CierreDTAModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('true');
	  }
	  
  }
  
  
  protected function onclickCancellation(){

  	require_once("CierreDTAModelClass.php");
    $Model = new CierreDTAModel();
	
     print '<pre>';print_r($_REQUEST);


  }

  protected function onclickPrint(){
  
    require_once("Imp_DTAClass.php");

    $print = new Imp_DTA($this -> getConex(),$this -> getEmpresaId());

    $print -> printOut();
  
  }

  protected function setCampos(){
  
	//campos formulario
	
	$this -> Campos[manifiesto] = array(
		name	=>'manifiesto',
		id	    =>'manifiesto',
		type	=>'text',
		value	=>'',	
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);	
	
	$this -> Campos[despacho] = array(
		name	=>'despacho',
		id	    =>'despacho',
		type	=>'text',
		value	=>'',	
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);		
	
   $this -> Campos[dta_id] = array(
    name=>'dta_id',
    id=>'dta_id',
    type=>'hidden',
    datatype=>array(type=>'autoincrement'),
    transaction=>array(
    table=>array('dta'),
    type=>array('primary_key'))
    );
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		size    =>'35',
		readonly=>'true',
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id	=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',	
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);

    $this -> Campos[numero_formulario] = array(
    name  =>'numero_formulario',
    id    =>'numero_formulario',
    type  =>'text',
	size  =>'10',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	
    $this -> Campos[fecha_consignacion] = array(
    name  =>'fecha_consignacion',
    id    =>'fecha_consignacion',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
	
    $this -> Campos[fecha_entrega_dta] = array(
    name  =>'fecha_entrega_dta',
    id    =>'fecha_entrega_dta',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
    $this -> Campos[numero_contenedor_dta] = array(
    name  =>'numero_contenedor_dta',
    id    =>'numero_contenedor_dta',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );
	
    $this -> Campos[naviera] = array(
    name  =>'naviera',
    id    =>'naviera',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );
	
	$this -> Campos[tara] = array(
    name  =>'tara',
    id    =>'tara',
    type  =>'text',
	size  => '5',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[tipo] = array(
    name  =>'tipo',
    id    =>'tipo',
    type  =>'text',
	readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );				
	
	
	$this -> Campos[numero_precinto] = array(
    name  =>'numero_precinto',
    id    =>'numero_precinto',
    type  =>'text',
	readonly=>'true',
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
			
	$this -> Campos[numero_identificacion_cliente] = array(
    name  =>'numero_identificacion_cliente',
    id    =>'numero_identificacion_cliente',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );			
	
	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id	    =>'codigo',
		type	=>'text',
		size    =>4,
		readonly=>'true',		
		datatype=>array(type => 'text'),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);	
	
	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id	    =>'producto_hidden',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);		

	$this -> Campos[producto] = array(
		name	=>'producto',
		id	    =>'producto',
		type	=>'text',
		readonly=>'true',		
		transaction=>array(
			table	=>array('dta'),
			type	=>array('column'))
	);	
	
	$this -> Campos[peso] = array(
    name  =>'peso',
    id    =>'peso',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[responsable_dian] = array(
    name  =>'responsable_dian',
    id    =>'responsable_dian',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
	
	$this -> Campos[responsable_empresa] = array(
    name  =>'responsable_empresa',
    id    =>'responsable_empresa',
    type  =>'text',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );				
	
	$this -> Campos[observaciones_dta] = array(
    name  =>'observaciones_dta',
    id    =>'observaciones_dta',
    type  =>'textarea',
	readonly=>'true',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[estado_dta] = array(
    name  =>'estado_dta',
    id    =>'estado_dta',
    type  =>'select',
    datatype=>array(type=>'text'),
	disabled=>'true',
	options=>array(array(value => 'A', text => 'ABIERTO'),array(value => 'C', text => 'CERRADO')),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[fecha_cierre] = array(
    name  =>'fecha_cierre',
    id    =>'fecha_cierre',
    type  =>'text',
	value =>date("Y-m-d"),
	required => 'yes',
    datatype=>array(type=>'date'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[zonas_francas_id] = array(
    name    =>'zonas_francas_id',
    id      =>'zonas_francas_id',
    type    =>'select',
	options =>array(),
	required => 'yes',	
    datatype=>array(type=>'integer'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
	
	$this -> Campos[imagen_prueba_entrega] = array(
    name  =>'imagen_prueba_entrega',
    id    =>'imagen_prueba_entrega',
    type  =>'file',
	disabled=>'true',
	required => 'yes',	
	path	=>'/velotax/imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_imagen_prueba_entrega')
    );	
	
	$this -> Campos[responsable_dian_entrega] = array(
    name  =>'responsable_dian_entrega',
    id    =>'responsable_dian_entrega',
    type  =>'text',
	value =>'',
	required => 'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );	
	
	$this -> Campos[responsable_empresa_entrega] = array(
    name  =>'responsable_empresa_entrega',
    id    =>'responsable_empresa_entrega',
    type  =>'text',
	value =>'',
	required => 'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );				
	
	$this -> Campos[novedades] = array(
    name  =>'novedades',
    id    =>'novedades',
    type  =>'text',
	value =>'',
	required => 'yes',	
    datatype=>array(type=>'text'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column'))
    );		
	
	$this -> Campos[imagen_prueba_entrega] = array(
    name  =>'imagen_prueba_entrega',
    id    =>'imagen_prueba_entrega',
    type  =>'file',
	required => 'yes',	
	path	=>'/velotax/imagenes/transporte/dta/',	
    datatype=>array(type=>'file'),
    transaction=>array(
    table=>array('dta'),
    type=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_formulario',
			text	=>'_imagen_prueba_entrega'),
		settings=>array(
		  width => 480,
		  height=> 320
		)
    );	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'CierreDTAOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'true',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CierreDTAOnUpdate')
	);
	
 	$this -> Campos[cancelacion] = array(
		name	=>'cancelacion',
		id		=>'cancelacion',
		type	=>'button',
		value	=>'Anular',
		disabled=>'true',
		property=>array(
			name	=>'cancellation_ajax',
			onsuccess=>'CierreDTAOnCancellation')
	);	
	 
    $this -> Campos[imprimir] = array(
      name     =>'imprimir',
      id       =>'imprimir',
      type     =>'print',
	  disabled =>'disabled',
      value    =>'Imprimir',
	  displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion DTA',
      width       => '0',
      height      => '0'
    )

    );
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CierreDTAOnReset(this.form)'
	);
	
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$CierreDTA_destinatario = new CierreDTA();

?>