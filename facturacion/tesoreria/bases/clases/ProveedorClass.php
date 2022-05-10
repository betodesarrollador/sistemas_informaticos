<?php
require_once("../../../framework/clases/ControlerClass.php");

final class Proveedor extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){
  

    $this -> noCache();
	  
	require_once("ProveedorLayoutClass.php");
	require_once("ProveedorModelClass.php");
	
	$Layout   = new ProveedorLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ProveedorModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> SetTiposId     ($Model -> GetTipoId($this -> getConex()));
   	$Layout -> SetTiposPersona($Model -> GetTipoPersona($this -> getConex()));
	$Layout -> SetTiposRegimen($Model -> GetTipoRegimen($this -> getConex()));	
	$Layout -> SetTiposCuenta ($Model -> GetTipoCuenta($this -> getConex()));		

	//// GRID ////
	$Attributes = array(
	  id		=>'terceros',
	  title		=>'Listado de Proveedores',
	  sortname	=>'numero_identificacion',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'100',	align=>'center'),
	  array(name=>'digito_verificacion',	index=>'digito_verificacion',	sorttype=>'int',	width=>'22',	align=>'center'),
	  array(name=>'tipo_persona_id',		index=>'tipo_persona_id',		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'primer_apellido',		index=>'primer_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'segundo_apellido',		index=>'segundo_apellido',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'primer_nombre',			index=>'primer_nombre',			sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'segundo_nombre',			index=>'segundo_nombre',		sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'razon_social',			index=>'razon_social',			sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'sigla',					index=>'sigla',					sorttype=>'text',	width=>'100',	align=>'center'),
  	  array(name=>'ubicacion',				index=>'ubicacion',				sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'direccion',				index=>'direccion',				sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'telefono',				index=>'telefono',				sorttype=>'text',	width=>'100',	align=>'center'),
  	  array(name=>'movil',					index=>'movil',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'telefax',				index=>'telefax',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'apartado',				index=>'apartado',				sorttype=>'text',	width=>'50',	align=>'center'),
  	  array(name=>'email',					index=>'email',					sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'numcuenta_proveedor',	index=>'numcuenta_proveedor',	sorttype=>'text',	width=>'150',	align=>'center'),
  	  array(name=>'tip_cuenta',				index=>'tip_cuenta',			sorttype=>'text',	width=>'150',	align=>'center'),	  
	  array(name=>'banco',					index=>'banco',					sorttype=>'text',	width=>'150',	align=>'center'),	  
  	  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'30',	align=>'center')
	);
	  
    $Titles = array('TIPO ID', 'IDENTIFICACION', 'DV', 'TIPO CONTRIBUYENTE', 'PRIMER APELLIDO', 'SEGUNDO APELLIDO', 'PRIMER NOMBRE',
					'OTROS NOMBRES', 'RAZON SOCIAL', 'SIGLA', 'CIUDAD RESIDENCIA', 'DIRECCION', 'TELEFONO', 'MOVIL', 'TELEFAX', 'APARTADO',
					'EMAIL', 'NUMERO CUENTA', 'TIPO CUENTA', 'BANCO', 'ESTADO');
	
	$Layout -> SetGridProveedores($Attributes,$Titles,$Cols,$Model -> GetQueryProveedoresGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ProveedorModelClass.php");
    $Model = new ProveedorModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }  

  protected function onclickSave(){

  	require_once("ProveedorModelClass.php");
    $Model = new ProveedorModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Proveedor');
	  }	
  }

  protected function onclickUpdate(){
 
  	require_once("ProveedorModelClass.php");
    $Model = new ProveedorModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Proveedor');
	  }	
  }

  protected function onclickDelete(){

  	require_once("ProveedorModelClass.php");
    $Model = new ProveedorModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar la empresa');
	}else{
	    exit('Se borro exitosamente la empresa');
	  }	
  }

