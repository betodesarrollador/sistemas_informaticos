<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ImputacionContable extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
	    
    $this -> noCache();
    	
	require_once("ImputacionesContablesLayoutClass.php");
    require_once("ImputacionesContablesModelClass.php");
		
	$Layout                 = new ImputacionContableLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model                  = new ImputacionContableModel();	
    $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	
	
    $Layout -> setIncludes();
    $Layout -> setImputacionesContables($Model -> getImputacionesContables($encabezado_registro_id,$this -> getConex()));	
    $Layout -> setEstadoEncabezado($Model -> getEstadoEncabezado($encabezado_registro_id,$this -> getConex()));		
	/*
	//$download = $_REQUEST['download'];
	if($download == 'true'){
	    $Layout -> exportToExcel('imputacionescontables.tpl'); 		
	}else{	
		  $Layout -> RenderMain();
	  }*/
	$Layout -> RenderMain();
    
  }
  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"ruta",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }
  protected function onclickSave(){
  
    require_once("ImputacionesContablesModelClass.php");
	
    $Model = new ImputacionContableModel();
	
	$encabezado_registro_id= $_REQUEST['encabezado_registro_id'];
	$datos_encabezado=  $Model -> getEncabezado($encabezado_registro_id,$this -> getConex());
	$empresa_id=$datos_encabezado[0]['empresa_id'];
	$oficina_id=$datos_encabezado[0]['oficina_id'];
	$fecha=$datos_encabezado[0]['fecha'];
	
	$mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
	$periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());
	
    if($mesContable && $periodoContable){	
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
	}else{
			 if(!$mesContable && !$periodoContable){
			   exit("No se permite guardar en el periodo y mes seleccionado ");
			 }elseif(!$mesContable){
 			       exit("No se permite guardar en el mes seleccionado");				 
			   }else if(!$periodoContable){
			         exit("No se permite guardar en el periodo seleccionado");				   
				 }
		
		
	}
  }
  
  protected function onclickUpdate(){
    require_once("ImputacionesContablesModelClass.php");
	
    $Model = new ImputacionContableModel();

	$encabezado_registro_id= $_REQUEST['encabezado_registro_id'];
	$datos_encabezado=  $Model -> getEncabezado($encabezado_registro_id,$this -> getConex());
	$empresa_id=$datos_encabezado[0]['empresa_id'];
	$oficina_id=$datos_encabezado[0]['oficina_id'];
	$fecha=$datos_encabezado[0]['fecha'];

	$mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
	$periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());


    if($mesContable && $periodoContable){
	    $Model -> Update($this -> Campos,$this -> getConex());
			if(strlen(trim($Model -> GetError())) > 0){
	  			exit("Error : ".$Model -> GetError());
			}else{
        		exit("true");
	  		 }	
	}else{
		 if(!$mesContable && !$periodoContable){
		   exit("No se permite guardar en el periodo y mes seleccionado ");
		 }elseif(!$mesContable){
			   exit("No se permite guardar en el mes seleccionado");				 
		   }else if(!$periodoContable){
				 exit("No se permite guardar en el periodo seleccionado");				   
			 }
	}
  }
	  
  protected function onclickDelete(){
  
    require_once("ImputacionesContablesModelClass.php");
	
    $Model = new ImputacionContableModel();

	$encabezado_registro_id= $_REQUEST['encabezado_registro_id'];
	$datos_encabezado=  $Model -> getEncabezado($encabezado_registro_id,$this -> getConex());
	$empresa_id=$datos_encabezado[0]['empresa_id'];
	$oficina_id=$datos_encabezado[0]['oficina_id'];
	$fecha=$datos_encabezado[0]['fecha'];

	$mesContable     = $Model -> mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$this -> getConex());
	$periodoContable = $Model -> PeriodoContableEstaHabilitado($this -> getConex());

    if($mesContable && $periodoContable){	
	    $Model -> Delete($this -> Campos,$this -> getConex());
		if(strlen(trim($Model -> GetError())) > 0){
			exit("Error : ".$Model -> GetError());
		}else{
        	exit("true");
	  	}	 
	}else{
		 if(!$mesContable && !$periodoContable){
		   exit("No se permite eliminar en el periodo y mes seleccionado ");
		 }elseif(!$mesContable){
			   exit("No se permite eliminar en el mes seleccionado");				 
		   }else if(!$periodoContable){
				 exit("No se permite eliminar en el periodo seleccionado");				   
			 }		
	}
  }
  
  protected function getRequieresCuenta(){
    require_once("ImputacionesContablesModelClass.php");
	
    $Model                  = new ImputacionContableModel();
    $puc_id                 = $_REQUEST['puc_id'];
    $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	
	$data = $Model -> selectCuentaPuc($puc_id,$encabezado_registro_id,$this -> getConex());
	
	$this -> getArrayJSON($data);
		  
  }
  
  protected function getvalorCalculadoBase(){
	  
    require_once("ImputacionesContablesModelClass.php");
	
    $Model = new ImputacionContableModel();
	
    $puc_id                 = $_REQUEST['puc_id'];
    $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
    $base                   = $_REQUEST['base'];
	
	$data = $Model -> selectImpuesto($puc_id,$base,$encabezado_registro_id,$this -> getConex());
	
	print json_encode($data);
	  
  }
  	
	
	
}
new ImputacionContable();
?>