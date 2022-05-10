<?php
ini_set("memory_limit","2048M");
ini_set('max_execution_time',1200);
require_once("../../../framework/clases/ControlerClass.php");

final class Despachos extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[fecha_inicio] = array(
		name	=>'fecha_inicio',
		id		=>'fecha_inicio',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'date')
	);
	
	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id		=>'fecha_final',
		type	=>'text',
		required=>'yes',
		datatype=>array(type=>'date')
	);	
	
	$this -> Campos[opciones_conductor] = array(
		name	=>'opciones_conductor',
		id		=>'opciones_conductor',
		type	=>'select',
		options => array(array(value => 'U', text => 'UNO'),array(value => 'T', text => 'TODOS')),
		selected=>'T',
		required=>'yes',
		datatype=>array(type=>'text')
	);		
	
	$this -> Campos[conductor] = array(
		name	 =>'conductor',
		id		 =>'conductor',
		type	 =>'text',
		size     =>'35',
		disabled =>'true',
		suggest=>array(
			name	=>'conductor',
			setId	=>'conductor_hidden'
			)
	);
		
	$this -> Campos[conductor_id] = array(
		name	=>'conductor_id',
		id	    =>'conductor_hidden',
		type	=>'hidden',
		datatype=>array(type=>'integer')
	);
	
	$this -> Campos[opciones_placa] = array(
		name	=>'opciones_placa',
		id		=>'opciones_placa',
		type	=>'select',
		options => array(array(value => 'U', text => 'UNO'),array(value => 'T', text => 'TODOS')),
		selected=>'T',
		required=>'yes',
		datatype=>array(type=>'text')
	);	
	
	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
		disabled=>'true',
		suggest=>array(
			name	=>'busca_vehiculo',
			setId	=>'placa_id_hidden'
			)
	);
		
	$this -> Campos[placa_id] = array(
		name	=>'placa_id',
		id	    =>'placa_id_hidden',
		type	=>'hidden',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[opciones_oficina] = array(
		name	=>'opciones_oficina',
		id		=>'opciones_oficina',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);		
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(type=>'integer')
	);
	
	$this -> Campos[opciones_estado] = array(
		name	=>'opciones_estado',
		id		=>'opciones_estado',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);				
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		required=>'yes',
		options	=>array(array(value => 'P', text => 'PENDIENTE'),array(value => 'M', text => 'MANIFESTADO'),array(value => 'L', text => 'LIQUIDADO'),array(value => 'A', text => 'ANULADO')),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(type=>'integer')
	);			

	$this -> Campos[opciones_documento] = array(
		name	=>'opciones_documento',
		id		=>'opciones_documento',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);				
	
	$this -> Campos[documento] = array(
		name	=>'documento',
		id		=>'documento',
		type	=>'select',
		required=>'yes',
		options	=>array(array(value => 'MC', text => 'MANIFIESTO DE CARGA'),array(value => 'DU', text => 'DESPACHO URBANO')),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(type=>'integer')
	);			

	
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DespachosLayoutClass.php");
    require_once("DespachosModelClass.php");
	
    $Layout   = new DespachosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DespachosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    $Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));    		
	$Layout -> RenderMain();
    
  }
  
  protected function generateReport(){

    require_once("DespachosLayoutClass.php");
    require_once("DespachosModelClass.php");
	
    $Layout   = new DespachosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new DespachosModel();
			
    $Layout -> setCssInclude("/velotax/framework/css/reset.css");	 	 	 
    $Layout -> setCssInclude("/velotax/framework/css/general.css");	 	 	 	 
    $Layout -> setCssInclude("/velotax/framework/css/generalDetalle.css");	 	 	 	
    $Layout -> setCssInclude("/velotax/framework/js/funciones.js");	 	 	 	
    $Layout -> setCssInclude("/velotax/transporte/reportes/js/Despachos.js");	 	 	 		
	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	

	$data = $Model -> selectInformacionRemesas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());

    $Layout -> setVar("DATA",$data);			
    $Layout	-> RenderLayout('DespachosResult.tpl');	
  
  }
     
  protected function generateFile(){
  
    require_once("DespachosModelClass.php");
	
    $Model = new DespachosModel();	
	$data  = $Model -> selectInformacionRemesas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());	
	$data  = $data['data'];

	
	$ruta_archivos = $_SERVER['DOCUMENT_ROOT'].'/velotax/archivos/transporte/despachos/';
		
	$file = "$ruta_archivos/Consolidado_Despachos".date("Y-m-d_H-i-s").".csv";	
	
    $ruta  = $this -> arrayToExcel("Despachos","Consolidado Despachos",$data,null);
	
    $this -> ForceDownload($ruta,"Consolidado_Despachos".date('Y-m-d_H-i-s').".xls");
	
	/*$fl   = fopen("$file","w");
	fclose($fl);
	
	$fl     = fopen("$file","w+");	
	$linea  = null;
	
	$titulos = array_keys($data[0]);
		
	foreach($titulos as $llave => $valor){
 		$linea .= "$valor;";
	}
	
	$linea .= "\n";		
	
	for($i = 0; $i < count($data); $i++){
	
		foreach($data[$i] as $llave => $valor){
			$linea .= "$valor;";
		}
		
		$linea .= "\n";			
		
	}		

    fwrite($fl,$linea);
	fclose($fl);	

    $this -> ForceDownload($file,"Consolidado_Despachos".date('Y-m-d').".csv");
	
    //$ruta  = $this -> arrayToExcel("Despachos","Reporte Despachos",$data['data']);
	
    //$this -> ForceDownload($ruta);
	*/	  
  }
	
}

new Despachos();
?>