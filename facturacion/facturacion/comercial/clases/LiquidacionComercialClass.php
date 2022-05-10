<?php
require_once("../../../framework/clases/ControlerClass.php");

final class LiquidacionComercial extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("LiquidacionComercialLayoutClass.php");
    require_once("LiquidacionComercialModelClass.php");
	
    $Layout   = new LiquidacionComercialLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new LiquidacionComercialModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    //$Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));   
	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	
	$Layout -> SetSi_Pro2($Model -> GetSi_Pro2($this -> getConex()));
	$Layout -> RenderMain();    
  }  
  
/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento();
    $print -> printOut($this -> getConex());  
  }*/
  /*
  protected function generateFileexcel(){
  
    require_once("LiquidacionComercialModelClass.php");
	
	$Model      	        = new LiquidacionComercialModel();	
     $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_comercial				= $_REQUEST['si_comercial'];
	$comercial_id				= $_REQUEST['comercial_id'];	
    $si_cliente			= $_REQUEST['si_cliente'];
	$cliente_id			= $_REQUEST['cliente_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	
	if($tipo == 'F'){
      	 $nombre = 'Liq_fact'.date('Ymd');  
    }elseif($tipo == 'R'){
			 $nombre = 'Liqu_rec'.date('Ymd');
	}
	
	if($si_cliente=='ALL' && $si_comercial=='ALL' && $tipo=='F')
		$data = $Model -> getReporteF1($oficina_id,$desde,$hasta,$this -> getConex());
		
	elseif($si_cliente=='ALL' && $si_comercial=='ALL' && $tipo=='R' )
		$data = $Model -> getReporteR1($oficina_id,$desde,$hasta,$this -> getConex());
	
	elseif($si_cliente==1 && $si_comercial=='ALL' && $tipo=='F')
		$data = $Model -> getReporteF2($oficina_id,$desde,$hasta,$comercial_id,$this -> getConex());
		
	elseif($si_cliente==1 && $si_comercial=='ALL' && $tipo=='R')
		$data = $Model -> getReporteR2($oficina_id,$desde,$hasta,$comercial_id,$this -> getConex());
		
	elseif($si_cliente=='ALL' && $si_comercial==1)
		$data = $Model -> getReporteDP2($oficina_id,$desde,$hasta,$comercial_id,$this -> getConex());
				
	elseif($si_cliente=='ALL' && $si_comercial==1)
		$data = $Model -> getReporteMC3($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());
		
	elseif($si_cliente==1 && $si_comercial=='ALL')
		$data = $Model -> getReporteDU3($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());
		
	elseif($si_cliente==1 && $si_comercial=='ALL')
		$data = $Model -> getReporteDP3($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());		

	elseif($si_cliente==1 && $si_comercial==1)
		$data = $Model -> getReporteMC4($oficina_id,$desde,$hasta,$cliente_id,$comercial_id,$this -> getConex());
		
	elseif($si_cliente==1 && $si_comercial==1)
		$data = $Model -> getReporteDU4($oficina_id,$desde,$hasta,$cliente_id,$comercial_id,$this -> getConex());
		
	elseif($si_cliente==1 && $si_comercial==1)
		$data = $Model -> getReporteDP4($oficina_id,$desde,$hasta,$cliente_id,$comercial_id,$this -> getConex());
	
   	$ruta  = $this -> arrayToExcel("Reporte",$nombre,$data,null,"string");	
	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }   */ 
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		multiple=>'yes'
	);

	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes'
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'cliente_si();'
	);
	
		$this -> Campos[si_comercial] = array(
		name	=>'si_comercial',
		id		=>'si_comercial',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'comercial_si();'
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);

	$this -> Campos[comercial_id] = array(
		name	=>'comercial_id',
		id		=>'comercial_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[comercial] = array(
		name	=>'comercial',
		id		=>'comercial',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'comercial',
			setId	=>'comercial_id')
	);	
	
	  $this -> Campos[cliente_id] = array(
	  name	=>'cliente_id',
	  id	=>'cliente_id',
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
		Boostrap =>'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_id')
	);	


	$this -> Campos[tipo_liquidacion] = array(
		name	=>'tipo_liquidacion',
		id		=>'tipo_liquidacion',
		type	=>'select',
		Boostrap =>'si',
		options	=>array(0=>array('value'=>'C','text'=>'COMISION'),1=>array('value'=>'R','text'=>'RECAUDO')),
		selected=>0,
		required=>'yes'
	);

/////// BOTONES 

	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);	
	$this -> Campos[liquidar] = array(
		name	=>'liquidar',
		id		=>'liquidar',
		type	=>'button',
		value	=>'Liquidar',
		onclick =>'OnclickLiquidar(this.form)'
	);
	
	
	$this -> Campos[generar_excel] = array(
    name   =>'generar_excel',
    id   =>'generar_excel',
    type   =>'button',
    value   =>'Descargar Excel'
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

$LiquidacionComercial = new LiquidacionComercial();

?>