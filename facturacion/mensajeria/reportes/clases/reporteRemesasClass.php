<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteRemesas extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
    require_once("reporteRemesasLayoutClass.php");
    require_once("reporteRemesasModelClass.php");
	
    $Layout   = new reporteRemesasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteRemesasModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));	
	$Layout -> SetSi_Pro ($Model -> GetSi_Pro ($this -> getConex()));	
	$Layout -> SetEstado ($Model -> GetEstado ($this -> getConex()));
	$Layout -> SetClase  ($Model -> GetClase  ($this -> getConex()));	
	$Layout -> RenderMain();    
  }  

  protected function generateFile(){
  
    require_once("reporteRemesasModelClass.php");
	
    $Model     = new reporteRemesasModel();	

	$oficina_id				= $_REQUEST['oficina_id'];
	$estado_id				= $_REQUEST['estado_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];		
	$all_oficina			= $_REQUEST['all_oficina'];
	$all_estado 			= $_REQUEST['all_estado'];	
	$all_clase 			    = $_REQUEST['all_clase'];
	$clase_id				= $_REQUEST['clase_id'];

	if($all_estado == 'SI'){
	  $estado = str_replace(',',"','",$estado_id);
	}else{	 
	   $estado = str_replace(',',"','",$estado_id);
	}
	
	if($all_clase == 'SI'){
	  $clase = str_replace(',',"','",$clase_id);
	}else{	 
	   $clase = str_replace(',',"','",$clase_id);
	}	

	if($si_cliente=='ALL') $consulta_cliente=""; else $consulta_cliente=" AND r.cliente_id =".$cliente_id;
	
	$data  = $Model -> getReporte1($oficina_id,$estado,$desde,$hasta,$consulta_cliente,$clase,$this -> getConex());	
		
    $ruta  = $this -> arrayToExcel("ReporRemesas","Reporte Remesas",$data,null);

    if($_REQUEST['download'] == 'SI'){
      $this -> ForceDownload($ruta);	
	}else{
       print json_encode(array(ruta => $ruta, errores => $data[0]['validaciones']));	
	  }  
  }

/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento($this -> getConex());
    $print -> printOut();
  
  }*/  
  
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
	
	$this -> Campos[clase_id] = array(
		name	=>'clase_id',
		id		=>'clase_id',
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
		onchange=>'Cliente_si();'
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);
	
	$this -> Campos[all_estado] = array(
		name	=>'all_estado',
		id		=>'all_estado',
		type	=>'checkbox',
		onclick =>'all_estados();',
		value	=>'NO'
	);	
	
	$this -> Campos[all_clase] = array(
		name	=>'all_clase',
		id		=>'all_clase',
		type	=>'checkbox',
		onclick =>'all_clases();',
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

	$this -> Campos[generar_excel] = array(
		name	=>'generar_excel',
		id		=>'generar_excel',
		type	=>'button',
		value	=>'Generar Excel',
		onclick =>'OnclickGenerarExcel(this.form)'
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

$reporteRemesas = new reporteRemesas();

?>