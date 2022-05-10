<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ReportePresupuesto extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[presupuesto_id] = array(
		name	=>'presupuesto_id',
		id		=>'presupuesto_id',
		type	=>'select',
        options =>array(),
		datatype=>array(type=>'integer')
	);
	
    $this -> Campos[imprimir] = array(
		name   =>'imprimir',
		id   =>'imprimir',
		type   =>'button',
		value   =>'Imprimir',
		onclick =>'beforePrint(this.form)'
    );
	
		
	$this -> Campos[descargar] = array(
		name   =>'descargar',
		id   =>'descargar',
		type   =>'button',
		value   =>'Descargar Excel',
		onclick =>'descargarexcel(this.form)'
		);	
	
	$this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("ReportePresupuestoLayoutClass.php");
    require_once("ReportePresupuestoModelClass.php");
	
    $Layout   = new ReportePresupuestoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReportePresupuestoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());		
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
    $Layout -> setCampos($this -> Campos);	    
    $Layout -> setReportePresupuestos($Model -> getReportePresupuestos($this -> getConex())); 

	$Layout -> RenderMain();
    
  } 
  
    protected function onclickGenerarPresupuesto(){ 
    
	require_once("DetalleReportePresupuestoLayoutClass.php");
    require_once("DetalleReportePresupuestoModelClass.php");
	
    $Layout         = new DetalleReportePresupuestoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model          = new DetalleReportePresupuestoModel();
    $presupuesto_id = $this -> requestData('presupuesto_id'); 
	
    $Layout -> setIncludes();	
    $Layout -> setDetalleReportePresupuesto($Model -> selectDetalleReportePresupuesto($presupuesto_id,$this -> getConex()));

	$download           = $this -> requestData('download');	
	
	$arrayReport        = array();
	$Conex              = $this  -> getConex();	


	if($download == 'true'){
		
	    $Layout -> exportToExcel('DetalleReportePresupuesto.tpl'); 		
	}else{
	  $Layout -> RenderLayout('DetalleReportePresupuesto.tpl');
		}
  } 

  protected function setReporteReportePresupuesto(){
  
     print '<pre>';print_r($_REQUEST);
    
  }
  
	
}

new ReportePresupuesto();

?>