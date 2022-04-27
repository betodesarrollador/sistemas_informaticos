<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Reportes extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ReportesLayoutClass.php");
	require_once("ReportesModelClass.php");
	
	$Layout   = new ReportesLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ReportesModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	$Layout -> SetLimpiar   ($Model -> getPermiso($this -> getActividadId(),CLEAR,$this -> getConex()));	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetOficina	($Model -> GetOficina($this -> getConex()));
   	$Layout -> SetCuenta	($Model -> GetCuenta($this -> getConex()));
   	$Layout -> SetDoc		($Model -> GetDoc($this -> getConex()));
	$Layout -> SetTipo		($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetSi_Pro	($Model -> GetSi_Pro($this -> getConex()));	


	$Layout -> RenderMain();
  
  }

/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento();
    $print -> printOut($this -> getConex());
  
  }*/

  protected function generateFileexcel(){
     
    require_once("ReportesModelClass.php");
	
    $Model      		= new ReportesModel();	
	$desde      		= $_REQUEST['desde'];
	$hasta      		= $_REQUEST['hasta'];
	$tipo       		= $_REQUEST['tipo'];
	$oficina_id			= $_REQUEST['oficina_id'];
	$si_proveedor		= $_REQUEST['si_proveedor'];
	$proveedor_id		= $_REQUEST['proveedor_id'];	
	$all_oficina		= $_REQUEST['all_oficina'];
	$tipo_documento_id	= $_REQUEST['tipo_documento_id'];
	$all_docs			= $_REQUEST['all_docs'];
	$puc_id				= $_REQUEST['puc_id'];
	$all_ctas			= $_REQUEST['all_ctas'];
	
	$saldos			= $_REQUEST['saldos'];
	if($saldos=='S'){
		$saldos=" AND ab.fecha BETWEEN '".$desde."'  AND  '".$hasta."' ";
	}else{
		$saldos='';
	}

	if($saldo == 'S'){
        $consulta="AND f.factura_id NOT IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r,abono_factura_proveedor a
		                                   WHERE r.factura_proveedor_id=f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) 
										        FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id) 
											    FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id 
												AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 
												GROUP BY r.factura_proveedor_id)";
	}else if($saldo == 'N'){
		$consulta="AND f.factura_id IN(SELECT r.factura_proveedor_id FROM relacion_abono_factura r, abono_factura_proveedor a
		                                WHERE r.factura_proveedor_id=f.factura_proveedor_id AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id
										AND a.estado_abono_factura != 'I'
										AND (SELECT SUM(r.rel_valor_abono_factura)-(SELECT SUM(d.cre_item_factura_proveedor) 
										        FROM item_factura_proveedor d WHERE d.factura_proveedor_id = r.factura_proveedor_id) 
											    FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id = f.factura_proveedor_id 
												AND r.abono_factura_proveedor_id = a.abono_factura_proveedor_id AND a.estado_abono_factura != 'I') = 0 
										        GROUP BY r.factura_proveedor_id)";
	}else if($saldo == 'NULL'){
        $consulta='';
	}
	
	if($all_docs=='NO'){
		$tipo_documento_id=" AND f.encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE tipo_documento_id IN ($tipo_documento_id))";
	}else{
		$tipo_documento_id='';
	}
	
	if($all_ctas=='NO'){
		$puc_id=" AND f.factura_proveedor_id IN (SELECT factura_proveedor_id FROM item_factura_proveedor WHERE puc_id IN ($puc_id)) ";
	}else{
		$puc_id='';
	}

	
	
	if($tipo == 'FP'){
      $nombre = 'Fac_Pend'.date('Ymd');	  
    }elseif($tipo == 'RF'){
		$nombre = 'Rel_Fac'.date('Ymd');	
	}elseif($tipo == 'EC'){
	  	$nombre = 'Est_Car'.date('Ymd');	
	}elseif($tipo == 'PE'){
		$nombre = 'Car_Edad'.date('Ymd');
	}elseif($tipo == 'RC'){
		$nombre = 'Rel_Causa'.date('Ymd');	
	}elseif($tipo == 'Rs'){
		$nombre = 'Rel_Solic'.date('Ymd');	
	}elseif($tipo == 'SP'){
		$nombre = 'Sol_Pend'.date('Ymd');	
	}
	
	if($tipo=='FP' && $si_proveedor==1){
    	$data = $Model -> getReporteFP1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$this -> getConex());
		
	}elseif($tipo=='RF' && $si_proveedor==1){
    	$data = $Model -> getReporteRF1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$saldos,$this -> getConex());	
		
	}elseif($tipo=='EC' && $si_proveedor==1){
		$data = $Model -> getReporteEC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$consulta,$this -> getConex());
		$data = $data[0]['factura'];

	}elseif($tipo=='PE' && $si_proveedor==1){
		$data = $Model -> getReportePE1($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$proveedor_id,$puc_id,$saldos,$this -> getConex());
		
	}elseif($tipo=='RC' && $si_proveedor==1){
		$data = $Model -> getReporteRC1($oficina_id,$desde,$hasta,$proveedor_id,$saldos,$this -> getConex());	
	
	}elseif($tipo=='RS' && $si_proveedor==1){
		$data = $Model -> getReporteRS1($oficina_id,$desde,$hasta,$proveedor_id,$this -> getConex());	
		
	}elseif($tipo=='SP' && $si_proveedor==1){
    	$data = $Model -> getReporteSP1($oficina_id,$desde,$hasta,$proveedor_id,$this -> getConex());
		
	}elseif($tipo=='FP' && $si_proveedor=='ALL'){
    	$data = $Model -> getReporteFP_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex());	
																										   
	}elseif($tipo=='RF' && $si_proveedor=='ALL'){
    	$data = $Model -> getReporteRF_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex());	
		
	}elseif($tipo=='EC' && $si_proveedor=='ALL'){
	    $data = $Model -> getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$consulta,$this -> getConex());
		$data = $data[0]['factura'];																								   
	}elseif($tipo=='PE' && $si_proveedor=='ALL'){ 
		$data = $Model -> getReportePE_ALL($oficina_id,$desde,$hasta,$puc_id,$tipo_documento_id,$saldos,$this -> getConex()); 
		
	}elseif($tipo=='RC' && $si_proveedor=='ALL'){ 
		$data = $Model -> getReporteRC_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()); 
	
	}elseif($tipo=='RS' && $si_proveedor=='ALL'){ 
		$data = $Model -> getReporteRS_ALL($oficina_id,$desde,$hasta,$this -> getConex()); 
	
	}elseif($tipo=='SP' && $si_proveedor=='ALL'){
    	$data = $Model -> getReporteSP_ALL($oficina_id,$desde,$hasta,$this -> getConex());	
	}
	

	
    $ruta  = $this -> arrayToExcel("Reportes",$tipo,$data,null,"string");
	
    $this -> ForceDownload($ruta,$nombre.'.xls');
	  
  }


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap =>'si',
		required=>'yes',
		multiple=>'yes'
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes'
	);

	$this -> Campos[saldos] = array(
		name	=>'saldos',
		id		=>'saldos',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		required=>'yes',
		selected=>'N',
		options	=>array(0 => array ( 'value' => 'S', 'text' => 'SI' ), 1 => array ( 'value' => 'N', 'text' => 'NO'))
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		Boostrap =>'si',
		type	=>'text',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_proveedor] = array(
		name	=>'si_proveedor',
		id		=>'si_proveedor',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Proveedor_si();'
	);
	
	$this -> Campos[proveedor_id] = array(
		name	=>'proveedor_id',
		id		=>'proveedor_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);


	$this -> Campos[proveedor] = array(
		name	=>'proveedor',
		id		=>'proveedor',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'proveedor',
			setId	=>'proveedor_id')
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);
	
	$this -> Campos[puc_id] = array(
		name	=>'puc_id',
		id		=>'puc_id',
		type	=>'select',
		Boostrap =>'si',
		//required=>'yes',
		multiple=>'yes'
	);

	$this -> Campos[all_ctas] = array(
		name	=>'all_ctas',
		id		=>'all_ctas',
		type	=>'checkbox',
		onclick =>'all_cta();',
		value	=>'NO'
	);
	 	
	$this -> Campos[tipo_documento_id] = array(
		name	=>'tipo_documento_id',
		id		=>'tipo_documento_id',
		type	=>'select',
		Boostrap =>'si',
		//required=>'yes',
		multiple=>'yes'
	);

	$this -> Campos[all_docs] = array(
		name	=>'all_docs',
		id		=>'all_docs',
		type	=>'checkbox',
		onclick =>'all_doc();',
		value	=>'NO'
	);
		
		
	/**********************************
 	             Botones
	**********************************/
	 
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'OnclickGenerar(this.form)'
	);		

	$this -> Campos[descargar] = array(
    name   =>'descargar',
    id   =>'descargar',
    type   =>'button',
    value   =>'Descargar Excel Formato',
	onclick =>'descargarexcel(this.form)'
	);
	
	$this -> Campos[generar_excel] = array(
    name   =>'generar_excel',
    id   =>'generar_excel',
    type   =>'button',
    value   =>'Descargar Excel'
    );
	
    $this -> Campos[limpiar] = array(
	name	=>'limpiar',
	id		=>'limpiar',
	type	=>'reset',
	value	=>'Limpiar',
	//tabindex=>'22',
	onclick	=>'ReporteOnReset()'
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

$Reportes = new Reportes();

?>