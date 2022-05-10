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
  
  protected function generateFileexcel(){
  
    require_once("reporteTrazabilidadModelClass.php");
	
	$Model      	        = new reporteTrazabilidadModel();	
    $oficina_id				= $_REQUEST['oficina_id'];
	$estado_id				= $_REQUEST['estado_id'];
	$trazabilidad_id		= $_REQUEST['trazabilidad_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];		
	$all_oficina			= $_REQUEST['all_oficina'];
	$all_estado 			= $_REQUEST['all_estado'];
	$all_trazabilidad 		= $_REQUEST['all_trazabilidad'];
	
	if($estado_id == 'MC'){
      	$nombre = 'Tra_MC'.date('Ymd');	  
    }elseif($estado_id == 'DU'){
			$nombre = 'Tra_DU'.date('Ymd');	
	}elseif($all_estado == 'SI'){
	  		$nombre = 'Rep_Tra'.date('Ymd');	
	}
	
	if($estado_id=='MC' && $si_cliente=='ALL' && $all_trazabilidad == 'SI')
		$data = $Model -> getReporte1($oficina_id,$desde,$hasta,$this -> getConex());
		
	elseif($estado_id=='DU' && $si_cliente=='ALL' && $all_trazabilidad == 'SI')
     	$data = $Model -> getReporte2($oficina_id,$desde,$hasta,$this -> getConex());
		
	elseif($all_estado=='SI' && $si_cliente=='ALL' && $all_trazabilidad == 'SI')
		$data = $Model -> getReporte3($oficina_id,$desde,$hasta,$this -> getConex());	
		
	elseif($estado_id=='MC' && $si_cliente==1 && $all_trazabilidad == 'SI')
     	$data = $Model -> getReporte4($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());	
		
	elseif($estado_id=='DU' && $si_cliente==1 && $all_trazabilidad == 'SI')
     	$data = $Model -> getReporte5($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());
		
	elseif($all_estado=='SI' && $si_cliente==1 && $all_trazabilidad == 'SI')
     	$data = $Model -> getReporte6($oficina_id,$desde,$hasta,$cliente_id,$this -> getConex());
	
    $ruta  = $this -> arrayToExcel("Reportes",$nombre,$data,null,"string");	
	
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

$reporteTrazabilidad = new reporteTrazabilidad();

?>