<?php
require_once("../../../framework/clases/ControlerClass.php");

final class PanelSoporte extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("PanelSoporteLayoutClass.php");
	require_once("PanelSoporteModelClass.php");
	
	$Layout = new PanelSoporteLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new PanelSoporteModel();
	
	$Layout -> SetCampos($this -> Campos);
	
  /*   $Layout -> setValorFacturado  ($Model -> GetValorFacturado($this -> getConex()));
   	$Layout -> setValorSaldo ($Model -> GetValorSaldo($this -> getConex()));
   $Layout -> setValorPagado ($Model -> GetValorPagado($this -> getConex())); */
   $Data  = $Model -> selectActividades($this -> getConex());
   $Prom  = $Model -> selectAvances($this -> getConex());
   $Layout -> setVar("PROM",$Prom);
   $Layout -> setVar("DATA",$Data);
	   

    $Layout -> RenderMain();    
  }  


   public function getValores($Conex){
  
      require_once("PanelSoporteModelClass.php"); 
     
      $Model = new PanelSoporteModel();
    
      $Data  = $Model -> selectValores($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

     public function getActividades($Conex){
  
      require_once("PanelSoporteModelClass.php"); 
     
	  $Model = new PanelSoporteModel();
    
      $Data  = $Model -> selectActividades($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   } 


   public function guardarObservacion($Conex){
  
      require_once("PanelSoporteModelClass.php"); 
     
	  $Model = new PanelSoporteModel();
	  
	  $soporte_id = $_REQUEST['soporte_id'];
	  $observacion = $_REQUEST['observacion'];
    
      $Data  = $Model -> saveObservacion($soporte_id,$observacion,$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

   public function guardarCierre($Conex){
  
      require_once("PanelSoporteModelClass.php"); 
     
	  $Model = new PanelSoporteModel();
	  
	  $soporte_id = $_REQUEST['soporte_id'];
     $observacion_cierre = $_REQUEST['observacion_cierre'];
     $fecha_cierre_real = $_REQUEST['fecha_cierre_real'];
     $fecha_cierre = date("Y-m-d H:i:s");
    
      $Data  = $Model -> saveCierre($soporte_id,$observacion_cierre,$fecha_cierre_real,$fecha_cierre,$this->getUsuarioId(),$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         exit($Data);
      } 
      
   }

   public function getObservaciones($Conex){
  
      require_once("PanelSoporteModelClass.php"); 
     
      $Model = new PanelSoporteModel();
    
      $soporte_id = $_REQUEST['soporte_id'];
      $Data  = $Model -> selectObservaciones($soporte_id,$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

  protected function SetCampos(){
	
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);


	$this -> Campos[proyecto] = array(
		name	=>'proyecto',
		id		=>'proyecto',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);


	$this -> SetVarsValidate($this -> Campos);
	}
  
  
}

new PanelSoporte();

?>