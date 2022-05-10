<?php

ini_set("memory_limit","2048M");

require_once("../../../framework/clases/ControlerClass.php");

final class reporteDespachos extends Controler{

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
		options	=>array(array(value => 'M', text => 'MANIFESTADO'),array(value => 'L', text => 'LIQUIDADO'),array(value => 'A', text => 'ANULADO'),array(value => 'P', text => 'PENDIENTE')),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(type=>'integer')
	);			
	
	
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("reporteDespachosLayoutClass.php");
    require_once("reporteDespachosModelClass.php");
	
    $Layout   = new reporteDespachosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteDespachosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    $Layout -> setOficinas($Model -> getOficinas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex()));    		
	$Layout -> RenderMain();
    
  }
  
  protected function generateReport(){

    require_once("reporteDespachosLayoutClass.php");
    require_once("reporteDespachosModelClass.php");
	
    $Layout   = new reporteDespachosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new reporteDespachosModel();
			
    $Layout -> setCssInclude("../../../framework/css/reset.css");	 	 	 
    $Layout -> setCssInclude("../../../framework/css/general.css");	 	 	 	 
    $Layout -> setCssInclude("../../../framework/css/generalDetalle.css");	 	 	 	
    $Layout -> setCssInclude("../../../framework/js/funciones.js");	 	 	 	
    $Layout -> setCssInclude("../../../transporte/reportes/js/reporteDespachos.js");	 	 	 		
	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	

	$data = $Model -> selectInformacionRemesas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());

    $Layout -> setVar("DATA",$data);			
    $Layout	-> RenderLayout('reporteDespachosResult.tpl');	
  
  }
     
  protected function generateFile(){
  
    require_once("reporteDespachosModelClass.php");
	
    $Model = new reporteDespachosModel();	
	$data  = $Model -> selectInformacionRemesas($this -> getEmpresaId(),$this -> getOficinaId(),$this -> getConex());	
    $ruta  = $this -> arrayToExcel("reporteDespachos","Reporte Despachos",$data['data']);
	
    $this -> ForceDownload($ruta);
		  
  }
	
}

$reporteDespachos = new reporteDespachos();

?>