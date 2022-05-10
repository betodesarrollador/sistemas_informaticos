<?php

require_once("../../../framework/clases/ControlerClass.php");

final class DetallePresupuesto extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("DetallePresupuestoLayoutClass.php");
    require_once("DetallePresupuestoModelClass.php");
	
    $Layout         = new DetallePresupuestoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model          = new DetallePresupuestoModel();
    $presupuesto_id = $this -> requestData('presupuesto_id'); 
	
    $Layout -> setIncludes();	
    $Layout -> setDetallePresupuesto($Model -> selectDetallePresupuesto($presupuesto_id,$this -> getConex()));
	
    $Layout -> RenderMain();
    
  }
  
  
  public function SetDetallePresupuesto(){

     require_once("DetallePresupuestoModelClass.php");
             
     $Model          = new DetallePresupuestoModel();
     $presupuesto_id = $this -> requestData('presupuesto_id'); 
     $presupuesto    = json_decode(stripslashes($_REQUEST['presupuesto']),1);
     
     $Model -> Save($presupuesto_id,$presupuesto['presupuesto'],$this -> getConex());
     
	 if($Model -> GetNumError() > 0){
	   exit($Model -> GetError());
	 }else{
	    exit('true');
	 }        

  }
  
  public function deleteRow(){
  
     require_once("DetallePresupuestoModelClass.php");
             
     $Model                  = new DetallePresupuestoModel();
     $detalle_presupuesto_id = $this -> requestData('detalle_presupuesto_id'); 
     
     $Model -> Delete($detalle_presupuesto_id,$this -> getConex());
     
	 if($Model -> GetNumError() > 0){
	   exit($Model -> GetError());
	 }else{
	    exit('true');
	 }            
  
  }
  
  	
}

new DetallePresupuesto();

?>