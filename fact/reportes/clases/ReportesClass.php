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
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	
	$Layout -> SetSi_Com($Model -> GetSi_Com($this -> getConex()));


	$Layout -> RenderMain();
  
  }

/*
  protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
     = new Imp_Documento();
    $print -> printOut( -> getConex());
  
  }*/


  
    protected function generateFileexcel(){
  
    require_once("ReportesModelClass.php");
	
    $Model      	= new ReportesModel();	
	$desde      	= $_REQUEST['desde'];
	$hasta      	= $_REQUEST['hasta'];
	$tipo       	= $_REQUEST['tipo'];
	$oficina_id		= $_REQUEST['oficina_id'];
	$si_cliente		= $_REQUEST['si_cliente'];
	$si_comercial	= $_REQUEST['si_comercial'];
	$comercial_id	= $_REQUEST['comercial_id'];
	$cliente_id		= $_REQUEST['cliente_id'];
	$cliente		= $_REQUEST['cliente'];	
	$all_oficina	= $_REQUEST['all_oficina'];
	$saldos		    = $_REQUEST['saldos'];
	$saldo		    = $_REQUEST['saldo'];
	$fecha_corte	= $_REQUEST['fecha_corte'];

	if($saldos=='1'){
		$saldos=" AND a.fecha BETWEEN '".$desde."'  AND  '".$hasta."' ";
		$fecha_corte = "(SELECT DATEDIFF('".$fecha_corte."',f.vencimiento)) as dias,";
	}else{
		$saldos='';
		$fecha_corte ='';
	}

	if($saldo == '1'){
        $consulta="AND f.factura_id NOT IN(SELECT r.factura_id FROM relacion_abono r,abono_factura a
		                                   WHERE r.factura_id=f.factura_id AND r.abono_factura_id = a.abono_factura_id 
										   AND a.estado_abono_factura != 'I' 
										   AND (SELECT SUM(r.rel_valor_abono)-(SELECT SUM(d.valor_liquida) FROM detalle_factura_puc d WHERE d.factura_id = r.factura_id AND d.contra_factura=1) FROM relacion_abono r, abono_factura a WHERE r.factura_id = f.factura_id AND r.abono_factura_id = a.abono_factura_id AND a.estado_abono_factura != 'I') = 0 GROUP BY r.factura_id)";
	}else if($saldo == '0'){
		$consulta="AND f.factura_id IN(SELECT r.factura_id FROM relacion_abono r, abono_factura a, detalle_factura_puc d
		                                WHERE r.factura_id=f.factura_id AND f.factura_id = d.factura_id
										AND r.abono_factura_id IS NOT NULL AND r.abono_factura_id = a.abono_factura_id
										AND a.estado_abono_factura != 'I' AND r.rel_valor_abono = d.valor_liquida GROUP BY r.factura_id)";
	}else if($saldo == 'NULL'){
        $consulta='';
	}
	
	
	if($tipo == 'FP'){
      $nombre = 'Fac_Pend'.date('Ymd');	  
    }elseif($tipo == 'RF'){
			$nombre = 'Rel_Fac'.date('Ymd');	
	}elseif($tipo == 'EC'){
	  	$nombre = 'Est_Cuenta'.date('Ymd');	
	}elseif($tipo == 'PE'){
		$nombre = 'Car_Edad'.date('Ymd');
	}elseif($tipo == 'RE'){
		$nombre = 'Rec_audos'.date('Ymd');
	}elseif($tipo == 'RP'){
		$nombre = 'Rem_pendientes'.date('Ymd');
	}


	
	if($tipo=='FP' && $si_cliente==1){
    	$data = $Model -> getReporteFP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex());
		
	}elseif($tipo=='RF' && $si_cliente==1){
    	$data = $Model -> getReporteRF1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex());	
	
	}elseif($tipo=='RE' && $si_cliente==1){
    	$data = $Model -> getReporteRE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex());	
		
	}elseif($tipo=='EC' && $si_cliente==1){
		$data = $Model -> getReporteEC1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$fecha_corte,$consulta,$this -> getConex());
		$data = $data[0]['factura'];		
	}elseif($tipo=='PE' && $si_cliente==1){
		$data = $Model -> getReportePE1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex());
	}elseif($tipo=='RP' && $si_cliente==1){
		$data = $Model -> getReporteRP1($oficina_id,$desde,$hasta,$cliente_id,$saldos,$this -> getConex());
	}


