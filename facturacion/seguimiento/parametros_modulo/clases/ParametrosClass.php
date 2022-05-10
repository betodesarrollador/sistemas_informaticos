<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Parametros extends Controler{

  public function __construct(){
  
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("ParametrosLayoutClass.php");
	require_once("ParametrosModelClass.php");
	
	$Layout   = new ParametrosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParametrosModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetMinuto($Model -> GetMinuto   ($this -> getConex()));
   	$Layout -> SetHoras	($Model -> GetHoras	   ($this -> getConex()));
	$Layout -> SetDias	($Model -> GetDias	   ($this -> getConex()));
   	$Layout -> SetEstado($Model -> GetEstado   ($this -> getConex()));

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'Parametros',
	  title		=>'Parametros Para Reporte',
	  sortname	=>'cliente',
	  width		=>'auto',
	  height	=>250
	);
	$Cols = array(
	  array(name=>'cliente',		index=>'cliente',		sorttype=>'text',	width=>'280',	align=>'left'),
	  array(name=>'minuto',			index=>'minuto',		sorttype=>'text',	width=>'140',	align=>'center'),
	  array(name=>'horas',			index=>'horas',			sorttype=>'text',	width=>'140',	align=>'center'),
  	  array(name=>'dias',			index=>'dias',			sorttype=>'text',	width=>'140',	align=>'center'),
	  array(name=>'tiempo_rojo',	index=>'tiempo_rojo',	sorttype=>'text',	width=>'110',	align=>'center'),	  
	  array(name=>'tiempo_amarillo',index=>'tiempo_amarillo',sorttype=>'text',	width=>'130',	align=>'center'),	  
	  array(name=>'tiempo_verde',	index=>'tiempo_verde',	sorttype=>'text',	width=>'110',	align=>'center'),	   
	  array(name=>'estado',			index=>'estado',		sorttype=>'text',	width=>'80',	align=>'center')
	);
    $Titles = array('CLIENTE',
					'MINUTO',
					'HORAS',
					'DIAS',
					'TIEMPO ROJO (m)',
					'TIEMPO AMARILLO (m)',
					'TIEMPO VERDE (m)',
					'ESTADO'
	);
	
	$Layout -> SetGridParametros($Attributes,$Titles,$Cols,$Model -> getQueryParametrosGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"parametros_reporte_trafico",$this ->Campos);
    $this -> getArrayJSON($Data  -> GetData());
  }

  protected function onclickSave(){
    require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
    $return =$Model -> Save($this -> Campos,$this -> getConex());

	if(strlen(trim($Model -> GetError())) > 0){
  		exit("Error : ".$Model -> GetError());
	}else{
        if(is_numeric($return)){
		  exit("$return");
		}else{
		    exit('false');
		  }
	}	
  }

  protected function onclickUpdate(){
    require_once("ParametrosModelClass.php");
	$Model = new ParametrosModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente el Parametro');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente el Parametro');
	}
  }

  protected function setDataCliente(){

    require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();    
    $cliente_id = $_REQUEST['cliente_id'];
    $data = $Model -> getDataCliente($cliente_id,$this -> getConex());
    $this -> getArrayJSON($data);

  }

//BUSQUEDA
  protected function onclickFind(){

  	require_once("ParametrosModelClass.php");
    $Model = new ParametrosModel();
    $parametros_reporte_trafico_id = $_REQUEST['parametros_reporte_trafico_id'];
    $Data =  $Model -> selectParametros($parametros_reporte_trafico_id,$this -> getConex());
    $this -> getArrayJSON($Data);

  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[parametros_reporte_trafico_id] = array(
		name	=>'parametros_reporte_trafico_id',
		id		=>'parametros_reporte_trafico_id',
		type	=>'hidden',
		required=>'no',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('parametros_reporte_trafico'),
			type	=>array('primary_key'))
	);
	

    $this -> Campos[cliente] = array(
    name=>'cliente',
    id=>'cliente',
    type=>'text',
	size=>82,
    suggest=>array(
		name=>'cliente',
		setId=>'cliente_id',
		onclick => 'setDataCliente'),
    datatype=>array(
	    type=>'text',
		length=>250)
	
    ); 

    $this -> Campos[cliente_id] = array(
    name=>'cliente_id',
    id=>'cliente_id',
    type=>'hidden',
	required=>'yes',
    datatype=>array(
	    type=>'integer',
		length=>250),
    transaction=>array(
		table=>array('parametros_reporte_trafico'),
		type=>array('column'))
	
    ); 

	$this -> Campos[minuto] = array(
		name	=>'minuto',
		id		=>'minuto',
		type	=>'select',
		options	=>null,
    	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_reporte_trafico'),
			type	=>array('column'))
	);

	$this -> Campos[horas] = array(
		name	=>'horas',
		id		=>'horas',
		type	=>'select',
		options	=>null,
    	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_reporte_trafico'),
			type	=>array('column'))
	);
	$this -> Campos[dias] = array(
		name	=>'dias',
		id		=>'dias',
		type	=>'select',
		options	=>null,
    	datatype=>array(
			type	=>'alphanum',
			length	=>'2'),
		transaction=>array(
			table	=>array('parametros_reporte_trafico'),
			type	=>array('column'))
	);


    $this -> Campos[tiempo_verde] = array(
    name=>'tiempo_verde',
    id=>'tiempo_verde',
    type=>'text',
	required=>'yes',
    datatype=>array(
	    type=>'integer',
		length=>3),
    transaction=>array(
		table=>array('parametros_reporte_trafico'),
		type=>array('column'))
	
    ); 

    $this -> Campos[tiempo_amarillo] = array(
    name=>'tiempo_amarillo',
    id=>'tiempo_amarillo',
    type=>'text',
	required=>'yes',
    datatype=>array(
	    type=>'integer',
		length=>3),
    transaction=>array(
		table=>array('parametros_reporte_trafico'),
		type=>array('column'))
	
    ); 

    $this -> Campos[tiempo_rojo] = array(
    name=>'tiempo_rojo',
    id=>'tiempo_rojo',
    type=>'text',
	required=>'yes',
    datatype=>array(
	    type=>'integer',
		length=>3),
    transaction=>array(
		table=>array('parametros_reporte_trafico'),
		type=>array('column'))
	
    ); 


	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options	=>null,
		selected=>'1',
		required=>'yes',
    	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametros_reporte_trafico'),
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
			onsuccess=>'ParametrosOnSave')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ParametrosOnUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		'disabled'=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ParametrosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		type	=>'reset',
		name	=>'limpiar',
		id		=>'limpiar',
		value	=>'Limpiar',
		onclick	=>'ParametrosOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		tabindex=>'1',
		suggest=>array(
			name	=>'busqueda_reporte_seguimiento',
			setId	=>'parametros_reporte_trafico_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$Parametros = new Parametros();

?>