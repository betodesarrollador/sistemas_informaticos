<?php
require_once("../../../framework/clases/ControlerClass.php");
final class CargaNomina extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
	     
    $this -> noCache();
    
    require_once("CargaNominaLayoutClass.php");  
    require_once("CargaNominaModelClass.php");
	
    $Layout = new CargaNominaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new CargaNominaModel();
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir		($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
    $Layout -> SetAnular		($Model -> getPermiso($this -> getActividadId(),ANULAR,$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));	
    $Layout -> setTiposDocumento($Model -> getTiposDocumento($this -> getConex()));	
    $Layout -> setFormaPago($Model -> getFormasPago($this -> getConex()));		
    $Layout -> setUsuarioModifica($this -> getUsuarioNombres());			
    $Layout -> setUsuarioId($this -> getUsuarioId());		
    $Layout -> setCausalesAnulacion($Model -> getCausalesAnulacion($this -> getConex()));
			
    $Layout -> RenderMain();	  
	  
  }
  
  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }
  protected function onclickSave(){
    
    require_once("CargaNominaModelClass.php");
    $Model = new CargaNominaModel();
	$this -> upload_max_filesize("2048M");
    
	$archivoPOST     = $_FILES['archivo'];
	$rutaAlmacenar   = "../../../archivos/contabilidad/nomina/";
    $dir_file        = $this -> moveUploadedFile($archivoPOST,$rutaAlmacenar,"archivoNomina");   
	$camposArchivo   = $this -> excelToArray($dir_file,'ALL');	
	
	$empresa_id             = $_REQUEST['empresa_id'];
	$oficina_id             = $_REQUEST['oficina_id'];
	$estado                 = $_REQUEST['estado'];
	$fecha                  = $_REQUEST['fecha'];
	$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	$modifica               = $_REQUEST['modifica'];
	$nombreModifica         = explode(" ",$modifica);

	$scan_documento = $_FILES['scan_documento'];
	$nombre = $_FILES['scan_documento']['name'];
		
		if($nombre!=''){
			$nombre_documento = 'scan_documento_'.rand();
			$dir_file  = $this -> moveUploadedFile($scan_documento,'../../../imagenes/contabilidad/movimientos/',$nombre_documento);
		}else{
			$dir_file = '';
		}
	
	if($estado == 'C' && $encabezado_registro_id == 'NULL'){
	  exit('<b>'.$nombreModifica[0].'</b> no se permite Contabilizar este registro aun ');				
    }else{
		
  	    $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
 	    $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	  	  
         if($mesContable && $periodoContable){
			 
           $return = $Model -> Save($dir_file,$this -> getOficinaId(),$this -> Campos,$camposArchivo,$this -> getUsuarioId(),$this -> getConex());
	
           if(strlen(trim($Model -> GetError())) > 0){
	         exit("Error : ".$Model -> GetError());
	       }else{
              $this -> getArrayJSON($return);	        
			}	
			 
         }else{
			 
			 if(!$mesContable && !$periodoContable){
			   exit("No se permite guardar en el periodo y mes seleccionado ");
			 }elseif(!$mesContable){
 			       exit("No se permite guardar en el mes seleccionado");				 
			   }else if(!$periodoContable){
			         exit("No se permite guardar en el periodo seleccionado");				   
				 }
			 
		   }
		
       }
	
  }
  protected function onclickUpdate(){
  
    require_once("CargaNominaModelClass.php");
	
	$Model                  = new CargaNominaModel();
	$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	$estado                 = trim($_REQUEST['estado']);
	$empresa_id             = $_REQUEST['empresa_id'];
	$oficina_id             = $_REQUEST['oficina_id'];
	$fecha                  = $_REQUEST['fecha'];

	$scan_documento = $_FILES['scan_documento'];
	$nombre = $_FILES['scan_documento']['name'];
		
		if($nombre!=''){
			$nombre_documento = 'scan_documento_'.rand();
			$dir_file  = $this -> moveUploadedFile($scan_documento,'../../../imagenes/contabilidad/movimientos/',$nombre_documento);
		}else{
			$dir_file = '';
		}
	
	if($estado == 'C'){
		
  	  $mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
 	  $periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	  	  
      if($mesContable && $periodoContable){
			 
        if($Model -> registroTieneMovimientos($encabezado_registro_id,$this -> getConex())){
	
          if($Model -> registroTieneSumasIguales($encabezado_registro_id,$this -> getConex())){
            $return = $Model -> Update($dir_file,$this -> Campos,$this -> getConex());
	
            if(strlen(trim($Model -> GetError())) > 0){
	          exit("Error : ".$Model -> GetError());
	        }else{
		          exit('true');
	         }	
		
   	       }else{
	         exit('no existen sumas iguales :<b>NO SE CONTABILIZARA</b>');
	        }
	   
	   }else{
   	         exit('no existen registros :<b>NO SE CONTABILIZARA</b>');
	     }
			 
       }else{
			 
		  if(!$mesContable && !$periodoContable){
			exit("No se permite guardar en el periodo y mes seleccionado ");
		  }elseif(!$mesContable){
 			  exit("No se permite guardar en el mes seleccionado");				 
			}else if(!$periodoContable){
			    exit("No se permite guardar en el periodo seleccionado");				   
			  }
			 
		  }		
			 
	 }else{
	 
	      $Model -> Update($dir_file,$this -> Campos,$this -> getConex());
	
          if($Model -> GetNumError() > 0){
            exit('false');
          }else{
              exit('true');
	        }
	 
	 
	   }
	 
  }
  
  protected function getEstadoEncabezadoRegistro($Conex=''){
	  
  	require_once("CargaNominaModelClass.php");
	
    $Model                  = new CargaNominaModel();
	$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];	
	
	$Estado = $Model -> selectEstadoEncabezadoRegistro($encabezado_registro_id,$this -> getConex());
	
	exit("$Estado");
	  
  } 
	  
  protected function onclickCancellation(){
  
  	require_once("CargaNominaModelClass.php");
	
    $Model = new CargaNominaModel();
	
	$Model -> cancellation($this -> getConex());
	
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}
	
  }
  
  protected function preView(){
	  
	require_once("CargaNominaLayoutClass.php");
	require_once("CargaNominaModelClass.php");
    require_once("ImputacionesContablesModelClass.php");
	
	$Layout   = new CargaNominaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model_1  = new CargaNominaModel();	 
    $Model_2  = new ImputacionContableModel();	
	
	$encabezado_registro_id = $this -> requestData('encabezado_registro_id');
	$encabezadoRegistro     = $Model_1 -> getEncabezadoRegistro($encabezado_registro_id,$this -> getConex());
	$movimientosContables   = $Model_2 -> getImputacionesContables($encabezado_registro_id,$this -> getConex());
	
    $Layout -> setCssInclude("../css/movimientoscontables.css");	 	 
	 	 
    $Layout -> assign("CSSSYSTEM",	  $Layout -> getCssInclude());	
    $Layout -> setVar("ENCABEZADOID", $encabezadoRegistro[0]['encabezado_registro_id']);
    $Layout -> setVar("CONSECUTIVO",  $encabezadoRegistro[0]['consecutivo']);
    $Layout -> setVar("EMPRESA",      $encabezadoRegistro[0]['empresa']);	
    $Layout -> setVar("OFICINA",      $encabezadoRegistro[0]['oficina']);		
    $Layout -> setVar("FECHA",		  $encabezadoRegistro[0]['fecha']);
	$Layout -> setVar("CONCEPTO",	  $encabezadoRegistro[0]['concepto']);
	$Layout -> setVar("ESTADO",	      $encabezadoRegistro[0]['estado']);
	$Layout -> setVar("FECHAREGISTRO",$encabezadoRegistro[0]['fecha']);
	$Layout -> setVar("DOCUMENTO"    ,$encabezadoRegistro[0]['documento']);	
	$Layout -> setVar("VALOR"        ,$encabezadoRegistro[0]['valor']);		
	$Layout -> setVar("FPAGO"        ,$encabezadoRegistro[0]['forma_pago']);			
	$Layout -> setVar("TEXTOSOPORTE" ,$encabezadoRegistro[0]['texto_soporte']);				
	$Layout -> setVar("NUMSOPORTE"   ,$encabezadoRegistro[0]['numero_soporte']);					
	$Layout -> setVar("TEXTOTERCERO" ,$encabezadoRegistro[0]['texto_tercero']);						
	$Layout -> setVar("TERCERO"      ,$encabezadoRegistro[0]['tercero']);							
	$Layout -> setVar("PUC"          ,$encabezadoRegistro[0]['puc']);									
	
    $Layout -> setVar("IMPUTACIONES", $movimientosContables);		
	
    $Layout	-> RenderLayout('preview.tpl');
	  
  }
  
