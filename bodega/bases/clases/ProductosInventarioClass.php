<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ProductosInventario extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ProductosInventarioLayoutClass.php");
	require_once("ProductosInventarioModelClass.php");
	
	$Layout   = new ProductosInventarioLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ProductosInventarioModel();

    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU
	//$Layout -> SetLineaProducto   	($Model -> GetLineaProducto($this -> getConex()));
	$Layout -> SetMedida   			($Model -> GetMedida($this -> getConex()));
	$Layout -> SetEmpaque   		($Model -> GetEmpaque($this -> getConex()));	
	$Layout -> SetImpuestos   		($Model -> GetImpuestos($this -> getConex()));	
	

	//// GRID ////
	$Attributes = array(
	  id		=>'wms_productos_inv',
	  title		=>'Listado de Productos de Inventario',
	  sortname	=>'producto_id',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
				  
	  array(name=>'producto_id',		index=>'producto_id',			sorttype=>'text',	width=>'80',	align=>'center'),
	  array(name=>'nombre',				index=>'nombre',				sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'estado',				index=>'estado',				sorttype=>'text',	width=>'150',	align=>'left'),	  
	 /* array(name=>'linea_producto_id',	index=>'linea_producto_id',		sorttype=>'text',	width=>'170',	align=>'left'),*/
	  array(name=>'referencia',			index=>'referencia',			sorttype=>'text',	width=>'130',	align=>'left'),	  
	  array(name=>'tipo_valuacion',		index=>'tipo_valuacion',		sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'medida_id',			index=>'medida_id',				sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'codigo_barra',		index=>'codigo_barra',			sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'tipo_empaque_inv_id',index=>'tipo_empaque_inv_id',	sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'procesado',			index=>'procesado',				sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'stock_min',			index=>'stock_min',				sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'stock_max',			index=>'stock_max',				sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'descripcion',		index=>'descripcion',			sorttype=>'text',	width=>'100',	align=>'left'),
	  array(name=>'iva',				index=>'iva',					sorttype=>'text',	width=>'100',	align=>'left'),	  
	  array(name=>'impuesto_id',		index=>'impuesto_id',			sorttype=>'text',	width=>'100',	align=>'left')	  
	  
	  
	);
	  
    $Titles = array('NO.',
					'NOMBRE',
					'ESTADO',
					/*'LINEA PRODUCTO',*/
					'REFERENCIA',
					'TIPO VALUACION',
					'MEDIDA',
					'CODIGO BARRA',
					'EMPAQUE',
					'PROCESADO',
					'STOCK MINIMO',
					'STOCK M�XIMO',
					'DESCRIPCION',
					'IVA',
					'IMPUESTO'
	);
	
	$Layout -> SetGridProductosInventario($Attributes,$Titles,$Cols,$Model -> GetQueryProductosInventarioGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ProductosInventarioModelClass.php");
    $Model = new ProductosInventarioModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }
  

  protected function onclickSave(){

  	require_once("ProductosInventarioModelClass.php");
    $Model = new ProductosInventarioModel();
	
	$Data = $Model -> Save($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	  echo json_encode($Data);
	}
	
  }

  protected function onclickUpdate(){
 
  	require_once("ProductosInventarioModelClass.php");
    $Model = new ProductosInventarioModel();

    $Model -> Update($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('Ocurrio una inconsistencia');
	}else{
	    exit('Se actualizo correctamente el Producto.');
	  }
	
  }

  protected function getCodigo(){
 
  	require_once("ProductosInventarioModelClass.php");
    $Model = new ProductosInventarioModel();

    $Data = $Model -> buscaCodigo($this -> getConex());

    echo json_encode($Data);
	
	
	
  }


  protected function onclickDelete(){

  	require_once("ProductosInventarioModelClass.php");
    $Model = new ProductosInventarioModel();
	
	$Model -> Delete($this -> Campos,$this -> getConex());
	
	if($Model -> GetNumError() > 0){
	  exit('No se puede borrar el Producto.');
	}else{
	    exit('Se borr� exitosamente el Producto.');
	  }
	
  }


