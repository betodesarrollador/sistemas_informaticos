<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteTrazabilidad extends Controler{

	public function __construct(){
		parent::__construct(3);	      
	}  
  
	public function Main(){

		$this -> noCache();

		require_once("reporteTrazabilidadLayoutClass.php");
		require_once("reporteTrazabilidadModelClass.php");

		$Layout   = new reporteTrazabilidadLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new reporteTrazabilidadModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		

		$Layout -> setCampos($this -> Campos);	

		//LISTA MENU
		$Layout -> SetOficina 		($Model -> GetOficina($this -> getConex()));
		$Layout -> SetSi_Pro  		($Model -> GetSi_Pro($this -> getConex()));	
		$Layout -> SetEstado 		($Model -> GetEstado($this -> getConex()));
		$Layout -> SetTrazabilidad	($Model -> GetTrazabilidad($this -> getConex()));	
		$Layout -> RenderMain(); 
	}  
  
	protected function OnclickGenerar(){

		require_once("reporteTrazabilidadLayoutClass.php");
		require_once("reporteTrazabilidadModelClass.php");

		$Layout                 = new reporteTrazabilidadLayout();
		$Model                  = new reporteTrazabilidadModel();	
		$download           	= $this -> requestData('download');
		$empresa_id 			= $this -> getEmpresaId();
		$empresa 				= $this -> getEmpresaNombre();
		$nitEmpresa				= $this -> getEmpresaIdentificacion();
		$desde					= $_REQUEST['desde'];
		$hasta					= $_REQUEST['hasta'];
		$cliente_id				= $_REQUEST['cliente_id'];		
		$si_cliente				= $_REQUEST['si_cliente'];
		$oficina_id				= $_REQUEST['oficina_id'];
		$all_oficina			= $_REQUEST['all_oficina'];
		$estado_id				= $_REQUEST['estado_id'];
		$all_estado 			= $_REQUEST['all_estado'];
		$trazabilidad_id		= $_REQUEST['trazabilidad_id'];
		$all_trazabilidad 		= $_REQUEST['all_trazabilidad'];

		$Conex 	= $this ->getConex();

		$array= array();

		if ($cliente_id == 'NULL') {
			$condicion_cliente='';
			$condicion_cliente1='';
			if ($trazabilidad_id=='OP') {
				if ($estado_id=='MC') {
					$array = $Model -> getReporte1($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
				if ($estado_id=='DU') {
					$array = $Model -> getReporte2($oficina_id,$desde,$hasta,$condicion_cliente1,$Conex);
				}
				if ($estado_id=='MC,DU') {
					$array = $Model -> getReporte3($oficina_id,$desde,$hasta,$condicion_cliente,$condicion_cliente1,$Conex);
				}
			}
			if ($trazabilidad_id=='FI') {
				if ($estado_id=='MC') {
					$array = $Model -> getReporte4($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
				if ($estado_id=='DU') {
					$array = $Model -> getReporte5($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
				if ($estado_id=='MC,DU') {
					$array = $Model -> getReporte6($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
			}
		}else{
			if ($trazabilidad_id=='OP') {
				$condicion_cliente=' ANd m.manifiesto_id IN (SELECT manifiesto_id FROM detalle_despacho dd,remesa r WHERE r.cliente_id = '.$cliente_id.' AND dd.remesa_id = r.remesa_id)';
				$condicion_cliente1=' ANd m.despachos_urbanos_id IN (SELECT despachos_urbanos_id FROM detalle_despacho dd,remesa r WHERE r.cliente_id = '.$cliente_id.' AND dd.remesa_id = r.remesa_id)';
				if ($estado_id=='MC') {
					$array = $Model -> getReporte1($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
				if ($estado_id=='DU') {
					$array = $Model -> getReporte2($oficina_id,$desde,$hasta,$condicion_cliente1,$Conex);
				}
				if ($estado_id=='MC,DU') {
					$array = $Model -> getReporte3($oficina_id,$desde,$hasta,$condicion_cliente,$condicion_cliente1,$Conex);
				}
			}
			if ($trazabilidad_id=='FI') {
				$condicion_cliente=' AND r.cliente_id = '.$cliente_id.' ';
				if ($estado_id=='MC') {
					$array = $Model -> getReporte4($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
				if ($estado_id=='DU') {
					$array = $Model -> getReporte5($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
				if ($estado_id=='MC,DU') {
					$array = $Model -> getReporte6($oficina_id,$desde,$hasta,$condicion_cliente,$Conex);
				}
			}
		}

		$Layout -> setCssInclude("../../../framework/css/reset.css");			
		$Layout -> setCssInclude("../css/reportes.css");						
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
		$Layout -> setJsInclude("../../../framework/js/funciones.js");
		$Layout -> setJsInclude("../../../transporte/reportes/js/detalles.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());		
	
		$Layout -> setVar('EMPRESA',$empresa);	
		$Layout -> setVar('NIT',$nitEmpresa);	
		$Layout -> setVar('CENTROS',$centrosTxt);													
		$Layout -> setVar('DESDE',$desde);															
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('estado_id',$estado_id);

		$Layout -> setVar('parametros',$parametros); 
		$Layout -> setVar('DETALLESTRAZABILIDAD',$array); 
		$Layout -> setVar('USUARIO',$this -> getUsuarioNombres());		  	  	  	  	  


		if($download == 'true'){
			if ($trazabilidad_id == 'OP') {
				$Layout -> exportToExcel('ReporteTrazabilidadResultado.tpl');
			}else{
				$Layout -> exportToExcel('ReporteTrazabilidadResultadoFinancieroExcel.tpl');
			}
		}else{
			if ($trazabilidad_id == 'OP') {
				$Layout -> RenderLayout('ReporteTrazabilidadResultado.tpl');
			}else{
				$Layout -> RenderLayout('ReporteTrazabilidadResultadoFinanciero.tpl');
			}
		}
	}


  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);
	
	$this -> Campos[estado_id] = array(
		name	=>'estado_id',
		id		=>'estado_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);	

	$this -> Campos[trazabilidad_id] = array(
		name	=>'trazabilidad_id',
		id		=>'trazabilidad_id',
		type	=>'select',
		required=>'yes'
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Cliente_si()'
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce()',
		value	=>'NO'
	);
	
	$this -> Campos[all_estado] = array(
		name	=>'all_estado',
		id		=>'all_estado',
		type	=>'checkbox',
		onclick =>'all_estados()',
		value	=>'NO'
	);	
	
	$this -> Campos[all_trazabilidad] = array(
		name	=>'all_trazabilidad',
		id		=>'all_trazabilidad',
		type	=>'checkbox',
		onclick =>'all_traza();',
		value	=>'NO'
	);		

	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_id')
	);	

/////// BOTONES 

	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

	$this -> Campos[imprimir] = array(
		name    =>'imprimir',
		id      =>'imprimir',
		type    =>'button',
		value   =>'Imprimir',
		onclick =>'beforePrint(this.form)'
	);	

	$this -> Campos[excel] = array(
		name    =>'excel',
		id      =>'excel',
		type    =>'button',
		value   =>'Exportar a Excel',
		onclick =>'descargarexcel(this.form)'
	);
	 
	$this -> SetVarsValidate($this -> Campos);	
  }  
  
 }

$reporteTrazabilidad = new reporteTrazabilidad();

?>