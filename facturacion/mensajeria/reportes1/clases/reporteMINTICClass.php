<?php
require_once("../../../framework/clases/ControlerClass.php");

final class reporteMINTICClass extends Controler{

	public function __construct(){
		parent::__construct(3);
	}

	public function Main(){

		$this -> noCache();

		require_once("reporteMINTICLayoutClass.php");
		require_once("reporteMINTICModelClass.php");

		$Layout   = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new reporteMINTICModel();

		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));

		$Layout -> setCampos($this -> Campos);

		//LISTA MENU

		$Layout -> SetSi_Cli ($Model -> GetSi_Cli ($this -> getConex()));
		$Layout -> setReporte($Model -> getReporte($this -> getConex()));
		$Layout -> SetOficina($Model -> GetOficina($this -> getOficinaId(),$this -> getEmpresaId(),$this -> getConex()));

		$Layout -> RenderMain();

	}

	public function generarTipoReporte(){

		$this -> noCache();
		require_once("reporteMINTICLayoutClass.php");

		$Layout = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());

		$tiporeporte 			= $_REQUEST['tipo_reporte'];

		$download				= $_REQUEST['download'];
		$desde					= $_REQUEST['desde'];
		$hasta					= $_REQUEST['hasta'];
		$origen					= $_REQUEST['origen'];
		$origen_id				= $_REQUEST['origen_id'];
		$destino				= $_REQUEST['destino'];
		$destino_id				= $_REQUEST['destino_id'];
		$cliente_id				= $_REQUEST['cliente_id'];
		$si_cliente				= $_REQUEST['si_cliente'];
		$oficina_id				= $_REQUEST['oficina_id'];
		$all_oficina			= $_REQUEST['all_oficina'];


		
		switch ($tiporeporte) {
			case 1:
				$this -> generarReporteFormato1ism($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte);
			break;
			case 2:
				$this -> generarReporteFormato3be($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte);
			break;
			case 3:
				$this -> generarReporteFormato1te($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte);
			break;
			// case 4:
			// 	$this -> generarReporteFormato1ism($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte);
			// break;
			case 5:
				$this -> generarReporteFormato1esm($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte);
			break;
			case 6:
				$this -> generarReporteFormato1esc($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte);
			break;
		}

	}


	public function generarReporteFormato1ism($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte){

		$this -> noCache();
		require_once("reporteMINTICLayoutClass.php");
		require_once("reporteMINTICModelClass.php");
		    
		$Layout                 = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model                  = new reporteMINTICModel();

		if ($origen=='' || $origen=='NULL' || $origen==NULL){
		    $consulta_origen="";
		}else $consulta_origen=" AND g.origen_id=".$origen_id;

		if ($destino=='' || $destino=='NULL' || $destino==NULL){
		    $consulta_destino="";
		}else $consulta_destino=" AND g.destino_id=".$destino_id;

		if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
		    $consulta_cliente="";
		}else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

		if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
		    $consulta_oficina="";
		}else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

		$entregas = $Model -> getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$this -> getConex());
		
		$Layout -> setCssInclude("../../framework/css/reset.css");
		$Layout -> setCssInclude("../css/reportes.css");
		$Layout -> setCssInclude("../css/detalles.css");
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../framework/js/jquery-1.4.4.min.js");
		$Layout -> setJsInclude("../../framework/js/funciones.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		$Layout -> setVar('EMPRESA',$empresa);
		$Layout -> setVar('NIT',$nitEmpresa);
		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('REPORTE',$tiporeporte);
		$Layout -> setVar('DETALLES',$entregas);

		if($download == 'SI'){
			$Layout -> exportToExcel('DetallesMINTIC.tpl');
		}else{
	 	   $Layout -> RenderLayout('DetallesMINTIC.tpl');
		}
	}


	public function generarReporteFormato1te($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte){

		$this -> noCache();
		require_once("reporteMINTICLayoutClass.php");
		require_once("reporteMINTICModelClass.php");
		    
		$Layout                 = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model                  = new reporteMINTICModel();

		if ($origen=='' || $origen=='NULL' || $origen==NULL){
		    $consulta_origen="";
		}else $consulta_origen=" AND g.origen_id=".$origen_id;

		if ($destino=='' || $destino=='NULL' || $destino==NULL){
		    $consulta_destino="";
		}else $consulta_destino=" AND g.destino_id=".$destino_id;

		if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
		    $consulta_cliente="";
		}else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

		if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
		    $consulta_oficina="";
		}else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

		$entregas = $Model -> getReporte3($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$this -> getConex());

		$Layout -> setCssInclude("../../framework/css/reset.css");
		$Layout -> setCssInclude("../css/reportes.css");
		$Layout -> setCssInclude("../css/detalles.css");
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../framework/js/jquery-1.4.4.min.js");
		$Layout -> setJsInclude("../../framework/js/funciones.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		$Layout -> setVar('EMPRESA',$empresa);
		$Layout -> setVar('NIT',$nitEmpresa);
		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('REPORTE',$tiporeporte);
		$Layout -> setVar('DETALLES',$entregas);


		if($download == 'SI'){
			$Layout -> exportToExcel('DetallesMINTIC.tpl');
		}else{
	 	   $Layout -> RenderLayout('DetallesMINTIC.tpl');
		}
	}


	public function generarReporteFormato3be($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte){

		$this -> noCache();
		require_once("reporteMINTICLayoutClass.php");
		require_once("reporteMINTICModelClass.php");
		    
		$Layout                 = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model                  = new reporteMINTICModel();

		if ($origen=='' || $origen=='NULL' || $origen==NULL){
		    $consulta_origen="";
		}else $consulta_origen=" AND g.origen_id=".$origen_id;

		if ($destino=='' || $destino=='NULL' || $destino==NULL){
		    $consulta_destino="";
		}else $consulta_destino=" AND g.destino_id=".$destino_id;

		if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
		    $consulta_cliente="";
		}else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

		if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
		    $consulta_oficina="";
		}else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

		$entregas = $Model -> getReporte2($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$this -> getConex());
		
		$totalg = array();
		$total = 0;
		foreach ($entregas as $key) {
			$total=$key[cant_tiempo_entrega]+$total;
		}
		$totalg[total]=$total;
		array_unshift($entregas, $totalg);

		$Layout -> setCssInclude("../../framework/css/reset.css");
		$Layout -> setCssInclude("../css/reportes.css");
		$Layout -> setCssInclude("../css/detalles.css");
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../framework/js/jquery-1.4.4.min.js");
		$Layout -> setJsInclude("../../framework/js/funciones.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		$Layout -> setVar('EMPRESA',$empresa);
		$Layout -> setVar('NIT',$nitEmpresa);
		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('REPORTE',$tiporeporte);
		$Layout -> setVar('DETALLES',$entregas);


		if($download == 'SI'){
			$Layout -> exportToExcel('DetallesMINTIC.tpl');
		}else{
	 	   $Layout -> RenderLayout('DetallesMINTIC.tpl');
		}
	}


	public function generarReporteFormato1esm($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte){

		$this -> noCache();
		require_once("reporteMINTICLayoutClass.php");
		require_once("reporteMINTICModelClass.php");
		    
		$Layout                 = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model                  = new reporteMINTICModel();

		if ($origen=='' || $origen=='NULL' || $origen==NULL){
		    $consulta_origen="";
		}else $consulta_origen=" AND g.origen_id=".$origen_id;

		if ($destino=='' || $destino=='NULL' || $destino==NULL){
		    $consulta_destino="";
		}else $consulta_destino=" AND g.destino_id=".$destino_id;

		if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
		    $consulta_cliente="";
		}else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

		if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
		    $consulta_oficina="";
		}else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

		$entregas = $Model -> getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$this -> getConex());

		$Layout -> setCssInclude("../../framework/css/reset.css");
		$Layout -> setCssInclude("../css/reportes.css");
		$Layout -> setCssInclude("../css/detalles.css");
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../framework/js/jquery-1.4.4.min.js");
		$Layout -> setJsInclude("../../framework/js/funciones.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		$Layout -> setVar('EMPRESA',$empresa);
		$Layout -> setVar('NIT',$nitEmpresa);
		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('REPORTE',$tiporeporte);
		$Layout -> setVar('DETALLES',$entregas);


		if($download == 'SI'){
			$Layout -> exportToExcel('DetallesMINTIC.tpl');
		}else{
	 	   $Layout -> RenderLayout('DetallesMINTIC.tpl');
		}
	}


	public function generarReporteFormato1esc($download,$desde,$hasta,$origen,$origen_id,$destino,$destino_id,$cliente_id,$si_cliente,$oficina_id,$all_oficina,$tiporeporte){

		$this -> noCache();
		require_once("reporteMINTICLayoutClass.php");
		require_once("reporteMINTICModelClass.php");
		    
		$Layout                 = new reporteMINTICLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model                  = new reporteMINTICModel();

		if ($origen=='' || $origen=='NULL' || $origen==NULL){
		    $consulta_origen="";
		}else $consulta_origen=" AND g.origen_id=".$origen_id;

		if ($destino=='' || $destino=='NULL' || $destino==NULL){
		    $consulta_destino="";
		}else $consulta_destino=" AND g.destino_id=".$destino_id;

		if ($si_cliente=='' || $si_cliente=='NULL' || $si_cliente==NULL || $si_cliente=='ALL'){
		    $consulta_cliente="";
		}else $consulta_cliente=" AND g.cliente_id =".$cliente_id;

		if ($all_oficina=='' || $all_oficina=='NULL' || $all_oficina==NULL || $all_oficina=='SI'){
		    $consulta_oficina="";
		}else $consulta_oficina=" AND g.oficina_id IN (".$oficina_id.") ";

		$entregas = $Model -> getReporte2($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$this -> getConex());

		$Layout -> setCssInclude("../../framework/css/reset.css");
		$Layout -> setCssInclude("../css/reportes.css");
		$Layout -> setCssInclude("../css/detalles.css");
		$Layout -> setCssInclude("../css/reportes.css","print");
		$Layout -> setJsInclude("../../framework/js/jquery-1.4.4.min.js");
		$Layout -> setJsInclude("../../framework/js/funciones.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		$Layout -> setVar('EMPRESA',$empresa);
		$Layout -> setVar('NIT',$nitEmpresa);
		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('REPORTE',$tiporeporte);
		$Layout -> setVar('DETALLES',$entregas);


		if($download == 'SI'){
			$Layout -> exportToExcel('DetallesMINTIC.tpl');
		}else{
	 	   $Layout -> RenderLayout('DetallesMINTIC.tpl');
		}
	}
 
  //DEFINICION CAMPOS DE FORMULARIO
  protected function setCampos(){    

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		required=>'yes',
		multiple=>'yes'
	);	

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);	

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Cliente_si();'
	);

	$this -> Campos[tipo_reporte] = array(
		name	=>'tipo_reporte',
		id		=>'tipo_reporte',
		type	=>'select',
		options	=>null,
		selected=>0,
		required=>'yes'
	);

	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);
	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_id')
	);	
	
 	$this -> Campos[origen] = array(
	    name=>'origen',
	    id=>'origen',
	    type=>'text',
		size=>16,
	    suggest=>array(
	    name=>'ciudad',
	    setId=>'origen_id')
    ); 
    $this -> Campos[origen_id] = array(
	    name=>'origen_id',
	    id=>'origen_id',
	    type=>'hidden',
	    datatype=>array(
	    type=>'integer',
	    length=>'20')   
    );

	$this -> Campos[destino] = array(
	    name=>'destino',
	    id=>'destino',
	    type=>'text',
		size=>16,
	    suggest=>array(
	    name=>'ciudad',
	    setId=>'destino_id')
    );
    $this -> Campos[destino_id] = array(
	    name=>'destino_id',
	    id=>'destino_id',
	    type=>'hidden',
	    value=>'',
	    datatype=>array(
	    type=>'integer',
	    length=>'20')
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
		name	=>'generar_excel',
		id		=>'generar_excel',
		type	=>'button',
		value	=>'Generar Excel',
		onclick =>'OnclickGenerarExcel(this.form)'
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

$reporteMINTICClass = new reporteMINTICClass();

?>