<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Comercial extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){
  

    $this -> noCache();
	  
	require_once("ComercialLayoutClass.php");
	require_once("ComercialModelClass.php");
	
	$Layout   = new ComercialLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ComercialModel();

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
	$Layout -> setOficinas($Model -> getOficinas($this -> getConex()));

	$Layout -> RenderMain();
  
  }
  
  protected function showGrid(){
	  
	require_once("ComercialLayoutClass.php");
	require_once("ComercialModelClass.php");
	
	$Layout   = new ComercialLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ComercialModel();
	  
		//// GRID ////
		$Attributes = array(
			id		=>'terceros',
			title		=>'Listado de Comerciales',
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
			  array(name=>'numcuenta_comercial',	index=>'numcuenta_comercial',	sorttype=>'text',	width=>'150',	align=>'center'),
			  array(name=>'tip_cuenta',				index=>'tip_cuenta',			sorttype=>'text',	width=>'150',	align=>'center'),	  
			array(name=>'banco',					index=>'banco',					sorttype=>'text',	width=>'150',	align=>'center'),	  
			  array(name=>'estado',					index=>'estado',				sorttype=>'text',	width=>'100',	align=>'center')
			
		  
		  );
			
		  $Titles = array('TIPO ID',
						  'IDENTIFICACION',
						  'DV',
						  'TIPO CONTRIBUYENTE',
						  'PRIMER APELLIDO',
						  'SEGUNDO APELLIDO',
						  'PRIMER NOMBRE',
						  'OTROS NOMBRES',
						  'RAZON SOCIAL',
						  'SIGLA',
						  'CIUDAD RESIDENCIA',
						  'DIRECCION',
						  'TELEFONO',
						  'MOVIL',
						  'TELEFAX',
						  'APARTADO',
						  'EMAIL',
						  'NUMERO CUENTA',
						  'TIPO CUENTA',					
						  'BANCO',
						  'ESTADO'
		  );
		  
	$html = $Layout -> SetGridComerciales($Attributes,$Titles,$Cols,$Model -> GetQueryComercialesGrid());
	 
	 print $html;
	  
  }

  protected function onclickValidateRow(){
	require_once("ComercialModelClass.php");
    $Model = new ComercialModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ComercialModelClass.php");
    $Model = new ComercialModel();
	
	$Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se ingreso correctamente un nuevo Comercial');
	  }
	
  }

  protected function onclickUpdate(){
 
  	require_once("ComercialModelClass.php");
    $Model = new ComercialModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Comercial');
	  }
	
  }


  protected function onclickDelete(){

  	require_once("ComercialModelClass.php");
    $Model = new ComercialModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('no se puede borrar el Comercial');
	}else{
	    exit('Se borro exitosamente el Comercial');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ComercialModelClass.php");
    $Model = new ComercialModel();
	
    $Data                  = array();
	$tercero_id            = $_REQUEST['tercero_id'];
  	$numero_identificacion = $_REQUEST['numero_identificacion'];
	 
	if(is_numeric($tercero_id)){
	  
	  $Data  = $Model -> selectDatosComercialTerceroId($tercero_id,$this -> getConex());
	}else if(is_numeric($numero_identificacion)){
		  
     	$Data  = $Model -> selectDatosComercialNumeroId($numero_identificacion,$this -> getConex());
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
			table	=>array('tercero','comercial'),
			type	=>array('primary_key','column'))
	);

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap=>'si',
		options  => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
		Boostrap=>'si',
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
	          Campos Comerciales
	 *********************************/

 	$this -> Campos[comercial_id] = array(
		name	=>'comercial_id',
		id		=>'comercial_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction	=>array(
			table	=>array('comercial'),
			type	=>array('primary_key'))
	);
	 
	$this -> Campos[url_comercial] = array(
		name	=>'url_comercial',
		id		=>'url_comercial',
		type	=>'text',
		Boostrap=>'si',
		//tabindex=>'18',
		datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);
	$this -> Campos[contac_comercial] = array(
		name	=>'contac_comercial',
		id		=>'contac_comercial',
		type	=>'text',
		Boostrap=>'si',
		//tabindex=>'18',
		datatype=>array(
			type	=>'text',
			length	=>'150'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);


	$this -> Campos[tipo_cta_id] = array(
		name	=>'tipo_cta_id',
		id		=>'tipo_cta_id',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'no',
		//tabindex=>'2',
	 	datatype=>array(
			type	=>'integer',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);
	 
	$this -> Campos[autoret_comercial_si] = array(
		name	=>'autoret_comercial',
		id		=>'auto_si',
		type	=>'radio',
	 	value	=>'S',
		checked	=>'',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial','tercero'),
			type	=>array('column'))
	);

	$this -> Campos[autoret_comercial_no] = array(
		name	=>'autoret_comercial',
		id		=>'auto_no',
		type	=>'radio',
	 	value	=>'N',
		checked	=>'yes',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial','tercero'),
			type	=>array('column'))
	);

	$this -> Campos[agente_comercial_si] = array(
		name	=>'retei_comercial',
		id		=>'reteica_si',
		type	=>'radio',
	 	value	=>'S',
		checked	=>'',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comcercial','tercero'),
			type	=>array('column'))
	);

	$this -> Campos[agente_comercial_no] = array(
		name	=>'retei_comercial',
		id		=>'reteica_no',
		type	=>'radio',
	 	value	=>'N',
		checked	=>'yes',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial','tercero'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[renta_comercial_si] = array(
		name	=>'renta_comercial',
		id		=>'renta_si',
		type	=>'radio',
	 	value	=>'S',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial','tercero'),
			type	=>array('column'))
	);

	$this -> Campos[renta_comercial_no] = array(
		name	=>'renta_comercial',
		id		=>'renta_no',
		type	=>'radio',
	 	value	=>'N',
		checked	=>'yes',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial','tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[numcuenta_comercial] = array(
		name	=>'numcuenta_comercial',
		id		=>'numcuenta_comercial',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
	 	transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);

	$this -> Campos[banco] = array(
		name	=>'banco',
		id		=>'banco',
		type	=>'text',
		Boostrap=>'si',
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
		required=>'no',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);

	 
	$this -> Campos[activo] = array(
		name	=>'estado_comercial',
		id		=>'activo',
		type	=>'radio',
	 	value	=>'A',
		checked	=>'checked',
		//tabindex=>'13',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);
	 
	$this -> Campos[inactivo] = array(
		name	=>'estado_comercial',
		id		=>'inactivo',
		type	=>'radio',
	 	value	=>'I',
		//tabindex=>'14',
		datatype=>array(
			type	=>'alpha',
			length	=>'1'),
		transaction=>array(
			table	=>array('comercial'),
			type	=>array('column'))
	);	
	 	  
		
	$this -> Campos[fac_rango1] = array(
		name	=>'fac_rango1',
		id		=>'fac_rango1',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		);
	$this -> Campos[fac_rango2] = array(
		name	=>'fac_rango2',
		id		=>'fac_rango2',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		);
	$this -> Campos[fac_rango3] = array(
		name	=>'fac_rango3',
		id		=>'fac_rango3',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		);
	$this -> Campos[fac_rango4] = array(
		name	=>'fac_rango4',
		id		=>'fac_rango4',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		); 
		 
	
	
	$this -> Campos[rec_rango1] = array(
		name	=>'rec_rango1',
		id		=>'rec_rango1',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		);
	$this -> Campos[rec_rango2] = array(
		name	=>'rec_rango2',
		id		=>'rec_rango2',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		);
	$this -> Campos[rec_rango3] = array(
		name	=>'rec_rango3',
		id		=>'rec_rango3',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
			type	=>array('column'))
		);
	$this -> Campos[rec_rango4] = array(
		name	=>'rec_rango4',
		id		=>'rec_rango4',
		type	=>'text',
		Boostrap=>'si',
		required=>'no',
		//tabindex=>'8',
		/*datatype=>array(
			type	=>'alpha',
			length	=>'2'),*/
	 	transaction=>array(
			table	=>array('porcentaje_comision_comercial'),
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
			onsuccess=>'ComercialOnSaveOnUpdateonDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ComercialOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		Boostrap=>'si',
		size	=>'85',
		//tabindex=>'1',
		suggest=>array(
			name	=>'comercial_crear',
			setId	=>'tercero_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tercero = new Comercial();

?>