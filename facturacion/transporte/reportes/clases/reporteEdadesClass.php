<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteEdades extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("reporteEdadesLayoutClass.php");
    require_once("reporteEdadesModelClass.php");
	
    $Layout   = new reporteEdadesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteEdadesModel();
    
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
  
    require_once("reporteEdadesModelClass.php");
	
	$Model      	        = new reporteEdadesModel();	
    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_tenedor				= $_REQUEST['si_tenedor'];
	$tenedor_id				= $_REQUEST['tenedor_id'];	
    $si_vehiculo			= $_REQUEST['si_vehiculo'];
	$vehiculo_id			= $_REQUEST['vehiculo_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	
	$all_documento			= $_REQUEST['all_documento'];
	$estado					= $_REQUEST['estado'];
	if($all_documento=='SI'){
		$nombre = 'Rep_Ant_Total'.date('Ymd');
	}else{
		if($tipo == 'MC'){
			 $nombre = 'Rep_Ant_MC'.date('Ymd');  
		}elseif($tipo == 'DU'){
			 $nombre = 'Rep_Ant_DU'.date('Ymd');
		}
	}
	
	if($tipo=='MC' && $si_vehiculo=='ALL' && $si_tenedor=='ALL')
		$data = $Model -> getReporteMC1($oficina_id,$desde,$hasta,$estado,$this -> getConex());		
	elseif($tipo=='DU' && $si_vehiculo=='ALL' && $si_tenedor=='ALL')
		$data = $Model -> getReporteDU1($oficina_id,$desde,$hasta,$estado,$this -> getConex());		
	
	elseif($tipo=='MC' && $si_vehiculo=='ALL' && $si_tenedor==1)
		$data = $Model -> getReporteMC2($oficina_id,$desde,$hasta,$tenedor_id,$estado,$this -> getConex());		
	elseif($tipo=='DU' && $si_vehiculo=='ALL' && $si_tenedor==1)
		$data = $Model -> getReporteDU2($oficina_id,$desde,$hasta,$tenedor_id,$estado,$this -> getConex());		
					
	elseif($tipo=='MC' && $si_vehiculo==1 && $si_tenedor=='ALL')
		$data = $Model -> getReporteMC3($oficina_id,$desde,$hasta,$vehiculo_id,$estado,$this -> getConex());		
	elseif($tipo=='DU' && $si_vehiculo==1 && $si_tenedor=='ALL')
		$data = $Model -> getReporteDU3($oficina_id,$desde,$hasta,$vehiculo_id,$estado,$this -> getConex());		

	elseif($tipo=='MC' && $si_vehiculo==1 && $si_tenedor==1)
		$data = $Model -> getReporteMC4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$estado,$this -> getConex());		
	elseif($tipo=='DU' && $si_vehiculo==1 && $si_tenedor==1)
		$data = $Model -> getReporteDU4($oficina_id,$desde,$hasta,$vehiculo_id,$tenedor_id,$estado,$this -> getConex());		

	elseif($all_documento=='SI' || $all_documento=='NO')
		$data = $Model -> getReporteALL($oficina_id,$desde,$hasta,$si_vehiculo,$vehiculo_id,$si_tenedor,$tenedor_id,$estado,$this -> getConex());		

   	$ruta  = $this -> arrayToExcel("Reporte",$nombre,$data,null,"string");		
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
		options	=>array(0=>array('value'=>'P','text'=>'PENDIENTES'),1=>array('value'=>'ALL','text'=>'TODOS')),
		selected=>0,
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

$reporteEdades = new reporteEdades();

?>