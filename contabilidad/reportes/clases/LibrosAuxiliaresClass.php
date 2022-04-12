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
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");
	$Layout              = new LibrosAuxiliaresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LibrosAuxiliaresModel();
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
    
  protected function onclickGenerarAuxiliar(){
    
    $agrupar = $this -> requestData('agrupar');
		
	if($agrupar == 'defecto'){
	  $this -> getAuxiliarDefecto();
	}else if($agrupar == 'cuenta'){
	     $this -> getAuxiliarCuenta();
	  }
	
  }  
  
  protected function validaCentroCosto(){
    
	require_once("LibrosAuxiliaresModelClass.php");
	$Model  = new LibrosAuxiliaresModel();
	
	$cuenta_desde_id = $this -> requestData('cuenta_desde_id');
	$cuenta_hasta_id = $this -> requestData('cuenta_hasta_id');
	
	$data   = $Model -> getCentroCosto($cuenta_desde_id,$cuenta_hasta_id,$this  -> getConex());
	
	$this -> getArrayJSON($data);
	
  }  
  
  protected function getAuxiliarDefecto($print = false,$export = false){
  
	require_once("LibrosAuxiliaresLayoutClass.php");
	require_once("LibrosAuxiliaresModelClass.php");
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new LibrosAuxiliaresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LibrosAuxiliaresModel();	
	$utilidadesContables = new UtilidadesContablesModel();	

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
    $Layout -> setJsInclude("../../../framework/js/funciones.js");					
    $Layout -> setJsInclude("../js/librosauxiliaresReporte.js");				
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
	
	$empresa_id          = $this -> getEmpresaId();
	$display             = $this -> requestData('display');
	$reporte             = $this -> requestData('reporte');
	$opciones_centros    = $this -> requestData('opciones_centros');	
	$centro_de_costo_id  = $this -> requestData('centro_de_costo_id');
	$oficina_id          = $this -> requestData('oficina_id');
	$opciones_documentos = $this -> requestData('opciones_documentos');		
	$documentos          = $this -> requestData('documentos');
	$opciones_tercero    = $this -> requestData('opciones_tercero');
    $tercero_id          = $this -> requestData('tercero_id');
	$desde               = $this -> requestData('desde');
	$hasta               = $this -> requestData('hasta');		
	$decimales           = $this -> requestData('decimales');		
	$empresa             = $this -> getEmpresaNombre();
	$nitEmpresa          = $this -> getEmpresaIdentificacion();
	$centrosTxt          = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
	$fechaProcesado      = date("Y-m-d");
	$horaProcesado       = date("H:i:s");
	$tipo_reporte        = $this -> requestData('tipo_reporte');	
	$agrupar	         = 'defecto';
	$opciones_cuentas    = $this -> requestData('opciones_cuentas');
	if($opciones_cuentas=='R'){
		$cuenta_desde_id     = $Model -> getCodigoPuc($this -> requestData('cuenta_desde_id'),$this  -> getConex());
		$cuenta_hasta_id     = $Model -> getCodigoPuc($this -> requestData('cuenta_hasta_id'),$this  -> getConex());
	}else{
		$cuenta_desde_id     = 1;
		$cuenta_hasta_id     = 99999999;
	}
	$estado           = str_replace(',',"','",$this -> requestData('estado'));

	
	$consul_estado       =  $estado != ""  ?  "AND e.estado IN('$estado')" : "AND e.estado IN('C')";

	
	if($reporte == 'C'){
		
		
      $arrayReport = array();
      $Conex       = $this  -> getConex();
	
	  if($opciones_tercero == 'T'){//
		
	    $arrayResult  = $Model -> selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$cuenta_desde_id,
		                                                        $cuenta_hasta_id,$desde,$hasta,$agrupar,$consul_estado,$Conex);																 																
       }else{
	   
          $arrayResult = $Model -> selectAuxiliarCentrosTercero($empresa_id,$opciones_centros,$centro_de_costo_id,$tercero_id,$documentos,$cuenta_desde_id,$cuenta_hasta_id,$desde,$hasta,$agrupar,$consul_estado,$Conex);	  	   
																
																
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
	  	  
	       if($tercero != $terceroTmp || $codigoPuc != $codigoPucTmp){
			  
			 if($contTercero >= 0){ 
			 
	          $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	          $arrayReport[$contTercero]['total_credito'] = $total_credito;		
	          $arrayReport[$contTercero]['total_base'] = $total_base;		
			  
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
			 $total_base = 0;			 
			 $saldoAnterior = 0;
			 $nuevoSaldo    = 0;	
			 $tercero_id    = $arrayResult[$i]['tercero_id'];
			 $puc_id        = $arrayResult[$i]['puc_id'];
			 
			 $saldoAnteriorCentrosTercero = 0;
			 $saldoTotalCentrosTercero    = 0;		 			 
			 
			 if(!strlen(trim($arrayResult[$i]['saldo'])) > 0){
			   $saldo = $Model->selectSaldoCentrosTercero($tercero_id,$empresa_id,$opciones_centros,$centro_de_costo_id,
			                                              $documentos,$puc_id,$desde,$consul_estado,$Conex);			
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
			 $total_base += $arrayResult[$i]['base'];	
			 
	         $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	         $arrayReport[$contTercero]['total_credito'] = $total_credito;				 
	         $arrayReport[$contTercero]['total_base'] = $total_base;				 
			 
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
			    $total_base += $arrayResult[$i]['base'];					
	            $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	            $arrayReport[$contTercero]['total_credito'] = $total_credito;	
	            $arrayReport[$contTercero]['total_base'] = $total_base;	
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
      $Layout -> setVar('EMPRESA',$empresa);
      $Layout -> setVar('NIT',$nitEmpresa);	  		
      $Layout -> setVar('CENTROS',$centrosTxt);				  
      $Layout -> setVar('DESDE',$this -> mesNumericoAtexto($desde));				  
      $Layout -> setVar('HASTA',$this -> mesNumericoAtexto($hasta));				  	  	  
      $Layout -> setVar('USUARIO',$this -> getUsuarioNombres());				  	  	  	  
      $Layout -> setVar('FECHA',$fechaProcesado);				  	  	  
      $Layout -> setVar('HORA',$horaProcesado);				  	  	  	  	  
      $Layout -> setVar('REPORTE',$arrayReport);	
      $Layout -> setVar('MOSTRARDECIMALES',$decimales);	
	  	  
	  if($print){
        $Layout -> exportToPdf('Imp_librosauxiliares.tpl');		  										 	  
	  }else if($export){
	      $Layout -> exportToExcel('librosauxiliaresReporteExcel.tpl');
	     }else{
    	      $Layout -> RenderLayout('librosauxiliaresReporte.tpl');
		   }
	  	
	}else{
	  
	  if($opciones_tercero == 'T'){
	  
	    $Conex = $this  -> getConex();
	    $data  = $Model -> selectAuxiliarOficinasTerceros($empresa_id,$oficina_id,$documentos,$cuenta_desde_id,$cuenta_hasta_id,
		$desde,$hasta,$Conex);
	  
	  }else{
	  
	      $Conex = $this  -> getConex();
          $data=$Model -> selectAuxiliarOficinasTercero($empresa_id,$oficina_id,$tercero_id,$documentos,$cuenta_desde_id,
		  $cuenta_hasta_id,$desde,$hasta,$Conex);	  
	  
	    }   
	  
	  }  
  
  }
  
  protected function getAuxiliarCuenta($print = false,$export = false){
	require_once("LibrosAuxiliaresLayoutClass.php");
	require_once("LibrosAuxiliaresModelClass.php");
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new LibrosAuxiliaresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new LibrosAuxiliaresModel();	
	$utilidadesContables = new UtilidadesContablesModel();	
    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css");						
    $Layout -> setCssInclude("../css/librosauxiliaresReporte.css","print");							
    $Layout -> setJsInclude("../../../framework/js/funciones.js");					
    $Layout -> setJsInclude("../js/librosauxiliaresReporte.js");				
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
		
	$empresa_id          = $this -> getEmpresaId();
	$display             = $this -> requestData('display');
	$reporte             = $this -> requestData('reporte');
	$opciones_centros    = $this -> requestData('opciones_centros');	
	$centro_de_costo_id  = $this -> requestData('centro_de_costo_id');
	$oficina_id          = $this -> requestData('oficina_id');
	$opciones_documentos = $this -> requestData('opciones_documentos');		
	$documentos          = $this -> requestData('documentos');
	$opciones_tercero    = $this -> requestData('opciones_tercero');
	$tercero_id          = $this -> requestData('tercero_id');
	$decimales           = $this -> requestData('decimales');
	/* $cuenta_desde_id     = $Model -> getCodigoPuc($this -> requestData('cuenta_desde_id'),$this  -> getConex());
	$cuenta_hasta_id     = $Model -> getCodigoPuc($this -> requestData('cuenta_hasta_id'),$this  -> getConex()); */
	$desde               = $this -> requestData('desde');
	$hasta               = $this -> requestData('hasta');		
	$empresa             = $this -> getEmpresaNombre();
	$nitEmpresa          = $this -> getEmpresaIdentificacion();
	$centrosTxt          = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
	$fechaProcesado      = date("Y-m-d");
	$horaProcesado       = date("H:i:s");
	$tipo_reporte        = $this -> requestData('tipo_reporte');	
	$agrupar	         = 'cuenta';
	$opciones_cuentas    = $this -> requestData('opciones_cuentas');
	if($opciones_cuentas=='R'){
		$cuenta_desde_id     = $Model -> getCodigoPuc($this -> requestData('cuenta_desde_id'),$this  -> getConex());
		$cuenta_hasta_id     = $Model -> getCodigoPuc($this -> requestData('cuenta_hasta_id'),$this  -> getConex());
	}else{
		$cuenta_desde_id     = 1;
		$cuenta_hasta_id     = 99999999;
	}
	$estado              = str_replace(',',"','",$this -> requestData('estado'));
	
	$consul_estado       =  $estado != ""  ?  "AND e.estado IN('$estado')" : "AND e.estado IN('C')";
				
	if($reporte == 'C'){
      $arrayReport = array();
      $Conex       = $this  -> getConex();
	
	  if($opciones_tercero == 'T'){
	  
	    $arrayResult  = $Model -> selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,
		                                                        $cuenta_desde_id,$cuenta_hasta_id,$desde,$hasta,$agrupar,$consul_estado,$Conex);																 																
       }else{
	   	   
          $arrayResult = $Model -> selectAuxiliarCentrosTercero($empresa_id,$opciones_centros,$centro_de_costo_id,
		                           $tercero_id,$documentos,$cuenta_desde_id,$cuenta_hasta_id,$desde,$hasta,$agrupar,$consul_estado,$Conex);	  	   																																
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
	          $arrayReport[$contTercero]['total_base'] = $total_base;		
			  
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
			 $total_base = 0;			 
			 $saldoAnterior = 0;
			 $nuevoSaldo    = 0;	
			 $tercero_id    = $arrayResult[$i]['tercero_id'];
			 $puc_id        = $arrayResult[$i]['puc_id'];
			 
			 $saldoAnteriorCentrosTercero = 0;
			 $saldoTotalCentrosTercero    = 0;		 			 
			 
			 if(!strlen(trim($arrayResult[$i]['saldo'])) > 0){
			   $saldo = $Model->selectSaldoCentrosPuc($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$puc_id,$desde,$consul_estado,$Conex);			
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
			 $total_base += $arrayResult[$i]['base'];	
			 
	         $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	         $arrayReport[$contTercero]['total_credito'] = $total_credito;				 
	         $arrayReport[$contTercero]['total_base'] = $total_base;				 
			 
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
			    $total_base += $arrayResult[$i]['base'];					
	            $arrayReport[$contTercero]['total_debito']  = $total_debito;	
	            $arrayReport[$contTercero]['total_credito'] = $total_credito;	
	            $arrayReport[$contTercero]['total_base'] = $total_base;	
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
      $Layout -> setVar('EMPRESA',$empresa);
      $Layout -> setVar('NIT',$nitEmpresa);	  		
      $Layout -> setVar('CENTROS',$centrosTxt);				  
      $Layout -> setVar('DESDE',$this -> mesNumericoAtexto($desde));				  
      $Layout -> setVar('HASTA',$this -> mesNumericoAtexto($hasta));				  	  	  
      $Layout -> setVar('USUARIO',$this -> getUsuarioNombres());				  	  	  	  
      $Layout -> setVar('FECHA',$fechaProcesado);				  	  	  
      $Layout -> setVar('HORA',$horaProcesado);				  	  	  	  	  
	  $Layout -> setVar('REPORTE',$arrayReport);	
	  $Layout -> setVar('MOSTRARDECIMALES',$decimales);
	  	  
	  if($print){
        $Layout -> exportToPdf2('librosauxiliaresReporteCuenta.tpl');		  										 	  
	  }else if($export){
	      $Layout -> exportToExcel('librosauxiliaresReporteCuentaExcel.tpl');
	     }else{
    	      $Layout -> RenderLayout('librosauxiliaresReporteCuenta.tpl');
		   }
	  	
	}else{
	  
	  if($opciones_tercero == 'T'){
	  
	    $Conex = $this  -> getConex();
	    $data  = $Model -> selectAuxiliarOficinasTerceros($empresa_id,$oficina_id,$documentos,$cuenta_desde_id,$cuenta_hasta_id,
		$desde,$hasta,$Conex);
	  
	  }else{
	  
	      $Conex = $this  -> getConex();
          $data=$Model -> selectAuxiliarOficinasTercero($empresa_id,$oficina_id,$tercero_id,$documentos,$cuenta_desde_id,
		  $cuenta_hasta_id,$desde,$hasta,$Conex);	  
	  
	    }   
	  
	  }  
  
  
  
  
  
  }
  
  protected function viewDocument(){
	  //die("TEST");
	  require_once("../../movimientos/clases/View_DocumentClass.php");
	  
    $print   = new View_Document();  	
    $print -> printOut($this -> getConex()); 	  
  
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'text',
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
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
		Boostrap =>'si',
		size    =>'3',
		multiple=>'yes',
        required=>'yes',		
		selected=>'NULL',
        options =>array(),
		datatype=>array(
			type	=>'integer')
	);	
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		Boostrap =>'si',
		size    =>'3',
		multiple=>'yes',
        required=>'yes',		
		selected=>'NULL',
		options =>array(array(value=>'C',text=>'CONTABILIZADOS'),array(value=>'E',text=>'EDICION')),
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
	
	$this -> Campos[opciones_estado] = array(
		name	=>'opciones_estado',
		id		=>'opciones_estado',
		type	=>'checkbox',
		value   =>'U',
		datatype=>array(type=>'text')
	);					
			
	$this -> Campos[cuenta_desde] = array(
		name	=>'cuenta_desde',
		id		=>'cuenta_desde',
		type	=>'text',
		Boostrap =>'si',
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
	$this -> Campos[opciones_cuentas] = array(
		name	=>'opciones_cuentas',
		id		=>'opciones_cuentas',
		type	=>'checkbox',
		value   =>'R',
	    datatype=>array(type=>'text')
	);			
	
	$this -> Campos[cuenta_hasta] = array(
		name	=>'cuenta_hasta',
		id		=>'cuenta_hasta',
		type	=>'text',
		Boostrap =>'si',	
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
	
	$this -> Campos[decimales] = array(
		name	=>'decimales',
		id		=>'decimales',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
        options =>array(array(value=>'0',text=>'SIN DECIMALES'),array(value=>'1',text=>'1 DECIMAL'),array(value=>'2',text=>'2 DECIMALES')),
        selected=>'0',		
		datatype=>array(
			type	=>'integer')
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
