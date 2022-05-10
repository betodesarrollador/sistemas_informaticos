<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Tenedores extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("TenedoresLayoutClass.php");
	require_once("TenedoresModelClass.php");
	
	$Layout   = new TenedoresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TenedoresModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setCambioEstado($Model -> getPermiso($this -> getActividadId(),'STATUS',$this -> getConex()));		
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
   	$Layout -> SetTiposPersona	($Model -> GetTipoPersona	($this -> getConex()));
	$Layout -> SetTiposId		($Model -> GetTipoId		($this -> getConex()));
	$Layout -> SetBancos		($Model -> getBancos 		($this -> getConex()));
	$Layout -> SetTipoCuenta	($Model -> GetTipoCuenta	($this -> getConex()));
    $Layout -> setEstado        ();	 	
    
	
	//// GRID ////
	$Attributes = array(
	  id=>'tenedores',width=>'auto',height=>250,title=>'Listado de tenedores',sortname=>'numero_identificacion'
	);
	$Cols = array(
	  array(name=>'tipo_identificacion',	index=>'tipo_identificacion',	sorttype=>'text',	width=>'100',		align=>'center'),
	  array(name=>'tipo_persona',			index=>'tipo_identificacion',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'digito_verificacion',	index=>'digito_verificacion',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'primer_apellido',		index=>'primer_apellido',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'segundo_apellido',		index=>'segundo_apellido',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'primer_nombre',			index=>'primer_nombre',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'segundo_nombre',			index=>'segundo_nombre',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'razon_social',			index=>'razon_social',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'sigla',					index=>'sigla',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'ubicacion',				index=>'ubicacion',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'direccion',				index=>'direccion',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'telefono',				index=>'telefono',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'movil',					index=>'movil',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'banco',					index=>'banco',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'nombre_tipo_cuenta',		index=>'nombre_tipo_cuenta',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'numero_cuenta_tene',		index=>'numero_cuenta_tene',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'fecha_data_tene',		index=>'fecha_data_tene',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'calificacion_data_tene',	index=>'calificacion_data_tene',sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'100',	align=>'center')
	);
    	$Titles = array('TIPO IDN',			'TIPO PERSONA',			'IDENTIFICACION',			'D. VERIF',				'PRIMER APELLIDO',
						'SEGUNDO APELLIDO',	'PRIMER NOMBRE',		'SEGUNDO NOMBRE',			'RAZON SOCIAL',			'SIGLA',
						'UBICACION',		'DIRECCION',			'TELEFONO',					'MOVIL',				'BANCO',
						'TIPO CUENTA',		'NUMERO CUENTA',		'FECHA CONSULTA DCTO',		'CALIFICACION',			'ESTADO');
		
	$Layout -> SetGridTenedores($Attributes,$Titles,$Cols,$Model -> getQueryTenedoresGrid());
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
  
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);

    print $Data -> GetData();

  }

  protected function onclickSave(){
    require_once("TenedoresModelClass.php");
    $Model = new TenedoresModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('true');
    }	
  }

  protected function onclickUpdate(){
    require_once("TenedoresModelClass.php");
	$Model = new TenedoresModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('true');
	}
  }
  
  protected function sendTenedorMintransporte(){
      
	include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	$webService = new WebServiceMinTransporte($this -> getConex());	  
	  
	$data = array(	  
	    tenedor_id                => $this -> requestData('tenedor_id'),
		tipo_identificacion_id    => $this -> requestData('tipo_identificacion_id'),
	    numero_identificacion     => $this -> requestData('numero_identificacion'),
		nombre                    => $this -> requestData('primer_nombre').' '.$this -> requestData('segundo_nombre').' '.$this -> requestData('razon_social'),		
		nombre_sede               => $this -> requestData('primer_nombre').' '.$this -> requestData('segundo_nombre').' '.$this -> requestData('primer_apellido').' '.$this -> requestData('segundo_apellido').' '.$this -> requestData('razon_social'),		
		primer_apellido           => $this -> requestData('primer_apellido'),
		segundo_apellido          => $this -> requestData('segundo_apellido'),
		telefono                  => $this -> requestData('telefono'),
	    direccion                 => $this -> requestData('direccion'),
		ubicacion_id              => $this -> requestData('ubicacion_id')
	  );
	  
    $webService -> sendTenedorMintransporte($data);	  
    
  
  } 
    	  
  protected function onclickDelete(){
  	require_once("TenedoresModelClass.php");
    $Model = new TenedoresModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      if($this -> Error == 'LLAVE_FORANEA_RESTRICT'){
        exit('NO SE PUEDE QUITAR EL REGISTRO, TIENE RELACION CON OTROS REGISTROS');
      }else{
         exit('ERROR :'.$this -> Error);
      }
    }else{
	    exit('Se elimino correctamente el tenedor');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
  
  	require_once("TenedoresModelClass.php");
    $Model = new TenedoresModel();
    $TerceroId = trim($_REQUEST['tercero_id']);
    $NumeroId  = trim($_REQUEST['numero_identificacion']);
	
    if(strlen($TerceroId) > 0){
       $Data =  $Model -> selectTenedoresporId($TerceroId,$this -> getConex());
    }elseif(strlen($NumeroId) > 0){
          $Data =  $Model -> selectTenedoresporNumId($NumeroId,$this -> getConex());
     }else{
        exit('ERROR : LINEA '.__LINE__." ARCHIVO ".__FILE__);
       }


    $this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero','tenedor','proveedor'),
			type	=>array('primary_key','column','column'))
	);
	  
	$this -> Campos[tenedor_id] = array(
		name	=>'tenedor_id',
		id		=>'tenedor_id',
		type	=>'hidden',
		required=>'no',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('tenedor'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		required=>'no',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('primary_key'))
	);	
	
	
	
	$this -> Campos[tipo_persona_id] = array(
		name	=>'tipo_persona_id',
		id		=>'tipo_persona_id',
		type	=>'select',
		required=>'yes',
		options	=>null,
	 	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		required=>'yes',
		options	=>null,
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id		=>'numero_identificacion',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[digito_verificacion] = array(
		name	=>'digito_verificacion',
		id		=>'digito_verificacion',
		type	=>'text',
		size	=>'1',
		readonly=>'readonly',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column')));
	
	$this -> Campos[primer_apellido] = array(
		name	=>'primer_apellido',
		id		=>'primer_apellido',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
    $this -> Campos[segundo_apellido] = array(
		name	=>'segundo_apellido',
		id		=>'segundo_apellido',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[primer_nombre] = array(
		name	=>'primer_nombre',
		id		=>'primer_nombre',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[segundo_nombre] = array(
		name	=>'segundo_nombre',
		id		=>'segundo_nombre',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[razon_social] = array(
	 	name	=>'razon_social',
		id		=>'razon_social',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[sigla] = array(
		name	=>'sigla',
		id		=>'sigla',
		type	=>'text',
	 	value	=>'',
		datatype=>array(
			type	=>'alphanum',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ubicacion_id')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_id',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
		
	$this -> Campos[direccion] = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
    
	$this -> Campos[telefono] = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[movil] = array(
		name	=>'movil',
		id		=>'movil',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	
	
	$this -> Campos[tipo_cta_id] = array(
		name	=>'tipo_cta_id',
		id		=>'tipo_cta_id',
		type	=>'select',
		options	=>null,
		selected=>'',
		datatype=>array(
			type	=>'numeric',
			length	=>'3'),
		transaction=>array(
			table	=>array('tenedor','proveedor'),
			type	=>array('column','column'))
	);
	
	$this -> Campos[numero_cuenta_tene] = array(
		name	=>'numero_cuenta_tene',
		id		=>'numero_cuenta_tene',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[numcuenta_proveedor] = array(
		name	=>'numcuenta_proveedor',
		id		=>'numcuenta_proveedor',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'60'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);	
		
	$this -> Campos[banco_id] = array(
		name	=>'banco_id',
		id		=>'banco_id',
		type	=>'select',
		options	=>array(),
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tenedor','proveedor'),
			type	=>array('column','column'))
	);
	
	
	
	$this -> Campos[fecha_data_tene] = array(
		name	=>'fecha_data_tene',
		id		=>'fecha_data_tene',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[calificacion_data_tene] = array(
		name	=>'calificacion_data_tene',
		id		=>'calificacion_data_tene',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column'))
	);
	
	$this -> Campos[autoret_proveedor] = array(
		name	=>'autoret_proveedor',
		id		=>'autoret_proveedor',
		type	=>'select',
	 	options	=>array(array(value => 'N', text => 'NO'),array(value => 'S', text => 'SI')),
		selected=>'N',
		required=>'yes',
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('tercero','tenedor','proveedor'),
			type	=>array('column','column','column'))
	);

    $this -> Campos[retei_proveedor] = array(
		name	=>'retei_proveedor',
		id		=>'retei_proveedor',
		type	=>'select',
	 	options	=>array(array(value => 'N', text => 'NO'),array(value => 'S', text => 'SI')),
		selected=>'N',
		required=>'yes',		
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('tercero','tenedor','proveedor'),
			type	=>array('column','column','column'))
	);		
    $this -> Campos[renta_proveedor] = array(
		name	=>'renta_proveedor',
		id		=>'renta_proveedor',
		type	=>'select',
	 	options	=>array(array(value => 'N', text => 'NO'),array(value => 'S', text => 'SI')),
		selected=>'N',
		required=>'yes',		
		datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('tercero','tenedor','proveedor'),
			type	=>array('column','column','column'))
	);		
	
	
	$this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
		required =>'yes',
		options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
        selected => 'B',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column'))
	);
	
 	$this -> Campos[documentos] = array(
		name	=>'documentos',
		id		=>'documentos',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/tenedores/',
		size	=>'70',	
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('tenedor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_documentos')
	);	
	
	
	
	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value=>'Guardar'
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled'
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TenedoresOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TenedoresOnClear()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		suggest=>array(
			name	=>'busqueda_tenedor',
			setId	=>'tercero_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$tenedores = new Tenedores();

?>