<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TarifasRutaCubicaje extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[solicitud_servicio_tarifar_id] = array(
		name	=>'solicitud_servicio_tarifar_id',
		id		=>'solicitud_servicio_tarifar_id',
		type	=>'text',
		required=>'no',
		readonly=>'readonly',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('solicitud_servicio_tarifar'),
			type	=>array('primary_key'))
	);	
	
	$this -> Campos[fecha_static] = array(
		name	=>'fecha_static',
		id	    =>'fecha_static',
		type	=>'hidden',
		value	=>date("Y-m-d"),
	    datatype=>array(
			type	=>'text')
	);	
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id	    =>'fecha',
		type	=>'text',
		value	=>date("Y-m-d"),
		readonly=>'true',
	    datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('solicitud_servicio_tarifar'),
			type	=>array('column'))
	);

	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id	=>'oficina_id',
		type	=>'hidden',
		value	=>$this -> getOficinaId(),
	    datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('solicitud_servicio_tarifar'),
			type	=>array('column'))
	);

	$this -> Campos[oficina_id_hidden] = array(
		name	=>'oficina_id_hidden',
		id	=>'oficina_id_hidden',
		type	=>'hidden',
		value	=>$this -> getOficinaId(),
	    datatype=>array(type=>'integer')
	);
	
	
	$this -> Campos[oficina] = array(
		name	=>'oficina',
		id	=>'oficina',
		type	=>'text',
		readonly=>'yes',
		value	=>$this -> getOficina(),
	    datatype=>array(
			type	=>'text')
	);	
		
	$this -> Campos[oficina_hidden] = array(
		name	=>'oficina_hidden',
		id	=>'oficina_hidden',
		type	=>'hidden',
		value	=>$this -> getOficina(),
	    datatype=>array( type =>'text')
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
			table	=>array('solicitud_servicio_tarifar'),
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
			onsuccess=>'CalculoTarifasRutaCubicajeOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CalculoTarifasRutaCubicajeOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CalculoTarifasRutaCubicajeOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	    =>'limpiar',
		id	    =>'limpiar',
		type	    =>'reset',
		value	    =>'Limpiar',
		onclick     =>'CalculoTarifasRutaCubicajeOnReset()'
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
			name	=>'busca_solicitud_servicio_tarifar',
			setId	=>'solicitud_servicio_tarifar_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache();
	   
    require_once("CalculoTarifasRutaCubicajeLayoutClass.php");
    require_once("CalculoTarifasRutaCubicajeModelClass.php");
	
    $Layout   = new CalculoTarifasRutaCubicajeLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CalculoTarifasRutaCubicajeModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
		
	//LISTA MENU
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    		
	
	//// GRID ////
    $Attributes = array(
      id		=>'TarifasRutaCubicaje',
      title		=>'Solicitud Servicio de Transporte',
      sortname	=>'fecha_ss',
      sortorder	=>'desc',
      rowId		=>'solicitud_servicio_tarifar_id',
      width		=>'auto',
      height	=>'250'
    );

    $Cols = array(
      array(name=>'solicitud_servicio_tarifar_id',			index=>'solicitud_servicio_tarifar_id',		sorttype=>'text',	width=>'50',	align=>'center'),
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

    require_once("CalculoTarifasRutaCubicajeModelClass.php");

    $Model         = new CalculoTarifasRutaCubicajeModel();
    $ruta          = "../";
    $archivo       = $_FILES['archivo_solicitud'];
    $nombreArchivo = "solicitud_servicio_tarifar_".rand();    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);
    $camposArchivo = $this -> excelToArray($dir_file,$rowLimit = 0);
    $cliente_id    = $_REQUEST['cliente_id'];
	$solicitud_servicio_tarifar_id  = $_REQUEST['solicitud_servicio_tarifar_id'];
    
    $errorLog      = '';
    
    if($Model -> archivoEstaParametrizado($cliente_id,$camposArchivo,$this -> getConex())){
    
      $arrayInsert = $this -> getArrayInsert($dir_file);          
      $linea       = 2;
	  
      for($i = 0; $i < count($arrayInsert) - 1; $i++){
	  
	    $errorLogTmp = '';
				
        $errorLogTmp = $Model -> setInsertDetalleSolicitud($arrayInsert[$i],$solicitud_servicio_tarifar_id,$cliente_id,$this -> getConex());      
		
		if(strlen(trim($errorLogTmp)) > 0){
		  $errorLog .= "LINEA[ $linea ] : $errorLogTmp\n";
		}
		
		$linea++;
		
      }      
    
    }
		
    print $errorLog;
	

  }
    
  protected function onclickValidateRow(){

    require_once("../../../framework/clases/ValidateRowClass.php");

    $Data = new ValidateRow($this -> getConex(),"solicitud_servicio_tarifar",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
	
  }

  protected function onclickSave(){
  
    require_once("CalculoTarifasRutaCubicajeModelClass.php");
    $Model = new CalculoTarifasRutaCubicajeModel();
	
    $result = $Model -> Save($this -> Campos,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       $this -> getArrayJSON($result);
	 }	
  }

  protected function onclickUpdate(){
  
    require_once("CalculoTarifasRutaCubicajeModelClass.php");
	$Model = new CalculoTarifasRutaCubicajeModel();
	
	$Model -> Update($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
	  
  }
	  
  protected function onclickDelete(){
  	require_once("CalculoTarifasRutaCubicajeModelClass.php");
        $Model = new CalculoTarifasRutaCubicajeModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la Solicitud');
	}
  }


//BUSQUEDA
  protected function onclickFind(){

    require_once("CalculoTarifasRutaCubicajeModelClass.php");

    $Model                         = new CalculoTarifasRutaCubicajeModel();
    $solicitud_servicio_tarifar_id = $_REQUEST['solicitud_servicio_tarifar_id'];		
    $Data                          =  $Model -> selectTarifasRutaCubicaje($solicitud_servicio_tarifar_id,$this -> getConex());

    $this -> getArrayJSON($Data);	

  }
  
  protected function calcularTarifasOrdenCliente(){
    
    require_once("CalculoTarifasRutaCubicajeModelClass.php");
	require_once("CalculoTarifasRutaCubicajeLayoutClass.php");

    $Model                         = new CalculoTarifasRutaCubicajeModel();
	$Layout                        = new CalculoTarifasRutaCubicajeLayout();
	$cliente_id                    = $_REQUEST['cliente_id'];		
    $solicitud_servicio_tarifar_id = $_REQUEST['solicitud_servicio_tarifar_id'];		

    $ordenes_cliente_calcular           = $Model -> selectDataOrdenCliente($solicitud_servicio_tarifar_id,$this -> getConex());	
	$tarifas_ruta_cubicaje_calculada_id = '';
	
	$Model -> clearTarifaOrdenCliente($solicitud_servicio_tarifar_id,$this -> getConex());
	
	for($i = 0; $i < count($ordenes_cliente_calcular); $i++){	
	
	   $tarifa_ruta_cubicaje_calculada_id = $Model -> setTarifaOrdenCliente($solicitud_servicio_tarifar_id,$cliente_id,$ordenes_cliente_calcular[$i]
	   ,$this -> getConex());
	
	   if(is_numeric($tarifa_ruta_cubicaje_calculada_id)){
	   
	     $tarifas_ruta_cubicaje_calculada_id .= "$tarifa_ruta_cubicaje_calculada_id,";
	   
	   }			   
	   
	}
		
	$tarifas_ruta_cubicaje_calculada_id = substr($tarifas_ruta_cubicaje_calculada_id,0,strlen($tarifas_ruta_cubicaje_calculada_id) -1);
	
	if(strlen(trim($tarifas_ruta_cubicaje_calculada_id)) > 0){
	
	  $ordenesCalculadas = $Model -> selectOrdenesCalculadas($tarifas_ruta_cubicaje_calculada_id,$this -> getConex());	  						
	
      $Layout -> setCssInclude("/velotax/transporte/operacion/css/solicitud_servicios.css");	
      $Layout -> setVar("DETALLES",$ordenesCalculadas);			
      $Layout -> RenderLayout('detalleCalculoTarifasRutaCubicaje.tpl');
	   
	
	}
  
  }
	
	
}

$TarifasRutaCubicaje = new TarifasRutaCubicaje();

?>