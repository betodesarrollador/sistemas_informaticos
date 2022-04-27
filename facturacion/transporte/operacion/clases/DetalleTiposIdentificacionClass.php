<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetalleTiposIdentificacion extends Controler{

  public function __construct(){
	parent::__construct(3);
  }


  public function Main(){
      
    $this -> noCache();
    
    require_once("DetalleTiposIdentificacionLayoutClass.php");
    require_once("DetalleTiposIdentificacionModelClass.php");
	
    $Layout = new DetalleTiposIdentificacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new DetalleTiposIdentificacionModel();

    $cliente_id = $_REQUEST['cliente_id'];

    $Layout -> setIncludes();	
    $Layout -> setTiposIdentificacion($Model -> getTiposIdentificacion($this -> getConex()));	
    $Layout -> setDetallesTiposIdentificacion($Model -> getDetallesTiposIdentificacion($cliente_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  public function setDetalleTiposIdentificacion(){
  
    require_once("DetalleTiposIdentificacionModelClass.php");
	
    $Model         = new DetalleTiposIdentificacionModel();
	$camposArchivo = $_REQUEST['campos_archivo'];
	$cliente_id    = $_REQUEST['cliente_id'];
	
	if($Model -> saveDetalleTiposIdentificacion($cliente_id,$camposArchivo,$this -> getConex())){
	  exit('true');
	}else{
	    exit('false');
	  }
	  
  
  }
   
	
}

$DetalleTiposIdentificacion = new DetalleTiposIdentificacion();

?>