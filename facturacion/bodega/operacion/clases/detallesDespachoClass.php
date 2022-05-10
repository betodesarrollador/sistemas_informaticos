<?php

require_once("../../../framework/clases/ControlerClass.php");

final class detallesDespacho extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	  require_once("detallesDespachoLayoutClass.php");
      require_once("detallesDespachoModelClass.php");
		
	  $Layout         = new detallesDespachoLayout();
      $Model          = new detallesDespachoModel();	
    
    $estado = $_REQUEST['estado']; 
    $alistamiento_salida_id = $_REQUEST['alistamiento_salida_id'];	

    $empresa_id		= $this -> getEmpresaId();
    $oficina_id		= $this -> getOficinaId();	

    $Layout -> setIncludes();
    
    if($estado == 'A'){
       $Layout -> setDetalles($Model -> getDetalles($alistamiento_salida_id,$oficina_id,$this -> getConex()));	
    }else{
      $Layout -> setDetallesDespachados($Model -> getDetallesDespachados($alistamiento_salida_id,$oficina_id,$this -> getConex()));
    }
    
		
	  $Layout -> RenderMain();
    
  }

    protected function onclickSave(){
  
    require_once("detallesDespachoModelClass.php");
	
    $Model = new detallesDespachoModel();
	
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
    require_once("detallesDespachoModelClass.php");
    $Model = new detallesDespachoModel();
    $Model -> Update($this -> Campos,$this -> getConex());
	
    if(strlen(trim($Model -> GetError())) > 0){
      exit("Error : ".$Model -> GetError());
    }else{
          exit("true");
      }	

    }
	  
  protected function onclickDelete(){
  
    require_once("detallesDespachoModelClass.php");
	
    $Model = new detallesDespachoModel();
	
    $Model -> Delete($this -> Campos,$this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	  }	 

  }

  protected function traerCodigo(){

    require_once("detallesDespachoModelClass.php");
	
    $Model = new detallesDespachoModel();
    $return = $Model -> getCodigo($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function traerProducto(){

    require_once("detallesDespachoModelClass.php");
	
    $Model = new detallesDespachoModel();
    $return = $Model -> getProducto($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
        exit("Error : ".$Model -> GetError());
      }else{
      print json_encode($return); 
      }
  }

  protected function setLeerCodigobar() {
		require_once("detallesDespachooModelClass.php");
		$Model= new detallesDespachoModel();
	
		$Data = $Model -> setLeerCodigobar($this -> getConex());
				
		if($Data[0][producto_id]>0){
					$this -> getArrayJSON($Data);
		}else{
			exit('No existe el producto');	
		}
		
  }
  
    protected function setLeerCodigoSerial() {
		require_once("detallesDespachoModelClass.php");
		$Model= new detallesDespachoModel();
	
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

$detallesDespacho = new detallesDespacho();

?>