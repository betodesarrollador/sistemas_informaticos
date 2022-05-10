<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TiposIdentificacion extends Controler{

  public function __construct(){
    parent::__construct(3);	  
  }

  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  

    $this -> Campos[cliente_id] = array(
	name	=>'cliente_id',
	id	=>'cliente_id',
	type	=>'select',
	options	=>array()
    );  
    
    $this -> Campos[guardar] = array(
	name	=>'guardar',
	id	=>'guardar',
	type	=>'button',
	value	=>'Guardar'
    );
    
    
    $this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache(); 
    
    require_once("TiposIdentificacionLayoutClass.php");
    require_once("TiposIdentificacionModelClass.php");
	
    $Layout   = new TiposIdentificacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TiposIdentificacionModel();    
        
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));           
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    	
		
    $Layout -> RenderMain();
    
  }
	
	
}

$TiposIdentificacion = new TiposIdentificacion();

?>