<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteProveedores extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("reporteProveedoresLayoutClass.php");
    require_once("reporteProveedoresModelClass.php");
	
    $Layout   = new reporteProveedoresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteProveedoresModel();
    
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
  
  protected function generateFileexcel(){
  
    require_once("reporteProveedoresModelClass.php");
	
	$Model      	        = new reporteProveedoresModel();	
    $tipo 					= $_REQUEST['tipo'];
    $estado 				= $_REQUEST['estado'];	
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_tenedor				= $_REQUEST['si_tenedor'];
	$tenedor_id				= $_REQUEST['tenedor_id'];	
    $si_vehiculo			= $_REQUEST['si_vehiculo'];
	$vehiculo_id			= $_REQUEST['vehiculo_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	
	$con_corte				= $_REQUEST['con_corte'];
	

	if($con_corte=="S"){
		$cons_cor = "";
		$cons_cor1 = "";
		
		
	}else{
		$cons_cor = "AND l.fecha BETWEEN '$desde' AND '$hasta'";
		$cons_cor1 = "AND af.fecha BETWEEN '$desde' AND '$hasta'";
		
	}
	
	if($estado=="P" || $estado=="CE"){
		$estadomc = "AND am.detalle_liquidacion_despacho_id IS NULL AND am.legalizacion_manifiesto_id IS NULL ";
		$estadodu = "AND adu.detalle_liquidacion_despacho_id IS NULL AND adu.legalizacion_despacho_id IS NULL ";
		$estadoap = "AND ap.estado='P'";
	}else{
		$estadomc = "";
		$estadodu = "";
		$estadoap = "";
	}
	
	if($si_vehiculo=="ALL"){
		$cons_vehm = "";
		$cons_vehd = "";
		$cons_veha = "";
		
	}else{
		$cons_vehm = "AND m.placa_id = $vehiculo_id";
		$cons_vehd = "AND du.placa_id = $vehiculo_id";
		$cons_veha = "AND ap.placa_id = $vehiculo_id";
	}

	if($si_tenedor=="ALL"){
		$cons_tenm = "";
		$cons_tend = "";
		$cons_tena = "";
		
	}else{
		$cons_tenm = "AND m.tenedor_id = $tenedor_id";
		$cons_tend = "AND du.tenedor_id = $tenedor_id";
		$cons_tena = "AND ap.tenedor_id = $tenedor_id";
	}

	if($estado=='CE'){
		$data=$Model -> getReporteMCE1DUE1APE1($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$this -> getConex());
		
	}elseif($estado=='P'){
		$data=$Model -> getReporteMCE1DUE1APE1($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$this -> getConex());
		
	}elseif($estado=='ALL'){
		$data=$Model -> getReporteTOTAL($tipo,$oficina_id,$desde,$hasta,$estadomc,$estadodu,$estadoap,$cons_vehm,$cons_vehd,$cons_veha,$cons_tenm,$cons_tend,$cons_tena,$cons_cor,$cons_cor1,$this -> getConex());
	}


	$nombre = 'ReporteProveedores';	
   	$ruta  = $this -> arrayToExcel('ReporteAnti','ReporteAnti',$data,null,"string");		
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

	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
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

	$this -> Campos[si_vehiculo] = array(
		name	=>'si_vehiculo',
		id		=>'si_vehiculo',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Vehiculo_si();'
	);

	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=>array(0=>array('value'=>'P','text'=>'Proveedores Pendientes'),1=>array('value'=>'ALL','text'=>'Relacion Proveedores'),2=>array('value'=>'CE','text'=>'Proveedores Por Edades')),
		selected=>0,
		required=>'yes'
	);
	
	$this -> Campos[con_corte] = array(
		name	=>'con_corte',
		id		=>'con_corte',
		type	=>'select',
		options	=>array(0=>array('value'=>'N','text'=>'NO','selected'=>0),1=>array('value'=>'S','text'=>'SI','selected'=>0)),
		//selected=>0,
		required=>'yes'
	);

	$this -> Campos[si_tenedor] = array(
		name	=>'si_tenedor',
		id		=>'si_tenedor',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Tenedor_si();'
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);

	$this -> Campos[all_documento] = array(
		name	=>'all_documento',
		id		=>'all_documento',
		type	=>'checkbox',
		onclick =>'all_documentos();',
		value	=>'NO'
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
	
	  $this -> Campos[vehiculo_id] = array(
	  name	=>'vehiculo_id',
	  id	=>'vehiculo_id',
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
	
	$this -> Campos[descargar] = array(
    name   =>'descargar',
    id   =>'descargar',
    type   =>'button',
    value   =>'Descargar Excel Formato',
	onclick =>'descargarexcel(this.form)'
    );
	

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
	/*displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Reporte',
      width       => '800',
      height      => '600'*/
    );
	 
	$this -> SetVarsValidate($this -> Campos);
	
  }
  
  }

$reporteProveedores = new reporteProveedores();

?>