//BUSQUEDA
  protected function onclickFind(){
  	require_once("CargaNominaModelClass.php");
    $Model = new CargaNominaModel();
    $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
		
    $Data = $Model -> getEncabezadoRegistro($encabezado_registro_id,$this -> getConex());
    $this -> getArrayJSON($Data);
  }
  
  protected function onchangeSetOptionList(){
	  
    require_once("CargaNominaLayoutClass.php");  
	require_once("CargaNominaModelClass.php");	
    require_once("../../../framework/clases/ListaDependiente.php");    
	
    $Layout = new CargaNominaLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new CargaNominaModel();
	
	if(isset($_REQUEST['empresa_id'])){
  	  $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
                                   'codigo_centro,nombre',concat=>'-',order=>'codigo_centro,nombre'),$this -> Campos);		
    }else if(isset($_REQUEST['periodo_contable_id'])){
  	      $list = new ListaDependiente($this -> getConex(),'mes_contable_id',array(table=>'mes_contable',value=>'mes_contable_id',
																			 text=>'mes,nombre',concat=>'-'),$this -> Campos);	
	  }else if(isset($_REQUEST['forma_pago_id'])){
  	         /*$list = new ListaDependiente($this -> getConex(),'puc_id',array(table=>'cuenta_tipo_pago',value=>'cuenta_tipo_pago_id',
																			 text=>'puc_id',concat=>'-'),$this -> Campos);	*/
																			 
		      $forma_pago_id = $this -> requestData('forma_pago_id');															 
              $data          = $Model -> selectCuentasFormaPago($forma_pago_id,$this -> getConex());																			 
			  
				$field[puc_id] = array(
					name	=>'puc_id',
					id		=>'puc_id',
					type	=>'select',
					options	=>$data,
					datatype=>array(
						type	=>'integer'),
					transaction=>array(
						table	=>array('encabezado_de_registro'),
						type	=>array('column'))	
				);
				
				
				print $Layout -> getObjectHtml($field[puc_id]);
			  
			  
	  
	    }
	
	$list -> getList();
	  
  } 
  
  protected function setTitulosDocumento(){
	  
  	require_once("CargaNominaModelClass.php");
	
    $Model             = new CargaNominaModel();
	$tipo_documento_id = $_REQUEST['tipo_documento_id'];
	
	$data = $Model -> getTitulosDocumento($tipo_documento_id,$this -> getConex());
	
    $this -> getArrayJSON($data);
	  
  }
  
  protected function getTotalDebitoCredito(){
	  
  	require_once("CargaNominaModelClass.php");
	
    $Model = new CargaNominaModel();
	
	$encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	
	$data = $Model -> getTotalDebitoCredito($encabezado_registro_id,$this -> getConex());
	
	$this -> getArrayJSON($data);  
	  
  }
  
  protected function onclickPrint(){
    require_once("View_DocumentClass.php");
    $print = new View_Document();
    $print -> printOut($this -> getConex());  
  }  
    
  protected function setCampos(){
    /*****************************************
            	 datos sesion
	*****************************************/  
	
	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id		=>'fecha_registro',
		type	=>'hidden',
        value   =>date("Y-m-d H:m"),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);
	
	$this -> Campos[modifica] = array(
		name	=>'modifica',
		id		=>'modifica',
		type	=>'hidden',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
	
	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[fecha_registro_static] = array(
		name	=>'fecha_registro_static',
		id		=>'fecha_registro_static',
		type	=>'hidden',
        value   =>date("Y-m-d H:m"),
		datatype=>array(
			type	=>'text')
	);
	
	$this -> Campos[modifica_static] = array(
		name	=>'modifica_static',
		id		=>'modifica_static',
		type	=>'hidden',
		datatype=>array(
			type	=>'text')
	);	
	
	$this -> Campos[usuario_id_static] = array(
		name	=>'usuario_id_static',
		id		=>'usuario_id_static',
		type	=>'hidden',
		datatype=>array(
			type	=>'integer')
	);				
	
	/*****************************************/
	
	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden',
		required=>'no',
		value   =>$_REQUEST['encabezado_registro_id'],
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[consecutivo] = array(
		name	=>'consecutivo',
		id		=>'consecutivo',
		type	=>'text',
		Boostrap=>'si',
		value	=>'',
		size    =>'1',
		readonly=>'yes',
	    datatype=>array(
			type	=>'integer',
			length	=>'9'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);
	
	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		selected=>$this -> getEmpresaId(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9'),
        setoptionslist=>array(childId=>'oficina_id'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))	
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		selected=>$this -> getOficinaId(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
	
	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	    datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);
	
	$this -> Campos[periodo_contable_id] = array(
		name	=>'periodo_contable_id',
		id		=>'periodo_contable_id',
		Boostrap=>'si',
	    datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);
	
	$this -> Campos[mes_contable_id] = array(
		name	=>'mes_contable_id',
		id		=>'mes_contable_id',
		Boostrap=>'si',
	    datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
	
	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
	
	$this -> Campos[forma_pago_id] = array(
		name	=>'forma_pago_id',
		id		=>'forma_pago_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column')),
        setoptionslist=>array(childId=>'puc_id')	
	);		
	
	$this -> Campos[valor] = array(
		name	=>'valor',
		id		=>'valor',
		type	=>'text',
		Boostrap=>'si',
		value	=>'',
		size    =>'12',
		required=>'yes',
	    datatype=>array(
			type	=>'numeric',
			length	=>'15',
			presition=>'5'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_soporte] = array(
		name	=>'numero_soporte',
		id		=>'numero_soporte',
		type	=>'text',
		Boostrap=>'si',
		value	=>'',
	    datatype=>array(
			type	=>'text',
			length	=>'15',
			presition=>'5'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);		
		
	
	$this -> Campos[concepto] = array(
		name	=>'concepto',
		id		=>'concepto',
		type	=>'text',
		Boostrap=>'si',
		value	=>'',
		required=>'yes',
		size    =>'30',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
		
    $nombre_documento = 'scan_documento_'.rand();		
		
 	$this -> Campos[scan_documento] = array(
		name	=>'scan_documento',
		id		=>'scan_documento',
		type	=>'file',
		value	=>'',
		path	=>'imagenes/contabilidad/movimientos/',
		size	=>'70',
//		required=>'yes',		
		datatype=>array(
			type	=>'file'),
		namefile=>array(
			field	=>'yes',
			text	=> $nombre_documento)
	);		
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		Boostrap=>'si',
		size    => '50',
		suggest=>array(
			name	=>'tercero_disponible',
			setId	=>'tercero_hidden')
	);
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);		
	  
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'select',
		Boostrap=>'si',
		options =>array(),
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);			
		
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		disabled=>'disabled',
		options	=>array(
  				   array(value=>'E',text=>'EDICION',selected=>'E'),
				   array(value=>'C',text=>'CONTABILIZADO')),
		datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
	
	$this -> Campos[anulado] = array(
		name	=>'anulado',
		id		=>'anulado',	
		type	=>'hidden',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('encabezado_de_registro'),
			type	=>array('column'))
	);	
		
		
	/*****************************************
	        Campos Anulacion Registro
	*****************************************/
	
	
	$this -> Campos[fecha_log] = array(
		name	=>'fecha_log',
		id		=>'fecha_log',
		type	=>'text',
		size    =>'17',
        value   =>date("Y-m-d H:m"),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('log_registro_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[causal_anulacion_id] = array(
		name	=>'causal_anulacion_id',
		id		=>'causal_anulacion_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('log_registro_contable'),
			type	=>array('column'))
	);		
	
	
	$this -> Campos[observaciones] = array(
		name	=>'observaciones',
		id		=>'observaciones',
		type	=>'textarea',
		value	=>'',
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('log_registro_contable'),
			type	=>array('column'))
	);	
	
	$this -> Campos[archivo]  = array(
		name	=>'archivo',
		id		=>'archivo',
		type	=>'file',
		required=>'yes',
        title     =>'Carga de Archivos Clientes',
		
	);
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value   =>'Continuar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'CargaNominaOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CargaNominaOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
	    property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CargaNominaOnDelete')
	);
	
   	$this -> Campos[anular] = array(
		name	=>'anular',
		id		=>'anular',
		type	=>'button',
		value	=>'Anular',
		onclick =>'onclickCancellation(this.form)'
	);	
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick => 'CargaNominaOnReset()'
	);	
	
   	$this -> Campos[contabilizar] = array(
		name	=>'contabilizar',
		id		=>'contabilizar',
		type	=>'button',
		value	=>'Contabilizar',
		onclick =>'OnclickContabilizar(this.form)'
	);		
	
   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id		   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	    displayoptions => array(
                  form        => 0,
                  beforeprint => 'beforePrint',
		  title       => 'Impresion Comprobantes Contables',
		  width       => '900',
		  height      => '600'
		)
	);	
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'movimientos_contables',
			setId	=>'encabezado_registro_id',
			onclick	=>'setDataFormWithResponse')
	);	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}
new CargaNomina();
?>