//BUSQUEDA
  protected function onclickFind(){
	
	require_once("ProductosInventarioModelClass.php");
    $Model = new ProductosInventarioModel();
	
    $Data                  = array();
	$producto_id   = $_REQUEST['producto_id'];
	 
	if(is_numeric($producto_id)){
	  
	  $Data  = $Model -> selectDatosProductosInventarioId($producto_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Prodcuto Inventario
	********************/
	
	$this -> Campos[producto_id] = array(
		name	=>'producto_id',
		id		=>'producto_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('primary_key'))
	);

	$this -> Campos[consecutivo] = array(
		name	=>'consecutivo',
		id		=>'consecutivo',
		type	=>'hidden',
		
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);
	
	$this -> Campos[fecha_inicio] = array(
		name	=>'fecha_inicio',
		id		=>'fecha_inicio',
		type	=>'hidden',
		
		value   =>date ( 'Y-m-d' ,strtotime ( '-10 day' , strtotime ( date("Y-m-d") ) ))
	);
	
	$this -> Campos[fecha_final] = array(
		name	=>'fecha_final',
		id		=>'fecha_final',
		type	=>'hidden',
		
		value   =>date("Y-m-d")
	);
	
	$this -> Campos[nombre] = array(
		name	=>'nombre',
		id		=>'nombre',
		type	=>'text',
		required=>'yes',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);
	$this -> Campos[codigo_interno] = array(
		name	=>'codigo_interno',
		id		=>'codigo_interno',
		type	=>'text',
		Boostrap=>'si',
		readonly=>'readonly',
	 	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);

	$this -> Campos[proveedor] = array(
			name	=>'proveedor',
			id		=>'proveedor',
			type	=>'text',
		    Boostrap=>'si',
			suggest=>array(
				name	=>'proveedor',
				setId	=>'proveedor_hidden')
		);
		
		$this -> Campos[proveedor_id] = array(
			name	=>'proveedor_id',
			id		=>'proveedor_hidden',
			type	=>'hidden',
			datatype=>array(
				type	=>'integer'),
			transaction=>array(
				table	=>array('wms_producto_inv'),
				type	=>array('column'))
		);	

	$this -> Campos[estado] = array(
		name =>'estado',
		id  =>'estado',
		type =>'select',
		Boostrap=>'si',
		options => array(
			array(value=>'A',text=>'ACTIVO'),
			array(value=>'I',text=>'INACTIVO')),
		required=>'yes',
		datatype=>array(
			type =>'alpha'),
		transaction=>array(
			table =>array('wms_producto_inv'),
			type =>array('column'))
	);

	/*$this -> Campos[linea_producto_id] = array(
		name	=>'linea_producto_id',
		id		=>'linea_producto_id',
		type	=>'hidden',
		
		required=>'yes',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);*/

	$this -> Campos[linea_producto] = array(
		name	=>'linea_producto',
		id		=>'linea_producto',
		type	=>'text',
		Boostrap=>'si',
		suggest=>array(
				name	=>'linea_producto',
				setId	=>'linea_producto_id',
				onclick =>'calcularCodigoInt')
	);
	
	$this -> Campos[referencia] = array(
		name	=>'referencia',
		id		=>'referencia',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);	

	$this -> Campos[tipo_valuacion] = array(
		name	=>'tipo_valuacion',
		id		=>'tipo_valuacion',
		type	=>'text',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);	

	$this -> Campos[medida_id] = array(
		name	=>'medida_id',
		id		=>'medida_id',
		type	=>'select',
		options	=>null,
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);

	$this -> Campos[codigo_barra] = array(
		name	=>'codigo_barra',
		id		=>'codigo_barra',
		type	=>'text',
		required=>'yes',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);	

	$this -> Campos[tipo_empaque_inv_id] = array(
		name	=>'tipo_empaque_inv_id',
		id		=>'tipo_empaque_inv_id',
		type	=>'select',
		options	=>null,
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'integer',
			length	=>'2'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);

 	$this -> Campos[imagen] = array(
		name	=>'imagen',
		id		=>'imagen',
		type	=>'file',
		value	=>'',
		path	=>'sistemas_informaticos/imagenes/inventarios/productos/',
		size	=>'70',
        Boostrap=>'si',	
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'nombre',
			text	=>'_foto'),
		settings => array(
		  width  => '400',
		  height => '420'
		)
	);


	$this -> Campos[procesado] = array(
		name =>'procesado',
		id  =>'procesado',
		type =>'select',
		Boostrap=>'si',
		options => array(
			array(value=>'S',text=>'SI'),
			array(value=>'N',text=>'NO')),
		required=>'yes',
		datatype=>array(
			type =>'alpha'),
		transaction=>array(
			table =>array('wms_producto_inv'),
			type =>array('column'))
	);

	$this -> Campos[stock_min] = array(
		name	=>'stock_min',
		id		=>'stock_min',
		type	=>'text',
		required=>'yes',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);	

	$this -> Campos[stock_max] = array(
		name	=>'stock_max',
		id		=>'stock_max',
		type	=>'text',
		required=>'yes',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'numeric',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);	

	$this -> Campos[descripcion] = array(
		name	=>'descripcion',
		id		=>'descripcion',
		type	=>'text',
		required=>'yes',
		size=>'80',
		Boostrap=>'si',
	 	datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('wms_producto_inv'),
			type	=>array('column'))
	);	


	$this -> Campos[iva] = array(
		name =>'iva',
		id  =>'iva',
		type =>'select',
		options => array(
			array(value=>'S',text=>'SI'),
			array(value=>'N',text=>'NO')),
		required=>'yes',
		Boostrap=>'si',
		datatype=>array(
			type =>'alpha'),
		transaction=>array(
			table =>array('wms_producto_inv'),
			type =>array('column'))
	);

	$this -> Campos[tipo_venta] = array(
		name =>'tipo_venta',
		id  =>'tipo_venta',
		type =>'select',
		options => array(
			array(value=>'P',text=>'PESO'),
			array(value=>'C',text=>'CANTIDAD')),
		required=>'yes',
		Boostrap=>'si',
		datatype=>array(
			type =>'alpha'),
		transaction=>array(
			table =>array('wms_producto_inv'),
			type =>array('column'))
	);
	$this -> Campos[impuesto_id] = array(
		name =>'impuesto_id',
		id  =>'impuesto_id',
		type =>'select',
		options => '',
		Boostrap=>'si',
		datatype=>array(
			type =>'alpha'),
		transaction=>array(
			table =>array('wms_producto_inv'),
			type =>array('column'))
	);

	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
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
			onsuccess=>'ProductosInventarioOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ProductosInventarioOnReset()'
	);
	 
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		size	=>'85',
		Boostrap=>'si',
		suggest=>array(
			name	=>'producto_inventario',
			setId	=>'producto_id',
			onclick	=>'setDataFormWithResponse')
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$parametros_factura_id = new ProductosInventario();

?>