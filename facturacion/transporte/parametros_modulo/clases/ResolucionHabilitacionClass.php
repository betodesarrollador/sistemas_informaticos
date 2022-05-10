<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ResolucionHabilitacion extends Controler{

  public function __construct(){  
    parent::__construct(3);    
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("ResolucionHabilitacionLayoutClass.php");
    require_once("ResolucionHabilitacionModelClass.php");
	
    $Layout   = new ResolucionHabilitacionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ResolucionHabilitacionModel();
    
    $Model -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout->setGuardar($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout->setActualizar($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout->setBorrar($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout->setLimpiar($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
	$Layout -> setCodRegional($Model -> getCodRegional($this -> getConex()));
	
	//LISTA MENU

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'ResolucionHabilitacion',
	  title		=>'Resolucion de Habilitacion',
	  sortname	=>'empresa',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'empresa',		index=>'empresa',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'habilitacion',	index=>'habilitacion',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'fecha',			index=>'fecha',			sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'regional',		index=>'regional',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'codigo_empresa',	index=>'codigo_empresa',sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('EMPRESA',
					'RESOLUCION HABILITACION',
					'FECHA',
					'REGIONAL',
					'CODIGO EMPRESA'
	);
	$Layout -> SetGridResolucionHabilitacion($Attributes,$Titles,$Cols,$Model -> getQueryResolucionHabilitacionGrid());
	
	
	
	$Layout -> RenderMain();
    
  }

  protected function onclickValidateRow(){

    require_once("ResolucionHabilitacionModelClass.php");
    $Model = new ResolucionHabilitacionModel();
	  
    $data = $Model -> selectResolucionHabilitacion($this -> getConex());
	
    $this -> getArrayJSON($data);
	
  }

  protected function onclickSave(){
    require_once("ResolucionHabilitacionModelClass.php");
    $Model = new ResolucionHabilitacionModel();
    $Model -> Save($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se ingreso correctamente ');
    }	
  }

  protected function onclickUpdate(){
    require_once("ResolucionHabilitacionModelClass.php");
	$Model = new ResolucionHabilitacionModel();
    $Model -> Update($this -> Campos,$this -> getConex());
    if($Model -> GetNumError() > 0){
      exit('Ocurrio una inconsistencia');
    }else{
      exit('Se actualizo correctamente ');
	}
  }
	  
  protected function onclickDelete(){
  	require_once("ResolucionHabilitacionModelClass.php");
    $Model = new ResolucionHabilitacionModel();
	$Model -> Delete($this -> Campos,$this -> getConex());
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se elimino correctamente ');
	}
  }


//BUSQUEDA
  protected function onclickFind(){
	  
    require_once("ResolucionHabilitacionModelClass.php");
	
	$Model = new ResolucionHabilitacionModel();
	
    $data  = $Model -> selectResolucionHabilitacionModel($this -> getConex());
	
	$this -> getArrayJSON($data);
	
  }



  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[habilitacion_id] = array(
		name	=>'habilitacion_id',
		id		=>'habilitacion_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('primary_key'))
	);
	  
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options=> array(),
		//tabindex	=>'1',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[habilitacion] = array(
		name	=>'habilitacion',
		id		=>'habilitacion',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'alphanum',
			length	=>'50'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_habilitacion] = array(
		name	=>'fecha_habilitacion',
		id		=>'fecha_habilitacion',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[codigo_regional] = array(
		name	=>'codigo_regional',
		id		=>'codigo_regional',
		type	=>'select',
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[codigo_empresa] = array(
		name	=>'codigo_empresa',
		id		=>'codigo_empresa',
		type	=>'text',
		size 	=>'8',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'10'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);

	$this -> Campos[numero_resolucion] = array(
		name	=>'numero_resolucion',
		id	=>'numero_resolucion',
		type	=>'text',
    	datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);

	$this -> Campos[fecha_resolucion] = array(
		name	=>'fecha_resolucion',
		id	=>'fecha_resolucion',
		type	=>'text',
    	datatype=>array(
			type	=>'date'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);

	$this -> Campos[codigo_usuario_aduanero] = array(
		name	=>'codigo_usuario_aduanero',
		id	=>'codigo_usuario_aduanero',
		type	=>'text',
    	        datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	

	$this -> Campos[rango_manif_ini] = array(
		name	=>'rango_manif_ini',
		id		=>'rango_manif_ini',
		type	=>'text',
		value	=>'1',
		required=>'yes',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'
			),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_manif_fin] = array(
		name	=>'rango_manif_fin',
		id		=>'rango_manif_fin',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);

	$this -> Campos[asignado_rango_manif] = array(
		name	=>'asignado_rango_manif',
		id		=>'asignado_rango_manif',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		readonly=>'true',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'),
	);
	
	$this -> Campos[saldo_rango_manif] = array(
		name	=>'saldo_rango_manif',
		id		=>'saldo_rango_manif',
		type	=>'text',
		value	=>'0',
		required=>'yes',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'),
	);

	$this -> Campos[rango_despacho_urbano_ini] = array(
		name	=>'rango_despacho_urbano_ini',
		id		=>'rango_despacho_urbano_ini',
		type	=>'text',
		value	=>'1',
		size	=>'6',
    	datatype=>array(
			type	  =>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_despacho_urbano_fin] = array(
		name	=>'rango_despacho_urbano_fin',
		id		=>'rango_despacho_urbano_fin',
		type	=>'text',
		value	=>'0',
		size	=>'6',
    	datatype=>array(
			type	  =>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);

	$this -> Campos[asignado_rango_despacho_urbano] = array(
		name	=>'asignado_rango_despacho_urbano',
		id		=>'asignado_rango_despacho_urbano',
		type	=>'text',
		value	=>'0',
		readonly=>'true',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'),
	);
	
	$this -> Campos[saldo_rango_despacho_urbano] = array(
		name	=>'saldo_rango_despacho_urbano',
		id		=>'saldo_rango_despacho_urbano',
		type	=>'text',
		value	=>'0',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'),
	);


	$this -> Campos[rango_remesa_ini] = array(
		name	=>'rango_remesa_ini',
		id		=>'rango_remesa_ini',
		type	=>'text',
		value	=>'1',
		size	=>'6',
    	datatype=>array(
			type	  =>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);
	
	$this -> Campos[rango_remesa_fin] = array(
		name	=>'rango_remesa_fin',
		id		=>'rango_remesa_fin',
		type	=>'text',
		value	=>'0',
		size	=>'6',
    	datatype=>array(
			type	  =>'integer'),
		transaction=>array(
			table	=>array('resolucion_habilitacion'),
			type	=>array('column'))
	);

	$this -> Campos[asignado_rango_remesa] = array(
		name	=>'asignado_rango_remesa',
		id		=>'asignado_rango_remesa',
		type	=>'text',
		value	=>'0',
		readonly=>'true',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'),
	);
	
	$this -> Campos[saldo_rango_remesa] = array(
		name	=>'saldo_rango_remesa',
		id		=>'saldo_rango_remesa',
		type	=>'text',
		value	=>'0',
		size	=>'6',
    	datatype=>array(
			type	=>'integer'),
	);
	
	
	
	//botones
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'ResolucionHabilitacionOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ResolucionHabilitacionOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ResolucionHabilitacionOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'ResolucionHabilitacionOnReset()'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		placeholder=>'ESCRIBA EL NOMBRE DE LA EMPRESA O N&Uacute;MERO DE RESOLUCI&Oacute;N',				
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_resolucion_habilitacion',
			setId	=>'habilitacion_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$ResolucionHabilitacion = new ResolucionHabilitacion();

?>