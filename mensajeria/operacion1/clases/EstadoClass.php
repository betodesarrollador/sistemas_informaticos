<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Estado extends Controler{

  public function __construct(){  
	$this -> setCampos();
	parent::__construct(3);    
  }

  public function Main(){
  
    $this -> noCache();
    
	require_once("EstadoLayoutClass.php"); 
	require_once("EstadoModelClass.php");
	
    $Layout   = new EstadoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new EstadoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());

    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));

    $Layout -> setCampos($this -> Campos);
	
	$Layout -> RenderMain();    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"entrega",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

/////
  protected function asignoGuiaEstado(){
  
    require_once("EstadoModelClass.php");
	
    $Model         = new EstadoModel();  
	$entrega_id = $_REQUEST['entrega_id'];
	
	if($Model -> entregaTieneGuias($entrega_id,$this -> getConex())){		
	  exit('true');
	}else{
	     exit('false');
	  }  
  }
  

	protected function onclickUpdate(){

		require_once("EstadoModelClass.php");
		$Model = new EstadoModel();

		$Model -> Update($this -> getConex());

		if($Model -> GetNumError() > 0){
			exit("false");
		}else{
			exit("true");
		}
	}  
  


protected function setLeerCodigobar() {
	require_once("EstadoModelClass.php");
	$Model= new EstadoModel();
	
	
	$guia = $_REQUEST['guia'];
	
	$Data = $Model -> setLeerCodigobar($guia, $this -> getConex());
	$Data1 = $Model -> setLeerCodigobar1($guia, $this -> getConex());
	
	if($Data[0][estado_mensajeria_id]>0){
		$estado = $Data[0][estado_mensajeria_id];
	}else{
		$estado = $Data1[0][estado_mensajeria_id];
	}


	if($Data[0][numero_guia]>0){
		if($estado=='6' || $estado=='7'){
				$Model -> seleccionar_remesa($guia,$estado,$this -> getConex()); 
				$this -> getArrayJSON($Data);
		}elseif($estado=='8'){
			exit('No se puede cambiar el estado de esta guia,<br>ya que esta Anulada');
		}
	}elseif($Data1[0][numero_guia]>0){
		if($estado=='6' || $estado=='7'){
				$Model -> seleccionar_remesa1($guia,$estado,$this -> getConex());
				$this -> getArrayJSON($Data1);
		}elseif($estado=='8'){
			exit('No se puede cambiar el estado de esta guia,<br>ya que esta Anulada');
		}
	}else{
		exit('No ha sido creada la guia '.$guia.'');
	}
} 

  protected function setCampos(){  
	//FORMULARIO
	
    $this -> Campos[usuario_id] = array(
    name  =>'usuario_id',
    id    =>'usuario_id',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'integer')
    );		
	
    $this -> Campos[usuario_registra] = array(
    name  =>'usuario_registra',
    id    =>'usuario_registra',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text')
    );	
	
    $this -> Campos[usuario_registra_numero_identificacion] = array(
    name  =>'usuario_registra_numero_identificacion',
    id    =>'usuario_registra_numero_identificacion',
    type  =>'hidden',
	value =>'',
    datatype=>array(type=>'text')
    );		
	

    $this -> Campos[oficina_id] = array(
    name=>'oficina_id',
    id=>'oficina_id',
    type=>'hidden',
    value   => $this -> getOficinaId(),
    datatype=>array(
    type=>'integer')
    );


	
	//BOTONES

    $this -> Campos[actualizar] = array(
    name=>'actualizar',
    id=>'actualizar',
    type=>'button',
    value=>'Actualizar',
    disabled=>'disabled'
    );
	
	
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick =>'EstadoOnReset()'
	);
	
  $this -> SetVarsValidate($this -> Campos);
  }
}

$Estado = new Estado();

?>