//----------------------------------FILTRO COMERCIAL INICIO
	elseif($tipo=='FP' && $si_comercial==1)
    	$data = $Model -> getReporteFP1($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex());
		
	elseif($tipo=='RF' && $si_comercial==1)
    	$data = $Model -> getReporteRF1($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex());	
	
	elseif($tipo=='RE' && $si_comercial==1)
    	$data = $Model -> getReporteRE1($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex());		
		
	elseif($tipo=='PE' && $si_comercial==1)
		$data = $Model -> getReportePE1($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex());

	elseif($tipo=='RP' && $si_comercial==1)
		$data = $Model -> getReporteRP1($oficina_id,$desde,$hasta,$comercial_id,$saldos,$this -> getConex());


//-------------------------------FILTRO COMERCIAL FIN 
	elseif($tipo=='FP' && $si_cliente=='ALL'){
    	$data = $Model -> getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex());	
																										   
	}elseif($tipo=='RF' && $si_cliente=='ALL'){
    	$data = $Model -> getReporteRF_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex());	
		
	}elseif($tipo=='EC' && $si_cliente=='ALL'){
	    
		$data = $Model -> getReporteEC_ALL($oficina_id,$desde,$hasta,$saldos,$fecha_corte,$consulta,$this -> getConex());
																									   
	}elseif($tipo=='PE' && $si_cliente=='ALL'){ 
		$data = $Model -> getReportePE_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()); 
	
	}elseif($tipo=='RE' && $si_cliente=='ALL'){ 
		$data = $Model -> getReporteRE_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()); 

	}elseif($tipo=='RP' && $si_cliente=='ALL'){ 
		$data = $Model -> getReporteRP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex()); 
	}
    $ruta  = $this -> arrayToExcel("Reportes",$tipo,$data,null);
	
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

	$this -> Campos[saldo] = array(
		name	=>'saldo',
		id		=>'saldo',
		type	=>'select',
		Boostrap=>'si',
		options => array(array(value => '1', text => 'SI'),array(value => '0', text => 'NO')),
		selected=>'',
		//required=>'yes',
		datatype=>array(type=>'text')
	);

		$this -> Campos[saldos] = array(
		name	=>'saldos',
		id		=>'saldos',
		type	=>'select',
		Boostrap=>'si',
		options => array(array(value => '1', text => 'SI'),array(value => '0', text => 'NO')),
		selected=>'',
		//required=>'yes',
		datatype=>array(type=>'text')
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		Boostrap =>'si',
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
		Boostrap =>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[fecha_corte] = array(
		name	=>'fecha_corte',
		id		=>'fecha_corte',
		type	=>'text',
		Boostrap =>'si',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Cliente_si();'
	);
	
	$this -> Campos[cliente_id] = array(
		name	=>'cliente_id',
		id		=>'cliente_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'15')
	);


	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'cliente',
			setId	=>'cliente_id')
	);

	$this -> Campos[all_oficina] = array(
		name	=>'all_oficina',
		id		=>'all_oficina',
		type	=>'checkbox',
		onclick =>'all_oficce();',
		value	=>'NO'
	);

	//Agregado filtro para comerciales
	
		$this -> Campos[si_comercial] = array(
		name	=>'si_comercial',
		id		=>'si_comercial',
		type	=>'select',
		Boostrap =>'si',
		options	=>null,
		selected=>0,
		required=>'yes',
		onchange=>'Comercial_si();'
	);
	
	$this -> Campos[comercial_id] = array(
		name	=>'comercial_id',
		id		=>'comercial_id',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'20')
	);


	$this -> Campos[comercial] = array(
		name	=>'comercial',
		id		=>'comercial',
		type	=>'text',
		Boostrap =>'si',
		disabled=>'disabled',
		suggest=>array(
			name	=>'comercial',
			setId	=>'comercial_id')
	);
	
	
	//Agregado filtro para comerciales

	 	  
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


    $this -> Campos[imprimir] = array(
	    name   =>'imprimir',
		id   =>'imprimir',
		type   =>'button',
		value   =>'Imprimir',
		onclick =>'beforePrint(this.form)'
	);
	
	
	$this -> Campos[enviar] = array(
     name   =>'enviar',
     id   =>'enviar',
     type   =>'button',
	 value   =>'Enviar Email',
	 onclick =>'enviarEmail(this.form)'
    );

	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Reportes = new Reportes();

?>