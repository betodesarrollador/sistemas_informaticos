<?php

require_once("../../../framework/clases/ControlerClass.php");

final class AprobarNocturno extends Controler{

  public function __construct(){
    
	$this -> setCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
    
	require_once("AprobarNocturnoLayoutClass.php");
	require_once("AprobarNocturnoModelClass.php");

	
	
	$Layout = new AprobarNocturnoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new AprobarNocturnoModel();
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetNocturno($Model -> GetNocturno($this -> getConex()));
	$Layout -> SetEstadoSeg($Model -> GetEstadoSeg($this -> getConex()));
	$Layout -> SetAprobar($Model -> GetAprobar($this -> getConex()));
	
	$Layout -> RenderMain();
    
  }
  
  

  protected function onclickValidateRow(){
    require_once("../../../framework/clases/ValidateRowClass.php");
    $Data = new ValidateRow($this -> getConex(),"trafico",$this ->Campos);
    $this -> getArrayJSON($Data -> GetData());
  }


  protected function onclickUpdate(){


    require_once("AprobarNocturnoModelClass.php");
	
	$Model = new AprobarNocturnoModel();
	
	$result = $Model -> Update($this -> getUsuarioId(),$this -> Campos,$this -> getConex());

    if($Model -> GetNumError() > 0){
      exit("false");
    }else{
       exit("true");
	  }
	
  }
	  


  protected function setDataMap(){
  
    require_once("AprobarNocturnoModelClass.php");
    
	$Model = new AprobarNocturnoModel();
    $map   = $Model -> getDataMap($this -> getConex());
	
	$this -> getArrayJSON($map);
  
  }

  protected function setEstado(){
  
    require_once("AprobarNocturnoModelClass.php");
    
	$Model = new AprobarNocturnoModel();
    $estado   = $Model -> getEstado($this -> getConex());
	exit("$estado");
  
  }

  


//BUSQUEDA
  protected function onclickFind(){
  
  	require_once("AprobarNocturnoModelClass.php");
    $Model = new AprobarNocturnoModel();
	
	$trafico_nocturno_id = $_REQUEST['trafico_nocturno_id'];
	
    $Data = $Model -> selectAprobarNocturno($trafico_nocturno_id,$this -> getConex());
	
    $this -> getArrayJSON($Data);
	
  }
  

  protected function setCampos(){
	  
	$this -> Campos[trafico_id] = array(
		name	=>'trafico_id',
		id		=>'trafico_id',
		type	=>'hidden',
		value => $this -> requestData('trafico_id'),
		required=>'no',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('primary_key'))
	);	  

	$this -> Campos[trafico_nocturno_id] = array(
		name	=>'trafico_nocturno_id',
		id		=>'trafico_nocturno_id',
		type	=>'hidden',
		value => $this -> requestData('trafico_nocturno_id'),
		required=>'no',
		datatype=>array(
			type	=>'integer')
	);	  


	$this -> Campos[numero] = array(
		name	=>'numero',
		id		=>'numero',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'200')
	);

	$this -> Campos[fecha] = array(
		name	=>'fecha',
		id		=>'fecha',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'10')
	);

	$this -> Campos[agencia] = array(
		name	=>'agencia',
		id		=>'agencia',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'100')
	);

	$this -> Campos[placa] = array(
		name	=>'placa',
		id		=>'placa',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'alphanum',
			length	=>'10')
	);


	$this -> Campos[marca] = array(
		name	=>'marca',
		id		=>'marca',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);
	$this -> Campos[color] = array(
		name	=>'color',
		id		=>'color',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'200')
	);

	$this -> Campos[link_gps] = array(
		name	=>'link_gps',
		id		=>'link_gps',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[usuario_gps] = array(
		name	=>'usuario_gps',
		id		=>'usuario_gps',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[clave_gps] = array(
		name	=>'clave_gps',
		id		=>'clave_gps',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);


	$this -> Campos[conduct] = array(
		name	=>'conduct',
		id		=>'conduct',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250')
	);

	$this -> Campos[celular] = array(
		name	=>'celular',
		id		=>'celular',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);

	$this -> Campos[categoria] = array(
		name	=>'categoria',
		id		=>'categoria',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'20')
	);

	$this -> Campos[escolta_recibe] = array(
		name	=>'escolta_recibe',
		id		=>'escolta_recibe',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
		
	);
	$this -> Campos[escolta_entrega] = array(
		name	=>'escolta_entrega',
		id		=>'escolta_entrega',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
		
	);


	$this -> Campos[t_nocturno] = array(
		name	=>'t_nocturno',
		id		=>'t_nocturno',
		options	=>null,
		type	=>'select',
		disabled=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('trafico'),
			type	=>array('column'))
		
	);

	$this -> Campos[origen] = array(
		name	=>'origen',
		id		=>'origen',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		
	);

	$this -> Campos[destino] = array(
		name	=>'destino',
		id		=>'destino',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		
	);

	$this -> Campos[ruta] = array(
		name	=>'ruta',
		id		=>'ruta',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'250'),
		
	);


	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		options	=>null,
		type	=>'select',
		disabled=>'yes',
		datatype=>array(
			type	=>'alphanum',
			length	=>'1')
		
	);

	$this -> Campos[fecha_inicial_salida] = array(
		name	=>'fecha_inicial_salida',
		id		=>'fecha_inicial_salida',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type=>'text',
			length=>'10')
	);
	$this -> Campos[hora_inicial_salida] = array(
		name	=>'hora_inicial_salida',
		id		=>'hora_inicial_salida',
		type	=>'text',
		readonly=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'12')
		
	);


	$this -> Campos[autoriza_nocturno] = array(
		name	=>'autoriza_nocturno',
		id		=>'autoriza_nocturno',
		options	=>null,
		type	=>'select',
		required=>'yes',
		datatype=>array(
			type	=>'alphanum',
			length	=>'1')
		
	);


	//botones

 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		'disabled'=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'AprobarNocturnoOnUpdate')
	);
	
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		'disabled'=>'disabled',
		onclick => 'AprobarNocturnoOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
//		tabindex=>'1',
		suggest=>array(
			name	=>'aprobar_nocturno',
			setId	=>'trafico_nocturno_id',
			onclick	=>'setDataFormWithResponse')
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$AprobarNocturno = new AprobarNocturno();

?>