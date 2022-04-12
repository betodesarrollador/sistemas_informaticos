<?php

require_once("../../../framework/clases/ControlerClass.php");

final class archivoUIAF extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  

  public function Main(){
  
    $this -> noCache();
    
    require_once("archivoUIAFLayoutClass.php");
    require_once("archivoUIAFModelClass.php");
	
    $Layout   = new archivoUIAFLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new archivoUIAFModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);	
	
	//LISTA MENU
    $Layout -> setPeriodosUIAF($Model -> getPeriodosUIAF($this -> getConex()));    
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    	
	
	$Layout -> RenderMain();
    
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[periodo_uiaf_id] = array(
		name	=>'periodo_uiaf_id',
		id		=>'periodo_uiaf_id',
		type	=>'select',
		required=>'yes',
		datatype=>array(type=>'integer')
	);
	
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'select',
		required=>'yes',
		datatype=>array(type=>'integer')
	);	
	
  }  
   
  protected function generateFile(){
  
    require_once("archivoUIAFModelClass.php");
	
    $Model            = new archivoUIAFModel();	
	$periodo_uiaf_id  = $_REQUEST['periodo_uiaf_id'];
	$download         = $_REQUEST['download'] > 0 ? true : false;
	
	$data  = $Model -> selectDataUIAF($periodo_uiaf_id,$this -> getConex());   
	
    $ruta  = $this -> arrayToExcel("archivoReporteUIAF","Reporte Trimestral UIAF",$data);
	
	if($download){
     $this -> ForceDownload($ruta);
	}else{
	     print $ruta;
	  }
	  
  }
	
}

new archivoUIAF();

?>