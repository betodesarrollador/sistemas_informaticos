<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Panel extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("PanelLayoutClass.php");
	require_once("PanelModelClass.php");
	
	$Layout = new PanelLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new PanelModel();
	
	$Layout -> SetCampos($this -> Campos);
	
  /*   $Layout -> setValorFacturado  ($Model -> GetValorFacturado($this -> getConex()));
   	$Layout -> setValorSaldo ($Model -> GetValorSaldo($this -> getConex()));
	$Layout -> setValorPagado ($Model -> GetValorPagado($this -> getConex())); */
	   

    $Layout -> RenderMain();    
  }  


   public function getValores($Conex){
  
      require_once("PanelModelClass.php"); 
     
      $Model = new PanelModel();
    
      $Data  = $Model -> selectValores($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

     public function getActividades($Conex){
  
      require_once("PanelModelClass.php"); 
     
	  $Model = new PanelModel();
	  
	  $cliente_id = $_REQUEST['cliente_id'];
    
      $Data  = $Model -> selectActividades($cliente_id,$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   } 


   public function guardarObservacion($Conex){
  
      require_once("PanelModelClass.php"); 
     
	  $Model = new PanelModel();
	  
	  $actividad_id = $_REQUEST['actividad_id'];
	  $observacion = $_REQUEST['observacion'];
    
      $Data  = $Model -> saveObservacion($actividad_id,$observacion,$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
   }

   public function guardarCierre($Conex){
  
      require_once("PanelModelClass.php"); 
     
	  $Model = new PanelModel();
	  
	  $actividad_id = $_REQUEST['actividad_id'];
     $observacion_cierre = $_REQUEST['observacion_cierre'];
     $fecha_cierre_real = $_REQUEST['fecha_cierre_real'];
     $fecha_cierre = date("Y-m-d H:i:s");
    
      $Data  = $Model -> saveCierre($actividad_id,$observacion_cierre,$fecha_cierre_real,$fecha_cierre,$this->getUsuarioId(),$this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         exit($Data);
      } 
      
   }

   public function getObservaciones($Conex){
  
      require_once("PanelModelClass.php"); 
     
      $Model = new PanelModel();
    
      $actividad_id = $_REQUEST['actividad_id'];
      $Data  = $Model -> selectObservaciones($actividad_id,$this -> getConex());

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

new Panel();

?>