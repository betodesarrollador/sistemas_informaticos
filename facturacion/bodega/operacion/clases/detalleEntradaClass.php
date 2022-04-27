<?php

require_once("../../../framework/clases/ControlerClass.php");

final class detalleEntrada extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	  require_once("detalleEntradaLayoutClass.php");
    require_once("detalleEntradaModelClass.php");
		
	  $Layout         = new detalleEntradaLayout();
    $Model          = new detalleEntradaModel();	
    
    $estado           = $_REQUEST['estado']; 
    $recepcion_id 		= $_REQUEST['recepcion_id'];	
    $entrada_id 			= $_REQUEST['entrada_id'];	

    $empresa_id		= $this -> getEmpresaId();
    $oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    
    if($estado == 'P'){
       $Layout -> setDetalles($Model -> getDetalles($recepcion_id,$oficina_id,$this -> getConex()));	
    }else{

      $Layout -> setDetallesIngresados($Model -> getDetallesIngresados($entrada_id,$recepcion_id,$oficina_id,$this -> getConex()));

    }
    
		
	  $Layout -> RenderMain();
    
  }

    protected function onclickSave(){
  
    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
	  if(strlen(trim($Model -> GetError())) > 0){
	      exit("Error : ".$Model -> GetError());
	  }else{
        if(is_numeric($return)){
		     exit("$return");
		    }else{
		      exit('false');
		    }
	  }	

  }

  /* protected function onclickSaveInventario(){
  
    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();
	
    $return = $Model -> SaveInventario($this -> Campos,$this -> getConex());
	
	  if(strlen(trim($Model -> GetError())) > 0){
	      exit("Error : ".$Model -> GetError());
	  }else{
        if(is_numeric($return)){
		     exit("$return");
		    }else{
		      exit('false');
		    }
	  }	

  } */

    protected function onclickUpdate(){
    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
    if(strlen(trim($Model -> GetError())) > 0){
      exit("Error : ".$Model -> GetError());
    }else{
          exit("true");
      }	

    }
	  
  protected function onclickDelete(){
  
    require_once("detalleEntradaModelClass.php");
	
    $Model = new detalleEntradaModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

    protected function pendientesInventario(){

    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();
    
    $recepcion_id 			= $_REQUEST['recepcion_id'];	
    $entrada_id 			= $_REQUEST['entrada_id'];	
    
    $return = $Model -> getPendientes($entrada_id,$recepcion_id,$this -> getConex());
    
      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
 
  }

  protected function traerUbicacion(){

    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();

    $return = $Model -> getUbicaciones($this -> getConex());
    
      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
 
  }

  protected function traerPosicion(){

    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();

    $return = $Model -> getPosiciones($this -> getConex());
    
    
      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
 
  }

  protected function traerEstado(){

    require_once("detalleEntradaModelClass.php");
    $Model = new detalleEntradaModel();

    $return = $Model -> getEstados($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function traerCodigo(){

    require_once("detalleEntradaModelClass.php");
	
    $Model = new detalleEntradaModel();
    $return = $Model -> getCodigo($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function traerProducto(){

    require_once("detalleEntradaModelClass.php");
	
    $Model = new detalleEntradaModel();
    $return = $Model -> getProducto($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function setLeerCodigobar() {
		require_once("detalleEntradaoModelClass.php");
		$Model= new detalleEntradaModel();
	
		$Data = $Model -> setLeerCodigobar($this -> getConex());
				
		if($Data[0][producto_id]>0){
					$this -> getArrayJSON($Data);
		}else{
			exit('No existe el producto');	
		}
		
  }
  
    protected function setLeerCodigoSerial() {
		require_once("detalleEntradaModelClass.php");
		$Model= new detalleEntradaModel();
	
    $return = $Model -> Save($this -> Campos,$this -> getConex());
	
	  if(strlen(trim($Model -> GetError())) > 0){
	      exit("Error : ".$Model -> GetError());
	  }else{
        if(is_numeric($return)){
		     exit("$return");
		    }else{
		      exit('false');
		    }
	  }	
		
  }	 

  

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    print json_encode($Data -> GetData());
  }


	  

}

$detalleEntrada = new detalleEntrada();

?>