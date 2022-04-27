<?php

require_once("../../../framework/clases/ControlerClass.php");

final class TablaDescuentos extends Controler{

  public function __construct(){
	parent::__construct(3);    
  }


  public function Main(){
	   
    $this -> noCache();
    
    require_once("TablaDescuentosLayoutClass.php");
    require_once("TablaDescuentosModelClass.php");
	
    $Layout   = new TablaDescuentosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new TablaDescuentosModel();
	    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar		($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar	($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar		($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar		($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setEmpresas($Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()));
//	$Layout -> setBases($Model -> getBases($this -> getUsuarioId(),$this -> getConex()));	

    
	
	//// GRID ////
	$Attributes = array(
	  id		=>'TablaDescuentos',
	  title		=>'Tabla de Descuentos',
	  sortname	=>'descuento',
	  width		=>'auto',
	  height	=>'250'
	);
	$Cols = array(
	  array(name=>'descuento',				index=>'descuento',				sorttype=>'text',	width=>'250',	align=>'center'),
	 // array(name=>'base',					index=>'base',					sorttype=>'text',	width=>'100',	align=>'center'),
//	  array(name=>'porciento',				index=>'porciento',				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'puc',					index=>'puc',					sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'naturaleza',				index=>'naturaleza',			sorttype=>'text',	width=>'100',	align=>'center'),
	//  array(name=>'tipo',					index=>'tipo',					sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'agencia',				index=>'agencia',				sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'calculo',				index=>'calculo',  				sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'porcentaje',				index=>'porcentaje',			sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'visible_en_impresion',	index=>'visible_en_impresion',	sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'estado',		 			index=>'estado',				sorttype=>'text',	width=>'50',	align=>'center'),
	  array(name=>'descuento_anticipos',	index=>'descuento_anticipos',	sorttype=>'text',	width=>'100',	align=>'center')
	);
    $Titles = array('DESCUENTO',
					//'BASE',
					//'PORCENTAJE',
					'CODIGO CONTABLE',
					'NATURALEZA',

					//'TIPO DESCUENTO',
					'AGENCIA',
					'CALCULO',
					'PORCENTAJE',
                    'VISIBLE IMP',
					'ESTADO',
					'APLICA ANTICIPOS'
	);
	$Layout -> SetGridTablaDescuentos($Attributes,$Titles,$Cols,$Model -> getQueryTablaDescuentosGrid());
	
	
	$Layout -> RenderMain();
    
  }

	protected function onclickValidateRow(){
		require_once("../../../framework/clases/ValidateRowClass.php");
		$Data = new ValidateRow($this -> getConex(),"tabla_descuentos",$this ->Campos);
		$this -> getArrayJSON($Data  -> GetData());
	}

	protected function onclickSave(){
		require_once("TablaDescuentosModelClass.php");
		$Model = new TablaDescuentosModel();
		$Model -> Save($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se ingreso correctamente el descuento');
		}
	}

	protected function onclickUpdate(){
		require_once("TablaDescuentosModelClass.php");
		$Model = new TablaDescuentosModel();
		$Model -> Update($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se actualizo correctamente el descuento');
		}
	}

	protected function onclickDelete(){
		require_once("TablaDescuentosModelClass.php");
		$Model = new TablaDescuentosModel();
		$Model -> Delete($this -> Campos,$this -> getConex());
		if($Model -> GetNumError() > 0){
			exit('Ocurrio una inconsistencia');
		}else{
			exit('Se elimino correctamente el descuento');
		}
	}


//BUSQUEDA
	protected function onclickFind(){
		require_once("TablaDescuentosModelClass.php");
		$Model = new TablaDescuentosModel();
		$Data  = $Model -> selectTablaDescuentos($this -> getConex());
		$this -> getArrayJSON($Data);
	}

	protected function onchangeSetOptionList(){
		require_once("../../../framework/clases/ListaDependiente.php");
		$list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>'nombre',concat=>''),$this -> Campos);
		$list -> getList();
	}
  
 /* protected function setBases(){

	require_once("TablaDescuentosLayoutClass.php");
	require_once("TablaDescuentosModelClass.php");
	
	$Layout = new TablaDescuentosLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model  = new TablaDescuentosModel();
	
	$bases  = $Model -> getBases($this -> getUsuarioId(),$this -> getConex());
	
    $field  = array(
		name	=>'base_desc_id',
		id		=>'base_desc_id',
		type	=>'select',
		options => $bases,
		required=>'yes',
    	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	  );
	  
	  print $Layout -> getObjectHtml($field);

  }*/
  /*
  public function validaPorcentajeBase(){
	  
	require_once("TablaDescuentosModelClass.php");

    $Model  = new TablaDescuentosModel();	  
	$data   = $Model -> selectDataDescuento($this -> getUsuarioId(),$this -> getConex());
	
	$valor_absoluto = $data[0]['valor_absoluto'];
	
	if($valor_absoluto == 0){
	  exit('false');
	}else{
	     exit('true');
	  }
	  
	  
  }*/

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[descuento_id] = array(
		name	=>'descuento_id',
		id		=>'descuento_id',
		type	=>'hidden',
    	datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('primary_key'))
	);
	
