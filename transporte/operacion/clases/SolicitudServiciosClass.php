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
		required=>'no',
		disabled=>'yes',
		size	=>'8',		
		readonly=>'readonly',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_ss_final] = array(
		name	=>'fecha_ss_final',
		id		=>'fecha_ss_final',
		type	=>'text',
		//required=>'yes',
		//value	=>date("Y-m-d"),
		//tabindex=>'3',
	    datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
			type	=>array('column'))		 
	);
	
	$this -> Campos[tipo_liquidacion] = array(
		name	 =>'tipo_liquidacion',
		id		 =>'tipo_liquidacion',
		type	 =>'select',
		//required => 'yes',
		options  =>array(array(value => 'G', text => 'Cant/Gls'),array(value => 'P', text => 'Peso'),array(value => 'I', text => 'Peso Inicial'),array(value => 'F', text => 'Peso Final')
					,array(value => 'V', text => 'Volumen'),array(value => 'C', text => 'Cupo'),array(value => 'M', text => 'Peso Menor')),
	 	datatype=>array(type=>'text'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
	);

	
	$this -> Campos[tipo_servicio_id] = array(
		name	=>'tipo_servicio_id',
		id		=>'tipo_servicio_id',
		type	=>'select',
		options	=>null,
		selected=>'0',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
	);

	$this -> Campos[paqueteo] = array(
		name	=>'paqueteo',
		id		=>'paqueteo',
		type	=>'select',
		options	=>array(array(value=>'S',text=>'Paqueteo'),array(value=>'N',text=>'Masivo')),
		//selected=>'N',
		required=>'yes',
    	datatype=>array(
			type	=>'text',
			length	=>'1'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
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
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
	);

	$this -> Campos[archivo_solicitud] = array(
		name	  =>'archivo_solicitud',
		id	  =>'archivo_solicitud',
		type	  =>'upload',
                title     =>'Carga de Archivos Clientes',
                parameters=>'solicitud_id',
                beforesend=>'validaSeleccionSolicitud',
                onsuccess =>'onSendFile'
	);


	$this -> Campos[valor_facturar] = array(
		name	=>'valor_facturar',
		id		=>'valor_facturar',
		type	=>'text',
		size	=>'12',	
		required=>'yes',		
		//tabindex=>'3',
	    datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
		
	);

	$this -> Campos[valor_costo] = array(
		name	=>'valor_costo',
		id		=>'valor_costo',
		type	=>'text',
		size	=>'12',
		required=>'yes',		
		//tabindex=>'3',
	    datatype=>array(
			type	=>'numeric'),
				transaction=>array(
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
	);
	

	
	
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id	    =>'observaciones',
		type	=>'textarea',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('solicitud_servicio'),
			type	=>array('column'))
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
	
	$this -> Campos[imprimir] = array(
		name   =>'imprimir',
		id   =>'imprimir',
		type   =>'print',
		disabled=>'disabled',
		value   =>'Imprimir',
		displayoptions => array(
				  form        => 0,
				  beforeprint => 'beforePrint',
		  title       => 'Impresion Solicitud de servicio',
		  width       => '800',
		  height      => '600'
		)

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
			name	=>'busca_solicitud_servicio',
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
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

	
    if($_REQUEST['historico']=='si'){
		$Layout -> SetHistorico($Model -> GetHistorico	($_REQUEST['solicitud_id'],$this -> getConex()));  
		
	}else{
		$Layout -> setCampos($this -> Campos);
		
		//LISTA MENU
		$Layout -> SetTipoServicio($Model -> GetTipoServicio	($this -> getConex()));    
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
	}
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
    $ruta          = "../../../archivos/transporte/solicitud_servicios/";
    $archivo       = $_FILES['archivo_solicitud'];
    $nombreArchivo = "solicitud_servicio_".rand();    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);
    $camposArchivo = $this -> excelToArray($dir_file,$rowLimit = 0);
    //$cliente_id    = $_REQUEST['cliente_id'];
	$solicitud_id  = $_REQUEST['solicitud_id'];

	$cliente_id = $Model -> getClienteId($solicitud_id,$this -> getConex());

	//exit(print_r($_REQUEST));
    
    $errorLog      = '';
    
    if($Model -> archivoEstaParametrizado($cliente_id,$camposArchivo,$this -> getConex())){
    
      $arrayInsert = $this -> getArrayInsert($dir_file);          
      $linea       = 2;
	  
      for($i = 0; $i < count($arrayInsert) - 1; $i++){
	  
	    $errorLogTmp = '';
				
        $errorLogTmp = $Model -> setInsertDetalleSolicitud($arrayInsert[$i],$solicitud_id,$cliente_id,$this -> getConex());      
		
		if(strlen(trim($errorLogTmp)) > 0){
		  $errorLog .= "LINEA[ $linea ] : $errorLogTmp\n";
		}
		
		$linea++;
		
      }      
    
    }
		
    print $errorLog;
	

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
			table	=>array('solicitud_servicio'),
			type	=>array('column'))		 
	 );	
	 
	 print $Layout -> getObjectHtml($field);

  }
  
  protected function onclickValidateRow(){

    require_once("../../../framework/clases/ValidateRowClass.php");

    $Data = new ValidateRow($this -> getConex(),"solicitud_servicio",$this ->Campos);

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


//BUSQUEDA
  protected function onclickFind(){

    require_once("SolicitudServiciosModelClass.php");

    $Model     = new SolicitudServiciosModel();
    $Solicitud = $_REQUEST['solicitud_id'];
    $Data      =  $Model -> selectSolicitud($Solicitud,$this -> getConex());

    $this -> getArrayJSON($Data);	

  }
  
   protected function onclickPrint(){
  
    require_once("Imp_SolicitudClass.php");

    $print = new Imp_Solicitud($this -> getConex());

    $print -> printOut();
  
  }
	
	
}

$SolicitudServicios = new SolicitudServicios();

?>