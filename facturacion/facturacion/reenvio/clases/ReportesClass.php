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
	$Layout -> setLimpiar	($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	


	$Layout -> RenderMain();
  
  }

  protected function generateFileexcel(){
  
    require_once("DetallesModelClass.php");
    $Model                  = new DetallesModel();	

    $tipo 					= $_REQUEST['tipo'];
	$oficina_id				= $_REQUEST['oficina_id'];
	$desde					= $_REQUEST['desde'];
	$hasta					= $_REQUEST['hasta'];
	$si_cliente				= $_REQUEST['si_cliente'];
	$cliente_id				= $_REQUEST['cliente_id'];	
	$all_oficina			= $_REQUEST['all_oficina'];
	
	
	if($si_cliente==1){
		$cliente= " AND  f.cliente_id=$cliente_id ";
	}else{
		$cliente= " ";
	}

	if($tipo=='SR'){
		$tipo_c= " AND  f.acuse=0 ";

	}else if($tipo=='SA'){
		$tipo_c= " AND  f.validacion_dian IS NULL ";

	}else if($tipo=='CR'){
		$tipo_c= " AND  f.acuse=1 ";

	}else if($tipo=='CA'){
		$tipo_c= " AND  f.validacion_dian IS NOT NULL ";

	}else{
		$tipo_c= "  ";
	}
	$data = $Model -> getReporteRF($oficina_id,$desde,$hasta,$cliente,$tipo_c,$this -> getConex());

    $ruta  = $this -> arrayToExcel("Reportes",$tipo,$data,null);
	
    $this -> ForceDownload($ruta,'Reporte_'.$tipo.date('YmdHi').'.xls');
	  
  }


  protected function SetCampos(){
  
    /********************
	  Campos causar
	********************/
	

	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		multiple=>'yes'
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		Boostrap=>'si',
		options	=>null,
		required=>'yes'
	);

	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
	 	datatype=>array(
			type	=>'date',
			length	=>'10')
	);

	$this -> Campos[si_cliente] = array(
		name	=>'si_cliente',
		id		=>'si_cliente',
		type	=>'select',
		Boostrap=>'si',
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
			length	=>'20')
	);


	$this -> Campos[cliente] = array(
		name	=>'cliente',
		id		=>'cliente',
		type	=>'text',
		Boostrap=>'si',
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

    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'print',
	disabled=>'disabled',
    value   =>'Imprimir',
	displayoptions => array(
		      form        => 0,
		      beforeprint => 'beforePrint',
      title       => 'Impresion Reporte',
      width       => '800',
      height      => '600'
    ));

	$this -> Campos[descargar] = array(
    name   =>'descargar',
    id   =>'descargar',
    type   =>'button',
    value   =>'Descargar Excel Formato',
	onclick =>'descargarexcel(this.form)'
    );

    $this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		//tabindex=>'22',
		onclick	=>'ReportesOnReset(this.form)'
	);

	$this -> Campos[generar_excel] = array(
    name   =>'generar_excel',
    id   =>'generar_excel',
    type   =>'button',
    value   =>'Descargar Excel'
    );

	 
	$this -> SetVarsValidate($this -> Campos);
	}

}

$Reportes = new Reportes();

?>