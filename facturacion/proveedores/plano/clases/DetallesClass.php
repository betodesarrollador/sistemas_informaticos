<?php

require_once("../../../framework/clases/ControlerClass.php");
final class Detalles extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("DetallesLayoutClass.php");
    require_once("DetallesModelClass.php");
		
	$Layout                 = new DetallesLayout();
    $Model                  = new DetallesModel();	
    $desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	
	
	
    $Layout -> setIncludes();
	
	$Layout -> setReporteFP_ALL($Model -> getReporteFP_ALL($desde,$hasta,$this -> getConex()));	
	
	 $download = $this -> requestData('download');
	
	if($download == 'true'){
	    $Layout -> exportToExcel('detalles.tpl'); 		
	}else{	
		  $Layout -> RenderMain();
	  }
    
  }
}

$Detalles = new Detalles();

?>