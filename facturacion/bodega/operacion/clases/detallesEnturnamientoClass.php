<?php

require_once("../../../framework/clases/ControlerClass.php");

final class detallesEnturnamiento extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	require_once("detallesEnturnamientoLayoutClass.php");
    require_once("detallesEnturnamientoModelClass.php");
		
	  $Layout         = new detallesEnturnamientoLayout();
    $Model          = new detallesEnturnamientoModel();	
    $enturnamiento_id 				= $_REQUEST['enturnamiento_id'];
	//$fuente_facturacion_cod 	= $_REQUEST['fuente_facturacion_cod'];
	
    $empresa_id		= $this -> getEmpresaId();
    $oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    $Layout -> setDetalles($Model -> getDetalles($enturnamiento_id,$oficina_id,$this -> getConex()));	
		
	  $Layout -> RenderMain();
    
  }

    protected function onclickSave(){
  
    require_once("detallesEnturnamientoModelClass.php");
	
    $Model = new detallesEnturnamientoModel();
	
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

    protected function onclickUpdate(){
    require_once("detallesEnturnamientoModelClass.php");
    $Model = new detallesEnturnamientoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
    if(strlen(trim($Model -> GetError())) > 0){
      exit("Error : ".$Model -> GetError());
    }else{
          exit("true");
      }	

    }
	  
  protected function onclickDelete(){
  
    require_once("detallesEnturnamientoModelClass.php");
	
    $Model = new detallesEnturnamientoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

  protected function traerCodigo(){

    require_once("detallesEnturnamientoModelClass.php");
	
    $Model = new detallesEnturnamientoModel();
    $return = $Model -> getCodigo($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function traerProducto(){

    require_once("detallesEnturnamientoModelClass.php");
	
    $Model = new detallesEnturnamientoModel();
    $return = $Model -> getProducto($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function setLeerCodigobar() {
		require_once("detallesEnturnamientoModelClass.php");
		$Model= new detallesEnturnamientoModel();
	
		$Data = $Model -> setLeerCodigobar($this -> getConex());
				
		if($Data[0][producto_id]>0){
					$this -> getArrayJSON($Data);
		}else{
			exit('No existe el producto');	
		}
		
  }
  
    protected function setLeerCodigoSerial() {
		require_once("detallesEnturnamientoModelClass.php");
		$Model= new detallesEnturnamientoModel();
	
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

$detallesEnturnamiento = new detallesEnturnamiento();

?>