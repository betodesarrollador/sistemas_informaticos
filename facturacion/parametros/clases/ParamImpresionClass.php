<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ParamImpresion extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ParamImpresionLayoutClass.php");
	require_once("ParamImpresionModelClass.php");
	
	$Layout   = new ParamImpresionLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ParamImpresionModel();

	$oficina_id = $this -> getOficinaId();	
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> SetGuardar   ($Model -> getPermiso($this -> getActividadId(),INSERT,$this -> getConex()));
    $Layout -> SetActualizar($Model -> getPermiso($this -> getActividadId(),UPDATE,$this -> getConex()));
    $Layout -> SetBorrar    ($Model -> getPermiso($this -> getActividadId(),DELETE,$this -> getConex()));
    $Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   /* 	$Layout -> SetFuente($Model -> GetFuente($this -> getConex()));
	$Layout -> SetDocumento($Model -> GetDocumento($this -> getConex()));
	$Layout -> SetAgencia($Model -> GetAgencia($oficina_id,$this -> getConex())); */
	

	//// GRID ////
	$Attributes = array(
	  id		=>'ParamImpresion',
	  title		=>'Listado de Tipos de Servicios',
	  sortname	=>'tipo_bien_servicio_factura_id',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'tipo_bien_servicio_factura_id',	index=>'tipo_bien_servicio_factura_id',	sorttype=>'int',	width=>'70',	align=>'center'),
	  array(name=>'nombre_bien_servicio_factura',	index=>'nombre_bien_servicio_factura',	sorttype=>'text',	width=>'250',	align=>'left'),
  	  array(name=>'fuente_servicio',				index=>'fuente_servicio',				sorttype=>'text',	width=>'230',	align=>'left'),
	  array(name=>'documento',						index=>'documento',						sorttype=>'text',	width=>'180',	align=>'left'),
	  array(name=>'estado',							index=>'estado',						sorttype=>'text',	width=>'70',	align=>'left')
	);
	  
    $Titles = array('CODIGO',
					'BIEN/SERVICIO',
					'FUENTE',
					'DOCUMENTO',
					'ESTADO'
	);
	
	$Layout -> SetGridParamImpresion($Attributes,$Titles,$Cols,$Model -> GetQueryParamImpresionGrid());
	$Layout -> RenderMain();
  
  }

  protected function onclickValidateRow(){
	require_once("ParamImpresionModelClass.php");
    $Model = new ParamImpresionModel();
	echo $Model -> ValidateRow($this -> getConex(),$this -> Campos);
  }

  protected function onclickUpdate(){
 
  	require_once("ParamImpresionModelClass.php");
	$Model = new ParamImpresionModel();
	
	 $observacion_encabezado = htmlentities($_REQUEST["observacion_encabezado"]);


    $Model -> Update($this -> getConex());
	
	if(strlen(trim($Model -> GetError())) > 0){
	  exit("Error : ".$Model -> GetError());
	}else{
        exit("true");
	}	
	
  }

  protected function onclickFind(){
	
	require_once("ParamImpresionModelClass.php");
    $Model = new ParamImpresionModel();
	
    $Data                 			= array();
	$parametro_impresion_id	= $_REQUEST['parametro_impresion_id'];
	 
	if(is_numeric($parametro_impresion_id)){
	  
	  $Data  = $Model -> selectParametros($parametro_impresion_id,$this -> getConex());
	  
	} 
    echo json_encode($Data);
	
  }


  protected function uploadFileAutomatically(){
  
    require_once("ParamImpresionModelClass.php");
	$Model = new ParamImpresionModel();
	
	$parametro_impresion_id  = rand(10,100);
    $ruta          = "../../../archivos/facturacion/parametrosFactura/";
    $archivo       = $_FILES['logo'];
    $nombreArchivo = "adjunto_logo".$parametro_impresion_id;    
    $dir_file      = $this -> moveUploadedFile($archivo,$ruta,$nombreArchivo);
  
    $Model -> setAdjunto($dir_file,$this -> getConex());      
		
	if(strlen($Model -> GetError()) > 0){
	  exit('false');
	}else{
	    exit('true');
	}


  }
  

  protected function SetCampos(){
  
    /********************
	  Campos Tarifas Proveedor
	********************/

	$this -> Campos[parametro_impresion_id] = array(
		name	=>'parametro_impresion_id',
		id	    =>'parametro_impresion_id',
		value  =>'1',
		type	=>'hidden',
	);

	$this -> Campos[logo] = array(
		name	  =>'logo',
		id	  =>'logo',
		type	  =>'upload',
				title     =>'Carga Adjunto',
				parameters=>'parametro_impresion_id',
                onsuccess =>'onSendFile'
	);


	$this -> Campos[observacion_encabezado] = array(
		name	=>'observacion_encabezado',
		id	=>'observacion_encabezado',
		type	=>'textarea',
		//size    =>'20',
		cols=>'100',
		rows=>'5',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('parametro_impresion_factura'),
			type	=>array('column'))
	);	

	$this -> Campos[pie_pagina] = array(
		name	=>'pie_pagina',
		id	=>'pie_pagina',
		type	=>'textarea',
		//size    =>'20',
		cols=>'110',
		rows=>'5',
		datatype=>array(
			type	=>'text'),
		transaction=>array(
			table	=>array('parametro_impresion_factura'),
			type	=>array('column'))
	);	

	$this -> Campos[formato_impresion] = array(
		name	=>'formato_impresion',
		id		=>'formato_impresion',
		type	=>'select',
		Boostrap =>'si',
		options => array(array(value => 1, text => 'SI'),array(value => 0, text => 'NO')),
		selected=>0,		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametro_impresion_factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[impuestos_visibles] = array(
		name	=>'impuestos_visibles',
		id		=>'impuestos_visibles',
		type	=>'select',
		Boostrap =>'si',
		options => array(array(value => 1, text => 'SI'),array(value => 0, text => 'NO')),
		selected=>0,		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametro_impresion_factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[detalles_visibles] = array(
		name	=>'detalles_visibles',
		id		=>'detalles_visibles',
		type	=>'select',
		Boostrap =>'si',
		options => array(array(value => 1, text => 'SI'),array(value => 0, text => 'NO')),
		selected=>0,		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametro_impresion_factura'),
			type	=>array('column'))
		
	);

	$this -> Campos[cabecera_por_pagina] = array(
		name	=>'cabecera_por_pagina',
		id		=>'cabecera_por_pagina',
		type	=>'select',
		Boostrap =>'si',
		options => array(array(value => 1, text => 'SI'),array(value => 0, text => 'NO')),
		selected=>0,		
	 	datatype=>array(
			type	=>'alphanum',
			length	=>'1'),
		transaction=>array(
			table	=>array('parametro_impresion_factura'),
			type	=>array('column'))
		
	);
	
	
	

	 	  
	/**********************************
 	             Botones
	**********************************/
	
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar'
		//tabindex=>'19'
	);
	 
 	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
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
			onsuccess=>'ParamImpresionOnDelete')
	);
	 
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ParamImpresionOnReset()'
	);
	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$tipo_bien_servicio_factura_id = new ParamImpresion();

?>