<?php

require_once("../../../framework/clases/ControlerClass.php");
  
final class CrearCiudad extends Controler{
	
  public function __construct(){
	parent::__construct(3);	
  }
  	
  public function Main(){
  
    $this -> noCache();

	require_once("CrearCiudadLayoutClass.php");
	require_once("CrearCiudadModelClass.php");	  
	
	$Layout   = new CrearCiudadLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new CrearCiudadModel();	  

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));   
    $Layout -> setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));	
	
    $Layout -> setCampos($this -> Campos);
	
	
	//// GRID ////
	$Attributes = array(
	  id		=>'crear_ciudad',
	  title		=>'Crear Ciudad Mensajeria',
	  sortname	=>'ciudad',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'ciudad', 	index=>'ciudad',sorttype=>'text',	width=>'300',	align=>'center')
	);
	  
    $Titles = array('EMPRESA'
	);
	
	$Layout -> SetGridPeriodo($Attributes,$Titles,$Cols,$Model -> GetQueryPeriodo());	

	$Layout -> RenderMain();
	
  
  }
	  	  
  protected function onclickFind(){
	      	
	require_once("../../../framework/clases/FindRowClass.php");	    

    $Find = new FindRow($this -> getConex(),"ubicacion",$this -> Campos);
	$data = $Find -> GetData();
	 		
	$this -> getArrayJSON($data);
	  
  }
	  
  protected function onclickSave(){
    	
  	require_once("CrearCiudadModelClass.php");	    
    $Model = new CrearCiudadModel();
		
	$Model -> Save($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se ingreso Exitosamente el periodo');
	 }	
		
  }

  protected function onclickUpdate(){

  	require_once("CrearCiudadModelClass.php");	    
    $Model = new CrearCiudadModel();
			
    $Model -> Update($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se actualizo Exitosamente el periodo');
	 }		
		
  }
	  
  protected function onclickDelete(){

  	require_once("CrearCiudadModelClass.php");	    
    $Model = new CrearCiudadModel();
		
	$Model -> Delete($this -> Campos,$this -> getConex());  
	
    if($Model -> GetNumError() > 0){
      exit('Error : '.$Model -> GetError());
    }else{
	    exit('Se Borro Exitosamente el periodo');
	 }		
		
  }
  
  protected function setCampos(){
  
	
	$this -> Campos[tipo_ubicacion] = array(
		name=>'tipo_ubicacion',
    	id=>'tipo_ubicacion',
		type=>'select',
		required=>'yes',
		datatype=>array(
			type=>'integer'),
		options=>array(array(value=>'D',text=>'DEPARTAMENTO/PROVINCIA'),array(value=>'M',text=>'MUNICIPIO',	selected=>'D'))
	);
	
	
	$this -> Campos[ciudad]= array(
		type=>'text',
		required=>'yes',
		datatype=>array(
			type=>'text'),
		name=>'ciudad',
		id=>'ciudad',
		tabindex => '5',
		transaction=>array(
			table=>array('ubicacion'),
			type=>array('column'))
	);
	
	$this -> Campos[cod_ciudad]  = array(
		type=>'text',
		required=>'yes',
		datatype=>array(
			type=>'text'),
		name=>'cod_ciudad',
		id=>'cod_ciudad',
		tabindex => '6',
		transaction=>array(
		   table=>array('ubicacion'),
		   type=>array('column'))
	);			

	$this -> Campos[departamento] = array(
		name	=>'departamento',
		id	    =>'departamento',
		type	=>'text',
		suggest=>array(
			name	=>'departamento',
			setId	=>'ubicacion_hidden')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('ubicacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[nom_departamento]  = array(
		type=>'text',
		required=>'yes',
		datatype=>array(
			type=>'text'),
		name=>'nom_departamento',
		id=>'nom_departamento',
		tabindex => '6',
		transaction=>array(
		   table=>array('ubicacion'),
		   type=>array('column'))
	);			

	$this -> Campos[pais] = array(
		name	=>'pais',
		id	    =>'pais',
		type	=>'text',
		suggest=>array(
			name	=>'pais_mensajeria',
			setId	=>'ubi_ubicacion_hidden')
	);
		
	$this -> Campos[ubi_ubicacion_id] = array(
		name	=>'ubi_ubicacion_id',
		id		=>'ubi_ubicacion_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('ubicacion'),
			type	=>array('column'))
	);
	
	
	
 
 ///BOTONES
 
	$this -> Campos[guardar] = array(
		type=>'button',
		name=>'guardar',
		id=>'guardar',
		tabindex => '9',
		value=>'Guardar','property'=>array(
			name=>'save_ajax',
			onsuccess=>'CrearCiudadOnSaveOnUpdateonDelete')
	);
	 
 	$this -> Campos[actualizar] = array(
		type=>'button',
		name=>'actualizar',
		id=>'actualizar',
		tabindex => '10','property'=>array(
			name=>'update_ajax',
			onsuccess=>'CrearCiudadOnSaveOnUpdateonDelete'),
			value=>'Actualizar','disabled'=>'disabled');
	 	 
   	$this -> Campos[limpiar] = array(
		type=>'reset',
		name=>'limpiar',
		id=>'limpiar',
		tabindex => '12',
		value=>'Limpiar',
		onclick=>'CrearCiudadOnReset(this.form)');
	 
   	$this -> Campos[busqueda] = array(
		type=>'text',
		name=>'busqueda',
		id=>'busqueda',
		tabindex =>'1',
		value=>'',
		size=>'85',
		suggest=>array(
			name=>'periodo_uiaf',
			onclick=>'LlenarFormPeriodo',
			setId=>'periodo_uiaf_id'));
	 
	$this -> SetVarsValidate($this -> Campos);
	}


}

$CrearCiudad = new CrearCiudad();

?>