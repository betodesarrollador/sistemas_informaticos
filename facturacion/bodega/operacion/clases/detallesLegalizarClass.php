<?php

require_once("../../../framework/clases/ControlerClass.php");

final class detallesLegalizar extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	  require_once("detallesLegalizarLayoutClass.php");
    require_once("detallesLegalizarModelClass.php");
		
	  $Layout         = new detallesLegalizarLayout();
    $Model          = new detallesLegalizarModel();	
    
    $estado              	= $_REQUEST['estado']; 
    $recepcion_id 				= $_REQUEST['recepcion_id'];	

    $empresa_id		= $this -> getEmpresaId();
    $oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    
    if($estado == 'P'){
       $Layout -> setDetalles($Model -> getDetalles($recepcion_id,$oficina_id,$this -> getConex()));	
    }else{
      $Layout -> setDetallesLegalizados($Model -> getDetallesLegalizados($recepcion_id,$oficina_id,$this -> getConex()));
    }
    
		
	  $Layout -> RenderMain();
    
  }

    protected function onclickSave(){
  
    require_once("detallesLegalizarModelClass.php");
	
    $Model = new detallesLegalizarModel();
	
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
    require_once("detallesLegalizarModelClass.php");
    $Model = new detallesLegalizarModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
    if(strlen(trim($Model -> GetError())) > 0){
      exit("Error : ".$Model -> GetError());
    }else{
          exit("true");
      }	

    }
	  
  protected function onclickDelete(){
  
    require_once("detallesLegalizarModelClass.php");
	
    $Model = new detallesLegalizarModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

  protected function traerCodigo(){

    require_once("detallesLegalizarModelClass.php");
	
    $Model = new detallesLegalizarModel();
    $return = $Model -> getCodigo($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function traerProducto(){

    require_once("detallesLegalizarModelClass.php");
	
    $Model = new detallesLegalizarModel();
    $return = $Model -> getProducto($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function setLeerCodigobar() {
		require_once("detallesLegalizaroModelClass.php");
		$Model= new detallesLegalizarModel();
	
		$Data = $Model -> setLeerCodigobar($this -> getConex());
				
		if($Data[0][producto_id]>0){
					$this -> getArrayJSON($Data);
		}else{
			exit('No existe el producto');	
		}
		
  }
  
    protected function setLeerCodigoSerial() {
		require_once("detallesLegalizarModelClass.php");
		$Model= new detallesLegalizarModel();
	
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

$detallesLegalizar = new detallesLegalizar();

?>