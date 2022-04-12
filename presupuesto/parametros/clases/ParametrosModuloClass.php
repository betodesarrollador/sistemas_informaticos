<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class ParametrosModulo extends Controler{
	
  private $HTMLcode;
  private $puc;
	
  public function __construct(){
	parent::__construct(3);
  }
  	
  public function Main(){    		
    $this ->getPlanCuentasTree();    	
  }  
  
  protected function getPlanCuentasTree(){
      
  	require_once("ParametrosModuloLayoutClass.php");
	require_once("ParametrosModuloModelClass.php");	  
    
	$Layout      = new ParametrosModuloLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model       = new ParametrosModuloModel();	
	$empresa_id  = $this->getEmpresaId();
	$this -> puc = array();	
	    
    $Cuentas = $Model -> getCuentasTree($empresa_id,$this -> getConex());
	
	$j = 0;
		
	for($i = 0; $i < count($Cuentas); $i++){
	  $this -> puc = array_merge($this -> puc,array($Cuentas[$i]));	  	  
	  $this -> getNodesTree($Cuentas[$i]['puc_id']);
	
	}
    
    $Layout ->setCampos();    
		
    $Layout -> setVar('sectionParametrosModuloTree',1);	
    $Layout -> setVar('print',0);		
    $Layout -> setVar('empresas',$empresas);	
    $Layout -> setVar('empresa_id',$empresa_id);	
    $Layout -> setVar('puc',$this -> puc);
		
    $Layout -> RenderLayout('parametrosmodulo.tpl');

  }
      
  protected function getNodesTree($IdParent){
  
	require_once("ParametrosModuloModelClass.php");	  
	
    $Model    = new ParametrosModuloModel();	
	
	$children = $Model -> getChildren($IdParent,$this -> getConex());
		
	if(count($children) > 0){
	
	   $j = 0;
	   
	   for($i = 0; $i < count($children); $i++){
		 		 
   	     $this -> puc = array_merge($this -> puc,array($children[$i]));		
		 		 
	     $this -> getNodesTree($children[$i]['puc_id']);
	   }
	   
	}else{
	     return false;
	  }
  
  }
  
  protected function setCuentaPresupuestar(){
    
	require_once("ParametrosModuloModelClass.php");	  
    
    $Model        = new ParametrosModuloModel();	    
    $puc_id       = $this->requestData('puc_id');
    $presupuestar = $this->requestData('presupuestar');
    
    $Model -> marcarCuentaPresupuestar($puc_id,$presupuestar,$this->getConex());
    
    if($Model->GetError()){
      print $Model->GetError();    
    }else{
       print 'true'; 
     }
    
  } 

}

new ParametrosModulo();

?>