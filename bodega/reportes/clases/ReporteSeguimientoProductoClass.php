<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ReporteSeguimientoProducto extends Controler{

  public function __construct(){
    parent::__construct(3);	      
  }  
  
   public function Main(){
  
    $this -> noCache();
    
	require_once("ReporteSeguimientoProductoLayoutClass.php");
	
	require_once("ReporteSeguimientoProductoModelClass.php");
	
	$Layout   = new ReporteSeguimientoProductoLayout($this -> getTitleTab(),$this -> getTitleForm());
	
	$Model    = new ReporteSeguimientoProductoModel();
	
    $Model   -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());	
	$Layout  -> setImprimir ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));		
    $Layout  -> setCampos   ($this -> Campos);	
	
	//LISTA MENU

	$Layout -> RenderMain();    

  }  

  protected function generateFile(){

    require_once("ReporteSeguimientoProductoModelClass.php");
	require_once("ReporteSeguimientoProductoLayoutClass.php");

    $Layout         = new ReporteSeguimientoProductoLayout(); 
	$Model          = new ReporteSeguimientoProductoModel();	
	
	$Layout -> setJsInclude("../../../framework/js/funciones.js");
	$Layout -> setJsInclude("../js/ReporteSeguimientoProducto.js");
	$Layout -> setCssInclude("../../../framework/css/bootstrap.css");
	$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());

	$serial			= $_REQUEST['serial'];
	$codigo_barra	= $_REQUEST['codigo_barra'];

	
	$data  = $Model -> getDatosPrincipales($serial,$this -> getConex()); 
	$reporte[0]['datos_principales']=$data;


	$data  = $Model -> getDatosEnturnamiento($serial,$this -> getConex()); 
	$reporte[0]['datos_enturnamiento']=$data;


	$data  = $Model -> getDatosMuelle($serial,$this -> getConex()); 
	$reporte[0]['datos_muelle']=$data;


	$data  = $Model -> getDatosRecepcion($serial,$this -> getConex()); 
	$reporte[0]['datos_recepcion']=$data;


	$data  = $Model -> getDatosLegalizacion($serial,$this -> getConex()); 
	$reporte[0]['datos_legalizacion']=$data;


	$data  = $Model -> getDatosInventario($serial,$this -> getConex()); 
	$reporte[0]['datos_inventario']=$data;


	$data  = $Model -> getDatosTraslados($serial,$this -> getConex()); 
	$reporte[0]['datos_traslados']=$data;


	$data  = $Model -> getDatosAlistamientoSalida($serial,$this -> getConex()); 
	$reporte[0]['datos_alistamiento_salida']=$data;

	
	$data  = $Model -> getDatosTurnoSalida($serial,$this -> getConex()); 
	$reporte[0]['datos_turno_salida']=$data;


	$data  = $Model -> getDatosDespacho($serial,$this -> getConex()); 
	$reporte[0]['datos_despacho']=$data;


	$data  = $Model -> getDatosEntrega($serial,$this -> getConex()); 
	$reporte[0]['datos_entrega']=$data;

	//exit(print_r($reporte));
	
	
    if($_REQUEST['download'] == 'true'){
		
		$Layout -> setVar("PRODUCTO",$reporte);
		
		$Layout -> exportToExcel('ReporteSeguimientoProductoResult.tpl');	
	  
	}else{

		$Layout -> setVar("PRODUCTO",$reporte);

		$Layout	-> RenderLayout('ReporteSeguimientoProductoResult.tpl');		

	  }  
  }

  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    
	

	$this -> Campos[serial] = array(
		name	=>'serial',
		id		=>'serial',
		type	=>'text',
		placeholder=>'Por favor digite el serial  de el producto.',
		Boostrap=>'si',
		size    => 60,
		datatype=>array(
			type	=>'text',
			length	=>'60'),
		suggest=>array(
			name	=>'wms_all_serials',
			setId	=>'num_serial')
	);	

	$this -> Campos[num_serial] = array(
		name	=>'num_serial',
		id		=>'num_serial',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'30')
	);	

	$this -> Campos[codigo] = array(
		name	=>'codigo',
		id		=>'codigo',
		type	=>'text',
		size    => 60,
		placeholder=>'Por favor digite el codigo de barras de el producto.',
		Boostrap=>'si',
		suggest=>array(
			name	=>'wms_codigo_barra',
			setId	=>'codigo_barra')
	);

	$this -> Campos[codigo_barra] = array(
		name	=>'codigo_barra',
		id		=>'codigo_barra',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'30')
	);	
	

/////// BOTONES 

	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);	

	
	$this -> Campos[generar_excel] = array(
    name   =>'generar_excel',
    id   =>'generar_excel',
    type   =>'button',
    value   =>'Descargar Excel Formato',
	onclick =>'OnclickGenerarExcel()'
    );

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
    );
	 
	$this -> SetVarsValidate($this -> Campos);
	
   }  
 }

$ReporteSeguimientoProducto = new ReporteSeguimientoProducto();

?>