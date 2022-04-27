<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Subtotal extends Controler{

  public function __construct(){
  
	parent::__construct(3);
    
  }


  public function Main(){
	    
    $this -> noCache();
    	
	  require_once("SubtotalLayoutClass.php");
    require_once("SubtotalModelClass.php");
		
	  $Layout                 = new SubtotalLayout();
    $Model                  = new SubtotalModel();	
  	$empresa_id 			= $this -> getEmpresaId();
	  $oficina_id 			= $this -> getOficinaId();	
    $abono_factura_id 			= $_REQUEST['abono_factura_id'];
    
    $Layout -> setIncludes();
    $Layout -> setDetalles($Model -> getDetalles($abono_factura_id,$empresa_id,$oficina_id,$this -> getConex()));	
		
	  $Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),$this ->Campos);
    echo json_encode($Data -> GetData());
  }

  protected function previsualizar(){

    require_once("SubtotalLayoutClass.php");
    require_once("SubtotalModelClass.php");

	  $Layout = new SubtotalLayout();
    $Model = new SubtotalModel();

        $remesas   = $_REQUEST['remesas'];
        $ordenes   = $_REQUEST['ordenes'];
        $previsual = $_REQUEST['previsual'];
        $aplica_total_factura = $_REQUEST['aplica_total_factura'];
        $valores_abono_factura = $_REQUEST['valores_abono_factura'];
        
        $data = $Model->previsual(0,$valores_abono_factura,$aplica_total_factura,$previsual,$remesas,$ordenes,$this->getEmpresaId(),$this->getOficinaId(),$this->getUsuarioId(),$this->getConex());
    
        
        if(strlen($Model -> GetError()) > 0){
            exit('Ocurrio una inconsistencuia'.$Model -> GetError());
        }else{
            $Layout->setIncludes();
            $Layout->setDetalles($data);
            $Layout->RenderMain();
        }

  }



}

$Subtotal = new Subtotal();

?>