//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ProveedorModelClass.php");
    $Model = new ProveedorModel();
	
    $Data                  = array();
	$tercero_id            = $_REQUEST['tercero_id'];
  	$numero_identificacion = $_REQUEST['numero_identificacion'];
	 
	if(is_numeric($tercero_id)){
	  
	  $Data  = $Model -> selectDatosProveedorTerceroId($tercero_id,$this -> getConex());
	}else if(is_numeric($numero_identificacion)){
		  
     	$Data  = $Model -> selectDatosProveedorNumeroId($numero_identificacion,$this -> getConex());
	  }
	  
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Terceros
	********************/
	
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tercero','proveedor'),
			type	=>array('primary_key','column'))
	);
	
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		options	=>array(),
		required=>'yes',
		//tabindex=>'1',
	 	datatype=>array(
			type	=>'alphanum'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	  
	$this -> Campos[tipo_persona_id] = array(
		name	=>'tipo_persona_id',
		id		=>'tipo_persona_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id		=>'numero_identificacion',
		type	=>'text',
		required=>'yes',
		size	=>'12',
		//tabindex=>'3',
		datatype=>array(
			type	=>'integer',
			length	=>'20',
			precision=>'0'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[digito_verificacion] = array(
		name	=>'digito_verificacion',
		id		=>'digito_verificacion',
		type	=>'text',
		size	=>'1',
		//tabindex=>'4',
		datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[primer_apellido] = array(
		name	=>'primer_apellido',
		id		=>'primer_apellido',
		type	=>'text',
		//tabindex=>'5',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
    $this -> Campos[segundo_apellido] = array(
		name	=>'segundo_apellido',
		id		=>'segundo_apellido',
		type	=>'text',
		//tabindex=>'6',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[primer_nombre] = array(
		name	=>'primer_nombre',
		id		=>'primer_nombre',
		type	=>'text',
		//tabindex=>'7',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[segundo_nombre] = array(
		name	=>'segundo_nombre',
		id		=>'segundo_nombre',
		type	=>'text',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'10'),
	 	transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[razon_social] = array(
	 	name	=>'razon_social',
		id		=>'razon_social',
		type	=>'text',
		//tabindex=>'9',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	 
	$this -> Campos[sigla] = array(
		name	=>'sigla',
		id		=>'sigla',
		type	=>'text',
	 	//tabindex=>'10',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id		=>'ubicacion',
		type	=>'text',
		//tabindex=>'7',
		suggest=>array(
			name	=>'ciudad',
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
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[direccion] = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
		required=>'yes',
	 	//tabindex=>'11',
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[telefono] = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
	 	//tabindex=>'12',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[movil] = array(
		name	=>'movil',
		id		=>'movil',
		type	=>'text',
	 	//tabindex=>'13',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[telefax] = array(
		name	=>'telefax',
		id		=>'telefax',
		type	=>'text',
	 	//tabindex=>'12',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[apartado] = array(
		name	=>'apartado',
		id		=>'apartado',
		type	=>'text',
	 	//tabindex=>'12',
		datatype=>array(
			type	=>'alphanum',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[email] = array(
		name	=>'email',
		id		=>'email',
		type	=>'text',
		//tabindex=>'12',
		datatype=>array(
			type	=>'email',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);	
	$this -> Campos[regimen_id] = array(
		name	=>'regimen_id',
		id		=>'regimen_id',
		type	=>'select',
		options	=>null,
		required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	 
	 /*********************************
	          Campos Proveedores
	 *********************************/

 	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction	=>array(
			table	=>array('proveedor'),
			type	=>array('primary_key'))
	);
	 
	$this -> Campos[url_proveedor] = array(
		name	=>'url_proveedor',
		id		=>'url_proveedor',
		type	=>'text',
		//tabindex=>'18',
		datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);
	$this -> Campos[contac_proveedor] = array(
		name	=>'contac_proveedor',
		id		=>'contac_proveedor',
		type	=>'text',
		//tabindex=>'18',
		datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);


	$this -> Campos[tipo_cta_id] = array(
		name	=>'tipo_cta_id',
		id		=>'tipo_cta_id',
		type	=>'select',
		options	=>null,
		//required=>'yes',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);
	 
	$this -> Campos[autoret_proveedor_si] = array(
		name	=>'autoret_proveedor',
		id		=>'auto_si',
		type	=>'radio',
	 	value	=>'S',
		checked	=>'',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor','tercero'),
			type	=>array('column')),
		onclick=>'auto();'		
	);

	$this -> Campos[autoret_proveedor_no] = array(
		name	=>'autoret_proveedor',
		id		=>'auto_no',
		type	=>'radio',
	 	value	=>'N',
		checked	=>'yes',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor','tercero'),
			type	=>array('column')),
		onclick=>'auto();'		
	);

	$this -> Campos[agente_proveedor_si] = array(
		name	=>'retei_proveedor',
		id		=>'reteica_si',
		type	=>'radio',
	 	value	=>'S',
		checked	=>'',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor','tercero'),
			type	=>array('column'))
	);

	$this -> Campos[agente_proveedor_no] = array(
		name	=>'retei_proveedor',
		id		=>'reteica_no',
		type	=>'radio',
	 	value	=>'N',
		checked	=>'yes',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor','tercero'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[renta_proveedor_si] = array(
		name	=>'renta_proveedor',
		id		=>'renta_si',
		type	=>'radio',
	 	value	=>'S',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor','tercero'),
			type	=>array('column'))
	);

	$this -> Campos[renta_proveedor_no] = array(
		name	=>'renta_proveedor',
		id		=>'renta_no',
		type	=>'radio',
	 	value	=>'N',
		checked	=>'yes',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor','tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[numcuenta_proveedor] = array(
		name	=>'numcuenta_proveedor',
		id		=>'numcuenta_proveedor',
		type	=>'text',
		//required=>'yes',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
	 	transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);

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
		//required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);

	 
	$this -> Campos[activo] = array(
		name	=>'estado_proveedor',
		id		=>'activo',
		type	=>'radio',
	 	value	=>'A',
		checked	=>'checked',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado_proveedor',
		id		=>'inactivo',
		type	=>'radio',
	 	value	=>'I',
		//tabindex=>'14',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('proveedor'),
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
			onsuccess=>'ProveedorOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'proveedorOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'proveedor_crear',
			setId	=>'tercero_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tercero = new Proveedor();

?>