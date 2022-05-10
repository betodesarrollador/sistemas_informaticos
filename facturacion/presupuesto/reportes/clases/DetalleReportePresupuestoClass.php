<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleReportePresupuesto extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function getReportePresupuesto(){
  
    $this -> noCache();
    
    require_once("DetalleReportePresupuestoLayoutClass.php");
    require_once("DetalleReportePresupuestoModelClass.php");
	
    $Layout         = new DetalleReportePresupuestoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model          = new DetalleReportePresupuestoModel();
    $presupuesto_id = $this -> requestData('presupuesto_id'); 
	
	$download           = $this -> requestData('download');	
	
    $Layout -> setIncludes();	
    $Layout -> setDetalleReportePresupuesto($Model -> selectDetalleReportePresupuesto($presupuesto_id,$this -> getConex()));
//	exit ($_REQUEST['enero']);
	if($download == 'true'){
		
	    $Layout -> exportToExcel('DetalleReportePresupuesto.tpl'); 		
	}else{
		$Layout -> RenderMain();  
	}
	
    
    
  }
  
  	
}

new DetalleReportePresupuesto();

?>