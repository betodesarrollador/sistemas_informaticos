<?php

require_once("../../../framework/clases/ControlerClass.php");

final class ArchivoPlano extends Controler{
	
  public function __construct(){

	parent::__construct(3);
	
  }
  	
  public function Main(){

    $this -> noCache();
	  
	require_once("ArchivoPlanoLayoutClass.php");
	require_once("ArchivoPlanoModelClass.php");
	
	$Layout   = new ArchivoPlanoLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ArchivoPlanoModel();
	
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
	$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
	
    $Layout -> SetCampos($this -> Campos);
	//LISTA MENU	
   	$Layout -> SetOficina($Model -> GetOficina($this -> getConex()));
	
	
	$Layout -> SetTipo($Model -> GetTipo($this -> getConex()));	
	//$Layout -> SetSi_Pro($Model -> GetSi_Pro($this -> getConex()));	

	//// GRID ////
	$Attributes = array(
	  id		=>'terceros',
	  title		=>'Listado de Proveedores',
	  sortname	=>'numero_identificacion',
	  width		=>'auto',
	  height	=>'250'
	);

	$Cols = array(
	
	  array(name=>'nombre_proveedor',		index=>'nombre_proveedor',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'numero_identificacion',	index=>'numero_identificacion',	sorttype=>'int',	width=>'150',	align=>'center'),
	  array(name=>'numcuenta_proveedor',	index=>'numcuenta_proveedor',	sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'tip_cuenta',				index=>'tip_cuenta',			sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'titular_cuenta',			index=>'titular_cuenta',		sorttype=>'text',	width=>'200',	align=>'center'),
	  array(name=>'banco',					index=>'banco',					sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'documento_titular',		index=>'documento_titular',		sorttype=>'text',	width=>'150',	align=>'center'),
	  array(name=>'tipo_identificacion_id',	index=>'tipo_identificacion_id',sorttype=>'text',	width=>'150',	align=>'center'),
	  
	  
	  
	  
	  
	
	);
	  
    $Titles = array('NOMBRE PROVEEDOR',
					'DOCUMENTO PROVEEDOR',
					'NUMERO DE CUENTA',
					'TIPO CUENTA',
					'NOMBRE TITULAR',
					'BANCO',
					'DOCUMENTO TITULAR',
					'TIPO DE DOCUMENTO'
					
	);
	
	$Layout -> SetGridProveedores($Attributes,$Titles,$Cols,$Model -> GetQueryProveedoresGrid());
	
	$Layout -> RenderMain();
  
  }


 /* protected function onclickPrint(){
    require_once("Imp_DocumentoClass.php");
    $print = new Imp_Documento();
    $print -> printOut($this -> getConex());
  
  }*/

  protected function generateFileexcel(){
  
    require_once("ArchivoPlanoModelClass.php");
	
    $Model      	= new ArchivoPlanoModel();	
	$desde      	= $_REQUEST['desde'];
	$hasta      	= $_REQUEST['hasta'];
	
	
	
	
	//$saldos			= $_REQUEST['saldos'];
	
		$data = $Model -> getReporteFP_ALL($oficina_id,$desde,$hasta,$saldos,$this -> getConex());	
	
	
	
	
    $ruta  = $this -> arrayToExcel("ArchivoPlano","Reporte",$data,null,"string");
	
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
		required=>'yes',
		multiple=>'yes'
	);


	$this -> Campos[tipo] = array(
		name	=>'tipo',
		id		=>'tipo',
		type	=>'select',
		options	=>null,
		required=>'yes'
	);

	$this -> Campos[saldos] = array(
		name	=>'saldos',
		id		=>'saldos',
		type	=>'select',
		options	=>null,
		required=>'yes',
		selected=>'N',
		options	=>array(0 => array ( 'value' => 'S', 'text' => 'SI' ), 1 => array ( 'value' => 'N', 'text' => 'NO'))
	);

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

	$this -> Campos[si_proveedor] = array(
		name	=>'si_proveedor',
		id		=>'si_proveedor',
		type	=>'select',
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
    value   =>'Descargar Excel',
	onclick =>'descargarexcel(this.form)'
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

$ArchivoPlano = new ArchivoPlano();

?>