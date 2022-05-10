<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class Chequeras extends Controler{
	
  public function __construct(){  
	//// -> setCampos();  	
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("ChequerasModelClass.php");
	require_once("ChequerasLayoutClass.php");
//		echo 'FUNCIONA...';
		
	$Layout   = new ChequerasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ChequerasModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));     
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);

	//// GRID ////
	$Attributes = array(
	  id		=>'chequeras',
	  title		=>'Chequeras',
	  sortname	=>'banco',
	  width		=>'800',
	  height	=>'250'
	);

	$Cols = array(	
	  array(name=>'banco', 			index=>'banco',		  	sorttype=>'text',	width=>'160',	align=>'rigth'),
	  array(name=>'tipo_cuenta',	index=>'tipo_cuenta', 	sorttype=>'int',	width=>'100',	align=>'center'),	  
	  array(name=>'referencia',		index=>'referencia',  	sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'codigo_cuenta',	index=>'codigo_cuenta', sorttype=>'int',	width=>'90',	align=>'center'),	  
	  array(name=>'rango_ini',  	index=>'rango_ini',	  	sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'rango_fin', 		index=>'rango_fin',	  	sorttype=>'int',	width=>'100',	align=>'center'),	  
	  array(name=>'estado',	 		index=>'estado', 	  	sorttype=>'text',	width=>'80',	align=>'center')	
	);
	  
    $Titles = array('BANCO','TIPO CUENTA','REFERENCIA','CUENTA PUC','RANGO INICIAL','RANGO FINAL','ESTADO');	
	$Layout -> SetGridChequeras($Attributes,$Titles,$Cols,$Model -> GetQueryChequerasGrid());	
	$Layout -> RenderMain();  
  }
	  	  
  protected function onclickFind(){   // REVISAR
	      	
	require_once("../../../framework/clases/FindRowClass.php");	 
    $Find = new FindRow($this -> getConex(),"chequeras",$this -> Campos);
	$data = $Find -> GetData();	 		
	$this -> getArrayJSON($data);	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("ChequerasModelClass.php");	    
    $Model = new ChequerasModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el Chequeras Reembolso');
	 }			
  }

  protected function onclickUpdate(){

  	require_once("ChequerasModelClass.php");	    
    $Model = new ChequerasModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el Chequeras Reembolso');
	 }			
  }
	  
  protected function onclickDelete(){

  	require_once("ChequerasModelClass.php");	    
    $Model = new ChequerasModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el Chequeras Reembolso');
	 }			
  }  
  
  protected function setCampos(){

// CAMPOS

	$this -> Campos[chequeras_id]  = array(
    type=>'hidden',
	name=>'chequeras_id',
	id=>'chequeras_id',
    datatype=>array(
		type=>'autoincrement'),
	transaction=>array(
		table=>array('chequeras'),
		type=>array('primary_key')));
	  
	$this -> Campos[banco] = array(
		name	=>'banco',
		id		=>'banco',
		type	=>'text',
		//tabindex=>'7',
		suggest=>array(
			name	=>'banco',
			setId	=>'banco_hidden')
	);
		
	$this -> Campos[banco_id] = array(
		name	=>'banco_id',
		id		=>'banco_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('chequeras'),
			type	=>array('column'))
	);
	
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_hidden',
			form    =>'0')
	);		
	  
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('chequeras'),
			type	=>array('column'))
	);	

	$this -> Campos[rango_ini]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'text'),
	name=>'rango_ini',
    id=>'rango_ini',
	//tabindex => '4',
	transaction=>array(
		table=>array('chequeras'),
		type=>array('column')));
	
	$this -> Campos[rango_fin]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'text'),
	name=>'rango_fin',
    id=>'rango_fin',
	//tabindex => '4',
	transaction=>array(
		table=>array('chequeras'),
		type=>array('column')));	

	$this -> Campos[referencia]  = array(
	type=>'text',
	required=>'yes',
	datatype=>array(
		type=>'alphanum'),
	name=>'referencia',
    id=>'referencia',
	//tabindex => '7',
	transaction=>array(
		table=>array('chequeras'),
		type=>array('column')));	
	
	$this -> Campos[tipo_cuenta]  = array(
	type=>'select',
	required=>'yes',
	datatype=>array(
		type=>'text'),
	name=>'tipo_cuenta',
    id=>'tipo_cuenta',
	//tabindex => '8',
	transaction=>array(
		table=>array('chequeras'),
		type=>array('column')),
	options=>array(array(
		value=>'AH',text=>'AHORROS',selected=>'AH'),array(value=>'CO',text=>'CORRIENTE',selected=>'AH')));	
	
	$this -> Campos[estado]  = array(
	type=>'select',
	required=>'yes',
	datatype=>array(
		type=>'integer'),
	name=>'estado',
    id=>'estado',
	//tabindex => '8',
	transaction=>array(
		table=>array('chequeras'),
		type=>array('column')),
	options=>array(array(
		value=>'1',text=>'ACTIVO'),array(value=>'0',text=>'INACTIVO',selected=>'1')));	
	
// BOTONES

	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'ChequerasOnSaveOnUpdateonDelete')		
	);	
	
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ChequerasOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ChequerasOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ChequerasOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'chequeras',
			setId	=>'chequeras_id',
			onclick	=>'setDataFormWithResponse')
	);	
	 
	$this -> SetVarsValidate($this -> Campos);
	}
}

$Chequeras = new Chequeras();

?>