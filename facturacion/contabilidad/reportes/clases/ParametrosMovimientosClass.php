<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ParametrosMovimientos extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
	     
    $this -> noCache();
    
	require_once("ParametrosMovimientosLayoutClass.php");
	require_once("ParametrosMovimientosModelClass.php");			
	require_once("UtilidadesContablesModelClass.php");

	$Layout = new ParametrosMovimientosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new ParametrosMovimientosModel(); 	
    $utilidadesContables = new UtilidadesContablesModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);
	$Layout->setCentrosCosto($utilidadesContables->getCentrosCosto($this->getEmpresaId(), $this->getConex()));

	//LISTA MENU
	//$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));	
	//$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this -> getConex()));		
	//$Layout -> setNivelesPuc($utilidadesContables -> getNivelesPuc($this -> getConex()));			
			
	$Layout -> RenderMain();	  
	  
  }
  
  protected function generateFile(){
  
    require_once("ParametrosMovimientosModelClass.php");
	
    $Model = new ParametrosMovimientosModel();	
	$data  = $Model -> selectRelacionMovimientos($this -> getConex());
    $ruta  = $this -> arrayToExcel("RelacionMovimientos","RelacionMovimientos",$data);
	
    $this -> ForceDownload($ruta);
		  
  }
    
  protected function setCampos(){

	$this->Campos[opciones_centros] = array(
		name => 'opciones_centros',
		id => 'opciones_centros',
		type => 'checkbox',
		value => 'U',
		datatype => array(type => 'text'),
	);

	$this->Campos[centro_de_costo_id] = array(
		name => 'centro_de_costo_id',
		id => 'centro_de_costo_id',
		type => 'select',
		required => 'yes',
		options => array(),
		multiple => 'yes',
		Boostrap =>'si',
		size => '3',
		datatype => array(
			type => 'integer',
			length => '9'),
	);


    /*****************************************
            	 datos sesion
	*****************************************/  
	$this -> Campos[fecha_inicial] = array(
		name	=>'fecha_inicial',
		id		=>'fecha_inicial',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	    datatype=>array(type=>'date')
	);
	
	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id		=>'fecha_final',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
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
new ParametrosMovimientos();
?>