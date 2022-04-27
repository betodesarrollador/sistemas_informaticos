<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicitudServicios extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[solicitud_id] = array(
		name	=>'solicitud_id',
		id		=>'solicitud_id',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		onblur  =>'validaRango()',
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[fecha_ss] = array(
		name	=>'fecha_ss',
		id		=>'fecha_ss',
		type	=>'text',
		required=>'yes',
		value	=>date("Y-m-d"),
		//tabindex=>'3',
	    datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_ss_static] = array(
		name	=>'fecha_ss_static',
		id		=>'fecha_ss_static',
		type	=>'hidden',
		value	=>date("Y-m-d")
	);	
	
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id	=>'oficina_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
	    datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
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
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column')),
            setoptionslist=>array(childId=>'contacto_id')			
	);
	
	$this -> Campos[contacto_id] = array(
		name	 =>'contacto_id',
		id		 =>'contacto_id',
		type	 =>'select',
		disabled => 'disabled',
		options  => array(),		
		selected =>'NULL',
		datatype => array(
			type	=>'alphanum'
		 ),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
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
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))
	);
	

	
	$this -> Campos[fecha_recogida_ss] = array(
		name	=>'fecha_recogida_ss',
		id		=>'fecha_recogida_ss',
		type	=>'text',
		value	=>'',
		size	=>'10',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[hora_recogida_ss] = array(
		name	=>'hora_recogida_ss',
		id		=>'hora_recogida_ss',
		type	=>'text',
		value	=>'',
		size	=>'10',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))
	);
	
    $this -> Campos[fecha_entrega_ss] = array(
		name	=>'fecha_entrega_ss',
		id		=>'fecha_entrega_ss',
		type	=>'text',
		value	=>'',
		size	=>'10',
		//tabindex=>'6',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))
	);
	
	$this -> Campos[hora_entrega_ss] = array(
		name	=>'hora_entrega_ss',
		id		=>'hora_entrega_ss',
		type	=>'text',
		value	=>'',
		size	=>'10',
		datatype=>array(
			type	=>'time'),
		transaction=>array(
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))
	);

	$this -> Campos[archivo_solicitud] = array(
		name	  =>'archivo_solicitud',
		id	  =>'archivo_solicitud',
		type	  =>'upload',
                title     =>'Carga de Archivos Clientes',
                parameters=>'cliente_id',
                beforesend=>'validaSeleccionSolicitud',
                onsuccess =>'onSendFile'
	);

	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'SolicitudServiciosOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'SolicitudServiciosOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'SolicitudServiciosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	    =>'limpiar',
		id	    =>'limpiar',
		type	    =>'reset',
		value	    =>'Limpiar',
		onclick     =>'SolicitudServiciosOnReset()'
	);
	
	//BUSQUEDA
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		value	=>'',
		//tabindex=> '1',
		suggest=>array(
			name	=>'busca_solicitud_servicio_guia',
			setId	=>'solicitud_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("SolicitudServiciosLayoutClass.php");
    require_once("SolicitudServiciosModelClass.php");
	
    $Layout   = new SolicitudServiciosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new SolicitudServiciosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout ->  SetTipoServicioMen	($Model -> GetTipoServicioMen   	  ($this -> getConex()));

    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    	
    $Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));    	
	
	
	//// GRID ////
    $Attributes = array(
      id		=>'SolicitudServicios',
      title		=>'Solicitud Servicio de Transporte',
      sortname	=>'fecha_ss',
      sortorder	=>'desc',
      rowId		=>'solicitud_id',
      width		=>'auto',
      height	=>'250'
    );

    $Cols = array(
      array(name=>'solicitud_id',			index=>'solicitud_id',		sorttype=>'text',	width=>'50',	align=>'center'),
      array(name=>'fecha_ss',				index=>'fecha_ss',			sorttype=>'date',	width=>'80',	align=>'center'),
      array(name=>'cliente',				index=>'cliente',			sorttype=>'text',	width=>'150',	align=>'left'),
      array(name=>'tipo_servicio',			index=>'tipo_servicio',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'fecha_recogida_ss',		index=>'fecha_recogida_ss',	sorttype=>'date',	width=>'80',	align=>'center'),
      array(name=>'hora_recogida_ss',		index=>'hora_recogida_ss',	sorttype=>'text',	width=>'80',	align=>'center'),
      array(name=>'fecha_entrega_ss',		index=>'fecha_entrega_ss',	sorttype=>'date',	width=>'80',	align=>'center'),
      array(name=>'hora_entrega_ss',		index=>'hora_entrega_ss',	sorttype=>'text',	width=>'80',	align=>'center')
    );

    $Titles = array('ID SOL',
				    'FECHA SOL',
				    'CLIENTE',
				    'TIPO SERVICIO',
				    'FECHA RECOGIDA',
				    'HORA RECOGIDA',
				    'FECHA ENTREGA',
				    'HORA ENTREGA'
    );
    
    $SubAttributes = array(
      subgrid	=>true,
      sortname	=>'detalle_ss',
      sortorder	=>'asc'
    );

    $SubCols = array(
      array(name=>'detalle_ss',				index=>'detalle_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      
      array(name=>'origen',					index=>'origen',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'remitente_ss',			index=>'remitente_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'doc_remitente_ss',		index=>'doc_remitente_ss',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'dir_remi_ss',			index=>'dir_remi_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tel_remi_ss',			index=>'tel_remi_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      
      array(name=>'destino',				index=>'destino',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'destinatario_ss',		index=>'destinatario_ss',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'doc_destinatario_ss',	index=>'doc_destinatario_ss',	sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'dir_dest_ss',			index=>'dir_dest_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tel_dest_ss',			index=>'tel_dest_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      
      array(name=>'codigo',					index=>'codigo',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'descrip_produc_ss',		index=>'descrip_produc_ss',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'naturaleza',				index=>'naturaleza',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'empaque',				index=>'empaque',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'medida',					index=>'medida',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'cantidad_ss',			index=>'cantidad_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      
      array(name=>'largo_ss',				index=>'largo_ss',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'ancho_ss',				index=>'ancho_ss',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'alto_ss',				index=>'alto_ss',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'peso_volumen_ss',		index=>'peso_volumen_ss',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'peso_neto_ss',			index=>'peso_neto_ss',			sorttype=>'text',	width=>'100',	align=>'center'),
      
      array(name=>'valor_declarado_ss',		index=>'valor_declarado_ss',	sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'guia_cliente_ss',		index=>'guia_cliente_ss',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'obser_ss',				index=>'obser_ss',				sorttype=>'text',	width=>'100',	align=>'center')
    );

    $SubTitles = array('DET SOL',
					
					'ORIGEN',
					'REMITENTE',
					'DOC REMITENTE',
					'DIR REMITENTE',
					'TEL REMITENTE',
					
					'DESTINO',
					'DESTINATARIO',
					'DOC DESTINATARIO',
					'DIR DESTINATARIO',
					'TEL DESTINATARIO',
					
					'COD PRODUCTO',
					'DESC PRODUCTO',
					'NATURALEZA',
					'EMPAQUE',
					'MEDIDA',
					'CANTIDAD',
					
					'LARGO',
					'ANCHO',
					'ALTO',
					'PESO VOLUMEN',
					'PESO NETO',
					
					'VALOR DECLARADO',
					'GUIA CLIENTE',
					'OBSERVACIONES'
	);
	
	$Layout -> SetGridSolicitudServicios($Attributes,$Titles,$Cols,$Model -> getQuerySolicitudServiciosGrid());
	
	$Layout -> RenderMain();
    
  }
  
  protected function getArrayInsert($dir_file){
  
    $fileContent = $this -> excelToArray($dir_file);
    $keys        = $fileContent[0];
    $arrayInsert = array();
    
    for($i = 1; $i <= count($fileContent); $i++){
    
      foreach($keys as $llave => $valor){
        $arrayInsert[$i][$valor] = $fileContent[$i][$llave];
      }
      
    }
        
    return array_values($arrayInsert); 
  
  }

  protected function uploadFileAutomatically(){
  
    require_once("SolicitudServiciosModelClass.php");

    $Model         = new SolicitudServiciosModel();
    $ruta          = "../../../archivos/mensajeria/solicitud_servicios/";
    $archivo       = $_FILES['archivo_solicitud'];
    $nombreArchivo = "solicitud_servicio_".rand();    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);
    $camposArchivo = $this -> excelToArray($dir_file,$rowLimit = 0);
    $cliente_id    = $_REQUEST['cliente_id'];
	$solicitud_id  = $_REQUEST['solicitud_id'];
    
    $errorLog      = '';

    if($Model -> archivoEstaParametrizado($cliente_id,$camposArchivo,$this -> getConex())){
    
      $arrayInsert = $this -> getArrayInsert($dir_file);          
      $linea       = 2;
	  $remitente_ingresado='';
	  
	  if($remitente_ingresado==''){
		 $remitente_ingresado= $Model -> remitente_ingresado($arrayInsert[0],$cliente_id,$this -> getConex());
	  }
	  
      for($i = 0; $i < count($arrayInsert) - 1; $i++){
	  
	    $errorLogTmp = '';
		$sql_valida ='';
		//$destinatario_ingresado= $Model -> destinatario_ingresado($arrayInsert[$i],$cliente_id,$this -> getConex());   
			
		$sql_valida=$Model -> setInsertDetalleSolicitud($arrayInsert[$i],$solicitud_id,$cliente_id,$remitente_ingresado,$this -> getConex());      
		if(substr($sql_valida[0],0,6)=="INSERT"){
			//$consulsql[$linea] = $Model -> setInsertDetalleSolicitud($arrayInsert[$i],$solicitud_id,$cliente_id,$this -> getConex());      
			$consulsql[$linea] = $sql_valida;      
		}elseif(strlen(trim($sql_valida)) > 0){  
		  	$errorLog .= "LINEA[ $linea ] : $sql_valida\n";	
		}
		$linea++;
		
      }    
	  //aca poner insert
	  if(!strlen(trim($errorLog)) > 0){
		 $return= $Model -> setInsertDetalles_Solicitud($consulsql,$solicitud_id,$cliente_id,$this -> getConex());   
		 if(!$return) print 'Hay un error subiendo los registros';
	  }
    
    }
	if(strlen(trim($errorLog)) > 0){
		print $errorLog;
	}


  }


  
  protected function setContactos(){

	require_once("SolicitudServiciosLayoutClass.php");
	require_once("SolicitudServiciosModelClass.php");
	
	$Layout = new SolicitudServiciosLayout($this -> getTitleTab(),$this -> getTitleForm());
        $Model  = new SolicitudServiciosModel();
		
	$cliente_id   = $_REQUEST['cliente_id'];
	$solicitud_id = $_REQUEST['solicitud_id'];
	
	$contactos  = $Model -> getContactos($cliente_id,$solicitud_id,$this -> getConex());
		
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
			table	=>array('solicitud_servicio_guia'),
			type	=>array('column'))		 
	 );	
	 
	 print $Layout -> getObjectHtml($field);

  }
  
  protected function onclickValidateRow(){

    require_once("../../../framework/clases/ValidateRowClass.php");

    $Data = new ValidateRow($this -> getConex(),"solicitud_servicio_guia",$this ->Campos);

    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){

    require_once("SolicitudServiciosModelClass.php");
    $Model = new SolicitudServiciosModel();
	
    $result = $Model -> Save($this -> Campos,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       $this -> getArrayJSON($result);
	 }	
  }

  protected function onclickUpdate(){
    require_once("SolicitudServiciosModelClass.php");
	$Model = new SolicitudServiciosModel();
	
	$Model -> Update($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  	require_once("SolicitudServiciosModelClass.php");
        $Model = new SolicitudServiciosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Solicitud');
	}
  }
  
  protected function onchangeSetOptionList(){
	  
    require_once("../../../framework/clases/ListaDependiente.php");
			
    $list = new ListaDependiente($this -> getConex(),'contacto_id',array(table=>'contacto',
	                                value=>'contacto_id',text=>'nombre_contacto',concat=>'-',
									order=>'nombre_contacto'),$this -> Campos);		

    $list -> getList();
	  
  }   

  	public function validaRango(){
		require_once("SolicitudServiciosModelClass.php");
		$Model = new SolicitudServiciosModel();
		$solicitud_id	= $_REQUEST['solicitud_id'];
		$oficina_id		= $_REQUEST['oficina_id'];
		$response=$Model -> validaRango($solicitud_id,$oficina_id,$this -> getConex());
		return $response;
	}


//BUSQUEDA
  protected function onclickFind(){

    require_once("SolicitudServiciosModelClass.php");

    $Model     = new SolicitudServiciosModel();
    $Solicitud = $_REQUEST['solicitud_id'];
    $Data      =  $Model -> selectSolicitud($Solicitud,$this -> getConex());

    $this -> getArrayJSON($Data);	

  }
	
	
}

$SolicitudServicios = new SolicitudServicios();

?>