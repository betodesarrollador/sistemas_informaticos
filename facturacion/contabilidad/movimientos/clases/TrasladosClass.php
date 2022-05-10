<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Traslados extends Controler{
	
	public function __construct(){
		parent::__construct(3);    
	}
	
	public function Main(){
		
		$this -> noCache();
		
		require_once("TrasladosLayoutClass.php");
		require_once("TrasladosModelClass.php");
		require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
		
		$Layout              = new TrasladosLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model               = new TrasladosModel();
		$utilidadesContables = new UtilidadesContablesModel();  
		
		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());		
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
		$Layout -> setCampos($this -> Campos);
		
		//LISTA MENU
		
		$Layout -> setDocumentos($Model -> getDocumentos($this -> getConex()));		
		$Layout -> RenderMain();	  
		
	}
    
	protected function onclickGenerarAuxiliar(){
		
		$agrupar    = $this -> requestData('opciones_tercero');
		

	require_once("TrasladosLayoutClass.php");
	require_once("TrasladosModelClass.php");
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new TrasladosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new TrasladosModel();	
	$utilidadesContables = new UtilidadesContablesModel();	

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
    $Layout -> setJsInclude("../../../framework/js/funciones.js");					
    $Layout -> setJsInclude("../js/librosauxiliaresReporte.js");				

    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
		
	$empresa_id          = $this -> getEmpresaId();
	$oficina_id          = $this -> getOficinaId();
	$usuario_id          = $this -> getUsuarioId();

	$documentos          = $this -> requestData('documentos');
	$tercero_id          = $this -> requestData('tercero_id');
	$cuenta_desde_id     = $this -> requestData('cuenta_desde_id');
	$cuenta_hasta_id     = $this -> requestData('cuenta_hasta_id');
	$desde               = $this -> requestData('desde');
	$hasta               = $this -> requestData('hasta');	
	$fecha_doc           = $this -> requestData('fecha_doc');		
	$empresa             = $this -> getEmpresaNombre();
	$nitEmpresa          = $this -> getEmpresaIdentificacion();
	$fechaProcesado      = date("Y-m-d");
	$horaProcesado       = date("H:i:s");
	
	$periodo_contable_id= $utilidadesContables -> getPeriodoContableId($fecha_doc,$this  -> getConex());
	$mes_contable_id= $utilidadesContables -> getMesContableId($fecha_doc,$periodo_contable_id,$this  -> getConex());

	$consecutivo= $utilidadesContables -> getConsecutivo($oficina_id,$documentos,$periodo_contable_id,$this  -> getConex());

	$tercero_enc= $Model -> getEmpTercero($empresa_id,$this  -> getConex());
	$natuorigen= $Model -> naturalezaorigen($cuenta_desde_id,$this  -> getConex());
	$arrayResult= $Model -> selectSaldoCuentaTercero($cuenta_desde_id,$desde,$hasta,$this  -> getConex());
	$saldo_total=0;
	$insert_enc='';
	$insert=array();
	$insert1=array();
	$acumula=0;
	if(count($arrayResult)>0){  
		$encabezado_registro_id = $Model ->DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$this  -> getConex(),true,1);

		for($i = 0; $i < count($arrayResult); $i++){
			$tercero_ori = $arrayResult[$i][tercero_id];
			$identificacion_ori= $utilidadesContables->getNumeroIdentificacionTercero($tercero_ori,$this  -> getConex());
			$digito_ori= $utilidadesContables->getDigitoVerificacionTercero($tercero_ori,$this  -> getConex());	
			$digito_ori= $digito_ori!='' ? $digito_ori : 'NULL';
			$centro_de_costo_id = $arrayResult[$i][centro_de_costo_id];
			$codigo_centro_costo = $arrayResult[$i][codigo_centro_costo]!='' ? "'".$arrayResult[$i][codigo_centro_costo]."'" : "(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id=$centro_de_costo_id)";
			$valor=$arrayResult[$i][saldo];
			$acumula=$acumula+$arrayResult[$i][saldo];
			
			if($this -> requestData('opciones_tercero') == 'T'){
				$tercero_des = $arrayResult[$i][tercero_id];
				$identificacion_des= $utilidadesContables->getNumeroIdentificacionTercero($tercero_des,$this  -> getConex());
				$digito_des= $utilidadesContables->getDigitoVerificacionTercero($tercero_des,$this  -> getConex());
				
			}else if($this -> requestData('opciones_tercero') == 'U'){
				$tercero_des = $tercero_id;
				$identificacion_des= $utilidadesContables->getNumeroIdentificacionTercero($tercero_des,$this  -> getConex());
				$digito_des= $utilidadesContables->getDigitoVerificacionTercero($tercero_des,$this  -> getConex());		
			}
			$digito_des= $digito_des!='' ? $digito_des : 'NULL';
			if($natuorigen=='D'){
				$debito=0;
				$credito = $arrayResult[$i][saldo];
				
				$debito1=$arrayResult[$i][saldo];
				$credito1 = 0;
				
			}else{
				$debito= $arrayResult[$i][saldo];
				$credito =0;

				$debito1= 0;
				$credito1 =$arrayResult[$i][saldo];
			}
			$insert[$i]="$tercero_ori,$identificacion_ori,$digito_ori,
														  $cuenta_desde_id,'TRASLADO SALDO',$encabezado_registro_id,$centro_de_costo_id,$codigo_centro_costo,
														  '$valor','$debito','$credito');";
			

			$insert1[$i]="$tercero_des,$identificacion_des,$digito_des,
														  $cuenta_hasta_id,'TRASLADO SALDO',$encabezado_registro_id,$centro_de_costo_id,$codigo_centro_costo,
														  '$valor','$debito1','$credito1');";
			
		}
		$insert_enc="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,tercero_id,
														 periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,
														 modifica,usuario_id )
		VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$documentos,$acumula,$tercero_enc,$periodo_contable_id,$mes_contable_id,$consecutivo,
			   '$fecha_doc','TRASLADO SALDO',$cuenta_hasta_id,'C','$fechaProcesado $horaProcesado','".$this -> getUsuarioNombres()."',$usuario_id);";
		
		$result = $Model -> Save($encabezado_registro_id,$insert_enc,$insert,$insert1,$this  -> getConex());
		
		if($result>0){
			$this->viewDocument($result); 
		}

	 }else{
		exit('Cuenta Origen sin Registros durante el Periodo Seleccionado'); 
	 }

	

  }  
  
  

  
  protected function viewDocument($encabezado_registro_id){
    
    require_once("View_DocumentClass.php");
	
    $print   = new View_Document();  	
    $print -> printOut1($encabezado_registro_id,$this -> getConex()); 	  
  
  }
  
  protected function onclickPrint(){

    $agrupar = $this -> requestData('agrupar');	
	
	if($agrupar == 'defecto'){
	  $this -> getAuxiliarDefecto(true,false);
	}else if($agrupar == 'cuenta'){
	     $this -> getAuxiliarCuenta(true,false);
	  }
 
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
	
	
	
	
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
        value   =>'',
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
        value   =>'',
		datatype=>array(
			type	=>'date')
	);	

	$this -> Campos[fecha_doc] = array(
		name	=>'fecha_doc',
		id		=>'fecha_doc',
		type	=>'text',
		required=>'yes',
        value   =>'',
		datatype=>array(
			type	=>'date')
	);	

	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		required=>'yes',
        options =>array(array(value=>'T',text=>'SI'),array(value=>'U',text=>'NO')),
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
		datatype=>array(
			type	=>'numeric')
	);
	
	$this -> Campos[documentos] = array(
		name	=>'documentos',
		id		=>'documentos',
		type	=>'select',
        required=>'yes',		
		selected=>'NULL',
        options =>array(),
		datatype=>array(
			type	=>'integer')
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

	$this -> Campos[cuenta_desde_id] = array(
		name	=>'cuenta_desde_id',
		id		=>'cuenta_desde_hidden',
		type	=>'hidden',
		required=>'yes'			
	);				

	$this -> Campos[encabezado_registro_id] = array(
		name	=>'encabezado_registro_id',
		id		=>'encabezado_registro_id',
		type	=>'hidden'		
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
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new Traslados();

?>