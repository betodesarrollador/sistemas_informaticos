<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ControlDocumental extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
	     
    $this -> noCache();
    
	require_once("ControlDocumentalLayoutClass.php");
	require_once("ControlDocumentalModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	

	
	$Layout              = new ControlDocumentalLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new ControlDocumentalModel();
    $utilidadesContables = new UtilidadesContablesModel();  
	  
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());		
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU

	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this -> getConex()));		
	$Layout -> setDocumentos($utilidadesContables -> getDocumentos($this -> getConex()));		
	$Layout -> RenderMain();	  
	  
  }
    
  protected function onclickGenerarAuxiliar($print = false){
	  
	  require_once("ControlDocumentalLayoutClass.php");
	require_once("ControlDocumentalModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	

	
	$Layout              = new ControlDocumentalLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new ControlDocumentalModel();
    $utilidadesContables = new UtilidadesContablesModel();  
	
    
    $documentos = $this -> requestData('documentos');	
	$desde      = $this -> requestData('desde');
	$hasta      = $this -> requestData('hasta');		
	
	$print      = $this -> requestData('print');		
	$export     = $this -> requestData('exportar');		

      $arrayReport = array();
      $Conex       = $this  -> getConex();
	 
	 
	  $arrayReport  = $Model -> selectDocumentos($desde,$hasta,$documentos,$Conex);																 		
		  
		  	  

      $Layout -> setVar('REPORTE',$arrayReport);	
	  	  
	  if($print=='true'){
           $Layout -> exportToPdf('Imp_ControlDocumental.tpl');		  										 	  
	  }else if($export=='true'){
	     $Layout -> exportToExcel('ControlDocumentalReporteExcel.tpl');
	  }else{
    	$Layout -> RenderLayout('ControlDocumentalReporte.tpl');
	  }
	  	
	
	  
	  
	

  }  
  
  
  protected function viewDocument(){
    
    require_once("View_DocumentClass.php");
	
    $print   = new View_Document();  	
    $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getConex()); 	  
  
  }
  
  protected function onclickPrint(){

    $this -> onclickGenerarAuxiliar(true);
  }  
  
  protected function onclickExport(){

    $agrupar = $this -> requestData('agrupar');	
	
	if($agrupar == 'defecto'){
	  $this -> getAuxiliarDefecto(false,true);
	}else if($agrupar == 'cuenta'){
	     $this -> getAuxiliarCuenta(false,true);
	  }

  }
  
  protected function setCampos(){

    /*****************************************
            	 datos sesion
	*****************************************/  

	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	
	
	$this -> Campos[opciones_centros] = array(
		name	=>'opciones_centros',
		id		=>'opciones_centros',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);		
	
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
	
	
	$this -> Campos[reporte] = array(
		name	=>'reporte',
		id		=>'reporte',
		type	=>'select',
		required=>'yes',
		size    =>'3',
        options =>array(array(value=>'O',text=>'OFICINA'),array(value=>'C',text=>'CENTRO COSTO')),
		selected=>'C',
		datatype=>array(
			type	=>'alpha')
	);
	
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'text',
		required=>'yes',
		size    =>'3',
        value   =>4,
		datatype=>array(
			type	=>'integer')
	);	
	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		required=>'yes',
        options =>array(array(value=>'T',text=>'TODOS'),array(value=>'U',text=>'UNO')),
        selected=>'T',		
		datatype=>array(
			type	=>'alpha')
	);	
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		disabled=>'yes',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_hidden')
	);
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_hidden',
		type	=>'hidden',
		//required=>'yes',
		datatype=>array(
			type	=>'numeric')
	);
	
	$this -> Campos[documentos] = array(
		name	=>'documentos',
		id		=>'documentos',
		type	=>'select',
		size    =>'3',
		multiple=>'yes',
        required=>'yes',		
		selected=>'NULL',
        options =>array(),
		datatype=>array(
			type	=>'integer')
	);	
	
	$this -> Campos[opciones_documentos] = array(
		name	=>'opciones_documentos',
		id		=>'opciones_documentos',
		type	=>'checkbox',
		value   =>'U',
		datatype=>array(type=>'text')
	);					
			
	$this -> Campos[cuenta_desde] = array(
		name	=>'cuenta_desde',
		id		=>'cuenta_desde',
		type	=>'text',
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'cuenta_desde_hidden',
			onclick =>'setCuentaHasta')		
			
	);

	$this -> Campos[opciones_cuentas] = array(
		name	=>'opciones_cuentas',
		id		=>'opciones_cuentas',
		type	=>'checkbox',
		value   =>'R',
	    datatype=>array(type=>'text')
	);		

	
	$this -> Campos[cuenta_desde_id] = array(
		name	=>'cuenta_desde_id',
		id		=>'cuenta_desde_hidden',
		type	=>'hidden',
		required=>'yes'			
	);				
	
	$this -> Campos[cuenta_hasta] = array(
		name	=>'cuenta_hasta',
		id		=>'cuenta_hasta',
		type	=>'text',	
		datatype=>array(type=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'cuenta_hasta_hidden')		
	);	
	
	$this -> Campos[cuenta_hasta_id] = array(
		name	=>'cuenta_hasta_id',
		id		=>'cuenta_hasta_hidden',
		type	=>'hidden',	
		required=>'yes'							
	);					
	
	
	//botones
	
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'onclickGenerarAuxiliar(this.form)'
	);		
	
    $this -> Campos[imprimir] = array(
      name    =>'imprimir',
      id      =>'imprimir',
      type    =>'print',
      value   =>'Imprimir',
	  displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
              title       => 'Impresion Libro Auxiliar',
              width       => '900',
              height      => '600'
      )

    );	
	
    $this -> Campos[export] = array(
      name    =>'export',
      id      =>'export',
      type    =>'button',
      value   =>'Exportar a Excel'
    );	

    $this -> Campos[export_excel] = array(
      name    =>'export_excel',
      id      =>'export_excel',
      type    =>'button',
      value   =>'Excel Consolidado'
    );	

	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new ControlDocumental();

?>