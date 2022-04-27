<?php
require_once("../../../framework/clases/ControlerClass.php");

final class InicialFacturacion extends Controler{

  public function __construct(){    
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("InicialFacturacionLayoutClass.php");
	require_once("InicialFacturacionModelClass.php");
	
	$Layout = new InicialFacturacionLayout($this -> getTitleTab(),$this -> getTitleForm());
	$Model  = new InicialFacturacionModel();
	
	$Layout -> SetCampos($this -> Campos);
	
    $Layout -> setValorFacturado  ($Model -> GetValorFacturado($this -> getConex()));
   	$Layout -> setValorSaldo ($Model -> GetValorSaldo($this -> getConex()));
	$Layout -> setValorPagado ($Model -> GetValorPagado($this -> getConex()));
	   

    $Layout -> RenderMain();    
  }  

   public function getMayorSaldo($Conex=''){
  
      require_once("InicialFacturacionModelClass.php"); 
     
      $Model = new InicialFacturacionModel();
    
      $Data  = $Model -> selectMayorSaldo($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
	
   }

   public function getValores($Conex=''){
  
      require_once("InicialFacturacionModelClass.php"); 
     
      $Model = new InicialFacturacionModel();
    
      $Data  = $Model -> selectValores($this -> getConex());

      if(strlen(trim($Model -> GetError())) > 0){
		   exit("Error : ".$Model -> GetError());
      }else{
         echo json_encode($Data); 
      } 
      
	
   }

  protected function SetCampos(){
	
	$this -> Campos[facturado] = array(
		name	=>'facturado',
		id		=>'facturado',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);


	$this -> Campos[saldo] = array(
		name	=>'saldo',
		id		=>'saldo',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);

	$this -> Campos[pagado] = array(
		name	=>'pagado',
		id		=>'pagado',
		Boostrap=>'si',
		type	=>'text',
		readonly=>'yes'
	);

	$this -> SetVarsValidate($this -> Campos);
	}
  
  
}

new InicialFacturacion();

?>