<?php

require_once("../../../framework/clases/ControlerClass.php");

final class FormaPago extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("FormaPagoLayoutClass.php");
    require_once("FormaPagoModelClass.php");
	
    $Layout   = new FormaPagoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new FormaPagoModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

	//// GRID ////
	$Attributes = array(
	  id		=>'forma_pago',
	  title		=>'Listado Formas Pago',
	  sortname	=>'nombre',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'codigo',index=>'codigo',width=>'50',	align=>'center'),
	  array(name=>'nombre',index=>'nombre',width=>'200',	align=>'center'),
	  array(name=>'requiere_soporte',index=>'requiere_soporte',width=>'100',	align=>'center'),	  	  
	  array(name=>'puc',index=>'puc',width=>'200',	align=>'center'),	  	  	  
	  array(name=>'naturaleza',index=>'naturaleza',width=>'100',	align=>'center'),	  	  	  	  
	  array(name=>'banco',index=>'banco',width=>'200',	align=>'center'),	  	  	  	  
	  array(name=>'estado',index=>'estado',width=>'100',	align=>'center')	
	);
	  
    $Titles = array('CODIGO','NOMBRE','SOPORTE REQUERIDO','PUC','NATURALEZA','BANCO','ESTADO');
		
	$Layout -> SetGridFormaPago($Attributes,$Titles,$Cols,$Model -> getQueryFormaPagoGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("FormaPagoModelClass.php");
    $Model = new FormaPagoModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la forma_pago');
	 }	
  }

  protected function onclickUpdate(){
	  
  	require_once("FormaPagoModelClass.php");
    $Model = new FormaPagoModel();	
    $Model -> Update($this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el destinatario');
	  }	  
  }  
  
  protected function onclickDelete(){

  	require_once("FormaPagoModelClass.php");
    $Model = new FormaPagoModel();	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el destinatario');
	  }
  }

//BUSQUEDA
  protected function onclickFind(){
  	require_once("FormaPagoModelClass.php");
    $Model = new FormaPagoModel();
	$Data  = $Model -> selectFormaPago($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[forma_pago_id] = array(
		name	=>'forma_pago_id',
		id	    =>'forma_pago_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('forma_pago'),
			type	=>array('primary_key'))
	);
		  	
	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id		=>'codigo',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20',
			precision=>'0'),
		transaction=>array(
			table	=>array('forma_pago'),
			type	=>array('column'))
	);	  
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		required=>'yes',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('forma_pago'),
			type	=>array('column'))
	);	
	
	$this -> Campos[requiere_soporte] = array(
		name	=>'requiere_soporte',
		id	    =>'requiere_soporte',
		type	=>'select',
		options =>array(array(value=>'1',text=>'SI'),array(value=>'0',text=>'NO')),
		selected=>'0',
		required=>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('forma_pago'),
			type	=>array('column'))
	);	
		
	$this -> Campos[activo] = array(
		name	=>'estado',
		id		=>'activo',
		type	=>'radio',
	 	value	=>'A',
		checked	=>'checked',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('forma_pago'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado',
		id		=>'inactivo',
		type	=>'radio',
	 	value	=>'I',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('forma_pago'),
			type	=>array('column'))
	);
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'FormaPagoOnSaveOnUpdateonDelete')		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'FormaPagoOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'FormaPagoOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'FormaPagoOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'forma_pago',
			setId	=>'forma_pago_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$forma_pago = new FormaPago();

?>