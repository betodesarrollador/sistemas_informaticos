<?php

require_once("../../../framework/clases/ControlerClass.php");

final class SolicFacturas extends Controler{

  public function __construct(){
  
	$this -> SetCampos();
	parent::__construct(3);
    
  }


  public function Main(){
  
    $this -> noCache();
   	
	require_once("SolicFacturasLayoutClass.php");
    require_once("SolicFacturasModelClass.php");
	
	$Layout = new SolicFacturasLayout();
    $Model  = new SolicFacturasModel();
    $cliente_id 					= $_REQUEST['cliente_id'];
    $fuente_facturacion_cod 		= $_REQUEST['fuente_facturacion_cod'];
    $tipo_bien_servicio_factura_os 	= $_REQUEST['tipo_bien_servicio_factura_os'];
    $tipo_bien_servicio_factura_rm 	= $_REQUEST['tipo_bien_servicio_factura_rm'];
	$tipo_bien_servicio_factura_st 	= $_REQUEST['tipo_bien_servicio_factura_st'];
	$fuente_nombre					= 'Ordenes de Servicio, Remesas y Despachos Particulares Pendientes';
    
	if($_REQUEST['fuente_facturacion_cod']=='OS') $tipo_bien_servicio_factura_id=$_REQUEST['tipo_bien_servicio_factura_os']; 
	elseif($_REQUEST['fuente_facturacion_cod']=='RM') $tipo_bien_servicio_factura_id=$_REQUEST['tipo_bien_servicio_factura_rm'];
	else $tipo_bien_servicio_factura_id=$_REQUEST['tipo_bien_servicio_factura_st'];
		
	$Layout -> setIncludes();

	$Layout -> setComprobar($Model -> getComprobar($tipo_bien_servicio_factura_id,$this -> getConex()));	
	
	
	$Layout -> SetCampos($this -> Campos);
	
//// GRID ////

	$Attributes = array(
	  id		=>'SolicFacturas',
	  title		=>$fuente_nombre,
	  sortname	=>'fuente',
	  width		=>'900',
	  height	=>'200',
	  rowList	=>'500,800,1000,2000,2500',
	  rowNum	=>'100'//, // numero maximo de registros por pagina en el grid
	);
	$Cols = array(
	  array(name=>'link',      				index=>'link',      				sorttype=>'text',	width=>'15',	align=>'center'),
	  array(name=>'fuente',      			index=>'fuente',      				sorttype=>'text',	width=>'90',	align=>'center'),
	  array(name=>'consecutivo',   			index=>'consecutivo',  				sorttype=>'int',	width=>'70',	align=>'center'),
	  array(name=>'tipo_servicio',      	index=>'tipo_servicio',      		sorttype=>'text',	width=>'100',	align=>'center'),
	  array(name=>'valor_facturar',			index=>'valor_orden',  				sorttype=>'int',	width=>'90',	align=>'center', format => 'currency'),
	  array(name=>'cliente',      			index=>'cliente',      				sorttype=>'text',	width=>'170',	align=>'left'),
	  array(name=>'origen',      			index=>'origen',      				sorttype=>'text',	width=>'75',	align=>'center'),
	  array(name=>'destino',      			index=>'destino',      				sorttype=>'text',	width=>'75',	align=>'center'),
	  array(name=>'producto',      			index=>'producto',      			sorttype=>'text',	width=>'75',	align=>'center'),		  
	  array(name=>'fecha',   				index=>'fecha',    					sorttype=>'date',	width=>'70',	align=>'center')
	  	 	  
 
	);

	$Titles =  
	  array('&nbsp;','FUENTE','CONS. No','TIPO SERVICIO','VALOR','CLIENTE','ORIGEN','DESTINO','PRODUCTO','FECHA');
	  
    
	$Layout -> SetGridSolicFacturas($Attributes,$Titles,$Cols,$Model -> getQuerySolicFacturasGrid($cliente_id));
	
    $Layout -> RenderMain();
    
  }
  

  protected function SetCampos(){

	$this -> Campos[fuente] = array(
		name	=>'fuente',
		id		=>'fuente',
		type	=>'hidden',
		value=>$_REQUEST['fuente_facturacion_cod']
	);

	//botones
	$this -> Campos[adicionar] = array(
		name	=>'adicionar',
		id		=>'adicionar',
		type	=>'button',
		value=>'ADICIONAR',
	);
	
		
	$this -> SetVarsValidate($this -> Campos);
  }

}

$SolicFacturas = new SolicFacturas();

?>