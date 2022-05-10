<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Imp_Arqueo extends Controler{

  private $Conex;
  
  public function __construct(){
     
  
  }

  public function printOut($Conex){  
    	
		require_once("Imp_ArqueoLayoutClass.php");
		require_once("Imp_ArqueoModelClass.php");
		require_once("LibrosAuxiliaresModelClass.php");		
		include_once("UtilidadesContablesModelClass.php");
		
		$Layout = new Imp_ArqueoLayout();
		$Model  = new Imp_ArqueoModel();	
		$Model1  = new LibrosAuxiliaresModel();	
		$utilidadesContables = new UtilidadesContablesModel();	
	
		$reporte             = 'C';
		$opciones_centros    = 'T';	
		$oficina_id          = $_REQUEST['oficina_id']; 
		//$centro_de_costo_id	 = $utilidadesContables -> getCentroCostoId($oficina_id,$this -> Conex);
		$centro_de_costo_id	 = $utilidadesContables -> getCentroCostosId($oficina_id,$this  -> Conex);
		$opciones_documentos = 'T';	
		$documentos          = $_REQUEST['documentos']; 
		$opciones_tercero    = 'T';
		$tercero_id          = '';
		$cuentas 			 = $_REQUEST['puc_id']; 
		$desde               = $_REQUEST['fecha_arqueo'];
		$hasta               = $_REQUEST['fecha_arqueo'];
		$empresa_id			 = $Model -> getEmpresa ($oficina_id,$this -> Conex);
		$centrosTxt          = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this -> Conex);

		$fechaProcesado      = date("Y-m-d");
		$horaProcesado       = date("H:i:s");
		$agrupar	         = 'cuenta';
		
		if($reporte == 'C'){

      		$arrayReport = array();
      		$Conex       = $this -> Conex;
	
	  		if($opciones_tercero == 'T'){
	  
	    		$arrayResult  = $Model1 -> selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$cuentas,$desde,$hasta,$agrupar,$Conex);																 																
	       	}else{
	   	   
          		$arrayResult = $Model1 -> selectAuxiliarCentrosTercero($tercero_id,$empresa_id,$opciones_centros,$centro_de_costo_id,$tercero_id,$documentos,$cuentas,$desde,$hasta,$agrupar,$Conex);	  	   																																
		    }																 
						
			if(count($arrayResult) > 0){
		
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
		   			$naturaleza = $Model1 -> getNaturalezaCodigoPuc($arrayResult[$i]['puc_id'],$Conex);
	  	  
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
			   				$saldo = $Model1->selectSaldoCentrosPuc($puc_id,$empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$puc_id,$desde,$Conex);			
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
		}  

	
      $Layout -> setIncludes();
	  	
	  $arqueo_caja_id = $_REQUEST['arqueo_caja_id'];
	  $Layout -> setVar('FECHAPRO',$fechaProcesado);				  	  	  
	  $Layout -> setVar('HORAPRO',$horaProcesado);				  	  	  	  	  
	
      $Layout -> setEncabezado($Model -> getEncabezado($arqueo_caja_id,$this -> Conex));	
	  $Layout -> setMonedas($Model -> getMonedas($arqueo_caja_id,$this -> Conex));	
	  $Layout -> setBilletes($Model -> getBilletes($arqueo_caja_id,$this -> Conex));
	  $Layout -> setReporte($arrayReport);

      $Layout -> RenderMain();
  }
}

?>