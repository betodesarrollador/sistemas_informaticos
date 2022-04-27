<?php
require_once("../../../framework/clases/ControlerClass.php");

final class LibrosAuxiliares extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }

  public function Main(){
	     
    $this -> noCache();
    
	require_once("LibrosAuxiliaresLayoutClass.php");
	require_once("LibrosAuxiliaresModelClass.php");
	require_once("UtilidadesContablesModelClass.php");	
	
	$Layout              = new LibrosAuxiliaresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LibrosAuxiliaresModel();
    $utilidadesContables = new UtilidadesContablesModel();  
	  
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());		
    $Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU

	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this -> getConex()));		
	$Layout -> setDocumentos($utilidadesContables -> getDocumentos_sincierre($this -> getConex()));		
	$Layout -> RenderMain();	  
	  
  }
    
  protected function onclickGenerarAuxiliar(){
    
    $agrupar = $this -> requestData('agrupar');	
		
     $this -> getAuxiliarCuenta();

  }  
  
  protected function getAuxiliarCuenta($print = false,$export = false){

	require_once("LibrosAuxiliaresLayoutClass.php");
	require_once("LibrosAuxiliaresModelClass.php");
    include_once("UtilidadesContablesModelClass.php");		
	
	$Layout              = new LibrosAuxiliaresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LibrosAuxiliaresModel();	
	$utilidadesContables = new UtilidadesContablesModel();	

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
    $Layout -> setJsInclude("../../../framework/js/funciones.js");					


    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
		
	$empresa_id          = $this -> getEmpresaId();
	$display             = $this -> requestData('display');
	$reporte             = $this -> requestData('reporte');
	$opciones_centros    = $this -> requestData('opciones_centros');
	
	//if($this -> requestData('centro_costo')=='1') $opciones_centros = 'T';
	
	$oficina_id          = $this -> requestData('oficina_id');
	
	if($this -> requestData('centro_costo')=='0'){
		$centro_de_costo_id	 = $utilidadesContables -> getCentroCostoId($oficina_id,$this  -> getConex());
	}else{
		$centro_de_costo_id	 = $utilidadesContables -> getCentroCostosId($oficina_id,$this  -> getConex());
	}
	
	$opciones_documentos = $this -> requestData('opciones_documentos');		
	$documentos          = $this -> requestData('documentos');
	$opciones_tercero    = $this -> requestData('opciones_tercero');
    $tercero_id          = $this -> requestData('tercero_id');
	
	if($_REQUEST[saldoauxi]=='si'){
		$cuentas = $_REQUEST[puc_id];
	}else{
		if($_REQUEST[ini_puc_id]!='' && $_REQUEST[ini_puc_id]!='NULL' && $_REQUEST[ini_puc_id]!=NULL) $cuentas = $_REQUEST[ini_puc_id];
		if($_REQUEST[ini2_puc_id]!='' && $_REQUEST[ini2_puc_id]!='NULL' && $_REQUEST[ini2_puc_id]!=NULL) $cuentas .= ','.$_REQUEST[ini2_puc_id];
		if($_REQUEST[ini3_puc_id]!='' && $_REQUEST[ini3_puc_id]!='NULL' && $_REQUEST[ini3_puc_id]!=NULL) $cuentas .= ','.$_REQUEST[ini3_puc_id];
		if($_REQUEST[ini4_puc_id]!='' && $_REQUEST[ini4_puc_id]!='NULL' && $_REQUEST[ini4_puc_id]!=NULL) $cuentas .= ','.$_REQUEST[ini4_puc_id];
		if($_REQUEST[ini5_puc_id]!='' && $_REQUEST[ini5_puc_id]!='NULL' && $_REQUEST[ini5_puc_id]!=NULL) $cuentas .= ','.$_REQUEST[ini5_puc_id];
		if($_REQUEST[ini6_puc_id]!='' && $_REQUEST[ini6_puc_id]!='NULL' && $_REQUEST[ini6_puc_id]!=NULL) $cuentas .= ','.$_REQUEST[ini6_puc_id];
	}
	
	$desde               = $this -> requestData('desde');
	$hasta               = $this -> requestData('hasta');		
	$empresa             = $this -> getEmpresaNombre();
	$nitEmpresa          = $this -> getEmpresaIdentificacion(); 
	$centrosTxt          = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
	$fechaProcesado      = date("Y-m-d");
	$horaProcesado       = date("H:i:s");
	$tipo_reporte        = $this -> requestData('tipo_reporte');	
	$agrupar	         = 'cuenta';
				
	if($reporte == 'C'){

      $arrayReport = array();
      $Conex       = $this  -> getConex();
	
	  if($opciones_tercero == 'T'){
	  
	    $arrayResult  = $Model -> selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,
		                                                        $cuentas,$desde,$hasta,$agrupar,$Conex);																 																
       }else{
	   	   
          $arrayResult = $Model -> selectAuxiliarCentrosTercero($empresa_id,$opciones_centros,$centro_de_costo_id,
		                           $tercero_id,$documentos,$cuentas,$desde,$hasta,$agrupar,$Conex);	  	   																																
	     }																 
						
		if(count(arrayResult) > 0){
		
          $tercero       = null;
	      $codigoPuc     = null;
          $terceroTmp    = null;
	      $codigoPucTmp  = null;
		  $contTercero   = -1;
		  $contRegistros = 0;
		  $j             = 0;
		  
	
          for($i = 0; $i < count($arrayResult); $i++){
	
	       $tercero    = $arrayResult[$i]['tercero'];
		   $codigoPuc  = $arrayResult[$i]['codigo_puc'];
		   $naturaleza = $Model -> getNaturalezaCodigoPuc($arrayResult[$i]['puc_id'],$Conex);
	  	  
	       if($codigoPuc != $codigoPucTmp){
			  
			 if($contTercero >= 0){ 
			 
	          $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	          $arrayReport[$contTercero]['total_credito'] = $total_credito;		
			  
			  if($naturaleza == 'D'){
			    $saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_debito) - $total_credito; 													
	            $arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;				 			  
			  }else{
			     $saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_credito) - $total_debito; 													
	             $arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;				 			  			  
			    }
			  		    
			 }
	
    	     $contTercero++;
			 $contRegistros = 0;			 			 			 
			 $total_debito  = 0;
			 $total_credito = 0;			 
			 $saldoAnterior = 0;
			 $nuevoSaldo    = 0;	
			 $tercero_id    = $arrayResult[$i]['tercero_id'];
			 $puc_id        = $arrayResult[$i]['puc_id'];
			 
			 $saldoAnteriorCentrosTercero = 0;
			 $saldoTotalCentrosTercero    = 0;		 			 
			 
			 if(!strlen(trim($arrayResult[$i]['saldo'])) > 0){
			   $saldo = $Model->selectSaldoCentrosPuc($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$puc_id,$desde,$Conex);			
			   $saldoAnteriorCentrosTercero = $saldo;
			 }else{
			     $saldo                       = $arrayResult[$i]['saldo'];
			     $saldoAnteriorCentrosTercero = $arrayResult[$i]['saldo'];				 
			   }
			   
	         $arrayReport[$contTercero]['tercero']       = strlen(trim($arrayResult[$i]['tercero']))    > 0 ? $arrayResult[$i]['tercero']    : 0;
	         $arrayReport[$contTercero]['codigo_puc']    = strlen(trim($arrayResult[$i]['codigo_puc'])) > 0 ? $arrayResult[$i]['codigo_puc'] : 0;	
	         $arrayReport[$contTercero]['saldo']         = $saldo;	
			
			 
			 $saldoAnterior  = $saldo;			 
			 $arrayRegistros = $arrayResult[$i];						
             $debito         = strlen(trim($arrayRegistros['debito']))  > 0? $arrayRegistros['debito']  : 0;
			 $credito        = strlen(trim($arrayRegistros['credito'])) > 0? $arrayRegistros['credito'] : 0;			 
			 
			 if($naturaleza == 'D'){
			   $nuevoSaldo = ($saldoAnterior + $debito) - $credito;
			 }else{
			     $nuevoSaldo = ($saldoAnterior + $credito) - $debito;
			   }
					
			 $arrayRegistros['saldo'] = $nuevoSaldo;				   
			 $saldoAnterior           = $nuevoSaldo;				
				
             $arrayReport[$contTercero]['registros'][$contRegistros] = $arrayRegistros;  			 
			 
	         $terceroTmp   = $arrayResult[$i]['tercero'];	
             $codigoPucTmp = $arrayResult[$i]['codigo_puc'];	
			 
			 $total_debito  += $arrayResult[$i]['debito'];	
			 $total_credito += $arrayResult[$i]['credito'];	
			 
	         $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	         $arrayReport[$contTercero]['total_credito'] = $total_credito;				 
			 
			 if($naturaleza == 'D'){
			   $saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_debito) - $total_credito; 													
	           $arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;			 			 			 
			 }else{
			    $saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_credito) - $total_debito; 													
	            $arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;			 			 			 
			   }
			   			 	 
			 			 			 		 	  
	       }else{
		   
		   		$contRegistros++;			
				$arrayRegistros = $arrayResult[$i];				
				$nuevoSaldo     = 0;			
                $debito         = strlen(trim($arrayRegistros['debito']))  > 0? $arrayRegistros['debito']  : 0;
				$credito        = strlen(trim($arrayRegistros['credito'])) > 0? $arrayRegistros['credito'] : 0;			 
								
				if($naturaleza == 'D'){
				   $nuevoSaldo     = ($saldoAnterior + $debito) - $credito;
				}else{
					 $nuevoSaldo = ($saldoAnterior + $credito) - $debito;
				  }
			   												
				$arrayRegistros['saldo'] = $nuevoSaldo;				   
				$saldoAnterior           = $nuevoSaldo;				
				
                $arrayReport[$contTercero]['registros'][$contRegistros] = $arrayRegistros;
				
			    $total_debito  += $arrayResult[$i]['debito'];	
			    $total_credito += $arrayResult[$i]['credito'];					

	            $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	            $arrayReport[$contTercero]['total_credito'] = $total_credito;	

				if($naturaleza == 'D'){
			     $saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_debito) - $total_credito; 													
	             $arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;														
				}else{
			      $saldoTotalCentrosTercero = ($saldoAnteriorCentrosTercero + $total_credito) - $total_debito; 													
	              $arrayReport[$contTercero]['saldo_total'] = $saldoTotalCentrosTercero;																		
				  }
					  
	         }
		
	      }
		  
	   
	    }else{
		    $arrayReport = array();
		  }		  
	  if($_REQUEST[saldoauxi]=='si'){
		 exit($arrayReport[$contTercero]['saldo_total']);
	  }else{
		  
		  $Layout -> setVar('EMPRESA',$empresa);
		  $Layout -> setVar('NIT',$nitEmpresa);	  		
		  $Layout -> setVar('CENTROS',$centrosTxt);				  
		  $Layout -> setVar('DESDE',$this -> mesNumericoAtexto($desde));				  
		  $Layout -> setVar('HASTA',$this -> mesNumericoAtexto($hasta));				  	  	  
		  $Layout -> setVar('USUARIO',$this -> getUsuarioNombres());				  	  	  	  
		  $Layout -> setVar('FECHA',$fechaProcesado);				  	  	  
		  $Layout -> setVar('HORA',$horaProcesado);				  	  	  	  	  
		  $Layout -> setVar('REPORTE',$arrayReport);	
			  
		  if($print){
			$Layout -> exportToPdf('Imp_librosauxiliaresCuenta.tpl');		  										 	  
		  }else if($export){
			$Layout -> exportToExcel('librosauxiliaresReporteCuentaExcel.tpl');
		  }else{
			$Layout -> RenderLayout('librosauxiliaresReporteCuenta.tpl');
		  }
	  }
	}else{
	  
	  if($opciones_tercero == 'T'){
	  
	    $Conex = $this  -> getConex();
	    $data  = $Model -> selectAuxiliarOficinasTerceros($empresa_id,$oficina_id,$documentos,$cuentas,$desde,$hasta,$Conex);
	  
	  }else{
	  
	      $Conex = $this  -> getConex();
          $data=$Model -> selectAuxiliarOficinasTercero($empresa_id,$oficina_id,$tercero_id,$documentos,$cuentas,$desde,$hasta,$Conex);	  
	  
	    }   
	  
	  }  
  }
  
  protected function viewDocument(){
    
    require_once("View_DocumentClass.php");
	
    $print   = new View_Document();  	
    $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getConex()); 	  
  
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
        selected=>'U',		
		datatype=>array(
			type	=>'alpha')
	);	
	
	$this -> Campos[tercero] = array(
		name	=>'tercero',
		id		=>'tercero',
		type	=>'text',
		suggest=>array(
			name	=>'tercero',
			setId	=>'tercero_hidden')
	);
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_hidden',
		type	=>'hidden',
		required=>'yes',
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
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

new LibrosAuxiliares();

?>