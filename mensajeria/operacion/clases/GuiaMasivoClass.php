<?php

require_once("../../../framework/clases/ControlerClass.php");

final class GuiaMasivo extends Controler{

  public function __construct(){
    parent::__construct(3);	  
  }

  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  

    $this -> Campos[cliente_id] = array(
	name	=>'cliente_id',
	id	=>'cliente_id',
	type	=>'select',
	required=>'yes',
	options	=>array()
    );  
   $this -> Campos[origen] = array(
		name	 =>'origen',
		id	     =>'origen',
		type	 =>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'origen_hidden')
	);
	
	$this -> Campos[origen_id] = array(
		name	=>'origen_id',
		id		=>'origen_hidden',
		type	=>'hidden',
		//required=>'yes',
		value=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);	
	
 	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		suggest=>array(
			name	=>'ubicacion',
			setId	=>'destino_hidden')
	);
	
	$this -> Campos[destino_id] = array(
		name	=>'destino_id',
		id		=>'destino_hidden',
		type	=>'hidden',
		//required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);		
   
  
    $this -> Campos[guardar] = array(
	name	=>'guardar',
	id	=>'guardar',
	type	=>'button',
	value	=>'Guardar'
    );

    $this -> Campos[buscar] = array(
	name	=>'buscar',
	id	=>'buscar',
	type	=>'button',
	value	=>'Buscar'
    );

    
    $this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache(); 
    
    require_once("GuiaMasivoLayoutClass.php");
    require_once("GuiaMasivoModelClass.php");
	
    $Layout   = new GuiaMasivoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new GuiaMasivoModel();    

    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));           
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout -> setClientes($Model -> getClientes($this -> getConex()));    	
		
    $Layout -> RenderMain();
    
  }

  
  
  protected function setDetalleGuiaMasivo(){
    
    require_once("GuiaMasivoModelClass.php");
	
    $Model         = new GuiaMasivoModel();    
    $camposArchivo = $_REQUEST['campos_archivo']; 
    $cliente_id    = $_REQUEST['cliente_id'];
    
	$return = $Model -> saveDetalleGuiaMasivo($this -> getOficinaId(),$cliente_id,$camposArchivo,$this -> getConex());
   	print $return;
  
  }
	
	
}

$GuiaMasivo = new GuiaMasivo();

?>