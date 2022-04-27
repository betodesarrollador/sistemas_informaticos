<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Aseguradoras extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("AseguradorasLayoutClass.php");
    require_once("AseguradorasModelClass.php");
	
    $Layout   = new AseguradorasLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new AseguradorasModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

	//// GRID ////
	$Attributes = array(
	  id		=>'aseguradora',
	  title		=>'Listado Destinatarios',
	  sortname	=>'nombre_aseguradora',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'nit_aseguradora',	index=>'nit_aseguradora',	  sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'digito_verificacion',index=>'digito_verificacion', sorttype=>'int',	width=>'22',	align=>'center'),
	  array(name=>'nombre_aseguradora',	index=>'nombre_aseguradora',  sorttype=>'text',	width=>'400',	align=>'left'),
	  array(name=>'estado',	            index=>'estado',			  sorttype=>'text',	width=>'50',	align=>'center')
	
	);
	  
    $Titles = array('NIT',
					'DV',
					'NOMBRE',
					'ESTADO'
	);
	
	$Layout -> SetGridAseguradoras($Attributes,$Titles,$Cols,$Model -> getQueryAseguradorasGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("AseguradorasModelClass.php");
    $Model = new AseguradorasModel();
    	
    $Model -> Save($this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente la aseguradora');
	 }
	
  }


  protected function onclickUpdate(){
	  
  	require_once("AseguradorasModelClass.php");
    $Model = new AseguradorasModel();
	
    $Model -> Update($this -> Campos,$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el destinatario');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("AseguradorasModelClass.php");
    $Model = new AseguradorasModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el destinatario');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("AseguradorasModelClass.php");
    $Model = new AseguradorasModel();
	$Data  = $Model -> selectAseguradoras($this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[aseguradora_id] = array(
		name	=>'aseguradora_id',
		id	    =>'aseguradora_id',
		type	=>'hidden',
		required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('aseguradora'),
			type	=>array('primary_key'))
	);
		  	
	$this -> Campos[nit_aseguradora] = array(
		name	=>'nit_aseguradora',
		id		=>'nit_aseguradora',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20',
			precision=>'0'),
		transaction=>array(
			table	=>array('aseguradora'),
			type	=>array('column'))
	);
	 
	$this -> Campos[digito_verificacion] = array(
		name	=>'digito_verificacion',
		id		=>'digito_verificacion',
		type	=>'text',
		size	=>'1',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('aseguradora'),
			type	=>array('column'))
	);
	 
	
	$this -> Campos[nombre_aseguradora] = array(
		name	=>'nombre_aseguradora',
		id	=>'nombre_aseguradora',
		type	=>'text',
		required=>'yes',
		size    =>'35',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('aseguradora'),
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
			table	=>array('aseguradora'),
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
			table	=>array('aseguradora'),
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
			onsuccess=>'AseguradorasOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'AseguradorasOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'AseguradorasOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'AseguradorasOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'aseguradora',
			setId	=>'aseguradora_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$aseguradora = new Aseguradoras();

?>