<?php

require_once("../../../framework/clases/ControlerClass.php");

final class reporteHistorico extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("reporteHistoricoLayoutClass.php");
    require_once("reporteHistoricoModelClass.php");
	
    $Layout   = new reporteHistoricoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteHistoricoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    //$Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));   
	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	    // VEHICULO
	$Layout -> SetSi_Pro2($Model -> GetSi_Pro2($this -> getConex()));	// CONDUCTOR
	$Layout -> SetSi_Pro3($Model -> GetSi_Pro3($this -> getConex()));	// TENEDOR
	$Layout -> SetSi_Pro4($Model -> GetSi_Pro4($this -> getConex()));	// CLIENTE
	$Layout -> RenderMain();
    
  }  
  
/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento();
    $print -> printOut($this -> getConex());  
  }*/  
  
  protected function generateFileexcel(){
  
    require_once("reporteHistoricoModelClass.php");
	
    $Model                  = new reporteHistoricoModel();	
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_vehiculo			= $_REQUEST['si_vehiculo'];
	$vehiculo_id			= $_REQUEST['vehiculo_id'];			
	$si_conductor			= $_REQUEST['si_conductor'];
	$conductor_id			= $_REQUEST['conductor_id'];	
	$si_tenedor			    = $_REQUEST['si_tenedor'];
	$tenedor_id				= $_REQUEST['tenedor_id'];	
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];		
	$all_oficina			= $_REQUEST['all_oficina'];
		
	if($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE GENERAL
		$data = $Model -> getReporte1($oficina_id,$desde,$hasta,$this -> getConex());
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE CLIENTE
		$data = $Model -> getReporte2($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());	
	elseif($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE TENEDOR
		$data = $Model -> getReporte3($oficina_id,$desde,$hasta,$tenedor_id,$this -> getConex());	
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE CONDUCTOR
		$data = $Model -> getReporte4($oficina_id,$desde,$hasta,$conductor_id,$this -> getConex());		
	elseif($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE VEHICULO
		$data = $Model -> getReporte5($oficina_id,$desde,$hasta,$vehiculo_id,$this -> getConex());			
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE VEHICULO - CLIENTE 
		$data = $Model -> getReporte6($oficina_id,$desde,$hasta,$vehiculo_id,$cliente_id,$this -> getConex());		
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE VEHICULO - CONDUCTOR 
		$data = $Model -> getReporte7($oficina_id,$desde,$hasta,$vehiculo_id,$conductor_id,$this -> getConex());		
	elseif($si_cliente=='ALL' && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor==1) // REPORTE VEHICULO - TENEDOR 
		$data = $Model -> getReporte8($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$this -> getConex());	
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE CONDUCTOR - TENEDOR 
		$data = $Model -> getReporte9($oficina_id,$desde,$hasta,$conductor_id,$tenedor_id,$this -> getConex());		
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor=='ALL') // REPORTE CONDUCTOR - CLIENTE 
		$data = $Model -> getReporte10($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$this -> getConex());		
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE CLIENTE - TENEDOR 
		$data = $Model -> getReporte11($oficina_id,$desde,$hasta,$cliente_id,$tenedor_id,$this -> getConex());			
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor=='ALL') // REPORTE CONDUCTOR - VEHICULO - CLIENTE
		$data = $Model -> getReporte12($oficina_id,$desde,$hasta,$conductor_id,$vehiculo_id,$cliente_id,$this -> getConex());		
	elseif($si_cliente=='ALL' && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor==1) // REPORTE CONDUCTOR - VEHICULO - TENEDOR
		$data = $Model -> getReporte13($oficina_id,$desde,$hasta,$conductor_id,$vehiculo_id,$tenedor_id,$this -> getConex());	
	elseif($si_cliente==1 && $si_conductor=='ALL' && $si_vehiculo==1 && $si_tenedor==1) // REPORTE CLIENTE - VEHICULO - TENEDOR
		$data = $Model -> getReporte14($oficina_id,$desde,$hasta,$cliente_id,$vehiculo_id,$tenedor_id,$this -> getConex());	
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo=='ALL' && $si_tenedor==1) // REPORTE CONDUCTOR - CLIENTE - TENEDOR
		$data = $Model -> getReporte15($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$tenedor_id,$this -> getConex());		
	elseif($si_cliente==1 && $si_conductor==1 && $si_vehiculo==1 && $si_tenedor==1) // REPORTE CONDUCTOR - CLIENTE - TENEDOR - VEHICULO
		$data = $Model -> getReporte16($oficina_id,$desde,$hasta,$conductor_id,$cliente_id,$tenedor_id,$vehiculo_id,$this -> getConex());
	
    $nombre = 'Rep_His'.date('Ymd');
	
	$ruta  = $this -> arrayToExcel("Reporte Historico",$nombre,$data,null,"string");	
	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
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
	
	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'no',
		onchange=>'Cliente_si();'
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
	
	$this -> Campos[si_conductor] = array(
		name	=>'si_conductor',
		id		=>'si_conductor',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'no',
		onchange=>'Conductor_si();'
	);

	$this -> Campos[conductor_id] = array(
		name	=>'conductor_id',
		id		=>'conductor_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[conductor] = array(
		name	=>'conductor',
		id		=>'conductor',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'conductor',
			setId	=>'conductor_id')
	);	
	
	$this -> Campos[si_tenedor] = array(
		name	=>'si_tenedor',
		id		=>'si_tenedor',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'no',
		onchange=>'Tenedor_si();'
	);

	$this -> Campos[tenedor_id] = array(
		name	=>'tenedor_id',
		id		=>'tenedor_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[tenedor] = array(
		name	=>'tenedor',
		id		=>'tenedor',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'tenedor',
			setId	=>'tenedor_id')
	);
	
	$this -> Campos[si_vehiculo] = array(
		name	=>'si_vehiculo',
		id		=>'si_vehiculo',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'no',
		onchange=>'Vehiculo_si();'
	);

	$this -> Campos[vehiculo_id] = array(
		name	=>'vehiculo_id',
		id		=>'vehiculo_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[vehiculo] = array(
		name	=>'vehiculo',
		id		=>'vehiculo',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'vehiculo',
			setId	=>'vehiculo_id')
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
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
    value   =>'Imprimir',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Reporte',
      width       => '800',
      height      => '600'
    ));
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  }

$reporteHistorico = new reporteHistorico();

?>