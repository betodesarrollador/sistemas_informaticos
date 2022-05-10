<?php

require_once("../../../framework/clases/ControlerClass.php");

final class InformacionExogenaMun extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  

  public function Main(){
  
    $this -> noCache();
    
    require_once("InformacionExogenaMunLayoutClass.php");
    require_once("InformacionExogenaMunModelClass.php");
	
    $Layout   = new InformacionExogenaMunLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new InformacionExogenaMunModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    $Layout -> setFormatos($Model -> getFormato($this -> getConex()));    
    $Layout -> setPeriodo($Model -> getPeriodo($this -> getConex()));    	
	
	$Layout -> RenderMain();
    
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[formato_exogena_id] = array(
		name	=>'formato_exogena_id',
		id		=>'formato_exogena_id',
		type	=>'select',
		required=>'yes',
		datatype=>array(type=>'integer')
	);
	
	$this -> Campos[periodo_contable_id] = array(
		name	=>'periodo_contable_id',
		id		=>'periodo_contable_id',
		type	=>'select',
		required=>'yes',
		datatype=>array(type=>'integer')
	);	
	
  }  
   
  protected function generateFile(){
  
    require_once("InformacionExogenaMunModelClass.php");
	
    $Model            = new InformacionExogenaMunModel();	
	$formato_exogena_id  = $_REQUEST['formato_exogena_id'];
	$periodo_contable_id = $_REQUEST['periodo_contable_id'];
	$download         = $_REQUEST['download'] > 0 ? true : false;
	
	$formato  = $Model -> selectFormato($formato_exogena_id,$this -> getConex()); 
	$periodo  = $Model -> selectPeriodo($periodo_contable_id,$this -> getConex()); 
	$data  = $Model -> selectDataExogena($periodo_contable_id,$formato_exogena_id,$this -> getConex());   
	
    $ruta  = $this -> arrayToExcel("archivoReporteExogena","Reporte Exogena",$data,null);
	
	if($download){
     $this -> ForceDownload($ruta,"Exogena_F".$formato.'_Periodo_'.$periodo.'_Creado'.date('Y-m-d').".xls");
	}else{
	     print $ruta;
	  }
	  
  }
	
}

new InformacionExogenaMun();

?>