<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Faq extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("FaqLayoutClass.php");
	require_once("FaqModelClass.php");
	
	$Layout   = new FaqLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new FaqModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	$Layout -> setModulo   			($Model -> GetModulo($this -> getConex()));
	//$Layout -> SetTipooficina    	($Model -> GetTipooficina($this -> getConex()));
	$Layout -> setUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	$Layout -> setUsuarioMod($this -> getUsuarioId(),$this -> getOficinaId());
	$Layout -> setAsunto   			($Model -> GetAsunto($this -> getConex()));
	

	//// GRID ////
	$Attributes = array(
	  id		=>'Faq',
	  title		=>'Listado de Errores',
	  sortname	=>'fecha_ingreso_error',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
		array(name=>'errores_id',				index=>'errores_id',			sorttype=>'int',	width=>'80',	align=>'center'),
		array(name=>'asunto',					index=>'asunto',				sorttype=>'text',	width=>'80',	align=>'center'),
		array(name=>'fecha_ingreso_error',		index=>'fecha_ingreso_error',	sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'fecha_solucion',			index=>'fecha_solucion',		sorttype=>'text',	width=>'130',	align=>'center'),	
		array(name=>'cliente',					index=>'cliente',				sorttype=>'text',	width=>'210',	align=>'left'),
		array(name=>'modulos_codigo',			index=>'modulos_codigo',		sorttype=>'text',	width=>'100',	align=>'center'),
		array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'90',	align=>'center'),
		array(name=>'usuario_modifica',			index=>'usuario_modifica',		sorttype=>'text',	width=>'260',	align=>'left'),
		array(name=>'descripcion',				index=>'descripcion',			sorttype=>'text',	width=>'170',	align=>'left'),
		array(name=>'solucion',					index=>'solucion',				sorttype=>'text',	width=>'170',	align=>'left')  
		
	);
	  
    $Titles = array('NO',
					'ASUNTO',
					'FECHA',
					'FECHA SOLUCION',
					'CLIENTE',
					'MODULO',
					'ESTADO',
					'USUARIO MODIFICA',
					'DESCRIPCION',
					'SOLUCION'
	);
	
	$Layout -> SetGridFaq($Attributes,$Titles,$Cols,$Model -> GetQueryFaqGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("FaqModelClass.php");
    $Model = new FaqModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("FaqModelClass.php");
    $Model = new FaqModel();

	$Model -> Save($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Error');
	}
	
  }

  protected function onclickUpdate(){
	  
  	require_once("FaqModelClass.php");
    $Model = new FaqModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Error');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("FaqModelClass.php");
    $Model = new FaqModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la Tarifa');
	}else{
	    exit('Se borro exitosamente el Error');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("FaqModelClass.php");
    $Model = new FaqModel();
	
    $Data                  = array();
	$errores_id   = $_REQUEST['errores_id'];
	 
	if(is_numeric($errores_id)){
	  
	  $Data  = $Model -> selectDatosFaqId($errores_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Faq
	********************/
	
	$this -> Campos[errores_id] = array(
		name	=>'errores_id',
		id		=>'errores_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[asunto_id] = array(
		name	=>'asunto_id',
		id		=>'asunto_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);

	
	/*$this -> Campos[asunto_id] = array(
		name	=>'asunto_id',
		id		=>'asunto_id',
		type	=>'select',
		required=>'yes',
	 	datatype=>array(
			type	=>'text',
			length	=>'45'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);*/
	$this -> Campos[fecha_ingreso_error] = array(
		name	=>'fecha_ingreso_error',
		id		=>'fecha_ingreso_error',
		type	=>'text',
		required=>'yes',
		size	=>'7',
		disabled=>'yes',
		value=>date('Y-m-d'),
	 	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);
	$this -> Campos[fecha_solucion] = array(
		name	=>'fecha_solucion',
		id		=>'fecha_solucion',
		type	=>'text',
	 	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		disabled=>'yes',
		type	=>'select',
		options	=> array(array(value=>'E',text=>'ESPERA',selected=>'E'),array(value=>'F',text=>'FINALIZADO')),
		required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'2'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);

		$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		datatype=>array(
		type	=>'integer',
		length	=>'11'),
		transaction=>array(
		table	=>array('errores'),
		type	=>array('column'))
	);
	
	$this -> Campos[cliente] = array(
		name =>'cliente',
		id =>'cliente',
		type =>'text',
		size    =>'68',
		suggest => array(
		name =>'cliente',
		setId =>'cliente_id')
	  );
	
	
	$this -> Campos[usuario_modifica] = array(
		name	=>'usuario_modifica',
		id		=>'usuario_modifica',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);

	/*$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
		type	=>'integer',
		length	=>'10'),
		transaction=>array(
		table	=>array('errores'),
		type	=>array('column'))
	  );*/

	$this -> Campos[usuario_id] = array(
		name	=>'usuario_id',
		id		=>'usuario_id',
		type	=>'hidden',
	 	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);

	$this -> Campos[modulos_codigo] = array(
		name	=>'modulos_codigo',
		id		=>'modulos_codigo',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);

	/*$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('Faq_factura'),
			type	=>array('column'))
	);*/

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'textarea',
		required=>'yes',
		cols	=>'70',
		rows	=>'2',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);
	$this -> Campos[solucion] = array(
		name	=>'solucion',
		id		=>'solucion',
		type	=>'textarea',
		cols	=>'70',
		rows	=>'2',
	 	datatype=>array(
			type	=>'text',
			length	=>'250'),
		transaction=>array(
			table	=>array('errores'),
			type	=>array('column'))
	);
	 
	 	  
	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		//tabindex=>'20'
	);
	 
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
  		disabled=>'disabled',
		//tabindex=>'21',
		property=>array(
			name	=>'delete_ajax',
			onsuccess=>'FaqOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'FaqOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'Faq',
			setId	=>'errores_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$errores_id = new Faq();

?>