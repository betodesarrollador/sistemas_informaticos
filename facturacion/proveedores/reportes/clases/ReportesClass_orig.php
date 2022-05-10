<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Reportes extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ReportesLayoutClass.php");
	require_once("ReportesModelClass.php");
	
	$Layout   = new ReportesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReportesModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	


	$Layout -> RenderMain();
  
  }

/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento($this -> getConex());
    $print -> printOut();
  
  }*/

  protected function generateFileexcel(){
  
    require_once("ReportesModelClass.php");
	
    $Model      	= new ReportesModel();	
	$desde      	= $_REQUEST['desde'];
	$hasta      	= $_REQUEST['hasta'];
	$tipo       	= $_REQUEST['tipo'];
	$oficina_id		= $_REQUEST['oficina_id'];
	$si_proveedor	= $_REQUEST['si_proveedor'];
	$proveedor_id	= $_REQUEST['proveedor_id'];	
	$all_oficina	= $_REQUEST['all_oficina'];
	$saldos			= $_REQUEST['saldos'];
	if($saldos=='S'){
		$saldos=" AND ab.fecha BETWEEN '".$desde."'  AND  '".$hasta."' ";
	}else{
		$saldos='';
	}
	
	
	if($tipo == 'FP'){
      $nombre = 'Fac_Pend'.date('Ymd');	  
    }elseif($tipo == 'RF'){
		$nombre = 'Rel_Fac'.date('Ymd');	
	}elseif($tipo == 'EC'){
	  	$nombre = 'Est_Car'.date('Ymd');	
	}elseif($tipo == 'PE'){
		$nombre = 'Car_Edad'.date('Ymd');
	}	

	if($tipo=='FP' && $si_proveedor==1)
    	$data = $Model -> getReporteFP1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$this -> getConex());
		
	elseif($tipo=='RF' && $si_proveedor==1)
    	$data = $Model -> getReporteRF1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$this -> getConex());	
		
	elseif($tipo=='EC' && $si_proveedor==1)
		$data = $Model -> getReporteEC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$this -> getConex());
		
	elseif($tipo=='PE' && $si_proveedor==1)
		$data = $Model -> getReportePE1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$this -> getConex());

	elseif($tipo=='FP' && $si_proveedor=='ALL')
    	$data = $Model -> getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex());	
																										   
	elseif($tipo=='RF' && $si_proveedor=='ALL')
    	$data = $Model -> getReporteRF_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex());	
		
	elseif($tipo=='EC' && $si_proveedor=='ALL')
		$data = $Model -> getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex());
																										   
	elseif($tipo=='PE' && $si_proveedor=='ALL') 
		$data = $Model -> getReportePE_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()); 
	
    $ruta  = $this -> arrayToExcel("Reportes",$tipo,$data,null,"string");
	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
		required=>'yes'
	);

	$this -> Campos[saldos] = array(
		name	=>'saldos',
		id		=>'saldos',
		type	=>'select',
		options	=>null,
		required=>'yes',
		selected=>'N',
		options	=>array(0 => array ( 'value' => 'S', 'text' => 'SI' ), 1 => array ( 'value' => 'N', 'text' => 'NO'))
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

	$this -> Campos[si_proveedor] = array(
		name	=>'si_proveedor',
		id		=>'si_proveedor',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Proveedor_si();'
	);
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);


	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'proveedor',
			setId	=>'proveedor_id')
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);

	 	  
	/**********************************
 	             Botones
	**********************************/
	 
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

	$this -> Campos[descargar] = array(
    name   =>'descargar',
    id   =>'descargar',
    type   =>'button',
    value   =>'Descargar Excel',
	onclick =>'descargarexcel(this.form)'
    );

     $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
 	onclick =>'beforePrint(this.form)'
    );
	 

	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Reportes = new Reportes();

?>