<?php

require_once("../../../framework/clases/ControlerClass.php");

final class CuentasTras extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("CuentasTrasLayoutClass.php");
    require_once("CuentasTrasModelClass.php");

    $Layout   = new CuentasTrasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CuentasTrasModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    $Layout -> setOficina($Model -> getOficina($this -> getConex()));	
	//// GRID ////
	$Attributes = array(
	  id		=>'cuentras_traslados',
	  title		=>'Listado Cuentas Traslado',
	  sortname	=>'codigo',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'codigo',index=>'codigo',width=>'100',	align=>'center'),
	  array(name=>'descripcion',index=>'descripcion',width=>'200',	align=>'left'),
	  array(name=>'descripcion_corta',index=>'descripcion_corta',width=>'200',	align=>'left'),
	   array(name=>'oficina',index=>'oficina',width=>'150',	align=>'left'),
	  array(name=>'estado',index=>'estado',width=>'50',	align=>'center')
	
	);
	  
    $Titles = array('CODIGO',
					'DESCRIPCION',
					'DESCRIPCION CORTA',
					'OFICINA',
					'ESTADO'
	);

	$Layout -> SetGridCuentasTras($Attributes,$Titles,$Cols,$Model -> getQueryCuentasTrasGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("CuentasTrasModelClass.php");
    $Model = new CuentasTrasModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la cuenta traslado');
	 }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("CuentasTrasModelClass.php");
    $Model = new CuentasTrasModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente la cuenta traslado');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("CuentasTrasModelClass.php");
    $Model = new CuentasTrasModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente la cuenta traslado');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("CuentasTrasModelClass.php");
    $Model = new CuentasTrasModel();
	$Data  = $Model -> selectCuentasTras($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[cuenta_traslado_id] = array(
		name	=>'cuenta_traslado_id',
		id	    =>'cuenta_traslado_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('cuenta_traslado'),
			type	=>array('primary_key'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('cuenta_traslado'),
			type	=>array('column'))
	);

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_id'),
		transaction=>array(
			table	=>array('cuenta_traslado'),
			type	=>array('column'))
	);	  

	$this -> Campos[descripcion_corta] = array(
		name	=>'descripcion_corta',
		id		=>'descripcion_corta',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('cuenta_traslado'),
			type	=>array('column'))
	);	  

	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type=>'integer'),
		transaction=>array(
			table	=>array('cuenta_traslado'),
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
			table	=>array('cuenta_traslado'),
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
			table	=>array('cuenta_traslado'),
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
			onsuccess=>'CuentasTrasOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'CuentasTrasOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'CuentasTrasOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'CuentasTrasOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'cuenta_traslado',
			setId	=>'cuenta_traslado_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$CuentasTras = new CuentasTras();

?>