	/*$this -> Campos[base_desc_id] = array(
		name	=>'base_desc_id',
		id		=>'base_desc_id',
		type	=>'select',
		options => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	  );*/
	
	$this->Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		options=> array(),
        setoptionslist => array(childId=>'oficina_id'),
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options  => array(),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
	
	$this -> Campos[descuento] = array(
		name	=>'descuento',
		id		=>'descuento',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'alpha_upper',
			length	=>'50'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
		
	/*$this -> Campos[porcentaje_descu] = array(
		name	=>'porcentaje_descu',
		id		=>'porcentaje_descu',
		type	=>'text',
		required=>'yes',
		datatype=>array(
			type	=>'numeric',
			length	=>'6',
			precision=>'3'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);*/	
	
	$this -> Campos[puc] = array(
		name	=>'puc',
		id		=>'puc',
		type	=>'text',
		suggest=>array(
			name	=>'cuentas_movimiento',
			setId	=>'puc_hidden',
			form    =>'0'
			)
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_hidden',
		type	=>'hidden',
		required=>'yes',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[naturaleza] = array(
		name	=>'naturaleza',
		id		=>'naturaleza',
		type	=>'select',
		required=>'yes',
		options => array(array(value => 'D', text => 'DEBITO'), array(value => 'C', text => 'CREDITO')),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[descuento_anticipos] = array(
		name	=>'descuento_anticipos',
		id		=>'descuento_anticipos',
		type	=>'select',
		required=>'yes',
		options => array(array(value => '1', text => 'SI'), array(value => '0', text => 'NO')),
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
	
	/*$this -> Campos[tipo_descuento] = array(
		name	=>'tipo_descuento',
		id		=>'tipo_descuento',
		type	=>'select',
		options => array(
				array(value=>'L',text=>'Ley'),
				array(value=>'O',text=>'Otros')),
		required=>'yes',
    	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);*/
	
	
	$this -> Campos[calculo] = array(
		name	=>'calculo',
		id	    =>'calculo',
		type	=>'select',
		options => array(
				array(value=>'A',text=>'Valor Absoluto',selected => 'A'),
				array(value=>'P',text=>'Porcentual',selected => 'A')),
		required=>'yes',
    	datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);
	
	
	$this -> Campos[porcentaje] = array(
		name	=>'porcentaje',
		id	    =>'porcentaje',
		type	=>'text',
		disabled=>'yes',
    	datatype=>array(
			type	=>'numeric'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);	

	$this -> Campos[visible_en_impresion] = array(
		name	=>'visible_en_impresion',
		id	=>'visible_en_impresion',
		type	=>'select',
		options => array(
				array(value=>1,text=>'SI',selected => 1),
				array(value=>0,text=>'NO',selected => 1)),
		required=>'yes',
    	datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
			type	=>array('column'))
	);

	
	$this -> Campos[estado] = array(
		name	=>'estado',
		id		=>'estado',
		type	=>'select',
		options => array(
				array(value=>'A',text=>'ACTIVO'),
				array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
    	datatype=>array(
			type	=>'alpha'),
		transaction=>array(
			table	=>array('tabla_descuentos'),
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
			onsuccess=>'TablaDescuentosOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'TablaDescuentosOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'TablaDescuentosOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick	=>'TablaDescuentosOnReset(this.form)'
	);
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		placeholder=>'ESCRIBA EL NOMBRE DEL DESCUENTO O NOMBRE DE LA OFICINA',								
		//tabindex=>'1',
		suggest=>array(
			name	=>'busca_descuento',
			setId	=>'descuento_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}

$TablaDescuentos = new TablaDescuentos();

?>