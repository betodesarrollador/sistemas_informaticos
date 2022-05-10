<?php
require_once("../../../framework/clases/ControlerClass.php");
  
final class TipoDinero extends Controler{
	
  public function __construct(){  
	//// -> setCampos();  	
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("TipoDineroModelClass.php");
	require_once("TipoDineroLayoutClass.php");
		
	$Layout   = new TipoDineroLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TipoDineroModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);

	//// GRID ////
	$Attributes = array(
	  id		=>'tipodinero',
	  title		=>'Tipo Dinero',
	  sortname	=>'tipo',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(	
	  array(name=>'tipo', 			index=>'tipo',		  	 sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'nombre_dinero',	index=>'nombre_dinero',  sorttype=>'text',	width=>'180',	align=>'left'),	  
	  array(name=>'valor_dinero',	index=>'valor_dinero',   sorttype=>'int',	width=>'80',	align=>'center'),
	  array(name=>'estado_dinero',	index=>'estado_dinero',  sorttype=>'text',	width=>'80',	align=>'center'),	  
	);
	  
    $Titles = array('TIPO','NOMBRE','VALOR','ESTADO');	
	$Layout -> SetGridTipoDinero($Attributes,$Titles,$Cols,$Model -> GetQueryTipoDineroGrid());	
	$Layout -> RenderMain();  
  }
	  	  
  protected function onclickFind(){   // REVISAR
	      	
	require_once("../../../framework/clases/FindRowClass.php");	 
    $Find = new FindRow($this -> getConex(),"tipo_dinero",$this -> Campos);
	$data = $Find -> GetData();	 		
	$this -> getArrayJSON($data);	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("TipoDineroModelClass.php");	    
    $Model = new TipoDineroModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el Tipo Dinero');
	 }			
  }

  protected function onclickUpdate(){

  	require_once("TipoDineroModelClass.php");	    
    $Model = new TipoDineroModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el Tipo Dinero');
	 }			
  }
	  
  protected function onclickDelete(){

  	require_once("TipoDineroModelClass.php");	    
    $Model = new TipoDineroModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el Tipo Dinero');
	 }			
  }  
  
  protected function setCampos(){

// CAMPOS

	$this -> Campos[tipo_dinero_id]  = array(
    type=>'hidden',
	name=>'tipo_dinero_id',
	id=>'tipo_dinero_id',
    datatype=>array(
		type=>'autoincrement'),
	transaction=>array(
		table=>array('tipo_dinero'),
		type=>array('primary_key'))
	);
	
	$this -> Campos[tipo]  = array(
	type=>'select',
	required=>'yes',
	datatype=>array(
		type=>'text'),
	name=>'tipo',
    id=>'tipo',
	transaction=>array(
		table=>array('tipo_dinero'),
		type=>array('column')),
	options=>array(array(
		value=>'M',text=>'MONEDA'),array(value=>'B',text=>'BILLETE'))
	);		

	$this -> Campos[nombre_dinero]  = array(
	type=>'text',
	name=>'nombre_dinero',
    id=>'nombre_dinero',	
	required=>'yes',
	datatype=>array(
		type=>'text'),
	transaction=>array(
		table=>array('tipo_dinero'),
		type=>array('column'))
	);	
	
	$this -> Campos[valor_dinero]  = array(
	type=>'text',
	name=>'valor_dinero',
    id=>'valor_dinero',
	required=>'yes',
	datatype=>array(
		type=>'integer'),
	transaction=>array(
		table=>array('tipo_dinero'),
		type=>array('column')));
	
	$this -> Campos[estado_dinero]  = array(
	type=>'select',
	required=>'yes',
	datatype=>array(
		type=>'text'),
	name=>'estado_dinero',
    id=>'estado_dinero',
	transaction=>array(
		table=>array('tipo_dinero'),
		type=>array('column')),
	options=>array(array(
		value=>'A',text=>'ACTIVO'),array(value=>'0',text=>'INACTIVO',selected=>'I')));	
	
// BOTONES

	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'TipoDineroOnSaveOnUpdateonDelete')		
	);	
	
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'TipoDineroOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TipoDineroOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TipoDineroOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'tipo_dinero',
			setId	=>'tipo_dinero_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$TipoDinero = new TipoDinero();

?>