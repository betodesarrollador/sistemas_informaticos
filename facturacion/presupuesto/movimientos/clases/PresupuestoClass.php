<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Presupuesto extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }
  
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){  
  
	$this -> Campos[presupuesto_id] = array(
		name	=>'presupuesto_id',
		id		=>'presupuesto_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(type=>'autoincrement'),
		transaction=>array(
			table	=>array('presupuesto'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[periodo_contable_id] = array(
		name	=>'periodo_contable_id',
		id		=>'periodo_contable_id',
		type	=>'select',
		required=>'yes',
		options =>array(),
	    datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('presupuesto'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options =>array(array('value'=>'1','text'=>'Activo'),array('value'=>'0','text'=>'Inactivo')),
	    datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('presupuesto'),
			type	=>array('column'))        
	);		
	

	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'PresupuestoOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'PresupuestoOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'PresupuestoOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	    =>'limpiar',
		id	    =>'limpiar',
		type	    =>'reset',
		value	    =>'Limpiar',
		onclick     =>'PresupuestoOnReset()'
	);
	
	//BUSQUEDA
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		value	=>'',
		//tabindex=> '1',
		suggest=>array(
			name	=>'busca_presupuesto',
			setId	=>'presupuesto_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("PresupuestoLayoutClass.php");
    require_once("PresupuestoModelClass.php");
	
    $Layout   = new PresupuestoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new PresupuestoModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar	($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar	($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU    
    $Layout -> setPeriodosContables($Model -> getPeriodosContables($this -> getConex()));    	    	
	
	$Layout -> RenderMain();
    
  }  

  protected function onclickSave(){
      
    require_once("PresupuestoModelClass.php");
    $Model = new PresupuestoModel();
	
    $result = $Model -> Save($this -> Campos,$this -> getConex());
	
    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("$result");
	 }	
  }

  protected function onclickUpdate(){
    
    require_once("PresupuestoModelClass.php");
	$Model = new PresupuestoModel();
	
	$Model -> Update($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
  }
	  
  protected function onclickDelete(){
  	require_once("PresupuestoModelClass.php");
        $Model = new PresupuestoModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Presupuesto');
	}
  }
  
//BUSQUEDA
  protected function onclickFind(){

    require_once("PresupuestoModelClass.php");

    $Model          = new PresupuestoModel();
    $presupuesto_id = $_REQUEST['presupuesto_id'];
    $Data           =  $Model -> selectPresupuesto($presupuesto_id,$this -> getConex());

    $this -> getArrayJSON($Data);	

  }
	
	
}

new Presupuesto();

?>