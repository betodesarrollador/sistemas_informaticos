<?php


require_once("../../../framework/clases/ControlerClass.php");

final class TiemposManifiestos extends Controler{

  public function __construct(){  
  	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("TiemposManifiestosLayoutClass.php");
	require_once("TiemposManifiestosModelClass.php");
	
	$Layout = new TiemposManifiestosLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new TiemposManifiestosModel();
	
    $Layout -> setIncludes();	
    $Layout -> setTiemposManifiesto($Model -> getTiemposManifiesto($this -> getConex()));	
	$Layout -> RenderMain();
	
  }  
	  
  protected function onclickUpdate(){
  
	require_once("TiemposManifiestosModelClass.php");
	
	$Model  = new TiemposManifiestosModel();
	  
	$Model -> Update($this -> getConex());  
	  
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
	     exit('true');
	  }	
  
  }  
			
}

new TiemposManifiestos();

?>