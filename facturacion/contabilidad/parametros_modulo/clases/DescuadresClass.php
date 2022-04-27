<?php
require_once("../../../framework/clases/ControlerClass.php");
final class Descuadres extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
	     
    $this -> noCache();
    
	require_once("DescuadresLayoutClass.php");
	require_once("DescuadresModelClass.php");			
	
	$Layout = new DescuadresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DescuadresModel(); 	
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);			
	$Layout -> RenderMain();	  
	  
  }
  
  protected function generateFile(){
      
    require_once("DescuadresModelClass.php");
	
    $Model = new DescuadresModel();	
	$data  = $Model -> selectRelacionMovimientos($this -> getConex());
    $ruta  = $this -> arrayToExcel("RelacionMovimientos","RelacionMovimientos",$data);
	
    $this -> ForceDownload($ruta);
		  
  }
    
  protected function setCampos(){
    /*****************************************
            	 datos sesion
	*****************************************/  
	$this -> Campos[fecha_inicial] = array(
		name	=>'fecha_inicial',
		id		=>'fecha_inicial',
		type	=>'text',
	    datatype=>array(type=>'date')
	);
	
	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id		=>'fecha_final',
		type	=>'text',
	    datatype=>array(type=>'date')
	);
        	
	
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'generateFile(this.form)'
	);			
	
	$this -> SetVarsValidate($this -> Campos);
    
  }
	
	
}
new Descuadres();
?>