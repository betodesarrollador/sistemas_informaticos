<?php

require_once("../../../framework/clases/ControlerClass.php");
final class DetallesLiquidacion extends Controler{

  public function __construct(){
	parent::__construct(3);
  }
  
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLiquidacionLayoutClass.php");
    require_once("DetallesLiquidacionModelClass.php");
		
	$Layout                 = new DetallesLiquidacionLayout();
    $Model                  = new DetallesLiquidacionModel();	
    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_comercial				= $_REQUEST['si_comercial'];
	$comercial_id				= $_REQUEST['comercial_id'];	
    $si_cliente			= $_REQUEST['si_cliente'];
	$cliente_id			= $_REQUEST['cliente_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	$download			= $_REQUEST['download'];
	
    $Layout -> setIncludes();
	
	if($si_cliente=='ALL' && $si_comercial=='ALL' && $tipo=='F')
		$Layout -> setReporteF1($Model -> getReporteF1($oficina_id,$desde,$hasta,$this -> getConex()));
		
	elseif($si_cliente=='ALL' && $si_comercial=='ALL' && $tipo=='R' )
		$Layout -> setReporteR1($Model -> getReporteR1($oficina_id,$desde,$hasta,$this -> getConex()));
	
	elseif($si_cliente==1 && $si_comercial=='ALL' && $tipo=='F')
		$Layout -> setReporteF2($Model -> getReporteF2($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex()));
		
	elseif($si_cliente==1 && $si_comercial=='ALL' && $tipo=='R')
		$Layout -> setReporteR2($Model -> getReporteR2($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex()));
		
	elseif($si_cliente=='ALL' && $si_comercial==1 && $tipo=='R')
		$Layout -> setReporteR3($Model -> getReporteR3($oficina_id,$desde,$hasta,$comercial_id,$this -> getConex()));
		
	elseif($si_cliente=='ALL' && $si_comercial==1 && $tipo=='F')
		$Layout -> setReporteF3($Model -> getReporteF3($oficina_id,$desde,$hasta,$comercial_id,$this -> getConex()));
	
	$download = $this -> requestData('download');
	
	if($download == 'true'){
	    $Layout -> exportToExcel('detallesLiquidacionComercial1.tpl'); 		
	}else{		
		  $Layout -> RenderMain();  
  	}
  }
  
  protected function viewDocument(){
    
    require_once("View_DocumentClass.php");
	
    $print   = new View_Document();  	
    $print -> printOut($this -> getUsuarioNombres(),$this -> getEmpresaId(),$this -> getConex()); 	  
  
  }
  
  protected function SaveComision(){
	
		 require_once("DetallesLiquidacionModelClass.php");
		
		$Model                  = new DetallesLiquidacionModel();	
		$tipo 					= $_REQUEST['tipo'];
		$desde					= $_REQUEST['desde'];
		$hasta					= $_REQUEST['hasta'];
		$comercial_id			= $_REQUEST['comercial_id'];	
		$cliente_id				= $_REQUEST['cliente_id'];
		$valor					= $_REQUEST['valor'];
		$porcentaje				= $_REQUEST['porcentaje'];
		
		$comisiones_id = $Model-> Save($cliente_id,$desde,$hasta,$comercial_id,$tipo,$valor,$porcentaje,$this -> getOficinaId(),$this -> getUsuarioId(),$this -> getConex());
		
		if ($comisiones_id >0){
			
			$oficina_id = $Model-> getOficina($comisiones_id,$this -> getConex());
			
			$detalles = $Model-> getReporteR2($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());
            
			$respuesta=$Model -> SaveDetalles($detalles,$comisiones_id,$this -> getConex());
			if($respuesta =='true'){
				return $comisiones_id;
			}else{
			   exit('error');
		    }
		}else{
			exit('error');
		}
		
		
  }
}

$DetallesLiquidacion = new DetallesLiquidacion();

?>