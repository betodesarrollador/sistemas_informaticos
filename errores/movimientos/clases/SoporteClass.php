<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Soporte extends Controler{
	
  public function __construct(){
    parent::__construct(2);	
  }
  	
  public function Main(){
  
    $this -> noCache();

    require_once("SoporteLayoutClass.php");
    require_once("SoporteModelClass.php");
	
    $Layout   = new SoporteLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new SoporteModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
				
    $Layout -> setGuardar   ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar    ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar   ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);	

    //LISTA MENU

    /*$Layout -> SetTipoBarrio($Model -> GetTipoBarrio($this -> getConex()));*/


//// GRID ////
	$Attributes = array(

	  id	=>'soporte_id',		
	  title		=>'Listado de tipos de Soporte',
	  sortname	=>'nombre',
	  width		=>'1100',
	  height	=>'250'
	);

	$Cols = array(

	  array(name=>'soporte_id',	        index=>'soporte_id',			width=>'80',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',			    width=>'230',	align=>'center'),
	  array(name=>'fecha_inicial',	    index=>'fecha_inicial',			width=>'230',	align=>'center'),
	  array(name=>'fecha_final',	    index=>'fecha_final',			width=>'230',	align=>'center'),
	  array(name=>'cliente',		    index=>'cliente',			    width=>'230',	align=>'center'),
	  array(name=>'estado',				index=>'estado',			    width=>'230',	align=>'center')
	);
	  
    $Titles = array('CODIGO',
					'NOMBRE',
					'FECHA INICIO',
					'FECHA FINAL',
					'CLIENTE',
					'ESTADO'
	);
		
	$Layout -> SetGridSoporte($Attributes,$Titles,$Cols,$Model -> getQuerySoporteGrid());




	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
  
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($this -> getConex(),"Soporte",$this ->Campos);	 
	 print $Data  -> GetData();
	 
  }
  
  
  protected function onclickSave(){
    
  	require_once("SoporteModelClass.php");
    $Model = new SoporteModel();
    	
    $Model -> Save($this -> Campos,$this -> getUsuarioId(),$this -> getConex());

    if($Model -> GetNumError() > 0){
	 exit('Ocurrio una inconsistencia');
    }else{
	  exit('Se ingreso correctamente el tipo de Soporte');
	 }
	
  }

  protected function getBarrio(){

	require_once("SoporteModelClass.php");
		
    $Model           = new SoporteModel();
    $ubicacion_id = $this->requestData('ubicacion_id');
    $barrio_id = $this->requestData('barrio_id');
    $result         = $Model -> selectBarrio($ubicacion_id,$barrio_id,$this -> getConex());
		
	echo json_encode($result);

  }


  protected function onclickUpdate(){
	  
  	require_once("SoporteModelClass.php");
    $Model = new SoporteModel();
    $Soporte_id = $this->requestData('soporte_id');
	
    $Model -> Update($Soporte_id,$this -> Campos,$this -> getUsuarioId(),$this -> getConex());

	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Soporte');
	  }
	  
  }
  
  
  protected function onclickDelete(){

  	require_once("SoporteModelClass.php");
    $Model = new SoporteModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Soporte');
	  }
  }


//BUSQUEDA
  protected function onclickFind(){
  	require_once("SoporteModelClass.php");
    $Model = new SoporteModel();
    $soporte_id = $this->requestData('soporte_id');
	$Data  = $Model -> selectSoporte($soporte_id,$this -> getConex());
	$this -> getArrayJSON($Data);
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[soporte_id] = array(
		name	=>'soporte_id',
		id	    =>'soporte_id',
		type	=>'text',
		disabled=>'true',
		//required=>'no',
	 	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id	=>'nombre',
		type	=>'text',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);	

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id	=>'descripcion',
		type	=>'textarea',
		required=>'yes',
		//size    =>'20',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);	

	/*$this -> Campos[archivo] = array(
		name	=>'archivo',
		id	=>'archivo',
		type	=>'text',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);*/

	/*$this -> Campos[prioridad] = array(
		name	=>'prioridad',
		id	=>'prioridad',
		type	=>'text',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);*/	

	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id	    =>'cliente',
		type	=>'text',
		required=>'yes',
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_hidden')
		

	);
		
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_hidden',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
		
	);


	$this -> Campos[fecha_inicial] = array(
		name	=>'fecha_inicial',
		id	=>'fecha_inicial',
		type	=>'text',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);	
    
    $this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id	=>'fecha_final',
		type	=>'text',
		required=>'yes',
		size    =>'20',
		datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);	

	 $this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=>array(array(value=>'1',text=>'ACTIVO',selected=>'1'),array(value=>'0',text=>'INACTIVO')),
		required=>'yes',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);	

	/*$this -> Campos[usuario_cierre_id] = array(
		name	=>'usuario_cierre_id',
		id	    =>'usuario_cierre_id',
		type	=>'hidden',
		//disabled=>'true',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);*/

		
	/*$this -> Campos[fase_id] = array(
		name	=>'fase_id',
		id		=>'fase_id',
		type	=>'text',
		//options=>array(),
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
		
	);*/

	$this -> Campos[fecha_registro] = array(
		name	=>'fecha_registro',
		id		=>'fecha_registro',
		type	=>'hidden',
		//required=>'yes',
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);


	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id	    =>'usuario_id',
		type	=>'hidden',
		//disabled=>'true',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('soporte'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_actualiza] = array(
				name	=>'fecha_actualiza',
				id		=>'fecha_actualiza',
				type	=>'hidden',
				//required=>'yes',
				transaction=>array(
					table	=>array('soporte'),
					type	=>array('column'))
			);	

	$this -> Campos[usuario_actualizo_id] = array(
		name	=>'usuario_actualizo_id',
		id	    =>'usuario_actualizo_id',
		type	=>'hidden',
		//disabled=>'true',
		//required=>'no',
	 	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('soporte'),
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
			onsuccess=>'SoporteOnSaveOnUpdateonDelete')
		
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'SoporteOnSaveOnUpdateonDelete')
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'SoporteOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'SoporteOnReset(this.form)'
	);
	
	//busqueda
    	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		placeholder=>'ESCRIBA EL N&Uacute;MERO DE MESA O EL NOMBRE DE LA MESA',
		//tabindex=>'1',
		suggest=>array(
			name	=>'soporte',
			setId	=>'soporte_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	 
	$this -> SetVarsValidate($this -> Campos);
  }


}

$Soporte = new Soporte();

?>